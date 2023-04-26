<?php
namespace Home\Controller;
use Think\Controller;

class ExtensionController extends CommonController
{

    public function _initialize(){
        parent::_initialize();
        self::IsLogin();

        $method = array('/home/extension/applyagent');
        
        $this->user_id = session('user_id');

        if(in_array(__ACTION__,$method))
        {
            return ;
        }
    }

    /**
     * [index 我的推广]
     * @author wang li
     */
    public function index()
    {   
        $extensionObj   = M('extension');
        $feeReceiveObj  = M('fee_receive');
        $userObj        = M('userinfo a');
        $prefix         = C('DB_PREFIX');

        //当前推广金额
        $data['money'] = $extensionObj->where(array('user_id' => $this->user_id))->getField('money');

        $info = $userObj->field('a.code,b.name,b.level,b.price')->where(array('a.uid' => $this->user_id))->join('left join '.$prefix.'userinfo_rate b on a.extension_level = b.id')->find();

        //推广链接
        $data['url']            = 'http://'.$_SERVER['HTTP_HOST'].'/Home/invatation/'.$info['code'];

        //后台链接
        $data['admin_url']      = 'http://'.$_SERVER['HTTP_HOST'].'/agent.php/login';

        //等级描述

        if(LANG == 'en-us') {
            if($info['level'] == 1) {
                $data['desc'] = L('one_star');
            } else if($info['level'] == 2) {
                $data['desc'] = L('two_star');
            } else if($info['level'] == 3) {
                $data['desc'] = L('samsung');
            }
        } else if(LANG == 'zh-tw') {
            $data['desc'] = simpleTradition($info['desc']);
        } else {
            $data['desc'] = $info['desc'];
        }

        $data['level']  = $info['level'];

        $prirceData     = F('data');

        foreach ($prirceData as $key => $value) {
        	$prirceData[$key]['price'] = $value['level'][$info['level']]['price'];
        	if(LANG == 'en-us') {
                $prirceData[$key]['name'] = $value['en_name'];
            } else if(LANG == 'zh-tw') {
                $prirceData[$key]['name'] = simpleTradition($value['name']);
            }
        }

        $this->assign('prirceData',$prirceData);

        $data['price']  = $info['price'];

        //我的朋友
        $data['friend'] = $userObj->where(array('rid' => $this->user_id))->count();

        //累计收入
        $data['profit'] = $feeReceiveObj->where(array('user_id' => $this->user_id,'status' =>1))->sum('profit');

        //好友交易手数
        $data['count'] = round(M('order')->where('uid in(select uid from '.$prefix.'userinfo where rid='.$this->user_id.') and type=1')->sum('onumber'),2);

        //升级还需交易手数
        $levelWhere = array(1 => 0,2 => 500,3 => 1000);

        $data['needCount'] = round($levelWhere[$data['level']+1] - $data['count'],2);

        //佣金诱导        
        $receive = array_values(F('data'));
        $prirce  = $receive[0]['level'][1]['price'];

        $list['lowReceive']     = round($prirce,2);
        $list['weekReceive']    = round($prirce * 10 * 7 * 5,2);
        $list['monthReceive']   = round($prirce * 10 * 30 * 5,2);


        $this->assign('list',$list);
        $this->assign('data',$data);
        $this->display();
    }

    /**
     * [levelRule 佣金返还规则]
     * @return [type] [description]
     */
    public function levelRule()
    {
        $prirceData     = F('data');

        $data = array();
        $classB = array();
        $classC = array();

        foreach ($prirceData as $key => &$value) {

            if(LANG == 'en-us') {
                $value['name'] = $value['en_name'];
            } else if(LANG == 'zh-tw') {
                $value['name'] = simpleTradition($value['name']);
            }


            $data['classA'][$value['name']] = $value['level'][1]['price'];
            $data['classB'][$value['name']] = $value['level'][2]['price'];
            $data['classC'][$value['name']] = $value['level'][3]['price'];
        }

        $this->assign('data',$data);
        $this->display();
    }


    /**
     * [friend 我的好友]
     * @author wang li
     */
    public function friend()
    {
        $userObj    = M('userinfo');
        $orderObj   = M('order'); 

        $user  = $userObj->field('uid,utel,utime,face,email,nickname')->where(array('rid' => $this->user_id))->select();

        foreach ($user as $key => $value) {
            $oid = $orderObj->where(array('uid' => $value['uid'],'type' => 1))->getField('oid');

            $user[$key]['msg']      = !empty($oid) ? '' : L('api_untraded_user');

            $user[$key]['utel']     = substr_replace($value['utel'],'****',3,4);
            $user[$key]['utime']    = date('Y/m/d H:i:s',$value['utime']);
            $user[$key]['face']     = !empty($value['face']) ? $value['face'] : '/Public/Qts/Home/img/me/1499222434250.png';
        }

        $this->assign('user',$user);
        $this->display();
    }

