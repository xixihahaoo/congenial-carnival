<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html data-n-head="" lang="zh-TW">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta data-n-head="true" content="Meta description" name="description" data-hid="description">
    <meta data-n-head="true" content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, user-scalable=no,minimum-scale=1.0, maximum-scale=1.0,viewport-fit=contain" data-n-head="true">
<title data-n-head="true"><?php echo ($option["capital_name"]); ?></title>
<link rel="stylesheet" href="/Public/Qts/Home/css/swiper.min.css">
<link href="/Public//Qts/Home/css/lCalendar.css" rel="stylesheet">
<link href="/Public//Qts/Home/css/common.css" rel="stylesheet">
<link href="/Public//Qts/Home/css/product.css" rel="stylesheet">
<link href="/Public//Qts/Home/css/pcPublic.css" rel="stylesheet">

<style type="text/css" data-n-head="true">
    body {
        overflow: auto
    }
    .zixuan[data-v-610295de] {
        width: 100%;
        height: 100%;
        overflow: hidden;
        display: none;
    }
    .rule[data-v-6524b236] {
        display: inline-block;
        position: absolute;
        top: .14rem;
        width: .6rem;
        height: .2rem;
        right:.14rem;
        background: #ffbf23;
        text-align: center;
        font-size: .12rem;
        line-height: .2rem;
        border-radius: .02rem;
        color: #000;
        /*background: url(/Public/Qts/Home/img/details/rule.png) no-repeat 0;*/
        /*background-size: cover;*/
    }

    .more-close[data-v-6524b236] {
        background: url(/Public/Qts/Home/img/details/close.png) no-repeat 0;
        background-size: 100%;
    }
    .zixuan-wrap[data-v-610295de] {
        width: 1.08rem;
        max-height: 85% !important;
        background: #1F222B;
        padding: 0 0 .14rem .14rem;
        position: fixed;
        top: .7rem;
        z-index: 1001;
        right: 0;
	    overflow-y: auto;
    }
    .modal[data-v-610295de] {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        opacity: .75;
        background: #000;
        z-index: 1000;
        overflow: hidden;
    }
    .zixuan-content[data-v-610295de] {
        height: 100% !important;
        overflow-y: auto;
    }
    .zixuan-list[data-v-610295de] {
        border-bottom: 1px solid #c8c8c8;
        padding: .14rem 0;
    }
    .zixuan-name[data-v-610295de] {
        font-size: .15rem;
        color: #FCFCFE;
    }
    .zixuan-price[data-v-610295de] {
        font-size: .11rem;
        color: #FCFCFE;
    }
    #showDatePop{
        display: block;
        position: relative;
    }
    #showDatePop input{
        position: relative;
        z-index: 6;
        color:#fff;
    }
    #showDatePop em{
        position: absolute;
        right: 0;
        top: 0;
        z-index: 1;
    }
    .article {
        height: 350px;
    }
    /* 时间插件默认样式修改 */
    .datetime_roll>div, .time_roll>div {
        font-size: 16px;
        color: #111;
    }
    .datetime_roll, .time_roll {
        font-weight: 400;
    }
    .date_btn_box {
        background: #eee;
    }
    .date_btn {
        color: #2187f7;
    }
    .date_grid>div {
        font-size: 1.2em;
        line-height: 1.8em;
        font-weight: 500;
    }

    .otherMoney input{
        color: white !important;
        width: 100%;
        font-size: 12px;
        height: 19px;
        line-height: 19px;
        text-align: center;
        background-color: #38373e;
    }

    .otherMoney input::-webkit-input-placeholder{
        font-size: 12px;
    }
    .btn-wrap[data-v-6524b236] {
        width: 100%;
    }
    .stock-title {
        height: .5rem;
        overflow: auto;
    }
    ul.stock-tab {
        width: 100%; !important;
        border-radius: 0 !important;
        overflow: hidden !important;
    }
    .stock-tab li {
        width: calc(100% / 8) !important;
        margin-left: 0 !important;
        color: #fff;
        cursor: pointer;
    }
    ul.stock-tab, .stock-tab li {
        height: .5rem;
        line-height: .5rem;
        background: none;
    }
    .timeTabContent .timeTabBtn {
        width: 60%;
    }
    #head {
        width: 60%;
    }
    .nav-wrap {
        overflow: auto;
        height: 100%;
        background: #262b41;
    }
    .scroll-wrap[data-v-6524b236],.variety-top[data-v-6524b236] {
        width: 60%;
    }
    .zixuan-wrap[data-v-610295de] {
        right: 3.8rem;
    }
    .order-confirm-panel {
        width: 30%;
    }
    .period {
        overflow-x: auto;
    }

    .titles {
        width: 60%;
        margin: auto;
        margin-top: .15rem;
        height: 36px;
        z-index: 99;
        color: #ddd;
        position: static;
    }
    .titles > div {
        width: 33.33%;
        float: left;
        text-align: center;
        line-height: .36rem;
        font-size: .14rem;
        color: #ddd;
        position: relative;
        cursor: pointer;
    }
    .titles > div.tab_checked {
        color: #e7ca31;
    }
    .titles > div.tab_checked span {
        display: inline-block;
        width: 50%;
        height: .02rem;
        background: #e7ca31;
        position: absolute;
        bottom: 0;
        left: 40%;
        margin-left: -15%;
        border-radius: .2rem;
    }
    body, html {
        background: #f5f9fe!important;
    }
    #head{
        position: static;
    }
    .variety-top[data-v-6524b236]{
        position: relative;
        width: 100%;
        top: 0;
        background: #212139;
        margin-bottom: 0.05rem;
    }
    .content-wrap[data-v-6524b236]{
        margin-top: 0;
    }
    .page-main{
        padding: 0;
    }
    .variety-type[data-v-6524b236]{
        color: #ddd;
    }
    .variety-price[data-v-6524b236]{
        color: #ea4879;
    }
    ._btn{
        border: 1px solid #d9bc3a;
        color: #d9bc3a;
        padding: 0.05rem;
        border-radius: 3px;
        font-size: 0.14rem;
        position: absolute;
        right: .3rem;
        top: 50%;
        transform: translateY(-50%);
    }
    .variety-price[data-v-6524b236]{
            padding: .05rem 0 0 .3rem;
    }
    .variety-type[data-v-6524b236]{
            padding: .1rem 0 0 .3rem;
    }
    .content-box{
        /*display: flex;*/
        /*justify-content: space-between;*/
    }
    .content-wrap[data-v-6524b236] {
        margin-top: 0;
        /*flex: 0 0 49.5%;*/
        /*min-height: 750px;*/
        background: #212139;
    }
    .con-txt[data-v-6524b236]{
        color: #ddd;
    }
    .quick-hand[data-v-6524b236]{
        border: 1px solid #d9bc3a;
        color: #d9bc3a;
    }
    input[data-v-6524b236]{
        color: #d9bc3a;
    }
    .quick-w2 .active[data-v-6524b236] {
        border-radius: .02rem;
        color: #fff;
        border: 1px solid #d9bc3a;
        background: #d9bc3a;
    }
    .trade-wrap[data-v-6524b236]{
        background: transparent;
    }
    .trade-title span.border[data-v-6524b236]{
            background: #7aaeed;
    }
    .isSelected {
        color: #7aaeed !important;
    }
    .quick-w2[data-v-6524b236] {
        width: 100%;
        position: relative;
        padding-top: 0.2rem;
        /*border-top: 1px solid #f5f9fe;*/
        border: none;
    }
    .trade-con .list[data-v-6524b236]{
        border-bottom: 1px solid #f5f9fe;

    }
    .putType-wrap li[data-v-6524b236]{
        border: 1px solid #7aaeed;
        color:#7aaeed;
        background: #f5f9fe;
    }
    .putType-wrap .active[data-v-6524b236] {
        background: #7aaeed;
        color: #fff;
        border: 1px solid #7aaeed;
    }
    .quick-w3{
        padding-bottom: .2rem;
        border-bottom: 1px solid #f5f9fe;
    }
    .btn-wrap[data-v-6524b236]{
        position: relative;
    }
    .quick-btn[data-v-6524b236]{
        flex-direction: column;
        position: relative;
    }
    .txt_green {
        color: #fff;
        background: #009900;
        border: 0;
        margin-bottom: 0.3rem;
    }
    .txt_red {
        color: #fff;
        background: #e62512;
        border: 0;
    }
    .putType-wrap[data-v-6524b236]{
        border-bottom: 1px solid #f5f9fe;
    }
    .timeTabContent .timeTabBtn {
        width: 100%;
        padding: 0 .15rem;
        position: relative;
        bottom: 0;
        z-index: 101;
        background: #2a2a42;
        height: .5rem;
        margin-top: 50px;
    }
    .sell_check[data-v-6524b236]{
        color: green;
    }
    .buy_check[data-v-6524b236]{
        color: red;
    }
    .bg_blue{
        background: #e8d030;
    }
    .btn[data-v-6524b236]{
        color: #fff;
    }
    .flow[data-v-6524b236]{
        position: relative;
        background: #212139;
        width: 100%;
        color: #ddd;
        margin: 20px 0;
    }
    .icon-min {
        /*background: url(/Public//Qts/Home/img/xiadan/subtract.png) no-repeat 50%;*/
    }
    .icon-add {
        /*background: url(/Public//Qts/Home/img/xiadan/add.png) no-repeat 50%;*/
    }
    .stock-tab li.has{
        color: #e8d030;
    }

    body, html {
        height: 100%;
        width: 100%;
        background: #262b41 !important;
    }
    .headertop{
        position: absolute;
        background: transparent !important;
        box-shadow:0 3px 6px 0 #212139 !important;
    }
    .nav li a {
        color: #fff !important;
    }
    .page-main {
        min-height: 600px;
        margin: 30px auto !important;
        padding: 20px 80px !important;
    }

    .trueFoot {
        background: #21213a !important;
    }

    .quick-hand[data-v-6524b236] {
        height: 34px !important;
        line-height: 34px !important;
        font-size: 16px !important;
    }
    .quick-hand[data-v-6524b236]:not(:last-child) {
        margin-right: 30px !important;
    }

    .lastSpan {
      display: flex !important;
      border: none !important;
    }
    .quick-hand em {
      display: inline-block;
      width: 34px;
      height: 34px;
      background-size: 60%;
      cursor: pointer;
    }
</style>
</head>
<body>


<!-- 买入方向 0涨 1跌 -->
<input type="hidden" name="ostyle" value="1">

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

