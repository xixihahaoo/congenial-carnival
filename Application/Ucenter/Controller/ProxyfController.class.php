<?php
/**
 * @author: FrankHong
 * @datetime: 2016-12-12 09:58:30
 * @filename: ProxyfController.class.php
 * @description: 运营中心信息模块
 * @note:
 *
 */

namespace Ucenter\Controller;


class ProxyfController extends CommonController
{

    /**
     * @functionname: sys_info
     * @author: FrankHong
     * @date: 2016-12-12 09:58:40
     * @description: 个人信息
     * @note:
     */
    public function sys_info()
    {
        $userinfoObj        = M('userinfo');
        $userInfoWhere      = 'uid='.NOW_UID;
        $userInfoRs         = $userinfoObj->where($userInfoWhere)->find();

        $this->assign('userInfo', $userInfoRs);
        $this->assign('now_user_id', NOW_UID);
        $this->display();
    }


    /**
     * @functionname: opt_sys_info
     * @author: FrankHong
     * @date: 2016-12-12 11:58:47
     * @description: 处理运营中心信息保存
     * @note:
     */
    public function opt_sys_info()
    {
        $userId     = I('post.now_user_id');

        $nickname   = I('post.nickname', '');

        if(!$userId || $userId != NOW_UID)
            outjson(array('status' => 0, 'ret_msg' => '系统错误'));

        if(!$nickname)
            outjson(array('status' => 0, 'ret_msg' => '不能为空'));

        $dataArr    = array();


        $dataArr['nickname']    = $nickname;
        $dataArr['update_time'] = time();

        $userinfoObj    = M('userinfo');
        $whereStr       = 'uid=' . NOW_UID;
        $userinfoRs     = $userinfoObj->where($whereStr)->find();


        if (!$userinfoRs)
        {
            outjson(array('status' => 0, 'ret_msg' => '系统错误：未查询到信息！'));
        }
        else
        {
            $flag   = $userinfoObj->where($whereStr)->save($dataArr);
            if($flag)
                outjson(array('status' => 1, 'ret_msg' => '保存成功'));
            else
                outjson(array('status' => 0, 'ret_msg' => '保存失败！'));
        }

    }

    /**
     * @functionname: change_password
     * @author: FrankHong
     * @date: 2016-12-12 10:43:02
     * @description: 运营中心修改后台密码
     * @note:
     */
    public function change_password()
    {
        if(!NOW_UID)
        {
            $this->display('Common/error_no_info');
            die();
        }

        $userinfoObj        = M('userinfo');
        $userInfoWhere      = 'uid='.NOW_UID;
        $userInfoRs         = $userinfoObj->where($userInfoWhere)->find();

        $this->assign('userInfo', $userInfoRs);
        $this->assign('now_user_id', NOW_UID);
        $this->display();
    }

    /**
     * @functionname: opt_change_password
     * @author: FrankHong
     * @date: 2016-12-12 10:48:02
     * @description: 处理修改密码
     * @note:
     */
    public function opt_change_password()
    {
        $password   = I('post.password'. '');
        $rpassword  = I('post.rpassword'. '');
        $nowUserId  = I('post.now_user_id'. '');

        if(NOW_UID != $nowUserId)
            outjson(array('status' => 0, 'ret_msg' => '系统错误'));

        if(!$password || !$rpassword)
            outjson(array('status' => 0, 'ret_msg' => '两次输入的密码不一样'));

        if($password != $rpassword)
            outjson(array('status' => 0, 'ret_msg' => '两次输入的密码不一样'));

        $userinfoObj        = M('userinfo');
        $dataArr            = array(
            'upwd'  => md5($password)
        );
        $userInfoWhere      = 'uid='.NOW_UID;
        $flag               = $userinfoObj->where($userInfoWhere)->save($dataArr);

        if($flag)
            outjson(array('status' => 1, 'ret_msg' => '密码修改成功！'));
        else
            outjson(array('status' => 0, 'ret_msg' => '密码修改失败！'));

    }
}