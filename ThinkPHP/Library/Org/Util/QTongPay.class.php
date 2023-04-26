<?php
/**
 * 钱通支付
 */
namespace Org\Util;
use Org\Util\Log;
use Think\Exception;

class QTongPay
{

    // 测试环境
    // private $gatewayUrl = "https://123.56.119.177:8443/pay/pay.htm";
    // private $notifyUrl  = "http://aaa.hjb58.com/demo_php/notify_linjuming.php";
    // private $merchantId = 1001508;  // 测试账号

    // 正式环境
    private $gatewayUrl = "https://www.qtongpay.com/pay/pay.htm";
    private $merchantId = 1003518;
    private $merchantPassword = 111111; // 证书密码 todo : 换密码

    public function __construct()
    {
        $config = $this->_getConfig();

        $this->merchantId = $config['merchantId'];
        $this->merchantPassword = $config['merchantPassword'];
        $this->gatewayUrl = $config['gatewayUrl'];
        $this->notifyUrl = U('home/PayQt/notify', '', true, true);
    }

    /**
     * 微信扫码支付方法
     * by linjuming 2017-5-8
     * @param array $balance 交易详细，wp_balance表中的一条记录
     * @return array
     */
    public function weiXinScanOrder($balance)
    {
        Log::debugArr('begin weiXinScanOrder', 'qtpay');
        $rs = $this->postOrder('weiXinScanOrder', $balance);
        return $rs;
    }

    /**
     * 支付宝扫码支付方法
     * by linjuming 2017-5-8
     * @param array $balance 交易详细，wp_balance表中的一条记录
     * @return array
     */
    public function zfbScanOrder($balance)
    {
        $rs = $this->postOrder('ZFBScanOrder', $balance);
        return $rs;
    }


    /**
     * 获取配置
     * @return array
     */
    private function _getConfig()
    {
        static $config;
        if ($config) return $config;

        $config = require(VENDOR_PATH . 'QtPay/config.inc.php');
        return $config;
    }

    /*	public function jumpRequest(){
            $config = $this->_getConfig();
            $xml = file_get_contents(VENDOR_PATH.'QtPay/tpl/CertPayOrderH5Request.xml');
            $xml = str_replace('[merchantId]', $config['merchantId'], $xml);
            $xml = str_replace('[merchantOrderId]', $balance['balanceno'], $xml);
            $xml = str_replace('[merchantName]', '恒金宝', $xml);
            $xml = str_replace('[merchantOrderAmt]', $balance['bpprice']*100, $xml);
            $xml = str_replace('[merchantOrderDesc]', $balance['bptype'], $xml);
            $xml = str_replace('[userName]', $_SESSION['username'], $xml);
            $xml = str_replace('[payerId]', $balance['uid'], $xml);  // todo 手册中说必填，但没交代到底是什么
            $xml = str_replace('[salerId]', '', $xml);
            $xml = str_replace('[guaranteeAmt]', 0, $xml);
            $xml = str_replace('[merchantPayNotifyUrl]', $this->_getNotifyUrl(), $xml);
            $xml = str_replace('[merchantFrontEndUrl]', '', $xml); // todo 支付完跳转地址？

            $strMD5 =  MD5($xml,true);
            $strsign =  sign($strMD5);
            $base64_src=base64_encode($str);
            $msg = $base64_src."|".$strsign;

            $def_url =  '<div style="text-align:center">';
            $def_url .= '<body onLoad="//document.ipspay.submit();">网银订单确认';
            $def_url .= '<form name="ipspay" action="'.$gateway_url.'" method="post">';
            $def_url .=	'<input name="msg" type="hidden" value="'.$msg.'" /><input type="submit" value="提交"/>';
            $def_url .=	'</form></div>';
            echo $def_url;

        }*/

    public function getPostString($type, $params)
    {
        $orderNum = $params['balanceno'];
        $amount = $params['bpprice'] * 100;//单位：分

        $merchantId = $this->merchantId;
        $time = time();
        switch ($type) {
            case 'WeiXinScanOrder':
                $str = '<?xml version="1.0" encoding="utf-8" standalone="no"?><message application="WeiXinScanOrder" version="1.0.1"
						timestamp="' . $time . '"
						merchantId="' . $merchantId . '"
						merchantOrderId="' . $orderNum . '"
						merchantOrderAmt="' . $amount . '"
						merchantOrderDesc="会员充值"
						userName="HJB USER"
						payerId="' . md5($params['uid']) . '"
						salerId=""
						guaranteeAmt="0"
						merchantPayNotifyUrl="' . $this->notifyUrl . '"/>';
                break;
            case 'ZFBScanOrder':
                $str = '<?xml version="1.0" encoding="utf-8" standalone="no"?><message application="ZFBScanOrder" version="1.0.1"
						timestamp="' . $time . '"
						merchantId="' . $merchantId . '"
						merchantOrderId="' . $orderNum . '"
						merchantOrderAmt="' . $amount . '"
						merchantOrderDesc="会员充值"
						userName="HJB USER"
						payerId="' . md5($params['uid']) . '"
						salerId=""
						guaranteeAmt="0"
						merchantPayNotifyUrl="' . $this->notifyUrl . '"/>';
                break;
            default :
                throw new Exception("not support method.");
                break;
        }


        return $str;
    }

