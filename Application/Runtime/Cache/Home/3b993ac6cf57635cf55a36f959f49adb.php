<?php if (!defined('THINK_PATH')) exit();?>    <!DOCTYPE html>
<html data-n-head="" lang="zh-tw">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta data-n-head="true" content="Meta description" name="description" data-hid="description">
    <meta data-n-head="true" content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, user-scalable=no,minimum-scale=1.0, maximum-scale=1.0,viewport-fit=contain" data-n-head="true">
    <!--<meta name="viewport" content="... viewport-fit=cover"/>-->
    <title data-n-head="true"><?php echo (L("position")); ?></title>
    <link rel="stylesheet" href="/Public/Qts/Home/css/swiper.min.css">
    <link href="/Public/Qts/Home/css/common.css" rel="stylesheet">
    <link href="/Public/Qts/Home/css/style.css" rel="stylesheet">

    <style data-vue-ssr-id="1e7e60bc:0 5e000063:0 cf79f97a:0">
        .head h3[data-v-145cf773] {
            height: .4rem;
            font-size: .18rem;
            position: relative
        }

        .head_tab li[data-v-145cf773] {
            -webkit-box-flex: 1;
            -ms-flex: 1;
            flex: 1;
            height: .3rem;
            line-height: .3rem;
            border-radius: .4rem
        }

        .title_right div[data-v-145cf773] {
            -webkit-box-flex: 1;
            -ms-flex: 1;
            flex: 1;
            -webkit-flex: 1
        }

        .variety li[data-v-145cf773] {
            width: 100%;
            height: .55rem;
            overflow: hidden;
            position: relative
        }

        .add-list li[data-v-145cf773]:after, .edit-list > div[data-v-145cf773]:after, .title_top[data-v-145cf773]:after, .variety li[data-v-145cf773]:after {
            content: "";
            display: block;
            position: absolute;
            left: -50%;
            bottom: 0;
            width: 200%;
            height: 1px;
            background: #ededed;
            -webkit-transform: scale(.5)
        }

        .variety_right div[data-v-145cf773] {
            -webkit-box-flex: 1;
            -ms-flex: 1;
            flex: 1;
            -webkit-flex: 1;
            border-radius: .02rem;
            font-size: .15rem;
            -webkit-box-sizing: border-box;
            box-sizing: border-box
        }

        .variety_right div[data-v-145cf773]:first-of-type {
            margin-right: .12rem
        }

        .variety_right div[data-v-145cf773]:nth-of-type(3) {
            margin-left: .12rem
        }

        @-webkit-keyframes move {
            0% {
                -webkit-transform: translateY(1000px)
            }
            to {
                -webkit-transform: translateX(0, 0)
            }
        }

        @-webkit-keyframes add {
            0% {
                -webkit-transform: translateY(1000px)
            }
            to {
                -webkit-transform: translateX(0, 0)
            }
        }

        @-webkit-keyframes pos {
            to {
                position: fixed
            }
        }

        .trade-top[data-v-7ecec926] {
            padding: 0 .15rem;
            /*background-image: -webkit-gradient(linear, left top, left bottom, from(#012861), to(#004895));*/
            /*background-image: -o-linear-gradient(top, #012861 0, #004895 100%);*/
            /*background-image: linear-gradient(-180deg, #012861, #004895);*/
            padding-bottom: .4rem;
            position: relative;
            padding-top: .2rem
        }

        .history[data-v-7ecec926] {
            position: absolute;
            right: 0;
            top: .2rem
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
            background: #ffbf23;
            color: #000
        }

        .history span.recharge[data-v-7ecec926] {
            background: #ffbf23;
            color: #000
        }

        .title[data-v-7ecec926] {
            height: .22rem;
            line-height: .22rem;
            font-size: .14rem;
            color: #fff;
            text-align: left;
            margin-top: .1rem
        }

        .float-money[data-v-7ecec926] {
            line-height: .34rem;
            text-align: left;
            font-size: .3rem;
            color: #ffbf23;
            line-height: .4rem
        }

        .finance-wrap[data-v-7ecec926] {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            display: -webkit-flex;
            padding: .1rem 0
        }

        .finance-list[data-v-7ecec926] {
            -webkit-box-flex: 1;
            -ms-flex: 1;
            flex: 1;
            -webkit-flex: 1;
            text-align: left;
            border-right: 1px solid #444;
            padding-left: .15rem
        }

        .finance-list[data-v-7ecec926]:last-child {
            border: 0 none
        }

        .finance-list[data-v-7ecec926]:first-child {
            padding-left: 0
        }

        .finance-txt[data-v-7ecec926] {
            font-size: .12rem;
            color: #fff;
            opacity: .7
        }

        .fianace-num[data-v-7ecec926] {
            font-size: .17rem;
            color: #fff
        }

        .showimgtip[data-v-7ecec926] {
            width: .28rem;
            position: absolute;
            top: 0;
            right: 0
        }

        .titles[data-v-7ecec926] {
            width: 100%;
            height: 36px;
            /*background: #1F222B;*/
            z-index: 99;
            /*position: fixed;*/
            top: 1.8rem
        }

        .titles > div[data-v-7ecec926] {
            width: 25%;
            float: left;
            color: #FCFCFE;
            text-align: center;
            line-height: .36rem
        }

        .titles > div.on[data-v-7ecec926] {
            color: #ffbf23;
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
            background: #ffbf23;
            position: absolute;
            bottom: 0;
            left: 50%;
            margin-left: -15%;
            border-radius: .2rem
        }

        .trade-box[data-v-7ecec926] {
            position: absolute;
            width: 100%;
            top: 0;
            bottom: 0;
            height: 100%;
            overflow-y: scroll;
            /*overflow-y: hidden;*/
        }

        .lists[data-v-7ecec926] {
            width: 100%;
            /*background: #1F222B;*/
            position: absolute;
            top: 2.16rem;
            bottom: 0;
            overflow: hidden;
            margin-top: .3rem;
        }

        .lists ul[data-v-7ecec926] {
            width: 100% !important;
            /*padding: .15rem;*/
            padding-bottom: .7rem;
            height: 100%;
            overflow-y: scroll
            /*overflow-y: hidden*/
        }

        .lists ul li[data-v-7ecec926] {
            width: 100%;
            padding: .05rem .2rem;
            background: #fff;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            display: -webkit-flex;
            position: relative;
            /*-webkit-box-shadow: 0 2px 5px #ebeff3;*/
            /*box-shadow: 0 2px 5px #ebeff3;*/
            border-radius: .1rem;
            margin-bottom: .2rem
        }

        .lists ul li > div.left[data-v-7ecec926] {
            -webkit-box-flex: 4;
            -ms-flex: 4;
            flex: 4;
            -webkit-flex: 4;
            border-right: .01rem solid #444;
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
            font-size: .16rem;
            color: #888;
            /* display:block;
            padding-top:0.08rem;
            padding-left:.5rem; */
        }
		.lists ul.follow li span.hands[data-v-7ecec926], .lists ul.follow li span.name[data-v-7ecec926]{
			display:block;
            padding-top:0.08rem;
            padding-left:.5rem;
		}
        .lists ul li span.tag[data-v-7ecec926] {
            display: inline-block;
            vertical-align: middle;
            /*width: .16rem;*/
            /*height: .16rem;*/
            text-align: center;
            line-height: .16rem;
            /*color: #fff !important;*/
            font-size: .1rem;
            border-radius: .03rem;
            padding:.01rem .03rem;
            margin: 0 .05rem
        }

        .lists ul li span.ask[data-v-7ecec926], .lists ul li span.open[data-v-7ecec926] {
            font-size: 12px;
            color: #999
        }

        .lists ul li span.ask[data-v-7ecec926] {
            padding-left: .1rem
        }

        .txt_red[data-v-7ecec926] {
            color: #e44c72 !important
        }

        .txt_green[data-v-7ecec926] {
            color: #00cf8c !important
        }

        .bg_red[data-v-7ecec926] {
            /*background: #f64e43 !important;*/
            border: 1px solid #e44c72;
            color: #e44c72
        }

        .bg_green[data-v-7ecec926] {
            /*background: #00cf8c !important;*/
            border: 1px solid #00cf8c;
            color: #00cf8c
        }

        .lists ul li div.right[data-v-7ecec926] {
            text-align: center;
            /* margin-top:.12rem; */
        }
        .lists ul.follow li div.right{
        	margin-top:0.12rem;
        }

        .lists ul li span.win[data-v-7ecec926] {
            font-size: .14rem
        }

        .lists ul li span.sale[data-v-7ecec926] {
            display: block;
            margin: 0 auto;
            width: .7rem;
            height: .23rem;
            text-align: center;
            line-height: .23rem;
            border: .01rem solid #ffbf23;
            color: #ffbf23;
            font-size: .14rem
        }

        .lists ul li.put span.sale[data-v-7ecec926] {
            margin-top: .15rem
        }

        .waiting[data-v-7ecec926] {
            width: .32rem;
            height: .32rem;
            margin: .2rem auto
        }

        .waiting img[data-v-7ecec926] {
            display: block;
            width: 100%
        }

        .nomore[data-v-7ecec926] {
            width: 100%;
            text-align: center;
            color: #999;
            font-size: .14rem;
            line-height: .3rem
        }
        .list-hold{
            background: rgba(0,0,0,.4) !important;
            color: #999999 !important;
        }

        .list-hold .follow p[data-v-7ecec926] {
            text-align: center;
            width: .1rem;
            color: #fff;
            margin: 0 .04rem;
            display: inline-block;
            vertical-align: middle;
            font-size: .1rem;
            line-height: .2rem;

        }

        .qts-content li {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex
        }

        .qts-content li span {
            -webkit-box-flex: 1;
            -ms-flex: 1;
            flex: 1
        }

        .qts-content li span:first-child {
            display: inline-block;
            text-align: right;
            color: #999;
            font-size: .16rem;
            margin-right: .05rem;
            min-width: 1rem
        }

        .qts-content li span:last-child {
            display: inline-block;
            text-align: left;
            margin-left: .1rem
        }

        .qts-content .txt_black {
            color: #999999 !important;
            font-size: .16rem;
            width: .6rem
        }

        .qts-window .btns {
            width: 100%;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            display: -webkit-flex;
            margin-top: .2rem
        }

        .qts-window .btns a {
            -webkit-box-flex: 1;
            -ms-flex: 1;
            flex: 1;
            -webkit-flex: 1;
            height: .44rem;
            display: block;
            text-align: center;
            line-height: .44rem;
            font-size: .17rem
        }

        .tab span[data-v-3fec6f8a] {
            display: block;
            -webkit-box-flex: 1;
            -ms-flex: 1;
            flex: 1;
            -webkit-flex: 1;
            height: .38rem;
            line-height: .4rem;
            text-align: center;
            color: #999;
            font-size: .17rem
        }

        .tab span.on[data-v-3fec6f8a] {
            color: #333;
            border-bottom: .02rem solid #ffbf23;
        }

        .chat-list li[data-v-3fec6f8a], .course-list li[data-v-3fec6f8a] {
            width: 100%;
            margin-bottom: .2rem;
            position: relative;
            clear: both
        }

        .chat-list li > div[data-v-3fec6f8a] {
            position: relative
        }

        .chat-list li.left img.tx[data-v-3fec6f8a], .course-list li img[data-v-3fec6f8a] {
            display: block;
            width: .45rem;
            height: .45rem;
            position: absolute;
            left: 0;
            top: 0;
            border-radius: .23rem
        }

        .chat-list li.right img.tx[data-v-3fec6f8a] {
            display: block;
            width: .45rem;
            height: .45rem;
            position: absolute;
            right: 0;
            top: 0;
            border-radius: .23rem
        }

        .course-list li .con[data-v-3fec6f8a] {
            width: auto;
            padding-left: .6rem
        }

        .course-list li .con b[data-v-3fec6f8a] {
            font-size: .15rem;
            color: #333;
            line-height: .22rem;
            display: block
        }

        .course-list li .con em[data-v-3fec6f8a] {
            font-size: .14rem;
            color: #666;
            display: block
        }

        .course-list li .con p[data-v-3fec6f8a] {
            font-size: .13rem;
            color: #666;
            line-height: .16rem
        }

        .chat-list li .contxt[data-v-3fec6f8a] {
            background: #fff;
            border: .01rem solid #ddd;
            padding: .08rem .1rem;
            border-radius: .04rem;
            font-size: 14px;
            color: #333;
            position: relative;
            max-width: 2rem;
            min-height: .42rem;
            word-break: break-all
        }

        .chat-list li.left .con[data-v-3fec6f8a] {
            float: left
        }

        .chat-list li.left .contxt img[data-v-3fec6f8a] {
            display: block;
            position: absolute;
            left: -.14rem;
            top: .03rem;
            width: .16rem
        }

        .chat-list li.right .contxt img[data-v-3fec6f8a] {
            display: block;
            position: absolute;
            right: -.14rem;
            top: .03rem;
            width: .16rem
        }

        .chat-list li.teacher .contxt[data-v-3fec6f8a], .chat-list li.teacher img.tx[data-v-3fec6f8a] {
            border: .01rem solid #ff9417
        }

        .chat-list li.right .contxt[data-v-3fec6f8a] {
            border: .01rem solid #ffbf23;
            background: #f7fbff;
            color: #ffbf23;
            max-width: 2rem;
            text-align: left
        }

        .chat-list li.left .con[data-v-3fec6f8a] {
            margin-left: .6rem
        }

        .chat-list li.right .con[data-v-3fec6f8a] {
            margin-right: .6rem;
            float: right;
            text-align: right
        }

        .chat-list li b[data-v-3fec6f8a] {
            font-size: .12rem;
            color: #333;
            line-height: .2rem;
            display: block;
            margin-left: .6rem
        }

        .chat-list li.teacher b[data-v-3fec6f8a] {
            color: #ff9417
        }

        .chat-list li.right b[data-v-3fec6f8a] {
            color: #ffbf23;
            text-align: right;
            padding-right: .6rem
        }

        .qts-window {
            position: fixed;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, .5);
            z-index: 999;
            top: 0;
            left: 0;
        }

        .qts-img {
            width: 75%;
            background: #1F222B;
            border-radius: 4px;
            position: absolute;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            -webkit-transform: translate(-50%, -50%);
            padding-top: .3rem;
        }

        .qts-name {
            text-align: center;
            margin-top: .1rem;
            padding: 0 .1rem .1rem;
            margin-bottom: 0;
            font-size: .2rem;
            font-weight: 700;
            color: #999999 !important;
        }

        .qts-content, .qts-order {
            line-height: .3rem;
            text-align: center;
        }

        .qts-order {
            font-size: .14rem;
            color: #b2b2b2;
        }

        .qts-content {
            padding: 10px 20px 15px;
            min-height: 36px;
            position: relative;
            font-size: .16rem;
            color: #999;
            margin: 0;
            margin-top: .15rem;
        }

        .qts-content li {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
        }

        .qts-content li span:first-child {
            display: inline-block;
            text-align: right;
            color: #999;
            font-size: .16rem;
            margin-right: .05rem;
            min-width: 1rem;
        }

        .qts-content .txt_black {
            color: #222;
            font-size: .16rem;
            width: .6rem;
        }

        .qts-content li span {
            -webkit-box-flex: 1;
            -ms-flex: 1;
            flex: 1;
        }

        .txt_black {
            color: #727272;
        }

        .txt_green {
            color: #00cf8c;
        }

        .qts-window .btns {
            width: 100%;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            display: -webkit-flex;
            margin-top: .2rem;
        }

        .qts-window .btns a {
            -webkit-box-flex: 1;
            -ms-flex: 1;
            flex: 1;
            -webkit-flex: 1;
            height: .44rem;
            display: block;
            text-align: center;
            line-height: .44rem;
            font-size: .17rem;
        }

        .btn-cancel {
            border-top: .01rem solid #ffbf23;
            color: #ffbf23;
        }

        .btn-cancel {
            border-top: .01rem solid #ffbf23;
            color: #ffbf23;
        }

        .btn-ok {
            border-top: .01rem solid #ffbf23;
            color: #000;
            background: #ffbf23;
        }

        .box {
            display: none;
        }
        .mint-msgbox[data-v-cd4b7ab0] {
            position: fixed;
            top: 50%;
            left: 50%;
            -webkit-transform: translate3d(-50%,-50%,0);
            transform: translate3d(-50%,-50%,0);
            background-color: #1F222B;
            width: 85%;
            border-radius: 3px;
            font-size: 16px;
            -webkit-user-select: none;
            overflow: hidden;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            -webkit-transition: .2s;
            -o-transition: .2s;
            transition: .2s;
            z-index: 1000;
        }
        .mint-msgbox-header[data-v-cd4b7ab0] {
            padding: 15px 0 0;
        }
        .mint-msgbox-content[data-v-cd4b7ab0] {
            padding: 5px 20px 15px;
            border-bottom: 1px solid #444;
            min-height: 36px;
            position: relative;
        }
        .mint-msgbox-btns[data-v-cd4b7ab0] {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            height: 40px;
            line-height: 40px;
        }
        .mint-msgbox-title[data-v-cd4b7ab0] {
            text-align: center;
            padding: 0 .1rem;
            margin-bottom: 0;
            font-size: .16rem;
            font-weight: 700;
            color: #999999;
        }
        .mint-msgbox-message[data-v-cd4b7ab0] {
            font-size: .16rem;
            color: #999;
            margin: 0;
            text-align: center;
            line-height: .3rem;
            margin-top: .15rem;
            margin-bottom: .15rem;
        }
        .mint-msgbox-message li {
            margin-left: -.38rem;
        }
        .mint-msgbox-message .txt_gray {
            color: #999;
            font-size: .16rem;
            margin-right: .05rem;
            min-width: 1rem;
        }
        .mint-msgbox-message li span {
            display: inline-block;
            text-align: right;
        }
        .txt_gray {
            color: #999;
        }
        .mint-msgbox-message .txt_black {
            color: #999;
            font-size: .16rem;
            width: .6rem;
        }
        .mint-msgbox-btn[data-v-cd4b7ab0] {
            line-height: 35px;
            display: block;
            background-color: #1F222B;
            -webkit-box-flex: 1;
            -ms-flex: 1;
            flex: 1;
            margin: 0;
            border: 0;
        }
        .mint-msgbox-cancel[data-v-cd4b7ab0] {
            width: 50%;
            border-right: 1px solid #444;
        }
        .mint-msgbox-confirm {
            color: #ffbf23;
        }
        .mint-msgbox-wrapper,.v-modal{
            display: none;
        }

        .lists ul li span.self[data-v-7ecec926] {
            display: block;
            margin: 0 auto;
            width: .7rem;
            height: .23rem;
            text-align: center;
            line-height: .23rem;
            border: .01rem solid #ffbf23;
            color: #ffbf23;
            font-size: .14rem
        }

        .lists ul li.put span.self[data-v-7ecec926] {
            margin-top: .15rem
        }
        .shadowC {
            height: auto;
            background: rgba(0,0,0,.78);
        }
        .pointP {
            position: absolute;
            top: 0.1rem;
            right: 0;
            z-index: 2;
            width: .08rem;
            height: .08rem;
            border-radius: .04rem;
            background-color: #f54f4c;
        }

        .lists ul li span.saleTime[data-v-7ecec926] {
            display: block;
            margin: 0 auto;
            width: .7rem;
            height: .23rem;
            text-align: center;
            line-height: .23rem;
            border: .01rem solid #ffbf23;
            color: #ffbf23;
            font-size: .14rem
        }
    </style>
