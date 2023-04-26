<?php
/**
 * @author: FrankHong
 * @datetime: 2016-12-12 15:15:58
 * @filename: AgentsController.class.php
 * @description: 经纪人管理模块，修改密码、查看二维码等
 * @note:
 *
 */

namespace Ucenter\Controller;


class AgentsController extends CommonController
{



    /**
     * @functionname: change_password
     * @author: FrankHong
     * @date: 2016-12-12 10:43:02
     * @description: 经纪人修改后台密码
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
        $nickname   = I('post.nickname'. '');

        if(NOW_UID != $nowUserId)
            outjson(array('status' => 0, 'ret_msg' => '系统错误'));

        if(!$password || !$rpassword)
            outjson(array('status' => 0, 'ret_msg' => '两次输入的密码不一样'));

        if($password != $rpassword)
            outjson(array('status' => 0, 'ret_msg' => '两次输入的密码不一样'));

        $userinfoObj        = M('userinfo');
        $dataArr            = array(
            'upwd'          => md5($password),
            'nickname'      => $nickname,
            'update_time'   => time()
        );
        $userInfoWhere      = 'uid='.NOW_UID;
        $flag               = $userinfoObj->where($userInfoWhere)->save($dataArr);

        if($flag)
            outjson(array('status' => 1, 'ret_msg' => '修改成功！'));

    }


    /**
     * @functionname: tuiguang_erweima
     * @author: FrankHong
     * @date: 2016-12-12 15:58:49
     * @description:
     * @note:
     */
    public function tuiguang_erweima()
    {

        $whereArr   = array(
            'uid'   => NOW_UID
        );

        $userinfoObj    = M('userinfo');
        $userinfoRs     = $userinfoObj->where($whereArr)->find();

        if(empty($userinfoRs['code']))
        {   
            $code = generate_code(4);
            $userinfoObj->where($whereArr)->setField('code',$code);
        } else {
            $code = $userinfoRs['code'];
        }

        $systemDomain   = 'http://'.$_SERVER['HTTP_HOST'].'/Home/invatation/'.$code;

        $this->assign('systemDomain', $systemDomain);

        $this->display();
    }



}