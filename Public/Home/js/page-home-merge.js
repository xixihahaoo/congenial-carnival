(function () {
    var MERGE_MODS = {
        "assets/lib/jquery/1.0/main": function () {
            define(function () {
                "use strict";
                return jQuery
            });
        },
        "assets/lib/lodash/1.0/main": function () {
            define(function () {
                "use strict";
                return _
            });
        },
        "assets/js/util/timer": function () {
            define(function () {
                "use strict";
                var n = 0,
                    t = {}, e = window.requestAnimationFrame || window.webkitRequestAnimationFrame || function (n) {
                            window.setTimeout(n, 17)
                        }, i = function (n) {
                        return "number" == typeof n
                    }, u = function () {
                        var n = Object.keys(t);
                        if (n.length) {
                            var e = Date.now();
                            n.forEach(function (n) {
                                var i = t[n];
                                if (null != i && e - i.time >= i.wait) {
                                    var u = i.times;
                                    u > 0 && u--, i.fn.call(i.context), -1 === u || u > 0 ? (i.time = Date.now(), i.times = u) : (i = null, delete t[n])
                                }
                            })
                        }
                    }, r = function (n) {
                        t[n + ""] && delete t[n + ""]
                    }, o = function () {
                        u(), e(o)
                    };
                return o(), {
                    add: function (e, u, o, a) {
                        return 2 === arguments.length ? i(u) ? 100 > u && (a = u, u = 1e3) : (o = u, u = 1e3) : 3 === arguments.length && (i(o) ? (a = o, o = null) : i(u) || (a = o, o = u, u = 1e3)), n++, t[n + ""] = {
                            id: n,
                            fn: e,
                            wait: u || 1e3,
                            context: o,
                            times: null != a ? a : -1,
                            time: Date.now()
                        }, {
                            id: n,
                            clear: function () {
                                r(this.id)
                            }
                        }
                    },
                    one: function (n, t, e) {
                        return null == t || i(t) || (e = t, t = 1e3), this.add(n, t, e, 1)
                    },
                    ever: function (n, t, e) {
                        return null == t || i(t) || (e = t, t = 1e3), this.add(n, t, e, -1)
                    },
                    async: function (n) {
                        return this.add(n, 25, null, 1)
                    },
                    clear: function (n) {
                        null != n && i(n) && r(n)
                    }
                }
            });
        },
       "assets/js/biz/page/home/carousel": function () {
            define(function (require) {
                var t = require("$"),
                    n = (require("_"), require("util/timer")),
                    k = require("util/cookie"),
                    j = require("ui/loading"),
                    u = require("ui/msgbox"),
                    e = t("#doc"),
                    isLogin = false,
                    f = (require("log"), require("net")),
                    m,
                    colorList = {
                        'HSI':'color:#BD6959',
                        'MHI':'color:#8097C1',
                        'ni':'color:#9777B4',
                        'pp':'color:#7DB181',
                        'au':'color:#7C7931',
                        'ag':'color:#7FCACA',
                        'rb':'color:#D19FC7',
                        'SR':'color:#CACA96',
                        'cu':'color:#949EC3',
                        'CL':'color:#b857b2',
                        'GC':'color:#B59449',
                        'DAX':'color:#A8D2C6',
                        'CN':'color:#CC9D82',
                        'ES':'color:#917795',
                        'NQ':'color:#62a4a8',
                        'SI':'color:#98CB76',
                        'YM':'color:#BD6959',
                        'DAX':'color:#A8D2C6',
                        'CN':'color:#CC9D82',
                        'ES':'color:#917795',
                        'NQ':'color:#62a4a8',
                        'SI':'color:#98CB76',
                        'YM':'color:#BD6959',
                        'gray': 'color:#cecece',
                        'AD': 'color:#c7c577',
                        'CD': 'color:#7fcbd4',
                        'NE': 'color:#bda5ce',
                        'SL': 'color:#d9ad9c'
                    },
                    i = e.find("section.main-home"),
                    r = i.find("div.mod-carousel"),
                    a = r.children("ul");
                return {
                    init: function () {
                        this.loadImage(1);
                        this.loadStatus();
                        this.Extension();
                        this.getLiveId();
                        //this.Carousel();
                        //this.information();
                    },
                    wait: function () {
                        var t = this;

                        var e = a.children("li"),
                            i = e.length - 1,
                            r = 0,
                            s = 0;
                        if (!(e.length <= 1)) {
                            var c = function (t) {
                                return t > i ? 0 : t
                            }, f = function (t) {
                                return 0 > t ? i : t
                            }, o = function () {
                                n.clear(s), s = n.one(function () {
                                    a.trigger("swipeleft")
                                }, 3e3).id
                            };
                            a.on("swipeleft", function () {
                                o();
                                var n = e.eq(r),
                                    i = e.eq(r = c(r + 1));
                                n.animate({
                                    left: "-100%"
                                }), i.css({
                                    left: "100%"
                                }), i.animate({
                                    left: 0
                                }, function () {
                                    e.eq(c(r + 1)).css({
                                        left: "100%"
                                    })
                                }), t.setCurrDot(r), t.setImageUrl(i.find("img"))
                            }), a.on("swiperight", function () {
                                o();
                                var n = e.eq(r),
                                    i = e.eq(r = f(r - 1));
                                n.animate({
                                    left: "100%"
                                }), i.css({
                                    left: "-100%"
                                }), i.animate({
                                    left: 0
                                }, function () {
                                    e.eq(f(r - 1)).css({
                                        left: "-100%"
                                    })
                                }), t.setCurrDot(r), t.setImageUrl(i.find("img"))
                            }), o()
                        }
                        $('#gold').on("tap",function(){
                            if(!isLogin){
                                window.location='/user/login.html';
                            }
                            else{
                                window.location='/mall/mall.html?1';
                            }
                        });
                        $('#tuig').on('click',function(){
                            if(!isLogin){
                                window.location = '../user/login.html';
                                return false;
                            }
                            $.ajax({
                                type:'get',
                                url:'/user/user/findPromoterCode.do',
                                data:{},
                                dataType:'json',
                                success:function(d){
                                    if(d.data){
                                         window.location.href = '/mine/extension.html';
                                    }else{
                                        u.confirm('您还不是我们的推广员，是否要成为我们的推广员？',function(){
                                            $.ajax({
                                                url: '/user/user/toBePromoter.do',
                                                data: {},
                                                dataType: 'json',
                                                type: 'post',
                                                success: function (data) {
                                                    window.location.href = '/mine/extension.html';
                                                }
                                            });
                                        })
                                        return false;
                                    }
                                }
                            })
                            
                        });
                    },
                    loadEndTime:function(t){
                        var s = parseInt(t.split(':')[0]),str='';
                        if(s<6){
                            str = '凌晨';
                        }
                        if(s>=18){
                            str = '晚间';
                        }
                        if(12<s&&s<18){
                            str ='下午';
                        }
                        return str+t;
                    },
                    loadStatus: function () {
                        var _=this;
                        f.get({
                            url:'user/user/getChannelByDomain.do',
                            success:function(e){
                                if(e.code==200){
                                    t('.productName').text(e.data.productName);
                                    t('#tele').text('客服电话：'+e.data.phone);
                                    if(e.data.qqType==2){
                                        t('#QQ').attr('href','http://wpa.qq.com/msgrd?v=3&uin='+e.data.qq+'&site=qq&menu=yes');
                                    }else{
                                        var _qq = e.data.qq;
                                        function Biz(){
                                            BizQQWPA.addCustom({aty: '0', a: '0', nameAccount: _qq, selector: 'QQ'});

                                        }
                                        t('#service').on('click',Biz());
                                    }
                                    
                                }
                            }
                        })
                        f.get({
                            url: '/order/variety/getVariety.do',
                            data: {},
                            beforeSend:function(){
                                j.show();
                            },
                            success: function (e) {
                                var makehotlist = function(currency,rm) {
                                    var lis = "";
                                    var tags = ['','<span class="icon-new hot"></span>','<span class="icon-remen hot"></span>']
                                    var tag = tags[rm];
                                    var times=e.data[i].openMarketTime.split(';');
                                    var openTime=times[0],endTime=_.loadEndTime(times[times.length-1]);
                                    lis += '<li class="tradeList" tradeId="' + e.data[i].varietyType.toUpperCase() + '"><a href="' + _url + '"><span class="img"><i class="icon-' + e.data[i].varietyType + '" style="' + (e.data[i].exchangeStatus==1? colorList[e.data[i].varietyType] : colorList['gray']) + '"></i></span><div class="list-info"><p><span class="list-name block">' + e.data[i].varietyName + '</span>'+tag+'<em class="chicangTxt">持仓中</em><span class="list-img "><i class="right-icon"><span class="icon-sun icon-star"></span><span class="icon-moon icon-star"></span><i class="list-txt">T+0</i></i></span></p><p><span class="gray mt02">' + (e.data[i].advertisement || '')+ '</span><span class="gray list-time">' + openTime+'-'+endTime + '</span> </p> <div class="right-arrow"></div></div> </a> </li>';
                                    if (currency) {
                                        $('#hot-internal-list').append(lis);
                                        $("#gupji").show();
                                    } else {
                                        $('#hot-comm-list').append(lis);
                                        $("#gupnei").show();
                                    }
                                }

                                if (e.code == 200) {
                                    for (var i = 0; i < e.data.length; i++) {
                                        var _url = e.data[i].isDomestic  ? 'trade/index.html?commodity=' + e.data[i].varietyType.toUpperCase() : 'guoji/index.html?commodity=' + e.data[i].varietyType;
                                        makehotlist(e.data[i].isDomestic,e.data[i].tags);
                                       
                                    }
                                    k.setItem('future', JSON.stringify(e.data));
                                }
                            },
                            complete:function(){
                                j.hide();
                                f.get({
                                    url: '/order/order/getUserPositionCount.do',
                                    data: {},
                                    dataType:'json',
                                    success: function (d) {
                                        d.code==503?isLogin=false:isLogin=true;
                                        if(!d.data)return;
                                        if(d.data.integralOpS.length){
                                            $(".chicang").show();
                                        }
                                        for(var i=0;i<d.data.cashOpS.length;i++) {
                                            var c = d.data.cashOpS[i];
                                             $(".tradeList[tradeid='"+c.varietyType+"']").find("em").show();
                                        }
                                    }
                                });
                                _.loadRange();

                            }
                        })
                    },
                    loadRange:function(){
                        var _this=this;
                        clearTimeout(m);
                        f.get({
                            url: '/quota/quota/getAllQuotaData.do',
                            data: {},
                            success: function (d) {
                               if(d.data){
                                    for(var i=0;i<d.data.length;i++){
                                        var _class=parseFloat(d.data[i].floatPricePoint)<0?'text-lows':'text-highs';
                                        $('li[tradeid="'+d.data[i].varietyType+'"]').find('i.right-icon').html('<span class="text-range '+_class+'">'+d.data[i].lastPrice +'&nbsp;&nbsp;'+d.data[i].floatPricePoint+'</span>')
                                    }
                               }
                              
                            },
                            error:function(){}
                        })
                        m=setTimeout(function(){ _this.loadRange();},5000);


                    },
                    loadImage: function (n) {
                        var _this = this,
                            i = '',
                            _img = "",
                            bot = "";
                        f.get({
                            url: '/user/news/findNewsList.do',
                            data: {
                                type: 0,
                            },
                            success: function (e) {
                                if (e.code == 200) {
                                    var _list = e.data;
                                    for (var i = 0; i < _list.length; i++) {
                                        _list[i].style=='html'?_list[i].url ='/news/newsDtl.html?id='+_list[i].id:_list[i].url =_list[i].content;
                                        _img += '<li><a href="' + _list[i].url + '"> <img src="' + _list[i].cover + '"></a></li>';
                                        bot += '<span class="dot"></span>';
                                    }

                                    a.append(_img);
                                    r.children("div").append(bot);
                                    r.find("span.dot:eq(0)").addClass("curr");
                                    _this.wait();
                                }
                            }
                        });
                       

                    },
                    setImageUrl: function (t) {
                        t.attr("src") || t.attr("src", t.data("src"))
                    },
                    setCurrDot: function (t) {
                        var n = r.find("span.dot").eq(t);
                        n.siblings(".curr").removeClass("curr"), n.addClass("curr")
                    },
                    Extension : function(){
                        if(getUrlParam('abc')) {
                            k.setItem('promoteCode',getUrlParam('abc'))
                           
                              
                        }
                        
                        function getUrlParam(name) {
                            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
                            var r = window.location.search.substr(1).match(reg);  //匹配目标参数
                            if (r != null) return unescape(r[2]); return null; //返回参数值
                        }
                    },
                    getLiveId:function(){
                        f.get({
                            url:'/user/live/getActivity.do',
                            success:function(d){
                                if(d.data.activityId){
                                    k.setItem('liveId',d.data.activityId);
                                }
                            }
                        })
                    },
                    Carousel : function(){
                       var Apeople = t('#onLine').find('.line_left').find('span') 
                       var AlbUl = t('#onLine').find('.line_right');
                       var AlbLi = '';
                       var timer1 = null;
                       var timer2 = null;
                       var iNow1 = 0;
                        
                       t.ajax({
                           url : 'order/order/indexReport',
                           data : {},
                           type : 'post',
                           dataType : 'json',
                           success : function(data){
                               if(data.code == 200){
                                   Apeople.html(data.data.count);
                                   for(var i=0; i<data.data.resultList.length;i++){
                                       var num2 = data.data.resultList[i].tradeType[1].charCodeAt();
                                       var color1 = '';
                                       
                                       if(num2 == 31354){//空
                                          color1 = '#17b03e';
                                       }
                                       else if(num2 == 22810){//多
                                          color1 = '#d0402d';
                                       }
                                       
                                       var Ali = t('<li>'+data.data.resultList[i].nick+'<span> '+data.data.resultList[i].time +' </span>'+'<span style="color:'+color1+'">'+data.data.resultList[i].tradeType+'</span><span> '+data.data.resultList[i].futuresType+'</span>'+'</li>');
                                       AlbUl.append(Ali);
                                   }

                                   AlbLi = AlbUl.find('li');

                               }
                           }
                       });

                       timer1 = setInterval(function(){
                           AlbLi.eq(iNow1).css('top','-0.35rem');
                           AlbLi.eq(iNow1+1).css('top','0');
                           if(iNow1<3){
                               iNow1++;
                           }
                       },4000);

                       timer2 =setInterval(function(){
                           clearInterval(timer1);
                           AlbUl.html('');
                           iNow1 = 0;

                           t.ajax({
                               url : 'order/order/indexReport',
                               data : {},
                               type : 'post',
                               dataType : 'json',
                               success : function(data){
                                   if(data.code == 200){
                                       Apeople.html(data.data.count);
                                       for(var i=0; i<data.data.resultList.length;i++){
                                           var num2 = data.data.resultList[i].tradeType[1].charCodeAt();
                                       var color1 = '';
                                       
                                       if(num2 == 31354){//空
                                          color1 = '#17b03e';
                                       }
                                       else if(num2 == 22810){//多
                                          color1 = '#d0402d';
                                       }
                                       
                                       var Ali = t('<li>'+data.data.resultList[i].nick+'<span> '+data.data.resultList[i].time +' </span>'+'<span style="color:'+color1+'">'+data.data.resultList[i].tradeType+'</span><span> '+data.data.resultList[i].futuresType+'</span>'+'</li>');
                                       AlbUl.append(Ali);
                                       }

                                       AlbLi = AlbUl.find('li');

                                   }
                               }
                           });

                           timer1 = setInterval(function(){
                               AlbLi.eq(iNow1).css('top','-0.35rem');
                               AlbLi.eq(iNow1+1).css('top','0');
                               if(iNow1<3){
                                   iNow1++;
                               }
                           },4000);
                       },21000)
                       
                       
                    },
                    information : function(){
                        var newMask = t('#newMask');
                        var Maskcon = newMask.find('.Maskcon');
                        var newMaskP = newMask.find('p');
                        var newMaskH3 = newMask.find('h3');
                        var newMaskA = newMask.find('a');
                        var newNone = t('#newNone');
                        
                        var onoff = false;
                        
                        if(k.getItem('token') != null){
                            onoff = true;
                        }
                        
                        t.ajax({
                           url : '/sms/message/popupSystemMessage',
                           data : {},
                           type : 'post',
                           dataType : 'json',
                           success : function(data){
                               
                               if((data.code == 200) && onoff){
                                   if(k.getItem('newId') != data.data.id){
                                       newMaskH3.html(data.data.title);
                                       newMaskP.html(data.data.content);
                                       k.setItem('newId',data.data.id);
                                       newMaskA.attr('href','/news/detailed.html?id='+data.data.id);
                                       newMask.show();
                                   }
                               }
                           }
                        });
                        
                        Maskcon.on('click',function(ev){
                            ev.stopPropagation();
                        });
                        
                        newMask.on('click',function(){
                            t(this).hide();
                        });
                        
                        newNone.on('click',function(){
                            newMask.hide();
                        });
                        
                    }
                }
            });
        },
        "data/holidays/1.0/main": function () {
            define(function (require) {
                "use strict";
                var e = require("_"),
                    t = {
                        2016: {}
                    };
                return {
                    isHoliday: function (n) {
                        n = n || new Date,
                            n = n instanceof Date ? n : new Date(n);
                        var a = t[n.getFullYear()];
                        if (!a) return !1;
                        var r = a[n.getMonth() + 1];
                        return r ? e.contains(r, n.getDate()) : !1
                    },
                    isWeekend: function (e) {
                        e = e || new Date,
                            e = e instanceof Date ? e : new Date(e);
                        var t = e.getDay();
                        return 0 === t || 6 === t
                    }
                }
            });
        },
       
        "assets/js/lang/mod-loader": function () {
            define(function (require, n, i) {
                "use strict";
                var t = require("$"),
                    c = require("_"),
                    r = t("#doc"),
                    f = function (n) {
                        return r.find(n).length
                    }, o = function (n) {
                        c.each(n, function (n) {
                            c.isString(n) ? require.async(n, function (n) {
                                n && n.init && n.init()
                            }) : n && n.init && n.init()
                        })
                    };
                i.exports = function (n) {
                    c.isString(n) && (n = [n]), c.isArray(n) ? o(n) : c.each(n, function (n, i) {
                        f(i) && o(c.isArray(n) ? n : [n])
                    })
                }
            });
        },
        "assets/js/biz/page/home/done": function () {
            define(function (require) {
                "use strict";
                var e = require("modLoader");
                e({
                    "section.main-home": ["page/home/carousel"],
                    "section.main-home-kefu": "page/home/kefu"
                })
            });
        },
        "assets/js/lang/log": function () {
            define(function () {
                "use strict";
                var n = !!window.console,
                    o = function () {
                        n && console.log.apply(console, arguments)
                    };
                return o.warn = function () {
                    n && console.warn.apply(console, arguments)
                }, o.error = function () {
                    n && console.error.apply(console, arguments)
                }, o
            });
        },
        "assets/js/util/json": function () {
            define(function (require, exports, module) {
                "use strict";
                return {
                    parse: function (txt) {
                        return txt && eval("(" + txt + ")")
                    },
                    stringify: function (t) {
                        return JSON.stringify(t)
                    }
                }
            });
        },
        "assets/js/util/strings": function () {
            define(function () {
                "use strict";
                return {
                    format: function () {
                        var n = /\$\w+|\$\{\w+\}/g,
                            r = /\$|\{|\}/g,
                            t = function (n) {
                                return n.replace(r, "")
                            };
                        return function (r, u) {
                            return r.replace(n, function (n) {
                                var r = u[t(n)];
                                return null == r ? n : r
                            })
                        }
                    }(),
                    tpl: function (n) {
                        var r = this;
                        return function (t) {
                            return r.format(n, t)
                        }
                    }
                }
            });
        },
        "assets/js/util/numbers": function () {
            define(function () {
                "use strict";
                var r = {
                    u: function (n, u) {
                        u || (u = 0), r.isS(n) && (n = r.f(n));
                        var o;
                        return n > 0 ? 1e5 > n ? r.round(n) : (1e8 > n ? (n /= 1e4, o = "万") : (n /= 1e8, o = "亿"), 0 == u ? r.round(n, 2).toFixed(2) + o : 1 == u ? n >= 100 ? r.round(n) + o : r.round(n, 2).toFixed(2) + o : 2 == u ? n >= 100 ? r.round(n) + o : r.round(n, 1).toFixed(1) + o : r.round(n) + o) : 0 > n ? n > -1e5 ? r.round(n) : (n > -1e8 ? (n /= 1e4, o = "万") : (n /= 1e8, o = "亿"), 0 == u ? r.round(n, 2).toFixed(2) + o : 1 == u ? -100 >= n ? r.round(n) + o : r.round(n, 2).toFixed(2) + o : 2 == u ? -100 >= n ? r.round(n) + o : r.round(n, 1).toFixed(1) + o : r.round(n) + o) : "0"
                    },
                    round: function (r, n) {
                        if (n || (n = 0), 0 >= n) return Math.round(r);
                        for (var u = 1, o = 0; n > o; o++) u *= 10;
                        return Math.round(r * u) / u
                    },
                    isS: function (r) {
                        return "string" == typeof r
                    }
                };
                return {
                    format: function (r) {
                        if ("number" != typeof r) return r + "";
                        for (var n = 0 > r ? "-" : "", u = Math.abs(r) + "", o = u.length, t = "", e = 0; o-- > 0;) e++, t = u.charAt(o) + t, e % 3 === 0 && 0 !== o && (e = 0, t = "," + t);
                        return n + t
                    },
                    money: function (r) {
                        var n = 0 | r,
                            r = r + "",
                            u = r.indexOf(".");
                        return this.format(n) + (-1 === u ? "" : r.substring(u))
                    },
                    shrink: function (n) {
                        return "number" == typeof n ? r.u(n) : n
                    },
                    fill: function (r) {
                        return (10 > r ? "0" : "") + r
                    }
                }
            });
        },
        "assets/js/biz/page/home/hero-rank": function () {
            define(function (require) {
                "use strict";
                var s = require("$"),
                    i = require("_"),
                    t = (require("log"), require("util/json")),
                    n = require("util/strings"),
                    a = require("util/numbers"),
                    e = s("#doc"),
                    r = e.find("section.main-home"),
                    c = '<li><a href="hero/${userId}.htm" class="clearfix"><div class="left img"><span class="iconfont text-s54">&#xe604;</span></div><div class="left detail"><div><span class="uname text-xm">${username}</span> <span class="win">胜率<em class="${win_css}">${winRate}%</em></span></div><p class="text-minor">交易${volume}手，胜<span>${profitVolume}手</span>，盈利<span class="${income_css}">${income}元</span></p></div><div class="iconfont arrow-right">&#xe60f;</div></a></li>';
                return {
                    init: function () {
                        this.initData(), this.updateRankList(), this.wait()
                    },
                    initData: function () {
                        var s = r.find("div.mod-tab-switcher");
                        this.source = t.parse(s.data("source"))
                    },
                    wait: function () {
                        var i = this,
                            t = r.find("div.mod-tab-switcher");
                        t.children("span").on("tap", function (t) {
                            t.preventDefault();
                            var n = s(this);
                            if (!n.hasClass("curr")) {
                                n.siblings(".curr").removeClass("curr"), n.addClass("curr");
                                var a = "收益英雄" === n.text();
                                i.updateRankList(a)
                            }
                        })
                    },
                    updateRankList: function (s) {
                        s = null == s ? !0 : s;
                        var t = "",
                            e = s ? this.source.incomeHero : this.source.winHero;
                        e.forEach(function (e) {
                            var r = i.extend({}, e);
                            s ? r.income_css = "text-stress" : r.win_css = "text-stress";
                            var o = (e.income + "").replace(/,/g, "");
                            r.income = a.shrink(o - 0), t += n.format(c, r)
                        });
                        var o = r.find("div.mod-tab-switcher").next();
                        o.empty().html(t)
                    }
                }
            });
        },
        "assets/js/util/cookie": function () {
            define(function (require) {
                "use strict";
                var t = require("_");
                return {
                    set: function (e, n, o) {
                        var r = "";
                        if (null != o) {
                            var i = new Date(t.now() + 24 * o * 3600 * 1e3);
                            r = i.toUTCString()
                        }
                        var c = [e + "=" + encodeURIComponent(n), "expires=" + r, "domain=.hrcf168.com", "path=/"];
                        return document.cookie = c.join("; "), this
                    },
                    get: function (e) {
                        var n = document.cookie.split("; "),
                            o = "";
                        return e += "=", t.each(n, function (n) {
                            return t.startsWith(n, e) ? (o = n.replace(e, ""), !1) : void 0
                        }), o
                    },
                    remove: function (t) {
                        return this.set(t, "", -1), this
                    },
                    setItem: function (key, value) {
                        if (window.localStorage) {
                            localStorage.setItem(key, value);
                        } else {
                            this.set(key, value, 3650);
                        }
                    },
                    getItem: function (key) {
                        return window.localStorage ? localStorage.getItem(key) : this.get(key);
                    },
                    removeItem: function (key) {
                        if (window.localStorage) {
                            localStorage.removeItem(key);
                        } else {
                            this.remove(key);
                        }
                    }
                }
            });
        },
        "assets/js/biz/page/home/index": function () {
            define(function (require) {
                "use strict";
                var t = require("$"),
                    i = (require("log"), require("util/timer"), require("util/cookie")),
                    n = t("#doc"),
                    o = n.find("section.main-home"),
                    a = "APP",
                    e = "1",
                    d = "0";
                return {
                    init: function () {
                        this.wait()
                    },
                    wait: function () {
                        var n = o.find("div.app-download");
                        n.on("tap", "a", function (o) {
                            o.preventDefault(), i.set(a, e), n.addClass("hide"), window.location.href = t(this).attr("href")
                        }), n.on("tap", "span.close", function (t) {
                            t.preventDefault(), t.stopPropagation(), i.set(a, d), n.addClass("hide")
                        })
                    }
                }
            });
        },
        "assets/js/ui/msgbox/1.0/main": function () {
            define(function (require) {
                "use strict";
                var i = require("$"),
                    n = require("util/timer"),
                    t = i("#doc"),
                    a = t.find("div.msgbox-info"),
                    d = t.find("div.msgbox-confirm"),
                    o = t.find("div.msgbox-toast"),
                    s = null,
                    e = null,
                    l = null,
                    v = null,
                    c = function () {
                        f(), r()
                    }, f = function () {
                        var n = t.find("div.float"),
                            s = n.children("div.content");
                        n.length || (t.append('<div class="float"><div class="content"></div></div>'), n = t.find("div.float"), s = n.children("div.content")), a.length || (a = i('<div class="overlay-top msgbox msgbox-info hide"><div class="content"><div class="main"></div><div class="action"><a href="javascript:void(0)" class="button ok">确定</a></div></div></div>').appendTo(s)), d.length || (d = i('<div class="overlay-top msgbox msgbox-confirm hide"><div class="content"><div class="main"></div><div class="action clearfix"><div class="left"><a href="javascript:void(0)" class="button button-lesser no">取消</a></div><div class="right"><a href="javascript:void(0)" class="button ok">确定</a></div></div></div></div>').appendTo(s)), o.length || (o = i('<div class="msgbox-toast hide"><div class="content"></div></div>').appendTo(s))
                    }, r = function () {
                        var n = function (n) {
                            n.preventDefault();
                            var t = i(this);
                            if (!t.hasClass("button-disabled")) {
                                if (-1 === t.attr("href").indexOf("javascript:void(0)")) return void (window.location.href = t.attr("href"));
                                g(), s && s.call(this)
                            }
                        }, t = function (n) {
                            n.preventDefault();
                            var t = i(this);
                            if (!i(this).hasClass("button-disabled")) {
                                if (-1 === t.attr("href").indexOf("javascript:void(0)")) return void (window.location.href = t.attr("href"));
                                g(), e && e.call(this)
                            }
                        };
                        a.find("div.action a.ok").on("tap", n), d.find("div.action a.ok").on("tap", n), d.find("div.action a.no").on("tap", t)
                    }, u = function (i) {
                        var n = a.find("div.action a.ok"),
                            t = "确定",
                            d = "javascript:void(0)";
                        i && i.ok && (t = i.ok.name || t, d = i.ok.url || d), n.text(t).attr("href", d)
                    }, h = function (i) {
                        var n = d.find("div.action a.ok"),
                            t = d.find("div.action a.no"),
                            a = "确定",
                            o = "javascript:void(0)",
                            s = "取消",
                            e = "javascript:void(0)";
                        i && i.ok && (a = i.ok.name || a, o = i.ok.url || o), i && i.no && (s = i.no.name || s, e = i.no.url || e), n.text(a).attr("href", o), t.text(s).attr("href", e)
                    }, m = function (i, n, t) {
                        s = n, e = null, i && (l = a.find("div.main").html(), a.find("div.main").html(i)), u(t), a.removeClass("hide")
                    }, b = function (i, n, t, a) {
                        s = n, e = t, i && (v = d.find("div.main").html(), d.find("div.main").html(i)), h(a), d.removeClass("hide")
                    }, p = 0,
                    x = function (i) {
                        i && (o.children("div.content").text(i), o.removeClass("hide"), n.clear(p), p = n.one(function () {
                            o.animate({
                                opacity: 0
                            }, 500, function () {
                                o.addClass("hide").css({
                                    opacity: 1
                                })
                            })
                        }, 2500).id)
                    }, g = function () {
                        a.addClass("hide"), d.addClass("hide"), o.addClass("hide"), l && a.find("div.main").html(l), v && d.find("div.main").html(v)
                    };
                return c(), {
                    alert: function (i, n, t) {
                        return "function" == typeof i && (t = n, n = i, i = null), m(i, n, t), this
                    },
                    confirm: function (i, n, t, a) {
                        return "function" == typeof i && (a = t, t = n, n = i, i = null), b(i, n, t, a), this
                    },
                    toast: function (i) {
                        x(i)
                    },
                    disable: function () {
                        return a.find("div.action > a.button").addClass("button-disabled"), d.find("div.action > a.button").addClass("button-disabled"), this
                    },
                    enable: function () {
                        return a.find("div.action > a.button").removeClass("button-disabled"), d.find("div.action > a.button").removeClass("button-disabled"), this
                    }
                }
            });
        },
        "assets/js/ui/loading/1.0/main": function () {
            define(function (require) {
                "use strict";
                var i = require("$"),
                    n = i("#doc"),
                    d = '<div class="loading hide"><div class="content"><img src="content/assets/imgs/loading/01.gif"/></div></div>',
                    s = 0,
                    e = null,
                    t = function () {
                        if (!e) {
                            var s = n.find("div.float");
                            s[0] || (s = i('<div class="float"><div class="content"></div></div>').appendTo(n)), e = i(d).appendTo(s.children("div.content"))
                        }
                    };
                return t(), {
                    show: function (i) {
                        return i === !0 ? s = -1 : s > -1 && s++, e.removeClass("hide"), this
                    },
                    hide: function (i) {
                        return i === !0 ? s = 0 : s > 0 && s--, 0 === s && e.addClass("hide"), this
                    }
                }
            });
        },
        "assets/js/biz/mod/ajax-result": function () {
            define(function (require) {
                "use strict";
                var r = require("log"),
                    o = require("ui/msgbox"),
                    t = require("ui/loading"),
                    n = function (r) {
                        return "function" == typeof r
                    }, e = function (r, t) {
                        var e = r.redirectUrl,
                        i = r.msg,
                        a = r.msgType,
                        c = r.button;
                        if (e && /^>/.test(e)) return void (window.location.href = e.substring(1));
                        if (e && /^\*/.test(e)) switch (e = e.replace("*", "")) {
                            case "refresh":
                                window.location.reload()
                        } else {
                            var f = function () {
                                e ? window.location.href = e : n(t) && t()
                            };
                            i ? c ? c.ok && c.no ? o.confirm(i, f, null, c) : o.alert(i, f, c) : e ? o.alert(i, f) : "toast" === a ? (o.toast(i), f()) : o.alert(i, f) : f()
                        }
                    };
                return {
                    done: function (r, o) {
                        e(r, o)
                    },
                    fail: function (o, n) {
                        r.error(n), t.hide(!0), e({
                            errorMsg: "抱歉，系统繁忙，请稍后再试"
                        })
                    }
                }
            });
        },
        "assets/js/lang/net": function () {
            define(function (require) {
                "use strict";
                var t = require("$"),
                    e = require("util/json"),
                    n = require("mod/ajax-result"),
                    r = function (e) {
                        this.jqXHR = t.ajax(e)
                    };
                return r.prototype = {
                    done: function (t) {
                        return this.jqXHR.done(t), this
                    },
                    fail: function (t) {
                        return this.jqXHR.fail(t), this
                    },
                    complete: function (t) {
                        return this.jqXHR.complete(t), this
                    },
                    always: function (t) {
                        return this.jqXHR.always(t), this
                    }
                }, {
                    post: function (t) {
                        return t.type = "POST", this.ajax(t)
                    },
                    get: function (t) {
                        return t.type = "GET", this.ajax(t)
                    },
                    jsonp: function (t) {
                        return t.type = "GET", t.dataType = "jsonp", this.ajax(t)
                    },
                    ajax: function (t) {
                        return t.type = t.type || "POST", t.cache = t.cache || !1, t.dataType = t.dataType || "json", t.success = t.success || n.done, t.error = t.error || n.fail, t.converters = {
                            "text json": function (t) {
                                return e.parse(t && t.replace(/[\n\r]/g, " "))
                            }
                        }, new r(t)
                    }
                }
            });
        },
        "assets/js/lang/data-store": function () {
            define(function (require) {
                "use strict";
                var t = require("$"),
                    n = require("_"),
                    e = require("util/json"),
                    i = t("#doc").data(),
                    c = t("#content").data(),
                    r = {}, u = /^\{.*\}$/m;
                return t.extend(r, i, c), n.each(r, function (t, i) {
                    n.isString(t) && u.test(t) && (r[i] = e.parse(t))
                }), {
                    get: function (t) {
                        return t && r[t] || r
                    },
                    set: function (t, n) {
                        r[t] = n
                    }
                }
            });
        },
        "assets/js/util/dates": function () {
            define(function () {
                "use strict";
                var e = function (e, r) {
                    return (!r && 10 > e ? "0" : "") + e
                };
                return {
                    format: function (r, a, t) {
                        a = a || "Y-M-D h:m:s";
                        for (var c = r.getTime ? r : new Date(r), s = a.length, g = a, n = 0; s > n; n++) switch (a.charAt(n)) {
                            case "Y":
                                g = g.replace(/Y/g, e(c.getFullYear(), t));
                                break;
                            case "y":
                                g = g.replace(/y/g, e(c.getFullYear(), t).substring(2));
                                break;
                            case "M":
                                g = g.replace(/M/g, e(c.getMonth() + 1, t));
                                break;
                            case "D":
                                g = g.replace(/D/g, e(c.getDate(), t));
                                break;
                            case "h":
                                g = g.replace(/h/g, e(c.getHours(), t));
                                break;
                            case "m":
                                g = g.replace(/m/g, e(c.getMinutes(), t));
                                break;
                            case "s":
                                g = g.replace(/s/g, e(c.getSeconds(), t))
                        }
                        return g
                    }
                }
            });
        },
        "assets/js/biz/page/home/kefu": function () {
            define(function (require) {
                "use strict";
                var t = require("$"),
                    e = require("_"),
                    n = (require("log"), require("net")),
                    i = require("dataStore"),
                    a = require("util/strings"),
                    s = require("util/dates"),
                    o = require("util/timer"),
                    r = require("mod/ajax-result"),
                    c = t("#doc"),
                    u = c.find("section.main-home-kefu"),
                    l = 50,
                    f = i.get("urlQuery"),
                    d = i.get("urlSend"),
                    m = '<div class="text-lesser time"><time>${title}</time></div>',
                    v = '<li class="clearfix ${fr}">${title}<div class="detail"><span class="img iconfont text-s30 ${color}">${img}</span><span class="icon-arrow-${dir}"></span><span class="icon-arrow-${dir}"></span><span>${content}</span><time class="text-lesser"></time></div></li>',
                    p = -1;
                return {
                    init: function () {
                        this.wait(), this.queryData();
                        var t = this;
                        o.ever(function () {
                            t.queryData()
                        }, 1e4)
                    },
                    wait: function () {
                        var e = this;
                        u.find("div.user-input .button").on("tap", function (i) {
                            i.preventDefault();
                            var a = t(this).prev(),
                                s = t.trim(a.val());
                            s && n.post({
                                url: d,
                                data: {
                                    content: s
                                },
                                success: function (t) {
                                    r.done(t, function () {
                                        t.success && (a.val("").blur(), e.queryData())
                                    })
                                }
                            })
                        })
                    },
                    queryData: function () {
                        var t = this;
                        n.get({
                            url: f,
                            data: {
                                size: l
                            },
                            success: function (e) {
                                r.done(e, function () {
                                    e.success && p !== e.data.length && (p = e.data.length || -1, t.processData(e.data))
                                })
                            }
                        })
                    },
                    processData: function (t) {
                        var n = "",
                            i = this.toGroup(t);
                        e.each(i, function (t, i) {
                            n += "<ul>", i = a.format(m, {
                                title: i
                            }), e.each(t, function (t, e) {
                                var s = t.status;
                                n += a.format(v, {
                                    title: 0 === e ? i : "",
                                    fr: 3 === s || 4 === s ? "" : "fr",
                                    dir: 3 === s || 4 === s ? "left" : "right",
                                    color: 3 === s || 4 === s ? "text-head" : "",
                                    img: 3 === s || 4 === s ? "&#xe61c;" : "&#xe604;",
                                    content: t.content
                                })
                            }), n += "</ul>"
                        }), u.find("div.content > ul").remove(), u.find("div.action").before(n), this.scrollToBottom()
                    },
                    toGroup: function (t) {
                        var e = {}, n = new Date,
                            i = s.format(n, "Y-M-D"),
                            a = "",
                            o = "",
                            r = "";
                        return t.forEach(function (t) {
                            var n = t.time.split(" "),
                                s = n[0],
                                c = n[1].substring(0, n[1].lastIndexOf(":")),
                                u = (s === i ? "" : s + " ") + c;
                            c = c.replace(":", "") - 0, a || (a = s, o = c, r = u);
                            var l = s === a && 3 >= c - o;
                            l ? n = e[r] || (e[r] = []) : (n = e[u] = [], r = u), a = s, o = c, n.push(t)
                        }), e
                    },
                    scrollToBottom: function () {
                        t(window).scrollTop(document.documentElement.scrollHeight + 100)
                    }
                }
            });
        },
        "assets/js/lang/cookie":function(){
             define(function (require) {
                "use strict";
                return  {
                     setCookie:function(name, value, days){
                        if(days){
                            var date = new Date();
                            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                            var expires = "; expires=" + date.toGMTString();
                        }else{
                            var expires = "";
                        }
                        document.cookie = name + "=" + encodeURIComponent(value) + expires + "; path=/";
                    },
                    getCookie:function(name){
                        var nameEQ = name + "=";
                        var ca = document.cookie.split(';');
                        for(var i = 0; i < ca.length; i++){
                            var c = ca[i];
                            while(c.charAt(0) == ' '){c = c.substring(1, c.length);}
                            if(c.indexOf(nameEQ) == 0){return decodeURIComponent(c.substring(nameEQ.length, c.length));}
                        }
                        return null;
                    },
                    deleteCookie:function(name){
                        this.setCookie(name, "", -1);
                    },
                    setItem:function(key,value){
                        if(window.localStorage){
                            localStorage.setItem(key,value);
                        }else{
                            this.setCookie(key,value,3650);
                        }
                    },
                    getItem:function(key){
                        return  window.localStorage?localStorage.getItem(key):this.getCookie(key);
                    },
                    removeItem:function(key){
                        if(window.localStorage){
                            localStorage.removeItem(key);
                        }else{
                            this.deleteCookie(key);
                        }
                    }
                }
            });
        }
    
    };
    seajs.on("request", function (data) {
        var uri = data.uri;
        uri = uri.replace(/\.js[?#].*/, "");
        uri = uri.replace(__baseDir, "");
        var fn = MERGE_MODS[uri];
        if (fn) {
            data.requested = true;
            fn();
            data.onRequest();
        }
    });
}());
