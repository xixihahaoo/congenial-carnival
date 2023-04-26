<?php
namespace Org\Util;

use \Workerman\Connection\AsyncTcpConnection;
use \Workerman\Lib\Timer;
use \Workerman\Worker;

require_once 'Workerman/Autoloader.php';

/**
 *
 */
class Work {

	private $aClients = array();

	/**
	 * 接收推送过来的数据
	 */

	public function __construct() {
		$worker = new Worker();

		// 进程启动时
		$worker->onWorkerStart = function () {
			//$ws_connection = new AsyncTcpConnection("ws://data.ronmei.com:8888/ws");
			  $ws_connection = new AsyncTcpConnection("ws://39.107.99.235:1008/ws");
			//  $ws_connection = new AsyncTcpConnection("ws://127.0.1:1071/ws");

			$ws_connection->onConnect = function ($connection) {

				$payload = json_encode(array(
					'event' => ')(*&^&*()',
					'Key' => $this->option(),
				));
				$connection->send($payload);
			};

			// 远程websocket服务器发来消息时
			$ws_connection->onMessage = function ($connection, $data) {

                file_put_contents('/tmp/'.date('Y-m-d').'new-ws-work.log', "{$data}\n", FILE_APPEND | LOCK_EX);

				$data = json_decode($data, true);
				$data = $data['body'];
				$code = $data['StockCode'];

				// if(isset($this->aClients[$code])){
				//     echo $code."\n";
				//     foreach($this->aClients as $key => $conn){
				//         $conn->send($data);
				//     }
				// }

				$datas[$code] = $data;
				S('aClients', json_encode($datas));
				$this->save_option($code, $data);
			};

			// 连接上发生错误时，一般是连接远程websocket服务器失败错误
			$ws_connection->onError = function ($connection, $code, $msg) {
				//  $connection->reConnect(1);
			};

			// 当连接远程websocket服务器的连接断开时
			$ws_connection->onClose = function ($connection) {
				$connection->reConnect();
			};

			$ws_connection->connect();
		};
	}

	public function option() {
		$dataArr = array();
		$option = M('option')->select();
		foreach ($option as $key => $value) {
			array_push($dataArr, $value['capital_key']);
		}
		return implode(',', $dataArr);
	}

	public function save_option($code, $datas) {
		$option = M('option');
		$data['Price'] = $datas['Price'];
		$data['Open'] = $datas['Open'];
		$data['Close'] = $datas['LastClose'];
		$data['High'] = $datas['High'];
		$data['Low'] = $datas['Low'];
		$data['Diff'] = $datas['Diff'];
		$data['DiffRate'] = $datas['DiffRate'];
		$data['edit_time'] = $datas['LastTime'];
		$data['bp'] = $datas['BP1'];
		$data['bv'] = $datas['BV1'];
		$data['sp'] = $datas['SP1'];
		$data['sv'] = $datas['SV1'];
		$option->where(array('capital_key' => $code))->save($data);
	}

	/**
	 * 推送数据
	 */

	public function work($ip) {
		// 创建一个Worker监听2346端口，使用websocket协议通讯
		$ws_worker = new Worker('websocket://' . $ip . '');

		$ws_worker->count = 4;

		// 定时推送消息
		$ws_worker->onWorkerStart = function ($task) {
			$time_interval = 0.05;
			Timer::add($time_interval, function () {
				$data = S('aClients');
				$data = json_decode($data, true);
				if (!empty($data)) {
					foreach ($data as $key => $value) {
						if (isset($this->aClients[$value['StockCode']])) {
							foreach ($this->aClients[$value['StockCode']] as $key => $conn) {
								$conn->send(json_encode($data[$value['StockCode']]));
								//S('aClients', null);
							}
						}
					}
				}
			});
		};

		$ws_worker->onConnect = function ($connection) {

		};

		$ws_worker->onClose = function ($connection) {
		};

		// 当收到客户端发来的数据后返回hello $data给客户端
		$ws_worker->onMessage = function ($connection, $data) {
			$data = json_decode($data, true);
			if ($data['event'] == 'REG') {
				$keys = explode(",", $data['Key']);
				foreach ($keys as $key) {
					if (isset($this->aClients[$key])) {
						$this->aClients[$key][] = $connection;
					} else {
						$this->aClients[$key] = [$connection];
					}
				}
			}
		};
		// 运行worker

		Worker::runAll();

	}

}
