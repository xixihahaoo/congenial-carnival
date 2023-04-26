<?php
/**
 * 支付接口调测例子
 * ================================================================
 * index 进入口，方法中转
 * submitOrderInfo 提交订单信息
 * queryOrder 查询订单
 *
 *
 * array(16) {
        ["MsgId"]=>
        string(5) "00001"
        ["ReqDate"]=>
        string(14) "20170206173741"
        ["MerCode"]=>
        string(6) "192545"
        ["MerName"]=>
        string(0) ""
        ["Account"]=>
        string(10) "1925450015"
        ["MerBillNo"]=>
        string(17) "Mer20170206173731"
        ["GatewayType"]=>
        string(2) "10"
        ["Date"]=>
        string(8) "20170206"
        ["RetEncodeType"]=>
        string(2) "17"
        ["CurrencyType"]=>
        string(3) "156"
        ["Amount"]=>
        string(4) "0.01"
        ["BillEXP"]=>
        string(1) "2"
        ["GoodsName"]=>
        string(6) "环迅"
        ["ServerUrl"]=>
        string(41) "http://huanxun.edc6.com/s2snotify_url.php"
        ["Lang"]=>
        string(2) "GB"
        ["Attach"]=>
        string(15) "商户数据包"
    }
 *
 * ================================================================
 */
namespace Org\Util;

require_once('ipspay/IpsPay.Config.php');
require_once("ipspay/lib/IpsPayRequest.class.php");
require_once("ipspay/lib/IpsPayVerify.class.php");
require_once("ipspay/phpqrcodeips/phpqrcode.php");
require_once ("ipspay/lib/IpsPayNotify.class.php");

class Ipspay
{
    /*
     * 商户号
     */
    private $merCode        = 192545;
    /*
     * 商户账户号
     */
    private $merAccount     = 1925450015;
    //商户名
    private $merMerName     = '';
    //订单有效期
    private $billEXP        = 2;
    //商品名称
    private $goodsName      = '账户充值';
    //商户数据包
    private $attach         = '商户数据包';
    //加密方式
    private $retEncodeType  = '17';
        //币种
    private $currencyType   = '156';
        //语言
    private $lang           = 'GB';

    private $MsgId          = '00001';
    //异步S2S返回
    private $serverUrl      = 'http://hjb.hjb58.com/Home/Payres/ips_notify';

    private $ipspay_config  = array();

    public function __construct()
    {
        $this->ipspay_config['Version'] = 'v1.0.0';
        //商戶号
        $this->ipspay_config['MerCode'] = '192545';
        //交易账户号
        $this->ipspay_config['Account'] = '1925450015';
        //商戶证书
        $this->ipspay_config['MerCert'] = 'lJjlcH8WLe3HRpCjLFK7kyDYNxtfOfbZEPvJpBduKFtF4NjHchCPRot5q72enYb9exbTzgMeh0E7g5wA327s44sGok39vJ78z277m7boYlg0lluT2Gn6ZU4cpEumktY3';
        //请求地址
        $this->ipspay_config['PostUrl'] = 'https://thumbpay.e-years.com/psfp-webscan/services/scan?wsdl';
    }


