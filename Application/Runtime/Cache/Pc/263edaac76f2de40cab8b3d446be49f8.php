<?php if (!defined('THINK_PATH')) exit();?>    <!DOCTYPE html>
<html data-n-head="" lang="zh-TW">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta data-n-head="true" content="Meta description" name="description" data-hid="description">
    <meta data-n-head="true" content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, user-scalable=no,minimum-scale=1.0, maximum-scale=1.0,viewport-fit=contain" data-n-head="true">
    <title data-n-head="true"><?php echo (L("market")); ?></title>

    <link href="/Public//Qts/Home/css/common.css" rel="stylesheet">
    <link href="/Public//Qts/Home/css/style.css" rel="stylesheet">
    <link href="/Public//Qts/Home/css/details.css" rel="stylesheet">

    <script src="/Public/Qts/Home/js/jquery.js"></script>

    <style type="text/css" data-n-head="true">
        body {
            overflow-y: scroll;
            /*background: #191A22;*/
        }

        html {
            /*overflow: hidden*/
        }
        .head {
            color: #508ee8 !important;
        }
        .add-list li .variety_left p{
            color: #999;
        }
        .add-content .titles1{
            background: #999;
            color: #666;
        }
        .edit-list .variety-edit .variety_name{
            color: #999;
        }
        .head_edit,.head_add {
            display: none;
        }
        .contentWrap {
            width: 60%;
            margin: auto;
        }
        .titles[data-v-145cf773] {
            position: static;
        }
        #head {
            position: relative;
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
        .title_top[data-v-145cf773] {
            position: static;
        }
        .variety[data-v-145cf773] {
            overflow: auto;
        }
        .edit[data-v-145cf773],.edit-head {
            width: 100%;
            position: relative;
        }

        .edit-headA[data-v-145cf773] {
            width: 100%;
            position: absolute;
            top: .1rem;
        }
        .edit-btn[data-v-145cf773] {
            width: 50%;
        }
        .edit-page-main .titles {
            width: 60%;
        }
        .bianji {
            width: 100% !important;
            overflow: auto !important;
            height: auto;
        }
        .edit-content[data-v-145cf773] {
            padding-top: 0;
        }
        .edit-list[data-v-145cf773] {
            overflow-y: auto;
            margin-top: 1rem;
            position: relative;
        }
        .add-content[data-v-145cf773] {
            padding-top: 0;
        }
        .add-list[data-v-145cf773], .edit-list[data-v-145cf773] {
            height: 7rem;
            margin-bottom: .43rem;
        }
        .titles > div[data-v-145cf773],.title_top[data-v-145cf773]{
            color: #ddd;
            cursor: pointer;
        }
        .titles > div.on[data-v-145cf773]{
            color: #508ee8 !important;
        }
        .titles > div.on span[data-v-145cf773]{
            background: #508ee8 !important;
        }
        p.variety_name[data-v-145cf773],p.variety_type[data-v-145cf773]{
            color: #ddd;
        }
        .bg_red {
            color: #e44c72 !important;
        }
        .bg_h{
            color: #ddd !important;
            border: 1px solid #ddd !important;
        }
        .head_add[data-v-145cf773], .head_edit[data-v-145cf773]{
            color: #ddd;
            cursor: pointer;
        }
        .head_name[data-v-145cf773]{
            color: #508ee8;
        }
         #head1, .head ,.variety[data-v-145cf773]{
            background: #212139;
        }
        #head,.titles[data-v-145cf773],.title_top[data-v-145cf773]{
            background: #262b41;
        }
        .add-list li[data-v-145cf773]:after, .edit-list > div[data-v-145cf773]:after, .variety li[data-v-145cf773]:after{
            background: #53524f;
        }
        .variety_right .pop_img[data-v-145cf773]{
            color: #ddd;
        }
        .variety li[data-v-145cf773]{
                /*border-bottom: 1px solid #ccc;*/
        }

      /*新增*/
      body, html {
        height: 100%;
        width: 100%;
        background: #f5f9fe !important;
      }
      #head {
        top: 10px !important;
      }
      .head {
        background: #212139 !important;
      }
      .arrow_left:after {
        border-color: #ccc !important;
      }
      .edit-page-main .titles {
        background: #212139 !important;
      }
      .add-list, .edit-list {
        background: #212139 !important;
      }
      .edit-content .edit-list > div .variety-edit {
        background: #212139 !important;
      }
      .edit-bottom {
        background: #212139 !important;
      }
      .edit-btn {
        background: #7aaeed !important;
        color: #fff !important;
      }
    </style>
