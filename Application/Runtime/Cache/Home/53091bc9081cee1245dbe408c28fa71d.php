<?php if (!defined('THINK_PATH')) exit();?>    <!DOCTYPE html>
<html data-n-head="" lang="zh-tw">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta data-n-head="true" content="Meta description" name="description" data-hid="description">
    <meta data-n-head="true" content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, user-scalable=no,minimum-scale=1.0, maximum-scale=1.0,viewport-fit=contain" data-n-head="true">
    <!--<meta name="viewport" content="... viewport-fit=cover"/>-->
    <title data-n-head="true"><?php echo (L("personal_center")); ?></title>
    <link href="/Public//Qts/Home/css/common.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/Public//Qts/Home/css/style.css">
    <link rel="stylesheet" type="text/css" href="/Public//Qts/Home/css/user.css">
    <style>
        body{
            background: #1F222B;
        }
        .m-m {
            /*background: rgba(28, 26, 37,.5);*/
        }
        .h-con1lf {
            line-height: 0.3rem;
        }
        .h-t1, .h-t {
            height: 0.3rem !important;
            line-height: 0.3rem !important;
            border: 1px solid #ffc22a !important;
            color: #ffc22a !important;
        }
    </style>
</head>
<body>
<div id="__nuxt">
    <div class="progress" data-v-4a8a9a01=""
         style="width: 0%; height: 2px; background: rgba(1, 40, 97,.5); opacity: 1;"></div>
    <div data-v-adff73de="" class="page-main" style="padding: 0 !important;">
        <div data-v-adff73de="" class="page-shadowC">

            <?php if(empty($_SESSION['user_id'])): ?><div class="h-h" data-v-adff73de="">
                    <div class="p-img fr" data-v-adff73de="">
                        <img src="/Public/Qts/Home/img/me/1499222434250.png" class="fr" data-v-adff73de="">
                    </div>
                    <div class="p-info fl" data-v-adff73de="">
                        <div class="p-login" data-v-adff73de="">
                            <span data-v-adff73de=""><?php echo (L("hello")); ?>,</span>
                        </div>

                        <div style="display:flex" data-v-adff73de="">
                            <p class="accountchange" data-v-adff73de=""><?php echo (L("not_logged")); ?>。</p>
                            <div class="p-plates" data-v-adff73de="">
                                <strong class="plate-selected" data-v-adff73de="" onclick="window.location.href='<?php echo U('Login/login');?>'"><?php echo (L("login")); ?></strong>
                            </div>
                        </div>

                    </div>
                </div>

                <div data-v-adff73de="" class="h-con1">
                    <div data-v-adff73de="" class="h-con1lf">
                        <?php echo (L("account_balance")); ?>：$0.00
                    </div>
                        <div data-v-adff73de="" class="h-con1rf" onclick="window.location.href='<?php echo U('Login/login');?>'">
                            <span data-v-adff73de="" class="h-t1" style="float: left;"><?php echo (L("recharge")); ?></span>
                            <span data-v-adff73de="" class="h-t1"><?php echo (L("withdrawal")); ?></span>
                        </div>
                </div>

            <?php else: ?>

                <div data-v-adff73de="" class="h-h">
                    <div data-v-adff73de="" class="p-img fr">
                        <a href="<?php echo U('userInfo');?>">
                            <img data-v-adff73de="" src="<?php echo ($user["face"]); ?>" class="fr">
                        </a>
                    </div>
                    <div data-v-adff73de="" class="p-info fl">
                        <div data-v-adff73de="" class="p-login1" style="color: #ffbf23"><?php echo ($user["nickname"]); ?></div>
                        <div data-v-adff73de="" style="display: flex;">

                            <?php if(($user['now_trade_status']) == "1"): ?><p data-v-adff73de="" class="accountchange"><?php echo (L("firm_account")); ?></p>
                            <?php else: ?>
                                <p data-v-adff73de="" class="accountchange"><?php echo (L("simulated_accounts")); ?></p><?php endif; ?>

                            <div data-v-adff73de="" class="p-plate">
                                <a href="<?php echo U('BrokersSwitch');?>">
                                    <strong data-v-adff73de="" class="plate-selected"><?php echo (L("switching_accounts")); ?></strong>
                                </a>
                            </div>
                        </div>
                        <img data-v-adff73de="" src="/Public/Qts/Home/img/public/LV<?php echo ($user["level"]); ?>@2x.png" class="gradeimg">

                        <!--<?php if($personal['status'] == '1'): ?>-->
                        <!--<?php elseif($personal['status'] == '0'): ?>-->
                            <!--<p style="color: #E3950D; font-weight: bold; position: absolute; right: .16rem;font-size: 14px;"><?php echo (L("in_audit")); ?></p>-->
                        <!--<?php else: ?>-->
                            <!--<p style="color: #E3950D; font-weight: bold; position: absolute; right: .16rem;font-size: 14px;"><?php echo (L("uncertified")); ?></p>-->
                        <!--<?php endif; ?>-->
                    </div>
                </div>

                <?php if(($user['now_trade_status']) == "1"): ?><div class="h-con1" data-v-adff73de="">
                        <div class="h-con1lf" data-v-adff73de="">
                            <?php echo (L("account_balance")); ?>：<span style="color: #ffca34">$<?php echo ($account["balance"]); ?></span>
                        </div>
                        <div class="h-con1rf" data-v-adff73de="">
                            <!--<a href="<?php echo U('Recharge/index');?>">-->
                            <a href="<?php echo U('Recharge/index');?>" target="_self">
                                <span class="h-t" style="border:1px solid #ffca34;float: left;" data-v-adff73de=""><?php echo (L("recharge")); ?></span>
                            </a>
                            <a href="<?php echo U('Withdrawals/index');?>">
                                <span class="h-t" style="border:1px solid #ffca34;" data-v-adff73de=""><?php echo (L("withdrawal")); ?></span>
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="h-con1" data-v-adff73de="">
                        <div class="h-con1lf" data-v-adff73de="">
                            <?php echo (L("simulated_balance")); ?>：$<?php echo ($account["gold"]); ?>
                        </div>
                        <div class="h-con1rf" data-v-adff73de="">
                            <span class="h-t1" style="float: left;" data-v-adff73de="" onclick="MsgPrompt('<?php echo (L("please_switch")); ?>')"><?php echo (L("recharge")); ?></span>
                            <span class="h-t1" data-v-adff73de="" onclick="MsgPrompt('<?php echo (L("please_switch")); ?>')"><?php echo (L("withdrawal")); ?></span>
                        </div>
                    </div><?php endif; endif; ?>

                <div data-v-adff73de="" class="managerlist">
                    <ul data-v-adff73de="" class="man-f">

                    <a href="<?php echo U('Follow/index');?>">
                        <li data-v-adff73de="">
                            <img data-v-adff73de="" src="/Public//Qts/Home/img/me/img2.png">
                            <p data-v-adff73de=""><?php echo (L("following")); ?></p>
                        </li>
                    </a>

                    <a href="<?php echo U('Investment/index');?>">
                        <li data-v-adff73de="">
                            <img data-v-adff73de="" src="/Public//Qts/Home/img/me/img3.png">
                            <p data-v-adff73de=""><?php echo (L("statistics")); ?></p>
                        </li>
                    </a>

                    <a href="<?php echo U('Withdrawals/bankinfo');?>">
                        <li data-v-adff73de="">
                            <img data-v-adff73de="" src="/Public//Qts/Home/img/me/img4.png">
                            <p data-v-adff73de=""><?php echo (L("banks")); ?></p>
                        </li>
                    </a>

                    <a href="<?php echo U('Message/index');?>">
                        <li data-v-adff73de="" class="linksystem">
                            <img data-v-adff73de="" src="/Public//Qts/Home/img/me/img7.png">
                            <p data-v-adff73de=""><?php echo (L("meessage")); ?></p>
                            <?php if($NoreadCount >= '1'): ?><strong data-v-adff73de=""></strong><?php endif; ?>
                        </li>
                    </a>
    
    
                    <?php if(!empty($user['code'])): ?><a href="<?php echo U('Extension/index');?>">
                            <li data-v-adff73de="">
                                <img data-v-adff73de="" src="/Public//Qts/Home/img/me/img6.png">
                                <p data-v-adff73de=""><?php echo (L("promotion")); ?></p>
                            </li>
                        </a>
                    <?php else: ?>
                            <li data-v-adff73de="" onclick="applyAgent();">
                                <img data-v-adff73de="" src="/Public//Qts/Home/img/me/img6.png">
                                <p data-v-adff73de=""><?php echo (L("promotion")); ?></p>
                            </li><?php endif; ?>
                    
                    </ul>
                        <!--<img onclick="window.location.href='<?php echo U('Index/advanced');?>'" data-v-adff73de="" src="/Public//Qts/Home/img/me/pic_enter_class@2x.png" class="waihuiweek">-->
                </div>

                <div data-v-adff73de="" class="m-m">
                    <ul data-v-adff73de="" class="h-f">
                        <!--<li data-v-adff73de="" class="linkus" onclick="window.location.href='http://tb.53kf.com/code/client/10173921/1'">-->
                            <!--<?php echo (L("service")); ?>-->
                            <!--<img data-v-adff73de="" src="/Public//Qts/Home/img/me/img8.png">-->
                        <!--</li>-->

                        <li data-v-adff73de="" class="warning linkus" onclick="window.location.href='<?php echo U('Help/Risk');?>'">
                            <?php echo (L("risk_warning")); ?>
                            <img data-v-adff73de="" src="/Public//Qts/Home/img/me/img8.png">
                        </li>

                        <li data-v-adff73de="" class="helps" onclick="window.location.href='<?php echo U('Help/help');?>'"><?php echo (L("help_center")); ?></li>

                        <!--<li data-v-adff73de="" class="set" onclick="window.location.href='<?php echo U('Lang/index');?>'"><?php echo (L("lang_choice")); ?></li>-->

                        <li data-v-adff73de="" class="set" onclick="window.location.href='<?php echo U('Setting/index');?>'"><?php echo (L("account_settings")); ?></li>

                    </ul>
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
</div>

