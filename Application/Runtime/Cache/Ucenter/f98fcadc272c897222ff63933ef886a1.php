<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>销售商后台</title>
    <meta name="keywords" content="销售商后台管理系统" />
    <meta name="description" content="销售商后台管理系统" />
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
                    销售商后台管理
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
                            <a href="<?php echo U('Agents/change_password');?>">
                                <i class="icon-user"></i>
                                修改密码
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="<?php echo U('Admin/User/signinout');?>">
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
            <li <?php if(($nowMenu == 'indexs') and ($nowAct == 'index')): ?>class="active"<?php endif; ?>>
                <a href="<?php echo U('indexs/index');?>">
                    <i class="icon-dashboard"></i>
                    <span class="menu-text"> 控制台 </span>
                </a>
            </li>

            <!-- 用户 -->
            <li <?php if(($nowMenu == 'users')): ?>class="active open"<?php endif; ?>>
                <a href="#" class="dropdown-toggle">
                    <i class="icon-group"></i>
                    <span class="menu-text">用户管理</span>

                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    <li <?php if(($nowAct == 'user_list') or ($nowAct == 'user_detail') or ($nowAct == 'subordinates')): ?>class="active"<?php endif; ?>>
                        <a href="/Ucenter/users/user_list">
                            <i class="icon-double-angle-right"></i>
                            用户列表
                        </a>
                    </li>

                    <li <?php if(($nowAct == 'recharge')): ?>class="active"<?php endif; ?>>
                        <a href="/Ucenter/users/recharge">
                            <i class="icon-double-angle-right"></i>
                            充值记录
                        </a>
                    </li>

                    <li <?php if(($nowAct == 'withdrawal')): ?>class="active"<?php endif; ?>>
                        <a href="/Ucenter/users/withdrawal">
                            <i class="icon-double-angle-right"></i>
                            提现记录
                        </a>
                    </li>
                    <li <?php if(($nowAct == 'money_flow') or ($nowAct == 'money_flow')): ?>class="active"<?php endif; ?>>
                        <a href="/Ucenter/users/money_flow">
                            <i class="icon-double-angle-right"></i>
                            资金流水
                        </a>
                    </li>
                    <!--<li <?php if(($nowAct == 'integral_flow') or ($nowAct == 'integral_flow')): ?>class="active"<?php endif; ?>>-->
                        <!--<a href="/Ucenter/users/integral_flow">-->
                            <!--<i class="icon-double-angle-right"></i>-->
                            <!--积分流水-->
                        <!--</a>-->
                    <!--</li>-->
                </ul>
            </li>
            
            <!--<li <?php if($nowMenu == 'capitals' ): ?>class="active open"<?php endif; ?>>-->
            <!--<a href="#" class="dropdown-toggle">-->
                <!--<i class="icon-hdd"></i>-->
                <!--<span class="menu-text"> 用户出入金 </span>-->
                <!--<b class="arrow icon-angle-down"></b>-->
            <!--</a>-->

                <!--<ul class="submenu">-->
                    <!--<li <?php if($nowAct == 'lists' ): ?>class="active"<?php endif; ?>>-->
                        <!--<a href="/Ucenter/capitals/lists">-->
                            <!--<i class="icon-double-angle-right"></i>-->
                            <!--出入金统计-->
                        <!--</a>-->
                    <!--</li>-->
                <!--</ul>-->
            <!--</li>-->


            <li <?php if($nowMenu == 'cashorders' ): ?>class="active open"<?php endif; ?>>
            <a href="#" class="dropdown-toggle">
                <i class="icon-hdd"></i>
                <span class="menu-text"> 订单管理 </span>
                <b class="arrow icon-angle-down"></b>
            </a>

                <ul class="submenu">
                    <li <?php if($nowAct == 'cash_list' ): ?>class="active"<?php endif; ?>>
                        <a href="/Ucenter/cashorders/cash_list/type/1">
                            <i class="icon-double-angle-right"></i>
                            现金订单
                        </a>
                    </li>
                    <li <?php if($nowAct == 'order_list_gold' ): ?>class="active"<?php endif; ?>>
                        <a href="/Ucenter/cashorders/order_list_gold/type/2">
                            <i class="icon-double-angle-right"></i>
                            模拟订单
                        </a>
                    </li>
                </ul>
            </li>


        <!-- 系统管理 -->
            <li <?php if($nowMenu == 'relships' ): ?>class="active open"<?php endif; ?>>
                <a href="#" class="dropdown-toggle">
                    <i class="icon-cog"></i>
                    <span class="menu-text"> 代理商管理 </span>

                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    
                    <li <?php if(($nowAct == 'relship_list') or ($nowAct == 'subordinate') or ($nowAct == 'lowerlevel')): ?>class="active"<?php endif; ?>>
                    <a href="/Ucenter/relships/relship_list">
                        <i class="icon-double-angle-right"></i>
                        代理商列表
                    </a>
                    </li>

                    <li <?php if($nowAct == 'extension' ): ?>class="active"<?php endif; ?>>
                    <a href="/Ucenter/relships/extension">
                        <i class="icon-double-angle-right"></i>
                        佣金转入记录
                    </a>
                    </li>

                    <li <?php if($nowAct == 'relship_commission_list' ): ?>class="active"<?php endif; ?>>
                    <a href="/Ucenter/relships/relship_commission_list">
                        <i class="icon-double-angle-right"></i>
                        佣金流水
                    </a>
                    </li>
                </ul>
            </li>

            <!-- 交易员 -->
            <li <?php if($nowMenu == 'traders' ): ?>class="active open"<?php endif; ?>>
                <a href="#" class="dropdown-toggle">
                    <i class="icon-cog"></i>
                    <span class="menu-text"> 交易员 </span>

                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    
                    <li <?php if(($nowAct == 'lists')): ?>class="active"<?php endif; ?>>
                    <a href="/Ucenter/traders/lists">
                        <i class="icon-double-angle-right"></i>
                        交易员列表
                    </a>
                    </li>
    
                    <li <?php if(($nowAct == 'followlist')): ?>class="active"<?php endif; ?>>
                    <a href="/Ucenter/traders/followList">
                        <i class="icon-double-angle-right"></i>
                        追随者列表
                    </a>
                    </li>
                </ul>
            </li>


            <!-- 推广管理 -->
