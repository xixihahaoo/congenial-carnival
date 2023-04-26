<?php
/**
 * @author: FrankHong
 * @datetime: 2016/11/30 16:08
 * @filename: IndexsController.class.php
 * @description: 经纪人首页，主做统计
 * @note: 
 * 
 */

namespace Ucenter\Controller;


class IndexsController extends CommonController
{

    public function index()
    {

        $mObj       = M();
        $returnRs   = array();

        $userinfoRelationshipObj    = M('userinfo_relationship');

        $userinfoObj    = M('userinfo');

        //用户
        $whereArr   = array(
            'parent_user_id'    => NOW_UID
        );
        $agentinfoRelationshipRs    = $userinfoRelationshipObj->where($whereArr)->select();

        $agentIdArr = array();
        foreach($agentinfoRelationshipRs as $k => $v)
        {
            array_push($agentIdArr, $v['user_id']);
        }
        $userIdStr  = implode(',', array_unique($agentIdArr));

        $agentinfoWhereArr  = 'uid in ('.$userIdStr.')';

        $returnRs['user_total']    = $userinfoObj->where($agentinfoWhereArr)->count();


        //需要从这里添加条件
        $userinfoWhereArr   = 'uid in ('.$userIdStr.')';
//      $orderRs            = $mObj->table('view_order')->where($userinfoWhereArr)->select();

        $orderRsCount   = $mObj->table('view_order')->where($userinfoWhereArr)->count('oid');
        $totalOvernight = $mObj->table('view_order')->where($userinfoWhereArr)->sum('overnight_fee');
        $totalFee       = $mObj->table('view_order')->where($userinfoWhereArr)->sum('fee');
        $totalCount     = $mObj->table('view_order')->where($userinfoWhereArr)->sum('Bond');
        $totalCount     = ($totalCount + $totalFee + $totalOvernight);
        $totalOnumber   = $mObj->table('view_order')->where($userinfoWhereArr)->sum('onumber');

        $sql_loading    = $userinfoWhereArr.' and ostaus = 0';
        $positionMoney  = $mObj->table('view_order')->where($sql_loading)->sum('ploss');

        $sql_over   = $userinfoWhereArr.' and ostaus = 1';
        $totalMoney = $mObj->table('view_order')->where($sql_over)->sum('ploss');

        $returnRs['position_money'] = number_format($positionMoney,2);
        $returnRs['total_money']    = number_format($totalMoney,2);
        $returnRs['user_total']     = $userinfoObj->where($userinfoWhereArr)->count();
        $returnRs['overnight_fee']  = number_format($totalOvernight,2);
        $returnRs['total_fee']      = number_format($totalFee,2);
        $returnRs['total_count']    = number_format($totalCount,2);
        $returnRs['order_total']    = $orderRsCount;
        $returnRs['onumber_total']  = number_format($totalOnumber,2);

        //        $totalFee       = array();
        //        $totalCount     = array();
        //        $totalOvernight = array();
        //        $totalOnumber   = array();
        //        $positionMoney  = array();
        //        $totalMoney     = array();
        //        foreach($orderRs as $k =>$v)
        //        {
        //            array_push($totalOvernight, $v['overnight_fee']);
        //            array_push($totalFee, $v['fee']);
        //            array_push($totalCount, $v['Bond']+$v['fee']+$v['overnight_fee']);
        //            array_push($totalOnumber, $v['onumber']);
        //
        //            //持仓盈亏
        //            if($v['ostaus'] == 0)
        //                array_push($positionMoney, $v['ploss']);
        //            else
        //                array_push($totalMoney, $v['ploss']);
        //        }
        //
        //        $returnRs['position_money'] = number_format(array_sum($positionMoney),2);
        //        $returnRs['total_money']    = number_format(array_sum($totalMoney),2);
        //        $returnRs['user_total']     = $userinfoObj->where($userinfoWhereArr)->count();
        //        $returnRs['overnight_fee']  = number_format(array_sum($totalOvernight),2);
        //        $returnRs['total_fee']      = number_format(array_sum($totalFee),2);
        //        $returnRs['total_count']    = number_format(array_sum($totalCount),2);
        //        $returnRs['order_total']    = empty($orderRs) ? 0 : count($orderRs);
        //        $returnRs['onumber_total']  = number_format(array_sum($totalOnumber),2);


        //保证金
        $accountinfoObj = M('accountinfo');
        $accountinfoRs  = $accountinfoObj->where('uid=' . NOW_UID)->find();

        $returnRs['account']        = number_format($accountinfoRs['balance'],2);

        //手续费
        $feeObj = M('fee_receive');

        //下面的用户获得佣金

        $feeWhereArr    = 'type = 1 and user_id in ('.$userIdStr.')';
        $feeRs          = $feeObj->where($feeWhereArr)->select();
        $totalCommissionUser= array();
        foreach($feeRs as $k => $v)
        {
            array_push($totalCommissionUser, $v['profit']);
        }
        $returnRs['total_user_commission']  = number_format(array_sum($totalCommissionUser),2);
        


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



        //用户推广佣金
        $feeWhereArrWeek    = "type = 1 and user_id in (".$userIdStr.") and YEARWEEK(FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s'),1) = YEARWEEK(now(),1)";
        $feeRsWeek          = $feeObj->where($feeWhereArrWeek)->select();
        $totalCommissionWeek= array();
        foreach($feeRsWeek as $k => $v)
        {
            array_push($totalCommissionWeek, $v['profit']);
        }
        $returnWeek['total_user_commission']  = number_format(array_sum($totalCommissionWeek),2);

        $this->assign('returnWeek',$returnWeek);
        $this->assign('returnRs', $returnRs);
        $this->display();
    }


}