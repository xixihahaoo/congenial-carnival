<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html class="login-bg">
<head>
	<title>谷歌验证器</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
	<!-- bootstrap -->
	<link href="/Public/Admin/css/bootstrap/bootstrap.css" rel="stylesheet" />
	<link href="/Public/Admin/css/bootstrap/bootstrap-responsive.css" rel="stylesheet" />
	<link href="/Public/Admin/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />
	
	<!-- global styles -->
	<link rel="stylesheet" type="text/css" href="/Public/Admin/css/layout.css" />
	<link rel="stylesheet" type="text/css" href="/Public/Admin/css/elements.css" />
	<link rel="stylesheet" type="text/css" href="/Public/Admin/css/icons.css" />
	
	<!-- libraries -->
	<link rel="stylesheet" type="text/css" href="/Public/Admin/css/lib/font-awesome.css" />
	
	<!-- this page specific styles -->
	<link rel="stylesheet" href="/Public/Admin/css/compiled/signin.css" type="text/css" media="screen" />
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>


<div class="row-fluid login-wrapper">
	
	<form method="post" action="<?php echo U('User/GoogleAuth');?>" style="width: 400px;margin: 0 auto;">
		<div class="span4 box">
			<div class="content-wrap">
				<h6>谷歌验证器</h6>
				<input class="span12" type="text" placeholder="请输入验证码" name="code"/>
				<input type="submit" value="登陆" class="btn-glow primary login" style="margin-left: 220px;"/>
			</div>
		</div>
	</form>
</div>

<!-- scripts -->
<script src="/Public/Admin/js/jquery-latest.js"></script>
<script src="/Public/Admin/js/bootstrap.min.js"></script>
<script src="/Public/Admin/js/theme.js"></script>

</body>
</html>