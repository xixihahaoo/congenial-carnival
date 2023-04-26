<?php
namespace Home\Controller;

use Think\Controller;
use Org\Util\Log;


class FunPayController extends CommonController
{
    const USER_ID    = '202006071626445';  //商户号码
    const KEY        = 'e0f0905bbd6552b983872e86b96a7c2f';  //APIKEY
    const SUBMIT_URL = 'https://funpay.moneypay.cloud/api/v1/deposit';

    protected $notifyUrl   = 'http://39.107.99.235:1007/Pc/FunPay/server';//异步通知地址
    protected $callback_ok = 'http://39.107.99.235:1007/Home/FunPay/page.html';

    public function index()
    {
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
        $datas   = $sysData['datas'];

        $currency = [
            [
                'type' => 1,
                'name' => L('bank_transfer'),
                'code' => 'TWD',
            ],
            [
                'type' => 2,
                'name' => L('bank_ibon'),
                'code' => 'TWD',
            ],
        ];

        foreach ($currency as $key => $val) {

            if (isset($datas[ $val['code'] ]['rate'])) {
                $rate = $datas[ $val['code'] ]['rate'];
            }
            else {
                $rate = 0;
            }

            $currency[ $key ]['rate']        = $rate;
            $currency[ $key ]['true_amount'] = round($balance['bpprice'] * $rate, 0);
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
        $pay_type  = trim(I('get.pay_type'));

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

        $amount = round($balance['bpprice'] * $rate, 0);

        if ($amount <= 0) {
            $this->error(L('pay_amount_error'));
        }

        $post_data = [
            'userid'       => self::USER_ID,
            'orderid'      => $balanceno,
            'amount'       => $amount,
            'type'         => $pay_type,
            'url'          => $this->notifyUrl,
            'redirect_url' => $this->callback_ok,
            'phone'        => '0912345678',
        ];

        $sign = self::createSign($post_data);

        $post_data['sign'] = $sign;

        $ret = $this->postMethod(self::SUBMIT_URL, json_encode($post_data));

        if ($ret['code'] == 0) {
            header('Location:'.$ret['cashier']);
            exit;
        }
        else {
            $this->error($ret['message']);
        }

    }

    public function createSign($dataArr)
    {
        $signPars = "";
        ksort($dataArr);
        foreach ($dataArr as $k => $v) {
            $signPars .= $k."=".$v."&";
        }
        $signPars = $signPars."key=".self::KEY;

        return md5($signPars);
    }

    public function server()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data, true);

        $param = [
            "client_id"   => $data["client_id"],
            "amount"      => $data["amount"],
            "bill_number" => $data["bill_number"],
            "status"      => $data["status"],
            "timestamp"   => $data["timestamp"],
        ];

        $sign = $this->createSign($param);

        Log::debugArr($sign, 'Paysign');
        Log::debugArr($param, 'PayNotify');

        if ($sign != $data['sign']) {
            die('fail');
        }

        if ($param["status"] != '成功') {
            die('fail');
        }

        $balanceObj = M('balance');
        $accountObj = M('accountinfo');

        $balanceData = $balanceObj->where(['balanceno' => $param['bill_number']])
                                  ->find();

        if (!$balanceData) {
            die('fail');
        }
        else {
            if ($balanceData['status'] == 1) {
                die('OK');
            }
        }

        $accountObj->startTrans();

        try {
            $order_amount = $balanceData['bpprice'];

            $balance['status']     = 1;
            $balance['cltime']     = time();
            $balance['shibpprice'] = $balanceData['shibpprice'] + $order_amount;

            $balanceRes = $balanceObj->where([
                'balanceno' => $param['bill_number'],
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
                die('OK');
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

    public function page()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data, true);

        $param = [
            "client_id"   => $data["client_id"],
            "amount"      => $data["amount"],
            "bill_number" => $data["bill_number"],
            "status"      => $data["status"],
            "timestamp"   => $data["timestamp"],
        ];

        $sign = $this->createSign($param);

        if ($sign != $data['sign']) {
            return $this->display('error');
        }

        if ($param["status"] != '成功') {
            return $this->display('error');
        }

        return $this->display('page');
    }

    public function postMethod($url, $data)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60); //Timeout 時間
        $result = curl_exec($ch);

        return json_decode($result, true);
    }
}
