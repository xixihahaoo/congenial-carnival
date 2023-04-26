<?php
return [


    //中英文切换语言包配置项
    'LANG_SWITCH_ON'    => true,
    //开启语言包功能
    'LANG_AUTO_DETECT'  => true,
    // 自动侦测语言
    'DEFAULT_LANG'      => 'zh-tw',
    // 默认语言
    'LANG_LIST'         => 'zh-cn,zh-tw,en-us',
    //必须写可允许的语言列表
    'VAR_LANGUAGE'      => 'l',
    // 默认语言切换变量



    //'配置项'=>'配置值'
    'SHOW_PAGE_TRACE'   => false,
    /* 模板相关配置 */
    'TMPL_PARSE_STRING' => [
        '__STATIC__' => __ROOT__.'/Public/static',
        '__ADDONS__' => __ROOT__.'/Public/'.MODULE_NAME.'/Addons',
        '__IMG__'    => __ROOT__.'/Public/'.MODULE_NAME.'/images',
        '__CSS__'    => __ROOT__.'/Public/'.MODULE_NAME.'/css',
        '__JS__'     => __ROOT__.'/Public/'.MODULE_NAME.'/js',
        '__PUBLIC__' => __ROOT__.'/Public/',
    ],


    // 'SHOW_PAGE_TRACE'=>true,//开启页面Trace

    /*默认模版分类*/
    //'DEFAULT_THEME'    =>    'Default',
    'DEFAULT_THEME'     => 'Qts',

    'URL_ROUTER_ON'   => true,
    'URL_ROUTE_RULES' => [ //定义路由规则
                           'invatation/:code' => 'Register/outsideReg',

    ],
];