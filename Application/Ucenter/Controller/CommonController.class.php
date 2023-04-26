<?php

namespace UCenter\Controller;
use Think\Controller;


class CommonController extends Controller
{

    /**
     * @var array
     * 当前通过f和s区分运营中心和代理
     *
     * f：first 运营中心
     * s：second 代理
     */
    public $userTypeArr = array(
        'f' => 5,
        's' => 6
    );


    /**
     * @functionname: _initialize
     * @author: FrankHong
     * @date: 2016-11-30 14:52:18
     * @description:
     * @note:
     */
    public function _initialize()
    {
        //判断用户是否已经登录
        if (!isset($_SESSION['cuid']))
        {
            $this->redirect('Admin/User/signin');
        }

        define('NOW_UID', $_SESSION['cuid']);
        define('NOW_USER_TYPE', session('userotype'));
        define('PAGE_SIZE', 15);


        //vD(CONTROLLER_NAME.'->'.ACTION_NAME);

        $this->assign('nowMenu', strtolower(CONTROLLER_NAME));
        $this->assign('nowAct', strtolower(ACTION_NAME));
        $this->assign('user_nickname', session('new_nickname'));



        //权限不足，则退出
        $this->check_user_type();

    }

    /**
     * @functionname: check_user_type
     * @author: FrankHong
     * @date: 2016-11-30 14:53:25
     * @description: 判断用户的类型
     * @note: 5 运营中心 6 代理商
     */
    public function check_user_type()
    {
        $userType   = substr(CONTROLLER_NAME, -1);

        if($this->userTypeArr[$userType] != intval(NOW_USER_TYPE))
        {
            session('');
            $this->error('系统错误','/login/User/signin');
        }
    }


}