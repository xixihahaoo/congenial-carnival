<?php
// +----------------------------------------------------------------------
// | 定时任务平仓 控制器
// +----------------------------------------------------------------------
// | Author wang <li> 
// +----------------------------------------------------------------------
namespace Home\Controller;
use Think\Controller;
use Org\Util\Log;
use Think\Cache\Driver\Redis;

class CrontabPositionController extends Controller {


	public function settlement()
	{

      	do{
          	$this->HandleOption();  //订单平仓
          	usleep(500000); //延迟 10 描述 usleep(10000000);
      	}while(true);
	}

    public function HandleOption()
    {
        //global $redis;

        $orderObj   = M('order');

        //订单信息
        $order      = $orderObj->field('oid')->where(array('ostaus' => 0,'order_scene' => 1))->order('oid desc')->select();

        if($order)
        {
          foreach ($order as $value)
          {
            //$redis->lpush('order_id',$value['oid']);
            $this->HandleTrade($value['oid']);
          }
        }
    }

    public function HandleTrade($order_id)
    {
        //global $redis;

        //$order_id   = $redis->rpop('order_id');

        if(empty($order_id))
        	return false;


        $orderObj   	= M('order');
        $optionObj 		= M('option');
        $optionInfoObj 	= M('option_info');


        if($order_id)
        {
          $order = $orderObj->
  			field('oid,uid,pid,ostyle,buyprice,onumber,buytime,endprofit,endloss,bond,overnight_fee,type,option_name,en_name,order_type,follow_user_id')->
  			where(array('oid' => $order_id,'ostaus' => 0))->
  			find();
        }

        if(!$order)
        {
          // $redis->del('order_id');
          return false;
        }

        if($order)
        {
        	$option = $optionObj->field('bp,sp,wave,capital_dot_length,flag')->where(array('id' => $order['pid']))->find();

        	$info 	= $optionInfoObj->field('capital_length,overnight_fee,sell_overnight_fee')->where(array('option_id' => $order['pid']))->find();

        	$sellprice = $order['ostyle'] == 0 ? $option['bp'] : $option['sp'];

        	//0涨 1跌，
			if ($order['ostyle'] == 0) {
				$ploss = (round($option['bp'] - $order['buyprice'], $info['capital_length']) * $option['wave']) * $option['capital_dot_length'];
				$ploss = round($ploss * $order['onumber'],2);
			} else {
				$ploss = (round($order['buyprice'] - $option['sp'], $info['capital_length']) * $option['wave']) * $option['capital_dot_length'];
				$ploss = round($ploss * $order['onumber'],2);
			}

			$dataArr = array(
				'ploss' 	=> $ploss,
				'sellprice' => $sellprice
			);

			$orderObj->where(array('oid' => $order_id,'ostaus' => 0))->save($dataArr);	//实时更新当前盈亏

			/*********判断是否持仓过夜 Start***************/
			$buyDate 	= date('Ymd',$order['buytime']);
			$nowDate	= date('Ymd',time());
			$nowTime	= date('Hi',time());
			if($nowDate != $buyDate && $nowTime == '0555')	//凌晨05:55收取过夜费
			{
				$this->overnight_fee($order,$info,$order_id);
			}
			/*********判断是否持仓过夜 End***************/

			//如果当前为休市状态，则禁止平仓
            if($option['flag'] == 0)
                return false;

            $this->baocang($order['type'],$order['uid']);   //爆仓

            //止损 止盈 强制平仓  (跟随订单暂不处理)
            if($order['order_type'] = 1 || $order['order_type'] == 3) {
				$this->force($ploss,$order,$option);
            }
        }
    }


