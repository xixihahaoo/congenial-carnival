<?php
// +----------------------------------------------------------------------
// | 首页控制器
// +----------------------------------------------------------------------
// | Author wang <li>
// +----------------------------------------------------------------------
namespace Pc\Controller;

use Think\Controller;

class IndexController extends CommonController
{


    public function _initialize()
    {
        parent::_initialize();
        $this->user_id = session('user_id');
    }


    /**
     * [index 首页展示]
     * @author [wang] <[li]>
     */
    public function index()
    {
        /*产品展示*/
        $prefix    = C('DB_PREFIX');
        $optionObj = M('option a');

        //展示自选产品
        $field  = 'a.id,a.capital_name,a.en_name,a.capital_key,a.pid,a.Price,a.DiffRate,b.capital_length';
        $option = $optionObj->field($field)
                            ->where('exists(select b.option_id from '.$prefix.'user_option c where a.id=c.option_id and c.user_id='.$this->user_id.') and a.global_flag=1')
                            ->join('left join '.$prefix.'option_info b on a.id=b.option_id')
                            ->order('b.sort asc')
                            ->limit(0, 3)
                            ->select();

        if (!$option)  //如果没有登录显示前三条产品
        {
            $option = $optionObj->field($field)
                                ->join('left join '.$prefix.'option_info b on a.id=b.option_id')
                                ->where('a.global_flag=1')
                                ->order('b.sort asc')
                                ->limit(0, 3)
                                ->select();
        }

        foreach ($option as $key => $value) {
            if ($value['DiffRate'] <= 0) {
                $operator   = '';
                $calssColor = 'price-green';
            }
            else {
                $operator   = '+';
                $calssColor = 'price-orange';
            }

            $option[ $key ]['DiffRate']   = $operator.$value['DiffRate'];
            $option[ $key ]['calssColor'] = $calssColor;

            if (LANG == 'en-us') {
                $option[ $key ]['capital_name'] = $value['en_name'];
            }
            elseif (LANG == 'zh-tw') {
                $option[ $key ]['capital_name'] = simpleTradition($value['capital_name']);
            }
        }

        //收益top
        $order = $this->profitTop(6, SORT_DESC, 'profit');

        //头部广告
        $fid = M('newsclass')
            ->where([
                'type' => 2,
                'lang' => LANG_SHOW,
            ])
            ->getField('fid');

        $newsinfo = M('newsinfo')
            ->field('nid,ncover,n_type,ncontent')
            ->where([
                'ncategory' => $fid,
                'lang'      => LANG_SHOW,
            ])
            ->order('ntime desc')
            ->select();

        //滚动公告
        $stretch = $stretchObj = M('site_stretch')
            ->field('title,id')
            ->where(['lang' => LANG_SHOW])
            ->order('id desc')
            ->select();

        foreach ($stretch as $key => $value) {

            if (mb_strlen($value['title']) > 14) {
                $stretch[ $key ]['title'] = mb_substr($value['title'], 0, 14, 'UTF-8');
            }

            if (LANG == 'zh-tw') {
                $stretch[ $key ]['title'] = simpleTradition($stretch[ $key ]['title']);
            }
        }

        $this->assign('lang', LANG);
        $this->assign('stretch', $stretch);
        $this->assign('newsinfo', $newsinfo);
        $this->assign('user_id', $this->user_id);
        $this->assign('order', $order);
        $this->assign('option', $option);
        $this->display();
    }


    /**
     * [adDetails 广告详情]
     * @author wang li
     */
    public function adDetails()
    {
        $nid = trim(I('get.nid'));

        $newsinfo = M('newsinfo')
            ->field('ntitle,ncontent')
            ->where([
                'nid'  => $nid,
                'lang' => LANG_SHOW,
            ])
            ->find();

        $newsinfo['content'] = htmlspecialchars_decode($newsinfo['ncontent']);

        if (LANG == 'zh-tw') {
            $newsinfo['content'] = simpleTradition($newsinfo['content']);
            $newsinfo['ntitle']  = simpleTradition($newsinfo['ntitle']);
        }

        $this->assign('info', $newsinfo);
        $this->display();
    }


