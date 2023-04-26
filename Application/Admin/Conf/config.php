<?php
return array(

 'DEFAULT_MODULE'     => 'Admin',
 'DEFAULT_CONTROLLER'=>'User',//默认控制器
 'DEFAULT_ACTION'   =>  'signin',
    //'配置项'=>'配置值'
   'SHOW_PAGE_TRACE'=>false,
     /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__IMG__'       => __ROOT__ . '/Public/' . MODULE_NAME . '/img',
        '__CSS__'       => __ROOT__ . '/Public/' . MODULE_NAME . '/css',
        '__JS__'        => __ROOT__ . '/Public/' . MODULE_NAME . '/js',
        '__PUBCSS__'    => __ROOT__ . '/Public/css',
        '__PUBJS__'     => __ROOT__ . '/Public/Js',
        '__PUBLIC__'    => __ROOT__ . '/Public/',
        '__PUBACE__'    => __ROOT__ . '/Public/Admin/proxy'
    ),
	
  'URL_CASE_INSENSITIVE'  =>  true,   //不区分大小写
	
 
);