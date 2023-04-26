<?php
namespace Home\Controller;
use Think\Controller;
use Org\Util\Log;


class YbPayController extends CommonController
{
    //银联快捷 测试
    // const APPID         = 201804159397;                                                                 //appid
    // const KEY           = 'c450fc81d139481f027bf1a47127531b2a190885';                                   //商户key
    
    //人脸快捷 测试
   // const APPID         = 201805178920;                                                                 //appid
    //const KEY           = 'f76182117dd62d7eca1927aae23a369b91bc0303';                                   //商户key

    // const PREORDER_URL  = 'http://t.pay.platform.api.taidupay.com/api/pay/unifiedOrder';                //预下单接口
    // const PAY_URL       = 'http://t.pay.platform.api.taidupay.com/api/pay/UnifiedSubmitQuickPayCode';   //快捷支付接口
    // const SMS_URL       = 'http://t.pay.platform.api.taidupay.com/api/pay/UnifiedResQuickPayCode';      //短信重发接口
    // const QUERY_URL     = 'http://t.pay.platform.api.taidupay.com/api/pay/orderQuery';                  //订单查询接口
    
    // 人脸快捷 正式
    const APPID         = 201805344125;                                                                 //appid
    const KEY           = 'ea78030e2e9beea8d39a555092009ad889db05d4';                                   //商户key

    const PREORDER_URL  = 'http://n.epay.api.taidupay.com/api/pay/unifiedOrder';                //预下单接口
    const PAY_URL       = 'http://n.epay.api.taidupay.com/api/pay/UnifiedSubmitQuickPayCode';   //快捷支付接口
    const SMS_URL       = 'http://n.epay.api.taidupay.com/api/pay/UnifiedResQuickPayCode';      //短信重发接口
    const QUERY_URL     = 'http://n.epay.api.taidupay.com/api/pay/orderQuery';                  //订单查询接口


    public function _initialize(){
        parent::_initialize();

        // 需要跳过登陆验证的路由 by wang 2018-5-19
        $excluded_rotuers = array(
            '/Home/YbPay/notifyurl',
        );

        if(in_array(__ACTION__, $excluded_rotuers))
            return;

        self::IsLogin();
    }

