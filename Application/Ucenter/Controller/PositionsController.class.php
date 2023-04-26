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


class PositionsController extends CommonController
{   

     public function _initialize(){
        parent::_initialize();
        $user    = M("userinfo")->field("opentlist")->where(array('uid'=>NOW_UID))->find();
        if(empty($user['opentlist'])){
            $this->error("您没有权限执行此操作");
        }
    }

    public function tlist()
    {
         $order = M('order a');
          
        $starttime = urldecode(trim(I('get.start_time')));
        $endtime   = urldecode(trim(I('get.end_time')));

        $email          = trim(I('get.email'));
        $username       = trim(I('get.username'));
        $nickname       = trim(I('get.nickname'));
        $oid            = trim(I('get.oid'));
    
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

        $where['a.uid'] = array('in',implode(',',array_unique($agentIdArr)));

        //日期筛选
        if($starttime && $endtime){
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $where['a.buytime'] = array('between',array($start_time,$end_time));
            $sea['start_time'] = $starttime;
            $sea['end_time'] = $endtime;
            $this->assign('time',$sea);
        }

        //电子邮箱筛选
        if($email) {
            $where['b.email'] = array('like','%'.$email.'%');
            $sea['email'] = $email;
            $this->assign('email',$email);
        }
        
        if($username) {
            $where['b.username'] = array('like','%'.$username.'%');
            $sea['username'] = $username;
            $this->assign('username',$username);
        }

        if($nickname) {
            $where['b.nickname'] = array('like','%'.$nickname.'%');
            $sea['nickname'] = $utel;
            $this->assign('nickname',$nickname);
        }

        if($oid) {
            $where['a.oid'] = $oid;
            $sea['oid'] = $oid;
            $this->assign('oid',$oid);
        }


        //分类大类
        if($optin_class_max)
        {
            $classObj = M('OptionClassify');
            $data = $classObj->field('group_concat(distinct id) id')->where(array('pid' => $optin_class_max))->find();

            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')->where('pid in('.$data['id'].')')->find();

            $where['a.pid'] = array('in',$option['id']);

            $sea['optin_class_max'] = $optin_class_max;
            $this->assign('optin_class_max',$optin_class_max);
        }

        //分类小类
        if($optin_class_min)
        {
            $classObj = M('OptionClassify');
            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')->where('pid='.$optin_class_min)->find();

            $where['a.pid'] = array('in',$option['id']);

            $mindata = $classObj->field('id,name')->where('id in('.$data['id'].')')->select();

            $sea['optin_class_min'] = $optin_class_min;
            $this->assign('mindata',$mindata);
            $this->assign('optin_class_min',$optin_class_min);
        }

        //产品名称
        if ($option_name) 
        {   
            $where['a.pid'] = $option_name;

            $optionObj = M('option');

            $option = $optionObj->field('id,capital_name')->where('pid='.$optin_class_min)->select();

            $sea['option_name'] = $option_name;
            $this->assign('option',$option);
            $this->assign('option_name',$option_name);
        }


        $where['a.type']    = 1;       //区分真实和模拟交易
        $where['a.ostaus']  = 0;

        $counts = $order->
                        join('left join wp_userinfo as b on a.uid = b.uid')->
                        where($where)->
                        count();

        $pagecount = 10;
        $page = new \Think\Page($counts , $pagecount);
        $page->parameter = $sea;
        $page->setConfig('first','首页');
        $page->setConfig('prev','<<');
        $page->setConfig('next','>>');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $start = $page->firstRow;
        $end   = $page->listRows;
        $show = $page->show();
        
        $field = 'a.*,b.email,b.username,b.nickname';
        $tlist = $order->field($field)->
                            join('left join wp_userinfo as b on a.uid = b.uid')->
                            where($where)->
                            order('a.oid desc')->
                            limit($page->firstRow.','.$page->listRows)->
                            select();
        foreach ($tlist as $key => $value) {
            if($value['ostyle'] == 0)
                $tlist[$key]['ostyleMsg']   = '买入';
            else
                $tlist[$key]['ostyleMsg']   = '卖出';
        }


        if($tlist)
        {
            $this->assign('statuss',1);
        }


        $tlistAll = $order->field('a.oid')->
                            join('left join wp_userinfo as b on a.uid = b.uid')->
                            order('a.oid desc')->
                            where($where)->
                            select();


        $total['totalCount'] = $counts;
        $total['nowStart'] = trim(I('get.p')) ? trim(I('get.p')) : 1;
        $total['nowEnd'] = ceil($counts / $pagecount);

        //产品大类
        $classify   = M('option_classify')->field('id,name')->where(array('level' => 1))->select();
        $this->assign('classify',$classify);

        $this->assign('tlist',$tlist);
        $this->assign('tlistAll',$tlistAll);
        $this->assign("sea",$sea);
        $this->assign('total',$total);
        $this->assign('page',$show);
        $this->display();
    }


