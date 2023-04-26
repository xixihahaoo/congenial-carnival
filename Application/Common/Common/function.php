<?php ?><?php
use Org\Util\QidianSmsApi;


function get_url() {
    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
    return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
 }
 


/**
 * 使用curl获取远程数据
 * @param  string $url url连接
 * @return string      获取到的数据
 */
function curl_get_contents($url){
    
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);                //设置访问的url地址
    curl_setopt($ch,CURLOPT_HEADER,1);                //是否显示头部信息
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);               //设置超时
    curl_setopt($ch, CURLOPT_USERAGENT, _USERAGENT_);   //用户访问代理 User-Agent
    curl_setopt($ch, CURLOPT_REFERER,_REFERER_);        //设置 referer
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);          //跟踪301
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        //返回结果
    $r=curl_exec($ch);
    curl_close($ch);
    var_dump($r);exit;
    return $r;
}

function getJson($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return json_decode($output, true);
}

/****************************
 * /*  手机短信接口（www.ussns.com）
 * /* 参数：$mob        手机号码
 * /*        $content    短信内容
 *****************************/
function sendsms($mob, $content)
{
    $msgconfig = C("SMS");
    $username=$msgconfig['user2'];
    $pwd=$msgconfig['pwd'];
    $type = 0;// type=0 短信接口
    if ($type == 0) {
        /////////////////////////////////////////短信接口 开始/////////////////////////////////////////////////////////////
        $post_data = array(
            'username' => $username,
            'pwd' => $pwd,
            'msg' => urlencode($content),//短信内容 编码处理
            'phone' => $mob,//发送手机号，多号码用半角逗号","分割
        );
        $smsapi = 'www.ussns.com/Api/send';//API地址
        header("Content-type:text/html;charset=utf-8");
        $postdata = http_build_query($post_data);
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => $postdata,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents('http://'.$smsapi, false, $context);
        if($result == '888'){
            return true;//echo('恭喜：发送成功！');
        }else{
            return false;//echo('错误：发送失败！');
        }
        /////////////////////////////////////////短信接口 结束/////////////////////////////////////////////////////////////
    }else{
        return false;
    }
}   




/**
 * @functionname: sms_qidian_send_code
 * @author: FrankHong
 * @date: 2016-11-08 15:19:41
 * @description: 发送手机号
 * @note:
 * 例子
 * sms_qidian_send_code('15688889065', '微操盘' , '您的验证码是：', 1)
 *
 *
 * @return array
 * @param $mobile
 * @param string $sign_msg 签名信息，默认验证码
 * @param string $content  签名主体内容，默认  您的验证码是：
 * @param int $sign_where 签名位置，默认1 在左侧， 2右侧
 */
function sms_qidian_send_code($mobile, $sign_msg = '验证码', $content = '您的验证码是：', $sign_where = 1)
{
    $returnRs   = array('ret_code' => 0, 'ret_msg' => '');
    if (empty($mobile) || !preg_match('/^(13[0-9]|15[012356789]|1[78][0-9]|14[57])[0-9]{8}$/', $mobile))
    {
        $returnRs['ret_msg']    = '手机号码错误！';
        return $returnRs;
    }

    $mobile_verify  = get_six_num();
    $r_sign         = '【'.$sign_msg.'】';
    $r_content      = $content.$mobile_verify;

    if($sign_where == 1)
        $r_content  = $r_sign.$r_content;
    else
        $r_content  = $r_content.$r_sign;


    $smsObj = new QidianSmsApi(C('SMS_USERNAME'), C('SMS_PASSWORD'));
    $res    = $smsObj->sendSMS($mobile, $r_content);
    $res    = $smsObj->execResult($res);

    if ($res['Status'] != 1)
    {
        $returnRs['ret_code']   = 0;
        $returnRs['ret_msg']    = '系统繁忙，发送失败！';
        return $returnRs;
    }
    else
    {
        $returnRs['ret_code']   = 1;
        $returnRs['ret_msg']    = $mobile_verify;
        return $returnRs;
    }

}



/**
 * @functionname: get_six_num
 * @author: FrankHong
 * @date: 2016-11-08 15:24:22
 * @description: 生成随机的6位数字
 * @note: 常用于6位数字手机验证码
 * @return int
 */
function get_six_num()
{
    return mt_rand(100000, 999999);
}

/**
 * @functionname: vD
 * @author: FrankHong
 * @date: 2016-11-08 16:03:12
 * @description: 友好的调试输出
 * @note:
 */
function vD($arr)
{
    header('content-type:text/html;charset=utf-8');
    echo '<pre>';
    var_dump($arr);
    echo '</pre>';
}


