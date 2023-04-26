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
	
	<link rel="stylesheet" href="/Public/Admin/css/compiled/order-list.css" type="text/css" media="screen"/>
	<link href="/Public/Admin/css/lib/bootstrap.datepicker.css" type="text/css" rel="stylesheet"/>
	<link rel="stylesheet" type="text/css" href="/Public/Admin/css/layerui/css/layui.css">
	<script type="text/javascript" src="/Public/Admin/css/layerui/layui.js"></script>
	<style>
		.tpsearch {
			margin-bottom: 20px;
		}
	</style>
	<div class="container-fluid">
		<div id="pad-wrapper" class="users-list">
			<div class="row-fluid header">
				<form id="form1" action="/login/order/tlist" method="get">
					<h3 style="height:40px;width: 100%">实盘交易流水</h3>
					<div class="span10 pull-left">
						<div class="tpsearch" style="width: 25%">
							电子邮箱：<input type="text" value="<?php echo ($sea["email"]); ?>" class="span6 search" placeholder="请输入电子邮箱查找..." name="email" id="email"/>
						</div>
						<div class="tpsearch" style="width: 25%">
							订单号码：<input type="text" value="<?php echo ($sea["orderno"]); ?>" class="span6 search" placeholder="请输入订单号码查找..." name="orderno"/>
						</div>
						<div class="tpsearch" style="width: 25%">
							<input class="layui-input input" style="width: 200px;" placeholder="开始时间" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="<?php echo ($sea['starttime']); ?>" name="starttime" id="starttime">
						</div>
						<div class="tpsearch" style="width: 25%">
							<input class="layui-input input" style="width: 200px;" placeholder="结束时间" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="<?php echo ($sea['endtime']); ?>" name="endtime" id="endtime">
						</div>
					</div>
					<div class="span10 pull-left" style="margin-top: 20px;">
						
						<div class="tpsearch" style="width: 25%">
							<input type="hidden" id="user_id" value="<?php echo ($user_id); ?>">
							运营中心：<select id="otype" class="span6" name="otype">
							<option value="">默认不选</option>
							<?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["uid"]); ?>"><?php echo ($vo["username"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
						</div>
						<div class="tpsearch" style="width: 25%;">
							销售：<select id="jingjiren" class="span6" name="jingjiren">
							<option value="">默认不选</option>
							<?php if(!empty($jingjiren)): ?><option value="<?php echo ($jingjiren['uid']); ?>" selected><?php echo ($jingjiren['username']); ?></option><?php endif; ?>
						</select>
						</div>
						<div class="tpsearch" style="width: 25%">
							会员：<select id="user" class="span6" name="user">
							<option value="">默认不选</option>
							<?php if(!empty($user)): ?><option value="<?php echo ($user['uid']); ?>" selected><?php echo ($user['username']); ?></option><?php endif; ?>
						</select>
						</div>
						<div class="tpsearch" style="width: 25%">
							订单类型：<select id="ostyle" class="span6" name="ostyle">
							<option value="">默认不选</option>
							<?php if($sea["ostyle"] == '0'): ?><option value="0" selected>买入</option>
								<?php else: ?>
								<option value="0">买入</option><?php endif; ?>
							<?php if($sea["ostyle"] == '1'): ?><option value="1" selected>卖出</option>
								<?php else: ?>
								<option value="1">卖出</option><?php endif; ?>
						</select>
						</div>
						
						
						<div style="margin-top: 50px;">
							<div class="tpsearch" style="width: 21.5%">
								订单状态：<select name="ostaus" id="ostaus" class="span7">
								<option value="">默认不选</option>
								<?php if($sea["ostaus"] == '0'): ?><option value="0" selected>建仓</option>
									<?php else: ?>
									<option value="0">建仓</option><?php endif; ?>
								<?php if($sea["ostaus"] == 1): ?><option value="1" selected>平仓</option>
									<?php else: ?>
									<option value="1">平仓</option><?php endif; ?>
							
							</select>
							</div>
							<div class="tpsearch" style="width: 25%;margin-left: 2.6%;">
								
								订单结果：<select id="ploss" class="span6" name="order_result">
								<option value="">默认不选</option>
								<?php if($sea['order_result'] == '1'): ?><option value="1" selected>平局</option>
									<?php else: ?>
									<option value="1">平局</option><?php endif; ?>
								
								<?php if($sea['order_result'] == '2'): ?><option value="2" selected>盈利</option>
									<?php else: ?>
									<option value="2">盈利</option><?php endif; ?>
								
								<?php if($sea['order_result'] == '3'): ?><option value="3" selected>亏损</option>
									<?php else: ?>
									<option value="3">亏损</option><?php endif; ?>
							</select>
							
							</div>
							
							<div class="tpsearch" style="width: 25%">
								产品大类：<select name="optin_class_max" class="span7 optin_class_max">
								<option value="">默认不选</option>
								<?php if(is_array($classify)): $i = 0; $__LIST__ = $classify;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($optin_class_max) == $vo['id']): ?><option value="<?php echo ($vo["id"]); ?>" selected=""><?php echo ($vo["name"]); ?></option>
										<?php else: ?>
										<option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
							</select>
							</div>
							
							<div class="tpsearch" style="width: 25%">
								产品小类：<select name="optin_class_min" class="span7 optin_class_min">
								<option value="">默认不选</option>
								<?php if(is_array($mindata)): $i = 0; $__LIST__ = $mindata;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($optin_class_min) == $vo['id']): ?><option value="<?php echo ($vo["id"]); ?>" selected=""><?php echo ($vo["name"]); ?></option>
										<?php else: ?>
										<option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
							</select>
							</div>
							
							<div class="tpsearch" style="width: 25%">
								交易产品：<select name="option_name" class="span7 option_name">
								<option value="">默认不选</option>
								<?php if(is_array($option)): $i = 0; $__LIST__ = $option;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($option_name) == $vo['id']): ?><option value="<?php echo ($vo["id"]); ?>" selected=""><?php echo ($vo["capital_name"]); ?></option>
										<?php else: ?>
										<option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["capital_name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
							</select>
							</div>
							
							<div class="tpsearch" style="width: 25%">
								交易时间：<select name="datetype" class="span7" id="datetype" onchange="cleanDateTime()">
								<option value="">默认不选</option>
								<option value="1" data-start="<?php echo ($starttimeYesterday); ?>" data-end="<?php echo ($endtimeYesterday); ?>"
								<?php if($datetype == 1): ?>selected="selected"<?php endif; ?>
								>昨日</option>
								<option value="2" data-start="<?php echo ($starttimeWeek); ?>" data-end="<?php echo ($endtimeWeek); ?>"
								<?php if($datetype == 2): ?>selected="selected"<?php endif; ?>
								>本周</option>
								<option value="3" data-start="<?php echo ($starttimeLastWeek); ?>" data-end="<?php echo ($endtimeLastWeek); ?>"
								<?php if($datetype == 3): ?>selected="selected"<?php endif; ?>
								>上周</option>
								<option value="4" data-start="<?php echo ($starttimeLastMonth); ?>" data-end="<?php echo ($endtimeLastMonth); ?>"
								<?php if($datetype == 4): ?>selected="selected"<?php endif; ?>
								>上月</option>
							</select>
							</div>
						</div>
						
						
						<input type="hidden" name="type" value="1">
						<div class="span10 pull-left" style="margin-top: 20px;">
							<a href="javascript:void(0)" class="btn-flat" onclick="submit()">开始查找</a>
							<a href="javascript:void(0)" class="btn-flat info" onclick="sub()">查找导出</a>
						</div>
				</form>
			</div>
			<!-- Users table -->
			<div class="row-fluid table">
				<!--//这个地方动态加载-->
				<table class="table table-hover">
					<thead>
					<tr>
						<th class="span2 sortable">
							<span class="line"></span>编号
						</th>
						<th class="span2 sortable">
							<span class="line"></span>订单号
						</th>
						<th class="span2 sortable">
							<span class="line"></span>用户名称
						</th>
						<th class="span2 sortable">
							<span class="line"></span>用户昵称
						</th>
						<th class="span2 sortable">
							<span class="line"></span>电子邮箱
						</th>
						<th class="span1 sortable">
							<span class="line"></span>运营中心
						</th>
						<th class="span1 sortable">
							<span class="line"></span>销售
						</th>
						<th class="span3 sortable">
							<span class="line"></span>建仓时间
						</th>
						<th class="span3 sortable">
							<span class="line"></span>平仓时间
						</th>
						<th class="span2 sortable">
							<span class="line"></span>产品信息
						</th>
						<th class="span2 sortable">
							<span class="line"></span>数量(手)
						</th>
						<th class="span2 sortable">
							<span class="line"></span>方向
						</th>
						<th class="span2 sortable">
							<span class="line"></span>止盈
						</th>
						<th class="span2 sortable">
							<span class="line"></span>止损
						</th>
						<th class="span2 sortable">
							<span class="line"></span>保证金
						</th>
						<th class="span2 sortable">
							<span class="line"></span>手续费
						</th>
						<th class="span2 sortable">
							<span class="line"></span>隔夜费
						</th>
						<th class="span2 sortable">
							<span class="line"></span>买入价
						</th>
						<th class="span2 sortable">
							<span class="line"></span>卖出价
						</th>
						<th class="span2 sortable">
							<span class="line"></span>买入时长
						</th>
						<th class="span2 sortable">
							<span class="line"></span>出入金
						</th>
						<th class="span2 sortable">
							<span class="line"></span>盈亏
						</th>
						<th class="span2 sortable">
							<span class="line"></span>平仓类型
						</th>
						<th class="span2 sortable">
							<span class="line"></span>订单结果
						</th>
						<th class="span2 sortable">
							<span class="line"></span>订单类型
						</th>
					</tr>
					</thead>
					<tbody id="ajaxback">
					<?php if(is_array($tlist)): $i = 0; $__LIST__ = $tlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tl): $mod = ($i % 2 );++$i;?><tr class="first">
							<td>
								<?php echo ($tl["oid"]); ?>
							</td>
							<td>
								<?php echo ($tl["orderno"]); ?>
							</td>
							<td>
								<a href="<?php echo U('User/updateuser',array('uid'=>$tl['uid']));?>" class="name">
									<?php echo ($tl["username"]); ?>
								</a>
							</td>
							<td><?php echo ($tl["nickname"]); ?></td>
							<td>
								<?php echo ($tl["email"]); ?>
							</td>
							
							<td><?php echo change(exchange($tl[uid],2));?></td>
							<td><?php echo change(exchange($tl[uid],1));?></td>
							<td><?php echo (date('Y-m-d H:i:s',$tl["buytime"])); ?></td>
							
							<?php if(($tl['ostaus']) == "0"): ?><td>--</td>
								<?php else: ?>
								<td><?php echo (date('Y-m-d H:i:s',$tl["selltime"])); ?></td><?php endif; ?>
							
							<td>
								<?php echo ($tl["option_name"]); ?>
							</td>
							<?php if($tl['order_scene'] == 1): ?><td><?php echo ($tl["onumber"]); ?>手</td>
								<?php else: ?>
								<td>--</td><?php endif; ?>
							<td>
								<?php if($tl["ostyle"] == 1): ?><span class="label label-success">卖出</span>
									<?php else: ?>
									<span class="label label-cc">买入</span><?php endif; ?>
							</td>
							
							<?php if($tl['order_scene'] == 1): ?><td><?php echo ($tl["endprofit"]); ?></td>
								<td><?php echo ($tl["endloss"]); ?></td>
								<?php else: ?>
								<td>--</td>
								<td>--</td><?php endif; ?>
							
							<td>
								<?php echo ($tl['Bond']); ?>
							</td>
							<td>
								<?php echo ($tl["fee"]); ?>
							</td>
							
							<td>
								<?php if($tl["order_scene"] == 1): echo ($tl["overnight_fee"]); ?>
								<?php else: ?>
									--<?php endif; ?>
							</td>
							<td>
								<font color="#ed0000" size="2"><?php echo ($tl["buyprice"]); ?></font>
							</td>
							<td>
								<?php if(($tl['ostaus']) == "1"): if($tl["buyprice"] < $tl["sellprice"]): ?><font color="#ed0000" size="2"><?php echo ($tl["sellprice"]); ?></font>
										<?php else: ?>
										<font color="#2fb44e" size="2"><?php echo ($tl["sellprice"]); ?></font><?php endif; ?>
									<?php else: ?>
									<font color="#ed0000" size="2">--</font><?php endif; ?>
							</td>
							
							<?php if($tl["order_scene"] == 1): ?><td>--</td>
							<?php else: ?>
								<td><?php echo ($tl["second"]); ?>秒</td><?php endif; ?>
							
							<td>
								
								<?php if($tl["access"] >= 0): ?><font color="#ed0000" size="2">+<?php echo ($tl["access"]); ?></font>
									<?php else: ?>
									<font color="#2fb44e" size="2"><?php echo ($tl["access"]); ?></font><?php endif; ?>
							</td>
							
							<td>
								<?php if(($tl['ostaus']) == "1"): if($tl["ploss"] >= 0): ?><font color="#ed0000" size="2">+<?php echo ($tl["ploss"]); ?></font>
										<?php else: ?>
										<font color="#2fb44e" size="2"><?php echo ($tl["ploss"]); ?></font><?php endif; ?>
									<?php else: ?>
									<font color="#ed0000" size="2">0.00</font><?php endif; ?>
							</td>
							
							<td>
								<?php if(($tl['ostaus']) == "1"): if(($tl['auto']) == "1"): ?><font color="#2fb44e" size="2">手动</font>
										<?php else: ?>
										<font color="#ed0000" size="2">自动</font><?php endif; endif; ?>
							</td>
							
							<td>
								<?php if(($tl['ostaus']) == "1"): if($tl['order_result'] == 1): ?><font color="#ed0000" size="2">平局</font>
										<?php elseif($tl['order_result'] == 2): ?>
										<font color="#ed0000" size="2">盈利</font>
										<?php else: ?>
										<font color="#2fb44e" size="2">亏损</font><?php endif; endif; ?>
							</td>
							
							<td>
								<?php if($tl['order_type'] == 1): ?><font color="#ed0000" size="2">自持</font>
									<?php elseif($tl['order_type'] == 2): ?>
									<font color="#ed0000" size="2">跟随</font>
									<?php else: ?>
									<font color="#ed0000" size="2">挂单</font><?php endif; ?>
							</td>
						
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
				</table>
				<div class="qjcz">
					<span style="margin-right:30px;float:right">
						总金额：<em style="color:red;font-weight: bold; font-size: 14px;"><?php echo ($data["account"]); ?></em><br>
						总盈亏：<em style="color:red;font-weight: bold; font-size: 14px;"><?php echo ($data["ploss"]); ?></em><br>
						总手续费：<em style="color:red;font-weight: bold;font-size: 14px;"><?php echo ($data["fee"]); ?></em><br>
                        总隔夜费：<em style="color:red;font-weight: bold;font-size: 14px;"><?php echo ($data["overnight_fee"]); ?></em><br>
				    </span>
					<span style="margin-right:30px;float:right">
                        总订单：<em style="color:red;font-weight: bold; font-size: 14px;"><?php echo ($data["count"]); ?>个</em><br>
				    </span>
				</div>
			</div>
			<div class="pagination pull-right">
				<ul>
					<?php echo ($page); ?>
				</ul>
			</div>
			<!-- end users table -->
		</div>
	</div>
	<!-- end main container -->
	<div id="loading" style="width: 100%;height: 105%;position: absolute;top: 0; z-index: 9999;display: none;">
		<div class="load-center" style="background: #000;position: absolute;width: 60%;height: 14%;bottom: 10%;border-radius: 10px;color: #fff;text-align: center;font-size: 24px;left: 17%;padding: 1%;">
			<img src="/Public/Admin/img/ajax-loading.jpg" alt="ajax-loading" width="40"/><br/>页面加载中...
		</div>
	</div>
	<!-- scripts -->
	
	<script src="/Public/Admin/js/jquery-latest.js"></script>
	<script src="/Public/Admin/js/bootstrap.min.js"></script>
	<script src="/Public/Admin/js/bootstrap.datepicker.js"></script>
	<script src="/Public/Admin/js/theme.js"></script>
	<script type="text/javascript">
        $(function () {

            // datepicker plugin
            $('.datepicker').datepicker().on('changeDate', function (ev) {
                $(this).datepicker('hide');
            });
        });
	</script>
	<script type="text/javascript">
        $(document).ready(function () {

            /**
             * 时间对象的格式化;
             */
            Date.prototype.format = function (format) {
                /*
				 * eg:format="yyyy-MM-dd hh:mm:ss";
				 */
                var o = {
                    "M+": this.getMonth() + 1, // month
                    "d+": this.getDate(), // day
                    "h+": this.getHours(), // hour
                    "m+": this.getMinutes(), // minute
                    "s+": this.getSeconds(), // second
                    "q+": Math.floor((this.getMonth() + 3) / 3), // quarter
                    "S": this.getMilliseconds()
                    // millisecond
                }

                if (/(y+)/.test(format)) {
                    format = format.replace(RegExp.$1, (this.getFullYear() + "").substr(4
                        - RegExp.$1.length));
                }

                for (var k in o) {
                    if (new RegExp("(" + k + ")").test(format)) {
                        format = format.replace(RegExp.$1, RegExp.$1.length == 1
                            ? o[k]
                            : ("00" + o[k]).substr(("" + o[k]).length));
                    }
                }
                return format;
            }

            //var now = new Date().format("MM/dd/yyyy");
            //$(".input-large").attr("value",now);
        });


        function cleanDateTime() {
            var dt = $('#datetype').val();
            if (dt > 0) {
                var starttime = $('#datetype').find(":selected").attr("data-start");
                var endtime = $('#datetype').find(":selected").attr("data-end");
                $("#starttime").val(starttime);
                $("#endtime").val(endtime);
            } else {
                $("#starttime").val("");
                $("#endtime").val("");
            }
        }

        function sub() {
            $('#form1').attr("action", "/login/order/daochu");
            $('#form1').submit();
        }

        function submit() {

            $('#form1').attr("action", "/login/order/tlist");
            $('#form1').submit();
        }

        $(function () {

            var user_id = $("#user_id").val();
            $("#otype option").each(function () {

                if (user_id == $(this).val()) {

                    $(this).attr('selected', true);
                }
            });

            var op_name = $("#op_name").val();
            $("#option option").each(function () {
                if (op_name == $(this).val()) {

                    $(this).attr('selected', true);
                }
            });

        });

        /*根据选择运营中心机构选择*/
        $("#otype").change(function () {
            var parent_id = $("#otype").val();
            $.ajax({
                type: "GET",
                url: "<?php echo U("user / ajax_get_brokers
            ");?>",
                data
        :
            "parent_id=" + parent_id,
                success
        :

            function (data) {
                var html = '';
                var list = data.data;
                html += '<option value="">默认不选</option>';
                if (data.status > 0) {
                    for (x in list) {
                        html += "<option value=\"" + list[x]['uid'] + "\">" + list[x]['username'] + "</option>"
                    }
                }
                $("#jingjiren").html(html);
            }
        })
            ;
        });
        /*根据选择机构获取下属会员列表*/
        $("#jingjiren").change(function () {
            var parent_id = $("#jingjiren").val();
            $.ajax({
                type: "GET",
                url: "<?php echo U("user / ajax_get_brokers
            ");?>",
                data
        :
            "parent_id=" + parent_id,
                success
        :

            function (data) {
                var html = '';
                var list = data.data;
                html += '<option value="">默认不选</option>';
                if (data.status > 0) {
                    for (x in list) {
                        html += "<option value=\"" + list[x]['uid'] + "\">" + list[x]['username'] + "</option>"
                    }
                }
                $("#user").html(html);
            }
        })
            ;
        });

        layui.use('laydate', function () {
            var laydate = layui.laydate;
        });

        $(".optin_class_max").change(function () {
            var parent_id = $(this).val();
            $.ajax({
                type: "get",
                url: "<?php echo U('getOptionClassify');?>",
                data: {'parent_id': parent_id},
                success: function (data) {
                    var html = '';
                    var list = data.data;
                    html += '<option value="">默认不选</option>';
                    if (data.status > 0) {
                        for (x in list) {
                            html += "<option value=\"" + list[x]['id'] + "\">" + list[x]['name'] + "</option>"
                        }
                    }
                    $(".optin_class_min").html(html);
                },
            });
        });

        $(".optin_class_min").change(function () {
            var parent_id = $(this).val();
            $.ajax({
                type: "get",
                url: "<?php echo U('getOption');?>",
                data: {'parent_id': parent_id},
                success: function (data) {
                    var html = '';
                    var list = data.data;
                    html += '<option value="">默认不选</option>';
                    if (data.status > 0) {
                        for (x in list) {
                            html += "<option value=\"" + list[x]['id'] + "\">" + list[x]['capital_name'] + "</option>"
                        }
                    }
                    $(".option_name").html(html);
                },
            });
        });
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