<?php
namespace Pc\Controller;

use Think\Controller;
use Org\Util\Log;


class SettingController extends CommonController
{

    public function _initialize()
    {
        parent::_initialize();
        $this->user_id = session('user_id');
    }


    //账户设置
    public function index()
    {
        $userModel = M('userinfo');

        $user = $userModel->field('utel,auto_order,email')
                          ->where(['uid' => $this->user_id])
                          ->find();

        $user['utel'] = substr_replace($user['utel'], '****', 3, 4);

        $this->assign('user', $user);
        $this->display();
    }


    //设置手机号
    public function bindPhone()
    {
        self::IsLogin();
        $userModel = M('userinfo');
        $phone     = $userModel->where(['uid' => $this->user_id])
                               ->getField('utel');

        $this->assign('phone', substr_replace($phone, '****', 3, 4));
        $this->assign('mobile', $phone);
        $this->display();
    }

    /**
     * [verifMobile 手机号验证]
     * @author wang li
     */
    public function verifMobile()
    {
        self::IsLogin();

        if (IS_AJAX) {
            $mobile  = trim(I('post.mobile'));
            $smscode = trim(I('post.smscode'));

            if (empty($mobile)) {
                outjson([
                    'code' => 400,
                    'msg'  => '手机号不能为空',
                ]);
            }

            if (!preg_match('/^(13[0-9]|15[012356789]|1[78][0-9]|14[57])[0-9]{8}$/', $mobile)) {
                outjson([
                    'code' => 400,
                    'msg'  => '手机号格式错误',
                ]);
            }

            if (empty($smscode)) {
                outjson([
                    'code' => 400,
                    'msg'  => '短信验证码不能为空',
                ]);
            }

            if (trim($smscode) != session('mobile_code')) {
                outjson([
                    'code' => 400,
                    'msg'  => '短信验证码不正确',
                ]);
            }

            $sms_token = md5($mobile.$smscode);
            session('sms_token', $sms_token);
            outjson([
                'code'      => 200,
                'msg'       => '验证通过',
                'sms_token' => $sms_token,
            ]);
        }
    }


    /**
     * [BindNewMobile 绑定新手机号]
     * @author wang li
     */
    public function BindNewMobile()
    {
        self::IsLogin();

        if (IS_AJAX) {
            $mobile    = trim(I('post.mobile'));
            $smscode   = trim(I('post.smscode'));
            $sms_token = trim(I('post.sms_token'));

            if (empty($mobile)) {
                outjson([
                    'code' => 400,
                    'msg'  => '手机号不能为空',
                ]);
            }

            if (!preg_match('/^(13[0-9]|15[012356789]|1[78][0-9]|14[57])[0-9]{8}$/', $mobile)) {
                outjson([
                    'code' => 400,
                    'msg'  => '手机号格式错误',
                ]);
            }

            if (empty($sms_token)) {
                outjson([
                    'code' => 400,
                    'msg'  => '验证token不存在',
                ]);
            }

            if ($sms_token != session('sms_token')) {
                outjson([
                    'code' => 400,
                    'msg'  => 'token验证失败',
                ]);
            }

            if (empty($smscode)) {
                outjson([
                    'code' => 400,
                    'msg'  => '短信验证码不能为空',
                ]);
            }

            if (trim($smscode) != session('mobile_code')) {
                outjson([
                    'code' => 400,
                    'msg'  => '短信验证码不正确',
                ]);
            }

            $userObj = M('userinfo');

            $dataArr = [
                'username' => $mobile,
                'utel'     => $mobile,
            ];
            $res     = $userObj->where(['uid' => $this->user_id])
                               ->save($dataArr);

            if ($res) {
                outjson([
                    'code' => 200,
                    'msg'  => '修改成功',
                ]);
            }
            else {
                outjson([
                    'code' => 400,
                    'msg'  => '修改失败',
                ]);
            }

        }
        else {

            $sms_token = trim(I('get.sms_token'));
            $this->assign('sms_token', $sms_token);
            $this->display();
        }
    }