</head>
<body>

<?php if(is_array($option)): $i = 0; $__LIST__ = $option;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><input type="hidden" class="capital_key" value="<?php echo ($vo["capital_key"]); ?>">
    <input type="hidden" id="length<?php echo ($vo["capital_key"]); ?>" value="<?php echo ($vo["capital_length"]); ?>">
    <input type="hidden" id="price<?php echo ($vo["capital_key"]); ?>" value=""><?php endforeach; endif; else: echo "" ;endif; ?>


<div id="__nuxt">
    <div class="progress" data-v-4a8a9a01=""
         style="width: 0%; height: 2px; background-color: rgb(1, 40, 97); opacity: 0;"></div>
    <div data-v-145cf773="" class="" style="background: #262b41;">
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
        <div class="contentWrap">
            <div data-v-145cf773="" id="head" class="" style="">
                <div data-v-145cf773="" class="head_edit"><?php echo (L("editor")); ?></div>
                <!--<span data-v-145cf773="" class="head_name"><?php echo (L("market")); ?></span>-->
                <div data-v-145cf773="" class="head_add">+</div>
            </div>
            <section data-v-145cf773="" class="page-main">
                <div data-v-145cf773="" class="titles list_class" style="margin-bottom: .15rem;">
                    <div data-v-145cf773="" data="0" style="font-size: .2rem;"><?php echo (L("focus")); ?><span data-v-145cf773=""></span></div>
                    <?php if(is_array($optionClass)): $i = 0; $__LIST__ = $optionClass;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div data-v-145cf773="" data="<?php echo ($i); ?>"  style="font-size: .2rem;"><?php echo ($vo["name"]); ?><span data-v-145cf773=""></span></div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <div data-v-145cf773="">
                    <div data-v-145cf773="" class="title_top" style="margin:0.05rem 0;">
                        <div data-v-145cf773="" class="title_left"><?php echo (L("trades")); ?></div>
                        <div data-v-145cf773="" class="title_right">
                            <div data-v-145cf773=""><?php echo (L("sell")); ?>.</div>
                            <div data-v-145cf773=""><?php echo (L("buy")); ?></div>
                        </div>
                    </div>
                </div>
                <div data-v-145cf773="" class="swiper-container swiper-container-horizontal">
                    <div data-v-145cf773="" class="swiper-wrapper list-wrapper"
                         style="transform: translate3d(0px, 0px, 0px); transition-duration:300ms;">

                        <!-- 自选品种 -->
                        <ul data-v-145cf773="" class="my-variety variety swiper-slide swiper-slide-active"
                            style="width: 414px;">
                            <?php if(is_array($selfData)): $i = 0; $__LIST__ = $selfData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('details',array('id' => $vo['id'],'index' => 0));?>">
                                    <li data-v-145cf773="">
                                        <div data-v-145cf773="" class="variety_left"><p data-v-145cf773="" class="variety_name">
                                            <?php echo ($vo["capital_name"]); ?></p>
                                            <p data-v-145cf773="" class="variety_type"><?php echo ($vo["option_key"]); ?></p></div>
                                        <div data-v-145cf773="" class="variety_right">
                                            <div data-v-145cf773="" class="wave_left bg_h color<?php echo ($vo["capital_key"]); ?>"><span class="bp<?php echo ($vo["capital_key"]); ?>"
                                                    style="font-size:.15rem"><?php echo ($vo["bp"]); ?></span>
                                            </div>
                                            <div data-v-145cf773="" class="pop_img diff<?php echo ($vo["capital_key"]); ?>">
                                                <?php echo ($vo["difference"]); ?>
                                            </div>
                                            <div data-v-145cf773="" class="wave_left bg_h color<?php echo ($vo["capital_key"]); ?>"><span class="sp<?php echo ($vo["capital_key"]); ?>"
                                                    style="font-size:.15rem"><?php echo ($vo["sp"]); ?></span>
                                            </div>
                                        </div>
                                    </li>
                                </a><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                        <!-- 自选品种 -->
                        <!-- 外汇品种 -->
                        <ul data-v-145cf773="" class="variety swiper-slide swiper-slide-next" style="width: 414px;">
                            <?php if(is_array($data['exchange'])): $i = 0; $__LIST__ = $data['exchange'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('details',array('id' => $vo['id'],'index' => 1));?>">
                                    <li data-v-145cf773="">
                                        <div data-v-145cf773="" class="variety_left"><p data-v-145cf773="" class="variety_name">
                                            <?php echo ($vo["capital_name"]); ?></p>
                                            <p data-v-145cf773="" class="variety_type"><?php echo ($vo["option_key"]); ?></p></div>
                                        <div data-v-145cf773="" class="variety_right">
                                            <div data-v-145cf773="" class="wave_left bg_h color<?php echo ($vo["capital_key"]); ?>"><span class="bp<?php echo ($vo["capital_key"]); ?>"
                                                                                                                        style="font-size:.15rem"><?php echo ($vo["bp"]); ?></span>
                                            </div>
                                            <div data-v-145cf773="" class="pop_img diff<?php echo ($vo["capital_key"]); ?>">
                                                <?php echo ($vo["difference"]); ?>
                                            </div>
                                            <div data-v-145cf773="" class="wave_left bg_h color<?php echo ($vo["capital_key"]); ?>"><span class="sp<?php echo ($vo["capital_key"]); ?>"
                                                                                                                        style="font-size:.15rem"><?php echo ($vo["sp"]); ?></span>
                                            </div>
                                        </div>
                                    </li>
                                </a><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                        <!-- 外汇品种 -->

                        <!-- 贵金属品种 能源品种 -->
                        <ul data-v-145cf773="" class="variety swiper-slide" style="width: 414px;">
                            <?php if(is_array($data['metal'])): $i = 0; $__LIST__ = $data['metal'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('details',array('id' => $vo['id'],'index' => 2));?>">
                                    <li data-v-145cf773="">
                                        <div data-v-145cf773="" class="variety_left"><p data-v-145cf773="" class="variety_name">
                                            <?php echo ($vo["capital_name"]); ?></p>
                                            <p data-v-145cf773="" class="variety_type"><?php echo ($vo["option_key"]); ?></p></div>
                                        <div data-v-145cf773="" class="variety_right">
                                            <div data-v-145cf773="" class="wave_left bg_h color<?php echo ($vo["capital_key"]); ?>"><span class="bp<?php echo ($vo["capital_key"]); ?>"
                                                                                                                        style="font-size:.15rem"><?php echo ($vo["bp"]); ?></span>
                                            </div>
                                            <div data-v-145cf773="" class="pop_img diff<?php echo ($vo["capital_key"]); ?>">
                                                <?php echo ($vo["difference"]); ?>
                                            </div>
                                            <div data-v-145cf773="" class="wave_left bg_h color<?php echo ($vo["capital_key"]); ?>"><span class="sp<?php echo ($vo["capital_key"]); ?>"
                                                                                                                        style="font-size:.15rem"><?php echo ($vo["sp"]); ?></span>
                                            </div>
                                        </div>
                                    </li>
                                </a><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                        <!-- 贵金属品种 能源品种-->

                        <!-- 港股美股品种 -->
                        <ul data-v-145cf773="" class="variety swiper-slide" style="width: 414px;">
                            <?php if(is_array($data['honkong'])): $i = 0; $__LIST__ = $data['honkong'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('details',array('id' => $vo['id'],'index' => 3));?>">
                                    <li data-v-145cf773="">
                                        <div data-v-145cf773="" class="variety_left"><p data-v-145cf773="" class="variety_name">
                                            <?php echo ($vo["capital_name"]); ?></p>
                                            <p data-v-145cf773="" class="variety_type"><?php echo ($vo["option_key"]); ?></p></div>
                                        <div data-v-145cf773="" class="variety_right">
                                            <div data-v-145cf773="" class="wave_left bg_h color<?php echo ($vo["capital_key"]); ?>"><span class="bp<?php echo ($vo["capital_key"]); ?>"
                                                                                                                        style="font-size:.15rem"><?php echo ($vo["bp"]); ?></span>
                                            </div>
                                            <div data-v-145cf773="" class="pop_img diff<?php echo ($vo["capital_key"]); ?>">
                                                <?php echo ($vo["difference"]); ?>
                                            </div>
                                            <div data-v-145cf773="" class="wave_left bg_h color<?php echo ($vo["capital_key"]); ?>"><span class="sp<?php echo ($vo["capital_key"]); ?>"
                                                                                                                        style="font-size:.15rem"><?php echo ($vo["sp"]); ?></span>
                                            </div>
                                        </div>
                                    </li>
                                </a><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                        <!-- 港股美股品种 -->

                        <!-- 数字货币品种 -->
                        <ul data-v-145cf773="" class="variety swiper-slide" style="width: 414px;">
                            <?php if(is_array($data['currency'])): $i = 0; $__LIST__ = $data['currency'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('details',array('id' => $vo['id'],'index' => 4));?>">
                                    <li data-v-145cf773="">
                                        <div data-v-145cf773="" class="variety_left"><p data-v-145cf773="" class="variety_name">
                                            <?php echo ($vo["capital_name"]); ?></p>
                                            <p data-v-145cf773="" class="variety_type"><?php echo ($vo["option_key"]); ?></p></div>
                                        <div data-v-145cf773="" class="variety_right">
                                            <div data-v-145cf773="" class="wave_left bg_h color<?php echo ($vo["capital_key"]); ?>"><span class="bp<?php echo ($vo["capital_key"]); ?>"
                                                                                                                        style="font-size:.15rem"><?php echo ($vo["bp"]); ?></span>
                                            </div>
                                            <div data-v-145cf773="" class="pop_img diff<?php echo ($vo["capital_key"]); ?>">
                                                <?php echo ($vo["difference"]); ?>
                                            </div>
                                            <div data-v-145cf773="" class="wave_left bg_h color<?php echo ($vo["capital_key"]); ?>"><span class="sp<?php echo ($vo["capital_key"]); ?>"
                                                                                                                        style="font-size:.15rem"><?php echo ($vo["sp"]); ?></span>
                                            </div>
                                        </div>
                                    </li>
                                </a><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                        <!-- 数字货币品种 -->
                    </div>
                </div>
            </section>


            <div data-v-145cf773="" class="edit add">
                <div data-v-145cf773="" class="add-content">
                    <div data-v-145cf773="" class="head edit-head edit-headA">
                        <h3 data-v-145cf773="" class="product-name">
                            <a data-v-145cf773="" class="arrow_left"></a><span data-v-145cf773=""><?php echo (L("add_optional")); ?></span>
                        </h3>
                    </div>
                    <!-- esitlist -->
                    <section class=" edit-page-main" style="height: 100%;height: 100%;background: #fff;z-index: 99999999;" >
                        <!--titles-->
                        <div class="titles">

                            <?php if(is_array($optionClass)): $i = 0; $__LIST__ = $optionClass;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($i) == "1"): ?><div data-v-145cf773 class="on" data="<?php echo ($i-1); ?>"><?php echo ($vo["name"]); ?><span data-v-145cf773></span></div>
                               <?php else: ?>
                                   <div data-v-145cf773  data="<?php echo ($i-1); ?>"><?php echo ($vo["name"]); ?><span data-v-145cf773></span></div><?php endif; endforeach; endif; else: echo "" ;endif; ?>

                        </div>
                        <!--content-->
                        <div class="swiper-container" style="top:46px; height: 100%;margin-top: .6rem">
                            <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px); transition-duration:300ms;">
                            <!-- 自选产品外汇 -->
                                <ul class="add-list" data-v-145cf773>
                                    <?php if(is_array($listData['exchange'])): $i = 0; $__LIST__ = $listData['exchange'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo['status']) == "1"): ?><li data-v-145cf773 class="selected" data-id="<?php echo ($vo["id"]); ?>">
                                        <?php else: ?>
                                            <li data-v-145cf773 class="" data-id="<?php echo ($vo["id"]); ?>"><?php endif; ?>
                                            <div class="variety_left" data-v-145cf773="">
                                                <p class="variety_name" data-v-145cf773><?php echo ($vo["capital_name"]); ?></p>
                                                <p class="variety_type" data-v-145cf773><?php echo ($vo["option_key"]); ?></p>
                                            </div>
                                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                </ul>
                                <!-- 自选产品外汇 -->

                                <!-- 自选产品大宗商品 -->
                                <ul class="add-list" data-v-145cf773>
                                    <?php if(is_array($listData['metal'])): $i = 0; $__LIST__ = $listData['metal'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo['status']) == "1"): ?><li data-v-145cf773 class="selected" data-id="<?php echo ($vo["id"]); ?>">
                                        <?php else: ?>
                                            <li data-v-145cf773 class="" data-id="<?php echo ($vo["id"]); ?>"><?php endif; ?>
                                            <div class="variety_left" data-v-145cf773="">
                                                <p class="variety_name" data-v-145cf773><?php echo ($vo["capital_name"]); ?></p>
                                                <p class="variety_type" data-v-145cf773><?php echo ($vo["option_key"]); ?></p>
                                            </div>
                                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                </ul>
                                <!-- 自选产品大宗商品 -->

                                <!-- 自选产品指数 -->
                                <ul class="add-list" data-v-145cf773>
                                    <?php if(is_array($listData['honkong'])): $i = 0; $__LIST__ = $listData['honkong'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo['status']) == "1"): ?><li data-v-145cf773 class="selected" data-id="<?php echo ($vo["id"]); ?>">
                                        <?php else: ?>
                                            <li data-v-145cf773 class="" data-id="<?php echo ($vo["id"]); ?>"><?php endif; ?>
                                            <div class="variety_left" data-v-145cf773="">
                                                <p class="variety_name" data-v-145cf773><?php echo ($vo["capital_name"]); ?></p>
                                                <p class="variety_type" data-v-145cf773><?php echo ($vo["option_key"]); ?></p>
                                            </div>
                                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                </ul>
                                <!-- 自选产品指数 -->

                                <!-- 自选产品数字币 -->
                                <ul class="add-list" data-v-145cf773>
                                    <?php if(is_array($listData['currency'])): $i = 0; $__LIST__ = $listData['currency'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo['status']) == "1"): ?><li data-v-145cf773 class="selected" data-id="<?php echo ($vo["id"]); ?>">
                                        <?php else: ?>
                                            <li data-v-145cf773 class="" data-id="<?php echo ($vo["id"]); ?>"><?php endif; ?>
                                            <div class="variety_left" data-v-145cf773="">
                                                <p class="variety_name" data-v-145cf773><?php echo ($vo["capital_name"]); ?></p>
                                                <p class="variety_type" data-v-145cf773><?php echo ($vo["option_key"]); ?></p>
                                            </div>
                                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                </ul>
                                <!-- 自选产品数字币 -->
                            </div>
                        </div>
                    </section>
                </div>
                <div data-v-145cf773="" class="edit-bottom">
                    <div data-v-145cf773="" class="edit-btn" onclick="addUserOption();"><?php echo (L("save")); ?></div>
                </div>
                <!--</div>-->
            </div>

            <div data-v-145cf773="" class="edit bianji">
                <div data-v-145cf773="" class="edit-content">
                    <div data-v-145cf773="" class="head edit-head edit-headA"><h3 data-v-145cf773="" class="product-name"><a
                            data-v-145cf773="" class="arrow_left"></a><span data-v-145cf773=""><?php echo (L("edit_optional")); ?></span></h3></div>
                    <div data-v-145cf773="" class="edit-list">

                        <?php if(is_array($selfData)): $i = 0; $__LIST__ = $selfData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div data-v-145cf773="" class="">
                                <img data-v-145cf773="" src="/Public/Qts/Home/img/details/img16.png" class="del">
                                <div data-v-145cf773="" class="variety-edit"><p data-v-145cf773="" class="variety_name"><?php echo ($vo["capital_name"]); ?></p>
                                    <p data-v-145cf773="" class="variety_type"><?php echo ($vo["capital_key"]); ?></p></div>
                                <div data-v-145cf773="" class="drag"></div>
                                <div data-v-145cf773="" class="remove empty_<?php echo ($vo["id"]); ?>" onclick="delOption('<?php echo ($vo["id"]); ?>');">
                                    <?php echo (L("delete")); ?>
                                </div>
                            </div><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                <!--<div data-v-145cf773="" class="edit-bottom">
                        <div data-v-145cf773="" class="edit-btn">保存</div>
                    </div> -->
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

