<?php

namespace Agent\Controller;

class UserController extends CommonController
{

    /**
     * @functionname: user_list
     * @author      : FrankHong
     * @date        : 2016-11-30 17:15:22
     * @description : 运营中心下的所有用户列表
     * @note        :
     */
    public function user_list()
    {
        $start_time = urldecode(trim(I('get.start_time')));
        $end_time   = urldecode(trim(I('get.end_time')));
        $email      = trim(I('get.email'));
        $jostyle    = trim(I('get.jostyle'));

        $username = trim(I('get.username'));
        $nickname = trim(I('get.nickname'));
        $uid      = trim(I('get.uid'));
        $level    = trim(I('get.level'));

        $userinfoObj = M('userinfo');

        //经纪人
        $whereArr = [
            'rid' => NOW_UID,
        ];

        $userData = $userinfoObj->field('uid')
                                ->where($whereArr)
                                ->select();

        $userIdArr = [];
        foreach ($userData as $k => $v) {
            array_push($userIdArr, $v['uid']);
        }

        $userIdStr = implode(',', array_unique($userIdArr));


        //时间筛选
        if ($start_time && $end_time) {
            $agentArr1    = [];
            $starttime    = strtotime($start_time);
            $endtime      = strtotime($end_time);
            $map['utime'] = [
                'between',
                ''.$starttime.','.$endtime.'',
            ];
            $map['otype'] = 4;
            $map['uid']   = [
                'in',
                $userIdStr,
            ];
            $userinfo     = $userinfoObj->where($map)
                                        ->select();

            foreach ($userinfo as $key => $value) {
                array_push($agentArr1, $value['uid']);
            }
            $userId             = implode(',', array_unique($agentArr1));
            $userIdStr          = $userId;
            $time['start_time'] = $start_time;
            $time['end_time']   = $end_time;
            $this->assign('time', $time);
        }

        //电子邮箱筛选
        if ($email) {
            $agentArr2    = [];
            $map['email'] = [
                'like',
                '%'.$email.'%',
            ];
            $map['otype'] = 4;
            $map['uid']   = [
                'in',
                $userIdStr,
            ];
            $userinfo     = $userinfoObj->where($map)
                                        ->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr2));
            $userId    = empty($userId) ? 1 - 1 : $userId;
            $userIdStr = $userId;
            $this->assign('email', $email);
        }

        //用户类型筛选
        if ($jostyle) {
            $this->assign('jostyle', $jostyle);
            $agentArr3           = [];
            $jostyle             = $jostyle == 1 ? 1 : 0;
            $map['trade_frozen'] = $jostyle;
            $map['otype']        = 4;
            $map['uid']          = [
                'in',
                $userIdStr,
            ];
            $userinfo            = $userinfoObj->where($map)
                                               ->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr3, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr3));
            $userIdStr = $userId;
        }

        //用户名称
        if ($username) {
            $agentArr2       = [];
            $map['username'] = [
                'like',
                '%'.$username.'%',
            ];
            $map['otype']    = 4;
            $map['uid']      = [
                'in',
                $userIdStr,
            ];
            $userinfo        = $userinfoObj->where($map)
                                           ->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr2));
            $userId    = empty($userId) ? 1 - 1 : $userId;
            $userIdStr = $userId;
            $this->assign('username', $username);
        }

        //用户昵称
        if ($nickname) {
            $agentArr2       = [];
            $map['nickname'] = [
                'like',
                '%'.$nickname.'%',
            ];
            $map['otype']    = 4;
            $map['uid']      = [
                'in',
                $userIdStr,
            ];
            $userinfo        = $userinfoObj->where($map)
                                           ->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr2));
            $userId    = empty($userId) ? 1 - 1 : $userId;
            $userIdStr = $userId;
            $this->assign('nickname', $nickname);
        }

        //用户编号
        if ($uid) {
            $agentArr2    = [];
            $map['otype'] = 4;
            $map['uid']   = [
                'in',
                $userIdStr,
            ];
            $userinfo     = $userinfoObj->where($map)
                                        ->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }

            if (in_array($uid, $agentArr2)) {
                $userId = empty($uid) ? 1 - 1 : $uid;
            }

            $userIdStr = $userId;
            $this->assign('uid', $uid);
        }

        //当前星级筛选
        if ($level) {
            $agentArr2              = [];
            $map['otype']           = 4;
            $map['uid']             = [
                'in',
                $userIdStr,
            ];
            $map['extension_level'] = $level;
            $userinfo               = $userinfoObj->where($map)
                                                  ->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }

            $userId = implode(',', array_unique($agentArr2));
            $userId = empty($userId) ? 1 - 1 : $userId;

            $userIdStr = $userId;
            $this->assign('level', $level);
        }


        $prefix = C('DB_PREFIX');

        //需要从这里添加条件
        $userinfoWhereArr = 'a.uid in ('.$userIdStr.') and a.ustatus=0';

        //排序
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


        $count = M('userinfo a')
            ->join('left join '.$prefix.'accountinfo as b on a.uid = b.uid')
            ->where($userinfoWhereArr)
            ->count();

        $pageObj  = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow = $pageObj->show();

        $field      = 'a.*,b.balance,b.gold,b.integral,b.recharge_total,b.money_total,c.money';
        $userinfoRs = M('userinfo a')
            ->field($field)
            ->join('left join '.$prefix.'accountinfo as b on a.uid = b.uid')
            ->join('left join '.$prefix.'extension as c on a.uid = c.user_id')
            ->where($userinfoWhereArr)
            ->order($sort)
            ->limit($pageObj->firstRow, $pageObj->listRows)
            ->select();

        $userinfoRs1 = [];
        foreach ($userinfoRs as $k => $v) {
            $userinfoRs1[ $v['uid'] ]                   = $v;
            $userinfoRs1[ $v['uid'] ]['agent_username'] = $agentinfoRs1[ $userRelArr[ $v['uid'] ]['agent_id'] ]['username'];
            $userinfoRs1[ $v['uid'] ]['agent_id']       = $userRelArr[ $v['uid'] ]['agent_id'];
        }


        foreach ($userinfoRs1 as $k => $v) {
            $userinfoRs2[ $k ]                = $v;
            $userinfoRs2[ $k ]['last_login']  = !empty($v['lastlog']) ? date('Y-m-d H:i:s', $v['lastlog']) : '<span class="label label-sm label-warning">未登录过</span>';
            $userinfoRs2[ $k ]['create_date'] = date('Y-m-d H:i:s', $v['utime']);


            $userinfoRs2[ $k ]['trade_frozen_name'] = $v['trade_frozen'] == 0 ? '<span class="label label-sm label-success">正常</span>' : '<span class="label label-sm label-warning">冻结</span>';

            $userinfoRs2[ $k ]['trade_frozen_o'] = $v['trade_frozen'] == 0 ? '冻结' : '激活';
            $userinfoRs2[ $k ]['trade_frozen_s'] = $v['trade_frozen'] == 0 ? 1 : 0;

            $counts                     = M('order')
                ->where([
                    'uid'  => $v['uid'],
                    'type' => 1,
                ])
                ->count();
            $userinfoRs2[ $k ]['count'] = $counts;
            //订单统计，持仓平仓条数
            $userinfoRs2[ $k ]['total_jc'] = M('order')
                ->where([
                    'uid'    => $v['uid'],
                    'ostaus' => '0',
                    'type'   => 1,
                ])
                ->count();
            $userinfoRs2[ $k ]['total_pc'] = M('order')
                ->where([
                    'uid'    => $v['uid'],
                    'ostaus' => '1',
                    'type'   => 1,
                ])
                ->count();
        }


        //星级列表 用于筛选
        $levelData = M('UserinfoRate')->getField('id,name,id', true);
        $this->assign('levelData', $levelData);

        foreach ($userinfoRs2 as $key => $value) {
            $userinfoRs2[ $key ]['level_name'] = $levelData[ $value['extension_level'] ]['name'];

            //统计下级用户个数
            if (!empty($value['code'])) {
                $userinfoRs2[ $key ]['user_count'] = M('userinfo')
                    ->where('otype=4 and ustatus=0 and rid='.$value['uid'].'')
                    ->count();
            }
            else {
                $userinfoRs2[ $key ]['user_count'] = 0;
            }
        }


        // vD($userinfoRs2);

        //底部统计
        $accountinfoRs = M('userinfo a')
            ->join('left join '.$prefix.'accountinfo as b on a.uid = b.uid')
            ->where($userinfoWhereArr)
            ->select();
        foreach ($accountinfoRs as $k => $v) {
            $acount['balance']        += $v['balance'];
            $acount['gold']           += $v['gold'];
            $acount['integral']       += $v['integral'];
            $acount['recharge_total'] += $v['recharge_total'];
            $acount['money_total']    += $v['money_total'];
        }

        //佣金计算
        $acount['fee_receive'] = M("userinfo a")
            ->field($field)
            ->join('left join wp_extension as d on a.uid = d.user_id')
            ->where($userinfoWhereArr)
            ->sum('money');

        $this->assign('account', $acount);


        $nowStart = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd   = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;


        $this->assign('userInfo', $userinfoRs2);
        $this->assign('totalCount', $count);

        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->display();
    }


    /**
     * @functionname: user_detail
     * @author      : FrankHong
     * @date        : 2016-11-30 19:35:57
     * @description : 用户列表导出excel
     * @note        :
     */
    public function user_daochu()
    {
        $start_time = urldecode(trim(I('get.start_time')));
        $end_time   = urldecode(trim(I('get.end_time')));
        $email      = trim(I('get.email'));
        $jostyle    = trim(I('get.jostyle'));

        $username = trim(I('get.username'));
        $nickname = trim(I('get.nickname'));
        $uid      = trim(I('get.uid'));

        $userinfoObj = M('userinfo');

        //经纪人
        $whereArr = [
            'rid' => NOW_UID,
        ];

        $userData = $userinfoObj->field('uid')
                                ->where($whereArr)
                                ->select();

        $userIdArr = [];
        foreach ($userData as $k => $v) {
            array_push($userIdArr, $v['uid']);
        }

        $userIdStr = implode(',', array_unique($userIdArr));


        //时间筛选
        if ($start_time && $end_time) {
            $agentArr1    = [];
            $starttime    = strtotime($start_time);
            $endtime      = strtotime($end_time);
            $map['utime'] = [
                'between',
                ''.$starttime.','.$endtime.'',
            ];
            $map['otype'] = 4;
            $map['uid']   = [
                'in',
                $userIdStr,
            ];
            $userinfo     = $userinfoObj->where($map)
                                        ->select();

            foreach ($userinfo as $key => $value) {
                array_push($agentArr1, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr1));
            $userIdStr = $userId;
        }

        //电子邮箱筛选
        if ($email) {
            $agentArr2    = [];
            $map['email'] = [
                'like',
                '%'.$email.'%',
            ];
            $map['otype'] = 4;
            $map['uid']   = [
                'in',
                $userIdStr,
            ];
            $userinfo     = $userinfoObj->where($map)
                                        ->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr2));
            $userId    = empty($userId) ? 1 - 1 : $userId;
            $userIdStr = $userId;
        }

        //用户类型筛选
        if ($jostyle) {
            $this->assign('jostyle', $jostyle);
            $agentArr3           = [];
            $jostyle             = $jostyle == 1 ? 1 : 0;
            $map['trade_frozen'] = $jostyle;
            $map['otype']        = 4;
            $map['uid']          = [
                'in',
                $userIdStr,
            ];
            $userinfo            = $userinfoObj->where($map)
                                               ->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr3, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr3));
            $userIdStr = $userId;
        }

        //用户名称
        if ($username) {
            $agentArr2       = [];
            $map['username'] = [
                'like',
                '%'.$username.'%',
            ];
            $map['otype']    = 4;
            $map['uid']      = [
                'in',
                $userIdStr,
            ];
            $userinfo        = $userinfoObj->where($map)
                                           ->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr2));
            $userId    = empty($userId) ? 1 - 1 : $userId;
            $userIdStr = $userId;
        }

        //用户昵称
        if ($nickname) {
            $agentArr2       = [];
            $map['nickname'] = [
                'like',
                '%'.$nickname.'%',
            ];
            $map['otype']    = 4;
            $map['uid']      = [
                'in',
                $userIdStr,
            ];
            $userinfo        = $userinfoObj->where($map)
                                           ->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr2));
            $userId    = empty($userId) ? 1 - 1 : $userId;
            $userIdStr = $userId;
        }

        //用户编号
        if ($uid) {
            $agentArr2    = [];
            $map['otype'] = 4;
            $map['uid']   = [
                'in',
                $userIdStr,
            ];
            $userinfo     = $userinfoObj->where($map)
                                        ->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }

            if (in_array($uid, $agentArr2)) {
                $userId = empty($uid) ? 1 - 1 : $uid;
            }

            $userIdStr = $userId;
        }


        $prefix = C('DB_PREFIX');

        //需要从这里添加条件
        $userinfoWhereArr = 'a.uid in ('.$userIdStr.') and a.ustatus=0';

        //排序
        $sort = 'a.utime desc';
        //余额排序
        $cat   = trim(I('get.cat'));
        $sorts = trim(I('get.sort'));
        if ($cat) {
            $sort = $cat.' '.$sorts.'';
        }


        $field      = 'a.*,b.balance,b.gold,b.integral,b.recharge_total,b.money_total,c.money';
        $userinfoRs = M('userinfo a')
            ->field($field)
            ->join('left join '.$prefix.'accountinfo as b on a.uid = b.uid')
            ->join('left join '.$prefix.'extension as c on a.uid = c.user_id')
            ->where($userinfoWhereArr)
            ->order($sort)
            ->select();

        $userinfoRs1 = [];
        foreach ($userinfoRs as $k => $v) {
            $userinfoRs1[ $v['uid'] ] = $v;
        }


        foreach ($userinfoRs1 as $k => $v) {
            $userinfoRs2[ $k ]                = $v;
            $userinfoRs2[ $k ]['last_login']  = !empty($v['lastlog']) ? date('Y-m-d H:i:s', $v['lastlog']) : '未登录过';
            $userinfoRs2[ $k ]['create_date'] = date('Y-m-d H:i:s', $v['utime']);


            $userinfoRs2[ $k ]['trade_frozen_name'] = $v['trade_frozen'] == 0 ? '正常' : '冻结';


            $count                      = M('order')
                ->where([
                    'uid'  => $v['uid'],
                    'type' => 1,
                ])
                ->count();
            $userinfoRs2[ $k ]['count'] = $count;
        }

        //星级列表 用于筛选
        $levelData = M('UserinfoRate')->getField('id,name,id', true);
        $this->assign('levelData', $levelData);

        foreach ($userinfoRs2 as $key => $value) {
            $userinfoRs2[ $key ]['level_name'] = $levelData[ $value['extension_level'] ]['name'];

            //统计下级用户个数
            if (!empty($value['code'])) {
                $userinfoRs2[ $key ]['user_count'] = M('userinfo')
                    ->where('otype=4 and ustatus=0 and rid='.$value['uid'].'')
                    ->count();
            }
            else {
                $userinfoRs2[ $key ]['user_count'] = 0;
            }
        }


        $data[0] = [
            '编号',
            '用户名称',
            '电子邮箱',
            '用户昵称',
            '当前级别',
            '上级',
            '下级用户',
            '创建日期',
            '最近登录时间',
            '订单数量',
            '账户余额',
            '账户模拟',
            '累计充值',
            '累计提现',
            '当前佣金',
            '当前状态',
        ];
        foreach ($userinfoRs2 as $key => $value) {
            $data[ $key + 1 ][] = $value['uid'];
            $data[ $key + 1 ][] = $value['username'];
            $data[ $key + 1 ][] = $value['email'];
            $data[ $key + 1 ][] = $value['nickname'];
            $data[ $key + 1 ][] = $value['level_name'];
            $data[ $key + 1 ][] = change($value['rid']);
            $data[ $key + 1 ][] = $value['user_count'];
            $data[ $key + 1 ][] = $value['create_date'];
            $data[ $key + 1 ][] = $value['last_login'];
            $data[ $key + 1 ][] = $value['count'];
            $data[ $key + 1 ][] = $value['balance'];
            $data[ $key + 1 ][] = $value['gold'];
            $data[ $key + 1 ][] = $value['recharge_total'];
            $data[ $key + 1 ][] = $value['money_total'];
            $data[ $key + 1 ][] = $value['money'];
            $data[ $key + 1 ][] = $value['trade_frozen_name'];
        }

        $name = '用户列表';
        $this->push($data, $name);
    }


    /**
     * @functionname: user_detail
     * @author      : FrankHong
     * @date        : 2016-11-30 19:35:57
     * @description : 用户的详细信息
     * @note        :
     */
    public function user_detail()
    {
        $userId = trim(I('get.user_id'));
        if (!$userId) {
            $this->display('Common/error_not_found');
            die();
        }

        $mObj = M();

        //用户信息
        $userinfoObj      = M('userinfo');
        $userinfoWhereArr = 'uid='.$userId;
        $userinfoRs       = $userinfoObj->where($userinfoWhereArr)
                                        ->find();


        //真实信息
        $personalObj = M('personal_user_data');
        $cityObj     = M('city');

        $personal = $personalObj->where([
            'uid'    => $userId,
            'status' => 1,
        ])
                                ->find();
        $city     = $cityObj->where('id in('.$personal['province'].','.$personal['city'].')')
                            ->getField('id,name,joinname', true);

        $userinfoRs['u_busername'] = !empty($personal['real_name']) ? $personal['real_name'] : '未填写';
        $userinfoRs['u_card']      = !empty($personal['card']) ? $personal['card'] : '未填写';
        $userinfoRs['province']    = !empty($city[ $personal['province'] ]['joinname']) ? $city[ $personal['province'] ]['joinname'] : '未填写';
        $userinfoRs['city']        = !empty($city[ $personal['city'] ]['name']) ? $city[ $personal['city'] ]['name'] : '未填写';

        $userinfoRs['card_positive'] = $personal['card_positive'];
        $userinfoRs['card_side']     = $personal['card_side'];

        $userinfoRs['status_n']   = $userinfoRs['trade_frozen'] == 0 ? '<span class="label label-sm label-success">正常</span>' : '<span class="label label-sm label-warning">冻结</span>';
        $userinfoRs['u_reg_time'] = date('Y-m-d H;i:s', $userinfoRs['utime']);

        $userinfoRs['u_lastlog_time']  = !empty($userinfoRs['lastlog']) ? date('Y-m-d H:i:s', $userinfoRs['lastlog']) : '<span class="label label-sm label-warning">未登录过</span>';
        $userinfoRs['u_reg_ip']        = !empty($userinfoRs['reg_ip']) ? $userinfoRs['reg_ip'] : '无';
        $userinfoRs['u_last_login_ip'] = !empty($userinfoRs['last_login_ip']) ? $userinfoRs['last_login_ip'] : '无';


        //资金帐户
        $accountinfoObj = M('accountinfo');
        $accountinfoRs  = $accountinfoObj->where('uid='.$userinfoRs['uid'])
                                         ->find();

        $userinfoRs['real_account']     = !empty($accountinfoRs['balance']) ? $accountinfoRs['balance'] : 0.00;
        $userinfoRs['gold_account']     = !empty($accountinfoRs['gold']) ? $accountinfoRs['gold'] : 0.00;
        $userinfoRs['integral_account'] = !empty($accountinfoRs['integral']) ? $accountinfoRs['integral'] : 0.00;

        //可提佣金
        $extensionObj                       = M('extension');
        $extensionRs                        = $extensionObj->field('money')
                                                           ->where('user_id='.$userId)
                                                           ->find();
        $userinfoRs['commission_available'] = !empty($extensionRs['money']) ? $extensionRs['money'] : 0.00;


        //累计充值
        $userinfoRs['money_in'] = !empty($accountinfoRs['recharge_total']) ? $accountinfoRs['recharge_total'] : 0.00;
        //累计提现
        $userinfoRs['money_out'] = !empty($accountinfoRs['money_total']) ? $accountinfoRs['money_total'] : 0.00;

        //累计盈亏
        $moneyReal                = $mObj->table('view_order')
                                         ->where('uid='.$userinfoRs['uid'])
                                         ->sum('ploss');
        $moneyGold                = $mObj->table('view_order_moni')
                                         ->where('uid='.$userinfoRs['uid'])
                                         ->sum('ploss');
        $userinfoRs['money_real'] = !empty($moneyReal) ? $moneyReal : 0.00;
        $userinfoRs['money_gold'] = !empty($moneyGold) ? $moneyGold : 0.00;


        if ($userinfoRs['money_real'] > 0) {
            $userinfoRs['money_real'] = '<b class="text-danger">'.$userinfoRs['money_real'].'</b>';
        }

        if ($userinfoRs['money_real'] < 0) {
            $userinfoRs['money_real'] = '<b class="text-success">'.$userinfoRs['money_real'].'</b>';
        }


        //累计手续费
        $commissionTotalRs            = $mObj->table('view_order')
                                             ->where('uid='.$userinfoRs['uid'])
                                             ->sum('fee');
        $userinfoRs['money_fee_real'] = !empty($commissionTotalRs) ? $commissionTotalRs : 0.00;
        $commissionTotalRs            = $mObj->table('view_order_moni')
                                             ->where('uid='.$userinfoRs['uid'])
                                             ->sum('fee');
        $userinfoRs['money_fee_gold'] = !empty($commissionTotalRs) ? $commissionTotalRs : 0.00;


        $this->assign('moneyOutRs', $moneyOutRs);
        $this->assign('userinfoRs', $userinfoRs);
        $this->assign('bankinfoRs', $bankinfoRs);
        $this->display();
    }


    /**
     * @functionname: subordinateUser
     * @description : 下级用户
     * @note        :
     */
    public function subordinateUser()
    {
        $user_id = trim(I('get.user_id'));       //上级用户编号

        $start_time = urldecode(trim(I('get.start_time')));
        $end_time   = urldecode(trim(I('get.end_time')));
        $jostyle    = trim(I('get.jostyle'));

        $nickname = trim(I('get.nickname'));
        $uid      = trim(I('get.uid'));
        $level    = trim(I('get.level'));

        $userinfoObj = M('userinfo');

        //经纪人
        $whereArr = [
            'rid' => $user_id,
        ];

        $userData = $userinfoObj->field('uid')
                                ->where($whereArr)
                                ->select();

        $userIdArr = [];
        foreach ($userData as $k => $v) {
            array_push($userIdArr, $v['uid']);
        }

        $userIdStr = implode(',', array_unique($userIdArr));


        $this->assign('user_id', $user_id);

        //时间筛选
        if ($start_time && $end_time) {
            $agentArr1    = [];
            $starttime    = strtotime($start_time);
            $endtime      = strtotime($end_time);
            $map['utime'] = [
                'between',
                ''.$starttime.','.$endtime.'',
            ];
            $map['otype'] = 4;
            $map['uid']   = [
                'in',
                $userIdStr,
            ];
            $userinfo     = $userinfoObj->where($map)
                                        ->select();

            foreach ($userinfo as $key => $value) {
                array_push($agentArr1, $value['uid']);
            }
            $userId             = implode(',', array_unique($agentArr1));
            $userIdStr          = $userId;
            $time['start_time'] = $start_time;
            $time['end_time']   = $end_time;
            $this->assign('time', $time);
        }


        //用户类型筛选
        if ($jostyle) {
            $this->assign('jostyle', $jostyle);
            $agentArr3           = [];
            $jostyle             = $jostyle == 1 ? 1 : 0;
            $map['trade_frozen'] = $jostyle;
            $map['otype']        = 4;
            $map['uid']          = [
                'in',
                $userIdStr,
            ];
            $userinfo            = $userinfoObj->where($map)
                                               ->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr3, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr3));
            $userIdStr = $userId;
        }


        //用户昵称
        if ($nickname) {
            $agentArr2       = [];
            $map['nickname'] = [
                'like',
                '%'.$nickname.'%',
            ];
            $map['otype']    = 4;
            $map['uid']      = [
                'in',
                $userIdStr,
            ];
            $userinfo        = $userinfoObj->where($map)
                                           ->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr2));
            $userId    = empty($userId) ? 1 - 1 : $userId;
            $userIdStr = $userId;
            $this->assign('nickname', $nickname);
        }

        //用户编号
        if ($uid) {
            $agentArr2    = [];
            $map['otype'] = 4;
            $map['uid']   = [
                'in',
                $userIdStr,
            ];
            $userinfo     = $userinfoObj->where($map)
                                        ->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }

            if (in_array($uid, $agentArr2)) {
                $userId = empty($uid) ? 1 - 1 : $uid;
            }

            $userIdStr = $userId;
            $this->assign('uid', $uid);
        }

        //当前星级筛选
        if ($level) {
            $agentArr2              = [];
            $map['otype']           = 4;
            $map['uid']             = [
                'in',
                $userIdStr,
            ];
            $map['extension_level'] = $level;
            $userinfo               = $userinfoObj->where($map)
                                                  ->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }

            $userId = implode(',', array_unique($agentArr2));
            $userId = empty($userId) ? 1 - 1 : $userId;

            $userIdStr = $userId;
            $this->assign('level', $level);
        }


        $prefix = C('DB_PREFIX');

        //需要从这里添加条件
        $userinfoWhereArr = 'a.uid in ('.$userIdStr.') and a.ustatus=0';

        //排序
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


        $count = M('userinfo a')
            ->join('left join '.$prefix.'accountinfo as b on a.uid = b.uid')
            ->where($userinfoWhereArr)
            ->count();

        $pageObj  = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow = $pageObj->show();

        $field      = 'a.*,b.balance,b.gold,b.integral,b.recharge_total,b.money_total,c.money';
        $userinfoRs = M('userinfo a')
            ->field($field)
            ->join('left join '.$prefix.'accountinfo as b on a.uid = b.uid')
            ->join('left join '.$prefix.'extension as c on a.uid = c.user_id')
            ->where($userinfoWhereArr)
            ->order($sort)
            ->limit($pageObj->firstRow, $pageObj->listRows)
            ->select();

        $userinfoRs1 = [];
        foreach ($userinfoRs as $k => $v) {
            $userinfoRs1[ $v['uid'] ]                   = $v;
            $userinfoRs1[ $v['uid'] ]['agent_username'] = $agentinfoRs1[ $userRelArr[ $v['uid'] ]['agent_id'] ]['username'];
            $userinfoRs1[ $v['uid'] ]['agent_id']       = $userRelArr[ $v['uid'] ]['agent_id'];
        }


        foreach ($userinfoRs1 as $k => $v) {
            $userinfoRs2[ $k ]                = $v;
            $userinfoRs2[ $k ]['last_login']  = !empty($v['lastlog']) ? date('Y-m-d H:i:s', $v['lastlog']) : '<span class="label label-sm label-warning">未登录过</span>';
            $userinfoRs2[ $k ]['create_date'] = date('Y-m-d H:i:s', $v['utime']);


            $userinfoRs2[ $k ]['trade_frozen_name'] = $v['trade_frozen'] == 0 ? '<span class="label label-sm label-success">正常</span>' : '<span class="label label-sm label-warning">冻结</span>';

            $userinfoRs2[ $k ]['trade_frozen_o'] = $v['trade_frozen'] == 0 ? '冻结' : '激活';
            $userinfoRs2[ $k ]['trade_frozen_s'] = $v['trade_frozen'] == 0 ? 1 : 0;

            $counts                     = M('order')
                ->where([
                    'uid'  => $v['uid'],
                    'type' => 1,
                ])
                ->count();
            $userinfoRs2[ $k ]['count'] = $counts;
            //订单统计，持仓平仓条数
            $userinfoRs2[ $k ]['total_jc'] = M('order')
                ->where([
                    'uid'    => $v['uid'],
                    'ostaus' => '0',
                    'type'   => 1,
                ])
                ->count();
            $userinfoRs2[ $k ]['total_pc'] = M('order')
                ->where([
                    'uid'    => $v['uid'],
                    'ostaus' => '1',
                    'type'   => 1,
                ])
                ->count();
        }


        //星级列表 用于筛选
        $levelData = M('UserinfoRate')->getField('id,name,id', true);
        $this->assign('levelData', $levelData);

        foreach ($userinfoRs2 as $key => $value) {
            $userinfoRs2[ $key ]['level_name'] = $levelData[ $value['extension_level'] ]['name'];

            //对用户名称，手机号码隐藏
            $userinfoRs2[ $key ]['username'] = substr_replace($value['username'], '****', 3, 4);
            $userinfoRs2[ $key ]['utel']     = substr_replace($value['utel'], '****', 3, 4);

            //判断昵称中是否包含手机号 则隐藏
            $nickname = $value['nickname'];
            $tel      = substr($nickname, -11);
            $telLen   = strlen($tel);

            if ($telLen == 11 && preg_match('/^1\d{10}$/', $tel)) {
                $tel = substr_replace($tel, '****', 3, 4);

                $strLen = strlen($nickname);

                $str = substr($nickname, 0, $strLen - $telLen);

                $nickname = $str.$tel;
            }

            $userinfoRs2[ $key ]['nickname'] = $nickname;
        }

        //底部统计
        $accountinfoRs = M('userinfo a')
            ->join('left join '.$prefix.'accountinfo as b on a.uid = b.uid')
            ->where($userinfoWhereArr)
            ->select();
        foreach ($accountinfoRs as $k => $v) {
            $acount['balance']        += $v['balance'];
            $acount['gold']           += $v['gold'];
            $acount['integral']       += $v['integral'];
            $acount['recharge_total'] += $v['recharge_total'];
            $acount['money_total']    += $v['money_total'];
        }

        //佣金计算
        $acount['fee_receive'] = M("userinfo a")
            ->field($field)
            ->join('left join wp_extension as d on a.uid = d.user_id')
            ->where($userinfoWhereArr)
            ->sum('money');

        $this->assign('account', $acount);


        //上级用户信息
        $prevUser = M('userinfo')
            ->where(['uid' => $user_id])
            ->getField('username');
        $this->assign('prevUser', $prevUser);


        $nowStart = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd   = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;


        $this->assign('userInfo', $userinfoRs2);
        $this->assign('totalCount', $count);

        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->display();
    }

    //下级用户列表导出
    public function subordinate_daochu()
    {
        $user_id = trim(I('get.user_id'));       //上级用户编号

        $start_time = urldecode(trim(I('get.start_time')));
        $end_time   = urldecode(trim(I('get.end_time')));
        $jostyle    = trim(I('get.jostyle'));

        $nickname = trim(I('get.nickname'));
        $uid      = trim(I('get.uid'));
        $level    = trim(I('get.level'));

        $userinfoObj = M('userinfo');

        //经纪人
        $whereArr = [
            'rid' => $user_id,
        ];

        $userData = $userinfoObj->field('uid')
                                ->where($whereArr)
                                ->select();

        $userIdArr = [];
        foreach ($userData as $k => $v) {
            array_push($userIdArr, $v['uid']);
        }

        $userIdStr = implode(',', array_unique($userIdArr));


        //时间筛选
        if ($start_time && $end_time) {
            $agentArr1    = [];
            $starttime    = strtotime($start_time);
            $endtime      = strtotime($end_time);
            $map['utime'] = [
                'between',
                ''.$starttime.','.$endtime.'',
            ];
            $map['otype'] = 4;
            $map['uid']   = [
                'in',
                $userIdStr,
            ];
            $userinfo     = $userinfoObj->where($map)
                                        ->select();

            foreach ($userinfo as $key => $value) {
                array_push($agentArr1, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr1));
            $userIdStr = $userId;
        }


        //用户类型筛选
        if ($jostyle) {
            $agentArr3           = [];
            $jostyle             = $jostyle == 1 ? 1 : 0;
            $map['trade_frozen'] = $jostyle;
            $map['otype']        = 4;
            $map['uid']          = [
                'in',
                $userIdStr,
            ];
            $userinfo            = $userinfoObj->where($map)
                                               ->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr3, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr3));
            $userIdStr = $userId;
        }


        //用户昵称
        if ($nickname) {
            $agentArr2       = [];
            $map['nickname'] = [
                'like',
                '%'.$nickname.'%',
            ];
            $map['otype']    = 4;
            $map['uid']      = [
                'in',
                $userIdStr,
            ];
            $userinfo        = $userinfoObj->where($map)
                                           ->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr2));
            $userId    = empty($userId) ? 1 - 1 : $userId;
            $userIdStr = $userId;
        }

        //用户编号
        if ($uid) {
            $agentArr2    = [];
            $map['otype'] = 4;
            $map['uid']   = [
                'in',
                $userIdStr,
            ];
            $userinfo     = $userinfoObj->where($map)
                                        ->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }

            if (in_array($uid, $agentArr2)) {
                $userId = empty($uid) ? 1 - 1 : $uid;
            }

            $userIdStr = $userId;
        }

        //当前星级筛选
        if ($level) {
            $agentArr2              = [];
            $map['otype']           = 4;
            $map['uid']             = [
                'in',
                $userIdStr,
            ];
            $map['extension_level'] = $level;
            $userinfo               = $userinfoObj->where($map)
                                                  ->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }

            $userId = implode(',', array_unique($agentArr2));
            $userId = empty($userId) ? 1 - 1 : $userId;

            $userIdStr = $userId;
        }


        $prefix = C('DB_PREFIX');

        //需要从这里添加条件
        $userinfoWhereArr = 'a.uid in ('.$userIdStr.') and a.ustatus=0';

        //排序
        $sort = 'a.utime desc';
        //余额排序
        $cat   = trim(I('get.cat'));
        $sorts = trim(I('get.sort'));
        if ($cat) {
            $sort = $cat.' '.$sorts.'';
        }

        $field      = 'a.*,b.balance,b.gold,b.integral,b.recharge_total,b.money_total,c.money';
        $userinfoRs = M('userinfo a')
            ->field($field)
            ->join('left join '.$prefix.'accountinfo as b on a.uid = b.uid')
            ->join('left join '.$prefix.'extension as c on a.uid = c.user_id')
            ->where($userinfoWhereArr)
            ->order($sort)
            ->select();

        $userinfoRs1 = [];
        foreach ($userinfoRs as $k => $v) {
            $userinfoRs1[ $v['uid'] ]                   = $v;
            $userinfoRs1[ $v['uid'] ]['agent_username'] = $agentinfoRs1[ $userRelArr[ $v['uid'] ]['agent_id'] ]['username'];
            $userinfoRs1[ $v['uid'] ]['agent_id']       = $userRelArr[ $v['uid'] ]['agent_id'];
        }


        foreach ($userinfoRs1 as $k => $v) {
            $userinfoRs2[ $k ]                = $v;
            $userinfoRs2[ $k ]['last_login']  = !empty($v['lastlog']) ? date('Y-m-d H:i:s', $v['lastlog']) : '未登录过';
            $userinfoRs2[ $k ]['create_date'] = date('Y-m-d H:i:s', $v['utime']);

            $userinfoRs2[ $k ]['trade_frozen_o'] = $v['trade_frozen'] == 0 ? '冻结' : '激活';

            $count                      = M('order')
                ->where([
                    'uid'  => $v['uid'],
                    'type' => 1,
                ])
                ->count();
            $userinfoRs2[ $k ]['count'] = $count;
        }


        //星级列表 用于筛选
        $levelData = M('UserinfoRate')->getField('id,name,id', true);

        foreach ($userinfoRs2 as $key => $value) {
            $userinfoRs2[ $key ]['level_name'] = $levelData[ $value['extension_level'] ]['name'];

            //对用户名称，手机号码隐藏
            $userinfoRs2[ $key ]['username'] = substr_replace($value['username'], '****', 3, 4);
            $userinfoRs2[ $key ]['utel']     = substr_replace($value['utel'], '****', 3, 4);

            //判断昵称中是否包含手机号 则隐藏
            $nickname = $value['nickname'];
            $tel      = substr($nickname, -11);
            $telLen   = strlen($tel);

            if ($telLen == 11 && preg_match('/^1\d{10}$/', $tel)) {
                $tel = substr_replace($tel, '****', 3, 4);

                $strLen = strlen($nickname);

                $str = substr($nickname, 0, $strLen - $telLen);

                $nickname = $str.$tel;
            }

            $userinfoRs2[ $key ]['nickname'] = $nickname;
        }


        $data[0] = [
            '编号',
            '用户名称',
            '用户昵称',
            '当前级别',
            '上级',
            '创建日期',
            '最近登录时间',
            '订单数量',
            '账户余额',
            '账户模拟',
            '累计充值',
            '累计提现',
            '当前佣金',
            '当前状态',
        ];
        foreach ($userinfoRs2 as $key => $value) {
            $data[ $key + 1 ][] = $value['uid'];
            $data[ $key + 1 ][] = $value['username'];
            $data[ $key + 1 ][] = $value['nickname'];
            $data[ $key + 1 ][] = $value['level_name'];
            $data[ $key + 1 ][] = change($value['rid']);
            $data[ $key + 1 ][] = $value['create_date'];
            $data[ $key + 1 ][] = $value['last_login'];
            $data[ $key + 1 ][] = $value['count'];
            $data[ $key + 1 ][] = $value['balance'];
            $data[ $key + 1 ][] = $value['gold'];
            $data[ $key + 1 ][] = $value['recharge_total'];
            $data[ $key + 1 ][] = $value['money_total'];
            $data[ $key + 1 ][] = $value['money'];
            $data[ $key + 1 ][] = $value['trade_frozen_o'];
        }

        $name = '下级用户列表';
        $this->push($data, $name);
    }


    /**
     * @functionname: opt_user_status
     * @author      : FrankHong
     * @date        : 2016-12-02 20:28:24
     * @description : 提现记录
     * @note        :
     */
    public function withdrawal($isExport = 0)
    {
        $email     = trim(I('get.email'));                 //手机号码
        $status    = trim(I('get.status'));               //提现状态
        $starttime = strtotime(urldecode(trim(I('get.start_time')))); //开始时间
        $endtime   = strtotime(urldecode(trim(I('get.end_time'))));   //结束时间

        $username = trim(I('get.username'));
        $nickname = trim(I('get.nickname'));
        $id       = trim(I('get.id'));

        $userinfoObj = M('userinfo');

        $whereArr = [
            'rid' => NOW_UID,
        ];

        $userinfo = $userinfoObj->field('uid')
                                ->where($whereArr)
                                ->select();

        $userIdArr = [];
        foreach ($userinfo as $k => $v) {
            array_push($userIdArr, $v['uid']);
        }

        $userIdStr = implode(',', array_unique($userIdArr));

        $map['a.uid'] = [
            'in',
            $userIdStr,
        ];

        if ($email) {
            $map['b.email'] = [
                'like',
                '%'.$email.'%',
            ];
            $this->assign('email', $email);
        }

        if ($status || $status == '0') {
            $map['a.status'] = $status;
            $this->assign('status', $status);
        }

        if ($starttime && $endtime) {
            $map['a.create_time'] = [
                'between',
                ''.$starttime.','.$endtime.'',
            ];
            $this->assign('starttime', date('Y-m-d H:i:s', $starttime));
            $this->assign('endtime', date('Y-m-d H:i:s', $endtime));
        }

        //用户名称
        if ($username) {
            $map['b.username'] = [
                'like',
                '%'.$username.'%',
            ];
            $this->assign('username', $username);
        }

        //用户昵称
        if ($nickname) {
            $map['b.nickname'] = [
                'like',
                '%'.$nickname.'%',
            ];
            $this->assign('nickname', $nickname);
        }

        //用户编号
        if ($id) {
            $map['a.id'] = $id;
            $this->assign('id', $id);
        }


        $prefix = C('DB_PREFIX');

        $count = M("withdraw a")
            ->join(''.$prefix.'userinfo as b on a.uid = b.uid')
            ->where($map)
            ->count();

        //分页
        $page     = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow = $page->show();

        $bm = M("withdraw a")
            ->join(''.$prefix.'userinfo as b on a.uid = b.uid')
            ->where($map)
            ->order('a.id desc');


        if ($isExport) {
            $rechargelist = $bm->select();

            return $rechargelist;
        }
        else {

            $rechargelist = $bm->limit($page->firstRow.','.$page->listRows)
                               ->select();

            $datas = M("withdraw a")
                ->join(''.$prefix.'userinfo as b on a.uid = b.uid')
                ->where($map)
                ->select();

            foreach ($datas as $key => $value) {
                $data['allAmount']    += $value['amount'];
                $data['sucessAmount'] += $value['status'] == 1 ? $value['amount'] : '0.00';
            }

            $nowStart = $page->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
            $nowEnd   = ($page->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;

            $this->assign('totalCount', $count);
            $this->assign('nowStart', $nowStart);
            $this->assign('nowEnd', $nowEnd);
            $this->assign('pageShow', $pageShow);
            $this->assign('data', $data);
            $this->assign('rechargelist', $rechargelist);
            $this->display();
        }
    }


    public function withdrawal_daochu()
    {
        $rechargelist = $this->withdrawal(1);
        $data[0]      = [
            '编号id',
            '用户名称',
            '电子邮箱',
            '用户昵称',
            '姓名',
            '卡号',
            '银行名称/币种',
            '开户行/币类型',
            '开户地址/提币地址',
            '汇款代码',
            '申请时间',
            '处理时间',
            '提现金额',
            '用户余额',
            '状态',
        ];
        foreach ($rechargelist as $key => $value) {
            $data[ $key + 1 ][] = $value['id'];
            $data[ $key + 1 ][] = $value['username'];
            $data[ $key + 1 ][] = $value['email'];
            $data[ $key + 1 ][] = $value['nickname'];
            $data[ $key + 1 ][] = $value['busername'];
            $data[ $key + 1 ][] = $value['banknumber'];
            $data[ $key + 1 ][] = $value['bankname'];
            $data[ $key + 1 ][] = $value['branch'];
            $data[ $key + 1 ][] = $value['address'];
            $data[ $key + 1 ][] = $value['swiftcode'];
            $data[ $key + 1 ][] = date('Y-m-d H:i:s', $value['create_time']);
            $data[ $key + 1 ][] = $value['c_time'] == '' ? '暂未处理' : date('Y-m-d H:i:s', $value['c_time']);
            $data[ $key + 1 ][] = $value['amount'];
            $data[ $key + 1 ][] = $value['balance'];
            if ($value['status'] == 1) {
                $data[ $key + 1 ][] = '已通过';
            }
            elseif ($value['status'] == '0') {
                $data[ $key + 1 ][] = '待处理';
            }
            else {
                $data[ $key + 1 ][] = '拒绝申请';
            }
        }
        $this->push($data, '用户提现记录');
    }


    /**
     * @functionname: money_flow
     * @author      : wang
     * @date        : 2016-12-02 20:28:24
     * @description : 用户资金流水
     * @note        :
     */
    public function money_flow()
    {
        $MoneyFlow               = M('MoneyFlow');
        $userinfo                = M('userinfo');

        $start_time = urldecode(trim(I('get.start_time')));
        $end_time   = urldecode(trim(I('get.end_time')));
        $email      = trim(I('get.email'));
        $type       = trim(I('get.type'));
        $operator   = trim(I('get.operator'));

        $username = trim(I('get.username'));
        $nickname = trim(I('get.nickname'));
        $id       = trim(I('get.id'));

        $userinfoObj = M('userinfo');

        //经纪人
        $extension = fiance([NOW_UID], 1);

        $whereArr['uid'] = [
            'in',
            array_unique(array_column($extension, 'uid')),
        ];

        $userData = $userinfoObj->field('uid')
                                ->where($whereArr)
                                ->select();

        $userIdArr = [];
        foreach ($userData as $k => $v) {
            array_push($userIdArr, $v['uid']);
        }

        $userIdStr = implode(',', array_unique($userIdArr));


        //时间筛选
        if ($start_time && $end_time) {
            $starttime          = strtotime($start_time);
            $endtime            = strtotime($end_time);
            $map['dateline']    = [
                'between',
                [
                    $starttime,
                    $endtime,
                ],
            ];
            $time['start_time'] = $start_time;
            $time['end_time']   = $end_time;
            $this->assign('time', $time);
        }

        //电子邮箱筛选
        if ($email) {
            $agentArr2      = [];
            $where['email'] = [
                'like',
                '%'.$email.'%',
            ];
            $where['otype'] = 4;
            $where['uid']   = [
                'in',
                $userIdStr,
            ];
            $tel            = $userinfo->where($where)
                                       ->select();
            foreach ($tel as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr2));
            $userId    = empty($userId) ? 1 - 1 : $userId;
            $userIdStr = $userId;
            $this->assign('email', $email);
        }

        //z资金变动筛选
        if ($type) {
            $map['type'] = $type;
            $this->assign('type', $type);
        }
        else {
            $map['type'] = [
                'neq',
                6,
            ];
        }

        //操作人筛选
        if ($operator) {
            $map['op_id'] = $operator;
            $this->assign('operator', $operator);
        }


        //用户名称
        if ($username) {
            $agentArr2         = [];
            $where['username'] = [
                'like',
                '%'.$username.'%',
            ];
            $where['otype']    = 4;
            $where['uid']      = [
                'in',
                $userIdStr,
            ];
            $tel               = $userinfo->where($where)
                                          ->select();
            foreach ($tel as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr2));
            $userId    = empty($userId) ? 1 - 1 : $userId;
            $userIdStr = $userId;
            $this->assign('username', $username);
        }

        //用户昵称
        if ($nickname) {
            $agentArr2         = [];
            $where['nickname'] = [
                'like',
                '%'.$nickname.'%',
            ];
            $where['otype']    = 4;
            $where['uid']      = [
                'in',
                $userIdStr,
            ];
            $tel               = $userinfo->where($where)
                                          ->select();
            foreach ($tel as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr2));
            $userId    = empty($userId) ? 1 - 1 : $userId;
            $userIdStr = $userId;
            $this->assign('nickname', $nickname);
        }

        //编号
        if ($id) {
            $map['id'] = $id;
            $this->assign('id', $id);
        }

        //start
        $map['uid'] = [
            'in',
            $userIdStr,
        ];

        $count = $MoneyFlow->where($map)
                           ->count();

        $pageObj  = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow = $pageObj->show();

        $Flow       = $MoneyFlow->where($map)
                                ->order('id  desc')
                                ->limit($pageObj->firstRow, $pageObj->listRows)
                                ->select();
        $Flow_money = $MoneyFlow->where($map)
                                ->order('id  desc')
                                ->select();

        $FlowArr  = [];
        $FlowArr1 = [];
        foreach ($Flow as $key => $value) {
            array_push($FlowArr, $value['uid']);
            array_push($FlowArr1, $value['op_id']);
        }

        $FlowId  = implode(',', array_unique($FlowArr));
        $FlowId1 = implode(',', array_unique($FlowArr1));

        //查询购买人信息
        $info = $userinfo->where('uid in('.$FlowId.')')
                         ->select();
        foreach ($info as $key => $value) {
            $info[ $value['uid'] ] = $value;
        }

        //查询操作人信息
        $info1 = $userinfo->where('uid in('.$FlowId1.')')
                          ->select();
        foreach ($info1 as $key => $value) {
            $info1[ $value['uid'] ] = $value;
        }


        foreach ($Flow as $key => $value) {
            $Flow[ $key ]['email']    = $info[ $value['uid'] ]['email'];
            $Flow[ $key ]['username'] = $info[ $value['uid'] ]['username'];
            $Flow[ $key ]['nickname'] = $info[ $value['uid'] ]['nickname'];

            $Flow[ $key ]['account'] = substr($value['note'], strrpos($value['note'], '[') + 1);
            $Flow[ $key ]['account'] = preg_replace("/]/", "", $Flow[ $key ]['account']);

            $Flow[ $key ]['operator'] = change($value['op_id']);  //操作人
        }

        $sum = 0;
        foreach ($Flow_money as $key => $value) {
            $Flow_money[ $key ]['account'] = substr($value['note'], strrpos($value['note'], '[') + 1);
            $sum                           += preg_replace("/]元/", "", $Flow_money[ $key ]['account']);
        }

        $nowStart = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd   = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;

        $this->assign('totalCount', $count);
        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->assign('flow', $Flow);
        $this->assign('sum', round($sum,2));
        $this->assign('info', M('userinfo')
            ->where(['otype' => 3])
            ->select());
        $this->display();
    }

    /**
     * @functionname: opt_user_status
     * @author      : FrankHong
     * @date        : 2016-12-02 20:28:24
     * @description : 用户资金流水导出excel
     * @note        :
     */
    public function flow_daochu()
    {
        $MoneyFlow               = M('MoneyFlow');
        $userinfo                = M('userinfo');

        $start_time = urldecode(trim(I('get.start_time')));
        $end_time   = urldecode(trim(I('get.end_time')));
        $email      = trim(I('get.email'));
        $type       = trim(I('get.type'));
        $operator   = trim(I('get.operator'));

        $username = trim(I('get.username'));
        $nickname = trim(I('get.nickname'));
        $id       = trim(I('get.id'));

        $userinfoObj = M('userinfo');

        //经纪人
        $extension = fiance([NOW_UID], 1);

        $whereArr['uid'] = [
            'in',
            array_unique(array_column($extension, 'uid')),
        ];

        $userData = $userinfoObj->field('uid')
                                ->where($whereArr)
                                ->select();

        $userIdArr = [];
        foreach ($userData as $k => $v) {
            array_push($userIdArr, $v['uid']);
        }

        $userIdStr = implode(',', array_unique($userIdArr));


        //时间筛选
        if ($start_time && $end_time) {
            $starttime       = strtotime($start_time);
            $endtime         = strtotime($end_time);
            $map['dateline'] = [
                'between',
                [
                    $starttime,
                    $endtime,
                ],
            ];
        }

        //电子邮箱筛选
        if ($email) {
            $agentArr2      = [];
            $where['email'] = [
                'like',
                '%'.$email.'%',
            ];
            $where['otype'] = 4;
            $where['uid']   = [
                'in',
                $userIdStr,
            ];
            $tel            = $userinfo->where($where)
                                       ->select();
            foreach ($tel as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr2));
            $userId    = empty($userId) ? 1 - 1 : $userId;
            $userIdStr = $userId;
        }

        //z资金变动筛选
        if ($type) {
            $map['type'] = $type;
        }
        else {
            $map['type'] = [
                'neq',
                6,
            ];
        }

        //操作人筛选
        if ($operator) {
            $map['op_id'] = $operator;
        }

        //用户名称
        if ($username) {
            $agentArr2         = [];
            $where['username'] = [
                'like',
                '%'.$username.'%',
            ];
            $where['otype']    = 4;
            $where['uid']      = [
                'in',
                $userIdStr,
            ];
            $tel               = $userinfo->where($where)
                                          ->select();
            foreach ($tel as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr2));
            $userId    = empty($userId) ? 1 - 1 : $userId;
            $userIdStr = $userId;
            $this->assign('username', $username);
        }

        //用户昵称
        if ($nickname) {
            $agentArr2         = [];
            $where['nickname'] = [
                'like',
                '%'.$nickname.'%',
            ];
            $where['otype']    = 4;
            $where['uid']      = [
                'in',
                $userIdStr,
            ];
            $tel               = $userinfo->where($where)
                                          ->select();
            foreach ($tel as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr2));
            $userId    = empty($userId) ? 1 - 1 : $userId;
            $userIdStr = $userId;
            $this->assign('nickname', $nickname);
        }

        //编号
        if ($id) {
            $map['id'] = $id;
            $this->assign('id', $id);
        }

        //start
        $map['uid'] = [
            'in',
            $userIdStr,
        ];


        $Flow = $MoneyFlow->where($map)
                          ->order('id  desc')
                          ->select();

        $FlowArr  = [];
        $FlowArr1 = [];
        foreach ($Flow as $key => $value) {
            array_push($FlowArr, $value['uid']);
            array_push($FlowArr1, $value['op_id']);
        }

        $FlowId  = implode(',', array_unique($FlowArr));
        $FlowId1 = implode(',', array_unique($FlowArr1));

        //查询购买人信息
        $info = $userinfo->where('uid in('.$FlowId.')')
                         ->select();
        foreach ($info as $key => $value) {
            $info[ $value['uid'] ] = $value;
        }

        //查询操作人信息
        $info1 = $userinfo->where('uid in('.$FlowId1.')')
                          ->select();
        foreach ($info1 as $key => $value) {
            $info1[ $value['uid'] ] = $value;
        }


        foreach ($Flow as $key => $value) {
            $Flow[ $key ]['email']    = $info[ $value['uid'] ]['email'];
            $Flow[ $key ]['username'] = $info[ $value['uid'] ]['username'];
            $Flow[ $key ]['nickname'] = $info[ $value['uid'] ]['nickname'];

            $Flow[ $key ]['account'] = substr($value['note'], strrpos($value['note'], '[') + 1);
            $Flow[ $key ]['account'] = preg_replace("/]/", "", $Flow[ $key ]['account']);

            $Flow[ $key ]['operator'] = change($value['op_id']);  //操作人
        }


        $data[0] = [
            '编号id',
            '用户名称',
            '电子邮箱',
            '用户昵称',
            '资金变动描述',
            '变动金额',
            '用户余额',
            '操作人',
            '操作时间',
        ];
        foreach ($Flow as $key => $value) {
            $data[ $key + 1 ][] = $value['id'];
            $data[ $key + 1 ][] = $value['username'];
            $data[ $key + 1 ][] = $value['email'];
            $data[ $key + 1 ][] = $value['nickname'];
            $data[ $key + 1 ][] = $value['note'];
            $data[ $key + 1 ][] = $value['account'];
            $data[ $key + 1 ][] = $value['balance'];
            $data[ $key + 1 ][] = $value['operator'];
            $data[ $key + 1 ][] = date('Y-m-d H:i:s', $value['dateline']);
        }
        $name = '用户资金流水';
        $this->push($data, $name);
    }


    //积分流水
    public function integral_flow()
    {
        $MoneyFlow               = M('MoneyFlow');
        $userinfo                = M('userinfo');
        $userinfoRelationshipObj = M('UserinfoRelationship');
        $bankinfo                = M('bankinfo');

        $start_time = urldecode(trim(I('get.start_time')));
        $end_time   = urldecode(trim(I('get.end_time')));
        $utel       = trim(I('get.utel'));
        $operator   = trim(I('get.operator'));

        $username = trim(I('get.username'));
        $nickname = trim(I('get.nickname'));
        $id       = trim(I('get.id'));

        $userinfoObj = M('userinfo');

        //经纪人
        $whereArr = [
            'rid' => NOW_UID,
        ];

        $userData = $userinfoObj->field('uid')
                                ->where($whereArr)
                                ->select();

        $userIdArr = [];
        foreach ($userData as $k => $v) {
            array_push($userIdArr, $v['uid']);
        }

        $userIdStr = implode(',', array_unique($userIdArr));


        //时间筛选
        if ($start_time && $end_time) {
            $starttime          = strtotime($start_time);
            $endtime            = strtotime($end_time);
            $map['dateline']    = [
                'between',
                [
                    $starttime,
                    $endtime,
                ],
            ];
            $time['start_time'] = $start_time;
            $time['end_time']   = $end_time;
            $this->assign('time', $time);
        }

        //手机号码筛选
        if ($utel) {
            $agentArr2      = [];
            $where['utel']  = [
                'like',
                '%'.$utel.'%',
            ];
            $where['otype'] = 4;
            $where['uid']   = [
                'in',
                $userIdStr,
            ];
            $tel            = $userinfo->where($where)
                                       ->select();
            foreach ($tel as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr2));
            $userId    = empty($userId) ? 1 - 1 : $userId;
            $userIdStr = $userId;
            $this->assign('utel', $utel);
        }


        //操作人筛选
        if ($operator) {
            $map['op_id'] = $operator;
            $this->assign('operator', $operator);
        }

        //用户名称
        if ($username) {
            $agentArr2         = [];
            $where['username'] = [
                'like',
                '%'.$username.'%',
            ];
            $where['otype']    = 4;
            $where['uid']      = [
                'in',
                $userIdStr,
            ];
            $tel               = $userinfo->where($where)
                                          ->select();
            foreach ($tel as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr2));
            $userId    = empty($userId) ? 1 - 1 : $userId;
            $userIdStr = $userId;
            $this->assign('username', $username);
        }

        //用户昵称
        if ($nickname) {
            $agentArr2         = [];
            $where['nickname'] = [
                'like',
                '%'.$nickname.'%',
            ];
            $where['otype']    = 4;
            $where['uid']      = [
                'in',
                $userIdStr,
            ];
            $tel               = $userinfo->where($where)
                                          ->select();
            foreach ($tel as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr2));
            $userId    = empty($userId) ? 1 - 1 : $userId;
            $userIdStr = $userId;
            $this->assign('nickname', $nickname);
        }

        //编号
        if ($id) {
            $map['id'] = $id;
            $this->assign('id', $id);
        }

        //start
        $map['uid']  = [
            'in',
            $userIdStr,
        ];
        $map['type'] = [
            'eq',
            6,
        ];

        $count    = $MoneyFlow->where($map)
                              ->count();
        $pageObj  = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow = $pageObj->show();

        $Flow       = $MoneyFlow->where($map)
                                ->order('id  desc')
                                ->limit($pageObj->firstRow, $pageObj->listRows)
                                ->select();
        $Flow_money = $MoneyFlow->where($map)
                                ->order('id  desc')
                                ->select();

        $FlowArr  = [];
        $FlowArr1 = [];
        foreach ($Flow as $key => $value) {
            array_push($FlowArr, $value['uid']);
            array_push($FlowArr1, $value['op_id']);
        }

        $FlowId  = implode(',', array_unique($FlowArr));
        $FlowId1 = implode(',', array_unique($FlowArr1));

        //查询购买人信息
        $info = $userinfo->where('uid in('.$FlowId.')')
                         ->select();
        foreach ($info as $key => $value) {
            $info[ $value['uid'] ] = $value;
        }

        //查询操作人信息
        $info1 = $userinfo->where('uid in('.$FlowId1.')')
                          ->select();
        foreach ($info1 as $key => $value) {
            $info1[ $value['uid'] ] = $value;
        }


        foreach ($Flow as $key => $value) {
            $Flow[ $key ]['utel']     = $info[ $value['uid'] ]['utel'];
            $Flow[ $key ]['username'] = $info[ $value['uid'] ]['username'];
            $Flow[ $key ]['nickname'] = $info[ $value['uid'] ]['nickname'];

            $Flow[ $key ]['account'] = substr($value['note'], strrpos($value['note'], '[') + 1);
            $Flow[ $key ]['account'] = preg_replace("/]/", "", $Flow[ $key ]['account']);

            $Flow[ $key ]['operator'] = change($value['op_id']);  //操作人

        }

        foreach ($Flow_money as $key => $value) {
            $Flow_money[ $key ]['account'] = substr($value['note'], strrpos($value['note'], '[') + 1);
            $sum                           += preg_replace("/]元/", "", $Flow_money[ $key ]['account']);
        }

        $nowStart = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd   = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;

        $this->assign('totalCount', $count);
        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->assign('flow', $Flow);
        $this->assign('sum', $sum);
        $this->assign('info', M('userinfo')
            ->where(['otype' => 3])
            ->select());
        $this->display();
    }

    /**
     * [integral_daochu 积分流水导出]
     * @author wang li
     */
    public function integral_daochu()
    {
        $MoneyFlow               = M('MoneyFlow');
        $userinfo                = M('userinfo');
        $userinfoRelationshipObj = M('UserinfoRelationship');
        $bankinfo                = M('bankinfo');

        $start_time = urldecode(trim(I('get.start_time')));
        $end_time   = urldecode(trim(I('get.end_time')));
        $utel       = trim(I('get.utel'));
        $operator   = trim(I('get.operator'));

        $username = trim(I('get.username'));
        $nickname = trim(I('get.nickname'));
        $id       = trim(I('get.id'));

        $userinfoObj = M('userinfo');

        //经纪人
        $whereArr = [
            'rid' => NOW_UID,
        ];

        $userData = $userinfoObj->field('uid')
                                ->where($whereArr)
                                ->select();

        $userIdArr = [];
        foreach ($userData as $k => $v) {
            array_push($userIdArr, $v['uid']);
        }

        $userIdStr = implode(',', array_unique($userIdArr));


        //时间筛选
        if ($start_time && $end_time) {
            $starttime       = strtotime($start_time);
            $endtime         = strtotime($end_time);
            $map['dateline'] = [
                'between',
                [
                    $starttime,
                    $endtime,
                ],
            ];
        }

        //手机号码筛选
        if ($utel) {
            $agentArr2      = [];
            $where['utel']  = [
                'like',
                '%'.$utel.'%',
            ];
            $where['otype'] = 4;
            $where['uid']   = [
                'in',
                $userIdStr,
            ];
            $tel            = $userinfo->where($where)
                                       ->select();
            foreach ($tel as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr2));
            $userId    = empty($userId) ? 1 - 1 : $userId;
            $userIdStr = $userId;
        }


        //操作人筛选
        if ($operator) {
            $map['op_id'] = $operator;
        }

        //用户名称
        if ($username) {
            $agentArr2         = [];
            $where['username'] = [
                'like',
                '%'.$username.'%',
            ];
            $where['otype']    = 4;
            $where['uid']      = [
                'in',
                $userIdStr,
            ];
            $tel               = $userinfo->where($where)
                                          ->select();
            foreach ($tel as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr2));
            $userId    = empty($userId) ? 1 - 1 : $userId;
            $userIdStr = $userId;
            $this->assign('username', $username);
        }

        //用户昵称
        if ($nickname) {
            $agentArr2         = [];
            $where['nickname'] = [
                'like',
                '%'.$nickname.'%',
            ];
            $where['otype']    = 4;
            $where['uid']      = [
                'in',
                $userIdStr,
            ];
            $tel               = $userinfo->where($where)
                                          ->select();
            foreach ($tel as $key => $value) {
                array_push($agentArr2, $value['uid']);
            }
            $userId    = implode(',', array_unique($agentArr2));
            $userId    = empty($userId) ? 1 - 1 : $userId;
            $userIdStr = $userId;
            $this->assign('nickname', $nickname);
        }

        //编号
        if ($id) {
            $map['id'] = $id;
            $this->assign('id', $id);
        }


        //start
        $map['uid']  = [
            'in',
            $userIdStr,
        ];
        $map['type'] = [
            'eq',
            6,
        ];


        $Flow = $MoneyFlow->where($map)
                          ->order('id  desc')
                          ->select();

        $FlowArr  = [];
        $FlowArr1 = [];
        foreach ($Flow as $key => $value) {
            array_push($FlowArr, $value['uid']);
            array_push($FlowArr1, $value['op_id']);
        }

        $FlowId  = implode(',', array_unique($FlowArr));
        $FlowId1 = implode(',', array_unique($FlowArr1));

        //查询购买人信息
        $info = $userinfo->where('uid in('.$FlowId.')')
                         ->select();
        foreach ($info as $key => $value) {
            $info[ $value['uid'] ] = $value;
        }

        //查询操作人信息
        $info1 = $userinfo->where('uid in('.$FlowId1.')')
                          ->select();
        foreach ($info1 as $key => $value) {
            $info1[ $value['uid'] ] = $value;
        }


        foreach ($Flow as $key => $value) {
            $Flow[ $key ]['utel']     = $info[ $value['uid'] ]['utel'];
            $Flow[ $key ]['username'] = $info[ $value['uid'] ]['username'];
            $Flow[ $key ]['nickname'] = $info[ $value['uid'] ]['nickname'];

            $Flow[ $key ]['account'] = substr($value['note'], strrpos($value['note'], '[') + 1);
            $Flow[ $key ]['account'] = preg_replace("/]/", "", $Flow[ $key ]['account']);

            $Flow[ $key ]['operator'] = change($value['op_id']);  //操作人

        }


        $data[0] = [
            '编号',
            '用户名称',
            '手机号',
            '用户昵称',
            '积分变动描述',
            '变动积分',
            '用户积分',
            '操作人',
            '操作时间',
        ];
        foreach ($Flow as $key => $value) {
            $data[ $key + 1 ][] = $value['id'];
            $data[ $key + 1 ][] = $value['username'];
            $data[ $key + 1 ][] = $value['utel'];
            $data[ $key + 1 ][] = $value['nickname'];
            $data[ $key + 1 ][] = $value['note'];
            $data[ $key + 1 ][] = $value['account'];
            $data[ $key + 1 ][] = $value['balance'];
            $data[ $key + 1 ][] = $value['operator'];
            $data[ $key + 1 ][] = date('Y-m-d H:i:s', $value['dateline']);
        }
        $name = '用户积分流水';
        $this->push($data, $name);
    }


    /**
     * 用户充值记录
     * @author wang li
     */
    public function recharge($isExport = 0)
    {
        $email     = trim(I('get.email'));                 //电子邮箱
        $status    = trim(I('get.status'));               //提现状态
        $starttime = strtotime(urldecode(trim(I('get.start_time')))); //开始时间
        $endtime   = strtotime(urldecode(trim(I('get.end_time'))));   //结束时间

        $username = trim(I('get.username'));
        $nickname = trim(I('get.nickname'));
        $bpid     = trim(I('get.bpid'));


        $userinfoObj = M('userinfo');

        //经纪人
        $whereArr = [
            'rid' => NOW_UID,
        ];

        $userData = $userinfoObj->field('uid')
                                ->where($whereArr)
                                ->select();

        $userIdArr = [];
        foreach ($userData as $k => $v) {
            array_push($userIdArr, $v['uid']);
        }

        $userIdStr = implode(',', array_unique($userIdArr));

        $map['a.uid'] = [
            'in',
            $userIdStr,
        ];


        if ($email) {
            $map['b.email'] = [
                'like',
                '%'.$email.'%',
            ];
            $this->assign('email', $email);
        }

        if ($status || $status == '0') {
            $map['a.status'] = $status;
            $this->assign('status', $status);
        }

        if ($starttime && $endtime) {
            $map['a.bptime'] = [
                'between',
                ''.$starttime.','.$endtime.'',
            ];
            $this->assign('starttime', date('Y-m-d H:i:s', $starttime));
            $this->assign('endtime', date('Y-m-d H:i:s', $endtime));
        }

        //用户名称
        if ($username) {
            $map['b.username'] = [
                'like',
                '%'.$username.'%',
            ];
            $this->assign('username', $username);
        }

        //用户昵称
        if ($nickname) {
            $map['b.nickname'] = [
                'like',
                '%'.$nickname.'%',
            ];
            $this->assign('nickname', $nickname);
        }

        //用户编号
        if ($bpid) {
            $map['a.bpid'] = $bpid;
            $this->assign('bpid', $bpid);
        }


        $prefix = C('DB_PREFIX');

        $count = M("balance a")
            ->join(''.$prefix.'userinfo as b on a.uid = b.uid')
            ->where($map)
            ->count();

        //分页
        $page     = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow = $page->show();

        $bm = M("balance a")
            ->join(''.$prefix.'userinfo as b on a.uid = b.uid')
            ->where($map)
            ->order('a.bpid desc');

        $payType = M()
            ->table('dict_pay_type')
            ->getField('id,id,pay_name', true);

        if ($isExport) {
            $rechargelist = $bm->select();
            foreach ($rechargelist as $key => $value) {
                $rechargelist[ $key ]['pay_type'] = $payType[ $value['pay_type'] ]['pay_name'];
            }

            return $rechargelist;
        }
        else {

            $rechargelist = $bm->limit($page->firstRow.','.$page->listRows)
                               ->select();
            foreach ($rechargelist as $key => $value) {

                $rechargelist[ $key ]['pay_type'] = $payType[ $value['pay_type'] ]['pay_name'];
            }

            $datas = M("balance a")
                ->join(''.$prefix.'userinfo as b on a.uid = b.uid')
                ->where($map)
                ->select();

            foreach ($datas as $key => $value) {
                $data['allAmount']    += $value['bpprice'];
                $data['sucessAmount'] += $value['status'] == 1 ? $value['bpprice'] : '0.00';
            }


            $nowStart = $page->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
            $nowEnd   = ($page->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;

            $this->assign('totalCount', $count);
            $this->assign('nowStart', $nowStart);
            $this->assign('nowEnd', $nowEnd);
            $this->assign('pageShow', $pageShow);
            $this->assign('data', $data);
            $this->assign('rechargelist', $rechargelist);
            $this->display();
        }
    }


    /**
     * 充值记录导出
     * @author wang li
     */
    public function recharge_daochu()
    {
        $rechargelist = $this->recharge(1);
        $data[0]      = [
            '编号id',
            '用户名称',
            '电子邮箱',
            '用户昵称',
            '订单号码',
            '充值时间',
            '处理时间',
            '充值金额',
            '用户余额',
            '充值渠道',
            '充值状态',
        ];
        foreach ($rechargelist as $key => $value) {
            $data[ $key + 1 ][] = $value['bpid'];
            $data[ $key + 1 ][] = $value['username'];
            $data[ $key + 1 ][] = $value['email'];
            $data[ $key + 1 ][] = $value['nickname'];
            $data[ $key + 1 ][] = $value['balanceno'];
            $data[ $key + 1 ][] = date('Y-m-d H:i:s', $value['bptime']);
            $data[ $key + 1 ][] = $value['cltime'] == '' ? '--' : date('Y-m-d H:i:s', $value['cltime']);
            $data[ $key + 1 ][] = $value['bpprice'];
            $data[ $key + 1 ][] = $value['shibpprice'];
            $data[ $key + 1 ][] = $value['pay_type'];

            if ($value['status'] == 1) {
                $data[ $key + 1 ][] = '充值完成';
            }
            elseif ($value['status'] == '0') {
                $data[ $key + 1 ][] = '待处理';
            }
            else {
                $data[ $key + 1 ][] = '充值失败';
            }
        }
        $this->push($data, '用户充值记录');
    }


    private function push($data, $name)
    {
        import("Excel.class.php");
        $excel = new Excel();
        $excel->download($data, $name);
    }


    private function get_username($uid = 0)
    {

        $personalObj = M('personal_user_data');
        $userObj     = M('userinfo');

        $persona = $personalObj->field('real_name username,uid')
                               ->where(['uid' => $uid])
                               ->find();

        if (!empty($persona)) {
            return $persona;
        }
        else {
            $user = $userObj->field('uid,username')
                            ->where(['uid' => $uid])
                            ->find();

            return $user;
        }
    }


    /**
     *   冻结交易用户
     * @author wang
     **/
    public function tradeFrozen()
    {
        $user_id      = trim(I('post.user_id'));
        $trade_frozen = trim(I('post.trade_frozen'));

        if (empty($user_id) || !isset($trade_frozen)) {
            $data['status']  = 0;
            $data['ret_msg'] = '非法操作';
            $this->ajaxReturn($data, 'JSON');
        }

        $userinfoObj = M('userinfo');

        $res = $userinfoObj->execute('update '.C('DB_PREFIX').'userinfo set trade_frozen='.$trade_frozen.' where uid='.$user_id.'');

        if ($res) {

            $data['status']  = 1;
            $data['ret_msg'] = '操作成功';
            $this->ajaxReturn($data, 'JSON');

        }
        else {

            $data['status']  = 0;
            $data['ret_msg'] = '操作失败';
            $this->ajaxReturn($data, 'JSON');
        }
    }

}