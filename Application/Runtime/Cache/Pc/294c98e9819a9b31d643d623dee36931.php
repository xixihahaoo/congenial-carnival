<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html data-n-head="" lang="zh-TW">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta data-n-head="true" content="Meta description" name="description" data-hid="description">
    <meta data-n-head="true" content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, user-scalable=no,minimum-scale=1.0, maximum-scale=1.0,viewport-fit=contain" data-n-head="true">
<title data-n-head="true"><?php echo config('webname');?></title>

<link rel="stylesheet" href="/Public/Qts/Home/css/swiper.min.css">
<script src="/Public/Qts/Home/js/jquery.js"></script>
<script src="/Public/Qts/Home/js/swiper.min.js"></script>
<link href="/Public/Qts/Home/css/common.css" rel="stylesheet">
<link href="/Public/Qts/Home/css/style.css" rel="stylesheet">
<link href="/Public/Qts/Home/css/pchome.css" rel="stylesheet">


<style data-n-head="true" type="text/css">
    body {
        -webkit-text-size-adjust: none;
        background: #1F1d28;
    }
    .trueFoot {
        background: #21213a !important;
    }
</style>



    <style type="text/css">

        .swiper-container {
            width: 100%;
            height: 100%;
        }
        .swiper-container a{
            color: #4E4E4E;
        }
        .swiper-slide {
            text-align: center;
            font-size: 18px;

            /* Center slide text vertically */
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
        }

        .swiper-container2 .swiper-wrapper {
            -webkit-box-orient: vertical;
            -moz-box-orient: vertical;
            -ms-flex-direction: column;
            -webkit-flex-direction: column;
            flex-direction: column;
            /*width: 250px;*/
            width: 53%;
            float: right;
            margin-right: 0.5rem;
        }

        .swiper-container2 .swiper-slide {
            background: transparent;
        }

        .swiper-wrapper > .swiper-slide {
            font-size: 0.12rem;
        }
        .activity[data-v-58525266] {
            position: fixed;
            width: 2.8rem;
            height: 100%;
            top: 0;
            left: 50%;
            margin-left: -1.4rem;
            z-index: 100;
        }

        .swiper-container[data-v-58525266] {
            width: 100%;
            height: 3.4rem;
            top: 19%;
        }
        .modal[data-v-58525266] {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            opacity: .3;
            background: #000;
        }
        .del-img[data-v-58525266] {
            position: absolute;
            width: .14rem;
            height: .14rem;
            top: .14rem;
            right: .14rem;
            z-index: 2001;
        }
        .swiper-container[data-v-58525266] li{
            background-size: contain;
            background-repeat: no-repeat;
        }
        .button-img[data-v-58525266] {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: .67rem;
            background-size: 100%;
        }

        .dashi-wrap[data-v-63966bdb] {
            padding: .14rem;
            padding-right: 8%;
            border: 0;
            border-radius: 0;
            box-shadow: none;
        }
        #news {
            display: inline-block;
            height: 290px;
        }
        #news li {
            width: 508px;
            height: 65px;
            display: inline-block;
            padding: 0 0 30px 34px;
            box-sizing: border-box;
            border-left: 1px solid #ddd;
            position: relative;
            float: left;
        }
        #news li h4 {
            font-size: 18px;
            color: #ccc;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            height: 28px;
            width: 473px;
        }
        #news li h4 a{
            color: #ccc;
        }
        #news li p {
            font-size: 14px;
            color: #999;
            margin: 10px 0;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
         #news li span {
            font-size: 14px;
            color: #999;
        }
        #news li i {
            background: #368ae5;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            position: absolute;
            left: -5px;
            top: -5px;
        }
        .dashi-wrap[data-v-63966bdb] > div > p, .onTimeInfo > div > p{
            color: #c6c4c4;
            margin-bottom: 0.1rem;
        }
        .annouceWrap > div.onTimeInfo {
            border: 0;
            border-radius: 0;
            box-shadow: none;
            margin-left: 2%;
        }
        .hotWrapC > div.hot-wrap,.hotWrapC > div.earnings-wrap{
            background-color: #21213a;
            border: 0;
            box-shadow: none;
        }
        .zixuan li{
            border-bottom: 1px solid #464646;
        }
        .earnings-list-wrap[data-v-63966bdb]:after{
            background: #464646;
        }
        .earnings-txt[data-v-63966bdb], .hot-txt[data-v-63966bdb]{
            font-size: .12rem;
        }
        .headertop{
            position: absolute;
            background: transparent !important;
            box-shadow: none !important;
        }
        /*.heads {*/
            /*height: 0 !important;*/
        /*}*/
        body, html {
            background: #272b41 !important;
        }
        .nav li a {
            color: #fff !important;
        }
        .coin_footer {
            width: 100%;
            background: #333848;
            z-index: 9999;
        }
        .coin_footer .footerView {
            width: 1140px;
            height: 235px;
            margin: 0 auto;
            padding: 35px 0;
            box-sizing: border-box;
        }
        .coin_footer .footerView .footer_left {
            width: 370px;
            float: left;
            color: #999;
            font-size: 14px;
        }
        .coin_footer .footerView .footer_left img {
            margin-bottom: 33px;
            width: 140px;
        }
        .coin_footer .footerView .footer_left p, .coin_footer .footerView .footer_right p {
            margin-bottom: 12px;
        }
        .coin_footer .footerView .footer_center {
            min-width: 250px;
            float: left;
            color: #999;
            font-size: 14px;
            margin-left: 103px;
        }
        .coin_footer .footerView .footer_center ul.footerNav_a {
            margin-right: 80px;
        }

        .coin_footer .footerView .footer_center ul {
            float: left;
        }


        .coin_footer .footerView .footer_center ul h3 {
            font-size: 14px;
            color: #999;
            font-weight: 700;
            text-align: center;
            margin-bottom: 20px;
        }
        .coin_footer .footerView .footer_center ul.footerNav_a h3, .coin_footer .footerView .footer_center ul.footerNav_b h3 {
            text-align: left;
        }
        .coin_footer .footerView .footer_center ul li {
            font-size: 14px;
            color: #fff;
            margin-bottom: 16px;
        }
        .coin_footer .footerView .footer_center ul li a {
            font-size: 14px;
            color: #fff;
        }
        .coin_footer .footerView .footer_right {
            float: right;
            min-width: 196px;
            color: #fff;
            font-size: 14px;
        }
        .coin_footer .footerView .footer_right p {
            text-align: center;
            margin-bottom: 30px;
        }

    </style>
