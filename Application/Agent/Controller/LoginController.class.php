<?php

namespace Agent\Controller;
use Think\Controller;
class LoginController extends Controller {

	//管理员登陆
	public function login()
	{
	 	if(IS_POST){

	 		//设置session周期
	 		ini_set('session.gc_maxlifetime', "1800"); // 秒  
			ini_set("session.cookie_lifetime","1800"); // 秒  

	 		header("Content-type: text/html; charset=utf-8");
			$user = D("userinfo");
				
			//查询条件
			$where = array();
			$where['email'] 	= I('post.username');
			$where['ustatus'] 	= 0;
			$where['otype']		= 4;
			$where['code']		= array('exp','is not null');
			$result = $user->where($where)->field("uid,upwd,username,nickname,email,utel,utime,otype,ustatus")->find();
			
			//验证用户
			if(empty($result)){
				$this->error('登录失败,用户名不存在!');
			}else{
				$map['lastlog'] = time();
                $map['last_login_ip']   = get_client_ip();
				M('userinfo')->where('uid='.$result['uid'])->save($map);


				if($result['upwd'] == md5(I('post.password'))){
					$logData = array(
						'cTime'=> date('Y-m-d H:i:s',$map['lastlog']),
						'uname'=>$result['username'],
						'uid'=>$result['uid'],
						'ip'=>$map['last_login_ip'],
						'status'=>1
					);
			
					if ($result['otype']==4&&$result['ustatus']==0)
					{
						session('cuid',$result['uid']);
						session('userotype',$result['otype']);
						session('username',$result['username']);
						session('new_nickname',$result['nickname']);
						$loginSign = M("login_log")->add($logData);
						session('login_sign', $loginSign);
						$this->success('登录成功,正跳转至系统代理商首页...', U('Agent/index/index'));
					}
					else{
						$logData['status'] = 0;
						M("login_log")->add($logData);
						$this->error('登录失败,用户名不存在!');
					}
				}
                else
                {
                    $this->error('登录失败,密码错误！');
                }
			}
	 	}else{
	 		$this->display();
		}
	}

    /**
     * 用户注销
     */
    public function login_out()
    {
        header("Content-type: text/html; charset=utf-8");
        session(null);
        redirect(U('login'), 2, '正在退出登录...');
    }
}