<?php
ini_set('date.timezone', 'Asia/Shanghai');
require_once ("IpsPayUtil.function.php");
//require_once 'log.php';
//
//// 初始化日志
//$logHandler = new CLogFileHandler("./logs/" . date('Y-m-d') . '.log');
//$log = Log::Init($logHandler, 15);

class IpsPayVerify
{

    var $ipspay_config;

    function __construct($ipspay_config)
    {
        $this->ipspay_config = $ipspay_config;
    }

    function IpsPayVerify($ipspay_config)
    {
        $this->__construct($ipspay_config);
    }

    function verifyReturn($param)
    {
        try {
            
            $xmlResult = new SimpleXMLElement($param);
            $strSignature = $xmlResult->GateWayRsp->head->Signature;
            
            $strBody = subStrXml("<body>", "</body>", $param);
            
            if (md5Verify($strBody, $strSignature, $this->ipspay_config["MerCode"], $this->ipspay_config["MerCert"])) {
                return true;
            } else {
                //Log::DEBUG("扫码支付返回报文验签失败:" . $param);
                return false;
            }
        } catch (Exception $e) {
            //Log::ERROR("异常:" . $e);
        }
        return false;
    }
}
