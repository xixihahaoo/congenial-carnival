<?php
//推广员列表
namespace Admin\Controller;
class ExtensionController extends BaseController {
	
	public function index()
	{
		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();

		$otype 		= trim(I('get.otype'));
		$jingjiren 	= trim(I('get.jingjiren'));
		$userss 	= trim(I('get.user'));

		$username 	= trim(I('get.username'));	//用户名称
        $email		= trim(I('get.email'));		//手机号码
		$superior	= trim(I('get.superior'));	//上级名称

        $starttime = urldecode(trim(I('get.starttime')));
        $endtime   = urldecode(trim(I('get.endtime')));

		$userobj 	= M('userinfo a');
		$prefix 	= C('DB_PREFIX');


        if($otype) {
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

        	$map['a.uid'] = array('in',$id);
        	$sea['otype'] = $otype;
        	$this->assign('user_id',$otype);
        }

        if($jingjiren) {
        	$userarr  = array();
            $userarr1 = array(); 
        	$ship = M("UserinfoRelationship")->where(array('parent_user_id' => $jingjiren))->select();
            foreach ($ship as $key => $value) {
            	
            	array_push($userarr, $value['user_id']);
            }
            $userid = implode(',',array_unique($userarr));

        	$map['a.uid'] = array('in',$userid);
        	$sea['jingjiren'] = $jingjiren;
        	$this->assign('jingjiren',$this->get_username($jingjiren));
        }

        if($userss) 
        {    
            $uid = $userss; 
        	$map['a.uid'] = array('in',$uid);
        	$sea['user'] = $userss;
        	$this->assign('use',$this->get_username($userss));
        }

        if($email)
        {
			$map['a.email'] = $email;
			$sea['email']   = $email;
			$this->assign('email', $email);
        }

        if($username)
        {
			$map['_complex']['a.username']	= array('like', '%' . $username . '%');
			$map['_complex']['c.real_name'] = array('like','%'.$username.'%');
			$map['_complex']['_logic']		= 'OR';
			$sea['username']   				= $username;
			$this->assign('username',$username);
        }

		if ($superior) {
			$where['_complex']['a.username'] 	= array('like', '%' . $superior . '%');
			$where['_complex']['b.real_name'] 	= array('like','%'.$superior.'%');
			$where['_complex']['_logic'] 		= 'OR';
		
			$superiorData = $userobj->
				join('left join '.$prefix.'personal_user_data as b on a.uid = b.uid')->
				field('group_concat(distinct a.uid) as uid')->
				where($where)->
				find();

			$map['a.rid'] = array('in',$superiorData['uid']);
            $sea['superior'] = $superior;
			$this->assign('superior', $superior);
		}


        if($starttime && $endtime)
        {
        	$start_time = strtotime($starttime);
        	$end_time   = strtotime($endtime);
        	$map['a.utime'] = array('between',array($start_time,$end_time));
        	$sea['starttime'] = $starttime;
        	$sea['endtime']   = $endtime;
        }


		$map['a.code'] 	= array('neq', '');
		$map['a.otype'] = 4;

		$count = $userobj->where($map)->count();   //总数量

		$pagecount = 10;   //每页显示的数量
		$page = new \Think\Page($count, $pagecount);
		$page->parameter = $sea; //此处的row是数组，为了传递查询条件
		$page->setConfig('first', '首页');
		$page->setConfig('prev', '&#8249;');
		$page->setConfig('next', '&#8250;');
		$page->setConfig('last', '尾页');
		$page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
		$show = $page->show();
		
		$field = 'a.uid,c.real_name,a.username,a.email,a.extension_level,a.nickname,b.money,a.rid,a.code,a.utime,d.name';
		
		$user = $userobj->
			join('left join '.$prefix.'extension as b  on a.uid = b.user_id')->
			join('left join '.$prefix.'personal_user_data as c on a.uid = c.uid')->
			join('left join '.$prefix.'userinfo_rate d on a.extension_level=d.id')->
			field($field)->
			where($map)->
			limit($page->firstRow, $page->listRows)->
			order('a.utime desc')->
			select();


		$this->assign('level',M('userinfo_rate')->select());	//星级表


		$this->assign('user', $user);
		$this->assign('page', $show);
		$this->assign('account', $userobj->join('left join '.$prefix.'extension as b  on a.uid = b.user_id')->where($map)->sum('b.money')); //总佣金额
		$this->assign('info',M("userinfo")->where('otype=5')->select());
		$this->assign('sea',$sea);
		$this->display();
	}
	