</head>
<body id="tradBC">

<!--<div class="shadowC">-->
<div id="__nuxt">
    <div class="progress" data-v-4a8a9a01=""
         style="width: 0%; height: 2px; background-color: rgb(1, 40, 97); opacity: 0;"></div>
    <div data-v-7ecec926="" class="">
        <section data-v-7ecec926="" id="trade" class="trade-box tradBC">
            <div data-v-7ecec926="" class="trade-head">
                <div data-v-7ecec926="" class="trade-top">
                    <div data-v-7ecec926="">
                        <p data-v-7ecec926="" class="title"><?php echo (L("float_ploss")); ?>
                            <span data-v-7ecec926="">
                                <?php if(($now_trade_status) == "1"): ?>(<?php echo (L("firm_offer")); ?>)
                                <?php else: ?>
                                    (<?php echo (L("simulation")); ?>)<?php endif; ?>
                            </span>
                        </p>
                        <p data-v-7ecec926="" class="float-money">$<?php echo ($account["floatloss"]); ?></p>
                    </div>
                    <ul data-v-7ecec926="" class="finance-wrap">
                        <li data-v-7ecec926="" class="finance-list"><p data-v-7ecec926="" class="finance-txt"><?php echo (L("available_margin")); ?></p>
                            <p data-v-7ecec926="" class="fianace-num balance">$<?php echo ($account["balance"]); ?></p></li>
                        <li data-v-7ecec926="" class="finance-list"><p data-v-7ecec926="" class="finance-txt"><?php echo (L("secured_money")); ?></p>
                            <p data-v-7ecec926="" class="fianace-num usedBond">$<?php echo ($account["usedBond"]); ?></p></li>
                        <li data-v-7ecec926="" class="finance-list"><p data-v-7ecec926="" class="finance-txt"><?php echo (L("net_asset_value")); ?></p>
                            <p data-v-7ecec926="" class="fianace-num worth">$<?php echo ($account["worth"]); ?></p></li>
                    </ul>
                    <div data-v-7ecec926="" class="history">
                        <a href="<?php echo U('Record/index');?>" style="position: relative;display: inline-block">
                            <span data-v-7ecec926="" class="order"><?php echo (L("history_order")); ?></span>
                            <?php if($orderStatusCount >= 1): ?><span class="pointP"></span><?php endif; ?>
                        </a>
                        
                        <a href="<?php echo U('Recharge/index');?>">
                            <span data-v-7ecec926="" class="recharge"><?php echo (L("recharge")); ?></span>
                        </a>
                    </div>
                </div>
            </div>
            <div data-v-7ecec926="" class="titles">
                <div data-v-7ecec926=""  class="on"><?php echo (L("position")); ?> <span data-v-7ecec926="" class="title-line"></span></div>
                <div data-v-7ecec926=""  class=""><?php echo (L("own")); ?> <span data-v-7ecec926="" class="title-line"></span></div>
                <div data-v-7ecec926=""  class=""><?php echo (L("follow")); ?><span data-v-7ecec926="" class="title-line"></span></div>
                <div data-v-7ecec926=""  class=""><?php echo (L("entrust")); ?><span data-v-7ecec926="" class="title-line"></span></div>
            </div>
            <div data-v-7ecec926="" class="lists swiper-container swiper-container-horizontal swiper-no-swiping
