<?php
//交易员控制器
namespace Admin\Controller;
class TraderController extends BaseController {
	
	
	public function index()
	{
        $otype 		= trim(I('get.otype'));
        $jingjiren 	= trim(I('get.jingjiren'));
        $userss 	= trim(I('get.user'));
        $email		= trim(I('get.email'));

        $starttime = urldecode(trim(I('get.starttime')));
        $endtime   = urldecode(trim(I('get.endtime')));

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

        	$map['uid'] = array('in',$id);
        	$username = M('userinfo')->where(array('uid'=> $otype))->find();
        	$sea['otype'] = $otype;
        	$this->assign('user_id',$username['uid']);
        }

        if($jingjiren) {
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

        if($userss){
            $uid = $userss; 
        	$map['uid'] = array('in',$uid);
        	$sea['user'] = $userss;
        	$this->assign('use',$this->get_username($userss));
        }


		if ($email) {
			$map['email'] 	= $email;
			$sea['email']   = $email;
			$this->assign('email', $email);
		}

        if($starttime && $endtime)
        {
        	$start_time = strtotime($starttime);
        	$end_time   = strtotime($endtime);
        	$map['utime'] = array('between',array($start_time,$end_time));
        	$sea['starttime'] = $starttime;
        	$sea['endtime']   = $endtime;
        	$this->assign('sea',$sea);
        }


		$userObj 	= M('userinfo');
		$followObj 	= M('order_follow');
		$accountObj = M('accountinfo');

		$map['otype'] 		= 4;
		$map['is_trader'] 	= 1;
		$map['ustatus'] 	= array('in','0,1'); 


       	$count = $userObj->where($map)->count();   //总数量
	   	$pagecount = 15;   //每页显示的数量
	   	$page = new \Think\Page($count, $pagecount);
	   	$page->parameter = $sea; //此处的row是数组，为了传递查询条件
	   	$page->setConfig('first', '首页');
   		$page->setConfig('prev', '&#8249;');
	   	$page->setConfig('next', '&#8250;');
	   	$page->setConfig('last', '尾页');
	   	$page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
	   	$show = $page->show();

		$info = $userObj->field('uid,email,username,nickname,utime,lastlog')->where($map)->order('utime desc')->limit($page->firstRow, $page->listRows)->select();

		$UidArr = array();
		foreach ($info as $key => $value) {
			array_push($UidArr,$value['uid']);
		}

		if($UidArr)
		{
			$uid = implode(',',array_unique($UidArr));

			//统计跟随人数
			$follow = $followObj->field('count(*) count ,count(case when status = 1 then status end) nowCount,follow_user_id')->where('follow_user_id in ('.$uid.')')->group('follow_user_id')->select();

			$followData = array();

			foreach ($follow as $key => $value) {
				$followData[$value['follow_user_id']] = $value;
			}

			//统计累计收益
			$account = $accountObj->where('uid in('.$uid.')')->getField('uid,trader_profit',true);
		}


		foreach ($info as $key => $value) {
			$info[$key]['count'] 	= $followData[$value['uid']]['count'];
			$info[$key]['nowCount'] = $followData[$value['uid']]['nowCount'];

			$info[$key]['trader_profit'] = $account[$value['uid']];

			$info[$key]['lastlog'] = empty($value['lastlog']) ? '未登陆过' : date('Y-m-d H:i:s',$value['lastlog']);
		}
		
		//底部总收益
		$allUser = $userObj->field('group_concat(distinct uid) uid')->where($map)->find();   //总数量
		
		if(!empty($allUser['uid']))
		{
			$sumProfit = $accountObj->where('uid in('.$allUser['uid'].')')->sum('trader_profit');
		}

		$this->assign('sumProfit',$sumProfit);
		$this->assign('page',$show);
		$this->assign('info',$info);

		$this->assign('yunying',$userObj->field('username,uid')->where('otype=5')->select());

		$this->display();
	}


	public function trader_daochu()
	{
        $otype 		= trim(I('get.otype'));
        $jingjiren 	= trim(I('get.jingjiren'));
        $userss 	= trim(I('get.user'));
        $email		= trim(I('get.email'));

        $starttime 	= urldecode(trim(I('get.starttime')));
        $endtime   	= urldecode(trim(I('get.endtime')));

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

        	$map['uid'] = array('in',$id);
        	$username = M('userinfo')->where(array('uid'=> $otype))->find();
        }

