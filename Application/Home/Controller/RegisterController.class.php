<?php
namespace Home\Controller;

use Think\Controller;

class RegisterController extends Controller
{


    /**
     * 用户注册
     * @author wang <li>
     */
    public function reg()
    {
        $code = trim(I('get.code'));

        $this->assign('code', $code);
        $this->display();
    }


    /**
     * 用户注册
     * @author wang <li>
     */

    public function register()
    {
        $email    = trim(I('post.email'));
        $password = trim(I('post.password'));
        $smscode  = trim(I('post.smscode'));
        $code     = trim(I('post.code'));

        $userObj = M('userinfo');

        if (empty($email)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_mailbox_cannot'),
            ]);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_mailbox_error'),
            ]);
        }
        if(empty($code)){
            outjson([
                'code' => 400,
                'msg'  => 'Please fill in the promotion code',
            ]);
        }
        if (empty($smscode)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_verification'),
            ]);
        }

        if (empty($password)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_login_password'),
            ]);
        }

        if (trim($smscode) != session('email_code')) {
            outjson([
                'code' => 400,
                'msg'  => L('api_code_incorrect'),
            ]);
        }


        if (M('userinfo')
            ->where('email='.$email.' and ustatus in(0,1) and otype=4')
            ->find()) {
            outjson([
                'code' => 400,
                'msg'  => L('api_mailbox_has'),
            ]);
        }

        if (!empty($code)) {
            $agent = $userObj->field('uid,otype')
                             ->where([
                                 'code'    => $code,
                                 'ustatus' => 0,
                                 'otype'   => [
                                     'in',
                                     '4,6',
                                 ],
                             ])
                             ->find();

            if (!$agent) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_promotion_not'),
                ]);
            }

        }
        else {
            $agent = [];
        }


        //判断是否已经有删除的
        $uid = $userObj->where([
            'email'   => $email,
            'ustatus' => 2,
            'otype'   => 4,
        ])
                       ->getField('uid');

        if ($uid) {
            $userObj->where('uid='.$uid)
                    ->delete();
            M('accountinfo')
                ->where('uid='.$uid)
                ->delete();
            M('bankinfo')
                ->where('uid='.$uid)
                ->delete();
            M('UserinfoRelationship')
                ->where('user_id='.$uid)
                ->delete();
            M("PersonalUserData")
                ->where('user_id='.$uid)
                ->delete();
        }

        $accountinfo          = M("accountinfo");
        $UserinfoRelationship = M("UserinfoRelationship");

        //用户上两级
        if ($agent['otype'] == 4) {
            $agent_id     = $UserinfoRelationship->where(['user_id' => $agent['uid']])
                                                 ->getField('parent_user_id');  //获取代理id
            $extension_id = $UserinfoRelationship->where(['user_id' => $agent_id])
                                                 ->getField('parent_user_id');            //获取运营中心id
            $map['rid']   = $agent['uid'];  //推广人id
        }
        elseif ($agent['otype'] == 6) {
            $agent_id     = $agent['uid'];                                                                                  //获取代理id
            $extension_id = $UserinfoRelationship->where(['user_id' => $agent_id])
                                                 ->getField('parent_user_id');      //获取运营中心id
        }
        else {
            //获取默认销售商
            $agent_id = $userObj->where([
                'otype'      => 6,
                'is_default' => 1,
            ])
                                ->getField('uid');
            if (empty($agent_id)) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_promotion_not'),
                ]);
            }

            $extension_id = $UserinfoRelationship->where('user_id='.$agent_id)
                                                 ->getField('parent_user_id');
        }

        $userObj->startTrans();

        $map['username']    = $email;
        $map['upwd']        = md5($password);
        $map['utel']        = '';
        $map['email']       = $email;
        $map['utime']       = time();
        $map['update_time'] = time();
        $map['otype']       = 4;
        $map['ustatus']     = 0;
        $map['nickname']    = generate_code(8).'';//用户昵称
        $map['reg_ip']      = get_client_ip();    //用户注册ip
        $map['level_id']    = 1;
        $map['face']        = 'http://'.$_SERVER['HTTP_HOST'].'/Uploads/face/1499222434250.png';
        $result             = $userObj->add($map);

        $account['uid']  = $result;
        $account['gold'] = gold();  //赠送金币
        $info            = $accountinfo->add($account);

        //用户关系表

        $rela['user_id']        = $result;
        $rela['parent_user_id'] = $agent_id;
        $rela['all_path']       = $extension_id.'_'.$agent_id.'_'.$result;
        $ship                   = $UserinfoRelationship->add($rela);

        if ($result && $info && $ship) {
            $userObj->commit(); //对数据库的操作
            session('email_code',null);

            outjson([
                'code' => 200,
                'msg'  => L('api_success'),
            ]);
        }
        else {
            $userObj->rollback(); //回滚处理
            outjson([
                'code' => 400,
                'msg'  => L('api_fail'),
            ]);
        }
    }


    /**
     * 忘记密码
     * @author wang <li>
     */

    public function outpwd()
    {
        if (IS_AJAX) {

            $email    = trim(I('post.email'));
            $password = trim(I('post.password'));
            $smscode  = trim(I('post.smscode'));

            if (empty($email)) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_mailbox_cannot'),
                ]);
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_mailbox_error'),
                ]);
            }

            if (empty($smscode)) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_mailbox_error'),
                ]);
            }

            if (empty($password)) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_login_password'),
                ]);
            }

            if ($smscode != session('pwd_email_code')) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_code_incorrect'),
                ]);
            }

            $map['email']   = $email;
            $map['ustatus'] = [
                'in',
                '0,1',
            ];
            $map['otype']   = 4;

            $user = M("userinfo")
                ->where($map)
                ->find();

            if (!$user) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_user_not'),
                ]);
            }

            if ($user['ustatus'] == 1) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_users_frozen'),
                ]);
            }

            $where['email']   = $email;
            $where['ustatus'] = [
                'in',
                '0',
            ];

            $password = md5($password);

            $res = M('userinfo')
                ->where($where)
                ->setField('upwd', $password);

            if ($res) {
                session('pwd_email_code',null);

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
            $this->display();
        }
    }


    /**
     * [regAgreement 注册协议]
     * @author wang li
     */
    public function regAgreement()
    {
        $lang = cookie('think_language');

        if ($lang == 'zh-tw') {
            $lang_show = 'zh-cn';
        }
        else {
            $lang_show = $lang;
        }

        $catagory = M('newsclass')
            ->where('fid=15')
            ->getField('fid');

        $news = M('newsinfo')
            ->field('ntitle,ncontent')
            ->where([
                'ncategory' => $catagory,
                'lang'      => $lang_show,
            ])
            ->find();

        $news['ncontent'] = html_entity_decode($news['ncontent']);

        if ($lang == 'zh-tw') {
            $news['ntitle']   = simpleTradition($news['ntitle']);
            $news['ncontent'] = simpleTradition($news['ncontent']);
        }

        $this->assign('news', $news);
        $this->display();
    }

    //app外的注册
    public function outsideReg()
    {
        $code = trim(I('get.code'));

        if (empty($code)) {
            die(L('api_suspend'));
        }

        $userObj = M('userinfo');
        $info    = $userObj->field('code')
                           ->where('code='."'$code'")
                           ->find();

        if (!$info) {
            die(L('api_suspend'));
        }

        //判断手机类型
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')) {
            $download = 'http://'.$_SERVER['HTTP_HOST'];
        }
        elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) {
            $download = 'http://'.$_SERVER['HTTP_HOST'];
        }
        else {
            $download = 'http://'.$_SERVER['HTTP_HOST'];
        }

        $this->assign('download', $download);
        $this->assign('code', $code);
        $this->display();
    }

}