<div id="__nuxt">
    <div class="progress" data-v-4a8a9a01="" style="width: 0%; height: 2px; background-color: rgb(1, 40, 97); opacity: 0;"></div>

    <div data-v-6524b236="" class="contentWrap">

        <!-- <div data-v-6524b236="" id="head">
            <div data-v-6524b236="" class="head_content">
                <ul data-v-6524b236="" class="head_tab">
                    <li data="1" data-v-6524b236="" class="head_list tab_checked"><?php echo (L("simple")); ?></li>
                    <li data="2" data-v-6524b236="" class="head_list"><?php echo (L("senior")); ?></li>
                    <li data="3" data-v-6524b236="" class="head_list"><?php echo (L("time")); ?></li>
                </ul>
                <div data-v-6524b236="" class="left" onclick="window.location.href='<?php echo U('lists',array('index' => $index));?>'"><a data-v-6524b236="" class="arrow_left"></a></div>
                <div data-v-6524b236="" class="more-close"></div>
            </div>
        </div> -->

        <section data-v-6524b236="" class="page-main">
            <div data-v-6524b236="" class="variety-top">
                <p data-v-6524b236="" class="variety-type">
                    <?php echo ($option["capital_name"]); ?>

                    <?php if(($option['flag']) == "0"): ?><span data-v-6524b236="" class="bishi"><?php echo (L("closed")); ?></span><?php endif; ?>
                </p>
                <p data-v-6524b236="" class="socket-num">
                    <span data-v-6524b236="" class="variety-price"><?php echo ($option["Price"]); ?></span>
                    <span data-v-6524b236="" class="price-value"><?php echo ($option["Diff"]); ?></span>
                    <span data-v-6524b236="" class="price-rate"><?php echo ($option["DiffRate"]); ?>%</span>
                </p>
                <a href="<?php echo U('playIntroduce',array('pid' => $option['id']));?>">
                     <span data-v-6524b236="" class="_btn"><?php echo (L("rules")); ?></span>
                </a>
                <a href="<?php echo U('Position/trade');?>">
                    <span data-v-6524b236="" style="right: 1.3rem;" class="_btn"><?php echo (L("position")); ?></span>
                </a>
            </div>

            <!--时间tab开始-->
            <div class="glass_mask">
                <div class="order-confirm-panel">
                    <div class="panel-header">
                        <div>
                            <?php echo (L("time_confirm")); ?>
                            <div class="close">
                                <i class="close_tag">x</i>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="period">
                            <p class="end_time"><?php echo (L("time_due_time")); ?></p>
                            <ul class="end_time_list">

                                <?php if(is_array($parameter)): $i = 0; $__LIST__ = $parameter;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($i == 1): ?><li class="active" data-time-id="<?php echo ($vo["id"]); ?>" data-time="<?php echo ($vo["time"]); ?>">
                                    <?php else: ?>
                                        <li data-time-id="<?php echo ($vo["id"]); ?>" data-time="<?php echo ($vo["time"]); ?>"><?php endif; ?>
                                        <p class="period-widget-header"><?php echo (L("time_settling_time")); ?></p>
                                        <p class="period-widget-content"><span class="final_time"><?php echo ($vo["time"]); ?></span><span class="final_unit"> <?php echo (L("time_seconds")); ?></span></p>
                                        <p class="period-widget-footer" data-rate="<?php echo ($vo["rate"]); ?>"><?php echo (L("time_earnings")); ?> <?php echo ($vo["rate"]); ?>%</p>
                                    </li><?php endforeach; endif; else: echo "" ;endif; ?>

                            </ul>
                        </div>
                        <div class="amount">
                            <p class="invest_account"><?php echo (L("time_investment")); ?></p>
                            <div class="investMoney">
                                <ul>
                                    <li class="active"><span>$</span><span>100</span></li>
                                    <li><span>$</span><span>200</span></li>
                                    <li><span>$</span><span>500</span></li>
                                    <li><span>$</span><span>1000</span></li>
                                    <li><span>$</span><span>5000</span></li>
                                    <li><span>$</span><span>10000</span></li>
                                </ul>
                            </div>
                            <span class="otherMoney">
                                <input type="number" value="" placeholder="<?php echo (L("time_other")); ?>" onkeyup="inputOrderAmount(this)">
                            </span>
                            <div class="balanceFee">
                                <p><?php echo (L("time_balance")); ?>：$ <span><?php echo ((isset($account["balance"]) && ($account["balance"] !== ""))?($account["balance"]):'0.00'); ?></span></p>
                                <p><?php echo (L("time_poundage")); ?>： <span><?php echo ($option["fee_time"]); ?>%</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="confirmInfo">
                        <ul class="currencyInfo">
                            <li><span><?php echo (L("time_name")); ?></span><span><?php echo (L("time_direction")); ?></span><span><?php echo (L("time_price")); ?></span><span><?php echo (L("time_money")); ?></span></li>
                            <li><span class="currencyName"><?php echo ($option["capital_name"]); ?></span><span class="rise"></span><span class="red variety-price"><?php echo ($option["Price"]); ?></span><span class="money">$ 100</span></li>
                        </ul>
                        <div class="confirmBtn">
                            <span><?php echo (L("time_confirm_order")); ?></span>
                        </div>
                        <div class="expectEarning"><span><?php echo (L("earnings")); ?>：$</span> <span>180.00</span></div>
                    </div>
                </div>
            </div>
            <!--时间tab结束-->
            <!--<div class="content-box">-->
            <div data-v-6524b236="" class="content-wrap">
                    <div data-v-6524b236="" class="stock-wrap">
                        <!--<div class="touch-border" style="display: block;"></div>-->
                        <div id="stock-title" class="stock-title">
                            <div class="nav-wrap"><img
                                    src="/Public//Qts/Home/img/xiadan/img1.png"
                                    class="nav-img">
                                <ul id="stock" class="stock-tab clearfix">
                                    <li data="fenshi" class="nav-list has">Time</li>
                                    <li data="1m" class="nav-list">1M</li>
                                    <li data="5m" class="nav-list">5M</li>
                                    <li data="15m" class="nav-list">15M</li>
                                    <li data="30m" class="nav-list">30M</li>
                                    <li data="1h" class="nav-list">1H</li>
                                    <li data="4h" class="nav-list">4H</li>
                                    <li data="1d" class="nav-list">1D</li>
                                </ul>
                            </div>
                        </div>
                        <div id="priceMsg" class="stock-price" style="position: fixed;"><p>
                            <span>开0.00</span><span>收0.00</span><span>高0.00</span><span>低0.00</span><span></span></p></div>
                        <article class="article">
                            <iframe  id="nowtu" name='nowtu' style='width:100%;height:100%;border: 0;' src="<?php echo U('highcharts',array('code' => $option['capital_key'],'interval' => 'fenshi','type' => 'candlestick','height' =>350,'length' => $info['capital_length']));?>"></iframe>
                        </article>
                    </div>

                    <!-- 闪电下单 -->
                </div><!---->

            <div class="titles list_class" style="margin-bottom: .15rem;">
                <div data="1" style="font-size: .2rem;"><?php echo (L("simple")); ?><span></span></div>
                <div data="2" style="font-size: .2rem;"><?php echo (L("senior")); ?><span></span></div>
                <div data="3" style="font-size: .2rem;" class="tab_checked"><?php echo (L("time")); ?><span></span></div>
            </div>

            <div data-v-6524b236="" class="content-wrap">
                    <div data-v-6524b236="" class="stock-wrap">
                        <!--<div class="touch-border" style="display: block;"></div>-->
                        <!-- <div id="stock-title" class="stock-title">
                            <div class="nav-wrap"><img
                                    src="/Public//Qts/Home/img/xiadan/img1.png"
                                    class="nav-img">
                                <ul id="stock" class="stock-tab clearfix">
                                    <li data="1" class="nav-list has">1M</li>
                                    <li data="5" class="nav-list">5M</li>
                                    <li data="15" class="nav-list">15M</li>
                                    <li data="30" class="nav-list">30M</li>
                                    <li data="1h" class="nav-list">1H</li>
                                    <li data="4h" class="nav-list">4H</li>
                                    <li data="1d" class="nav-list">1D</li>
                                </ul>
                            </div>
                        </div>
                        <div id="priceMsg" class="stock-price" style="position: fixed;"><p>
                            <span>开0.00</span><span>收0.00</span><span>高0.00</span><span>低0.00</span><span></span></p></div>
                        <article class="article">
                            <iframe  id="nowtu" name='nowtu' style='width:100%;height:100%;border: 0;' src="<?php echo U('highcharts',array('code' => $option['capital_key'],'interval' => 1,'type' => 'candlestick','height' =>350,'length' => $info['capital_length']));?>"></iframe>
                        </article> -->
                    </div>

                    <!-- 闪电下单 -->
                    <div data-v-6524b236="" class="none top none">
                        <div data-v-6524b236="" class="trade-con quick-wrap">
                            <div data-v-6524b236="" class="list clearfix quick-w">
                                <div data-v-6524b236="">
                                    <span data-v-6524b236="" class="con-txt setting-txt"><?php echo (L("trading_hand")); ?></span>
                                    <img data-v-6524b236="" src="/Public//Qts/Home/img/xiadan/img2.png" class="yhq-bg" style="display: none;">
                                </div>
                                <div data-v-6524b236="" class="quick-w2 quick-w3">
                                    <div data-v-6524b236="" class="con-right number">
                                        <span data-v-6524b236="" class="quick-hand" onclick="number(this,'bond')">1</span>
                                        <span data-v-6524b236="" class="quick-hand active" onclick="number(this,'bond')">5</span>
                                        <span data-v-6524b236="" class="quick-hand" onclick="number(this,'bond')">10</span>
                                        <span data-v-6524b236="" class="quick-hand" onclick="number(this,'bond')">20</span>
                                        <span data-v-6524b236="" class="quick-hand lastSpan">
                                          <em data-v-6524b236="" class="icon-min" onclick="subtract(this,2,'bond')"></em>
                                          <input data-v-6524b236="" type="number" value="5.00" class="handnum hands" onkeyup="hands(this,'bond')" id="lightning_number" style="text-align: center">
                                          <em data-v-6524b236="" class="icon-add" onclick="subtract(this,1,'bond')"></em>
                                        </span>
                                    </div>
                                    <!--<div data-v-6524b236="" class="con-right taparea">-->
                                        <!--<em data-v-6524b236="" class="icon-min" onclick="subtract(this,2,'bond')"></em>-->
                                        <!--<input data-v-6524b236="" type="number" value="0.10" class="handnum hands" onkeyup="hands(this,'bond')" id="lightning_number">-->
                                        <!--<em data-v-6524b236="" class="icon-add" onclick="subtract(this,1,'bond')"></em>-->
                                    <!--</div>-->
                                </div>
                            </div>
                        </div>

                        <!-- 占用保证金 Start-->
                        <div data-v-6524b236="" class="trade-con quick-wrap">
                            <div data-v-6524b236="" class="list clearfix quick-w">
                                <span data-v-6524b236="" class="con-txt setting-txt"><?php echo (L("margin_occupancy")); ?></span>
                                <div data-v-6524b236="" class="quick-w2 quick-w3">
                                    <div data-v-6524b236="" class="con-right bond">
                                        <span data-v-6524b236="" class="quick-hand" onclick="bondActive(this,'bond','bondLever')">$0</span>
                                        <span data-v-6524b236="" class="quick-hand active" onclick="bondActive(this,'bond','bondLever')">$0</span>
                                        <span data-v-6524b236="" class="quick-hand" onclick="bondActive(this,'bond','bondLever')">$0</span>
                                    </div>
                                    <p data-v-6524b236="" class="margin clearfix "><?php echo (L("available_margin")); ?>
                                        <em data-v-6524b236="">$<?php echo ((isset($account["balance"]) && ($account["balance"] !== ""))?($account["balance"]):'--'); ?></em></p>
                                </div>
                            </div>
                        </div>
                        <!-- 占用保证金 End-->

                        <!-- 杠杆倍数 Start-->
                        <div data-v-6524b236="" class="trade-con quick-wrap">
                            <div data-v-6524b236="" class="list clearfix quick-w">
                                <span data-v-6524b236="" class="con-txt setting-txt"><?php echo (L("leverage")); ?></span>
                                <div data-v-6524b236="" class="quick-w2 quick-w3">
                                    <div data-v-6524b236="" class="con-right">
                                        <span data-v-6524b236="" class="quick-hand active" id="bondLever" style="height: 100%;border-radius: 30px;">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 杠杆倍数 End-->

                        <div data-v-6524b236="" class="btn-wrap" style="bottom: 0.2rem;">
                            <div data-v-6524b236="" class="right quick-btn">
                                <a data-v-6524b236="" href="javascript:;" class="con-btn txt_green"  data-ostyle="0" style="border-radius: 30px;">
                                    <p data-v-6524b236="" class="type"> <?php echo (L("buy")); if(($now_trade_status) == "2"): ?>（<?php echo (L("simulation")); ?>）<?php endif; ?></p>
                                    <p data-v-6524b236="" class="bidprice price"><?php echo ($option["sp"]); ?></p>
                                </a>
                                <span data-v-6524b236="" class="spread" style="position: absolute;left: 50%;line-height: 106px;margin-top: 0"><?php echo ($option["difference"]); ?></span>
                                <a data-v-6524b236="" href="javascript:;" class="con-btn txt_red" data-ostyle=1 style="border-radius: 30px;">
                                    <p data-v-6524b236="" class="type"><?php echo (L("sell")); if(($now_trade_status) == "2"): ?>（<?php echo (L("simulation")); ?>）<?php endif; ?></p>
                                    <p data-v-6524b236="" class="askprice price"><?php echo ($option["bp"]); ?></p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- 闪电下单 -->
                    <div data-v-6524b236="" class="none top buy-wrap">
                        <div data-v-6524b236="" class="trade-wrap">

                            <ul data-v-6524b236="" class="trade-title">
                                <li data-v-6524b236="" data="1" class="isSelected nav-list"><?php echo (L("market_price")); ?>
                                    <span data-v-6524b236="" data="2" class="border"></span></li>
                                <li data-v-6524b236="" class="nav-list"><?php echo (L("entrust")); ?>
                                    <span data-v-6524b236="" class=""></span></li>
                            </ul>

                            <!-- 市价 -->
                            <div data-v-6524b236="" class="trade-con">
                                <div data-v-6524b236="" class="list clearfix">
                                    <span data-v-6524b236="" class="con-txt setting-txt"><?php echo (L("direction")); ?></span>
                                    <div data-v-6524b236="" class="con-right right buy_wrap">
                                        <a data-v-6524b236="" href="javascript:;" class="con-btn txt_green" data-ostyle=0 style="border-radius: 30px;">
                                            <em data-v-6524b236=""><?php echo (L("buy")); ?></em>
                                            <b data-v-6524b236="" class="bidprice"><?php echo ($option["sp"]); ?></b>
                                        </a>
                                        <span data-v-6524b236="" class="spread"><?php echo ($option["difference"]); ?></span>
                                        <a data-v-6524b236="" href="javascript:;" class="con-btn txt_red buy_check" data-ostyle=1 style="border-radius: 30px;">
                                            <em data-v-6524b236=""><?php echo (L("sell")); ?></em>
                                            <b data-v-6524b236="" class="askprice"><?php echo ($option["bp"]); ?></b>
                                        </a>
                                    </div>
                                </div>

                                <div data-v-6524b236="" class="list clearfix">
                                    <div data-v-6524b236=""><span data-v-6524b236="" class="con-txt"><?php echo (L("trading_hand")); ?></span>
                                        <div data-v-6524b236="" class="con-right right taparea">
                                            <em data-v-6524b236="" class="icon-min minusBtn" onclick="subtract(this,2,'marketBond')"></em>
                                            <input data-v-6524b236="" type="number" value="0.10" class="handnum hands marketNumber" onkeyup="hands(this,'marketBond')">
                                            <em data-v-6524b236="" class="icon-add addBtn" onclick="subtract(this,1,'marketBond')"></em>
                                        </div>
                                    </div>
                                    <p data-v-6524b236="" class="right clearfix "><?php echo (L("margin_occupancy")); ?>
                                        <em data-v-6524b236="" class="marketOccupyBond">$0.00</em>
                                    </p>
                                </div>

                                <!-- 对应保证金 Start -->
                                <div data-v-6524b236="" class="list clearfix quick-w">
                                    <span data-v-6524b236="" class="con-txt"><?php echo (L("margin_occupancy")); ?></span>
                                    <div data-v-6524b236="" class="quick-w2">
                                        <div data-v-6524b236="" class="con-right marketBond">
                                            <span data-v-6524b236="" class="quick-hand" onclick="bondActive(this,'marketBond','marketBondLever')">$0</span>
                                            <span data-v-6524b236="" class="quick-hand active" onclick="bondActive(this,'marketBond','marketBondLever')">$0</span>
                                            <span data-v-6524b236="" class="quick-hand" onclick="bondActive(this,'marketBond','marketBondLever')">$0</span>
                                        </div>
                                        <p data-v-6524b236="" class="margin clearfix "><?php echo (L("available_margin")); ?>
                                            <em data-v-6524b236="">$<?php echo ((isset($account["balance"]) && ($account["balance"] !== ""))?($account["balance"]):'--'); ?></em>
                                        </p>
                                    </div>
                                </div>
                                <!-- 对应保证金 End -->

                                <!-- 对应杠杆 Start-->
                                <div data-v-6524b236="" class="list clearfix quick-w">
                                    <span data-v-6524b236="" class="con-txt"><?php echo (L("leverage")); ?></span>
                                    <div data-v-6524b236="" class="quick-w2">
                                        <div data-v-6524b236="" class="con-right">
                                            <span data-v-6524b236="" class="quick-hand active" id="marketBondLever" style="height: 100%;border-radius: 30px;">0</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- 对应杠杆 End-->

                                <div data-v-6524b236="" class="list clearfix marketLoss">
                                    <div data-v-6524b236="">
                                        <span data-v-6524b236="" class="con-txt"><?php echo (L("stop_loss")); ?></span>
                                        <div data-v-6524b236="" class="con-right right taparea">
                                            <em data-v-6524b236="" class="icon-min minusBtn" onclick="loss(this,2,1,1)"></em>
                                            <input data-v-6524b236="" type="number" value="0.1" class="handnum lossWinInput" onchange="targetMarket(this,'marketLoss',2)">
                                            <em data-v-6524b236="" class="icon-add addBtn" onclick="loss(this,1,1,1)"></em>
                                        </div>
                                    </div>
                                    <p data-v-6524b236="" class="right clearfix ">
                                        <span>≥</span>
                                        <em data-v-6524b236="">0.00</em>
                                        <?php echo (L("expected_losses")); ?> <em data-v-6524b236="">$0.00</em>
                                    </p>
                                </div>

                                <div data-v-6524b236="" class="list clearfix marketProfit" style="margin-bottom: .5rem">
                                    <div data-v-6524b236="">
                                        <span data-v-6524b236="" class="con-txt"><?php echo (L("target_profit")); ?></span>
                                        <div data-v-6524b236="" class="con-right right taparea">
                                            <em data-v-6524b236="" class="icon-min minusBtn" onclick="loss(this,2,2,1)"></em>
                                            <input data-v-6524b236="" type="number" value="0.1" class="handnum lossWinInput" onchange="targetMarket(this,'marketProfit',1)">
                                            <em data-v-6524b236="" class="icon-add addBtn" onclick="loss(this,1,2,1)"></em>
                                        </div>
                                    </div>
                                    <p data-v-6524b236="" class="right clearfix ">
                                        <span>≤</span>
                                        <em data-v-6524b236="">0.00</em>
                                        <?php echo (L("expected_profits")); ?> <em data-v-6524b236="">$0.00</em>
                                    </p>
                                </div>
                            </div>
                            <!-- 市价 -->

                            <div data-v-6524b236="" class="trade-con Marketguadan" style="display: none;margin-bottom: .5rem">
                                <ul data-v-6524b236="" class="putType-wrap">
                                    <li data-v-6524b236="" class="active" data-type=1 data-ostyle="1"><?php echo (L("sell_limit")); ?></li>
                                    <li data-v-6524b236="" class="" data-type=2 data-ostyle=0><?php echo (L("buy_limit")); ?></li>
                                    <li data-v-6524b236="" class="" data-type=3 data-ostyle=1><?php echo (L("break_sell")); ?></li>
                                    <li data-v-6524b236="" class="" data-type=4 data-ostyle=0><?php echo (L("break_buy")); ?></li>
                                </ul>

                                <div data-v-6524b236="" class="list clearfix">
                                    <div data-v-6524b236="">
                                        <span data-v-6524b236="" class="con-txt"><?php echo (L("guadan_entrust")); ?></span>
                                        <div data-v-6524b236="" class="con-right right taparea">
                                            <em data-v-6524b236="" class="icon-min minusBtn" onclick="onclickGuadanPrice(this,2);"></em>
                                            <input data-v-6524b236="" type="number" value="0.10" class="handnum hands">
                                            <em data-v-6524b236="" class="icon-add addBtn" onclick="onclickGuadanPrice(this,1);"></em>
                                        </div>
                                    </div>
                                    <p data-v-6524b236="" class="right clearfix "><?php echo (L("guadan_price")); ?><span>≥</span><em data-v-6524b236="">0.00</em></p>
                                </div>

                                <div data-v-6524b236="" class="list clearfix">
                                    <div data-v-6524b236="">
                                        <span data-v-6524b236="" class="con-txt"><?php echo (L("trading_hand")); ?></span>
                                        <div data-v-6524b236="" class="con-right right taparea">
                                            <em data-v-6524b236="" class="icon-min minusBtn" onclick="subtract(this,2,'guadanBond')"></em>
                                            <input data-v-6524b236="" type="number" value="0.1" class="handnum hands guadanNumber" onkeyup="hands(this,'guadanBond')">
                                            <em data-v-6524b236="" class="icon-add addBtn" onclick="subtract(this,1,'guadanBond')"></em>
                                        </div>
                                    </div>
                                    <p data-v-6524b236="" class="right clearfix "><?php echo (L("margin_occupancy")); ?>
                                        <em data-v-6524b236="">$--</em>
                                    </p>
                                </div>

                                <div data-v-6524b236="" class="list clearfix quick-w">
                                    <span data-v-6524b236="" class="con-txt"><?php echo (L("margin_occupancy")); ?></span>
                                    <div data-v-6524b236="" class="quick-w2">
                                        <div data-v-6524b236="" class="con-right guadanBond">
                                            <span data-v-6524b236="" class="quick-hand" onclick="bondActive(this,'guadanBond','guadanBondLever')">$0</span>
                                            <span data-v-6524b236="" class="quick-hand active" onclick="bondActive(this,'guadanBond','guadanBondLever')">$0</span>
                                            <span data-v-6524b236="" class="quick-hand" onclick="bondActive(this,'guadanBond','guadanBondLever')">$0</span>
                                        </div>
                                        <p data-v-6524b236="" class="margin clearfix "><?php echo (L("available_margin")); ?>
                                            <em data-v-6524b236="">$<?php echo ((isset($account["balance"]) && ($account["balance"] !== ""))?($account["balance"]):'--'); ?></em>
                                        </p>
                                    </div>
                                </div>

                                <div data-v-6524b236="" class="list clearfix quick-w">
                                    <span data-v-6524b236="" class="con-txt"><?php echo (L("leverage")); ?></span>
                                    <div data-v-6524b236="" class="quick-w2">
                                        <div data-v-6524b236="" class="con-right">
                                            <span data-v-6524b236="" class="quick-hand active" id="guadanBondLever">0</span>
                                        </div>
                                    </div>
                                </div>

                                <div data-v-6524b236="" class="list clearfix guadanLoss">
                                    <div data-v-6524b236="">
                                        <span data-v-6524b236="" class="con-txt"><?php echo (L("stop_loss")); ?></span>
                                        <div data-v-6524b236="" class="con-right right taparea">
                                            <em data-v-6524b236="" class="icon-min minusBtn" onclick="loss(this,2,1,2)"></em>
                                            <input  data-v-6524b236="" value="0.00" type="number" class="handnum lossWinInput" onchange="targetGuadan(this,'guadanLoss',2)">
                                            <em data-v-6524b236="" class="icon-add addBtn" onclick="loss(this,1,1,2)"></em>
                                        </div>
                                    </div>
                                    <p data-v-6524b236="" class="right clearfix ">
                                        <span>≥</span>
                                        <em data-v-6524b236="">0.00</em>
                                        <?php echo (L("expected_losses")); ?>
                                        <em data-v-6524b236="">$--</em>
                                    </p>
                                </div>

                                <div data-v-6524b236="" class="list clearfix guadanProfit">
                                    <div data-v-6524b236="">
                                        <span data-v-6524b236="" class="con-txt"><?php echo (L("target_profit")); ?></span>
                                        <div data-v-6524b236="" class="con-right right taparea">
                                            <em data-v-6524b236="" class="icon-min minusBtn" onclick="loss(this,2,2,2)"></em>
                                            <input data-v-6524b236="" value="0.00" type="number" class="handnum lossWinInput" onchange="targetGuadan(this,'guadanProfit',1)">
                                            <em data-v-6524b236="" class="icon-add addBtn" onclick="loss(this,1,2,2)"></em>
                                        </div>
                                    </div>
                                    <p data-v-6524b236="" class="right clearfix ">
                                        <span>≤</span>
                                        <em data-v-6524b236="">$--</em>
                                        <?php echo (L("expected_profits")); ?> <em data-v-6524b236="">$--</em>
                                    </p>
                                </div>

                                <div data-v-6524b236="" class="list clearfix">
                                    <div data-v-6524b236="">
                                        <span data-v-6524b236="" class="con-txt"><?php echo (L("guadan_end_time")); ?></span>
                                        <div data-v-6524b236="" data-year="" data-month="" data-date="" id="showDatePop" class="con-right right taparea">
                                            <input id="showDate" type="text" readonly="" name="input_date" placeholder="<?php echo (L("guadan_please_date")); ?>" />
                                            <em data-v-6524b236="" class="icon_date"></em>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div data-v-6524b236="" class="btn-wrap buy-wrap" style="bottom: 0.2rem;">
                            <button data-v-6524b236="" class="btn bg_blue marketPrice marketSubmit" style="border-radius: 30px;">
                                <?php if(($now_trade_status) == "2"): echo (L("market_price_sell")); ?>(<?php echo (L("simulation")); ?>)
                                    <?php else: ?>
                                    <?php echo (L("market_price_sell")); endif; ?>
                            </button>
                            <button data-v-6524b236="" class="btn bg_blue guadanSubmit" style="display: none" style="border-radius: 30px;">
                                <?php echo (L("guadan_confirm_trust")); ?>
                            </button>
                        </div>


                    </div>

                    <!--时间tab的内容开始-->
                    <div class="block top timeTabContent">
                        <div class="timeTabBtn">
                            <div class="">
                                <p class="sellOut border_green" data-ostyle="0" style="cursor: pointer;border-radius: 30px;background: #00cf8c;color: #ddd">
                                    <span class="type"><?php echo (L("buy")); if(($now_trade_status) == "2"): ?>（<?php echo (L("simulation")); ?>）<?php endif; ?></span>
                                    <span class="price bidprice"><?php echo ($option["sp"]); ?></span>
                                </p>
                                <span class="spread"><?php echo ($option["difference"]); ?></span>
                                <p class="sellOut border_red" data-ostyle="1" style="cursor: pointer;border-radius: 30px;background: #f64e43;color: #ddd">
                                    <span class="type"><?php echo (L("sell")); if(($now_trade_status) == "2"): ?>（<?php echo (L("simulation")); ?>）<?php endif; ?></span>
                                    <span class="price askprice"><?php echo ($option["bp"]); ?></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!--时间tab的内容结束-->
                    <div data-v-6524b236="" class="scroll-wrap swiper-container flow">
                        <div class="swiper-wrapper">
                            <?php if(is_array($dealMsg)): foreach($dealMsg as $key=>$vo): ?><div class="swiper-slide"><?php echo ($vo["time"]); ?> <span data-v-6524b236="" class="name-color"><?php echo ($vo["nickname"]); ?></span> <?php echo ($vo["ostyle"]); ?> <?php echo ($vo["option_name"]); ?>
                                </div><?php endforeach; endif; ?>
                        </div>
                    </div>
                </div><!---->
            <!--</div>-->
        </section>



        <div data-v-610295de="" data-v-6524b236="" class="zixuan">
            <div data-v-610295de="" class="zixuan-wrap">
                <ul data-v-610295de="" class="zixuan-content" >
                    <?php if(is_array($optionAll)): $i = 0; $__LIST__ = $optionAll;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['id'] != $option['id']): ?><a href="<?php echo U('details',array('id' => $vo['id']));?>">
                            <li data-v-610295de="" class="zixuan-list"><p data-v-610295de="" class="zixuan-name"><?php echo ($vo["capital_name"]); ?></p>
                                <p data-v-610295de="" class="zixuan-price capital_key <?php echo ($vo["capital_key"]); ?>" data-key="<?php echo ($vo["capital_key"]); ?>"><?php echo ($vo["price"]); ?></p></li>
                        </a><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
            <div data-v-610295de="" class="modal"></div>
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


