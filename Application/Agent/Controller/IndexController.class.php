<?php

namespace Agent\Controller;


class IndexController extends CommonController
{

    public function index()
    {

        $mObj       = M();
        $returnRs   = array();

        //运营中心用户信息
        $userinfoObj    = M('userinfo');

        //用户
        $whereArr   = array(
            'rid'    => NOW_UID
        );

        $userData = $userinfoObj->field('uid')->where($whereArr)->select();

        $userIdArr = array();
        foreach($userData as $k => $v)
        {
            array_push($userIdArr, $v['uid']);
        }

        $userIdStr      = implode(',', array_unique($userIdArr));


        //需要从这里添加条件
        $userinfoWhereArr   = 'uid in ('.$userIdStr.')';
        $orderRs            = $mObj->table('view_order')->where($userinfoWhereArr)->select();

        $totalFee       = array();
        $totalCount     = array();
        $totalOvernight = array();
        $totalOnumber   = array();
        $positionMoney  = array();
        $totalMoney     = array();
        foreach($orderRs as $k =>$v)
        {

            array_push($totalOvernight, $v['overnight_fee']);
            array_push($totalFee, $v['fee']);
            array_push($totalCount, $v['Bond']+$v['fee']+$v['overnight_fee']);
            array_push($totalOnumber, $v['onumber']);

            //持仓盈亏
            if($v['ostaus'] == 0)
                array_push($positionMoney, $v['ploss']);
            else
                array_push($totalMoney, $v['ploss']);
        }

        $returnRs['position_money'] = number_format(array_sum($positionMoney),2);
        $returnRs['total_money']    = number_format(array_sum($totalMoney),2);
        $returnRs['user_total']     = $userinfoObj->where($userinfoWhereArr)->count();
        $returnRs['overnight_fee']  = number_format(array_sum($totalOvernight),2);
        $returnRs['total_fee']      = number_format(array_sum($totalFee),2);
        $returnRs['total_count']    = number_format(array_sum($totalCount),2);
        $returnRs['order_total']    = empty($orderRs) ? 0 : count($orderRs);
        $returnRs['onumber_total']  = number_format(array_sum($totalOnumber),2);


        //我的资金账户
        $accountinfoObj = M('accountinfo');
        $accountinfoRs  = $accountinfoObj->where('uid=' . NOW_UID)->find();

        $returnRs['account']        = number_format($accountinfoRs['balance'],2);
        $returnRs['gold']           = number_format($accountinfoRs['gold'],2);
        $returnRs['integral']       = number_format($accountinfoRs['integral'],2);
        $returnRs['money']          = M('extension')->where(array('user_id' => NOW_UID))->getField('money');



        //本周交易信息统计
        $orderWeek = $mObj->table('view_order')->where("uid in(".$userIdStr.") and YEARWEEK(FROM_UNIXTIME(buytime,'%Y-%m-%d %H:%i:%s'),1) = YEARWEEK(now(),1)")->select();

        $totalFeeWeek       = array();
        $totalCountWeek     = array();
        $totalOvernightWeek = array();
        $totalOnumberWeek   = array();
        $totalmoneyWeek     = array();
        $totalpositionWeek  = array();
        foreach($orderWeek as $k =>$v)
        {
            array_push($totalOvernightWeek, $v['overnight_fee']);
            array_push($totalFeeWeek, $v['fee']);
            array_push($totalCountWeek, $v['Bond']+$v['fee']+$v['overnight_fee']);
            array_push($totalOnumberWeek, $v['onumber']);
            //持仓盈亏
            if($v['ostaus'] == 0)
                array_push($totalpositionWeek, $v['ploss']);
            else
                array_push($totalmoneyWeek, $v['ploss']);
        }

        $returnWeek['total_money']          = number_format(array_sum($totalmoneyWeek),2);
        $returnWeek['total_position']       = number_format(array_sum($totalpositionWeek),2);
        $returnWeek['overnight_fee']        = number_format(array_sum($totalOvernightWeek),2);
        $returnWeek['total_fee']            = number_format(array_sum($totalFeeWeek),2);
        $returnWeek['total_count']          = number_format(array_sum($totalCountWeek),2);
        $returnWeek['order_total']          = empty($orderWeek) ? 0 : count($orderWeek);
        $returnWeek['onumber_total']        = number_format(array_sum($totalOnumberWeek),2);


        $this->assign('returnWeek',$returnWeek);
        $this->assign('returnRs', $returnRs);
        $this->display();
    }
}