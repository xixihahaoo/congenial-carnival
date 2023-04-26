<?php
/**
 * @author: FrankHong
 * @datetime: 2016/12/2 20:36
 * @filename: OrderfController.class.php
 * @description: 运营中心出入金模块
 * @note: 
 * 
 */

namespace Ucenter\Controller;

use Think\Controller;
use Org\Util\ShouxinyiYinlian;

class BalancefController extends CommonController
{
    /**
     * @description: 生成订单号最后的标识
     * @note:
     * @return string
     */
    
    private function number_syx()
    {
        return substr(time(), 7, 4).mt_rand(1, 999);
    }


    public function recharge()
    {
        $uid = NOW_UID;
        $account   = M('accountinfo');
        
        $accountinfo = $account->where(array('uid' => $uid))->find();
        $this->assign('info',$accountinfo);
        $this->display();
    }

    /**
     * 选择支付方式
     */
    public function recharge_pay()
    {
            $data = array();
            $paytype = trim(I('post.paytype'));  
            $money   = trim(I('post.money'));

            if(trim($money) == ''){
               $data['status'] = 0;
               $data['msg']    = '支付金额不能为空';
                outjson($data);
            }

            if(trim($paytype) == ''){
               $data['status'] = 0;
               $data['msg']    = '请选择支付方式';
                outjson($data);
            }

            $info = M('accountinfo')->where(array('uid' => NOW_UID))->find();
            $uid = $info['uid'];
            if(!$uid)
            {
                $map['uid'] = NOW_UID;
                $uid = M('accountinfo')->add($map);
            }

            switch($paytype)
            {
                case 'wxpay_syx':
                    $randN  = $this->number_syx();   //订单号
                    $v_ymd  = date('Ymd'); //订单产生日期，要求订单日期格式yyyymmdd.
                    $v_mid  = "10704";    //商户编号，和首信签约后获得,测试的商户编号444

                    $num  = $v_ymd .'-' . $v_mid . '-' .$randN;
                    $redirectUrl      = U('Home/Paysxy/pay_sxy');
                    $data['pay_type']   = 2;
                    break;

                case 'wxpay_syx_yl':
                    $randN  = $this->number_syx();   //订单号
                    $v_ymd  = date('Ymd'); //订单产生日期，要求订单日期格式yyyymmdd.
                    $v_mid  = "10704";    //商户编号，和首信签约后获得,测试的商户编号444

                    $num  = $v_ymd .'-' . $v_mid . '-' .$randN;
                    $redirectUrl      = U('Home/Paysxy/pay_sxy_yinlian');
                    $data['pay_type']   = 3;
                    break;
            }


            $data['bptype']     = '充值';
            $data['remarks']    = '运营中心充值';
            $data['bptime']     = time();               //操作时间
            $data['bpprice']    = $money;               //充值金额
            $data['uid']        = $uid;                //用户id
            $data['isverified'] = 0;                    //0未通过
            $data['balanceno']  = $num;                 //订单编号
            $data['shibpprice'] = M('accountinfo')->where(array('uid' => $uid))->sum('balance');  //用户余额
            $data['b_type']     = 1;                    //流水类型，1充值，2提现
            $data['status']     = 0;                    //0待处理  1完成

            $res = M('balance')->add($data);

           if($res){

                $return['status']   = 1;
                $return['paytype']  = trim($paytype);           //支付类型
                $return['amount']   = trim($money);            //支付金额
                $return['ordernum'] = trim($data['balanceno']);//订单号
                $return['redirectUrl']  = $redirectUrl;
                $return['msg']      = '正在跳转支付页面';
               outjson($return);
           }
    }



    /****************提现*****************/

    public function withdrawals()
    {
        $uid = NOW_UID;
        $account   = M('accountinfo a');
        $userinfo  = M('userinfo');
        
        $field = 'a.*,b.banknumber';
        $accountinfo = $account->field($field)->join('left join wp_bankinfo as b on a.uid = b.uid')->where(array('a.uid' => $uid))->find();
        
        $accountinfo['gold_balance'] = ($accountinfo['balance'] - $accountinfo['gold_threshold']);
        $accountinfo['gold_balance'] = $accountinfo['balance'] <= $accountinfo['gold_threshold'] ? '0' : $accountinfo['gold_balance'];

        $this->assign('info',$accountinfo);
        $this->display();
    }

