<?php
namespace Pc\Controller;

use Think\Controller;

class CommonController extends Controller
{

    public function _initialize()
    {
        if (isMobile()) {
            $controller = CONTROLLER_NAME;
            $action     = ACTION_NAME;

            $getParam = $_GET;
            $params   = '';
            foreach ($getParam as $key => $val) {
                $params .= $key.'/'.$val.'/';
            }

            $params = rtrim($params, '/');

            return $this->redirect('/Home/'.$controller.'/'.$action.'/'.$params);
        }

        //当前语言包
        $lang = cookie('think_language');

        if(!in_array($lang,explode(',',C('LANG_LIST')))) {
            $lang = C('DEFAULT_LANG');
            cookie('think_language', $lang, (30 * 86400));
            header("Refresh:0; url=/");
            exit;
        }

        cookie('think_language', $lang, (30 * 86400));

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
                ->field('uid,username,utel,now_trade_status,nickname,face,code,level_id')
                ->where([
                    'uid'     => $user_id,
                    'otype'   => 4,
                    'ustatus' => 0,
                ])
                ->find();

            $levelData = M('user_level')->getField('id,level', true);

            $user['level'] = $levelData[$user['level_id']];

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
        //本周数据
//        $sqlWhere = " YEARWEEK(FROM_UNIXTIME(dateline,'%Y-%m-%d'),1) = YEARWEEK(DATE_FORMAT(now(),'%Y-%m-%d'),1) and uid={$this->user_id} and is_read = 1";

        //近三个月数据
        $sqlWhere = "FROM_UNIXTIME(dateline,'%Y-%m-%d') > DATE_SUB(CURDATE(), INTERVAL 3 MONTH) and uid={$this->user_id} and is_read = 1";

        $NoreadCount = $flowObj->where($sqlWhere)
                               ->count();
        $this->assign('NoreadCount', $NoreadCount);

        //取出用户余额        
        if (isset($this->user_id)) {
            //账号余额
            $account = M('accountinfo')
                ->where(['uid' => $this->user_id])
                ->find();

            $this->assign('user', $account);
            $this->assign('public_account',$account);
            $this->assign('public_user', $user);
        }

        //获取网站配置
        $config = M('webconfig')->find();
        $config['footer_desc'] = htmlspecialchars_decode($config['footer_desc']);
        $this->assign('config',$config);

        //个人中心位置
        $this->get_current_location();

        //获取上一页链接
        $this->assign('urlcan', $_SERVER['HTTP_REFERER']);
        $this->assign('lang', $lang);
    }


