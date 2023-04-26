<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<title>后台系统管理中心</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	
	<!-- bootstrap -->
	<link href="/Public/Admin/css/bootstrap/bootstrap.css" rel="stylesheet"/>
	<link href="/Public/Admin/css/bootstrap/bootstrap-responsive.css" rel="stylesheet"/>
	<link href="/Public/Admin/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet"/>
	
	<!-- libraries -->
	<link href="/Public/Admin/css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css"/>
	<link href="/Public/Admin/css/lib/font-awesome.css" type="text/css" rel="stylesheet"/>
	
	<!-- global styles -->
	<link rel="stylesheet" type="text/css" href="/Public/Admin/css/layout.css"/>
	<link rel="stylesheet" type="text/css" href="/Public/Admin/css/elements.css"/>
	<link rel="stylesheet" type="text/css" href="/Public/Admin/css/icons.css"/>
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style>
		img[src=""] {
			opacity: 0;
		}
	</style>
</head>
<body>

<!-- navbar -->
<div class="navbar navbar-inverse">
	<div class="navbar-inner">
		<button type="button" class="btn btn-navbar visible-phone" id="menu-toggler">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		
		
		<ul class="nav pull-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle hidden-phone" data-toggle="dropdown">
					<?php echo ($_SESSION['username']); ?>
					<b class="caret"></b>
				</a>
			</li>
			<li class="settings hidden-phone">
				<a href="<?php echo U('Admin/User/signinout');?>" role="button">
					<i class="icon-share-alt"></i>
				</a>
			</li>
		</ul>
	</div>
</div>
<!-- end navbar -->

