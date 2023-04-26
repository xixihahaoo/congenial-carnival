<?php
/**
 * @author: wang
 * @datetime: 2016-11-30 20:21:02
 * @filename: AgentController.class.php
 * @description: 运营中心销售商模块
 * @note: 
 * 
 */

namespace Ucenter\Controller;


class AgentfController extends CommonController
{

    /**
     * @functionname: agent_list
     * @author: FrankHong
     * @date: 2016-11-30 17:15:22
     * @description: 运营中心下的所有销售商列表
     * @note:
     */
    public function agent_list()
    {
        /**
         * get area
         */
        $agentId        = trim(I('get.agent_id', ''));
        $agentName      = trim(I('get.agent_name', ''));
        $agentUser      = trim(I('get.agent_user', ''));
        $agentNickname  = trim(I('get.agent_nickname', ''));
        $startTime      = urldecode(trim(I('get.start_time','')));
        $endTime        = urldecode(trim(I('get.end_time','')));


        $userinfoRelationshipObj = M('userinfo_relationship');

        $whereArr = array(
                'parent_user_id' => NOW_UID
        );
        $userinfoRelationshipRs = $userinfoRelationshipObj->where($whereArr)->select();

        $userIdArr = array();
        foreach ($userinfoRelationshipRs as $k => $v)
        {
            array_push($userIdArr, $v['user_id']);
        }

        $userIdStr = implode(',', array_unique($userIdArr));
        //vD($userIdStr);

        $userinfoObj = M('userinfo');

        //search

        $userinfoWhereArr = 'uid in (' . $userIdStr . ')';


        if($agentId)
            $userinfoWhereArr   .= ' and uid='.$agentId;

        if($agentName)
            $userinfoWhereArr   .= " and utel like '%".$agentName."%'";

        if($agentUser)
            $userinfoWhereArr   .= " and username like '%".$agentUser."%'";

        if($agentNickname)
            $userinfoWhereArr   .= " and nickname like '%".$agentNickname."%'";

        if($startTime && $endTime) {
            $start_time = strtotime($startTime);
            $end_time   = strtotime($endTime);
            $userinfoWhereArr   .= " and utime between {$start_time} and {$end_time}";
            $this->assign('startTime',$startTime);
            $this->assign('endTime',$endTime);
        }

        $count = $userinfoObj->where($userinfoWhereArr)->count();


        $pageObj = new \Think\Pageace($count, 15);
        $pageShow = $pageObj->show();

        $userinfoRs = $userinfoObj
            ->where($userinfoWhereArr)
            ->order('temptime desc')
            ->limit($pageObj->firstRow, $pageObj->listRows)
            ->select();

        //vD($userinfoRs);

        $userIdArr1 = array();
        foreach ($userinfoRs as $k => $v) {
            $userinfoRs[$k]['last_login'] = !empty($v['lastlog']) ? date('Y-m-d H:i:s', $v['lastlog']) : '<span class="label label-sm label-warning">未登录过</span>';
            $userinfoRs[$k]['last_login_ip'] = !empty($v['last_login_ip']) ? $v['last_login_ip'] : '<span class="label label-sm label-warning">未登录过</span>';
            $userinfoRs[$k]['create_date']  = date('Y-m-d H:i:s', $v['utime']);
            $userinfoRs[$k]['create_ip']    = $v['reg_ip'];
            array_push($userIdArr1, $v['uid']);
        }
        $userIdStr1 = implode(',', array_unique($userIdArr1));


        //************************
        $userinfoRs1 = array();
        foreach ($userinfoRs as $k => $v)
        {
            $userinfoRs1[$v['uid']] = $v;
            $userinfoRs1[$v['uid']]['name'] = $bankinfoRs1[$v['uid']]['busername'];


            $userinfoRs1[$v['uid']]['status_name']  = $v['ustatus'] == 0 ? '<span class="label label-sm label-success">正常</span>' : '<span class="label label-sm label-warning">冻结</span>';

            $userinfoRs1[$v['uid']]['status_o']     = $v['ustatus'] == 0 ? '冻结' : '激活';
            $userinfoRs1[$v['uid']]['status_s']     = $v['ustatus'] == 0 ? 1 : 0;
        }


        $nowStart = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;



        $this->assign('userInfo', $userinfoRs1);
        $this->assign('totalCount', $count);


        //get area
        $this->assign('agentId', $agentId);
        $this->assign('agentName', $agentName);
        $this->assign('agentUser',$agentUser);
        $this->assign('agentNickname',$agentNickname);



        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->display();
    }

    /**
     * @functionname: opt_user_status
     * @author: FrankHong
     * @date: 2016-12-01 18:10:38
     * @description: 操作用的状态
     * @note:
     */
    public function opt_user_status()
    {
        $userId             = I('post.user_id', 0);
        $userStatus         = I('post.user_status', '');

        if(!$userId)
            outjson(array('status' => 0, 'ret_msg' => '参数错误'));

        $dataArr            = array();
        $dataArr['ustatus'] = $userStatus;


        $userinfoObj        = M('userinfo');
        $userInfoWhere      = 'uid='.$userId;
        $flag               = $userinfoObj->where($userInfoWhere)->save($dataArr);


        if($flag)
            outjson(array('status' => 1, 'ret_msg' => '操作成功'));
        else
            outjson(array('status' => 0, 'ret_msg' => '操作失败'));
    }


