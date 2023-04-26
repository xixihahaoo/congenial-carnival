<?php if (!defined('THINK_PATH')) exit();?>
    <!DOCTYPE html>
<html data-n-head="" lang="zh-TW">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta data-n-head="true" content="Meta description" name="description" data-hid="description">
    <meta data-n-head="true" content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, user-scalable=no,minimum-scale=1.0, maximum-scale=1.0,viewport-fit=contain" data-n-head="true">
    <title data-n-head="true"><?php echo (L("to_login")); ?></title>
    <link href="/Public/Qts/Home/css/common.css" rel="stylesheet">
    <link href="/Public//Qts/Home/css/pcPublic.css" rel="stylesheet">

    <style type="text/css">.captcha[data-v-2d3e0ef2] {
        width: .89rem;
        height: .28rem;
        color: #ddd;
        position: absolute;
        right: .01rem;
        top: .12rem;
        text-align: center;
        line-height: .28rem;
        border-radius: .01rem
    }

    .cap[data-v-2d3e0ef2] {
        color: #2187f7
    }

    .login_footers[data-v-2d3e0ef2] {
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        padding: 0 .2rem;
        width: 70%;
        overflow: hidden;
        font-size: 15px;
        color: #ddd;
        margin: .2rem auto;
    }

    .login_footers > div[data-v-2d3e0ef2]:first-of-type {
        float: left
    }

    .login_footers > div[data-v-2d3e0ef2]:nth-of-type(2) {
        position: relative;
        float: right;
        color: #2187f7;
        padding-right: .15rem
    }

    h2[data-v-2d3e0ef2] {
        font-size: 30px;
        color: #ddd;
        line-height: .9rem
    }

    .nuxt-link-exact-active[data-v-2d3e0ef2] {
        color: #ddd;
        text-decoration: none
    }

    .content {
        padding: 0 .2rem;
        width: 70%;
        margin: auto;
    }

    label[data-v-2d3e0ef2] {
        position: relative;
        display: block
    }

    .login_form[data-v-2d3e0ef2] {
        margin: 0 auto;
        text-align: center
    }

    input[data-v-2d3e0ef2] {
        position: relative;
        width: 100%;
        height: .48rem;
        margin-top: .05rem;
        -webkit-box-shadow: inset 0 0 0 0 #ddd;
        box-shadow: inset 0 0 0 0 #ddd;
        border-bottom: .01rem solid #ddd;
        color: #ddd;
    }

    .login_btn[data-v-2d3e0ef2] {
        position: relative;
        margin-top: .42rem
    }

    .login_btn1[data-v-2d3e0ef2] {
        position: relative;
        margin-top: .15rem
    }

    .login_btn i[data-v-2d3e0ef2] {
        position: absolute;
        display: none;
        top: .16rem;
        left: 58%;
        display: block;
        width: .15rem;
        height: .15rem;
        background-size: 100%
    }

    .login_btn .activeColor[data-v-2d3e0ef2] {
        /*background-image: -o-linear-gradient(319deg, #1254a8 0, #0c62c1 100%);*/
        /*background-image: linear-gradient(-229deg, #1254a8, #0c62c1)*/
        background: #7aaeed;
    }

    .login_btn .activeBg[data-v-2d3e0ef2] {
        background-image: url(/_nuxt/img/login_loading.gif)
    }

    .squre[data-v-2d3e0ef2] {
        position: relative;
        font-weight: 400;
        display: block;
        margin: 0 auto;
        text-align: center;
        line-height: .44rem;
        border-radius: .44rem;
        font-size: .17rem;
        letter-spacing: 0;
        cursor: pointer;
    }

    span[data-v-2d3e0ef2] {
        background-color: #cecfd1;
        color: #fff
    }

    b[data-v-2d3e0ef2] {
        color: #7aaeed;
        border: .01rem solid #7aaeed;
    }

    b > a[data-v-2d3e0ef2] {
        display: block;
        width: 100%;
        height: 100%
    }

    </style>
    <style type="text/css">#header[data-v-7fd5ad9d] {
        width: 100%;
        text-align: center;
        color: #012057;
        z-index: 4;
        top: 0
    }

    #header h3[data-v-7fd5ad9d] {
        position: relative;
        height: .5rem;
        line-height: .5rem;
        margin: 0;
        font-size: .16rem;
        font-weight: 400;
        overflow: hidden
    }

    #header .header_content .left[data-v-7fd5ad9d] {
        position: absolute;
        top: 0;
        left: .2rem
    }

    #header .header_content .right[data-v-7fd5ad9d] {
        position: absolute;
        top: .1rem;
        right: .2rem
    }

    #header .header_content .left a[data-v-7fd5ad9d] {
        color: #fff;
        line-height: .5rem;
        font-size: .2rem
    }

    .arrow_white[data-v-7fd5ad9d]:after {
        border-color: #fff
    }

    .arrow_left[data-v-7fd5ad9d]:after, .arrow_white[data-v-7fd5ad9d]:after {
        content: " ";
        display: inline-block;
        -webkit-transform: rotate(225deg);
        -ms-transform: rotate(225deg);
        transform: rotate(225deg);
        height: .17rem;
        width: .17rem;
        border-width: .02rem .02rem 0 0;
        border-style: solid;
        top: -.02rem;
        position: absolute;
        left: 0;
        top: .19rem
    }

    .arrow_left[data-v-7fd5ad9d]:after {
        border-color: #012057
    }

    .arrow_right[data-v-7fd5ad9d] {
        display: inline-block;
        top: .15rem;
        width: .25rem;
        height: .25rem;
        background-image: url("/Public//Qts/Home/img/user/exit.png");
        background-size: 100%
    }
    .footer {
        position: relative;
        top: 0;
        height: .55rem;
        line-height: .55rem;
    }
    .footer:after {
        content: '';
        clear: both;
        display: block;
    }
    .footer > div {
        float: left;
        width: 50%;
    }
    .footer > ul {
        float: right;
        width: 50%;
    }
    .footer[data-v-18c6d448] {
        width: 100%;
        background-color: #1F222B;
    }
    .footer em[data-v-18c6d448] {
        display: block;
        margin: auto;
        color: #666;
        font-size: .16rem;
    }
    /*.contentWrap {*/
        /*width: 60%;*/
        /*margin: auto;*/
    /*}*/
    #header {
        position: static;
    }
    /*新增*/
    body, html {
        height: 100%;
        width: 100%;
        background: #262b41 !important;
    }
    .page-main {
        background: #212139;
        min-height: 600px;
        margin: 30px auto !important;
        padding: 20px 80px !important;
    }
    </style>