/**
 * @functionname: get_setting_config
 * @author: FrankHong
 * @date: 2016-11-14 14:51:49
 * @description: 得到配置信息
 * @note:
 * @return array|string
 * @param $type
 * @param string $name
 */
function get_setting_config($type, $name = '')
{
    $res        = '';
    $setting    = M('setting');
    switch($type)
    {
        //获取单条信息
        case 'find':
            if (empty($name)) break;

            $res    = $setting->field('name, title, datas')->where(array('name' => $name))->find();
            if ($res)
            {
                $res['datas']   = !empty($res['datas']) ? unserialize($res['datas']) : array();
            }
            break;
        case 'all':
            $list   = $setting->field('name,title,datas')->select();
            $res    = array();
            if ($list)
            {
                foreach($list as $key => $val)
                {
                    $res[$val['name']]  = !empty($val['datas']) ? unserialize($val['datas']) : array();
                }
            }
            break;
    }
    return $res;
}


/**
 * @functionname: set_setting_config
 * @author: FrankHong
 * @date: 2016-11-14 15:03:48
 * @description: 设置配置信息
 * @note:
 * @return bool
 * @param $name
 * @param $datas
 */
function set_setting_config($name, $datas)
{    
    $setting    = M('setting');
    if ($setting->where(array('name' => $name))->setField('datas', $datas) !== false)
    {
        $setting->where(array('name' => $name))->setField('modify_date', date('Y-m-d H:i:s'));
        return true;
    }
    else
    {
        return false;
    }
}


/**
 * @functionname: init_common_function
 * @author: FrankHong
 * @date: 2016-11-14 17:24:31
 * @description: 系统加载的配置，来自于表setting
 * @note:
 */
function init_common_function()
{
    $con    = S('DB_CONFIG_DATA');

    if (!$con)
    {
        $con        = array();
        $setting    = get_setting_config('all');

        if (!empty($setting))
            $con    = array_merge($con, $setting);

        S('DB_CONFIG_DATA', $con);
    }

    C($con);
}

/**
 * @functionname: outjson
 * @author: FrankHong
 * @date: 2016-11-16 11:44:23
 * @description: 输出json
 * @note: 输出json，常用于前后台json交互时，后台输出json数据
 * @param $data
 * @param bool $flag
 */
function outjson($data, $flag = true)
{
    header('Content-type: application/json');
    echo json_encode($data, $flag);
    die();
}


/**
 * @author: wang
 * @date: 2016-11-10 12:04:12
 * @description: 外汇转换
 * @note:
 */
   function Transformation($pid){

      $option = M('option')->field('currency')->where(array('id' => $pid))->find();
      return $option['currency'];
}

/**
 * @author: wang
 * @date: 2016-11-10 12:04:12
 * @description: 生成二维码
 * @note:
 */
  
  function qrcode($url,$size=4,$code){

       Vendor('Phpqrcode.phpqrcode');
       $errorCorrectionLevel = 'L';//容错级别   

       // 如果没有http 则添加
        if (strpos($url, 'http')===false) 
           {
               $url='http://'.$url;
           }

       QRcode::png($url,'qrcode.png',$errorCorrectionLevel,$size,2);
       $logo = 'logo.png';//准备好的logo图片   
       $QR = 'qrcode.png';//已经生成的原始二维码图

       if ($logo !== FALSE) {   
        $QR = imagecreatefromstring(file_get_contents($QR));   
        $logo = imagecreatefromstring(file_get_contents($logo));   
        $QR_width = imagesx($QR);//二维码图片宽度   
        $QR_height = imagesy($QR);//二维码图片高度   
        $logo_width = imagesx($logo);//logo图片宽度   
        $logo_height = imagesy($logo);//logo图片高度   
        $logo_qr_width = $QR_width / 5;   
        $scale = $logo_width/$logo_qr_width;   
        $logo_qr_height = $logo_height/$scale;   
        $from_width = ($QR_width - $logo_qr_width) / 2;   
        //重新组合图片并调整大小   
        imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,   
        $logo_qr_height, $logo_width, $logo_height);   
      }

        //保存图片到文件夹
         $datapath = 'Uploads/qrcode/';
         if(!is_dir($datapath)) {
             mkdir($datapath,0777);
         } 

        //输出图片   
        $time = $datapath.'extension_'.$code;
        imagepng($QR, "$time.png");
        //$img  = '<img src="'.$time.'.png">';
        $ext = $time.'.png';
        return $ext;
  }