<!--时间盘开始-->
<link href="/Public//Qts/Home/style.css" rel="stylesheet">
<link href="/Public//Qts/Home/ionic.css" rel="stylesheet">

<ion-view class="trade-view">
    
    <div class="order_mengban glass_masks" id="div2" style="">
        <div>
            <div>
                <div class="order-state-panel" style="display: block;width: 40%;margin-left: -20%;">
                    <div class="panel-header">
                        <div class="ng-binding goodstitle">--</div>
                    </div>
                    <div class="panel-body">
                        
                        <div class="paysuccess success">
                            <div class="circle_wrapper" >
                                <div class="right_circle">
                                    <img class="img_circle_right" style="-webkit-animation: run 10s linear; animation-fill-mode:forwards" src="/Public//Qts/Home/right_circle1.png">
                                </div>
                                <div class="left_circle">
                                    <img class="img_circle_lift" style="-webkit-animation: runaway 10s linear; animation-fill-mode:forwards" src="/Public//Qts/Home/left_circle1.png">
                                </div>
                            </div>
                            <div class="row remaining count_remaining" >
                                <div class="col">
                                    <div class="ng-binding pay_order_sen">0</div>
                                    <div><?php echo (L("time_price")); ?></div>
                                    <div class="ng-binding newprice">0.00</div>
                                </div>
                            </div>
                            <div class="row info_list">
                                <div class="col col-15 first_info">
                                    <p><?php echo (L("time_direction")); ?></p>
                                    <p class="ng-binding pay_order_type">--</p>
                                </div>
                                <div class="col col-30">
                                    <p><?php echo (L("time_money")); ?></p>
                                    <p class="ng-binding">$<span class="pay_order_price">0</span></p>
                                </div>
                                <div class="col col-30">
                                    <p><?php echo (L("strike_price")); ?></p>
                                    <p class="ng-binding pay_order_buypricee">0.00</p>
                                </div>
                                <div class="col col-25 last_info">
                                    <p><?php echo (L("forecast_result")); ?></p>
                                    <p class="ng-binding yuce">$0</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="wait ng-hide">
                            <div class="row">
                                <div class="col ng-binding">
                                    <!--<i class="ion-paper-airplane"></i>-->
                                    <?php echo (L("in_settlement")); ?>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="success ng-hide order_result">
                            <div class="row remaining finish_remaining">
                                <div class="col">
                                    <div class="result_profit ng-binding " style="">$0</div>
                                    <div class="expired_statements"><?php echo (L("close_complete")); ?></div>
                                </div>
                            </div>
                            <div class="row info_list">
                                <div class="col col-15 first_info">
                                    <p><?php echo (L("time_direction")); ?></p>
                                    <p class="ng-binding pay_order_type">--</p>
                                </div>
                                <div class="col col-30">
                                    <p><?php echo (L("time_money")); ?></p>
                                    <p class="ng-binding">$<span class="pay_order_price">0</span></p>
                                </div>
                                <div class="col col-30">
                                    <p><?php echo (L("strike_price")); ?></p>
                                    <p class="ng-binding pay_order_buypricee">0.00</p>
                                </div>
                                
                                <div class="col col-25 last_info">
                                    <p><?php echo (L("deal_price")); ?></p>
                                    <p class="ng-binding endprice" style="">0</p>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="row button_row">
                            <div class="col">
                                <button class="button" onclick="closeDjs()"><?php echo (L("continue_place_order")); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
