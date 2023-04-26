<?php

namespace Admin\Controller;
class SuperController extends BaseController
{

    public function _initialize()
    {
        //判断用户是否登陆
        $user = A('Admin/User');
        $user->checklogin();
    }

    //管理员列表
    public function slist()
    {

        $users = D('userinfo');
        //分页
        $count     = $users->where('otype=3')
                           ->count();
        $pagecount = 20;
        $page      = new \Think\Page($count, $pagecount);
        //        $page->parameter = $row; //此处的row是数组，为了传递查询条件
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '&#8249;');
        $page->setConfig('next', '&#8250;');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();
        //查询用户和账户信息
        $ulist = $users->where('otype=3')
                       ->order('uid desc')
                       ->limit($page->firstRow.','.$page->listRows)
                       ->select();

        //当前角色Id
        $role_id = M('user_role')
            ->field('user_id,role_id')
            ->select();

        foreach ($ulist as $key => $value) {

            $role_id_arr = [];
            foreach ($role_id as $k => $v) {
                if ($value['uid'] == $v['user_id']) {
                    $role_id_arr[] = (int)$v['role_id'];
                }
            }

            $ulist[ $key ]['role_id'] = json_encode($role_id_arr);
        }

        //获取所有角色
        $role = M('role')
            ->field('id,role_name')
            ->order('created_at desc')
            ->select();

        foreach ($role as $key => $value) {
            $role[ $key ]['title'] = $value['role_name'];

            unset($role[ $key ]['role_name']);
        }