    //爆仓
    private function baocang($now_trade_status,$user_id)
    {
        //订单
        $orderTotal  = M('order')->field('sum(Bond) bond,sum(ploss) ploss')->where(array('uid' => $user_id,'type' => $now_trade_status,'ostaus' => 0))->find();

        //挂单
        $guadanBond = M('gudan_order')->where(array('user_id' => $user_id,'type' => $now_trade_status,'status' => 1))->sum('bond');

        //用户资金
        $account = M('accountinfo')->field('balance,gold')->where(array('uid' => $user_id))->find();

        if($now_trade_status == 1)
            $balance = $account['balance'];
        else
            $balance = $account['gold'];

        $useBond    = round($orderTotal['bond'] + $guadanBond);
        $worth      = round($balance + $useBond + $orderTotal['ploss'],2);
        $bondRate   = round(($worth / $useBond) * 100,2);

        if($bondRate < C('BOND_RATE'))  //保证金比例小于50%,先平最重一仓，以此类推
        {
            $order = M('order')->field('oid,uid,pid,ostyle,buyprice,sellprice,ploss,onumber,buytime,endprofit,endloss,bond,overnight_fee,type,option_name,order_type,follow_user_id')->where(array('uid' => $user_id,'ostaus' => 0,'type' => $now_trade_status))->order('ploss asc')->find();

            $data['ploss']      = $order['ploss'];
            $data['sellprice']  = $order['sellprice'];
            $data['ostaus'] 	= 1;
            $data['selltime'] 	= time();
            $data['auto']    	= 2;
            if($data['ploss'] == 0) {
                $data['order_result'] 	= 1;	//平局
            } else if($data['ploss'] > 0) {
                $data['order_result'] 	= 2;	//赢
            } else {
                $data['order_result'] 	= 3;	//输
            }

            $this->Payment($data,$order,1);
        }
    }

    /**
     * [force 止盈止损强制平仓]
     * @author wang li
     */
    private function force(float $ploss,array $order,array $option,$status=0)
    {	
    	$wave = round($option['wave'] * $order['onumber'],2);	//盈亏只保留2位

    	if($order['ostyle'] == 0)
		{
			$order['endprofit'] = ($order['endprofit'] - $order['buyprice']) * $wave * $option['capital_dot_length'];
			$order['endloss']	= ($order['buyprice'] - $order['endloss']) * $wave * $option['capital_dot_length'];
		} else {
			$order['endprofit'] = ($order['buyprice'] - $order['endprofit']) * $wave * $option['capital_dot_length'];
			$order['endloss']	= ($order['endloss'] - $order['buyprice']) * $wave * $option['capital_dot_length'];
		}

        if($ploss >= $order['endprofit'] || $ploss <= -$order['endloss'])
        {
            if($ploss >= $order['endprofit']) {

				$price 		= ($order['endprofit'] / $wave) / $option['capital_dot_length'];
				$sellprice 	= $order['ostyle'] == 0 ? $order['buyprice']+$price : ($order['buyprice']-$price);

				$data 	= array(
					'sellprice' => $sellprice,
					'ploss'		=> $order['endprofit']
				);
			}

			if($ploss <= -$order['endloss']) {
				$price 		= ($order['endloss'] / $wave) / $option['capital_dot_length'];
				$sellprice 	= $order['ostyle'] == 0 ? ($order['buyprice']-$price) : $order['buyprice']+$price;

				$data = array(
					'sellprice' => $sellprice,
					'ploss'		=> -$order['endloss']
				);
			}

			$data['ostaus'] 	= 1;
            $data['selltime'] 	= $status == 1 ? $order['selltime'] : time();
            $data['auto']    	= 2;

	        if($data['ploss'] == 0)
	        {
	        	$data['order_result'] 	= 1;	//平局
	        } else if($data['ploss'] > 0) {
	        	$data['order_result'] 	= 2;	//赢
	        } else {
	        	$data['order_result'] 	= 3;	//输
	        }

	        $this->Payment($data,$order);
        }
    }


