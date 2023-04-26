<?php
namespace Pc\Controller;

class MessageController extends CommonController
{

    public function _initialize()
    {
        parent::_initialize();
        self::IsLogin();
        $this->user_id = session('user_id');
    }

    /**
     * [index 系统消息]
     * @author wang li
     */
    public function index()
    {
        $flowObj    = M('money_flow');
        $stretchObj = M('SiteStretch');

        $dataType = [
            1 => L('api_position'),
            2 => L('api_close_position'),
            3 => L('api_withdrawal'),
            4 => L('api_recharge'),
            5 => L('api_commission'),
            7 => L('api_cancel_order'),
        ];

        $sqlWhere = " YEARWEEK(FROM_UNIXTIME(dateline,'%Y-%m-%d'),1) = YEARWEEK(DATE_FORMAT(now(),'%Y-%m-%d'),1) and uid={$this->user_id}";

        $list = $flowObj->field('id,type,note,en_note,dateline,is_read')
                        ->where($sqlWhere)
                        ->order('dateline desc')
                        ->select();


        foreach ($list as $key => $value) {
            $list[$key]['msg']  = $dataType[$value['type']];
            $list[$key]['time'] = date('Y/m/d H:i:s', $value['dateline']);

            if (LANG == 'zh-tw') {
                $list[$key]['note'] = simpleTradition($value['note']);
            } elseif (LANG == 'en-us') {
                $list[$key]['note'] = $value['en_note'];
            }

        }

        $stretch = $stretchObj->field('dateline,start_time,end_time')
                              ->select();
        $time    = time();
        $status  = 0;

        foreach ($stretch as $key => $value) {
            if ($time >= $value['start_time'] && $time <= $value['end_time']) {
                $status = 1;
            }
        }

        //一次性处理该用户所有未读消息
        if ($this->NoreadCount > 0) {
            $flowObj->where([
                'uid'     => $this->user_id,
                'is_read' => 1,
            ])
                    ->setField('is_read', 2);
        }


        $this->assign('status', $status);
        $this->assign('list', $list);

        //用户信息
        $userModel = D('userinfo');
        $user      = $userModel->getDataFind($this->user_id);
        $this->assign('user', $user);

        $accountModel = M('accountinfo');
        $account      = $accountModel->field('balance,gold')
                                     ->where(['uid' => $user['uid']])
                                     ->find();
        $this->assign('account', $account);

        $personalObj = M('personal_user_data');
        $personal    = $personalObj->where(['uid' => $this->user_id])
                                   ->find();
        $this->assign('personal', $personal);

        $userModel     = M('userinfo');
        $personalModel = M('personal_user_data');

        //个人资料
        $personal = $personalModel->field('province,city')
                                  ->where(['uid' => $this->user_id])
                                  ->find();

        $cityModel = M('city');
        //省
        $province = $cityModel->field('id,joinname')
                              ->where(['level' => 1])
                              ->order('id')
                              ->select();
        //市
        $city_id = !empty($personal['province']) ? $personal['province'] : $province[0]['id'];

        $city = $cityModel->field('id,name')
                          ->where([
                              'level'     => 2,
                              'parent_id' => $city_id,
                          ])
                          ->select();

        $this->assign('city', $city);
        $this->assign('province', $province);
        $this->assign('personal', $personal);

        $bankObj     = M('bankinfo');
        $personalObj = M('personal_user_data a');

        $prefix = C('DB_PREFIX');

        $personal = $personalObj->field('a.real_name,a.card,a.status,b.face')
                                ->where(['a.uid' => $this->user_id])
                                ->join('right join '.$prefix.'userinfo b on a.uid=b.uid')
                                ->find();

        $personal['face'] = !empty($personal['face']) ? $personal['face'] : '/Public/Qts/Home/img/me/1499222434250.png';
        $personal['card'] = substr_replace($personal['card'], '**********', 4, 10);

        $map['uid']    = $this->user_id;
        $map['status'] = [
            'in',
            '0,1',
        ];

        $bank = $bankObj->field('bid,bankname,banknumber,busername,status')
                        ->where($map)
                        ->select();

        foreach ($bank as $key => $value) {
            $bank[$key]['banknumber'] = substr_replace($value['banknumber'], '**** **** **** ', 0, 12);
        }


        $this->assign('personal', $personal);
        $this->assign('bank', $bank);


        $this->display();
    }

