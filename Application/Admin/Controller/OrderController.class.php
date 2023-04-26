<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;

use Think\Controller;

class OrderController extends BaseController
{


    public function tlist()
    {
        $user = A('Admin/User');
        $user->checklogin();

        $tq    = C('DB_PREFIX');
        $user  = D('userinfo');
        $order = M('order');

        $where          = "";
        $orderno        = trim(I('get.orderno'));    //订单号查找
        $email          = trim(I('get.email'));    //电子邮箱查找
        $starttime      = urldecode(trim(I('get.starttime')));    //开始时间
        $endtime        = urldecode(trim(I('get.endtime')));    //结束时间
        $ostyle         = trim(I('get.ostyle'));    //买入方向
        $order_result   = trim(I('get.order_result'));        //是否盈利
        $ostaus         = trim(I('get.ostaus'));    //建仓/平仓
        $datetype       = intval(I('get.datetype'));    //日期查找

        $optin_class_max = trim(I('get.optin_class_max'));
        $optin_class_min = trim(I('get.optin_class_min'));
        $option_name     = trim(I('get.option_name'));


        //订单类型
        $type = trim(I('get.type'));
        if ($type) {
            $where['type'] = $type;
            $sea['type']   = $type;
        }


        //手机号查找
        if ($email) {
            $uid             = $user->where([
                'email'  => $email,
                'otype' => 4,
            ])
                                    ->getField('uid');
            $where['uid']       = $uid;
            $sea['email']       = $email;
        }

        if ($orderno) {
            $where['orderno'] = $orderno;
            $sea['orderno']   = $orderno;
        }


        //时间统计
        if ($starttime && $endtime) {
            $start_time       = strtotime($starttime);
            $end_time         = strtotime($endtime);
            $where['buytime'] = [
                'between',
                ''.$start_time.','.$end_time.'',
            ];
            $sea['starttime'] = $starttime;
            $sea['endtime']   = $endtime;
        }
        else {
            $starttime        = strtotime(date('Y-m-d')." 06:00:00");
            $endtime          = strtotime(date('Y-m-d')." 05:00:00") + 3600 * 24;
            $where['buytime'] = [
                'between',
                ''.$starttime.','.$endtime.'',
            ];
            $sea['starttime'] = date('Y-m-d H:i:s', $starttime);
            $sea['endtime']   = date('Y-m-d H:i:s', $endtime);
        }

        if ($ostyle || $ostyle == '0') {
            $where['ostyle'] = [
                "eq",
                $ostyle,
            ];
            $sea['ostyle']   = $ostyle;
        }

        if ($ostaus || $ostaus == '0') {
            $where['ostaus'] = $ostaus;
            $sea['ostaus']   = $ostaus;
        }

        //订单结果筛选
        if ($order_result) {
            $where['order_result'] = $order_result;
            $sea['order_result']   = $order_result;
        }

        $otype     = trim(I('get.otype'));
        $jingjiren = trim(I('get.jingjiren'));
        $userss    = trim(I('get.user'));

        //运营中心筛选
        if ($otype) {
            $userarr  = [];
            $userarr1 = [];
            $ship     = M("UserinfoRelationship")
                ->field('user_id')
                ->where(['parent_user_id' => $otype])
                ->select();
            foreach ($ship as $key => $value) {
                array_push($userarr, $value['user_id']);
            }
            $user_id = implode(',', array_unique($userarr));

            $users = M("UserinfoRelationship")
                ->field('user_id')
                ->where('parent_user_id  in('.$user_id.')')
                ->select();

            foreach ($users as $key => $val) {

                array_push($userarr1, $val['user_id']);
            }
            $id = implode(',', array_unique($userarr1));

            $where['uid'] = [
                'in',
                $id,
            ];
            $sea['otype'] = $otype;
            $this->assign('user_id', $otype);
        }

        //经纪人筛选
        if ($jingjiren) {

            $userarr  = [];
            $userarr1 = [];
            $ship     = M("UserinfoRelationship")
                ->field('user_id')
                ->where(['parent_user_id' => $jingjiren])
                ->select();
            foreach ($ship as $key => $value) {

                array_push($userarr, $value['user_id']);
            }
            $id = implode(',', array_unique($userarr));

            $where['uid']     = [
                'in',
                $id,
            ];
            $sea['jingjiren'] = $jingjiren;
            $this->assign('jingjiren', $this->get_username($jingjiren));
        }

        //用户筛选
        if ($userss) {

            $id           = $userss;
            $where['uid'] = [
                'in',
                $id,
            ];
            $sea['user']  = $userss;
            $this->assign('user', $this->get_username($userss));
        }

        //分类大类
        if ($optin_class_max) {
            $classObj = M('OptionClassify');
            $data     = $classObj->field('group_concat(distinct id) id')
                                 ->where(['pid' => $optin_class_max])
                                 ->find();

            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')
                                ->where('pid in('.$data['id'].')')
                                ->find();

            $where['pid'] = [
                'in',
                $option['id'],
            ];

            $sea['optin_class_max'] = $optin_class_max;
            $this->assign('optin_class_max', $optin_class_max);
        }

        //分类小类
        if ($optin_class_min) {
            $classObj  = M('OptionClassify');
            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')
                                ->where('pid='.$optin_class_min)
                                ->find();

            $where['pid'] = [
                'in',
                $option['id'],
            ];

            $mindata = $classObj->field('id,name')
                                ->where('id in('.$data['id'].')')
                                ->select();

            $sea['optin_class_min'] = $optin_class_min;
            $this->assign('mindata', $mindata);
            $this->assign('optin_class_min', $optin_class_min);
        }

        //产品名称
        if ($option_name) {
            $where['pid'] = $option_name;

            $optionObj = M('option');

            $option = $optionObj->field('id,capital_name')
                                ->where('pid='.$optin_class_min)
                                ->select();

            $sea['option_name'] = $option_name;
            $this->assign('option', $option);
            $this->assign('option_name', $option_name);
        }


        //昨天
        $this->assign("starttimeYesterday", date('Y-m-d 06:00:00', strtotime('-1 day')));
        $this->assign("endtimeYesterday", date('Y-m-d 05:00:00'));
        //今天
        //		$this->assign("starttimeToday", date('Y-m-d 06:00:00'));
        //		$this->assign("endtimeToday", date('Y-m-d 05:00:00',strtotime('+1 day')));
        //本周
        $this->assign("starttimeWeek", date('Y-m-d 06:00:00', strtotime('-1 monday')));
        $this->assign("endtimeWeek", date('Y-m-d 05:00:00', strtotime('+1 day')));
        //上周
        $this->assign("starttimeLastWeek", date('Y-m-d 06:00:00', strtotime('-2 monday')));
        $this->assign("endtimeLastWeek", date('Y-m-d 05:00:00', strtotime('-1 monday')));
        //上月
        $this->assign("starttimeLastMonth", date('Y-m-01 06:00:00', strtotime('-1 month')));
        $this->assign("endtimeLastMonth", date('Y-m-d H:i:s', strtotime(date('Y-m-t 05:00:00', strtotime('-1 month'))) + 3600 * 24));


        if ($datetype > 0) {
            $sea['datetype'] = $datetype;
            $this->assign("datetype", $datetype);
        }


        $count = $order->where($where)
                       ->count();

        $pagecount       = 10;
        $page            = new \Think\Page($count, $pagecount);
        $page->parameter = $sea; //此处的row是数组，为了传递查询条件
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $start = $page->firstRow;
        $end   = $page->listRows;

        $tlist = $order->where($where)
                       ->order('oid desc')
                       ->limit($start, $end)
                       ->select();

        $uidArr = [];
        foreach ($tlist as $key => $value) {
            array_push($uidArr, $value['uid']);
        }

        if ($uidArr) {
            $uid      = implode(',', array_unique($uidArr));
            $userinfo = $user->where('uid in ('.$uid.')')
                             ->getField('uid,email,username,nickname', true);
        }

        foreach ($tlist as $key => $value) {
            $tlist[ $key ]['email']    = $userinfo[ $value['uid'] ]['email'];
            $tlist[ $key ]['username'] = $userinfo[ $value['uid'] ]['username'];
            $tlist[ $key ]['nickname'] = $userinfo[ $value['uid'] ]['nickname'];

            if ($value['ostaus'] == 1) {
                $tlist[ $key ]['access'] = (($value['ploss']) - $value['fee']) - $value['overnight_fee'];
            }
            else {
                $tlist[ $key ]['access'] = -($value['Bond'] + $value['fee']) + $value['overnight_fee'];
            }

        }

        /********************底部统计**************************/

        $data['count'] = $count;    //总订单
        $orderSta      = $order->field('sum(fee) fee,sum(overnight_fee) overnight_fee,sum(Bond) Bond,sum(ploss) ploss')
                               ->where($where)
                               ->find();

        $data['fee']           = $orderSta['fee'];
        $data['bond']          = $orderSta['Bond'];
        $data['overnight_fee'] = $orderSta['overnight_fee'];
        $data['account']       = ($data['fee'] + $data['bond'] + $data['overnight_fee']);

        $data['ploss'] = $orderSta['ploss'];
        /**********************************************/

        //产品大类
        $classify = M('option_classify')
            ->field('id,name')
            ->where(['level' => 1])
            ->select();
        $this->assign('classify', $classify);

        $this->assign('sea', $sea);
        $this->assign('tlist', $tlist);
        $this->assign('page', $page->show());
        $this->assign('info', $user->field('uid,username')
                                   ->where(["otype" => 5])
                                   ->select());
        $this->assign('data', $data);

        if ($type == 1) {
            $this->display();
        }
        else {
            $this->display('moni');
        }

    }


