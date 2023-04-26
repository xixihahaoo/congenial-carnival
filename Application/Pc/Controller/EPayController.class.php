<?php
namespace Pc\Controller;

use Think\Controller;
use Org\Util\Log;


class EPayController extends CommonController
{
    //PASS = 'zhuzhu123@'
    const ACCOUNT    = 'bbg2018bbg2018@gmail.com';
    const API_KEY    = 'c14244a734f4420364753173297300fd';
    const SUBMIT_URL = 'https://api.epay.com/paymentApi/merReceive';

    protected $notifyUrl      = '/Pc/EPay/server';//异步通知地址
    protected $callback_ok    = '/Pc/EPay/page.html';
    protected $callback_error = '/Pc/EPay/error.html';

    public function index()
    {
        //                $data = [
        //                    'CNY'  => [
        //                        'name' => '人民币',
        //                        'code' => 'CNY',
        //                        'rate' => 7.4,
        //                    ],
        //                    'HKD'  => [
        //                        'name' => '港元',
        //                        'code' => 'HKD',
        //                        'rate' => 7.8424,
        //                    ],
        //                    'MYR'  => [
        //                        'name' => '马来西亚林吉特',
        //                        'code' => 'MYR',
        //                        'rate' => 4.5,
        //                    ],
        //                    'USD'  => [
        //                        'name' => '美元',
        //                        'code' => 'USD',
        //                        'rate' => 1,
        //                    ],
        //                    'EUR'  => [
        //                        'name' => '欧元',
        //                        'code' => 'EUR',
        //                        'rate' => 0.9050,
        //                    ],
        //                    'GBP'  => [
        //                        'name' => '英镑',
        //                        'code' => 'GBP',
        //                        'rate' => 0.7753,
        //                    ],
        //                    'JPY'  => [
        //                        'name' => '日元',
        //                        'code' => 'JPY',
        //                        'rate' => 108.73,
        //                    ],
        //                    'BTC'  => [
        //                        'name' => '比特币',
        //                        'code' => 'BTC',
        //                        'rate' => 0.00011,
        //                    ],
        //                    'ETH'  => [
        //                        'name' => '以太坊',
        //                        'code' => 'ETH',
        //                        'rate' => 0.00550,
        //                    ],
        //                    'EOS'  => [
        //                        'name' => 'EOS币',
        //                        'code' => 'EOS',
        //                        'rate' => 0.29864,
        //                    ],
        //                    'BCH'  => [
        //                        'name' => '比特币现金',
        //                        'code' => 'BCH',
        //                        'rate' => 0.00376,
        //                    ],
        //                    'LTC'  => [
        //                        'name' => '莱特币',
        //                        'code' => 'LTC',
        //                        'rate' => 0.01716,
        //                    ],
        //                    'XRP'  => [
        //                        'name' => '瑞波币',
        //                        'code' => 'XRP',
        //                        'rate' => 3.84024,
        //                    ],
        //                    'USDT' => [
        //                        'name' => 'USDT',
        //                        'code' => 'USDT',
        //                        'rate' => 1,
        //                    ],
        //                ];
        //
        //                echo serialize($data);die;


        $balanceno = trim(I('get.balanceno'));

        if (empty($balanceno)) {
            $this->error(L('api_cannot_empty'));
        }

        $balanceObj = M('balance');

        $balance = $balanceObj->where([
            'uid'       => $this->user_id,
            'balanceno' => $balanceno,
            'status'    => 0,
        ])
                              ->find();

        if (!$balance) {
            $this->error(L('api_not_exist'));
        }

        $sysData = get_setting_config('find', 'SYSTEM_CURRENCY_TYPE');
        $datas   = $sysData['datas'];  //美元兑人民币汇率

        $currency = [
            ['code' => 'USD'],
            ['code' => 'EUR'],
            ['code' => 'HKD'],
            ['code' => 'GBP'],
            ['code' => 'JPY'],

            ['code' => 'BTC'],
            ['code' => 'ETH'],
            ['code' => 'EOS'],
            ['code' => 'BCH'],
            ['code' => 'LTC'],
            ['code' => 'XRP'],
            ['code' => 'USDT'],
        ];

        foreach ($currency as $key => $val) {

            if (isset($datas[ $val['code'] ]['rate'])) {
                $rate = $datas[ $val['code'] ]['rate'];
            }
            else {
                $rate = 0;
            }

            $currency[ $key ]['rate']        = $rate;
            $currency[ $key ]['true_amount'] = round($balance['bpprice'] * $rate, self::set_digit($val['code']));
        }

        $this->assign('balanceno', $balanceno);
        $this->assign('amount', $balance['bpprice']);
        $this->assign('currency', $currency);
        $this->display('index');
    }


    public function pay()
    {
        $balanceno = trim(I('get.balanceno'));
        $code      = trim(I('get.code'));

        if (empty($balanceno)) {
            $this->error(L('api_cannot_empty'));
        }

        $balanceObj = M('balance');

        $balance = $balanceObj->where([
            'uid'       => $this->user_id,
            'balanceno' => $balanceno,
            'status'    => 0,
        ])
                              ->find();

        if (!$balance) {
            $this->error(L('api_not_exist'));
        }

        $sysData = get_setting_config('find', 'SYSTEM_CURRENCY_TYPE');
        $datas   = $sysData['datas'];  //美元兑人民币汇率


        if (isset($datas[ $code ]['rate'])) {
            $rate = $datas[ $code ]['rate'];
        }
        else {
            $rate = 0;
        }

        $amount = round($balance['bpprice'] * $rate, self::set_digit($code));

        if ($amount <= 0) {
            $this->error(L('pay_amount_error'));
        }

        //支付
        $data = [
            "PAYEE_ACCOUNT"      => self::ACCOUNT,
            "PAYEE_NAME"         => 'Recharge',
            "PAYMENT_AMOUNT"     => $amount,
            "PAYMENT_UNITS"      => $code,
            "PAYMENT_ID"         => $balanceno,
//            'INTERFACE_LANGUAGE' => 'zh_cn',
            "STATUS_URL"         => $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$this->notifyUrl,
            "PAYMENT_URL"        => $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$this->callback_ok,
            "NOPAYMENT_URL"      => $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$this->callback_error,
        ];

        $data["V2_HASH"] = $this->sign($data);;

        $this->create($data, self::SUBMIT_URL);
    }