        $this->assign('role', json_encode($role));
        $this->assign('page', $show);
        $this->assign('ulist', $ulist);
        $this->display();

    }

    public function loginlog()
    {

        $logger = D('login_log');
        //分页
        $count     = $logger->count();
        $pagecount = 20;
        $page      = new \Think\Page($count, $pagecount);
        //		$page->parameter = $row; //此处的row是数组，为了传递查询条件
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '&#8249;');
        $page->setConfig('next', '&#8250;');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();
        //查询用户和账户信息
        $ulist = $logger->order('id desc')
                        ->limit($page->firstRow.','.$page->listRows)
                        ->select();

        $this->assign('page', $show);
        $this->assign('ulist', $ulist);
        $this->display();
    }


    /**
     * 管理员操作日志
     * by linjuming 2017-4-15
     */
    public function actionlog()
    {
        $logger = D('action_log');


        $where = [];
        if (I('get.id')) {
            $where['id'] = I('get.id');
        }
        if (I('get.uname')) {
            $where['uname'] = I('get.uname');
        }
        if (I('get.action')) {
            $where['action'] = I('get.action');
        }
        if (I('get.request_method')) {
            $where['request_method'] = I('get.request_method');
        }


        // 分页
        $count     = $logger->where($where)
                            ->count();
        $pagecount = 20;
        $page      = new \Think\Page($count, $pagecount);
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '&#8249;');
        $page->setConfig('next', '&#8250;');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();

        // 分页日志数据
        $uslist = $logger->order('id desc')
                         ->where($where)
                         ->limit($page->firstRow.','.$page->listRows)
                         ->select();

        $this->assign('where', $where);
        $this->assign('page', $show);
        $this->assign('ulist', $uslist);
        $this->display();


    }


    //添加管理员
    public function sadd()
    {
        //判断用户是否登陆
        $user = A('Admin/User');
        $user->checklogin();
        //实例化userinfo表
        $users = D('userinfo');
        if (IS_POST) {
            $data['utime']    = time();
            $data['username'] = trim(I('post.username'));
            if (trim(I('post.upwd')) != trim(I('post.upwdqr'))) {
                $this->error('密码不一致');
            }
            $data['upwd']  = md5(trim(I('post.upwd')));
            $data['utel']  = I('post.utel');
            $data['otype'] = 3; //网站管理员
            $result        = $users->add($data);
            if ($result) {
                $this->success('添加管理员成功', U('Super/slist'));
            }
            else {
                $this->error('添加失败');
            }

        }
        else {
            $this->display();
        }
    }

    //修改管理员
    public function sedit()
    {
        //判断用户是否登陆
        $user = A('Admin/User');
        $user->checklogin();

        $users = D('userinfo');
        if (IS_POST) {
            if (I('post.upwd') != I('post.upwdqr')) {
                $this->error('两次密码不一致');
            }

            $uid = I('post.uid');
            //				$data['username'] = I('post.username');
            $data['upwd'] = md5(I('post.upwd'));
            if (empty($data['upwd'])) {
                unset($data['upwd']);
            }
            $data['utel'] = I('post.utel');
            $result       = $users->where('uid='.$uid)
                                  ->save($data);
            if ($result === false) {
                ECHO 'ERROR';
                EXIT();
                $this->error("管理员修改失败！");
            }
            else {
                $this->success("管理员修改成功", U('Super/slist'));
            }
        }
        else {
            //根据修改管理员的id读取数据
            $uid = I('get.uid');
            $ult = $users->where('uid='.$uid)
                         ->find();
            $this->assign('ult', $ult);
            $this->display();
        }
    }

    //删除管理员
    public function sdel()
    {
        $user = D('userinfo');
        //单个删除
        $uid       = I('get.uid');
        $sup_admin = [1];//超级管理员（禁止删除）的uid
        if (in_array($uid, $sup_admin)) {
            $this->error("禁止删除超级管理员");
        }
        $result = $user->where('uid='.$uid)
                       ->delete();
        if ($result !== false) {

            M('user_role')->where(['user_id' => $uid])->delete();

            $this->success("成功删除管理员！", U("Super/slist"));
        }
        else {
            $this->error('删除失败！');
        }
    }


    //基本设置
    public function esystem()
    {
        //判断用户是否登陆
        $user = A('Admin/User');
        $user->checklogin();
        $config  = D('webconfig');
        $isopen  = I('post.isopen');
        $webname = I('post.webname');
        $notice  = I('post.notice');
        $tel     = I('post.tel');
        $gold    = I('post.gold');
        $where   = "id=1";
        if ($isopen != "") {
            if ($isopen == 0) {
                $config->where($where)
                       ->setField('isopen', '1');

                $this->ajaxReturn("开启成功");
            }
            else {
                $config->where($where)
                       ->setField('isopen', '0');
                $this->ajaxReturn("关闭成功");
            }
        }
        elseif ($webname != "") {
            $result = $config->where($where)
                             ->setField('webname', $webname);
            if ($result) {
                $this->ajaxReturn("修改成功");
            }
            else {
                $this->ajaxReturn("修改失败");
            }
        }
        elseif ($notice != "") {
            $result = $config->where($where)
                             ->setField('notice', $notice);
            if ($result) {
                $this->ajaxReturn("修改成功");
            }
            else {
                $this->ajaxReturn("修改失败");
            }
        }
        elseif ($tel != "") {
            $result = $config->where($where)
                             ->setField('tel', $tel);
            if ($result) {
                $this->ajaxReturn("修改成功");
            }
            else {
                $this->ajaxReturn("修改失败");
            }
        }
        elseif ($gold != "") {
            $result = $config->where($where)
                             ->setField('gold', $gold);
            if ($result) {
                $this->ajaxReturn("修改成功");
            }
            else {
                $this->ajaxReturn("修改失败");
            }
        }
        else {
            $conf = $config->where($where)
                           ->find();
            $this->assign('conf', $conf);
        }
        $this->display();
    }


    //角色设置
    public function role_setting()
    {
        $role_id = trim(I('post.role_id'));
        $uid     = trim(I('post.uid'));

        if (empty($uid)) {
            $data['status'] = 0;
            $data['msg']    = '用户不存在';
            $this->ajaxReturn($data, 'JSON');
        }

        $data = stripslashes(html_entity_decode($role_id)); //$info是传递过来的json字符串
        $data = json_decode($data, true);

        $role_id = array_unique(array_column($data, 'id'));

        M('user_role')
            ->where(['user_id' => $uid])
            ->delete();

        if (!empty($role_id)) {

            $insert = [];
            foreach ($role_id as $key => $value) {
                $insert['role_id']      = $value;
                $insert['user_id']      = $uid;
                $insert['created_date'] = date('Y-m-d H:i:s');
                $insert['updated_at']   = date('Y-m-d H:i:s');

                M('user_role')->add($insert);
            }
        }

        $data['status'] = 1;
        $data['msg']    = '操作成功';
        $this->ajaxReturn($data, 'JSON');
    }
}