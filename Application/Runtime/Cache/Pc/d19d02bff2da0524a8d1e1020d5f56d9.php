<?php if (!defined('THINK_PATH')) exit();?>    <!DOCTYPE html>
<html data-n-head="" lang="zh-TW">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta data-n-head="true" content="Meta description" name="description" data-hid="description">
    <meta data-n-head="true" content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, user-scalable=no,minimum-scale=1.0, maximum-scale=1.0,viewport-fit=contain" data-n-head="true">
    <title data-n-head="true"><?php echo (L("personal_center")); ?></title>
    <link href="/Public//Qts/Home/css/common.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/Public//Qts/Home/css/style.css">
    <link rel="stylesheet" type="text/css" href="/Public//Qts/Home/css/user.css">
    <link href="/Public//Qts/Home/css/pcPublic.css" rel="stylesheet">
    <style>
      /*.footer {*/
          /*position: relative;*/
          /*top: 0;*/
          /*height: .55rem;*/
          /*line-height: .55rem;*/
      /*}*/
      /*.footer:after {*/
          /*content: '';*/
          /*clear: both;*/
          /*display: block;*/
      /*}*/
      /*.footer > div {*/
          /*float: left;*/
          /*width: 50%;*/
      /*}*/
      /*.footer > ul {*/
          /*float: right;*/
          /*width: 50%;*/
      /*}*/
      /*.footer[data-v-18c6d448] {*/
          /*width: 100%;*/
          /*background-color: #1F222B;*/
      /*}*/
      /*.footer em[data-v-18c6d448] {*/
          /*display: block;*/
          /*margin: auto;*/
          /*color: #666;*/
          /*font-size: .16rem;*/
      /*}*/
      body, html {
        height: 100% !important;
        width: 100% !important;
        background: #262b41 !important;
        /*background: url('/Public//Qts/Home/img/index/bodyBack.jpg') no-repeat center center !important;*/
        /*background-size: 100% 100% !important;*/
      }
      .contentWrap {
        width: 1014px;
        min-height: 720px;
        float: left;
        background: #212139;
        padding: 0 68px;
      }
      .title {
        height: 66px;
        line-height: 66px;
        font-size: 16px;
        font-weight: normal;
        border-bottom: 2px solid #262b41;
        color: #ddd;
      }
      /*个人信息*/
      .contentWrap .userInf {
        height: 120px;
        line-height: 120px;
        border-bottom: 2px solid #262b41;
      }
      .contentWrap .userInf .userHeader {
        float: left;
        position: relative;
        margin-top: 29px;
        width: 64px;
        height: 64px;
      }
      .contentWrap .userInf .userHeader img {
        width: 64px;
        height: 64px;
        border-radius: 50%;
      }
      .contentWrap .userInf .userHeader #upDateImg{
        position: absolute;
        width:100%;
        height: 100%;
        left: 0;
        top:0;
        opacity: 0;
        cursor: pointer;
      }
      .contentWrap .userInf a {
        display: inline-block;
        margin: 0 20px;
        color: #ddd;
      }
      /*安全设置*/
      .contentWrap .security {
        border-bottom: 2px solid #262b41;
      }
      .contentWrap .security ul li {
        height: 44px;
        line-height: 44px;
        padding: 0 66px;
      }
      .contentWrap .security ul li a {
        display: inline-block;
        width: 100%;
        height: 100%;
        color: #ddd;
      }
      .contentWrap .security ul li a p {
        float: left;
      }
      .contentWrap .security ul li a span {
        float: right;
      }
      /*银行卡管理*/
      .contentWrap .backCard .backCon {
        text-align: center;
      }
      .contentWrap .backCard .backCon .backInfo {
        border: 2px solid #262b41;
        height: 96px;
        background: #262b41;
        border-radius: 2px;
        margin: 10px 0;
      }
      .contentWrap .backCard .backCon .backInfo .info {
        float: left;
        margin: 13px 0 13px 60px;
      }
      .contentWrap .backCard .backCon .backInfo .info p,
      .contentWrap .backCard .backCon .backInfo .info span {
        display: block;
        line-height: 35px;
        color: #ddd;
      }
      .contentWrap .backCard .backCon .backInfo .unbundle {
        float: right;
        margin: 13px 60px 13px 0;
      }
      .contentWrap .backCard .backCon .backInfo .unbundle p,
      .contentWrap .backCard .backCon .backInfo .unbundle span {
        display: block;
        line-height: 35px;
        color: #ddd;
      }
      .contentWrap .backCard .backCon .backInfo .unbundle p {
        color: #7aaeed;
        cursor: pointer;
      }
      .contentWrap .backCard .backCon .addBack {
        width: 120px;
        height: 40px;
        line-height: 40px;
        text-align: center;
        background: #7aaeed;
        border-radius: 4px;
        color: #fff;
        margin: 20px 0;
      }
    </style>