    private function sign($param)
    {
        $sign = strtolower(md5($param['PAYEE_ACCOUNT'].':'.$param['PAYMENT_AMOUNT'].':'.$param['PAYMENT_UNITS'].':'.self::API_KEY));

        return $sign;
    }

    //表单提交
    private function create($data, $submitUrl)
    {
        $inputstr = "";
        foreach ($data as $key => $v) {
            $inputstr .= '<input type="hidden"  id="'.$key.'" name="'.$key.'" value="'.$v.'"/>';
        }
        $form = '<form action="'.$submitUrl.'" name="pay" id="pay" method="POST">';
        $form .= $inputstr;
        $form .= '</form>';
        $html = '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml"><head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Loading.....</title>
        </head><body>
        ';
        $html .= $form;
        $html .= '
        <script type="text/javascript">
           document.getElementById("pay").submit();
        </script>';
        $html .= '</body></html>';
        echo $html;

        exit;

    }

    public function server()
    {
        $param = [
            "PAYEE_ACCOUNT"  => $_REQUEST["PAYEE_ACCOUNT"],
            "ORDER_NUM"      => $_REQUEST["ORDER_NUM"],
            "PAYMENT_AMOUNT" => $_REQUEST["PAYMENT_AMOUNT"],
            "PAYMENT_UNITS"  => $_REQUEST["PAYMENT_UNITS"],
            "PAYMENT_ID"     => $_REQUEST["PAYMENT_ID"],
            "STATUS"         => $_REQUEST["STATUS"],
            "TIMESTAMPGMT"   => $_REQUEST["TIMESTAMPGMT"],
            'PAYER_ACCOUNT'  => $_REQUEST["PAYER_ACCOUNT"],
            'V2_HASH2'       => $_REQUEST["V2_HASH2"],
        ];

        $sign = strtolower(md5($param['PAYMENT_ID'].':'.$param['ORDER_NUM'].':'.$param['PAYEE_ACCOUNT'].':'.$param['PAYMENT_AMOUNT'].':'.$param['PAYMENT_UNITS'].':'.$param['PAYER_ACCOUNT'].':'.$param['STATUS'].':'.$param['TIMESTAMPGMT'].':'.self::API_KEY));

        Log::debugArr($sign, 'Paysign');
        Log::debugArr($param, 'PayNotify');

        if ($sign != $param['V2_HASH2']) {
            die('fail');
        }

        if ($param["STATUS"] != 2) {
            die('fail');
        }

        $balanceObj = M('balance');
        $accountObj = M('accountinfo');

        $balanceData = $balanceObj->where(['balanceno' => $param['PAYMENT_ID']])
                                  ->find();

        if (!$balanceData) {
            die('fail');
        }
        else {
            if ($balanceData['status'] == 1) {
                die('Success');
            }
        }

        $accountObj->startTrans();

        try {
            $order_amount = $balanceData['bpprice'];

            $balance['status']     = 1;
            $balance['cltime']     = time();
            $balance['shibpprice'] = $balanceData['shibpprice'] + $order_amount;

            $balanceRes = $balanceObj->where([
                'balanceno' => $param['PAYMENT_ID'],
                'uid'       => $balanceData['uid'],
            ])
                                     ->save($balance);

            if ($balanceRes) {

                $accountArr = [
                    'balance'        => [
                        'exp',
                        '`balance`+'.$order_amount.'',
                    ],
                    'recharge_total' => [
                        'exp',
                        '`recharge_total`+'.$order_amount.'',
                    ],
                ];

                $moneyRes = $accountObj->where(['uid' => $balanceData['uid']])
                                       ->save($accountArr);
            }

            if ($balanceRes && $moneyRes) {
                $map['uid']       = $balanceData['uid'];
                $map['type']      = 4;
                $map['oid']       = $balanceData['bpid'];
                $map['note']      = '资金变动增加['.$order_amount.']美元';
                $map['en_note']   = 'Increased capital movements['.$order_amount.']Dollar';
                $map['balance']   = $accountObj->where(['uid' => $balanceData['uid']])
                                               ->sum('balance');
                $map['op_id']     = $balanceData['uid'];
                $map['user_type'] = 1;
                $map['dateline']  = time();
                M("money_flow")->add($map);

                $accountObj->commit();
                die('Success');
            }
            else {
                $accountObj->rollback();
                die('fail');
            }

        } catch (\Exception $e) {
            $accountObj->rollback();
            die('fail');
        }
    }

    private static function set_digit($code)
    {
        $currency = [
            'USD'  => 2,
            'EUR'  => 2,
            'HKD'  => 2,
            'GBP'  => 2,
            'JPY'  => 2,
            'BTC'  => 5,
            'ETH'  => 5,
            'EOS'  => 5,
            'BCH'  => 5,
            'LTC'  => 5,
            'XRP'  => 5,
            'USDT' => 2,
        ];

        return $currency[ $code ];
    }
}