    /**
     * @functionname: agent_detail
     * @author: FrankHong
     * @date: 2016-11-30 19:35:57
     * @description: 经纪人的详细信息
     * @note:
     */
    public function agent_detail()
    {
        $agentId    = I('get.agent_id', '');
        if(!$agentId)
        {
            $this->display('Common/error_not_found');
            die();
        }

        $userinfoObj        = M('userinfo');
        $userinfoWhereArr   = 'uid='.$agentId;

        $userinfoRs         = $userinfoObj->where($userinfoWhereArr)->find();


        $userinfoRs['status_n'] = $userinfoRs['ustatus'] == 0 ? '<span class="label label-sm label-success">正常</span>' : '<span class="label label-sm label-warning">冻结</span>';
        $userinfoRs['u_reg_time']       = date('Y-m-d H;i:s', $userinfoRs['utime']);


        $userinfoRs['u_lastlog_time']   = !empty($userinfoRs['lastlog']) ? date('Y-m-d H:i:s', $userinfoRs['lastlog']) : '<span class="label label-sm label-warning">未登录过</span>';
        $userinfoRs['u_reg_ip']         = !empty($userinfoRs['reg_ip']) ? $userinfoRs['reg_ip'] : '无';
        $userinfoRs['u_last_login_ip']  = !empty($userinfoRs['last_login_ip']) ? $userinfoRs['last_login_ip'] : '无';


        //vD($bankinfoRs);


        //用户
        $userinfoRelationshipObj    = M('userinfo_relationship');
        $userinfoRelationshipRs     = $userinfoRelationshipObj->where('parent_user_id in ('.$agentId.')')->select();

        $userIdArr      = array();
        $userRelArr     = array();
        foreach($userinfoRelationshipRs as $k => $v)
        {
            array_push($userIdArr, $v['user_id']);
            $userRelArr[$v['user_id']]['agent_id']  = $v['parent_user_id'];
        }
        $userIdStr      = implode(',', array_unique($userIdArr));



        //获取所有佣金
        $feeObj = M('fee_receive');

        $feeWhereArr    = 'type = 1 and status = 1 and user_id in ('.$userIdStr.')';
        $feeRs          = $feeObj->where($feeWhereArr)->select();

        $orderObj       = M();
        $orderWhereStr  = 'uid in ('.$userIdStr.')';

        $orderRs = $orderObj->table('view_order')->where($orderWhereStr)->select();
        $optionObj  = M('option');
        $optionRs   = $optionObj->select();
        foreach($optionRs as $k => $v)
        {
            $optionRs1[$v['id']]    = $v;
        }

        $returnRs       = array();
        if(!empty($orderRs))
        {

            $totalFee   = array();
            $totalMoney = array();
            foreach($orderRs as $k => $v)
            {
                array_push($totalFee, $v['fee']);
                array_push($totalMoney, $v['ploss']);
            }

            $returnRs['total_fee']      = number_format(array_sum($totalFee),2);
            $returnRs['total_money']    = number_format(array_sum($totalMoney),2);
        }
        else
        {
            $returnRs['total_fee']      = 0;
            $returnRs['total_money']    = 0;
        }

        $totalCommission    = array();
        $returnRs['total_commission']   = 0;
        foreach($feeRs as $k => $v)
        {
            $returnRs['total_commission'] += $v['profit'];
        }

        
        //经纪人本周资金信息
        $orderWeek = $orderObj->table('view_order')->where("uid in(".$userIdStr.") and YEARWEEK(FROM_UNIXTIME(buytime,'%Y-%m-%d %H:%i:%s'),1) = YEARWEEK(now(),1)")->select();
        if(!empty($orderWeek))
        {
            $totalFeeWeek   = array();
            $totalMoneyWeek = array();
            foreach($orderWeek as $k => $v)
            {
                array_push($totalFeeWeek, $v['fee']);
                array_push($totalMoneyWeek, $v['ploss']);
            }

            $returnWeek['total_fee']      = number_format(array_sum($totalFeeWeek),2);
            $returnWeek['total_money']    = number_format(array_sum($totalMoneyWeek),2);
        }
        else
        {
            $returnWeek['total_fee']      = 0;
            $returnWeek['total_money']    = 0;
        }
        
        //获取本周佣金
        $feeWeek        = $feeObj->where("type = 1 and status = 1 and user_id in(".$userIdStr.") and YEARWEEK(FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s'),1) = YEARWEEK(now(),1)")->select();
        $totalCommission    = array();
        $returnWeek['total_commission']   = 0;
        foreach($feeWeek as $k => $v)
        {
            $returnWeek['total_commission'] += $v['profit'];
        }

        $this->assign('userinfoRs', $userinfoRs);
        $this->assign('returnRs', $returnRs);
        $this->assign('returnWeek',$returnWeek);
        $this->display();
    }


