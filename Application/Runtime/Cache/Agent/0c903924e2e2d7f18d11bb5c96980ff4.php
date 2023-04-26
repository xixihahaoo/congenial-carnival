<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>代理商后台</title>
    <meta name="keywords" content="代理商后台管理系统" />
    <meta name="description" content="代理商后台管理系统" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- basic styles -->
    <link href="/Public/Ucenter/proxy/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/Public/Ucenter/proxy/assets/css/font-awesome.min.css" />

    <!--[if IE 7]>
    <link rel="stylesheet" href="/Public/Ucenter/proxy/assets/css/font-awesome-ie7.min.css" />
    <![endif]-->

    <!-- page specific plugin styles -->

    <!-- fonts

    <link rel="stylesheet" href="/Public/Ucenter/proxy/assets\css\cyrillic.css" />
-->
    <!-- ace styles -->

    <link rel="stylesheet" href="/Public/Ucenter/proxy/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/Public/Ucenter/proxy/assets/css/ace-rtl.min.css" />
    <link rel="stylesheet" href="/Public/Ucenter/proxy/assets/css/ace-skins.min.css" />

    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/Public/Ucenter/proxy/assets/css/ace-ie.min.css" />
    <![endif]-->

    <!-- inline styles related to this page -->

    <!-- ace settings handler -->

    <script src="/Public/Ucenter/proxy/assets/js/ace-extra.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="/Public/Ucenter/proxy/assets/js/html5shiv.js"></script>
    <script src="/Public/Ucenter/proxy/assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="navbar navbar-default" id="navbar">
    <script type="text/javascript">
        try{ace.settings.check('navbar' , 'fixed')}catch(e){}
    </script>

    <div class="navbar-container" id="navbar-container">
        <div class="navbar-header pull-left">
            <a href="#" class="navbar-brand">
                <small>
                    <i class="icon-leaf"></i>
                   代理商管理后台  (<?php echo ($levels); ?>)
                </small>
            </a><!-- /.brand -->
        </div><!-- /.navbar-header -->

        <div class="navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="light-blue">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <img class="nav-user-photo" src="/Public/Ucenter/proxy/assets/avatars/user.jpg" alt="Jason's Photo" />
                        <span class="user-info">
                            <small>欢迎光临,</small><?php echo ($user_nickname); ?>
                        </span>
                        <i class="icon-caret-down"></i>
                    </a>

                    <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="<?php echo U('Agent/Proxy/sys_info');?>">
                                <i class="icon-cog"></i>
                                个人资料
                            </a>
                        </li>
 
                        <li>
                            <a href="<?php echo U('Agent/Proxy/change_password');?>">
                                <i class="icon-user"></i>
                                修改密码
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="<?php echo U('Agent/Login/login_out');?>">
                                <i class="icon-off"></i>
                                安全退出
                            </a>
                        </li>
                    </ul>
                </li>
            </ul><!-- /.ace-nav -->
        </div><!-- /.navbar-header -->
    </div><!-- /.container -->
</div>
<div class="main-container" id="main-container">
    <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){}
    </script>