<script>
    $(function(){


        /**
         * websocket 传输数据
         */
        function websocket()
        {
            var arr = [];
            $.each($('.capital_key'),function(){
                var key = $(this).val();
                arr.push(key);
            });
            var arrString = arr.join(',');

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
                        $.post('<?php echo U("Bind/binding");?>', {client_id: data.client_id,group:arrString}, function(data){}, 'json');
                        break;
                    default :

                        var data        = JSON.parse(e.data);
                        var length      = $('#length'+data.capital_key+'').val();

                        data.sp     = parseFloat(data.sp).toFixed(length);
                        data.bp     = parseFloat(data.bp).toFixed(length);
                        difference  = parseFloat(data.erence).toFixed(1);
                        price       = parseFloat(data.Price);

                        preverence  = $('.diff'+data.capital_key+'').html();

                        $('.sp'+data.capital_key+'').html(data.sp);
                        $('.diff'+data.capital_key+'').html(difference);
                        $('.bp'+data.capital_key+'').html(data.bp);
                        $('#price'+data.capital_key+'').val(price);


                        //颜色切换
                        if(difference > preverence)
                        {
                            $('.color'+data.capital_key+'').removeClass('bg_green bg_h').addClass('bg_red txt_w');
                        } else if(difference == preverence)
                        {
                            $('.color'+data.capital_key+'').removeClass('bg_red bg_green txt_w').addClass('bg_h');
                        } else {
                            $('.color'+data.capital_key+'').removeClass('bg_red bg_h').addClass('bg_green txt_w');
                        }
                }
            };
        }

        websocket();    //websoket 传输数据

        //对列表的分类进行显示
        $('.page-main .titles').on('click','div',function(){
            $('.page-main .titles > div').removeClass('on');
            $(this).addClass('on');
            // var cWidth=window.innerWidth;
            var cWidth=$('.contentWrap').width();

            // alert($(this).attr('data'))
            $('.page-main .swiper-wrapper').css('transform','translate3d(-'+$(this).attr('data')*cWidth+'px, 0px, 0px)');
            // if ($(this).)
        });

        //对添加关注进行显示
        $('.edit-page-main .titles div').click(function () {
            $('.edit-page-main .titles > div').removeClass('on');
            $(this).addClass('on');
            // var cWidth = window.innerWidth;
            var cWidth = $('.edit-headA').width();
            $('.edit-page-main .swiper-wrapper').css('transform','translate3d(-'+$(this).attr('data')*cWidth+'px, 0px, 0px)');
        });

        //选中和解除选中
        $('.add-list').on('click','li[data-v-145cf773]',function(){
            if($(this).hasClass('selected')){
                $(this).removeClass('selected')
            }else{
                $(this).addClass('selected')
            }
        });

        //点击编辑显示弹出层
        $('.head_edit').click(function(){
            var user_id = "<?php echo (session('user_id')); ?>";
            if(user_id == ''){
                return window.location.href="<?php echo U('Login/login');?>";
            } else {
                $('.bianji').show();
                $('.page-main,#head').hide();
            }
        });

        //点击添加 显示弹出层
        $('.head_add').click(function(){
            var user_id = "<?php echo (session('user_id')); ?>";
            if(user_id == ''){
                return window.location.href="<?php echo U('Login/login');?>";
            } else {
                $('.add').show();
                $('.page-main,#head').hide();
            }
        });

        //点击删除
        $('.edit-content .edit-list > div .del[data-v-145cf773]').click(function(){
            $('.edit-content .edit-list > div[data-v-145cf773]').removeClass('deleteX')
            $(this).parent().addClass('deleteX')
        });
        //点击body不让删除
        $('body').click(function(e){
            if(!$(e.target).hasClass('del')){
                $('.edit-content .edit-list > div[data-v-145cf773]').removeClass('deleteX')
            }
        });

        //点击关闭弹出层
        $('.arrow_left').click(function(){
            $('.edit').hide();
            $('.add').hide();
            $('.bianji').hide();
            $('.page-main,#head').show();
        });


        //获取当前品种宽度 自动加载当前产品对应列表
        var index   = "<?php echo ($index); ?>";
        // var cWidth  = window.innerWidth;
        var cWidth  = $('.list_class').width();
        $('.list-wrapper').css('transform','translate3d(-'+(parseInt(index)+1)*cWidth+'px, 0px, 0px)');

        //对产品分类执行选中状态
        $.each($('.list_class > div'),function(){
            if((parseInt(index)+1) == $(this).attr('data')){
                $('.page-main .titles > div').removeClass('on');
                $(this).addClass('on');
                if ($(this).attr('data') == 0){
                    $('.head_edit,.head_add').show();
                }else {
                    $('.head_edit,.head_add').hide();
                }
            }
        });

        $('.list_class > div').click(function () {
            if ($(this).attr('data') != 0){
                $('.head_edit,.head_add').hide();
            }else {
                $('.head_edit,.head_add').show();
            }
        });


        //设置底部导航选中状态
        // $('.footer > ul > li').eq(1).find('a').addClass('common2');
        // $('.footer > ul > li').eq(1).find('em').addClass('selected');
        $('.headertop .wapper > ul > li').eq(1).find('a').addClass('active');
    });
</script>


<script type="text/javascript" src="/Public//Home/css/layer/layer.js"></script>
<script type="text/javascript">

    //删除自选产品
    function delOption(option_id='')
    {
       if(option_id == '')
       {
            return layer.msg('删除失败');
       }
       var index = layer.load(2);
       $.post('<?php echo U("selfOptionDel");?>', {'option_id': option_id}, function(data){

            if(data.code == 400)
            {   layer.close(index);
                return layer.msg(data.msg);
            } else {
                layer.close(index);
                layer.msg(data.msg);
                $('.empty_'+option_id+'').parent().remove();    //删除之后自动清除当前元素
            }
       }, 'json');
    }


    /**
     * [addUserOption 添加自选产品]
     */
    function addUserOption()
    {
        var arr = [];
        $.each($('.add-list > .selected'),function(){
            arr.push($(this).attr('data-id'));
        });

        idStr = arr.join(',');


        console.log(idStr);


        var load2 = layer.load(2);

        $.post("<?php echo U('addUserOption');?>",{'id':idStr},function(data){

            if(data.code == 400)
            {
                layer.close(load2);
                return layer.msg(data.msg);
            } else {
                layer.close(load2);
                return location.reload();
            }

        },'json');
    }


</script>
</body>
</html>