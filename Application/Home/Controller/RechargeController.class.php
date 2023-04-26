<?php
namespace Home\Controller;

use Think\Controller;
use Org\Util\Log;


class RechargeController extends CommonController
{

    public function _initialize()
    {
        parent::_initialize();
        self::IsLogin();
        $this->user_id = session('user_id');
    }

    /**
     * 充值中心
     * @author wang <li>
     */
    public function index()
    {
        $accountModel = M('accountinfo');

        $account = $accountModel->field('balance,gold')
                                ->where(['uid' => $this->user_id])
                                ->find();

        //查看资料是否完善
        $personalObj = M('personal_user_data');

        $personal = $personalObj->field('status')
                                ->where(['uid' => $this->user_id])
                                ->find();

        $this->assign('personal', $personal);
        $this->assign('account', $account);
        $this->display();
    }

    /**
     * 设置支付订单号
     */
    private function number()
    {
        return $this->user_id.time().mt_rand(100000, 999999);
    }


    /**
     * recharge 对充值进行处理
     * @author wang li
     */
    public function recharge()
    {
        if (IS_POST) {
            $pay_type = trim(I('post.pay_type'));     //支付方式
            $amount   = trim(I('post.amount'));    //充值金额

            if (empty($amount)) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_cannot_empty'),
                ]);
            }

            if ($amount < 100) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_payment_less'),
                ]);
            }

            if ($amount > 300000000) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_payment_greater'),
                ]);
            }

            if (empty($pay_type)) {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_choose'),
                ]);
            }

            switch ($pay_type) {
                case 'ybQuick':
                    $balanceno        = $this->number();
                    $redirectUrl      = U('YbPay/QuickPreorder');
                    $data['pay_type'] = 1;
                    break;
                case 'T/T':             //电汇入金
                    $balanceno        = $this->number();
                    $redirectUrl      = U('TT/index');
                    $data['pay_type'] = 26;
                    break;
                case 'MYR':             //马来西亚林吉特
                    $balanceno        = $this->number();
                    $redirectUrl      = U('Pay/index');
                    $data['pay_type'] = 28;
                    break;
                case 'EPay':             //易派支付
                    $balanceno        = $this->number();
                    $redirectUrl      = U('EPay/index');
                    $data['pay_type'] = 29;
                    break;
                case 'FunPay':             //FunPay
                    $balanceno        = $this->number();
                    $redirectUrl      = U('FunPay/index');
                    $data['pay_type'] = 30;
                    break;
                default:
                    outjson([
                        'code' => 400,
                        'msg'  => L('api_methond_not'),
                    ]);
            }

            $balance = M('accountinfo')
                ->where('uid='.$this->user_id)
                ->getField('balance');
            $data['bptime']     = time();                       //操作时间
            $data['bpprice']    = $amount;                      //充值金额 美元
            $data['uid']        = $this->user_id;               //用户id
            $data['balanceno']  = $balanceno;                   //订单编号
            $data['shibpprice'] = $balance;                     //用户余额
            $data['status']     = 0;                            //0待处理  1完成
            $res = true;
            if($pay_type != 'MYR'){
                $res = M('balance')->add($data);
            }

            if ($res) {
                $return['code']        = 200;
                $return['balanceno']   = $balanceno;//订单号
                $return['redirectUrl'] = $redirectUrl;
                $return['amount'] = $amount;
                $return['msg']         = L('api_skipping');
                outjson($return);
            }
            else {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_pay_failure'),
                ]);
            }

        }
        else {
            outjson([
                'code' => 400,
                'msg'  => L('api_pay_failure'),
            ]);
        }
    }


    /**
     * [RechargeAgreement 充值协议]
     */
    public function agreement()
    {
        $catagory = M('newsclass')
            ->where('fid=19')
            ->getField('fid');

        $news = M('newsinfo')
            ->field('ntitle,ncontent')
            ->where('ncategory='.$catagory)
            ->where([
                'ncategory' => $catagory,
                'lang'      => LANG_SHOW,
            ])
            ->find();


        $news['ncontent'] = html_entity_decode($news['ncontent']);

        if (LANG == 'zh-tw') {
            $news['ntitle']   = simpleTradition($news['ntitle']);
            $news['ncontent'] = simpleTradition($news['ncontent']);
        }


        $this->assign('news', $news);

        $this->display();
    }


    /**
     * [rechargeDetails 充值记录]
     * @author wang li
     */
    public function rechargeDetails()
    {
        $balanceModel = M('balance');

        $balance = $balanceModel->field('bptime,bpprice,status,pay_type')
                                ->where(['uid' => $this->user_id])
                                ->order('bptime desc')
                                ->select();

        foreach ($balance as $key => $value) {
            $balance[ $key ]['bptime'] = date('y/m/d H:i:s', $value['bptime']);
            if ($value['status'] == '0') {
                $balance[ $key ]['status'] = L('api_pending');
            }
            elseif ($value['status'] == 1) {
                $balance[ $key ]['status'] = L('api_rech_success');
            }
            elseif ($value['status'] == 2) {
                $balance[ $key ]['status'] = L('api_rech_fail');
            }
        }

        $this->assign('list', $balance);
        $this->display();
    }


    //判断是否登录
    private function IsLogin()
    {
        if (empty($this->user_id)) {
            if (IS_AJAX) {
                outjson([
                    'code' => 400,
                    'msg'  => L('no_login'),
                ]);
            }
            else {
                $this->redirect('Login/login');
            }
        }
    }
}
