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
	
<!-- this page specific styles -->
<link rel="stylesheet" href="/Public/Admin/css/compiled/user-list.css" type="text/css" media="screen" />
<link href="/Public/Admin/css/lib/bootstrap.datepicker.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/layerui/css/layui.css">


<div class="container-fluid">
    <div id="pad-wrapper" class="users-list">
        <div class="row-fluid header">
                <form id="form1" action="/login/recharge/lists" method="get">
                <h3 style="height: 40px;width: 100%;">充值记录</h3>
                <div class="span10 pull-left" style="margin-top: 20px;">
                    <div class="tpsearch" style="width: 25%">
                    <input type="hidden" id="yunying" value="<?php echo ($yunying); ?>">
                        运营中心：<select id="otype" class="span6" name="yunying">
                                    <option value="">默认不选</option>
                                    <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["uid"]); ?>"><?php echo ($vo["username"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                    </div>
                    <div class="tpsearch" style="width: 25%">
                        销售商：<select id="jingjiren" class="span6" name="jingjiren">
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
                </div>

                <div class="span10 pull-left" style="margin-top: 20px;">
                    <div class="tpsearch">
                        用户类型：<select id="type" class="span6" name="user_type">
                                    <option value="">默认不选</option>
                                    <?php if($sea["user_type"] == '4'): ?><option value="4" selected>普通会员</option>
                                    <?php else: ?>
                                        <option value="4">普通会员</option><?php endif; ?>
                                    <?php if($sea["user_type"] == '5'): ?><option value="5" selected>运营中心</option>
                                    <?php else: ?>
                                        <option value="5">运营中心</option><?php endif; ?>
                                    <?php if($sea["user_type"] == '6'): ?><option value="6" selected>销售商</option>
                                    <?php else: ?>
                                        <option value="6">销售商</option><?php endif; ?>
                                </select>
                    </div>
                    <div class="tpsearch">
                        充值状态：<select id="type" class="span6" name="status">
                                    <option value="">默认不选</option>
                                    <?php if($sea["status"] == '0'): ?><option value="0" selected>待处理</option>
                                    <?php else: ?>
                                        <option value="0" >待处理</option><?php endif; ?>
                                    <?php if($sea["status"] == '1'): ?><option value="1" selected>充值成功</option>
                                    <?php else: ?>
                                        <option value="1" >充值成功</option><?php endif; ?>
                                    <?php if($sea["status"] == '2'): ?><option value="2" selected>充值失败</option>
                                    <?php else: ?>
                                        <option value="2">充值失败</option><?php endif; ?>
                                </select>
                    </div>

                    <div class="tpsearch">
                        电子邮箱：<input type="text" value="<?php echo ($sea["email"]); ?>" class="span6 search" placeholder="请输入电子邮箱查找..." name="email" id="email"/>
                    </div>
                </div>

                <div class="span10 pull-left" style="margin: 20px 0 10px 30px;">
                    
                    <div class="tpsearch">
                                    <?php if($sea['starttime']): ?><input class="layui-input input" style="width: 200px;" placeholder="开始时间" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="<?php echo ($sea['starttime']); ?>" name="starttime">
                                   <?php else: ?>
                                    <input class="layui-input input" style="width: 200px;" placeholder="开始时间" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="" name="starttime"><?php endif; ?>
                    </div>
                    <div class="tpsearch">
                            <?php if($sea['endtime']): ?><input class="layui-input input" style="width: 200px;" placeholder="结束时间" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="<?php echo ($sea['endtime']); ?>" name="endtime">
                                <?php else: ?>
                                    <input class="layui-input input" style="width: 200px;" placeholder="结束时间" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="" name="endtime"><?php endif; ?>
                    </div>
                    <div class="span10 pull-left " style="width:30%;">
                        <a href="javascript:void(0)" class="btn-flat info" onclick="submit()">开始查找</a>
                        <a href="javascript:void(0)" class="btn-flat info" onclick="sub()">查询导出</a>
                    </div>

                </div>
               
                </form>
            </div>
            
        <!-- Users table -->
        <div class="row-fluid table">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="span1 sortable">
                            编号
                        </th>
                        <th class="span1 sortable">
                            订单号
                        </th>
                        <th class="span1 sortable">
                            <span class="line"></span>用户名称
                        </th>
                        <th class="span1 sortable">
                            <span class="line"></span>电子邮箱
                        </th>
                        <th class="span2 sortable">
                            <span class="line"></span>用户类型
                        </th>
                        <th class="span2 sortable">
                            <span class="line"></span>生成时间
                        </th>
                        <th class="span2 sortable">
                            <span class="line"></span>处理时间
                        </th>
                        <th class="span2 sortable">
                            <span class="line"></span>充值金额
                        </th>

                        <th class="span2 sortable">
                            <span class="line"></span>状态
                        </th>
                        <th class="span2 sortable">
                            <span class="line"></span>充值渠道
                        </th>
                        <th class="span2 sortable">
                            <span class="line"></span>接口校验
                        </th>
                        
                    </tr>
                </thead>
                <tbody id="ajaxback">
                <?php if(is_array($rechargelist)): $i = 0; $__LIST__ = $rechargelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$relist): $mod = ($i % 2 );++$i;?><!-- row -->
                <tr class="first">
                    
                    <td>
                        <?php echo ($relist["bpid"]); ?>
                    </td>
                    <td>
                        <?php echo ($relist["balanceno"]); ?>
                    </td>
                    <td>
                        <a href="<?php echo U('User/updateuser',array('uid'=>$relist['uid']));?>"> <?php echo getUsername($relist['uid']);?></a>
                    </td>

                    <td>
                        <?php echo ($relist[email]); ?>
                    </td>
                    
                    <td>
                       <?php if(($relist['otype']) == "4"): ?>普通会员<?php endif; ?>
                        <?php if(($relist['otype']) == "5"): ?>运营中心<?php endif; ?>
                        <?php if(($relist['otype']) == "6"): ?>销售商<?php endif; ?>
                    </td>
                    <td>
                        <?php echo (date('Y-m-d H:i:s',$relist[bptime])); ?>
                    </td>
                    <td>
                        <?php if($relist['cltime'] != ''): echo (date('Y-m-d H:i:s',$relist[cltime])); ?>
                        <?php else: ?>
                         —<?php endif; ?>
                    </td>
                    <td>
                        <font color="#f00" size="4"><?php echo ($relist["bpprice"]); ?></font>
                    </td>
                    <td>

                        <?php if($relist['status'] == 1 ): ?><font color="green">充值完成</font>
                        <?php elseif($relist['status'] == 2): ?>
                            <font color="red">充值失败</font>
                        <?php else: ?>
                             <font color="red">待处理</font><?php endif; ?>

                    </td>
                    <td><?php echo ($relist["pay_name"]); ?></td>
                    <td>
                        <?php if(($relist['status'] == 0) OR ($relist['status'] == 2) AND ($relist['pay_type'] == 1)): ?><!-- <button class="layui-btn getMoney" data-balanceno="<?php echo ($relist["balanceno"]); ?>">点击校验</button> -->
                           <button class="layui-btn layui-btn-disabled">无需校验</button>
                        <?php else: ?>
                           <button class="layui-btn layui-btn-disabled">无需校验</button><?php endif; ?>
                    </td>
                </tr>
                
                <!-- row --><?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
        </div>
        <span style="color: red;">总充值金额&nbsp;:<?php if($amount == ''): ?>0.00<?php else: echo ($amount["amount"]); endif; ?></span> </br>
        <span style="color: red;">成功充值金额&nbsp;:<?php if($amount == ''): ?>0.00<?php else: echo ($amount["chengong"]); endif; ?></span>
        <div class="pagination pull-right">
            <ul id="show">
                <?php echo ($page); ?>
            </ul>
        </div>
        <!-- end users table -->
    </div>