    public function postOrder($type, $params)
    {
        $str = $this->getPostString($type, $params);
        Log::debugArr('postOrder params string :'.$str, 'qtpay');
        /*****生成请求内容**开始*****/
        $strMD5 = MD5($str, true);
        $strsign = $this->sign($strMD5);
        $base64_src = base64_encode($str);
        $msg = $base64_src . "|" . $strsign;
        /*****生成请求内容**结束*****/
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->gatewayUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $tmp = explode("|", $result);
        $resp_xml = base64_decode($tmp[0]);
        $resp_sign = $tmp[1];
        $return = array('status' => 1, 'msg' => 'Success');
        if ($this->verity(MD5($resp_xml, true), $resp_sign)) {//验签
            $rs = $this->parseXmlStr($resp_xml);
            //return $rs['@attributes'];
            $responseData = $rs['@attributes'];
            if ($responseData['respCode'] == '000') {//下单成功
                Log::debugArr('postOrder success', 'qtpay');
                Log::debugArr($responseData, 'qtpay');
//                @file_get_contents($responseData['codeUrl']);
//                header("Location: ".$responseData['codeUrl']);
                //echo "<script>location.href='".$responseData['codeUrl']."'</script>";
                //exit;
                $return = array('status' => 1, 'codeUrl' => $responseData['codeUrl']);
            } else {
                Log::debugArr('postOrder Error code:'.$responseData['respCode'], 'qtpay');
                $return = array('status' => 0, 'msg' => 'Error');
            }
        } else {
            Log::debugArr('postOrder 验签失败', 'qtpay');
            $return = array('status' => 0, 'msg' => '验签失败');
        }
        return $return;
    }


    /**
     * xml 转换成数组
     * @param  string $str xml字符串
     * @return array
     */
    public function parseXmlStr($str)
    {
        $rs = (array)simplexml_load_string($str);
        return $rs;
    }


    /**
     * 签名  生成签名串  基于sha1withRSA
     * @param string $data 签名前的字符串
     * @return string 签名串
     */
    private function sign($data)
    {
        $certs = array();
        $cont = file_get_contents(VENDOR_PATH . 'QtPay/merchants/merchant_cert.pfx');
        openssl_pkcs12_read($cont, $certs, $this->merchantPassword); //其中password为你的证书密码
        if (!$certs) return;
        $signature = '';
        openssl_sign($data, $signature, $certs['pkey']);
        return base64_encode($signature);
    }


    /**
     * 验证签名：
     * @param data ：原文
     * @param signature ：签名
     * @return bool 返回：签名结果，true为验签成功，false为验签失败
     */
    private function verity($data, $signature)
    {
        $pubKey = file_get_contents(VENDOR_PATH . 'QtPay/merchants/server_cert.cer');
        $res = openssl_get_publickey($pubKey);
        $result = (bool)openssl_verify($data, base64_decode($signature), $res);
        openssl_free_key($res);
        return $result;
    }

    /**
     * 支付结果异步通知
     */
    public function notify()
    {
        $result = file_get_contents('php://input', 'r');
        $tmp = explode("|", $result);
        $resp_xml = base64_decode($tmp[0]);
        $resp_sign = $tmp[1];
        $return = array('status' => 0, 'msg' => '');

        if ($this->verity(MD5($resp_xml, true), $resp_sign)) {//验签
            /*$resp_xml = '<?xml version="1.0" encoding="utf-8" standalone="no"?><message application="NotifyOrder" merchantId="1001508" merchantOrderId="15520170508164801" version="1.0.1">
						<deductList>
							<item payAmt="1000" payDesc="付款成功" payOrderId="qiDZ39b2Q3rKV7t" payStatus="01" payTime="20170508164811"/>
						</deductList>
						<refundList/>
					</message>';*/
            $xml = simplexml_load_string($resp_xml);
            $res = json_decode(json_encode($xml), TRUE);
            $payStatus = $res['deductList']['item']['@attributes']['payStatus'] == '01' ? 'success' : 'failed';
            Log::debugArr('pay status : '.$payStatus, 'qtpay_notify');
            $amount = $res['deductList']['item']['@attributes']['payAmt']/100;//单位是分，/100转化为元
            $orderId = $res['@attributes']['merchantOrderId'];
            $payTime = $res['deductList']['item']['@attributes']['payTime'];
            $payDesc = $res['deductList']['item']['@attributes']['payDesc'];
            $return = array('status' => 1, 'payStatus' => $payStatus, 'orderId' => $orderId, 'amount' => $amount, 'payTime' => $payTime, 'msg' => $payDesc);
        } else {
            $return['msg'] = '验签失败';
            Log::debugArr($return['msg'], 'qtpay_notify');
        }
        return $return;
    }


}