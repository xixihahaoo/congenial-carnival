<?php
/**
 * @author: FrankHong
 * @datetime: 2016/12/2 20:36
 * @filename: OrderfController.class.php
 * @description: 运营中心订单模块
 * @note: 
 * 
 */

namespace Ucenter\Controller;


class CashorderfController extends CommonController
{
    /**
     * @functionname: cash_list
     * @author: wang
     * @date: 2018-4-16 14:18:26
     * @description: 运营中心订单列表--现金订单
     * @note:
     *
     * 1.所有经纪人
     * 2.所有用户
     * 3.所有订单
     */

    public function cash_list() {

        $order      = M('order');
        $user       = M('userinfo');
        $where      = "";

        $jinjiren      = trim(I('get.jinjiren'));
        $users         = trim(I('get.user'));
        $starttime     = urldecode(trim(I('get.start_time')));
        $endtime       = urldecode(trim(I('get.end_time')));
        $email         = trim(I('get.email'));
        $jostyle       = trim(I('get.jostyle'));
        $order_result  = trim(I('get.order_result'));
        $status        = trim(I('get.status'));
        $datetype      = trim(I('get.datetype'));
        $type          = trim(I('get.type'));

        $username   = trim(I('get.username'));
        $nickname   = trim(I('get.nickname'));
        $oid         = trim(I('get.oid'));

        $optin_class_max      = trim(I('get.optin_class_max')); 
        $optin_class_min      = trim(I('get.optin_class_min')); 
        $option_name          = trim(I('get.option_name'));

        $sea['type'] = $type;

        //经纪人列表()
        $whereArr   = array(
            'parent_user_id'    => NOW_UID
        );
        $agentinfoRelationshipRs    = M("UserinfoRelationship")->where($whereArr)->select();

        $agentIdArr  = array();
        foreach($agentinfoRelationshipRs as $k => $v)
        {
            array_push($agentIdArr, $v['user_id']);
        }
        $agentIdStr  = implode(',', array_unique($agentIdArr));

        $agentinfoWhereArr  = 'uid in ('.$agentIdStr.')';

        $agentinfoRs    = M("userinfo")->where($agentinfoWhereArr)->select();
        $this->assign('agentinfoRs',$agentinfoRs);
         
        //用户
        $ship = M("UserinfoRelationship")->where('parent_user_id in('.$agentIdStr.')')->select();
        $shipArr = array();
        foreach ($ship as $key => $value) {
            array_push($shipArr,$value['user_id']);
        }
        $userIdStr      = implode(',', array_unique($shipArr));
        $where['uid'] = array('in',implode(',',array_unique($shipArr)));


        //联动经纪人筛选
        if($jinjiren){
            
            $userarr  = array();
            $userarr1 = array();
            $ship = M("UserinfoRelationship")->where(array('parent_user_id' => $jinjiren))->select();
            foreach ($ship as $key => $value) {
                array_push($userarr, $value['user_id']);
            }
            $id = implode(',',array_unique($userarr));

            $where['uid'] = array('in',$id);
            $sea['jinjiren'] = $jinjiren;
            $this->assign('jingji',$jinjiren);
        }

        //联动用户筛选
        if($users) {
            $id = $users; 
            $where['uid'] = array('in',$id);
            $sea['user'] = $users;
            $this->assign('user',$this->get_username($users));
        }

        //日期筛选
        if($starttime && $endtime){
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $where['buytime'] = array('between',array($start_time,$end_time));
            $sea['start_time'] = $starttime;
            $sea['end_time'] = $endtime;
            $this->assign('time',$sea);
        } else {
            $starttime  = strtotime(date('Y-m-d')." 06:00:00");
            $endtime    = strtotime(date('Y-m-d')." 05:00:00")+ 3600*24;
            $where['buytime']    = array('between',''.$starttime.','.$endtime.'');
            $sea['start_time'] = date('Y-m-d H:i:s',$starttime);
            $sea['end_time']   = date('Y-m-d H:i:s',$endtime);
            $this->assign('time',$sea);
        }


        //订单类型筛选
        if($jostyle){
            $sea['jostyle'] = $jostyle;
            $this->assign('jostyle',$jostyle);
            $jostyle = $jostyle == 1?0:1;
            $where['ostyle'] = $jostyle;
        }

        //订单结果筛选
        if($order_result){
            $where['order_result']  = $order_result;
            $this->assign('order_result',$order_result);
            $sea['order_result']    = $order_result;
        }

        //订单状态筛选
        if($status || $status == '0') {
            $where['ostaus']    = $status;
            $sea['status']      = $status;
            $this->assign('status',$status);
        }
        
        //昨天
        $this->assign("starttimeYesterday", date('Y-m-d 06:00:00',strtotime('-1 day')));
        $this->assign("endtimeYesterday", date('Y-m-d 05:00:00'));

        //本周
        $this->assign("starttimeWeek", date('Y-m-d 06:00:00',strtotime('-1 monday')));
        $this->assign("endtimeWeek", date('Y-m-d 05:00:00',strtotime('+1 day')));
        //上周
        $this->assign("starttimeLastWeek", date('Y-m-d 06:00:00',strtotime('-2 monday')));
        $this->assign("endtimeLastWeek", date('Y-m-d 05:00:00',strtotime('-1 monday')));
        //上月
        $this->assign("starttimeLastMonth", date('Y-m-01 06:00:00',strtotime('-1 month')));
        $this->assign("endtimeLastMonth", date('Y-m-d H:i:s',strtotime(date('Y-m-t 05:00:00',strtotime('-1 month')))+ 3600*24));

        if($datetype > 0){
            $sea['datetype'] = $datetype;
            $this->assign("datetype", $datetype);
        }

        //手机号码筛选
        if($email) {
            $uid = $user->where("email='{$email}' and otype=4 and uid in({$userIdStr})")->getField('uid');
            $where['uid']   = $uid;
            $sea['email']   = $email;
            $this->assign('email',$email);
        }

        //用户名称
        if($username)
        {   
            $uid = $user->where("username='{$username}' and otype=4 and uid in({$userIdStr})")->getField('uid');
            $where['uid']   = $uid;
            $sea['username']    = $username;
            $this->assign('username',$username);
        }

        //用户昵称
        if($nickname)
        {
            $uid = $user->where("nickname='{$nickname}' and otype=4 and uid in({$userIdStr})")->getField('uid');
            $where['uid']       = $uid;
            $sea['nickname']    = $nickname;
            $this->assign('nickname',$nickname);
        }

        //编号
        if($oid)
        {
            $where['oid']   = $oid;
            $sea['oid']     = $oid;
            $this->assign('oid',$oid);
        }

        //分类大类
        if($optin_class_max)
        {
            $classObj = M('OptionClassify');
            $data = $classObj->field('group_concat(distinct id) id')->where(array('pid' => $optin_class_max))->find();

            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')->where('pid in('.$data['id'].')')->find();

            $where['pid'] = array('in',$option['id']);

            $sea['optin_class_max'] = $optin_class_max;
            $this->assign('optin_class_max',$optin_class_max);
        }

        //分类小类
        if($optin_class_min)
        {
            $classObj = M('OptionClassify');
            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')->where('pid='.$optin_class_min)->find();

            $where['pid'] = array('in',$option['id']);

            $mindata = $classObj->field('id,name')->where('id in('.$data['id'].')')->select();

            $sea['optin_class_min'] = $optin_class_min;
            $this->assign('mindata',$mindata);
            $this->assign('optin_class_min',$optin_class_min);
        }

        //产品名称
        if ($option_name) 
        {   
            $where['pid'] = $option_name;

            $optionObj = M('option');

            $option = $optionObj->field('id,capital_name')->where('pid='.$optin_class_min)->select();

            $sea['option_name'] = $option_name;
            $this->assign('option',$option);
            $this->assign('option_name',$option_name);
        }



        $where['type'] = $type;       //区分真实和模拟交易

        $count      = $order->where($where)->count();
        $pagecount  = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $sea; //此处的row是数组，为了传递查询条件
        $page->setConfig('first','首页');
        $page->setConfig('prev','<<');
        $page->setConfig('next','>>');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $start = $page->firstRow;
        $end = $page->listRows;

        $tlist = $order->where($where)->order('oid desc')->limit($start,$end)->select();

        
        $userIdArr = array();
        foreach ($tlist as $key => $value) {
             array_push($userIdArr,$value['uid']);
        }

        $userId = implode(',',array_unique($userIdArr));
        if($userId)
        {
            $user   = M('userinfo')->where('uid in('.$userId.')')->getField('uid,email,username,nickname',true);
        }

        
        foreach ($tlist as $key => $value) 
        {
            $tlist[$key]['email']    = $user[$value['uid']]['email'];
            $tlist[$key]['username'] = $user[$value['uid']]['username'];
            $tlist[$key]['nickname'] = $user[$value['uid']]['nickname'];

            if($value['ostaus'] == 1)
                $tlist[$key]['access']  = (($value['ploss']) - $value['fee']) - $value['overnight_fee'];
                
            else
                $tlist[$key]['access']  = -($value['Bond'] + $value['fee']) + $value['overnight_fee'];
        }


        //用于统计

        /********************底部统计**************************/

        $data['count']      = $count;   //总订单   
        $orderSta           = $order->field('sum(fee) fee,sum(overnight_fee) overnight_fee,sum(Bond) Bond,sum(ploss) ploss')->where($where)->find();
        
        $data['fee']            = $orderSta['fee'];
        $data['bond']           = $orderSta['Bond'];
        $data['overnight_fee']  = $orderSta['overnight_fee'];
        $data['account']        = ($data['fee'] + $data['bond'] + $data['overnight_fee']);

        $data['ploss']          = $orderSta['ploss'];
        /**********************************************/
        
        //产品大类
        $classify   = M('option_classify')->field('id,name')->where(array('level' => 1))->select();
        $this->assign('classify',$classify);



        $this->assign('data',$data);
        $this->assign('totalCount',$count);
        $this->assign('nowStart',!I('get.p')?1:I('get.p'));
        $this->assign('nowEnd',ceil($count/$pagecount));
        $this->assign('tlist',$tlist);
        $this->assign('page',$page->show());

        $this->display();
    }