/**
 * @author: wang
 * @date: 2016-11-10 12:04:12
 * @description: 生成6位随机验证码
 * @note:
 */
   function generate_code($length = 6) {
        $randStr = str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz');
        $rand = substr($randStr, 0, $length);
        return $rand;
    }


    /**
     *  获取上级编号
     */
    function exchange($user_id,$numer)
     {     
        $user = M('UserinfoRelationship')->where(array('user_id'=>$user_id))->find();  //用户
         
        if(isset($user))
        {
            //运营中心
            if(trim($numer) == 2){
              
                 if($user["parent_user_id"] != 0){
                      return exchange($user["parent_user_id"],$numer);
                  }
            }
             //经纪人
            if(trim($numer) == 1){

                    $user = M("UserinfoRelationship")->where(array('user_id' => $user['parent_user_id']))->find();
            }

            if(isset($user['user_id']))
            {
                
                return $user['user_id'];       
            }
        }  else {

            return null;
        }
    }

    //获取用户名
     function change($user_id){
      
        $user = M('userinfo')->where(array('uid' => $user_id))->find();
        return !empty($user['username']) ? $user['username'] : '暂无';
     }


    //昵称
    function agent_name($user_id)
    {
        $user = M('userinfo')->where(array('uid' => $user_id))->find();
        return !empty($user['nickname']) ? $user['nickname'] : $user['username'];
    }

 //上级推广员
 function promotion($user_id,$numer)
 {
    $user = M('userinfo')->where(array('uid' => $user_id))->find();
    if($user['rid'])
    {
        $row = M('userinfo')->where(array('uid' => $user['rid']))->find();
        if($numer == 2)
        {
            $row = M('userinfo')->where(array('uid' => $row['rid']))->find();
        }
    }

    $bank = M('bankinfo')->where(array('uid' => $row['uid']))->find();
    return !empty($bank['busername']) ? $bank['busername'] : $row['username'];
 }
 

 //运营中心统计金额
 function change_money($user_ids,$status){
      
      $arr1 = array();
      $arr2 = array();

      $jinji = M("UserinfoRelationship")->distinct(true)->field('user_id')->where(array('parent_user_id' => $user_ids))->select();  //经纪人

      foreach ($jinji as $k => $v) {
         
         array_push($arr1,$v['user_id']);
      }
      $jinji_id = implode(',',array_unique($arr1));

      $user = M("UserinfoRelationship")->distinct(true)->field('user_id')->where('parent_user_id in('.$jinji_id.')')->select();

      foreach ($user as $key => $value) {
           
           array_push($arr2,$value['user_id']);
      }

      $user_id   = implode(',',array_unique($arr2));
     

     if($status == 1){
            $orderFee            = M()->table('view_wp_journal_jian')->where('uid in('.$user_id.')')->select();

            $totalFee = array();
            foreach ($orderFee as $key => $v) {
                array_push($totalFee, $v['jfee']);
            }
            return  number_format(array_sum($totalFee),2).'元';

     } else {

            $orderRs            = M()->table('view_wp_journal')->where('uid in('.$user_id.')')->select();
            $totalMoney = array();
            foreach($orderRs as $k =>$v)
            {
                array_push($totalMoney, $v['jploss'] );
            }
            return number_format(array_sum($totalMoney),2);
     }
     
 }

    /**
     * @author: wang
     * @date: 2016-11-10 12:04:12
     * @description: 后台查看外汇
     * @note:
     */

    function currency($code){

      $setting = M("setting")->where(array('name' => 'SYSTEM_CURRENCY_TYPE'))->find();
      $datas = unserialize($setting['datas']);

      return($datas[$code]);
    }



/**
 * @functionname: get_curl_contents
 * @author: FrankHong
 * @date: 2016-12-15 17:46:18
 * @description: curl方法
 * @note:
 * @return bool|mixed|string
 * @param $url
 * @param string $method
 * @param array $data
 */