">
                <div data-v-7ecec926="" class="swiper-wrapper">
                    <ul data-v-7ecec926=""  class="swiper-slide ping closing" style="width: 414px;">

                    </ul>
                    <ul data-v-7ecec926=""  class="swiper-slide ping physical" style="width: 414px;">

                    </ul>
                    <ul data-v-7ecec926=""  class="swiper-slide follow" style="width: 414px;">

                    </ul>
                    <ul data-v-7ecec926=""  class="swiper-slide resting" style="width: 414px;">

                    </ul>
                </div>
            </div>
        </section>

        <div data-v-7ecec926="" class="box" data-oid="">
            <div class="qts-window">
                <div class="qts-img">
                    <div class="qts-name"><?php echo (L("confirm_closure")); ?></div>
                    <p class="qts-order"><?php echo (L("orderno")); ?>：<span>0000000</span></p>
                    <div class="qts-content">
                        <ul>
                            <li><span class="txt_black"><?php echo (L("float_ploss")); ?>：</span><span class="txt_red">$0.00</span></li>
                            <li><span class="txt_black"><?php echo (L("opening_price")); ?>：</span><span class="txt_black">0.00</span></li>
                            <li><span class="txt_black"><?php echo (L("current_price")); ?>：</span><span class="txt_black">0.00</span></li>
                        </ul>
                    </div>
                    <div class="qts-footer btns"><a class="btn-cancel"><?php echo (L("cancel")); ?></a><a class="btn-ok" onclick="cover();"><?php echo (L("determine")); ?></a></div>
                </div>
            </div>
        </div>

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
<div data-v-cd4b7ab0="" style="position: absolute; z-index: 2013;">
    <div data-v-cd4b7ab0="" class="mint-msgbox-wrapper" data-oid="">
        <div data-v-cd4b7ab0="" class="mint-msgbox">
            <div data-v-cd4b7ab0="" class="mint-msgbox-header">
                <div data-v-cd4b7ab0="" class="mint-msgbox-title"><?php echo (L("confirm_cancel")); ?></div>
            </div>
            <div data-v-cd4b7ab0="" class="mint-msgbox-content">
                <div data-v-cd4b7ab0="" class="mint-msgbox-message">
                    <ul>
                        <li><span class="txt_gray"></span><span class="txt_black"></span></li>
                        <li></li>
                        <li><span class="txt_gray"><?php echo (L("entrusted_price")); ?>&nbsp;</span><span class="txt_black">65.658</span></li>
                    </ul>
                </div>
            </div>
            <div data-v-cd4b7ab0="" class="mint-msgbox-btns">
                <button data-v-cd4b7ab0="" class="mint-msgbox-btn mint-msgbox-cancel " style="color: #fff"><?php echo (L("cancel")); ?></button>
                <button data-v-cd4b7ab0="" class="mint-msgbox-btn mint-msgbox-confirm " onclick="cancelOrder();"><?php echo (L("determine")); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="v-modal" style="z-index: 2012;"></div>
