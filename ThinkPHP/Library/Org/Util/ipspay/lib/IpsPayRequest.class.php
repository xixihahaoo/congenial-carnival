<?php
ini_set('date.timezone', 'Asia/Shanghai');
require_once("IpsPayUtil.function.php");
//require_once 'log.php';

//初始化日志
//$logHandler = new CLogFileHandler("./logs/".date('Y-m-d').'.log');
//$log = Log::Init($logHandler, 15);

class IpsPayRequest
{
    var $ipspay_config;
     
    function __construct($ipspay_config){
        $this->ipspay_config = $ipspay_config;
    }
    function IpsPayRequest($ipspay_config) {
        $this->__construct($ipspay_config);
    }
    /**
     * 建立请求，以表单HTML形式构造（默认）
     * @param $para_temp 请求参数数组
     * @return 提交表单HTML文本
     */
    function buildRequest($para_temp) {
        try {
            $para = $this->buildRequestPara($para_temp);
            
            $wsdl = $this->ipspay_config['PostUrl'];
             
            $client=new SoapClient($wsdl);
            
            $sReqXml = $client->scanPay($para);
             
            //Log::DEBUG("扫码支付请求返回报文:" . $sReqXml);
            return $sReqXml;
        } catch (Exception $e) {
            //Log::ERROR("扫码支付请求异常:" . $e);
        }
       return null;
    }
    
    /**
     * 生成要请求给IPS的参数XMl
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数XMl
     */
    function buildRequestPara($para_temp) {
        $sReqXml = "<Ips>";
        $sReqXml .= "<GateWayReq>";
        $sReqXml .= $this->buildHead($para_temp);
        $sReqXml .= $this->buildBody($para_temp);
        $sReqXml .= "</GateWayReq>";
        $sReqXml .= "</Ips>";
        //Log::DEBUG("扫码支付请求报文:" . $sReqXml);
        return $sReqXml;
    }
    /**
     * 请求报文头
     * @param   $para_temp 请求前的参数数组
     * @return 要请求的报文头
     */
    function buildHead($para_temp){
        $sReqXmlHead = "<head>";
        $sReqXmlHead .= "<Version>".$this->ipspay_config["Version"]."</Version>";
        $sReqXmlHead .= "<MerCode>".$para_temp["MerCode"]."</MerCode>";
        $sReqXmlHead .= "<MerName>".$para_temp["MerName"]."</MerName>";
        $sReqXmlHead .= "<Account>".$para_temp["Account"]."</Account>";
        $sReqXmlHead .= "<MsgId>".$para_temp["MsgId"]."</MsgId>";
        $sReqXmlHead .= "<ReqDate>".$para_temp["ReqDate"]."</ReqDate>";
        $sReqXmlHead .= "<Signature>".md5Sign($this->buildBody($para_temp),$this->ipspay_config["MerCode"],$this->ipspay_config['MerCert'])."</Signature>";
        $sReqXmlHead .= "</head>";
        return $sReqXmlHead;
    }
    
    /**
     *  请求报文体
     * @param  $para_temp 请求前的参数数组
     * @return 要请求的报文体
     */
    function buildBody($para_temp){
        $sReqXmlBody = "<body>";
        $sReqXmlBody .= "<MerBillNo>".$para_temp["MerBillNo"]."</MerBillNo>";
        $sReqXmlBody .= "<GatewayType>".$para_temp["GatewayType"]."</GatewayType>";
        $sReqXmlBody .= "<Date>".$para_temp["Date"]."</Date>";
        $sReqXmlBody .= "<CurrencyType>".$para_temp["CurrencyType"]."</CurrencyType>";
        $sReqXmlBody .= "<Amount>".$para_temp["Amount"]."</Amount>";
        $sReqXmlBody .= "<Lang>".$para_temp["Lang"]."</Lang>";
        $sReqXmlBody .= "<Attach>".$para_temp["Attach"]."</Attach>";
        $sReqXmlBody .= "<RetEncodeType>".$para_temp["RetEncodeType"]."</RetEncodeType>";
        $sReqXmlBody .= "<ServerUrl>".$para_temp["ServerUrl"]."</ServerUrl>";
        $sReqXmlBody .= "<BillEXP>".$para_temp["BillEXP"]."</BillEXP>";
        $sReqXmlBody .= "<GoodsName>".$para_temp["GoodsName"]."</GoodsName>";
        $sReqXmlBody .= "</body>";
        return $sReqXmlBody;
    }
}