    /**
     * @functionname: get_pay_img
     * @author: FrankHong
     * @date: 2017-02-07 11:29:52
     * @description: 请求接口，获取相应支付的二维码图片
     * @note:
     * gatewayType  10 微信
     *              11 支付宝
     * @return array
     * @param $dataArr
     *
     * <Ips>
     * <GateWayRsp>
     * <head>
     * <ReferenceID>00001</ReferenceID>
     * <RspCode>000000</RspCode>
     * <RspMsg><![CDATA[交易成功]]></RspMsg>
     * <ReqDate>20170207134320</ReqDate>
     * <RspDate>20170207134321</RspDate>
     * <Signature>ef4e6b5370f3b855329bdc663dabe01c</Signature>
     * </head>
     * <body>
     * <QrCode>weixin://wxpay/bizpayurl?pr=qGsf0yM</QrCode>
     * </body>
     * </GateWayRsp>
     * </Ips>
     */
    public function get_pay_img($dataArr)
    {


        //商户订单号
        $merBillNo      = $dataArr['merBillNo'];
        //支付方式
        $gatewayType    = $dataArr['gatewayType'];
        //订单日期
        $orderDate      = $dataArr['orderDate'];
        //订单金额
        $amount         = $dataArr['amount'];

        $parameter  = array(
            "MsgId"	        => $this->MsgId,
            "ReqDate"	    => date("YmdHis"),
            "MerCode"	    => $this->merCode,
            "MerName"	    => $this->merMerName,
            "Account"	    => $this->merAccount,
            "MerBillNo"	    => $merBillNo,
            "GatewayType"   => $gatewayType,
            "Date"	        => $orderDate,
            "RetEncodeType"	=> $this->retEncodeType,
            "CurrencyType"	=> $this->currencyType,
            "Amount"	    => $amount,
            "BillEXP"	    => $this->billEXP,
            "GoodsName"	    => $this->goodsName,
            "ServerUrl"	    => $this->serverUrl,
            "Lang"	        => $this->lang,
            "Attach"	    => $this->attach
        );

        //建立请求
        $ipspayRequest  = new \IpsPayRequest($this->ipspay_config);

        $html_text      = $ipspayRequest->buildRequest($parameter);

		//Log::debugArr($html_text, 'xxxxxx');

        $xmlResult      = new \SimpleXMLElement($html_text);
        $strRspCode     = $xmlResult->GateWayRsp->head->RspCode;

        $returnArr  = array('ret_code' => 0, 'ret_msg' => '', 'img_url' => '');
        if($strRspCode == "000000")
        {
            //返回报文验签
            $ipspayVerify   = new \IpsPayVerify($this->ipspay_config);
            $verify_result  = $ipspayVerify->verifyReturn($html_text);

            // 验证成功
            if ($verify_result)     //bool(true)
            {
                $returnArr['ret_msg']   = '交易成功';
                $returnArr['ret_code']  = 1;
                $returnArr['img_url']   = $xmlResult->GateWayRsp->body->QrCode;
            }
            else
            {
                $returnArr['ret_msg']   = '验签失败';
                $returnArr['ret_code']  = 0;
                $returnArr['img_url']   = '';
            }
        }
        else
        {
            $returnArr['ret_msg']   = $xmlResult->GateWayRsp->head->RspMsg;
            $returnArr['ret_code']  = 0;
            $returnArr['img_url']   = '';
        }

        return $returnArr;
    }


    /**
     * @functionname: create_img_url
     * @author: FrankHong
     * @date: 2017-02-07 14:15:44
     * @description: 根据环迅返回的参数，生成二维码url
     * @note:
     * @param $imgUrl
     */
    public function create_img_url($imgUrl)
    {
        error_reporting(E_ERROR);

		ob_clean();
        \QRcode::png($imgUrl);
    }

    /**
     * @functionname: callback
     * @author: FrankHong
     * @date: 2017-02-07 11:30:23
     * @description: 第三方支付回调地址，返回支付状态
     * @note:
     */
    public function callback()
    {
        //Log::debugArr($_REQUEST, 'notify');
        $ipspayNotify   = new \IpsPayNotify($this->ipspay_config);
        $verify_result  = $ipspayNotify->verifyReturn();

        //Log::debugArr($verify_result, 'sssssss');

        // 验证成功
        if ($verify_result)
        {
            return 'ipscheckok';
            die();
            //TODO 判断订单号和金额。请使用报文数据与本地数据比较
            echo "ipscheckok";
            //echo "ipscheckfail";
        }
        else
        {
            return 'ipscheckfail';
            die();
            echo "ipscheckfail";
        }


    }



}
