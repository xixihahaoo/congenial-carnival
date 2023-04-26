<?php if (!defined('THINK_PATH')) exit();?>	<!DOCTYPE html>
<html data-n-head="" lang="zh-tw">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta data-n-head="true" content="Meta description" name="description" data-hid="description">
    <meta data-n-head="true" content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, user-scalable=no,minimum-scale=1.0, maximum-scale=1.0,viewport-fit=contain" data-n-head="true">
    <!--<meta name="viewport" content="... viewport-fit=cover"/>-->
	<title data-n-head="true"><?php echo (L("setting")); ?></title>
	<link href="/Public/Qts/Home/css/common.css" rel="stylesheet">
	<style data-vue-ssr-id="4cddb420:0 cf79f97a:0">
		.li-main > span[data-v-adff73de] {
			position: relative;
			-webkit-box-flex: 1;
			-ms-flex: 1;
			flex: 1;
			justify-items: center;
			-webkit-box-align: center;
			-ms-flex-align: center;
			align-items: center;
			padding-left: .4rem
		}
		
		.li-main > span[data-v-adff73de]:before {
			position: absolute;
			left: 0;
			width: .32rem;
			height: .38rem;
			margin-top: .08rem;
			content: "";
			background-repeat: no-repeat
		}
		
		.history span[data-v-7ecec926] {
			display: block;
			width: .8rem;
			height: .2rem;
			line-height: .2rem;
			text-align: center;
			font-size: .14rem;
			border-radius: .1rem 0 0 .1rem;
			margin-top: .1rem;
			margin-right: -.01rem
		}
		
		.history span.order[data-v-7ecec926] {
			border: 1px solid #2187f7;
			color: #2187f7
		}
		
		.history span.recharge[data-v-7ecec926] {
			background: #2289f8;
			color: #fff
		}
		
		.titles > div[data-v-7ecec926] {
			width: 25%;
			float: left;
			text-align: center;
			line-height: .36rem
		}
		
		.titles > div.on[data-v-7ecec926] {
			color: #2187f7;
			position: relative
		}
		
		.titles > div[data-v-7ecec926]:last-child {
			-webkit-box-shadow: none;
			box-shadow: none
		}
		
		.titles > div.on span[data-v-7ecec926] {
			display: inline-block;
			width: 30%;
			height: .02rem;
			background: #2187f7;
			position: absolute;
			bottom: 0;
			left: 50%;
			margin-left: -15%;
			border-radius: .2rem
		}
		
		.lists ul[data-v-7ecec926] {
			width: 100%;
			padding: .15rem;
			padding-bottom: .7rem;
			height: 100%;
			overflow-y: scroll
		}
		
		.lists ul li[data-v-7ecec926] {
			width: 100%;
			padding: .1rem .2rem;
			background: #fff;
			display: -webkit-box;
			display: -ms-flexbox;
			display: flex;
			display: -webkit-flex;
			position: relative;
			-webkit-box-shadow: 0 2px 5px #ebeff3;
			box-shadow: 0 2px 5px #ebeff3;
			border-radius: .1rem;
			margin-bottom: .2rem
		}
		
		.lists ul li > div.left[data-v-7ecec926] {
			-webkit-box-flex: 4;
			-ms-flex: 4;
			flex: 4;
			-webkit-flex: 4;
			border-right: .01rem solid #e5e5e5;
			padding-left: .1rem
		}
		
		.lists ul li > div.right[data-v-7ecec926] {
			-webkit-box-flex: 1;
			-ms-flex: 1;
			flex: 1;
			-webkit-flex: 1;
			padding-left: .1rem
		}
		
		.lists ul li p[data-v-7ecec926] {
			line-height: .3rem
		}
		
		.lists ul li span.hands[data-v-7ecec926], .lists ul li span.name[data-v-7ecec926] {
			font-size: .14rem;
			color: #333
		}
		
		.lists ul li span.tag[data-v-7ecec926] {
			display: inline-block;
			vertical-align: middle;
			width: .16rem;
			height: .16rem;
			text-align: center;
			line-height: .16rem;
			color: #fff;
			font-size: .1rem;
			border-radius: .08rem;
			margin: 0 .05rem
		}
		
		.lists ul li span.ask[data-v-7ecec926], .lists ul li span.open[data-v-7ecec926] {
			font-size: 12px;
			color: #999
		}
		
		.lists ul li span.ask[data-v-7ecec926] {
			padding-left: .1rem
		}
		
		.exitOut[data-v-4dec191d] {
			height: .45rem;
			line-height: .45rem;
			background: #fff;
			margin-top: .1rem;
			font-size: 15px;
			color: #ffbf23 !important;
			letter-spacing: 0
		}
		
		.list[data-v-4dec191d] {
			margin-top: 0
		}
		
		.list .all-same2[data-v-4dec191d], .list .all-same[data-v-4dec191d] {
			height: .5rem;
			line-height: .5rem;
			position: relative;
			background: #171520;
			padding: 0 .14rem;
			font-size: 15px;
			color: #b0afa5;
			letter-spacing: -.46px
		}
		
		.list .all-same[data-v-4dec191d]:nth-of-type(3) {
			margin-bottom: .1rem
		}
		
		.list .all-same > p[data-v-4dec191d] {
			color: #999;
			font-size: .14rem;
			position: absolute;
			right: .28rem;
			top: 0
		}
		
		.list > div[data-v-4dec191d]:last-child {
			border-bottom: none
		}
		
		#div1[data-v-4dec191d] {
			width: .54rem;
			height: .3rem;
			border-radius: 50px;
			position: absolute;
			top: .12rem;
			right: .14rem
		}
		
		#div2[data-v-4dec191d] {
			width: .28rem;
			height: .28rem;
			border-radius: 48px;
			position: absolute;
			background: #fff;
			-webkit-box-shadow: 0 2px 4px rgba(0, 0, 0, .4);
			box-shadow: 0 2px 4px rgba(0, 0, 0, .4)
		}
		
		.open1[data-v-4dec191d] {
			background: #ffbf23
		}
		
		.open2[data-v-4dec191d] {
			top: 1px;
			right: 0
		}
		
		.pccode[data-v-4dec191d] {
			position: absolute;
			right: .28rem;
			top: 0;
			color: #999;
			font-size: .14rem
		}
		.close1[data-v-4dec191d] {
			background: hsla(0,0%,100%,.4);
			border: 1px solid rgba(0,0,0,.15);
			border-left: transparent;
		}
		.close2[data-v-4dec191d] {
			left: 0;
			top: 0;
			border: 1px solid rgba(0,0,0,.1);
		}
		body {
			background: #1c1a25
		}</style>
