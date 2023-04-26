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
	<link rel="stylesheet" href="/Public/Admin/css/compiled/article.css" type="text/css" media="screen"/>
	<link rel="stylesheet" type="text/css" href="/Public/Admin/css/layui/css/layui.css">
	
	
	
	
	<div class="container-fluid">
		<div id="pad-wrapper" class="users-list">
			<div class="row-fluid header">
				<h3>角色列表</h3>
			</div>
			<form id="form1" action="/login/role/get_list" method="get">
			<div class="row-fluid header head2">
				
				<label class="layui-form-label">角色名称：</label>
				<div class="layui-inline">
					<input class="layui-input" name="role_name" id="demoReload" autocomplete="off" value="<?php echo ($sea["role_name"]); ?>">
				</div>
				
				<button style="float: right;" type="button" class="layui-btn add">新增</button>
				<button style="float: right;margin-right: 20px;" type="button" class="layui-btn layui-btn-normal" onclick="submit()">查询
				</button>
			</div>
			</form>
			
			<!-- Users table -->
				<div class="row-fluid table">
					<table class="table table-hover">
						<thead>
						<tr>
							<th class="span2 sortable">
								<span class="line"></span>角色名称
							</th>
							<th class="span2 sortable">
								<span class="line"></span>创建时间
							</th>
							<th class="span2 sortable">
								<span class="line"></span>操作
							</th>
						</tr>
						</thead>
						<tbody id="ajaxback">
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><!-- row -->
							<tr class="first">
								<td>
									<?php echo ($vo["role_name"]); ?>
								</td>
								<td>
									<?php echo ($vo["created_at"]); ?>
								</td>
								<td>
									<ul class="actions">
										<button type="button" class="layui-btn layui-btn-small layui-btn-sm layui-btn-normal role" data-role-id="<?php echo ($vo["id"]); ?>" data-menu-id="<?php echo ($vo["menu_id"]); ?>">
											权限控制
										</button>
										
										<button type="button" class="layui-btn layui-btn-small layui-btn-sm layui-btn-normal" onclick="edit('<?php echo ($vo["id"]); ?>','<?php echo ($vo["role_name"]); ?>')">
											<i class="layui-icon"></i></button>
										
										<button type="button" class="layui-btn layui-btn-danger layui-btn-small" onclick="del_submit('<?php echo ($vo["id"]); ?>')">
											<i class="layui-icon"></i></button>
									</ul>
								</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				
				</div>
			
			<div class="pagination pull-right">
				<ul>
					<?php echo ($page); ?>
				</ul>
			</div>
			<!-- end users table -->
		</div>
	</div>
	
	
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title" id="exampleModalLabel">新增角色</h3>
				</div>
				
				<div class="modal-body">
					
					<div class="layui-form-item">
						<label class="layui-form-label">角色名称:</label>
						<div class="layui-input-inline">
							<input type="text" name="username" lay-verify="required" placeholder="请输入角色名称" autocomplete="off" class="layui-input" id="add_role_name">
						</div>
					</div>
					
					<div class="layui-form-item">
						<div class="layui-input-block">
							<button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1" onclick="add_submit()">
								确定
							</button>
							<button type="reset" class="layui-btn layui-btn-primary" data-dismiss="modal">关闭</button>
						</div>
					</div>
				
				</div>
				
				<div class="modal-footer">
					<!--<p style="color: #606266;">123</p>-->
				</div>
			
			</div>
		</div>
	</div>
	
	
	<div class="modal fade" id="roleEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title" id="roleEditLabel">修改角色</h3>
				</div>
				
				<div class="modal-body">
					
					<div class="layui-form-item">
						<label class="layui-form-label">角色名称:</label>
						<div class="layui-input-inline">
							<input type="text" name="username" lay-verify="required" placeholder="请输入角色名称" autocomplete="off" class="layui-input" id="edit_role_name">
						</div>
					</div>
					
					<div class="layui-form-item">
						<div class="layui-input-block">
							<button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1" onclick="edit_submit(this)" id="edit_role_id" data-role-id>
								确定
							</button>
							<button type="reset" class="layui-btn layui-btn-primary" data-dismiss="modal">关闭</button>
						</div>
					</div>
				
				</div>
				
				<div class="modal-footer">
					<!--<p style="color: #606266;">123</p>-->
				</div>
			
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="role" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title" id="roleLabel">权限控制</h3>
				</div>
				
				<div class="modal-body">
					
					<div id="test12" class="demo-tree-more"></div>
				
				</div>
				
				<div class="layui-form-item">
					<button class="layui-btn" lay-submit="" lay-filter="demo2" style="margin-left: 5%;" lay-demo="getChecked" id="role_submit" data-role-id="">
						保存
					</button>
				</div>
				
				<div class="modal-footer">
				
				</div>
			
			</div>
		</div>
	</div>
	
	
	<!-- scripts -->
	<script src="/Public/Admin/js/jquery-latest.js"></script>
	<script src="/Public/Admin/js/bootstrap.min.js"></script>
	<script src="/Public/Admin/js/theme.js"></script>
	
	
	<script>

        //添加界面
        $('.add').click(function () {

            $('#add_role_name').val('');

            $('#exampleModal').modal({
                show: true,
                backdrop: 'static',
            })
        });

        //权限界面
        $('.role').click(function () {
            $('#role').modal({
                show: true,
                backdrop: 'static',
            })

            var role_id = $(this).attr('data-role-id');
            var menu_id = $(this).attr('data-menu-id');

            $('#role_submit').attr('data-role-id', role_id);

            layui.use('tree', function () {
                var tree = layui.tree;

                tree.reload('demoId1', {
                    //新的参数
                });

                tree.setChecked('demoId1', JSON.parse(menu_id));
            })
        });

        //编辑界面
        function edit(id, name) {

            $('#edit_role_name').val(name);
            $('#edit_role_id').attr('data-role-id', id);

            $('#roleEdit').modal({
                show: true,
                backdrop: 'static',
            });
        }
	
	</script>
	
	<script src="/Public/Admin/css/layui/layui.js" charset="utf-8"></script>
	
	<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
	<script>
        layui.use(['tree', 'util'], function () {

            var menus = <?php echo ($menus_all); ?>;

            var tree = layui.tree
                , layer = layui.layer
                , util = layui.util

                //模拟数据
                , data = menus;


            //基本演示
            tree.render({
                elem: '#test12'
                , data: data
                , showCheckbox: true  //是否显示复选框
                , id: 'demoId1'
                , isJump: false //是否允许点击节点时弹出新窗口跳转
            });

            //按钮事件
            util.event('lay-demo', {
                getChecked: function (othis) {
                    var checkedData = tree.getChecked('demoId1'); //获取选中节点的数据
                    role_submit(checkedData);
                }
            });
        });

        //新增角色提交
        function add_submit() {

            var index = layer.load(0, {
                shade: [0.1, '#fff'] //0.1透明度的白色背景
            });

            var role_name = $('#add_role_name').val();

            $.ajax({
                url: "<?php echo U('add');?>",
                dataType: 'json',
                type: 'post',
                data: {role_name: role_name},
                success: function (data) {

                    if (data.status === 0) {

                        layer.close(index);
                        layer.msg(data.msg, {icon: 7});
                        return false;
                    }

                    if (data.status === 1) {

                        layer.close(index);
                        layer.msg(data.msg, {icon: 6});
                        window.setTimeout("location.reload()", 1000);
                        return false;
                    }
                }
            });
        }

        //修改角色提交
        function edit_submit(obj) {
            var index = layer.load(0, {
                shade: [0.1, '#fff'] //0.1透明度的白色背景
            });

            var role_name = $('#edit_role_name').val();
            var role_id = $(obj).attr('data-role-id');

            $.ajax({
                url: "<?php echo U('update');?>",
                dataType: 'json',
                type: 'post',
                data: {role_name: role_name, role_id: role_id},
                success: function (data) {

                    if (data.status === 0) {

                        layer.close(index);
                        layer.msg(data.msg, {icon: 7});
                        return false;
                    }

                    if (data.status === 1) {

                        layer.close(index);
                        layer.msg(data.msg, {icon: 6});
                        window.setTimeout("location.reload()", 1000);
                        return false;
                    }
                }
            });
        }

        //删除角色提交
        function del_submit(role_id) {
            layer.confirm('确定要删除吗？', {
                btn: ['确定', '关闭'] //按钮
            }, function () {

                var index_load = layer.load(0, {
                    shade: [0.1, '#fff'] //0.1透明度的白色背景
                });

                $.ajax({
                    url: "<?php echo U('delete');?>",
                    dataType: 'json',
                    type: 'post',
                    data: {role_id: role_id},
                    success: function (data) {

                        if (data.status === 0) {

                            layer.close(index_load);
                            layer.msg(data.msg, {icon: 7});
                            return false;
                        }

                        if (data.status === 1) {
                            layer.close(index_load);
                            layer.msg(data.msg, {icon: 6});
                            window.setTimeout("location.reload()", 1000);
                            return false;
                        }
                    }
                });

            }, function (index) {
                layer.close(index);
            });
        }

        //权限控制提交
        function role_submit(data) {
            var index = layer.load(0, {
                shade: [0.1, '#fff'] //0.1透明度的白色背景
            });

            var role_id = $('#role_submit').attr('data-role-id');

            $.ajax({
                url: "<?php echo U('auth_menu');?>",
                dataType: 'json',
                type: 'post',
                data: {menus: JSON.stringify(data), role_id: role_id},
                success: function (data) {

                    if (data.status === 0) {

                        layer.close(index);
                        layer.msg(data.msg, {icon: 7});
                        return false;
                    }

                    if (data.status === 1) {

                        layer.close(index);
                        layer.msg(data.msg, {icon: 6});
                        window.setTimeout("location.reload()", 1000);
                        return false;
                    }
                }
            });
        }

        function submit() {
            $('#form1').submit();
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