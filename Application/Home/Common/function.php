<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/12
 * Time: 9:05
 */

  //系统基本信息
  function config($field){
    $user = M('webconfig')->where(array('id' => 1))->find();
    return $user[$field];
  }


  //交易所赠送金币
  function gold(){
   
     $gold = M("webconfig")->field('gold')->where(array('id' => 1))->find();
     return $gold['gold'];

  }

  /* 
  *function：计算两个日期相隔多少年，多少月，多少天 
  *param string $date1[格式如：2011-11-5] 
  *param string $date2[格式如：2012-12-01] 
  *return array array('年','月','日'); 
  */  
  function diffDate($date1,$date2){  
      if(strtotime($date1)>strtotime($date2)){  
          $tmp=$date2;  
          $date2=$date1;  
          $date1=$tmp;  
      }  
      list($Y1,$m1,$d1)=explode('-',$date1);  
      list($Y2,$m2,$d2)=explode('-',$date2);  
      $Y=$Y2-$Y1;  
      $m=$m2-$m1;  
      $d=$d2-$d1;  
      if($d<0){  
          $d+=(int)date('t',strtotime("-1 month $date2"));  
          $m--;  
      }  
      if($m<0){  
          $m+=12;  
          $Y--;
      }  
      return array('year'=>$Y,'month'=>$m,'day'=>$d);  
  }

  /**
   * [setExtensionLevel 自动检测推广星级]
   * @author wang li
   * @param int $uid 用户编号
   */
  function setExtensionLevel($uid)
  {

    if(empty($uid))
      return false;

    //获取推广人id
    $userObj    = M('userinfo a');
    $orderObj   = M('order');
    $rateObj    = M('userinfo_rate');
    $prefix     = C('DB_PREFIX');

    $rid = $userObj->where(array('a.uid' => $uid))->getField('a.rid');

    if(!empty($rid))
    {
      $onumber    = round($orderObj->where('uid in(select uid from '.$prefix.'userinfo where rid='.$rid.') and type=1')->sum('onumber'),2);
      $rateData   = $rateObj->getField('level,id',true); 

      $level = $userObj->where(array('a.uid' => $rid))->join('left join '.$prefix.'userinfo_rate b on a.extension_level = b.id')->getField('b.level');
      
      if($onumber >= 0 && $onumber<= 499.99) {
        if($level > 1 || $level == 1){
            return false;
        }
        $level_id = $rateData[1];
      } else if($onumber >= 500 && $onumber<= 999.99) {
        if($level > 2 || $level == 2){
            return false;
        }
        $level_id = $rateData[2];
      } else if($onumber >= 1000) {
        if($level > 3 || $level == 3){
            return false;
        }
        $level_id = $rateData[3];
      }

      if($level_id)
      {
          $userObj->where(array('a.uid' => $rid))->setField('a.extension_level',$level_id);
      }
    }
  }

  //交易累计超过2000手，5000订单，立刻获取5000积分
  function give_intergral($user_id)
  {   
      if(empty($user_id))
        return false;
      
      $integralObj    = M('integral_record');
      $orderObj       = M('order');
      $accouontObj    = M('accountinfo');
      $flowObj        = M('money_flow');

      $integralData = C('INTE.EVERY_TRADE');

      $orderData = $orderObj->field('count(oid) count,sum(onumber) onumber')->where("type=1 and uid={$user_id}")->find();

      if($orderData['count'] > $integralData['count'] && $orderData['onumber'] > $integralData['every_number'])
      {
        if(!$integralObj->field('uid')->where(array('uid' => $user_id,'type' => 7))->find())
        {
          if($accouontObj->where(array('uid' => $user_id))->setInc('integral',$integralData['intergral']))
          {
              $integral['uid']        = $user_id;
              $integral['type']       = 6;
              $integral['note']       = '累计交易超过'.$integralData['every_number'].'手赠送['.$integralData['intergral'].']积分';
              $integral['balance']    = $accouontObj->where(array('uid' => $user_id))->sum('integral');
              $integral['user_type']  = 1;
              $integral['op_id']      = $user_id;
              $integral['dateline']   = time();
              $flowObj->add($integral);

              $recordArr = array(
                  'uid'         => $user_id,
                  'integral'    => $integralData['intergral'],
                  'type'        => 7,
                  'create_time' => time()
              );
              $integralObj->add($recordArr);
          }
        }
      }
  }