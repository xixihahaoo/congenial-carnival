<?php if (!defined('THINK_PATH')) exit();?>    <!DOCTYPE html>
<html data-n-head="" lang="zh-TW">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta data-n-head="true" content="Meta description" name="description" data-hid="description">
    <meta data-n-head="true" content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, user-scalable=no,minimum-scale=1.0, maximum-scale=1.0,viewport-fit=contain" data-n-head="true">
    <title data-n-head="true"><?php echo (L("order_details")); ?></title>
    <link href="/Public/Qts/Home/css/common.css" rel="stylesheet">
    <link href="/Public//Qts/Home/css/pcPublic.css" rel="stylesheet">
    <style data-vue-ssr-id="7117ae39:0 309b0fcd:0">.page-main[data-v-9f8bfaaa] {
        padding-bottom: 0
    }

    .variety-name[data-v-9f8bfaaa] {
        font-weight: 500;
        font-size: .16rem;
        color: #ddd;
        margin-right: .1rem
    }

    .order-title[data-v-9f8bfaaa] {
        line-height: .25rem
    }

    .variety-order[data-v-9f8bfaaa] {
        color: #ddd
    }

    .order-detail[data-v-9f8bfaaa] {
        color: #ddd;
        line-height: .25rem
    }

    .buy-tag[data-v-9f8bfaaa] {
        padding: .02rem .03rem;
        color: #fff;
        border-radius: .1rem;
        font-size: .1rem
    }

    section[data-v-9f8bfaaa] {
        /*background: #002f82*/
    }

    .main[data-v-9f8bfaaa] {
        padding: .15rem;
        /*background: #fff;*/
        border-radius: .1rem .1rem 0 0;
        position: relative
    }

    .showimgtip[data-v-9f8bfaaa] {
        position: absolute;
        top: 0;
        right: 0;
        width: .28rem
    }

    .main ul[data-v-9f8bfaaa] {
        width: 100%;
        border-radius: .05rem;
        margin: .1rem 0;
        overflow: hidden
    }

    .main ul li[data-v-9f8bfaaa] {
        width: 100%;
        height: .5rem;
        line-height: .5rem;
        padding: 0 .15rem
    }

    .main ul li .order-detail[data-v-9f8bfaaa] {
        line-height: .5rem
    }

    .main ul li[data-v-9f8bfaaa]:nth-of-type(odd) {
        /*background: #fff;*/
    }

    .main ul li[data-v-9f8bfaaa]:nth-of-type(2n) {
        /*background: #fff*/
    }

    .infos[data-v-9f8bfaaa] {
        width: 100%;
        margin-bottom: 1rem
    }

    .infos .line[data-v-9f8bfaaa] {
        width: 100%;
        /*padding: .25rem 0;*/
        /*background: #fff;*/
        padding-top: 0
    }

    .line img[data-v-9f8bfaaa] {
        display: block;
        width: 100%
    }

    .infos .order-info[data-v-9f8bfaaa] {
        /*background: #fff;*/
        padding: 0 .15rem
    }

    .order-info p[data-v-9f8bfaaa] {
        line-height: .25rem;
        color: #ddd;
        font-size: .1rem
    }

    .order-win[data-v-9f8bfaaa] {
        line-height: .6rem;
        border-top: .01rem solid #ddd;
        color: #333;
        font-size: .16rem;
        margin-top: .1rem
    }

    .order-win span.right[data-v-9f8bfaaa] {
        font-size: .24rem
    }

    .bottombtn[data-v-9f8bfaaa] {
        position: fixed;
        bottom: .3rem;
        height: .4rem;
        width: 90%;
        left: 0;
        right: 0;
        margin: auto;
        text-align: center;
        line-height: .4rem;
        background: #2187f7;
        border-radius: 100px;
        font-size: 17px;
        color: #fff
    }

    .detail[data-v-9f8bfaaa] {
        width: 100%;
        margin: .1rem 0;
        display: none;
    }

    .detail > div[data-v-9f8bfaaa] {
        float: left;
        width: 25%;
        text-align: center;
        margin-bottom: .1rem
    }

    @media screen and (max-width: 370px) {
        .detail > div[data-v-9f8bfaaa] {
            width: 25%
        }
    }

    .detail p.max[data-v-9f8bfaaa] {
        font-size: .14rem;
        color: #ddd;
        line-height: .2rem
    }

    .detail p.min[data-v-9f8bfaaa] {
        font-size: .11rem;
        color: #ddd;
        line-height: .2rem
    }

    .main ul li.detail[data-v-9f8bfaaa] {
        padding: .1rem .15rem;
        border-radius: .1rem;
        height: auto
    }

    .total[data-v-9f8bfaaa] {
        font-size: .24rem;
        position: relative;
        padding-right: .15rem
    }

    .total em[data-v-9f8bfaaa] {
        display: block;
        width: .1rem;
        height: .1rem;
        border-top: .01rem solid #000;
        border-right: .01rem solid #000;
        -ms-transform: rotate(135deg);
        transform: rotate(135deg);
        -webkit-transform: rotate(135deg);
        position: absolute;
        top: 5px;
        right: -5px;
        cursor: pointer;
    }

    .total em.up[data-v-9f8bfaaa] {
        -ms-transform: rotate(-45deg);
        transform: rotate(-45deg);
        -webkit-transform: rotate(-45deg)
    }

    .dealer[data-v-9f8bfaaa] {
        color: #ddd;
        font-size: .12rem
    }</style>
    <style type="text/css">._v-container[data-v-ecaca2b0] {
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        overflow: hidden;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        -o-user-select: none;
        user-select: none
    }

    ._v-container > ._v-content[data-v-ecaca2b0] {
        width: 100%;
        -webkit-transform-origin: left top;
        -webkit-transform: translateZ(0);
        -moz-transform-origin: left top;
        -moz-transform: translateZ(0);
        -ms-transform-origin: left top;
        -ms-transform: translateZ(0);
        -o-transform-origin: left top;
        -o-transform: translateZ(0);
        transform-origin: left top;
        transform: translateZ(0)
    }

    ._v-container > ._v-content > .pull-to-refresh-layer[data-v-ecaca2b0] {
        width: 100%;
        height: 60px;
        margin-top: -60px;
        text-align: center;
        font-size: 16px;
        color: #aaa
    }

    ._v-container > ._v-content > .loading-layer[data-v-ecaca2b0] {
        width: 100%;
        height: 60px;
        text-align: center;
        font-size: 16px;
        line-height: 60px;
        color: #aaa;
        position: relative
    }

    ._v-container > ._v-content > .loading-layer > .no-data-text[data-v-ecaca2b0] {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 1
    }

    ._v-container > ._v-content > .loading-layer > .no-data-text[data-v-ecaca2b0], ._v-container > ._v-content > .loading-layer > .spinner-holder[data-v-ecaca2b0] {
        opacity: 0;
        transition: opacity .15s linear;
        -webkit-transition: opacity .15s linear
    }

    ._v-container > ._v-content > .loading-layer > .no-data-text.active[data-v-ecaca2b0], ._v-container > ._v-content > .loading-layer > .spinner-holder.active[data-v-ecaca2b0] {
        opacity: 1
    }

    ._v-container > ._v-content > .loading-layer .spinner-holder[data-v-ecaca2b0], ._v-container > ._v-content > .pull-to-refresh-layer .spinner-holder[data-v-ecaca2b0] {
        text-align: center;
        -webkit-font-smoothing: antialiased
    }

    ._v-container > ._v-content > .loading-layer .spinner-holder .arrow[data-v-ecaca2b0], ._v-container > ._v-content > .pull-to-refresh-layer .spinner-holder .arrow[data-v-ecaca2b0] {
        width: 20px;
        height: 20px;
        margin: 8px auto 0;
        -webkit-transform: translateZ(0) rotate(0deg);
        transform: translateZ(0) rotate(0deg);
        transition: transform .2s linear
    }

    ._v-container > ._v-content > .loading-layer .spinner-holder .text[data-v-ecaca2b0], ._v-container > ._v-content > .pull-to-refresh-layer .spinner-holder .text[data-v-ecaca2b0] {
        display: block;
        margin: 0 auto;
        font-size: 14px;
        line-height: 20px;
        color: #aaa
    }

    ._v-container > ._v-content > .loading-layer .spinner-holder .spinner[data-v-ecaca2b0], ._v-container > ._v-content > .pull-to-refresh-layer .spinner-holder .spinner[data-v-ecaca2b0] {
        margin-top: 14px;
        width: 32px;
        height: 32px;
        fill: #444;
        stroke: #69717d
    }

    ._v-container > ._v-content > .pull-to-refresh-layer.active .spinner-holder .arrow[data-v-ecaca2b0] {
        -webkit-transform: translateZ(0) rotate(180deg);
        transform: translateZ(0) rotate(180deg)
    }
    /*新增css*/
    body, html {
      height: 100%;
      width: 100%;
      background: #262b41 !important;
    }
    .page-main {
      background: #212139;
      min-height: 600px;
      margin: 30px auto !important;
      padding: 0 80px !important;
    }
    .page-main h3 {
      line-height: 110px;
      text-align: center;
      position: relative;
    }
    .page-main h3 span {
        color: #ddd;
    }
    .page-main h3 a {
      position: absolute;
      font-size: 14px;
      color: #77abf4;
      top: 0;
      right: 160px;
    }
    </style>