    //添加资金 如果is_support = 1则对跟随者订单转为自持
    private function Payment(array $data,array $order,int $is_support)
    {
        $orderObj 	= M('order');
        $accountObj = M('accountinfo');

		$orderObj->startTrans(); //开启事务

		$ostaus 	= $orderObj->where(array('oid' => $order['oid'],'ostaus' => 0))->save($data);

   		$data['ploss'] 	= round($data['ploss'],2);
		$money   		= ($order['bond'] + $data['ploss']);  //保证金+盈亏

		if($order['type'] == 1)
		{
			//设置运营中心 (盈亏)
   			$exchangeId = exchange($order['uid'],2);

            $yingkui 	= $data['ploss'] < 0 ? (abs($data['ploss'])) : -$data['ploss'];

            $accountObj->where(array('uid' => $exchangeId))->setInc('balance',$yingkui);  					//修改运营中心金额

            $accountObj->where(array('uid' => $order['uid']))->setInc('balance',$money);  					//修改用户金额

        	if($yingkui < 0) {
           		$accountObj->where(array('uid' => $order['uid']))->setInc('income_total',abs($yingkui));  	//修改用户总盈利 
            } else {
               $accountObj->where(array('uid' => $order['uid']))->setInc('loss_total',abs($yingkui));  		//修改用户总亏损
            }
		} else {
            $accountObj->where(array('uid' => $order['uid']))->setInc('gold',$money);  	 //修改用户金币
		}

		try {
			if($ostaus)
			{
				$orderObj->commit();
				if($order['type'] == 1)
				{
		       		//添加资金流水
		       		$surplusBalance = $accountObj->where(array('uid' => $order['uid']))->getField('balance');
					$this->balanceFlow($order['oid'],$order['option_name'],$money,$surplusBalance,$exchangeId,$yingkui,$order['uid'],$order['en_name']);
					//自动晒单
					$this->autoOrder($data['ploss'],$order['uid'],$order['oid']);
					//自动返还跟随费用
					$this->setByFollowBalance($data,$order);

					if($is_support == 1) {
                        $this->followOrderSelf($order['oid'],$order['uid']);
                    } else {
                        //对跟随者订单进行处理
                        $this->followOrder($order);
                    }
				}
			} else {
				$orderObj->rollback();
			}
		} catch (Exception $e) {
			$orderObj->rollback();
		}
    }


	/**
	 * [balanceFlow 添加资金流水]
	 * @param  int    $oid            [订单id]
	 * @param  string $option_name    [产品名称]
	 * @param  float  $money          [用户要增加的金额]
	 * @param  float  $surplusBalance [用户剩余金额]
	 * @param  int    $exchangeId     [运营中心id]
	 * @param  float  $yingkui        [运营中心盈亏]
	 * @param  int 	  $uid 			  [用户id]
	 * @author wang li
	 */
	private function balanceFlow(int $oid,string $option_name,float $money,float $surplusBalance,int $exchangeId,float $yingkui,int $uid,$en_name)
	{
		$flowObj = M('MoneyFlow');

		//用户资金流水表
		$userNote   = $money >= 0 ? '增加' : '扣除';
		$enUserNote = $money >= 0 ? 'increase' : 'deduction';
      	$map['uid']      	= $uid;
      	$map['type']     	= 2;
      	$map['oid']      	= $oid;
      	$map['note']     	= '对'.$option_name.'进行平仓'.$userNote.'['.$money.']美元';
        $map['en_note']    	= $en_name.' Liquidate '.$enUserNote.'['.$money.']Dollar';
      	$map['balance']  	= $surplusBalance;
      	$map['op_id']    	= $uid;
      	$map['user_type'] 	= 1;
      	$map['dateline'] 	= time();
      	$flowObj->add($map);

      	//运营中心资金流水表
      	$operateNote    = $yingkui >= 0 ? '增加' : '扣除';
        $enOperateNote  = $yingkui >= 0 ? 'increase' : 'deduction';
      	$operate['uid']      	= $exchangeId;
      	$operate['type']     	= 2;
      	$operate['oid']      	= $oid;
      	$operate['note']     	= '用户对'.$option_name.'进行平仓'.$operateNote.'['.$yingkui.']美元';
        $operate['en_note']     = 'User pairs '.$en_name.' Liquidate '.$enOperateNote.'['.$yingkui.']Dollar';
      	$operate['balance']  	= M('accountinfo')->where('uid='.$exchangeId)->sum('balance');
      	$operate['op_id']    	= $uid;
      	$operate['user_type']	= 2;
      	$operate['dateline'] 	= time();
      	$flowObj->add($operate);
	}