</ion-view>


<!--时间盘结束-->

<script src="/Public//Qts/Home/js/jquery.js"></script>
<script typet="text/javascript" src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
<script src="/Public/Qts/Home/js/swiper.min.js"></script>
<script src="/Public//Qts/Home/js/lCalendar.min.js"></script>
<script src="/Public//Qts/Home/js/laydate/laydate.js"></script>

<script>

    var swiper2 = new Swiper('.swiper-container', {
        autoplay:true,
        direction: 'vertical'
    });

    //时间插件
    // var calendardatetime = new lCalendar();
    // calendardatetime.init({
    //     'trigger': '#showDate',
    //     'type': 'datetime'
    // },function () {
    //     $('html').setAttribute("style","overflow:hidden;height:100%;");
    //     $('body').setAttribute("style","overflow:hidden;height:100%;");
    // });
    //时间选择器
    laydate.render({
      elem: '#showDate'
      ,type: 'datetime'
    });

    $('.head_tab li').click(function(){
        if($(this).attr('data')==1){
            $(this).addClass('tab_checked').siblings().removeClass('tab_checked1').removeClass('tab_checked2');
            $('.content-wrap>div:nth-child(2)').show();
            $('.content-wrap>div:nth-child(3)').hide();
            $('.content-wrap>div:nth-child(4)').hide();
            $('.article').css('height','350px');
        }else if($(this).attr('data')==2){
            $(this).addClass('tab_checked1').siblings().removeClass('tab_checked').removeClass('tab_checked2');
            $('.content-wrap>div:nth-child(2)').hide();
            $('.content-wrap>div:nth-child(4)').hide();
            $('.content-wrap>div:nth-child(3)').show();
            $('.article').css('height','350px');
        }else {
            $(this).addClass('tab_checked2').siblings().removeClass('tab_checked').removeClass('tab_checked1');
            $('.content-wrap>div:nth-child(2)').hide();
            $('.content-wrap>div:nth-child(3)').hide();
            $('.content-wrap>div:nth-child(4)').show();
            $('.article').css('height','486px');
        }
        loadKline();
    });

    $('.titles>div').click(function(){
        if($(this).attr('data')==1){
            $(this).addClass('tab_checked').siblings().removeClass('tab_checked').removeClass('tab_checked');
            $('.content-wrap>div:nth-child(2)').show();
            $('.content-wrap>div:nth-child(3)').hide();
            $('.content-wrap>div:nth-child(4)').hide();
            $('.article').css('height','350px');
        }else if($(this).attr('data')==2){
            $(this).addClass('tab_checked').siblings().removeClass('tab_checked').removeClass('tab_checked');
            $('.content-wrap>div:nth-child(2)').hide();
            $('.content-wrap>div:nth-child(4)').hide();
            $('.content-wrap>div:nth-child(3)').show();
            $('.article').css('height','350px');
        }else {
            $(this).addClass('tab_checked').siblings().removeClass('tab_checked').removeClass('tab_checked');
            $('.content-wrap>div:nth-child(2)').hide();
            $('.content-wrap>div:nth-child(3)').hide();
            $('.content-wrap>div:nth-child(4)').show();
            $('.article').css('height','350px');
        }
        loadKline();
    });
    $('.stock-tab li').click(function () {
        $('.stock-tab li').removeClass('has');
        $(this).addClass('has');
        loadKline();
    });

    function loadKline()
    {
        var type = $('.head_tab .tab_checked2').attr('data');

        if(type != undefined) {
            var height = 450;
        } else {
            var height = 350;
        }

        var interval    = $('#stock .has').attr('data');
        var code        = "<?php echo ($option["capital_key"]); ?>";
        var type        = 'type';
        var length      = "<?php echo ($info["capital_length"]); ?>";
        var src         = '<?php echo U("highcharts");?>'+"?code="+code+"&interval="+interval+"&type="+type+"&height="+height+"&length="+length+"";
        $('#nowtu').attr('src',src);
    }


    $('.trade-title .nav-list').click(function () {
        $(this).addClass('isSelected').siblings().removeClass('isSelected');
        $(this).find('span').addClass('border');
        $(this).siblings().find('span').removeClass('border');
        if($(this).attr('data')==1){
            $('.btn-wrap button:first-child').show()
            $('.btn-wrap button:last-child').hide()
            $('.trade-wrap .trade-con:nth-child(2)').show();
            $('.trade-wrap .trade-con:nth-child(3)').hide();
        }else{
            $('.btn-wrap button:first-child').hide()
            $('.btn-wrap button:last-child').show()
            $('.trade-wrap .trade-con:nth-child(2)').hide();
            $('.trade-wrap .trade-con:nth-child(3)').show();
        }
    });

    $('.con-btn').click(function () {

        $("input[name='ostyle']").val($(this).attr('data-ostyle'));
        settingLoss();  //止盈止损

        var now_trade_status = "<?php echo ($now_trade_status); ?>";
        var html = now_trade_status == 2 ? '(<?php echo (L("simulation")); ?>)' : '';
        if($(this).hasClass('txt_green')){
            $(this).addClass('sell_check').siblings('.txt_red').removeClass('buy_check');
            $('.marketPrice').html('<?php echo (L("market_price_buy")); ?>'+html+'')
        }else{
            $(this).addClass('buy_check').siblings('.txt_green').removeClass('sell_check');
            $('.marketPrice').html('<?php echo (L("market_price_sell")); ?>'+html+'')
        }
    });

    //点击挂单
    $('.putType-wrap li').click(function(){
        $('.putType-wrap li').removeClass('active');
        $(this).addClass('active');
        guadanPrice();
        guadanSettingLoss()//止盈止损设置
    });

    $('.more-close').click(function(){
        $('.zixuan').show();
        $('html').css({"overflow":"hidden","height":"100%"});
        $('body').css({"overflow":"hidden","height":"100%"});
    });

    $('.modal').click(function(e){
        if(!$(e.target).hasClass('zixuan')){
            $('.zixuan').hide();
            $('html').css({"overflow":"auto","height":"auto"});
            $('body').css({"overflow":"auto","height":"auto"});
        }
    });
    // $('#showDate').click(function () {
    //     $('.lcalendar_cancel').html('<?php echo (L("cancel")); ?>');
    //     $('.lcalendar_finish').html('<?php echo (L("determine")); ?>');
    //     $('.date_yy').next('div').find('div').html('<?php echo (L("year")); ?>');
    //     $('.date_mm').next('div').find('div').html('<?php echo (L("month")); ?>');
    //     $('.date_dd').next('div').find('div').html('<?php echo (L("day")); ?>');
    //     $('.time_hh').next('div').find('div').html('<?php echo (L("hour")); ?>');
    //     $('.time_mm').next('div').find('div').html('<?php echo (L("minute")); ?>');
    //     $('html').css({"overflow":"hidden","height":"100%"});
    //     $('body').css({"overflow":"hidden","height":"100%"});
    // });