<!-- sidebar -->
<div id="sidebar-nav" style="padding-top:0.5em">
	<ul id="dashboard-menu">
		
		<li class="Index">
			<div class="">
				<div class="arrow"></div>
				<div class="arrow_border"></div>
			</div>
			<a href="<?php echo U('Admin/Index/index');?>">
				<i class="icon-home"></i>
				<span>系统首页</span>
			</a>
		</li>
		
		<?php if(is_array($menus)): $i = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="<?php echo ($vo["controller"]); ?>">
				<div class="">
					<div class="arrow"></div>
					<div class="arrow_border"></div>
				</div>
				
				<?php if(empty($vo['children']) != true): ?><a class="dropdown-toggle" href="#">
						<i class="<?php echo ($vo["icon"]); ?>"></i>
						<span><?php echo ($vo["title"]); ?></span>
					</a>
					<ul class="submenu">
						<?php if(is_array($vo['children'])): $i = 0; $__LIST__ = $vo['children'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($v["url"]); ?>"><?php echo ($v["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
					<?php else: ?>
					<a href="<?php echo ($vo["url"]); ?>">
						<i class="<?php echo ($vo["icon"]); ?>"></i>
						<span><?php echo ($vo["title"]); ?></span>
					</a><?php endif; ?>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
		
		
		<!--<li class="index-index">-->
		<!--<div class="">-->
		<!--<div class="arrow"></div>-->
		<!--<div class="arrow_border"></div>-->
		<!--</div>-->
		<!--<a href="<?php echo U('Admin/Index/index');?>">-->
		<!--<i class="icon-home"></i>-->
		<!--<span>系统首页</span>-->
		<!--</a>-->
		<!--</li>-->
		
		
		<!--<li class="news-typelist news-newslist news-tedit news-newsadd news-newsedit">-->
		<!--<div class="">-->
		<!--<div class="arrow"></div>-->
		<!--<div class="arrow_border"></div>-->
		<!--</div>-->
		<!--<a class="dropdown-toggle" href="#">-->
		<!--<i class="icon-edit"></i>-->
		<!--<span>内容管理</span>-->
		<!--</a>-->
		<!--<ul class="submenu">-->
		<!--<li><a href="<?php echo U('Admin/News/typelist');?>">栏目管理</a></li>-->
		<!--<li><a href="<?php echo U('Admin/News/newslist');?>">文章管理</a></li>-->
		<!--</ul>-->
		<!--</li>-->
		<!---->
		<!--<li class="country-lists country-add country-edit">-->
		<!--<div class="">-->
		<!--<div class="arrow"></div>-->
		<!--<div class="arrow_border"></div>-->
		<!--</div>-->
		<!--<a class="dropdown-toggle" href="#">-->
		<!--<i class="icon-edit"></i>-->
		<!--<span>国家管理</span>-->
		<!--</a>-->
		<!--<ul class="submenu">-->
		<!--<li><a href="<?php echo U('Admin/Country/lists');?>">国家列表</a></li>-->
		<!--<li><a href="<?php echo U('Admin/Country/add');?>">添加国家</a></li>-->
		<!--</ul>-->
		<!--</li>-->
		<!---->
		<!---->
		<!--<li class="goods-goods_list goods-goods_classify goods-classify_edit goods-time_list">-->
		<!--<div class="">-->
		<!--<div class="arrow"></div>-->
		<!--<div class="arrow_border"></div>-->
		<!--</div>-->
		<!--<a class="dropdown-toggle" href="#">-->
		<!--<i class="icon-calendar-empty"></i>-->
		<!--<span>产品管理</span>-->
		<!--</a>-->
		<!--<ul class="submenu">-->
		<!--<li><a href="<?php echo U('Admin/Goods/goods_list');?>">产品列表</a></li>-->
		<!--<li><a href="<?php echo U('Admin/Goods/time_list');?>">时间交易</a></li>-->
		<!--<li><a href="<?php echo U('Admin/Goods/goods_classify');?>">产品分类</a></li>-->
		<!--</ul>-->
		<!--</li>-->
		<!---->
		<!--<li class="position-tlist">-->
		<!--<div class="">-->
		<!--<div class="arrow"></div>-->
		<!--<div class="arrow_border"></div>-->
		<!--</div>-->
		<!--<a class="dropdown-toggle" href="#">-->
		<!--<i class="icon-th-large"></i>-->
		<!--<span>持仓管理</span>-->
		<!--</a>-->
		<!--<ul class="submenu">-->
		<!--<li><a href="<?php echo U('Admin/Position/tlist',array('type' => 1));?>">实盘持仓</a></li>-->
		<!--<li><a href="<?php echo U('Admin/Position/tlist',array('type' => 2));?>">模拟持仓</a></li>-->
		<!--</ul>-->
		<!--</li>-->
		<!---->
		<!--<li class="order-tlist">-->
		<!--<div class="">-->
		<!--<div class="arrow"></div>-->
		<!--<div class="arrow_border"></div>-->
		<!--</div>-->
		<!--<a class="dropdown-toggle" href="#">-->
		<!--<i class="icon-th-large"></i>-->
		<!--<span>订单管理</span>-->
		<!--</a>-->
		<!--<ul class="submenu">-->
		<!--<li><a href="<?php echo U('Admin/Order/tlist',array('type' => 1));?>">实盘交易流水</a></li>-->
		<!--<li><a href="<?php echo U('Admin/Order/tlist',array('type' => 2));?>">模拟交易流水</a></li>-->
		<!--</ul>-->
		<!--</li>-->
		<!---->
		<!--<li class="user-ulist user-money_flow user-integral_flow user-updateuser user-online_user user-bankinfo user-updatebank">-->
		<!--<div class="">-->
		<!--<div class="arrow"></div>-->
		<!--<div class="arrow_border"></div>-->
		<!--</div>-->
		<!--<a class="dropdown-toggle" href="#">-->
		<!--<i class="icon-group"></i>-->
		<!--<span>客户管理</span>-->
		<!--</a>-->
		<!--<ul class="submenu">-->
		<!--<li><a href="<?php echo U('User/ulist');?>">客户列表</a></li>-->
		<!--<li><a href="<?php echo U('User/money_flow');?>">资金流水</a></li>-->
		<!--&lt;!&ndash;<li><a href="<?php echo U('User/integral_flow');?>">积分流水</a></li>&ndash;&gt;-->
		<!--&lt;!&ndash;         <li><a href="<?php echo U('User/online_user');?>">在线用户</a></li> &ndash;&gt;-->
		<!--</ul>-->
		<!--</li>-->
		<!---->
		<!--<li data-route="admin/recharge,admin/withdraw" class="recharge-lists withdraw-lists withdraw-tongji">-->
		<!--<div class="">-->
		<!--<div class="arrow"></div>-->
		<!--<div class="arrow_border"></div>-->
		<!--</div>-->
		<!--<a class="dropdown-toggle" href="#">-->
		<!--<i class="icon-group"></i>-->
		<!--<span>客户资金</span>-->
		<!--</a>-->
		<!--<ul class="submenu">-->
		<!--<li><a href="<?php echo U('Recharge/lists');?>">充值记录</a></li>-->
		<!--<li><a href="<?php echo U('Withdraw/lists');?>">提现申请</a></li>-->
		<!--&lt;!&ndash;<li><a href="<?php echo U('Withdraw/tongji');?>">出入金统计</a></li>&ndash;&gt;-->
		<!--</ul>-->
		<!--</li>-->
		
		<!--<li class="trader-index trader-traderexamine">-->
		<!--<div class="">-->
		<!--<div class="arrow"></div>-->
		<!--<div class="arrow_border"></div>-->
		<!--</div>-->
		<!--<a class="dropdown-toggle" href="#">-->
		<!--<i class="icon-group"></i>-->
		<!--<span>交易员</span>-->
		<!--</a>-->
		<!--<ul class="submenu">-->
		<!--<li><a href="<?php echo U('Trader/index');?>">交易员列表</a></li>-->
		<!--<li><a href="<?php echo U('Trader/traderExamine');?>">交易员审核</a></li>-->
		<!--</ul>-->
		<!--</li>-->
		
		<!--<li class="extension-index extension-extension extension-extension_water extension-lowerlevel extension-subordinate">-->
		<!--<div class="">-->
		<!--<div class="arrow"></div>-->
		<!--<div class="arrow_border"></div>-->
		<!--</div>-->
		<!--<a class="dropdown-toggle" href="#">-->
		<!--<i class="icon-picture"></i>-->
		<!--<span>代理佣金</span>-->
		<!--</a>-->
		<!--<ul class="submenu">-->
		<!--<li><a href="<?php echo U('Extension/index');?>">代理商列表</a></li>-->
		<!--<li><a href="<?php echo U('Extension/extension');?>">佣金转入记录</a></li>-->
		<!--<li><a href="<?php echo U('Extension/extension_water');?>">佣金流水</a></li>-->
		<!--</ul>-->
		<!--</li>-->
		<!---->
		<!--<li class="super-sadd super-slist super-sedit super-loginlog super-actionlog">-->
		<!--<div class="">-->
		<!--<div class="arrow"></div>-->
		<!--<div class="arrow_border"></div>-->
		<!--</div>-->
		<!--<a class="dropdown-toggle" href="personal-info.html">-->
		<!--<i class="icon-code-fork"></i>-->
		<!--<span>系统管理</span>-->
		<!--<ul class="submenu">-->
		<!--<li><a href="<?php echo U('Super/sadd');?>">添加管理员</a></li>-->
		<!--<li><a href="<?php echo U('Super/slist');?>">管理员列表</a></li>-->
		<!--<li><a href="<?php echo U('Super/loginlog');?>">登录日志</a></li>-->
		<!--<li><a href="<?php echo U('Super/actionlog');?>">操作日志</a></li>-->
		<!--</ul>-->
		<!--</a>-->
		<!--</li>-->
		<!---->
		<!---->
		<!--<li class="tools-basic tools-basic tools-product_sell_time tools-commission_rate tools-commission_time tools-product_number tools-setting_dollar tools-setting_list">-->
		<!--<div class="">-->
		<!--<div class="arrow"></div>-->
		<!--<div class="arrow_border"></div>-->
		<!--</div>-->
		<!--<a class="dropdown-toggle" href="#">-->
		<!--<i class="icon-cog"></i>-->
		<!--<span>系统设置</span>-->
		<!--</a>-->
		<!--<ul class="submenu">-->
		<!--<li><a href="<?php echo U('Tools/basic');?>">基本设置</a></li>-->
		<!--<li><a href="<?php echo U('Tools/setting_list');?>">系统货币设置</a></li>-->
		<!--<li><a href="<?php echo U('Tools/product_sell_time');?>">禁止下单时间</a></li>-->
		<!--<li><a href="<?php echo U('Tools/commission_rate');?>">佣金返还金额</a></li>-->
		<!--<li><a href="<?php echo U('Tools/commission_time');?>">佣金返还时间</a></li>-->
		<!--<li><a href="<?php echo U('Tools/product_number');?>">用户交易手数</a></li>-->
		<!--&lt;!&ndash;<li><a href="<?php echo U('Tools/setting_dollar');?>">美元汇率设置</a></li>&ndash;&gt;-->
		<!--</ul>-->
		<!--</li>-->
		
		<!--<li class="operate-index operate-add operate-flow">-->
		<!--<div class="">-->
		<!--<div class="arrow"></div>-->
		<!--<div class="arrow_border"></div>-->
		<!--</div>-->
		<!--<a class="dropdown-toggle" href="#">-->
		<!--<i class="icon-cog"></i>-->
		<!--<span>运营中心</span>-->
		<!--</a>-->
		<!--<ul class="submenu">-->
		<!--<li><a href="<?php echo U('Operate/index');?>">运营中心列表</a></li>-->
		<!--<li><a href="<?php echo U('Operate/add');?>">添加运营</a></li>-->
		<!--<li><a href="<?php echo U('Operate/flow');?>">资金流水</a></li>-->
		<!--</ul>-->
		<!--</li>-->
		
		<!--<li class="agent-index agent-add agent-tongji">-->
		<!--<div class="">-->
		<!--<div class="arrow"></div>-->
		<!--<div class="arrow_border"></div>-->
		<!--</div>-->
		<!--<a class="dropdown-toggle" href="#">-->
		<!--<i class="icon-cog"></i>-->
		<!--<span>销售商</span>-->
		<!--</a>-->
		<!--<ul class="submenu">-->
		<!--<li><a href="<?php echo U('Agent/index');?>">销售商列表</a></li>-->
		<!--<li><a href="<?php echo U('Agent/add');?>">添加销售商</a></li>-->
		<!--<li><a href="<?php echo U('Agent/tongji');?>">出入金统计</a></li>-->
		<!--</ul>-->
		<!--</li>-->
		
		<!--<li class="stretch-index stretch-newsadd stretch-newsedit stretch-jputh stretch-jpushmsg">-->
		<!--<div class="">-->
		<!--<div class="arrow"></div>-->
		<!--<div class="arrow_border"></div>-->
		<!--</div>-->
		<!--<a class="dropdown-toggle" href="#">-->
		<!--<i class="icon-cog"></i>-->
		<!--<span>公告消息</span>-->
		<!--</a>-->
		<!--<ul class="submenu">-->
		<!--<li><a href="<?php echo U('stretch/index');?>">公告列表</a></li>-->
		<!--&lt;!&ndash;<li><a href="<?php echo U('stretch/jpush');?>">信息推送</a></li>&ndash;&gt;-->
		<!--&lt;!&ndash;<li><a href="<?php echo U('stretch/jpushMsg');?>">推送历史</a></li>&ndash;&gt;-->
		<!--</ul>-->
		<!--</li>-->
		
		<!--<li class="live-room live-addanchor live-roomimg live-anchor live-message">-->
		<!--<div class="">-->
		<!--<div class="arrow"></div>-->
		<!--<div class="arrow_border"></div>-->
		<!--</div>-->
		<!--<a class="dropdown-toggle" href="#">-->
		<!--<i class="icon-cog"></i>-->
		<!--<span>直播管理</span>-->
		<!--</a>-->
		<!--<ul class="submenu">-->
		<!--<li><a href="<?php echo U('Live/room');?>">房间列表</a></li>-->
		<!--<li><a href="<?php echo U('Live/anchor');?>">主播列表</a></li>-->
		<!--<li><a href="<?php echo U('Live/message');?>">历史消息</a></li>-->
		<!---->
		<!--</ul>-->
		<!--</li>-->
		
		<!--<li class="datareview-personal datareview-bank">-->
		<!--<div class="">-->
		<!--<div class="arrow"></div>-->
		<!--<div class="arrow_border"></div>-->
		<!--</div>-->
		<!--<a class="dropdown-toggle" href="#">-->
		<!--<i class="icon-cog"></i>-->
		<!--<span>资料审核</span>-->
		<!--</a>-->
		<!--<ul class="submenu">-->
		<!--&lt;!&ndash;<li><a href="<?php echo U('Datareview/personal');?>">个人信息审核</a></li>&ndash;&gt;-->
		<!--<li><a href="<?php echo U('Datareview/bank');?>">银行卡审核</a></li>-->
		<!--</ul>-->
		<!--</li>-->
		<!---->
		<!--<li class="role-get_list">-->
		<!--<div class="">-->
		<!--<div class="arrow"></div>-->
		<!--<div class="arrow_border"></div>-->
		<!--</div>-->
		<!--<a class="dropdown-toggle" href="#">-->
		<!--<i class="icon-cog"></i>-->
		<!--<span>权限控制</span>-->
		<!--</a>-->
		<!--<ul class="submenu">-->
		<!--<li><a href="<?php echo U('Role/get_list');?>">角色管理</a></li>-->
		<!--</ul>-->
		<!--</li>-->
	
	</ul>
</div>
<!-- end sidebar -->


<!-- main container -->
<div class="content">
	
    <link href="/Public/Admin/css/bootstrap/bootstrap-switch.css" type="text/css" rel="stylesheet" />
    <link href="/Public/Admin/css/bootstrap/highlight.css" type="text/css" rel="stylesheet" />

	<!-- this page specific styles -->
	<link rel="stylesheet" href="/Public/css/public.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="/Public/Admin/css/compiled/article.css" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/layerui/css/layui.css">

    <style>
        .layui-layer-dialog .layui-layer-content {
            position: relative;
            padding: 20px;
            line-height: 24px;
            word-break: break-all;
            overflow: hidden;
            font-size: 14px;
            overflow-x: hidden;
            overflow-y: auto;
        }
    </style>
    <div class="container-fluid">
        <div id="pad-wrapper" class="users-list">
            <div class="row-fluid header head2">
                <h3><?php if($posiname): echo ($posiname["name"]); else: ?>产品管理<?php endif; ?>&nbsp;>&nbsp;产品列表</h3>
            </div>
            <!--<div class="row-fluid header head2">-->
                <!--<a href="/login/goods/gadd.html" class="btn-flat success">-->
                    <!--添加产品-->
                <!--</a>-->
            <!--</div>-->
            <div class="row-fluid header">
                <form  action="<?php echo U('Goods/gdel');?>" method="post" name="del">
                <div class="row-fluid table" style="overflow-x:scroll">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="span1 sortable">
                                    <!--<input type="checkbox">-->
                                    编号
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span>商品名称
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span>是否允许交易
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span>交易状态
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span>持仓状态
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span>品种价格
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span>点位波动金额（单位）
                                </th>

                                <th class="span2 sortable">
                                    <span class="line"></span>1手手续费
                                </th>
                                
                                <th class="span2 sortable">
                                    <span class="line"></span>1手隔夜费(买多)
                                </th>
    
                                <th class="span2 sortable">
                                    <span class="line"></span>1手隔夜费(卖空)
                                </th>

                                <th class="span3 sortable">
                                    <span class="line"></span>最大杠杆
                                </th>
                            
                                <th class="span3 sortable">
                                    <span class="line"></span>合约数量/1标准手
                                </th>

                                <th class="span3 sortable">
                                    <span class="line"></span>点差
                                </th>

                                <th class="span2 sortable">
                                    <span class="line"></span>今开/昨收
                                </th>

                                <th class="span3 sortable">
                                    <span class="line"></span>交易时间
                                </th>

                                <th class="span3 sortable">
                                    <span class="line"></span>所属分类
                                </th>

                                <th class="span3 sortable">
                                    <span class="line"></span>商品玩法
                                </th>
                                

                                <th class="span3 sortable">
                                    <span class="line"></span>排序
                                </th>
                                
                                <th class="span3 sortable">
                                    <span class="line"></span>英文名称
                                </th>
                                <!--<th class="span3 sortable">-->
                                    <!--<span class="line"></span>参考商品英文名称-->
                                <!--</th>-->
                                <!--<th class="span3 sortable">-->
                                    <!--<span class="line"></span>参考比例-->
                                <!--</th>-->

                            </tr>
                        </thead>
                        <tbody id="ajaxback">
                        <?php if(is_array($optionRs)): $i = 0; $__LIST__ = $optionRs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><!-- row -->
                        <tr class="first">
                            <td>
                                <?php echo ($v['id']); ?>
                            </td>
                            <td>
                                <a href="#" class="name" onclick="edit(<?php echo ($v['id']); ?>,'capital_name','产品名称')"><?php echo ($v['capital_name']); ?></a>
                            </td>
                            <td>
                                <p id="deal_status_opt_<?php echo ($v['id']); ?>">
                                    <input class="class_deal_status"  name="deal_status" data-option-id="<?php echo ($v['id']); ?>" type="checkbox" <?php echo ($v['deal_status_check']); ?> data-size="mini">
                                </p>
                            </td>
                            <td>
                                <b class="<?php echo ($v['deal_status_style']); ?>"><?php echo ($v['deal_status']); ?></b>
                            </td>
                            <td>
                                <b class="<?php echo ($v['sell_status_style']); ?>"><?php echo ($v['sell_status']); ?></b>                       
                            </td>
                            <td>
                                 <a class="layui-btn layui-btn-small layui-btn-normal layui-btn-radius capital_dot_length" onclick="edit(<?php echo ($v['id']); ?>,'capital_dot_length','品种价格')"><?php echo ($v['capital_dot_length']); ?></a>
                            </td>
                            <td>
                                <a class="layui-btn layui-btn-small layui-btn-normal layui-btn-radius wave" onclick="edit(<?php echo ($v['id']); ?>,'wave','波动金额')"><?php echo ($v['wave']); ?></a>
                            </td>

                            <td>
                                <a class="layui-btn layui-btn-small layui-btn-normal layui-btn-radius CounterFee" onclick="edit(<?php echo ($v['id']); ?>,'CounterFee','手续费')"><?php echo ($v['fee']); ?></a>
                            </td>

                            <td>
                                <a class="layui-btn layui-btn-small layui-btn-normal layui-btn-radius overnight_fee" onclick="edit(<?php echo ($v['id']); ?>,'overnight_fee','过夜费(买多)')"><?php echo ($v['overnight_fee']); ?></a>
                            </td>
    
                            <td>
                                <a class="layui-btn layui-btn-small layui-btn-normal layui-btn-radius overnight_fee" onclick="edit(<?php echo ($v['id']); ?>,'sell_overnight_fee','过夜费(卖空)')"><?php echo ($v['sell_overnight_fee']); ?></a>
                            </td>

                            <td>
                                <a class="layui-btn layui-btn-small layui-btn-normal layui-btn-radius bond" onclick="edit(<?php echo ($v['id']); ?>,'bond','最大杠杆倍数')"><?php echo ($v['bond']); ?></a>
                            </td>

                            <td>
                                <a class="layui-btn layui-btn-small layui-btn-normal layui-btn-radius contract_number" onclick="edit(<?php echo ($v['id']); ?>,'contract_number','合约数量')"><?php echo ($v['contract_number']); ?></a>
                            </td>

                            <td>
                                <a class="layui-btn layui-btn-small layui-btn-normal layui-btn-radius spread" onclick="edit(<?php echo ($v['id']); ?>,'spread','点差值')"><?php echo ($v['spread']); ?></a>
                            </td>

                            <td>
                                <b class="<?php echo ($v['style_color']); ?>"><?php echo ($v['Open']); ?></b>/<?php echo ($v['Close']); ?>
                            </td>
                            <td>
                                <div style="display:inline-block;float:left;">
                                    <?php echo ($dealTimeRs1[$v['id']]['deal_time']); ?>
                                </div>
                                <div style="display:inline-block;float:left;margin-left:20px;">
                                    <ul class="actions">
                                        <li style="border: 0;">
                                            <a class="option_time_edit" href="#" data-id="<?php echo ($v['id']); ?>"><i class="table-edit"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                 <?php echo ($class[$v['pid']]['name']); ?>
                            </td>
                            <td>
                                 <a class="layui-btn layui-btn-small layui-btn-primary  take" data-id="<?php echo ($v['id']); ?>" data-lang="zh-cn" style="text-align: center">中文</a>
                                <br/>
                                <a class="layui-btn layui-btn-small layui-btn-primary take" data-id="<?php echo ($v['id']); ?>" data-lang="en-us" style="text-align: center;margin-top: 4px;margin-right: 3.5px;">英文</a>
                            </td>

                            <td>
                                <a class="layui-btn layui-btn-small layui-btn-primary sort" onclick="edit(<?php echo ($v['id']); ?>,'sort','产品排序')"><?php echo ($v['sort']); ?></a>
                            </td>

                            <td>
                                <a class="layui-btn layui-btn-small layui-btn-primary option_key" onclick="edit(<?php echo ($v['id']); ?>,'option_key','英文名称')"><?php echo ($v['option_key']); ?></a>
                            </td>


                            <!--<td>-->
                                <!--<a class="layui-btn layui-btn-primary quote_capital_key" onclick="edit(<?php echo ($v['id']); ?>,'quote_capital_key','参考商品英文名称')"><?php echo ($v['quote_capital_key']); ?></a>-->
                            <!--</td>-->

                            <!--<td>-->
                                <!--<a class="layui-btn layui-btn-primary quote_value" onclick="edit(<?php echo ($v['id']); ?>,'quote_value','参考比例')"><?php echo ($v['quote_value']); ?></a>-->
                            <!--</td>-->

                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="pagination pull-right">
                    <ul>
                        <?php echo ($page); ?>
                    </ul>
                </div>
                </form>
            </div>

            <!-- end users table -->
        </div>
    </div>
</div>
<!-- end main container -->


<!-- scripts -->
<script src="/Public/Admin/js/jquery-latest.js"></script>
<script src="/Public/Admin/js/bootstrap.min.js"></script>
<script src="/Public/Admin/css/bootstrap/highlight.js"></script>
<script src="/Public/Admin/css/bootstrap/bootstrap-switch.js"></script>

<script src="/Public/Admin/js/theme.js"></script>
<script type="text/javascript" src="/Public/Js/layer/layer.js"></script>
<script type="text/javascript">  

</script>
<script type="text/javascript">
$(document).ready(function(){
    $('[name="deal_status"]').bootstrapSwitch({
        onText:"交易开启",
        offText:"交易关闭",
        onSwitchChange:function(event, state){
            if(state == true)
                flag = 1;
            else
                flag = 0;

            $.ajax({
                type: "post",
                url: "<?php echo U('Goods/opt_deal_status');?>",
                data:{'flag' : flag, 'option_id' : $(this).attr('data-option-id')},
                success: function(data) {
                    console.log(data.status);
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
                            content: '操作失败，请重新操作',
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
        }
    });


    $('.option_time_edit').click(function(){
        layer.open({
            type: 2,
            area: ['700px', '530px'],
            fixed: true, //不固定
            maxmin: true,
            title: "商品交易时间设置",
            content: ["<?php echo U('Goods/good_time_edit');?>?option_id="+$(this).attr('data-id'), 'no'],
            end: function () {
                top.location.reload();
            }
        });
    });


   //商品玩法
    $(".take").click(function(){

        var option_id   = $(this).attr('data-id');
        var lang        = $(this).attr('data-lang');
        
        layer.open({
            type: 2,
            area: ['600px', '500px'],
            fixed: true, //不固定
            maxmin: true,
            title: "商品玩法",
            content: ["<?php echo U('Goods/take');?>?option_id="+option_id+'&lang='+lang, 'no'],
            end: function () {
                //top.location.reload();
            }

        });
    });
    
});

function edit(option_id,field,msg){

 layer.prompt({title: '请输入要修改的'+msg+'', formType: 0}, function(pass, index){
    layer.close(index);

           $.ajax({
                type: "post",
                url: "<?php echo U('Goods/good_fee');?>",
                data:{'option_id' : option_id,'pass' : pass,'field' : field},
                success: function(data) {
                    console.log(data.status);
                    if(data.status == 1)
                    {
                        layer.open({
                            content: data.msg,
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
                            content: data.msg,
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

   });
}
</script>

</div>
<script type="text/javascript">
    var wid = $(window).height();
    document.writeln('<div id="popupLayer" style="position:absolute;z-index:2;width:100%;height:' + wid + 'px;left:0;top:0;opacity:0.3;filter:Alpha(opacity=30);background:#000;display: none;"></div>');

    var url = "<?php echo ($route); ?>";

    //对客户资金菜单 单独设置状态
    if (url == 'Withdraw') {
        $('.Recharge').addClass('active');
        $('.Recharge').find('div').addClass('pointer');
        $("#dashboard-menu .active .submenu").css("display", "block");
    } else {
        $('.' + url).addClass('active');
        $('.' + url).find('div').addClass('pointer');
        $("#dashboard-menu .active .submenu").css("display", "block");
    }

    //对表格上一级 进行滑动设置
    $('table').parent().css({"overflow-x": "auto"});
</script>
</body>
</html>