</head>
<body>
<div id="__nuxt">
    <div class="progress" data-v-4a8a9a01=""
         style="width: 0%; height: 2px; background: rgba(1, 40, 97,.5); opacity: 1;"></div>
    <!--引入导航条-->
    <!-- <div data-v-18c6d448="" data-v-63966bdb="" class="footer">
        <ul data-v-18c6d448="">

            <li data-v-18c6d448="" onclick="jumpUrl('/')">
                <a data-v-18c6d448="" class="footer_common1"></a>
                <em data-v-18c6d448="" class=""><?php echo (L("common_home")); ?></em>
            </li>

            <li data-v-18c6d448="" onclick="jumpUrl('<?php echo U('Product/lists');?>')">
                <a data-v-18c6d448="" class="footer_common2"></a>
                <em data-v-18c6d448="" class=""><?php echo (L("common_market")); ?></em>
            </li>

            <li data-v-18c6d448="" onclick="jumpUrl('<?php echo U('Position/trade');?>')">
                <a data-v-18c6d448="" class="footer_common4"></a>
                <em data-v-18c6d448="" class=""><?php echo (L("common_position")); ?></em>
            </li>

            <li data-v-18c6d448="" onclick="jumpUrl('<?php echo U('Lang/index');?>')">

                <em data-v-18c6d448="" class=""><?php echo (L("common_language")); ?></em>
            </li>

            <li data-v-18c6d448="" onclick="jumpUrl('<?php echo U('Broadcast/index');?>')">
                &lt;!&ndash;<a data-v-18c6d448="" class="footer_common5"></a>&ndash;&gt;
                <em data-v-18c6d448="" class=""><?php echo (L("common_live")); ?></em>
            </li>


            <li data-v-18c6d448="" onclick="jumpUrl('<?php echo U('User/index');?>')">
                <a data-v-18c6d448="" class="footer_common3">
                    <?php if($NoreadCount >= '1'): ?><span data-v-18c6d448=""></span><?php endif; ?>
                </a>
                <em data-v-18c6d448="" class=""><?php echo (L("common_my")); ?></em>
            </li>
        </ul>
    </div> -->

<div class="headTop">
    <div class="headertop">
        <div class="wapper clearfix">
            <h1 class="left" style="width: 140px;">
                <a href="/" style="margin-top: 7px;">
                    <img src="/Public/Qts/Home/img/index/logo.png" alt="JinglanEX">
                </a>
            </h1>

            <ul class="nav" style="z-index:9995;width: 510px;">
                <li onclick="jumpUrl('/')">
                    <a href="/"><?php echo (L("common_home")); ?></a>
                </li>
                <li onclick="jumpUrl('<?php echo U('Product/lists');?>')">
                    <a href="javascript:;"><?php echo (L("common_market")); ?></a>
                </li>
                <li onclick="jumpUrl('<?php echo U('Position/trade');?>')">
                    <a href="javascript:;"><?php echo (L("common_position")); ?></a>
                </li>
                <!--<li onclick="jumpUrl('<?php echo U('Lang/index');?>')">-->
                    <!--<a href="javascript:;"><?php echo (L("common_language")); ?></a>-->
                <!--</li>-->
                <li onclick="jumpUrl('<?php echo U('User/index');?>')">
                    <a href="javascript:;"><?php echo (L("common_my")); ?></a>
                </li>
                <!--<li onclick="jumpUrl('https://www.pgyer.com/TFTrade')">-->
                    <!--<a href="javascript:;"><?php echo (L("common_xiazai")); ?></a>-->
                <!--</li>-->
            </ul>
            <div class="logout">
                <?php if(!empty($_SESSION['user_id'])): ?><div data-v-4dec191d="" class="all-same exitOut">
                        <div data-v-4dec191d="" onclick="window.location.href='<?php echo U('Home/Login/logout');?>'"><?php echo (L("logout")); ?></div>
                    </div><?php endif; ?>
            </div>

            <div class="switchLang"  onclick="jumpUrl('<?php echo U('Lang/index');?>')">
                <?php if($lang == 'zh-cn'): ?><div class="swicthLanguage" style="background: url('/Public/Qts/Home/img/index/Chinese.jpg') no-repeat;background-size: 100% 100%"></div>
                    <!--<img src="/Public/Qts/Home/img/index/Chinese.jpg" alt="">-->
                    <?php elseif($lang == 'en-us'): ?>
                    <div class="swicthLanguage" style="background: url('/Public/Qts/Home/img/index/English.jpg') no-repeat;background-size: 100% 100%"></div>
                    <!--<img src="/Public/Qts/Home/img/index/English.jpg" alt="">-->
                    <?php else: ?>
                    <div class="swicthLanguage" style="background: url('/Public/Qts/Home/img/index/hk.jpg') no-repeat;background-size: 100% 100%"></div>
                    <!--<img src="/Public/Qts/Home/img/index/hk.jpg" alt="">--><?php endif; ?>
            </div>

        </div>
    </div>
    <div class="heads"></div>
</div>

<style>
.headertop {
height: 60px;
z-index: 999;
position: fixed;
top: 0;
margin-bottom: 5px;
width: 100%;

/*background: #fff;*/
/*box-shadow: 0 3px 6px 0 rgba(192,222,255,.5);*/

background: #262b41 !important;
box-shadow: 0 3px 6px 0 #212139 !important;
}
.nav li a {
    color: #fff !important;
}
.heads {
    height: 60px;
}
.wapper {
width: 1140px;
height: 100%;
margin: 0 auto;
    position: relative;
}

/*切换语言*/
.switchLang {
    position: absolute;
    top: 17px;
    right: -6%;
    cursor: pointer;
}
.switchLang .swicthLanguage {
    width: 40px;
    height: 26px;
    cursor: pointer;
}
/*.switchLang img {*/
    /*width: 40px;*/
    /*height: 26px;*/
