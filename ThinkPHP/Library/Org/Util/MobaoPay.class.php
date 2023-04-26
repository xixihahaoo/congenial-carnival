<?php
/**
 * 中南支付
 */
namespace Org\Util;
use Org\Util\Log;
use Think\Exception;
require_once('mobao/HttpCilent.php');
require_once('mobao/AESUtil.php');
require_once('mobao/EncodeUtil.php');

class MobaoPay
{
    public function __construct()
    {
        $config = $this->_getConfig();

        $this->url = $config['url'];
        $this->merId = $config['merId'];
        $this->merPubKey = $config['merPubKey'];
        $this->notifyUrl = U('home/PayMobao/notify', '', true, true);
        $this->frontNotifyUrl = U('home/PayMobao/jump_notify', '', true, true);
    }

    /**
     * 获取配置
     * @return array
     */
    private function _getConfig()
    {

        static $config;
        if ($config) return $config;

        $config = require(VENDOR_PATH . 'MobaoPay/config.inc.php');
        return $config;
    }

	public function jumpRequest($paytype,$amount,$ordernum,$cardNo,$cardName,$idNo,$uid,$mobile,$cardDay,$cardCvv2){

	
		Log::debugArr($paytype, 'MobaoPay');
		Log::debugArr($amount, 'MobaoPay');
		Log::debugArr($ordernum, 'MobaoPay');
		Log::debugArr($cardNo, 'MobaoPay');
		Log::debugArr($cardName, 'MobaoPay');
		Log::debugArr($idNo, 'MobaoPay');
		Log::debugArr($mobile, 'MobaoPay');
		Log::debugArr($cardDay, 'MobaoPay');
		Log::debugArr($cardCvv2, 'MobaoPay');
	

		//贷记卡版本
		$transMap=array(
		"versionId"=>"001",                //版本号
		"businessType"=>"1401",            //交易类型
		"insCode"=>"",                      //交易类型
		"merId"=>$this->merId,                    //商户号
		"orderId"=>$ordernum,   //商户订单号
		"transDate"=>date('YmdHis',time()), //交易日期
		"transAmount"=>$amount,
		"cardByName"=>base64_encode($cardName),
		"cardByNo"=>$cardNo,               //卡号
		"cardType"=>"01",                  //卡类型
		"expireDate"=>$cardDay,            //有效期
		"CVV"=>$cardCvv2,                   //cvv
		"bankCode"=>"",                    //银行编号
		"openBankName"=>"",                //开户银行
		"cerType"=>"01",                   //证件类型
		"cerNumber"=>$idNo,                //证件号码
		"mobile"=>$mobile,                 //手机号码
		"isAcceptYzm"=>"00",               //是否下发验证码
		"pageNotifyUrl"=>$this->frontNotifyUrl, //前台页面通知地址
		"backNotifyUrl"=>$this->notifyUrl,  //后台页面通知地址
		"orderDesc"=>"",                   //商品名称
		"instalTransFlag"=>"01",           //分期标志
		"instalTransNums"=>"",             //分期期数
		"dev"=>"",                         //自定义域
		"fee"=>"",                         //
		);

		Log::debugArr($transMap, 'MobaoPay');
		//获取URL格式字符串
		$EncodeUitl = new \EncodeUitl();
		$transStr=$EncodeUitl->getUrlStr($transMap);

		//MD5加密
		$signData= strtoupper( md5($transStr.$this->merPubKey,false)); 
		$transMap["signType"]="MD5";
		$transMap["signData"]=$signData;
		$transStr=$EncodeUitl->getUrlStr($transMap);;

		//进行AES加密
		$aes = new \AESUtil();
		// 加密  (参数一  明文报文   参数2 商户的私钥)
		$string = $aes->encrypt($transStr,$this->merPubKey);

		//发送交易
		$HttpCilnet=new \HttpCilnet();	
		$transData=array('merId'=>$this->merId,'transData'=>$string);

		$resBody=$HttpCilnet->post2($this->url,$transData);
		Log::debugArr("返回的信息".mb_convert_encoding($resBody, "utf-8", "GBK"), 'MobaoPay');


		return $resBody;
	}