    /**
     * 快捷支付预下单接口
     * @author wang <li>
     */
    public function QuickPreorder()
    {   
        if(IS_POST)
        {   
            $balanceObj = M('balance');
            $bankObj    = M('bankinfo');

            $balanceno  = trim(I('post.balanceno')); 

            if(empty($balanceno))
                outjson(array('code' => 400,'msg' => '订单号不能为空'));

            $balance = $balanceObj->where(array('uid' => $this->user_id,'balanceno' => $balanceno,'status' => 0))->find();

            if(!$balance)
                outjson(array('code' => 400,'msg' => '订单不存在'));


            $bid        = trim(I('post.bid'));

            if(!empty($bid))
            {
                $bank = $bankObj->where(array('bid' => $bid,'status' => 1,'uid' => $this->user_id))->find();

                $busername  = $bank['busername'];
                $banknumber = $bank['banknumber'];
                $tel        = $bank['tel'];
                $card       = $bank['card'];
            } else {
                $busername  = trim(I('post.busername'));
                $banknumber = trim(I('post.banknumber'));
                $tel        = trim(I('post.tel'));
                $card       = trim(I('post.card'));

                if(empty($busername))
                    outjson(array('code' => 400,'msg' => '请填写持卡人姓名'));

                if(empty($tel))
                    outjson(array('code' => 400,'msg' => '请填写银行预留手机号'));

                if(empty($banknumber))
                    outjson(array('code' => 400,'msg' => '请填写持卡人银行卡号'));
                
                if(empty($card))
                    outjson(array('code' => 400,'msg' => '请填写持卡人身份信息'));
            }

            $dataArr = array(
                'appId'             => self::APPID,                 //商户应用标识
                'timestamp'         => time(),                      //请求时间戳
                'nonce'             => generate_code(12),           //请求随机数
                'service'           => 'quick.facepay',             //商户请求服务    API快捷：quick.depositCard 刷脸快捷：quick.facepay
                'orderNo'           => $balanceno,                  //商户请求流水号
                'totalAmount'       => $balance['bpprice_cny']*100, //金额
                'clientIp'          => get_client_ip(),             //客户端IP
                'callbackUrl'       => U('Home/YbPay/facePay', array('balanceno' => $balanceno), true, true),
                'notifyUrl'         => U('Home/YbPay/notifyUrl', '', true, true),//回调地址
                'body'              => urlencode('在线支付'),       //商品描述
                'cardType'          => 0,                           //银行卡类型 0 储蓄卡
                'quickCustomerName' => $busername,                  //持卡人姓名
                'quickAcctNo'       => $banknumber,                 //银行卡号
                'quickPhoneNumber'  => $tel,                        //银行卡绑定手机号
                'quickCerdId'       => $card,                       //持卡人身份证号
            );

            $dataArr['sign'] = $this->signMd5($dataArr);

            $data = $this->curlPost(json_encode($dataArr),self::PREORDER_URL);
            Log::debugArr($data, 'yuxiadan');
            if($data['success'] == true && !empty($data['orderNo']))
            {
                $data = array('platformOrderNo' => $data['platformOrderNo'],'balanceno' => $balanceno,'busername' => $busername,'tel' => $tel,'banknumber' => $banknumber);

                outjson(array('code' => 200,'msg' => '提交成功','data' => $data));
            } else {
                $data['errorMsg'] = empty($data['errorMsg']) ? '服务器无响应,请稍后再试' : $data['errorMsg'];
                outjson(array('code' => 400,'msg' => $data['errorMsg']));
            }

        } else {
            $data['balanceno']  = trim(I('get.balanceno'));

            $bankObj    = M('bankinfo');
            $bankinfo   = $bankObj->field('bid,banknumber,bankname')->where(array('uid' => $this->user_id,'status' => 1))->select();

            if($bankinfo)
            {
                foreach ($bankinfo as $key => $value) {
                    $bankinfo[$key]['bankMsg'] = $value['bankname'].'('.substr($value['banknumber'], strlen($value['banknumber'])-4).')';
                }
                $this->assign('bankinfo',$bankinfo);

                $this->assign('data',$data);
                $this->display('quickpreorder');
            } else {
                $this->assign('data',$data);
                $this->display('inputpreorder');
            }
        }
    }

    /**
     * 手动输入预下单
     */
    public function manualPreorder()
    {
        $data['balanceno']  = trim(I('get.balanceno'));
        $this->assign('data',$data);
        $this->display('inputpreorder');
    }


