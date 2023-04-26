<?php
// +----------------------------------------------------------------------
// | 定时任务跟随 控制器
// +----------------------------------------------------------------------
// | Author wang <li> 
// +----------------------------------------------------------------------
namespace Home\Controller;
use Think\Controller;
use Org\Util\Log;
use Think\Cache\Driver\Redis;

class CrontabFollowController extends Controller {

    /*
    * 自动平仓操作
    */
    public function settlement()
    {
      global $redis;
      $redis  = new Redis();

      do{
          $this->HandleOption();  //订单平仓
//          $this->HandleFollow();

          usleep(500000); //延迟 10 描述 usleep(10000000);
      }while(true);

    }


  public function HandleOption()
  {
    global $redis;

    $followObj	= M('order_follow');

    //挂单信息
    $guadan_order = $followObj->field('id')->where(array('status' => 1))->select();

    if($guadan_order)
    {
    	foreach ($guadan_order as $key => $value) {
    		$redis->lpush('follow_id',$value['id']);
            $this->HandleFollow();
    	}
    }
  }


	//处理跟随列表
  public function HandleFollow()
  {
    global $redis;

    $follow_id   	= $redis->rpop('follow_id');

    if(empty($follow_id))
      return false;
    
    $followObj 		= M('order_follow');
    $orderObj       = M('order');
    $userObj        = M('userinfo');

    if($follow_id)
    {
      $data = $followObj->where(array('id' => $follow_id,'status' => 1))->find();
    }

    if(!$data)
    {
      $redis->del('follow_id');
      return false;
    }

    //查看跟随的用户是否为交易员
    $is_trader = $userObj->where(array('uid' => $data['follow_user_id']))->getField('is_trader');
    if($is_trader == 0) {
      $this->cancelFollow($data['user_id'],$data['follow_user_id']);  //取消跟随
      return false;
    }

    //已经跟随下单的
    $followWhere['buytime']        = array('egt',$data['create_time']);
    $followWhere['ostaus']         = 0;
    $followWhere['uid']            = $data['user_id'];
    $followWhere['follow_user_id'] = $data['follow_user_id'];
    $followWhere['type']           = 1;
    $followWhere['order_scene']    = 1;

    $followData = $orderObj->where($followWhere)->select();

    //被跟随者的订单
    $orderWhere['buytime']          = array('egt',$data['create_time']);
    $orderWhere['ostaus']           = 0;
    $orderWhere['uid']              = $data['follow_user_id'];
    $orderWhere['type']             = 1;
    $orderWhere['order_scene']      = 1;

    $orderData = $orderObj->where($orderWhere)->select();

    if(count($orderData) >= count($followData))
    {
      $notFollowData = array();
      foreach ($orderData as $key => $value) {

        if(!$followData)
        {
          $notFollowData[] = $value;
        } else {
          foreach ($followData as $k => $v) {
            if($value['oid'] !== $v['follow_order_id'])
            {
              $notFollowData[] = $value;
            }
          }
        }
      }

      if($notFollowData)
      { 
          foreach ($notFollowData as $key => $value) {
            $this->trade($value,$data);
          }
      }

    }
  }


  /**
   * [trade 订单下单]
   * @param  [array] $order
   * @param  [array] $data
   * @author wang 	 li
   */
  public function trade($order,$data)
  {
    $userObj        = M('userinfo');
    $optionInfoObj  = M('option_info');

    $order['orderno']           = generate_code(7);
    $order['order_type']        = 2;
    $order['follow_user_id']    = $order['uid'];
    $order['follow_order_id']   = $order['oid'];
    $order['uid']               = $data['user_id'];


    if($data['follow_type'] == 1) //跟随方式：1固定比例 2固定手数
    {
      $onumber  = round(($order['onumber'] * $data['follow_number']),2);
      
      $onumber  = $onumber <= 0.01 ? 0.01 : $onumber;

      $bond 	= ($order['Bond'] / $order['onumber']) * $onumber;

      $order['onumber']   = $onumber;//固定比例
      $order['Bond']      = $bond;
    } else {
      $order['onumber']   = $data['follow_number'];
      $order['Bond']      = ($order['Bond'] / $order['onumber']) * $data['follow_number'];
    }

    $CounterFee         = $optionInfoObj->where(array('option_id' => $order['pid']))->getField('CounterFee');

    $order['fee']       = round($order['onumber'] * $CounterFee,2);

    $rid        = $userObj->where(array('uid' => $order['uid']))->getField('rid');

    $sumPrice   = ($order['Bond'] + $order['fee']);

    $this->placeOrder($order,$sumPrice,$rid,$order['type']);
  }


