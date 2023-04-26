<?php

namespace Admin\Controller;
class RechargeController extends BaseController {
	
	
	public function daochu_rechare(){
		$user= A('Admin/User');
		$user->checklogin();

        $yunying   = trim(I('get.yunying'));              //运营中心
        $jingjiren = trim(I('get.jingjiren'));            //经纪人	
        $user      = trim(I('get.user'));			      //用户
        $user_type = trim(I('get.user_type'));            //用户类型
        $email     = trim(I('get.email'));              //电子邮箱
        $status    = trim(I('get.status'));               //充值状态
		$starttime = urldecode(trim(I('get.starttime')));
		$endtime   = urldecode(trim(I('get.endtime')));

        if($yunying) {

        	$relation = M('userinfo_relationship')->where(array('parent_user_id' => $yunying))->select();
        	$relationArr = array();
        	$relationArr1 = array();
        	foreach ($relation as $key => $value) {
        		 array_push($relationArr,$value['user_id']);
        	}
        	$relationId = implode(',',array_unique($relationArr));
        	$users = M('userinfo_relationship')->where('parent_user_id in('.$relationId.')')->select();
            foreach ($users as $key => $value) {
            	 array_push($relationArr1,$value['user_id']);
            }
            $userId = implode(',',array_unique($relationArr1));
            $map['a.uid'] = array('in',$userId);
        }

        if($jingjiren) {
            $relationArr2 = array();
        	$jingjiren_user = M('userinfo_relationship')->where('parent_user_id in('.$jingjiren.')')->select();
            foreach ($jingjiren_user as $key => $value) {
            	 array_push($relationArr2,$value['user_id']);
            }
            $userId1 = implode(',',array_unique($relationArr2));
            $map['a.uid'] = array('in',$userId1);
        }
        
        if($user) {
            $map['a.uid'] = $user;
        }

      	if($user_type){
      	 	$map['c.otype']   = $user_type;
      	}

        if($email){
            $map['c.email'] = $email;
        }

      	if($status || $status == '0') {
	      	if($status == '0') {
               $map['a.status'] = 0;
	      	} else if($status == 1) {
	      	   $map['a.status'] = 1;
	      	} else {
	      	   $map['a.status'] = 2;
	      	}
      	}

      	if($starttime && $endtime) {
			     $start_time  = strtotime($starttime);
			     $end_time 	 = strtotime($endtime);
	      	$map['a.bptime']  = array('between',''.$start_time.','.$end_time.'');
      	} else {
	      	$starttime 	= strtotime(date('Y-m-d')." 06:00:00");
	      	$endtime 	= strtotime(date('Y-m-d')." 05:00:00")+ 3600*24;
	      	$map['a.bptime']  = array('between',''.$starttime.','.$endtime.'');
      	}

       
       $field = 'a.*,c.username,c.email,c.otype,d.balance,e.pay_name';
       $rechargelist = M("balance a")->
                    field($field)->
                    join('wp_userinfo as c on a.uid = c.uid')->
                    join('left join wp_accountinfo as d on a.uid = d.uid')->
                    join('left join dict_pay_type as e on a.pay_type = e.id')->
                    where($map)->
                    order('a.bpid desc')->
                    select();

		$data[0] = array('编号','订单号','用户名','电子邮箱','用户类型','创建时间','充值金额','状态','充值渠道');
		foreach($rechargelist as $k => $v){
			if($v['otype'] == 4)
			{
				$otype = '普通客户';
			} else if($v['otype'] == 5)
			{
				$otype = '运营中心';
			} else if($v['otype'] == 6)
			{
				$otype = '销售商';
			}

			$data[$k+1][] = $v['bpid'];
			$data[$k+1][] = $v['balanceno'];
			$data[$k+1][] = getUsername($v['uid']);
			$data[$k+1][] = $v['email'];
			$data[$k+1][] = $otype;
			$data[$k+1][] = date("Y-m-d H:i:s",$v['bptime']);
			$data[$k+1][] = number_format($v['bpprice'],2);
            if($v['status'] == 1) {
            	$data[$k+1][] = '充值成功';
            } else if($v['status'] == 2) {
            	$data[$k+1][] = '充值失败';
            } else if($v['status'] == 0) {
            	$data[$k+1][] = '未处理';
            } else {
            	$data[$k+1][] = '不存在';
            }

			$data[$k+1][] = $v['pay_name'];
		}
		$name='充值流水记录';  //生成的Excel文件文件名
		$res=$this->push($data,$name);
	}