</head>
<body data-n-head="">
<div id="__nuxt">
    <div class="progress" data-v-4a8a9a01="" style="width:0;height:2px;background-color:#012861;opacity:0"></div>
    <div data-v-63966bdb="" class="">
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

        <section data-v-63966bdb="" class="page-main" style="background: #272b41;padding: 0 !important;">
            <div data-v-f2c7254e="" data-v-63966bdb="" class="swiper-wrap">
                <!-- Swiper -->
                <div class="swiper-container swiper-container1">
                    <div class="swiper-wrapper">
                        
                        <?php if(is_array($newsinfo)): $i = 0; $__LIST__ = $newsinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="swiper-slide">
            
                                <?php if($vo['n_type'] == 1): ?><img src="/Uploads/<?php echo ($vo["ncover"]); ?>" alt="">
                                <?php else: ?>
                                    <a href="<?php echo ($vo["ncontent"]); ?>" target="_blank">
                                        <img src="/Uploads/<?php echo ($vo["ncover"]); ?>" alt="">
                                    </a><?php endif; ?>
        
                            </div><?php endforeach; endif; else: echo "" ;endif; ?>

                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>

            <div class="contentWrap">
                <div class="hotWrapC">
                    <div data-v-63966bdb="" class="earnings-wrap">
                        <?php if($lang == 'zh-cn'): ?><img data-v-63966bdb="" src="/Public/Qts/Home/img/index/top_cn.png" class="earning-img">
                            <?php elseif($lang == 'zh-tw'): ?>
                            <img data-v-63966bdb="" src="/Public/Qts/Home/img/index/top_tw.png" class="earning-img">
                            <?php else: ?>
                            <img data-v-63966bdb="" src="/Public/Qts/Home/img/index/top_en.png" class="earning-img" style="width: 1.6rem;"><?php endif; ?>

                        <a href="<?php echo U('profitAll');?>"><span data-v-63966bdb="" class="earnings-txt"><?php echo (L("show_more")); ?> &gt;</span></a>
                        <div data-v-63966bdb="" class="earnings-con">
                            <ul data-v-63966bdb="" class="earnings-list">

                                <?php if(is_array($order)): $i = 0; $__LIST__ = $order;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li data-v-63966bdb="" class="earnings-list-wrap">
                                        <a href="<?php echo U('profitDetails',array('uid' => $vo['uid']));?>">
                                            <div data-v-63966bdb="" class="portrait-wrap left">
                                                <img data-v-63966bdb="" src="<?php echo ($vo["face"]); ?>" class="portrait top-<?php echo ($i); ?>">
                                                <span data-v-63966bdb="" class="portrait-grade">Lv<?php echo ($vo["level"]); ?></span>
                                            </div>

                                            <div data-v-63966bdb="" class="left earnings-name-wrap">
                                                <p data-v-63966bdb="" class="earnings-list-name"><?php echo ($vo["nickname"]); ?></p>
                                                <img data-v-63966bdb="" src="/Public/Qts/Home/img/index/TOP<?php echo ($i); ?>.png"
                                                     class="earnings-list-top">
                                            </div>

                                            <ol data-v-63966bdb="" class="earnings-list-con left">
                                                <li data-v-63966bdb=""><p data-v-63966bdb="" class="earnings-num">
                                                    <?php echo ($vo["profit"]); ?>%</p>
                                                    <p data-v-63966bdb="" class="earnings-list-txt"><?php echo (L("yield")); ?></p></li>
                                                <li data-v-63966bdb=""><p data-v-63966bdb="" class="earnings-num">
                                                    <?php echo ($vo["correct"]); ?>%</p>
                                                    <p data-v-63966bdb="" class="earnings-list-txt"><?php echo (L("accurate")); ?></p></li>
                                                <li data-v-63966bdb=""><p data-v-63966bdb="" class="earnings-num">
                                                    <?php echo ($vo["followCount"]); ?></p>
                                                    <p data-v-63966bdb="" class="earnings-list-txt"><?php echo (L("follow_people")); ?></p></li>
                                            </ol>
                                        </a>

                                        <?php if(!empty($vo['follow_user_id'])): if(($user_id) == $vo['follow_user_id']): ?><div data-v-63966bdb="" class="earnings-list-btn earnings-edit-btn">
                                                    <a href="<?php echo U('orderFollow',array('uid' => $vo['uid']));?>"><span
                                                        data-v-63966bdb=""><?php echo (L("edit")); ?></span></a>
                                                </div>
                                                <?php else: ?>
                                                <div data-v-63966bdb="" class="earnings-list-btn earnings-list-btn">
                                                    <a href="<?php echo U('orderFollow',array('uid' => $vo['uid']));?>"><span
                                                        data-v-63966bdb=""><?php echo (L("follow")); ?></span></a>
                                                </div><?php endif; ?>
                                            <?php else: ?>
                                            <div data-v-63966bdb="" class="earnings-list-btn earnings-list-btn">
                                                <a href="<?php echo U('orderFollow',array('uid' => $vo['uid']));?>"><span
                                                    data-v-63966bdb=""><?php echo (L("follow")); ?></span></a>
                                            </div><?php endif; ?>
                                    </li><?php endforeach; endif; else: echo "" ;endif; ?>

                            </ul>
                            <!--<a href="<?php echo U('profitAll');?>">-->
                                <!--<p data-v-63966bdb="" class="earnings-tips"><?php echo (L("show_master")); ?><em data-v-63966bdb="" class="arrow">-->
                                    <!--&gt;</em></p>-->
                            <!--</a>-->
                        </div>
                    </div>


                    <div data-v-63966bdb="" class="hot-wrap">

                        <?php if($lang == 'zh-cn'): ?><img data-v-63966bdb="" src="/Public/Qts/Home/img/index/hot_cn.png">
                            <?php elseif($lang == 'zh-tw'): ?>
                            <img data-v-63966bdb="" src="/Public/Qts/Home/img/index/hot_tw.png">
                            <?php else: ?>
                            <img data-v-63966bdb="" src="/Public/Qts/Home/img/index/hot_en.png" style="width: 1.4rem;"><?php endif; ?>


                        <a href="<?php echo U('Product/lists');?>"><span data-v-63966bdb="" class="hot-txt"><?php echo (L("show_all")); ?></span></a>
                        <ul data-v-63966bdb="" class="zixuan clearfix">
                            <?php if(is_array($option)): foreach($option as $key=>$vo): ?><input type="hidden" class="capital_key" value="<?php echo ($vo["capital_key"]); ?>">
                                <input type="hidden" id="length<?php echo ($vo["capital_key"]); ?>" value="<?php echo ($vo["capital_length"]); ?>">

                                <li data-v-63966bdb="" class="left clearfix <?php echo ($vo["capital_key"]); ?>">
                                    <a href="<?php echo U('Product/details',array('id' => $vo['id']));?>" class="clearfix">
                                        <p data-v-63966bdb="" class="variety-name1"><?php echo ($vo["capital_name"]); ?></p>
                                        <p data-v-63966bdb="" class="variety-price <?php echo ($vo["calssColor"]); ?>"><?php echo ($vo["Price"]); ?></p>
                                        <p data-v-63966bdb="" class="variety-rate <?php echo ($vo["calssColor"]); ?>"><?php echo ($vo["DiffRate"]); ?>%</p>
                                        <!--  <?php echo ($vo["id"]); ?> -->
                                    </a>
                                </li><?php endforeach; endif; ?>
                        </ul>
                    </div>
                </div>

                <ul data-v-63966bdb="" class="content-tip">

                    <li data-v-63966bdb="" class="">
                        <a href="<?php echo U('advanced');?>">
                            <img data-v-63966bdb="" src="/Public/Qts/Home/img/index/newUser.png">
                            <p data-v-63966bdb="" class="title"><?php echo (L("beginner_must")); ?></p>
                            <p data-v-63966bdb="" class="sub-title"><?php echo (L("from_to")); ?></p>
                        </a>
                    </li>

                    <li data-v-63966bdb="" class="">
                        <a href="<?php echo U('watch');?>">
                            <img data-v-63966bdb="" src="/Public/Qts/Home/img/index/shaidan.png">
                            <p data-v-63966bdb="" class="title"><?php echo (L("drying_list")); ?></p>
                            <p data-v-63966bdb="" class="sub-title"><?php echo (L("pick_steak")); ?></p>
                        </a>
                    </li>

                    <li data-v-63966bdb="" class="mr14">
                        <a href="<?php echo U('financeNews');?>">
                           <img data-v-63966bdb="" src="/Public/Qts/Home/img/index/news.png">
                            <p data-v-63966bdb="" class="title"><?php echo (L("information")); ?></p>
                           <p data-v-63966bdb="" class="sub-title"><?php echo (L("material")); ?></p>
                        </a>
                    </li>
                </ul>
               <!-- <img data-v-63966bdb="" src="/Public/Qts/Home/img/index/xsbb.png" onclick="window.location.href='<?php echo U('advanced');?>'">-->
               <!--  <img data-v-63966bdb="" src="/Public/Qts/Home/img/index/dssd.png" onclick="window.location.href='<?php echo U('watch');?>'">-->
               <!--  <div class="annouceWrap">
                    <?php if($lang == 'zh-cn'): ?><div data-v-63966bdb="" class="notice_cn">
                    <?php elseif($lang == 'zh-tw'): ?>
                        <div data-v-63966bdb="" class="notice_tw">
                    <?php else: ?>
                        <div data-v-63966bdb="" class="notice_en"><?php endif; ?>

                            <div data-v-63966bdb="" class="dashi-wrap">
                                <!-- Swiper -->
                               <!--  <div>
                                    <?php if(empty($_SESSION['user_id'])): ?><p><span><?php echo (L("system_notice")); ?></span><span style="cursor: pointer;font-size:.12rem"  onclick="window.location.href='<?php echo U('Login/login');?>'"><?php echo (L("more")); ?></span></p>
                                    <?php else: ?>
                                        <p><span><?php echo (L("system_notice")); ?></span><span style="cursor: pointer;font-size:.12rem"  onclick="window.location.href='<?php echo U('Message/publicMsg');?>'"><?php echo (L("more")); ?></span></p><?php endif; ?>
                                    <!--<div class="swiper-container swiper-container2">-->
                                  <!--   <div>
                                        <!--<div class="swiper-wrapper">-->
                                        <!-- <?php if(is_array($stretch)): $i = 0; $__LIST__ = $stretch;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="" onclick="window.location.href='<?php echo U('Stretch/stretchDetails',array('id' => $vo['id']));?>'"><a href="<?php echo U('Stretch/stretchDetails',array('id' => $vo['id']));?>"><?php echo ($vo["title"]); ?></a>
                                            </div><?php endforeach; endif; else: echo "" ;endif; ?> -->
                                     <!--    <ul id="news">
                                      <!--       <?php if(is_array($stretch)): $i = 0; $__LIST__ = $stretch;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li onclick="window.location.href='<?php echo U('Stretch/stretchDetails',array('id' => $vo['id']));?>'">
                                                    <h4><a href="<?php echo U('Stretch/stretchDetails',array('id' => $vo['id']));?>"><?php echo ($vo["title"]); ?></a></h4>
                                                    <!-- <p>全球首个智能区块链研究实验室成立</p><span>2018-8-11&nbsp;16:51</span> -->
                                        <!--             <i></i>
                                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--<a href="<?php echo U('Stretch/stretchList');?>">-->
                                <!--<img data-v-63966bdb="" src="/Public/Qts/Home/img/index/right.png" class="arrow-right" style="z-index: 9999">-->
                            <!--</a>-->
                      <!--  </div>-->
                      <!--  <div class="onTimeInfo">
                            <div>
                                <p><span><?php echo (L("information")); ?></span><span style="cursor: pointer;font-size:.12rem" onclick="window.location.href='<?php echo U('financeNews');?>'"><?php echo (L("more")); ?></span></p>

                                <div>
                                    <!-- <a href="<?php echo U('financeNews');?>"> -->
                                        <!--<img data-v-63966bdb="" src="/Public/Qts/Home/img/index/news.png">-->
                                        <!-- <p data-v-63966bdb="" class="title"><?php echo (L("information")); ?></p>
                                        <p data-v-63966bdb="" class="sub-title"><?php echo (L("material")); ?></p> -->
                                    <!-- </a> -->
                          <!--      <ul id="news">
                            <!--        <li>
                                        <h4><a href="<?php echo U('financeNews');?>"><?php echo (L("information")); ?></a></h4>
                                        <!-- <p>全球首个智能区块链研究实验室成立</p><span>2018-8-11&nbsp;16:51</span> -->
                            <!--            <i></i>
                            <!--        </li>
                                    <!--<li>-->
                                        <!--<h4><a href="<?php echo U('financeNews');?>"><?php echo (L("material")); ?></a></h4>-->
                                        <!--&lt;!&ndash; <p>全球首个智能区块链研究实验室成立</p><span>2018-8-11&nbsp;16:51</span> &ndash;&gt;-->
                                        <!--<i></i>-->
                                    <!--</li>-->
                             <!--   </ul>
                                </div>

                            </div>

                        </div>-->
                </div>
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


        <?php if(!empty($info['id'])): ?><div data-v-58525266="" data-v-63966bdb="" class="activity">
                <div data-v-58525266="" class="swiper-container swiper-container-horizontal">
                    <ul data-v-58525266="" class="swiper-wrapper"
                        style="transform: translate3d(-280px, 0px, 0px); transition-duration: 0ms;">

                        <li data-v-58525266="" class="swiper-slide swiper-list swiper-slide-active swiper-slide-duplicate-next swiper-slide-duplicate-prev" style="background-image: url(&quot;/Uploads/<?php echo ($info["thumb"]); ?>&quot;); width: 280px;" data-swiper-slide-index="0">
                            <img data-v-58525266="" src="/Public/Qts/Home/img/index/exit.png" class="del-img">
                            <div data-v-58525266="" class="button-img" style="background-image: url(&quot;/Public/Qts/Home/img/index/details.png&quot;);">
                            </div>
                        </li>

                        <li data-v-58525266="" class="swiper-slide swiper-list swiper-slide-duplicate swiper-slide-duplicate-active swiper-slide-next"
                            style="background-image: url(&quot;/Uploads/<?php echo ($info["thumb"]); ?>&quot;); width: 280px;" data-swiper-slide-index="0">
                                <img data-v-58525266="" src="/Public/Qts/Home/img/index/exit.png" class="del-img">

                            <div data-v-58525266="" onclick='window.location.href="<?php echo U('Stretch/details',array('id' => $info['id']));?>"' class="button-img" onclick="" style="background-image: url(&quot;/Public/Qts/Home/img/index/details.png&quot;);">
                            </div>
                        </li>

                    </ul>
                </div>
                <div data-v-58525266="" class="modal"></div>
            </div><?php endif; ?>

    </div>
