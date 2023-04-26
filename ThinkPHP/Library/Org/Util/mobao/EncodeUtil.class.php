<?php
/*****************************
Huang Jing
2016年1月12日 10:51:29
Function    url格式编码
Function 1  Base64编码
Function 2  Base64解码
Function 3  MD5加密
******/


class  EncodeUitl{
	
	
	public  static  function  getUrlStr($transMap){
		//组织需要加密的字符串
	$transStr="";
	$flag=1;
	foreach($transMap as $v=>$a) 
	{
 		if(sizeof($transMap)==$flag){
	  	$transStr= $transStr.$v."=".$a;
 		}else{
	  	$transStr= $transStr.$v."=".$a."&";
  	}
 	 $flag++;
	} 
	  return 	$transStr;
 	}

}
?>