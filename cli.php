<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 应用入口文件
// 检测PHP环境
// echo 1;exit;
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

define('APP_DEBUG', true);
// 定义应用目录

// 引入ThinkPHP入口文件
define( 'APP_PATH', dirname(__FILE__).'/Application/' );


////系统日志路径，根据应用不同，分别建立目录存储
//define('LOG_PATH', dirname($_SERVER['SCRIPT_FILENAME']).'/Logs/');
define('APP_NAME', '');
define('APP_MODE','cli');

define('LOG_PATH_SPE', dirname($_SERVER['SCRIPT_FILENAME']).'/Logs/');

require dirname( __FILE__).'/ThinkPHP/ThinkPHP.php';


// 亲^_^ 后面不需要任何代码了 就是如此简单
