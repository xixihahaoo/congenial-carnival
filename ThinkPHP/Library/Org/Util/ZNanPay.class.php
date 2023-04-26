<?php
/**
 * 中南支付
 */
namespace Org\Util;
use Org\Util\Log;
use Think\Exception;

class ZNanPay
{

    // 测试环境
    // private $gatewayUrl = "https://123.56.119.177:8443/pay/pay.htm";
    // private $notifyUrl  = "http://aaa.hjb58.com/demo_php/notify_linjuming.php";
    // private $merchantId = 1001508;  // 测试账号

    // 正式环境
    private $gatewayUrl = "http://api.zhongnanpay.com:3022/hmpay/online/createWxOrder.do2";
    private $notifyurl = "";
    private $merchantId = "168666999001266";
    private $merchantPassword = "86z3u17v6mpuaht0"; // 证书密码 todo : 换密码
    

    public function __construct()
    {
        $config = $this->_getConfig();

        $this->merchantId = $config['merchantId'];
        $this->merchantPassword = $config['merchantPassword'];
        $this->gatewayUrl = $config['gatewayUrl'];
        $this->notifyUrl = U('home/PayZn/notify', '', true, true);
        $this->frontNotifyUrl = U('home/PayZn/jump_notify', '', true, true);
    }

    /**
     * 微信扫码支付方法
     * by linjuming 2017-5-8
     * @param array $balance 交易详细，wp_balance表中的一条记录
     * @return array
     */
    public function wxpay($balance)
    {
        Log::debugArr('begin wxpay', 'znpay');
        $rs = $this->postOrder('wxpay', $balance);
        return $rs;
    }

    /**
     * 支付宝扫码支付方法
     * by linjuming 2017-5-8
     * @param array $balance 交易详细，wp_balance表中的一条记录
     * @return array
     */
    public function alipay($balance)
    {
        $rs = $this->Postorder('alipay', $balance);
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

        $config = require(VENDOR_PATH . 'ZnPay/config.inc.php');
        return $config;
    }

   public function jumpRequest($params,$cardNo,$cardName,$idNo){

        $str = $this->getPostString('qkpay',$params,$cardNo,$cardName,$idNo);
        return $str;
    }
//       $str = $this->getPostString('qkpay',$params,$cardNo);
//       Log::debugArr('jumpRequest params string :'.$str, 'znpay');


//    <body>
//    <form id="submitPay" name="submitPay" action="http://ip:port/hmpay/online/createWxOrder.do" method="POST">
//        <input type="hidden" name="sign" value="be414b9b7dd652a4afb0dba88c48958f"/>
//        <input type="hidden" name="total_fee" value="50"/>  
//        <input type="hidden" name="pay_type" value="qkpay"/>
//        <input type="hidden" name="return_url" value="http://www.baidu.com"/>
//        <input type="hidden" name="notifyurl" value="http://api.zhongnanpay.com:3022/hmpay/online/notifyYUMOrder.do"/>
//        <input type="hidden" name="merchant_no" value="5921214141015223"/>
//        <input type="hidden" name="pay_num" value="ZN13972017052216125175448"/>
//        <input type="hidden" name="card_no" value="62155830101002925099"/>
//        <script>document.forms['submitPay'].submit();</script></script>    
//        </form>        
//    </body>
//</html> 




//        $def_url =  '<body>';
//        $def_url .= '<form id="submitPay" name="submitPay" action="'.$this->gatewayUrl.'" method="POST">';
//        
//        $def_url .= '<input type="hidden" name="merchant_no" value="'.$this->merchant_no.'"/>';
//        $def_url .= '<input type="hidden" name="total_fee" value="'.$this->total_fee.'"/>';
//        $def_url .= '<input type="hidden" name="pay_num" value="'.$this->pay_num.'"/>';
//        $def_url .= '<input type="hidden" name="notifyurl" value="'.$this->notifyurl.'"/>';
//        $def_url .= '<input type="hidden" name="sign" value="'.$this->sign.'"/>';
//        $def_url .= '<input type="hidden" name="card_no" value="'.$this->card_no.'"/>';
//        $def_url .= '<input type="hidden" name="return_url" value="'.$this->return_url.'"/>';
//        $def_url .= '<input type="hidden" name="sign" value="'.$this->sign.'"/>';
//        $def_url .=    '</form> ';
//        $def_url .=    '</body> ';
//        $def_url .=    '</html> ';
//        return $def_url;



