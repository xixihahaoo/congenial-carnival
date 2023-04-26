<?php
namespace Pc\Controller;

use Think\Controller;

class InvestmentController extends CommonController
{

    public function _initialize()
    {
        parent::_initialize();
        self::IsLogin();
        $this->user_id = session('user_id');
    }

    /**
     * [index 投资报表]
     * @author wang li
     */
    public function index()
    {
        $uid = $this->user_id;

        $optionObj = M('option');
        $orderObj  = M('order');
        $userObj   = M('userinfo a');
        $followObj = M('order_follow');
        $prefix    = C('DB_PREFIX');

        $now_trade_status = $userObj->where(['a.uid' => $this->user_id])
                                    ->getField('a.now_trade_status');


        //会员信息
        $info = $userObj->field('uid,nickname,face,level,desc')
                        ->where(['a.uid' => $uid])
                        ->join('inner join '.$prefix.'user_level b on a.level_id = b.id')
                        ->find();

        $map['ostaus'] = 1;
        $map['type']   = $now_trade_status;
        $map['uid']    = $uid;

        $order = $orderObj->field('sum(ploss) / sum(bond) as profit,
                        count(*) as count,
                        uid,
                        sum(onumber) as onumber,
                        max(onumber) as maxOnmuber,
                        count(
                            CASE
                            WHEN order_result = 2 THEN
                                order_result
                            END
                        ) AS profitCount,
                        count(
                            CASE
                            WHEN order_result = 3 THEN
                                order_result
                            END
                        ) AS lossCount,
                            count(
                            CASE
                            WHEN ostyle = 0 THEN
                                ostyle
                            END
                        ) AS riseCount,
                        count(
                            CASE
                            WHEN ostyle = 1 THEN
                                ostyle
                            END
                        ) AS fallCount
                        ')
                          ->group('uid')
                          ->where($map)
                          ->find();

        // echo M()->getLastSql();die;

        $order['profit'] = round($order['profit'] * 100, 2);

        $order['correct'] = round(($order['profitCount'] / $order['count']) * 100, 2);

        $order['followCount'] = $followObj->where([
            'status'         => 1,
            'follow_user_id' => $uid,
        ])
                                          ->count();

        //上一日交易状况 收益率
        $map['_string']     = 'TO_DAYS(NOW()) - TO_DAYS(FROM_UNIXTIME(selltime,"%Y-%m-%d %H:%i:%s")) = 1';
        $Yesterday          = $orderObj->field('sum(ploss) / sum(bond) as profit')
                                       ->group('uid')
                                       ->where($map)
                                       ->find();
        $order['Yesterday'] = round($Yesterday['profit'] * 100, 2);


        //历史交易品种统计
        $orderIdStr = $orderObj->where('uid='.$uid.' and type='.$now_trade_status.'')
                               ->getField('group_concat(distinct pid)');

        $option = $optionObj->where('id in('.$orderIdStr.')')
                            ->field('capital_key,pid,id,capital_name,en_name')
                            ->select();

        $data = $orderObj->where([
            'uid'    => $uid,
            'ostaus' => 1,
            'type'   => 1,
        ])
                         ->group('pid')
                         ->getField('pid,count(oid)');

        foreach ($option as $key => $value) {

            $option[ $key ]['purchase_count'] = $orderObj->where([
                'pid'    => $value['id'],
                'ostyle' => 0,
                'uid'    => $uid,
            ])
                                                         ->count();
            $option[ $key ]['sell_count']     = $orderObj->where([
                'pid'    => $value['id'],
                'ostyle' => 1,
                'uid'    => $uid,
            ])
                                                         ->count();

            $option[ $key ]['purchase_rate'] = round($option[ $key ]['purchase_count'] / ($option[ $key ]['purchase_count'] + $option[ $key ]['sell_count']) * 100, 2);
            $option[ $key ]['sell_rate']     = round(100 - $option[ $key ]['purchase_rate'], 2);

            //交易品种百分比
            $option[ $key ]['rate'] = round(($data[ $value['id'] ] / $order['count']) * 100, 2);

            if (LANG == 'en-us') {
                $option[ $key ]['capital_name'] = $value['en_name'];
            }
            elseif (LANG == 'zh-tw') {
                $option[ $key ]['capital_name'] = simpleTradition($value['capital_name']);
            }
        }

        $pidArr = [];
        foreach ($option as $key => $value) {
            array_push($pidArr, $value['pid']);
            $optionData[ $value['pid'] ][] = $value;
        }

        $optionClassObj = M('OptionClassify');

        $pidStr    = implode(',', array_unique($pidArr));
        $classData = $optionClassObj->where('id in('.$pidStr.')')
                                    ->select();

        foreach ($classData as $key => $value) {
            $classData[ $key ]['parent'] = $optionData[ $value['id'] ];
        }

        //当前持仓总数
        $position_count = M('order')
            ->where([
                'uid'    => $uid,
                'ostaus' => 0,
                'type'   => 1,
            ])
            ->count();
        //总订单
        $count = M('order')
            ->where([
                'uid'  => $uid,
                'type' => 1,
            ])
            ->count();

        $this->assign('position_count', $position_count);
        $this->assign('count', $count);

        $this->assign('classData', $classData);
        $this->assign('info', $info);
        $this->assign('order', $order);


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
            $bank[ $key ]['banknumber'] = substr_replace($value['banknumber'], '**** **** **** ', 0, 12);
        }


        $this->assign('personal', $personal);
        $this->assign('bank', $bank);


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
