<?php

namespace Admin\Controller;

use Think\Controller;

class BaseController extends Controller
{

    public function __construct()
    {

        parent::__construct();

        if(!in_array(strtolower(CONTROLLER_NAME.'/'.ACTION_NAME),[
            'user/signin',
            'user/signinout',
            'user/googleauth',
        ])){

            $server         = parse_url($_SERVER['HTTP_REFERER']);
            $server['host'] = str_replace("www.","",$server['host']);
            //判断请求域名是否合法
            if($server['host'] != constant('ADMIN_URL')) {
                session(null);
                $this->error('请登录', '/login/User/signin');
                die;
            }

            $uid = islogin();
            if (!$uid) {
                $this->error('请登录', '/login/User/signin');
                die;
            }
        }

        static $i = 0;
        if ($i == 0 && $_SESSION['userid'] > 0) {
            $data['action'] = strtolower(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME);

            if ($data['action'] != 'admin/position/getdata') {
                $data['action_name'] = $this->getActionDesc($data['action']);

                if (!empty($data['action_name'])) {
                    $data['cTime'] = date("Y-m-d H:i:s");
                    if ($_SESSION['newusername']) {
                        $data['uname'] = $_SESSION['newusername'];
                    }
                    else {
                        $data['uname'] = $_SESSION['username'];
                    }
                    $data['uid']        = $_SESSION['userid'];
                    $data['login_sign'] = $_SESSION['login_sign'];
                    if (IS_GET) {
                        $data['params'] = implode(",", $_GET);
                    }
                    elseif (IS_POST) {
                        $data['params'] = implode(",", $_POST);
                    }
                    $data['request_method'] = IS_POST ? 'POST' : 'GET';
                    M("action_log")->add($data);
                }
            }
            $i++;

            //            $this->assign('route',strtolower(CONTROLLER_NAME . '-' . ACTION_NAME));

            $this->assign('route', CONTROLLER_NAME);
            //菜单
            $this->assign('menus', json_decode(session('menus'), true));
        }
    }


    private function getActionDesc($action)
    {
        $desc = [
            'admin/index/index' => '系统首页-系统首页',

            'admin/news/typelist' => '内容管理-》栏目管理',
            'admin/news/newslist' => '内容管理-》文章管理',

            'admin/country/lists' => '国家管理-》国家列表',
            'admin/country/add'   => '国家管理-》添加国家',

            'admin/goods/goods_list'     => '产品管理-》产品列表',
            'admin/goods/time_list'      => '产品管理-》时间交易',
            'admin/goods/goods_classify' => '产品管理-》产品分类',

            'admin/position/tlist' => '持仓管理-》持仓订单',

            'admin/order/tlist' => '订单管理-》交易流水',

            'admin/user/ulist'      => '客户管理-》客户列表',
            'admin/user/money_flow' => '客户管理-》资金流水',

            'admin/recharge/lists'          => '客户资金-》充值记录',
            'admin/withdraw/lists'          => '客户资金-》提现申请',

            'admin/trader/index'       => '交易员-》交易员列表',
            'admin/user/traderexamine' => '客户管理-》交易员审核',

            'admin/extension/index'           => '推广管理-》推广员列表',
            'admin/extension/extension'       => '推广管理-》佣金转出记录',
            'admin/extension/extension_water' => '推广管理-》佣金流水',

            'admin/super/sadd'      => '系统管理员-》添加管理员',
            'admin/super/slist'     => '系统管理员-》管理员列表',
            'admin/super/loginlog'  => '系统管理员-》登陆日志',
//            'admin/super/actionlog' => '系统管理员-》操作日志',

            'admin/tools/basic'             => '系统设置-》基本设置',
            'admin/tools/setting_list'      => '系统设置-》系统货币设置',
            'admin/tools/product_sell_time' => '系统设置-》禁止下单时间',
            'admin/tools/commission_rate'   => '系统设置-》佣金返还金额',
            'admin/tools/commission_time'   => '系统设置-》佣金返还时间',
            'admin/tools/product_number'    => '系统设置-》用户交易手数',
            'admin/tools/setting_dollar'    => '系统设置-》美元汇率设置',

            'admin/operate/index' => '运营中心-》运营中心列表',
            'admin/operate/add'   => '运营中心-》添加运营',
            'admin/operate/flow'  => '运营中心-》资金流水',

            'admin/agent/index'  => '销售商-》销售商列表',
            'admin/agent/add'    => '销售商-》添加销售商',
            'admin/agent/tongji' => '销售商-》出入金统计',

            'admin/stretch/index' => '公告消息-》公告列表',

//            'admin/live/room'    => '直播管理-》房间列表',
//            'admin/live/anchor'  => '直播管理-》主播列表',
//            'admin/live/message' => '直播管理-》历史消息',

            'admin/datareview/bank'           => '资料审核-》银行卡审核',

            'admin/role/get_list' => '权限控制-》角色管理',
        ];

        return $desc[ $action ];
    }
}