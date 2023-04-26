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
    <link rel="stylesheet" href="/Public/Admin/css/compiled/user-list.css" type="text/css" media="screen">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/layerui/css/layui.css">


    <div class="container-fluid">
        <div id="pad-wrapper" class="users-list">
            <div class="row-fluid header" style="margin-bottom: 10px">
                <form id="form1" action="/login/agent/index" method="get">
                    <h3 style="height: 40px; width: 100%;font-size: 24px;">销售商列表</h3>
                    <div class="span10 pull-left">
                        <div class="tpsearch" style="width: 20%">
                            运营中心：<select name="uid" id="uid" class="span7">
                            <option value="">默认不选</option>
                            <?php if(is_array($extends)): foreach($extends as $key=>$vo): if($uid == $vo['uid']){ ?>
                                <option value="<?php echo ($vo["uid"]); ?>" selected><?php echo ($vo["username"]); ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo ($vo["uid"]); ?>"><?php echo ($vo["username"]); ?></option>
                                <?php } endforeach; endif; ?>
                        </select>
                        </div>
                        <div class="tpsearch" style="width: 20%">
                            手机号：<input type="text" class="span6 search" value="<?php echo ($phone); ?>" placeholder="请输入手机号" name="phone" id="phone"/>
                        </div>
                        <div class="tpsearch"  style="width: 20%">
                            用户名称：<input type="text" value="<?php echo ($username); ?>" class="span6 search" placeholder="请输入用户名称查找..." name="username" id="username"/>
                        </div>

                    </div>
                    <div class="tpsearch" style="width:12%;float:right">
                        <a href="javascript:void(0)" class="btn-flat info" id="submit">开始查找</a>
                        <a href="javascript:void(0)" class="btn-flat info" id="daochu">查找导出</a>
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
                        <th class="span2 sortable">
                            <span class="line"></span>用户名
                        </th>

                        <th class="span2 sortable">
                            <span class="line"></span>昵称
                        </th>

                        <th class="span2 sortable">
                            <span class="line"></span>手机号
                        </th>

                        <th class="span2 sortable">
                            <span class="line"></span>注册时间
                        </th>
                        
                        <th class="span2 sortable">
                            <span class="line"></span>注册ip
                        </th>

                        <th class="span2 sortable">
                            <span class="line"></span>登录时间
                        </th>

                        <th class="span2 sortable">
                            <span class="line"></span>登录ip
                        </th>

                        <th class="span2 sortable">
                            <span class="line"></span>所属运营中心
                        </th>
                        <th class="span2 sortable">
                            <span class="line"></span>操作
                        </th>
                    </tr>
                    </thead>
                    <tbody id="ajaxback">
                    <?php if(is_array($agent)): $i = 0; $__LIST__ = $agent;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ult): $mod = ($i % 2 );++$i;?><!-- row -->
                        <tr class="first">
                            <td>
                                <?php echo ($ult['uid']); ?>
                            </td>

                            <td>
                                <a href="javascript:void(0)"  style="color: red;" onclick="showdetail(<?php echo ($ult['uid']); ?>)" title="查看资金详情"><?php echo ($ult['username']); ?>
                                <?php if(($ult['is_default']) == "1"): ?><span>(默认)</span><?php endif; ?>
                                </a>
                            </td>
                            
                            <td>
                                <?php echo ($ult['nickname']); ?>
                            </td>

                            <td>
                                <?php echo ($ult['utel']); ?>
                            </td>

                            <td>
                                <?php echo (date('Y-m-d H:i:s',$ult["utime"])); ?>
                            </td>
                            
                            <td>
                                <?php echo ($ult["reg_ip"]); ?>
                            </td>
                            
                            <td>
                                <?php if(!empty($ult['lastlog'])): echo (date('Y-m-d H:i:s',$ult["lastlog"])); ?>
                                <?php else: ?>
                                    尚未登录<?php endif; ?>
                            </td>
                            
                            <td>
                                <?php if(!empty($ult['last_login_ip'])): echo ($ult["last_login_ip"]); ?>
                                <?php else: ?>
                                    尚未登录<?php endif; ?>
                            </td>

                            <td>
                                <?php echo ($user[$ult['parent_user_id']]['name']); ?>
                            </td>

                            <td>
                                <a href="<?php echo U('user/resetpwd/',array('uid'=>$ult['uid']));?>" class="layui-btn layui-btn-normal layui-btn-mini">重置密码</a>
                                <a  class="del layui-btn layui-btn-mini layui-btn-danger"  data-id="<?php echo ($ult['uid']); ?>">删除</a>
                            </td>

                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
                <div class="qjcz">
                    <span style="margin-right:30px;float:right">总销售商：<i style="color:red"><?php echo ($count); ?>个</i><br></span>
                </div>
            </div>
            <div class="pagination pull-right">
                <ul>
                    <?php echo ($page); ?>
                </ul>
            </div>
            <!-- end users table -->
        </div>


    <!--运营上详情界面 the template of the showdetail-->
    <div style="display:none;" id="showdetail">
        <div class="container-fluid">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row"  style="margin-left:0;">
                <div class="col-md-6">
                    <h2>交易信息统计</h2>

                    <table class="special_table_border table table-striped table-bordered" style="text-align:center;">
                        <tbody>
                        <tr>
                            <td class="center hidden-xs specla_background_class">
                                <h5>订单总数</h5>
                            </td>
                            <td class="center specla_background_class">
                                <h5>订单总金额</h5>
                            </td>
                            <td class="center specla_background_class">
                                <h5>总盈亏</h5>
                            </td>
                            <td class="center specla_background_class">
                                <h5>总手续费</h5>
                            </td>
                        </tr>
                        <tr>
                            <td id="show_order_total"></td>
                            <td id="show_order_count"></td>
                            <td id="show_order_money"></td>
                            <td id="show_order_fee"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row"  style="margin-left:0;">
                <div class="col-md-6">
                    <h3 class="header smaller lighter blue">用户信息统计</h3>

                    <table class="special_table_border table table-striped table-bordered">

                        <tbody>
                        <tr>
                            <td class="center specla_background_class">
                                <h5>用户总数</h5>
                            </td>
                        </tr>
                        <tr>
                            <td id="show_user_total"></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- PAGE CONTENT ENDS -->
        </div>
    </div>
    <!-- scripts -->
    <script src="/Public/Admin/js/jquery-latest.js"></script>
    <script src="/Public/Admin/js/bootstrap.min.js"></script>
    <script src="/Public/Admin/js/bootstrap.datepicker.js"></script>
    <script src="/Public/Admin/js/theme.js"></script>
    <script type="text/javascript" src="/Public/Js/layer/layer.js"></script>
    <script type="text/javascript">

            $('#daochu').click(function(){
                $('#form1').attr("action","/login/agent/daochu");
                $('#form1').submit();
            });

            $('#submit').click(function(){
                $('#form1').attr("action","/login/agent/index");
                $('#form1').submit();
            });


        $(".del").click(function(){

            var uid = $(this).attr('data-id');

            //询问框
            layer.open({
                content: '您确定要删除吗？'
                ,btn: ['确定', '不要']
                ,yes: function(index){

                    $.ajax({
                        url:"<?php echo U('agent_del');?>",
                        type:"post",
                        dataType:"json",
                        data:"uid="+uid+"",
                        success:function(data){
                            if(data.status === 0){

                                layer.msg(data.msg);
                                return false;
                            } else {

                                layer.msg(data.msg);
                                top.location.reload();
                                return false;
                            }

                        }
                    });
                    layer.close(index);
                }
            });

        });
    </script>

    <script type="text/javascript">

        //展示指定销售商资金详情
        function showdetail(uid){
            if(uid == ''){
                layer.msg('用户id不存在');
            }else{
                $.ajax({
                    type: "post",
                    url: "<?php echo U('show');?>",
                    data: {'uid': uid},
                    success: function(data){
                        $("#show_account").html('<strong>&yen;'+data.data.account+'</strong>');
                        $("#show_order_total").html('<strong>&yen;'+data.data.order_total+'</strong>');
                        $("#show_order_count").html('<strong>&yen;'+data.data.total_count+'</strong>');
                        $("#show_order_money").html('<strong>&yen;'+data.data.total_money+'</strong>');
                        $("#show_order_fee").html('<strong>&yen;'+data.data.total_fee+'</strong>');
                        $("#show_user_total").html('<strong>'+data.data.user_total+' 个</strong>');
                        layer.open({
                            type: 1,
                            shadeClose: true,
                            title: '<strong>'+data.data.username+'</strong> 的资金统计',
                            area: ['800px', '300px'],
                            content: $('#showdetail') //这里content是一个DOM，注意：最好该元素要存放在body最外层，否则可能被其它的相对元素所影响
                        });
                    }
                });
            }
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