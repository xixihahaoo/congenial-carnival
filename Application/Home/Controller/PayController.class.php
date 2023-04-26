<?php
/**
 * Created by PhpStorm.
 * @User: wanglin
 * @Date: 19-5-14 下午3:34
 */

namespace Home\Controller;

use Think\Exception;

class PayController extends CommonController
{
    protected $memberid = '10063';//商户id

    protected $url = 'https://pay.apay8.com/Pay_cashier_index.html';//接口地址


    protected $userName = 'APAY9318';//用户名

    protected $pay_bankcode = '907';

    protected $apiUrl = '';
    protected $notifyUrl = '/Pc/Pay/server';//异步通知地址


    protected $md5_key = 'fvjouqiisrgtrmvxh6lifk5tehezsv5d';

    protected $callback = '/Home/Pay/page.html';



    protected $params = null;

    public function sendOrder($amount){
        $orderNo = 'E'.date("YmdHis").rand(100000,999999);    //订单号
        //        //获取充值对应利率
        //        $sysData = get_setting_config('find', 'SYSTEM_CURRENCY_TYPE');
        //        $datas   = $sysData['datas'];  //美元兑人民币汇率
        //
        //        $cny_rate = $datas['CNY']['rate'];
        //        $amount = round($amount * $cny_rate,4);
        $this->params = [
            'pay_memberid' => $this->memberid,
            'pay_orderid' => $orderNo,
            'pay_amount' => $amount,
            'pay_applydate' => date('Y-m-d H:i:s'),
            'pay_notifyurl' => $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$this->notifyUrl,
            'pay_callbackurl' => $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$this->callback,
        ];
        $this->params['pay_md5sign'] = $this->sign();
        $this->params['pay_attach'] = "1234|456";
        $this->params['pay_productname'] = 'VIP基础服务';
        $this->params['currency'] = 'USD';
        return $this->params;
    }

    /**
     * 制作签名
     * @author
     * @date   19-5-13 上午10:41
     * @return string
     */
    protected function sign()
    {

        $param = $this->params;
        ksort($param);
        $md5str = "";
        foreach ($param as $key => $val) {
            $md5str = $md5str . $key . "=" . $val . "&";
        }
        $sign = strtoupper(md5($md5str . "key=" . $this->md5_key));

        return $sign;
    }

    /**
     * 充值页面
     * @author
     * @date   19-5-13 上午11:18
     * @return void
     */
    public function pay()
    {
        $this->display('pay');
    }

    /**
     * 提交页面
     * @author
     * @date   19-5-13 上午11:18
     * @return void
     */
    public function index()
    {
        $amount = I('amount');
        if(empty($amount)){
            outjson([
                'code' => 400,
                'msg'  => '金额不得为空!',
            ]);
        }
        //        if($amount < 1200 || $amount > 7000){
        //            outjson([
        //                'code' => 400,
        //                'msg'  => '单笔交易金额最低为1200 ,最高为7000',
        //            ]);
        //        }
        $params = $this->sendOrder($amount);
        //充值记录
        $where['bptime']      = time();
        //充值利率
        $accountObj = M('accountinfo');
        $sysData = get_setting_config('find', 'SYSTEM_DOLLAR_SETTING');
        $shibpprice = $accountObj->where(['uid' => $this->user_id])
                                 ->sum('balance');
        $rate    = $sysData['datas']['data'][0];
        $where['bpprice']     = $amount;
        $where['bpprice_cny'] = round($amount * $rate['value'], 2);
        $where['uid']         = $this->user_id;
        $where['cltime']      = time();
        $where['balanceno']   = $params['pay_orderid'];
        $where['shibpprice']  = $shibpprice;
        $where['status']      = 0;//待处理
        $where['pay_type']    = 28;
        //支付请求
        $data['create_time'] = date('Y-m-d H:i:s');
        $data['content'] = json_encode($params);
        $data['uid'] = $this->user_id;
        M('test')->add($data);
        $res = M("balance")->add($where);
        if(!$res){
            outjson([
                'code' => 400,
                'msg'  => '充值失败',
            ]);
        }
        $string = "<form style='display:none;' id='form1' name='form1' method='post' action='" . $this->url . "'>";

        foreach ($params as $key => $value) {

            if (!isset($value) || is_null($value) || empty($value)) {

                unset($params[$key]);

                continue;

            } else {

                $string .= "<input name='" . $key . "' type='text' value='" . $value . "' />";

            }

        }

        $string .= "</form>";

        $string .= "<script type='text/javascript'>function load_submit(){document.form1.submit()}load_submit();</script>";

        echo $string;
    }

