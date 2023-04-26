<?php
namespace Admin\Controller;
class WithdrawController extends BaseController
{
    public function lists()
    {
        //判断用户是否登陆
        $user = A('Admin/User');
        $user->checklogin();

        $yunying   = trim(I('get.yunying')); //运营中心
        $jingjiren = trim(I('get.jingjiren')); //经纪人
        $user      = trim(I('get.user')); //用户
        $user_type = trim(I('get.user_type')); //用户类型
        $email     = trim(I('get.email')); //电子邮箱
        $status    = trim(I('get.status')); //提现状态
        $starttime = urldecode(trim(I('get.starttime')));
        $endtime   = urldecode(trim(I('get.endtime')));

        if ($yunying) {
            $relation     = M('userinfo_relationship')
                ->where(['parent_user_id' => $yunying])
                ->select();
            $relationArr  = [];
            $relationArr1 = [];
            foreach ($relation as $key => $value) {
                array_push($relationArr, $value['user_id']);
            }
            $relationId = implode(',', array_unique($relationArr));
            $users      = M('userinfo_relationship')
                ->where('parent_user_id in('.$relationId.')')
                ->select();
            foreach ($users as $key => $value) {
                array_push($relationArr1, $value['user_id']);
            }
            $userId         = implode(',', array_unique($relationArr1));
            $map['a.uid']   = [
                'in',
                $userId,
            ];
            $sea['yunying'] = $yunying;
            $this->assign('yunying', $yunying);
        }

        if ($jingjiren) {
            $relationArr2   = [];
            $jingjiren_user = M('userinfo_relationship')
                ->where('parent_user_id in('.$jingjiren.')')
                ->select();
            foreach ($jingjiren_user as $key => $value) {
                array_push($relationArr2, $value['user_id']);
            }
            $userId1          = implode(',', array_unique($relationArr2));
            $map['a.uid']     = [
                'in',
                $userId1,
            ];
            $sea['jingjiren'] = $jingjiren;
            $this->assign('jingjiren', $this->get_username($jingjiren));
        }

        if ($user) {
            $map['a.uid'] = $user;
            $sea['user']  = $user;
            $this->assign('user', $this->get_username($user));
        }

        if ($user_type) {
            $map['c.otype']   = $user_type;
            $sea['user_type'] = $user_type;
        }

        if ($email) {
            $map['c.email'] = $email;
            $sea['email']   = $email;
        }

        if ($status || $status == '0') {
            if ($status == '0') {
                $map['a.status'] = 0;
            }
            elseif ($status == 1) {
                $map['a.status'] = 1;
                $map['a.c_time'] = [
                    'exp',
                    'is not null',
                ];
            }
            else {
                $map['a.status'] = 2;
                $map['a.c_time'] = [
                    'exp',
                    'is null',
                ];
            }
            $sea['status'] = $status;
        }

        if ($starttime && $endtime) {
            $start_time           = strtotime($starttime);
            $end_time             = strtotime($endtime);
            $map['a.create_time'] = [
                'between',
                ''.$start_time.','.$end_time.'',
            ];
            $sea['starttime']     = $starttime;
            $sea['endtime']       = $endtime;
        }
        else {
            $starttime            = strtotime(date('Y-m-d')." 06:00:00");
            $endtime              = strtotime(date('Y-m-d')." 05:00:00") + 3600 * 24;
            $map['a.create_time'] = [
                'between',
                ''.$starttime.','.$endtime.'',
            ];
            $sea['starttime']     = date('Y-m-d H:i:s', $starttime);
            $sea['endtime']       = date('Y-m-d H:i:s', $endtime);
        }

        $withdrawObj = M('withdraw a');

        $count = $withdrawObj->join('wp_userinfo as c on a.uid = c.uid')
                             ->join('left join wp_accountinfo as d on a.uid = d.uid')
                             ->where($map)
                             ->count();

        //分页
        $pagecount       = 10;
        $page            = new \Think\Page($count, $pagecount);
        $page->parameter = $sea; //此处的row是数组，为了传递查询条件
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '&#8249;');
        $page->setConfig('next', '&#8250;');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();