    /**
     * 快捷支付接口
     * @author wang li
     */
    public function Quickpay()
    {
        if(IS_POST)
        {   
            $platformOrderNo    = trim(I('post.platformOrderNo'));
            $balanceno          = trim(I('post.balanceno'));
            $checkCode          = trim(I('post.checkCode'));
            $tel                = trim(I('post.tel'));

            if(empty($platformOrderNo))
                outjson(array('code' => 400,'msg' => '错误，没有平台单号'));

            if(empty($balanceno))
                outjson(array('code' => 400,'msg' => '订单号不能为空'));

            if(empty($checkCode))
                outjson(array('code' => 400,'msg' => '验证码不能为空'));

            if(empty($tel))
                outjson(array('code' => 400,'msg' => '手机号不能为空'));


            $balance    = M('balance')->where(array('balanceno' => $balanceno))->find();

            if(!$balance)
                outjson(array('code' => 400,'msg' => '订单不存在'));
            else if($balance['status'] == 1)
                outjson(array('code' => 400,'msg' => '该订单已经充值'));


            $dataArr = array(
                'appId'             => self::APPID,         //商户应用标识
                'timestamp'         => time(),              //请求时间戳
                'nonce'             => generate_code(12),   //随机数
                'platformOrderNo'   => $platformOrderNo,    //订单号
                'checkCode'         => $checkCode,          //短信验证码
                'mobileNo'          => $tel,                //手机号码
                'action'            => 'confirm_order'
            );

            $dataArr['sign'] = $this->signMd5($dataArr);

            $data = $this->curlPost(json_encode($dataArr),self::PAY_URL);

            if($data['success'] == true)
            {
                if(!empty($data['payInfo'])){
                    $redirectUrl                = $data['payInfo'];
                    $data['bpprice_cny']        = $balance['bpprice_cny'];
                    $data['tel']                = $tel;
                    $data['platformOrderNo']    = $platformOrderNo;
                    S($balanceno,$data,600);    //对返回的信息进行缓存处理

                    //插入订单
                    M('temp_yb_pay')->add(array('balanceno' => $balanceno,'platformTradeNo' => $platformOrderNo,'create_time' => time()));

                }
                else {
                    $redirectUrl = U('Home/Recharge/index', '', true, true);
                }

                outjson(array('code' => 200,'msg' => $data['errorMsg'],'redirectUrl' => $redirectUrl));
            } else {
                $data['errorMsg'] = empty($data['errorMsg']) ? '服务器无响应,请稍后再试' : $data['errorMsg'];
                outjson(array('code' => 400,'msg' => $data['errorMsg']));
            }

        } else {

            $balanceno  = trim(I('get.balanceno'));

            $data['platformOrderNo']    = trim(I('get.platformOrderNo'));
            $data['tel']                = trim(I('get.tel'));
            $data['busername']          = trim(I('get.busername'));
            $data['banknumber']         = trim(I('get.banknumber'));

            $balance    = M('balance')->where(array('balanceno' => $balanceno))->find();

            if(!$balance)
                $this->error('订单不存在');
            else if($balance['status'] == 1)
                $this->error('该订单已经充值');

            $this->assign('data',$data);
            $this->assign('balance',$balance);
            $this->display();
        }
    }

    //人脸验证接口
    public function facePay()
    {   
        $balanceno  = trim(I('get.balanceno'));
        $data       = S($balanceno);
        $data['balanceno'] = $balanceno;

        $this->assign('data',$data);
        $this->display();
    }

    //人脸验证提交
    public function facePaySbumit()
    {
        if(IS_POST)
        {
            $balanceno          = trim(I('post.balanceno'));
            $checkCode          = trim(I('post.checkCode'));

            if(empty($balanceno))
                outjson(array('code' => 400,'msg' => '订单号不能为空'));

            if(empty($checkCode))
                outjson(array('code' => 400,'msg' => 'authKey不能为空'));

            $dataS = S($balanceno);

            if(empty($dataS))
                outjson(array('code' => 400,'msg' => '充值遇到了错误，请稍后再试'));

            $balance    = M('balance')->where(array('balanceno' => $balanceno))->find();

            if(!$balance)
                outjson(array('code' => 400,'msg' => '订单不存在'));
            else if($balance['status'] == 1)
                outjson(array('code' => 400,'msg' => '该订单已经充值'));

            $dataArr = array(
                'appId'             => self::APPID,                 //商户应用标识
                'timestamp'         => time(),                      //请求时间戳
                'nonce'             => generate_code(12),           //随机数
                'platformOrderNo'   => $dataS['platformOrderNo'],    //订单号
                'checkCode'         => $checkCode,                  //短信验证码
                'mobileNo'          => $dataS['tel'],                //手机号码
                'action'            => 'confirm_face'
            );

            $dataArr['sign'] = $this->signMd5($dataArr);

            $data = $this->curlPost(json_encode($dataArr),self::PAY_URL);

            if($data['success'] == true)
            {
                $redirectUrl = U('Home/Recharge/index', '', true, true);
                outjson(array('code' => 200,'msg' => $data['errorMsg'],'redirectUrl' => $redirectUrl));
            } else {
                $data['errorMsg'] = empty($data['errorMsg']) ? '服务器无响应,请稍后再试' : $data['errorMsg'];
                outjson(array('code' => 400,'msg' => $data['errorMsg']));
            }
        } else {
            outjson(array('code' => 400,'msg' => '非法提交'));
        }
    }




