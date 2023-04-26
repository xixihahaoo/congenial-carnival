<?php
namespace Home\Model;
use Think\Model;
class BalanceModel extends Model {


	/**
	 * 获得交易详情
	 * by wanghaidong 2017-4-23
	 * @param  int $order_id 订单id
	 * @return array           
	 */
	public function getDetail($order_id){
		return $this->where(array('bpid'=>$order_id))->find();
	}


	/**
	 * 根据订单号码获取交易详情
	 * @param  string $order_no 订单号码
	 * @return array           
	 */
	public function getDetailByOrderNo($order_no){
		return $this->where(array('balanceno'=>$order_no))->find();
	}


}