</script>
</body>
</html>


<!-- 闪电下单 -->

<script type="text/javascript">

    /**
     * [number 交易手数选取状态]
     * @param  {[object]} obj       [当前DOM对象]
     * @param  {[string]} className [类名称]
     * @author wang 990529346@qq.com
     */
    function number(obj,className)
    {
        $(obj).addClass('active').siblings().removeClass('active');
        var val = parseFloat($(obj).html());
        $(obj).siblings().find('input').val(val);
        bondFormula(parseFloat(val).toFixed(2),className);
    }


    /**
     * [bondActive 保证金选取状态]
     * @param  {[object]} obj [当前DOM对象]
     * @param  {[strting]} className [对应保证金类名称]
     * @param  {[strting]} idName [对应杠杆id名称]
     * @author wang 990529346@qq.com
     */
    function bondActive(obj,className,idName)
    {
        $(obj).addClass('active').siblings().removeClass('active');

        marketOccupy(); //市价设置需使用保证金
       // settingLoss();  //市价设置止盈止损

       // guadanSettingLoss(); //挂单设置止盈止损

        //显示对应杠杆倍数 (针对全部类型)
        showLever(className,idName);

    }


    /**
     * [subtract 下单数量加减]
     * @param  {[object]} obj       [当前DOM对象]
     * @param  {[Number]}    type      [加减类型 1加 2减]
     * @param  {[string]} className [类名称]
     * @author wang 990529346@qq.com
     */
    function subtract(obj,type,className)
    {
        var val=parseFloat($(obj).siblings('input').val());

        if(type == 1)
        {
            if(val < 0.1)
                var step = 0.01;
            else
                var step = 0.1;

            if(val<10000)
                val+=step;
        } else {

            if(val <= 0.1)
                var step = 0.01;
            else
                var step = 0.1

            if(val>0.01)
                val-=step;
        }

        $(obj).siblings('input').val(val.toFixed(2));

        bondFormula(parseFloat(val).toFixed(2),className);

        marketOccupy(); //设置市价需使用保证金
        settingLoss(2);  //设置市价止盈止损

        guadanSettingLoss(2);
    }


    /**
     * [hands 检测输入的手数]
     * @param  {[object]} obj       [当前DOM对象]
     * @param  {[string]} className [类名称]
     * @author wang 990529346@qq.com
     */
    function hands(obj,className)
    {
        var val = $(obj).val().replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3'); //只能输入两个小数

        $(obj).val(val);

        if(val < 0)
        {
            $(obj).val(0.01);
            val  = 0.01;
        } else if(val == '')
        {
            val = 0;
        } else if(val > 10000) {
            $(obj).val(10000);
            val = 10000;
        }
        bondFormula(parseFloat(val).toFixed(2),className);
    }


    /**
     * [bondFormula 计算保证金]
     * @param  {[Number]}    val          [计算的数值]
     * @param  {[string]} className       [赋值类名称]
     * @param  {[string]} idName          [对应杠杆赋值类名称]
     * @authro wang 990529346@qq.com
     */
    function bondFormula(val,className,idName)
    {
        var contract        = "<?php echo ($info["contract_number"]); ?>";    //原始合约数量
        var numberContract  = (contract * val);             //根据原始合约数量计算 当前合约数量
        var bond            = "<?php echo ($info["bond"]); ?>";               //最高杠杆倍数

        // alert(numberContract);

        var firstBond       = (numberContract / bond).toFixed(2);
        var secondBond      = (firstBond * 2).toFixed(2);
        var lastBond        = (secondBond * 2).toFixed(2);
        $('.'+className+' span').first().html('$'+firstBond);
        $('.'+className+' span').eq(1).html('$'+secondBond);
        $('.'+className+' span').last().html('$'+lastBond);

        //杠杆倍数
        showLever(className,idName);
    }


    /**
     * showLever 显示对应杠杆倍数
     * @param  {[type]} className [保证金赋值类名称]
     * @param  {[type]} idName    [对应杠杆赋值类名称]
     */
    function showLever(className,idName)
    {
        var bond            = "<?php echo ($info["bond"]); ?>";               //最高杠杆倍数
        var index = $('.'+className+' .active').index();
        if(index == 0)
        {
            $('#'+idName+'').html(bond);
        } else if(index == 1)
        {
            $('#'+idName+'').html(bond/2);
        } else {
            $('#'+idName+'').html((bond/2)/2);
        }
    }


    /**
     * [loss 点击止损止盈]
     * @param  {[object]}     obj       [单钱DOM对象]
     * @param  {[Number]} 	type      [1加 2减]
     * @param  {[Number]} 	stop_type [1止损 2止盈]
     * @return {[Number]} 	play_type [玩法类型 1市价 2挂单]
     */
    function loss(obj,type,stop_type,play_type)
    {
        var val     = parseFloat($(obj).siblings('input').val());

        var length              = "<?php echo ($info["capital_length"]); ?>";
        var capital_dot_length  = "<?php echo ($option["capital_dot_length"]); ?>";
        var wave                = "<?php echo ($option["wave"]); ?>";

        if(play_type == 1){
            var marketBond     = $('.marketBond > .active').html().replace(/[^\d.]/g,'');
            var ostyle         = $("input[name=ostyle]").val();
            var bp             = $('.bidprice').html();         //买入
            var sp             = $('.askprice').html();         //卖出
            var number         = $('.marketNumber').val().replace(/[^\d.]/g,'');
            wave = wave * number;
        } else {
            var marketBond     = $('.guadanBond > .active').html().replace(/[^\d.]/g,'');
            var ostyle         = $('.putType-wrap > .active').attr('data-ostyle'); //买入方向 0涨 1跌
            var bp 			   = $('.Marketguadan > div').first().find('div > input').val();
            var sp 			   = $('.Marketguadan > div').first().find('div > input').val();
            var number         = $('.guadanNumber').val().replace(/[^\d.]/g,'');
            wave = wave * number;
        }

        var point = (marketBond / wave) / capital_dot_length;

        if(stop_type == 1)  //如果为卖出
        {   //如果买涨
            if(ostyle == 0)
            {
                var order_type  = 1;
                var price       = bp;
            } else {
                var order_type  = 2;
                var price       = sp;
            }
        } else {    //如果为买入
            if(ostyle == 0)
            {
                var order_type  = 2;
                var price       = bp;
            } else {
                var order_type  = 1;
                var price       = sp;
            }
        }

        arr    = profitFormula(price,point,length,val,type,order_type);
        val    = arr.val;
        price  = arr.price;

        $(obj).siblings('input').val(val.toFixed(length));
        //预计亏损
        var ploss = Math.abs((val - price) * wave * capital_dot_length);
        $(obj).parent('div').parent('div').parent('div').find('p > em').last().html('$'+ploss.toFixed(2));
    }

    /**
     * [profitFormula 判断当前点位是否已经超过预期值]
     * @param  {[float]} 	bp         [买入价]
     * @param  {[float]} 	sp         [卖出价]
     * @param  {[float]} 	point      [根据保证金计算出的点位]
     * @param  {[Number]} length     [价格小数位数]
     * @param  {[float]} 	val        [当前点位]
     * @param  {[Number]} type       [1加 2减]
     * @param  {[Number]} order_type [1止损 2止盈]
     * @author wang 990529346@qq.com
     */
    function profitFormula(price,point,length,val,type,order_type)
    {
        var numberArr 	= lengthToNumber(1);
        var num 		= parseFloat(numberArr[length]);

        if(order_type == 1)
        {
            var price 		= parseFloat(price).toFixed(length);
            var loss 		= (parseFloat(price) - parseFloat(point)).toFixed(length);
            var upperLimit  = parseFloat(price)-parseFloat(lengthToNumber(6)[length]);//止损上限6个点位
            var lowerLimit  = num;   //止损下限点位 0.00001

            if(type ==1)
            {
                if(val < price)
                    val+=num;
            } else {
                if(val>lowerLimit)
                    val-=num;
            }
        } else {
            var price       = parseFloat(price).toFixed(length);
            var loss 		= (parseFloat(price) + parseFloat(point)).toFixed(length);
            var upperLimit  = 999999;   //止盈上限点位
            var lowerLimit  = parseFloat(price)+parseFloat(lengthToNumber(6)[length]);//止盈下限6个点位

            if(type ==1)    //如果买入并且止盈不设上限
            {
                if(val < upperLimit)
                    val+=num;
            } else {
                if(val>price)
                    val-=num;
            }
        }
        arr = {};
        arr['val'] 		= val;
        arr['price']	= price;

        return arr;
    }


    /**
     * [lengthToNumber 数字位数转换小说之]
     * @param  {[Number]} num [数字位数]
     * @author wang 990529346@qq.com
     */
    function lengthToNumber(num)
    {
        var numberArr = {};
        numberArr[0] = num;
        numberArr[1] = '0.'+num;
        numberArr[2] = '0.0'+num;
        numberArr[3] = '0.00'+num;
        numberArr[4] = '0.000'+num;
        numberArr[5] = '0.0000'+num;
        numberArr[6] = '0.00000'+num;
        numberArr[7] = '0.000000'+num;
        return numberArr;
    }


    /**
     * [settingloss 止盈止损设置(市价)]
     * @param {Number} [type] [如果type为1则自动加载市价止盈止损信息]
     * @author wang 990529346@qq.com
     */
    function settingLoss(type = 1)
    {

        var ostyle = $("input[name=ostyle]").val();   //商品类型 0买入 1卖出

        var length              = "<?php echo ($info["capital_length"]); ?>";       //数据长度
        var capital_dot_length  = "<?php echo ($option["capital_dot_length"]); ?>"; //计算盈亏必需品
        var wave                = "<?php echo ($option["wave"]); ?>";               //每点波动金额

        var number              = $('.marketNumber').val().replace(/[^\d.]/g,''); //当前手数
       // var marketBond          = $('.marketBond > .active').html().replace(/[^\d.]/g,'') / 2;  // 保证金 默认赢一半，输一半

        var bp = parseFloat($('.bidprice').html()).toFixed(length); //买入
        var sp = parseFloat($('.askprice').html()).toFixed(length); //卖出

        wave = wave * number;     //根据选择的手数计算出每点波动的金额

        //var point = (marketBond / wave) / capital_dot_length; //已盈亏公式计算出的点位

        var point = "<?php echo ($option["defaultPoint"]); ?>";

        var ploss = (point * wave * capital_dot_length).toFixed(2);        //得到的盈亏


        if(ostyle == 0)
        {
            var plusLoss      = (parseFloat(bp) - parseFloat(point)).toFixed(length);
            var plusSymbol    = '≤';    //止损

            var reduceLoss    = (parseFloat(bp) + parseFloat(point)).toFixed(length);
            var reduceSymbol  = '≥';    //止盈

            var price         = bp; //当前点位
        } else {
            var plusLoss      = (parseFloat(sp) + parseFloat(point)).toFixed(length);
            var plusSymbol    = '≥';    //止损

            var reduceLoss    = (parseFloat(sp) - parseFloat(point)).toFixed(length);
            var reduceSymbol  = '≤';    //止盈

            var price         = sp; //当前点位
        }


        //止损
        if(type == 1) {
            $('.marketLoss > div > div > input').val(plusLoss); //亏损点位
            $('.marketLoss > p > em').last().html('$'+ploss);   //预计亏损
        } else if(type == 2) {

            /**************************************/
            var val = $('.marketLoss > div > div > input').val();   //当前亏损点位

            //如果焦点存在则不处理
            var isFocus=$('.marketLoss > div > div > input').is(":focus");

            if(ostyle == 0)
            {
                if(val > price)
                {
                    if(isFocus != true)
                        $('.marketLoss > div > div > input').val(plusLoss);

                    ploss = (price - plusLoss) * wave * capital_dot_length;
                } else {
                    ploss = (price - val) * wave * capital_dot_length;
                }

            } else {

                if(val < price)
                {
                    if(isFocus != true)
                        $('.marketLoss > div > div > input').val(plusLoss);

                    ploss = (plusLoss - price) * wave * capital_dot_length;
                } else {
                    ploss = (val - price) * wave * capital_dot_length;
                }
            }
            $('.marketLoss > p > em').last().html('$'+ploss.toFixed(2));
            /**************************************/
        }

        $('.marketLoss > p > em').first().html(price);
        $('.marketLoss > p > span').html(plusSymbol);


        //止盈
        if(type == 1)
        {
            $('.marketProfit > div > div > input').val(reduceLoss);
            $('.marketProfit > p > em').last().html('$'+ploss);
        } else if(type == 2)
        {
            /**************************************/
            var val = $('.marketProfit > div > div > input').val();

            //如果焦点存在则不处理
            var marketIsFocus = $('.marketProfit > div > div > input').is(":focus");

            if(ostyle == 0)
            {

                if(val < price)
                {
                    if(marketIsFocus != true)
                        $('.marketProfit > div > div > input').val(reduceLoss);

                    ploss = (reduceLoss - price) * wave * capital_dot_length;
                } else {
                    ploss = (val - price) * wave * capital_dot_length;
                }
            } else {
                if(val > price) {
                    if(marketIsFocus != true)
                        $('.marketProfit > div > div > input').val(reduceLoss);

                    ploss = (price - reduceLoss) * wave * capital_dot_length;
                } else {
                    ploss = (price - val) * wave * capital_dot_length;
                }
            }

            $('.marketProfit > p > em').last().html('$'+ploss.toFixed(2));

            /**************************************/
        }

        $('.marketProfit > p > em').first().html(price);
        $('.marketProfit > p > span').html(reduceSymbol);

    }


    /**
     * [marketOccupy 占用保证金金额]
     * @author wang 990529346@qq.com
     */
    function marketOccupy()
    {
        //市价占用保证金
        $('.marketOccupyBond').html('$'+$('.marketBond > .active').html().replace(/[^\d.]/g,''));

        //挂单占用保证金
        var GuadanBond = $('.Marketguadan > div').eq(2).find('div > div > .active').html();
        $('.Marketguadan > div').eq(1).find('p > em').html(GuadanBond);
    }


    /**
     * [onload 页面初始化加载]
     * @author wang 990529346@qq.com
     */
    window.onload=function()
    {
        //闪电下单自动加载
        var val   = $('.number > .active').html().replace(/[^\d.]/g,'');
        bondFormula(val,'bond','bondLever');

        //市价自动加载
        var marketVal   = $('.marketNumber').val().replace(/[^\d.]/g,'');
        bondFormula(marketVal,'marketBond','marketBondLever');
        settingLoss();//止盈止损自动加载

        //挂单自动加载
        var guadanVal   = $('.guadanNumber').val().replace(/[^\d.]/g,'');
        bondFormula(guadanVal,'guadanBond','guadanBondLever');
        guadanPrice();
        guadanSettingLoss();

        marketOccupy(); //占用保证金金额

        estimateProfit();   //计算时间盘 预期收益
        var width   = "<?php echo ($parameterCount); ?>";  //自动计算时间盘宽度
        width       = (width*115);
        $('.end_time_list').css('width',''+width+'px');
    }