	public function jumpRequest_yzm($ksPayOrderId,$yzm){

		Log::debugArr($ksPayOrderId, 'MobaoPay');
		Log::debugArr($yzm, 'MobaoPay');
	
		//贷记卡版本
		$transMap=array(
		"versionId"=>"001",  //版本号
		"businessType"=>"1411", //交易类型
		"insCode"=>"", 			//交易类型
		"merId"=>$this->merId,         //商户号
		"yzm"=>$yzm,                       //验证码     1401的返回验证码填入
		"ksPayOrderId"=>$ksPayOrderId,                //摩宝交易号  1401的返回的摩宝交易号填入
		);

		Log::debugArr($transMap, 'MobaoPay');
		//获取URL格式字符串
		$EncodeUitl=new \EncodeUitl();
		$transStr=$EncodeUitl->getUrlStr($transMap);

		//MD5加密
		$signData= strtoupper( md5($transStr.$this->merPubKey,false)); 
		$transMap["signType"]="MD5";
		$transMap["signData"]=$signData;
		$transStr=$EncodeUitl->getUrlStr($transMap);;

		//进行AES加密
		$aes = new \AESUtil();
		// 加密  (参数一  明文报文   参数2 商户的私钥)
		$string = $aes->encrypt($transStr,$this->merPubKey);

		//发送交易
		$HttpCilnet=new \HttpCilnet();
		$transData=array('merId'=>$this->merId,'transData'=>$string);
		$resBody=$HttpCilnet->post2($this->url,$transData);
		Log::debugArr("返回的信息".mb_convert_encoding($resBody, "utf-8", "GBK"), 'MobaoPay');

		return $resBody;
	}
	
    /**
     * 支付结果异步通知
     */
    public function notify()
    {
        Log::debugArr('notify开始', 'MobaoPayNotify');
        // $result = file_get_contents('php://input');
		$result = iconv("GBK", "UTF-8",urldecode(file_get_contents('php://input')));

        Log::debugArr($result, 'MobaoPayNotify');
        Log::debugArr(mb_convert_encoding($result, "utf-8", "GBK"), 'MobaoPayNotify');
        $obj= $this->str2arr1($result);

		Log::debugArr("versionId:".$obj['versionId'], 'MobaoPayNotify');
		Log::debugArr("businessType:".$obj['businessType'], 'MobaoPayNotify');
		Log::debugArr("insCode:".$obj['insCode'], 'MobaoPayNotify');
		Log::debugArr("merId:".$obj['merId'], 'MobaoPayNotify');
		Log::debugArr("transDate:".$obj['transDate'], 'MobaoPayNotify');
		Log::debugArr("transAmount:".$obj['transAmount'], 'MobaoPayNotify');
		Log::debugArr("orderId:".$obj['orderId'], 'MobaoPayNotify');
		Log::debugArr("refCode:".$obj['refCode'], 'MobaoPayNotify');
		Log::debugArr("refMsg:".$obj['refMsg'], 'MobaoPayNotify');
		Log::debugArr("pageNotifyUrl:".$obj['pageNotifyUrl'], 'MobaoPayNotify');
		Log::debugArr("backNotifyUrl:".$obj['backNotifyUrl'], 'MobaoPayNotify');
		Log::debugArr("signData:".$obj['signData'], 'MobaoPayNotify');

		$transMap=array(
			"versionId"=>$obj['versionId'],  
			"businessType"=>$obj['businessType'], 
			"insCode"=>$obj['insCode'], 
			"merId"=>$obj['merId'], 
			"transDate"=>$obj['transDate'], 
			"transAmount"=>$obj['transAmount'], 
			"orderId"=>$obj['orderId'], 
			"refCode"=>$obj['refCode'], 
			"refMsg"=>$obj['refMsg'], 
			"pageNotifyUrl"=>$obj['pageNotifyUrl'], 
			"backNotifyUrl"=>$obj['backNotifyUrl'],
		);

		//获取URL格式字符串
		$EncodeUitl=new \EncodeUitl();
		$transStr=$EncodeUitl->getUrlStr($transMap);

		//MD5加密
		$signData= strtoupper( md5($transStr.$this->merPubKey,false)); 

		Log::debugArr("transStr:".$transStr.$this->merPubKey, 'MobaoPayNotify');
		Log::debugArr("signData:".$signData, 'MobaoPayNotify');

        if (strtoupper($signData) == strtoupper($obj['signData'])) {
			Log::debugArr('postOrder success', 'MobaoPayNotify');
			Log::debugArr($obj, 'MobaoPayNotify');
			$return = array('status' => 1, 'payStatus' => 'success','orderId' =>$obj['orderId'],'amount'=>$obj['transAmount']);
        } else {
            Log::debugArr('postOrder 验签失败', 'MobaoPayNotify');
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
    