        if($jingjiren) {
        	$userarr  = array();
            $userarr1 = array(); 
        	$ship = M("UserinfoRelationship")->where(array('parent_user_id' => $jingjiren))->select();
            foreach ($ship as $key => $value) {
            	
            	array_push($userarr, $value['user_id']);
            }
            $userid = implode(',',array_unique($userarr));

        	$map['uid'] = array('in',$userid);
        }

        if($userss){
            $uid = $userss; 
        	$map['uid'] = array('in',$uid);
        }


		if ($email) {
			$map['email'] 	= $email;
		}

        if($starttime && $endtime)
        {
        	$start_time = strtotime($starttime);
        	$end_time   = strtotime($endtime);
        	$map['utime'] = array('between',array($start_time,$end_time));
        }


		$userObj 	= M('userinfo');
		$followObj 	= M('order_follow');
		$accountObj = M('accountinfo');

		$map['otype'] 		= 4;
		$map['is_trader'] 	= 1;
		$map['ustatus'] 	= array('in','0,1'); 


		$info = $userObj->field('uid,email,username,nickname,utime,lastlog')->where($map)->order('utime desc')->select();

		$UidArr = array();
		foreach ($info as $key => $value) {
			array_push($UidArr,$value['uid']);
		}

		if($UidArr)
		{
			$uid = implode(',',array_unique($UidArr));

			//统计跟随人数
			$follow = $followObj->field('count(*) count ,count(case when status = 1 then status end) nowCount,follow_user_id')->where('follow_user_id in ('.$uid.')')->group('follow_user_id')->select();

			$followData = array();

			foreach ($follow as $key => $value) {
				$followData[$value['follow_user_id']] = $value;
			}

			//统计累计收益
			$account = $accountObj->where('uid in('.$uid.')')->getField('uid,trader_profit',true);
		}


		foreach ($info as $key => $value) {
			$info[$key]['count'] 	= $followData[$value['uid']]['count'];
			$info[$key]['nowCount'] = $followData[$value['uid']]['nowCount'];

			$info[$key]['trader_profit'] = $account[$value['uid']];

			$info[$key]['lastlog'] = empty($value['lastlog']) ? '未登陆过' : date('Y-m-d H:i:s',$value['lastlog']);
		}
				

