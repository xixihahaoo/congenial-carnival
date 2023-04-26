<?php if (!defined('THINK_PATH')) exit();?>    
    <!DOCTYPE html>
<html data-n-head="" lang="zh-tw">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta data-n-head="true" content="Meta description" name="description" data-hid="description">
    <meta data-n-head="true" content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, user-scalable=no,minimum-scale=1.0, maximum-scale=1.0,viewport-fit=contain" data-n-head="true">
    <!--<meta name="viewport" content="... viewport-fit=cover"/>-->
    <title data-n-head="true"><?php echo (L("to_login")); ?></title>
    <link href="/Public/Qts/Home/css/common.css" rel="stylesheet">


    <style type="text/css">.captcha[data-v-2d3e0ef2] {
        width: .89rem;
        height: .28rem;
        color: #ddd;
        position: absolute;
        right: .01rem;
        top: .12rem;
        text-align: center;
        line-height: .28rem;
        border-radius: .01rem
    }

    .cap[data-v-2d3e0ef2] {
        color: #2187f7
    }

    .login_footers[data-v-2d3e0ef2] {
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        padding: 0 .2rem;
        width: 100%;
        overflow: hidden;
        font-size: 15px;
        color: #999;
        margin-top: .2rem
    }

    .login_footers > div[data-v-2d3e0ef2]:first-of-type {
        float: left
    }

    .login_footers > div[data-v-2d3e0ef2]:nth-of-type(2) {
        position: relative;
        float: right;
        color: #2187f7;
        padding-right: .15rem
    }

    h2[data-v-2d3e0ef2] {
        font-size: 30px;
        color: #999;
        line-height: .9rem
    }

    .nuxt-link-exact-active[data-v-2d3e0ef2] {
        color: #999;
        text-decoration: none
    }

    .content[data-v-2d3e0ef2] {
        padding: 0 .2rem
    }

    label[data-v-2d3e0ef2] {
        position: relative;
        display: block
    }

    .login_form[data-v-2d3e0ef2] {
        margin: 0 auto;
        text-align: center
    }

    input[data-v-2d3e0ef2] {
        position: relative;
        width: 100%;
        height: .48rem;
        margin-top: .05rem;
        -webkit-box-shadow: inset 0 0 0 0 #ddd;
        box-shadow: inset 0 0 0 0 #ddd;
        border-bottom: .01rem solid #444;
        color: #999;
    }

    .login_btn[data-v-2d3e0ef2] {
        position: relative;
        margin-top: .42rem
    }

    .login_btn1[data-v-2d3e0ef2] {
        position: relative;
        margin-top: .15rem
    }

    .login_btn i[data-v-2d3e0ef2] {
        position: absolute;
        display: none;
        top: .16rem;
        left: 58%;
        display: block;
        width: .15rem;
        height: .15rem;
        background-size: 100%
    }

    .login_btn .activeColor[data-v-2d3e0ef2] {
        /*background-image: -o-linear-gradient(319deg, #1254a8 0, #0c62c1 100%);*/
        /*background-image: linear-gradient(-229deg, #1254a8, #0c62c1)*/
        background: #ffbf23;
    }

    .login_btn .activeBg[data-v-2d3e0ef2] {
        background-image: url(/_nuxt/img/login_loading.gif)
    }

    .squre[data-v-2d3e0ef2] {
        position: relative;
        font-weight: 400;
        display: block;
        margin: 0 .03rem 0 .04rem;
        text-align: center;
        line-height: .44rem;
        border-radius: .44rem;
        font-size: .17rem;
        letter-spacing: 0
    }

    span[data-v-2d3e0ef2] {
        background-color: #cecfd1;
        color: #000
    }

    b[data-v-2d3e0ef2] {
        color: #ffbf23;
        border: .01rem solid #ffbf23;
    }

    b > a[data-v-2d3e0ef2] {
        display: block;
        width: 100%;
        height: 100%
    }

    </style>
    <style type="text/css">#header[data-v-7fd5ad9d] {
        width: 100%;
        text-align: center;
        color: #012057;
        z-index: 4;
        top: 0
    }

    #header h3[data-v-7fd5ad9d] {
        position: relative;
        height: .5rem;
        line-height: .5rem;
        margin: 0;
        font-size: .16rem;
        font-weight: 400;
        overflow: hidden
    }

    #header .header_content .left[data-v-7fd5ad9d] {
        position: absolute;
        top: 0;
        left: .2rem
    }

    #header .header_content .right[data-v-7fd5ad9d] {
        position: absolute;
        top: .1rem;
        right: .2rem
    }

    #header .header_content .left a[data-v-7fd5ad9d] {
        color: #fff;
        line-height: .5rem;
        font-size: .2rem
    }

    .arrow_white[data-v-7fd5ad9d]:after {
        border-color: #fff
    }

    .arrow_left[data-v-7fd5ad9d]:after, .arrow_white[data-v-7fd5ad9d]:after {
        content: " ";
        display: inline-block;
        -webkit-transform: rotate(225deg);
        -ms-transform: rotate(225deg);
        transform: rotate(225deg);
        height: .17rem;
        width: .17rem;
        border-width: .02rem .02rem 0 0;
        border-style: solid;
        top: -.02rem;
        position: absolute;
        left: 0;
        top: .19rem
    }

    .arrow_left[data-v-7fd5ad9d]:after {
        border-color: #012057
    }

    .arrow_right[data-v-7fd5ad9d] {
        display: inline-block;
        top: .15rem;
        width: .25rem;
        height: .25rem;
        background-image: url("/Public//Qts/Home/img/user/exit.png");
        background-size: 100%
    }

    </style>
