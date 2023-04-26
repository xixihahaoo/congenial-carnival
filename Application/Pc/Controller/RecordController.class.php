<?php
// +----------------------------------------------------------------------
// | 历史订单控制器
// +----------------------------------------------------------------------
// | Author wang <li> 
// +----------------------------------------------------------------------
namespace Pc\Controller;
use Think\Controller;

class RecordController extends CommonController{

	public function _initialize()
	{    
		parent::_initialize();
		
        $this->user_id = session('user_id');

        if(!$this->user_id)
        {
	        if(IS_AJAX)
	        	outjson(array('code' => 400,'msg' => L('no_login')));
	        else
	        	$this->redirect('Login/login');
        }
	}

	/**
	 * [list 历史记录]
	 * @author wang li
	 */
	public function index()
	{
		$userModel 	= D('userinfo');
		$orderModel = D('order');

		$user = $userModel->getDataFind($this->user_id);

		$count = $orderModel->GetCount($user['uid'],1,$user['now_trade_status']);

        //一次性处理该用户所有未读历史订单
        if($this->orderStatusCount > 0) {
            M('order')->where(array('uid' => $this->user_id,'ostaus' => 1,'is_read' => 1,'type' => $user['now_trade_status']))->setField('is_read',2);
        }

		$this->assign('count',ceil($count/10));
		$this->assign('user',$user);
		$this->display();
	}


	/**
	 * [GetRecordOrder 获取历史交易记录]
	 * @author wang li
	 */
	public function GetRecordOrder()
	{
		if(IS_AJAX)
		{
			$orderModel = D('order');
			$userModel 	= D('userinfo');

			$page 		= trim(I('get.page'));
			$order_type = trim(I('get.orderType'));  //0全部，1自持 2跟单 3撤单

			$page = $page == 0 ? 1 : $page; 

			$user = $userModel->getDataFind($this->user_id);


			if($order_type == 1 || $order_type == 2)
			{
				$data = $orderModel->GetPageList($user['uid'],1,$user['now_trade_status'],$page,10,$order_type);
			} else if($order_type == '0') {
				$data = $orderModel->GetPageList($user['uid'],1,$user['now_trade_status'],$page,10);
			}

			foreach ($data as $key => $value) {

				$data[$key]['onumber'] 		= round($value['onumber'],2);

				$data[$key]['ostyleMsg'] 	= $value['ostyle'] == 0 ? L('api_buy') : L('api_sell');
				$data[$key]['ostyleColor'] 	= $value['ostyle'] == 0 ? 'bg_red' : 'bg_green';
				$data[$key]['plossColor'] 	= $value['ploss'] >= 0 ? 'txt_green' : 'txt_red';
				$data[$key]['orderType']	= 1;	//平仓

                if(LANG == 'en-us') {
                    $data[$key]['option_name'] = $value['en_name'];
                } else if(LANG == 'zh-tw') {
                    $data[$key]['option_name'] = simpleTradition($value['option_name']);
                }
			}

			//查询撤单信息
			$guadan = M('guadan_order')->where(array('user_id' => $user['uid'],'type' => $user['now_trade_status'],'status' => 3))->order('handle_time desc')->page($page,10)->select();

			foreach ($guadan as $key => $value) {
				$guadan[$key]['onumber'] 		= round($value['number'],2);
				$guadan[$key]['ostyleMsg'] 		= $value['ostyle'] == 0 ? L('api_buy') : L('api_sell');
				$guadan[$key]['ostyleColor'] 	= $value['ostyle'] == 0 ? 'bg_red' : 'bg_green';
				$guadan[$key]['orderType']		= 2;	//挂单

                if(LANG == 'en-us') {
                    $guadan[$key]['option_name'] = $value['en_name'];
                } else if(LANG == 'zh-tw') {
                    $guadan[$key]['option_name'] = simpleTradition($value['option_name']);
                }
			}

			if($order_type == 3)
			{
				$data = $guadan;
			} else if($order_type == 1 || $order_type == 2){
				$data = $data;
			} else {
				if($guadan) $data = array_merge($data,$guadan);
			}

			if($data)
				outjson(array('code' => 200,'msg' => 'success','data' => $data));
			else
				outjson(array('code' => 400,'msg' => 'error'));
		} else {
			outjson(array('code' => 400,'msg' => 'error'));
		}
	}

	//交易记录详情
	public function recordDetails()
	{	
		$oid = trim(I('get.oid'));

		$orderObj = M('order');

		$order = $orderObj->where(array('oid' => $oid))->find();

		//订单结果
		switch ($order['order_result']) {
			case 1:
				$order['order_result_note'] 	= L('api_a_draw');
				$order['order_result_class']	= 'txt_green';
				break;
			case 2:
				$order['order_result_note'] 	= L('api_target_profit');
				$order['order_result_class']	= 'txt_green';
				break;
			case 3:
				$order['order_result_note'] 	= L('api_stop_loss');
				$order['order_result_class']	= 'txt_red';
				break;
		}

		//买入类型
		if($order['order_type'] == 1 || $order['order_type'] == 2)
		{
			if($order['ostyle'] == 0){
				$order['order_type_note'] 	= L('api_market_buying');
				$order['order_class']	= 'bg_red';
			} else {
				$order['order_type_note'] 	= L('api_sell_market');
				$order['order_class']	= 'bg_green';
			}
		} else{
			if($order['ostyle'] == 0){
				$order['order_type_note'] 		= L('api_purchase_bills');
				$order['order_class']		= 'bg_red';
			} else {
				$order['order_type_note'] 	= L('api_sale_bills');
				$order['order_class']		= 'bg_green';
			}
		}

		//挂单类型
		if($order['order_type'] == 3)
		{
			switch ($order['resting_type']) {
				case 1:
					$order['resting_note'] = L('api_sell_limit');
					break;
				case 2:
					$order['resting_note'] = L('api_buy_limit');
					break;
				case 3:
					$order['resting_note'] = L('api_break_sell');
					break;
				case 4:
					$order['resting_note'] = L('api_Break_buying');
					break;
			}
		}

		//净盈亏计算
		$order['net_profit'] = round($order['ploss'] + (-$order['fee']) + (-$order['overnight_fee']),2);

        if(LANG == 'en-us') {
            $order['option_name'] = $order['en_name'];
        } else if(LANG == 'zh-tw') {
            $order['option_name'] = simpleTradition($order['option_name']);
        }


		$this->assign('order',$order);
		$this->display();
	}
}