</script>

<!-- 挂单 Start-->
<script type="text/javascript">

    /**
     * [guadanPrice 自动加载挂单价格]
     * @param  {Number} order_type [如果为1 表示初始自动加载挂单信息]
     * @author wang 990529346@qq.com
     */
    function guadanPrice(order_type=1)
    {
        //type 限价卖出：1，限价买入：2，突破卖出：3，突破买入：4
        var type    = $('.putType-wrap > .active').attr('data-type');
        var bp      = $('.bidprice').html(); //买入
        var sp      = $('.askprice').html(); //卖出

        var length  = "<?php echo ($info["capital_length"]); ?>";

        if(order_type == 1)
        {
            if(type == 1)
            {
                var symbol  = '≥';
                var price   = parseFloat(sp).toFixed(length);
            } else if(type == 2)
            {
                var symbol  = '≤';
                var price   = parseFloat(bp).toFixed(length);
            } else if(type == 3)
            {
                var symbol  = '≤';
                var price   = parseFloat(sp).toFixed(length);
            } else if(type == 4)
            {
                var symbol  = '≥';
                var price   = parseFloat(bp).toFixed(length);
            }
            $('.Marketguadan > div').first().find('div > div > input').val(price);
            $('.Marketguadan > div').first().find('p > em').html(price);
        } else {
            var val 	= $('.Marketguadan > div').first().find('div > div > input').val();
            if(type == 1)
            {
                var symbol  = '≥';
                var price   = parseFloat(sp).toFixed(length);
                if(val < price)
                    var status = 1;
            } else if(type == 2)
            {
                var symbol  = '≤';
                var price   = parseFloat(bp).toFixed(length);
                if(val > price)
                    var status = 1;
            } else if(type == 3)
            {
                var symbol  = '≤';
                var price   = parseFloat(sp).toFixed(length);
                if(val > price)
                    var status = 1;
            } else if(type == 4)
            {
                var symbol  = '≥';
                var price   = parseFloat(bp).toFixed(length);
                if(val < price)
                    var status = 1;
            }

            if(status == 1)
            {
                $('.Marketguadan > div').first().find('div > div > input').val(price);
            }
            $('.Marketguadan > div').first().find('p > em').html(price);
        }

        $('.Marketguadan > div').first().find('p > span').html(symbol);
    }


    /**
     * [onclickGuadanPrice 增加或减少挂单价格]
     * @param  {[object]} 	obj        [当前DOM对象]
     * @param  {[int]} 		click_type [1加 2减]
     * @author wang 990529346@qq.com
     */
    function onclickGuadanPrice(obj,click_type)
    {
        //type 限价卖出：1，限价买入：2，突破卖出：3，突破买入：4
        var val     = parseFloat($(obj).siblings('input').val());
        var price   = $('.Marketguadan > div').first().find('p > em').html();
        var type    = $('.putType-wrap > .active').attr('data-type');

        var length      = "<?php echo ($info["capital_length"]); ?>";

        var numberArr   = lengthToNumber(1);
        var num         = parseFloat(numberArr[length]);

        if(click_type == 1)
        {
            if(type == 2 || type == 3)
            {
                if(val < price)
                    val+=num;
            } else {
                val+=num;
            }
        } else {
            if(type == 1 || type == 4)
            {
                if(val > price)
                    val-=num;
            } else {
                val-=num;
            }
        }

        $(obj).siblings('input').val(val.toFixed(length));

        guadanSettingLoss(2);
    }



    /**
     * [guadanSettingLoss 止盈止损设置(挂单信息)]
     * @param {int} [type] [如果为1表示按初始加载方法]
     * @author wang 990529346@qq.com
     */
    function guadanSettingLoss(type = 1)
    {
        var ostyle  = $('.putType-wrap > .active').attr('data-ostyle'); //买入方向 0涨 1跌

        var length              = "<?php echo ($info["capital_length"]); ?>";
        var capital_dot_length  = "<?php echo ($option["capital_dot_length"]); ?>";
        var wave                = "<?php echo ($option["wave"]); ?>";
      //  var guadanBond          = $('.guadanBond > .active').html().replace(/[^\d.]/g,'') / 2;
        var number              = $('.guadanNumber').val().replace(/[^\d.]/g,'');

        wave = number * wave;

        //var point = (guadanBond / wave) / capital_dot_length;

        var point = "<?php echo ($option["defaultPoint"]); ?>";   //默认点差50

        var ploss = (point * wave * capital_dot_length).toFixed(2);

        /*****************************/
        var p = $('.Marketguadan > div').first().find('div > input').val();
        /*****************************/

        if(ostyle == 0)
        {
            var plusLoss      = (parseFloat(p) - parseFloat(point)).toFixed(length);
            var plusSymbol    = '≤';

            var reduceLoss    = (parseFloat(p) + parseFloat(point)).toFixed(length);
            var reduceSymbol  = '≥';

        } else {
            var plusLoss      = (parseFloat(p) + parseFloat(point)).toFixed(length);
            var plusSymbol    = '≥';

            var reduceLoss    = (parseFloat(p) - parseFloat(point)).toFixed(length);
            var reduceSymbol  = '≤';
        }

        var price         = parseFloat(p).toFixed(length);

        //止损
        if(type == 1)
        {
            $('.guadanLoss > div > div > input').val(plusLoss);
            $('.guadanLoss > p > em').last().html('$'+ploss);
        } else if(type == 2)
        {
            /**************************************/
            var val = $('.guadanLoss > div > div > input').val();   //当前亏损点位

            //如果焦点存在则不处理
            var isFocus=$('.guadanLoss > div > div > input').is(":focus");

            if(ostyle == 0)
            {
                if(val > price)
                {
                    if(isFocus != true)
                        $('.guadanLoss > div > div > input').val(plusLoss);

                    ploss = (price - plusLoss) * wave * capital_dot_length;
                } else {
                    ploss = (price - val) * wave * capital_dot_length;
                }
            } else {
                if(val < price)
                {
                    if(isFocus != true)
                        $('.guadanLoss > div > div > input').val(plusLoss);

                    ploss = (plusLoss - price) * wave * capital_dot_length;
                } else {
                    ploss = (val - price) * wave * capital_dot_length;
                }
            }
            $('.guadanLoss > p > em').last().html('$'+ploss.toFixed(2));
            /**************************************/
        }
        $('.guadanLoss > p > em').first().html(price);
        $('.guadanLoss > p > span').html(plusSymbol);


        //止盈
        if(type == 1)
        {
            $('.guadanProfit > div > div > input').val(reduceLoss);
            $('.guadanProfit > p > em').last().html('$'+ploss);
        } else if(type == 2)
        {
            /**************************************/
            var val = $('.guadanProfit > div > div > input').val();

            //如果焦点存在则不处理
            var marketIsFocus = $('.guadanProfit > div > div > input').is(":focus");

            if(ostyle == 0)
            {
                if(val < price)
                {
                    if(marketIsFocus != true)
                        $('.guadanProfit > div > div > input').val(reduceLoss);

                    ploss = (reduceLoss - price) * wave * capital_dot_length;
                } else {
                    ploss = (val - price) * wave * capital_dot_length;
                }
            } else {
                if(val > price)
                {
                    if(marketIsFocus != true)
                        $('.guadanProfit > div > div > input').val(reduceLoss);

                    ploss = (price - reduceLoss) * wave * capital_dot_length;
                } else{
                    ploss = (price - val) * wave * capital_dot_length;
                }
            }
            $('.guadanProfit > p > em').last().html('$'+ploss.toFixed(2));
            /**************************************/
        }
        $('.guadanProfit > p > em').first().html(price);
        $('.guadanProfit > p > span').html(reduceSymbol);
    }


    /**
     * 手动输入市价止盈止损
     * @param  {[object]} obj       当前dom对象
     * @param  {[string]} className 类名称
     * @param  {[int]}    stop      止盈止损 1止盈 2止损
     */
    function targetMarket(obj,className,stop)
    {
        var minPrice    = parseFloat($('.'+className+' > p > em').html());      //最小价格
        var maxPrice    = parseFloat($('.'+className+' > p > em').html());   //最大价格
        var val         = parseFloat($(obj).val());         //当前止盈止损点位
        var ostyle      = $("input[name=ostyle]").val();    //买入方向 0涨 1跌
        var length      = "<?php echo ($info["capital_length"]); ?>";         //当前小数点位长度

        minPrice        = parseFloat(minPrice).toFixed(length);
        maxPrice        = parseFloat(maxPrice).toFixed(length);

        var point       = "<?php echo ($option["defaultPoint"]); ?>";   //大于或小于50个点位

        var upperLimit  = 999999;   //止盈上限点位
        var loperLimit  = 0;

        if(ostyle == 1)
        {
            if(stop == 2)
            {
                if(val < minPrice || val > upperLimit || isNaN(val))
                    $(obj).val(minPrice+point);
            } else {
                if(val > maxPrice || val <= loperLimit || isNaN(val))
                    $(obj).val(maxPrice-point);
            }
        } else {
            if(stop == 2)
            {
                if(val > minPrice || val <= loperLimit || isNaN(val))
                    $(obj).val(minPrice-point);
            } else {
                if(val < maxPrice || val > upperLimit || isNaN(val))
                    $(obj).val(maxPrice-point);
            }
        }

        settingLoss(2);
    }


    /**
     * 手动输入挂单止盈止损
     * @param  {[object]} obj       当前dom对象
     * @param  {[string]} className 类名称
     * @param  {[int]}    stop      止盈止损 1止盈 2止损
     */
    function targetGuadan(obj,className,stop)
    {
        var minPrice    = parseFloat($('.'+className+' > p > em').html());      //最小价格
        var maxPrice    = parseFloat($('.'+className+' > p > em').html());      //最大价格
        var val         = parseFloat($(obj).val());
        var ostyle      = $('.Marketguadan ul .active').attr('data-ostyle');    //买入方向 0涨 1跌;
        var length      = "<?php echo ($info["capital_length"]); ?>"; //当前小数点位长度

        minPrice        = parseFloat(minPrice).toFixed(length);
        maxPrice        = parseFloat(maxPrice).toFixed(length);

        var point       = "<?php echo ($option["defaultPoint"]); ?>";   //大于或小于50个点位

        var upperLimit  = 999999;   //止盈上限点位
        var loperLimit  = 0;

        //如果当前价格小于最小止盈
        if(ostyle == 1)
        {
            if(stop == 2)
            {
                if(val < minPrice || val > upperLimit || isNaN(val))
                    $(obj).val(minPrice+point);
            } else {
                if(val > maxPrice || val <= loperLimit || isNaN(val))
                    $(obj).val(maxPrice-point);
            }
        } else {
            if(stop == 2)
            {
                if(val > minPrice || val <= loperLimit || isNaN(val))
                    $(obj).val(minPrice-point);
            } else {
                if(val < maxPrice || val > upperLimit || isNaN(val))
                    $(obj).val(maxPrice+point);
            }
        }

        guadanSettingLoss(2);
    }