<!--             <li <?php if($nowMenu == 'relships' ): ?>class="active open"<?php endif; ?>>
                <a href="#" class="dropdown-toggle">
                    <i class="icon-cog"></i>
                    <span class="menu-text"> 推广管理 </span>

                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    <li <?php if($nowAct == 'relship_commission_list' ): ?>class="active"<?php endif; ?>>
                    <a href="/Ucenter/relships/relship_commission_list">
                        <i class="icon-double-angle-right"></i>
                        佣金流水
                    </a>
                    </li>
                    <li <?php if($nowAct == 'relship_list' ): ?>class="active"<?php endif; ?>>
                    <a href="/Ucenter/relships/relship_list">
                        <i class="icon-double-angle-right"></i>
                        推广员列表
                    </a>
                    </li>
                </ul>
            </li> -->
            <!-- 持仓管理 -->
            <li <?php if($nowMenu == 'positions' ): ?>class="active open"<?php endif; ?>>
            <a href="#" class="dropdown-toggle">
                <i class="icon-cog"></i>
                <span class="menu-text"> 持仓管理 </span>

                <b class="arrow icon-angle-down"></b>
            </a>

                <ul class="submenu">
                    <li <?php if($nowAct == 'tlist' ): ?>class="active"<?php endif; ?>>
                    <a href="/Ucenter/positions/tlist/type/1">
                        <i class="icon-double-angle-right"></i>
                        实盘监控
                    </a>
                    </li>

                    <li <?php if($nowAct == 'moni' ): ?>class="active"<?php endif; ?>>
                    <a href="/Ucenter/positions/moni/type/2">
                        <i class="icon-double-angle-right"></i>
                        模拟监控
                    </a>
                    </li>
                </ul>
            </li>
            <!-- 订单 -->
            <li <?php if($nowMenu == 'agents' ): ?>class="active open"<?php endif; ?>>
            <a href="#" class="dropdown-toggle">
                <i class="icon-hdd"></i>
                <span class="menu-text"> 系统管理 </span>
                <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">
                <li <?php if($nowAct == 'change_password' ): ?>class="active"<?php endif; ?>>
                <a href="/Ucenter/Agents/change_password">
                    <i class="icon-double-angle-right"></i>
                    信息修改
                </a>
                </li>

                <li <?php if($nowAct == 'tuiguang_erweima' ): ?>class="active"<?php endif; ?>>
                <a href="/Ucenter/Agents/tuiguang_erweima">
                    <i class="icon-double-angle-right"></i>
                    我的二维码
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
<link rel="stylesheet" type="text/css" href="/Public/Ucenter/css/layerui/css/layui.css">
<style type="text/css">
.dataTables_length span{color: red;}
td{text-align: center;}
#id_search_area>div>div>div{height: 70px}
</style>

