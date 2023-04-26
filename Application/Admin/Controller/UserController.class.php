<?php

namespace Admin\Controller;
vendor('googleAuth.GoogleAuthenticator-master.PHPGangsta.GoogleAuthenticator');

class UserController extends BaseController
{

    private $secret = 'YD2HX4K44VFVH7PO'; //谷歌验证生成的唯一秘钥
    private $time   = 1; //超时时间 1*30s

    //管理员登陆
    public function signin()
    {
        if (IS_POST) {

            //设置session周期
            ini_set('session.gc_maxlifetime', "3600"); // 秒
            ini_set("session.cookie_lifetime", "3600"); // 秒

            header("Content-type: text/html; charset=utf-8");
            $user = D("userinfo");

            //查询条件
            $where             = [];
            $where['username'] = I('post.username');
            $where['ustatus']  = 0;
            $result            = $user->where($where)
                                      ->field("uid,upwd,username,nickname,utel,utime,otype,ustatus,is_admin")
                                      ->find();

            //验证用户
            if (empty($result)) {
                $this->error('登录失败,用户名不存在!');
            }
            else {
                $map['lastlog']       = time();
                $map['last_login_ip'] = get_client_ip();
                M('userinfo')
                    ->where('username ="'.I('post.username').'"')
                    ->save($map);


                if ($result['upwd'] == md5(I('post.password'))) {
                    $logData = [
                        'cTime'  => date('Y-m-d H:i:s', $map['lastlog']),
                        'uname'  => $result['username'],
                        'uid'    => $result['uid'],
                        'ip'     => $map['last_login_ip'],
                        'status' => 1,
                    ];

                    if ($result['otype'] == 3 && $result['ustatus'] == 0) {

                        session('auth_user',['time_out' => time()+300,'uid' => $result['uid']]);
                        redirect(U('User/GoogleAuth'));

                        //                        session('userid', $result['uid']);
                        //                        session('userotype', $result['otype']);
                        //                        session('username', $result['username']);
                        //                        $loginSign = M("login_log")->add($logData);
                        //                        session('login_sign', $loginSign);
                        //
                        //                        //获取菜单
                        //
                        //                        if($result['is_admin'] == 1) {
                        //                            $user_role = M('user_role')
                        //                                ->field('role_id')
                        //                                ->where(['user_id' => $result['uid']])
                        //                                ->select();
                        //                            $role_id   = array_unique(array_column($user_role, 'role_id'));
                        //                            $role_menu = M('role_menu')
                        //                                ->field('menu_id')
                        //                                ->where([
                        //                                    'role_id' => [
                        //                                        'in',
                        //                                        $role_id,
                        //                                    ],
                        //                                ])
                        //                                ->select();
                        //                            $menu_id   = array_unique(array_column($role_menu, 'menu_id'));
                        //                            $menu       = $this->get_menu($menu_id);
                        //                        } else {
                        //                            $menu = $this->get_all_menu();
                        //                        }
                        //
                        //                        $url_prefix = array_keys(C('URL_MODULE_MAP'))[0];
                        //
                        //                        foreach ($menu as $key => $value) {
                        //                            $menu[$key]['url'] = '/'.$url_prefix.'/'.$value['controller'].'/'.$value['method'].$value['param'];
                        //                        }
                        //
                        //                        $menus = $this->admin_menus($menu);
                        //
                        //                        session('menus', json_encode($menus));
                        //
                        //                        $this->success('登录成功,正跳转至系统管理员首页...', U('admin/Index/index'));
                    }
                    elseif ($result['otype'] == 5 && $result['ustatus'] == 0) {
                        session('cuid', $result['uid']);
                        session('newusername', $result['username']);
                        session('userotype', $result['otype']);
                        session('new_nickname', $result['nickname']);
                        $loginSign = M("login_log")->add($logData);
                        session('login_sign', $loginSign);
                        $this->success('登录成功,正跳转至运营中心管理后台首页...', U('Ucenter/indexf/index'));
                    }
                    elseif ($result['otype'] == 6 && $result['ustatus'] == 0) {
                        session('cuid', $result['uid']);
                        session('newusername', $result['username']);
                        session('new_nickname', $result['nickname']);
                        session('userotype', $result['otype']);
                        M("login_log")->add($logData);
                        $this->success('登录成功,正跳转至销售商管理后台首页...', U('Ucenter/indexs/index'));
                    }
                    else {
                        $logData['status'] = 0;
                        M("login_log")->add($logData);
                        $this->error('登录失败,用户名不存在!');
                    }
                }
                else {
                    $this->error('登录失败,密码错误！');
                }
            }
        }
        else {
            $this->display();
        }
    }

    /**
     * 谷歌验证器
     */
    public function GoogleAuth()
    {
        $user_session = $_SESSION['auth_user'];

        if(empty($user_session)) {
            $this->error('登录超时，请重新输入用户名及密码',U('User/signin'));
        }

        if($user_session['time_out'] < time()) {
            session(null);
            $this->error('登录超时，请重新输入用户名及密码',U('User/signin'));
        }

        $uid = $user_session['uid'];

        if (IS_POST) {

            $ga = new \PHPGangsta_GoogleAuthenticator();

            //设置session周期
            ini_set('session.gc_maxlifetime', "3600"); // 秒
            ini_set("session.cookie_lifetime", "3600"); // 秒

            header("Content-type: text/html; charset=utf-8");

            //下面为验证参数
            $code = I('post.code');

            if(empty($code)) {
                $this->error('请输入验证码');
            }

            //验证用户提交的验证码是否正确
            $checkResult = $ga->verifyCode($this->secret, $code, $this->time);

            if (!$checkResult) {

                $user = D("userinfo");

                $result = $user->where(['uid' => $uid])
                               ->field("uid,upwd,username,nickname,utel,utime,otype,ustatus,is_admin")
                               ->find();

                if ($result['otype'] == 3 && $result['ustatus'] == 0) {

                    $map['lastlog']       = time();
                    $map['last_login_ip'] = get_client_ip();

                    $logData = [
                        'cTime'  => date('Y-m-d H:i:s', $map['lastlog']),
                        'uname'  => $result['username'],
                        'uid'    => $result['uid'],
                        'ip'     => $map['last_login_ip'],
                        'status' => 1,
                    ];

                    session('userid', $result['uid']);
                    session('userotype', $result['otype']);
                    session('username', $result['username']);
                    $loginSign = M("login_log")->add($logData);
                    session('login_sign', $loginSign);

                    //获取菜单
                    if($result['is_admin'] == 1) {
                        $user_role = M('user_role')
                            ->field('role_id')
                            ->where(['user_id' => $result['uid']])
                            ->select();
                        $role_id   = array_unique(array_column($user_role, 'role_id'));
                        $role_menu = M('role_menu')
                            ->field('menu_id')
                            ->where([
                                'role_id' => [
                                    'in',
                                    $role_id,
                                ],
                            ])
                            ->select();
                        $menu_id   = array_unique(array_column($role_menu, 'menu_id'));
                        $menu       = $this->get_menu($menu_id);
                    } else {
                        $menu = $this->get_all_menu();
                    }

                    $url_prefix = array_keys(C('URL_MODULE_MAP'))[0];

                    foreach ($menu as $key => $value) {
                        $menu[$key]['url'] = '/'.$url_prefix.'/'.$value['controller'].'/'.$value['method'].$value['param'];
                    }

                    $menus = $this->admin_menus($menu);

                    session('menus', json_encode($menus));

                    unset($_SESSION['auth_user']);
                    $this->success('验证成功,正跳转至系统管理员首页...', U('admin/Index/index'));
                } else {
                    session(null);
                    $this->error('登录失败，请重新输入用户名及密码',U('User/signin'));
                }
            } else {
                $this->error('验证失败，请重新输入验证码');
            }
        }
        else {
            $this->display();
        }
    }