<!--</div>-->
<script src="/Public/Qts/Home/js/swiper.min.js"></script>
<script src="/Public/Qts/Home/js/jquery.js"></script>
<script>

    //设置底部导航选中状态
    $('.footer > ul > li').eq(2).find('a').addClass('common4');
    $('.footer > ul > li').eq(2).find('em').addClass('selected');

</script>

</body>
</html>

<script src="/Public//Qts/Home/js/template.js"></script>

<script id="closing" type="text/html">
    {{each order as vo}}
    <li data-v-7ecec926="" class="list-hold">
    {{if vo['order_type'] == 2}}
        <div data-v-7ecec926="" class="left" onclick="window.location.href='<?php echo U('followDetails');?>?oid={{vo.oid}}'">
    {{else}}
        <div data-v-7ecec926="" class="left" onclick="window.location.href='<?php echo U('equityDetails');?>?oid={{vo.oid}}'">
    {{/if}}
            <p data-v-7ecec926="">
                <span data-v-7ecec926="" class="name">{{vo.option_name}}</span>
                {{if vo['ostyle'] == 0}}
                <span data-v-7ecec926="" class="tag {{vo.typeClass}}">买</span>
                {{else}}
                <span data-v-7ecec926="" class="tag {{vo.typeClass}}">卖</span>
                {{/if}}
                {{if vo['order_scene'] == 2}}
                    <em data-v-7ecec926="" class="hands">$ {{vo.Bond}}</em>
                {{else}}
                    <em data-v-7ecec926="" class="hands">x {{vo.onumber}} <?php echo (L("lots")); ?></em>
                {{/if}}
            </p>

            <p data-v-7ecec926="">
                <span data-v-7ecec926="" class="open"><?php echo (L("opening_price")); ?>  {{vo.buyprice}}</span>
                <span data-v-7ecec926="" class="ask"><?php echo (L("current_price")); ?>  {{vo.sellprice}}</span>
            </p>
        </div>

        <div data-v-7ecec926="" class="right">
            <p data-v-7ecec926="">
                <span data-v-7ecec926="" class="win {{vo.plossClass}}">${{vo.ploss}}</span>
            </p>

        {{if vo['order_scene'] == 2}}
            <p data-v-7ecec926="">
                    <span data-v-7ecec926="" class="saleTime" >{{vo.remainingTime}}s</span>
            </p>
        {{else}}
            {{if vo['order_type'] == 2}}
            <p data-v-7ecec926="">
                <span data-v-7ecec926="" class="self" data-oid="{{vo.oid}}" onclick="changeOrder({{vo.oid}});"><?php echo (L("self_hold")); ?></span>
            </p>
            {{else}}
            <p data-v-7ecec926="">
                    <span data-v-7ecec926="" class="sale" data-oid="{{vo.oid}}" data-orderno="{{vo.orderno}}"
                          data-open="{{vo.buyprice}}" data-ask="{{vo.sellprice}}" data-ploss="{{vo.ploss}}"><?php echo (L("close_position")); ?></span>
            </p>
            {{/if}}
        {{/if}}
        </div>
    </li>
    {{/each}}