        $rechargelist = $withdrawObj->join('left join wp_userinfo as c on a.uid = c.uid')
                                    ->join('left join wp_accountinfo as d on a.uid = d.uid')
                                    ->where($map)
                                    ->order('a.id desc')
                                    ->limit($page->firstRow.','.$page->listRows)
                                    ->select();

        $sum = $withdrawObj->join('left join wp_userinfo as c on a.uid = c.uid')
                           ->join('left join wp_accountinfo as d on a.uid = d.uid')
                           ->where($map)
                           ->select();

        $amount = '';
        foreach ($sum as $key => $value) {
            if ($value['status'] == 1) {
                $amount['chengong'] += $value['amount'];
            }

            $amount['amount'] += $value['amount'];
        }


        $this->assign('rechargelist', $rechargelist);
        $this->assign('page', $show);
        $this->assign('sea', $sea);
        $this->assign('amount', $amount);
        $this->assign('info', M('userinfo')
            ->where(['otype' => 5])
            ->select());
        $this->display();
    }

    public function daochu_withdrawal()
    {
        //判断用户是否登陆
        $user = A('Admin/User');
        $user->checklogin();

        $yunying   = trim(I('get.yunying')); //运营中心
        $jingjiren = trim(I('get.jingjiren')); //经纪人
        $user      = trim(I('get.user')); //用户
        $user_type = trim(I('get.user_type')); //用户类型
        $email      = trim(I('get.email')); //电子邮箱
        $status    = trim(I('get.status')); //提现状态
        $starttime = urldecode(trim(I('get.starttime')));
        $endtime   = urldecode(trim(I('get.endtime')));

        if ($yunying) {
            $relation     = M('userinfo_relationship')
                ->where(['parent_user_id' => $yunying])
                ->select();
            $relationArr  = [];
            $relationArr1 = [];
            foreach ($relation as $key => $value) {
                array_push($relationArr, $value['user_id']);
            }
            $relationId = implode(',', array_unique($relationArr));
            $users      = M('userinfo_relationship')
                ->where('parent_user_id in('.$relationId.')')
                ->select();
            foreach ($users as $key => $value) {
                array_push($relationArr1, $value['user_id']);
            }
            $userId       = implode(',', array_unique($relationArr1));
            $map['a.uid'] = [
                'in',
                $userId,
            ];
        }

        if ($jingjiren) {
            $relationArr2   = [];
            $jingjiren_user = M('userinfo_relationship')
                ->where('parent_user_id in('.$jingjiren.')')
                ->select();
            foreach ($jingjiren_user as $key => $value) {
                array_push($relationArr2, $value['user_id']);
            }
            $userId1      = implode(',', array_unique($relationArr2));
            $map['a.uid'] = [
                'in',
                $userId1,
            ];
        }

        if ($user) {
            $map['a.uid'] = $user;
        }

        if ($user_type) {
            $map['c.otype'] = $user_type;
        }

        if ($email) {
            $map['c.email'] = $email;
        }

        if ($status || $status == '0') {
            if ($status == '0') {
                $map['a.status'] = 0;
            }
            elseif ($status == 1) {
                $map['a.status'] = 1;
                $map['a.c_time'] = [
                    'exp',
                    'is not null',
                ];
            }
            else {
                $map['a.status'] = 2;
                $map['a.c_time'] = [
                    'exp',
                    'is null',
                ];
            }
        }

        if ($starttime && $endtime) {
            $start_time           = strtotime($starttime);
            $end_time             = strtotime($endtime);
            $map['a.create_time'] = [
                'between',
                ''.$start_time.','.$end_time.'',
            ];
        }
        else {
            $starttime            = strtotime(date('Y-m-d')." 06:00:00");
            $endtime              = strtotime(date('Y-m-d')." 05:00:00") + 3600 * 24;
            $map['a.create_time'] = [
                'between',
                ''.$starttime.','.$endtime.'',
            ];
        }

        $withdrawObj = M('withdraw a');

        $rechargelist = $withdrawObj->join('left join wp_userinfo as c on a.uid = c.uid')
                                    ->join('left join wp_accountinfo as d on a.uid = d.uid')
                                    ->where($map)
                                    ->order('a.id desc')
                                    ->select();

        $data[0] = [
            '编号',
            '用户名称',
            '电子邮箱',
            '用户类型',
            '银行名称',
            '开户行',
            '开户地址',
            '卡号',
            '汇款代码',
            '姓名',
            '操作时间',
            '处理时间',
            '提现金额',
            '账户余额',
            '状态',
        ];
        foreach ($rechargelist as $k => $v) {
            $cltime = empty($v['c_time']) ? '--' : date('Y-m-d H:i:s', $v['c_time']);

            if ($v['otype'] == 4) {
                $otype = '普通客户';
            }
            elseif ($v['otype'] == 5) {
                $otype = '运营中心';
            }
            elseif ($v['otype'] == 6) {
                $otype = '销售商';
            }

            $data[ $k + 1 ][] = $v['id'];
            $data[ $k + 1 ][] = getUsername($v['uid']);
            $data[ $k + 1 ][] = $v['email'];
            $data[ $k + 1 ][] = $otype;
            $data[ $k + 1 ][] = $v['bankname'];
            $data[ $k + 1 ][] = $v['branch'];
            $data[ $k + 1 ][] = $v['address'];
            $data[ $k + 1 ][] = $v['banknumber'];
            $data[ $k + 1 ][] = $v['swiftcode'];
            $data[ $k + 1 ][] = $v['busername'];
            $data[ $k + 1 ][] = date("Y-m-d H:i:s", $v['create_time']);
            $data[ $k + 1 ][] = $cltime;
            $data[ $k + 1 ][] = number_format($v['amount'], 2);
            $data[ $k + 1 ][] = number_format($v['balance'], 2);
            if (empty($v['c_time']) && $v['status'] == '0') {
                $data[ $k + 1 ][] = '未处理';
            }
            else {
                if ($v['status'] == 1) {
                    $data[ $k + 1 ][] = '提现成功';
                }
                else {
                    $data[ $k + 1 ][] = '提现失败';
                }
            }
        }
        $name = '提现流水记录'; //生成的Excel文件文件名
        $this->push($data, $name);
    }

    //更新充值提现状态
    public function upbalance()
    {
        $uid = islogin();
        if (!$uid) {
            $this->ajaxReturn('login');
        }

        //获取参数
        $bpid       = trim(I('post.bpid'));
        $isverified = trim(I('post.isverified'));
        $remarks    = trim(I('post.remarks'));
        $c_time     = time();

        $withdrawObj = M('withdraw');

        $balance = $withdrawObj->where(['id' => $bpid])
                               ->find();
        if (!empty($balance['c_time']) && $balance['status'] != '0') {
            $this->ajaxReturn("null");
        }

        $userid = $balance['uid'];

        if ($isverified == 1) { //同意

            $data['status']  = 1;
            $data['c_time']  = $c_time;
            $data['remarks'] = $remarks;
            $isver           = $withdrawObj->where(['id' => $bpid])
                                           ->save($data);
            if($isver) {
                $accountArr = [
                    'money_total' => [
                        'exp',
                        '`money_total`+'.$balance['amount'].'',
                    ],
                ];

                M('accountinfo')->where(['uid' => $userid])->save($accountArr);
            }
        }
        else { //拒绝
            $data['c_time']  = $c_time;
            $data['status']  = 2;
            $data['remarks'] = $remarks;
            $res             = $withdrawObj->where(['id' => $bpid])
                                           ->save($data);

            if ($res) {
                $isver = M("accountinfo")
                    ->where([
                        'uid' => $userid,
                    ])
                    ->setInc('balance', $balance['amount']);
                $infos = M('userinfo')
                    ->where([
                        'uid' => $userid,
                    ])
                    ->find();
                if ($infos['otype'] == 5) {
                    $map['user_type'] = 2;
                }
                //用户资金流水表
                $map['uid']      = $userid;
                $map['type']     = 3;
                $map['oid']      = $bpid;
                $map['note']     = '管理员拒绝提现增加['.$balance['amount'].']美元';
                $map['en_note']  = 'Administrators refuse to raise cash['.$balance['amount'].']dollar';
                $map['balance']  = M('accountinfo')
                    ->where(['uid' => $userid])
                    ->sum('balance');
                $map['op_id']    = session('userid');
                $map['dateline'] = time();
                $money_flow      = M("MoneyFlow")->add($map);
            }
        }

        if ($isver) {
            $this->ajaxReturn("success");
        }
        else {
            $this->ajaxReturn("null");
        }
    }

    /*
     * 用户出入金统计
     */
    public function tongji()
    {
        //判断用户是否登陆
        $user = A('Admin/User');
        $user->checklogin();

        $yunying   = trim(I('get.yunying')); //运营中心
        $jingjiren = trim(I('get.jingjiren')); //经纪人
        $user      = trim(I('get.user')); //用户

        $level    = trim(I('get.level')); //用户类型
        $utel     = trim(I('get.utel')); //手机号码
        $username = trim(I('get.username')); //用户名
        $nickname = trim(I('get.nickname')); //昵称
        $uid      = trim(I('get.uid')); //编号

        $starttime = urldecode(trim(I('get.starttime')));
        $endtime   = urldecode(trim(I('get.endtime')));

        if ($yunying) {
            $relation     = M('userinfo_relationship')
                ->where(['parent_user_id' => $yunying])
                ->select();
            $relationArr  = [];
            $relationArr1 = [];
            foreach ($relation as $key => $value) {
                array_push($relationArr, $value['user_id']);
            }
            $relationId = implode(',', array_unique($relationArr));
            $users      = M('userinfo_relationship')
                ->where('parent_user_id in('.$relationId.')')
                ->select();
            foreach ($users as $key => $value) {
                array_push($relationArr1, $value['user_id']);
            }
            $userId         = implode(',', array_unique($relationArr1));
            $map['a.uid']   = [
                'in',
                $userId,
            ];
            $sea['yunying'] = $yunying;
            $this->assign('yunying', $yunying);
        }

        if ($jingjiren) {
            $relationArr2   = [];
            $jingjiren_user = M('userinfo_relationship')
                ->where('parent_user_id in('.$jingjiren.')')
                ->select();
            foreach ($jingjiren_user as $key => $value) {
                array_push($relationArr2, $value['user_id']);
            }
            $userId1          = implode(',', array_unique($relationArr2));
            $map['a.uid']     = [
                'in',
                $userId1,
            ];
            $sea['jingjiren'] = $jingjiren;
            $this->assign('jingjiren', $this->get_username($jingjiren));
        }

        if ($user) {
            $map['a.uid'] = $user;
            $sea['user']  = $user;
            $this->assign('user', $this->get_username($user));
        }

        if ($level) {
            $agentArr2                = [];
            $where['extension_level'] = $level;
            $where['otype']           = 4;
            $userinfo                 = M('userinfo')
                ->where($where)
                ->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }
            $agentId = implode(',', array_unique($agentArr2));

            if (!empty($agentId)) {
                $userArr         = [];
                $wheres['rid']   = [
                    'in',
                    $agentId,
                ];
                $wheres['otype'] = 4;
                $users           = M('userinfo')
                    ->where($wheres)
                    ->select();
                foreach ($users as $key => $value) {
                    array_push($userArr, $value['uid']);
                }
                $userId = implode(',', array_unique($userArr));
                if (!empty($userId)) {
                    $userIdStr = $userId.','.$agentId;
                }
                else {
                    $userIdStr = $agentId;
                }
            }
            else {
                $userIdStr = 1 - 1;
            }

            $map['a.uid'] = [
                'in',
                $userIdStr,
            ];

            $sea['level'] = $level;
            $this->assign('levels', $level);
        }

        if ($utel) {
            $map['a.utel'] = $utel;
            $sea['utel']   = $utel;
            $this->assign('utel', $utel);
        }

        if ($username) {
            $map['a.username'] = $username;
            $sea['username']   = $username;
            $this->assign('username', $username);
        }

        if ($nickname) {
            $map['a.nickname'] = $nickname;
            $sea['nickname']   = $nickname;
            $this->assign('nickname', $nickname);
        }

        if ($uid) {
            $map['a.uid'] = $uid;
            $sea['uid']   = $uid;
            $this->assign('uid', $uid);
        }

        if ($starttime && $endtime) {
            $start_time       = strtotime($starttime);
            $end_time         = strtotime($endtime);
            $map['a.utime']   = [
                'between',
                ''.$start_time.','.$end_time.'',
            ];
            $sea['starttime'] = $starttime;
            $sea['endtime']   = $endtime;
        }

        $map['otype'] = 4;

        $prefix = C('DB_PREFIX');

        $count = M('userinfo a')
            ->join('left join '.$prefix.'accountinfo as b on a.uid = b.uid')
            ->where($map)
            ->count();

        //分页
        $pagecount       = 10;
        $page            = new \Think\Page($count, $pagecount);
        $page->parameter = $sea; //此处的row是数组，为了传递查询条件
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '&#8249;');
        $page->setConfig('next', '&#8250;');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();

        $field      = 'a.*,b.recharge_total,b.money_total,b.balance';
        $userinfoRs = M('userinfo a')
            ->field($field)
            ->join('left join '.$prefix.'accountinfo as b on a.uid = b.uid')
            ->where($map)
            ->limit($page->firstRow.','.$page->listRows)
            ->order('utime desc')
            ->select();
        foreach ($userinfoRs as $k => $v) {
            $userinfoRs[ $k ]['net_gold'] = number_format($v['recharge_total'] - $v['money_total'], 2);
        }

        //底部出入金统计
        $tongji = M('userinfo a')
            ->field($field)
            ->join('left join '.$prefix.'accountinfo as b on a.uid = b.uid')
            ->where($map)
            ->select();
        foreach ($tongji as $key => $value) {
            $data['recharge_total'] += $value['recharge_total'];
            $data['money_total']    += $value['money_total'];
            //$data['net_gold'] += number_format($value['recharge_total'] - $value['money_total'], 2);
            $data['balance'] += $value['balance'];
        }

        $data['net_gold'] = number_format($data['recharge_total'] - $data['money_total'], 2);
        $this->assign('data', $data);

        //用户级别
        $level = M('userinfo_rate')
            ->field('id,name')
            ->select();
        $this->assign('level', $level);

        $this->assign('userinfoRs', $userinfoRs);
        $this->assign('page', $show);
        $this->assign('sea', $sea);
        $this->assign('info', M('userinfo')
            ->where(['otype' => 5])
            ->select());
        $this->display();
    }

    public function tongji_daochu()
    {
        //判断用户是否登陆
        $user = A('Admin/User');
        $user->checklogin();

        $yunying   = trim(I('get.yunying')); //运营中心
        $jingjiren = trim(I('get.jingjiren')); //经纪人
        $user      = trim(I('get.user')); //用户

        $level    = trim(I('get.level')); //用户类型
        $utel     = trim(I('get.utel')); //手机号码
        $username = trim(I('get.username')); //用户名
        $nickname = trim(I('get.nickname')); //昵称
        $uid      = trim(I('get.uid')); //编号

        $starttime = urldecode(trim(I('get.starttime')));
        $endtime   = urldecode(trim(I('get.endtime')));

        if ($yunying) {
            $relation     = M('userinfo_relationship')
                ->where(['parent_user_id' => $yunying])
                ->select();
            $relationArr  = [];
            $relationArr1 = [];
            foreach ($relation as $key => $value) {
                array_push($relationArr, $value['user_id']);
            }
            $relationId = implode(',', array_unique($relationArr));
            $users      = M('userinfo_relationship')
                ->where('parent_user_id in('.$relationId.')')
                ->select();
            foreach ($users as $key => $value) {
                array_push($relationArr1, $value['user_id']);
            }
            $userId       = implode(',', array_unique($relationArr1));
            $map['a.uid'] = [
                'in',
                $userId,
            ];
        }

        if ($jingjiren) {
            $relationArr2   = [];
            $jingjiren_user = M('userinfo_relationship')
                ->where('parent_user_id in('.$jingjiren.')')
                ->select();
            foreach ($jingjiren_user as $key => $value) {
                array_push($relationArr2, $value['user_id']);
            }
            $userId1      = implode(',', array_unique($relationArr2));
            $map['a.uid'] = [
                'in',
                $userId1,
            ];
        }

        if ($user) {
            $map['a.uid'] = $user;
        }

        if ($level) {
            $agentArr2                = [];
            $where['extension_level'] = $level;
            $where['otype']           = 4;
            $userinfo                 = M('userinfo')
                ->where($where)
                ->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }
            $agentId = implode(',', array_unique($agentArr2));

            if (!empty($agentId)) {
                $userArr         = [];
                $wheres['rid']   = [
                    'in',
                    $agentId,
                ];
                $wheres['otype'] = 4;
                $users           = M('userinfo')
                    ->where($wheres)
                    ->select();
                foreach ($users as $key => $value) {
                    array_push($userArr, $value['uid']);
                }
                $userId = implode(',', array_unique($userArr));
                if (!empty($userId)) {
                    $userIdStr = $userId.','.$agentId;
                }
                else {
                    $userIdStr = $agentId;
                }
            }
            else {
                $userIdStr = 1 - 1;
            }

            $map['a.uid'] = [
                'in',
                $userIdStr,
            ];
        }

        if ($utel) {
            $map['a.utel'] = $utel;
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

        if ($starttime && $endtime) {
            $start_time     = strtotime($starttime);
            $end_time       = strtotime($endtime);
            $map['a.utime'] = [
                'between',
                ''.$start_time.','.$end_time.'',
            ];
        }

        $map['otype'] = 4;

        $prefix = C('DB_PREFIX');

        $field      = 'a.*,b.recharge_total,b.money_total,b.balance';
        $userinfoRs = M('userinfo a')
            ->field($field)
            ->join('left join '.$prefix.'accountinfo as b on a.uid = b.uid')
            ->where($map)
            ->order('utime desc')
            ->select();
        foreach ($userinfoRs as $k => $v) {
            $userinfoRs[ $k ]['net_gold'] = number_format($v['recharge_total'] - $v['money_total'], 2);

            //累计佣金
            $userinfoRs[ $k ]['fee_profit'] = M('fee_receive')
                ->where('status=1 and user_id = '.$v['uid'].'')
                ->sum('profit');
        }

        $data[0] = [
            '编号ID',
            '用户名称',
            '手机号码',
            '用户昵称',
            '注册时间',
            '总入金',
            '总出金',
            '净入金',
            '累计佣金',
            '当前资金',
        ];
        foreach ($userinfoRs as $k => $v) {
            $data[ $k + 1 ][] = $v['uid'];
            $data[ $k + 1 ][] = $v['username'];
            $data[ $k + 1 ][] = $v['utel'];
            $data[ $k + 1 ][] = $v['nickname'];
            $data[ $k + 1 ][] = date("Y-m-d H:i:s", $v['utime']);
            $data[ $k + 1 ][] = number_format($v['recharge_total'], 2);
            $data[ $k + 1 ][] = number_format($v['money_total'], 2);
            $data[ $k + 1 ][] = number_format($v['net_gold'], 2);
            $data[ $k + 1 ][] = number_format($v['fee_profit'], 2);
            $data[ $k + 1 ][] = number_format($v['balance'], 2);
        }
        $name = '出入金统计'; //生成的Excel文件文件名
        $res  = $this->push($data, $name);
    }

    /**
     * 导入Excel类
     */
    public function push($data, $name)
    {
        import("Excel.class.php");
        $excel = new Excel();
        $excel->download($data, $name);
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
}