    /**
     * [BindNewMobile 绑定新邮箱]
     * @author wang li
     */
    public function BindEmail()
    {
        if (IS_AJAX) {

            outjson([
                'code' => 400,
                'msg'  => 'error',
            ]);

            $email   = trim(I('post.email'));
            $smscode = trim(I('post.smscode'));

            if (empty($email)) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_mailbox_cannot'),
                ]);
            }

            if (empty($smscode)) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_verification'),
                ]);
            }

            if ($smscode != session('email_code')) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_code_incorrect'),
                ]);
            }

            $userObj = M('userinfo');

            if ($userObj->where('email='.$email.' and otype=4')
                        ->find()) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_mailbox_has'),
                ]);
            }

            $res = $userObj->where(['uid' => $this->user_id])
                           ->setField('email', $email);

            if (!$res) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_fail'),
                ]);
            }

            outjson([
                'code' => 200,
                'msg'  => L('api_success'),
            ]);

        }
        else {
            $this->display();
        }
    }


    /**
     * [modifyLoginPwd 修改登录密码]
     * @author wang li
     */
    public function modifyLoginPwd()
    {
        self::IsLogin();

        if (IS_AJAX) {
            $password    = trim(I('post.password'));
            $newpassword = trim(I('post.newpassword'));

            if (empty($password)) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_old_pwd_not'),
                ]);
            }

            if (empty($newpassword)) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_new_pwd_not'),
                ]);
            }

            $password    = md5(trim(I('post.password')));
            $newpassword = md5(trim(I('post.newpassword')));

            $userObj = M('userinfo');

            $upwd = $userObj->where(['uid' => $this->user_id])
                            ->getField('upwd');

            if ($password != $upwd) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_old_pwd_incorrect'),
                ]);
            }

            $res = $userObj->where(['uid' => $this->user_id])
                           ->setField('upwd', $newpassword);

            if ($res) {
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
     * [autoOrder 自动晒单]
     * @author wang li
     */
    public function autoOrder()
    {
        self::IsLogin();

        if (IS_AJAX) {
            $userObj = M('userinfo');

            $auto_order = $userObj->where(['uid' => $this->user_id])
                                  ->getField('auto_order');

            $auto_order = $auto_order == 1 ? 2 : 1;

            $res = $userObj->where(['uid' => $this->user_id])
                           ->setField('auto_order', $auto_order);

            if ($res) {
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

    }


    //关于我们
    public function aboutwe()
    {
        $fid  = M('newsclass')
            ->where(['fid' => 22])
            ->getField('fid');
        $info = M('newsinfo')
            ->field('nid,ntitle')
            ->where(['ncategory' => $fid,'lang' => LANG_SHOW])
            ->select();

        if(LANG == 'zh-tw') {
            foreach ($info as $key => $val) {
                $info[$key]['ntitle'] = simpleTradition($val['ntitle']);
            }
        }

        $this->assign('info', $info);

        //用户信息
        $userModel = D('userinfo');
        $user      = $userModel->getDataFind($this->user_id);
        $this->assign('user', $user);

        $accountModel = M('accountinfo');
        $account      = $accountModel->field('balance,gold')
                                     ->where(['uid' => $user['uid']])
                                     ->find();
        $this->assign('account', $account);

        $personalObj = M('personal_user_data');
        $personal    = $personalObj->where(['uid' => $this->user_id])
                                   ->find();
        $this->assign('personal', $personal);

        $userModel     = M('userinfo');
        $personalModel = M('personal_user_data');

        //个人资料
        $personal = $personalModel->field('province,city')
                                  ->where(['uid' => $this->user_id])
                                  ->find();

        $cityModel = M('city');
        //省
        $province = $cityModel->field('id,joinname')
                              ->where(['level' => 1])
                              ->order('id')
                              ->select();
        //市
        $city_id = !empty($personal['province']) ? $personal['province'] : $province[0]['id'];

        $city = $cityModel->field('id,name')
                          ->where([
                              'level'     => 2,
                              'parent_id' => $city_id,
                          ])
                          ->select();

        $this->assign('city', $city);
        $this->assign('province', $province);
        $this->assign('personal', $personal);

        $bankObj     = M('bankinfo');
        $personalObj = M('personal_user_data a');

        $prefix = C('DB_PREFIX');

        $personal = $personalObj->field('a.real_name,a.card,a.status,b.face')
                                ->where(['a.uid' => $this->user_id])
                                ->join('right join '.$prefix.'userinfo b on a.uid=b.uid')
                                ->find();

        $personal['face'] = !empty($personal['face']) ? $personal['face'] : '/Public/Qts/Home/img/me/1499222434250.png';
        $personal['card'] = substr_replace($personal['card'], '**********', 4, 10);

        $map['uid']    = $this->user_id;
        $map['status'] = [
            'in',
            '0,1',
        ];

        $bank = $bankObj->field('bid,bankname,banknumber,busername,status')
                        ->where($map)
                        ->select();

        foreach ($bank as $key => $value) {
            $bank[$key]['banknumber'] = substr_replace($value['banknumber'], '**** **** **** ', 0, 12);
        }


        $this->assign('personal', $personal);
        $this->assign('bank', $bank);


        $this->display();
    }

    //关于我们文章详情
    public function details()
    {
        $nid = trim(I('get.nid', ''));

        $info = M('newsinfo')
            ->field('nid,ntitle,ncontent')
            ->where(['nid' => $nid])
            ->find();

        $info['ncontent'] = html_entity_decode($info['ncontent']);

        if(LANG == 'zh-tw') {
            $info['ntitle']     = simpleTradition($info['ntitle']);
            $info['ncontent']   = simpleTradition($info['ncontent']);
        }


        $this->assign('info', $info);
        $this->display();
    }



    //判断是否登录
    private function IsLogin()
    {
        if (empty($this->user_id)) {
            if (IS_AJAX) {
                outjson([
                    'code' => 400,
                    'msg'  => L('no_login'),
                ]);
            }
            else {
                $this->redirect('Login/login');
            }
        }
    }


}