    //短信重发接口
    public function sms()
    {
        $dataArr = array(
            'appId'             => self::APPID,         //商户应用标识
            'timestamp'         => time(),              //请求时间戳
            'nonce'             => generate_code(12),   //随机数
            'platformOrderNo'   => $platformOrderNo,    //订单号
        );

        $dataArr['sign'] = $this->signMd5($dataArr);

        $res = $this->curlPost(json_encode($dataArr),self::SMS_URL);

        vD($res);
    }

    //异步通知接口
    public function notifyUrl()
    {
        $data = file_get_contents('php://input', 'r');

        $data = json_decode($data, true);

        Log::debugArr($data, 'ybpayNotify');

        $sign = $data['sign'];

        unset($data['sign']);
        unset($data['outBankTradeOrderNo']);
        unset($data['bankType']);

        $md5 = $this->signMd5($data);

        if($sign == $md5 && $data['status'] == 3){

            $balanceObj = M('balance');
            $accountObj = M('accountinfo');

            $balanceData = $balanceObj->where(array('balanceno' => $data['orderNo']))->find();

            $bpprice_cny    = $data['totalAmount'] / 100;

            if(!$balanceData)
            {
                die('fail');
            } else {
                if($balanceData['status'] == 1)
                    die('success');
                if($balanceData['bpprice_cny'] != $bpprice_cny)
                    die('fail');
            }

            $accountObj->startTrans();

            //获取充值对应利率
            $sysData    = get_setting_config('find', 'SYSTEM_DOLLAR_SETTING');
            $rate       = $sysData['datas']['data'][0]['value'];  //美元兑人民币汇率
            
            $order_amount = round($bpprice_cny/$rate,2); 

            $balance['bpprice']     = $order_amount;
            $balance['status']      = 1;
            $balance['cltime']      = time();
            $balance['shibpprice']  = $balanceData['shibpprice'] + $balance['bpprice'];

            $balanceRes = $balanceObj->where(array('balanceno' => $data['orderNo'],'uid' => $balanceData['uid']))->save($balance);
            if($balanceRes) {

                $accountArr = array(
                    'balance'           => array('exp', '`balance`+'.$order_amount.''),
                    'recharge_total'    => array('exp', '`recharge_total`+'.$order_amount.''),
                );

                $moneyRes = $accountObj->where(array('uid' => $balanceData['uid']))->save($accountArr);
            }

            if($balanceRes && $moneyRes)
            {
                $map['uid']         = $balanceData['uid'];
                $map['type']        = 4;
                $map['oid']         = $balanceData['bpid'];
                $map['note']        = '在线充值金额[' . $order_amount . ']美元';
                $map['balance']     = $accountObj->where(array('uid' => $balanceData['uid']))->sum('balance');
                $map['op_id']       = $balanceData['uid'];
                $map['user_type']   = 1;
                $map['dateline']    = time();
                M("money_flow")->add($map);

                $accountObj->commit();
                die('success');
            } else {
                $accountObj->rollback();
                die('fail');
            }
        }else{
            die('fail');
        }
    }