    public function daochu()
    {
        $user = A('Admin/User');
        $user->checklogin();

        $tq    = C('DB_PREFIX');
        $user  = D('userinfo');
        $order = M('order');

        $where        = "";
        $orderno      = trim(I('get.orderno'));                 //订单号查找
        $email        = trim(I('get.email'));    //电子邮箱查找
        $starttime    = urldecode(trim(I('get.starttime')));    //开始时间
        $endtime      = urldecode(trim(I('get.endtime')));      //结束时间
        $ostyle       = trim(I('get.ostyle'));                  //买入方向
        $order_result = trim(I('get.order_result'));            //是否盈利
        $ostaus       = trim(I('get.ostaus'));                  //建仓/平仓
        $datetype     = intval(I('get.datetype'));              //日期查找

        $optin_class_max = trim(I('get.optin_class_max'));
        $optin_class_min = trim(I('get.optin_class_min'));
        $option_name     = trim(I('get.option_name'));


        //订单类型
        $type = trim(I('get.type'));
        if ($type) {
            $where['type'] = $type;
        }

        //手机号查找
        if ($email) {
            $uid             = $user->where([
                'email'  => $email,
                'otype' => 4,
            ])
                                    ->getField('uid');
            $where['uid']       = $uid;
            $sea['email']       = $email;
        }

        if ($orderno) {
            $where['orderno'] = $orderno;
        }


        //时间统计
        if ($starttime && $endtime) {
            $start_time       = strtotime($starttime);
            $end_time         = strtotime($endtime);
            $where['buytime'] = [
                'between',
                ''.$start_time.','.$end_time.'',
            ];
        }
        else {
            $starttime        = strtotime(date('Y-m-d')." 06:00:00");
            $endtime          = strtotime(date('Y-m-d')." 05:00:00") + 3600 * 24;
            $where['buytime'] = [
                'between',
                ''.$starttime.','.$endtime.'',
            ];
        }

        if ($ostyle || $ostyle == '0') {
            $where['ostyle'] = [
                "eq",
                $ostyle,
            ];
        }

        if ($ostaus || $ostaus == '0') {
            $where['ostaus'] = $ostaus;
        }

        //订单结果筛选
        if ($order_result) {
            $where['order_result'] = $order_result;
            $sea['order_result']   = $order_result;
        }

        $otype     = trim(I('get.otype'));
        $jingjiren = trim(I('get.jingjiren'));
        $userss    = trim(I('get.user'));

        //运营中心筛选
        if ($otype) {
            $userarr  = [];
            $userarr1 = [];
            $ship     = M("UserinfoRelationship")
                ->field('user_id')
                ->where(['parent_user_id' => $otype])
                ->select();
            foreach ($ship as $key => $value) {
                array_push($userarr, $value['user_id']);
            }
            $user_id = implode(',', array_unique($userarr));

            $users = M("UserinfoRelationship")
                ->field('user_id')
                ->where('parent_user_id  in('.$user_id.')')
                ->select();

            foreach ($users as $key => $val) {

                array_push($userarr1, $val['user_id']);
            }
            $id = implode(',', array_unique($userarr1));

            $where['uid'] = [
                'in',
                $id,
            ];
        }

        //经纪人筛选
        if ($jingjiren) {

            $userarr  = [];
            $userarr1 = [];
            $ship     = M("UserinfoRelationship")
                ->field('user_id')
                ->where(['parent_user_id' => $jingjiren])
                ->select();
            foreach ($ship as $key => $value) {

                array_push($userarr, $value['user_id']);
            }
            $id = implode(',', array_unique($userarr));

            $where['uid'] = [
                'in',
                $id,
            ];
        }

        //用户筛选
        if ($userss) {

            $id           = $userss;
            $where['uid'] = [
                'in',
                $id,
            ];
        }

        //分类大类
        if ($optin_class_max) {
            $classObj = M('OptionClassify');
            $data     = $classObj->field('group_concat(distinct id) id')
                                 ->where(['pid' => $optin_class_max])
                                 ->find();

            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')
                                ->where('pid in('.$data['id'].')')
                                ->find();

            $where['pid'] = [
                'in',
                $option['id'],
            ];
        }

        //分类小类
        if ($optin_class_min) {
            $classObj  = M('OptionClassify');
            $optionObj = M('option');

            $option = $optionObj->field('group_concat(distinct id) id')
                                ->where('pid='.$optin_class_min)
                                ->find();

            $where['pid'] = [
                'in',
                $option['id'],
            ];

            $mindata = $classObj->field('id,name')
                                ->where('id in('.$data['id'].')')
                                ->select();
        }

        //产品名称
        if ($option_name) {
            $where['pid'] = $option_name;

            $optionObj = M('option');

            $option = $optionObj->field('id,capital_name')
                                ->where('pid='.$optin_class_min)
                                ->select();
        }


        $tlist = $order->where($where)
                       ->order('oid desc')
                       ->select();

        $uidArr = [];
        foreach ($tlist as $key => $value) {
            array_push($uidArr, $value['uid']);
        }

        if ($uidArr) {
            $uid      = implode(',', array_unique($uidArr));
            $userinfo = $user->where('uid in ('.$uid.')')
                             ->getField('uid,email,username,nickname', true);
        }

        foreach ($tlist as $key => $value) {
            $tlist[ $key ]['email']   = $userinfo[ $value['uid'] ]['email'];
            $tlist[ $key ]['username'] = $userinfo[ $value['uid'] ]['username'];
            $tlist[ $key ]['nickname'] = $userinfo[ $value['uid'] ]['nickname'];

            if ($value['ostaus'] == 1) {
                $tlist[ $key ]['access'] = (($value['ploss']) - $value['fee']) - $value['overnight_fee'];
            }
            else {
                $tlist[ $key ]['access'] = -($value['Bond'] + $value['fee']) + $value['overnight_fee'];
            }
        }

        $data[0] = [
            '编号',
            '订单号',
            '用户名称',
            '用户昵称',
            '电子邮箱',
            '运营中心',
            '销售',
            '建仓时间',
            '平仓时间',
            '产品信息',
            '数量(手)',
            '方向',
            "止盈",
            "止损",
            '保证金',
            '手续费',
            '隔夜费',
            '买入价',
            '卖出价',
            '买入时长',
            '出入金',
            '盈亏',
            '平仓类型',
            '订单结果',
            '订单类型',
        ];

        foreach ($tlist as $key => $val) {
            $data[ $key + 1 ][] = $val['oid'];
            $data[ $key + 1 ][] = $val['orderno'];
            $data[ $key + 1 ][] = $val['username'];
            $data[ $key + 1 ][] = $val['nickname'];
            $data[ $key + 1 ][] = $val['email'];
            $data[ $key + 1 ][] = change(exchange($val['uid'], 2));
            $data[ $key + 1 ][] = change(exchange($val['uid'], 1));
            $data[ $key + 1 ][] = date('Y-m-d H:i:s', $val['buytime']);

            if ($val['ostaus'] == 0) {
                $data[ $key + 1 ][] = '--';
            }
            else {
                $data[ $key + 1 ][] = date('Y-m-d H:i:s', $val['selltime']);
            }

            $data[ $key + 1 ][] = $val['option_name'];
            $data[ $key + 1 ][] = $val['order_scene'] == 1 ? $val['onumber'] : '--';

            if ($val['ostyle'] == 0) {
                $data[ $key + 1 ][] = '买入';
            }
            else {
                $data[ $key + 1 ][] = '卖出';
            }

            if($val['order_scene'] == 1) {
                $data[ $key + 1 ][] = $val['endprofit'];
                $data[ $key + 1 ][] = $val['endloss'];
            } else {
                $data[ $key + 1 ][] = '--';
                $data[ $key + 1 ][] = '--';
            }

            $data[ $key + 1 ][] = $val['Bond'];
            $data[ $key + 1 ][] = $val['fee'];
            $data[ $key + 1 ][] = $val['order_scene'] == 1 ? $val['overnight_fee'] : '--';
            $data[ $key + 1 ][] = $val['buyprice'];

            if ($val['ostaus'] == 0) {
                $data[ $key + 1 ][] = '--';
            }
            else {
                $data[ $key + 1 ][] = $val['sellprice'];
            }

            $data[ $key + 1 ][] = $val['order_scene'] == 1 ? '--' : $val['second'].'秒';

            $data[ $key + 1 ][] = $val['access'];
            $data[ $key + 1 ][] = $val['ploss'];

            if ($val['ostaus'] == 0) {
                $data[ $key + 1 ][] = '--';
            }
            else {
                $data[ $key + 1 ][] = $val['auto'] == 1 ? '手动' : '自动';
            }

            if ($val['ostaus'] == 0) {
                $data[ $key + 1 ][] = '--';
            }
            else {
                if ($val['order_result'] == 1) {
                    $data[ $key + 1 ][] = '平局';
                }
                elseif ($val['order_result'] == 2) {
                    $data[ $key + 1 ][] = '盈利';
                }
                else {
                    $data[ $key + 1 ][] = '亏损';
                }
            }

            if ($val['order_type'] == 1) {
                $data[ $key + 1 ][] = '自持';
            }
            elseif ($val['order_type'] == 2) {
                $data[ $key + 1 ][] = '跟随';
            }
            else {
                $data[ $key + 1 ][] = '挂单';
            }
        }

        $name = $type == 1 ? '实盘交易流水' : '模拟交易流水';
        $name = $name;
        $res  = $this->push($data, $name);
    }


