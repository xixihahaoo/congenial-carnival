<?php
namespace Home\Model;
use Think\Model;
class OrderModel extends Model {

	/**
	 * [getList 获取交易记录]
	 * @param  [int] $user_id [用户id]
	 * @param  [int] $ostaus  [0持仓 1平仓]
	 * @param  [int] $type    [1 实盘交易 2模拟交易]
	 * @return array
	 * by wanghaidong 2018-3-23
	 */
	public function getList($user_id,$ostaus,$type)
	{
		return $this->where(array('uid'=>$user_id,'ostaus' => $ostaus,'type' => $type))->order('oid desc')->select();
	}


	/**
	 * [GetPageList 使用分页获取交易记录]
	 * @param  [int] $user_id 		[用户id]
	 * @param  [int] $ostaus  		[0持仓 1平仓]
	 * @param  [int] $type    		[1 实盘交易 2模拟交易]
	 * @param  [int] $nowPage 		[当前页]
	 * @param  [int] $num     		[显示的条数]
	 * @param  [int] $order_tpye 	[订单类型]
	 * @return array
	 * by wanghaidong 2018-3-23
	 */
	public function GetPageList($user_id,$ostaus,$type,$nowPage,$num,$order_type)
	{
		$map = array(
			'uid' 	=> $user_id,
			'ostaus'	=> $ostaus,
			'type'		=> $type
		);
		if($order_type) $map['order_type'] = $order_type;

		return $this->where($map)->order('selltime desc')->page($nowPage,$num)->select();
	}

	//获取订单总条数
	public function GetCount($user_id,$ostaus,$type)
	{
		return $this->where(array('uid'=>$user_id,'ostaus' => $ostaus,'type' => $type))->count();
	}
}
