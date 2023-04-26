<?php
// +----------------------------------------------------------------------
// | 定时任务挂单 控制器
// +----------------------------------------------------------------------
// | Author wang <li> 
// +----------------------------------------------------------------------
namespace Home\Controller;
use Think\Controller;
use Org\Util\Log;
use Think\Cache\Driver\Redis;

class CrontabRestingController extends Controller {

    /*
    * 自动平仓操作
    */
    public function settlement()
    {
      global $redis;
      $redis  = new Redis();
    
      do{
          $this->HandleOption();  //订单平仓

          usleep(500000); //延迟 10 描述 usleep(10000000);
      }while(true);
    }


    public function HandleOption()
    {
      global $redis;

      $guadanObj	= M('guadan_order');

      //挂单信息
      $guadan_order = $guadanObj->field('id')->where(array('status' => 1))->select();

      if($guadan_order)
      {
      	foreach ($guadan_order as $key => $value) {
      		$redis->lpush('guadan_id',$value['id']);
            $this->guadan();
      	}
      }
    }


	//处理挂单
  public function guadan()
  {
    global $redis;

    $guadan_id   	= $redis->rpop('guadan_id');

    if(empty($guadan_id))
      return false;

    $guadanObj 		= M('guadan_order');
    $optionObj 		= M('option');

    if($guadan_id)
    {
      $order = $guadanObj->where(array('id' => $guadan_id,'status' => 1))->find();
    }

    if(!$order)
    {
      $redis->del('guadan_id');
      return false;
    }

    $option = $optionObj->field('sp,bp,global_flag,flag')->where(array('id' => $order['option_id']))->find();

    if($option)
    {
        //判断挂单产品是否休市，若休市则不可挂单
        if($option['flag'] == 0 || $option['global_flag'] == 0)
            return false;

        if($order['ostyle'] == 0)
            $now_price = $option['sp'];
        else
            $now_price = $option['bp'];

        $guadanObj->where(array('id' => $order['id'],'status' => 1))->setField('now_price',$now_price);
    }

    //对已过期的订单进行失效处理
    $nowTime = time();
    if($nowTime > $order['end_time'])
    {	
      $this->handleInvalid($order);
      return false;
    }


    //判断当前是否有条件下单
    if($order['guadan_type'] == 1) {	// 1限价卖出 2限价买入 3突破卖出 4 突破买入
      if($option['bp'] >= $order['guadan_price'] ) {
        $status = 1;
        $order['sellprice'] = $option['sp'];
      }
    } else if($order['guadan_type'] == 2) {
      if($option['sp'] <= $order['guadan_price'])
      {
        $status = 1;
        $order['sellprice'] = $option['bp'];
      }
    } else if($order['guadan_type'] == 3) {
      if($option['bp'] <= $order['guadan_price'])
      {
        $status = 1;
        $order['sellprice'] = $option['sp'];
      }
    } else if($order['guadan_type'] == 4) {
      if($option['sp'] >= $order['guadan_price'])
      {
        $status = 1;
        $order['sellprice'] = $option['bp'];
      }
    }

    //处理订单 如果在相应价格之内
    if($status == 1)
    {
     $this->trade($order);
    }
  }



	//订单下单
	public function trade($order)
	{
		  $userObj = M('userinfo');

	    $order['option_name']       = $order['option_name'];  	 //产品名称
	    $order['orderno']           = generate_code(7);          //订单号码
	    $order['uid']               = $order['user_id'];         //客户编号
	    $order['pid']               = $order['option_id'];       //下单产品
	    $order['buytime']           = time();                    //下单时间
	    $order['ostyle']            = $order['ostyle'];          //0涨 1跌，
	    $order['onumber']           = $order['number'];          //下单手数
	    $order['ostaus']            = 0;                         //0交易，1平仓
	    $order['buyprice']          = $order['guadan_price'];    //下单价格
	    $order['sellprice']         = $order['sellprice'];  	   //平仓价
	    $order['endprofit']         = $order['endprofit'];  	   //止盈
	    $order['endloss']           = $order['endloss'];    	   //止损
	    $order['fee']               = $order['fee'];             //手续费
	    $order['Bond']              = $order['bond'];            //保证金
	    $order['type']              = $order['type'];			       //1实盘 2模拟
	    $order['order_type']        = 3;                         //挂单订单
	    $order['resting_type']		= $order['guadan_type'];

	    $rid        = $userObj->where(array('uid' => $order['user_id']))->getField('rid');

	    $sumPrice 	= ($order['bond'] + $order['fee']);

	    $returnArr 	= $this->placeOrder($order,$sumPrice,$rid,$order['type']);

	}

