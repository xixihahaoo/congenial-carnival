<?php
ini_set('date.timezone','Asia/Shanghai');
require_once ("IpsPayUtil.function.php");
//require_once 'log.php';
//
////初始化日志
//$logHandler= new CLogFileHandler("./logs/".date('Y-m-d').'.log');
//$log = Log::Init($logHandler, 15);

class IpsPayNotify
{
    var $ipspay_config;
    
    function __construct($ipspay_config){
        $this->ipspay_config = $ipspay_config;
    }
    function IpsPayNotify($ipspay_config) {
        $this->__construct($ipspay_config);
    }
    
    function verifyReturn(){
        try {
            if(empty($_REQUEST)) {
                return false;
            }
            else {
                $paymentResult = $_REQUEST['paymentResult'];
                //Log::DEBUG("扫码支付成功返回报文:" . $paymentResult);
                
                $xmlResult = new SimpleXMLElement($paymentResult);
                $strSignature = $xmlResult->GateWayRsp->head->Signature;
                
                $strRspCode = $xmlResult->GateWayRsp->head->RspCode;
                
                if($strRspCode == "000000"){
                    $strStatus = $xmlResult->GateWayRsp->body->Status;
                    if($strStatus == "Y"){
                        $strBody = subStrXml("<body>","</body>",$paymentResult);
                        if(md5Verify($strBody, $strSignature,$this->ipspay_config["MerCode"],$this->ipspay_config["MerCert"])){
                            return true;
                        }else{
                            //Log::DEBUG("扫码支付返回报文验签失败");
                            return false;
                        }
                    }else{
                        $strRspMsg = $xmlResult->GateWayRsp->head->RspMsg;
                        //Log::DEBUG("扫码支付失败:" . $strRspMsg);
                        return false;
                    }
                }else{
                    return false;
                }
            }
        } catch (Exception $e) {
            //Log::ERROR("异常:" . $e);
        }
        return false;
    }
}