/*}*/


.clearfix:after, .clearfix:before {
content: '.';
display: block;
font-size: 0;
height: 0;
line-height: 0;
overflow: hidden;
visibility: hidden;
width: 0;
}
.headertop .left {
width: 140px;
height: 60px;
position: relative;
z-index: 10;
}
.left {
float: left;
}
.headertop .left a {
display: inline-block;
margin-top: 12px;
}
.headertop .left img {
max-width: 100%;
}
.nav {
position: relative;
margin-top: 9px;
width: 510px;
float: left;
display: flex;
justify-content: space-around;
}
.nav li a {
height: 40px;
line-height: 40px;
/*color: #665f5c;*/
font-size: 14px;
text-decoration: none;
}
.nav li a:hover, .nav li a.active {
border-bottom: 1px solid #ddd;
}
    .logout {
        float: right;
        margin-top: 9px;
        cursor: pointer;
    }
    .logout .all-same {
      height: 40px !important;
      line-height: 40px !important;
      margin: 0 !important;
      padding: 0 !important;
      color: #7aaeed !important;
      font-size: 14px !important;
    }
</style>
    <script type="text/javascript">
        function jumpUrl(url) {
            window.location.href = url;
        }
    </script>
    <div data-v-adff73de="" class="page-main generalBG" style="padding: 0 !important; background: #262b41 !important;">
      <div data-v-adff73de="" class="page-shadowC clearfix">
          <!--引入个人中心公共组件-->
          <!--<script src="../../../../Public/Qts/Home/js/layerui/layui.js"></script>-->
<link rel="stylesheet" type="text/css" href="/Public//Qts/Home/css/user.css">
<?php if(empty($_SESSION['user_id'])): ?><!--未登录样式-->
  <section class="userPublic">
    <div class="userInfo">
      <div class="headPortrait" style="background: url('/Public/Qts/Home/img/me/1499222434250.png'); background-size: 100% 100%">
        <!--<img src="/Public/Qts/Home/img/me/1499222434250.png" alt="">-->
      </div>
      <div class="info">
        <p><?php echo (L("not_logged")); ?></p>
        <span style="cursor: pointer" onclick="window.location.href='<?php echo U('Login/login');?>'"><?php echo (L("login")); ?></span>
      </div>
      <!--充值体现按钮-->
      <div class="TW">
        <a href="<?php echo U('Login/login');?>"><?php echo (L("recharge")); ?></a>
        <a href="<?php echo U('Login/login');?>"><?php echo (L("withdrawal")); ?></a>
      </div>
    </div>
    <!--导航条-->
    <aside class="userMenu">
      <ul>
        <li>
          <a href="<?php echo U('Login/login');?>"><?php echo (L("personal_center")); ?></a>
        </li>
        <li>
          <a href="<?php echo U('Login/login');?>"><?php echo (L("statistics")); ?></a>
        </li>
        <li>
          <a href="<?php echo U('Login/login');?>"><?php echo (L("following")); ?></a>
        </li>
        <li>
          <a href="<?php echo U('Login/login');?>"><?php echo (L("meessage")); ?></a>
        </li>
        <li>
          <a href="<?php echo U('Login/login');?>"><?php echo (L("about_us")); ?></a>
        </li>
        <li>
          <a href="<?php echo U('Login/login');?>"><?php echo (L("help_center")); ?></a>
        </li>
        <li>
          <a href="<?php echo U('Login/login');?>"><?php echo (L("risk_warning")); ?></a>
        </li>
        <li>
          <a href="<?php echo U('Login/login');?>"><?php echo (L("promotion")); ?></a>
        </li>
      </ul>
    </aside>
  </section>