    /**
     * [income 累计收入]
     * @author wang li
     */
    public function income()
    {
        $feeReceiveObj  = M('fee_receive');
        $list           = $feeReceiveObj->field('profit,create_time')->where(array('user_id' => $this->user_id,'status' =>1))->order('create_time desc')->select();

        foreach ($list as $key => $value) {
            $list[$key]['profit']       = round($value['profit'],2);
            $list[$key]['create_time']  = date('Y-m-d H:i:s',$value['create_time']);
        }

        $this->assign('list',$list);
        $this->display();
    }

    /**
     * [changeAccount 转入账户]
     * @author wang li
     */
    public function changeAccount()
    {
        $extensionObj   = M('extension');

        //当前推广金额
        $money = $extensionObj->where(array('user_id' => $this->user_id))->getField('money');

        if(IS_AJAX) {

            $postMoney = trim(I('post.money'));

            if(empty($postMoney))
                outjson(array('code' => 400,'msg' => L('api_input_balance')));

            if ($postMoney <= 0)
                outjson(array('code' => 400,'msg' => L('api_input_balance')));

            if($postMoney > $money)
                outjson(array('code' => 400,'msg' => L('api_balance_insufficient')));

            $accountObj = M('accountinfo');
            $flowObj    = M('money_flow');

            $accountObj->startTrans(); //开启事务

            $extension_res  = $extensionObj->where(array('user_id' => $this->user_id))->setDec('money',$postMoney);
            $account_res    = $accountObj->where(array('uid' => $this->user_id))->setInc('balance',$postMoney);

            $map['uid']         = $this->user_id;
            $map['type']        = 5;
            $map['note']        = '佣金转入账户['.$postMoney.']美元';
            $map['en_note']     = 'Commission transfer to account['.$postMoney.']Dollar';
            $map['balance']     = $accountObj->where(array('uid' => $this->user_id))->getField('balance');
            $map['op_id']       = $this->user_id;
            $map['user_type']   = 1;
            $map['dateline']    = time();
            $flow_res = $flowObj->add($map);

            //转入记录
            $journal['user_id']     = $this->user_id;
            $journal['account']     = $postMoney;
            $journal['type']        = 1;
            $journal['create_time'] = time();
            $journal_res = M('UserJournal')->add($journal);

            try {
                if($extension_res && $account_res && $flow_res && $journal_res)
                {
                    $accountObj->commit();
                    outjson(array('code' => 200,'msg' => L('api_success')));
                } else{
                    $accountObj->rollback();
                    outjson(array('code' => 400,'msg' => L('api_fail')));
                }
            } catch (Exception $e) {
                $accountObj->rollback();
                outjson(array('code' => 400,'msg' => $e->errorMessage()));
            }


        } else {
            $this->assign('money',$money);
            $this->display();
        }
    }

    /**
     * [changeRecord 佣金转入记录]
     * @author wang li
     */
    public function changeRecord()
    {
        $flowObj = M('money_flow');

        $map['uid']     = $this->user_id;
        $map['type']    = 5;

        $list = $flowObj->field('note,en_note,dateline')->where($map)->order('dateline desc')->select();

        foreach ($list as $key => $value) {
            $list[$key]['dateline']     = date('Y/m/d H:i:s',$value['dateline']);

            if(LANG == 'en-us') {
                $list[$key]['note'] = $value['en_note'];
            } else if(LANG == 'zh-tw') {
                $list[$key]['note'] = simpleTradition($value['note']);
            }
        }

        $this->assign('list',$list);
        $this->display();
    }


    /**
     * [applyAgent 申请代理商]
     * @author wang li
     */
    public function applyAgent()
    {
        if(IS_AJAX)
        {   
            $userObj = M('userinfo');

            $user = $userObj->field('uid,code')->where(array('uid' => $this->user_id))->find();

            if(!$user)      outjson(array('code' => 400,'msg' => L('api_apply_fail')));

            if(!empty($user['code']))   outjson(array('code' => 200,'msg' => L('api_no_repeat_fail')));

            $dataArr = array(
                'code' => generate_code(4),
                'extension_level' => 1
            );

            $res = $userObj->where(array('uid' => $this->user_id))->save($dataArr);

            if($res)    outjson(array('code' => 200,'msg' => L('api_apply_success')));
            else        outjson(array('code' => 400,'msg' => L('api_apply_fail')));


        } else {
            outjson(array('code' => 400,'msg' => L('api_apply_fail')));
        }
    }


    //判断是否登录
    private function IsLogin()
    {
        if(empty($this->user_id))
        {
            if(IS_AJAX)
                outjson(array('code' => 400,'msg' => L('no_login')));
            else
                $this->redirect('Login/login');
        }
    }
}
