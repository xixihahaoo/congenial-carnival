<?php
/**
 * @author: FrankHong
 * @datetime: 2016-11-17 00:49:10
 * @filename: Crontab.php
 * @description: 系统计划任务，每天定时计算平台用户返现金额
 * @note:

 *
 */
namespace Admin\Controller;
use Think\Controller;
use Org\Util\Log;

class CrontabController extends Controller
{


    /**
     * @functionname: write_log
     * @author: FrankHong
     * @date: 2016-12-27 16:43:33
     * @description: 写脚本运行log到数据表log_cli
     * @note:
     * @param $note
     */
    public function write_log($note = '')
    {
        $logObj = M();
        $logArr = array(
            'type'          => 1,
            'script_name'   => 'opt_deal_status',
            'note'          => $note
        );

        $logObj->table('log_cli')->add($logArr);

    }


    /**
     * @functionname: opt_deal_status
     * @author: FrankHong
     * @date: 2016-12-27 16:52:47
     * @description: 升级后脚本
     * @note:
     */
    public function opt_deal_status()
    {
        date_default_timezone_set('PRC');

        $dealTimeObj    = M('option_deal_time');
        $dealTimeRs     = $dealTimeObj->order('option_id desc')->select();


        $weekNow        = date('w');


        $timeNow        = time();

        $dealTimeRs1    = array();
        foreach($dealTimeRs as $k => $v)
        {
            if($v['deal_time_type'] == 2)
            {
                $aaa	= array(
                    'option_id'         => $v['option_id'],
                    'deal_time_start'   => $v['deal_time_start'].'00',
                    'deal_time_end'	    => '235959',
                    'deal_time_type'	=> 5
                );
                $dealTimeRs1[$v['option_id']][]	= $aaa;

                //如果是把隔夜的时间拆分了，则设置一个type6
                $bbb	= array(
                    'option_id'	        => $v['option_id'],
                    'deal_time_start'	=> '000000',
                    'deal_time_end'	    => $v['deal_time_end'].'00',
                    'deal_time_type'	=> 6
                );
                $dealTimeRs1[$v['option_id']][]	= $bbb;
            }

            else
            {
                $ccc	= array(
                    'option_id'	        => $v['option_id'],
                    'deal_time_start'	=> $v['deal_time_start'].'00',
                    'deal_time_end'	    => $v['deal_time_end'].'00',
                    'deal_time_type'	=> 6,
                    'time_type'         => 1    //time_type 表示不是跨夜产品
                );
                $dealTimeRs1[$v['option_id']][] = $ccc;
            }

        }

        //        vD($dealTimeRs1);
        //        die();

        foreach($dealTimeRs1 as $k => $v)
        {
            $flagRs[$k]     = 0;
            $flagRs1[$k]    = 0;

            foreach($v as $k1 => $v1)
            {
                //当状态不为1时，则是次日，需要加上一天，得到次日该时间对应的时间戳

                if($this->opt_time($timeNow, $this->get_time_new($v1['deal_time_start']), $this->get_time_new($v1['deal_time_end'])))
                {
                    $flagRs[$k] = 1;
                }



                if($v1['deal_time_type'] != 5)
                {
                    if($this->opt_time($timeNow, $this->get_time_new($v1['deal_time_start']), $this->get_time_sell_new($v1['deal_time_end'])))
                    {
                        $flagRs1[$k] = 1;
                    }
                }
                else
                {
                    if($this->opt_time($timeNow, $this->get_time_new($v1['deal_time_start']), $this->get_time_new($v1['deal_time_end'])))
                    {
                        $flagRs1[$k] = 1;
                    }
                }

                //当前为周日时
                if($weekNow == 0)
                {
                    $flagRs[$k]     = 0;
                    $flagRs1[$k]    = 0;
                }


                //当为周六时
                if($weekNow == 6 )
                {
                    if($v1['deal_time_type'] == 6)
                    {
                        if($v1['time_type'] == 1)   //如果不是跨夜产品。那么周六必须全天休市
                        {
                            $flagRs[$k]     = 0;
                            $flagRs1[$k]    = 0;
                        } else {
                            if($this->opt_time($timeNow, $this->get_time_new($v1['deal_time_start']), $this->get_time_new($v1['deal_time_end'])))
                            {
                                $flagRs[$k]     = 1;
                            }
                            else
                            {
                                $flagRs[$k]     = 0;
                            }

                            if($this->opt_time($timeNow, $this->get_time_new($v1['deal_time_start']), $this->get_time_sell_new($v1['deal_time_end'])))
                            {
                                $flagRs1[$k]    = 1;
                            }
                            else
                            {
                                $flagRs1[$k]    = 0;
                            }
                        }
                    }

                    //如果为螺纹钢 周六则休市
                    if($v1['option_id'] == 91) {
                        $flagRs[$k]     = 0;
                        $flagRs1[$k]    = 0;
                    }
                }

                //数字币全天不休市
                $hughCity = array(95,96,97,98,99,94,93,92,81);
                if(in_array($v1['option_id'],$hughCity)) {
                    $flagRs[$k]     = 1;
                    $flagRs1[$k]    = 1;
                }
            }
        }

        // vD($dealTimeRs1);

        $optionObj  = M('option');
        $optionRs   = $optionObj->select();

        $i          = 0;
        foreach($optionRs as $k => $v)
        {
            $dealStatus = !empty($flagRs[$v['id']]) ? $flagRs[$v['id']] : 0;
            if($optionObj->where('id='.$v['id'])->setField('flag', $dealStatus))
                $i++;
        }

        $z          = 0;
        foreach($optionRs as $k => $v)
        {
            $dealStatus = !empty($flagRs1[$v['id']]) ? $flagRs1[$v['id']] : 0;
            if($optionObj->where('id='.$v['id'])->setField('sell_flag', $dealStatus))
                $z++;
        }


        $this->write_log("[note]系统本次共处理商品交易状态: [".$i.'__'.$z."]");
        Log::w("[note]\t系统本次共处理商品交易状态: [".$i.'__'.$z."]\t");

    }