<?php else: ?>
  <!--登录后样式-->
  <section class="userPublic">
    <div class="userInfo">
      <!--头像-->
      <div class="headPortrait" style="background: url('<?php echo ($user["face"]); ?>'); background-size: 100% 100%">
        <!--<img src="<?php echo ($user["face"]); ?>" alt="">-->
      </div>
      <!--昵称 金额-->
      <div class="info">
        <p><?php echo ($user["nickname"]); ?></p>
        <?php if(($user['now_trade_status']) == "1"): ?><span><?php echo (L("account_balance")); ?>: $<?php echo ($account["balance"]); ?></span>
        <?php else: ?>
          <span><?php echo (L("simulated_balance")); ?>: $<?php echo ($account["gold"]); ?></span><?php endif; ?>
      </div>
      <!--账户类型-->
      <?php if(($user['now_trade_status']) == "1"): ?><div class="info">
          <p><?php echo (L("firm_account")); ?>  <a class="switch" href="<?php echo U('User/BrokersSwitch');?>"><?php echo (L("switch")); ?></a></p>
        </div>
      <?php else: ?>
        <div class="info">
          <p><?php echo (L("simulated_accounts")); ?>  <a class="switch" href="<?php echo U('User/BrokersSwitch');?>"><?php echo (L("switch")); ?></a></p>
        </div><?php endif; ?>

      <!--充值体现按钮-->
      <?php if(($user['now_trade_status']) == "1"): ?><div class="TW">
          <a href="<?php echo U('Recharge/index');?>" target="_self"><?php echo (L("recharge")); ?></a>
          <a href="<?php echo U('Withdrawals/index');?>"><?php echo (L("withdrawal")); ?></a>
        </div>
      <?php else: ?>
        <div class="TW">
          <a href="javascript:void (0);" onclick="MsgPrompt('<?php echo (L("please_switch")); ?>')"><?php echo (L("recharge")); ?></a>
          <a href="javascript:void (0);" onclick="MsgPrompt('<?php echo (L("please_switch")); ?>')"><?php echo (L("withdrawal")); ?></a>
        </div><?php endif; ?>
    </div>
    <!--导航条-->
    <aside class="userMenu">
      <ul>
        <li>
          <a href="<?php echo U('User/index');?>"><?php echo (L("personal_center")); ?></a>
        </li>
        <li>
          <a href="<?php echo U('Investment/index');?>"><?php echo (L("statistics")); ?></a>
        </li>
        <li>
          <a href="<?php echo U('Follow/index');?>"><?php echo (L("following")); ?></a>
        </li>
        <li>
          <a href="<?php echo U('Message/index');?>">
            <?php echo (L("meessage")); ?>
            <!--<?php if($NoreadCount >= '1'): ?>-->
              <!--<strong></strong>-->
            <!--<?php endif; ?>-->
          </a>
        </li>
        <li>
          <a href="<?php echo U('Setting/aboutwe');?>"><?php echo (L("about_us")); ?></a>
        </li>
        <li>
          <a href="<?php echo U('Help/help');?>"><?php echo (L("help_center")); ?></a>
        </li>
        <li>
          <a href="<?php echo U('Help/Risk');?>"><?php echo (L("risk_warning")); ?></a>
        </li>
  
          <?php if(!empty($user['code'])): ?><li>
              <a href="<?php echo U('Extension/index');?>"><?php echo (L("promotion")); ?></a>
            </li>
        <?php else: ?>
                <li data-v-adff73de="" onclick="applyAgent();">
                  <a href="#"><?php echo (L("promotion")); ?></a>
                </li><?php endif; ?>
        
      </ul>
    </aside>
  </section><?php endif; ?>


<script src="/Public/Qts/Home/js/jquery.js"></script>
<script type="text/javascript" src="/Public//Home/css/layer/layer.js"></script>
<script type="text/javascript">

    //申请成为代理商
    function applyAgent()
    {
        layer.open({
            content: "<?php echo (L("confim_msg")); ?>"
            ,btn: ["<?php echo (L("determine")); ?>", "<?php echo (L("do_not")); ?>"]
            ,shadeClose:false
            ,yes: function(index){

                var please_wait = "<?php echo (L("please_wait")); ?>";
                var load   = layer.open({type: 2,shadeClose:false,content:please_wait});
                $.ajax({
                    url: "<?php echo U('Extension/applyAgent');?>",
                    dataType: 'json',
                    type: 'post',
                    success: function (data) {
                        layer.open({
                            content: data.msg
                            ,skin: 'msg'
                            ,time: 2 //2秒后自动关闭
                        });
                        layer.close(load);
                        if(data.code == 200) return setTimeout(" window.location.href='<?php echo U('Extension/index');?>'",500);
                    },
                    error: function (response) {
                        console.log(response);
                    }
                });
            }
        });
    }
    
  //信息提示
  function MsgPrompt(msg)
  {
    layer.open({
      content: msg
      ,skin: 'msg'
      ,time: 2000 //2秒后自动关闭
    });
  }
</script>

<style>
  .userPublic {
    width: 1200px;
    margin: 0 auto;
  }
  /*个人信息*/
  .userPublic .userInfo {
    width: 100%;
    height: 117px;
    background: #212139;
    padding: 0 20px;
    margin: 20px 0 6px;
  }
  .userPublic .userInfo .headPortrait{
    float: left;
    margin-top: 24px;
    width: 64px;
    height: 64px;
    border-radius: 50%;
  }
  /*.userPublic .userInfo .headPortrait img {*/
    /*width: 64px;*/
    /*border-radius: 50%;*/
  /*}*/
  .userPublic .userInfo .info {
    float: left;
    margin: 30px 30px 0;
  }
  .userPublic .userInfo .info span {
    line-height: 50px;
    color: #ddd;
  }
  .userPublic .userInfo .info p {
    color: #fff;
  }
  .userPublic .userInfo .info p .switch {
    color: #519ae9;
  }
  .userPublic .userInfo .TW {
    float: right;
    margin: 42px 10px 0 0;
  }
  .userPublic .userInfo .TW a {
    display: inline-block;
    width: 90px;
    height: 33px;
    background: #7aaeed;
    border-radius: 4px;
    text-align: center;
    line-height: 33px;
    margin: 0 15px;
    color: #fff;
  }
  /*菜单*/
  .userPublic .userMenu {
    width: 180px;
    min-height: 720px;
    background: #212139;
    margin-right: 6px;
    float: left;
  }
  .userPublic .userMenu ul {
    padding-top: 50px;
  }
  .userPublic .userMenu ul li {
    height: 40px;
    line-height: 40px;
    text-align: center;
  }
  .userPublic .userMenu ul li a {
    display: inline-block;
    width: 100%;
    height: 100%;
    color: #ddd;
  }
  .userPublic .userMenu ul li a.active,
  .userPublic .userMenu ul li a:hover {
    color: #7aaeed;
  }