		$data[0] = array('编号','用户名称','用户昵称','电子邮件','累计跟随人数','当前跟随人数','累计收益','注册日期','最后登录');
		foreach($info as $k => $v){

			$data[$k+1][] = $v['uid'];
			$data[$k+1][] = $v['username'];
			$data[$k+1][] = $v['nickname'];
			$data[$k+1][] = $v['email'];
			$data[$k+1][] = empty($v['count']) ? '0' : $v['count'];
			$data[$k+1][] = empty($v['nowCount']) ? '0' : $v['nowCount'];
			$data[$k+1][] = $v['trader_profit'];
			$data[$k+1][] = date('Y-m-d H:i:s',$v['utime']);
			$data[$k+1][] = $v['lastlog'];
		}
		$name='交易员列表记录';      //生成的Excel文件文件名
		$res=$this->push($data,$name);
	}


	/**
	 * 取消交易员
	 * @author wang li
	 */
	public function exitTrader()
	{
		$uid = trim(I('get.uid'));

		if(empty($uid))
			$this->error('操作失败');

		$userObj 	= M('userinfo');

		$res = $userObj->where(array('uid' => $uid))->setField('is_trader',0);

		if($res)
			$this->success('操作成功');
		else
			$this->error('操作失败');
	}


	/**
	 * 交易员审核
	 */
	public function traderExamine()
	{
        $otype 		= trim(I('get.otype'));
        $jingjiren 	= trim(I('get.jingjiren'));
        $userss 	= trim(I('get.user'));
        $email		= trim(I('get.email'));

        $starttime = urldecode(trim(I('get.starttime')));
        $endtime   = urldecode(trim(I('get.endtime')));

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

        	$map['b.uid'] = array('in',$id);
        	$username = M('userinfo')->where(array('uid'=> $otype))->find();
        	$sea['otype'] = $otype;
        	$this->assign('user_id',$username['uid']);
        }

        if($jingjiren) {
        	$userarr  = array();
            $userarr1 = array(); 
        	$ship = M("UserinfoRelationship")->where(array('parent_user_id' => $jingjiren))->select();
            foreach ($ship as $key => $value) {
            	
            	array_push($userarr, $value['user_id']);
            }
            $userid = implode(',',array_unique($userarr));

        	$map['b.uid'] = array('in',$userid);
        	$sea['jingjiren'] = $jingjiren;
        	$this->assign('jingjiren',$this->get_username($jingjiren));
        }

        if($userss){
            $uid = $userss; 
        	$map['b.uid'] = array('in',$uid);
        	$sea['user'] = $userss;
        	$this->assign('use',$this->get_username($userss));
        }


		if ($email) {
			$map['b.email'] 	= $email;
			$sea['email']   = $email;
			$this->assign('email', $email);
		}

        if($starttime && $endtime)
        {
        	$start_time = strtotime($starttime);
        	$end_time   = strtotime($endtime);
        	$map['a.create_time'] = array('between',array($start_time,$end_time));
        	$sea['starttime'] = $starttime;
        	$sea['endtime']   = $endtime;
        	$this->assign('sea',$sea);
        }


		$applyObj 	= M('trade_apply a');
		$accountObj = M('accountinfo');
		$userObj	= M('userinfo');
		$orderObj   = M('order');

		$prefix = C('DB_PREFIX');

		$map['a.status'] = 1;

       	$count = $applyObj->where($map)->count();   //总数量
	   	$pagecount = 15;   //每页显示的数量
	   	$page = new \Think\Page($count, $pagecount);
	   	$page->parameter = $sea; //此处的row是数组，为了传递查询条件
	   	$page->setConfig('first', '首页');
   		$page->setConfig('prev', '&#8249;');
	   	$page->setConfig('next', '&#8250;');
	   	$page->setConfig('last', '尾页');
	   	$page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
	   	$show = $page->show();

		$info = $applyObj->
				field('a.*,b.email,b.username,b.nickname,b.lastlog,c.balance')->
				where($map)->
				join('left join '.$prefix.'userinfo b on a.user_id=b.uid')->
				join('left join '.$prefix.'accountinfo c on a.user_id=c.uid')->
				order('a.create_time desc')->
				limit($page->firstRow, $page->listRows)->
				select();


		foreach ($info as $key => $value) {

			$info[$key]['lastlog'] = empty($value['lastlog']) ? '未登陆过' : date('Y-m-d H:i:s',$value['lastlog']);

	        $order = $orderObj->field('sum(ploss) / sum(bond) as profit')->where(array('uid' => $value['user_id'],'type' => 1,'ostaus' => 1))->find();

	        $info[$key]['profit'] = round($order['profit']*100,2);
		}
		

		$this->assign('page',$show);
		$this->assign('info',$info);
		$this->assign('yunying',$userObj->field('username,uid')->where('otype=5')->select());
		$this->display();
	}


	/**
	 * [traderExamineDaochu 交易员审核列表导出]
	 * @author wang li
	 */
	public function traderExamineDaochu()
	{

        $otype 		= trim(I('get.otype'));
        $jingjiren 	= trim(I('get.jingjiren'));
        $userss 	= trim(I('get.user'));
        $email		= trim(I('get.email'));

        $starttime = urldecode(trim(I('get.starttime')));
        $endtime   = urldecode(trim(I('get.endtime')));

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

        	$map['b.uid'] = array('in',$id);
        	$username = M('userinfo')->where(array('uid'=> $otype))->find();
        }

        if($jingjiren) {
        	$userarr  = array();
            $userarr1 = array(); 
        	$ship = M("UserinfoRelationship")->where(array('parent_user_id' => $jingjiren))->select();
            foreach ($ship as $key => $value) {
            	
            	array_push($userarr, $value['user_id']);
            }
            $userid = implode(',',array_unique($userarr));

        	$map['b.uid'] = array('in',$userid);
        }

        if($userss){
            $uid = $userss; 
        	$map['b.uid'] = array('in',$uid);
        }


		if ($email) {
			$map['b.email'] 	= $email;
		}

        if($starttime && $endtime)
        {
        	$start_time = strtotime($starttime);
        	$end_time   = strtotime($endtime);
        	$map['a.create_time'] = array('between',array($start_time,$end_time));
        }


		$applyObj 	= M('trade_apply a');
		$accountObj = M('accountinfo');
		$userObj	= M('userinfo');
		$orderObj   = M('order');

		$prefix = C('DB_PREFIX');

		$map['a.status'] = 1;

		$info = $applyObj->
				field('a.*,b.email,b.username,b.nickname,b.lastlog,c.balance')->
				where($map)->
				join('left join '.$prefix.'userinfo b on a.user_id=b.uid')->
				join('left join '.$prefix.'accountinfo c on a.user_id=c.uid')->
				order('a.create_time desc')->
				select();


		foreach ($info as $key => $value) {

			$info[$key]['lastlog'] = empty($value['lastlog']) ? '未登陆过' : date('Y-m-d H:i:s',$value['lastlog']);

	        $order = $orderObj->field('sum(ploss) / sum(bond) as profit')->where(array('uid' => $value['user_id'],'type' => 1,'ostaus' => 1))->find();

	        $info[$key]['profit'] = round($order['profit']*100,2);
		}
		

		$data[0] = array('编号','用户名称','用户昵称','电子邮箱','当前收益率','账户余额','申请日期','最后登录');
		foreach($info as $k => $v){

			$data[$k+1][] = $v['user_id'];
			$data[$k+1][] = $v['username'];
			$data[$k+1][] = $v['nickname'];
			$data[$k+1][] = $v['email'];
			$data[$k+1][] = $v['profit'].'%';
			$data[$k+1][] = $v['balance'];
			$data[$k+1][] = date('Y-m-d H:i:s',$v['create_time']);
			$data[$k+1][] = $v['lastlog'];
		}
		$name='交易员审核记录';      //生成的Excel文件文件名
		$res=$this->push($data,$name);
	}

	/**
	 * [tarderSubmit 交易员审核]
	 * @author wang li
	 */
	public function tarderSubmit()
	{
		$uid 	= trim(I('get.uid'));
		$status = trim(I('get.status')); 

		if(empty($uid))
			$this->error('操作失败');

		if($status != 2 && $status != 3)
			$this->error('操作失败');

		$applyObj 	= M('trade_apply');
		$userObj	= M('userinfo');

		$res = $applyObj->where(array('user_id' => $uid))->setField('status',$status);

		if($status == 2 && $res)
		{
			$userObj->where(array('uid' => $uid))->setField('is_trader',1);
		}

		if($res)
			$this->success('操作成功');
		else
			$this->error('操作失败');
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


    /**
     * 追随者列表
     * @author Admin
     * @date   2022/3/28
     * @return void
     */
    public function followList()
    {
        $otype 		= trim(I('get.otype'));
        $jingjiren 	= trim(I('get.jingjiren'));
        $userss 	= trim(I('get.user'));
        $email		= trim(I('get.email'));
        $fu_email	= trim(I('get.fu_email'));

        $starttime = urldecode(trim(I('get.starttime')));
        $endtime   = urldecode(trim(I('get.endtime')));

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

            $map['u.uid'] = array('in',$id);
            $username = M('userinfo')->where(array('uid'=> $otype))->find();
            $sea['otype'] = $otype;
            $this->assign('user_id',$username['uid']);
        }

        if($jingjiren) {
            $userarr  = array();
            $ship = M("UserinfoRelationship")->where(array('parent_user_id' => $jingjiren))->select();
            foreach ($ship as $key => $value) {

                array_push($userarr, $value['user_id']);
            }
            $userid = implode(',',array_unique($userarr));

            $map['u.uid'] = array('in',$userid);
            $sea['jingjiren'] = $jingjiren;
            $this->assign('jingjiren',$this->get_username($jingjiren));
        }

        if($userss){
            $uid = $userss;
            $map['u.uid'] = array('in',$uid);
            $sea['user'] = $userss;
            $this->assign('use',$this->get_username($userss));
        }

        if ($email) {
            $map['u.email'] 	= $email;
            $sea['email']      = $email;
            $this->assign('email', $email);
        }

        if ($fu_email) {
            $map['fu.email'] 	= $fu_email;
            $sea['fu_email']   = $fu_email;
            $this->assign('fu_email', $fu_email);
        }

        if($starttime && $endtime)
        {
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $map['u.utime'] = array('between',array($start_time,$end_time));
            $sea['starttime'] = $starttime;
            $sea['endtime']   = $endtime;
            $this->assign('sea',$sea);
        }


        $userObj 	= M('userinfo');
        $followObj 	= M('order_follow as o');

        $map['u.otype'] 		= 4;
        $map['u.ustatus'] 	    = array('in','0,1');
        $map['o.status']       = 1;

        $count = $followObj
            ->where($map)
            ->join('left join wp_userinfo as u on o.user_id = u.uid')
            ->join('left join wp_userinfo as fu on o.follow_user_id = fu.uid')
            ->count();

        $pagecount = 15;   //每页显示的数量
        $page = new \Think\Page($count, $pagecount);
        $page->parameter = $sea; //此处的row是数组，为了传递查询条件
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '&#8249;');
        $page->setConfig('next', '&#8250;');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();

        $info = $followObj
            ->field('u.uid,u.email,u.username,u.nickname,u.utime,u.lastlog,o.follow_type,o.follow_number,o.follow_profit,fu.email as fu_email')
            ->where($map)
            ->join('left join wp_userinfo as u on o.user_id = u.uid')
            ->join('left join wp_userinfo as fu on o.follow_user_id = fu.uid')
            ->order('o.follow_profit desc,u.utime asc')
            ->limit($page->firstRow, $page->listRows)
            ->select();

        //总收益
        $sumProfit = $followObj
            ->where($map)
            ->join('left join wp_userinfo as u on o.user_id = u.uid')
            ->join('left join wp_userinfo as fu on o.follow_user_id = fu.uid')
            ->sum('o.follow_profit');

        $this->assign('sumProfit',$sumProfit);
        $this->assign('page',$show);
        $this->assign('info',$info);
        $this->assign('yunying',$userObj->field('username,uid')->where('otype=5')->select());
        $this->display();
    }

    /**
     * 追随者列表导出
     * @author 王海东
     * @date   2022/3/28
     * @return void
     */
    public function followList_daochu()
    {
        $otype 		= trim(I('get.otype'));
        $jingjiren 	= trim(I('get.jingjiren'));
        $userss 	= trim(I('get.user'));
        $email		= trim(I('get.email'));
        $fu_email	= trim(I('get.fu_email'));

        $starttime = urldecode(trim(I('get.starttime')));
        $endtime   = urldecode(trim(I('get.endtime')));

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

            $map['u.uid'] = array('in',$id);
        }

        if($jingjiren) {
            $userarr  = array();
            $ship = M("UserinfoRelationship")->where(array('parent_user_id' => $jingjiren))->select();
            foreach ($ship as $key => $value) {

                array_push($userarr, $value['user_id']);
            }
            $userid = implode(',',array_unique($userarr));

            $map['u.uid'] = array('in',$userid);
        }

        if($userss){
            $uid = $userss;
            $map['u.uid'] = array('in',$uid);
        }

        if ($email) {
            $map['u.email'] 	= $email;
        }

        if ($fu_email) {
            $map['fu.email'] 	= $fu_email;
        }

        if($starttime && $endtime)
        {
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $map['u.utime'] = array('between',array($start_time,$end_time));
        }


        $followObj 	= M('order_follow as o');

        $map['u.otype'] 		= 4;
        $map['u.ustatus'] 	    = array('in','0,1');
        $map['o.status']       = 1;

        $info = $followObj
            ->field('u.uid,u.email,u.username,u.nickname,u.utime,u.lastlog,o.follow_type,o.follow_number,o.follow_profit,fu.email as fu_email')
            ->where($map)
            ->join('left join wp_userinfo as u on o.user_id = u.uid')
            ->join('left join wp_userinfo as fu on o.follow_user_id = fu.uid')
            ->order('o.follow_profit desc,u.utime asc')
            ->select();

        foreach ($info as $key => $value) {
            $info[$key]['follow_type']  = $value['follow_type'] == 1 ? "固定比例" : "固定手数";
            $info[$key]['utime']        = date('Y-m-d H:i:s',$value['utime']);
            $info[$key]['lastlog']      = date('Y-m-d H:i:s',$value['lastlog']);
        }

        $data[0] = array('编号','用户名称','用户昵称','电子邮箱','交易员邮箱','跟随方式','跟随数量','跟随收益','注册日期','最后登录');
        foreach($info as $k => $v){

            $data[$k+1][] = $v['uid'];
            $data[$k+1][] = $v['username'];
            $data[$k+1][] = $v['nickname'];
            $data[$k+1][] = $v['email'];
            $data[$k+1][] = $v['fu_email'];
            $data[$k+1][] = $v['follow_type'];
            $data[$k+1][] = $v['follow_number'];
            $data[$k+1][] = $v['follow_profit'];
            $data[$k+1][] = $v['utime'];
            $data[$k+1][] = $v['lastlog'];
        }

        $name='追随者列表记录';      //生成的Excel文件文件名
        $this->push($data,$name);
    }
}