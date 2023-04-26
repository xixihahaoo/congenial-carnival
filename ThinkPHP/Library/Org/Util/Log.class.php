<?php
/**
 * @author: FrankHong
 * @datetime: 2015-04-23 11:08
 * @filename: AccountAction.php
 * @note: 基础action
 *
 * @usage: 基于Thinkphp框架的使用
 * 先定义  namespace Org\Util;
 *
 * 第一种
 *      $Log    = new \Org\Util\Log();
 *      $Log->t();
 * 第二种
 *      \Org\Util\Log::test();
 * 第三种
 *      文件头部引用  use Org\Util\Log;
 *      调用          Log::test();
 *
 *
 *
 * @function:
 *      Log::debugArr($goodsRs, 'index');       //数组
 *      Log::debug($goodsRs, 'wx');             //字符串、json
 */


namespace Org\Util;
class Log{


    /**
     * @functionname: t
     * @author: FrankHong
     * @date: 2016-08-26 10:34:51
     * @description: 不使用静态方法
     * @note:
     */
    public function t()
    {
        echo 'Just test this class';
    }

    /**
     * @functionname: test
     * @author: FrankHong
     * @date: 2016-08-26 09:45:55
     * @description: 测试当前日志类是否加到框架中
     * @note:
     */
    public static function test()
    {
        echo 'Just test this class';
    }

    /**
     * frank @ 2015-03-12
     * 打日志
     * @param string $msg 日志内容
     * @param string $preFix 日志前缀，比如可以标记属于什么类型的日志
     * @param string $level 日志等级
     * @param bool $type 日志类型
     */
    public static function write($msg, $preFix = 'log', $level = 'DEBUG', $type = null)
	{
		$msg = date('[ Y-m-d H:i:s ]')."[{$level}]\r\n".$msg."\r\n";
		$logPath = LOG_PATH_SPE.APP_NAME.'/'.$preFix.'_'.date('Y_md_H_i');

        //echo $logPath;

		if($type)
			$logPath .= '.'.$type;

		$logPath	.= '.log';
		file_put_contents($logPath, $msg, FILE_APPEND);
    }

	/**
	 * @functionname: w
	 * @author: FrankHong
	 * @date: 2016-09-20 11:00:31
	 * @description: 新建 写入类
	 * @note: 用与cli模式下的日志记录，生成的log日志路径为 clilogs
	 * @param $msg
	 * @param string $preFix
	 * @param string $logPath
	 * @param string $level
	 * @param null $type
	 */
	public static function w($msg, $preFix = 'log', $logPath = LOG_PATH_SPE, $level = 'SYSTEM', $type = null)
	{
		$msg = date('[ Y-m-d H:i:s ]')."[{$level}]\r\n".$msg."\r\n";
		$logPath = $logPath.'clilogs'.APP_NAME.'/'.$preFix.'_'.date('Ymd');
		//echo $logPath;
		if($type)
			$logPath .= '.'.$type;

		$logPath	.= '.log';

		//echo $logPath;
		file_put_contents($logPath, $msg, FILE_APPEND);
	}


    /**
     * 打印fatal日志
     * @param string $msg 日志信息
     */
    public static function fatal($msg)
	{
        self::write($msg, 'FATAL', 'error');
    }

    /**
     * 打印warning日志
     * @param string $msg 日志信息
     */
    public static function warn($msg)
	{
        self::write($msg, 'WARN', 'error');
    }

    /**
     * 打印notice日志
     * @param string $msg 日志信息
     */
    public static function notice($msg)
	{
        self::write($msg, 'NOTICE');
    }

    /**
     * 打印debug日志
     * @param string $msg 日志信息
     * @param string $preFix 日志前缀，配合appname使用，可以清晰的知道日志来源
     */
    public static function debug($msg, $preFix = 'log')
	{
        self::write($msg, $preFix, 'DEBUG', 'debug');
    }

    /**
     * 打印debug日志
     * @param $arr  param array $msg 日志信息
     * @param string $preFix 日志前缀，配合appname使用，可以清晰的知道日志来源
     * @param null $type
     */
	public static function debugArr($arr = null, $preFix = 'log', $type = null)
	{
		$msg	= var_export($arr, true);
		if(!is_null($type))
			$logType	= 'debug_'.$type;

		self::write($msg, $preFix, 'DEBUG', $logType);
	}

    /**
     * 打印sql日志
     * @param string $msg 日志信息
     */
    public static function sql($msg)
	{
        self::write($msg, 'SQL', 'sql');
    }
}