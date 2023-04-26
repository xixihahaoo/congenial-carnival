<?php
/**
 * 个人资料审核
 */
namespace Admin\Controller;

class DatareviewController extends CommonController {

    public function _initialize(){
        parent::_initialize();
		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();
    }

		
	//个人信息审核
	public function personal()
	{
		$utel 		= trim(I('get.utel'));
		$username 	= trim(I('get.username'));	
		$nickname 	= trim(I('get.nickname'));
		$starttime 	= urldecode(trim(I('get.starttime')));	//开始时间
		$endtime 	= urldecode(trim(I('get.endtime')));	//结束时间
		$user_type 	= trim(I('get.user_type'));
		$status 	= trim(I('get.status'));

		if($utel) 
		{
			$where['b.utel'] 	= array('like','%'.$utel.'%');
			$sea['utel'] 		= $utel;
		}

		if($username) 
		{
			$where['b.username'] 	= array('like','%'.$username.'%');
			$sea['username'] 		= $username;
		}

		if($nickname)
		{
			$where['b.nickname'] 	= array('like','%'.$nickname.'%');
			$sea['nickname'] 		= $nickname;
		}

		//时间统计
		if($starttime && $endtime) {
			$start_time  	  = strtotime($starttime);
			$end_time 		  = strtotime($endtime);
			$where['a.create_time'] = array('between',''.$start_time.','.$end_time.'');
			$sea['starttime'] = $starttime;
			$sea['endtime']   = $endtime;
		}
		
		if($user_type) {
			$where['a.user_type'] = $user_type;
			$sea['user_type']   = $user_type;
		}

		if($status || $status == '0') {
			$where['a.status'] = $status;
			$sea['status']   = $status;
		}


		$personalObj = M('personal_user_data a');
		
		$prefix = C('DB_PREFIX');

		$count = $personalObj->
					where($where)->
					join('left join '.$prefix.'userinfo b on a.uid=b.uid')->
					count();

		$pagecount = 10;
		$page = new \Think\Page($count , $pagecount);
		$page->parameter = $sea; //此处的row是数组，为了传递查询条件
		$page->setConfig('first','首页');
		$page->setConfig('prev','上一页');
		$page->setConfig('next','下一页');
		$page->setConfig('last','尾页');
		$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
		$start = $page->firstRow;
		$end = $page->listRows;

		$personal = $personalObj->
					where($where)->
					join('left join '.$prefix.'userinfo b on a.uid=b.uid')->
					limit($start,$end)->
					order('a.status asc')->
					select();


		$userType 	= array(1 => '普通用户',2 => '运营中心');
		$userStaus 	= array(0 => '待处理',1 => '已通过',2 => '已拒绝');

		foreach ($personal as $key => $value) {
			$personal[$key]['userType'] 	= $userType[$value['user_type']];
			$personal[$key]['userStaus'] 	= $userStaus[$value['status']];
		}


		//统计
		$statistics = $personalObj->
					where($where)->
					field('a.status')->
					join('inner join '.$prefix.'userinfo b on a.uid=b.uid')->
					select();

		foreach ($statistics as $key => $value) {
			if($value['status'] == '0')
				$data['failCount'] += count($value);
			else
				$data['succesCount'] += count($value);
		}

		$this->assign('sea',$sea);
		$this->assign('data',$data);
		$this->assign('personal',$personal);
		$this->assign('page',$page->show());
		$this->display();
	}


	public function personal_daochu()
	{
		$utel 		= trim(I('get.utel'));	
		$username 	= trim(I('get.username'));	
		$nickname 	= trim(I('get.nickname'));
		$starttime 	= urldecode(trim(I('get.starttime')));	//开始时间
		$endtime 	= urldecode(trim(I('get.endtime')));	//结束时间
		$user_type 	= trim(I('get.user_type'));
		$status 	= trim(I('get.status'));

		if($utel) 
		{
			$where['b.utel'] 	= array('like','%'.$utel.'%');
			$sea['utel'] 		= $utel;
		}

		if($username) 
		{
			$where['b.username'] 	= array('like','%'.$username.'%');
			$sea['username'] 		= $username;
		}

		if($nickname)
		{
			$where['b.nickname'] 	= array('like','%'.$nickname.'%');
			$sea['nickname'] 		= $nickname;
		}

		//时间统计
		if($starttime && $endtime) {
			$start_time  	  = strtotime($starttime);
			$end_time 		  = strtotime($endtime);
			$where['a.create_time'] = array('between',''.$start_time.','.$end_time.'');
			$sea['starttime'] = $starttime;
			$sea['endtime']   = $endtime;
		}
		
		if($user_type) {
			$where['a.user_type'] = $user_type;
			$sea['user_type']   = $user_type;
		}

		if($status || $status == '0') {
			$where['a.status'] = $status;
			$sea['status']   = $status;
		}


		$personalObj = M('personal_user_data a');
		
		$prefix = C('DB_PREFIX');

		$personal = $personalObj->
					where($where)->
					join('left join '.$prefix.'userinfo b on a.uid=b.uid')->
					order('a.status asc')->
					select();

		$userType 	= array(1 => '普通用户',2 => '运营中心');
		$userStaus 	= array(0 => '待处理',1 => '已通过',2 => '已拒绝');

		foreach ($personal as $key => $value) {
			$personal[$key]['userType'] 	= $userType[$value['user_type']];
			$personal[$key]['userStaus'] 	= $userStaus[$value['status']];
		}
 
		$data[0] = array(
			'编号id','用户名称','手机号码','用户昵称','用户类型','真实姓名','身份证号','审核状态','申请时间'
		);
		foreach($personal as $key=>$val)
		{
			$data[$key+1][] = $val['id'];
			$data[$key+1][] = $val['username'];
			$data[$key+1][] = $val['utel'];
			$data[$key+1][] = $val['nickname'];
			$data[$key+1][] = $val['userType'];
			$data[$key+1][] = $val['real_name'];
			$data[$key+1][] = $val['card'];
			$data[$key+1][] = $val['userStaus'];
			$data[$key+1][] = date('Y-m-d H:i:s',$val['create_time']);
		}

		$res=$this->push($data,'个人信息审核');
	}