	/**
	 * [extension_daochu 推广员导出]
	 * @author wang li
	 */
	public function extension_daochu()
	{
				//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();

		$otype 		= trim(I('get.otype'));
		$jingjiren 	= trim(I('get.jingjiren'));
		$userss 	= trim(I('get.user'));

		$username 	= trim(I('get.username'));	//用户名称
        $email		= trim(I('get.email'));		//手机号码
		$superior	= trim(I('get.superior'));	//上级名称

        $starttime = urldecode(trim(I('get.starttime')));
        $endtime   = urldecode(trim(I('get.endtime')));

		$userobj 	= M('userinfo a');
		$prefix 	= C('DB_PREFIX');


        if($otype) {
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

        	$map['a.uid'] = array('in',$id);
        }

        if($jingjiren) {
        	$userarr  = array();
            $userarr1 = array(); 
        	$ship = M("UserinfoRelationship")->where(array('parent_user_id' => $jingjiren))->select();
            foreach ($ship as $key => $value) {
            	
            	array_push($userarr, $value['user_id']);
            }
            $userid = implode(',',array_unique($userarr));

        	$map['a.uid'] = array('in',$userid);
        }

        if($userss) 
        {    
            $uid = $userss; 
        	$map['a.uid'] = array('in',$uid);
        }

        if($email)
        {
			$map['a.email'] 	= $email;
        }

        if($username)
        {
			$map['_complex']['a.username']	= array('like', '%' . $username . '%');
			$map['_complex']['c.real_name'] = array('like','%'.$username.'%');
			$map['_complex']['_logic']		= 'OR';
        }

		if ($superior) {
			$where['_complex']['a.username'] 	= array('like', '%' . $superior . '%');
			$where['_complex']['b.real_name'] 	= array('like','%'.$superior.'%');
			$where['_complex']['_logic'] 		= 'OR';
		
			$superiorData = $userobj->
				join('left join '.$prefix.'personal_user_data as b on a.uid = b.uid')->
				field('group_concat(distinct a.uid) as uid')->
				where($where)->
				find();
			$map['a.rid'] = array('in',$superiorData['uid']);
		}


        if($starttime && $endtime)
        {
        	$start_time = strtotime($starttime);
        	$end_time   = strtotime($endtime);
        	$map['a.utime'] = array('between',array($start_time,$end_time));
        }


		$map['a.code'] 	= array('neq', '');
		$map['a.otype'] = 4;
		
		$field = 'a.uid,c.real_name,a.username,a.email,a.nickname,b.money,a.rid,a.code,a.utime,d.name';
		
		$user = $userobj->
			join('left join '.$prefix.'extension as b  on a.uid = b.user_id')->
			join('left join '.$prefix.'personal_user_data as c on a.uid = c.uid')->
			join('left join '.$prefix.'userinfo_rate d on a.extension_level=d.id')->
			field($field)->
			where($map)->
			order('a.utime desc')->
			select();

   	 	$data[0] = array('编号','用户名称','用户昵称','电子邮箱','上级','当前佣金','推广码','推广星级','注册日期');
		foreach($user as $k => $v){

			$data[$k+1][] = $v['uid'];
			$data[$k+1][] = $v['username'];
            $data[$k+1][] = $v['nickname'];
			$data[$k+1][] = $v['email'];
			$data[$k+1][] = change($v['rid']);
			$data[$k+1][] = empty($v['money']) ? '0.00' : $v['money'];
			$data[$k+1][] = $v['code'];
			$data[$k+1][] = $v['name'];
			$data[$k+1][] = date('Y-m-d H:i:s',$v['utime']);
		}
		$name='代理商列表';      //生成的Excel文件文件名
		$res=$this->push($data,$name);
	}