    /**
     * 用户注销
     */
    public function signinout()
    {
        // 清楚所有session
        header("Content-type: text/html; charset=utf-8");
        session(null);
        redirect(U('User/signin'), 2, '正在退出登录...');
    }


    //会员列表
    public function ulist()
    {
        $user = A('Admin/User');
        $user->checklogin();

        $oid = trim(I('get.oid'));    //运营中心id
        $jjr = trim(I('get.jjr'));    //销售商id

        $email    = trim(I('get.email'));
        $username = trim(I('get.username'));
        $nickname = trim(I('get.nickname'));
        $uid      = trim(I('get.uid'));

        $trade_frozen = trim(I('get.trade_frozen'));

        if ($email) {
            $map['a.email'] = $email;
            $sea['email']   = I('get.email');
        }

        if ($username) {
            $map['a.username'] = $username;
            $sea['username']   = I('get.username');
        }

        if ($nickname) {
            $map['a.nickname'] = $nickname;
            $sea['nickname']   = I('get.nickname');
        }

        if ($uid) {
            $map['a.uid'] = $uid;
            $sea['uid']   = I('get.uid');
        }

        if ($trade_frozen || $trade_frozen == '0') {
            $map['a.trade_frozen'] = $trade_frozen;
            $sea['trade_frozen']   = I('get.trade_frozen');
        }


        if ($jjr) {
            $userarr = [];
            $ship    = M('userinfoRelationship')
                ->where(['parent_user_id' => $jjr])
                ->select();
            foreach ($ship as $key => $value) {
                array_push($userarr, $value['user_id']);
                $id = implode(',', array_unique($userarr));
            }
            $jjr_userinfo = M('userinfo')
                ->field('username')
                ->where(['uid' => $jjr])
                ->find();
            $map['a.uid'] = [
                'IN',
                $id,
            ];
            $this->assign('jjr_info', $jjr_userinfo['username']);
            $this->assign('user_id', $oid);
            $sea['jjr'] = $$jjr;
        }
        elseif ($oid) {
            $userarr  = [];
            $userarr1 = [];
            $ship     = M("UserinfoRelationship")
                ->where(['parent_user_id' => $oid])
                ->select();
            foreach ($ship as $key => $value) {
                array_push($userarr, $value['user_id']);
            }
            $user_id = implode(',', array_unique($userarr));
            $users   = M("UserinfoRelationship")
                ->where('parent_user_id  in('.$user_id.')')
                ->select();
            foreach ($users as $key => $val) {
                array_push($userarr1, $val['user_id']);
            }
            $id = implode(',', array_unique($userarr1));

            $map['a.uid'] = [
                'in',
                $id,
            ];
            $this->assign('user_id', $oid);
            $sea['oid'] = $oid;
        }

        $sort = 'a.utime desc';
        //余额排序
        $cat   = trim(I('get.cat'));
        $sorts = trim(I('get.sort'));
        if ($cat) {
            $sort        = $cat.' '.$sorts.'';
            $sea['cat']  = $cat;
            $sea['sort'] = $sorts;
        }

        $this->assign('sea', $sea);

        $map['a.otype']   = 4;
        $map['a.ustatus'] = [
            'in',
            '0,1',
        ];

        $count           = M('userinfo a')
            ->where($map)
            ->count();
        $pagecount       = 10;
        $page            = new \Think\Page($count, $pagecount);
        $page->parameter = $sea; //此处的row是数组，为了传递查询条件
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '&#8249;');
        $page->setConfig('next', '&#8250;');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();

        $field = "a.*,b.balance,b.gold,b.integral,b.income_total,b.recharge_total,b.loss_total,b.money_total,d.money";
        $info  = M("userinfo a")
            ->field($field)
            ->join('wp_accountinfo as b on a.uid = b.uid')
            ->join('left join wp_extension as d on a.uid = d.user_id')
            ->where($map)
            ->order($sort)
            ->limit($page->firstRow.','.$page->listRows)
            ->select();


        $orderObj = M('order');

        $userIdArr = [];
        foreach ($info as $k => $v) {

            array_push($userIdArr, $v['uid']);

            $info[ $k ]['count'] = M('order')
                ->where([
                    'uid'  => $v['uid'],
                    'type' => 1,
                ])
                ->count();
            //推广佣金
            $info[ $k ]['fee_receive'] += $v['money'];
            //订单统计，持仓平仓条数
            $info[ $k ]['total_jc'] = $orderObj->where([
                'uid'    => $v['uid'],
                'ostaus' => '0',
                'type'   => 1,
            ])
                                               ->count();
            $info[ $k ]['total_pc'] = $orderObj->where([
                'uid'    => $v['uid'],
                'ostaus' => '1',
                'type'   => 1,
            ])
                                               ->count();

            //首次入金时间
            $recharge_time = M('balance')
                ->where([
                    'uid'    => $v['uid'],
                    'status' => 1,
                ])
                ->order('bpid asc')
                ->getField('bptime');

            $info[ $k ]['recharge_time'] = empty($recharge_time) ? '尚未入金' : date('Y-m-d H:i:s', $recharge_time);
        }

        // vD($info);die;

        //累计账户余额
        $account = M("userinfo a")
            ->join('wp_accountinfo as b on a.uid = b.uid')
            ->where($map)
            ->select();

        foreach ($account as $key => $value) {
            $data['balance']        += $value['balance'];
            $data['gold']           += $value['gold'];
            $data['integral']       += $value['integral'];
            $data['recharge_total'] += $value['recharge_total'];
            $data['money_total']    += $value['money_total'];
        }


        //佣金计算
        $data['fee_receive'] = M("userinfo a")
            ->field($field)
            ->join('left join wp_extension as d on a.uid = d.user_id')
            ->where($map)
            ->sum('money');

        $data['count'] = $count;