</script>


<script id="physical" type="text/html">
    {{if selfData != ''}}
    {{each selfData as vo}}
    <li data-v-7ecec926="" class="list-hold">
        <div data-v-7ecec926="" class="left" onclick="window.location.href='<?php echo U('equityDetails');?>?oid={{vo.oid}}'">
            <p data-v-7ecec926="">
                <span data-v-7ecec926="" class="name">{{vo.option_name}}</span>
                <span data-v-7ecec926="" class="tag {{vo.typeClass}}">{{vo.typeMsg}}</span>
                {{if vo['order_scene'] == 2}}
                    <em data-v-7ecec926="" class="hands">$ {{vo.Bond}}</em>
                {{else}}
                    <em data-v-7ecec926="" class="hands">x {{vo.onumber}} <?php echo (L("lots")); ?></em>
                {{/if}}
            </p>

            <p data-v-7ecec926="">
                <span data-v-7ecec926="" class="open"><?php echo (L("opening_price")); ?>  {{vo.buyprice}}</span>
                <span data-v-7ecec926="" class="ask"><?php echo (L("current_price")); ?>  {{vo.sellprice}}</span>
            </p>
        </div>

        <div data-v-7ecec926="" class="right">
            <p data-v-7ecec926="">
                <span data-v-7ecec926="" class="win {{vo.plossClass}}">${{vo.ploss}}</span>
            </p>
    
            {{if vo['order_scene'] == 2}}
                <p data-v-7ecec926="">
                    <span data-v-7ecec926="" class="saleTime" >{{vo.remainingTime}}s</span>
                </p>
            {{else}}
                <p data-v-7ecec926="">
                    <span data-v-7ecec926="" class="sale" data-oid="{{vo.oid}}" data-orderno="{{vo.orderno}}"
                          data-open="{{vo.buyprice}}" data-ask="{{vo.sellprice}}" data-ploss="{{vo.ploss}}"><?php echo (L("close_position")); ?></span>
                </p>
            {{/if}}
            
        </div>
    </li>
    {{/each}}
    {{else}}
    <div data-v-7ecec926=""><p data-v-7ecec926="" class="nomore"><?php echo (L("no_more")); ?></p></div>
    {{/if}}