    /**
     * [firmOrder 实盘下单]
     * @author wang  li
     */
    private function placeOrder($order,$sumPrice,$rid,$now_trade_status)
    {
        $orderObj       = M('order');
        $flowObj        = M('MoneyFlow');
        $accouontObj    = M('accountinfo');
        $guadanObj      = M('guadan_order');

        $accouontObj->startTrans();

        $order_res      = $orderObj->add($order);

        //如果实盘挂单
        if($now_trade_status == 1)
        {
            //添加资金流水
            $account['uid']         = $order['user_id'];
            $account['type']        = 1;
            $account['oid']         = $order_res;
            $account['note']        = '挂单'.$order['option_name'].'成功扣除[0]美元';
            $account['en_note']     = 'List '.$order['en_name'].' Successful deduction of $0';
            $account['balance']     = $accouontObj->where(array('uid' => $order['user_id']))->sum('balance');
            $account['op_id']       = $order['user_id'];
            $account['dateline']    = time();
            $flow_res = $flowObj->add($account);

            //对待挂订单进行成功处理
            $dataArr['status'] = 3;
            $dataArr['handle_time'] = time();
            $guadan_res = $guadanObj->where(array('id' => $order['id']))->setField($dataArr);

            try {
              if($order_res && $flow_res && $guadan_res)
              {
                give_intergral($order['user_id']);      //交易累计超过2000手，5000订单，立刻获取5000积分
                setExtensionLevel($order['user_id']);   //检测上级会员等级
                $this->rebate($order['pid'],$order_res,$order['onumber'],$order['fee'],$rid,$order['user_id']); //佣金返还
                $accouontObj->commit();
              } else {
                $accouontObj->rollback();
              }
            } catch (Exception $e) {
              $accouontObj->rollback();
            }
        } else {
            $account_res    = $accouontObj->where(array('uid' => $order['user_id']))->setDec('gold',$sumPrice);
            //对待挂订单进行成功处理
            $dataArr['status'] = 3;
            $dataArr['handle_time'] = time();
            $guadan_res = $guadanObj->where(array('id' => $order['id']))->setField($dataArr);

            try {
              if($order_res && $account_res && $guadan_res)
                $accouontObj->commit();
              else
                $accouontObj->rollback();
            } catch (Exception $e) {
                $accouontObj->rollback();
            }
        }
    }



    /**
     * [rebate 返佣操作]
     * @param  [type] $option_id [产品id]
     * @param  [type] $order_id [订单id]
     * @param  [type] $number   [交易手数]
     * @param  [type] $fee      [总手续费]
     * @return [type] void      [description]
     */
    private function rebate($option_id,$order_id,$number,$fee,$rid,$user_id)
    {
      if($fee > 0)
      {
        $userObj    = M('userinfo');

        $info = $userObj->field('uid,extension_level')->where(array('uid' => $rid))->find();

        if($info)
        {
          $rateObj    = M('UserinfoRate');
          $classObj   = M('OptionClassify');
          $orderObj   = M('order');
          $optionObj  = M('option'); 

          $pid        = $optionObj->where(array('id' => $option_id))->getField('pid');
          $classId    = $classObj->where(array('id' => $pid,'level' => 2))->getField('pid');

          $data       = F('data');
          $level      = $rateObj->where(array('id' => $info['extension_level']))->getField('level');
          $price      = $data[$classId]['level'][$level]['price'];

          if(!empty($price))
          {
            $money      = $number * $price;           //收益

            $data['order_id']      = $order_id;        //订单id
            $data['user_id']       = $info['uid'];     //领取人id 0表示交易所
            $data['profit']        = $money;           //佣金收益
            $data['fee']           = $fee;             //订单总手续费
            $data['create_time']   = time();           //创建时间
            $data['status']        = 2;                //1已经发放  2未发放
            $data['type']          = 1;                //1用户 2交易所 3运营中心  4 经纪人
            $data['purchaser_id']  = $user_id;         //购买人
            M('FeeReceive')->add($data);
          }
        }
      }
    }


    /**
     * [handleInvalid 处理相关失效订单]
     * @author wang li
     */
    private function handleInvalid(array $data)
    {
    	$guadanObj 		= M('guadan_order');
    	$accouontObj 	= M('accountinfo');

    	$accouontObj->startTrans();

		$dataArr 	= array('status' => 4,'handle_time' => time());

		$res 		= $guadanObj->where(array('id' => $data['id'],'status' => 1))->save($dataArr);

		$sumPrice 	= $data['bond'] + $data['fee'];

		if($data['type'] == 1)
		{
			$account_res = $accouontObj->where(array('uid' => $data['user_id']))->setInc('balance',$sumPrice);

	        //添加资金流水
	        $account['uid']         = $data['user_id'];
	        $account['type']        = 7;
	        $account['oid']         = $data['id'];
	        $account['note']        = '撤单'.$data['option_name'].'成功返还金额['.$sumPrice.']美元';
            $account['en_note']     = 'Cancel the order '.$data['en_name'].' Successful Return Amount['.$sumPrice.']Dollar';
	        $account['balance']     = $accouontObj->where(array('uid' => $data['user_id']))->sum('balance');
	        $account['op_id']       = $data['user_id'];
	        $account['dateline']    = time();
	        M('MoneyFlow')->add($account);
		} else {
			$account_res = $accouontObj->where(array('uid' => $this->user_id))->setInc('gold',$sumPrice);
		}

		if($res && $account_res)
			$accouontObj->commit();
		else
			$accouontObj->rollback();
    }

}