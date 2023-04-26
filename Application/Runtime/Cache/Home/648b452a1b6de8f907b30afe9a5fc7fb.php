<?php if (!defined('THINK_PATH')) exit();?>    <!DOCTYPE html>
<html data-n-head="" lang="zh-tw">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta data-n-head="true" content="Meta description" name="description" data-hid="description">
    <meta data-n-head="true" content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, user-scalable=no,minimum-scale=1.0, maximum-scale=1.0,viewport-fit=contain" data-n-head="true">
    <!--<meta name="viewport" content="... viewport-fit=cover"/>-->
    <title data-n-head="true"><?php echo (L("order_details")); ?></title>
    <link href="/Public/Qts/Home/css/common.css" rel="stylesheet">
    <style data-vue-ssr-id="7117ae39:0 309b0fcd:0">.page-main[data-v-9f8bfaaa] {
        padding-bottom: 0
    }

    .variety-name[data-v-9f8bfaaa] {
        font-weight: 500;
        font-size: .16rem;
        color: #888;
        margin-right: .1rem
    }

    .order-title[data-v-9f8bfaaa] {
        line-height: .25rem
    }

    .variety-order[data-v-9f8bfaaa] {
        color: #999
    }

    .order-detail[data-v-9f8bfaaa] {
        color: #999;
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
        background: #171520
    }

    .main ul li[data-v-9f8bfaaa]:nth-of-type(2n) {
        background: #171520
    }

    .infos[data-v-9f8bfaaa] {
        width: 100%;
        margin-bottom: 1rem
    }

    .infos .line[data-v-9f8bfaaa] {
        width: 100%;
        /*padding: .25rem 0;*/
        background: #fff;
        padding-top: 0
    }

    .line img[data-v-9f8bfaaa] {
        display: block;
        width: 100%
    }

    .infos .order-info[data-v-9f8bfaaa] {
        background: #1c1a25;
        padding: 0 .15rem
    }

    .order-info p[data-v-9f8bfaaa] {
        line-height: .25rem;
        color: #999;
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
        width: 20%;
        margin-bottom: .1rem
    }

    @media screen and (max-width: 370px) {
        .detail > div[data-v-9f8bfaaa] {
            width: 25%
        }
    }

    .detail p.max[data-v-9f8bfaaa] {
        font-size: .14rem;
        color: #FCFCFE;
        line-height: .2rem
    }

    .detail p.min[data-v-9f8bfaaa] {
        font-size: .11rem;
        color: #999;
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
        border-top: .01rem solid #c8c8c8;
        border-right: .01rem solid #c8c8c8;
        -ms-transform: rotate(135deg);
        transform: rotate(135deg);
        -webkit-transform: rotate(135deg);
        position: absolute;
        top: .05rem;
        right: 0
    }

    .total em.up[data-v-9f8bfaaa] {
        -ms-transform: rotate(-45deg);
        transform: rotate(-45deg);
        -webkit-transform: rotate(-45deg)
    }

    .dealer[data-v-9f8bfaaa] {
        color: #666;
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
    }</style>
</head>
<body data-n-head="">
<div id="__nuxt">
    <div class="progress" data-v-4a8a9a01="" style="width:0;height:2px;background-color:#012861;opacity:0"></div>
    <div class="content" data-v-9f8bfaaa="">
        <div id="head" data-v-9f8bfaaa="">
            <div class="head_content"><h3 class="product-name"><span><?php echo ($order["option_name"]); ?>(<?php echo ($order["order_result_note"]); ?>)</span><em></em></h3>
                <div class="left" onclick="window.history.back();"><a class="arrow_left"></a></div>
                <div class="right arrow_right"><b></b></div>
            </div>
        </div>
        <section class="page-main" data-v-9f8bfaaa="">
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