</script>


<script id="followUser" type="text/html">
    {{if followUser != ''}}
    {{each followUser as vo}}
    <li data-v-7ecec926="" class="list-hold">
        <div data-v-7ecec926="" class="left">

            <p data-v-7ecec926="">
                <img data-v-46d1b599 src="{{vo.face}}" style="display: inline-block; width: .4rem; height: .4rem;border-radius: 50%;margin-top: .06rem;float:left;">
                <span data-v-7ecec926="" class="name">{{vo.nickname}}</span>
            </p>
        </div>

        <div data-v-7ecec926="" class="right">
            <p data-v-7ecec926="">
            </p>
            <p data-v-7ecec926="">
                <a href="<?php echo U('tradeByFloowUser');?>?uid={{vo.uid}}"><span data-v-7ecec926="" class="sale"><?php echo (L("show_order")); ?></span></a>
            </p>
        </div>
    </li>
    {{/each}}
    {{else}}
    <div data-v-7ecec926="">
        <div data-v-ea184226="" data-v-7ecec926="" class="textNone_content">
            <div data-v-ea184226="" class="textNone_img"></div>
            <p data-v-ea184226=""><?php echo (L("no_followers")); ?></p>
            <a href="<?php echo U('followData');?>">
                <button data-v-ea184226="" class="textNone_btn"><?php echo (L("to_follow")); ?></button>
            </a>
        </div>
    </div>
    {{/if}}