</head>
<body>
<div id="__nuxt">
    <div class="progress" data-v-4a8a9a01=""
         style="width: 0%; height: 2px; background-color: rgb(1, 40, 97); opacity: 0;"></div>
    <div data-v-2d3e0ef2="" class="">
        <div data-v-7fd5ad9d="" data-v-2d3e0ef2="" id="header">
            <div data-v-7fd5ad9d="" class="header_content"><h3 data-v-7fd5ad9d=""></h3><!---->
                <div data-v-7fd5ad9d="" class="right"><a data-v-7fd5ad9d="" class="arrow_right" onclick="window.history.back(-1);"></a></div>
            </div>
        </div>
        <div data-v-2d3e0ef2="" class="content">
            <h2 data-v-2d3e0ef2=""><?php echo (L("to_login")); ?></h2>
            <div data-v-2d3e0ef2="">
                <div data-v-2d3e0ef2="" class="login_form">
                    <div data-v-2d3e0ef2="" class="ipt-group">
                        <label data-v-2d3e0ef2="">
                            <input data-v-2d3e0ef2="" type="email" placeholder="<?php echo (L("input_mailbox")); ?>"  value="<?php echo ($username); ?>" autofocus="autofocus">
                            <i data-v-2d3e0ef2="" style="display: none" class="icon icon_tel"></i>
                        </label>
                    </div>

                    <div data-v-2d3e0ef2="">
                        <div data-v-2d3e0ef2="" class="ipt-group">
                            <label data-v-2d3e0ef2="">
                                <input data-v-2d3e0ef2="" type="password" placeholder="<?php echo (L("input_password")); ?>" maxlength="15" class="password">
                                <i data-v-2d3e0ef2="" class="icon icon_pwd" style="display: block;"></i>
                            </label>
                        </div>
                    </div>
                </div>

                <div data-v-2d3e0ef2="" class="login_btn">
                    <span data-v-2d3e0ef2="" class="squre login" onclick="login();">
                        <?php echo (L("sign_in")); ?>
                        <i data-v-2d3e0ef2="" class=""></i>
                    </span>
                </div>

                <div data-v-2d3e0ef2="" class="login_btn login_btn1">
                    <b data-v-2d3e0ef2="" class="squre">
                        <a data-v-2d3e0ef2="" href="<?php echo U('Register/reg');?>" class=""><?php echo (L("sign_up")); ?></a>
                    </b>
                </div>
            </div>
        </div>
        <div data-v-2d3e0ef2="" class="login_footers">
            <div data-v-2d3e0ef2="">
                <a data-v-2d3e0ef2="" href="<?php echo U('Register/outpwd');?>" class=""><?php echo (L("forget_password")); ?></a>
            </div>
        </div>
    </div>
</div>


<script src="/Public/Qts/Home/js/jquery.js"></script>
<script type="text/javascript" src="/Public//Home/css/layer/layer.js"></script>
<script type="text/javascript" src="/Public//Qts/Home/js/appAlert.js"></script>
<script>
    $('.icon.icon_pwd').click(function () {
        if ($(this).attr('data') == 0) {
            $(this).siblings().attr('type', 'password')
            $(this).attr('data', 1)
        } else {
            $(this).attr('data', 0)
            $(this).siblings().attr('type', 'text')
        }
    });

    $('input').keyup(function () {

        var email   = $('input[type=email]').val();
        var pwd     = $('.password').val();
        var reg     = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
        if(reg.test(email) && pwd != '') {
            $('.login').addClass('activeColor');
        } else {
            $('.login').removeClass('activeColor');
        }
    });

    /**
     * [login 登录]
     * @return void
     */
    function login()
    {
        var email       = $('input[type=email]').val();
        var password    = $(".password").val();

        try{
            showProgress();
        }catch(e){
            var index = layer.load(2);
        }

        $.ajax({
            type: "post",
            url: "<?php echo U('login');?>",
            dataType: 'json',
            data:{'email':email,'password':password},
             success: function (data) {

                try{
                    closeProgress();
                }catch(e){
                    layer.close(index);
                }

                if(data.code === 400)
                {
                    try{
                        return alertMessage(data.msg,1000);
                    }catch(e){
                        return layer.msg(data.msg);
                    }
                }
                if(data.code === 200)
                {
                    try{
                        alertMessage(data.msg,1000);
                    }catch(e){
                        layer.msg(data.msg);
                    }
                    return window.setTimeout("window.location='<?php echo U('Index/index');?>'",1500);
                }
             }
        });
    }


</script>
</body>
</html>