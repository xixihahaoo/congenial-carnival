<?php

namespace Org\Util;

/**
 * Class ShouxinyiYinlian

 * object(SimpleXMLElement)#1 (8)
 * {
 *  ["status"]=> string(1) "0"
 * ["statusdesc"]=> string(21) "预下单处理成功"
 * ["oid"]=> string(21) "20170107-10630-064934"
 * ["amount"]=> string(4) "0.01"
 * ["moneytype"]=> string(1) "0"
 * ["codeurl"]=> string(35) "weixin://wxpay/bizpayurl?pr=fiVH6XA"
 * ["bankurl"]=> string(90) "http://210.73.90.235/customer/otherpay/qrcode.jsp?uuid=weixin://wxpay/bizpayurl?pr=fiVH6XA"
 * ["sign"]=> string(256) "27b9b3c688db3bb12ddc871c07ff4ab86e75fda0fc78072701505d40271498ca3963d1a0fb31f36155024ae75f5b6558cf2d360e56c40bd2005bbb7fc122868ef6e9986ce396da73723da8a9115d07df6ccdaf8a41f242dec2069037fa59368998f8abdd4b2772b03e2b313f409dcc98ecc8ab87b3962cf1bb5d62f7b194c142"
 * }
 */

class ShouxinyiYinlian
{

    private $v_mid  = "10704";

    //支付完成后的实时返回地址。
    //支付完成后实时先向这个地址做返回?
    //在此地囿下做接收银行返回的支付确认消息?详细的返回参数格式西(接口文档的第二部分或者代码示例的received1.php)
    private $v_url      = "http://hjb.hjb58.com/Home/Paysxy/get_pay_result_yinlian";
    private $key        = 'z10263028'; //商户的密钥
    private $requestUrl = "https://pay.yizhifubj.com/customer/gb/pay_bank.jsp";

    private $v_pmode    = 126;  //支付方式编号 可选值包括 254 微信扫码 微信扫码 微信扫码 , 271271 支付宝扫码 支付宝扫码

    //0为人民币，1为美元，2为欧元，3为英镑，4为日元，5为韩元，6为澳大利亚元，7为卢布(内卡商户币种只能为人民币)
    private $v_moneytype    = "0";


	private $resultUrl	= "http://api.yizhifubj.com/merchant/order/order_ack_oid_list.jsp";

    public function __construct()
    {

    }

    /**
     * @functionname: opt_pay
     * @author: FrankHong
     * @date: 2017-01-13 14:21:52
     * @description: 处理支付
     * @note:
     * @return mixed
     * @param $data
     */
    public function opt_pay($data)
    {
        $v_ymd  = date('Ymd'); //订单产生日期，要求订单日期格式yyyymmdd.
        $v_mid  = $this->v_mid;    //商户编号，和首信签约后获得,测试的商户编号444
        $v_date = date('His');
        //$v_oid=$v_ymd .'-' . $v_mid . '-' .$v_date; //订单编号。订单编号的格式是yyyymmdd-商户编号-流水号，流水号可以取系统当前时间，也可以取随机数，也可以商户自己定义的订单号，自己定义的订单号必须保证每?次提交，订单号是唯一的??

        $v_oid  = $data['v_oid'];

		$v_rcvname  = $data['v_rcvname']; //收货人姓名,建议用商户编号代替或者是英文数字。因为首信平台的编号是gb2312的
        $v_rcvaddr  = $data['v_rcvaddr']; //收货人地址，可用商户编号代替
        $v_rcvtel   = $data['v_rcvtel'];   //收货人电话
        $v_rcvpost  = $data['v_rcvpost'];  //收货人邮箱
        $v_amount   = $data['v_amount']; //订单金额
        $v_pmode	= $this->v_pmode;

        $v_orderstatus  = "1";//配货状态:0-未配齐，1-已配
        $v_ordername    = $v_rcvname;  //订货人姓名
        $v_moneytype    = $this->v_moneytype;
        $v_url          = $data['v_url'];  //回调地址

        $data           = $v_moneytype.$v_ymd.$v_amount.$v_rcvname.$v_oid.$v_mid.$v_url;//七个参数的拼串
        $v_md5info      = $this->hmac($this->key, $data);


        $rsReturn       = array();
        $rsReturn['v_mid']          = $v_mid;
        $rsReturn['v_oid']          = $v_oid;
        $rsReturn['v_rcvname']      = $v_rcvname;
        $rsReturn['v_rcvaddr']      = $v_rcvaddr;
        $rsReturn['v_rcvtel']       = $v_rcvtel;
        $rsReturn['v_rcvpost']      = $v_rcvpost;
        $rsReturn['v_amount']       = $v_amount;
        $rsReturn['v_ymd']          = $v_ymd;
        $rsReturn['v_orderstatus']  = $v_orderstatus;
        $rsReturn['v_ordername']    = $v_ordername;
        $rsReturn['v_moneytype']    = $v_moneytype;
        $rsReturn['v_url']          = $v_url;
        $rsReturn['v_md5info']      = $v_md5info;
        $rsReturn['v_pmode']        = $v_pmode;

        return $rsReturn;
    }


	/**
	 * @functionname: hmac
	 * @author: FrankHong
	 * @date: 2017-01-07 14:12:40
	 * @description:
	 * @note: 创建 md5的HMAC
	 * @return string
	 * @param $key
	 * @param $data
	 */
    public function hmac($key, $data)
    {
        // 创建 md5的HMAC
        $b  = 64; // md5加密字节长度
        if (strlen($key) > $b)
        {
            $key    = pack("H*", md5($key));
        }
        $key    = str_pad($key, $b, chr(0x00));
        $ipad   = str_pad('', $b, chr(0x36));
        $opad   = str_pad('', $b, chr(0x5c));
        $k_ipad = $key ^ $ipad;
        $k_opad = $key ^ $opad;

        return md5($k_opad . pack("H*", md5($k_ipad . $data)));
    }



    /**
     * @functionname: curlOptResult
     * @author: FrankHong
     * @date: 2017-01-08 10:13:00
     * @description: 用于主动获取支付结果
     * @note:
     * @param $requestUrl
     * @param $curlPost
     */
    public function curlOptResult($requestUrl, $curlPost)
    {


        $ch=curl_init();

        curl_setopt($ch, CURLOPT_URL, $requestUrl);

        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

        $back_date=trim(curl_exec($ch));

        curl_close($ch);

        $xml = simplexml_load_string($back_date);

        Log::debugArr($xml, 'sxy_result');

        $desc=$xml->messagebody->order->pstatus;

        return $desc;
    }

	/**
	 * @functionname: get_result
	 * @author: FrankHong
	 * @date: 2017-01-08 10:15:09
	 * @description: 获取结果
	 * @note:
	 *
	 *  $desc=$xml->messagebody->order->pstatus;

	if($desc==1){
	echo "支付成功";
	}else if($desc==2){
	echo "未支付";
	}else{
	echo "支付失败";
	}

	 *
	 * @return
	 * @param $postData
	 */
	public function get_result($postData)
	{
		$key	= $this->key;//商户的密钥
		$data	= $this->v_mid.$postData['v_oid'];
		$v_mac	= $this->hmac($key, $data);

		$curlPostData	= '';
		$curlPostData	.="v_mid=".$this->v_mid;
		$curlPostData	.="&v_oid=".$postData['v_oid'];
		$curlPostData	.="&v_mac=".$v_mac;

		$rs		= $this->curlOptResult($this->resultUrl, $curlPostData);
		return $rs;
	}
}