<div class="main-container-inner">
    <a class="menu-toggler" id="menu-toggler" href="#">
        <span class="menu-text"></span>
    </a>

    <div class="sidebar" id="sidebar">
        <script type="text/javascript">
            try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
        </script>


        <ul class="nav nav-list">
            <li <?php if(($nowMenu == 'index') and ($nowAct == 'index')): ?>class="active"<?php endif; ?>>
                <a href="<?php echo U('index/index');?>">
                    <i class="icon-dashboard"></i>
                    <span class="menu-text"> 控制台 </span>
                </a>
            </li>

            <!-- 用户 -->
            <li <?php if(($nowMenu == 'user')): ?>class="active open"<?php endif; ?>>
                <a href="#" class="dropdown-toggle">
                    <i class="icon-group"></i>
                    <span class="menu-text">用户管理</span>

                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    <li <?php if(($nowAct == 'user_list') or ($nowAct == 'user_detail') or ($nowAct == 'subordinateuser')): ?>class="active"<?php endif; ?>>
                        <a href="/Agent/user/user_list">
                            <i class="icon-double-angle-right"></i>
                            用户列表
                        </a>
                    </li>

                    <li <?php if(($nowAct == 'recharge')): ?>class="active"<?php endif; ?>>
                        <a href="/Agent/user/recharge">
                            <i class="icon-double-angle-right"></i>
                            充值记录
                        </a>
                    </li>

                    <li <?php if(($nowAct == 'withdrawal')): ?>class="active"<?php endif; ?>>
                        <a href="/Agent/user/withdrawal">
                            <i class="icon-double-angle-right"></i>
                            提现记录
                        </a>
                    </li>
                    <li <?php if(($nowAct == 'money_flow') or ($nowAct == 'money_flow')): ?>class="active"<?php endif; ?>>
                        <a href="/Agent/user/money_flow">
                            <i class="icon-double-angle-right"></i>
                            资金流水
                        </a>
                    </li>
                    <!--<li <?php if(($nowAct == 'integral_flow') or ($nowAct == 'integral_flow')): ?>class="active"<?php endif; ?>>-->
                        <!--<a href="/Agent/user/integral_flow">-->
                            <!--<i class="icon-double-angle-right"></i>-->
                            <!--积分流水-->
                        <!--</a>-->
                    <!--</li>-->
                </ul>
            </li>
            
            <!-- 佣金管理 -->
            <li <?php if($nowMenu == 'relship' ): ?>class="active open"<?php endif; ?>>
                <a href="#" class="dropdown-toggle">
                    <i class="icon-hdd"></i>
                    <span class="menu-text"> 佣金管理 </span>
                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    <li <?php if($nowAct == 'extension' ): ?>class="active"<?php endif; ?>>
                        <a href="/Agent/relship/extension">
                            <i class="icon-double-angle-right"></i>
                            佣金转入记录
                        </a>
                    </li>
                    <li <?php if($nowAct == 'relship_commission_list' ): ?>class="active"<?php endif; ?>>
                        <a href="/Agent/relship/relship_commission_list">
                            <i class="icon-double-angle-right"></i>
                            佣金流水
                        </a>
                    </li>
                </ul>
            </li>

            <!-- 出入金管理 -->
            <!--<li <?php if($nowMenu == 'capital' ): ?>class="active open"<?php endif; ?>>-->
                <!--<a href="#" class="dropdown-toggle">-->
                    <!--<i class="icon-hdd"></i>-->
                    <!--<span class="menu-text"> 用户出入金 </span>-->
                    <!--<b class="arrow icon-angle-down"></b>-->
                <!--</a>-->

                <!--<ul class="submenu">-->
                    <!--<li <?php if($nowAct == 'lists' ): ?>class="active"<?php endif; ?>>-->
                        <!--<a href="/Agent/capital/lists">-->
                            <!--<i class="icon-double-angle-right"></i>-->
                            <!--出入金统计-->
                        <!--</a>-->
                    <!--</li>-->
                <!--</ul>-->
            <!--</li>-->

            <!-- 订单 -->
            <li <?php if($nowMenu == 'cashorder' ): ?>class="active open"<?php endif; ?>>
                <a href="#" class="dropdown-toggle">
                    <i class="icon-hdd"></i>
                    <span class="menu-text"> 订单管理 </span>
                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    <li <?php if($nowAct == 'cash_list' ): ?>class="active"<?php endif; ?>>
                        <a href="/Agent/cashorder/cash_list/type/1">
                            <i class="icon-double-angle-right"></i>
                            交易订单
                        </a>
                    </li>
                    <li <?php if($nowAct == 'order_list_gold' ): ?>class="active"<?php endif; ?>>
                        <a href="/Agent/cashorder/order_list_gold/type/2">
                            <i class="icon-double-angle-right"></i>
                            模拟订单
                        </a>
                    </li>
                </ul>
            </li>


            <!-- 交易员 -->
            <li <?php if($nowMenu == 'trader' ): ?>class="active open"<?php endif; ?>>
                <a href="#" class="dropdown-toggle">
                    <i class="icon-cog"></i>
                    <span class="menu-text"> 交易员 </span>

                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    
                    <li <?php if(($nowAct == 'lists')): ?>class="active"<?php endif; ?>>
                    <a href="/Agent/trader/lists">
                        <i class="icon-double-angle-right"></i>
                        交易员列表
                    </a>
                    </li>
    
                    <li <?php if(($nowAct == 'followlist')): ?>class="active"<?php endif; ?>>
                    <a href="/Agent/trader/followList">
                        <i class="icon-double-angle-right"></i>
                        追随者列表
                    </a>
                    </li>
                </ul>
            </li>



            <!-- 用户 -->
            <li <?php if(($nowMenu == 'proxy')): ?>class="active open"<?php endif; ?>>
                <a href="#" class="dropdown-toggle">
                    <i class="icon-group"></i>
                    <span class="menu-text">系统配置</span>

                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    <li <?php if($nowAct == 'sys_info' ): ?>class="active"<?php endif; ?>>
                    <a href="/Agent/proxy/sys_info">
                        <i class="icon-double-angle-right"></i>
                        系统信息
                    </a>
                    </li>

                    <li <?php if($nowAct == 'change_password' ): ?>class="active"<?php endif; ?>>
                    <a href="/Agent/proxy/change_password">
                        <i class="icon-double-angle-right"></i>
                        密码修改
                    </a>
                    </li>

                    <li <?php if($nowAct == 'tuiguang_erweima' ): ?>class="active"<?php endif; ?>>
                    <a href="/Agent/proxy/tuiguang_erweima">
                        <i class="icon-double-angle-right"></i>
                        我的二维码
                    </a>
                    </li>
                </ul>
            </li>
            

            <!-- 资金流水 -->
            <li <?php if($nowMenu == 'flow' ): ?>class="active open"<?php endif; ?>>
                <a href="#" class="dropdown-toggle">
                    <i class="icon-cog"></i>
                    <span class="menu-text"> 我的资金账户 </span>

                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    <li <?php if($nowAct == 'money_flow' ): ?>class="active"<?php endif; ?>>
                    <a href="/Agent/flow/money_flow">
                        <i class="icon-double-angle-right"></i>
                        资金流水
                    </a>
                    </li>
                    <li <?php if($nowAct == 'recharge' ): ?>class="active"<?php endif; ?>>
                    <a href="/Agent/flow/recharge">
                        <i class="icon-double-angle-right"></i>
                        充值记录
                    </a>
                    </li>
                    <li <?php if($nowAct == 'withdrawal' ): ?>class="active"<?php endif; ?>>
                    <a href="/Agent/flow/withdrawal">
                        <i class="icon-double-angle-right"></i>
                        提现记录
                    </a>
                    </li>

                    <li <?php if($nowAct == 'commissionrecord' ): ?>class="active"<?php endif; ?>>
                    <a href="/Agent/flow/commissionRecord">
                        <i class="icon-double-angle-right"></i>
                        佣金转入记录
                    </a>
                    </li>

                    <li <?php if($nowAct == 'receive_flow' ): ?>class="active"<?php endif; ?>>
                    <a href="/Agent/flow/receive_flow">
                        <i class="icon-double-angle-right"></i>
                        佣金流水
                    </a>
                    </li>
                </ul>
            </li>

        </ul><!-- /.nav-list -->

        <div class="sidebar-collapse" id="sidebar-collapse">
            <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
        </div>

        <script type="text/javascript">
            try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
        </script>
    </div>

    <div class="main-content">
        <!--div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
                try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
            </script>

            <ul class="breadcrumb">
                <li>
                    <i class="icon-home home-icon"></i>
                    <a href="#">首页</a>
                </li>
                <li class="active">控制台</li>
            </ul><!-- .breadcrumb -->
        <!--/div>
        <!--end breadcrumbs-->