    public function get_current_location()
    {
        //会员中心当前位置

        $personalCenter = '<a href="'.U('User/index').'">'.L('location_personal_center').'</a>';

        $following = '<a href="'.U('Follow/index').'">'.L('location_following').'</a>';

        $location_message = '<a href="'.U('Message/index').'">'.L('location_message').'</a>';

        $location_promotion = '<a href="'.U('Extension/index').'">'.L('location_promotion').'</a>';

        $current_location = [
            'User/index' => [
                'first' => L('location_personal_center'),
                'last'  => ''
            ],
            'Recharge/index' => [
                'first' => $personalCenter,
                'last'  => '<li class="uk-active"><span>'.L('location_recharge').'</span></li>'
            ],
            'Recharge/agreement' => [
                'first' => $personalCenter,
                'last'  => '<li><a href="'.U('Recharge/index').'">'.L('location_recharge').'</a></li>
                        <li class="uk-active"><span>'.L('location_recharge_agreement').'</span></li>'
            ],
            'Recharge/rechargeDetails' => [
                'first' => $personalCenter,
                'last'  => '<li><a href="'.U('Recharge/index').'">'.L('location_recharge').'</a></li>
                        <li class="uk-active"><span>'.L('location_recharge_details').'</span></li>'
            ],
            'Withdrawals/index' => [
                'first' => $personalCenter,
                'last'  => '<li class="uk-active"><span>'.L('location_withdrawal').'</span></li>'
            ],
            'Withdrawals/withdrawList' => [
                'first' => $personalCenter,
                'last'  => '<li><a href="'.U('Withdrawals/index').'">'.L('location_withdrawal').'</a></li>
                        <li class="uk-active"><span>'.L('location_withdrawal_details').'</span></li>'
            ],
            'Setting/bindEmail' => [
                'first' => $personalCenter,
                'last'  => '<li class="uk-active"><span>'.L('location_bind_mailbox').'</span></li>'
            ],
            'Setting/modifyLoginPwd' => [
                'first' => $personalCenter,
                'last'  => '<li class="uk-active"><span>'.L('location_edit_pwd').'</span></li>'
            ],
            'User/select_bind_card' => [
                'first' => $personalCenter,
                'last'  => '<li class="uk-active"><span>'.L('location_binding_mode').'</span></li>'
            ],
            'User/currency_bind' => [
                'first' => $personalCenter,
                'last'  => '<li class="uk-active"><span>'.L('location_bind_currency_mode').'</span></li>'
            ],
            'User/BrokersOpen' => [
                'first' => $personalCenter,
                'last'  => '<li class="uk-active"><span>'.L('location_add_back').'</span></li>'
            ],
            'User/nicknameSave' => [
                'first' => $personalCenter,
                'last'  => '<li class="uk-active"><span>'.L('location_modify_nickname').'</span></li>'
            ],
            'User/BrokersSwitch' => [
                'first' => $personalCenter,
                'last'  => '<li class="uk-active"><span>'.L('location_account_switch').'</span></li>'
            ],


            'Investment/index' => [
                'first' => L('location_statistics'),
                'last'  => ''
            ],


            'Follow/index' => [
                'first' => $following,
                'last'  => '<li class="uk-active"><span>'.L('location_i_follower').'</span></li>'
            ],
            'Follow/userTrade' => [
                'first' => $following,
                'last'  => '<li class="uk-active"><span>'.L('location_i_trader').'</span></li>'
            ],
            'Follow/rule' => [
                'first' => $following,
                'last'  => '<li class="uk-active"><span>'.L('location_rules').'</span></li>'
            ],
            'Index/tradeUser' => [
                'first' => $following,
                'last'  => '<li class="uk-active"><span>'.L('location_apply_trader').'</span></li>'
            ],
            'Index/orderFollow' => [
                'first' => $following,
                'last'  => '<li class="uk-active"><span>'.L('location_orderfollow_way').'</span></li>'
            ],
            'Index/agreementFollow' => [
                'first' =>  $following,
                'last'  => '<li class="uk-active"><span>'.L('location_orderfollow_agreement').'</span></li>'
            ],


            'Message/index' => [
                'first' =>  $location_message,
                'last'  => '<li class="uk-active"><span>'.L('location_system_message').'</span></li>'
            ],
            'Message/stretchDetails' => [
                'first' =>  $location_message,
                'last'  => '<li><a href="'.U('Message/index').'">'.L('location_system_message').'</a></li>
                        <li class="uk-active"><span>'.L('location_details').'</span></li>'
            ],
            'Message/publicMsg' => [
                'first' =>  $location_message,
                'last'  => '<li class="uk-active"><span>'.L('location_notice_message').'</span></li>'
            ],
            'Stretch/stretchDetails' => [
                'first' =>  $location_message,
                'last'  => '<li><a href="'.U('Message/publicMsg').'">'.L('location_notice_message').'</a></li>
                        <li class="uk-active"><span>'.L('location_details').'</span></li>'
            ],


            'Setting/aboutwe' => [
                'first' =>  L('location_about_us'),
                'last'  => ''
            ],
            'Setting/details' => [
                'first' =>  '<a href="'.U('Setting/aboutwe').'">'.L('location_about_us').'</a>',
                'last'  => '<li class="uk-active"><span>'.L('location_details').'</span></li>'
            ],


            'Help/help' => [
                'first' =>  L('location_help_center'),
                'last'  => ''
            ],
            'Help/details' => [
                'first' =>  '<a href="'.U('Help/help').'">'.L('location_help_center').'</a>',
                'last'  => '<li class="uk-active"><span>'.L('location_details').'</span></li>'
            ],
            'Help/Risk' => [
                'first' =>  L('location_risk_warning'),
                'last'  => ''
            ],


            'Extension/index' => [
                'first' =>  L('location_promotion'),
                'last'  => ''
            ],
            'Extension/changeAccount' => [
                'first' =>  $location_promotion,
                'last'  => '<li class="uk-active"><span>'.L('location_transfer_account').'</span></li>'
            ],
            'Extension/changeRecord' => [
                'first' =>  $location_promotion,
                'last'  => '<li><a href="'.U('Extension/changeAccount').'">'.L('location_transfer_account').'</a></li>
                        <li class="uk-active"><span>'.L('location_transfer_history').'</span></li>'
            ],
            'Extension/friend' => [
                'first' =>  $location_promotion,
                'last'  => '<li class="uk-active"><span>'.L('location_my_friend').'</span></li>'
            ],
            'Extension/income' => [
                'first' =>  $location_promotion,
                'last'  => '<li class="uk-active"><span>'.L('location_accumulated').'</span></li>'
            ],
            'Extension/levelRule' => [
                'first' =>  $location_promotion,
                'last'  => '<li class="uk-active"><span>'.L('location_rules').'</span></li>'
            ],

            'UsdtPay/index' => [
                'first' => $personalCenter,
                'last'  => '<li><a href="'.U('Recharge/index').'">'.L('location_recharge').'</a></li>
                        <li class="uk-active"><span>'.L('location_recharge_usdt').'</span></li>'
            ],
            'UsdtPay/img_upload' => [
                'first' => $personalCenter,
                'last'  => '<li><a href="'.U('Recharge/index').'">'.L('location_recharge').'</a></li>
                            <li class="uk-active"><span>'.L('location_recharge_img').'</span></li>'
            ],
            'UsdtPay/rechargecheck' => [
                'first' => $personalCenter,
                'last'  => '<li><a href="'.U('Recharge/index').'">'.L('location_recharge').'</a></li>
                        <li class="uk-active"><span>'.L('location_recharge_confirm').'</span></li>'
            ],

            'Contact/info' => [
                'first' =>  L('location_service'),
                'last'  => ''
            ],
        ];

        $position_arr = [];
        foreach ($current_location as $key => $value) {
            $position_arr[strtolower($key)] = $value;
        }

        unset($current_location);

        $route = strtolower(CONTROLLER_NAME.'/'.ACTION_NAME);

        if(isset($position_arr[$route])) {
            $this->assign('current_location',$position_arr[$route]);
        }
    }
}
