<?php
namespace Pc\Controller;

use Think\Controller;

class LoginController extends Controller
{
    /**
     * [login 登录]
     * @author wang li
     */
    public function login()
    {
        if (IS_AJAX) {
            $data     = [];
            $email    = trim(I("post.email"));
            $password = trim(I('post.password'));
            if (empty($email)) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_input_email'),
                ]);
            }

            if (empty($password)) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_input_pwd'),
                ]);
            }

            $userObj = M('userinfo');

            $where['email'] = $email;
            $where['otype'] = 4;

            $user = $userObj->where($where)
                            ->find();

            if ($user['ustatus'] == 1) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_frozen'),
                ]);
            }

            if (!$user) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_no_user'),
                ]);
            }


            if ($user['upwd'] != md5($password)) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_incorrect_pwd'),
                ]);
            }

            $_SESSION['user_id']  = $user['uid'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['utel']     = $user['utel'];

            if (session('user_id')) {
                setcookie("username", $user['email'], (time() + 24 * 60 * 60) * 15, '/');
                setcookie("user_id", $user['uid'], (time() + 24 * 60 * 60) * 15, '/');

                $map['lastlog']       = time();
                $map['last_login_ip'] = get_client_ip();                            //最后登录ip
                $userObj->where(['uid' => session('user_id')])
                        ->save($map);    //用户最后登录时间

                outjson([
                    'code' => 200,
                    'msg'  => L('api_success'),
                ]);
            }
            else {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_fail'),
                ]);
            }

        }
        else {

            $username = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';
            $this->assign('username', $username);
            $this->display('login');
        }
    }


    /**
     * 退出登录
     * @author wang <li>
     */

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['utel']);

        setcookie('user_id', '', time() - 3600, '/');
        $this->redirect('Index/index');
    }

}