    /**
     * @functionname: order_list_gold
     * @author: wang
     * @date: 2018-4-16 14:18:26
     * @description: 运营中心订单列表--积分订单
     * @note:
     *
     * 1.所有经纪人
     * 2.所有用户
     * 3.所有订单
     */

    public function order_list_gold() {
        
        $order      = M('order');
        $user       = M('userinfo');
        $where      = "";

        $jinjiren      = trim(I('get.jinjiren'));
        $users         = trim(I('get.user'));
        $starttime     = urldecode(trim(I('get.start_time')));
        $endtime       = urldecode(trim(I('get.end_time')));
        $email         = trim(I('get.email'));
        $jostyle       = trim(I('get.jostyle'));
        $order_result  = trim(I('get.order_result'));
        $status        = trim(I('get.status'));
        $datetype      = trim(I('get.datetype'));
        $type          = trim(I('get.type'));

        $username   = trim(I('get.username'));
        $nickname   = trim(I('get.nickname'));
        $oid         = trim(I('get.oid'));

        $optin_class_max      = trim(I('get.optin_class_max')); 
        $optin_class_min      = trim(I('get.optin_class_min')); 
        $option_name          = trim(I('get.option_name'));

        $sea['type'] = $type;


        //经纪人列表()
        $whereArr   = array(
            'parent_user_id'    => NOW_UID
        );
        $agentinfoRelationshipRs    = M("UserinfoRelationship")->where($whereArr)->select();

        $agentIdArr  = array();
        foreach($agentinfoRelationshipRs as $k => $v)
        {
            array_push($agentIdArr, $v['user_id']);
        }
        $agentIdStr  = implode(',', array_unique($agentIdArr));

        $agentinfoWhereArr  = 'uid in ('.$agentIdStr.')';

        $agentinfoRs    = M("userinfo")->where($agentinfoWhereArr)->select();
        $this->assign('agentinfoRs',$agentinfoRs);
         
        //用户
        $ship = M("UserinfoRelationship")->where('parent_user_id in('.$agentIdStr.')')->select();
        $shipArr = array();
        foreach ($ship as $key => $value) {
            array_push($shipArr,$value['user_id']);
        }

        $userIdStr      = implode(',', array_unique($shipArr));
        $where['uid']   = array('in',implode(',',array_unique($shipArr)));

        //联动经纪人筛选
        if($jinjiren){
            
            $userarr  = array();
            $userarr1 = array();
            $ship = M("UserinfoRelationship")->where(array('parent_user_id' => $jinjiren))->select();
            foreach ($ship as $key => $value) {
                array_push($userarr, $value['user_id']);
            }
            $id = implode(',',array_unique($userarr));

            $where['uid'] = array('in',$id);
            $sea['jinjiren'] = $jinjiren;
            $this->assign('jingji',$jinjiren);
        }

        //联动用户筛选
        if($users) {
            $id = $users; 
            $where['uid'] = array('in',$id);
            $sea['user'] = $users;
            $this->assign('user',$this->get_username($users));
        }

        //日期筛选
        if($starttime && $endtime){
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $where['buytime'] = array('between',array($start_time,$end_time));
            $sea['start_time'] = $starttime;
            $sea['end_time'] = $endtime;
            $this->assign('time',$sea);
        } else {
            $starttime  = strtotime(date('Y-m-d')." 06:00:00");
            $endtime    = strtotime(date('Y-m-d')." 05:00:00")+ 3600*24;
            $where['buytime']    = array('between',''.$starttime.','.$endtime.'');
            $sea['start_time'] = date('Y-m-d H:i:s',$starttime);
            $sea['end_time']   = date('Y-m-d H:i:s',$endtime);
            $this->assign('time',$sea);
        }

        //订单类型筛选
        if($jostyle){
            $sea['jostyle'] = $jostyle;
            $this->assign('jostyle',$jostyle);
            $jostyle = $jostyle == 1?0:1;
            $where['ostyle'] = $jostyle;
        }

        //订单结果筛选
        if($order_result){
            $where['order_result']  = $order_result;
            $this->assign('order_result',$order_result);
            $sea['order_result']    = $order_result;
        }

        //订单状态筛选
        if($status || $status == '0') {
            $where['ostaus']    = $status;
            $sea['status']      = $status;
            $this->assign('status',$status);
        }

        //昨天
        $this->assign("starttimeYesterday", date('Y-m-d 06:00:00',strtotime('-1 day')));
        $this->assign("endtimeYesterday", date('Y-m-d 05:00:00'));

        //本周
        $this->assign("starttimeWeek", date('Y-m-d 06:00:00',strtotime('-1 monday')));
        $this->assign("endtimeWeek", date('Y-m-d 05:00:00',strtotime('+1 day')));
        //上周
        $this->assign("starttimeLastWeek", date('Y-m-d 06:00:00',strtotime('-2 monday')));
        $this->assign("endtimeLastWeek", date('Y-m-d 05:00:00',strtotime('-1 monday')));
        //上月
        $this->assign("starttimeLastMonth", date('Y-m-01 06:00:00',strtotime('-1 month')));
        $this->assign("endtimeLastMonth", date('Y-m-d H:i:s',strtotime(date('Y-m-t 05:00:00',strtotime('-1 month')))+ 3600*24));

        if($datetype > 0){
            $sea['datetype'] = $datetype;
            $this->assign("datetype", $datetype);
        }

        //手机号码筛选
        if($email) {
            $uid = $user->where("email='{$email}' and otype=4 and uid in({$userIdStr})")->getField('uid');
            $where['uid']   = $uid;
            $sea['email']   = $email;
            $this->assign('email',$email);
        }

        //用户名称
        if($username)
        {   
            $uid = $user->where("username='{$username}' and otype=4 and uid in({$userIdStr})")->getField('uid');
            $where['uid']   = $uid;
            $sea['username']    = $username;
            $this->assign('username',$username);
        }

        //用户昵称
        if($nickname)
        {
            $uid = $user->where("nickname='{$nickname}' and otype=4 and uid in({$userIdStr})")->getField('uid');
            $where['uid']       = $uid;
            $sea['nickname']    = $nickname;
            $this->assign('nickname',$nickname);
        }

        //编号
        if($oid)
        {
            $where['oid']   = $oid;
            $sea['oid']     = $oid;
            $this->assign('oid',$oid);
        }

        //分类大类
        if($optin_class_max)
        {
            $classObj = M('OptionClassify');
            $data = $classObj->field('group_concat(distinct id) id')->where(array('pid' => $optin_class_max))->find();

            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')->where('pid in('.$data['id'].')')->find();

            $where['pid'] = array('in',$option['id']);

            $sea['optin_class_max'] = $optin_class_max;
            $this->assign('optin_class_max',$optin_class_max);
        }

        //分类小类
        if($optin_class_min)
        {
            $classObj = M('OptionClassify');
            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')->where('pid='.$optin_class_min)->find();

            $where['pid'] = array('in',$option['id']);

            $mindata = $classObj->field('id,name')->where('id in('.$data['id'].')')->select();

            $sea['optin_class_min'] = $optin_class_min;
            $this->assign('mindata',$mindata);
            $this->assign('optin_class_min',$optin_class_min);
        }

        //产品名称
        if ($option_name) 
        {   
            $where['pid'] = $option_name;

            $optionObj = M('option');

            $option = $optionObj->field('id,capital_name')->where('pid='.$optin_class_min)->select();

            $sea['option_name'] = $option_name;
            $this->assign('option',$option);
            $this->assign('option_name',$option_name);
        }

        $where['type'] = $type;       //区分真实和模拟交易

        $count      = $order->where($where)->count();
        $pagecount  = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $sea; //此处的row是数组，为了传递查询条件
        $page->setConfig('first','首页');
        $page->setConfig('prev','<<');
        $page->setConfig('next','>>');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $start = $page->firstRow;
        $end = $page->listRows;

        $tlist = $order->where($where)->order('oid desc')->limit($start,$end)->select();

        
        $userIdArr = array();
        foreach ($tlist as $key => $value) {
             array_push($userIdArr,$value['uid']);
        }

        $userId = implode(',',array_unique($userIdArr));
        if($userId)
        {
            $user   = M('userinfo')->where('uid in('.$userId.')')->getField('uid,email,username,nickname',true);
        }

        
        foreach ($tlist as $key => $value) 
        {
            $tlist[$key]['email']    = $user[$value['uid']]['email'];
            $tlist[$key]['username'] = $user[$value['uid']]['username'];
            $tlist[$key]['nickname'] = $user[$value['uid']]['nickname'];

            if($value['ostaus'] == 1)
                $tlist[$key]['access']  = (($value['ploss']) - $value['fee']) - $value['overnight_fee'];
                
            else
                $tlist[$key]['access']  = -($value['Bond'] + $value['fee']) + $value['overnight_fee'];
        }


        //用于统计

        /********************底部统计**************************/

        $data['count']      = $count;   //总订单   
        $orderSta           = $order->field('sum(fee) fee,sum(overnight_fee) overnight_fee,sum(Bond) Bond,sum(ploss) ploss')->where($where)->find();
        
        $data['fee']            = $orderSta['fee'];
        $data['bond']           = $orderSta['Bond'];
        $data['overnight_fee']  = $orderSta['overnight_fee'];
        $data['account']        = ($data['fee'] + $data['bond'] + $data['overnight_fee']);

        $data['ploss']          = $orderSta['ploss'];
        /**********************************************/
        //产品大类
        $classify   = M('option_classify')->field('id,name')->where(array('level' => 1))->select();
        $this->assign('classify',$classify);                

        $this->assign('data',$data);
        $this->assign('totalCount',$count);
        $this->assign('nowStart',!I('get.p')?1:I('get.p'));
        $this->assign('nowEnd',ceil($count/$pagecount));
        $this->assign('tlist',$tlist);
        $this->assign('page',$page->show());

        $this->display();
    }

    
    public function ajax_get_brokers(){
        if(IS_AJAX){
            $userobj         = M('userinfo a');
            $relationshipobj = M('userinfo_relationship');
            
            $parent_id = I('get.parent_id',0,'intval');
            
            if($parent_id < 1) $this->AjaxReturn(array('msg'=>'父级id不存在','status'=>0));
            $ids_arr = $relationshipobj->field('user_id')->where(array('parent_user_id'=>$parent_id))->select();
            $ids='';
            
            if($ids_arr){
                foreach($ids_arr as $v){
                    if(!empty($ids)){
                        $ids .=','.$v['user_id'];
                    }else{
                        $ids = $v['user_id'];
                    }
                }
            }
            $where['a.uid']=array('IN',$ids);
            $res = $userobj->field('a.uid,a.username')->where($where)->order('uid DESC')->select();
            foreach ($res as $key => $value) {
                $res[$key]['username'] = $value['username'];
            }

            $data=array('msg'=>'成功','status'=>1,'data'=>$res);
            $this->AjaxReturn($data);
        }
        $this->error('您访问的页面不存在','index/index');
        
    }