    /**
     * @functionname: add_agent
     * @author: FrankHong
     * @date: 2016-12-01 11:15:34
     * @description: 运营中心增加代理账户
     * @note:
     */
    public function add_agent()
    {

        $this->assign('s_domain', SYSTEM_DOMAIN);
        $this->assign('now_user_id', NOW_UID);
        $this->display();
    }

    /**
     * @functionname: edit_agent
     * @author: FrankHong
     * @date: 2016-12-02 09:44:51
     * @description: 修改经纪人信息
     * @note:
     */
    public function edit_agent()
    {
        $userId = I('get.user_id', 0);

        if(!$userId)
        {
            $this->display('Common/error_no_info');
            die();
        }

        $userinfoObj        = M('userinfo');
        $userInfoWhere      = 'uid='.$userId;
        $userInfoRs         = $userinfoObj->where($userInfoWhere)->find();

        $this->assign('userInfo', $userInfoRs);

        $this->display();
    }


    /**
     * @functionname: opt_edit_agent
     * @author: FrankHong
     * @date: 2016-12-02 10:02:13
     * @description: 处理修改经纪人信息
     * @note:
     */
    public function opt_edit_agent()
    {
        //$nowUserId  = I('post.now_user_id', 0);
        $userId     = I('post.user_id');
        $password   = I('post.password', '');
        $nickname   = I('post.nickname', '');
        $mobile     = I('post.mobile', '');
        $opentlist     = I('post.opentlist',0);//是否开放持仓监控功能

        if(!$userId)
            outjson(array('status' => 0, 'ret_msg' => '系统错误'));

        if(!$nickname || !$mobile)
            outjson(array('status' => 0, 'ret_msg' => '不能为空'));

        $dataArr    = array();

        if(!empty($password))
            $dataArr['upwd']        = md5($password);

        $dataArr['nickname']    = $nickname;
        $dataArr['utel']        = $mobile;
        //$dataArr['s_domain_name']   = $domainName;
        $dataArr['update_time'] = time();
        $dataArr['opentlist'] = $opentlist;

        $userinfoObj    = M('userinfo');
        $whereStr       = 'uid=' . $userId;
        $userinfoRs     = $userinfoObj->where($whereStr)->find();


        if (!$userinfoRs)
        {
            outjson(array('status' => 0, 'ret_msg' => '系统错误：未查询到信息！'));
        }
        else
        {
            $flag   = $userinfoObj->where($whereStr)->save($dataArr);
            if($flag)
                outjson(array('status' => 1, 'ret_msg' => '保存成功'));
            else
                outjson(array('status' => 0, 'ret_msg' => '保存失败！'));
        }

    }


    /**
     * @functionname: opt_add_agent
     * @author: FrankHong
     * @date: 2016-12-01 15:46:51
     * @description: 处理代理账户的添加
     * @note:
     * array(4) {
     * ["username"]=>
     * string(4) "aaaa"
     * ["password"]=>
     * string(5) "bbbbb"
     * ["nickname"]=>
     * string(11) "11111111111"
     * ["mobile"]=>
     * string(10) "2331231312"
     * }
     */
    public function opt_add_agent()
    {

        $nowUserId  = I('post.now_user_id', 0);
        $username   = I('post.username', '');
        $password   = I('post.password', '');
        $nickname   = I('post.nickname', '');
        $mobile     = I('post.mobile', '');
        $opentlist  = I('post.opentlist',0);//是否开放持仓监控功能
        $domain     = I('post.domain', '');
        $domainName = I('post.domain_name', '');

        $dataArr    = array();

        $dataArr['username']    = $username;
        $dataArr['upwd']        = md5($password);
        $dataArr['nickname']    = $nickname;
        $dataArr['utel']        = $mobile;
        $dataArr['utime']       = time();
        $dataArr['reg_ip']      = get_client_ip();
        $dataArr['otype']       = 6;
        $dataArr['oid']         = $nowUserId;
        $dataArr['opentlist']   = $opentlist;


        $acountinfoObj  = M('accountinfo');
        $userRelObj     = M('userinfo_relationship');
        $userinfoObj    = M('userinfo');

        $userinfoRs = $userinfoObj->where("username='$username'")->find();

        if (!$userinfoRs)
        {
            $flag   = $userinfoObj->add($dataArr);
            if ($flag)
            {
                $dataAccountArr['uid']      = $flag;
                $dataAccountArr['balance']  = 0.00;
                $acountinfoObj->add($dataAccountArr);

                $dataRelationshipArr['user_id']         = $flag;
                $dataRelationshipArr['parent_user_id']  = $nowUserId;
                $dataRelationshipArr['all_path']        = $nowUserId . ',' . $flag;
                $userRelObj->add($dataRelationshipArr);

                outjson(array('status' => 1, 'ret_msg' => '销售商添加成功！'));
            }
        }
        else
        {
            outjson(array('status' => 0, 'ret_msg' => '保存失败：用户名已经存在。'));
        }

    }

}