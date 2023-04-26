<?php if (!defined('THINK_PATH')) exit();?>    <!DOCTYPE html>
<html data-n-head="" lang="zh-tw">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta data-n-head="true" content="Meta description" name="description" data-hid="description">
    <meta data-n-head="true" content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, user-scalable=no,minimum-scale=1.0, maximum-scale=1.0,viewport-fit=contain" data-n-head="true">
    <!--<meta name="viewport" content="... viewport-fit=cover"/>-->
    <title data-n-head="true"><?php echo (L("recharge")); ?></title>
    <link href="/Public//Qts/Home/css/common.css" rel="stylesheet">
    <style data-vue-ssr-id="4cddb420:0 cf79f97a:0">
        .li-main > span[data-v-adff73de] {
            position: relative;
            -webkit-box-flex: 1;
            -ms-flex: 1;
            flex: 1;
            justify-items: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            padding-left: .4rem
        }

        .li-main > span[data-v-adff73de]:before {
            position: absolute;
            left: 0;
            width: .32rem;
            height: .38rem;
            margin-top: .08rem;
            content: "";
            background-repeat: no-repeat
        }

        .man-f li[data-v-adff73de] {
            width: 33.33%;
            float: left;
            text-align: center;
            margin-bottom: .2rem
        }

        .man-f img[data-v-adff73de] {
            width: .29rem
        }

        .man-f p[data-v-adff73de] {
            font-size: 12px;
            color: #333;
            letter-spacing: 0
        }

        .linksystem strong[data-v-adff73de] {
            position: absolute;
            width: .08rem;
            height: .08rem;
            display: block;
            border-radius: 50%;
            background: #f64e43;
            right: .3rem;
            top: 0
        }

        a[data-v-18c6d448] {
            display: block;
            width: .24rem;
            height: .23rem;
            background-size: 100%;
            margin: .06rem auto
        }

        .contenthas[data-v-66de26a6] {
            /* border-top: .01rem solid #ddd; */
            border-top: .01rem solid #383836;
            padding: 0 .15rem
        }

        .ipt-group[data-v-66de26a6] {
            overflow: hidden;
            line-height: .4rem;
            font-size: .15rem;
           /*  background: #f5f5f5; */
            /*border: 1px solid #A67D25;*/
            border-radius: 5px
        }
        #inputmoney {
            border: 1px solid #A67D25;
            padding: .05rem .1rem;
            border-radius: .06rem;
            width: 70%;
            color: #999;
        }

        .ipt-before[data-v-66de26a6] {
            overflow: hidden;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            width: .89rem;
            float: left;
            text-align: right;
            padding-left: .1rem
        }
        .ipt-before em[data-v-66de26a6]:first-of-type {
            float: left;
           /*  color: #666; */
            color: #ACABB1;
            font-size: .14rem
        }

        .ipt-before em[data-v-66de26a6]:nth-of-type(2) {
            float: right;
            color: #A67D25;
        }

        .ipt-btn[data-v-66de26a6] {
           /*  margin-top: .3rem;
           line-height: .44rem;
           text-align: center;
           font-size: .17rem;
           border-radius: .22rem;
           background: -o-linear-gradient(319deg, #cdcfd1 0, #d1d2d5 100%);
           background: linear-gradient(-229deg, #cdcfd1, #d1d2d5);
           color: #fff */
            margin-top: .3rem;
            margin-right: .1rem;
            margin-left: .1rem;
            line-height: .4rem;
            text-align: center;
            font-size: .15rem;
            /* border-radius: .22rem; */
            border-radius: .04rem;
            background: #ffbf23;
           /*  background: -webkit-linear-gradient(229deg, #cdcfd1 0%, #d1d2d5 100%);
           background: -o-linear-gradient(229deg, #cdcfd1 0%, #d1d2d5 100%);
           background: linear-gradient(319deg, #cdcfd1 0%, #d1d2d5 100%); */
            /* background: linear-gradient(-229deg, #cdcfd1, #d1d2d5); */
            color: #000
        }

        .zftype li[data-v-66de26a6] {
            margin-top: .1rem;
            overflow: hidden
        }

        .zftype li[data-v-66de26a6]:first-child {
            margin-top: 0
        }

        .zftype .bankapi[data-v-66de26a6] {
            width: 100%;
            padding: 0 .14rem;
            /* background: #f5f5f5; */
            background: #171520;
            position: relative;
            border-radius: .05rem;
            overflow: hidden
        }

        .zftype li em[data-v-66de26a6] {
            margin-right: .1rem;
            font-size: .12rem;
            /* color: #999; */
            color: #AFAEB4;
            float: right;
            line-height: .5rem
        }

        .zftype li span[data-v-66de26a6] {
            display: inline-block;
            height: 100%;
            line-height: .5rem;
            margin-left: .15rem
        }

        .zftype li .tipimg[data-v-66de26a6] {
            height: .3rem;
            width: .3rem;
            margin-top: .1rem;
            float: left
        }

        .recom[data-v-66de26a6] {
            width: .18rem;
            height: .18rem;
            float: right;
            margin-top: .16rem
        }

        .hasbank[data-v-66de26a6] {
            height: .3rem;
            width: 100%;
            line-height: .3rem;
            font-size: .12rem;
            color: #999;
            position: relative
        }

        .hasbank[data-v-66de26a6]:after {
            content: "";
            position: absolute;
            width: 200%;
            height: 1px;
            top: 0;
            border-bottom: 1px solid #d8d8d8;
            -webkit-transform-origin: 0 0;
            -ms-transform-origin: 0 0;
            transform-origin: 0 0;
            -webkit-transform: scale(.5);
            -ms-transform: scale(.5);
            transform: scale(.5);
            -webkit-box-sizing: border-box;
            box-sizing: border-box
        }

        .icon[data-v-66de26a6] {
            position: absolute;
            right: 0;
            overflow: hidden;
            background-image: url(/Public/Qts/Home/img/user/right_gray.png);
            background-repeat: no-repeat;
            width: .07rem;
            height: .13rem;
            top: .25rem
        }

        .icon1[data-v-66de26a6] {
            top: .1rem
        }

        .payaddbank .icon[data-v-66de26a6] {
            right: 0
        }

        .showpay[data-v-66de26a6] {
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, .4);
            position: fixed;
            top: 0;
            z-index: 1000
        }

        .paymodal[data-v-66de26a6] {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: #fff
        }

        .paymodaltitle[data-v-66de26a6] {
            height: .5rem;
            width: 100%;
            line-height: .5rem;
            font-size: .15rem;
            color: #222;
            position: relative;
            text-align: center
        }

        .paymodaltitle[data-v-66de26a6]:before {
            content: "";
            position: absolute;
            width: 200%;
            height: 1px;
            bottom: 0;
            left: 0;
            border-bottom: 1px solid #d8d8d8;
            -webkit-transform-origin: 0 0;
            -ms-transform-origin: 0 0;
            transform-origin: 0 0;
            -webkit-transform: scale(.5);
            -ms-transform: scale(.5);
            transform: scale(.5);
            -webkit-box-sizing: border-box;
            box-sizing: border-box
        }

        .paymodaltitle img[data-v-66de26a6] {
            position: absolute;
            display: inline-block;
            width: .15rem;
            height: .15rem;
            top: .15rem;
            left: .2rem
        }

        .banklist[data-v-66de26a6] {
            max-height: 1.4rem;
            overflow: scroll;
            width: 100%
        }

        .banklist li[data-v-66de26a6] {
            height: .5rem;
            width: 90%;
            margin: 0 auto;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            line-height: .5rem;
            color: #666;
            font-size: .14rem;
            position: relative
        }

        .banklist li[data-v-66de26a6]:before {
            content: "";
            position: absolute;
            width: 200%;
            height: 1px;
            bottom: 0;
            left: 0;
            border-bottom: 1px solid #d8d8d8;
            -webkit-transform-origin: 0 0;
            -ms-transform-origin: 0 0;
            transform-origin: 0 0;
            -webkit-transform: scale(.5);
            -ms-transform: scale(.5);
            transform: scale(.5);
            -webkit-box-sizing: border-box;
            box-sizing: border-box
        }

        .banklist li .bankicon[data-v-66de26a6] {
            width: .2rem;
            height: .2rem;
            margin: .15rem .1rem 0 0;
            float: left
        }

        .payaddbank[data-v-66de26a6] {
            height: .6rem;
            width: 90%;
            margin: 0 auto;
            line-height: .6rem;
            position: relative
        }

        .payaddbank img[data-v-66de26a6] {
            width: .2rem;
            height: .2rem;
            margin: .18rem .1rem 0 0;
            float: left
        }

        .showpayload[data-v-66de26a6] {
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, .4);
            position: fixed;
            top: 0;
            z-index: 1200
        }

        .showpayload img[data-v-66de26a6] {
            width: .3rem;
            height: .3rem;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: 60% auto;
            display: block
        }

        .txt-blue[data-v-66de26a6] {
          /*   color: #2187f7 */
          color: #ffbf23;
        }

        .rate[data-v-66de26a6] {
            line-height: .4rem;
            font-size: .1rem;
            color: #999;
            padding-left: .1rem;
        }

        .inner[data-v-66de26a6] {
            background: url(/Public//Qts/Home/img/recharge/img8.png) no-repeat 0;
            background-size: .16rem .16rem
        }

        .inner[data-v-66de26a6], .selct[data-v-66de26a6] {
            overflow: hidden;
            display: inline-block;
            font-size: .12rem;
            text-indent: .2rem;
            color: #999
        }

        .selct[data-v-66de26a6] {
            /* background: #fff url(/Public//Qts/Home/img/recharge/img7.png) no-repeat 0; */
            background:url(/Public//Qts/Home/img/recharge/img7.png) no-repeat 0;
            background-size: .16rem .16rem
        }

        .choose[data-v-66de26a6] {
            margin: .1rem;
            padding: 0
        }

        .rengongcard[data-v-66de26a6] {
            width: 100%;
            position: relative;
            margin-top: .15rem;
            border-radius: .05rem
        }

        .rengongbtn a[data-v-66de26a6] {
            display: inline-block;
            width: 45%;
            height: .4rem;
            text-align: center;
            line-height: .4rem;
            font-size: .14rem;
            color: #2187f7;
            background: #fff url('/Public//Qts/Home/img/recharge/img8.png') no-repeat 10%;
            background-size: .16rem .16rem;
            border: 1px solid #eaeaea;
            border-radius: 5px;
            font-weight: 400
        }

        .rengongbtn .rengongactive[data-v-66de26a6] {
            border: 1px solid #2187f7;
            background: #fff url('/Public//Qts/Home/img/recharge/img7.png') no-repeat 10%;
            background-size: .16rem .16rem
        }

        .rengongbtn a[data-v-66de26a6]:first-child {
            float: left
        }

        .rengongbtn a[data-v-66de26a6]:nth-child(2) {
            float: right
        }

        .clearfix[data-v-66de26a6] {
            clear: both
        }

        .rengongcard p[data-v-66de26a6] {
            margin-top: .16rem;
            font-size: 14px;
            color: #666
        }

        .rengongcard input[data-v-66de26a6] {
            width: 100%;
            height: .45rem;
            line-height: .45rem;
            padding-left: .14rem;
            background: #f5f5f5;
            font-size: 14px;
            color: #999;
            margin-top: .1rem
        }

        .rengmodal[data-v-66de26a6] {
            position: fixed;
            top: 30%;
            left: 0;
            right: 0;
            margin: auto;
            width: 85%;
            background: #fff;
            border-radius: 3px
        }

        .rentitle[data-v-66de26a6] {
            text-align: center;
            position: relative;
            height: .4rem;
            line-height: .4rem;
            color: #999;
            font-size: .16rem
        }

        .rentitle img[data-v-66de26a6] {
            width: .2rem;
            position: absolute;
            right: .05rem;
            top: .08rem
        }

        .rencontent[data-v-66de26a6] {
            font-size: .15rem;
            color: #999;
            margin-bottom: .15rem;
            word-break: break-all;
            padding: 0 .1rem
        }

        .renfoot[data-v-66de26a6] {
            text-align: center;
            margin-bottom: .1rem
        }

        .renfoot a[data-v-66de26a6] {
            display: inline-block;
            height: .35rem;
            width: 1.5rem;
            text-align: center;
            line-height: .35rem;
            background: #0086ff;
            -webkit-box-shadow: 0 2px 8px 2px #ebf1f7;
            box-shadow: 0 2px 8px 2px #ebf1f7;
            border-radius: .5rem;
            color: #fff
        }

        .ipt-money[data-v-66de26a6] {
            height: .4rem;
            line-height: .4rem;
            font-size: 14px;
          /*   color: #333; */
            color: #ACABB1;
            position: relative
        }

        .ipt-money span[data-v-66de26a6] {
            font-size: 14px;
            /* color: #f64e43; */
            color: #ffc932;
            letter-spacing: 0;
            display: inline-block;
            /*margin-left: .1rem*/
        }

        .lookmx[data-v-66de26a6] {
            position: absolute;
            font-size: 14px;
            /* color: #2187f7; */
            color: #ffc932;
            letter-spacing: 0;
            top: 0;
            right: .25rem
        }

        .lookmx[data-v-66de26a6]:after {
            content: "";
            position: absolute;
            display: block;
            width: .08rem;
            height: .08rem;
            border-top: .01rem solid #ffc932;
            border-right: .01rem solid #ffc932;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
            top: .16rem;
            right: -.15rem
        }

        .apptip[data-v-66de26a6] {
            margin: .2rem 0
        }

        .apptip p[data-v-66de26a6] {
            font-size: .14rem;
            color: #f64e43;
            text-align: center
        }

        .apptip span[data-v-66de26a6] {
            color: #2187f7
        }

        html {
            overflow-x: hidden;
        }
        .btnColor, .newbtnColor {
           /*  background-image: -o-linear-gradient(319deg,#1254a8 0,#0c62c1 100%)!important;
           background-image: linear-gradient(-229deg,#1254a8,#0c62c1)!important; */
        }
        .page-main {
            padding: 0.5rem 0 0 !important;
        }

        .arrow_left:after {
            content: " ";
            display: inline-block;
            -webkit-transform: rotate(225deg);
            transform: rotate(225deg);
            height: 13px;
            width: 13px;
            border-width: 2px 2px 0 0;
            border-color: #B2B1B7;
            border-style: solid;
            position: relative;
            top: -2px;
            position: absolute;
            left: 0;
            top: 19px;
         }
        input::-webkit-input-placeholder, textarea::-webkit-input-placeholder {
            /* WebKit browsers */
            color: #666;
        }
        input:-moz-placeholder, textarea:-moz-placeholder {
            /* Mozilla Firefox 4 to 18 */
            color: #666;
        }
        input::-moz-placeholder, textarea::-moz-placeholder {
            /* Mozilla Firefox 19+ */
            color: #666;
        }
        input:-ms-input-placeholder, textarea:-ms-input-placeholder {
            /* Internet Explorer 10+ */
            color: #666;
        }
    </style>
</head>
<body style="background: #1C1A25">
<div id="__nuxt">
    <div class="progress" data-v-4a8a9a01=""
         style="width: 0%; height: 2px; background-color: rgb(1, 40, 97); opacity: 0;"></div>
    <div data-v-66de26a6="" class="content">
        <div data-v-66de26a6="" id="head" style="background: #1C1A25;">
            <div data-v-66de26a6="" class="head_content">
                <h3 data-v-66de26a6="" class="product-name" style="text-align: center;">
                    <span data-v-66de26a6="" style="display: block; text-align: center; width: 100%; height: 100%;color: #ffc932;"><?php echo (L("recharge")); ?></span>
                </h3>
                <div data-v-66de26a6="" class="left" onclick="window.location.href='<?php echo ($urlcan); ?>'">
                    <a data-v-66de26a6="" class="arrow_left"></a>
                </div>
            </div>
        </div>
        <section data-v-66de26a6="" class="page-main">
            <div data-v-66de26a6="" class="contenthas">
                <div data-v-66de26a6="" class="ipt-money">
                    <div data-v-66de26a6="" style="text-indent: 0.1rem;">
                        <?php echo (L("account_balance")); ?>:<span data-v-66de26a6="">$<?php echo ($account["balance"]); ?></span>
                    </div>
                    <a href="<?php echo U('rechargeDetails');?>">
                        <div data-v-66de26a6="" class="lookmx"><?php echo (L("recharge_details")); ?></div>
                    </a>
                </div>
                <div data-v-66de26a6="" id="group" class="ipt-group">
                    <label data-v-66de26a6="">
                        <div data-v-66de26a6="" class="ipt-before">
                            <em data-v-66de26a6=""><?php echo (L("recharge_amount")); ?>：</em>
                            <em data-v-66de26a6="">$</em>
                        </div>
                    <input data-v-66de26a6="" type="number" id="inputmoney" placeholder="<?php echo (L("minimum")); ?>"
                           autofocus="autofocus" style="margin-left: 0.05rem;"></label>
                </div>
                <ul data-v-66de26a6="" class="zftype">
                   
                   <li data-v-66de26a6="" class="bankapi" data-pay_type='T/T'>
                        <div data-v-66de26a6="">
                            <div data-v-66de26a6="" class="cloft">
                                <img data-v-66de26a6="" src="/Public//Qts/Home/img/recharge/1512559073191024782.png" class="tipimg">
                                <span data-v-66de26a6=""><?php echo (L("wire_transfer")); ?></span>
                                <img data-v-66de26a6="" src="/Public//Qts/Home/img/recharge/img5.png" class="recom">
                            </div>
                        </div>
                    </li>
    
                    <li data-v-66de26a6="" class="bankapi on" data-pay_type='MYR'>
                        <div data-v-66de26a6="">
                            <div data-v-66de26a6="" class="cloft">
                                <img data-v-66de26a6="" src="/Public//Qts/Home/img/recharge/bankcard.png" class="tipimg">
                                <span data-v-66de26a6="" style=" color: #AFAEB4;"><?php echo (L("online_payment")); ?></span>
                                <img data-v-66de26a6="" src="/Public//Qts/Home/img/recharge/img4.png" class="recom">
                            </div>
                        </div>
                    </li>
    
                    <li data-v-66de26a6="" class="bankapi" data-pay_type='EPay'>
                        <div data-v-66de26a6="">
                            <div data-v-66de26a6="" class="cloft">
                                <img data-v-66de26a6="" src="/Public//Qts/Home/img/recharge/bankcard.png" class="tipimg">
                                <span data-v-66de26a6="" style=" color: #AFAEB4;"><?php echo (L("global_payments")); ?></span>
                                <img data-v-66de26a6="" src="/Public//Qts/Home/img/recharge/img5.png" class="recom">
                            </div>
                        </div>
                    </li>
    
                    <li data-v-66de26a6="" class="bankapi" data-pay_type='FunPay'>
                        <div data-v-66de26a6="">
                            <div data-v-66de26a6="" class="cloft">
                                <img data-v-66de26a6="" src="/Public//Qts/Home/img/recharge/bankcard.png" class="tipimg">
                                <span data-v-66de26a6="" style=" color: #AFAEB4;"><?php echo (L("taiwan_dollar")); ?></span>
                                <img data-v-66de26a6="" src="/Public//Qts/Home/img/recharge/img5.png" class="recom">
                            </div>
                        </div>
                    </li>
<!--                     <li data-v-66de26a6="" class="bankapi" data-pay_type='alipay'>
                        <div data-v-66de26a6="" >
                            <div data-v-66de26a6="" class="cloft">
                                <img data-v-66de26a6="" src="/Public//Qts/Home/img/recharge/-QQ@2x.png" class="tipimg">
                                <span data-v-66de26a6="">QQ充值</span>
                                <img data-v-66de26a6="" src="/Public//Qts/Home/img/recharge/img5.png" class="recom">
                                <em data-v-66de26a6="">单笔最高限额$5000</em>
                            </div>
                        </div>
                    </li>

                    <li data-v-66de26a6="" class="bankapi" data-pay_type='wetchart'>
                        <div data-v-66de26a6="" >
                            <div data-v-66de26a6="" class="cloft">
                                <img data-v-66de26a6="" src="/Public//Qts/Home/img/recharge/alipay.png" class="tipimg">
                                <span data-v-66de26a6="">支付宝</span>
                                <img data-v-66de26a6="" src="/Public//Qts/Home/img/recharge/img5.png" class="recom">
                                <em data-v-66de26a6="">单笔最高限额$5000</em>
                            </div>
                        </div>
                    </li> -->

                    <!--<li data-v-66de26a6="" class="bankapi on" data-pay_type='ybQuick'>-->
                        <!--<div data-v-66de26a6="" >-->
                            <!--<div data-v-66de26a6="" class="cloft">-->
                                <!--<img data-v-66de26a6="" src="/Public//Qts/Home/img/recharge/bankcard.png" class="tipimg">-->
                                <!--<span data-v-66de26a6="" style=" color: #AFAEB4;">快捷支付</span>-->
                                <!--<img data-v-66de26a6="" src="/Public//Qts/Home/img/recharge/img4.png" class="recom">-->
                                <!--<em data-v-66de26a6="">单笔最高限额$5000</em>-->
                            <!--</div>-->
                        <!--</div>-->
                    <!--</li>-->

                </ul>
                <div data-v-66de26a6="" class="ipt-btn btnColor" onclick="pay();"><?php echo (L("confirm_recharge")); ?></div>
                
                <div data-v-66de26a6="" class="choose">
                    <div data-v-66de26a6="" class="selct" data="1">
                        <?php echo (L("agreed")); ?>
                        <a href="<?php echo U('agreement');?>">
                            <span data-v-66de26a6="" class="txt-blue">《<?php echo (L("service_agreement")); ?>》&nbsp;</span>
                        </a>
                    </div>
                </div>
<!--                 <div data-v-66de26a6="" class="apptip">
                    <p data-v-66de26a6="">如果在app内充值失败，或需要大额入金，</p>
                    <p data-v-66de26a6="">请在电脑端打开
                        <span data-v-66de26a6="">https://www.forexvv.com</span>
                        进行充值。
                    </p>
                    <p data-v-66de26a6="">您的登陆码为7sedj</p>
                </div> -->
            </div>
        </section>
    </div>
</div>
<script src="/Public//Qts/Home/js/jquery.js"></script>
<script>
    //我已阅读
    $('.choose div').click(function(){
        if($(this).attr('data')==0){
            $(this).removeClass('inner').addClass('selct');
            $(this).attr('data',1)
        }else{
            $(this).removeClass('selct').addClass('inner');
            $(this).attr('data',0)
        }
    })
    
    //选择支付方式
    $('.bankapi').click(function () {
        var src = $(this).find('.recom').attr('src');
        newSrc  = src.replace(/[4|5]/g,5);
        thisSrc = src.replace(/[4|5]/g,4);
        $('.recom').attr('src',newSrc);
        $(this).find('.recom').attr('src',thisSrc)
        $(this).addClass('on').siblings().removeClass('on');
    })
    
</script>
</body>
</html>

<script type="text/javascript" src="/Public//Home/css/layer_mobile/layer.js"></script>
<script type="text/javascript">

    //开始支付
    function pay()
    {   
        var status    = "<?php echo ($personal['status']); ?>";
        
        var amount     = $('#inputmoney').val();
        var pay_type    = $('.on').attr('data-pay_type');
            
        var val = $('.selct').attr('data');
        if(val != 1)
        {
            layer.open({
                content: '<?php echo (L("you_must")); ?>',
                btn: '<?php echo (L("determine")); ?>',
                yes: function(index, layero){
                    layer.close(index);
                },
                shadeClose:false,
            });
            return false;
        }
        
        playRecharge(amount,pay_type);

    }


    function playRecharge(amount,pay_type)
    {
        var loading = "<?php echo (L("loading")); ?>";
        var index   = layer.open({type: 2,shadeClose:false,content:loading});

        $.ajax({
            url: "<?php echo U('recharge');?>",
            dataType: 'json',
            type: 'post',
            data: {'amount':amount,'pay_type':pay_type},
            success: function (data) {

                if (data.code == 200) {
                    layer.open({
                        content: data.msg,
                        btn: '<?php echo (L("determine")); ?>',
                        yes: function(index, layero){
                            layer.close(index);
                            top.location.href=data.redirectUrl + '?balanceno=' + data.balanceno+'&amount='+data.amount;
                        },
                        shadeClose:false,
                    });
                } else {
                    layer.open({
                        content: data.msg
                        ,skin: 'msg'
                        ,time: 2 //2秒后自动关闭
                    });
                }
                return layer.close(index);
            },
            error: function (response) {
                console.log(response);
            }
        });
    }

</script>