</style>
          <!--内容区-->
          <div class="contentWrap">
            <?php if(empty($_SESSION['user_id'])): ?><!--登录前-->
              <!--头像昵称修改-->
              <div class="userInf">
                <div class="userHeader">
                  <img src="/Public/Qts/Home/img/me/1499222434250.png" alt="">
                </div>
                <a href="<?php echo U('Login/login');?>" class="nickName"><?php echo (L("not_logged")); ?> <?php echo (L("login")); ?></a>
              </div>
              <!--安全设置-->
              <div class="security">
                <h5 class="title"></h5>
                <ul>
                  <li>
                    <a href="<?php echo U('Login/login');?>">
                      <p class="fl"><?php echo (L("email_binding")); ?></p>
                      <span class="fr" style="color: #7aaeed"><?php echo (L("setting")); ?></span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo U('Login/login');?>">
                      <p><?php echo (L("login_password")); ?></p>
                      <span class="fr" style="color: #7aaeed"><?php echo (L("setting")); ?></span>
                    </a>
                  </li>
                </ul>
              </div>
              <!--银行卡管理-->
              <div class="backCard">
                <h5 class="title"><?php echo (L("bank_management")); ?></h5>
                <div class="backCon">
                  <button class="addBack" onclick="window.location.href = '<?php echo U('Login/login');?>'"><?php echo (L("add_back")); ?></button>
                </div>
              </div>
            <?php else: ?>
              <!--登录后-->
              <!--头像昵称修改-->
              <div class="userInf">
                <div class="userHeader">
                  <img src="<?php echo ($user["face"]); ?>" alt="">
                  <input type="file" id="upDateImg">
                </div>
                <a href="<?php echo U('nicknameSave');?>" class="nickName"><?php echo ($user["nickname"]); ?></a>
              </div>
              <!--安全设置-->
              <div class="security">
                <h5 class="title"><?php echo (L("security_settings")); ?></h5>
                <ul>
                  <li>
                    <a href="javascript:void(0);">
                      <p><?php echo (L("email_binding")); ?></p>
                      <span><?php echo ((isset($user["email"]) && ($user["email"] !== ""))?($user["email"]):'****'); ?></span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo U('Setting/modifyLoginPwd');?>">
                      <p><?php echo (L("login_password")); ?></p>
                      <span class="fr" style="color: #7aaeed"><?php echo (L("setting")); ?></span>
                    </a>
                  </li>
                </ul>
              </div>
              <!--银行卡管理-->
              <div class="backCard">
                <h5 class="title"><?php echo (L("bank_management")); ?></h5>
                <div class="backCon">
                  <?php if(is_array($bank)): $i = 0; $__LIST__ = $bank;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="backInfo">
                      <div class="info">
                        <p><?php echo ($vo["bankname"]); ?></p>
                        <span><?php echo ($vo["banknumber"]); ?></span>
                      </div>
                      <div class="unbundle">
                        <p onclick="Unbundling('<?php echo ($vo["bid"]); ?>')"><?php echo (L("untying")); ?></p>
                        <?php if($vo['status'] == '0'): ?><span><?php echo (L("in_audit")); ?></span>
                          <?php else: ?>
                          <span><?php echo (L("audited")); ?></span><?php endif; ?>
                      </div>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                  <button class="addBack" onclick="window.location.href = '<?php echo U('User/BrokersOpen');?>'"><?php echo (L("add_back")); ?></button>
                </div>
              </div><?php endif; ?>
  <!-- -----------------------------------------------------旧样式 ---------------------------------------------- -->
            <!--&lt;!&ndash;个人信息/余额&ndash;&gt;-->
            <!--<?php if(empty($_SESSION['user_id'])): ?>-->

                <!--<div class="h-h" data-v-adff73de="">-->
                    <!--<div class="p-img fr" data-v-adff73de="">-->
                        <!--<img src="/Public/Qts/Home/img/me/1499222434250.png" class="fr" data-v-adff73de="">-->
                    <!--</div>-->
                    <!--<div class="p-info fl" data-v-adff73de="">-->
                        <!--<div class="p-login" data-v-adff73de="">-->
                            <!--<span data-v-adff73de=""><?php echo (L("hello")); ?>,</span>-->
                        <!--</div>-->

                        <!--<div style="display:flex" data-v-adff73de="">-->
                            <!--<p class="accountchange" data-v-adff73de=""><?php echo (L("not_logged")); ?>。</p>-->
                            <!--<div class="p-plates" data-v-adff73de="">-->
                                <!--<strong class="plate-selected" data-v-adff73de="" onclick="window.location.href='<?php echo U('Login/login');?>'"><?php echo (L("login")); ?></strong>-->
                            <!--</div>-->
                        <!--</div>-->

                    <!--</div>-->
                <!--</div>-->

                <!--<div data-v-adff73de="" class="h-con1">-->
                    <!--<img data-v-adff73de="" src="/Public/Qts/Home/img/me/img1.png">-->
                    <!--<div data-v-adff73de="" class="h-con1lf">-->
                        <!--<?php echo (L("account_balance")); ?>：$0.00-->
                    <!--</div>-->
                        <!--<div data-v-adff73de="" class="h-con1rf" onclick="window.location.href='<?php echo U('Login/login');?>'">-->
                            <!--<span data-v-adff73de="" class="h-t1" style="float: left;"><?php echo (L("recharge")); ?></span>-->
                            <!--<span data-v-adff73de="" class="h-t1"><?php echo (L("withdrawal")); ?></span>-->
                        <!--</div>-->
                <!--</div>-->

            <!--<?php else: ?>-->

                <!--<div data-v-adff73de="" class="h-h">-->
                    <!--<div data-v-adff73de="" class="p-img fr">-->
                        <!--<a href="<?php echo U('userInfo');?>">-->
                            <!--<img data-v-adff73de="" src="<?php echo ($user["face"]); ?>" class="fr">-->
                        <!--</a>-->
                    <!--</div>-->
                    <!--<div data-v-adff73de="" class="p-info fl">-->
                        <!--<div data-v-adff73de="" class="p-login1" style="color: #ffbf23"><?php echo ($user["nickname"]); ?></div>-->
                        <!--<div data-v-adff73de="" style="display: flex;">-->

                            <!--<?php if(($user['now_trade_status']) == "1"): ?>-->
                                <!--<p data-v-adff73de="" class="accountchange"><?php echo (L("firm_account")); ?></p>-->
                            <!--<?php else: ?>-->
                                <!--<p data-v-adff73de="" class="accountchange"><?php echo (L("simulated_accounts")); ?></p>-->
                            <!--<?php endif; ?>-->

                            <!--<div data-v-adff73de="" class="p-plate">-->
                                <!--<a href="<?php echo U('BrokersSwitch');?>">-->
                                    <!--<strong data-v-adff73de="" class="plate-selected"><?php echo (L("switching_accounts")); ?></strong>-->
                                <!--</a>-->
                            <!--</div>-->
                        <!--</div>-->
                        <!--<img data-v-adff73de="" src="/Public/Qts/Home/img/public/LV<?php echo ($user["level"]); ?>@2x.png" class="gradeimg">-->

                        <!--&lt;!&ndash;<?php if($personal['status'] == '1'): ?>&ndash;&gt;-->
                        <!--&lt;!&ndash;<?php elseif($personal['status'] == '0'): ?>&ndash;&gt;-->
                            <!--&lt;!&ndash;<p style="color: #E3950D; font-weight: bold; position: absolute; right: .16rem;font-size: 14px;"><?php echo (L("in_audit")); ?></p>&ndash;&gt;-->
                        <!--&lt;!&ndash;<?php else: ?>&ndash;&gt;-->
                            <!--&lt;!&ndash;<p style="color: #E3950D; font-weight: bold; position: absolute; right: .16rem;font-size: 14px;"><?php echo (L("uncertified")); ?></p>&ndash;&gt;-->
                        <!--&lt;!&ndash;<?php endif; ?>&ndash;&gt;-->
                    <!--</div>-->
                <!--</div>-->

                <!--<?php if(($user['now_trade_status']) == "1"): ?>-->
                    <!--<div class="h-con1" data-v-adff73de="">-->
                        <!--<img src="/Public/Qts/Home/img/me/img1.png" style="display:none;" data-v-adff73de="">-->
                        <!--<div class="h-con1lf" data-v-adff73de="">-->
                            <!--<?php echo (L("account_balance")); ?>：<span style="color: #ffca34">$<?php echo ($account["balance"]); ?></span>-->
                        <!--</div>-->
                        <!--<div class="h-con1rf" data-v-adff73de="">-->
                            <!--<a href="<?php echo U('Recharge/index');?>">-->
                                <!--<span class="h-t" style="border:1px solid #ffca34;float: left;border-radius: .05rem" data-v-adff73de=""><?php echo (L("recharge")); ?></span>-->
                            <!--</a>-->
                            <!--<a href="<?php echo U('Withdrawals/index');?>">-->
                                <!--<span class="h-t" style="border:1px solid #ffca34;border-radius: .05rem" data-v-adff73de=""><?php echo (L("withdrawal")); ?></span>-->
                            <!--</a>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--<?php else: ?>-->
                    <!--<div class="h-con1" data-v-adff73de="">-->
                        <!--<img src="/Public/Qts/Home/img/me/img1.png" style="display:block" data-v-adff73de="">-->
                        <!--<div class="h-con1lf" data-v-adff73de="">-->
                            <!--<?php echo (L("simulated_balance")); ?>：$<?php echo ($account["gold"]); ?>-->
                        <!--</div>-->
                        <!--<div class="h-con1rf" data-v-adff73de="">-->
                            <!--<span class="h-t1" style="float: left;" data-v-adff73de="" onclick="MsgPrompt('<?php echo (L("please_switch")); ?>')"><?php echo (L("recharge")); ?></span>-->
                            <!--<span class="h-t1" data-v-adff73de="" onclick="MsgPrompt('<?php echo (L("please_switch")); ?>')"><?php echo (L("withdrawal")); ?></span>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--<?php endif; ?>-->

            <!--<?php endif; ?>-->
            <!--&lt;!&ndash;菜单&ndash;&gt;-->
            <!--<div data-v-adff73de="" class="managerlist">-->
                <!--<ul data-v-adff73de="" class="man-f">-->

                <!--<a href="<?php echo U('Follow/index');?>">-->
                    <!--<li data-v-adff73de="">-->
                        <!--<img data-v-adff73de="" src="/Public//Qts/Home/img/me/img2.png">-->
                        <!--<p data-v-adff73de=""><?php echo (L("following")); ?></p>-->
                    <!--</li>-->
                <!--</a>-->

                <!--<a href="<?php echo U('Investment/index');?>">-->
                    <!--<li data-v-adff73de="">-->
                        <!--<img data-v-adff73de="" src="/Public//Qts/Home/img/me/img3.png">-->
                        <!--<p data-v-adff73de=""><?php echo (L("statistics")); ?></p>-->
                    <!--</li>-->
                <!--</a>-->

                <!--<a href="<?php echo U('Withdrawals/bankinfo');?>">-->
                    <!--<li data-v-adff73de="">-->
                        <!--<img data-v-adff73de="" src="/Public//Qts/Home/img/me/img4.png">-->
                        <!--<p data-v-adff73de=""><?php echo (L("banks")); ?></p>-->
                    <!--</li>-->
                <!--</a>-->


                <!--<?php if(!empty($user['code'])): ?>-->
                    <!--<a href="<?php echo U('Extension/index');?>">-->
                        <!--<li data-v-adff73de="">-->
                            <!--<img data-v-adff73de="" src="/Public//Qts/Home/img/me/img6.png">-->
                            <!--<p data-v-adff73de=""><?php echo (L("promotion")); ?></p>-->
                        <!--</li>-->
                    <!--</a>-->
                <!--<?php else: ?>-->
                        <!--<li data-v-adff73de="" onclick="applyAgent();">-->
                            <!--<img data-v-adff73de="" src="/Public//Qts/Home/img/me/img6.png">-->
                            <!--<p data-v-adff73de=""><?php echo (L("promotion")); ?></p>-->
                        <!--</li>-->
                <!--<?php endif; ?>-->

                <!--<a href="<?php echo U('Message/index');?>">-->
                    <!--<li data-v-adff73de="" class="linksystem">-->
                        <!--<img data-v-adff73de="" src="/Public//Qts/Home/img/me/img7.png">-->
                        <!--<p data-v-adff73de=""><?php echo (L("meessage")); ?></p>-->
                        <!--<?php if($NoreadCount >= '1'): ?>-->
                        <!--<strong data-v-adff73de=""></strong>-->
                        <!--<?php endif; ?>-->
                    <!--</li>-->
                <!--</a>-->
                <!--</ul>-->
                    <!--&lt;!&ndash;<img onclick="window.location.href='<?php echo U('Index/advanced');?>'" data-v-adff73de="" src="/Public//Qts/Home/img/me/pic_enter_class@2x.png" class="waihuiweek">&ndash;&gt;-->
            <!--</div>-->
            <!--&lt;!&ndash;菜单列表&ndash;&gt;-->
            <!--<div data-v-adff73de="" class="m-m">-->
                      <!--<ul data-v-adff73de="" class="h-f">-->
                          <!--&lt;!&ndash;<li data-v-adff73de="" class="linkus" onclick="window.location.href='http://tb.53kf.com/code/client/10173921/1'">&ndash;&gt;-->
                              <!--&lt;!&ndash;<?php echo (L("service")); ?>&ndash;&gt;-->
                              <!--&lt;!&ndash;<img data-v-adff73de="" src="/Public//Qts/Home/img/me/img8.png">&ndash;&gt;-->
                          <!--&lt;!&ndash;</li>&ndash;&gt;-->

                          <!--<li data-v-adff73de="" class="warning linkus" onclick="window.location.href='<?php echo U('Help/Risk');?>'">-->
                              <!--<?php echo (L("risk_warning")); ?>-->
                              <!--<img data-v-adff73de="" src="/Public//Qts/Home/img/me/img8.png">-->
                          <!--</li>-->

                          <!--<li data-v-adff73de="" class="helps" onclick="window.location.href='<?php echo U('Help/help');?>'"><?php echo (L("help_center")); ?></li>-->

                          <!--<li data-v-adff73de="" class="set" onclick="window.location.href='<?php echo U('Lang/index');?>'"><?php echo (L("lang_choice")); ?></li>-->

                          <!--<li data-v-adff73de="" class="set" onclick="window.location.href='<?php echo U('Setting/index');?>'"><?php echo (L("account_settings")); ?></li>-->

                      <!--</ul>-->
                  <!--</div>-->

    <!-- -----------------------------------------------------旧样式 ---------------------------------------------- -->

          </div>
      </div>

    </div>
    <div class="trueFoot">
  <div class="download">
    <!--<img src="/Public/Qts/Home/img/index/NcX7.png" alt="">-->
    <!--<p>https://www.pgyer.com/TFTrade</p>-->
  </div>
  <div class="honor_foot"></div>
  <ul class="contact">
    <li>
      
      <span style="font-size:16px;">  E-mail:support@kmforex.com  </span>
    </li>
  </ul>
  <div class="copyWrap">
    <div class="copyright">
      <p>
        COPYRIGHT © 2015-2019 Kmforex.com  FIRST COMMERCIAL LIMITED Registration No. 24840 IBC 2017 

        <!--span>
            <a href="javascript: void (0);">免责声明</a>
            <em>|</em>
            <a href="javascript: void (0);">私隐条款</a>
            <em>|</em>
            <a href="javascript: void (0);">客户协议</a>
        </span-->
      </p>
      <!--p style="margin-top: 5px;">HXPM Limited.Registered address: 8/F,29Austin Road ,Tsim Sha Tsui,Kowloon,HongKong</p-->
      <p id="fxtip">
        <!--<br>-->
     Financial operations offered by this website may have an increased level of risk. By purchasing financial services and tools from this website, you can suffer significant financial losses or completely lose the funds from your guaranteed trading account. Please evaluate all financial risks and consult with an independent financial adviser before trading.
        <br>
        <span>投资有风险，入市需谨慎</span>
        <br>
      </p>
    </div>
  </div>
