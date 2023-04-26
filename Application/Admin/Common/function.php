<?php
	
	/**
	 * 判断session是否存在
	 * @author li
	 */
	function islogin(){
	  $uid=$_SESSION['userid'];
	  return $uid;
	}
?>