    /**
     * @functionname: opt_time
     * @author: FrankHong
     * @date: 2016-11-17 11:37:11
     * @description: 判断当前时间，是否是交易时间区间，基础时间是以时区为RPC的当前时间
     * @note: 当返回true时，是交易时间
     * @return bool
     * @param $time
     * @param $time1
     * @param $time2
     */
    public function opt_time($time, $time1, $time2)
    {
        if($time > $time1 && $time < $time2)
            return true;
        else
            return false;
    }


    public function get_time_sell_new($dateStr)
    {
        $sysDate    = get_setting_config('find', 'SYSTEM_OPTION_TIME');
        $sysMinute  = $sysDate['datas']['sys_date'];

        return strtotime(date('Ymd').$dateStr) - $sysMinute * 60;
    }

    public function get_time_new($dateStr)
    {
        return strtotime(date('Ymd').$dateStr);
    }


    /**
     * @functionname: auto_commission
     * @author: wang
     * @date: 2018-5-5 11:43:22
     * @description: 结算佣金
     * @note:
     */

    public function auto_commission()
    {
        $prefix = C('DB_PREFIX');

        $sysData    = get_setting_config('find', 'SYSTEM_COMMISSION_TIME');

        $sysData    = $sysData['datas']['data'];

        $datas 		= array();
        foreach ($sysData as $key => $value) {
            if($value['checked'] == 1)
            {
                $datas = $value;
            }
        }

        if($datas['type'] == 1)
        {
//            $fee = M()->query("SELECT * FROM {$prefix}fee_receive WHERE status = 2 and type = 1 and YEARWEEK(FROM_UNIXTIME(create_time,'%Y-%m-%d'), 1) = YEARWEEK(NOW(), 1)");

            $sql = "SELECT * FROM {$prefix}fee_receive c WHERE EXISTS ( SELECT o.oid FROM {$prefix}order o WHERE c.order_id = o.oid AND o.ostaus = 1) AND c.type = 1 AND c.`status` = 2";

            $fee = M()->query($sql);

        } else if($datas['type'] == 2)
        {
            $fee = M()->query("SELECT * FROM {$prefix}fee_receive WHERE status = 2 and type = 1 and TO_DAYS(NOW()) - TO_DAYS(FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s')) <= 1");

        } else if($datas['type'] == 3)
        {
            $fee = M()->query("SELECT * FROM {$prefix}fee_receive WHERE status = 2 and type = 1 and YEARWEEK(FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s'), 1) = YEARWEEK(NOW(), 1)-1");
        }

        if($fee)
        {
            $data   = array();
            $status = array();
            foreach ($fee as $key => $value) {

                $data[$key]['user_id']      = $value['user_id'];
                $data[$key]['profit']       = $value['profit'];
                array_push($status,$value['id']);
            }

            $id = implode(',',array_unique($status));
            $result = M("FeeReceive")->where('id in('.$id.')')->setField('status',1);

            if($result){
                foreach ($data as $k => $v) {

                    $extension = M('extension')->field('user_id')->where(array('user_id' => $v['user_id']))->find();
                    if(!$extension)
                    {
                        $add['user_id'] = $v['user_id'];
                        $add['money']   = $v['profit'];
                        $add['create_time'] = time();

                        M('extension')->add($add);

                    } else {
                        M("extension")->where(array('user_id' => $v['user_id']))->setInc('money',$v['profit']);
                    }
                }
            }
        }
    }


    /**
     * @functionname: auto_upgrade
     * @author: wang
     * @date: 2018-8-8 17:57:22
     * @description: 推广员自动升级
     * @note:
     */
    public function  auto_upgrade()
    {
        $userObj    = M('userinfo');
        $orderObj   = M('order');

        $levelData = array(1 => 0,2 => 500,3 => 1000);  //升级手数

        $user = $userObj->field('uid,extension_level')->where('code is not null and otype = 4')->select();

        foreach ($user as $key => $val)
        {
            $subordinate = $userObj->field('group_concat(distinct uid) user_id,rid')->where(['rid' => $val['uid']])->find();

            if(!empty($subordinate['user_id']) && !empty($subordinate['rid']))
            {
                $onumber = $orderObj->where("uid in ({$subordinate['user_id']}) and type = 1")->sum('onumber');

                if($onumber >= 0 && $onumber < 500)
                    $extension_lenvel = 1;
                else if($onumber >= 500 && $onumber < 1000)
                    $extension_lenvel = 2;
                else if($onumber >= 1000)
                    $extension_lenvel = 3;
                else
                    $extension_lenvel = 1;

                $userObj->where(['uid' => $subordinate['rid']])->setField('extension_level',$extension_lenvel);
            }
        }
    }

}