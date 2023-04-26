<?php
	function getDownuids($uid,$type=1){
		$oid=M('userinfo')->field('uid,username')->where('oid='.$uid." and otype!=0")->select();//查询当前用户下级所有非客户的uid
		// var_dump($oid);die;
        for($i=0; $i<count($oid); $i++ ) {
			$oid[$i]=$oid[$i]['uid'];
		}
		

	//	var_dump($oid);
		
		if(!empty($oid)){//如果有,继续查询下级所有非客户的uid
			$oid1=M('userinfo')->where('oid in('.implode(',',$oid).') and ustatus=0 and otype!=0 and vertus = 1')->select();
			for($i=0; $i<count($oid1); $i++ ) {
				$oid1[$i]=$oid1[$i]['uid'];
			}
		}
		//var_dump($oid1);
		
		if(!empty($oid))
		{
				if(!empty($oid1))
				{
					$olds = array_merge(array_merge($oid,$oid1),array($uid));
					
				}else{
					$olds = array_merge($oid,array($uid));
				}
		}else{
			$olds = array($uid);
		}
		
		
		$us = M('userinfo')->where('oid in('.implode(',',array_filter($olds)).') and ustatus=0 and otype=0 and vertus = 1')->select();
		foreach ($us as $key => $value) {
    		$arruid[]=$value['uid'];
    	}
	
		if($type == 1)//下级所有客户，经纪人，普通会员，会员单位
		{
			if(empty($arruid))
			{
				$arruid = $olds;
			}else{
				$arruid = array_merge($arruid,$olds);
			}
			
		}else{//下级所有客户
			$arruid = $arruid;
		}
	//		var_dump($arruid);
		return $arruid;
	}