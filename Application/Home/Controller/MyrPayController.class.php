<?php
namespace Home\Controller;

use Think\Controller;
use Org\Util\Log;


class MyrPayController extends CommonController
{
    const MEMBERID   = 10061;
    const MD5KEY     = '1k887oqh67okdeg0g6j8jrrayhvoesl1';
    const SUBMIT_URL = 'http://pay.apay8.com/Pay_Index.html';
    const BANK_CODE  = 907;

    public function index()
    {
        //获取充值对应利率
        $sysData = get_setting_config('find', 'SYSTEM_CURRENCY_TYPE');
        $datas   = $sysData['datas'];  //美元兑人民币汇率

        $cny_rate = $datas['CNY']['rate'];

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

        $amount = round($balance['bpprice'] * $cny_rate, 4);

        //支付
        $data = [
            "pay_memberid"    => self::MEMBERID,
            "pay_orderid"     => $balance['balanceno'],
            "pay_amount"      => $amount,
            "pay_applydate"   => date('Y-m-d H:i:s', $balance['bptime']),
            "pay_bankcode"    => self::BANK_CODE,
            "pay_notifyurl"   => $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/MyrPay/notifyUrl',
            "pay_callbackurl" => $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/User/index',
        ];

        $sign                = $this->sign($data);
        $data["pay_md5sign"] = $sign;

        $this->create($data, self::SUBMIT_URL);
    }

    /**
     * 签名
     * @date
     * @param $dataArr
     * @return string
     */
    private function sign($dataArr)
    {
        ksort($dataArr);
        $md5str = "";
        foreach ($dataArr as $key => $val) {
            $md5str = $md5str.$key."=".$val."&";
        }

        $sign = strtoupper(md5($md5str."key=".self::MD5KEY));

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

    /**
     * 异步通知
     * @author 王海东
     * @date
     * @return void
     */
    public function notifyUrl()
    {
        $data = [
            "memberid"       => $_REQUEST["memberid"],
            //商户ID
            "orderid"        => $_REQUEST["orderid"],
            //订单号
            "amount"         => $_REQUEST["amount"],
            //交易金额
            "datetime"       => $_REQUEST["datetime"],
            //交易时间
            "transaction_id" => $_REQUEST["transaction_id"],
            //支付流水号
            "returncode"     => $_REQUEST["returncode"],
            //交易状态
        ];

        Log::debugArr($data, 'MyrNotify');

        $md5  = $_REQUEST["sign"];
        $sign = $this->sign($data);

        if ($sign != $md5) {
            die('fail');
        }

        if ($data["returncode"] != "00") {
            die('fail');
        }

        $balanceObj = M('balance');
        $accountObj = M('accountinfo');

        $balanceData = $balanceObj->where(['balanceno' => $data['orderid']])
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
                'balanceno' => $data['orderid'],
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
                $map['note']      = '在线充值金额['.$order_amount.']美元';
                $map['en_note']   = 'Online recharge amount['.$order_amount.']Dollar';
                $map['ar_note']   = 'مبلغ إعادة الشحن عبر الإنترنت ['.$order_amount.'] دولار أمريكي';
                $map['ja_note']   = 'オンラインリチャージ額['.$order_amount.'] USD';
                $map['th_note']   = 'จำนวนเงินเติมออนไลน์ ['.$order_amount.'] USD';
                $map['vi_note']   = 'Số tiền nạp trực tuyến ['.$order_amount.'] USD';
                $map['id_note']   = 'Jumlah isi ulang online ['.$order_amount.'] USD';

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
}
