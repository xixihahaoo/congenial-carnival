<?php
return array(

    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'db_utrade',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '0032d5a9f34989df',   // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'wp_',    // 数据库表前缀

    'DB_FIELDTYPE_CHECK'    =>  false,       // 是否进行字段类型检查
    'DB_FIELDS_CACHE'       =>  false,        // 启用字段缓存
    'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE'        =>  0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE'        =>  false,       // 数据库读写是否分离 主从式有效
    'DB_MASTER_NUM'         =>  1, // 读写分离后 主服务器数量
    'DB_SLAVE_NO'           =>  '', // 指定从服务器序号
    'DB_SQL_BUILD_CACHE'    =>  false, // 数据库查询的SQL创建缓存
    'DB_SQL_BUILD_QUEUE'    =>  'file',   // SQL缓存队列的缓存方式 支持 file xcache和apc
    'DB_SQL_BUILD_LENGTH'   =>  20, // SQL缓存的队列长度
    'DB_SQL_LOG'            =>  false, // SQL执行日志记录
    'DB_BIND_PARAM'         =>  false, // 数据库写入数据自动参数绑定

    'SMS_USERNAME'          =>  '2779224307',     // 当前系统客户短信平台用户名
    'SMS_PASSWORD'          =>  'Xu1234568', //当前系统客户短信平台密码

    'ZHIFUNO'               => '2030250272',   //智付商户号

    'BOND_RATE'             => 10,      //最小保证金比例 %

    'DB_FIELD_CACHE'       => false,
    'TMPL_CACHE_ON' => false,//禁止模板编译缓存
    'HTML_CACHE_ON' => false,//禁止静态缓存
    
    'DEFAULT_MODULE'       =>    'Home',  // 默认模块
    'URL_MODULE_MAP'       =>    array('login'=>'admin'),    //模块路由映射

    'LOAD_EXT_CONFIG'      => array('INTE'=>'integral','COMM' => 'commission','ZH' => 'zh-tw'),    //加载扩展配置

    'LANG_SWITCH_ON'    => true, // 开启语言包功能
    'LANG_AUTO_DETECT'  => true, // 自动侦测语言 开启多语言功能后有效
    'DEFAULT_LANG'      => 'zh-cn', // 默认语言
    'LANG_LIST'         => 'zh-cn,zh-tw,en-us', // 允许切换的语言列表 用逗号分隔
    'VAR_LANGUAGE'      => 'l', // 默认语言切换变量
);
