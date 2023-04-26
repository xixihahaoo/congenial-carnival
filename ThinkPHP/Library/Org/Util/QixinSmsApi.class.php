<?php
/**
 * @author: FrankHong
 * @datetime: 2016-11-19 18:04:43
 * @filename: QixinSmsApi.class.php
 * @description: 启信短信接口   www.ussns.com/Api/index.html
 * @note:
 *
    接口地址：http://www.ussns.com/Api/send
    传参方式：\Post方式
    抛送参数：
    参数       说明           备注
    Uname       用户名           必选
    Upass       用户密码      必选（需MD5加密）
    Mobile      手机号码      必选
    Content     短信内容      必选（每到65字符自动拆分短信，注意带签名）


    数据返回格式：Json格式
        999：错误
        888：成功
        001：账户冻结或密码不正确
        002：账户余额不足
        003：内容字数超过64个字符
        004：平台接口关闭
        005：失败
 */

namespace Org\Util;

class QixinSmsApi
{
    private $qixin_config = array();

    public function __construct($username = '', $password = '')
    {
        $this->qixin_config = array(
            'api_send_url' => 'http://www.ussns.com/Api/send',
            'api_balance_query_url' => 'http://www.ussns.com/Api/',
            'api_account' => $username,
            'api_password' => $password
        );
    }


    /**
     * @functionname: sendSMS
     * @author: FrankHong
     * @date: 2016-11-19 18:08:54
     * @description: 发送验证码
     * @note:
     * @return mixed
     * @param $mobile
     * @param $content
     */
    public function sendSMS($mobile, $content)
    {
        $postArr = array(
            'username' => $this->qixin_config['api_account'],
            'pwd' => $this->qixin_config['api_password'],
            'msg' => urlencode($content),
            'phone' => $mobile
        );

        //$result = $this->normalPost($postArr);

        $result = $this->curlPost($this->qixin_config['api_send_url'], $postArr);
        return $result;
    }


    public function getResult($result,$mobile_verify)
    {
        switch($result)
        {
            case '999':
                $returnMsg  = '错误';
                $returnCode = 0;
                $code = $mobile_verify;
                break;
            case '888':
                $returnMsg  = '成功';
                $returnCode = 1;
                 $code = $mobile_verify;
                break;
            case '001':
                $returnMsg  = '账户冻结或密码不正确';
                $returnCode = 0;
                 $code = $mobile_verify;
                break;
            case '002':
                $returnMsg  = '账户余额不足';
                $returnCode = 0;
                $code = $mobile_verify;
                break;
            case '003':
                $returnMsg  = '内容字数超过64个字符';
                $returnCode = 0;
                $code = $mobile_verify;
                break;
            case '004':
                $returnMsg  = '平台接口关闭';
                $returnCode = 0;
                $code = $mobile_verify;
                break;
            case '005':
                $returnMsg  = '失败';
                $returnCode = 0;
                $code = $mobile_verify;
                break;
        }

        return array('ret_code' => $returnCode, 'ret_msg' => $returnMsg,'code' => $code);
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
     * @functionname: normalPost
     * @author: FrankHong
     * @date: 2016-11-19 18:10:29
     * @description: file_get_contents
     * @note:
     * @return bool|string
     * @param $postData
     */
    private function normalPost($postData)
    {
        header("Content-type:text/html;charset=utf-8");

        $postData1  = http_build_query($postData);
        $options    = array(
            'http'  => array(
                'method'    => 'POST',
                'header'    => 'Content-type:application/x-www-form-urlencoded',
                'content'   => $postData1,
                'timeout'   => 15 * 60      // 超时时间（单位:s）
            )
        );


        $context    = stream_context_create($options);

        $result     = file_get_contents('http://'.$this->qixin_config['api_send_url'], false, $context);

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


}