</script>


<script id="resting" type="text/html">
    {{if restingData != ''}}
    {{each restingData as vo}}
    <li data-v-7ecec926="" class="list-hold">
        <div data-v-7ecec926="" class="left" onclick="window.location.href='<?php echo U('cancelDetails');?>?id={{vo.id}}'">
            <p data-v-7ecec926="">
                <span data-v-7ecec926="" class="name">{{vo.option_name}}</span>
                <span data-v-7ecec926="" class="tag {{vo.typeClass}}">{{vo.typeMsg}}</span>
                <em data-v-7ecec926="" class="hands">x {{vo.number}} <?php echo (L("lots")); ?></em>
            </p>

            <p data-v-7ecec926="">
                <span data-v-7ecec926="" class="open"><?php echo (L("entrusted_price")); ?>  {{vo.guadan_price}}</span>
                <span data-v-7ecec926="" class="ask"><?php echo (L("current_price")); ?>  {{vo.now_price}}</span>
            </p>
        </div>

        <div data-v-7ecec926="" class="right">
            <p data-v-7ecec926="">
                <span data-v-7ecec926="" class="win {{vo.plossClass}}"></span>
            </p>
            <p data-v-7ecec926="" style="margin-top: 0.17rem;">
                <span data-v-7ecec926="" class="sale" data-oid="{{vo.id}}" data-name="{{vo.option_name}}" data-ostyle="{{vo.ostyle}}" data-number="{{vo.number}}" data-price="{{vo.guadan_price}}"><?php echo (L("cancellations")); ?></span>
            </p>
        </div>
    </li>
    {{/each}}
    {{else}}
    <div data-v-7ecec926="">
        <div data-v-ea184226="" data-v-7ecec926="" class="textNone_content">
            <div data-v-ea184226="" class="textNone_img"></div>
            <p data-v-ea184226=""><?php echo (L("no_more")); ?></p>
            <a href="<?php echo U('Product/lists');?>">
            <button data-v-ea184226="" class="textNone_btn"><?php echo (L("go_to_order")); ?></button>
            </a>
        </div>
    </div>
    {{/if}}
</script>