       /**
     * @functionname: order_list_gold
     * @author: FrankHong
     * @date: 2016-12-05 17:14:16
     * @description: 现金或模拟订单导出excel
     * @note:
     */
    
    public function cash_daochu() 
    {
        $type    = trim(I('get.type'));
        if($type != 1)$type = 2;
        $name    = $type == 1 ? '现金订单' : '模拟订单'; 

        $order      = M('order');
        $user       = M('userinfo');
        $where      = "";

        $jinjiren      = trim(I('get.jinjiren'));
        $users         = trim(I('get.user'));
        $starttime     = urldecode(trim(I('get.start_time')));
        $endtime       = urldecode(trim(I('get.end_time')));
        $email         = trim(I('get.email'));
        $jostyle       = trim(I('get.jostyle'));
        $order_result  = trim(I('get.order_result'));
        $status        = trim(I('get.status'));
        $datetype      = trim(I('get.datetype'));
        $type          = trim(I('get.type'));

        $username   = trim(I('get.username'));
        $nickname   = trim(I('get.nickname'));
        $oid         = trim(I('get.oid'));

        $optin_class_max      = trim(I('get.optin_class_max')); 
        $optin_class_min      = trim(I('get.optin_class_min')); 
        $option_name          = trim(I('get.option_name'));


        //经纪人列表()
        $whereArr   = array(
            'parent_user_id'    => NOW_UID
        );
        $agentinfoRelationshipRs    = M("UserinfoRelationship")->where($whereArr)->select();

        $agentIdArr  = array();
        foreach($agentinfoRelationshipRs as $k => $v)
        {
            array_push($agentIdArr, $v['user_id']);
        }
        $agentIdStr  = implode(',', array_unique($agentIdArr));

        $agentinfoWhereArr  = 'uid in ('.$agentIdStr.')';

        $agentinfoRs    = M("userinfo")->where($agentinfoWhereArr)->select();
        $this->assign('agentinfoRs',$agentinfoRs);
         
        //用户
        $ship = M("UserinfoRelationship")->where('parent_user_id in('.$agentIdStr.')')->select();
        $shipArr = array();
        foreach ($ship as $key => $value) {
            array_push($shipArr,$value['user_id']);
        }

        $userIdStr      = implode(',', array_unique($shipArr));
        $where['uid']   = array('in',implode(',',array_unique($shipArr)));


        //联动经纪人筛选
        if($jinjiren){
            
            $userarr  = array();
            $userarr1 = array();
            $ship = M("UserinfoRelationship")->where(array('parent_user_id' => $jinjiren))->select();
            foreach ($ship as $key => $value) {
                array_push($userarr, $value['user_id']);
            }
            $id = implode(',',array_unique($userarr));

            $where['uid'] = array('in',$id);
        }

        //联动用户筛选
        if($users) {
            $id = $users; 
            $where['uid'] = array('in',$id);
        }

        //日期筛选
        if($starttime && $endtime){
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $where['buytime'] = array('between',array($start_time,$end_time));
        } else {
            $starttime  = strtotime(date('Y-m-d')." 06:00:00");
            $endtime    = strtotime(date('Y-m-d')." 05:00:00")+ 3600*24;
            $where['buytime']    = array('between',''.$starttime.','.$endtime.'');
        }

        //订单类型筛选
        if($jostyle){
            $jostyle = $jostyle == 1?0:1;
            $where['ostyle'] = $jostyle;
        }

        //订单结果筛选
        if($order_result){
            $where['order_result']  = $order_result;
        }

        //订单状态筛选
        if($status || $status == '0') {
            $where['ostaus']    = $status;
        }

        //昨天
        $this->assign("starttimeYesterday", date('Y-m-d 06:00:00',strtotime('-1 day')));
        $this->assign("endtimeYesterday", date('Y-m-d 05:00:00'));

        //本周
        $this->assign("starttimeWeek", date('Y-m-d 06:00:00',strtotime('-1 monday')));
        $this->assign("endtimeWeek", date('Y-m-d 05:00:00',strtotime('+1 day')));
        //上周
        $this->assign("starttimeLastWeek", date('Y-m-d 06:00:00',strtotime('-2 monday')));
        $this->assign("endtimeLastWeek", date('Y-m-d 05:00:00',strtotime('-1 monday')));
        //上月
        $this->assign("starttimeLastMonth", date('Y-m-01 06:00:00',strtotime('-1 month')));
        $this->assign("endtimeLastMonth", date('Y-m-d H:i:s',strtotime(date('Y-m-t 05:00:00',strtotime('-1 month')))+ 3600*24));

        if($datetype > 0){
            $sea['datetype'] = $datetype;
        }

        //手机号码筛选
        if($email) {
            $uid = $user->where("email='{$email}' and otype=4 and uid in({$userIdStr})")->getField('uid');
            $where['uid']   = $uid;
        }

        //用户名称
        if($username)
        {   
            $uid = $user->where("username='{$username}' and otype=4 and uid in({$userIdStr})")->getField('uid');
            $where['uid']   = $uid;
        }

        //用户昵称
        if($nickname)
        {
            $uid = $user->where("nickname='{$nickname}' and otype=4 and uid in({$userIdStr})")->getField('uid');
            $where['uid']       = $uid;
        }

        //编号
        if($oid)
        {
            $where['oid']   = $oid;
        }

        //分类大类
        if($optin_class_max)
        {
            $classObj = M('OptionClassify');
            $data = $classObj->field('group_concat(distinct id) id')->where(array('pid' => $optin_class_max))->find();

            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')->where('pid in('.$data['id'].')')->find();

            $where['pid'] = array('in',$option['id']);
        }

        //分类小类
        if($optin_class_min)
        {
            $classObj = M('OptionClassify');
            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')->where('pid='.$optin_class_min)->find();

            $where['pid'] = array('in',$option['id']);

            $mindata = $classObj->field('id,name')->where('id in('.$data['id'].')')->select();
        }

        //产品名称
        if ($option_name) 
        {   
            $where['pid'] = $option_name;

            $optionObj = M('option');

            $option = $optionObj->field('id,capital_name')->where('pid='.$optin_class_min)->select();
        }


        $where['type'] = $type;       //区分真实和模拟交易

        $tlist = $order->where($where)->order('oid desc')->select();

        
        $userIdArr = array();
        foreach ($tlist as $key => $value) {
             array_push($userIdArr,$value['uid']);
        }

        $userId = implode(',',array_unique($userIdArr));
        if($userId)
        {
            $user   = M('userinfo')->where('uid in('.$userId.')')->getField('uid,email,username,nickname',true);
        }

        
        foreach ($tlist as $key => $value) 
        {
            $tlist[$key]['email']    = $user[$value['uid']]['email'];
            $tlist[$key]['username'] = $user[$value['uid']]['username'];
            $tlist[$key]['nickname'] = $user[$value['uid']]['nickname'];

            if($value['ostaus'] == 1)
                $tlist[$key]['access']  = (($value['ploss']) - $value['fee']) - $value['overnight_fee'];
                
            else
                $tlist[$key]['access']  = -($value['Bond'] + $value['fee']) + $value['overnight_fee'];
        }

      
        $data[0] = array('编号id','用户名称','电子邮箱','用户昵称','订单号码','建仓时间','平仓时间','产品信息','数量(手)','  方向','止盈','止损','保证金','手续费','隔夜费','购买时长','买入价','卖出价','出入金','盈亏','平仓类型','订单结果','订单类型');
        foreach ($tlist as $key => $value) {

            if($value['ostaus'] == 1)
            {
                if($value['auto'] == 1)
                    $auto = '手动';
                else
                    $auto = '自动';
            }

            if($value['ostaus'] == 1)
            {
                if($value['order_result'] == 1){
                    $order_result = '平局';
                }
                else if($value['order_result'] == 2){
                    $order_result = '盈利';
                } else {
                    $order_result = '亏损';
                }
            }

            if($value['order_type'] == 1){
                $order_type = '自持';
            }
            else if($value['order_type'] == 2){
                $order_type = '跟随';
            } else {
                $order_type = '挂单';
            }


            $data[$key+1][] = $value['oid'];
            $data[$key+1][] = $value['username'];
            $data[$key+1][] = $value['email'];
            $data[$key+1][] = $value['nickname'];
            $data[$key+1][] = $value['orderno'];
            $data[$key+1][] = date('Y-m-d H:i:s',$value['buytime']);
            $data[$key+1][] = $value['ostaus'] == '0' ? '--' : date('Y-m-d H:i:s',$value['selltime']);
            $data[$key+1][] = $value['option_name'];

            if($value['order_scene'] == 1) {
                $data[$key+1][] = $value['onumber'];
            } else {
                $data[$key+1][] = '--';
            }

            $data[$key+1][] = $value['ostyle'] == 0 ? '买涨' : '买跌';

            if($value['order_scene'] == 1) {
                $data[$key+1][] = $value['endprofit'];
                $data[$key+1][] = $value['endloss'];
            } else {
                $data[$key+1][] = '--';
                $data[$key+1][] = '--';
            }

            $data[$key+1][] = $value['Bond'];
            $data[$key+1][] = $value['fee'];

            if($value['order_scene'] == 1) {
                $data[$key+1][] = $value['overnight_fee'];
                $data[$key+1][] = '--';
            } else {
                $data[$key+1][] = '--';
                $data[$key+1][] = $value['second'].'秒';
            }

            $data[$key+1][] = $value['buyprice'];
            $data[$key+1][] = $value['ostaus'] == '0' ? '--' : $value['sellprice'];
            $data[$key+1][] = $value['access'];
            $data[$key+1][] = $value['ostaus'] == '0' ? '--' : $value['ploss'];
            $data[$key+1][] = $auto;
            $data[$key+1][] = $order_result;
            $data[$key+1][] = $order_type;
        }

        $name=$name;
        $this->push($data,$name);
    }