<div class="page-content">
    <div class="page-header">
        <h1>
            我的用户
            <small>
                <i class="icon-double-angle-right"></i>
                用户列表
            </small>
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-header">
                        用户列表&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="table-responsive">

                    <div role="grid" class="dataTables_wrapper" id="sample-table-2_wrapper">
                        <form action="/Ucenter/Users/user_list" method="get" id="form1">

                            <div class="row" id="id_search_area">
                                <div class="col-sm-9">
                                <div style=" width: 1350px; height: 100px;">

                                <div class="col-sm-2">
                                    <!-- <label>开始时间:</label> -->
                                    <?php if($time): ?><input class="layui-input input" style="width: 200px;" placeholder="注册开始时间" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="<?php echo ($time['start_time']); ?>" name="start_time">
                                   <?php else: ?>
                                    <input class="layui-input input" style="width: 200px;" placeholder="注册开始时间" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="" name="start_time"><?php endif; ?>
                                </div>

                                <div class="col-sm-2">
                                 <!--    <label>结束时间:</label> -->
                                 <?php if($time): ?><input class="layui-input input" style="width: 200px;" placeholder="注册结束时间" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="<?php echo ($time['end_time']); ?>" name="end_time">
                                <?php else: ?>
                                    <input class="layui-input input" style="width: 200px;" placeholder="注册结束时间" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="" name="end_time"><?php endif; ?>
                                </div>
                                    <div class="col-sm-2">
                                        <div class="dataTables_length" id="">
                                            <label>
                                                <input class="class_search_area input" placeholder="电子邮箱" value="<?php echo ($email); ?>" aria-controls="sample-table-2" name="email" data-type="agent_name" type="text" style="height: 36px;">
                                            </label>
                                        </div>
                                    </div>

                                   <div class="col-sm-2">
                                        <div class="dataTables_length" id="">
                                            <label>
                                                <input class="class_search_area input" placeholder="用户名称" value="<?php echo ($username); ?>" aria-controls="sample-table-2" name="username" data-type="agent_name" type="text" style="height: 36px;">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="dataTables_length" id="">
                                            <label>
                                                <input class="class_search_area input" placeholder="用户昵称" value="<?php echo ($nickname); ?>" aria-controls="sample-table-2" name="nickname" data-type="agent_name" type="text" style="height: 36px;">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="dataTables_length" id="">
                                            <label>
                                                <input class="class_search_area input" placeholder="编号ID" value="<?php echo ($uid); ?>" aria-controls="sample-table-2" name="uid" data-type="agent_name" type="text" style="height: 36px;">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="dataTables_length" id="">
                                            <label>
                                                交易状态：
                                                <select name="jostyle"  style="width: 120px;">
                                                <option value="" class="selected">默认不选</option>
                                                   <?php if($jostyle == 1): ?><option value="1" selected>冻结</option>
                                                    <?php else: ?>
                                                     <option value="1">冻结</option><?php endif; ?>
                                                    <?php if($jostyle == 2): ?><option value="2" selected>正常</option>
                                                    <?php else: ?>
                                                    <option value="2">正常</option><?php endif; ?>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    


                                    </div>
                                </div>


                                <div class="hr hr-24"></div>
                                <div class="col-sm-12">
                                    <div class="dataTables_length" id="sample-table-2_length1">
                                        <label>
                                            <input type="button"  onclick="sub()" value="点击查询" class="btn btn-xs btn-info">
                                        </label>&nbsp;&nbsp;
                                        <label>
                                            <input type="button" onclick="daochu()" value="查找导出" class="btn btn-xs btn-info">
                                        </label>&nbsp;&nbsp;
                                        <label>
                                            <input type="button" id="id_reset" value="清空数据" class="btn btn-xs btn-info">
                                        </label>
                                    </div>
                                </div>
                            </div>  <!-- 导出排序 -->
                                    <input type="hidden" name="cat" value="<?php echo ($sea["cat"]); ?>">
                                    <input type="hidden" name="sort" value="<?php echo ($sea["sort"]); ?>">
                                    <!-- 导出排序 -->
                            </form>
                        <div role="grid" class="dataTables_wrapper" id="sample-table-2_wrapper">
                            <table id="sample-table-2" class="table table-striped table-bordered table-hover dataTable">
                                <thead>
                                <tr>
                                    <th class="center">编号id</th>
                                    <th class="center">用户名称</th>
                                    <th class="center">电子邮箱</th>
                                    <th class="center">用户昵称</th>
                                    <th class="center">上级</th>
                                    <th class="center">创建日期</th>
                                    <th class="center">最近登录时间</th>
                                    <th class="center">订单数量</th>
                                    <th class="sort" data-cat="b.balance" data-sort="<?php echo ($sea["sort"]); ?>">账户余额</th>
                                    <th class="sort" data-cat="b.gold" data-sort="<?php echo ($sea["sort"]); ?>">模拟金额</th>
                                    <!--<th class="sort" data-cat="b.integral" data-sort="<?php echo ($sea["sort"]); ?>">账户积分</th>-->
                                    <th class="sort" data-cat="b.recharge_total" data-sort="<?php echo ($sea["sort"]); ?>">累计充值</th>
                                    <th class="sort" data-cat="b.money_total" data-sort="<?php echo ($sea["sort"]); ?>">累计提现</th>
                                    <th class="center">当前佣金</th>
                                    <th class="center">当前状态</th>
                                    <!--<th class="center">操作</th>-->
                                </tr>
                                </thead>
                                <tbody>

                                <?php if(is_array($userInfo)): $i = 0; $__LIST__ = $userInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
            
                                    <td class="center"><a target="_blank" style="color: #307ECC;" href="<?php echo U('user_detail');?>?user_id=<?php echo ($v["uid"]); ?>"><?php echo ($v["uid"]); ?></a></td>
                                    <td><?php echo ($v["username"]); ?></td>
                                    <td><?php echo ($v["email"]); ?></td>
                                    <td><?php echo ($v["nickname"]); ?></td>
                                     <td><?php echo change($v['rid']);?></td>
                                    <td><?php echo ($v["create_date"]); ?></td>
                                    <td><?php echo ($v["last_login"]); ?></td>
                                    <td>
                                        <?php echo ((isset($v["count"]) && ($v["count"] !== ""))?($v["count"]):0); ?>
                                        <br />
                                        [持仓<?php echo ((isset($v['total_jc']) && ($v['total_jc'] !== ""))?($v['total_jc']):0); ?>] [平仓<?php echo ((isset($v['total_pc']) && ($v['total_pc'] !== ""))?($v['total_pc']):0); ?>]
                                    </td>

                                    <td><?php echo ($v["balance"]); ?></td>
                                    <td><?php echo ($v["gold"]); ?></td>
                                    <!--<td><?php echo ($v["integral"]); ?></td>-->
                                    <td><?php echo ($v["recharge_total"]); ?></td>
                                    <td><?php echo ($v["money_total"]); ?></td>
                                    <td><?php echo ((isset($v["money"]) && ($v["money"] !== ""))?($v["money"]):'0.00'); ?></td>
                                    <td><?php echo ($v["trade_frozen_name"]); ?></td>
                                    <!--<td>-->
                                        <!--<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">-->
                                            <!--<a href="#" data-id="<?php echo ($v['uid']); ?>" data-status="<?php echo ($v['trade_frozen_s']); ?>" class="trade_frozen">-->
                                                <!--<?php echo ($v["trade_frozen_o"]); ?>-->
                                            <!--</a>-->
                                        <!--</div>-->
                                    <!--</td>-->
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="dataTables_info" id="sample-table-2_info">共<b class="orange"><?php echo ($totalCount); ?></b>，当前显示第 <b class="orange"><?php echo ($nowStart); ?></b>到<b class="orange"><?php echo ($nowEnd); ?></b></div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="dataTables_paginate paging_bootstrap">
                                        <ul class="pagination">
                                            <?php echo ($pageShow); ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="dataTables_length" id="" style="width: 265px;">
                                    <label>
                                        <span>总用户&nbsp;&nbsp;&nbsp;: <?php echo ($totalCount); ?>个</span></br>

                                        <span>总余额&nbsp;&nbsp;&nbsp;: <?php echo ((isset($account["balance"]) && ($account["balance"] !== ""))?($account["balance"]):0); ?></span></br>

                                        <span>总模拟&nbsp;&nbsp;&nbsp;: <?php echo ((isset($account["gold"]) && ($account["gold"] !== ""))?($account["gold"]):0); ?></span></br>

                                        <!--<span>总积分&nbsp;&nbsp;&nbsp;: <?php echo ((isset($account["integral"]) && ($account["integral"] !== ""))?($account["integral"]):0); ?></span></br>-->

                                        <span>总佣金&nbsp;&nbsp;&nbsp;: <?php echo ((isset($account["fee_receive"]) && ($account["fee_receive"] !== ""))?($account["fee_receive"]):0); ?></span></br>

                                        <span>累计充值金额&nbsp;&nbsp;&nbsp;: <?php echo ((isset($account["recharge_total"]) && ($account["recharge_total"] !== ""))?($account["recharge_total"]):0); ?></span></br>

                                        <span>累计提现金额&nbsp;&nbsp;&nbsp;: <?php echo ((isset($account["money_total"]) && ($account["money_total"] !== ""))?($account["money_total"]):0); ?></span></br>
                                    </label>
                                </div>
                            </div>

                        </div>
                        <!--end id sample-table-2_wrapper-->
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
            <div class="space-20"></div>
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