    /**
     * 服务端返回地址
     * @author
     * @date   19-5-13 上午11:32
     * @return void
     */
    public function server()
    {
        $returnArray = array( // 返回字段
                              "memberid" => $_REQUEST["memberid"], // 商户ID
                              "orderid" =>  $_REQUEST["orderid"], // 订单号
                              "amount" =>  $_REQUEST["amount"], // 交易金额
                              "datetime" =>  $_REQUEST["datetime"], // 交易时间
                              "currency" =>  $_REQUEST["currency"],
                              "transaction_id" =>  $_REQUEST["transaction_id"], // 支付流水号
                              "returncode" => $_REQUEST["returncode"],
        );
        //支付回调
        $data['create_time'] = date('Y-m-d H:i:s');
        $data['content'] = '111';
        M('test')->add($data);
        ksort($returnArray);
        reset($returnArray);
        $md5str = "";
        foreach ($returnArray as $key => $val) {
            $md5str = $md5str . $key . "=" . $val . "&";
        }
        $sign = strtoupper(md5($md5str . "key=" . $this->md5_key));
        if ($sign == $_REQUEST["sign"]) {
            if ($_REQUEST["returncode"] == "00") {
                $db = M();
                $db->startTrans();
                try{
                    $str = "交易成功！订单号：".$_REQUEST["orderid"];
                    //修改充值信息 增加资金流水记录 修改客户余额字段
                    //修改账户余额
                    $balanceInfo = $db->table('wp_balance')->where(['balanceno' => $_REQUEST['orderid']])
                                      ->find();
                    if(!$balanceInfo){
                        $db->rollback();
                    }
                    $info['status'] = 1;
                    $balanceRes = $db->table('wp_balance')->where(['balanceno' => $_REQUEST['orderid']])->save($info);
                    if ($balanceRes === false) {
                        $db->rollback();
                    }
                    $trueAcinfo = $db->table('wp_accountinfo')->where(['uid' => $balanceInfo['uid']])
                                     ->setInc('balance', $balanceInfo['bpprice']);
                    if($trueAcinfo === false){
                        $db->rollback();
                    }
                    //增加资金流水记录
                    $shibpprice = $db->table('wp_accountinfo')->where(['uid' => $balanceInfo['uid']])
                                     ->sum('balance');
                    $map['uid']       = $balanceInfo['uid'];
                    $map['type']      = 4;
                    $map['note']      = '在线充值金额['.$balanceInfo['bpprice'].']美元';
                    $map['en_note']   = 'Online recharge amount['.$balanceInfo['bpprice'].']Dollar';
                    $map['ar_note']   = 'مبلغ إعادة الشحن عبر الإنترنت ['.$balanceInfo['bpprice'].'] دولار أمريكي';
                    $map['ja_note']   = 'オンラインリチャージ額['.$balanceInfo['bpprice'].'] USD';
                    $map['th_note']   = 'จำนวนเงินเติมออนไลน์ ['.$balanceInfo['bpprice'].'] USD';
                    $map['vi_note']   = 'Số tiền nạp trực tuyến ['.$balanceInfo['bpprice'].'] USD';
                    $map['id_note']   = 'Jumlah isi ulang online ['.$balanceInfo['bpprice'].'] USD';

                    $map['balance']   = $shibpprice;
                    $map['op_id']     = $balanceInfo['uid'];
                    $map['user_type'] = 1;
                    $map['dateline']  = time();
                    $flowRes =  $db->table('wp_money_flow')->add($map);
                    if($flowRes === false){
                        $db->rollback();
                    }
                    file_put_contents("success.txt",$str."\n", FILE_APPEND);
                    $db->commit();
                    exit("ok");
                }catch (Exception $e){
                    $db->rollback();
                    echo $e->getMessage();
                }
            }
        }
    }

    public function tets(){
        echo 111;die;
    }
    /**
     * 页面返回地址
     * @author
     * @date   19-5-13 上午11:32
     * @return void
     */
    public function page()
    {
        $returnArray = array( // 返回字段
                              "memberid" => $_REQUEST["memberid"], // 商户ID
                              "orderid" =>  $_REQUEST["orderid"], // 订单号
                              "amount" =>  $_REQUEST["amount"], // 交易金额
                              "datetime" =>  $_REQUEST["datetime"], // 交易时间
                              "currency" =>  $_REQUEST["currency"],
                              "transaction_id" =>  $_REQUEST["transaction_id"], // 流水号
                              "returncode" => $_REQUEST["returncode"]
        );
        ksort($returnArray);
        reset($returnArray);
        $md5str = "";
        foreach ($returnArray as $key => $val) {
            $md5str = $md5str . $key . "=" . $val . "&";
        }
        $sign = strtoupper(md5($md5str . "key=" . $this->md5_key));
        if ($sign == $_REQUEST["sign"]) {
            if ($_REQUEST["returncode"] == "00") {
                $this->display();
            }
        }else{
            $this->display('error');
        }
    }
}