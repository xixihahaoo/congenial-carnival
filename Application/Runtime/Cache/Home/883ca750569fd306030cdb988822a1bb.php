<?php if (!defined('THINK_PATH')) exit();?>    <!DOCTYPE html>
<html data-n-head="" lang="zh-tw">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta data-n-head="true" content="Meta description" name="description" data-hid="description">
    <meta data-n-head="true" content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, user-scalable=no,minimum-scale=1.0, maximum-scale=1.0,viewport-fit=contain" data-n-head="true">
    <!--<meta name="viewport" content="... viewport-fit=cover"/>-->
    <title data-n-head="true"><?php echo (L("transaction_records")); ?></title>
    <link href="/Public/Qts/Home/css/common.css" rel="stylesheet">
    <link rel="stylesheet" href="/Public//Qts/Home/js/layerui/css/layui.css"  media="all">
    <style>
           
        ul.lists[data-v-161fa528] {
            width: 100%;
            padding: .15rem
        }

        ul.lists li[data-v-161fa528] {
            width: 100%;
            padding: .1rem .15rem .1rem .25rem;
            background: #1F222B;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            display: -webkit-flex;
            position: relative;
            color: #999999 !important;
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
            color: #888
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
            color: #999
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
            background: rgba(0, 0, 0, .4);
            z-index: 9999
        }

        .sift[data-v-161fa528] {
            background: #171520;
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
            border-bottom: .1rem solid #171520;
            position: absolute;
            top: -.2rem;
            right: .06rem
        }

        .sift ul li[data-v-161fa528] {
            line-height: 35px;
            border-bottom: 1px solid #444;
            color: #fcffec;
            font-size: .14rem;
            text-align: center;
            width: .8rem
        }

        .sift ul li.on[data-v-161fa528] {
            color: #2187f7
        }

        .sift ul li[data-v-161fa528]:last-child {
            border: none
        }

    </style>
</head>
<body>
    
    <input type="hidden" name="orderType" value="0">

<div id="__nuxt">
    <div class="progress" data-v-4a8a9a01=""
         style="width: 0%; height: 2px; background-color: rgb(1, 40, 97); opacity: 0;"></div>
    <div data-v-161fa528="" class="content">
        <div data-v-161fa528="" id="head">
            <div class="head_content"><h3 class="product-name"><span><?php echo (L("transaction_records")); if(($user['now_trade_status']) == "2"): ?>（<?php echo (L("simulation")); ?>）<?php endif; ?></span><em></em></h3>
                <div class="left" onclick="window.location.href='<?php echo ($urlcan); ?>'"><a class="arrow_left"></a></div>
                <div class="right arrow_right"><b><?php echo (L("screening")); ?></b></div>
            </div>
        </div>
        <section data-v-161fa528="" class="page-main">
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