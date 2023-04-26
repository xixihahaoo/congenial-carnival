<?php
namespace Home\Controller;

use Think\Controller;

class CommonController extends Controller
{

    public function _initialize()
    {
        if (!isMobile()) {
            $controller = CONTROLLER_NAME;
            $action     = ACTION_NAME;

            $getParam = $_GET;
            $params   = '';
            foreach ($getParam as $key => $val) {
                $params .= $key.'/'.$val.'/';
            }

            $params = rtrim($params, '/');

            return $this->redirect('/Pc/'.$controller.'/'.$action.'/'.$params);
        }

        //当前语言包
        $lang = cookie('think_language');

        if(empty($lang) || $lang == 'zh') {
            $lang = 'en-us';
        }

        cookie('think_language', $lang, (7 * 86400));

        define('LANG', $lang);

        if (LANG == 'zh-tw')     //如果当前语言包为繁体，则显示简体内容
        {
            define('LANG_SHOW', 'zh-cn');
        } else {
            define('LANG_SHOW', LANG);
        }


        $user_id = $_COOKIE['user_id'];    //判断cookie是否存在

        if (!empty($user_id)) {
            $user = M('userinfo')
                ->field('uid,username,utel,now_trade_status')
                ->where(['uid'     => $user_id,
                         'otype'   => 4,
                         'ustatus' => 0,
                ])
                ->find();
            if ($user) {
                session('user_id', $user['uid']);
                session('username', $user['username']);
                session('utel', $user['utel']);
            } else {
                unset($_SESSION['user_id']);
                unset($_SESSION['username']);
                unset($_SESSION['utel']);

                setcookie('user_id', '', time() - 3600, '/');
                $this->redirect('Index/index');
            }
        }

        $this->user_id = session('user_id');

        // 需要验证登陆验证的路由 by wang 2018-4-01     
        $excluded_rotuers = [
            '/Home/Index/orderfollow',
            '/Home/Index/tradeuser',
        ];

        if (empty($this->user_id)) {
            if (in_array(__ACTION__, $excluded_rotuers)) {
                $this->redirect('Login/login');
            }
        }

        //消息中心查看用户是否有未读消息
        $flowObj  = M('money_flow');
        $sqlWhere = " YEARWEEK(FROM_UNIXTIME(dateline,'%Y-%m-%d'),1) = YEARWEEK(DATE_FORMAT(now(),'%Y-%m-%d'),1) and uid={$this->user_id} and is_read = 1";

        $NoreadCount = $flowObj->where($sqlWhere)
                               ->count();
        $this->assign('NoreadCount', $NoreadCount);


        //查看历史订单是否存在未读
        $orderObj         = M('order');
        $orderStatusCount = $orderObj->where(['uid'     => $this->user_id,
                                              'ostaus'  => 1,
                                              'is_read' => 1,
                                              'type'    => $user['now_trade_status'],
        ])
                                     ->count();
        $this->assign('orderStatusCount', $orderStatusCount);

        //取出用户余额        
        if (isset($this->user_id)) {
            //账号余额
            $user = M('accountinfo')
                ->where(['uid' => $this->user_id])
                ->find();
            $this->assign('user', $user);
        }

        //获取上一页链接
        $this->assign('urlcan', $_SERVER['HTTP_REFERER']);
    }

}