</body>
</html>

<script src="/Public/Qts/Home/js/jquery.js"></script>
<script type="text/javascript" src="/Public//Home/css/layer_mobile/layer.js"></script>

<script type="text/javascript">

//信息提示
    function MsgPrompt(msg)
    {
        layer.open({
            content: msg
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
    }

    //申请成为代理商
    function applyAgent()
    {
        layer.open({
            content: "<?php echo (L("confim_msg")); ?>"
            ,btn: ["<?php echo (L("determine")); ?>", "<?php echo (L("do_not")); ?>"]
            ,shadeClose:false
            ,yes: function(index){
                var please_wait = "<?php echo (L("please_wait")); ?>";
                var load   = layer.open({type: 2,shadeClose:false,content:please_wait});
                $.ajax({
                    url: "<?php echo U('Extension/applyAgent');?>",
                    dataType: 'json',
                    type: 'post',
                    success: function (data) {
                        layer.open({
                            content: data.msg
                            ,skin: 'msg'
                            ,time: 2 //2秒后自动关闭
                        });
                        layer.close(load);
                        if(data.code == 200) return setTimeout(" window.location.href='<?php echo U('Extension/index');?>'",500);
                    },
                    error: function (response) {
                        console.log(response);
                    }
                });
            }
        });
    }

    window.onload=function(){
        //设置底部导航选中状态
        $('.footer > ul > li').last().find('a').addClass('common3');
        $('.footer > ul > li').last().find('em').addClass('selected');
    }


    // function sort(array)
    // {
    //     var compare = function(val1,val2){
    //         return val2 - val1;
    //     };
    //
    //     array.sort(compare);
    //
    //     return array;
    // }
// console.log(sort([2,3,45,7]));

    // function sum(head,foot){
    //     let arr = [];
    //     let a   = 0;//鸡
    //     let b   = 0;//兔
    //     for(let a = 0; a < head; a++){
    //         b= (head-a);
    //         if(2*a+4*b==foot){
    //             arr.push(a,b);
    //         }
    //     }
    //
    //     return arr;
    // }
    //
    // arr = sum(48,132);




</script>