	/**
	 * [autoOrder 自动晒单]
	 * @author wang li
	 */
	private function autoOrder(float $ploss,int $user_id,int $order_id)
	{
		if($ploss > 0)
		{
			$userObj = M('userinfo');

			$auto = $userObj->where(array('uid' => $user_id))->getField('auto_order');

			if($auto == 1)
			{
				$dataArr = array(
					'order_id' 		=> $order_id,
					'user_id'		=> $user_id,
					'create_time'	=> time()
				);

				$publishObj = M('publish');
				$publishObj->add($dataArr);
			}
		}
	}



	/**
	 * [setByFollowBalance 根据条件设置返还跟随费用]
	 * @author wamg li
	 */
	private function setByFollowBalance(array $data,array $order)
	{	
		if($data['order_result'] == 2 && !empty($order['follow_user_id']))	//只有盈利才会返回跟随费用
		{
			//跟随费用 = 订单盈利-过夜费*20%;
   			//触发条件：每0.01手盈利大于0.5美元 公式(手数*50)

			$followObj 		= M('order_follow');
			$accouontObj 	= M('accountinfo'); 
			$flowObj 		= M('MoneyFlow');

			$conditionPrice = ($order['onumber'] * 50);

			if($data['ploss'] > $conditionPrice)
			{
				$followPrice = round((($data['ploss'] - $order['overnight_fee']) * 20) / 100,2);	//被跟随者费用

				$accouontObj->startTrans(); //开启事务

				//交易员
				$tradeArr = array(
					'balance' 		=> array('exp', '`balance`+'.$followPrice.''),
					'trader_profit' => array('exp', '`trader_profit`+'.$followPrice.''),
				);

				$trade_res 	= $accouontObj->where(array('uid' => $order['follow_user_id']))->save($tradeArr);

				if($trade_res)
				{
					//用户资金流水表
			      	$map['uid']      	= $order['follow_user_id'];
			      	$map['type']     	= 2;
			      	$map['oid']      	= $order['oid'];
			      	$map['note']     	= '跟随者对跟随订单'.$order['option_name'].'进行平仓增加跟随费用['.$followPrice.']美元';
                    $map['en_note']     = 'Follower to follower order '.$order['en_name'].' Increase follow-up costs by closing warehouses['.$followPrice.']Dollar';
			      	$map['balance']  	= $accouontObj->where(array('uid' => $order['follow_user_id']))->getField('balance');
			      	$map['op_id']    	= $order['follow_user_id'];
			      	$map['user_type'] 	= 1;
			      	$map['dateline'] 	= time();
			      	$flowObj->add($map);
				}


				//普通用户
				$userArr = array(
					'balance' 		=> array('exp', '`balance`-'.$followPrice.''),
					'follow_profit' => array('exp', '`follow_profit`+'.$data['ploss'].''),
				);
				$user_res 	= $accouontObj->where(array('uid' => $order['uid']))->save($userArr);

				$follow_res = $followObj->where(array('user_id' => $order['uid'],'follow_user_id' => $order['follow_user_id']))->setInc('follow_profit',$data['ploss']);

				if($user_res && $follow_res)
				{
					//用户资金流水表
			      	$map['uid']      	= $order['uid'];
			      	$map['type']     	= 2;
			      	$map['oid']      	= $order['oid'];
			      	$map['note']     	= '对跟随订单'.$order['option_name'].'进行平仓扣除跟随费用['.$followPrice.']美元';
                    $map['en_note']     = 'Follow-up orders '.$order['en_name'].' Open the warehouse and deduct follow-up costs['.$followPrice.']Dollar';
			      	$map['balance']  	= $accouontObj->where(array('uid' => $order['uid']))->getField('balance');
			      	$map['op_id']    	= $order['uid'];
			      	$map['user_type'] 	= 1;
			      	$map['dateline'] 	= time();
			      	$flowObj->add($map);
				}

				try {
					if($trade_res && $user_res && $follow_res)
						$accouontObj->commit();
					else
						$accouontObj->rollback();
				} catch (Exception $e) {
					$accouontObj->rollback();
				}

			}
		}
	}