<script type="text/javascript" src="/Public/Js/layer/layer.js"></script>
<script type="text/javascript" src="/Public/Ucenter/css/layerui/layui.js"></script>


<!-- inline scripts related to this page -->
<script type="text/javascript">

    //交易冻结
    $('.trade_frozen').click(function(){
        var user_id   = $(this).attr('data-id');
        var trade_frozen   = $(this).attr('data-status');

        layer.confirm('确认修改用户的状态吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                type: "post",
                url: "<?php echo U('users/tradeFrozen');?>",
                data:{'user_id' : user_id, 'trade_frozen' : trade_frozen},
                success: function(data) {
                    //console.log(data.status);
                    if(data.status == 1)
                    {
                        layer.open({
                            content: data.ret_msg,
                            btn: '确定',
                            yes: function(index, layero){
                                layer.close(index);
                                top.location.reload();
                            }
                        });
                    }
                    else
                    {
                        layer.open({
                            content: data.ret_msg,
                            btn: '确定',
                            yes: function(index, layero){
                                layer.close(index);
                                top.location.reload();
                            }
                        });
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });

        }, function(){

        });

    });



var user_id = $("#jingji").val();
$("#jinjiren option").each(function(){
        if(user_id == $(this).val()){

             $(this).attr('selected',true);
        }
});

$("#id_reset").click(function(){
    
     $('.input').val("");
     $('.selected').attr('selected',true);
});


//日期选择时间
layui.use('laydate', function(){
  var laydate = layui.laydate;
});

function sub() {
    $('#form1').attr("action","/Ucenter/Users/user_list");
    $('#form1').submit();
}

function daochu() {
    $('#form1').attr("action","/Ucenter/Users/user_daochu");
    $('#form1').submit();
}


$('.sort').click(function(){
     var cat = $(this).attr('data-cat');
     var sort = $(this).attr('data-sort');
     if(sort == 'desc')
     {
         sort = 'asc';
     } else {
         sort = 'desc';
     }
     window.location.href="<?php echo U('user_list');?>"+'?cat='+cat+'&sort='+sort+'';
});
</script>

<!-- ace scripts -->

<script src="/Public/Ucenter/proxy/assets/js/ace-elements.min.js"></script>
<script src="/Public/Ucenter/proxy/assets/js/ace.min.js"></script>
</body>
</html>