    public function getPostString($type, $params,$cardNo,$cardName,$idNo)
    {
        $orderNum = $params['balanceno'];
        $amount = $params['bpprice'] * 100;//单位：分

        $merchantId = $this->merchantId;
        $merchantPassword = $this->merchantPassword;
        $toDay=date('Ymd');
        Log::debugArr($merchantId, 'znpay');
        Log::debugArr($merchantPassword, 'znpay');
        Log::debugArr($toDay, 'znpay');
        Log::debugArr($amount, 'znpay');
        $strSign=$merchantId . $amount . $toDay . $merchantPassword;
        $strSignMD5 = MD5($strSign);


        Log::debugArr($strSign, 'znpay');
        Log::debugArr($strSignMD5, 'znpay');


        $time = time();
        switch ($type) {
            case 'wxpay':
                $str = 'merchant_no=' . $merchantId . 
                     '&total_fee=' . $amount . 
                     '&pay_num=' . $orderNum . 
                     '&sign=' . $strSignMD5 . 
                     '&notifyurl=' . $this->notifyUrl . 
                     '&today=' . $toDay . 
                     '&pay_type=wxh5pay';
                break;
            case 'alipay':
                $str = 'merchant_no=' . $merchantId . 
                     '&total_fee=' . $amount . 
                     '&pay_num=' . $orderNum . 
                     '&sign=' . $strSignMD5 . 
                     '&notifyurl=' . $this->notifyUrl . 
                     '&today=' . $toDay . 
                     '&pay_type=' . $type;
            case 'qqpay':
                $str = 'merchant_no=' . $merchantId . 
                     '&total_fee=' . $amount . 
                     '&pay_num=' . $orderNum . 
                     '&sign=' . $strSignMD5 . 
                     '&notifyurl=' . $this->notifyUrl . 
                     '&today=' . $toDay . 
                     '&pay_type=' . $type;
                break;
            case 'qkpay':
                    $str =  '<html><body>'.
	                        '<form id="submitPay" name="submitPay" action="'.$this->gatewayUrl.'" method="POST">'.
	                        '<input type="hidden" name="merchant_no" value="'.$merchantId.'"/>'.
	                        '<input type="hidden" name="total_fee" value="'.$amount.'"/>'.
	                        '<input type="hidden" name="pay_num" value="'.$orderNum.'"/>'.
	                        '<input type="hidden" name="notifyurl" value="'.$this->notifyUrl.'"/>'.
	                        '<input type="hidden" name="sign" value="'.$strSignMD5.'"/>'.
	                        '<input type="hidden" name="pay_type" value="'.$type.'"/>'.
	                        '<input type="hidden" name="card_no" value="'.$cardNo.'"/>'.
	                        '<input type="hidden" name="return_url" value="'.$this->frontNotifyUrl.'"/>'.
                            '<input type="hidden" name="card_name" value="'.$cardName.'"/>'.
                            '<input type="hidden" name="id_no" value="'.$idNo.'"/>'.
	                        '<script>document.forms['.
	                        '"'.
	                        'submitPay'.
	                        '"'.
	                        '].submit();</script></script>'.
	                        '</form>'.
	                        '</body>'.
	                        '</html>';

                break;
            default :
                throw new Exception("not support method.");
                break;
        }

        return $str;
    }

    public function postOrder($type, $params)
    {
        Log::debugArr('postOrder params string :', 'znpay');
        $str = $this->getPostString($type, $params,'');
        Log::debugArr('postOrder params string :'.$str, 'znpay');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->gatewayUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $str);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $obj=json_decode($result); 
        
        $return = array('status' => 1, 'msg' => 'Success');
        
    
        if ($obj->return_code == '10000') {//下单成功
            Log::debugArr('postOrder success', 'znpay');
            Log::debugArr($return, 'znpay');
            $return = array('status' => 1, 'codeUrl' => $obj->code_url);
        } else {
            Log::debugArr('postOrder Error code:['.$obj->return_code.']'.$obj->message, 'znpay');
            $return = array('status' => 0, 'msg' => 'Error');
        }

        return $return;
    }
    
    /**
     * 支付结果异步通知
     */
    public function notify()
    {
        Log::debugArr('notify开始', 'znpay');
        $result = file_get_contents('php://input');
        Log::debugArr($result, 'znpay');
        $obj= $this->str2arr1($result);
                
        $merchantId = $this->merchantId;
        $merchantPassword = $this->merchantPassword;
        $out_trade_no=$obj['out_trade_no'];
        $pay_num =$obj['pay_num'];
        $total_fee =$obj['total_fee'];

        
        $strSign=$merchantId . $out_trade_no .$pay_num .$total_fee. $merchantPassword;
        $strSignMD5 = MD5($strSign);
        
        if (strtoupper($strSignMD5) == strtoupper($obj['sign'])) {

        Log::debugArr($obj['return_code'], 'znpay');
        Log::debugArr($obj['trade_result'], 'znpay');

            if ($obj['return_code'] == '10000' && $obj['trade_result'] == 'success' ) {//下单成功
                Log::debugArr('postOrder success', 'znpay');
                Log::debugArr($obj, 'znpay');
                $return = array('status' => 1, 'payStatus' => 'success','orderId' =>$pay_num,'amount'=>$total_fee/100 );
            } else {
                Log::debugArr('postOrder Error code:'.$obj['return_code'], 'znpay');
                $return = array('status' => 0, 'msg' => 'Error');
            }
        } else {
            Log::debugArr('postOrder 验签失败', 'znpay');
            $return = array('status' => 0, 'msg' => '验签失败');
        }

        return $return;
    }
    
    
    /* 将一个字符串转变成键值对数组
     * @param    : string str 要处理的字符串 $str ='TranAbbr=IPER|AcqSsn=000000073601|MercDtTm=20090615144037';
     * @return    : array*/
    function str2arr1($str){
        $arr = explode("&",$str);
        $r = array();
        foreach ($arr as $val ){
            $t = explode("=",$val);
            $r[$t[0]]= $t[1];
        }
        return $r;
    }
}
    