    public function lists(){

		$user= A('Admin/User');
		$user->checklogin();

        $yunying   = trim(I('get.yunying'));              //运营中心
        $jingjiren = trim(I('get.jingjiren'));            //经纪人	
        $user      = trim(I('get.user'));			      //用户
        $user_type = trim(I('get.user_type'));            //用户类型
        $email     = trim(I('get.email'));                 //电子邮箱
        $status    = trim(I('get.status'));               //充值状态
		    $starttime = urldecode(trim(I('get.starttime')));
		    $endtime   = urldecode(trim(I('get.endtime')));

        if($yunying) {

        	$relation = M('userinfo_relationship')->where(array('parent_user_id' => $yunying))->select();
        	$relationArr = array();
        	$relationArr1 = array();
        	foreach ($relation as $key => $value) {
        		 array_push($relationArr,$value['user_id']);
        	}
        	$relationId = implode(',',array_unique($relationArr));
        	$users = M('userinfo_relationship')->where('parent_user_id in('.$relationId.')')->select();
            foreach ($users as $key => $value) {
            	 array_push($relationArr1,$value['user_id']);
            }
            $userId = implode(',',array_unique($relationArr1));
            $map['a.uid'] = array('in',$userId);
            $sea['yunying'] = $yunying;
            $this->assign('yunying',$yunying);
        }

        if($jingjiren) {
            $relationArr2 = array();
        	$jingjiren_user = M('userinfo_relationship')->where('parent_user_id in('.$jingjiren.')')->select();
            foreach ($jingjiren_user as $key => $value) {
            	 array_push($relationArr2,$value['user_id']);
            }
            $userId1 = implode(',',array_unique($relationArr2));
            $map['a.uid'] = array('in',$userId1);
            $sea['jingjiren'] = $jingjiren;
            $this->assign('jingjiren',$this->get_username($jingjiren));
        }
        
        if($user) {
            $map['a.uid'] = $user;
            $sea['user'] = $user;
            $this->assign('user',$this->get_username($user));
        }

	      if($user_type){
	      	 $map['c.otype']   = $user_type;
	      	 $sea['user_type'] = $user_type;
	      }

	      if($email){
	      	 $map['c.email'] = $email;
	      	 $sea['email']   = $email;
	      }

	      if($status || $status == '0') {
	      	if($status == '0') {
               $map['a.status'] = 0;
	      	} else if($status == 1) {
	      	   $map['a.status'] = 1;
	      	} else {
	      	   $map['a.status'] = 2;
	      	}
	      	$sea['status'] = $status;
	      }

	      if($starttime && $endtime) {
				$start_time  = strtotime($starttime);
				$end_time 	 = strtotime($endtime);
		      	$map['a.bptime']  = array('between',''.$start_time.','.$end_time.'');
		      	$sea['starttime'] = $starttime;
		      	$sea['endtime']   = $endtime;
	      } else {
		      	$starttime 	= strtotime(date('Y-m-d')." 06:00:00");
		      	$endtime 	= strtotime(date('Y-m-d')." 05:00:00")+ 3600*24;
		      	$map['a.bptime']  = array('between',''.$starttime.','.$endtime.'');
		      	$sea['starttime'] = date('Y-m-d H:i:s',$starttime);
		      	$sea['endtime']   = date('Y-m-d H:i:s',$endtime);
	      }


      	$count = M("balance a")->
                join('wp_userinfo as c on a.uid = c.uid')->
                join('left join wp_accountinfo as d on a.uid = d.uid')->
                where($map)->
                count();
	   //分页
	   $pagecount = 10;
	   $page = new \Think\Page($count , $pagecount);
	   $page->parameter = $sea; //此处的row是数组，为了传递查询条件
	   $page->setConfig('first','首页');
	   $page->setConfig('prev','&#8249;');
	   $page->setConfig('next','&#8250;');
	   $page->setConfig('last','尾页');
	   $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
	   $show = $page->show();
       
       $field = 'a.*,c.username,c.email,c.otype,d.balance,e.pay_name';
       $rechargelist = M("balance a")->
                    field($field)->
                    join('wp_userinfo as c on a.uid = c.uid')->
                    join('left join wp_accountinfo as d on a.uid = d.uid')->
                    join('left join dict_pay_type as e on a.pay_type = e.id')->
                    where($map)->
                    order('a.bpid desc')->
                    limit($page->firstRow.','.$page->listRows)->
                    select();
      	
       	$sum = M("balance a")->
                    field($field)->
                    join('left join wp_bankinfo as b on a.uid = b.uid')->
                    join('wp_userinfo as c on a.uid = c.uid')->
                    join('left join wp_accountinfo as d on a.uid = d.uid')->
                    join('left join dict_pay_type as e on a.pay_type = e.id')->
                    where($map)->
                    select();
      foreach ($sum as $key => $value) {
      	  if($value['status'] == 1) $amount['chengong'] += $value['bpprice'];
      	  $amount['amount'] += $value['bpprice'];
      }

      $this->assign('rechargelist',$rechargelist);
      $this->assign('page',$show);
      $this->assign('sea',$sea);
      $this->assign('amount',$amount);   //总充值金额
      $this->assign('info',M('userinfo')->where(array('otype' => 5))->select());
      $this->display();
    }

    /**
     * 导入Excel类
     */
	public function push($data,$name){
		import("Excel.class.php");
		$excel = new Excel();
		$excel->download($data,$name);
	}

    private function get_username($uid = 0) {
        $info = M("userinfo")->field('uid,username')->where(array('uid'
                                  => $uid))->find();
        return $info ? $info : null;
    }

}