</head>
<body>
<div id="__nuxt">
	<div class="progress" data-v-4a8a9a01=""
	     style="width: 0%; height: 2px; background-color: rgb(1, 40, 97); opacity: 0;"></div>
	<div data-v-4dec191d="" class="content">
		<div data-v-4dec191d="" id="head">
			<div class="head_content"><h3 class="product-name"><span style="color: #ffbf23"><?php echo (L("setting")); ?></span><em></em></h3>
				<div class="left" onclick="window.history.back()"><a class="arrow_left"></a></div>
				<div class="right arrow_right"><b></b></div>
			</div>
		</div>
		<section data-v-4dec191d="" class="page-main" style="padding-bottom: 0.5rem;">
			
			<div data-v-4dec191d="" class="list">
				<a href="<?php echo U('User/userInfo');?>">
					<div data-v-4dec191d="" class="all-same">
						<div data-v-4dec191d=""><?php echo (L("personal_data")); ?></div>
					</div>
				</a>
				
				<!--<a href="<?php echo U('bindPhone');?>">-->
					<!--<div data-v-4dec191d="" class="all-same">-->
						<!--<div data-v-4dec191d=""><?php echo (L("binding_phone")); ?></div>-->
						<!--<p data-v-4dec191d=""><?php echo ($user["utel"]); ?></p>-->
					<!--</div>-->
				<!--</a>-->
				
				<a href="javascript:void(0);">
					<div data-v-4dec191d="" class="all-same">
						<div data-v-4dec191d=""><?php echo (L("bind_mailbox")); ?></div>
						<p data-v-4dec191d=""><?php echo ((isset($user["email"]) && ($user["email"] !== ""))?($user["email"]):'****'); ?></p>
					</div>
				</a>
				
				<a href="<?php echo U('modifyLoginPwd');?>">
					<div data-v-4dec191d="" class="all-same">
						<div data-v-4dec191d=""> <?php echo (L("login_password")); ?></div>
					</div>
				</a>
				
				<a href="<?php echo U('aboutwe');?>">
					<div data-v-4dec191d="" class="all-same">
						<div data-v-4dec191d=""><?php echo (L("about_us")); ?></div>
					</div>
				</a>

					<div data-v-4dec191d="" class="all-same2">
						<div data-v-4dec191d=""><?php echo (L("auto_share_order")); ?></div>
						<?php if(($user['auto_order']) == "1"): ?><div data-v-4dec191d="" id="div1" class="open1">
								<div data-v-4dec191d="" id="div2" class="close2 close1" style="left: 0.26rem"></div>
							</div>
						<?php else: ?>
							<div data-v-4dec191d="" id="div1" class="close1">
								<div data-v-4dec191d="" id="div2" class="close2 close1" style="left: 0"></div>
							</div><?php endif; ?>
					</div>
			</div>

			<?php if(!empty($_SESSION['user_id'])): ?><div data-v-4dec191d="" class="list">
					<div data-v-4dec191d="" class="all-same exitOut">
						<div data-v-4dec191d="" onclick="window.location.href='<?php echo U('Home/Login/logout');?>'"><?php echo (L("logout")); ?></div>
					</div>
				</div><?php endif; ?>

		</section>
	</div>
</div>

<script src="/Public//Qts/Home/js/jquery.js"></script>
<script type="text/javascript" src="/Public//Home/css/layer/layer.js"></script>

<script>
    $('#div2').click(function (e){
        if($(this).hasClass('close2')){
            $(this).removeClass('close2');
            $(this).parent().removeClass('close1').addClass('open1')
        }else{
            $(this).addClass('close2');
            $(this).parent().addClass('close1').removeClass('open1')
        }
        var index   = layer.load(2);

        $.ajax({
            url:"<?php echo U('autoOrder');?>",
            dataType: 'json',
            type: 'post',
            success:function(data){

                if(data.code == 200){

                    layer.close(index);
                    return window.location.reload();

                } else{
                    layer.close(index);
                    return layer.msg(data.msg);
                }
            }
        });
    });


</script>
</body>
</html>