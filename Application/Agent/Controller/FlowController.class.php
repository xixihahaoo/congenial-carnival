<?php
/**
 * @author     : FrankHong
 * @datetime   : 2016/12/2 20:36
 * @filename   : OrderfController.class.php
 * @description: 运营中心订单模块
 * @note       :
 *
 */

namespace Agent\Controller;


class FlowController extends CommonController
{


    /**
     * @functionname: opt_user_status
     * @author      : FrankHong
     * @date        : 2016-12-02 20:28:24
     * @description : 操作用户的状态
     * @note        :
     */
    public function money_flow()
    {
        $MoneyFlow = M('MoneyFlow');

        $start_time = urldecode(I('get.start_time'));
        $end_time   = urldecode(I('get.end_time'));
        $type       = I('get.type');
        $operator   = trim(I('get.operator'));


        $userIdStr = NOW_UID;

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

        //资金变动筛选
        if ($type) {
            $map['type'] = $type;
            $this->assign('type', $type);
        }

        //操作人筛选
        if ($operator) {
            $map['op_id'] = $operator;
            $this->assign('operator', $operator);
        }

        //start
        $map['uid'] = [
            'in',
            $userIdStr,
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


        foreach ($Flow as $key => $value) {
            $Flow[ $key ]['account'] = substr($value['note'], strrpos($value['note'], '[') + 1);
            $Flow[ $key ]['account'] = preg_replace("/]/", "", $Flow[ $key ]['account']);
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
        $MoneyFlow = M('MoneyFlow');

        $start_time = urldecode(I('get.start_time'));
        $end_time   = urldecode(I('get.end_time'));
        $type       = I('get.type');
        $operator   = trim(I('get.operator'));


        $userIdStr = NOW_UID;

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

        //资金变动筛选
        if ($type) {
            $map['type'] = $type;
        }

        //操作人筛选
        if ($operator) {
            $map['op_id'] = $operator;
        }

        //start
        $map['uid'] = [
            'in',
            $userIdStr,
        ];


        $Flow       = $MoneyFlow->where($map)
                                ->order('id  desc')
                                ->select();


        foreach ($Flow as $key => $value) {
            $Flow[ $key ]['account'] = substr($value['note'], strrpos($value['note'], '[') + 1);
            $Flow[ $key ]['account'] = preg_replace("/]/", "", $Flow[ $key ]['account']);
        }


        $data[0] = [
            '编号',
            '资金变动描述',
            '变动金额',
            '余额',
            '操作人',
            '操作时间',
        ];
        foreach ($Flow as $key => $value) {
            $data[ $key + 1 ][] = $value['id'];
            $data[ $key + 1 ][] = $value['note'];
            $data[ $key + 1 ][] = $value['account'];
            $data[ $key + 1 ][] = $value['balance'];
            $data[ $key + 1 ][] = change($value['op_id']);
            $data[ $key + 1 ][] = date('Y-m-d H:i:s', $value['dateline']);
        }
        $name = '资金流水';
        $this->push($data, $name);
    }

    /**
     * 充值记录
     */
    public function recharge()
    {
        $balance  = M('balance');

        $start_time = urldecode(trim(I('get.start_time')));
        $end_time   = urldecode(trim(I('get.end_time')));
        $status     = trim(I('get.status'));


        //时间筛选
        if ($start_time && $end_time) {
            $starttime          = strtotime($start_time);
            $endtime            = strtotime($end_time);
            $map['bptime']      = [
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

        //充值状态
        if ($status || $status == '0') {
            $map['status'] = $status;
            $this->assign('status', $status);
        }


        $map['uid'] = NOW_UID;

        $count    = $balance->where($map)
                            ->count();
        $pageObj  = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow = $pageObj->show();

        $balance_data = $balance->where($map)
                                ->order('bpid  desc')
                                ->limit($pageObj->firstRow, $pageObj->listRows)
                                ->select();

        $pay_type = [];
        foreach ($balance_data as $key => $value) {
            array_push($pay_type, $value['pay_type']);
        }
        $payTypeId = implode(',', array_unique($pay_type));


        //查询用户充值渠道
        $pay = M()
            ->table('dict_pay_type')
            ->where('id in('.$payTypeId.')')
            ->select();
        foreach ($pay as $key => $value) {
            $pay[ $value['id'] ] = $value;
        }

        foreach ($balance_data as $key => $value) {
            $balance_data[ $key ]['pay_type'] = $pay[ $value['pay_type'] ]['pay_name'];

            if ($value['status'] == '0') {
                $balance_data[ $key ]['type'] = '待处理';
            }
            elseif ($value['status'] == 1) {
                $balance_data[ $key ]['type'] = '充值成功';
            }
            else {
                $balance_data[ $key ]['type'] = '充值失败';
            }

        }

        //查询用户总充值金额
        $map['status'] = 1;
        $bpprice       = $balance->where($map)
                                 ->sum('bpprice');

        $nowStart = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd   = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;

        $this->assign('totalCount', $count);
        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->assign('balance', $balance_data);
        $this->assign('bpprice', $bpprice);
        $this->display();
    }


    /**
     * 充值记录
     */
    public function recharge_daochu()
    {
        $balance  = M('balance');

        $start_time = urldecode(trim(I('get.start_time')));
        $end_time   = urldecode(trim(I('get.end_time')));
        $status     = trim(I('get.status'));


        //时间筛选
        if ($start_time && $end_time) {
            $starttime     = strtotime($start_time);
            $endtime       = strtotime($end_time);
            $map['bptime'] = [
                'between',
                [
                    $starttime,
                    $endtime,
                ],
            ];
        }

        //充值状态
        if ($status || $status == '0') {
            $map['status'] = $status;
        }


        $map['uid'] = NOW_UID;

        $balance_data = $balance->where($map)
                                ->order('bpid  desc')
                                ->select();

        $pay_type = [];
        foreach ($balance_data as $key => $value) {
            array_push($pay_type, $value['pay_type']);
        }
        $payTypeId = implode(',', array_unique($pay_type));


        //查询用户充值渠道
        $pay = M()
            ->table('dict_pay_type')
            ->where('id in('.$payTypeId.')')
            ->select();
        foreach ($pay as $key => $value) {
            $pay[ $value['id'] ] = $value;
        }

        foreach ($balance_data as $key => $value) {
            $balance_data[ $key ]['pay_type'] = $pay[ $value['pay_type'] ]['pay_name'];

            if ($value['status'] == '0') {
                $balance_data[ $key ]['type'] = '待处理';
            }
            elseif ($value['status'] == 1) {
                $balance_data[ $key ]['type'] = '充值成功';
            }
            else {
                $balance_data[ $key ]['type'] = '充值失败';
            }
        }


        $data[0] = [
            '编号',
            '订单号码',
            '充值时间',
            '处理时间',
            '充值金额',
            '账户余额',
            '状态',
            '充值渠道',
        ];
        foreach ($balance_data as $key => $value) {

            $data[ $key + 1 ][] = $value['bpid'];
            $data[ $key + 1 ][] = $value['balanceno'];
            $data[ $key + 1 ][] = date('Y-m-d H:i:s', $value['bptime']);
            $data[ $key + 1 ][] = !empty($value['cltime']) ? date('Y-m-d H:i:s', $value['cltime']) : '--';
            $data[ $key + 1 ][] = $value['bpprice'];
            $data[ $key + 1 ][] = $value['shibpprice'];
            $data[ $key + 1 ][] = $value['type'];
            $data[ $key + 1 ][] = $value['pay_type'];
        }
        $name = '充值记录';
        $this->push($data, $name);
    }

    /**
     * 提现记录
     */
    public function withdrawal()
    {
        $withdraw = M('withdraw');

        $start_time = urldecode(trim(I('get.start_time')));
        $end_time   = urldecode(trim(I('get.end_time')));
        $status     = trim(I('get.status'));


        //时间筛选
        if ($start_time && $end_time) {
            $starttime          = strtotime($start_time);
            $endtime            = strtotime($end_time);
            $map['create_time'] = [
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

        //提现状态
        if ($status || $status == '0') {
            $map['status'] = $status;
        }


        $map['uid'] = NOW_UID;

        $count    = $withdraw->where($map)
                             ->count();
        $pageObj  = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow = $pageObj->show();

        $balance_data = $withdraw->where($map)
                                 ->order('id desc')
                                 ->limit($pageObj->firstRow, $pageObj->listRows)
                                 ->select();


        foreach ($balance_data as $key => $value) {
            if ($value['status'] == '0') {
                $balance_data[ $key ]['type'] = '待处理';
            }
            elseif ($value['status'] == 1) {
                $balance_data[ $key ]['type'] = '已通过';
            }
            else {
                $balance_data[ $key ]['type'] = '已拒绝';
            }
        }

        //查询用户总提现金额
        $bpprice       = $withdraw->where($map)
                                  ->sum('amount');

        $nowStart = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd   = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;

        $this->assign('totalCount', $count);
        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->assign('balance', $balance_data);
        $this->assign('bpprice', $bpprice);
        $this->display();
    }


    /**
     * 提现记录
     */
    public function withdrawal_daochu()
    {
        $userinfo = M('userinfo');
        $balance  = M('withdraw');
        $bankinfo = M('bankinfo');

        $start_time = urldecode(trim(I('get.start_time')));
        $end_time   = urldecode(trim(I('get.end_time')));
        $status     = trim(I('get.status'));


        //时间筛选
        if ($start_time && $end_time) {
            $starttime          = strtotime($start_time);
            $endtime            = strtotime($end_time);
            $map['create_time'] = [
                'between',
                [
                    $starttime,
                    $endtime,
                ],
            ];
        }

        //提现状态
        if ($status || $status == '0') {
            $map['status'] = $status;
        }


        $map['uid']    = NOW_UID;

        $balance_data = $balance->where($map)
                                ->order('id  desc')
                                ->select();

        $balanceArr   = [];
        foreach ($balance_data as $key => $value) {
            array_push($balanceArr, $value['uid']);
        }
        $balanceId = implode(',', array_unique($balanceArr));

        //查询用户银行卡信息
        $bank = $bankinfo->where('uid in('.$balanceId.')')
                         ->select();
        foreach ($bank as $key => $value) {
            $bank[ $value['uid'] ] = $value;
        }

        //查询用户信息
        $info = $userinfo->where('uid in('.$balanceId.')')
                         ->select();
        foreach ($info as $key => $value) {
            $info[ $value['uid'] ] = $value;
        }


        $data[0] = [
            '编号',
            '姓名',
            '卡号',
            '银行名称',
            '开户行',
            '开户地址',
            '汇款代码',
            '申请时间',
            '处理时间',
            '提现金额',
            '账户余额',
            '状态',
        ];
        foreach ($balance_data as $key => $value) {
            if($value['status'] == '0') {
                $status = '待审核';
            } else if($value['status'] == 1) {
                $status = '已通过';
            } else {
                $status = '已拒绝';
            }

            $data[ $key + 1 ][] = $value['id'];
            $data[ $key + 1 ][] = $value['busername'];
            $data[ $key + 1 ][] = $value['banknumber'];
            $data[ $key + 1 ][] = $value['bankname'];
            $data[ $key + 1 ][] = $value['branch'];
            $data[ $key + 1 ][] = $value['address'];
            $data[ $key + 1 ][] = $value['swiftcode'];
            $data[ $key + 1 ][] = date('Y-m-d H:i:s', $value['create_time']);
            $data[ $key + 1 ][] = date('Y-m-d H:i:s', $value['c_time']);
            $data[ $key + 1 ][] = $value['amount'];
            $data[ $key + 1 ][] = $value['balance'];
            $data[ $key + 1 ][] = $status;
        }
        $name = '提现记录';
        $this->push($data, $name);
    }


    /**
     * 佣金转入记录
     * @author wang li
     */
    public function commissionRecord()
    {
        $userinfo = M('userinfo');
        $journal  = M('userJournal');

        $start_time = urldecode(trim(I('get.start_time')));
        $end_time   = urldecode(trim(I('get.end_time')));


        //时间筛选
        if ($start_time && $end_time) {
            $starttime          = strtotime($start_time);
            $endtime            = strtotime($end_time);
            $map['create_time'] = [
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


        $map['uid']  = NOW_UID;
        $map['type'] = 1;

        $count    = $journal->where($map)
                            ->count();
        $pageObj  = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow = $pageObj->show();

        $balance_data = $journal->where($map)
                                ->order('id desc')
                                ->limit($pageObj->firstRow, $pageObj->listRows)
                                ->select();


        //查询用户总提现金额
        $map['status'] = 1;
        $bpprice       = $journal->where($map)
                                 ->sum('account');

        $nowStart = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd   = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;

        $this->assign('totalCount', $count);
        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->assign('balance', $balance_data);
        $this->assign('bpprice', $bpprice);
        $this->display();
    }


    public function commissionRecord_daochu()
    {
        $userinfo = M('userinfo');
        $journal  = M('userJournal');

        $start_time = urldecode(trim(I('get.start_time')));
        $end_time   = urldecode(trim(I('get.end_time')));


        //时间筛选
        if ($start_time && $end_time) {
            $starttime          = strtotime($start_time);
            $endtime            = strtotime($end_time);
            $map['create_time'] = [
                'between',
                [
                    $starttime,
                    $endtime,
                ],
            ];
        }


        $map['uid']  = NOW_UID;
        $map['type'] = 1;

        $balance_data = $journal->where($map)
                                ->order('id desc')
                                ->select();


        $data[0] = [
            '编号',
            '转入时间',
            '转入金额',
        ];
        foreach ($balance_data as $key => $value) {
            $data[ $key + 1 ][] = $value['id'];
            $data[ $key + 1 ][] = date('Y-m-d H:i:s', $value['create_time']);
            $data[ $key + 1 ][] = $value['account'];
        }
        $name = '佣金转入记录';
        $this->push($data, $name);
    }

    /**
     * 佣金流水
     * @author wang li
     */
    public function receive_flow()
    {
        $userinfo = M('userinfo');
        $receive  = M('fee_receive a');

        $start_time = urldecode(trim(I('get.start_time')));
        $end_time   = urldecode(trim(I('get.end_time')));
        $status     = trim(I('get.status'));

        $optin_class_max = trim(I('get.optin_class_max'));
        $optin_class_min = trim(I('get.optin_class_min'));
        $option_name     = trim(I('get.option_name'));


        //时间筛选
        if ($start_time && $end_time) {
            $starttime            = strtotime($start_time);
            $endtime              = strtotime($end_time);
            $map['a.create_time'] = [
                'between',
                [
                    $starttime,
                    $endtime,
                ],
            ];
            $time['start_time']   = $start_time;
            $time['end_time']     = $end_time;
            $this->assign('time', $time);
        }

        //佣金状态
        if ($status) {
            $map['a.status'] = $status;
            $this->assign('status', $status);
        }

        //分类大类
        if ($optin_class_max) {
            $classObj = M('OptionClassify');
            $data     = $classObj->field('group_concat(distinct id) id')
                                 ->where(['pid' => $optin_class_max])
                                 ->find();

            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')
                                ->where('pid in('.$data['id'].')')
                                ->find();

            $map['b.pid'] = [
                'in',
                $option['id'],
            ];

            $this->assign('optin_class_max', $optin_class_max);
        }

        //分类小类
        if ($optin_class_min) {
            $classObj  = M('OptionClassify');
            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')
                                ->where('pid='.$optin_class_min)
                                ->find();

            $map['b.pid'] = [
                'in',
                $option['id'],
            ];

            $mindata = $classObj->field('id,name')
                                ->where('id in('.$data['id'].')')
                                ->select();

            $this->assign('mindata', $mindata);
            $this->assign('optin_class_min', $optin_class_min);
        }

        //产品名称
        if ($option_name) {
            $map['b.pid'] = $option_name;

            $optionObj = M('option');

            $option = $optionObj->field('id,capital_name')
                                ->where('pid='.$optin_class_min)
                                ->select();

            $this->assign('option', $option);
            $this->assign('option_name', $option_name);
        }


        $map['a.user_id'] = NOW_UID;
        $map['a.type']    = 1;

        $count    = $receive->where($map)
                            ->count();
        $pageObj  = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow = $pageObj->show();

        $prefix = C('DB_PREFIX');

        $balance_data = $receive->where($map)
                                ->join('left join '.$prefix.'order as b on a.order_id=b.oid')
                                ->order('a.id desc')
                                ->limit($pageObj->firstRow, $pageObj->listRows)
                                ->select();

        foreach ($balance_data as $key => $value) {
            if ($value['status'] == 1) {
                $balance_data[ $key ]['status'] = '已结算';
            }
            else {
                $balance_data[ $key ]['status'] = '未结算';
            }
        }


        // 底部统计
        $data = $receive->field('a.profit,a.status')
                        ->where($map)
                        ->join('left join '.$prefix.'order as b on a.order_id=b.oid')
                        ->join('left join '.$prefix.'userinfo as c on a.purchaser_id=c.uid')
                        ->select();

        foreach ($data as $key => $value) {
            if ($value['status'] == 1) {
                $data['settlement'] += $value['profit'];
            }
            else {
                $data['unsettled'] += $value['profit'];
            }
        }

        //产品大类
        $classify = M('option_classify')
            ->field('id,name')
            ->where(['level' => 1])
            ->select();


        $nowStart = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd   = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;


        $this->assign('classify', $classify);
        $this->assign('totalCount', $count);
        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->assign('balance', $balance_data);
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * 佣金导出
     */
    public function receive_flow_daochu()
    {
        $userinfo = M('userinfo');
        $receive  = M('fee_receive a');

        $start_time = urldecode(trim(I('get.start_time')));
        $end_time   = urldecode(trim(I('get.end_time')));
        $status     = trim(I('get.status'));

        $optin_class_max = trim(I('get.optin_class_max'));
        $optin_class_min = trim(I('get.optin_class_min'));
        $option_name     = trim(I('get.option_name'));


        //时间筛选
        if ($start_time && $end_time) {
            $starttime            = strtotime($start_time);
            $endtime              = strtotime($end_time);
            $map['a.create_time'] = [
                'between',
                [
                    $starttime,
                    $endtime,
                ],
            ];
        }

        //佣金状态
        if ($status) {
            $map['a.status'] = $status;
        }

        //分类大类
        if ($optin_class_max) {
            $classObj = M('OptionClassify');
            $data     = $classObj->field('group_concat(distinct id) id')
                                 ->where(['pid' => $optin_class_max])
                                 ->find();

            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')
                                ->where('pid in('.$data['id'].')')
                                ->find();

            $map['b.pid'] = [
                'in',
                $option['id'],
            ];
        }

        //分类小类
        if ($optin_class_min) {
            $classObj  = M('OptionClassify');
            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')
                                ->where('pid='.$optin_class_min)
                                ->find();

            $map['b.pid'] = [
                'in',
                $option['id'],
            ];
        }

        //产品名称
        if ($option_name) {
            $map['b.pid'] = $option_name;
        }


        $map['a.user_id'] = NOW_UID;
        $map['a.type']    = 1;

        $prefix = C('DB_PREFIX');

        $balance_data = $receive->where($map)
                                ->join('left join '.$prefix.'order as b on a.order_id=b.oid')
                                ->order('a.id desc')
                                ->select();

        foreach ($balance_data as $key => $value) {
            if ($value['status'] == 1) {
                $balance_data[ $key ]['status'] = '已结算';
            }
            else {
                $balance_data[ $key ]['status'] = '未结算';
            }
        }


        $data[0] = [
            '编号',
            '产品名称',
            '结算状态',
            '获得佣金',
            '操作时间',
        ];
        foreach ($balance_data as $key => $value) {
            $data[ $key + 1 ][] = $value['id'];
            $data[ $key + 1 ][] = $value['option_name'];
            $data[ $key + 1 ][] = $value['status'];
            $data[ $key + 1 ][] = $value['profit'];
            $data[ $key + 1 ][] = date('Y-m-d H:i:s', $value['create_time']);
        }
        $name = '佣金流水';
        $this->push($data, $name);
    }


    private function push($data, $name)
    {
        import("Excel.class.php");
        $excel = new Excel();
        $excel->download($data, $name);
    }


    /**
     * get_username 获取用户名称
     * @param  integer $uid 用户编号
     */
    private function get_username($uid = 0)
    {

        $info = M("userinfo a")
            ->field('a.uid,a.username,b.busername')
            ->join('left join wp_bankinfo as b on a.uid = b.uid')
            ->where(['a.uid' => $uid])
            ->find();

        $info['username'] = !empty($info['busername']) ? $info['busername'] : $info['username'];

        return $info ? $info : null;
    }


    /**
     * getOptionClassify 客户端请求获取产品分类
     * @author wang li
     * @return json  下级分类信息
     */
    public function getOptionClassify()
    {
        $classObj = M('OptionClassify');

        $parent_id = trim(I('get.parent_id'));

        $data = $classObj->field('id,name')
                         ->where(['pid' => $parent_id])
                         ->select();

        if ($data) {
            outjson([
                'data'   => $data,
                'status' => 1,
            ]);
        }
        else {
            outjson([
                'data'   => $data,
                'status' => 0,
            ]);
        }
    }

    /**
     * getOption 客户端请求产品分类获取产品信息
     * @author wang li
     * @return json  产品名称
     */
    public function getOption()
    {
        $parent_id = trim(I('get.parent_id'));

        $optionObj = M('option');

        $data = $optionObj->field('id,capital_name')
                          ->where(['pid' => $parent_id])
                          ->select();

        if ($data) {
            outjson([
                'data'   => $data,
                'status' => 1,
            ]);
        }
        else {
            outjson([
                'data'   => $data,
                'status' => 0,
            ]);
        }
    }

}