    /**
     * [profitDetails 收益榜详情]
     * @author wang <[li]>
     */
    public function profitDetails()
    {
        $uid = trim(I('get.uid'));

        $optionObj = M('option');
        $orderObj  = M('order');
        $userObj   = M('userinfo a');
        $followObj = M('order_follow');
        $prefix    = C('DB_PREFIX');


        //会员信息
        $info = $userObj->field('uid,nickname,face,level,desc')
                        ->where(['a.uid' => $uid])
                        ->join('inner join '.$prefix.'user_level b on a.level_id = b.id')
                        ->find();

        $map['ostaus'] = 1;
        $map['type']   = 1;
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
        $orderIdStr = $orderObj->where('uid='.$uid)
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


        $data['nowCount'] = ceil(($orderObj->where([
                'ostaus' => 0,
                'type'   => 1,
                'uid'    => $uid,
            ])
                                           ->count()) / 10);
        $data['hisCount'] = ceil(($orderObj->where([
                'ostaus' => 1,
                'type'   => 1,
                'uid'    => $uid,
            ])
                                           ->count()) / 10);

        //查看该会员我是否跟随
        $followObj = M('order_follow');
        $follow    = $followObj->where([
            'user_id'        => $this->user_id,
            'follow_user_id' => $info['uid'],
            'status'         => 1,
        ])
                               ->find();

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

        $this->assign('follow', $follow);
        $this->assign('data', $data);
        $this->assign('classData', $classData);
        $this->assign('info', $info);
        $this->assign('order', $order);
        $this->display();
    }

    /**
     * [tradeNow 交易记录信息]
     * @author wang <[li]>
     */
    public function tradeNow()
    {
        $orderObj      = M('order');
        $optionINfoObj = M('option_info');

        $uid    = trim(I('get.uid'));
        $page   = trim(I('get.page'));
        $ostaus = trim(I('get.ostaus'));

        $page = !empty($page) ? $page : 1;

        $map['uid']    = $uid;
        $map['ostaus'] = $ostaus;
        $map['type']   = 1;

        if ($ostaus == 1) {
            $orderby = 'selltime desc';
        }
        else {
            $orderby = 'oid desc';
        }


        $orderData = $orderObj->field('oid,option_name,en_name,buyprice,sellprice,ploss,ostyle,onumber,pid,Bond')
                              ->where($map)
                              ->order($orderby)
                              ->page($page, 10)
                              ->select();
        $info      = $optionINfoObj->getField('option_id,capital_length', true);
        foreach ($orderData as $key => $value) {

            if ($value['ploss'] >= 0) {
                $orderData[ $key ]['ploss']     = '+'.$value['ploss'];
                $orderData[ $key ]['txt_color'] = 'txt_red';
            }
            else {
                $orderData[ $key ]['ploss']     = $value['ploss'];
                $orderData[ $key ]['txt_color'] = 'txt_green';
            }

            $orderData[ $key ]['ostyle'] = $value['ostyle'] == '0' ? L('history_buy') : L('history_sell');
            $orderData[ $key ]['color']  = $value['ostyle'] == '0' ? 'bg_red' : 'bg_green';

            $orderData[ $key ]['buyprice']  = sprintf("%.".$info[ $value['pid'] ]['capital_length']."f", $value['buyprice']);
            $orderData[ $key ]['sellprice'] = sprintf("%.".$info[ $value['pid'] ]['capital_length']."f", $value['sellprice']);

            if (LANG == 'en-us') {
                $orderData[ $key ]['option_name'] = $value['en_name'];
            }
            elseif (LANG == 'zh-tw') {
                $orderData[ $key ]['option_name'] = simpleTradition($value['option_name']);
            }

        }

        if ($orderData) {
            outjson([
                'code' => 200,
                'data' => $orderData,
            ]);
        }
        else {
            outjson([
                'code' => 400,
                'msg'  => L('api_no_data'),
            ]);
        }
    }