    /**
     * [publicMsg 公告信息]
     * @author  wang li
     */
    public function publicMsg()
    {
        $stretchObj = M('SiteStretch');

        $list = $stretchObj->field('id,title,content,dateline,start_time,end_time')
                           ->where(['lang' => LANG_SHOW])
                           ->order('dateline desc')
                           ->select();

        $time   = time();
        $status = 0;

        foreach ($list as $key => $value) {
            $list[$key]['time']    = date('Y/m/d H:i:s', $value['dateline']);
            $list[$key]['content'] = mb_substr(trim(htmlspecialchars_decode($value['content'])), 0, 80, 'UTF-8').' ...';

            if (LANG == 'zh-tw') {
                $list[$key]['title']   = simpleTradition($value['title']);
                $list[$key]['content'] = simpleTradition($list[$key]['content']);
            }

            if ($time >= $value['start_time'] && $time <= $value['end_time']) {
                $list[$key]['class'] = '';
                $status              = 1;
            } else {
                $list[$key]['class'] = 'isread';
            }
        }

        $this->assign('status', $status);
        $this->assign('list', $list);


        //用户信息
        $userModel = D('userinfo');
        $user      = $userModel->getDataFind($this->user_id);
        $this->assign('user', $user);

        $accountModel = M('accountinfo');
        $account      = $accountModel->field('balance,gold')
                                     ->where(['uid' => $user['uid']])
                                     ->find();
        $this->assign('account', $account);

        $personalObj = M('personal_user_data');
        $personal    = $personalObj->where(['uid' => $this->user_id])
                                   ->find();
        $this->assign('personal', $personal);

        $userModel     = M('userinfo');
        $personalModel = M('personal_user_data');

        //个人资料
        $personal = $personalModel->field('province,city')
                                  ->where(['uid' => $this->user_id])
                                  ->find();

        $cityModel = M('city');
        //省
        $province = $cityModel->field('id,joinname')
                              ->where(['level' => 1])
                              ->order('id')
                              ->select();
        //市
        $city_id = !empty($personal['province']) ? $personal['province'] : $province[0]['id'];

        $city = $cityModel->field('id,name')
                          ->where([
                              'level'     => 2,
                              'parent_id' => $city_id,
                          ])
                          ->select();

        $this->assign('city', $city);
        $this->assign('province', $province);
        $this->assign('personal', $personal);

        $bankObj     = M('bankinfo');
        $personalObj = M('personal_user_data a');

        $prefix = C('DB_PREFIX');

        $personal = $personalObj->field('a.real_name,a.card,a.status,b.face')
                                ->where(['a.uid' => $this->user_id])
                                ->join('right join '.$prefix.'userinfo b on a.uid=b.uid')
                                ->find();

        $personal['face'] = !empty($personal['face']) ? $personal['face'] : '/Public/Qts/Home/img/me/1499222434250.png';
        $personal['card'] = substr_replace($personal['card'], '**********', 4, 10);

        $map['uid']    = $this->user_id;
        $map['status'] = [
            'in',
            '0,1',
        ];

        $bank = $bankObj->field('bid,bankname,banknumber,busername,status')
                        ->where($map)
                        ->select();

        foreach ($bank as $key => $value) {
            $bank[$key]['banknumber'] = substr_replace($value['banknumber'], '**** **** **** ', 0, 12);
        }


        $this->assign('personal', $personal);
        $this->assign('bank', $bank);

        $this->display();
    }

    /**
     * stretchDetails 系统消息详情
     * @author wang li
     */
    public function stretchDetails()
    {
        $id   = trim(I('get.id'));
        $flow = M('money_flow')
            ->where('id='.$id)
            ->find();

        $dataType = [
            1 => L('api_position'),
            2 => L('api_close_position'),
            3 => L('api_withdrawal'),
            4 => L('api_recharge'),
            5 => L('api_commission'),
            7 => L('api_cancel_order'),
        ];

        $flow['msg'] = $dataType[$flow['type']];

        //判断消息类型 如果为持仓或平仓或撤单则显示详情 1持仓,2平仓,7撤单
        if ($flow['type'] == 1 || $flow['type'] == 2 || $flow['type'] == 7) {
            $order           = M('order')
                ->where('oid='.$flow['oid'])
                ->find();
            $order['ostyle'] = $order['ostyle'] == 0 ? L('api_buy') : L('api_sell');
        }

        if (LANG == 'zh-tw') {
            $flow['note']         = simpleTradition($flow['note']);
            $order['option_name'] = simpleTradition($order['option_name']);
        } elseif (LANG == 'en-us') {
            $flow['note']         = $flow['en_note'];
            $order['option_name'] = $order['en_name'];
        }


        //如果消息是未读状态,则改变状态
        if ($flow['is_read'] == '1') {
            $data['is_read'] = '2';
            M('money_flow')
                ->where('id='.$id)
                ->save($data);
        }
        $this->assign('order', $order);
        $this->assign('flow', $flow);
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
            } else {
                $this->redirect('Login/login');
            }
        }
    }
}