</head>
<body data-n-head="">
<div id="__nuxt">
    <div class="progress" data-v-4a8a9a01="" style="width:0;height:2px;background-color:#012861;opacity:0"></div>
    <div class="content" data-v-9f8bfaaa="">
        <!--<div id="head" data-v-9f8bfaaa="" style="width: 60%">-->
            <!--<div class="head_content"><h3 class="product-name"><span><?php echo ($order["option_name"]); ?>(<?php echo ($order["order_result_note"]); ?>)</span><em></em></h3>-->
                <!--<div class="left" onclick="window.history.back();"><a class="arrow_left"></a></div>-->
                <!--<div class="right arrow_right"><b></b></div>-->
            <!--</div>-->
        <!--</div>-->
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
        <section class="page-main" data-v-9f8bfaaa="">
            <h3>
              <span><?php echo ($order["option_name"]); ?>(<?php echo ($order["order_result_note"]); ?>)</span>
              <a href="javascript: void (0);" onclick="window.history.back()"><?php echo (L("back")); ?></a>
            </h3>
            <div class="main" data-v-9f8bfaaa="">

                <p class="order-title" data-v-9f8bfaaa="">
                    <span class="variety-name" data-v-9f8bfaaa=""><?php echo (L("Profit_loss")); ?></span>
                    <span class="buy-tag <?php echo ($order["order_class"]); ?>" data-v-9f8bfaaa=""><?php echo ($order["order_type_note"]); ?></span>
                    <span class="right total <?php echo ($order["order_result_class"]); ?>" data-v-9f8bfaaa="">$<?php echo ($order["ploss"]); ?>
                        <em data-v-9f8bfaaa=""></em>
                    </span>
                </p>

                <div class="detail clearfix" data-v-9f8bfaaa=""><!---->
                    <div data-v-9f8bfaaa=""><p class="max" data-v-9f8bfaaa="">$<?php echo ($order["net_profit"]); ?></p>
                        <p class="min" data-v-9f8bfaaa=""><?php echo (L("net_profit")); ?></p></div>

                    <?php if($order['order_scene'] == 1): ?><div data-v-9f8bfaaa=""><p class="max" data-v-9f8bfaaa=""><?php echo ($order["overnight_fee"]); ?></p>
                            <p class="min" data-v-9f8bfaaa=""><?php echo (L("stock")); ?></p></div><?php endif; ?>


                    <div data-v-9f8bfaaa=""><p class="max" data-v-9f8bfaaa=""><?php echo ($order["fee"]); ?></p>
                        <p class="min" data-v-9f8bfaaa=""><?php echo (L("fee")); ?></p></div>
                    <div data-v-9f8bfaaa=""><p class="max" data-v-9f8bfaaa="">±$<?php echo ($order["Bond"]); ?></p>
                        <p class="min" data-v-9f8bfaaa=""><?php echo (L("bond")); ?></p></div>
                </div>

                <ul data-v-9f8bfaaa="">
                    <li data-v-9f8bfaaa="">
                        <p class="order-detail" data-v-9f8bfaaa="">
                            <span data-v-9f8bfaaa=""><?php echo (L("opening_price")); ?></span>
                            <span class="right txt_num" data-v-9f8bfaaa=""><?php echo ($order["buyprice"]); ?></span>
                        </p>
                    </li>

                    <li data-v-9f8bfaaa="">
                        <p class="order-detail" data-v-9f8bfaaa="">
                            <span data-v-9f8bfaaa=""><?php echo (L("exit_price")); ?></span>
                            <span class="right txt_num" data-v-9f8bfaaa=""><?php echo ($order["sellprice"]); ?></span>
                        </p>
                    </li>


                    <?php if($order['order_scene'] == 1): ?><li data-v-9f8bfaaa="">
                            <p class="order-detail" data-v-9f8bfaaa="">
                                <span data-v-9f8bfaaa=""><?php echo (L("stop_loss")); ?></span>
                                <span class="right txt_num" data-v-9f8bfaaa=""><?php echo ($order["endloss"]); ?></span>
                            </p>
                        </li>

                        <li data-v-9f8bfaaa=""><p class="order-detail" data-v-9f8bfaaa=""><span
                                data-v-9f8bfaaa=""><?php echo (L("target_profit")); ?></span><span class="right txt_num" data-v-9f8bfaaa=""><?php echo ($order["endprofit"]); ?></span>
                        </p></li>

                        <li data-v-9f8bfaaa=""><p class="order-detail" data-v-9f8bfaaa=""><span
                                data-v-9f8bfaaa=""><?php echo (L("trade_lots")); ?></span><span class="right txt_num" data-v-9f8bfaaa=""><?php echo ($order["onumber"]); ?> <?php echo (L("lots")); ?></span></p>
                        </li>
                    <?php else: ?>
                        <li data-v-9f8bfaaa="">
                            <p class="order-detail" data-v-9f8bfaaa="">
                                <span data-v-9f8bfaaa=""><?php echo (L("hold_time")); ?></span>
                                <span class="right txt_num" data-v-9f8bfaaa=""><?php echo ($order["second"]); ?> s</span>
                            </p>
                        </li>

                        <li data-v-9f8bfaaa="">
                            <p class="order-detail" data-v-9f8bfaaa="">
                                <span data-v-9f8bfaaa=""><?php echo (L("earnings_ratio")); ?></span>
                                <span class="right txt_num" data-v-9f8bfaaa=""><?php echo ($order["odds"]); ?>%</span>
                            </p>
                        </li><?php endif; ?>


                    <?php if(($order['order_type']) == "3"): ?><li data-v-9f8bfaaa=""><p class="order-detail" data-v-9f8bfaaa=""><span
                                data-v-9f8bfaaa=""><?php echo (L("delegate_type")); ?></span><span class="right txt_num" data-v-9f8bfaaa=""><?php echo ($order["resting_note"]); ?></span></p>
                        </li><?php endif; ?>
                </ul>
            </div>

            <div class="infos" data-v-9f8bfaaa="">
                <!--<div class="line" data-v-9f8bfaaa=""><img-->
                        <!--src="/Public/Qts/Home/img/record/1.png"-->
                        <!--data-v-9f8bfaaa=""></div>-->
                <div class="order-info" data-v-9f8bfaaa=""><p data-v-9f8bfaaa=""><?php echo (L("open_time")); ?>:<?php echo date('Y/m/d H:i:s',$order['buytime']);?></p>
                    <p data-v-9f8bfaaa=""><?php echo (L("closing_time")); ?>:<?php echo date('Y/m/d H:i:s',$order['selltime']);?></p>
                    <p data-v-9f8bfaaa=""><?php echo (L("orderno")); ?>：<?php echo ($order["orderno"]); ?></p></div>
            </div>
        </section>

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
<script>
    $(function () {
      $('.total em[data-v-9f8bfaaa]').click(function () {
          if($(this).attr('data')==0){
              $(this).removeClass('up')
              $(this).attr('data',1)
              $('.detail[data-v-9f8bfaaa]').hide()
          }else{
              $(this).addClass('up')
              $(this).attr('data',0)
              $('.detail[data-v-9f8bfaaa]').show()
          }
      })
    })
</script>
</body>
</html>