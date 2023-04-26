<?php
/**
 * 
 * 微信支付API异常类
 * @author widyhu
 *
 */
//---------------------------------
//开发: 小曾
//扣扣: 839024615
//官网: www.php127.com
//---------------------------------
class WxPayException extends Exception {
	public function errorMessage()
	{
		return $this->getMessage();
	}
}