</div>
<style>
  .trueFoot {
    margin-top: 20px;
    background: #21213a !important;
    color: #999;
    width: 100%;
    padding: 10px 0;
    min-width: 1080px;
    position: relative;
  }
  .download {
    position: absolute;
    top: 0;
    right: 20%;
    text-align: center;
  }
  .download img {
    width: 90px;
    margin: 15px 0;
    transition: all .5s;
    cursor: pointer;
  }
  .download img:hover {
    transform: scale(1.3);
  }
  .download p {
    font-size: 14px;
    color: #d3b782;
  }
  .honor_foot{
    height: 160px;
    margin-bottom: 10px;
    /*padding-bottom: 10px;*/
    background: url('/Public/Qts/Home/img/index/honor.png') 40% top no-repeat;
    background-size: 50%;
    border-bottom: 1px solid #484848;
  }
  .contact li {
    width: 250px;
    text-align: left;
    line-height: 24px;
    margin: auto;
  }
  .contact li i {
    display: inline-block;
    vertical-align: middle;
    width: 24px;
    height: 24px;
    margin-right: 8px;
    background: url('/Public/Qts/Home/img/index/icon_index.png') -307px -36px no-repeat;
  }
  .contact li span {
    display: inline-block;
    vertical-align: middle;
  }
  .copyWrap .copyright {
    width: 1080px;
    margin: 0 auto;
    padding: 15px 0;
    font-size: 12px;
    text-align: center;
  }
  .certificate {
    text-align: center;
  }
  .certificate a {
    display: inline-block;
  }
