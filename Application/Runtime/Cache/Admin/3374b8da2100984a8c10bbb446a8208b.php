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
	
<link rel="stylesheet" href="/Public/Admin/css/compiled/user-list.css" type="text/css" media="screen">
<link rel="stylesheet" href="/Public/Admin/css/layerui/css/layui.css"  media="all">
<script typet="text/javascript" src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/Public/css/layer/layer.js"></script>
              
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
  <legend>销售商</legend>
</fieldset>
<form id="submit" method="post" class="layui-form">
  
  <div class="layui-form-item">
    <label class="layui-form-label">运营中心</label>
    <div class="layui-input-inline">
      <select name="parent_user_id">
        <option value="">请选择</option>
        <?php if(is_array($extends)): $i = 0; $__LIST__ = $extends;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["uid"]); ?>"><?php echo ($vo["username"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
      </select>
    </div>
     <div class="layui-form-mid layui-word-aux">选择运营中心</div>
  </div>


  <div class="layui-form-item">
    <label class="layui-form-label">销售商用户名</label>
    <div class="layui-input-inline">
      <input type="username" name="username" id="username" lay-verify="title" autocomplete="off"  placeholder="请输入销售商用户名" class="layui-input">
    </div>
        <div class="layui-form-mid layui-word-aux">不得包含中文和特殊字符</div>
  </div>


  <div class="layui-form-item">
    <label class="layui-form-label">密码</label>
    <div class="layui-input-inline">
      <input type="password" name="pwd" id="password" lay-verify="password" autocomplete="off" placeholder="请输入密码" class="layui-input">
    </div>
     <div class="layui-form-mid layui-word-aux">不得包含中文和特殊字符</div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">确认密码</label>
    <div class="layui-input-inline">
      <input type="password" name="notpwd" id="notpassword" lay-verify="notpassword" autocomplete="off"  placeholder="请输入确认密码" class="layui-input">
    </div>
            <div class="layui-form-mid layui-word-aux">不得包含中文和特殊字符</div>
  </div>

    <div class="layui-form-item">
    <label class="layui-form-label">手机号码</label>
    <div class="layui-input-inline">
      <input type="tel" name="tel" lay-verify="tel" id="tel" autocomplete="off" placeholder="请输入手机号码" class="layui-input">
    </div>
  </div>
</form>

  <div class="layui-form-item">
    <button class="layui-btn" lay-submit="" lay-filter="demo2" style="margin-left: 2%;">确认提交</button>
  </div>



<script src="/Public/Admin/js/jquery-latest.js"></script>
<script src="/Public/Admin/js/bootstrap.min.js"></script>
<script src="/Public/Admin/js/bootstrap.datepicker.js"></script>
<script src="/Public/Admin/js/theme.js"></script>

<script type="text/javascript" src="/Public/Admin/css/layerui/layui.js"></script>
<script>
layui.use(['form'], function(){


  
});
</script>


<script>
 $(".layui-btn").click(function(){
            
          var index = layer.load(0, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
          });
          
            $.ajax({
                url: "<?php echo U('add');?>",
                dataType: 'json',
                type: 'post',
                data: $("#submit").serialize(),
                success: function (data) {                       
                  
                  if(data.status === 0){

                      layer.close(index);     
                      layer.msg(data.msg, {icon: 7});
                      return false;
                    }

                  if(data.status === 1){

                      layer.close(index);     
                      layer.msg(data.msg, {icon: 6});
                      window.setTimeout("window.location='<?php echo U('index');?>' ",1000);
                      return false;
                    }
                }
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