    /**
     * 用户银行卡信息
     */
    public function edit_bank()
    {
        $uid  = trim(I('get.uid'));
        $bank = M('bankinfo a');
        $field = 'a.*,b.name';
        $bankinfo = $bank->field($field)->join('inner join wp_city as b on a.city = b.id')->where(array('a.uid' => $uid))->find();
        $this->assign('bankinfo',$bankinfo);

        $city = M('city')->where(array('level' => 1))->select();
        $this->assign('city',$city);
        $this->assign('uid',$uid);
        $this->display();
    }

    /**
     * 省市联动
     * @author wang <li>
     */
    public function city(){
         if(IS_AJAX) {
             $id = I('post.id');
             $city = M('city')->where(array('parent_id' => $id))->select();
             if(!$city) {
                    $this->ajaxReturn('不存在','JSON');
             } else {
                    $this->ajaxReturn($city,'JSON');
             }
        } else {
             $this->ajaxReturn('程序异常','JSON');
        }
    }

    /**
     * 绑定银行卡或实名认证
     * @author wang <li>
     */
    public function binding(){

        $data = array();

        if (IS_AJAX) {

                $uid          = trim(I('post.uid'));
                $j_name       = trim(I('post.j_name'));  //姓名
                $Card         = trim(I('post.Card'));   // 身份证号码
                $j_bankPhone  = trim(I('post.j_bankPhone')); //银行预留手机号
                $bankName     = trim(I('post.bankName'));  //银行名称
                $province     = trim(I('post.province'));  //开户所在省
                $city         = trim(I('post.city'));  //开户所在市
                $branch       = trim(I('post.branch'));    //支行名称
                $j_bankNo     = trim(I('post.j_bankNo'));  //银行卡号码
                $j_bankNoNote = trim(I('post.j_bankNoNote'));  //再次确认银行卡号码
                
                if (empty($j_name)) {
                    $data['status'] = 0;
                    $data['msg'] = '持卡人不能为空';
                    $this->ajaxReturn($data, 'JSON');
                }

                if (is_numeric($j_name) || mb_strlen($j_name) > 15) {
                    $data['status'] = 0;
                    $data['msg'] = '持卡人填写不正确';
                    $this->ajaxReturn($data, 'JSON');
                }
                
                if(empty($Card)) {

                    $data['status'] = 0;
                    $data['msg'] = '身份证号码不能为空';
                    $this->ajaxReturn($data, 'JSON');
                }

               if(!preg_match("/(^\d{15}$)|(^\d{17}([0-9]|X)$)/",$Card)) {

                    $data['status'] = 0;
                    $data['msg'] = '身份证号码填写不正确';
                    $this->ajaxReturn($data, 'JSON');
                }

                if (empty($j_bankPhone)) {
                    $data['status'] = 0;
                    $data['msg'] = '银行预留手机号不能为空';
                    $this->ajaxReturn($data, 'JSON');
                }

                if (!preg_match('/^1\d{10}$/', $j_bankPhone)) {
                    $data['status'] = 0;
                    $data['msg'] = '手机号填写错误';
                    $data['tel'] = $j_bankPhone;
                    $this->ajaxReturn($data, 'JSON');
                }

                if (empty($bankName)) {

                    $data['status'] = 0;
                    $data['msg'] = '银行名称不能为空';
                    $this->ajaxReturn($data, 'JSON');
                }

                if (empty($province)) {

                    $data['status'] = 0;
                    $data['msg'] = '请填写开户所在省';
                    $this->ajaxReturn($data, 'JSON');
                }

                if (empty($city)) {

                    $data['status'] = 0;
                    $data['msg'] = '请填写开户所在市';
                    $this->ajaxReturn($data, 'JSON');
                }

                if (empty($branch)) {
                    $data['status'] = 0;
                    $data['msg'] = '支行名称不能为空';
                    $this->ajaxReturn($data, 'JSON');
                }

                if (empty($j_bankNo) || empty($j_bankNoNote)) {
                    $data['status'] = 0;
                    $data['msg'] = '银行卡号不能为空';
                    $this->ajaxReturn($data, 'JSON');
                }

                if (!is_numeric($j_bankNo) || !is_numeric($j_bankNoNote)) {
                    $data['status'] = 0;
                    $data['msg'] = '银行卡号填写不正确';
                    $this->ajaxReturn($data, 'JSON');
                }

                if($j_bankNo != $j_bankNoNote) {
                    $data['status'] = 0;
                    $data['msg'] = '银行卡号填写不一致';
                    $this->ajaxReturn($data, 'JSON');
                }


                $data['uid']        = $uid;
                $data['busername']  = $j_name;
                $data['bankname']   = $bankName;
                $data['banknumber'] = $j_bankNo;
                $data['branch']     = $branch;
                $data['tel']        = $j_bankPhone;
                $data['card']       = $Card;
                $data['province']   = $province;
                $data['city']       = $city;
                $data['status']     = 1;
                $data['user_type']  = 2;
                $data['create_time'] = time();

                $bankinfoObj = M('bankinfo');
                $is_exist = $bankinfoObj->field('busername,bankname,banknumber,tel')->where(array('uid' => $data['uid']))->find();
                if ($is_exist) {
                    $bank = $bankinfoObj->where(array('uid' => $data['uid']))->save($data);
                } else {
                    $bank = $bankinfoObj->add($data);
                }
            }

            if ($bank) {
                $data['status'] = 1;
                $data['msg'] = '绑定成功';
                $this->ajaxReturn($data, 'JSON');
            } else {
                $data['status'] = 0;
                $data['msg'] = '绑定失败';
                $this->ajaxReturn($data, 'JSON');
            }
    }