        $this->assign('data', $data);
        $this->assign('ulist', $info);
        $this->assign('page', $show);
        $this->assign('info', M('userinfo')
            ->where('otype=5')
            ->select());
        $this->display();
    }


    public function ajax_get_brokers()
    {
        if (IS_AJAX) {
            $userobj         = M('userinfo a');
            $relationshipobj = M('userinfo_relationship');

            $parent_id = I('get.parent_id', 0, 'intval');

            if ($parent_id < 1) {
                $this->AjaxReturn([
                    'msg'    => '父级id不存在',
                    'status' => 0,
                ]);
            }
            $ids_arr = $relationshipobj->field('user_id')
                                       ->where(['parent_user_id' => $parent_id])
                                       ->select();
            $ids     = '';

            if ($ids_arr) {
                foreach ($ids_arr as $v) {
                    if (!empty($ids)) {
                        $ids .= ','.$v['user_id'];
                    }
                    else {
                        $ids = $v['user_id'];
                    }
                }
            }
            $where['a.uid'] = [
                'IN',
                $ids,
            ];
            $res            = $userobj->field('a.uid,a.username')
                                      ->where($where)
                                      ->order('a.uid DESC')
                                      ->select();
            foreach ($res as $key => $value) {
                $res[ $key ]['username'] = $value['username'];
            }

            $data = [
                'msg'    => '成功',
                'status' => 1,
                'data'   => $res,
            ];
            $this->AjaxReturn($data);
        }
        $this->error('您访问的页面不存在', 'index/index');
    }


    //会员列表导出
    public function daochu()
    {
        $user = A('Admin/User');
        $user->checklogin();

        $oid = trim(I('get.oid'));    //运营中心id
        $jjr = trim(I('get.jjr'));    //销售商id

        $email    = trim(I('get.email'));
        $username = trim(I('get.username'));
        $nickname = trim(I('get.nickname'));
        $uid      = trim(I('get.uid'));

        $trade_frozen = trim(I('get.trade_frozen'));

        if ($email) {
            $map['a.email'] = $email;
        }

        if ($username) {
            $map['a.username'] = $username;
        }

        if ($nickname) {
            $map['a.nickname'] = $nickname;
        }

        if ($uid) {
            $map['a.uid'] = $uid;
        }

        if ($trade_frozen || $trade_frozen == '0') {
            $map['a.trade_frozen'] = $trade_frozen;
        }


        if ($jjr) {
            $userarr = [];
            $ship    = M('userinfoRelationship')
                ->where(['parent_user_id' => $jjr])
                ->select();
            foreach ($ship as $key => $value) {
                array_push($userarr, $value['user_id']);
                $id = implode(',', array_unique($userarr));
            }
            $jjr_userinfo = M('userinfo')
                ->field('username')
                ->where(['uid' => $jjr])
                ->find();
            $map['a.uid'] = [
                'IN',
                $id,
            ];
        }
        elseif ($oid) {
            $userarr  = [];
            $userarr1 = [];
            $ship     = M("UserinfoRelationship")
                ->where(['parent_user_id' => $oid])
                ->select();
            foreach ($ship as $key => $value) {
                array_push($userarr, $value['user_id']);
            }
            $user_id = implode(',', array_unique($userarr));
            $users   = M("UserinfoRelationship")
                ->where('parent_user_id  in('.$user_id.')')
                ->select();
            foreach ($users as $key => $val) {
                array_push($userarr1, $val['user_id']);
            }
            $id = implode(',', array_unique($userarr1));

            $map['a.uid'] = [
                'in',
                $id,
            ];
        }

        $sort = 'a.utime desc';
        //余额排序
        $cat   = trim(I('get.cat'));
        $sorts = trim(I('get.sort'));
        if ($cat) {
            $sort = $cat.' '.$sorts.'';
        }


        $map['a.otype']   = 4;
        $map['a.ustatus'] = [
            'in',
            '0,1',
        ];


        $field = "a.*,b.balance,b.gold,b.integral,b.income_total,b.recharge_total,b.loss_total,b.money_total,d.money";
        $info  = M("userinfo a")
            ->field($field)
            ->join('wp_accountinfo as b on a.uid = b.uid')
            ->join('left join wp_extension as d on a.uid = d.user_id')
            ->where($map)
            ->order($sort)
            ->select();


        $orderObj = M('order');

        $userIdArr = [];
        foreach ($info as $k => $v) {

            array_push($userIdArr, $v['uid']);

            $info[ $k ]['count'] = M('order')
                ->where([
                    'uid'  => $v['uid'],
                    'type' => 1,
                ])
                ->count();
            //推广佣金
            $info[ $k ]['fee_receive'] += $v['money'];

            //首次入金时间
            $recharge_time = M('balance')
                ->where([
                    'uid'    => $v['uid'],
                    'status' => 1,
                ])
                ->order('bpid asc')
                ->getField('bptime');

            $info[ $k ]['recharge_time'] = empty($recharge_time) ? '尚未入金' : date('Y-m-d H:i:s', $recharge_time);
        }


        $data[0] = [
            '编号ID',
            '用户名称',
            '电子邮箱',
            '用户昵称',
            '上级',
            '创建日期',
            '首次入金',
            '最近登录时间',
            '订单数量',
            '账户余额',
            '模拟金额',
            //            '账户积分',
            '累计充值',
            '累计提现',
            '当前佣金',
            '运营中心',
            '销售商',
            '交易状态',
        ];
        foreach ($info as $k => $v) {
            $lastlog = empty($v['lastlog']) ? '未登录过' : date("Y-m-d H:i:s", $v['lastlog']);

            $data[ $k + 1 ][] = $v['uid'];
            $data[ $k + 1 ][] = $v['username'];
            $data[ $k + 1 ][] = $v['email'];
            $data[ $k + 1 ][] = $v['nickname'];
            $data[ $k + 1 ][] = change($v['rid']);
            $data[ $k + 1 ][] = date("Y-m-d H:i:s", $v['utime']);
            $data[ $k + 1 ][] = $v['recharge_time'];
            $data[ $k + 1 ][] = $lastlog;
            $data[ $k + 1 ][] = $v['count'];
            $data[ $k + 1 ][] = number_format($v['balance'], 2);
            $data[ $k + 1 ][] = number_format($v['gold'], 2);
            //            $data[ $k + 1 ][] = number_format($v['integral'], 2);
            $data[ $k + 1 ][] = number_format($v['recharge_total'], 2);
            $data[ $k + 1 ][] = number_format($v['money_total'], 2);
            $data[ $k + 1 ][] = $v['fee_receive'];
            $data[ $k + 1 ][] = change(exchange($v['uid'], 2));
            $data[ $k + 1 ][] = change(exchange($v['uid'], 1));
            $data[ $k + 1 ][] = $v['trade_frozen'] == '0' ? '正常' : '冻结';
        }

        $name = '客户列表';  //生成的Excel文件文件名
        $res  = $this->push($data, $name);
    }


    //修改会员
    public function updateuser()
    {
        //判断用户是否登陆
        $user = A('Admin/User');
        $user->checklogin();

        if (IS_POST) {
            $uid       = trim(I('post.uid'));            //编号
            $real_name = trim(I('post.real_name'));    //真实姓名
            $utel      = trim(I('post.utel'));            //手机号码
            $balance   = trim(I('post.balance'));        //金额
            $gold      = trim(I('post.gold'));            //金币
            $integral  = trim(I('post.integral'));        //积分

            $card     = trim(I('post.card'));            //身份证
            $province = trim(I('post.province'));        //省
            $city     = trim(I('post.city'));            //市

            $upwd = trim(I('post.upwd'));            //密码
            $rpwd = trim(I('post.rpwd'));

            if (empty($uid)) {
                $this->error('修改失败');
            }

            $userObj    = M('userinfo');
            $accountObj = M('accountinfo');
            $personObj  = M('personal_user_data');


            if (!empty($real_name)) {
                $person['real_name'] = $real_name;
            }

            if (!empty($utel)) {
                $users['utel'] = $utel;
            }

            if (!empty($balance)) {
                $account['balance'] = $balance;
            }

            if (!empty($gold)) {
                $account['gold'] = $gold;
            }

            if (!empty($integral)) {
                $account['integral'] = $integral;
            }

            if (!empty($card)) {
                $person['card'] = $card;
            }

            if (!empty($province)) {
                $person['province'] = $province;
            }

            if (!empty($city)) {
                $person['city'] = $city;
            }

            if (!empty($upwd)) {
                $users['upwd'] = md5($upwd);
            }

            //修改用户基本信息
            $resultUser = $userObj->where('uid='.$uid)
                                  ->save($users);

            //修改用户真实信息
            if ($personObj->where('uid='.$uid)
                          ->find()) {
                $resultManager = $personObj->where('uid='.$uid)
                                           ->save($person);
            }
            //            else {
            //                $person['uid']         = $uid;
            //                $person['create_time'] = time();
            //                $resultManager         = $personObj->add($person);
            //            }


            //修改账户余额
            if ($accountObj->where('uid='.$uid)
                           ->find()) {
                $trueAcinfo = $accountObj->where('uid='.$uid)
                                         ->setInc('balance', $balance);
            }
            else {
                $balan['uid']     = $uid;
                $balan['balance'] = $balance;
                $trueAcinfo       = $accountObj->add($balan);
            }

            if ($trueAcinfo) {

                $shibpprice = $accountObj->where(['uid' => $uid])
                                         ->sum('balance');

                if ($balance > 0) {

                    //充值利率
                    $sysData = get_setting_config('find', 'SYSTEM_DOLLAR_SETTING');
                    $rate    = $sysData['datas']['data'][0];

                    $where['bptime']      = time();
                    $where['bpprice']     = $balance;
                    $where['bpprice_cny'] = round($balance * $rate['value'], 2);
                    $where['uid']         = $uid;
                    $where['cltime']      = time();
                    $where['balanceno']   = time().mt_rand();
                    $where['shibpprice']  = $shibpprice;
                    $where['status']      = 1;
                    $where['pay_type']    = 25;
                    M("balance")->add($where);

                    $msg    = '资金变动增加['.$balance.']美元';
                    $en_msg = 'Increased capital movements['.$balance.']Dollar';
                }
                else {
                    $msg    = '资金变动扣除['.$balance.']美元';
                    $en_msg = 'Increased capital movements['.$balance.']Dollar';
                }
                $map['uid']       = $uid;
                $map['type']      = 4;
                $map['note']      = $msg;
                $map['en_note']   = $en_msg;
                $map['balance']   = $shibpprice;
                $map['op_id']     = session('userid');
                $map['user_type'] = 1;
                $map['dateline']  = time();
                M("MoneyFlow")->add($map);
            }

            //修改账户金币
            if ($accountObj->where('uid='.$uid)
                           ->find()) {
                $integralAcinfo = $accountObj->where('uid='.$uid)
                                             ->setInc('integral', $integral);
            }
            else {
                $balan['uid']      = $uid;
                $balan['integral'] = $integral;
                $trueAcinfo        = $accountObj->add($balan);
            }

            if ($integralAcinfo) {

                $where['user_id']     = $uid;
                $where['account']     = $integral;
                $where['type']        = 5;
                $where['create_time'] = time();
                $res                  = M("UserJournal")->add($where);

                if ($res) {
                    //生成用户流水
                    if ($integral > 0) {
                        $msg = '积分变动增加['.$integral.']积分';
                    }
                    else {
                        $msg = '积分变动扣除['.$integral.']积分';
                    }
                    $map['uid']       = $uid;
                    $map['type']      = 6;
                    $map['oid']       = $res;
                    $map['note']      = $msg;
                    $map['balance']   = $accountObj->where(['uid' => $uid])
                                                   ->sum('integral');
                    $map['op_id']     = session('userid');
                    $map['user_type'] = 1;
                    $map['dateline']  = time();
                    M("MoneyFlow")->add($map);
                }
            }

            //修改账户金币
            if ($accountObj->where('uid='.$uid)
                           ->find()) {

                $falseAcinfo = $accountObj->where('uid='.$uid)
                                          ->setInc('gold', $gold);
            }
            else {
                $balan['uid']  = $uid;
                $balan['gold'] = $gold;
                $falseAcinfo   = $accountObj->add($balan);
            }
            if ($falseAcinfo) {

                $where['user_id']     = $uid;
                $where['account']     = $gold;
                $where['type']        = 4;
                $where['create_time'] = time();
                M("UserJournal")->add($where);
            }

            if ($resultUser || $resultManager || $trueAcinfo || $falseAcinfo || $integralAcinfo) {
                $this->success('修改成功');
            }
            elseif ($resultUser == 0 || $resultManager == 0 || $trueAcinfo == 0 || $falseAcinfo == 0 || $integralAcinfo == 0) {
                $this->error('未做任何修改');
            }
            else {
                $this->error('修改失败');
            }

        }
        else {
            $uid = trim(I('get.uid'));

            $userObj    = M('userinfo');
            $accountObj = M('accountinfo');
            $personObj  = M('personal_user_data');
            $cityObj    = M('city');

            $userme = $userObj->field('uid,nickname,ustatus,email,utime')
                              ->where(['uid' => $uid])
                              ->find();

            $account = $accountObj->field('balance,gold,integral')
                                  ->where(['uid' => $uid])
                                  ->find();

            $person = $personObj->field('real_name,card,province,city,card_positive,card_side')
                                ->where([
                                    'uid'    => $uid,
                                    'status' => 1,
                                ])
                                ->find();

            $province = $cityObj->field('id,joinname')
                                ->where(['level' => 1])
                                ->select();

            //获取市区
            if (!empty($person['city'])) {
                $city = $cityObj->field('id,name')
                                ->where(['parent_id' => $person['province']])
                                ->select();
                $this->assign('city', $city);
            }
            else {
                $city = $cityObj->field('id,name')
                                ->where(['parent_id' => $province[0]['id']])
                                ->select();
                $this->assign('city', $city);
            }

            $this->assign('province', $province);
            $this->assign('person', $person);
            $this->assign('account', $account);
            $this->assign('userme', $userme);
            $this->display();
        }
    }

    /**
     * [bankinfo 银行卡信息]
     * @author wang li
     */
    public function bankInfo()
    {
        $uid = trim(I('get.uid'));

        $bankObj = M('bankinfo');
        $cityObj = M('city');

        $bank = $bankObj->where([
            'uid'    => $uid,
            'status' => 1,
        ])
                        ->select();

        foreach ($bank as $key => $value) {
            $bank[ $key ]['province'] = $cityObj->where(['id' => $value['province']])
                                                ->getField('joinname');
            $bank[ $key ]['city']     = $cityObj->where(['id' => $value['city']])
                                                ->getField('name');
        }

        $this->assign('bank', $bank);
        $this->display();
    }


    /**
     * [delBankInfo 银行卡删除]
     * @author wang li
     */
    public function delBankInfo()
    {
        $bid = trim(I('get.bid'));

        if (empty($bid)) {
            $this->error('删除失败');
        }

        $bankObj = M('bankinfo');

        $res = $bankObj->where(['bid' => $bid])
                       ->delete();

        if ($res) {
            $this->success('删除成功');
        }
        else {
            $this->error('删除失败');
        }
    }

    /**
     * [updateBank 银行卡修改]
     * @author wang 9li
     */
    public function updateBank()
    {
        if (IS_POST) {

            $post = I('post.');

            $bankObj = M('bankinfo');

            $res = $bankObj->save($post);

            if ($res) {
                $this->success('修改成功');
            }
            else {
                $this->error('修改失败');
            }

        }
        else {

            $bid = trim(I('get.bid'));

            if (empty($bid)) {
                $this->error('修改失败');
            }

            $bankObj = M('bankinfo');

            $bank = $bankObj->where(['bid' => $bid])
                            ->find();

            $this->assign('bank', $bank);
            $this->display();
        }
    }


    /**
     * 资金流水
     * @author wang <li>
     */
    public function money_flow()
    {

        //判断用户是否登陆
        $user = A('Admin/User');
        $user->checklogin();

        $MoneyFlow            = M('MoneyFlow');
        $userinfo             = M('userinfo');
        $UserinfoRelationship = M('UserinfoRelationship');
        $bankinfo             = M('bankinfo');

        $email     = trim(I('get.email'));
        $type      = trim(I('get.type'));
        $yunying   = trim(I('get.yunying'));
        $jingjiren = trim(I('get.jingjiren'));
        $user      = trim(I('get.user'));
        $starttime = urldecode(trim(I('get.starttime')));
        $endtime   = urldecode(trim(I('get.endtime')));
        $operator  = trim(I('get.operator'));  //操作人


        if ($email) {
            $searchArr      = [];
            $where['email'] = [
                'like',
                '%'.$email.'%',
            ];
            $info           = $userinfo->where($where)
                                       ->select();
            foreach ($info as $key => $value) {
                array_push($searchArr, $value['uid']);
            }
            $searchId     = implode(',', array_unique($searchArr));
            $map['uid']   = [
                'in',
                $searchId,
            ];
            $sea['email'] = $email;
        }

        if ($type) {
            $map['type'] = $type;
            $sea['type'] = $type;
        }
        else {
            $map['type'] = [
                'neq',
                6,
            ];
        }

        if ($operator) {
            $map['op_id'] = $operator;
            $this->assign('op_id', $operator);
            $sea['operator'] = $operator;
        }

        if ($yunying) {

            $relation     = $UserinfoRelationship->where(['parent_user_id' => $yunying])
                                                 ->select();
            $relationArr  = [];
            $relationArr1 = [];
            foreach ($relation as $key => $value) {
                array_push($relationArr, $value['user_id']);
            }
            $relationId = implode(',', array_unique($relationArr));
            $users      = $UserinfoRelationship->where('parent_user_id in('.$relationId.')')
                                               ->select();
            foreach ($users as $key => $value) {
                array_push($relationArr1, $value['user_id']);
            }
            $userId         = implode(',', array_unique($relationArr1));
            $map['uid']     = [
                'in',
                $userId,
            ];
            $sea['yunying'] = $yunying;
        }

        if ($jingjiren) {
            $relationArr2   = [];
            $jingjiren_user = $UserinfoRelationship->where('parent_user_id in('.$jingjiren.')')
                                                   ->select();
            foreach ($jingjiren_user as $key => $value) {
                array_push($relationArr2, $value['user_id']);
            }
            $userId1          = implode(',', array_unique($relationArr2));
            $map['uid']       = [
                'in',
                $userId1,
            ];
            $sea['jingjiren'] = $jingjiren;
            $this->assign('jingjiren', $this->get_username($jingjiren));
        }

        if ($user) {
            $map['uid']  = $user;
            $sea['user'] = $user;
            $this->assign('user', $this->get_username($user));
        }

        if ($starttime && $endtime) {
            $start_time       = strtotime($starttime);
            $end_time         = strtotime($endtime);
            $map['dateline']  = [
                'between',
                ''.$start_time.','.$end_time.'',
            ];
            $sea['starttime'] = $starttime;
            $sea['endtime']   = $endtime;
        }
        else {
            $starttime        = strtotime(date('Y-m-d')." 06:00:00");
            $endtime          = strtotime(date('Y-m-d')." 05:00:00") + 3600 * 24;
            $map['dateline']  = [
                'between',
                ''.$starttime.','.$endtime.'',
            ];
            $sea['starttime'] = date('Y-m-d H:i:s', $starttime);
            $sea['endtime']   = date('Y-m-d H:i:s', $endtime);
        }


        $map['user_type'] = [
            'eq',
            1,
        ];

        $count           = $MoneyFlow->where($map)
                                     ->count();   //总数量
        $pagecount       = 15;   //每页显示的数量
        $page            = new \Think\Page($count, $pagecount);
        $page->parameter = $sea; //此处的row是数组，为了传递查询条件
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '&#8249;');
        $page->setConfig('next', '&#8250;');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();

        $Flow = $MoneyFlow->where($map)
                          ->order('dateline  desc')
                          ->limit($page->firstRow, $page->listRows)
                          ->select();

        $Flow_money = $MoneyFlow->field('note')
                                ->where($map)
                                ->order('dateline  desc')
                                ->select();

        $flowArr  = [];
        $flowArr2 = [];
        foreach ($Flow as $key => $value) {
            array_push($flowArr, $value['uid']);
            array_push($flowArr2, $value['op_id']);
        }
        $flowId  = implode(',', array_unique($flowArr));
        $flowId1 = implode(',', array_unique($flowArr2));

        $info    = $userinfo->field('uid,username,email,nickname')
                            ->where('uid in('.$flowId.')')
                            ->select();
        $infoArr = [];
        foreach ($info as $key => $value) {
            $infoArr[ $value['uid'] ] = $value;
        }

        $info1    = $userinfo->field('username,uid')
                             ->where('uid in('.$flowId1.')')
                             ->select();
        $infoArr1 = [];
        foreach ($info1 as $key => $value) {
            $infoArr1[ $value['uid'] ] = $value;
        }


        foreach ($Flow as $key => $value) {

            $Flow[ $key ]['email']    = $infoArr[ $value['uid'] ]['email'];
            $Flow[ $key ]['username'] = $infoArr[ $value['uid'] ]['username'];
            $Flow[ $key ]['nickname'] = $infoArr[ $value['uid'] ]['nickname'];

            $Flow[ $key ]['account'] = substr($value['note'], strrpos($value['note'], '[') + 1);
            $Flow[ $key ]['account'] = preg_replace("/]/", "", $Flow[ $key ]['account']);

            $Flow[ $key ]['operator'] = $infoArr1[ $value['op_id'] ]['username'];
        }

        //无分页
        $money = '';
        foreach ($Flow_money as $key => $value) {
            $Flow_money[ $key ]['account'] = substr($value['note'], strrpos($value['note'], '[') + 1);
            $Flow_money[ $key ]['account'] = preg_replace("/]/", "", $Flow_money[ $key ]['account']);
            $money                         += $Flow_money[ $key ]['account'];
        }

        $this->assign('flow', $Flow);
        $this->assign('page', $show);
        $this->assign('sea', $sea);
        $this->assign('yunying', $userinfo->field('username,uid')
                                          ->where('otype=5')
                                          ->select());
        $this->assign('money', $money);
        $this->assign('info', $userinfo->field('uid,username')
                                       ->where(['otype' => 3])
                                       ->select());
        $this->display();
    }


    public function daochu_moneyFlow()
    {
        //判断用户是否登陆
        $user = A('Admin/User');
        $user->checklogin();

        $MoneyFlow            = M('MoneyFlow');
        $userinfo             = M('userinfo');
        $UserinfoRelationship = M('UserinfoRelationship');
        $bankinfo             = M('bankinfo');

        $email     = trim(I('get.email'));
        $type      = trim(I('get.type'));
        $yunying   = trim(I('get.yunying'));
        $jingjiren = trim(I('get.jingjiren'));
        $user      = trim(I('get.user'));
        $starttime = urldecode(trim(I('get.starttime')));
        $endtime   = urldecode(trim(I('get.endtime')));
        $operator  = trim(I('get.operator'));  //操作人


        if ($email) {
            $searchArr      = [];
            $where['email'] = [
                'like',
                '%'.$email.'%',
            ];
            $info           = $userinfo->where($where)
                                       ->select();
            foreach ($info as $key => $value) {
                array_push($searchArr, $value['uid']);
            }
            $searchId   = implode(',', array_unique($searchArr));
            $map['uid'] = [
                'in',
                $searchId,
            ];
        }

        if ($type) {
            $map['type'] = $type;
        }
        else {
            $map['type'] = [
                'neq',
                6,
            ];
        }

        if ($operator) {
            $map['op_id'] = $operator;
        }

        if ($yunying) {

            $relation     = $UserinfoRelationship->where(['parent_user_id' => $yunying])
                                                 ->select();
            $relationArr  = [];
            $relationArr1 = [];
            foreach ($relation as $key => $value) {
                array_push($relationArr, $value['user_id']);
            }
            $relationId = implode(',', array_unique($relationArr));
            $users      = $UserinfoRelationship->where('parent_user_id in('.$relationId.')')
                                               ->select();
            foreach ($users as $key => $value) {
                array_push($relationArr1, $value['user_id']);
            }
            $userId     = implode(',', array_unique($relationArr1));
            $map['uid'] = [
                'in',
                $userId,
            ];
        }

        if ($jingjiren) {
            $relationArr2   = [];
            $jingjiren_user = $UserinfoRelationship->where('parent_user_id in('.$jingjiren.')')
                                                   ->select();
            foreach ($jingjiren_user as $key => $value) {
                array_push($relationArr2, $value['user_id']);
            }
            $userId1    = implode(',', array_unique($relationArr2));
            $map['uid'] = [
                'in',
                $userId1,
            ];
        }

        if ($user) {
            $map['uid'] = $user;
        }

        if ($starttime && $endtime) {
            $start_time      = strtotime($starttime);
            $end_time        = strtotime($endtime);
            $map['dateline'] = [
                'between',
                ''.$start_time.','.$end_time.'',
            ];
        }
        else {
            $starttime       = strtotime(date('Y-m-d')." 06:00:00");
            $endtime         = strtotime(date('Y-m-d')." 05:00:00") + 3600 * 24;
            $map['dateline'] = [
                'between',
                ''.$starttime.','.$endtime.'',
            ];
        }


        $map['user_type'] = [
            'eq',
            1,
        ];

        $Flow = $MoneyFlow->where($map)
                          ->order('dateline  desc')
                          ->select();

        $flowArr  = [];
        $flowArr2 = [];
        foreach ($Flow as $key => $value) {
            array_push($flowArr, $value['uid']);
            array_push($flowArr2, $value['op_id']);
        }
        $flowId  = implode(',', array_unique($flowArr));
        $flowId1 = implode(',', array_unique($flowArr2));

        $info    = $userinfo->field('uid,username,email,nickname')
                            ->where('uid in('.$flowId.')')
                            ->select();
        $infoArr = [];
        foreach ($info as $key => $value) {
            $infoArr[ $value['uid'] ] = $value;
        }

        $info1    = $userinfo->field('username,uid')
                             ->where('uid in('.$flowId1.')')
                             ->select();
        $infoArr1 = [];
        foreach ($info1 as $key => $value) {
            $infoArr1[ $value['uid'] ] = $value;
        }


        foreach ($Flow as $key => $value) {

            $Flow[ $key ]['email']    = $infoArr[ $value['uid'] ]['email'];
            $Flow[ $key ]['username'] = $infoArr[ $value['uid'] ]['username'];
            $Flow[ $key ]['nickname'] = $infoArr[ $value['uid'] ]['nickname'];

            $Flow[ $key ]['account'] = substr($value['note'], strrpos($value['note'], '[') + 1);
            $Flow[ $key ]['account'] = preg_replace("/]元/", "", $Flow[ $key ]['account']);

            $Flow[ $key ]['operator'] = $infoArr1[ $value['op_id'] ]['username'];
        }


        $data[0] = [
            '编号',
            '用户名称',
            '用户昵称',
            '电子邮箱',
            '资金变动描述',
            '变动金额',
            '用户余额',
            '操作人',
            '操作时间',
        ];
        foreach ($Flow as $k => $v) {
            $data[ $k + 1 ][] = $v['id'];
            $data[ $k + 1 ][] = $v['username'];
            $data[ $k + 1 ][] = $v['nickname'];
            $data[ $k + 1 ][] = $v['email'];
            $data[ $k + 1 ][] = $v['note'];
            $data[ $k + 1 ][] = number_format($v['account'], 2);
            $data[ $k + 1 ][] = $v['balance'];
            $data[ $k + 1 ][] = $v['operator'];
            $data[ $k + 1 ][] = date('Y-m-d H:i:s', $v['dateline']);
        }
        $name = '资金流水记录';      //生成的Excel文件文件名
        $res  = $this->push($data, $name);
    }

    /**
     * 积分流水
     * @author wang li
     */
    public function integral_flow()
    {
        //判断用户是否登陆
        $user = A('Admin/User');
        $user->checklogin();

        $MoneyFlow            = M('MoneyFlow');
        $userinfo             = M('userinfo');
        $UserinfoRelationship = M('UserinfoRelationship');
        $bankinfo             = M('bankinfo');

        $utel      = trim(I('get.utel'));
        $type      = trim(I('get.type'));
        $yunying   = trim(I('get.yunying'));
        $jingjiren = trim(I('get.jingjiren'));
        $user      = trim(I('get.user'));
        $starttime = urldecode(trim(I('get.starttime')));
        $endtime   = urldecode(trim(I('get.endtime')));
        $operator  = trim(I('get.operator'));  //操作人


        if ($utel) {
            $searchArr     = [];
            $where['utel'] = [
                'like',
                '%'.$utel.'%',
            ];
            $info          = $userinfo->where($where)
                                      ->select();
            foreach ($info as $key => $value) {
                array_push($searchArr, $value['uid']);
            }
            $searchId    = implode(',', array_unique($searchArr));
            $map['uid']  = [
                'in',
                $searchId,
            ];
            $sea['utel'] = $utel;
        }

        if ($operator) {
            $map['op_id'] = $operator;
            $this->assign('op_id', $operator);
            $sea['operator'] = $operator;
        }

        if ($yunying) {

            $relation     = $UserinfoRelationship->where(['parent_user_id' => $yunying])
                                                 ->select();
            $relationArr  = [];
            $relationArr1 = [];
            foreach ($relation as $key => $value) {
                array_push($relationArr, $value['user_id']);
            }
            $relationId = implode(',', array_unique($relationArr));
            $users      = $UserinfoRelationship->where('parent_user_id in('.$relationId.')')
                                               ->select();
            foreach ($users as $key => $value) {
                array_push($relationArr1, $value['user_id']);
            }
            $userId         = implode(',', array_unique($relationArr1));
            $map['uid']     = [
                'in',
                $userId,
            ];
            $sea['yunying'] = $yunying;
        }

        if ($jingjiren) {
            $relationArr2   = [];
            $jingjiren_user = $UserinfoRelationship->where('parent_user_id in('.$jingjiren.')')
                                                   ->select();
            foreach ($jingjiren_user as $key => $value) {
                array_push($relationArr2, $value['user_id']);
            }
            $userId1          = implode(',', array_unique($relationArr2));
            $map['uid']       = [
                'in',
                $userId1,
            ];
            $sea['jingjiren'] = $jingjiren;
            $this->assign('jingjiren', $this->get_username($jingjiren));
        }

        if ($user) {
            $map['uid']  = $user;
            $sea['user'] = $user;
            $this->assign('user', $this->get_username($user));
        }

        if ($starttime && $endtime) {
            $start_time       = strtotime($starttime);
            $end_time         = strtotime($endtime);
            $map['dateline']  = [
                'between',
                ''.$start_time.','.$end_time.'',
            ];
            $sea['starttime'] = $starttime;
            $sea['endtime']   = $endtime;
        }
        else {
            $starttime        = strtotime(date('Y-m-d')." 06:00:00");
            $endtime          = strtotime(date('Y-m-d')." 05:00:00") + 3600 * 24;
            $map['dateline']  = [
                'between',
                ''.$starttime.','.$endtime.'',
            ];
            $sea['starttime'] = date('Y-m-d H:i:s', $starttime);
            $sea['endtime']   = date('Y-m-d H:i:s', $endtime);
        }

        $map['type']      = [
            'eq',
            6,
        ];
        $map['user_type'] = [
            'eq',
            1,
        ];

        $count           = $MoneyFlow->where($map)
                                     ->count();   //总数量
        $pagecount       = 15;   //每页显示的数量
        $page            = new \Think\Page($count, $pagecount);
        $page->parameter = $sea; //此处的row是数组，为了传递查询条件
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '&#8249;');
        $page->setConfig('next', '&#8250;');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();

        $Flow = $MoneyFlow->where($map)
                          ->order('dateline  desc')
                          ->limit($page->firstRow, $page->listRows)
                          ->select();

        $Flow_money = $MoneyFlow->field('note')
                                ->where($map)
                                ->order('dateline  desc')
                                ->select();

        $flowArr  = [];
        $flowArr2 = [];
        foreach ($Flow as $key => $value) {
            array_push($flowArr, $value['uid']);
            array_push($flowArr2, $value['op_id']);
        }
        $flowId  = implode(',', array_unique($flowArr));
        $flowId1 = implode(',', array_unique($flowArr2));

        $info    = $userinfo->field('uid,username,utel,nickname')
                            ->where('uid in('.$flowId.')')
                            ->select();
        $infoArr = [];
        foreach ($info as $key => $value) {
            $infoArr[ $value['uid'] ] = $value;
        }

        $info1    = $userinfo->field('username,uid')
                             ->where('uid in('.$flowId1.')')
                             ->select();
        $infoArr1 = [];
        foreach ($info1 as $key => $value) {
            $infoArr1[ $value['uid'] ] = $value;
        }


        foreach ($Flow as $key => $value) {

            $Flow[ $key ]['utel']     = $infoArr[ $value['uid'] ]['utel'];
            $Flow[ $key ]['username'] = $infoArr[ $value['uid'] ]['username'];
            $Flow[ $key ]['nickname'] = $infoArr[ $value['uid'] ]['nickname'];

            $Flow[ $key ]['account'] = substr($value['note'], strrpos($value['note'], '[') + 1);
            $Flow[ $key ]['account'] = preg_replace("/]积分/", "", $Flow[ $key ]['account']);

            $Flow[ $key ]['operator'] = $infoArr1[ $value['op_id'] ]['username'];
        }

        //无分页
        foreach ($Flow_money as $key => $value) {
            $Flow_money[ $key ]['account'] = substr($value['note'], strrpos($value['note'], '[') + 1);
            $Flow_money[ $key ]['account'] = preg_replace("/]积分/", "", $Flow_money[ $key ]['account']);
            $money                         += $Flow_money[ $key ]['account'];
        }

        $this->assign('flow', $Flow);
        $this->assign('page', $show);
        $this->assign('sea', $sea);
        $this->assign('yunying', $userinfo->field('username,uid')
                                          ->where('otype=5')
                                          ->select());
        $this->assign('money', $money);
        $this->assign('info', $userinfo->field('uid,username')
                                       ->where(['otype' => 3])
                                       ->select());
        $this->display();
    }


    /**
     * [daochu_integralFlow 积分流水导出]
     * @author wang li
     */
    public function daochu_integralFlow()
    {
        //判断用户是否登陆
        $user = A('Admin/User');
        $user->checklogin();

        $MoneyFlow            = M('MoneyFlow');
        $userinfo             = M('userinfo');
        $UserinfoRelationship = M('UserinfoRelationship');
        $bankinfo             = M('bankinfo');

        $utel      = trim(I('get.utel'));
        $type      = trim(I('get.type'));
        $yunying   = trim(I('get.yunying'));
        $jingjiren = trim(I('get.jingjiren'));
        $user      = trim(I('get.user'));
        $starttime = urldecode(trim(I('get.starttime')));
        $endtime   = urldecode(trim(I('get.endtime')));
        $operator  = trim(I('get.operator'));  //操作人


        if ($utel) {
            $searchArr     = [];
            $where['utel'] = [
                'like',
                '%'.$utel.'%',
            ];
            $info          = $userinfo->where($where)
                                      ->select();
            foreach ($info as $key => $value) {
                array_push($searchArr, $value['uid']);
            }
            $searchId   = implode(',', array_unique($searchArr));
            $map['uid'] = [
                'in',
                $searchId,
            ];
        }

        if ($operator) {
            $map['op_id'] = $operator;
        }

        if ($yunying) {

            $relation     = $UserinfoRelationship->where(['parent_user_id' => $yunying])
                                                 ->select();
            $relationArr  = [];
            $relationArr1 = [];
            foreach ($relation as $key => $value) {
                array_push($relationArr, $value['user_id']);
            }
            $relationId = implode(',', array_unique($relationArr));
            $users      = $UserinfoRelationship->where('parent_user_id in('.$relationId.')')
                                               ->select();
            foreach ($users as $key => $value) {
                array_push($relationArr1, $value['user_id']);
            }
            $userId     = implode(',', array_unique($relationArr1));
            $map['uid'] = [
                'in',
                $userId,
            ];
        }

        if ($jingjiren) {
            $relationArr2   = [];
            $jingjiren_user = $UserinfoRelationship->where('parent_user_id in('.$jingjiren.')')
                                                   ->select();
            foreach ($jingjiren_user as $key => $value) {
                array_push($relationArr2, $value['user_id']);
            }
            $userId1    = implode(',', array_unique($relationArr2));
            $map['uid'] = [
                'in',
                $userId1,
            ];
        }

        if ($user) {
            $map['uid'] = $user;
        }

        if ($starttime && $endtime) {
            $start_time      = strtotime($starttime);
            $end_time        = strtotime($endtime);
            $map['dateline'] = [
                'between',
                ''.$start_time.','.$end_time.'',
            ];
        }
        else {
            $starttime       = strtotime(date('Y-m-d')." 06:00:00");
            $endtime         = strtotime(date('Y-m-d')." 05:00:00") + 3600 * 24;
            $map['dateline'] = [
                'between',
                ''.$starttime.','.$endtime.'',
            ];
        }

        $map['type']      = [
            'eq',
            6,
        ];
        $map['user_type'] = [
            'eq',
            1,
        ];


        $Flow = $MoneyFlow->where($map)
                          ->order('dateline  desc')
                          ->select();

        $flowArr  = [];
        $flowArr2 = [];
        foreach ($Flow as $key => $value) {
            array_push($flowArr, $value['uid']);
            array_push($flowArr2, $value['op_id']);
        }
        $flowId  = implode(',', array_unique($flowArr));
        $flowId1 = implode(',', array_unique($flowArr2));

        $info    = $userinfo->field('uid,username,utel,nickname')
                            ->where('uid in('.$flowId.')')
                            ->select();
        $infoArr = [];
        foreach ($info as $key => $value) {
            $infoArr[ $value['uid'] ] = $value;
        }

        $info1    = $userinfo->field('username,uid')
                             ->where('uid in('.$flowId1.')')
                             ->select();
        $infoArr1 = [];
        foreach ($info1 as $key => $value) {
            $infoArr1[ $value['uid'] ] = $value;
        }


        foreach ($Flow as $key => $value) {

            $Flow[ $key ]['utel']     = $infoArr[ $value['uid'] ]['utel'];
            $Flow[ $key ]['username'] = $infoArr[ $value['uid'] ]['username'];
            $Flow[ $key ]['nickname'] = $infoArr[ $value['uid'] ]['nickname'];

            $Flow[ $key ]['account'] = substr($value['note'], strrpos($value['note'], '[') + 1);
            $Flow[ $key ]['account'] = preg_replace("/]积分/", "", $Flow[ $key ]['account']);

            $Flow[ $key ]['operator'] = $infoArr1[ $value['op_id'] ]['username'];
        }


        $data[0] = [
            '编号',
            '用户名称',
            '用户昵称',
            '手机号码',
            '积分变动描述',
            '变动积分',
            '用户积分',
            '操作人',
            '操作时间',
        ];
        foreach ($Flow as $k => $v) {
            $data[ $k + 1 ][] = $v['id'];
            $data[ $k + 1 ][] = $v['username'];
            $data[ $k + 1 ][] = $v['nickname'];
            $data[ $k + 1 ][] = $v['utel'];
            $data[ $k + 1 ][] = $v['note'];
            $data[ $k + 1 ][] = number_format($v['account'], 2);
            $data[ $k + 1 ][] = $v['balance'];
            $data[ $k + 1 ][] = $v['operator'];
            $data[ $k + 1 ][] = date('Y-m-d H:i:s', $v['dateline']);
        }
        $name = '积分流水记录';      //生成的Excel文件文件名
        $res  = $this->push($data, $name);
    }


    /**
     * 省市联动
     * @author wang <li>
     */
    public function city()
    {
        if (IS_AJAX) {
            $id   = I('post.id');
            $city = M('city')
                ->where(['parent_id' => $id])
                ->select();
            if (!$city) {
                $this->ajaxReturn('不存在', 'JSON');
            }
            else {
                $this->ajaxReturn($city, 'JSON');
            }
        }
        else {
            $this->ajaxReturn('程序异常', 'JSON');
        }
    }


    public function push($data, $name)
    {
        import("Excel.class.php");
        $excel = new Excel();
        $excel->download($data, $name);
    }


    /**
     * 重置密码表单页
     * $uid  用户uid
     */
    public function resetpwd($uid = null)
    {
        if ($uid < 1) {
            redirect(U(''), 2, '用户id不存在');
        }
        $userinfo = M('userinfo')
            ->field('username')
            ->where(['uid' => $uid])
            ->find();
        $this->assign('username', $userinfo['username']);
        $this->assign('uid', $uid);
        $this->display();
    }

    public function resetop()
    {
        $uid       = I('post.uid', 0);
        $password  = I('post.password', null);
        $password2 = I('post.password2', null);
        if ($uid < 1) {
            $data['post']   = I('post.');
            $data['status'] = 0;
            $data['msg']    = '用户id不存在';
            $this->ajaxReturn($data, 'JSON');
        }

        if (trim($password) == '' || trim($password2) == '') {

            $data['status'] = 0;
            $data['msg']    = '密码不能为空';
            $this->ajaxReturn($data, 'JSON');
        }
        if (trim($password2) != $password) {

            $data['status'] = 0;
            $data['msg']    = '密码必须一致';
            $this->ajaxReturn($data, 'JSON');
        }

        if (!preg_match('/^[A-Za-z0-9]+$/', trim($password))) {

            $data['status'] = 0;
            $data['msg']    = '密码不能包含中文或特殊字符';
            $this->ajaxReturn($data, 'JSON');
        }

        $userObj = M('userinfo');
        $pwd     = ['upwd' => md5($password)];
        $userObj->where(['uid' => $uid])
                ->save($pwd);
        $data['status'] = 1;
        $data['msg']    = '修改成功';
        $this->ajaxReturn($data, 'JSON');
    }

    public function userdel()
    {
        $user = D('userinfo');
        //单个删除
        $uid    = I('get.uid');
        $result = $user->where(['uid='.$uid])
                       ->setField('ustatus', 2);         //用户 2已删除

        if ($result !== false) {
            $this->success("成功删除！", U("User/ulist"));
        }
        else {
            $this->error('删除失败！');
        }
    }


    public function checklogin()
    {
        $uid = islogin();
        if (!$uid) {
            $this->error('请登录', '/index.php/login/User/signin');
        }
    }


    /**
     * [dongtis 用户状态冻结]
     * @author wang li
     */
    public function dongtis()
    {
        $this->checklogin();

        $uid   = trim(I('get.uid'));
        $types = trim(I('get.types'));

        if ($types == 1) {
            $dongtis = M("userinfo")
                ->where("uid = '".$uid."'")
                ->setField('ustatus', 1);
        }
        else {
            $dongtis = M("userinfo")
                ->where("uid = '".$uid."'")
                ->setField('ustatus', 0);
        }

        if ($dongtis) {
            $this->success("操作成功!");
        }
        else {
            $this->error('操作失败,请重试!');
        }
    }


    private function get_username($uid = 0)
    {
        $info = M("userinfo")
            ->field('uid,username')
            ->where([
                'uid' => $uid,
            ])
            ->find();

        return $info ? $info : null;
    }

    public function online_user()
    {
        $set   = [
            'host'       => '127.0.0.1',
            'port'       => 11211,
            'timeout'    => false,
            'persistent' => false,
        ];
        $cache = \Think\Cache::getInstance("memcache", $set);
        $users = $cache->get("online_user");

        $loginUser = $guestUser = [];
        foreach ($users as $ssid => $user) {
            if ($user['lasttime'] < time() - 1800) {//3分钟内的才算在线
                unset($users[ $ssid ]);
            }
            elseif ($user['userid'] > 0) {
                $loginUser[] = $user;
            }
            elseif ($user['cuid'] > 0) {
                $user['userid'] = $user['cuid'];
                $loginUser[]    = $user;
            }
            else {
                $guestUser[] = $user;
            }
        }
        $cache->set("online_user", $users);

        $this->assign('users', $users);
        $this->assign('loginUser', $loginUser);
        $this->assign('guestUser', $guestUser);
        $this->display();
    }

    /**
     *    客户交易冻结
     * @author wang
     **/
    public function frozen()
    {
        $uid = trim(I('get.uid'));

        $trade_frozen = trim(I('get.trade_frozen'));

        if (empty($uid) || !isset($trade_frozen)) {
            $this->error('用户编号不存在');
        }

        $userinfoObj = M('userinfo');

        $res = $userinfoObj->execute('update '.C('DB_PREFIX').'userinfo set trade_frozen='.$trade_frozen.' where uid='.$uid.'');

        if ($res) {

            $this->success("操作成功！");

        }
        else {

            $this->error('操作失败！');
        }
    }

    /**
     * upgrade 升级用户为交易员
     * @author  fcb
     * @date    2018/7/3 15:46
     * @return void
     */
    public function upgrade()
    {
        $this->checklogin();

        $uid   = trim(I('get.uid'));
        $model = M('order_follow');
        $pre   = $model->where('user_id='.$uid)
                       ->getField('status');

        if ($pre) {
            if ($pre != 2) {
                $this->error('该用户正在跟随不可升级为交易员');
            }
        }


        if (empty($uid)) {
            $this->error('用户编号不存在');
        }

        $is_trader   = trim(I('get.is_trader'));
        $userinfoObj = M('userinfo');

        $res = $userinfoObj->execute('update '.C('DB_PREFIX').'userinfo set is_trader='.$is_trader.' where uid='.$uid.'');

        if (!$res) {
            $this->error('操作失败！');
        }
        $this->success("操作成功！");


    }

    /**
     * cusfrozen 冻结客户账号
     * @author fcb
     * @date   2018/7/3 16:44
     * @return void
     */
    public function cusfrozen()
    {
        $uid = trim(I('get.uid'));

        $trade_frozen = trim(I('get.trade_frozen'));

        if (empty($uid) || !isset($trade_frozen)) {
            $this->error('用户编号不存在');
        }

        $userinfoObj = M('userinfo');

        $res = $userinfoObj->execute('update '.C('DB_PREFIX').'userinfo set ustatus='.$trade_frozen.' where uid='.$uid.'');

        if ($res) {

            $this->success("操作成功！");

        }
        else {

            $this->error('操作失败！');
        }
    }

    //获取菜单
    private function get_menu($menu_id)
    {
        $data = M('menus')
            ->where([
                [
                    'id' => [
                        'in',
                        $menu_id,
                    ],
                ],
                ['is_show' => 1],
                ['is_menu' => 1],
            ])
            ->field('id,title,p_id,level,icon,controller,method,param')
            ->order('sort asc')
            ->select();

        $pid = [];

        foreach ($data as $key => $val) {
            if (!empty($val['p_id'])) {
                $pid[] = $val['p_id'];
            }
        }

        if (!empty($pid)) {
            $data = array_merge($data, $this->get_menu($pid));
        }

        return $data;
    }

    //获取全部菜单
    private function get_all_menu()
    {
        $data = M('menus')
            ->where([
                ['is_show' => 1],
                ['is_menu' => 1],
            ])
            ->field('id,title,p_id,level,icon,controller,method,param')
            ->order('sort asc')
            ->select();

        return $data;
    }

    private function admin_menus($array, $pid = 0)
    {
        $data = [];
        foreach ($array as $k => $v) {
            if ($v['p_id'] == $pid) {
                $child         = $this->admin_menus($array, $v['id']); //加入数组
                $v['children'] = $child ?: [];
                $data[]        = $v;//加入数组中
            }
        }

        return $data;
    }
}