    /**
     * [profitTop 收益率top]
     * @param int $[limit] [展示数据条数]
     * @param string $[ordery] [排序方式]
     * @param string $[field] [要排序的字段]
     * @return [array] [收益榜]
     * @author wang <[li]>
     */
    private function profitTop($limit = 0, $orderby = SORT_DESC, $field = '')
    {
        $orderObj  = M('order');
        $userObj   = M('userinfo a');
        $followObj = M('order_follow');
        $prefix    = C('DB_PREFIX');

        $map['ostaus'] = 1;
        $map['type']   = 1;

        //只查询交易员
        $uidStr     = $userObj->where([
            'is_trader' => 1,
            'otype'     => 4,
        ])
                              ->getField('group_concat(uid) as uid');
        $map['uid'] = [
            'in',
            $uidStr,
        ];

        $order = $orderObj->field('sum(ploss) / sum(bond) as profit,count(*) as count,uid')
                          ->group('uid')
                          ->where($map)
                          ->select();

        //我跟随的大神
        $followData = $followObj->where([
            'user_id' => $this->user_id,
            'status'  => 1,
        ])
                                ->getField('follow_user_id,user_id', true);


        $uidArr = [];
        foreach ($order as $key => $value) {

            array_push($uidArr, $value['uid']);

            $order[ $key ]['profit'] = round($value['profit'] * 100, 2);

            $count                    = $orderObj->where([
                'ostaus'       => 1,
                'type'         => 1,
                'uid'          => $value['uid'],
                'order_result' => 2,
            ])
                                                 ->count();
            $order[ $key ]['correct'] = round(($count / $value['count']) * 100, 2);

            $order[ $key ]['followCount'] = $followObj->where([
                'status'         => 1,
                'follow_user_id' => $value['uid'],
            ])
                                                      ->count();
        }

        $uid = implode(',', array_unique($uidArr));

        if (!empty($uid)) {
            $info = $userObj->where('a.uid in('.$uid.')')
                            ->join('left join '.$prefix.'user_level b on a.level_id = b.level')
                            ->getField('a.uid,a.nickname,a.face,b.desc,b.level');

            $levelObj = M('UserLevel');

            foreach ($order as $key => $value) {
                $order[ $key ]['nickname']       = $info[ $value['uid'] ]['nickname'];
                $order[ $key ]['face']           = $info[ $value['uid'] ]['face'];
                $order[ $key ]['level']          = $info[ $value['uid'] ]['level'];
                $order[ $key ]['follow_user_id'] = $followData[ $value['uid'] ];   //查看是否被我跟随了
            }

            foreach ($order as $key => $value) {
                $dos[ $key ] = $value[ $field ];
            }

            array_multisort($dos, $orderby, $order);
            $order = array_slice($order, 0, $limit);

            return $order;
        }
        else {
            return false;
        }
    }

