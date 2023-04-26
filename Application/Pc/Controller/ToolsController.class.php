<?php
/**
 * @author     : FrankHong
 * @datetime   : 2016/11/8 15:07
 * @filename   : ToolsController.class.php
 * @description: 代码样例
 * @note       :
 * 1.手机验证码使用样例
 *
 */

namespace Pc\Controller;

use Think\Controller;

class ToolsController extends Controller
{
    const HOST      = "smtp.yunyou.top";       //邮箱的服务器地址
    const PORT      = 465;                 //服务器端口号
    const IS_SSL    = true;                //是否使用ssl加密方式登录鉴权
    const USER_NAME = "reg@kmforex.com";  //smtp登录的账号
    const PWD       = 'zgl123';  //smtp登录的密码
    const FROM      = 'reg@kmforex.com';  //发件人邮箱地址

    /**
     * @functionname: 获取手机验证码 起点接口
     * @author      : FrankHong
     * @date        : 2016-11-08 15:09:33
     * @description : 获取手机验证码 起点接口
     * @note        :
     * @return array
     * @param string $mobile           手机号
     * @param int    $mobile_code_time 手机验证码有效期，默认2*60
     */
    public function get_mobile_code($mobile = '', $mobile_code_time = 2)
    {

        if (empty($mobile)) {
            return [
                'ret_code' => 400,
                'ret_msg'  => '手机号不能为空',
            ];
        }

        if (!preg_match('/^(13[0-9]|15[012356789]|1[78][0-9]|14[57])[0-9]{8}$/', $mobile)) {
            return [
                'ret_code' => 400,
                'ret_msg'  => '手机号格式错误',
            ];
        }

        //一分钟内不能重复获取
        if (time() - session('mobile_code_time') < 60 * 1) {
            return [
                'ret_code' => 400,
                'ret_msg'  => '您获取验证码太频繁了，请稍后再获取！',
            ];
        }

        //判断该手机号码是否还在有效期内, 120s
        if (($mobile == session('mobiles')) && (time() - session('mobile_code_time') < 60 * $mobile_code_time)) {
            return [
                'ret_code' => 400,
                'ret_msg'  => '该号码在2分钟内已经获取过验证码，可继续使用！',
            ];
        }

        //获取平台名称
        $webname = M('webconfig')->getField('webname');

        $res = sms_qidian_send_code($mobile, $webname);

        if ($res['ret_code'] == 1) {
            session('mobile_code', $res['ret_msg']);
            session('mobile_code_time', time());
            session('mobiles', $mobile);

            $mObj   = M();
            $addArr = [
                'mobile'      => $mobile,
                'mobile_code' => $res['ret_msg'],
                'type'        => 1,
            ];
            $mObj->table('log_mobile_code')
                 ->add($addArr);

            return [
                'ret_code' => 200,
                'ret_msg'  => '短信发送成功',
            ];
        }
        else {
            return [
                'ret_code' => 400,
                'ret_msg'  => $res['ret_msg'],
            ];
        }
    }

    /**
     * 短信验证码 注册用户
     * @author wang <li>
     */
    public function smsverify()
    {

        $mobile = I('get.mobile');  //手机号

        if (empty($mobile)) {
            outjson([
                'ret_code' => 400,
                'ret_msg'  => '请输入手机号',
            ]);
        }

        if (!preg_match('/^1\d{10}$/', $mobile)) {
            outjson([
                'ret_code' => 400,
                'ret_msg'  => '手机号填写错误',
            ]);
        }

        $map['utel']    = $mobile;
        $map['ustatus'] = [
            'in',
            '0,1',
        ];  //没有被删除的用户
        $map['otype']   = 4;

        $user = M('userinfo')
            ->where($map)
            ->find();
        if ($user) {
            outjson([
                'ret_code' => 400,
                'ret_msg'  => '该手机号码已经被注册了',
            ]);
        }

        $res = $this->get_mobile_code($mobile);

        outjson($res);
    }

    /**
     * 短信验证码 忘记密码
     * @author wang <li>
     */
    public function outpwd_smsverify()
    {

        $mobile = trim(I('get.mobile'));

        if (empty($mobile)) {
            outjson([
                'ret_code' => 400,
                'ret_msg'  => '请输入手机号',
            ]);
        }

        if (!preg_match('/^1\d{10}$/', $mobile)) {
            outjson([
                'ret_code' => 400,
                'ret_msg'  => '手机号填写错误',
            ]);
        }

        $map['utel']    = $mobile;
        $map['ustatus'] = [
            'in',
            '0,1',
        ];
        $map['otype']   = 4;

        $info = M("userinfo")
            ->where($map)
            ->find();

        if (!$info) {
            outjson([
                'ret_code' => 400,
                'ret_msg'  => '系统未查到此号码',
            ]);
        }
        else {

            if ($info['ustatus'] == 1) {
                outjson([
                    'ret_code' => 400,
                    'ret_msg'  => '该账户被冻结了',
                ]);
            }
            else {
                $res = $this->get_mobile_code($mobile);
                outjson($res);
            }
        }
    }

