<?php
namespace Org\Util;

use \Workerman\Worker;
use \Workerman\Lib\Timer;
use \Workerman\Connection\AsyncTcpConnection;
require_once 'Workerman/Autoloader.php';

/**
* 
*/
class Websocket 
{
	public function option ()
	{   
		$dataArr = array();
		$option = M('option')->select();
		foreach ($option as $key => $value) {
		   array_push($dataArr, $value['capital_key']);
		}
		 return implode(',', $dataArr);
	}

	public function save_option($code,$datas)
	{
        $option = M('option');
        $data['Price']     = $datas['Price'];
        $data['Open']      = $datas['Open'];
        $data['Close']     = $datas['LastClose'];
        $data['High']      = $datas['High'];
        $data['Low']       = $datas['Low'];
        $data['Diff']      = $datas['Diff'];
        $data['DiffRate']  = $datas['DiffRate'];
        $data['edit_time'] = $datas['LastTime'];
        $data['bp']        = $datas['BP1'];
        $data['bv']        = $datas['BV1'];
        $data['sp']        = $datas['SP1'];
        $data['sv']        = $datas['SV1'];
        $option->where(array('capital_key' => $code))->save($data);
	}


    public function work()
    {
        $worker = new Worker();
		// 进程启动时
		$worker->onWorkerStart = function()
		{
		    // 以websocket协议连接远程websocket服务器
		    $ws_connection = new AsyncTcpConnection("ws://aishang.ronmei.com:8888/ws");

		    $ws_connection->onConnect = function($connection){

		    	$payload = json_encode(array(
		            'event' => 'REG',
		            'Key' => $this->option()
		        ));
		        $connection->send($payload);
		    };
		    // 远程websocket服务器发来消息时
		    $ws_connection->onMessage = function($connection, $data){
		        $data = json_decode($data,true);
		        $data = $data['body'];
		        $datas['Price']     = $data['Price'];
		        $datas['Open']      = $data['Open'];
		        $datas['LastClose'] = $data['LastClose'];
		        $datas['Low']       = $data['Low'];
		        $datas['Diff']      = $data['Diff'];
		        $datas['DiffRate']  = $data['DiffRate'];
		        $datas['LastTime']  = $data['LastTime'];
		        $datas['BP1']       = $data['BP1'];
		        $datas['BV1']       = $data['BV1'];
		        $datas['SP1']       = $data['SP1'];
		        $datas['SV1']       = $data['SV1'];
		        $this->save_option($data['StockCode'],$datas);
		        //echo $data['StockCode'];
		    };
		    // 连接上发生错误时，一般是连接远程websocket服务器失败错误
		    $ws_connection->onError = function($connection, $code, $msg){
		        echo "error: $msg\n";
		    };
		    // 当连接远程websocket服务器的连接断开时
		    $ws_connection->onClose = function($connection){
		    	 // 如果连接断开，则在1秒后重连 如果为空 0则立即重新连接
		        $connection->reConnect(1);
		    };
		    // 设置好以上各种回调后，执行连接操作
		    $ws_connection->connect();
		};
		Worker::runAll();
    }
}