	/**
	 * [followOrder 处理跟随者订单]
	 * @author wang li
	 */
	private function followOrder(array $order)
	{	
		$optionObj 	= M('option');
		$orderObj 	= M('order');
		$followObj	= M('order_follow');

		$foloow =  $followObj->field('id')->where(array('follow_user_id' => $order['uid']))->find();	//只要有数据就一定当过交易员(包括撤销)

		if($foloow)
		{
			$where = array(
				'order_type' 		=> 2,
				'follow_user_id' 	=> $order['uid'],
				'pid' 				=> $order['pid'],
				'follow_order_id' 	=> $order['oid'],
				'ostaus' 			=> 0,
				'type' 				=> 1,
			);

			$data = $orderObj->where($where)->select();

			if($data)
			{
				foreach ($data as &$value) {
					$option = $optionObj->field('wave,capital_dot_length')->where(array('id' => $value['pid']))->find();

					$value['selltime'] 	= $order['selltime'];

					$ploss = $order['ploss'] * $value['onumber'];

					$this->force($ploss,$value,$option,1);
				}	
			}
		}
	}

	//处理隔夜手续费
	public function overnight_fee($order,$info,$order_id)
	{
		$overnightObj 	= M('overnight_record');
		$orderObj		= M('order');
		$accountObj 	= M('accountinfo');

		$res = $overnightObj->where("uid={$order['uid']} and order_id={$order_id} and TO_DAYS(FROM_UNIXTIME(collect_time)) = TO_DAYS(NOW())")->find();
		if(!$res)
		{
		    //处理买多或卖空隔夜费
		    if($order['ostyle'] == 0)
                $overnight_fee = $info['overnight_fee'];
		    else
                $overnight_fee = $info['sell_overnight_fee'];

			$overnight_fee = round($order['onumber'] * $overnight_fee,2);

			if($overnight_fee <= 0)
			    return false;

			$orderObj->where(array('oid' => $order_id,'ostaus' => 0))->setInc('overnight_fee',$overnight_fee);

			if($order['type'] == 1) {
				if($accountObj->where(array('uid' => $order['uid']))->setDec('balance',$overnight_fee)) {
					$overFlow = array(
						'uid'		=> $order['uid'],
						'type'  	=> 1,
						'oid'		=> $order_id,
						'note'		=> '订单扣取隔夜费['.$overnight_fee.']美元',
                        'en_note'	=> 'Order deduction overnight fee['.$overnight_fee.']Dollar',
						'op_id'		=> $order['uid'],
						'balance' 	=> $accountObj->where(array('uid' => $order['uid']))->getField('balance'),
						'user_type' => 1,
						'dateline'	=> time()
					);
					M('money_flow')->add($overFlow);
				}

			} else {
				$accountObj->where(array('uid' => $order['uid']))->setDec('gold',$overnight_fee);
			}

			$overnight['order_id'] 		= $order_id;
			$overnight['uid'] 			= $order['uid'];
			$overnight['money'] 		= $overnight_fee;
			$overnight['collect_time'] 	= time();
			$overnightObj->add($overnight);
		}
	}

	//跟随订单转为自持订单
    private function followOrderSelf(int $order_id,int $user_id)
    {
        $orderObj 	= M('order');
        $orderObj->where(array('follow_order_id' => $order_id,'follow_user_id' => $user_id))->setField('order_type',1);
    }

}