<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html data-n-head="" lang="zh-tw">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta data-n-head="true" content="Meta description" name="description" data-hid="description">
    <meta data-n-head="true" content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, user-scalable=no,minimum-scale=1.0, maximum-scale=1.0,viewport-fit=contain" data-n-head="true">
    <!--<meta name="viewport" content="... viewport-fit=cover"/>-->
<title data-n-head="true"><?php echo config('webname');?></title>

<link rel="stylesheet" href="/Public/Qts/Home/css/swiper.min.css">
<script src="/Public/Qts/Home/js/jquery.js"></script>
<script src="/Public/Qts/Home/js/swiper.min.js"></script>
<link href="/Public/Qts/Home/css/common.css" rel="stylesheet">
<link href="/Public/Qts/Home/css/style.css" rel="stylesheet">


<style data-n-head="true" type="text/css">
    body {
        -webkit-text-size-adjust: none;
        background: #1F1d28;
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

    </style>
</head>
<body data-n-head="">
<div id="__nuxt">
    <div class="progress" data-v-4a8a9a01="" style="width:0;height:2px;background-color:#012861;opacity:0"></div>
    <div data-v-63966bdb="" class="bgImgContent">
        <section data-v-63966bdb="" class="page-main">
            <div data-v-f2c7254e="" data-v-63966bdb="" class="swiper-wrap">
                <!-- Swiper -->
                <div class="swiper-container swiper-container1">
                    <div class="swiper-wrapper">
    
                        <?php if(is_array($newsinfo)): $i = 0; $__LIST__ = $newsinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="swiper-slide">
                                <?php if($vo['n_type'] == 1): ?><a href="<?php echo U('adDetails',array('nid' =>$vo['nid']));?>">
                                        <img src="/Uploads/<?php echo ($vo["ncover"]); ?>" alt="">
                                    </a>
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
            <ul data-v-63966bdb="" class="content-tip">

                <li data-v-63966bdb="" class="mr14">
                    <a href="<?php echo U('advanced');?>">
                        <img data-v-63966bdb="" src="/Public/Qts/Home/img/index/book.png">
                        <p data-v-63966bdb="" class="title"><?php echo (L("beginner_must")); ?></p>
                        <p data-v-63966bdb="" class="sub-title"><?php echo (L("from_to")); ?></p>
                    </a>
                </li>

                <li data-v-63966bdb="" class="mr14">
                    <a href="<?php echo U('watch');?>">
                        <img data-v-63966bdb="" src="/Public/Qts/Home/img/index/gather.png">
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

                <li data-v-63966bdb="" class="mr14">
                    <a href="<?php echo U('Lang/index');?>">
                        <img data-v-63966bdb="" src="/Public/Qts/Home/img/index/lang.png">
                        <p data-v-63966bdb="" class="title"><?php echo (L("common_language")); ?></p>
                        <p data-v-63966bdb="" class="sub-title"><?php echo (L("common_language_des")); ?></p>
                    </a>
                </li>
            </ul>

            <?php if($lang == 'zh-cn'): ?><div data-v-63966bdb="" class="notice_cn">
                <?php elseif($lang == 'zh-tw'): ?>
                    <div data-v-63966bdb="" class="notice_tw">
                <?php else: ?>
                    <div data-v-63966bdb="" class="notice_en"><?php endif; ?>

                <div data-v-63966bdb="" class="dashi-wrap">
                    <!-- Swiper -->
                    <div class="swiper-container swiper-container2">
                        <div class="swiper-wrapper">
                            <?php if(is_array($stretch)): $i = 0; $__LIST__ = $stretch;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="swiper-slide" onclick="window.location.href='<?php echo U('Stretch/stretchDetails',array('id' => $vo['id']));?>'"><a href="<?php echo U('Stretch/stretchDetails',array('id' => $vo['id']));?>"><?php echo ($vo["title"]); ?></a>
                                </div><?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                    </div>
                </div>
                    <a href="<?php echo U('Stretch/stretchList');?>">
                    <img data-v-63966bdb="" src="/Public/Qts/Home/img/index/right.png" class="arrow-right" style="z-index: 9999">
                    </a>
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
                    <a href="<?php echo U('profitAll');?>">
                        <p data-v-63966bdb="" class="earnings-tips"><?php echo (L("show_master")); ?><em data-v-63966bdb="" class="arrow">
                            &gt;</em></p>
                    </a>
                </div>
            </div>
        </section><!---->


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

        <div data-v-18c6d448="" data-v-63966bdb="" class="footer">
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
                <a data-v-18c6d448="" class="footer_common4">
                </a>
                <em data-v-18c6d448="" class=""><?php echo (L("common_position")); ?></em>
            </li>

            <!--<li data-v-18c6d448="" onclick="jumpUrl('<?php echo U('Broadcast/index');?>')">-->
                <!--<a data-v-18c6d448="" class="footer_common5"></a>-->
                <!--<em data-v-18c6d448="" class=""><?php echo (L("live")); ?></em>-->
            <!--</li>-->

            <li data-v-18c6d448="" onclick="jumpUrl('<?php echo U('User/index');?>')">
                <a data-v-18c6d448="" class="footer_common3">
                    <?php if($NoreadCount >= '1'): ?><span data-v-18c6d448=""></span><?php endif; ?>
                </a>
                <em data-v-18c6d448="" class=""><?php echo (L("common_my")); ?></em>
            </li>
        </ul>
    </div>
<style>

</style>
    <script type="text/javascript">
        function jumpUrl(url) {
            window.location.href = url;
        }
    </script>

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
        $('.footer > ul > li').first().find('a').addClass('common1');
        $('.footer > ul > li').first().find('em').addClass('selected');
    }

</script>
</body>
</html>