    /**
     * 申请提现
     */
    public function send_withdrawal()
    {
        $uid     = trim(I('post.uid'));
        $balance = trim(I('post.send_balance'));

        $userinfo    = M('userinfo');
        $bankinfo    = M('bankinfo');
        $account     = M('accountinfo');

        $data = array();
        if(IS_AJAX)
        {            
            $info = $userinfo->where(array('uid' => $uid))->find();
            if($info)
            {
                $banks       = $bankinfo->where(array('uid' => $uid))->find();
                $accountinfo = $account->where(array('uid' => $uid))->find();
                $sure_money  = ($accountinfo['balance'] - $accountinfo['gold_threshold']);
                
                if(!$banks['banknumber'])
                {
                    $data['status'] = 3;
                    $data['msg'] = '银行卡还没有绑定';
                    $this->ajaxReturn($data,'JSON');
                }

                if(empty($balance))
                {
                    $data['status'] = 2;
                    $data['msg'] = '请输入你要提现的金额';
                    $this->ajaxReturn($data,'JSON');
                }

                if(!is_numeric($balance) || $balance < 0)
                {
                    $data['status'] = 2;
                    $data['msg'] = '请输入正确的提现金额';
                    $this->ajaxReturn($data,'JSON'); 
                }

                if($accountinfo['balance'] <= $accountinfo['gold_threshold'])
                {
                    $data['status'] = 2;
                    $data['msg'] = '提现失败！当前资金小于最大出金阈值';
                    $this->ajaxReturn($data,'JSON');
                }
                
                if($balance > $sure_money)
                {
                    $data['status'] = 2;
                    $data['msg'] = '提现金额不能大于可提金额';
                    $this->ajaxReturn($data,'JSON'); 
                }

                //开始提现
                $status        = $account->where(array('uid' => $uid))->setDec('balance',$balance);
                $surplus_money = $account->where(array('uid' => $uid))->sum('balance');
                if($status)
                {
                    $datas['uid']           = $uid;
                    $datas['bank_id']       = $banks['bid'];
                    $datas['balanceno']     = time().mt_rand();
                    $datas['amount']        = $balance;             //提现金额
                    $datas['amount_rmb']    = $balance * 6.2;       //提现金额rmb
                    $datas['balance']       = $surplus_money;

                    $datas['busername']     = $banks['busername'];
                    $datas['banknumber']    = $banks['banknumber'];
                    $datas['bankname']      = $banks['bankname'];
                    $datas['card']          = $banks['card'];
                    $datas['tel']           = $banks['tel'];
                    $datas['status']        = 0;
                    $datas['create_time']   = time();

                    $res = M('withdraw')->add($datas);
                } 
                if($res)
                {
                    //添加出入金流动表
                    $map['uid']      = $uid;
                    $map['type']     = 3;
                    $map['oid']      = $res;
                    $map['note']     = '运营中心申请提现扣除['.$balance.']';
                    $map['balance']  = $surplus_money;
                    $map['op_id']    = $uid;
                    $map['user_type']= 2;
                    $map['dateline'] = time();
                    M("MoneyFlow")->add($map);

                    $data['status'] = 1;
                    $data['msg'] = '提现成功';
                    $this->ajaxReturn($data,'JSON');
                } else {

                    $data['status'] = 2;
                    $data['msg'] = '提现失败';
                    $this->ajaxReturn($data,'JSON');
                }

            } else {
                $data['status'] = 2;
                $data['msg'] = '系统没有找到该用户';
                $this->ajaxReturn($data,'JSON');
            }
        }
    }

}