	//设置推广员星级
	public function setLevel()
	{
		$uid=islogin();
		if(!$uid)
		{
		    $this->ajaxReturn('login');
		}

		$isverified = trim(I('post.isverified'));
		$userid 	= trim(I('post.userid'));

		$userObj = M('userinfo');

        $user = $userObj->where(array('uid' => $userid))->find();
        if(!$user){
            $this->ajaxReturn("null");
        }

        $isver = $userObj->where('uid='.$userid)->setField('extension_level',$isverified);

		if($isver){
			$this->ajaxReturn("success");	
		}else{
			$this->ajaxReturn("null");
		}

	}



  	/**
  	* 推广员下级流水
  	* @author wang <li>
  	*/
   public function subordinate(){

        $user_id 	= trim(I('get.user_id'));
        $status  	= trim(I('get.status'));
        $starttime 	= urldecode(trim(I('get.starttime')));
        $endtime 	= urldecode(trim(I('get.endtime')));

        $sea['user_id'] = $user_id;

        if($status)
        {
        	$map['a.status'] 	= $status;
        	$sea['status']		= $status;
        }


       	if($starttime  && $endtime)
        {
        	$start_time = strtotime($starttime);
        	$end_time   = strtotime($endtime);
            $map['a.create_time'] = array('between',array($start_time,$end_time));
            $sea['starttime'] = $starttime;
            $sea['endtime'] = $endtime;
        }


		$receiveObj 		= M('fee_receive a');
		$prefix 			= C('DB_PREFIX');

		$map['a.user_id']	= $user_id;

		$count = $receiveObj->where($map)->count();   //总数量

		$pagecount = 10;   		//每页显示的数量
		$page = new \Think\Page($count, $pagecount);
		$page->parameter = $sea; //此处的row是数组，为了传递查询条件
		$page->setConfig('first', '首页');
		$page->setConfig('prev', '&#8249;');
		$page->setConfig('next', '&#8250;');
		$page->setConfig('last', '尾页');
		$page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
		$show = $page->show();

		$receive = $receiveObj->
					field('a.*,b.option_name,b.onumber')->
					join('left join '.$prefix.'order b on a.order_id = b.oid')->
					where($map)->
					limit($page->firstRow, $page->listRows)->
					order('a.id desc')->
					select();

		foreach ($receive as $key => $value) {
			$receive[$key]['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
		}


		$data = $receiveObj->field('sum(profit) profit,sum(fee) fee')->where($map)->find();


		$this->assign('sea',$sea);
		$this->assign('data',$data);
		$this->assign('page',$show);
        $this->assign('user',$receive);
        $this->assign('user_id',$user_id);
        $this->display();
   }


 	/**
   * 下级推广员
   * @author wang <li>
   */
   public function lowerlevel()
   {

        $user_id 	= trim(I('get.user_id'));

        $sea['user_id'] = $user_id;

        $email 		= trim(I('get.email'));
        $starttime 	= urldecode(trim(I('get.starttime')));
        $endtime 	= urldecode(trim(I('get.endtime')));


    	if($email)
        {
        	$map['a.email'] = $email;
        	$sea['email']	= $email;
        }


       	if($starttime  && $endtime)
        {
        	$start_time = strtotime($starttime);
        	$end_time   = strtotime($endtime);
            $map['a.utime'] = array('between',array($start_time,$end_time));
            $sea['starttime'] = $starttime;
            $sea['endtime'] = $endtime;
        }


		$userObj 		= M('userinfo a');
		$prefix 		= C('DB_PREFIX');

		$map['a.rid']	= $user_id;

		$count = $userObj->where($map)->count();   //总数量

		$pagecount = 10;   //每页显示的数量
		$page = new \Think\Page($count, $pagecount);
		$page->parameter = $sea; //此处的row是数组，为了传递查询条件
		$page->setConfig('first', '首页');
		$page->setConfig('prev', '&#8249;');
		$page->setConfig('next', '&#8250;');
		$page->setConfig('last', '尾页');
		$page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
		$show = $page->show();

		$receive = $userObj->
					field('a.*,c.balance')->
					join('left join '.$prefix.'accountinfo c on a.uid = c.uid')->
					where($map)->
					limit($page->firstRow, $page->listRows)->
					order('a.uid desc')->
					select();

		foreach ($receive as $key => $value) {
			$receive[$key]['utime'] = date('Y-m-d H:i:s',$value['utime']);
			$receive[$key]['lastlog'] = !empty($value['lastlog']) ? date('Y-m-d H:i:s',$value['lastlog']) : '未登录过';

			$receive[$key]['last_login_ip'] = !empty($value['last_login_ip']) ? $value['last_login_ip'] : '未登录过';
		}

		unset($map['b.type']);
		$count = $userObj->where($map)->count();

		if($receive[0]['uid'])    $this->assign('user',$receive);


		$this->assign('sea',$sea);
		$this->assign('count',$count);
		$this->assign('page',$show);
        $this->assign('user_id',$user_id);
        $this->display();
   	}


 	/**
	  * 佣金转入记录
	  * @author wang <li>
	*/
   public function extension(){

		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();


	    $email      = trim(I('get.email'));                  //手机号码
	    $starttime  = urldecode(trim(I('get.starttime')));   //开始时间
	    $endtime    = urldecode(trim(I('get.endtime')));     //结束时间
        $yunying    = trim(I('get.yunying'));        	    //运营中心
        $jingjiren  = trim(I('get.jingjiren'));             //经纪人
        $user       = trim(I('get.user'));			        //用户


	    if($email) {
	        $map['b.email'] = $email;
	        $sea['email'] 	= $email;
	    }
	        
	    if($starttime && $endtime) {
	    	$start_time = strtotime($starttime);
	    	$end_time   = strtotime($endtime);
            $map['a.create_time'] = array('between',''.$start_time.','.$end_time.'');
            $sea['starttime']     = $starttime;
            $sea['endtime']       = $endtime;
	    }

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
            $map['a.user_id'] = array('in',$userId);
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
            $map['a.user_id'] = array('in',$userId1);
            $sea['jingjiren'] = $jingjiren;
            $this->assign('jingjiren',$this->get_username($jingjiren));
        }
        
        if($user) {
            $map['a.user_id'] = $user;
            $sea['user'] = $user;
            $this->assign('user',$this->get_username($user));
        }

        $map['a.type'] = 1;

	    $count = M('UserJournal a')->
	                join('left join wp_userinfo as b on a.user_id = b.uid')->
                    where($map)->
                    count();

		$pagecount = 10;   //每页显示的数量
		$page = new \Think\Page($count , $pagecount);
		$page->parameter = $sea; //此处的row是数组，为了传递查询条件
		$page->setConfig('first','首页');
		$page->setConfig('prev','&#8249;');
		$page->setConfig('next','&#8250;');
		$page->setConfig('last','尾页');
		$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
		$show = $page->show();
        
        $field = 'a.*,b.username,b.email,b.nickname,b.rid';
        $commission = M('UserJournal a')->
                      field($field)->
                      join(' left join wp_userinfo as b on a.user_id = b.uid')->
                      where($map)->
                      limit($page->firstRow,$page->listRows)->
                      order('a.id desc')->
                      select();

	    $sum = M('UserJournal a')->
	                join('left join wp_userinfo as b on a.user_id = b.uid')->
                    where($map)->
                    sum('account');

	    $this->assign('sum',$sum);                                       //总提金额
	    $this->assign('commission',$commission);
	    $this->assign('page',$show);
	    $this->assign('sea',$sea);
	    $this->assign('info',M("userinfo")->where('otype=5')->select()); //运营中心
	    $this->display();
   	}


