<?php
return array(
    'DEFAULT_MODULE'     => 'Agent',
    'DEFAULT_CONTROLLER'=>'Login',//默认控制器
    'DEFAULT_ACTION'   =>  'login',
	//'配置项'=>'配置值'
   'SHOW_PAGE_TRACE'=>false,
	 /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__Fonts__' => __ROOT__ . '/Public/Ucenter/fonts',
         '__ICO__'    => __ROOT__ . '/Public/Ucenter/ico',
        '__IMG__'    => __ROOT__ . '/Public/Ucenter/img',
        '__CSS__'    => __ROOT__ . '/Public/Ucenter/css',
        '__JS__'     => __ROOT__ . '/Public/Ucenter/js',
        '__PLU_'     => __ROOT__ . '/Public/Ucenter/plugins',
        '__PUBACE__'    => __ROOT__ . '/Public/Ucenter/proxy',
        '__PUBCSS__'    => __ROOT__ . '/Public/css',
        '__PUBJS__'     => __ROOT__ . '/Public/Js',
        '__PUBLIC__'    => __ROOT__ . '/Public/'

    )

);