<?php
namespace Home\Controller;
use Think\Controller;
//微信支付类
class WxpayController extends Controller {
	//获取access_token过程中的跳转uri，通过跳转将code传入jsapi支付页面
	public function js_api_call() {
        $order_sn = I('get.order_sn', '');
        if (empty($order_sn)) {
            header('location:'.__ROOT__.'/');
        }
        vendor('Weixinpay.WxPayPubHelper');
        //使用jsapi接口
        $jsApi = new \JsApi_pub();
        //=========步骤1：网页授权获取用户openid============
        //通过code获得openid
        if (!isset($_GET['code'])){
            //触发微信返回code码
            $url = $jsApi->createOauthUrlForCode('域名/Wxpay/js_api_call?order_sn='.$order_sn);
            //$url = $jsApi->createOauthUrlForCode(\WxPayConf_pub::JS_API_CALL_URL);
            Header("Location: $url"); 
        }else{
            //获取code码，以获取openid
            $code = $_GET['code'];
            $jsApi->setCode($code);
            $openid = $jsApi->getOpenId();
        }
        $res = array(
            'order_sn' => '20150109113322',
            'order_amount' => 255
        );
        //=========步骤2：使用统一支付接口，获取prepay_id============
        //使用统一支付接口
        $unifiedOrder = new \UnifiedOrder_pub();
        //设置统一支付接口参数
        //设置必填参数
        //appid已填,商户无需重复填写
        //mch_id已填,商户无需重复填写
        //noncestr已填,商户无需重复填写
        //spbill_create_ip已填,商户无需重复填写
        //sign已填,商户无需重复填写
        $total_fee = $res['order_amount']*100;
        //$total_fee = 1;
        $body = "订单支付{$res['order_sn']}";
        $unifiedOrder->setParameter("openid", "$openid");//用户标识
        $unifiedOrder->setParameter("body", $body);//商品描述
        //自定义订单号，此处仅作举例
        $out_trade_no = $res['order_sn'];
        $unifiedOrder->setParameter("out_trade_no", $out_trade_no);//商户订单号 
        $unifiedOrder->setParameter("total_fee", $total_fee);//总金额
        //$unifiedOrder->setParameter("attach", "order_sn={$res['order_sn']}");//附加数据 
        $unifiedOrder->setParameter("notify_url", \WxPayConf_pub::NOTIFY_URL);//通知地址 
        $unifiedOrder->setParameter("trade_type", "JSAPI");//交易类型
        //非必填参数，商户可根据实际情况选填
        //$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号  
        //$unifiedOrder->setParameter("device_info","XXXX");//设备号 
        //$unifiedOrder->setParameter("attach","XXXX");//附加数据 
        //$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
        //$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间 
        //$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记 
        //$unifiedOrder->setParameter("openid","XXXX");//用户标识
        //$unifiedOrder->setParameter("product_id","XXXX");//商品ID
        $prepay_id = $unifiedOrder->getPrepayId();
        //=========步骤3：使用jsapi调起支付============
        $jsApi->setPrepayId($prepay_id);
        $jsApiParameters = $jsApi->getParameters();
        $wxconf = json_decode($jsApiParameters, true);
        if ($wxconf['package'] == 'prepay_id=') {
            $this->error('当前订单存在异常，不能使用支付');
        }
        $this->assign('res', $res);
        $this->assign('jsApiParameters', $jsApiParameters);
        $this->display('jsapi');
	}
	//异步通知url，商户根据实际开发过程设定
	public function notify_url() {
		vendor('Weixinpay.WxPayPubHelper');
	    //使用通用通知接口
		$notify = new \Notify_pub();
		//存储微信的回调
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];	
		$notify->saveData($xml);
		//验证签名，并回应微信。
		//对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
		//微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
		//尽可能提高通知的成功率，但微信不保证通知最终能成功。
		if($notify->checkSign() == FALSE){
			$notify->setReturnParameter("return_code", "FAIL");//返回状态码
			$notify->setReturnParameter("return_msg", "签名失败");//返回信息
		}else{
			$notify->setReturnParameter("return_code", "SUCCESS");//设置返回码
		}
		$returnXml = $notify->returnXml();
		//==商户根据实际情况设置相应的处理流程，此处仅作举例=======
		//以log文件形式记录回调信息
		//$log_name = "notify_url.log";//log文件路径
		//$this->log_result($log_name, "【接收到的notify通知】:\n".$xml."\n");
        $parameter = $notify->xmlToArray($xml);
        //$this->log_result($log_name, "【接收到的notify通知】:\n".$parameter."\n");
		if($notify->checkSign() == TRUE){
			if ($notify->data["return_code"] == "FAIL") {
                //此处应该更新一下订单状态，商户自行增删操作
                //$this->log_result($log_name, "【通信出错】:\n".$xml."\n");
                //更新订单数据【通信出错】设为无效订单
                echo 'error';
			}
			else if($notify->data["result_code"] == "FAIL"){
                //此处应该更新一下订单状态，商户自行增删操作
                //$this->log_result($log_name, "【业务出错】:\n".$xml."\n");
                //更新订单数据【通信出错】设为无效订单
                echo 'error';
			}
			else{
                //$this->log_result($log_name, "【支付成功】:\n".$xml."\n");
                //我这里用到一个process方法，成功返回数据后处理，返回地数据具体可以参考微信的文档
                if ($this->process($parameter)) {
                    //处理成功后输出success，微信就不会再下发请求了
                    echo 'success';
                }else {
                    //没有处理成功，微信会间隔的发送请求
                    echo 'error';
                }
			}
		}
	}
    //订单处理
    private function process($parameter) {
        //此处应该更新一下订单状态，商户自行增删操作
        /*
        * 返回的数据最少有以下几个
        * $parameter = array(
            'out_trade_no' => xxx,//商户订单号
            'total_fee' => XXXX,//支付金额
            'openid' => XXxxx,//付款的用户ID
        );
        */
        return true;
    }
}
?>