    /**
     * 邮箱验证 注册用户
     * @author 王海东
     * @date
     * @return void
     */
    public function emailVerify()
    {
        $email = trim(I('get.email'));

        if (empty($email)) {
            outjson([
                'ret_code' => 400,
                'ret_msg'  => L('api_mailbox_cannot'),
            ]);
        }

        $map['email']   = $email;
        $map['ustatus'] = [
            'in',
            '0,1',
        ];  //没有被删除的用户
        $map['otype']   = 4;

        $user = M('userinfo')
            ->where($map)
            ->find();
        if ($user) {
            outjson([
                'ret_code' => 400,
                'ret_msg'  => L('api_mailbox_has'),
            ]);
        }

        $code    = get_six_num();
        $title   = L('api_code');
        $contnet = L('api_your_code').'【'.$code.'】'.L('api_effective');

        $res = $this->sendEmail($email, $title, $contnet, $code);

        if($res['ret_code'] == 200) {
            session('email_code', $code);
        }

        outjson($res);
    }

    /**
     * 邮箱验证 找回密码
     * @author 王海东
     * @date
     * @return void
     * @throws \Exception
     */
    public function outpwd_emailverify()
    {
        $email = trim(I('get.email'));

        if (empty($email)) {
            outjson([
                'ret_code' => 400,
                'ret_msg'  => L('api_mailbox_cannot'),
            ]);
        }

        $map['email']   = $email;
        $map['ustatus'] = [
            'in',
            '0,1',
        ];
        $map['otype']   = 4;

        $user = M('userinfo')
            ->where($map)
            ->find();

        if (!$user) {
            outjson([
                'ret_code' => 400,
                'ret_msg'  => L('api_account_not'),
            ]);
        }

        if ($user['ustatus'] == 1) {
            outjson([
                'ret_code' => 400,
                'ret_msg'  => L('api_account_frozen'),
            ]);
        }

        $code    = get_six_num();
        $title   = L('api_code');
        $contnet = L('api_your_code').'【'.$code.'】'.L('api_effective');

        $res = $this->sendEmail($email, $title, $contnet, $code);

        if($res['ret_code'] == 200) {
            session('pwd_email_code', $code);
        }

        outjson($res);
    }


    /**
     * 发送邮件
     * @author 王海东
     * @date
     * @param        $email         邮箱
     * @param        $title         邮箱标题
     * @param string $content       邮箱内容
     * @param        $code          验证码
     * @param int    $email_time    有效时间
     * @param null   $attachment    附件文件完整路径,支持多个
     * @return array
     * @throws \Exception
     */
    public function sendEmail($email, $title, $content = '', $code, $email_time = 2, $attachment = null)
    {
        if (empty($email)) {
            return [
                'ret_code' => 400,
                'ret_msg'  => L('api_mailbox_cannot'),
            ];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'ret_code' => 400,
                'ret_msg'  => L('api_mailbox_error'),
            ];
        }

        //一分钟内不能重复获取
        if (time() - session('email_code_time') < 60 * $email_time) {
            return [
                'ret_code' => 400,
                'ret_msg'  => L('api_code_frequently'),
            ];
        }

        //判断该手机号码是否还在有效期内, 120s
        if (($email == session('email')) && (time() - session('email_code_time') < 60 * $email_time)) {
            return [
                'ret_code' => 400,
                'ret_msg'  => L('api_code_continue_use'),
            ];
        }

        $from_name = M('webconfig')->getField('webname');

        //实例化PHPMailer核心类
        vendor('PHPMailer.PHPMailer');

        $mail = new \PHPMailer();

        //是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
        $mail->SMTPDebug = 0;

        //使用smtp鉴权方式发送邮件
        $mail->isSMTP();

        //smtp需要鉴权 这个必须是true
        $mail->SMTPAuth = true;

        //链接qq域名邮箱的服务器地址
        $mail->Host = self::HOST;

        //设置使用ssl加密方式登录鉴权
        if (self::IS_SSL) {
            $mail->SMTPSecure = 'ssl';
        }

        //设置ssl连接smtp服务器的远程服务器端口号，以前的默认是25，但是现在新的好像已经不可用了 可选465或587
        $mail->Port = self::PORT;

        //设置smtp的helo消息头 这个可有可无 内容任意
        // $mail->Helo = 'Hello smtp.qq.com Server';

        //设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名
        //$mail->Hostname = 'http://www.lsgogroup.com';

        //设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
        $mail->CharSet = 'UTF-8';

        //设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
        $mail->FromName = $from_name;

        //smtp登录的账号 这里填入字符串格式的qq号即可
        $mail->Username = self::USER_NAME;

        //smtp登录的密码 使用生成的授权码（就刚才叫你保存的最新的授权码）
        $mail->Password = self::PWD;

        //设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
        $mail->From = self::FROM;

        //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
        $mail->isHTML(true);

        //设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
        if (is_array($email)) {
            foreach ($email as $v) {
                $mail->addAddress($v);
            }
        }
        else {
            $mail->addAddress($email);
        }

        //添加该邮件的主题
        $mail->Subject = $title;

        //添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
        $mail->Body = $content;

        //为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
        if (is_array($attachment)) {
            foreach ($attachment as $v) {
                $mail->addAttachment($v);
            }
        }
        elseif (is_string($attachment)) {
            $mail->addAttachment($attachment);
        }

        try {
            $status = $mail->send();
        } catch (\Exception $e) {
            //$this->error($e->getMessage());
            //throw new \Exception($e->getMessage(),$e->getCode());
        }

        if (!$status) {
            //            throw new \Exception("邮件发送失败:".$mail->ErrorInfo);
            return [
                'ret_code' => 400,
                'ret_msg'  => L('api_fail'),
            ];
        }

        session('email_code_time', time());
        session('email', $email);

        return [
            'ret_code' => 200,
            'ret_msg'  => L('api_success'),
        ];
    }
}