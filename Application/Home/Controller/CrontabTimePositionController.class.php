<?php
// +----------------------------------------------------------------------
// | 定时任务时间盘平仓
// +----------------------------------------------------------------------
// | Author wang <li>
// +----------------------------------------------------------------------
namespace Home\Controller;
use Think\Controller;
use Org\Util\Log;
use Think\Cache\Driver\Redis;

class CrontabTimePositionController extends Controller {


    public function settlement()
    {
        do{
            $this->HandleOption();  //订单平仓
            usleep(500000);
        }while(true);
    }

    /**
     * 定时任务平仓
     * @author 王海东
     * @date
     * @return void
     */
    private function HandleOption()
    {
        $orderObj   = M('order');

        //订单信息
        $order      = $orderObj->field('oid')->where(array('ostaus' => 0,'order_scene' => 2))->order('oid desc')->select();

        if($order) {
            foreach ($order as $value)
                $this->HandleTrade($value['oid']);
        }
    }

    private function HandleTrade($oid)
    {
        $orderObj   = M('Order');
        $optionObj  = M('option');

        $order      = $orderObj->where(array('oid' => $oid,'ostaus' => 0))->find();

        if(!$order || !$oid) {
            return false;
        }

        //平仓价
        $option = $optionObj->field('Price')->where(array('id' => $order['pid']))->find();
        $price  = $option['Price'];


        //计算结果
        if($order['ostyle'] == 0) {
            if ($price > $order['buyprice']) {
                $direction = 1;  //赢
            } elseif ($price == $order['buyprice']) {
                $direction = 0; //平局
            } elseif ($price < $order['buyprice']) {
                $direction = -1; //输
            }
        } else {
            if ($price < $order['buyprice']) {
                $direction = 1;  // 赢
            } elseif ($price == $order['buyprice']) {
                $direction = 0; // 平局
            } elseif ($price > $order['buyprice']) {
                $direction = -1; //输
            }
        }

        if($direction == 1) {
            $ploss        = round($order['Bond'] * ($order['odds'] / 100),2);
            $money        = round($order['Bond'] + $ploss,2);
            $order_result = 2;
        } else if($direction == -1) {
            $ploss        = -$order['Bond'];
            $money        = 0;
            $order_result = 3;
        } else {
            $money        = round($order['Bond'],2);
            $ploss        = 0;
            $order_result = 1;
        }

        $dataArr = array(
            'ploss' 	=> $ploss,
            'sellprice' => $price
        );


        $orderObj->where(array('oid' => $oid,'ostaus' => 0))->save($dataArr);	//实时更新当前盈亏

        $date = date('Y-m-d H:i:s');

        if($date >= $order['finirm_time']) {

            $data = [
                'ostaus'    => 1,
                'selltime'  => time(),
                'sellprice' => $price,
                'ploss'     => $ploss,
                'order_result' => $order_result,
                'auto'      => 2,
            ];

            $this->Payment($data,$order,$money);
        }
    }


    //添加资金
    private function Payment($data,$order,$money)
    {
        $orderObj 	= M('order');
        $accountObj = M('accountinfo');

        $orderObj->startTrans();

        $ostaus = $orderObj->where(array('oid' => $order['oid'],'ostaus' => 0))->save($data);

        if($order['type'] == 1) {

            $yingkui = 0;

            if($order['order_result'] != 1) {
                $exchangeId = exchange($order['uid'],2);

                if($data['ploss'] < 0) {
                    $yingkui = abs($data['ploss']);
                } elseif($data['ploss'] > 0) {
                    $yingkui = -$data['ploss'];
                }
                $accountObj->where(array('uid' => $exchangeId))->setInc('balance',$yingkui);

                $balance = $accountObj->where(['uid' => $exchangeId])->getField('balance');

                $this->balanceFlow($order['oid'],$order['option_name'],$yingkui,$balance,$exchangeId,2,$order['en_name']);
            }

            $accountObj->where(array('uid' => $order['uid']))->setInc('balance',$money);
            $balance = $accountObj->where(['uid' => $order['uid']])->getField('balance');
            $this->balanceFlow($order['oid'],$order['option_name'],$money,$balance,$order['uid'],1,$order['en_name']);

            if($yingkui < 0) {
                $accountObj->where(array('uid' => $order['uid']))->setInc('income_total',abs($yingkui));
            } else {
                $accountObj->where(array('uid' => $order['uid']))->setInc('loss_total',abs($yingkui));
            }

            //实盘自动晒单
            $this->autoOrder($data['ploss'],$order['uid'],$order['oid']);

        } else if($order['type'] == 2) {
            $accountObj->where(array('uid' => $order['uid']))->setInc('gold',$money);
        }

        try {

            if($ostaus) {
                $orderObj->commit();
            } else {
                $orderObj->rollback();
            }
        } catch (\Exception $e) {
            $orderObj->rollback();
        }
    }

    /**
     *自动晒单
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
     * [balanceFlow 添加资金流水]
     * @param  int    $oid              [订单id]
     * @param  string $option_name      [产品名称]
     * @param  float  $money            [用户要增加的金额]
     * @param  float  $balance          [用户剩余金额]
     * @param  int 	  $uid 			    [用户id]
     * @param  int 	  $user_type 		[用户类型]
     * @author wang li
     */
    private function balanceFlow(int $oid,string $option_name,float $money,float $balance,int $uid,int $user_type,$en_name)
    {
        $flowObj        = M('MoneyFlow');
        $userNote       = $money >= 0 ? '增加' : '扣除';
        $enUserNote     = $money >= 0 ? 'increase' : 'deduction';

        $map['uid']      	= $uid;
        $map['type']     	= 2;
        $map['oid']      	= $oid;
        $map['note']     	= '用户对'.$option_name.'进行平仓'.$userNote.'['.$money.']美元';
        $map['en_note']    	= 'User pairs '.$en_name.' Liquidate'.$enUserNote.'['.$money.']Dollar';
        $map['balance']  	= $balance;
        $map['op_id']    	= $uid;
        $map['user_type'] 	= $user_type;
        $map['dateline'] 	= time();
        $flowObj->add($map);
    }
}