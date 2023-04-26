<?php if (!defined('THINK_PATH')) exit();?>    <!DOCTYPE html>
<html data-n-head="" lang="zh-tw">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta data-n-head="true" content="Meta description" name="description" data-hid="description">
    <meta data-n-head="true" content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, user-scalable=no,minimum-scale=1.0, maximum-scale=1.0,viewport-fit=contain" data-n-head="true">
    <!--<meta name="viewport" content="... viewport-fit=cover"/>-->
    <title data-n-head="true"><?php echo (L("market")); ?></title>

    <link href="/Public//Qts/Home/css/common.css" rel="stylesheet">
    <link href="/Public//Qts/Home/css/style.css" rel="stylesheet">
    <link href="/Public//Qts/Home/css/details.css" rel="stylesheet">
    
    <script src="/Public/Qts/Home/js/jquery.js"></script>

    <style type="text/css" data-n-head="true">
        body {
            overflow: hidden;
            background: #191A22;
        }

        html {
            overflow: hidden
        }
        .add-list li .variety_left p{
            color: #FCFCFE;
        }
        .add-content .titles1{
            background: #F5F5F5;
            color: #666;
        }
        .edit-list .variety-edit .variety_name{
            color: #FCFCFE;
        }
        .head_edit,.head_add {
            display: none;
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
    <div data-v-145cf773="" class="">
        <div data-v-145cf773="" id="head" class="" style="border-bottom: 1px solid #444">
            <div data-v-145cf773="" class="head_edit"><?php echo (L("editor")); ?></div>
            <span data-v-145cf773="" class="head_name"><?php echo (L("market")); ?></span>
            <div data-v-145cf773="" class="head_add">+</div>
        </div>
        <section data-v-145cf773="" class="page-main">
            <div data-v-145cf773="" class="titles list_class">
                <div data-v-145cf773="" data="0" ><?php echo (L("focus")); ?><span data-v-145cf773=""></span></div>
                <?php if(is_array($optionClass)): $i = 0; $__LIST__ = $optionClass;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div data-v-145cf773="" data="<?php echo ($i); ?>"><?php echo ($vo["name"]); ?><span data-v-145cf773=""></span></div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <div data-v-145cf773="">
                <div data-v-145cf773="" class="title_top">
                    <div data-v-145cf773="" class="title_left"><?php echo (L("trades")); ?></div>
                    <div data-v-145cf773="" class="title_right">
                        <div data-v-145cf773=""><?php echo (L("sell")); ?></div>
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

        <div data-v-145cf773="" class="edit add">
            <div data-v-145cf773="" class="add-content">
                <div data-v-145cf773="" class="head edit-head"><h3 data-v-145cf773="" class="product-name"><a
                        data-v-145cf773="" class="arrow_left"></a><span data-v-145cf773=""><?php echo (L("add_optional")); ?></span></h3>
                        </div>
        <!--   esitlist -->
        <section class=" edit-page-main" style="height: 100%;height: 100%;background: #fff;z-index: 99999999;" >
            <!--titles-->
            <div class="titles">
                
                <?php if(is_array($optionClass)): $i = 0; $__LIST__ = $optionClass;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($i) == "1"): ?><div data-v-145cf773 class="on" data="<?php echo ($i-1); ?>"><?php echo ($vo["name"]); ?><span data-v-145cf773></span></div>
                   <?php else: ?>
                       <div data-v-145cf773  data="<?php echo ($i-1); ?>"><?php echo ($vo["name"]); ?><span data-v-145cf773></span></div><?php endif; endforeach; endif; else: echo "" ;endif; ?>

            </div>
            <!--content-->
            <div class="swiper-container" style="top:46px; height: 100%;">
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
            </div>
        </div>

        <div data-v-145cf773="" class="edit bianji">
            <div data-v-145cf773="" class="edit-content">
                <div data-v-145cf773="" class="head edit-head"><h3 data-v-145cf773="" class="product-name"><a
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
<!--                 <div data-v-145cf773="" class="edit-bottom">
                    <div data-v-145cf773="" class="edit-btn">保存</div>
                </div> -->
            </div>
        </div>
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
            var cWidth=window.innerWidth;
            // alert($(this).attr('data'))
            $('.page-main .swiper-wrapper').css('transform','translate3d(-'+$(this).attr('data')*cWidth+'px, 0px, 0px)');
            // if ($(this).)
        });

        //对添加关注进行显示
        $('.edit-page-main .titles div').click(function () {
            $('.edit-page-main .titles > div').removeClass('on');
            $(this).addClass('on');
            var cWidth = window.innerWidth;
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
            }
        });

        //点击添加 显示弹出层
        $('.head_add').click(function(){
            var user_id = "<?php echo (session('user_id')); ?>";
            if(user_id == ''){
                return window.location.href="<?php echo U('Login/login');?>";
            } else {
                $('.add').show();
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
        });
        

        //获取当前品种宽度 自动加载当前产品对应列表
        var index   = "<?php echo ($index); ?>";
        var cWidth  = window.innerWidth;
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
        $('.footer > ul > li').eq(1).find('a').addClass('common2');
        $('.footer > ul > li').eq(1).find('em').addClass('selected');
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