</script>
<!-- 挂单 End-->

<script type="text/javascript" src="/Public//Home/css/layer/layer.js"></script>
<script type="text/javascript">
    /**
     * websocket 传输数据
     */
    var arrString = "<?php echo ($option["capital_key"]); ?>";
    var option_key = "<?php echo ($option["option_key"]); ?>";

    // ws = new WebSocket("ws://47.244.175.58:2346");
    ws = new WebSocket("ws://39.107.99.235:8026");
    ws.onopen = function() {
        ws.send('tom');
    };
    ws.onmessage = function(e) {

        var data = eval("("+e.data+")");
        var type = data.type || '';
        switch(type){
            case 'init':
                $.post('<?php echo U("Bind/binding");?>', {client_id: data.client_id,group:arrString,option_key:option_key}, function(data){}, 'json');
                break;
            default :
                // console.log(e.data);
                var data      = JSON.parse(e.data);
                var length    = "<?php echo ($info["capital_length"]); ?>";

                price       = data.Price.toFixed(length);
                diff        = data.Diff < 0 ? ''+data.Diff+'' : '+'+data.Diff+'';
                diffrate    = data.DiffRate < 0 ? ''+data.DiffRate+'%' : '+'+data.DiffRate+'%';
                sp          = parseFloat(data.sp).toFixed(length);
                bp          = parseFloat(data.bp).toFixed(length);

                spread      = parseFloat(data.erence).toFixed(1); //点差

                try{
                    frames['nowtu'].updateData1M(price);
                }catch(e){
                }


                $('.variety-price').html(price);
                $('.price-value').html(diff);
                $('.price-rate').html(diffrate);
                $('.askprice').html(bp);
                $('.bidprice').html(sp);
                $('.spread').html(spread);

                settingLoss(2); 		//市价止盈止损
                guadanPrice(2);			//挂单价格
                guadanSettingLoss(2);	//挂单止盈止损
        }
    };

    //关注产品点位实时刷新
    var arr = [];
    $.each($('.capital_key'),function(){
        var key = $(this).attr('data-key');
        arr.push(key);
    });
    var arrKey = arr.join(',');

    // wss = new WebSocket("ws://47.244.175.58:2346");
    wss = new WebSocket("ws://39.107.99.235:8026");
    wss.onmessage = function(e) {

        var data = eval("("+e.data+")");
        var type = data.type || '';
        switch(type){
            case 'init':
                $.post('<?php echo U("Bind/binding");?>', {client_id: data.client_id,group:arrKey}, function(data){}, 'json');
                break;
            default :
                var data        = JSON.parse(e.data);
                price           = parseFloat(data.Price);

                $('.'+data.capital_key+'').html(price);
        }
    };



    //闪电下单
    $('.quick-btn a').click(function(){

        var pid     = "<?php echo ($option["id"]); ?>";                           //下单产品

        var ostyle  = $(this).attr('data-ostyle');              //下单方向 0涨 1跌

        var number  = $('#lightning_number').val();             //下单手数

        var bond    = $('.bond > .active').html().replace(/[^\d.]/g,''); //下单保证金

        var index = layer.load(2); //加载中

        $.ajax({
            url: "<?php echo U('Transaction/trade');?>",
            dataType: "json",
            type:"post",
            data: {'pid':pid,'ostyle':ostyle,'number':number,'bond':bond},
            success: function(data){
                layer.msg(data.msg);
                if(data.code == 200)
                {
                    layer.close(index);
                    return setTimeout("window.location.href='<?php echo U('Position/trade');?>';",500);
                } else {
                    return layer.close(index);
                }
            },
        });
    });

    //市价下单
    $('.marketSubmit').click(function(){

        var pid         = "<?php echo ($option["id"]); ?>";                       //下单产品

        var ostyle      = $("input[name=ostyle]").val();        //买入方向 0涨 1跌

        var number      = $('.marketNumber').val();             //下单手数

        var bond        = $('.marketBond > .active').html().replace(/[^\d.]/g,''); //下单保证金

        var endprofit   = $('.marketProfit > div > div > input').val();     //止盈点位

        var endloss     = $('.marketLoss > div > div > input').val();       //止损点位

        var index = layer.load(2); //加载中

        $.ajax({
            url: "<?php echo U('Transaction/trade');?>",
            dataType: "json",
            type:"post",
            data: {'pid':pid,'ostyle':ostyle,'number':number,'bond':bond,'endprofit':endprofit,'endloss':endloss},
            success: function(data){
                layer.msg(data.msg);
                if(data.code == 200)
                {
                    layer.close(index);
                    return setTimeout("window.location.href='<?php echo U('Position/trade');?>';",500);
                } else {
                    return layer.close(index);
                }
            },
        });
    });


    //订单挂单
    $('.guadanSubmit').on('click',function(){

        var arr            = {};

        arr['pid']         = "<?php echo ($option["id"]); ?>";                                                       //下单产品

        arr['price']       = $('.Marketguadan > div').first().find('div > div > input').val();     //挂单价格

        arr['type']        = $(".Marketguadan > ul > .active").attr('data-type');      // 1限价卖出 2限价买入 3突破卖出 4突破买入

        arr['ostyle']      = $(".Marketguadan > ul > .active").attr('data-ostyle');                //买入方向 0涨 1跌

        arr['number']      = $('.guadanNumber').val();                                             //下单手数

        arr['bond']        = $('.guadanBond > .active').html().replace(/[^\d.]/g,'');              //下单保证金

        arr['endloss']     = $('.Marketguadan > div').eq(4).find('div > div > input').val();       //止损点位

        arr['endprofit']   = $('.Marketguadan > div').eq(5).find('div > div > input').val();       //止盈点位

        arr['time']        = $('.Marketguadan > div').last().find('div > div > input').val();       //截止时间


        var index = layer.load(2); //加载中

        $.ajax({
            url: "<?php echo U('Transaction/restingOrder');?>",
            dataType: "json",
            type:"post",
            data:arr,
            success: function(data){
                layer.msg(data.msg);
                if(data.code == 200)
                {
                    layer.close(index);
                    return setTimeout("window.location.href='<?php echo U('Position/trade');?>';",500);
                } else {
                    return layer.close(index);
                }
            },
        });
    });

    //时间盘开始

    // 确认弹出框事件
    $('.close_tag').click(function () {
        $('.glass_mask').hide();
    })

    // 到期时间下面的点击事件
    $('.end_time_list li').click(function () {
        $(this).addClass('active').siblings('.active').removeClass('active');
        estimateProfit();
    });

    // 投资金额的点击事件
    $('.investMoney ul li').click(function () {
        $(this).addClass('active').siblings('.active').removeClass('active');
        $('.otherMoney').css('border','');

        $('.money').html('$ ' +$(this).find('span').eq(1).html());
        estimateProfit();
    });

    //点击买入卖出
    $('.sellOut').click(function () {
        $('.glass_mask').show();
        var ostyle      = $(this).attr('data-ostyle');
        var direction   = ostyle == 0 ? '<?php echo (L("buy")); ?>' : '<?php echo (L("sell")); ?>';
        $('.rise').html(direction);
        $('.rise').attr('data-ostyle',ostyle);
    });

    // 手动输入下单金额
    function inputOrderAmount(obj)
    {
        var money   = $(obj).val();
        money       = money == '' ? '0.00' : money;
        $('.money').html('$ ' +money);
        estimateProfit();
    }

    //点击其他金额时
    $('.otherMoney').click(function () {
        $('.investMoney ul li').removeClass('active');
        $(this).css('border','solid 1px #fdbe19');

        var inputMoney  = $(this).find('input').val();
        inputMoney      = inputMoney == '' ? '0.00' : inputMoney;

        $('.money').html('$ ' +inputMoney);
        estimateProfit();
    });

    //预计收益公共方法
    function estimateProfit()
    {
        var rate    = $('.end_time_list .active .period-widget-footer').attr('data-rate');
        var money   = $('.money').html().replace(/[^0-9]/ig,"");
        var profit  = parseFloat(parseFloat(money) + (money * (rate/100))).toFixed(2);
        $('.expectEarning').find('span').last().html(profit);
    }

    //时间盘下单
    $('.confirmBtn span').click(function () {

        var pid     = "<?php echo ($option["id"]); ?>";                                   //下单产品
        var ostyle  = $('.rise').attr('data-ostyle');                   //下单方向 0涨 1跌
        var bond    = $('.money').html().replace(/[^0-9]/ig,"");        //下单金额
        var time_id = $('.end_time_list .active').attr('data-time-id'); //时长id

        var index   = layer.load(2); //加载中

        $.ajax({
            url: "<?php echo U('Transaction/timeTradeOrder');?>",
            dataType: "json",
            type:"post",
            data: {'pid':pid,'ostyle':ostyle,'time_id':time_id,'bond':bond},
            success: function(data){
                layer.msg(data.msg);
                if(data.code == 200)
                {
                    layer.close(index);
                    daojishi(data.id);
                } else {
                    return layer.close(index);
                }
            },
        });
    });

    var interval        = null;
    var result_interval = null;

    //倒计时
    function daojishi(order_id) {

        var time = $('.end_time_list .active').attr('data-time'); //时长
        continue_order(time);

        interval = setInterval(function(){

            $.ajax({
                url: "<?php echo U('Product/order_details');?>",
                dataType: "json",
                type:"post",
                data: {order_id:order_id},
                success: function(data){
                    if(data.code == 200)
                    {
                        $('.glass_masks').show();
                        $('.wait').addClass('ng-hide');
                        $('.order_result').addClass('ng-hide');
                        $('.paysuccess').removeClass('ng-hide');

                        if(data.data.time < 0) {
                            clearInterval(interval);
                            $('.paysuccess').addClass('ng-hide');
                            $('.wait').removeClass('ng-hide');
                            return setTimeout(get_result(order_id),1000);
                        }

                        $('.goodstitle').html(data.data.option_name);
                        $('.pay_order_sen').html(data.data.time);
                        $('.newprice').html(data.data.sellprice);
                        $('.pay_order_price').html(data.data.Bond);
                        $('.pay_order_buypricee').html(data.data.buyprice);
                        $('.yuce').html('$'+data.data.ploss);
                        $('.pay_order_type').html(data.data.ostyle_name);

                        if(data.data.ploss > 0) {
                            $('.yuce').removeClass('rise').addClass('fall');
                        } else if(data.data.ploss < 0) {
                            $('.yuce').removeClass('fall').addClass('rise');
                        } else if(data.data.ploss == 0){
                            $('.yuce').removeClass('fall').removeClass('rise');
                        }

                        if(data.data.ostyle == 0) {
                            $('.pay_order_type').removeClass('rise');
                            $('.pay_order_type').addClass('fall');
                        } else {
                            $('.pay_order_type').removeClass('fall');
                            $('.pay_order_type').addClass('rise');
                        }

                    } else {
                        clearInterval(interval);
                        return layer.msg(data.msg);
                    }
                },
            });

        }, 1000);
    }

    //倒计时动画
    function continue_order(second) {

        $('.img_circle_right').remove();
        $('.img_circle_lift').remove();

        $('.right_circle').html('<img class="img_circle_right" style="-webkit-animation: run '+second+'s linear; animation-fill-mode:forwards" src="/Public//Qts/Home/right_circle1.png">');

        $('.left_circle').html('<img class="img_circle_lift" style="-webkit-animation: runaway '+second+'s linear; animation-fill-mode:forwards" src="/Public//Qts/Home/left_circle1.png">');
    }

    //关闭倒计时窗口
    function closeDjs()
    {
        clearInterval(interval);
        clearInterval(result_interval);

        $('.glass_masks').hide();
    }

    //获取本次交易结果
    function get_result(order_id)
    {
        result_interval = setInterval(function(){
            $.ajax({
                url: "<?php echo U('Product/order_details');?>",
                dataType: "json",
                type:"post",
                data: {order_id:order_id},
                success: function(data){
                    if(data.code == 200)
                    {
                        if(data.data.ostaus == 1) {

                            clearInterval(result_interval);

                            $('.wait').addClass('ng-hide');
                            $('.order_result').removeClass('ng-hide');

                            $('.pay_order_price').html(data.data.Bond);
                            $('.result_profit').html('$'+data.data.ploss);
                            $('.endprice').html(data.data.sellprice);
                        }

                    } else {
                        return layer.msg(data.msg);
                    }
                },
            });
        }, 1000);
    }
    
    //时间盘结束
</script>