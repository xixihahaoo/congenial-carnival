<?php

/*****************************
Huang Jing
2016年1月12日 10:51:29
Http 客户端   实例
Post方法
******/

class HttpCilnet{
	
	
  //post方法提交
  public static function post2($url, $data){//file_get_content
        $postdata = http_build_query(
            $data
        );
        $opts = array('http' =>
                      array(
                          'method'  => 'POST',
                          'header'  => 'Content-type:application/x-www-form-urlencoded;charset=GBK',
                          'content' => $postdata
                      )
        );
 
        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);
	
		return  $result;
    }
}


?>