	/**
	 * 银行卡审核
	 * @author wang li
	 */
	public function bank()
	{
		$email 		= trim(I('get.email'));
		$username 	= trim(I('get.username'));	
		$nickname 	= trim(I('get.nickname'));
		$starttime 	= urldecode(trim(I('get.starttime')));	//开始时间
		$endtime 	= urldecode(trim(I('get.endtime')));	//结束时间
		$user_type 	= trim(I('get.user_type'));
		$status 	= trim(I('get.status'));

		if($email)
		{
			$where['b.email'] 	= array('like','%'.$email.'%');
			$sea['email'] 		= $email;
		}

		if($username)
		{
			$where['b.username'] 	= array('like','%'.$username.'%');
			$sea['username'] 		= $username;
		}

		if($nickname)
		{
			$where['b.nickname'] 	= array('like','%'.$nickname.'%');
			$sea['nickname'] 		= $nickname;
		}

		//时间统计
		if($starttime && $endtime) {
			$start_time  	  = strtotime($starttime);
			$end_time 		  = strtotime($endtime);
			$where['a.create_time'] = array('between',''.$start_time.','.$end_time.'');
			$sea['starttime'] = $starttime;
			$sea['endtime']   = $endtime;
		}
		
		if($user_type) {
			$where['a.user_type'] = $user_type;
			$sea['user_type']   = $user_type;
		}

		if($status || $status == '0') {
			$where['a.status'] = $status;
			$sea['status']   = $status;
		}


		$bankObj = M('bankinfo a');
		
		$prefix = C('DB_PREFIX');

		$count = $bankObj->
					where($where)->
					join('left join '.$prefix.'userinfo b on a.uid=b.uid')->
					count();

		$pagecount = 10;
		$page = new \Think\Page($count , $pagecount);
		$page->parameter = $sea; //此处的row是数组，为了传递查询条件
		$page->setConfig('first','首页');
		$page->setConfig('prev','上一页');
		$page->setConfig('next','下一页');
		$page->setConfig('last','尾页');
		$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
		$start = $page->firstRow;
		$end = $page->listRows;

		$personal = $bankObj->
					field('a.*,b.*')->
					where($where)->
					join('left join '.$prefix.'userinfo b on a.uid=b.uid')->
					limit($start,$end)->
					order('a.create_time desc,a.status asc')->
					select();

		$userType 	= array(1 => '普通用户',2 => '运营中心');
		$userStaus 	= array(0 => '待处理',1 => '已通过',2 => '已拒绝');

		foreach ($personal as $key => $value) {
			$personal[$key]['userType'] 	= $userType[$value['user_type']];
			$personal[$key]['userStaus'] 	= $userStaus[$value['status']];
		}


		//统计
		$statistics = $bankObj->
					where($where)->
					field('a.status')->
					join('inner join '.$prefix.'userinfo b on a.uid=b.uid')->
					select();

		foreach ($statistics as $key => $value) {
			if($value['status'] == '0')
				$data['failCount'] += count($value);
			else
				$data['succesCount'] += count($value);
		}

		$this->assign('sea',$sea);
		$this->assign('data',$data);
		$this->assign('personal',$personal);
        $this->assign('page',$page->show());
		$this->display();
	}