</style>
</div>

</body>
</html>

<script src="/Public/Qts/Home/js/jquery.js"></script>
<script type="text/javascript" src="/Public//Home/css/layer/layer.js"></script>
<script type="text/javascript" src="/Public//Home/css/layer_mobile/layer.js"></script>

<script type="text/javascript">

//信息提示
//   function MsgPrompt(msg)
//   {
//       layer.open({
//           content: msg
//           ,skin: 'msg'
//           ,time: 2 //2秒后自动关闭
//       });
//   }

  window.onload=function(){
      //设置底部导航选中状态
      $('.headertop .wapper > ul > li').last().find('a').addClass('active');
      // $('.footer > ul > li').last().find('em').addClass('selected');

      $('.userPublic .userMenu > ul > li').first().find('a').addClass('active');
  }


  // function sort(array)
  // {
  //     var compare = function(val1,val2){
  //         return val2 - val1;
  //     };
  //
  //     array.sort(compare);
  //
  //     return array;
  // }
// console.log(sort([2,3,45,7]));

  // function sum(head,foot){
    //     let arr = [];
    //     let a   = 0;//鸡
    //     let b   = 0;//兔
    //     for(let a = 0; a < head; a++){
    //         b= (head-a);
    //         if(2*a+4*b==foot){
    //             arr.push(a,b);
    //         }
    //     }
    //
    //     return arr;
    // }
    //
    // arr = sum(48,132);
  //上传图片
  var formdata = new FormData();
  formdata.append("action", "UploadVMKImagePath");
  $('#upDateImg').change(function () {

    var index = layer.load(2);

    var file = this.files[0];
    if(!/image\/\w+/.test(file.type)){
      layer.close(index);
      return layer.msg('<?php echo (L("upload_error")); ?>');
    }
    formdata.append("face",$(this)[0].files[0]);
    $.ajax({
      type:'post',
      url:"<?php echo U('faceUpload');?>",
      cache: false,//上传文件无需缓存
      processData: false,//用于对data参数进行序列化处理 这里必须false
      contentType: false, //必须
      data:formdata,
      success:function(data){
        if(data.status==1){
          layer.close(index);
          layer.msg(data.info);
          return window.location.reload();
        }else{
          laeyr.close(index);
          return layer.msg(data.info);
        }
      }
    });
  });

  // 解绑银行卡
function Unbundling(id)
{
  layer.open({
    content: '<?php echo (L("are_you_unbind")); ?>'
    ,btn: ['<?php echo (L("bank_determine")); ?>', '<?php echo (L("cancel")); ?>']
    ,shadeClose:false
    ,yes: function(index){

      var load   = layer.open({type: 2,shadeClose:false,content:'解绑中'});
      $.ajax({
        url: "<?php echo U('Withdrawals/Unbundling');?>",
        dataType: 'json',
        type: 'post',
        data: {'id': id},
        success: function (data) {
          layer.open({
            content: data.msg
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
          });
          layer.close(load);
          if(data.code == 200)
            return window.location.reload();
        },
        error: function (res) {
          console.log(res);
        }
      });
    }
  });
}

</script>