    //支付查询接口
    public function payQuery()
    {   
        $oid = trim(I('post.oid'));

        if(empty($oid))
            outjson(array('code' => 400,'msg' => '订单号不能为空'));

        $platformTradeNo = M('temp_yb_pay')->where()->getField('platformTradeNo');

        $dataArr = array(
            'appId'             => self::APPID,                 //商户应用标识
            'timestamp'         => time(),                      //请求时间戳
            'nonce'             => generate_code(12),           //随机数
            'platformTradeNo'   => '2018051917084400000000004643'//$platformTradeNo,         //订单号
        );

        $dataArr['sign'] = $this->signMd5($dataArr);

        $data = $this->curlPost(json_encode($dataArr),self::QUERY_URL);

        if($data['status'] == true)
        {
            $sign = $data['sign'];

            unset($data['sign']);
            unset($data['outBankTradeOrderNo']);
            unset($data['bankType']);

            $md5 = $this->signMd5($data);

            if($sign == $md5 && $data['status'] == 3){

                $balanceObj = M('balance');
                $accountObj = M('accountinfo');

                $balanceData = $balanceObj->where(array('balanceno' => $data['orderNo']))->find();

                $bpprice_cny    = $data['totalAmount'] / 100;

                if(!$balanceData)
                {
                    outjson(array('code' => 400,'msg' => '订单号不存在'));
                } else {
                    if($balanceData['status'] == 1)
                        outjson(array('code' => 400,'msg' => '订单已经充值了'));
                    if($balanceData['bpprice_cny'] != $bpprice_cny)
                        outjson(array('code' => 400,'msg' => '金额对不不正确'));
                }

                $accountObj->startTrans();

                //获取充值对应利率
                $sysData    = get_setting_config('find', 'SYSTEM_DOLLAR_SETTING');
                $rate       = $sysData['datas']['data'][0]['value'];  //美元兑人民币汇率
                
                $order_amount = round($bpprice_cny/$rate,2);

                $balance['bpprice']     = $order_amount;
                $balance['status']      = 1;
                $balance['cltime']      = time();
                $balance['shibpprice']  = $balanceData['shibpprice'] + $balance['bpprice'];

                $balanceRes = $balanceObj->where(array('balanceno' => $data['orderNo'],'uid' => $balanceData['uid']))->save($balance);
                if($balanceRes) {

                    $accountArr = array(
                        'balance'           => array('exp', '`balance`+'.$order_amount.''),
                        'recharge_total'    => array('exp', '`recharge_total`+'.$order_amount.''),
                    );

                    $moneyRes = $accountObj->where(array('uid' => $balanceData['uid']))->save($accountArr);
                }

                if($balanceRes && $moneyRes)
                {
                    $map['uid']         = $balanceData['uid'];
                    $map['type']        = 4;
                    $map['oid']         = $balanceData['bpid'];
                    $map['note']        = '在线充值金额[' . $order_amount . ']美元';
                    $map['balance']     = $accountObj->where(array('uid' => $balanceData['uid']))->sum('balance');
                    $map['op_id']       = $balanceData['uid'];
                    $map['user_type']   = 1;
                    $map['dateline']    = time();
                    M("money_flow")->add($map);

                    // $this->firstRecharge(); //对首次入金的用户增加20积分

                    $accountObj->commit();
                    outjson(array('code' => 200,'msg' => '验证成功'));
                } else {
                    $accountObj->rollback();
                    outjson(array('code' => 400,'msg' => '验证失败'));
                }
	        } else {
	            $data['errorMsg'] = empty($data['errorMsg']) ? '服务器无响应,请稍后再试' : $data['errorMsg'];
	            outjson(array('code' => 400,'msg' => $data['errorMsg']));
	        }
    	}
	}




    //md5签名运算
    private function signMd5($dataArr)
    {
        ksort($dataArr);

        $str = '';

        foreach ($dataArr as $key => $value) {
            $str.= $key.'='.$value.'&';
        }

        $str = $str.'key='.self::KEY;

        return strtoupper(md5($str));
    }

    //请求头使用json post方式发送数据
    private function curlPost($data,$url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept-Charset: utf-8',
            'Content-Type: application/json'
        )
        );

        $errorno    = curl_errno($ch);
        $info       = curl_exec($ch);
        $infoArr    = json_decode($info,true);

        curl_close($ch);
        return $infoArr;
    }


    //判断是否登录
    private function IsLogin()
    {
        if(empty($this->user_id))
        {
            if(IS_AJAX)
                outjson(array('code' => 400,'msg' =>'请先登录'));
            else
                $this->redirect('Login/login');
        }
    }



}