    private function push($data,$name){
        import("Excel.class.php");
        $excel = new Excel();
        $excel->download($data,$name);
    }

    /**
     * get_username 获取用户名称
     * @param  integer $uid 用户编号
     */
    private function get_username($uid = 0) {
         
        $info = M("userinfo")->field('uid,username')->where(array('uid'=> $uid))->find();
        return $info ? $info : null;
    }


    /**
     * getOptionClassify 客户端请求获取产品分类
     * @author wang li
     * @return json  下级分类信息
     */
    public function getOptionClassify()
    {   
        $classObj = M('OptionClassify');

        $parent_id = trim(I('get.parent_id'));

        $data = $classObj->field('id,name')->where(array('pid' => $parent_id))->select();

        if($data)
            outjson(array('data' => $data,'status' => 1));
        else
            outjson(array('data' => $data,'status' => 0));
    }

    /**
     * getOption 客户端请求产品分类获取产品信息
     * @author wang li
     * @return json  产品名称
     */
    public function getOption()
    {
        $parent_id = trim(I('get.parent_id'));

        $optionObj = M('option');

        $data = $optionObj->field('id,capital_name')->where(array('pid' => $parent_id))->select();

        if($data)
            outjson(array('data' => $data,'status' => 1));
        else
            outjson(array('data' => $data,'status' => 0));
    }

}