    public function bank_daochu()
    {
        $email 		= trim(I('get.email'));
        $username 	= trim(I('get.username'));
        $nickname 	= trim(I('get.nickname'));
        $starttime 	= urldecode(trim(I('get.starttime')));	//开始时间
        $endtime 	= urldecode(trim(I('get.endtime')));	//结束时间
        $user_type 	= trim(I('get.user_type'));
        $status 	= trim(I('get.status'));

        if($email)
        {
            $where['b.email'] 	= array('like','%'.$email.'%');
            $sea['email'] 		= $email;
        }

        if($username)
        {
            $where['b.username'] 	= array('like','%'.$username.'%');
            $sea['username'] 		= $username;
        }

        if($nickname)
        {
            $where['b.nickname'] 	= array('like','%'.$nickname.'%');
            $sea['nickname'] 		= $nickname;
        }

        //时间统计
        if($starttime && $endtime) {
            $start_time  	  = strtotime($starttime);
            $end_time 		  = strtotime($endtime);
            $where['a.create_time'] = array('between',''.$start_time.','.$end_time.'');
            $sea['starttime'] = $starttime;
            $sea['endtime']   = $endtime;
        }

        if($user_type) {
            $where['a.user_type'] = $user_type;
            $sea['user_type']   = $user_type;
        }

        if($status || $status == '0') {
            $where['a.status'] = $status;
            $sea['status']   = $status;
        }


        $bankObj = M('bankinfo a');

        $prefix = C('DB_PREFIX');


        $personal = $bankObj->
        field('a.*,b.*')->
        where($where)->
        join('left join '.$prefix.'userinfo b on a.uid=b.uid')->
        order('a.create_time desc,a.status asc')->
        select();

        $userType 	= array(1 => '普通用户',2 => '运营中心');
        $userStaus 	= array(0 => '待处理',1 => '已通过',2 => '已拒绝');

        foreach ($personal as $key => $value) {
            $personal[$key]['userType'] 	= $userType[$value['user_type']];
            $personal[$key]['userStaus'] 	= $userStaus[$value['status']];
        }

        $data[0] = array(
            '编号id',
            '电子邮箱',
            '用户昵称',
            '用户类型',
            '银行名称',
            '开户行',
            '开户地址',
            '姓名',
            '身份证号/护照',
            '银行卡',
            '电话',
            '汇款代码',
            '审核状态',
            '申请时间'
        );
        foreach($personal as $key=>$val)
        {
            $data[$key+1][] = $val['bid'];
            $data[$key+1][] = $val['email'];
            $data[$key+1][] = $val['nickname'];
            $data[$key+1][] = $val['userType'];
            $data[$key+1][] = $val['bankname'];
            $data[$key+1][] = $val['branch'];
            $data[$key+1][] = $val['address'];
            $data[$key+1][] = $val['busername'];
            $data[$key+1][] = $val['card'];
            $data[$key+1][] = $val['banknumber'];
            $data[$key+1][] = $val['tel'];
            $data[$key+1][] = $val['swiftcode'];
            $data[$key+1][] = $val['userStaus'];
            $data[$key+1][] = date('Y-m-d H:i:s',$val['create_time']);
        }

        $this->push($data,'银行卡审核');
    }


	//银行卡审核
	public function bankExamine()
	{
		$bpid 		= trim(I('post.bpid'));
		$isverified = trim(I('post.isverified'));
		$userid 	= trim(I('post.userid'));

		$uid=islogin();
		if(!$uid)
			outjson(array('code' => 400,'msg' => '请重新登录'));

		if(empty($bpid) || empty($userid))
			outjson(array('code' => 400,'msg' => '参数非法'));

		if($isverified != 1 && $isverified!= 2)
			outjson(array('code' => 400,'msg' => '至少选择一种类型'));


		//审核银行卡之前必须先审核个人资料信息
//		if($isverified == 1)
//		{
//			$personalObj 	= M('personal_user_data');
//
//			$personalData 	= $personalObj->where(array('uid' => $userid,'status' => 1))->find();
//
//			if(!$personalData)
//				outjson(array('code' => 400,'msg' => '请先审核该用户身份信息'));
//		}

		$bankObj = M('bankinfo');

		$res = $bankObj->where(array('uid' => $userid,'bid' => $bpid))->setField('status',$isverified);

		if($res)
			outjson(array('code' => 200,'msg' => '操作成功'));
		else
			outjson(array('code' => 400,'msg' => '操作失败'));
	}



	/**
	 * 身份信息审核
	 */
	public function examine()
	{
		$bpid 		= trim(I('post.bpid'));
		$isverified = trim(I('post.isverified'));
		$userid 	= trim(I('post.userid'));

		if(empty($bpid) || empty($userid))
			outjson(array('code' => 400,'msg' => '参数非法'));

		if($isverified != 1 && $isverified!= 2)
			outjson(array('code' => 400,'msg' => '至少选择一种类型'));

		$uid=islogin();
		if(!$uid)
			outjson(array('code' => 400,'msg' => '请重新登录'));

		$personalObj = M('personal_user_data');

		$res = $personalObj->where(array('uid' => $userid,'id' => $bpid))->setField('status',$isverified);

		//如果审核拒绝旗下银行卡全部作废
		if($res && $isverified == 2)
		{
			M('bankinfo')->where('uid='.$userid)->setField('status',2);
		}


		if($res)
			outjson(array('code' => 200,'msg' => '操作成功'));
		else
			outjson(array('code' => 400,'msg' => '操作失败'));
	}


	public function push($data,$name){
		import("Excel.class.php");
		$excel = new Excel();
		$excel->download($data,$name);
	}

}