</div>
    <!-- footer-->

<div class="coin_footer" style="position:absolute;bottom: 0;left:0;display:none;">
    <div class="footerView">

        <div class="footer_left">
            <a href="/"><img src="http://www.molly.mobi/resource/frontend/img/white_logo.png" alt="JinglanEX"></a>
            <p>JingLanEx数字币交易所 仅供软件演示</p>
            <p>© 2018 北京景蓝信息技术有限公司 All Rights Reserved.</p>
            <p data-i18n="a_investment">市场有风险，投资需谨慎</p>
        </div>
        <div class="footer_center">
            <ul class="footerNav_a">
                <h3 data-i18n="nav_6">关于</h3>
                <li>
                    <a href="/about" data-i18n="a_about">关于我们</a>

                </li>
                <li>
                    <a href="/download" data-i18n="a_about">APP下载</a>
                </li>
                <li>
                    <a href="/recent" data-i18n="a_about">公告</a>
                </li>
            </ul>
            <ul class="footerNav_b">
                <h3 data-i18n="nav_7">条款说明</h3>
                <li>
                    <a href="/help/14" data-i18n="a_clause">使用条款</a>
                </li>
                <li>
                    <a href="/help/13" data-i18n="a_policy">隐私政策</a>
                </li>
                <li>
                    <a href="/help/15" data-i18n="a_rules">反洗钱条例</a>
                </li>
                <li style="margin-right:46px;">
                    <a href="/help/16" data-i18n="a_rate">费率说明</a>
                </li>
            </ul>
            <ul class="footerNav_c">
                <h3 data-i18n="nav_8">服务支持</h3>
                <li>
                    <a href="/deploy" data-i18n="apply">上币申请</a>
                </li>
            </ul>
        </div>
        <div class="footer_right">
            <p style="text-align: left;" data-i18n="a_contact">联系我们</p>
            <p style="white-space: nowrap;margin-top: 25px;margin-right: -40px;text-align: left;color: #999;"
                class="contact_msg">
                客服邮箱： kinlink010@163.com </p>
        </div>
    </div>
