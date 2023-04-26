<?php

/**
 * 签名字符串
 * @return string
 * @param $prestr 需要签名的字符串
 * @param $key 私钥
 * @param $merCode 商戶號
 * return 签名结果
 */
function md5Sign($prestr,$merCode, $key) {
	$prestr = $prestr . $merCode . $key;
	return md5($prestr);
}

/**
 * 验证签名
 * @return bool
 * @param $prestr 需要签名的字符串
 * @param $sign 签名结果
 * @param $merCode 商戶號
 * @param $key 私钥
 * return 签名结果
 */
function md5Verify($prestr, $sign,$merCode, $key) {
	$prestr = $prestr .$merCode. $key;
	$mysgin = md5($prestr);
	 
	if($mysgin == $sign) {
		return true;
	}
	else {
		return false;
	}
}

/**
 * php截取<body>和</body>之間字符串
 * @param string $begin 开始字符串
 * @param string $end 结束字符串
 * @param string $str 需要截取的字符串
 * @return string
 */
function subStrXml($begin,$end,$str){
    $b= (strpos($str,$begin));
    $c= (strpos($str,$end));

    return substr($str,$b,$c-$b + strlen($end));
}
/**
 * 对象转数组
 * @param unknown $array
 * @return array
 */
function object_array($array)
{
    if(is_object($array))
    {
        $array = (array)$array;
    }
    if(is_array($array))
    {
        foreach($array as $key=>$value)
        {
            $array[$key] = object_array($value);
        }
    }
    return $array;
}