    public function push($data, $name)
    {
        import("Excel.class.php");
        $excel = new Excel();
        $excel->download($data, $name);
    }


    private function get_username($uid = 0)
    {
        $info = M("userinfo")
            ->field('uid,username')
            ->where([
                'uid' => $uid,
            ])
            ->find();

        return $info ? $info : null;
    }


    /**
     * getOptionClassify 客户端请求获取产品分类
     * @author wang li
     * @return json  下级分类信息
     */
    public function getOptionClassify()
    {
        $classObj = M('OptionClassify');

        $parent_id = trim(I('get.parent_id'));

        $data = $classObj->field('id,name')
                         ->where(['pid' => $parent_id])
                         ->select();

        if ($data) {
            outjson([
                'data'   => $data,
                'status' => 1,
            ]);
        }
        else {
            outjson([
                'data'   => $data,
                'status' => 0,
            ]);
        }
    }

    /**
     * getOption 客户端请求产品分类获取产品信息
     * @author wang li
     * @return json  产品名称
     */
    public function getOption()
    {
        $parent_id = trim(I('get.parent_id'));

        $optionObj = M('option');

        $data = $optionObj->field('id,capital_name')
                          ->where(['pid' => $parent_id])
                          ->select();

        if ($data) {
            outjson([
                'data'   => $data,
                'status' => 1,
            ]);
        }
        else {
            outjson([
                'data'   => $data,
                'status' => 0,
            ]);
        }
    }

}