  /**
   * [firmOrder 实盘下单]
   * @author wang  li
   */
  private function placeOrder($order,$sumPrice,$rid,$now_trade_status)
  {
      global $redis;

    $orderObj       = M('order');
    $flowObj        = M('MoneyFlow');
    $accouontObj    = M('accountinfo');

    $oid        = $order['oid'];
    unset($order['oid']);

    //如果已经挂单禁止挂单
    if($orderObj->where(array('follow_order_id' => $oid,'uid' => $order['uid']))->getField('oid')) {
        $redis->del('follow_id');
        return false;
    }


    //如果实盘挂单
    if($now_trade_status == 1)
    {
      $balance    = $accouontObj->where(array('uid' => $order['uid']))->getField('balance');

      if($balance < $sumPrice)  //该用户是否资金充足，如果资金不足自动取消跟随系统
      {
        $this->cancelFollow($order['uid'],$order['follow_user_id']);
        return false;
      }

      //判断运营中心阈值是否充足 如果资金不足自动取消跟随系统
      $exchange_id = exchange($order['uid'],2);
      $acc         = $accouontObj->field('balance,frozen_threshold')->where(array('uid' => $exchange_id))->find();

      if($acc['frozen_threshold'] == 0) {
        $this->cancelFollow($order['uid'],$order['follow_user_id']);
        return false;
      }

      if($acc['balance'] <= $acc['frozen_threshold']) {
        $this->cancelFollow($order['uid'],$order['follow_user_id']);
        return false;
      }

      //运营中心金额是否小于用户下单最大保证金
      if($acc['balance'] < $order['Bond']) {
        $this->cancelFollow($order['uid'],$order['follow_user_id']);
        return false;
      }


      $accouontObj->startTrans();

      $order_res  = $orderObj->add($order);

      $account_res    = $accouontObj->where(array('uid' => $order['uid']))->setDec('balance',$sumPrice);

      //添加资金流水
      if($account_res)
      {
        $account['uid']         = $order['uid'];
        $account['type']        = 1;
        $account['oid']         = $order_res;
        $account['note']        = '跟随购买'.$order['option_name'].'包含交易费共扣除['.$sumPrice.']美元';
        $account['en_note']     = 'Follow purchase '.$order['en_name'].' Including transaction fee deduction['.$sumPrice.']Dollar';
        $account['balance']     = $accouontObj->where(array('uid' => $order['uid']))->sum('balance');
        $account['op_id']       = $order['uid'];
        $account['dateline']    = time();
        $flowObj->add($account);
      }


      if($order_res && $account_res)
      {
        setExtensionLevel($order['uid']);   //检测上级会员等级
        $this->rebate($order['pid'],$order_res,$order['onumber'],$order['fee'],$rid,$order['uid']); //佣金返还
        $accouontObj->commit();
      } else {
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
            $data['purchaser_id']  = $user_id;          //购买人
            M('FeeReceive')->add($data);
          }
        }
      }
    }


    /**
     * [cancelFollow 取消跟随]
     * @author li
     */
    private function cancelFollow(int $user_id,int $follow_user_id)
    {
      $followObj = M('order_follow');

      $followObj->where(array('user_id' => $user_id,'follow_user_id' => $follow_user_id))->setField('status',2);
    }

}