<?php
// +----------------------------------------------------------------------
// | 运营中心控制器
// +----------------------------------------------------------------------
// | Author wang <li> 
// +----------------------------------------------------------------------
namespace Admin\Controller;

class PositionController extends CommonController {

    /**
     * 持仓中的订单
     * @author wang <li>
     */
    public function tlist()
    {
    	$orderObj = M('order');
        $userObj  = M('userinfo'); 
       
        /*条件筛选*/
        $email      = trim(I('get.email'));
        $starttime  = urldecode(trim(I('get.starttime')));
        $endtime    = urldecode(trim(I('get.endtime')));
        $otype      = trim(I('get.otype'));
        $jingjiren  = trim(I('get.jingjiren'));
        $user       = trim(I('get.user'));
        $option     = trim(I('get.option'));
        $orderno    = trim(I('get.orderno'));


        if($starttime && $endtime) {
            $start_time = strtotime($starttime." 00:00:00");
            $end_time   = strtotime($endtime." 23:59:59");
            $map['buytime']     = array('between',array($start_time,$end_time));
            $sea['starttime']   = $starttime;
            $sea['endtime']     = $endtime;
        }

        if($option) {
            $map['option_name'] = $option;
            $sea['option'] 		= $option;
        }

        //运营中心筛选
        if($otype){
            
            $userarr  = array();
            $userarr1 = array(); 
            $ship = M("UserinfoRelationship")->where(array('parent_user_id' => $otype))->select();
            foreach ($ship as $key => $value) {
                array_push($userarr, $value['user_id']);
            }
            $user_id = implode(',',array_unique($userarr));
  
            $users = M("UserinfoRelationship")->where('parent_user_id  in('.$user_id.')')->select();

            foreach ($users as $key => $val) {
                 
                array_push($userarr1,$val['user_id']);
            }
            $id = implode(',',array_unique($userarr1));
     
            $map['uid'] = array('in',$id);
            $username = M('userinfo')->where(array('uid'=> $otype))->find();
            $sea['otype'] = $otype;
            $this->assign('user_id',$username['uid']);
        }

        //经纪人筛选
        if($jingjiren){
            
            $userarr  = array();
            $userarr1 = array(); 
            $ship = M("UserinfoRelationship")->where(array('parent_user_id' => $jingjiren))->select();
            foreach ($ship as $key => $value) {
                
                array_push($userarr, $value['user_id']);
            }
            $userid = implode(',',array_unique($userarr));

            $map['uid'] = array('in',$userid);
            $sea['jingjiren'] = $jingjiren;
            $this->assign('jingjiren',$this->get_username($jingjiren));
        }


        if($user){
            $uid = $user;
            $map['uid'] = array('in',$uid);
            $sea['user'] = $user;
            $this->assign('user',$this->get_username($user));
        }

        if ($email) {

            $uid             = M('userinfo')->where([
                'email'  => $email,
                'otype' => 4,
            ])
                                    ->getField('uid');

            $map['uid']     = $uid;
            $sea['email']   = $email;
        }

        //订单号码查找
        if($orderno) {
            $map['orderno'] = $orderno;
            $sea['orderno'] = $orderno;
        }

        $type = trim(I('get.type'));
        if($type)
        {
	        $map['type']    = $type;
        }

        $map['ostaus']  = 0;

    	$counts = $orderObj->where($map)->count();
	    $pagecount = 10;
	    $page = new \Think\Page($counts , $pagecount);
	    $page->parameter = $sea; //此处的row是数组，为了传递查询条件
	    $page->setConfig('first','首页');
	    $page->setConfig('prev','&#8249;');
	    $page->setConfig('next','&#8250;');
	    $page->setConfig('last','尾页');
	    $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
	    $show = $page->show();

    	$orders = $orderObj->where($map)->limit($page->firstRow.','.$page->listRows)->order('oid desc')->select();

        $uidArr = array();
        foreach ($orders as $key => $value) {
            array_push($uidArr,$value['uid']);
        }

        if($uidArr)
        {
            $uid = implode(',',array_unique($uidArr));
            $userinfo = $userObj->where('uid in ('.$uid.')')->getField('uid,email,username,nickname',true);
        }


        foreach ($orders as $key => $value) 
        {
            $orders[$key]['email']      = $userinfo[$value['uid']]['email'];
            $orders[$key]['username']   = $userinfo[$value['uid']]['username'];
            $orders[$key]['nickname']   = $userinfo[$value['uid']]['nickname'];
        }



        //全部持仓订单
        $tlistAll = $orderObj->where($map)->select();
        $this->assign('tlistAll',$tlistAll);


    	$this->assign('tlist',$orders);
        $this->assign('info', M('userinfo')->where('otype=5')->select());
        $this->assign('options',M('option')->select());
        $this->assign('sea',$sea);
        $this->assign('page',$show);

        if($type == 1)
        	$this->display();
        else
        	$this->display('moni');
    }




    public function getdata()
    {
    	$oid   = trim(I('post.oid'));
        $type  = trim(I('post.type'));

    	$order = M('order');

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
            $orders['ploss_sum'] 			+= $value['ploss'];
            $orders['fee_sum']   			+= $value['fee'];
            $orders['overnight_fee_sum']   	+= $value['overnight_fee'];
            $orders['count']     			+= count($value['oid']);
    	}

        if($orders[0]['oid'])
        {
           $orders['code'] = 200;
        } else {
           $orders['code'] = 300;
        }
    	$this->ajaxReturn($orders,'JSON');
    }



    private function get_username($uid = 0) {
        $info = M("userinfo")->field('uid,username')->where(array('uid'
                                  => $uid))->find();
        return $info ? $info : null;
    }
}