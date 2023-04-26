<?php
namespace Home\Model;
use Think\Model;
class UserinfoModel extends Model {

	/**
	 * [getDataFind 获取用户单条信息]
	 * @param  [int] $user_id [用户id]
	 * @return array
	 * by wanghaidong 2018-3-23
	 */
	public function getDataFind($user_id)
	{
		return $this->where(array('uid'=>$user_id))->find();
	}

	/**
	 * [getDataList 获取所有用户列表]
	 * @return [type] [description]
	 */
	public function getDataList()
	{
		return $this->select();
	}
}
