<?php
/**
 * @author: FrankHong
 * @datetime: 2016/11/8 15:39
 * @filename: QidianSmsApi.class.php
 * @description: 起点短信接口   http://www.96xun.com/Api/index.html
 * @note:
 *
    接口地址：http://open.96xun.com/Api/SendSms
    传参方式：Get / Post方式
    抛送参数：
    参数 	     说明 	      备注
    Uname 	    用户名 	      必选
    Upass 	    用户密码 	  必选（需MD5加密）
    Mobile 	    手机号码 	  必选
    Content 	短信内容 	  必选（每到65字符自动拆分短信，注意带签名）


    数据返回格式：Json格式
    参数 	     说明 	      备注
    Status 	     返回状态 	  1：成功 0：失败
    Msg 	     返回消息 	  例：用户名或密码错误。短信发送成功
 */

namespace Org\Util;

class QidianSmsApi
{
    private $qidian_config  = array();

    public function __construct($username = '', $password = '')
    {
        $this->qidian_config	= array(
            'api_send_url'			=> 'http://open.96xun.com/Api/SendSms',
            'api_balance_query_url'	=> 'http://open.96xun.com/Api/UserDetail',
            'api_account'			=> $username,
            'api_password'			=> md5($password)
        );
    }


    /**
     * @functionname: sendSMS
     * @author: FrankHong
     * @date: 2016-11-08 15:50:09
     * @description: 发送验证码
     * @note:
     * @return mixed
     * @param $mobile
     * @param $content
     */
    public function sendSMS($mobile, $content)
    {
        $postArr = array (
            'Uname'     => $this->qidian_config['api_account'],
            'Upass'     => $this->qidian_config['api_password'],
            'Mobile'    => $mobile,
            'Content'   => $content
        );

        $result = $this->curlPost($this->qidian_config['api_send_url'], $postArr);
        return $result;
    }


    /**
     * @functionname: execResult
     * @author: FrankHong
     * @date: 2016-11-08 15:51:29
     * @description: 处理结果
     * @note:
     * @return array
     * @param $result
     */
    public function execResult($result)
    {
        //$result = preg_split("/[,\r\n]/", $result);
        $result = json_decode($result, true);
        return $result;
    }


    /**
     * @functionname: curlPost
     * @author: FrankHong
     * @date: 2016-11-08 15:51:50
     * @description: curl请求
     * @note:
     * @return mixed
     * @param $url
     * @param $postFields
     */
    private function curlPost($url, $postFields)
    {
        $postFields = http_build_query($postFields);
        $ch         = curl_init ();

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }


//    public function __get()
//    {
//
//    }
//
//
//    public function __set()
//    {
//
//    }
}