    /**
     * [profitAll 高手榜单]
     * @return [type] [description]
     */
    public function profitAll()
    {
        //收益榜
        $data['profitData'] = $this->profitTop(17, SORT_DESC, 'profit');

        //常胜榜
        $data['correctData'] = $this->profitTop(17, SORT_DESC, 'correct');

        //人气榜
        $data['followData'] = $this->profitTop(17, SORT_DESC, 'followCount');

        $userObj = M('userinfo');
        $user    = $userObj->field('nickname,face,is_trader')
                           ->where(['uid' => $this->user_id])
                           ->find();

        $this->assign('user_id', $this->user_id);    //我的编号
        $this->assign('user', $user);
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * [tradeUser 交易员]
     * @author wang <[li]>
     */
    public function tradeUser()
    {
        $userObj  = M('userinfo');
        $orderObj = M('order');

        $info = $userObj->field('nickname,face,is_trader')
                        ->where(['uid' => $this->user_id])
                        ->find();

        $map['ostaus'] = 1;
        $map['type']   = 1;
        $map['uid']    = $this->user_id;

        $order = $orderObj->field('sum(ploss) / sum(bond) as profit,count(*) count')
                          ->group('uid')
                          ->where($map)
                          ->find();

        $order['profit'] = round($order['profit'] * 100, 2);

        //查询第一次交易时间
        $order['buytime'] = $orderObj->where(['type' => 1,'uid' => $this->user_id])
                                     ->order('oid asc')
                                     ->getField('buytime');
        $order['buytime'] = !empty($order['buytime']) ? $order['buytime'] : '';
        $order['time']    = date('y-m-d H:i:s', $order['buytime']);


        //判断当前是否可以申请交易员

        //判断交易时间是否大于2个月
        $date = diffDate(date('Y-m-d', $order['buytime']), date('Y-m-d', time()));

        $date['month'] = ($date['year'] * 12) + $date['month'];

        if ($order['time']) {
            if ($order['profit'] >= 5 && $date['month'] >= 2 && $this->user['balance'] >= 1000) {
                $order['status'] = 1;
            }
            else {
                $order['status'] = 0;
            }
        }
        else {
            $date['month'] = 0;
        }


        //交易员申请表
        $tradeApplyObj = M('TradeApply');
        $tradeStatus   = $tradeApplyObj->where(['user_id' => $this->user_id])
                                       ->getField('status');

        //获取网站配置
        $webname = M('webconfig')->getField('webname');

        //对已经达到条件的特殊显示
        if ($date['month'] >= 2) {
            $data['month_note'] = '<p class="gray first_trade"><span>'.L('api_in').$webname.L('api_real_money').'</span><span class="reachT"></span></p>';
        }
        else {
            $data['month_note'] = '<p class="gray"><span>'.L('api_in').$webname.L('api_real_money').'</span></p>';
        }

        if ($order['profit'] >= 5) {
            $data['profit_note'] = '<p class="gray first_trade"><span>'.L('api_yield').'</span><span class="reachT"></span></p>';
        }
        else {
            $data['profit_note'] = '<p class="gray"><span>'.L('api_yield').'</span></p>';
        }

        if ($this->user['balance'] >= 1000) {
            $data['balance_note'] = '<p class="gray first_trade"><span>'.L('api_accounts').' >=$1000</span><span class="reachT"></span></p>';
        }
        else {
            $data['balance_note'] = '<p class="gray"><span>'.L('api_accounts').' >=$1000</span></p>';
        }


        $this->assign('data', $data);
        $this->assign('tradeStatus', $tradeStatus);
        $this->assign('order', $order);
        $this->assign('info', $info);
        $this->display();
    }


    /**
     * [tradeApply 交易员申请]
     * @author wang <[li]>
     */
    public function tradeApply()
    {
        $tradeApplyObj = M('TradeApply');
        $orderObj      = M('order');

        $info = $tradeApplyObj->field('status')
                              ->where('user_id='.$this->user_id.' and status in(1,2)')
                              ->find();

        if ($info) {
            outjson([
                'code' => 400,
                'msg'  => L('api_repeat'),
            ]);
        }
        else {

            $map['ostaus'] = 1;
            $map['type']   = 1;
            $map['uid']    = $this->user_id;

            $order = $orderObj->field('sum(ploss) / sum(bond) as profit
                            ')
                              ->group('uid')
                              ->where($map)
                              ->find();

            $order['profit'] = round($order['profit'] * 100, 2);

            //查询第一次交易时间
            $order['buytime'] = $orderObj->where(['type' => 1,'uid' => $this->user_id])
                                         ->order('oid asc')
                                         ->getField('buytime');
            $order['time']    = date('y-m-d H:i:s', $order['buytime']);

            //判断当前是否可以申请交易员

            //判断交易时间是否大于2个月
            $date = diffDate(date('Y-m-d', $order['buytime']), date('Y-m-d', time()));

            $date['month'] = ($date['year'] * 12) + $date['month'];

            if ($order['profit'] >= 5 && $date['month'] >= 2 && $this->user['balance'] >= 1000) {
            }
            else {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_permissions'),
                ]);
            }

            $dataArr = [
                'user_id'     => $this->user_id,
                'status'      => 1,
                'create_time' => time(),
            ];

            $res = $tradeApplyObj->add($dataArr);
            if ($res) {
                outjson([
                    'code' => 200,
                    'msg'  => L('api_success'),
                ]);
            }
            else {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_fail'),
                ]);
            }
        }
    }


    /**
     * [advanced 进阶必备]
     * @author wang <[li]>
     */
    public function advanced()
    {
        $this->display();
    }

    /**
     * [getNewsInfo 获得新闻信息]
     * @author wang <[li]>
     */
    public function getNewsInfo()
    {
        $fid = trim(I('get.fid'));

        if (empty($fid)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_fail'),
            ]);
        }

        $newsInfoObj = M('newsinfo');

        $data = $newsInfoObj->field('nid,ntitle,ncontent,ncover,ncategory,ntime')
                            ->where([
                                'ncategory' => $fid,
                                'lang'      => LANG_SHOW,
                            ])
                            ->select();
        if (!$data) {
            outjson([
                'code' => 400,
                'msg'  => L('api_fail'),
            ]);
        }

        foreach ($data as $key => $val) {
            if (LANG == 'zh-tw') {
                $data[ $key ]['ntitle'] = simpleTradition($val['ntitle']);
            }

        }

        outjson([
            'code' => 200,
            'msg'  => L('api_success'),
            'data' => $data,
        ]);
    }

    /**
     * [newsDetails 获得新闻详情]
     * @author wang <[li]>
     */
    public function newsDetails()
    {
        $nid = trim(I('get.nid'));

        $info = M('newsinfo')
            ->where([
                'nid'  => $nid,
                'lang' => LANG_SHOW,
            ])
            ->find();

        $info['ncontent'] = htmlspecialchars_decode($info['ncontent']);

        if ($info['ncategory'] == 1) {
            $className = L('entry_transaction');
        }
        else {
            $className = L('index_analysis');
        }

        if (LANG == 'zh-tw') {
            $info['ntitle']   = simpleTradition($info['ntitle']);
            $info['ncontent'] = simpleTradition($info['ncontent']);
            $className        = simpleTradition($className);
        }


        $this->assign('className', $className);
        $this->assign('info', $info);
        $this->display();
    }

    /**
     * [prefixPloss 外汇盈亏计算助手]
     * @return [type] [description]
     */
    public function prefixPloss()
    {
        //获取外汇产品
        $prefix = C('DB_PREFIX');
        $option = M('option a')
            ->field('a.id,a.option_key,a.capital_name,a.bp,a.sp,a.erence,a.wave,a.capital_dot_length,b.contract_number,b.bond,b.capital_length')
            ->join('left join '.$prefix.'option_info b on a.id=b.option_id')
            ->where(['a.global_flag' => 1])
            ->order('b.sort asc')
            ->select();

        $this->assign('option', $option);
        $this->display();
    }


    /**
     * [financeNews 资讯快递]
     * @author wang <[li]>
     */
    public function financeNews()
    {
        $this->display();
    }

    /**
     * [getNews 获取远程网站资讯快递信息]
     * @author wang <li>
     */
    public function getNews()
    {
        //        $page = 0;
        //        $page = empty(I('get.page')) ? 0 : trim(I('get.page'));
        //
        //        $page = $page * 10;
        //
        //        $arr = file_get_contents("https://www.newsnow.co.uk/h/Business+&+Finance/Cryptocurrencies?type=ln");
        //
        //        $arr = json_decode($arr);
        //
        //        $arr = array_slice($arr, $page, 10);  //分割数组
        //
        //        foreach ($arr as $key => $value) {
        //
        //            $lista = explode("#", $value);
        //
        //            $time = substr($lista[2], 11);
        //
        //            if (strlen($time) <= 8) {
        //                $a[ $key ]['time']    = $time;
        //                $a[ $key ]['content'] = strip_tags(preg_replace("/<img.+?\/>/", "", $lista[3]));
        //                $a[ $key ]['url']     = $lista[4];
        //
        //                if (LANG == 'zh-tw') {
        //                    $a[ $key ]['content'] = simpleTradition($a[ $key ]['content']);
        //                }
        //            }
        //        }
        //
        //        outjson(['data' => $a]);

        $rows = 20;
        $page = empty(I('get.page')) ? 0 : trim(I('get.page'));
        $page = $page + 1;

        $arr = file_get_contents("https://newsapi.eastmoney.com/kuaixun/v1/getlist_105__".$rows."_".$page."_.html");

        $arr = json_decode($arr,true);

        $a = [];
        foreach ($arr['LivesList'] as $key => $value) {

            $a[ $key ]['time']    = $value['showtime'];
            $a[ $key ]['content'] = $value['digest'];
            $a[ $key ]['url']     = $value['url_unique'];

            if(in_array(LANG,C('LANG_ARR'))) {

                $url = 'http://fanyi.youdao.com/translate?&doctype=json&type=AUTO&i='.urlencode($a[ $key ]['content']).'';
                $fanyi_data = file_get_contents($url);
                $fanyi_data = json_decode($fanyi_data,true);

                if($fanyi_data['errorCode'] != 0) {
                    $a[ $key ]['content'] = [];
                    continue;
                }

                $result = $fanyi_data['translateResult'];
                $src    = '';

                foreach ($result as $k => $v) {
                    for ($i=0;$i<count($v);$i++) {

                        $tgt = $v[$i]['tgt'];

                        if(empty($tgt)) {
                            $tgt = '<br/>';
                        }
                        $src .= $tgt;
                    }
                }

                $a[ $key ]['content'] = $src;
            }
            elseif (LANG == 'zh-tw') {
                $a[ $key ]['content'] = simpleTradition($a[ $key ]['content']);
            }
        }

        outjson(['data' => $a]);
    }


    /**
     * [finance 财经资讯]
     * @return [type] [description]
     */
    public function finance()
    {

        $classData = $this->newsInformation();

        $url = 'https://second.abcgh.com/user/information/getInformationDeliveries.do?page=0';

        $data = get_curl_contents($url);

        $dataArr = json_decode($data, true);

        foreach ($dataArr['data'] as &$value) {

            if (empty($value['title'])) {
                $value['content'] = strip_tags($value['eventcontent']);
            }
            else {
                $value['content'] = strip_tags($value['title']);
            }


            $value['createTime'] = substr($value['createTime'], 0, 16);
        }

        $this->assign('list', $dataArr['data']);
        $this->assign('classData', $classData);
        $this->display();
    }


    /**
     * 财经日历接口
     * @author wang
     */
    public function getFinance()
    {

        header("Access-Control-Allow-Origin: http://qts.21jrd.com"); // 允许任意域名发起的跨域请求
        header('Access-Control-Allow-Headers: Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With,X_Requested_With');
        header('Access-Control-Allow-Method:GET, POST'); //允许访问的方式
        header("Access-Control-Allow-Credentials: true"); //是否允许请求带有验证信息
        /*       header("Access-Control-Max-Age:".ACCESS_CONTROL_MAX_AGE); //在这个时间范围内，所有同类型的请求都将不再发送预检请求而是直接使用此次返回的头作为判断依据*/
        //  http:192.168.0.253:8052/Home/Index/finance.html

        $date = trim(I('get.date'));

        $url = 'https://second.abcgh.com/user/information/getFinanceCalendar.do?date='.$date.'';

        $data = get_curl_contents($url);

        $dataArr = json_decode($data, true);

        foreach ($dataArr['data'] as &$value) {

            if (empty($value['title'])) {
                $value['content'] = strip_tags($value['eventcontent']);
            }
            else {
                $value['content'] = strip_tags($value['title']);
            }

            $value['createTime'] = substr($value['createTime'], 0, 16);
        }


        $nmb = count($dataArr['data']);

        for ($i = 0; $i < $nmb; $i++) {

            if ($dataArr['data'][ $i ]['star'] == 0) {
                $dataArr['data'][ $i ]['star_url'] = '/Uploads/star/star_gray@2x1.png';
            }
            if ($dataArr['data'][ $i ]['star'] == 1) {
                $dataArr['data'][ $i ]['star_url'] = '/Uploads/star/star_gray@2x2.png';
            }
            if ($dataArr['data'][ $i ]['star'] == 2) {
                $dataArr['data'][ $i ]['star_url'] = '/Uploads/star/star_gray@2x3.png';
            }
            if ($dataArr['data'][ $i ]['star'] == 3) {
                $dataArr['data'][ $i ]['star_url'] = '/Uploads/star/star_gray@2x4.png';
            }
            if ($dataArr['data'][ $i ]['star'] == 4) {
                $dataArr['data'][ $i ]['star_url'] = '/Uploads/star/star_gray@2x5.png';
            }
            if ($dataArr['data'][ $i ]['star'] == 5) {
                $dataArr['data'][ $i ]['star_url'] = '/Uploads/star/star_gray@2x6.png';
            }


        }
        if (!$dataArr) {
            outjson([
                'code' => 400,
                'msg'  => L('api_fail'),
            ]);
        }
        else {
            outjson($dataArr);
        }
    }

    /**
     * [newsInformation 获取金融资讯信息]
     * @author wang <[li]>
     */
    private function newsInformation()
    {
        $newsClassObj = M('newsclass');

        $map['type']    = 0;
        $map['fid']     = [
            3,
            4,
            'or',
        ];
        $map['is_show'] = 1;
        $classData      = $newsClassObj->field('fid,fclass,type')
                                       ->where($map)
                                       ->select();

        return $classData;
    }

    /**
     * [watch 强势围观]
     * @return [type] [description]
     */
    public function watch()
    {
        $publishObj = M('publish');
        $count      = $publishObj->count();

        $this->assign('count', ceil($count / 10));
        $this->display();
    }

    /**
     * [getWatchList 接口请求方式获取晒单信息]
     * @return [array] [晒单列表数据]
     * @author [wang] <[li]>
     */
    public function getWatchList()
    {
        $publishObj   = M('publish');
        $userObj      = M('userinfo');
        $orderObj     = M('order');
        $userLevelObj = M('UserLevel');

        $page = trim(I('get.page')) ? trim(I('get.page')) : 1;

        $publishData = $publishObj->order('create_time desc')
                                  ->page($page, 10)
                                  ->select();

        $userArr     = [];
        $orderArr    = [];
        $fabulousArr = [];
        foreach ($publishData as $key => $value) {
            array_push($userArr, $value['user_id']);
            array_push($orderArr, $value['order_id']);
            array_push($fabulousArr, $value['id']);
        }

        $fabulousId = implode(',', array_unique($fabulousArr));
        $userId     = implode(',', array_unique($userArr));
        $orderId    = implode(',', array_unique($orderArr));

        //查询用户信息
        $userData = $userObj->where('uid in('.$userId.')')
                            ->getField('uid,nickname,face,level_id,uid', true);

        //查询订单信息
        $orderData = $orderObj->where('oid in('.$orderId.')')
                              ->getField('oid,option_name,en_name,onumber,ostyle,buyprice,sellprice,ploss,pid', true);

        //查询对应等级
        $levelData = $userLevelObj->getField('id,level', true);

        foreach ($userData as $key => $value) {
            $userData[ $key ]['level'] = $levelData[ $value['level_id'] ];
        }

        foreach ($publishData as $key => $value) {
            $publishData[ $key ]['nickname'] = $userData[ $value['user_id'] ]['nickname'];
            $publishData[ $key ]['face']     = $userData[ $value['user_id'] ]['face'];
            $publishData[ $key ]['level']    = $userData[ $value['user_id'] ]['level'];

            $option_name = $orderData[ $value['order_id'] ]['option_name'];
            $en_name     = $orderData[ $value['order_id'] ]['en_name'];
            $ploss       = $orderData[ $value['order_id'] ]['ploss'];

            if (LANG == 'zh-tw') {
                $option_name = simpleTradition($option_name);
            }
            elseif (LANG == 'en-us') {
                $option_name = $en_name;
            }

            $publishData[ $key ]['desc'] = L('buy').' '.$option_name.' '.L('profit').' $'.$ploss.'！';

            $publishData[ $key ]['create_time'] = format_date($value['create_time']);

        }

        if (IS_AJAX) {
            if ($publishData) {
                outjson([
                    'code' => 200,
                    'data' => $publishData,
                    'msg'  => L('api_success'),
                ]);
            }
            else {
                outjson([
                    'code' => 400,
                    'msg'  => L('api_fail'),
                ]);
            }
        }
        else {
            return $publishData;
        }
    }


    /**
     * [echarts 图表展示]
     * @author wang <[li]>
     */
    public function echarts()
    {
        $code = I('get.capital_key');
        $this->assign('code', $code);                    //代码
        $this->assign('interval', I('get.interval'));    //类型
        $this->assign('length', I('get.length'));        //保留小数

        $this->display("highstock");
    }


    /**
     * [orderFollow 订单跟随]
     * @author wang li
     * @return void
     */
    public function orderFollow()
    {
        $uid = trim(I('get.uid'));

        if (empty($uid)) {
            $this->error(L('api_no_user'));
        }

        $followObj = M('order_follow');

        $follow = $followObj->where([
            'follow_user_id' => $uid,
            'user_id'        => $this->user_id,
            'status'         => 1,
        ])
                            ->find();

        $follow['follow_multiple'] = !empty($follow['follow_number']) ? round($follow['follow_number'], 1) : 0.1;
        $follow['follow_number']   = !empty($follow['follow_number']) ? round($follow['follow_number'], 2) : 0.01;

        $this->assign('follow', $follow);
        $this->assign('uid', $uid);
        $this->display();
    }

    /**
     * [followSubmit 编辑跟随]
     * @author wang li
     * @return array|json [返回相关状态]
     */
    public function followSubmit()
    {
        $follow_type   = trim(I('post.type'));
        $follow_number = trim(I('post.numerical'));
        $uid           = trim(I('post.uid'));

        if(empty($this->user_id)) {
            outjson([
                'code' => 400,
                'msg'  => L('no_login'),
            ]);
        }

        if ($follow_type != 1 && $follow_type != 2) {
            outjson([
                'code' => 400,
                'msg'  => L('api_fail'),
            ]);
        }

        if (empty($follow_number) || empty($uid)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_fail'),
            ]);
        }

        //跟随倍数不能超过5倍
        if ($follow_type == 1 && $follow_number > 5) {
            outjson([
                'code' => 400,
                'msg'  => L('api_exceed_multiple'),
            ]);
        }

        //跟随手数不能超过5手
        if ($follow_type == 2 && $follow_number > 5) {
            outjson([
                'code' => 400,
                'msg'  => L('api_exceed_lot'),
            ]);
        }


        $followObj = M('OrderFollow');
        $userObj   = M('userinfo');

        $is_trader = $userObj->where(['uid' => $this->user_id])
                             ->getField('is_trader');
        if ($is_trader == 1) {
            outjson([
                'code' => 400,
                'msg'  => L('api_no_merchandiser'),
            ]);
        }

        $data = $followObj->where([
            'follow_user_id' => $uid,
            'user_id'        => $this->user_id,
        ])
                          ->find();

        if (!$data) {
            $dataArr = [
                'user_id'        => $this->user_id,
                'follow_user_id' => $uid,
                'follow_number'  => $follow_number,
                'follow_type'    => $follow_type,
                'status'         => 1,
                'create_time'    => time(),
            ];

            $res = $followObj->add($dataArr);
        }
        else {
            $dataArr = [
                'follow_number' => $follow_number,
                'follow_type'   => $follow_type,
                'status'        => 1,
                'create_time'   => time(),
            ];
            $res     = $followObj->where([
                'follow_user_id' => $uid,
                'user_id'        => $this->user_id,
            ])
                                 ->save($dataArr);
        }

        if ($res) {
            outjson([
                'code' => 200,
                'msg'  => L('api_success'),
            ]);
        }
        else {
            outjson([
                'code' => 400,
                'msg'  => L('api_fail'),
            ]);
        }
    }

    /**
     * [cancelFollow 取消跟随]
     * @author wang li
     * @return array|json [返回业务相关状态]
     */
    public function cancelFollow()
    {
        $uid = trim(I('post.uid'));

        if (empty($uid)) {
            outjson([
                'code' => 400,
                'msg'  => L('api_fail'),
            ]);
        }

        $followObj = M('OrderFollow');

        $res = $followObj->where([
            'follow_user_id' => $uid,
            'user_id'        => $this->user_id,
            'status'         => 1,
        ])
                         ->setField('status', 2);

        if ($res) {
            outjson([
                'code' => 200,
                'msg'  => L('api_success'),
            ]);
        }
        else {
            outjson([
                'code' => 400,
                'msg'  => L('api_fail'),
            ]);
        }
    }

    /**
     * [agreementFollow 跟随协议]
     * @author wang li
     * @return void
     */
    public function agreementFollow()
    {
        $catagory = M('newsclass')
            ->where('fid=16')
            ->getField('fid');

        $news = M('newsinfo')
            ->field('ntitle,ncontent')
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
}