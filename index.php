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
//只有该域名可访问本系统
define('ADMIN_URL','test.com');

//防止SQL注入代码，请将该文件中前两段代码添加到自己项目index.php的最前面即可
/////*****防止SQL注入代码 begin*****/////
//判断是否含有注入并跳出
function sqlInj($value) {
    //过滤参数
    $arr = explode('|', 'UPDATEXML|EXEC|TRUNCATE|DECLARE|NOTLIKE|NOT BETWEEN|NOTBETWEEN|BETWEEN|NOTIN|NOT IN|EXTRACTVALUE|LOAD_FILE|outfile');
    if (is_string($value)) {
        foreach ($arr as $a) {
            //判断参数值中是否含有SQL关键字，如果有则跳出
            if (stripos($value, $a) !== false){
                exit(json_encode(array('status' => -1, 'info' => '参数错误，含有敏感字符' . $a, 'data' => array($a)), 0));
            }
        }
    } elseif (is_array($value)) {
        //如果参数值是数组则递归遍历判断
        foreach ($value as $v) {
            sqlInj($v);
        }
    }
}

//过滤请求参数
foreach ($_REQUEST as $key => $value) {
    sqlInj($value);
}
/////*****防止SQL注入代码 end*****/////</pre>


// phpinfo();die;
// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',true);
define('DB_FIELD_CACHE',true);

defined('APP_REAL_PATH') 	or define('APP_REAL_PATH',     __DIR__.'/');
// 定义应用目录
define('APP_PATH','./Application/');

define('EXTEND_PATH','./Extend/');

define('SYSTEM_DOMAIN_NAME', '微操盘');

define('SYSTEM_HEAD_UPLOAD_PATH', dirname($_SERVER['SCRIPT_FILENAME']).'/Public/Qts/Home/img/live');	//其他图片存储地址


define('SYSTEM_WEIXIN_UPLOAD_PATH', dirname($_SERVER['SCRIPT_FILENAME']).'/Uploads/');	//其他图片存储地址

define('SYSTEM_FACE_UPLOAD_PATH', dirname($_SERVER['SCRIPT_FILENAME']).'/Uploads/face/');//用户头像存储

define('LOG_PATH_SPE', dirname($_SERVER['SCRIPT_FILENAME']).'/Logs/');
define('APP_NAME', 'index');

define('NORMAL_WX_APPID', 'wxc63594d45a3df5bb');
define('NORMAL_WX_APPSECRET', 'df258fc30c973721e7fce2e2f38694da');

define('WX_TOKEN_PATH', dirname($_SERVER['SCRIPT_FILENAME']).'/wxcache/');


// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单