</div>

<!-- scripts -->
<script src="/Public/Admin/js/jquery-latest.js"></script>
<script src="/Public/Admin/js/bootstrap.min.js"></script>
<script src="/Public/Admin/js/popup_layer.js"></script>
<script src="/Public/Admin/js/bootstrap.datepicker.js"></script>
<script src="/Public/Admin/js/theme.js"></script>
<script type="text/javascript">

function sub()
{
    $('#form1').attr("action","/login/recharge/daochu_rechare");
    $('#form1').submit();
}

function submit() {

    $('#form1').attr("action","/login/recharge/lists");
    $('#form1').submit();
}

</script>
<script type="text/javascript">

//运营中心回填
var yunying = $("#yunying").val();
$("#otype option").each(function(){      
    if(yunying == $(this).val()){
        $(this).attr('selected',true);
    }
});

 /*根据选择运营中心销售商选择*/
$("#otype").change(function() {
        var parent_id = $("#otype").val();
        $.ajax({
            type: "GET",
            url: "<?php echo U("user/ajax_get_brokers");?>",
            data: "parent_id="+parent_id,
            success: function(data){
            var html = '';
            var list = data.data;
            html +='<option value="">默认不选</option>';
            if(data.status>0){
                for (x in list) {
                    html +="<option value=\""+list[x]['uid']+"\">"+list[x]['username']+"</option>"
                }
            }
            $("#jingjiren").html(html);
        }
   });
});
    /*根据选择销售商获取下属会员列表*/
$("#jingjiren").change(function() {
        var parent_id = $("#jingjiren").val();
        $.ajax({
            type: "GET",
            url: "<?php echo U("user/ajax_get_brokers");?>",
            data: "parent_id="+parent_id,
            success: function(data){
            var html = '';
            var list = data.data;
            html +='<option value="">默认不选</option>';
            if(data.status>0){
                for (x in list) {
                    html +="<option value=\""+list[x]['uid']+"\">"+list[x]['username']+"</option>"
                }
            }
            $("#user").html(html);
        }
    });
});
</script>

<script type="text/javascript" src="/Public/Js/layer/layer.js"></script>
<script type="text/javascript" src="/Public/Admin/css/layerui/layui.js"></script>
<script type="text/javascript">
$('.getMoney').click(function(){

    var index = layer.load(0, {
    shade: [0.1,'#fff'] //0.1透明度的白色背景
    });
    
    var o_id = $(this).attr('data-balanceno');
    $.ajax({
            url: "<?php echo U('./Home/YbPay/payQuery');?>",
            dataType: 'json',
            type: 'post',
            data: {'oid': o_id},
            success: function (data) {
                  layer.close(index);

                    layer.msg(data.msg, {
                        icon: 7,
                        time: 5*1000,
                      });
                  if(data.status == 200)
                  {
                        return top.location.reload();
                  } else {
                    return false;
                  }
            }
    });    
});

//日期选择时间
layui.use('laydate', function(){
  var laydate = layui.laydate;
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