    /**
     * 模拟持仓监控
     * @author wang li
     */
    public function moni()
    {
         $order = M('order a');
          
        $starttime = urldecode(trim(I('get.start_time')));
        $endtime   = urldecode(trim(I('get.end_time')));

        $email          = trim(I('get.email'));
        $username       = trim(I('get.username'));
        $nickname       = trim(I('get.nickname'));
        $oid            = trim(I('get.oid'));
    
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


        $where['a.uid'] = array('in',implode(',',array_unique($agentIdArr)));


        //日期筛选
        if($starttime && $endtime){
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $where['a.buytime'] = array('between',array($start_time,$end_time));
            $sea['start_time'] = $starttime;
            $sea['end_time'] = $endtime;
            $this->assign('time',$sea);
        }    


        //电子邮箱筛选
        if($email) {
            $where['b.email'] = array('like','%'.$email.'%');
            $sea['email'] = $email;
            $this->assign('email',$email);
        }
        
        if($username) {
            $where['b.username'] = array('like','%'.$username.'%');
            $sea['username'] = $username;
            $this->assign('username',$username);
        }

        if($nickname) {
            $where['b.nickname'] = array('like','%'.$nickname.'%');
            $sea['nickname'] = $utel;
            $this->assign('nickname',$nickname);
        }

        if($oid) {
            $where['a.oid'] = $oid;
            $sea['oid'] = $oid;
            $this->assign('oid',$oid);
        }


        //分类大类
        if($optin_class_max)
        {
            $classObj = M('OptionClassify');
            $data = $classObj->field('group_concat(distinct id) id')->where(array('pid' => $optin_class_max))->find();

            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')->where('pid in('.$data['id'].')')->find();

            $where['a.pid'] = array('in',$option['id']);

            $sea['optin_class_max'] = $optin_class_max;
            $this->assign('optin_class_max',$optin_class_max);
        }

        //分类小类
        if($optin_class_min)
        {
            $classObj = M('OptionClassify');
            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')->where('pid='.$optin_class_min)->find();

            $where['a.pid'] = array('in',$option['id']);

            $mindata = $classObj->field('id,name')->where('id in('.$data['id'].')')->select();

            $sea['optin_class_min'] = $optin_class_min;
            $this->assign('mindata',$mindata);
            $this->assign('optin_class_min',$optin_class_min);
        }

        //产品名称
        if ($option_name) 
        {   
            $where['a.pid'] = $option_name;

            $optionObj = M('option');

            $option = $optionObj->field('id,capital_name')->where('pid='.$optin_class_min)->select();

            $sea['option_name'] = $option_name;
            $this->assign('option',$option);
            $this->assign('option_name',$option_name);
        }


        $where['a.type']    = 2;       //区分真实和模拟交易
        $where['a.ostaus']  = 0;

        $counts = $order->
                        join('left join wp_userinfo as b on a.uid = b.uid')->
                        where($where)->
                        count();

        $pagecount = 10;
        $page = new \Think\Page($counts , $pagecount);
        $page->parameter = $sea;
        $page->setConfig('first','首页');
        $page->setConfig('prev','<<');
        $page->setConfig('next','>>');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $start = $page->firstRow;
        $end   = $page->listRows;
        $show = $page->show();
        
        $field = 'a.*,b.email,b.username,b.nickname';
        $tlist = $order->field($field)->
                            join('left join wp_userinfo as b on a.uid = b.uid')->
                            where($where)->
                            order('a.oid desc')->
                            limit($page->firstRow.','.$page->listRows)->
                            select();
        foreach ($tlist as $key => $value) {
            if($value['ostyle'] == 0)
                $tlist[$key]['ostyleMsg']   = '买入';
            else
                $tlist[$key]['ostyleMsg']   = '卖出';
        }


        if($tlist)
        {
            $this->assign('statuss',1);
        }


        $tlistAll = $order->field('a.oid')->
                            join('left join wp_userinfo as b on a.uid = b.uid')->
                            order('a.oid desc')->
                            where($where)->
                            select();


        $total['totalCount'] = $counts;
        $total['nowStart'] = trim(I('get.p')) ? trim(I('get.p')) : 1;
        $total['nowEnd'] = ceil($counts / $pagecount);

        //产品大类
        $classify   = M('option_classify')->field('id,name')->where(array('level' => 1))->select();
        $this->assign('classify',$classify);

        $this->assign('tlist',$tlist);
        $this->assign('tlistAll',$tlistAll);
        $this->assign("sea",$sea);
        $this->assign('total',$total);
        $this->assign('page',$show);
        $this->assign('options',M('option')->field('id,capital_name')->select());
        $this->display();
    }


    public function getdata()
    {
        $oid    = trim(I('post.oid'));
        $type   = trim(I('post.type'));

        $order  = M('order');

        $orders = $order->where('oid in('.$oid.') and ostaus = 0')->select();

        foreach ($orders as $key => $value) {
           
            /*盈亏百分比*/
            $profit_count = $order->where('type = '.$type.' and uid='.$value['uid'].' and ploss > 0')->count();
            $ploss_count  = $order->where('type = '.$type.' and uid='.$value['uid'].'')->count();
            $orders[$key]['percentage'] = round(($profit_count / $ploss_count) * 100,2);
            /*盈亏百分比*/

            $jploss = $order->where('TO_DAYS(FROM_UNIXTIME(buytime,"%Y-%m-%d")) = TO_DAYS(CURDATE()) and type = '.$type.' and uid='.$value['uid'].' ')->sum('ploss');
            $orders[$key]['day_ploss'] = $jploss;

            /*总统计*/
            $orders['ploss_sum']            += $value['ploss'];
            $orders['fee_sum']              += $value['fee'];
            $orders['overnight_fee_sum']    += $value['overnight_fee'];
            $orders['count']                += count($value['oid']);
        }

        if($orders[0]['oid'])
        {
           $orders['code'] = 200;
        } else {
           $orders['code'] = 300;
        }
        $this->ajaxReturn($orders,'JSON');
    }

}