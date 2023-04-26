<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html class="login-bg">
<head>
	<title>后台管理系统-登录</title>
 
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


    <!-- background switcher -->
    <div class="bg-switch visible-desktop">
        <div class="bgs">
            <a href="#" data-img="landscape.jpg" class="bg">
                <img src="/Public/Admin/img/bgs/landscape.jpg" />
            </a>
            <a href="#" data-img="blueish.jpg" class="bg">
                <img src="/Public/Admin/img/bgs/blueish.jpg" />
            </a>
            <a href="#" data-img="7.jpg" class="bg">
                <img src="/Public/Admin/img/bgs/7.jpg" />
            </a>
            <a href="#" data-img="8.jpg" class="bg">
                <img src="/Public/Admin/img/bgs/8.jpg" />
            </a>
            <a href="#" data-img="9.jpg" class="bg">
                <img src="/Public/Admin/img/bgs/9.jpg" />
            </a>
            <a href="#" data-img="10.jpg" class="bg active">
                <img src="/Public/Admin/img/bgs/10.jpg" />
            </a>
            <a href="#" data-img="11.jpg" class="bg">
                <img src="/Public/Admin/img/bgs/11.jpg" />
            </a>
        </div>
    </div>


    <div class="row-fluid login-wrapper">
<!--         <a href="#">
            <img class="logo" style="height:150px" src="/Public/Admin/img/logo.png" />
        </a> -->
		
		<form method="post" action="<?php echo U('User/signin');?>" style="width: 400px;margin: 0 auto;">
	        <div class="span4 box">
	            <div class="content-wrap">
	                <h6>管理员登陆</h6>
	                <input class="span12" type="text" placeholder="管理员账号" name="username"/>
	                <input class="span12" type="password" placeholder="管理员密码" name="password"/>
	<!--                 <a href="#" class="forgot">忘记密码？</a> -->
	                <div class="remember">
	                    <input id="remember-me" type="checkbox" />
	                    <label for="remember-me">记住账号</label>
	                </div>
	                <input type="submit" value="登陆" class="btn-glow primary login" style="margin-left: 220px;"/>
	            </div>
	        </div>
		</form>
    </div>

	<!-- scripts -->
    <script src="/Public/Admin/js/jquery-latest.js"></script>
    <script src="/Public/Admin/js/bootstrap.min.js"></script>
    <script src="/Public/Admin/js/theme.js"></script>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?747abb31b53b9eeb7f13685130b9dd16";
  var s = document.getElementsByTagName("script")[0];
  s.parentNode.insertBefore(hm, s);
})();
</script>

    <!-- pre load bg imgs -->
    <script type="text/javascript">
        $(function () {
            // bg switcher
            var $btns = $(".bg-switch .bg");
            $btns.click(function (e) {
                e.preventDefault();
                $btns.removeClass("active");
                $(this).addClass("active");
                var bg = $(this).data("img");

                $("html").css("background-image", "url('/Public/Admin/img/bgs/" + bg + "')");
            });
        });
    </script>

</body>
</html>