   	/**
   	 * [daochu_extension 佣金记录导出]
   	 * @author wang li
   	 */
  	public function daochu_extension()
   	{    
		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();

        $email      = trim(I('get.email'));                  //手机号码
	    $starttime  = urldecode(trim(I('get.starttime')));           //开始时间
	    $endtime    = urldecode(trim(I('get.endtime')));            //结束时间
        $yunying    = trim(I('get.yunying'));        	//运营中心
        $jingjiren  = trim(I('get.jingjiren'));         //经纪人
        $user       = trim(I('get.user'));			  //用户


	    if($email) {
	        $map['b.email'] 	= $email;
	    }
	        
	    if($starttime && $endtime) {
	    	$start_time = strtotime($starttime);
	    	$end_time   = strtotime($endtime);
            $map['a.create_time'] = array('between',''.$start_time.','.$end_time.'');
	    }

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
            $map['a.user_id'] = array('in',$userId);
        }

        if($jingjiren) {
            $relationArr2 = array();
        	$jingjiren_user = M('userinfo_relationship')->where('parent_user_id in('.$jingjiren.')')->select();
            foreach ($jingjiren_user as $key => $value) {
            	 array_push($relationArr2,$value['user_id']);
            }
            $userId1 = implode(',',array_unique($relationArr2));
            $map['a.user_id'] = array('in',$userId1);
        }
        