<script type="text/javascript" src="/Public//Home/css/layer_mobile/layer.js"></script>
<script type="text/javascript">


    $(function () {
        
        var lang = "<?php echo ($lang); ?>";
        
        /**
         * [websocketByAcceptData 以websocket方式接受数据]
         * @return {[type]} [description]
         */
        function websocketByAcceptData(index) {
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
                        $.post('<?php echo U("Bind/bindUid");?>', {client_id: data.client_id}, function (data) {
                        }, 'json');
                        break;
                    default :

                        layer.close(index);
                        
                        //console.log(e.data);
                        data = JSON.parse(e.data);
                        
                        $.each(data.order,function (key,val) {
                            if(lang == 'en-us') {
                                val.option_name = val.en_name;
                            } else if(lang == 'zh-tw') {
                                val.option_name = val.tw_name;
                            }
                            val.typeMsg = "<?php echo (L("api_buy")); ?>";
                        });
                        $.each(data.selfData,function (key,val) {
                            if(lang == 'en-us') {
                                val.option_name = val.en_name;
                            } else if(lang == 'zh-tw') {
                                val.option_name = val.tw_name;
                            }
                            val.typeMsg = "<?php echo (L("api_buy")); ?>";
                        });

                        $.each(data.restingData,function (key,val) {
                            if(lang == 'en-us') {
                                val.option_name = val.en_name;
                            } else if(lang == 'zh-tw') {
                                val.option_name = val.tw_name;
                            }
                            val.typeMsg = "<?php echo (L("api_buy")); ?>";
                        });
                        

                        var userHtml = template('followUser', data);
                        $('.follow').html(userHtml);

                        //////////////////////////////////////////////

                        var closingHtml = template('closing', data);
                        $('.closing').html(closingHtml);

                        var physicalHtml = template('physical', data);
                        $('.physical').html(physicalHtml);

                        var restingHtml = template('resting', data);
                        $('.resting').html(restingHtml);


                        $('.float-money').html('$' + data.account.floatloss);
                        $('.balance').html('$' + data.account.balance);
                        $('.usedBond').html('$' + data.account.usedBond);
                        $('.worth').html('$' + data.account.worth);

                        //操作用户点开的订单
                        var oid = $('.box').attr('data-oid');
                        if (oid != '') {
                            $.each(data.order, function (key, val) {
                                if (oid == val.oid)
                                    alertByLoad(val.orderno, val.ploss, val.buyprice, val.sellprice);
                            });
                        }
                }
            };
        }
        var loading = "<?php echo (L("loading")); ?>";
        var index = layer.open({type: 2,shadeClose:false,content:loading});
        websocketByAcceptData(index);

        //9分钟后刷新页面
        window.setTimeout("location.reload()", 540000);
    });
    

    //点击平仓显示弹出框
    $('.ping').on('click', '.sale', function () {

        $('.box').show();

        var oid         = $(this).attr('data-oid');
        var orderno     = $(this).attr('data-orderno');
        var buyprice    = $(this).attr('data-open');
        var sellprice   = $(this).attr('data-ask');
        var ploss       = $(this).attr('data-ploss');

        $('.box').attr('data-oid', oid);
        // alert(ploss);
        alertByLoad(orderno, ploss, buyprice, sellprice);
    });
    //取消弹框
    $('.btn-cancel').click(function () {
        $('.box').hide()
    });

    //对弹框进行加载数据
    function alertByLoad(orderno, ploss, buyprice, sellprice) {
        $('.box > div > div > p > span').html(orderno);
        $('.box > div > div > div').eq(1).find('ul > li').first().find('span').last().html('$'+ ploss);
        $('.box > div > div > div').eq(1).find('ul > li').eq(1).find('span').last().html(buyprice);
        $('.box > div > div > div').eq(1).find('ul > li').last().find('span').last().html(sellprice);
    }

    //取消挂单弹出框
    $('.mint-msgbox-cancel').click(function () {
        $('.mint-msgbox-wrapper').hide();
        $('.v-modal').hide()
    })

    //点击按钮弹出挂单弹框
    $('.resting').on('click', '.sale', function () {
        $('.mint-msgbox-wrapper').show();
        $('.v-modal').show();

        var oid         = $(this).attr('data-oid');
        var name        = $(this).attr('data-name');
        var ostyle      = $(this).attr('data-ostyle') == 0 ? '<?php echo (L("api_buy")); ?>' : '<?php echo (L("api_sell")); ?>';
        var number      = $(this).attr('data-number');
        var price       = $(this).attr('data-price');

        $('.mint-msgbox-wrapper').attr('data-oid', oid);
        $('.mint-msgbox-wrapper > div > div').eq(1).find('div > ul > li').first().find('span').first().html(name+' '+ostyle);
        $('.mint-msgbox-wrapper > div > div').eq(1).find('div > ul > li').first().find('span').last().html(number+'<?php echo (L("lots")); ?>');
        $('.mint-msgbox-wrapper > div > div').eq(1).find('div > ul > li').last().find('span').last().html(price);
    });

    //订单平仓操作
    function cover() {
        var loading = "<?php echo (L("loading")); ?>";
        var oid     = $('.box').attr('data-oid');
        var index = layer.open({type: 2,shadeClose:false,content:loading});

        $.ajax({
            url: "<?php echo U('cover');?>",
            dataType: 'json',
            type: 'post',
            data: {'oid': oid},
            success: function (data) {
                layer.open({
                    content: data.msg
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
                layer.close(index);
                if(data.code == 200){
                    setTimeout(" window.location.href='<?php echo U('trade');?>'",500);
                }
            },
            error: function (res) {
                console.log(res);
            }
        });
    }

    //订单撤单操作
    function cancelOrder()
    {
        var loading = "<?php echo (L("loading")); ?>";
        var id      = $('.mint-msgbox-wrapper').attr('data-oid');
        var index   = layer.open({type: 2,shadeClose:false,content:loading});

        $.ajax({
            url: "<?php echo U('cancelOrder');?>",
            dataType: 'json',
            type: 'post',
            data: {'id': id},
            success: function (data) {
                layer.open({
                    content: data.msg
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
                layer.close(index);
                if(data.code == 200){
                    setTimeout("window.location.reload();",500);
                }
            },
            error: function (res) {
                console.log(res);
            }
        });
    }

    /**
     * [changeOrder 跟随订单转自持]
     * @author wang 990529346@qq.com
     */
    function changeOrder(oid)
    {
        layer.open({
            content: '<?php echo (L("confirm_turn")); ?>？'
            ,btn: ['<?php echo (L("determine")); ?>', '<?php echo (L("cancel")); ?>']
            ,shadeClose:false
            ,yes: function(index){
                var loading = "<?php echo (L("loading")); ?>";
                var load   = layer.open({type: 2,shadeClose:false,content:loading});
                $.ajax({
                    url: "<?php echo U('changeOrder');?>",
                    dataType: 'json',
                    type: 'post',
                    data: {'oid': oid},
                    success: function (data) {
                        layer.open({
                            content: data.msg
                            ,skin: 'msg'
                            ,time: 2 //2秒后自动关闭
                        });
                        return layer.close(load);
                    },
                    error: function (res) {
                        console.log(res);
                    }
                });
            }
        });
    }

    var mySwiper = new Swiper('.swiper-container',{
        watchSlidesProgress : true,
        watchSlidesVisibility : true,
        on: {
            slideChangeTransitionStart: function(swiper){
                $('.titles div').eq(mySwiper.activeIndex).addClass('on').siblings().removeClass('on');
            }
        }
    })
    $('.titles div').click(function(){
        $(this).addClass('on').siblings().removeClass('on');
        mySwiper.slideTo($(this).index(), 1000,false)
    })

</script>