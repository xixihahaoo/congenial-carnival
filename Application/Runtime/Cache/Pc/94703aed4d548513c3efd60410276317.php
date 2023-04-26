<?php if (!defined('THINK_PATH')) exit();?>    <!DOCTYPE html>
<html data-n-head="" lang="zh-TW">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta data-n-head="true" content="Meta description" name="description" data-hid="description">
    <meta data-n-head="true" content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, user-scalable=no,minimum-scale=1.0, maximum-scale=1.0,viewport-fit=contain" data-n-head="true">
    <title data-n-head="true"><?php echo (L("transaction_records")); ?></title>
    <link href="/Public/Qts/Home/css/common.css" rel="stylesheet">
    <link rel="stylesheet" href="/Public//Qts/Home/js/layerui/css/layui.css"  media="all">
    <link href="/Public//Qts/Home/css/pcPublic.css" rel="stylesheet">
    <style>

        ul.lists[data-v-161fa528] {
            width: 100%;
            padding: .15rem
        }

        ul.lists li[data-v-161fa528] {
            width: 100%;
            padding: .1rem .15rem .1rem .25rem;
            border-bottom: 1px solid #ddd;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            display: -webkit-flex;
            position: relative;
            color: #ddd !important;
            /*-webkit-box-shadow: 0 2px 5px #ebeff3;*/
            /*box-shadow: 0 2px 5px #ebeff3;*/
            border-radius: .1rem;
            margin-bottom: .2rem
        }

        ul.lists li > div.left[data-v-161fa528] {
            -webkit-box-flex: 4;
            -ms-flex: 4;
            flex: 4;
            -webkit-flex: 4;
            border-right: .01rem solid #444;
            padding-left: .05rem
        }

        ul.lists li > div.right[data-v-161fa528] {
            -webkit-box-flex: 1;
            -ms-flex: 1;
            flex: 1;
            -webkit-flex: 1;
            padding-left: .1rem
        }

        ul.lists li p[data-v-161fa528] {
            line-height: .2rem
        }

        ul.lists li span.hands[data-v-161fa528], ul.lists li span.name[data-v-161fa528] {
            font-size: .14rem;
            color: #ddd
        }

        ul.lists li span.tag[data-v-161fa528] {
            display: inline-block;
            vertical-align: middle;
            width: .16rem;
            height: .16rem;
            text-align: center;
            line-height: .16rem;
            color: #fff !important;
            font-size: .1rem;
            border-radius: .08rem;
            margin: 0 .05rem
        }

        ul.lists li span.ask[data-v-161fa528], ul.lists li span.open[data-v-161fa528] {
            font-size: 12px;
            color: #ddd
        }

        ul.lists li span.ask[data-v-161fa528] {
            padding-left: .1rem
        }

        .txt_red[data-v-161fa528] {
            color: #f64e43 !important
        }

        .txt_green[data-v-161fa528] {
            color: #00cf8c !important
        }

        .bg_red[data-v-161fa528] {
            background: #f64e43 !important;
            color: #fff
        }

        .bg_green[data-v-161fa528] {
            background: #00cf8c !important;
            color: #fff
        }

        ul.lists li div.right[data-v-161fa528] {
            text-align: center
        }

        ul.lists li span.win[data-v-161fa528] {
            font-size: .14rem
        }

        ul.lists li span.sale[data-v-161fa528] {
            display: block;
            margin: 0 auto;
            width: .48rem;
            height: .23rem;
            text-align: center;
            line-height: .23rem;
            border: .01rem solid #2187f7;
            color: #2187f7;
            font-size: .14rem
        }

        .put[data-v-161fa528], ul.lists li.put span.sale[data-v-161fa528] {
            margin-top: .15rem
        }

        .showimgtip[data-v-161fa528] {
            width: .28rem;
            position: absolute;
            top: 0;
            right: 0
        }

        .float[data-v-161fa528] {
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            background: rgba(0, 0, 0, .4);
            z-index: 9999
        }

        .sift[data-v-161fa528] {
            background: #fff;
            border-radius: 5px;
            padding: .1rem;
            position: absolute;
            top: .55rem;
            right: .05rem
        }

        .sift ul[data-v-161fa528] {
            width: 100%;
            position: relative
        }

        .sift ul[data-v-161fa528]:after {
            content: "";
            width: 0;
            height: 0;
            border-left: .1rem solid transparent;
            border-right: .1rem solid transparent;
            border-bottom: .1rem solid #fff;
            position: absolute;
            top: -.2rem;
            right: .06rem
        }

        .sift ul li[data-v-161fa528] {
            line-height: 35px;
            border-bottom: 1px solid #ddd;
            color: #000;
            font-size: .14rem;
            text-align: center;
            width: .8rem;
            cursor: pointer;
        }

        .sift ul li.on[data-v-161fa528] {
            color: #2187f7
        }

        .sift ul li[data-v-161fa528]:last-child {
            border: none
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
        .page-main h3 .left {
          position: absolute;
          left: 160px;
          color: #77abf4;
          font-size: 14px;
          top: 0;
          margin-right: 0;
          line-height: 110px;
          cursor: pointer;
        }
    </style>
</head>
<body>

    <input type="hidden" name="orderType" value="0">

<div id="__nuxt">
    <div class="progress" data-v-4a8a9a01=""
         style="width: 0%; height: 2px; background-color: rgb(1, 40, 97); opacity: 0;"></div>
    <div data-v-161fa528="" class="content">
        <!--<div data-v-161fa528="" id="head" style="width: 60%">-->
            <!--<div class="head_content"><h3 class="product-name"><span><?php echo (L("transaction_records")); if(($user['now_trade_status']) == "2"): ?>（<?php echo (L("simulation")); ?>）<?php endif; ?></span><em></em></h3>-->
                <!--<div class="left" onclick="window.location.href='<?php echo ($urlcan); ?>'"><a class="arrow_left"></a></div>-->
                <!--<div class="right arrow_right"><b><?php echo (L("screening")); ?></b></div>-->
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
        <section data-v-161fa528="" class="page-main">
            <h3>
              <span><?php echo (L("transaction_records")); if(($user['now_trade_status']) == "2"): ?>（<?php echo (L("simulation")); ?>）<?php endif; ?></span>
              <a href="javascript: void (0);" onclick="window.location.href='<?php echo ($urlcan); ?>'"><?php echo (L("back")); ?></a>
              <div class="left arrow_right"><b><?php echo (L("screening")); ?></b></div>
            </h3>
            <div data-v-161fa528="">
                <div data-v-161fa528="" class="trade-list">
                    <div data-v-ecaca2b0="" data-v-161fa528="" id="outer-vhr7b" class="_v-container" snappingheight="50"
                         style="top: 0.5rem;">
                        <div data-v-ecaca2b0="" id="inner-3rvho" class="_v-content"
                             style="transform: translate3d(0px, 0px, 0px) scale(1);">
                            <ul data-v-161fa528="" data-v-ecaca2b0="" class="lists">


                            </ul>
                            <div data-v-ecaca2b0="" class="loading-layer" id="LAY_demo1"></div>

                        </div>
                    </div>
                </div>
            </div>
            <div data-v-161fa528="" class="float" style="display: none;">
                <div data-v-161fa528="" class="sift">
                    <ul data-v-161fa528="">
                        <li data-v-161fa528="" data-order-type=0><?php echo (L("all")); ?></li>
                        <li data-v-161fa528="" data-order-type=2><?php echo (L("follow")); ?></li>
                        <li data-v-161fa528="" data-order-type=1><?php echo (L("own")); ?></li>
                        <li data-v-161fa528="" data-order-type=3><?php echo (L("cancel")); ?></li>
                    </ul>
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
    </div>
</div>
</body>
</html>





<script src="/Public//Qts/Home/js/template.js"></script>
<script src="/Public/Qts/Home/js/jquery.js"></script>

<script id="template" type="text/html">
    {{each data as vo}}
    {{if vo.orderType == 1}}
        <a href="<?php echo U('recordDetails');?>?oid={{vo.oid}}">
            <li data-v-161fa528="" data-v-ecaca2b0="" class="list-hold">
                <div data-v-161fa528="" data-v-ecaca2b0="" class="left">
                    <p data-v-161fa528="" data-v-ecaca2b0="">
                        <span data-v-161fa528="" data-v-ecaca2b0="" class="name">{{vo.option_name}}</span>
                        <span data-v-161fa528="" data-v-ecaca2b0="" class="tag {{vo.ostyleColor}}">{{vo.ostyleMsg}}</span>
                        {{if vo.order_scene == 1}}
                        <em data-v-161fa528="" data-v-ecaca2b0="" class="hands"> x {{vo.onumber}} <?php echo (L("lots")); ?></em>
                        {{else}}
                        <em data-v-161fa528="" data-v-ecaca2b0="" class="hands"> $ {{vo.Bond}}</em>
                        {{/if}}
                    </p>
                    <p data-v-161fa528="" data-v-ecaca2b0="">
                        <span data-v-161fa528="" data-v-ecaca2b0="" class="open"><?php echo (L("opening_price")); ?>  {{vo.buyprice}}</span>
                        <span data-v-161fa528="" data-v-ecaca2b0="" class="ask"><?php echo (L("exit_price")); ?>  {{vo.sellprice}}</span>
                    </p>

                    {{if vo.order_scene == 1}}
                    <p data-v-161fa528="" data-v-ecaca2b0="">
                        <span data-v-161fa528="" data-v-ecaca2b0="" class="open"><?php echo (L("target_profit")); ?>  {{vo.endprofit}}</span>
                        <span data-v-161fa528="" data-v-ecaca2b0="" class="ask"><?php echo (L("stop_loss")); ?>  {{vo.endloss}}</span>
                    </p>
                    {{else}}
                    <p data-v-161fa528="" data-v-ecaca2b0="">
                        <span data-v-161fa528="" data-v-ecaca2b0="" class="open"><?php echo (L("hold_time")); ?>  {{vo.second}} s</span>
                    </p>
                    {{/if}}
                </div>
                <div data-v-161fa528="" data-v-ecaca2b0="" class="right">
                    <div data-v-161fa528="" data-v-ecaca2b0="">
                        <p data-v-161fa528="" data-v-ecaca2b0="" class="" style="padding-top: 0.1rem;">
                            <span data-v-161fa528="" data-v-ecaca2b0=""><?php echo (L("cover")); ?></span>
                        </p>
                        <p data-v-161fa528="" data-v-ecaca2b0="">
                            <span data-v-161fa528="" data-v-ecaca2b0="" class="win {{vo.plossColor}}">${{vo.ploss}}</span>
                        </p>
                    </div>
                </div>
            </li>
        </a>
    {{else}}
        <li data-v-161fa528="" data-v-ecaca2b0="" class="list-hold">
            <div data-v-161fa528="" data-v-ecaca2b0="" class="left">
                <p data-v-161fa528="" data-v-ecaca2b0="">
                    <span data-v-161fa528="" data-v-ecaca2b0="" class="name">{{vo.option_name}}</span>
                    <span data-v-161fa528="" data-v-ecaca2b0="" class="tag {{vo.ostyleColor}}">{{vo.ostyleMsg}}</span>
                    <em data-v-161fa528="" data-v-ecaca2b0="" class="hands"> x {{vo.onumber}} <?php echo (L("lots")); ?></em>
                </p>
                <p data-v-161fa528="" data-v-ecaca2b0="">
                    <span data-v-161fa528="" data-v-ecaca2b0="" class="open"><?php echo (L("entrust")); ?>  {{vo.guadan_price}}</span>
                </p>
                <p data-v-161fa528="" data-v-ecaca2b0="">
                    <span data-v-161fa528="" data-v-ecaca2b0="" class="open"><?php echo (L("target_profit")); ?>  {{vo.endprofit}}</span>
                    <span data-v-161fa528="" data-v-ecaca2b0="" class="ask"><?php echo (L("stop_loss")); ?>  {{vo.endloss}}</span>
                </p>
            </div>
            <div data-v-161fa528="" data-v-ecaca2b0="" class="right">
                <div data-v-161fa528="" data-v-ecaca2b0="">
                    <p data-v-161fa528="" data-v-ecaca2b0="" class="put" style="padding-top: 0.1rem;">
                        <span data-v-161fa528="" data-v-ecaca2b0=""><?php echo (L("already_cancel")); ?></span>
                    </p>
                </div>
            </div>
        </li>
    {{/if}}
    {{/each}}
</script>


<script>
    $('.arrow_right').click(function () {
        $('.float').show();
        $('html').css({"overflow":"hidden","height":"100%"});
        $('body').css({"overflow":"hidden","height":"100%"});
    })
    $('.float').click(function (e) {
        if (!$(e.target).hasClass('sift')) {
            $('.float').hide();
            $('html').css({"overflow":"auto","height":"auto"});
            $('body').css({"overflow":"auto","height":"auto"});
        }
    });
</script>

<script src="/Public//Qts/Home/js/layerui/layui.js" charset="utf-8"></script>
<script type="text/javascript">
layui.use('flow', function(){
  var flow = layui.flow;

  flow.load({
    elem: '#LAY_demo1' //流加载容器
    ,scrollElem: '' //滚动条所在元素，一般不用填，此处只是演示需要。
    ,done: function(page, next){ //执行下一页的回调

      //模拟数据插入
      setTimeout(function(){
        var lis = [];

        var lists = GetRecordOrder(page);
        $('.lists').append(lists);

        next(lis.join(''), page < "<?php echo ($count); ?>");
          $('#LAY_demo1 > div > a > cite').html('<?php echo (L("load_more")); ?>');
      }, 1500);
    }
  });
    $('#LAY_demo1 > div > a > cite').html('<?php echo (L("load_more")); ?>');
});
</script>

<script type="text/javascript" src="/Public//Home/css/layer_mobile/layer.js"></script>
<script type="text/javascript">

var loading = "<?php echo (L("loading")); ?>";

window.onload=function(){
    var index = layer.open({type: 2,shadeClose:false,content:loading});
    var lists = GetRecordOrder(1,index);
    $('.lists').html(lists);
}


/**
 * 获取订单信息
 */
function GetRecordOrder(page=1,index)
{
    var  orderType = $('input[name=orderType]').val();
    $.ajax({
        url:"<?php echo U('GetRecordOrder');?>",
        async:false,
        dataType:'json',
        type:'get',
        data:{'page':page,'orderType':orderType},
        success:function(data){
            layer.close(index);
            if(data.code == 200)
            {
                lists = template('template', data);
                if(data.data.length < 10) {
                    $('#LAY_demo1 > div').html('<?php echo (L("no_more")); ?>');
                    return;
                }

            } else {
                lists = '';
            }
        },
        error:function(response){
            console.log(response);
        }

    });

    return lists;
}

//检索
$('.sift > ul > li').on('click',function(){

    var orderType = $(this).attr('data-order-type');
    $('input[name=orderType]').val(orderType);

    var index = layer.open({type: 2,shadeClose:false,content:loading});
    var lists = GetRecordOrder(1,index);
    $('.lists').html(lists);
});


</script>