        if($user) {
            $map['a.user_id'] = $user;
        }

        $map['a.type'] = 1;
        
        $field = 'a.*,b.username,b.email,b.nickname,b.rid';
        $commission = M('UserJournal a')->
                    field($field)->
                    join(' left join wp_userinfo as b on a.user_id = b.uid')->
                    where($map)->
                    order('a.id desc')->
                    select();

   	 	$data[0] = array('编号','用户名称','用户昵称','电子邮箱','上级','转入时间','金额');
		foreach($commission as $k => $v){

			$data[$k+1][] = $v['id'];
			$data[$k+1][] = $v['username'];
			$data[$k+1][] = $v['nickname'];
			$data[$k+1][] = $v['email'];
			$data[$k+1][] = change($v['rid']);
			$data[$k+1][] = date('Y-m-d H:i:s',$v['create_time']);
			$data[$k+1][] = empty($v['account']) ? '0.00' : $v['account'];
		}
		$name='佣金转入记录';
		$res=$this->push($data,$name);
   	}




   	/**
  	* 推广员流水
  	* @author wang <li>
  	*/
  	public function extension_water()
  	{
        //判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();

        $email     = trim(I('get.email'));    //手机号
        $status    = trim(I('get.status'));   //计算状态
        $starttime = urldecode(trim(I('get.starttime')));
	    $endtime   = urldecode(trim(I('get.endtime')));  //结束时间
	    $otype     = trim(I('get.otype'));
        $jingjiren = trim(I('get.jingjiren'));
        $userss    = trim(I('get.user'));

        $optin_class_max      = trim(I('get.optin_class_max')); 
        $optin_class_min      = trim(I('get.optin_class_min')); 
        $option_name          = trim(I('get.option_name'));
	        
        if($email) {
        	$map['b.email'] 	= $email;
        	$sea['email'] 	= $email;
        }

        if($status) {
           $map['a.status'] = $status;
           $sea['status'] 	= $status;
        }


        //日期筛选
        if($starttime && $endtime){
            $start_time = strtotime($starttime);
        	$end_time   = strtotime($endtime);
    	    $map['a.create_time'] = array('between',array($start_time,$end_time));
            $sea['starttime'] 	= $starttime;
            $sea['endtime'] 	= $endtime;
        } else {

            $start_time = strtotime(date('Y-m-d')." 06:00:00");
	       	$end_time 	= strtotime(date('Y-m-d')." 05:00:00")+ 3600*24;
	       	$map['a.create_time'] 	= array('between',array($start_time,$end_time));
	       	$sea['starttime'] 		= date('Y-m-d H:i:s',$start_time);
	       	$sea['endtime']   		= date('Y-m-d H:i:s',$end_time);
        }

        if($otype) {
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
        	$map['a.user_id'] = array('in',$id);
        	$sea['otype'] = $otype;
        	$this->assign('user_id',$otype);
        }

        if($jingjiren) {

            $relationArr2 = array();
        	$jingjiren_user = M('UserinfoRelationship')->where('parent_user_id in('.$jingjiren.')')->select();
            foreach ($jingjiren_user as $key => $value) {
            	 array_push($relationArr2,$value['user_id']);
            }
            $userId1 = implode(',',array_unique($relationArr2));
            $map['a.user_id'] = array('in',$userId1);

        	$sea['jingjiren'] = $jingjiren;
        	$this->assign('jingjiren',$this->get_username($jingjiren));
        }

        if($userss){
            
            $uid = $userss; 
        	$map['a.user_id'] = array('in',$uid);
        	$sea['user'] = $userss;
        	$this->assign('use',$this->get_username($userss));
        }


        //分类大类
        if($optin_class_max)
        {
            $classObj = M('OptionClassify');
            $data = $classObj->field('group_concat(distinct id) id')->where(array('pid' => $optin_class_max))->find();

            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')->where('pid in('.$data['id'].')')->find();

            $map['c.pid'] = array('in',$option['id']);

            $sea['optin_class_max'] = $optin_class_max;
            $this->assign('optin_class_max',$optin_class_max);
        }

        //分类小类
        if($optin_class_min)
        {
            $classObj = M('OptionClassify');
            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')->where('pid='.$optin_class_min)->find();

            $map['c.pid'] = array('in',$option['id']);

            $mindata = $classObj->field('id,name')->where('id in('.$data['id'].')')->select();

            $sea['optin_class_min'] = $optin_class_min;
            $this->assign('mindata',$mindata);
            $this->assign('optin_class_min',$optin_class_min);
        }

        //产品名称
        if ($option_name) 
        {   
            $map['c.pid'] = $option_name;

            $optionObj = M('option');

            $option = $optionObj->field('id,capital_name')->where('pid='.$optin_class_min)->select();

            $sea['option_name'] = $option_name;
            $this->assign('option',$option);
            $this->assign('option_name',$option_name);
        }

        
        $FeeReceive =  M('FeeReceive a'); //流水表初始化
        $prefix 	=  C('DB_PREFIX'); 

        $map['a.type'] = 1;

        $count = $FeeReceive->join('left join '.$prefix.'userinfo as b on a.user_id = b.uid')->join('left join '.$prefix.'order as c on a.order_id = c.oid')->where($map)->count();   //总数量
		$pagecount = 10;   //每页显示的数量
		$page = new \Think\Page($count, $pagecount);
		$page->parameter = $sea; //此处的row是数组，为了传递查询条件
		$page->setConfig('first', '首页');
		$page->setConfig('prev', '&#8249;');
		$page->setConfig('next', '&#8250;');
		$page->setConfig('last', '尾页');
		$page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
		$show = $page->show();
		
		$receive = $FeeReceive->join('left join '.$prefix.'userinfo as b on a.user_id = b.uid')->join('left join '.$prefix.'order as c on a.order_id = c.oid')->where($map)->order('a.order_id desc')->limit($page->firstRow, $page->listRows)->select();


    	$field = 'a.order_id,a.user_id,a.profit,a.type,a.status,b.uid';
        $count = $FeeReceive->field($field)->join('left join '.$prefix.'userinfo as b on a.user_id = b.uid')->join('left join '.$prefix.'order as c on a.order_id = c.oid')->where($map)->select();

        foreach ($count as $key => $value) {
            if($value['type'] == 1)
            {
            	$account['user_rmb'] += $value['profit'];
            }

        	if($value['status'] == 1) {
               $account['count'] += count($value['status']);
            } 
            if($value['status'] == 2) {
                $account['count_stop'] += count($value['status']);
            }
        }

        //产品大类
        $classify   = M('option_classify')->field('id,name')->where(array('level' => 1))->select();
        $this->assign('classify',$classify);

        $this->assign('user',$receive);
        $this->assign('page',$show);
        $this->assign('sea',$sea);
        $this->assign('account',$account);
        $this->assign('info',M('userinfo')->where(array('otype' => 5))->select());
	    $this->display();
  	}



  	public function daochu_ExtensionWater()
  	{ 
        //判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();

        $email     = trim(I('get.email'));    //电子邮箱
        $status    = trim(I('get.status'));   //计算状态
        $starttime = urldecode(trim(I('get.starttime')));
	    $endtime   = urldecode(trim(I('get.endtime')));  //结束时间
	    $otype     = trim(I('get.otype'));
        $jingjiren = trim(I('get.jingjiren'));
        $userss    = trim(I('get.user'));

        $optin_class_max      = trim(I('get.optin_class_max')); 
        $optin_class_min      = trim(I('get.optin_class_min')); 
        $option_name          = trim(I('get.option_name'));
	        
        if($email) {
        	$map['b.email'] 	= $email;
        }

        if($status) {
           $map['a.status'] = $status;
        }

        //日期筛选
        if($starttime && $endtime){
            $start_time = strtotime($starttime);
        	$end_time   = strtotime($endtime);
    	    $map['a.create_time'] = array('between',array($start_time,$end_time));
        } else {

            $start_time = strtotime(date('Y-m-d')." 06:00:00");
	       	$end_time 	= strtotime(date('Y-m-d')." 05:00:00")+ 3600*24;
	       	$map['a.create_time'] 	= array('between',array($start_time,$end_time));
        }

        if($otype) {
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
        	$map['a.user_id'] = array('in',$id);
        }

        if($jingjiren) {

            $relationArr2 = array();
        	$jingjiren_user = M('UserinfoRelationship')->where('parent_user_id in('.$jingjiren.')')->select();
            foreach ($jingjiren_user as $key => $value) {
            	 array_push($relationArr2,$value['user_id']);
            }
            $userId1 = implode(',',array_unique($relationArr2));
            $map['a.user_id'] = array('in',$userId1);
        }

        if($userss){
            
            $uid = $userss; 
        	$map['a.user_id'] = array('in',$uid);
        }


        //分类大类
        if($optin_class_max)
        {
            $classObj = M('OptionClassify');
            $data = $classObj->field('group_concat(distinct id) id')->where(array('pid' => $optin_class_max))->find();

            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')->where('pid in('.$data['id'].')')->find();

            $map['c.pid'] = array('in',$option['id']);
        }

        //分类小类
        if($optin_class_min)
        {
            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')->where('pid='.$optin_class_min)->find();
            $map['c.pid'] = array('in',$option['id']);
        }

        //产品名称
        if ($option_name) 
        {   
            $map['c.pid'] = $option_name;
        }

        
        $FeeReceive =  M('FeeReceive a'); //流水表初始化
        $prefix 	=  C('DB_PREFIX'); 

		
		$receive = $FeeReceive->join('left join '.$prefix.'userinfo as b on a.user_id = b.uid')->join('left join '.$prefix.'order as c on a.order_id = c.oid')->where($map)->order('a.order_id desc')->select();


  	   	$data[0] = array('编号','用户名称','用户昵称','电子邮箱','产品名称','状态','获得佣金','操作时间','购买人');
		foreach($receive as $k => $v){

			$data[$k+1][] = $v['order_id'];

			$data[$k+1][] = $v['username'];
			$data[$k+1][] = $v['nickname'];

			$data[$k+1][] = $v['email'];
			$data[$k+1][] = $v['option_name'];
			if($v['status'] == 1) {
				$data[$k+1][] = '已结算';
			} else {
				$data[$k+1][] = '未结算';
			}
			$data[$k+1][] = $v['profit'];
			$data[$k+1][] = date('Y-m-d H:i:s',$v['create_time']);
			$data[$k+1][] = change($v['purchaser_id']);
		}
		$name='佣金流水';      //生成的Excel文件文件名
		$this->push($data,$name);
  	}




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