</head>
<body>
<div id="__nuxt">
    <div class="progress" data-v-4a8a9a01=""
         style="width: 0%; height: 2px; background-color: rgb(1, 40, 97); opacity: 0;"></div>
    <div data-v-2d3e0ef2="" class="">
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
        <div class="page-main">
            <div data-v-7fd5ad9d="" data-v-2d3e0ef2="" id="header">
                <div data-v-7fd5ad9d="" class="header_content"><h3 data-v-7fd5ad9d=""></h3><!---->
                    <div data-v-7fd5ad9d="" class="right"><a data-v-7fd5ad9d="" class="arrow_right" onclick="window.history.back(-1);"></a></div>
                </div>
            </div>
            <div data-v-2d3e0ef2="" class="content">
                <h2 data-v-2d3e0ef2=""><?php echo (L("to_login")); ?></h2>
                <div data-v-2d3e0ef2="">
                    <div data-v-2d3e0ef2="" class="login_form">
                        <div data-v-2d3e0ef2="" class="ipt-group">
                            <label data-v-2d3e0ef2="">
                                <input data-v-2d3e0ef2="" type="email" placeholder="<?php echo (L("input_mailbox")); ?>"  value="<?php echo ($username); ?>" autofocus="autofocus">
                                <i data-v-2d3e0ef2="" style="display: none" class="icon icon_tel"></i>
                            </label>
                        </div>

                        <div data-v-2d3e0ef2="">
                            <div data-v-2d3e0ef2="" class="ipt-group">
                                <label data-v-2d3e0ef2="">
                                    <input data-v-2d3e0ef2="" type="password" placeholder="<?php echo (L("input_password")); ?>" maxlength="15" class="password">
                                    <i data-v-2d3e0ef2="" class="icon icon_pwd" style="display: block;"></i>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div data-v-2d3e0ef2="" class="login_btn">
                        <span data-v-2d3e0ef2="" class="squre login" onclick="login();">
                            <?php echo (L("sign_in")); ?>
                            <i data-v-2d3e0ef2="" class=""></i>
                        </span>
                    </div>

                    <div data-v-2d3e0ef2="" class="login_btn login_btn1">
                        <b data-v-2d3e0ef2="" class="squre">
                            <a data-v-2d3e0ef2="" href="<?php echo U('Register/reg');?>" class=""><?php echo (L("sign_up")); ?></a>
                        </b>
                    </div>
                </div>
            </div>
            <div data-v-2d3e0ef2="" class="login_footers">
                <div data-v-2d3e0ef2="">
                    <a data-v-2d3e0ef2="" href="<?php echo U('Register/outpwd');?>" class=""><?php echo (L("forget_password")); ?></a>
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
</div>


<script src="/Public/Qts/Home/js/jquery.js"></script>
<script type="text/javascript" src="/Public//Home/css/layer/layer.js"></script>
<script type="text/javascript" src="/Public//Qts/Home/js/appAlert.js"></script>
<script>
    $('.icon.icon_pwd').click(function () {
        if ($(this).attr('data') == 0) {
            $(this).siblings().attr('type', 'password')
            $(this).attr('data', 1)
        } else {
            $(this).attr('data', 0)
            $(this).siblings().attr('type', 'text')
        }
    });

    $('input').keyup(function () {

        var email   = $('input[type=email]').val();
        var pwd     = $('.password').val();
        var reg     = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
        if(reg.test(email) && pwd != '') {
            $('.login').addClass('activeColor');
        } else {
            $('.login').removeClass('activeColor');
        }
    });

    /**
     * [login 登录]
     * @return void
     */
    function login()
    {
        var email       = $('input[type=email]').val();
        var password    = $(".password").val();

        try{
            showProgress();
        }catch(e){
            var index = layer.load(2);
        }

        $.ajax({
            type: "post",
            url: "<?php echo U('login');?>",
            dataType: 'json',
            data:{'email':email,'password':password},
             success: function (data) {

                try{
                    closeProgress();
                }catch(e){
                    layer.close(index);
                }

                if(data.code === 400)
                {
                    try{
                        return alertMessage(data.msg,1000);
                    }catch(e){
                        return layer.msg(data.msg);
                    }
                }
                if(data.code === 200)
                {
                    try{
                        alertMessage(data.msg,1000);
                    }catch(e){
                        layer.msg(data.msg);
                    }
                    return window.setTimeout("window.location='<?php echo U('Index/index');?>'",1500);
                }
             }
        });
    }


</script>
</body>
</html>