<style>
    .specla_background_class{
        background:#edf3f4 !important;
    }
    table {
        border:1px solid #dcebf7 !important;
    }
    td{color: #336199 !important;}
    td.special_color{color:#000 !important;}
</style>

<div class="page-content">
    <div class="page-header">
        <h1>
            统计
            <small>
                <i class="icon-double-angle-right"></i>
                信息统计
            </small>
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-sm-6">

                    <h3 class="header smaller lighter blue">资金帐户信息</h3>

                    <table class="special_table_border table table-striped table-bordered">
                        <tbody>
                        <tr>
                            <td class="center hidden-xs specla_background_class">
                                <h5>我的余额</h5>
                            </td>

                            <td class="center hidden-xs specla_background_class">
                                <h5>我的模拟</h5>
                            </td>
                            <!--<td class="center hidden-xs specla_background_class">-->
                                <!--<h5>我的积分</h5>-->
                            <!--</td>-->
                            <td class="center hidden-xs specla_background_class">
                                <h5>我的佣金</h5>
                            </td>
                        </tr>
                        <tr>
                            <td class="center orange"><h4><b><?php echo ($returnRs["account"]); ?></b></h4></td>
                            <td class="center orange"><h4><b><?php echo ($returnRs["gold"]); ?></b></h4></td>
                            <!--<td class="center orange"><h4><b><?php echo ($returnRs["integral"]); ?></b></h4></td>-->
                            <td class="center orange"><h4><b><?php echo ((isset($returnRs["money"]) && ($returnRs["money"] !== ""))?($returnRs["money"]):'0.00'); ?></b></h4></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="space-12"></div>
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="header smaller lighter blue">（下级用户）交易信息统计</h3>

                    <table class="special_table_border table table-striped table-bordered">
                        <tbody>
                        <tr>
                            <td class="center hidden-xs specla_background_class">
                                <h5>订单总数</h5>
                            </td>
                            <td class="center hidden-xs specla_background_class">
                                <h5>订单总手数</h5>
                            </td>
                            <td class="center specla_background_class">
                                <h5>订单总金额</h5>
                            </td>
                            <td class="center specla_background_class">
                                <h5>总平仓盈亏</h5>
                            </td>
                            <td class="center specla_background_class">
                                <h5>总持仓盈亏</h5>
                            </td>
                            <td class="center specla_background_class">
                                <h5>总手续费</h5>
                            </td>
                            <td class="center specla_background_class">
                                <h5>总隔夜费</h5>
                            </td>

                        </tr>
                        <tr>
                            <td class="center  orange"><h4><b><?php echo ($returnRs["order_total"]); ?></b></h4></td>
                            <td class="center  orange"><h4><b><?php echo ($returnRs["onumber_total"]); ?></b></h4></td>
                            <td class="center  hidden-480 orange"><h4><b><?php echo ($returnRs["total_count"]); ?></b></h4></td>
                            <td class="center  hidden-480 orange"><h4><b><?php echo ($returnRs["total_money"]); ?></b></h4></td>
                            <td class="center  hidden-480 orange"><h4><b><?php echo ($returnRs["position_money"]); ?></b></h4></td>
                            <td class="center  hidden-480 orange"><h4><b><?php echo ($returnRs["total_fee"]); ?></b></h4></td>
                            <td class="center  hidden-480 orange"><h4><b><?php echo ($returnRs["overnight_fee"]); ?></b></h4></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="header smaller lighter blue">（下级用户）本周交易信息统计</h3>

                    <table class="special_table_border table table-striped table-bordered">
                        <tbody>
                        <tr>
                            <td class="center hidden-xs specla_background_class">
                                <h5>订单总数</h5>
                            </td>
                            <td class="center hidden-xs specla_background_class">
                                <h5>订单总手数</h5>
                            </td>
                            <td class="center specla_background_class">
                                <h5>订单总金额</h5>
                            </td>
                            <td class="center specla_background_class">
                                <h5>总平仓盈亏</h5>
                            </td>
                            <td class="center specla_background_class">
                                <h5>总持仓盈亏</h5>
                            </td>
                            <td class="center specla_background_class">
                                <h5>总手续费</h5>
                            </td>
                            <td class="center specla_background_class">
                                <h5>总隔夜费</h5>
                            </td>
                        </tr>
                        <tr>
                            <td class="center  orange"><h4><b><?php echo ($returnWeek["order_total"]); ?></b></h4></td>
                            <td class="center  orange"><h4><b><?php echo ($returnWeek["onumber_total"]); ?></b></h4></td>
                            <td class="center  hidden-480 orange"><h4><b><?php echo ($returnWeek["total_count"]); ?></b></h4></td>
                            <td class="center  hidden-480 orange"><h4><b><?php echo ($returnWeek["total_money"]); ?></b></h4></td>
                            <td class="center  hidden-480 orange"><h4><b><?php echo ($returnWeek["total_position"]); ?></b></h4></td>
                            <td class="center  hidden-480 orange"><h4><b><?php echo ($returnWeek["total_fee"]); ?></b></h4></td>
                            <td class="center  hidden-480 orange"><h4><b><?php echo ($returnWeek["overnight_fee"]); ?></b></h4></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="space-12"></div>
            <div class="row">
                <div class="col-sm-6">

                    <h3 class="header smaller lighter blue">用户信息统计</h3>

                    <table class="special_table_border table table-striped table-bordered">

                        <tbody>
                        <tr>
                            <td class="center specla_background_class">
                                <h5>用户总数</h5>
                            </td>
                        </tr>
                        <tr>
                            <td class="center orange hidden-480 "><h4><b><?php echo ($returnRs["user_total"]); ?></b></h4></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->



</div><!-- /.main-content -->
</div><!-- /.main-container-inner -->
<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
    <i class="icon-double-angle-up icon-only bigger-110"></i>
</a>
</div><!-- /.main-container -->
<!-- basic scripts -->
<script src="/Public/Ucenter/proxy/assets\js\jquery-2.0.3.min.js"></script>

<!-- <![endif]-->

<!--[if IE]>
<script src="/Public/Ucenter/proxy/assets\js\jquery-1.10.2.min.js"></script>
<![endif]-->

<!--[if !IE]> -->

<script type="text/javascript">
    window.jQuery || document.write("<script src='/Public/Ucenter/proxy/assets/js/jquery-2.0.3.min.js'>"+"<"+"script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='/Public/Ucenter/proxy/assets/js/jquery-1.10.2.min.js'>"+"<"+"script>");
</script>
<![endif]-->

<script type="text/javascript">
    if("ontouchend" in document) document.write("<script src='/Public/Ucenter/proxy/assets/js/jquery.mobile.custom.min.js'>"+"<"+"script>");
</script>
<script src="/Public/Ucenter/proxy/assets/js/bootstrap.min.js"></script>
<script src="/Public/Ucenter/proxy/assets/js/typeahead-bs2.min.js"></script>


<!-- basic scripts -->

<!--[if !IE]> -->


<!-- page specific plugin scripts -->

<!--[if lte IE 8]>
<script src="/Public/Ucenter/proxy/assets/js/excanvas.min.js"></script>
<![endif]-->

<script src="/Public/Ucenter/proxy/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="/Public/Ucenter/proxy/assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="/Public/Ucenter/proxy/assets/js/jquery.slimscroll.min.js"></script>
<script src="/Public/Ucenter/proxy/assets/js/jquery.easy-pie-chart.min.js"></script>
<script src="/Public/Ucenter/proxy/assets/js/jquery.sparkline.min.js"></script>
<script src="/Public/Ucenter/proxy/assets/js/flot/jquery.flot.min.js"></script>
<script src="/Public/Ucenter/proxy/assets/js/flot/jquery.flot.pie.min.js"></script>
<script src="/Public/Ucenter/proxy/assets/js/flot/jquery.flot.resize.min.js"></script>



<!-- inline scripts related to this page -->
<script type="text/javascript">
    jQuery(function($) {

    });
</script>

<!-- ace scripts -->

<script src="/Public/Ucenter/proxy/assets/js/ace-elements.min.js"></script>
<script src="/Public/Ucenter/proxy/assets/js/ace.min.js"></script>
</body>
</html>