</div>
<script type="text/javascript">
    var swiper1 = new Swiper('.swiper-container1', {
        autoplay: true,
        loop: true,
        spaceBetween: 30,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });

    var swiper2 = new Swiper('.swiper-container2', {
        autoplay: true,
        loop: true,
        direction: 'vertical'
    });

    /**
     * websocket 传输数据
     */
    var arr = [];
    $.each($('.capital_key'), function () {
        var key = $(this).val();
        arr.push(key);
    });
    var arrString = arr.join(',');

    // ws = new WebSocket("ws://47.244.175.58:2346");
    ws = new WebSocket("ws://39.107.99.235:8026");
    ws.onopen = function () {
        ws.send('tom');
    };
    ws.onmessage = function (e) {

        var data = eval("(" + e.data + ")");
        var type = data.type || '';
        switch (type) {
            case 'init':
                $.post('<?php echo U("Bind/binding");?>', {client_id: data.client_id, group: arrString}, function (data) {
                }, 'json');
                break;
            default :

                var data = JSON.parse(e.data);

                var operator    = data.DiffRate <= 0 ? '' : '+';
                var length      = $('#length' + data.capital_key + '').val();
                var prePrice    = $('.' + data.capital_key + ' p').eq(1).html();

                data.Price = data.Price.toFixed(length);

                $('.' + data.capital_key + ' p').eq(1).html(data.Price);
                $('.' + data.capital_key + ' p').eq(2).html(operator + data.DiffRate + '%');

                if(data.Price < prePrice)
                {
                    $('.' + data.capital_key + ' p').eq(1).removeClass('price-green').addClass('price-orange');
                    $('.' + data.capital_key + ' p').eq(2).removeClass('price-green').addClass('price-orange');
                } else {
                    $('.' + data.capital_key + ' p').eq(1).removeClass('price-orange').addClass('price-green');
                    $('.' + data.capital_key + ' p').eq(2).removeClass('price-orange').addClass('price-green');
                }
        }
    };

    //点击关闭弹出框 (保持时间一周)
    $('.del-img[data-v-58525266]').click(function () {

        var id = "<?php echo ($info['id']); ?>";
        $.get("<?php echo U('Stretch/setCookie');?>",{'id':id},function(data){});

        $('.activity').hide();
    });


    window.onload=function(){
        //设置底部导航选中状态
      $('.headertop .wapper > ul > li').first().find('a').addClass('active');
        // $('.footer > ul > li').first().find('a').addClass('common1');
        // $('.footer > ul > li').first().find('em').addClass('selected');
    }

</script>
</body>
</html>