function get_curl_contents($url, $method = 'GET', $data = array())
{
    if ($method == 'POST')
    {
        //使用crul模拟
        $ch = curl_init();
        //禁用https
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        //允许请求以文件流的形式返回
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch); //执行发送
        curl_close($ch);
    }
    else
    {
        if (ini_get('allow_fopen_url') == '1')
        {
            $result = file_get_contents($url);
        }
        else
        {
            //使用crul模拟
            $ch = curl_init();
            //允许请求以文件流的形式返回
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            //禁用https
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_URL, $url);
            $result = curl_exec($ch); //执行发送
            curl_close($ch);
        }
    }

    return $result;
}

    /**
     * 获取用户真实名称
     */
    function getUsername($uid) 
    {
        $personalObj    = M('personal_user_data');
        $userObj        = M('userinfo');

        $persona = $personalObj->where(array('uid' => $uid))->getField('real_name');

       if(!empty($persona)) {
         return  $persona;
       } else {
         $user = $userObj->where(array('uid' => $uid))->getField('username');
         return $user == '' ? '暂无' : $user;
       }
    }


    /**
     * 文件流信息返回
     */
    function post_codeimglist ($requestUrl, $curlPost) {

        $curl = curl_init();
        //设置提交的url  
        curl_setopt($curl, CURLOPT_URL, $requestUrl);
        //设置头文件的信息作为数据流输出  
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。  
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交  
        curl_setopt($curl, CURLOPT_POST, 1);
        //设置post数据
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        //执行命令  
        $data = curl_exec($curl);
        //关闭URL请求  
        curl_close($curl);
        //获得数据并返回  
        $data = explode("&", $data);
        foreach ($data as $key => $val) {

            $arr = explode("=", $val);
            $data[$arr[0]] = $arr[1];
            unset($data[$key]);
        }
        return  $data;
       // echo "<img src='data:image/png;base64," . $data['codeImg'] . "'></img>";
               
    }
    /**
     * [format_date 时间格式化]
     * @param  [int] $time [要转化的时间]
     * @return [string]    [格式话的字符串]
     * @author wang  99052946@qq.com
     */
    function format_date($time){
        $t=time()-$time;  
        $f = array(
            '31536000'=>L('years'),
            '2592000'=>L('month'),
            '604800'=>L('week'),
            '86400'=>L('day'),
            '3600'=>L('hours'),
            '60'=>L('minutes'),
            '1'=>L('seconds')
        );  
        foreach ($f as $k=>$v)    {  
            if (0 !=$c=floor($t/(int)$k)) {  
                return $c.$v.' '.L('before');
            }  
        }  
    }

    /**
     * [isMobile 判断是否为手机登录]
     * @return boole true|false
     */
    function isMobile() 
    {
      // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
      if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
        return true;
      } 
      // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
      if (isset($_SERVER['HTTP_VIA'])) { 
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
      } 
      // 脑残法，判断手机发送的客户端标志,兼容性有待提高。其中'MicroMessenger'是电脑微信
      if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile','MicroMessenger'); 
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
          return true;
        } 
      } 
      // 协议法，因为有可能不准确，放到最后判断
      if (isset ($_SERVER['HTTP_ACCEPT'])) { 
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
          return true;
        } 
      } 
      return false;
    }

    /*
     * 秒数转换日期
     * @param  [int] $secs [要转化的时间戳]
     * @return string 转换成的日期
     * @author wang  99052946@qq.com
     */
    function secsToStr($secs) {
        if($secs>=86400){$days=floor($secs/86400);
            $secs=$secs%86400;
            $r=$days.'日';
        }
        if($secs>=3600){$hours=floor($secs/3600);
            $secs=$secs%3600;
            $r.=$hours.'时';
        }
        if($secs>=60){$minutes=floor($secs/60);
            $secs=$secs%60;
            $r.=$minutes.'分';
        }
        $r.=$secs.'秒';
        return $r;
    }

    /**
     * 简体转化繁体
     *
     * @param string $sContent 要转化的字符串
     * @return string 转化之后得到的字符串
     */
    function simpleTradition($sContent)
    {
        $sd = C('ZH.zh_cn');
        $td = C('ZH.zh_tw');

        $traditionalCN = '';
        $iContent=mb_strlen($sContent,'UTF-8');

        for($i=0;$i<$iContent;$i++) {
            $str=mb_substr($sContent,$i,1,'UTF-8');
            $match=mb_strpos($sd,$str,null,'UTF-8');
            $traditionalCN.=($match!==false )?mb_substr($td,$match,1,'UTF-8'):$str;
        }
        return $traditionalCN;
    }

    /**
     * 繁体转化简体
     *
     * @param string $sContent 要转化的字符串
     * @return string 转化之后得到的字符串
     */
    function tradition2simple($sContent)
    {
        $sd = C('ZH.zh_cn');
        $td = C('ZH.zh_tw');

        $simpleCN = '';
        $iContent=mb_strlen($sContent,'UTF-8');

        for($i=0;$i<$iContent;$i++){
            $str=mb_substr($sContent,$i,1,'UTF-8');
            $match=mb_strpos($td,$str,null,'UTF-8');
            $simpleCN.=($match!==false )?mb_substr($sd,$match,1,'UTF-8'):$str;
        }

        return $simpleCN;
    }
?>


