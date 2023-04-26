<?php
// +----------------------------------------------------------------------
// |  [ 阿里大于短信接口 ]
// +----------------------------------------------------------------------

// 引入阿里大于的SDK
namespace Org\Util;
include_once 'TopSdk.php';



class Alidayu
{

	private static $appkey    = '23566970';
	private static $secretKey = '1a5b47e400fbe7a1818b6dcd3d1872d0';

	/**
	 * 发送注册验证码
	 * @param $mobile
	 * @param $code
	 * @param $product
	 * @return mixed|\SimpleXMLElement|alidayu\ResultSet
	 */
	public static function sendRegCode($mobile, $code) {
		$c            = new \TopClient();
		$c->appkey    = self::$appkey;
		$c->secretKey = self::$secretKey;
		$c->format    = 'json';
		$req          = new \AlibabaAliqinFcSmsNumSendRequest();
		$req->setExtend("");
		$req->setSmsType("normal");
		$req->setSmsFreeSignName("验证码");
		$req->setSmsParam("{\"code\":\"$code\"}");
		$req->setRecNum($mobile);
		$req->setSmsTemplateCode("SMS_34330114");
		$resp = $c->execute($req);
		return $resp;
	}

	/**
	 * 发送修改密码验证码
	 * @param $mobile
	 * @param $code
	 * @param $product
	 * @return mixed|\SimpleXMLElement|alidayu\ResultSet
	 */
	public static function sendChangePasswordCode($mobile, $code, $product) {
		$c            = new TopClient();
		$c->appkey    = self::$appkey;
		$c->secretKey = self::$secretKey;
		$c->format    = 'json';
		$req          = new AlibabaAliqinFcSmsNumSendRequest();
		$req->setExtend("");
		$req->setSmsType("normal");
		$req->setSmsFreeSignName("");
		$req->setSmsParam("{\"code\":\"$code\",\"product\":\"$product\"}");
		$req->setRecNum($mobile);
		$req->setSmsTemplateCode("SMS_13760936");
		$resp = $c->execute($req);
		return $resp;
	}

	/**
	 * 发送优惠券到账提醒
	 * @param $mobile
	 * @param $number
	 * @param $product
	 * @return mixed|\SimpleXMLElement|alidayu\ResultSet
	 */
	public static function sendCouponMsg($mobile, $number, $money, $product) {
		$c            = new TopClient();
		$c->appkey    = self::$appkey;
		$c->secretKey = self::$secretKey;
		$c->format    = 'json';
		$req          = new AlibabaAliqinFcSmsNumSendRequest();
		$req->setExtend("");
		$req->setSmsType("normal");
		$req->setSmsFreeSignName("");
		$req->setSmsParam("{\"number\":\"$number\",\"money\":\"$money\",\"product\":\"$product\"}");
		$req->setRecNum($mobile);
		$req->setSmsTemplateCode("SMS_16685036");
		$resp = $c->execute($req);
		return $resp;
	}

}
