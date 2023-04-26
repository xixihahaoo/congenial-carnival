<?php
namespace Pc\Controller;

use Think\Controller;


class WithdrawalsController extends CommonController
{

    public function _initialize()
    {
        parent::_initialize();
        self::IsLogin();
        $this->user_id = session('user_id');
    }

    /**
     * 提现
     * @author wang <li>
     */
    public function index()
    {
        $accountModel = M('accountinfo');
        $bankModel    = M('bankinfo');

        $account  = $accountModel->field('balance,gold')
                                 ->where(['uid' => $this->user_id])
                                 ->find();
        $bankinfo = $bankModel->where([
            'uid'    => $this->user_id,
            'status' => 1,
        ])
                              ->select();

        foreach ($bankinfo as $key => $value) {
            $bankinfo[ $key ]['banknameMsg'] = $value['bankname'].'('.substr($value['banknumber'], count($value['banknumber']) - 5).')';
        }

        //        $personal = M('personal_user_data')->where(array('uid' => $this->user_id))->find();

        //        if($personal)
        //        {
        //            if($personal['status'] == '0' || $personal['status'] == 2)
        //            {
        //                $this->redirect('User/examine');
        //            }
        //
        //        } else {
        //            $this->redirect('User/standardOpen');
        //        }


        if (!$bankinfo) {
            $this->redirect('User/BrokersOpen');
        }
        else {
            $this->assign('bankinfo', $bankinfo);
            $this->assign('account', $account);
            $this->display();
        }
    }

    /**
     * [withdrawals 提现提交]
     * @return [type] [description]
     */
    public function withdrawals()
    {
        $bank   = trim(I('post.bank'));
        $amount = trim(I('post.amount'));

        if ($amount < 100) {
            outjson([
                'code' => 400,
                'msg'  => L('api_minimum'),
            ]);
        }

        $bankModel    = M('bankinfo');
        $accountModel = M('accountinfo');

        $bank = $bankModel->where(['bid' => $bank])
                          ->find();

        if (!$bank) {
            outjson([
                'code' => 400,
                'msg'  => L('api_user_not'),
            ]);
        }

        $balance = $accountModel->where(['uid' => $this->user_id])
                                ->getField('balance');

        if ($amount > $balance) {
            outjson([
                'code' => 400,
                'msg'  => L('api_balance_insufficient'),
            ]);
        }

        $dataArray = [
            'uid'         => $this->user_id,
            'bank_id'     => $bank['bid'],
            'balance'     => (M('accountinfo')
                    ->where(['uid' => $this->user_id])
                    ->sum('balance') - $amount),
            'balanceno'   => $this->numberOrder(),
            'amount'      => $amount,
            'busername'   => $bank['busername'],
            'banknumber'  => $bank['banknumber'],
            'bankname'    => $bank['bankname'],
            'branch'      => $bank['branch'],
            'status'      => 0,
            'card'        => $bank['card'],
            'tel'         => $bank['tel'],
            'swiftcode'   => $bank['swiftcode'],
            'address'     => $bank['address'],
            'create_time' => time(),
        ];

        $flowModel     = M('MoneyFlow');
        $withdrawModel = M('withdraw');
        $withdrawModel->startTrans();

        $res         = $withdrawModel->add($dataArray);
        $account_res = $accountModel->where(['uid' => $this->user_id])
                                    ->setDec('balance', $amount);

        try {
            if ($res && $account_res) {
                if ($withdrawModel->commit()) {
                    //添加出入金流动表
                    $map['uid']       = $this->user_id;
                    $map['type']      = 3;
                    $map['oid']       = $res;
                    $map['note']      = '用户申请提现扣除['.$amount.']美元';
                    $map['en_note']   = 'User Application for Discount Deduction['.$amount.']Dollar';
                    $map['balance']   = M('accountinfo')
                        ->where(['uid' => $this->user_id])
                        ->sum('balance');
                    $map['op_id']     = $this->user_id;
                    $map['user_type'] = 1;
                    $map['dateline']  = time();
                    $flowModel->add($map);
                }
                outjson([
                    'code' => 200,
                    'msg'  => L('api_success'),
                ]);
            }
            else {
                $withdrawModel->rollback();
                outjson([
                    'code' => 400,
                    'msg'  => L('api_fail'),
                ]);
            }
        } catch (Exception $e) {
            $withdrawModel->rollback();
            outjson([
                'code' => 400,
                'msg'  => $e->errorMessage(),
            ]);
        }
    }


    /**
     * [withdrawList 提现记录 ]
     * @return [type] [description]
     */
    public function withdrawList()
    {
        $withdrawModel = M('withdraw');

        $withdraw = $withdrawModel->field('create_time,amount,status')
                                  ->where(['uid' => $this->user_id])
                                  ->order('create_time desc')
                                  ->select();

        foreach ($withdraw as $key => $value) {
            $withdraw[ $key ]['create_time'] = date('y/m/d H:i:s', $value['create_time']);
            if ($value['status'] == '0') {
                $withdraw[ $key ]['status'] = L('api_in_audit');
            }
            elseif ($value['status'] == 1) {
                $withdraw[ $key ]['status'] = L('api_audit_pass');
            }
            elseif ($value['status'] == 2) {
                $withdraw[ $key ]['status'] = L('api_audit_failure');
            }
        }

        $this->assign('list', $withdraw);
        $this->display();
    }


    /**
     * [bankinfo 银行卡信息]
     * @author wang li
     */
    public function bankinfo()
    {
        $bankObj     = M('bankinfo');
        $personalObj = M('personal_user_data a');

        $prefix = C('DB_PREFIX');

        $personal = $personalObj->field('a.real_name,a.card,a.status,b.face')
                                ->where(['a.uid' => $this->user_id])
                                ->join('right join '.$prefix.'userinfo b on a.uid=b.uid')
                                ->find();

        //        if($personal)
        //        {
        //            if($personal['status'] == '0' || $personal['status'] == 2)
        //            {
        //                $this->redirect('User/examine');
        //            }
        //
        //        } else {
        //            $this->redirect('User/standardOpen');
        //        }


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
            $bank[ $key ]['banknumber'] = substr_replace($value['banknumber'], '**** **** **** ', 0, 12);
        }


        $this->assign('personal', $personal);
        $this->assign('bank', $bank);
        $this->display();
    }

    /**
     * [Unbundling 银行卡解绑]
     */
    public function Unbundling()
    {
        $id = trim(I('post.id'));

        if (empty($id)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_fail'),
            ]);
        }

        $bankObj = M('bankinfo');

        $res = $bankObj->where([
            'uid' => $this->user_id,
            'bid' => $id,
        ])
                       ->delete();
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


    /**
     * 订单编号
     * @author wang
     */
    private function numberOrder()
    {
        return $this->user_id.time().mt_rand();
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
