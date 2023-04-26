<?php

namespace Agent\Controller;
use Think\Controller;


class CommonController extends Controller
{

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
            $this->error('请先登录',U('/Agent/login'));
        }

        define('NOW_UID', $_SESSION['cuid']);
        define('NOW_USER_TYPE', session('userotype'));
        define('PAGE_SIZE', 15);


        $this->assign('nowMenu', strtolower(CONTROLLER_NAME));
        $this->assign('nowAct', strtolower(ACTION_NAME));
        $this->assign('user_nickname', session('new_nickname'));


        //判断代理商当前星级
        $prefix = C('DB_PREFIX');
        $levels  = M('userinfo as a')->where('a.uid='.NOW_UID)->join('inner join '.$prefix.'userinfo_rate b on a.extension_level = b.id')->getField('b.name');

        $this->assign('levels',$levels);

    }
}