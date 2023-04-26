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
        "assets/js/lang/mod-loader": function () {
            define(function (require, n, i) {
                "use strict";
                var t = require("$"),
                c = require("_"),
                r = t("#doc"),
                f = function (n) {
                    return r.find(n).length
                },
                o = function (n) {
                    c.each(n,
                    function (n) {
                        c.isString(n) ? require.async(n,
                        function (n) {
                            n && n.init && n.init()
                        }) : n && n.init && n.init()
                    })
                };
                i.exports = function (n) {
                    c.isString(n) && (n = [n]),
                    c.isArray(n) ? o(n) : c.each(n,
                    function (n, i) {
                        f(i) && o(c.isArray(n) ? n : [n])
                    })
                }
            });
        },
        "assets/js/biz/page/user/done": function () {
            define(function (require) {
                "use strict";
                var e = require("modLoader");
                e({
                    "section.main-user-login": "page/user/login",
                    "section.main-user-register": "page/user/register",
                    "section.main-user-findback": "page/user/findback",
                    "section.user-reset-pwd": "page/user/resetpwd",
                    "section.user-reset-pay-pwd": "page/user/resetpaypwd"
                })
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
        "assets/js/lang/log": function () {
            define(function () {
                "use strict";
                var n = !!window.console,
                o = function () {
                    n && console.log.apply(console, arguments)
                };
                return o.warn = function () {
                    n && console.warn.apply(console, arguments)
                },
                o.error = function () {
                    n && console.error.apply(console, arguments)
                },
                o
            });
        },
        "assets/js/util/timer": function () {
            define(function () {
                "use strict";
                var n = 0,
                t = {},
                e = window.requestAnimationFrame || window.webkitRequestAnimationFrame ||
                function (n) {
                    window.setTimeout(n, 17)
                },
                i = function (n) {
                    return "number" == typeof n
                },
                u = function () {
                    var n = Object.keys(t);
                    if (n.length) {
                        var e = Date.now();
                        n.forEach(function (n) {
                            var i = t[n];
                            if (null != i && e - i.time >= i.wait) {
                                var u = i.times;
                                u > 0 && u--,
                                i.fn.call(i.context),
                                -1 === u || u > 0 ? (i.time = Date.now(), i.times = u) : (i = null, delete t[n])
                            }
                        })
                    }
                },
                r = function (n) {
                    t[n + ""] && delete t[n + ""]
                },
                o = function () {
                    u(),
                    e(o)
                };
                return o(),
                {
                    add: function (e, u, o, a) {
                        return 2 === arguments.length ? i(u) ? 100 > u && (a = u, u = 1e3) : (o = u, u = 1e3) : 3 === arguments.length && (i(o) ? (a = o, o = null) : i(u) || (a = o, o = u, u = 1e3)),
                        n++,
                        t[n + ""] = {
                            id: n,
                            fn: e,
                            wait: u || 1e3,
                            context: o,
                            times: null != a ? a : -1,
                            time: Date.now()
                        },
                        {
                            id: n,
                            clear: function () {
                                r(this.id)
                            }
                        }
                    },
                    one: function (n, t, e) {
                        return null == t || i(t) || (e = t, t = 1e3),
                        this.add(n, t, e, 1)
                    },
                    ever: function (n, t, e) {
                        return null == t || i(t) || (e = t, t = 1e3),
                        this.add(n, t, e, -1)
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
                    f(),
                    r()
                },
                f = function () {
                    var n = t.find("div.float"),
                    s = n.children("div.content");
                    n.length || (t.append('<div class="float"><div class="content"></div></div>'), n = t.find("div.float"), s = n.children("div.content")),
                    a.length || (a = i('<div class="overlay-top msgbox msgbox-info hide"><div class="content"><div class="main"></div><div class="action"><a href="javascript:void(0)" class="button ok">确定</a></div></div></div>').appendTo(s)),
                    d.length || (d = i('<div class="overlay-top msgbox msgbox-confirm hide"><div class="content"><div class="main"></div><div class="action clearfix"><div class="left"><a href="javascript:void(0)" class="button button-lesser no">取消</a></div><div class="right"><a href="javascript:void(0)" class="button ok">确定</a></div></div></div></div>').appendTo(s)),
                    o.length || (o = i('<div class="msgbox-toast hide"><div class="content"></div></div>').appendTo(s))
                },
                r = function () {
                    var n = function (n) {
                        n.preventDefault();
                        var t = i(this);
                        if (!t.hasClass("button-disabled")) {
                            if (-1 === t.attr("href").indexOf("javascript:void(0)")) return void (window.location.href = t.attr("href"));
                            g(),
                            s && s.call(this)
                        }
                    },
                    t = function (n) {
                        n.preventDefault();
                        var t = i(this);
                        if (!i(this).hasClass("button-disabled")) {
                            if (-1 === t.attr("href").indexOf("javascript:void(0)")) return void (window.location.href = t.attr("href"));
                            g(),
                            e && e.call(this)
                        }
                    };
                    a.find("div.action a.ok").on("tap", n),
                    d.find("div.action a.ok").on("tap", n),
                    d.find("div.action a.no").on("tap", t)
                },
                u = function (i) {
                    var n = a.find("div.action a.ok"),
                    t = "确定",
                    d = "javascript:void(0)";
                    i && i.ok && (t = i.ok.name || t, d = i.ok.url || d),
                    n.text(t).attr("href", d)
                },
                h = function (i) {
                    var n = d.find("div.action a.ok"),
                    t = d.find("div.action a.no"),
                    a = "确定",
                    o = "javascript:void(0)",
                    s = "取消",
                    e = "javascript:void(0)";
                    i && i.ok && (a = i.ok.name || a, o = i.ok.url || o),
                    i && i.no && (s = i.no.name || s, e = i.no.url || e),
                    n.text(a).attr("href", o),
                    t.text(s).attr("href", e)
                },
                m = function (i, n, t) {
                    s = n,
                    e = null,
                    i && (l = a.find("div.main").html(), a.find("div.main").html(i)),
                    u(t),
                    a.removeClass("hide")
                },
                b = function (i, n, t, a) {
                    s = n,
                    e = t,
                    i && (v = d.find("div.main").html(), d.find("div.main").html(i)),
                    h(a),
                    d.removeClass("hide")
                },
                p = 0,
                x = function (i) {
                    i && (o.children("div.content").text(i), o.removeClass("hide"), n.clear(p), p = n.one(function () {
                        o.animate({
                            opacity: 0
                        },
                        500,
                        function () {
                            o.addClass("hide").css({
                                opacity: 1
                            })
                        })
                    },
                    2500).id)
                },
                g = function () {
                    a.addClass("hide"),
                    d.addClass("hide"),
                    o.addClass("hide"),
                    l && a.find("div.main").html(l),
                    v && d.find("div.main").html(v)
                };
                return c(),
                {
                    alert: function (i, n, t) {
                        return "function" == typeof i && (t = n, n = i, i = null),
                        m(i, n, t),
                        this
                    },
                    confirm: function (i, n, t, a) {
                        return "function" == typeof i && (a = t, t = n, n = i, i = null),
                        b(i, n, t, a),
                        this
                    },
                    toast: function (i) {
                        x(i)
                    },
                    disable: function () {
                        return a.find("div.action > a.button").addClass("button-disabled"),
                        d.find("div.action > a.button").addClass("button-disabled"),
                        this
                    },
                    enable: function () {
                        return a.find("div.action > a.button").removeClass("button-disabled"),
                        d.find("div.action > a.button").removeClass("button-disabled"),
                        this
                    }
                }
            });
        },
        "assets/js/ui/loading/1.0/main": function () {
            define(function (require) {
                "use strict";
                var i = require("$"),
                n = i("#doc"),
                d = '<div class="loading hide"><div class="content"><img src="../content/assets/imgs/loading/01.gif"/></div></div>',
                s = 0,
                e = null,
                t = function () {
                    if (!e) {
                        var s = n.find("div.float");
                        s[0] || (s = i('<div class="float"><div class="content"></div></div>').appendTo(n)),
                        e = i(d).appendTo(s.children("div.content"))
                    }
                };
                return t(),
                {
                    show: function (i) {
                        return i === !0 ? s = -1 : s > -1 && s++,
                        e.removeClass("hide"),
                        this
                    },
                    hide: function (i) {
                        return i === !0 ? s = 0 : s > 0 && s--,
                        0 === s && e.addClass("hide"),
                        this
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
                w = require("assets/js/lang/cookie"),
                n = function (r) {
                    return "function" == typeof r
                },
                e = function (r, t) {
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
                    done: function (r, o,v) {
                        e(r, o,v)
                    },
                    fail: function (o, n) {
                        r.error(n),
                        t.hide(!0),
                        e({
                            errorMsg: "抱歉，系统繁忙，请稍后再试"
                        })
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
                        return this.jqXHR.done(t),
                        this
                    },
                    fail: function (t) {
                        return this.jqXHR.fail(t),
                        this
                    },
                    complete: function (t) {
                        return this.jqXHR.complete(t),
                        this
                    },
                    always: function (t) {
                        return this.jqXHR.always(t),
                        this
                    }
                },
                {
                    post: function (t) {
                        return t.type = "POST",
                        this.ajax(t)
                    },
                    get: function (t) {
                        return t.type = "GET",
                        this.ajax(t)
                    },
                    jsonp: function (t) {
                        return t.type = "GET",
                        t.dataType = "jsonp",
                        this.ajax(t)
                    },
                    ajax: function (t) {
                        return t.type = t.type || "POST",
                        t.cache = t.cache || !1,
                        t.dataType = t.dataType || "json",
                        t.success = t.success || n.done,
                        t.error = t.error || n.fail,
                        t.converters = {
                            "text json": function (t) {
                                return e.parse(t && t.replace(/[\n\r]/g, " "))
                            }
                        },
                        new r(t)
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
                r = {},
                u = /^\{.*\}$/m;
                return t.extend(r, i, c),
                n.each(r,
                function (t, i) {
                    n.isString(t) && u.test(t) && (r[i] = e.parse(t))
                }),
                {
                    get: function (t) {
                        return t && r[t] || r
                    },
                    set: function (t, n) {
                        r[t] = n
                    }
                }
            });
        },
        "assets/js/biz/mod/sms": function () {
            define(function (require) {
                "use strict";
                var e = require("net"),
                b = require("$"),
                n = require("dataStore"),
                i = (require("net"), require("dataStore"), require("ui/msgbox")),
                t = require("mod/ajax-result"),
                a = n.get("urlSendCode"),
                u = n.get("urlVerifyCode"),
                Vcode='',
                w = require("assets/js/lang/cookie");
                return {
                    
                    send: function (n, u, picVCode, o) {
                        var _this=this;
                        e.ajax({
                            url: a,
                            data: {
                                userPhone: u,
                                regImageCode: picVCode||''
                            },
                            success: function (e) {
                                if(e.code==601){
                                    b('body').off().on('click','.img-code-view',function(){
                                        $(this).attr('src','/user/user/getRegImage.do?userPhone='+u+"&_="+(new Date()).getTime());
                                    })
                                    b('body').on("keyup",'.img-code-input',
                                    function () {
                                        Vcode =$.trim($(this).val());
                                    });
                                    var l = '<div style="margin-bottom:0.06rem;">请输入验证码</div><div><img class="img-code-view" src="/user/user/getRegImage.do?userPhone='+u+'" style="width:0.8rem;vertical-align:middle;"><input type="text" class="input img-code-input" maxlength="4" style="width:0.8rem;text-align:center;border-radius:0;border:1px solid #ddd"></div>';
                                    i.confirm(l,
                                    function () {
                                        _this.send(n,u,Vcode,
                                        function () {
                                            var e= b("a.get-smscode");
                                            _this.countdown(e);
                                        })
                                    })
                                }else{
                                    t.done(e,
                                    function () {
                                        (e.code==200) && o && o()
                                    })
                                }
                               
                            }
                        })
                    },
                    verify: function (n, action, mobile) {
                        e.ajax({
                            url: u,
                            data: {
                                action: action,
                                code: n,
                                tele: mobile
                            },
                            success:function(e){
                                if(e.code==200){
                                    e.redirectUrl='../user/regnext.html';
                                    w.setCookie('vcode',n,1);
                                    w.setCookie('tele',mobile,1);
                                }
                                
                                t.done(e,
                                function () {
                                    (e.code==200) && o && o()
                                })
                            }
                        })
                    },
                     countdown: function (t) {
                        var i = 60,
                        d = t.addClass("disabled button-disabled").text();
                        e = !1;
                        var n = function () {
                            i > 0 ? (t.text(i + "秒后重发"), window.setTimeout(n, 1e3)) : (e = !0, t.text(d).removeClass("disabled button-disabled")),
                            i--
                        };
                        n()
                    }
                }
            });
        },

        "assets/js/biz/mod/smscode": function () {
            define(function (require) {
                "use strict";
                var t = require("$"),
                i = (require("net"), require("dataStore"), require("ui/msgbox")),
                d = require("mod/sms"),
                n = t("#doc"),
                a = n.find("section.main-smscode"),
                e = !0;
                return {
                    init: function () {
                        this.wait()
                    },
                    wait: function () {
                        var n = this,
                        s = a.find("a.get-smscode"),
                        o = a.find("div.action a.button"),
                        u = a.find("input.mobile"),
                        l = a.find("input.smscode");
                       // picVcodeInput = a.find("input.pic-vcode");
                        u.on("keyup",
                        function () {
                            var i = t.trim(this.value);
                            //var picVcode = t.trim(picVcodeInput.val());
                            e && /\d{11}/.test(i)  ? s.removeClass("disabled button-disabled") : s.addClass("disabled button-disabled")
                            n.isValid() ? o.removeClass("button-disabled") : o.addClass("button-disabled");
                        }),
                        /*l.on("keyup",
                        function () {
                            n.isValid() ? o.removeClass("button-disabled") : o.addClass("button-disabled");
                        }),*/
                        // picVcodeInput.on("keyup",
                        // function () {
                        //     var i = t.trim(u.val() || u.data("value"));
                        //     var picVcode = t.trim(picVcodeInput.val());
                        //     e && /\d{11}/.test(i) && picVcode.length === 4 ? s.removeClass("disabled button-disabled") : s.addClass("disabled button-disabled")
                        //     n.isValid() ? o.removeClass("button-disabled") : o.addClass("button-disabled");
                        // }),
                        s.on("tap",
                        function (a) {
                            a.preventDefault();
                            var e = t(this);
                            if (u.blur(), !e.hasClass("button-disabled")) {
                                var s = e.data("action"),
                                o = t.trim(u.val()),
                                v='';
                                //picVcode = t.trim(picVcodeInput.val());

                                if (o) {
                        
                                    var l = "<div>短信验证码将发送到</div><div>" + o + "</div>";
                                    i.confirm(l,
                                    function () {
                                        d.send(s, o,v,
                                        function () {
                                            n.countdown(e);

                                        })
                                    })
                                }
                            }
                        }),
                        a.find("div.agreement input").on("click",
                        function () {
                            (n.isChecked()&&(t('.mobile').val() != '')&&(t('.smscode').val() != '')&&(t('.password').val() != '')) ? o.removeClass("button-disabled") : o.addClass("button-disabled")
                        }),
                        o.on("tap",
                        function (i) {
                            i.preventDefault();
                            var n = t(this),
                            a = n.data("value");
                            var mobile = t.trim(u.val()),
                                action = t(s).data("action");
                            if (l.blur(), !n.hasClass("button-disabled") && 0 === a) {
                                var e = t.trim(l.val());
                                e && d.verify(e, action, mobile)
                            }
                        })
                    },
                    countdown: function (t) {
                        var i = 60,
                        d = t.addClass("disabled button-disabled").text();
                        e = !1;
                        var n = function () {
                            i > 0 ? (t.text(i + "秒后重发"), window.setTimeout(n, 1e3)) : (e = !0, t.text(d).removeClass("disabled button-disabled")),
                            i--
                        };
                        n()
                    },
                    isChecked:function(){
                        var o = a.find("div.agreement input"),
                        s = !0;
                        return o[0] && (s = o.prop("checked"));
                    },
                    isValid: function () {
                        var i = a.find("input.mobile"),
                        d = a.find("input.smscode"),
                        //picVcodeInput = a.find("input.pic-vcode"),
                        n = t.trim(i.data("value") || i.val()),
                        //picVcode = t.trim(picVcodeInput.val()),
                        e = t.trim(d.val()),
                        s = !0,
                        o = a.find("div.agreement input");
                        return o[0] && (s = o.prop("checked")),
                            n && /\d{11}/.test(n) && e && /\d{4}/.test(e) && s;
                    }
                }
            });
        },
        "assets/js/biz/page/user/resetpwd": function () {
            define(function (require) {
                "use strict";
                var n = require("$"),
                a = (require("log"), require("net")),
                t = require("dataStore"),
                i = require("ui/msgbox"),
                e = n("#doc"),
                o = require("ui/msgbox"),
                s = e.find("section.user-reset-pwd"),
                w = require("assets/js/lang/cookie"),
                v = require("page/user/md5"),
                r = t.get("urlSave");
                return {
                    init: function () {
                        this.wait()

                    },
                    wait: function () {
                        var n = this;
                        s.find("div.action a.button").on("tap",
                        function (t) {
                            var i = n.getParams();
                            n.isValid(i) && a.ajax({
                                url: r,
                                data: i,
                                success:function(e){
                                   if(e.code==200){
                                        o.alert(e.msg, function(){
                                            window.location.href="../user/login.html";
                                        });
                                   }else{
                                        o.alert(e.msg);
                                   }
                                }
                            })
                        })
                    },
                    getParams: function () {
                        return {
                            userPhone:w.getCookie('tele'),
                            userPass: v.hex(n.trim(s.find('input[name="newPass"]').val()))
                        }
                    },
                    isValid: function (n) {
                        return n.userPass ?  !0 : (i.alert("请输入新密码"), !1)
                    }
                }
            });
        },
        "assets/js/biz/page/user/resetpaypwd": function () {
            define(function (require) {
                "use strict";
                var n = require("$"),
                a = (require("log"), require("net")),
                t = require("dataStore"),
                i = require("ui/msgbox"),
                e = n("#doc"),
                s = e.find("section.user-reset-pay-pwd"),
                r = t.get("urlSave");
                return {
                    init: function () {
                        this.wait()

                    },
                    wait: function () {
                        var n = this;
                        s.find("div.action a.button").on("tap",
                        function (t) {
                            t.preventDefault();
                            var i = n.getParams();
                            n.isValid(i) && a.ajax({
                                url: r,
                                data: i
                            })
                        })
                    },
                    getParams: function () {
                        return {
                            idCard: n.trim(s.find('input[name="idCard"]').val()),
                            id: n.trim(s.find('input[name="id"]').val()),
                            newPass: n.trim(s.find('input[name="newPass"]').val()),
                            newPassCfm: n.trim(s.find('input[name="newPassCfm"]').val())
                        }
                    },
                    isValid: function (n) {
                        if (n.idCard.length == 0) {
                            i.alert("请输入身份证");
                            return false;
                        }
                        return n.newPass ? n.newPassCfm ? !0 : (i.alert("请确认新密码"), !1) : (i.alert("请输入新密码"), !1)
                    }
                }
            });
        },
        "assets/js/biz/page/user/findback": function () {
            define(function (require) {
                "use strict";
                require("mod/smscode").init();
                var t = require("$"),
                a = (require("log"), require("net")),
                i = require("dataStore"),
                n = require("ui/msgbox"),
                e = t("#doc"),
                s = e.find("section.main-user-findback"),
                r = i.get("urlAuth"),
                u = i.get("urlPass");
                return {
                    init: function () {
                        this.wait()
                    },
                    wait: function () {
                        var i = this;
                        s.find("div.action a.button").on("tap",
                        function (n) {
                            n.preventDefault();
                            var e = t(this),
                            s = e.data("value");
                            if (1 === s) {
                                var d = i.getAuthParams();
                                i.isValidAuth(d) && a.ajax({
                                    url: r,
                                    data: d
                                })
                            } else if (2 === s) {
                                var d = i.getPassParams();
                                i.isValidPass(d) && a.ajax({
                                    url: u,
                                    data: d
                                })
                            }
                        })
                    },
                    getAuthParams: function () {
                        return {
                            name: t.trim(s.find("input.name").val()),
                            identityNumber: t.trim(s.find("input.identityNumber").val())
                        }
                    },
                    isValidAuth: function (t) {
                        return t.name ? t.identityNumber ? !0 : (n.alert("请输入您之前登记的身份证号"), !1) : (n.alert("请输入您之前登记的真实姓名"), !1)
                    },
                    getPassParams: function () {
                        return {
                            newPass: t.trim(s.find("input.password").val()),
                            newPassCfm: t.trim(s.find("input.passwordCfm").val())
                        }
                    },
                    isValidPass: function (t) {
                        return t.newPass ? t.newPassCfm ? !0 : (n.alert("请再次确认新密码"), !1) : (n.alert("请输入新密码"), !1)
                    }
                }
            });
        },
         "assets/js/biz/page/user/md5": function () {
            define(function (require) {
                "use strict";
                var n = require("$");
                var rotateLeft = function(lValue, iShiftBits) {
                    return (lValue << iShiftBits) | (lValue >>> (32 - iShiftBits));
                }
                var addUnsigned = function(lX, lY) {
                    var lX4, lY4, lX8, lY8, lResult;
                    lX8 = (lX & 0x80000000);
                    lY8 = (lY & 0x80000000);
                    lX4 = (lX & 0x40000000);
                    lY4 = (lY & 0x40000000);
                    lResult = (lX & 0x3FFFFFFF) + (lY & 0x3FFFFFFF);
                    if (lX4 & lY4) return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
                    if (lX4 | lY4) {
                        if (lResult & 0x40000000) return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
                        else return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
                    } else {
                        return (lResult ^ lX8 ^ lY8);
                    }
                }
                var F = function(x, y, z) {
                    return (x & y) | ((~ x) & z);
                }
                var G = function(x, y, z) {
                    return (x & z) | (y & (~ z));
                }
                var H = function(x, y, z) {
                    return (x ^ y ^ z);
                }
                var I = function(x, y, z) {
                    return (y ^ (x | (~ z)));
                }
                var FF = function(a, b, c, d, x, s, ac) {
                    a = addUnsigned(a, addUnsigned(addUnsigned(F(b, c, d), x), ac));
                    return addUnsigned(rotateLeft(a, s), b);
                };
                var GG = function(a, b, c, d, x, s, ac) {
                    a = addUnsigned(a, addUnsigned(addUnsigned(G(b, c, d), x), ac));
                    return addUnsigned(rotateLeft(a, s), b);
                };
                var HH = function(a, b, c, d, x, s, ac) {
                    a = addUnsigned(a, addUnsigned(addUnsigned(H(b, c, d), x), ac));
                    return addUnsigned(rotateLeft(a, s), b);
                };
                var II = function(a, b, c, d, x, s, ac) {
                    a = addUnsigned(a, addUnsigned(addUnsigned(I(b, c, d), x), ac));
                    return addUnsigned(rotateLeft(a, s), b);
                };
                var convertToWordArray = function(string) {
                    var lWordCount;
                    var lMessageLength = string.length;
                    var lNumberOfWordsTempOne = lMessageLength + 8;
                    var lNumberOfWordsTempTwo = (lNumberOfWordsTempOne - (lNumberOfWordsTempOne % 64)) / 64;
                    var lNumberOfWords = (lNumberOfWordsTempTwo + 1) * 16;
                    var lWordArray = Array(lNumberOfWords - 1);
                    var lBytePosition = 0;
                    var lByteCount = 0;
                    while (lByteCount < lMessageLength) {
                        lWordCount = (lByteCount - (lByteCount % 4)) / 4;
                        lBytePosition = (lByteCount % 4) * 8;
                        lWordArray[lWordCount] = (lWordArray[lWordCount] | (string.charCodeAt(lByteCount) << lBytePosition));
                        lByteCount++;
                    }
                    lWordCount = (lByteCount - (lByteCount % 4)) / 4;
                    lBytePosition = (lByteCount % 4) * 8;
                    lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80 << lBytePosition);
                    lWordArray[lNumberOfWords - 2] = lMessageLength << 3;
                    lWordArray[lNumberOfWords - 1] = lMessageLength >>> 29;
                    return lWordArray;
                };
                var wordToHex = function(lValue) {
                    var WordToHexValue = "", WordToHexValueTemp = "", lByte, lCount;
                    for (lCount = 0; lCount <= 3; lCount++) {
                        lByte = (lValue >>> (lCount * 8)) & 255;
                        WordToHexValueTemp = "0" + lByte.toString(16);
                        WordToHexValue = WordToHexValue + WordToHexValueTemp.substr(WordToHexValueTemp.length - 2, 2);
                    }
                    return WordToHexValue;
                };
                var uTF8Encode = function(string) {
                    string = string.replace(/\x0d\x0a/g, "\x0a");
                    var output = "";
                    for (var n = 0; n < string.length; n++) {
                        var c = string.charCodeAt(n);
                        if (c < 128) {
                            output += String.fromCharCode(c);
                        } else if ((c > 127) && (c < 2048)) {
                            output += String.fromCharCode((c >> 6) | 192);
                            output += String.fromCharCode((c & 63) | 128);
                        } else {
                            output += String.fromCharCode((c >> 12) | 224);
                            output += String.fromCharCode(((c >> 6) & 63) | 128);
                            output += String.fromCharCode((c & 63) | 128);
                        }
                    }
                    return output;
                };
                return{
                    hex: function(string,reg) {
                        if(reg){
                            string = string+'luckin';
                        }
                        
                        var x = Array();
                        var k, AA, BB, CC, DD, a, b, c, d;
                        var S11=7, S12=12, S13=17, S14=22;
                        var S21=5, S22=9 , S23=14, S24=20;
                        var S31=4, S32=11, S33=16, S34=23;
                        var S41=6, S42=10, S43=15, S44=21;
                        string = uTF8Encode(string);
                        x = convertToWordArray(string);
                        a = 0x67452301; b = 0xEFCDAB89; c = 0x98BADCFE; d = 0x10325476;
                        for (k = 0; k < x.length; k += 16) {
                            AA = a; BB = b; CC = c; DD = d;
                            a = FF(a, b, c, d, x[k+0],  S11, 0xD76AA478);
                            d = FF(d, a, b, c, x[k+1],  S12, 0xE8C7B756);
                            c = FF(c, d, a, b, x[k+2],  S13, 0x242070DB);
                            b = FF(b, c, d, a, x[k+3],  S14, 0xC1BDCEEE);
                            a = FF(a, b, c, d, x[k+4],  S11, 0xF57C0FAF);
                            d = FF(d, a, b, c, x[k+5],  S12, 0x4787C62A);
                            c = FF(c, d, a, b, x[k+6],  S13, 0xA8304613);
                            b = FF(b, c, d, a, x[k+7],  S14, 0xFD469501);
                            a = FF(a, b, c, d, x[k+8],  S11, 0x698098D8);
                            d = FF(d, a, b, c, x[k+9],  S12, 0x8B44F7AF);
                            c = FF(c, d, a, b, x[k+10], S13, 0xFFFF5BB1);
                            b = FF(b, c, d, a, x[k+11], S14, 0x895CD7BE);
                            a = FF(a, b, c, d, x[k+12], S11, 0x6B901122);
                            d = FF(d, a, b, c, x[k+13], S12, 0xFD987193);
                            c = FF(c, d, a, b, x[k+14], S13, 0xA679438E);
                            b = FF(b, c, d, a, x[k+15], S14, 0x49B40821);
                            a = GG(a, b, c, d, x[k+1],  S21, 0xF61E2562);
                            d = GG(d, a, b, c, x[k+6],  S22, 0xC040B340);
                            c = GG(c, d, a, b, x[k+11], S23, 0x265E5A51);
                            b = GG(b, c, d, a, x[k+0],  S24, 0xE9B6C7AA);
                            a = GG(a, b, c, d, x[k+5],  S21, 0xD62F105D);
                            d = GG(d, a, b, c, x[k+10], S22, 0x2441453);
                            c = GG(c, d, a, b, x[k+15], S23, 0xD8A1E681);
                            b = GG(b, c, d, a, x[k+4],  S24, 0xE7D3FBC8);
                            a = GG(a, b, c, d, x[k+9],  S21, 0x21E1CDE6);
                            d = GG(d, a, b, c, x[k+14], S22, 0xC33707D6);
                            c = GG(c, d, a, b, x[k+3],  S23, 0xF4D50D87);
                            b = GG(b, c, d, a, x[k+8],  S24, 0x455A14ED);
                            a = GG(a, b, c, d, x[k+13], S21, 0xA9E3E905);
                            d = GG(d, a, b, c, x[k+2],  S22, 0xFCEFA3F8);
                            c = GG(c, d, a, b, x[k+7],  S23, 0x676F02D9);
                            b = GG(b, c, d, a, x[k+12], S24, 0x8D2A4C8A);
                            a = HH(a, b, c, d, x[k+5],  S31, 0xFFFA3942);
                            d = HH(d, a, b, c, x[k+8],  S32, 0x8771F681);
                            c = HH(c, d, a, b, x[k+11], S33, 0x6D9D6122);
                            b = HH(b, c, d, a, x[k+14], S34, 0xFDE5380C);
                            a = HH(a, b, c, d, x[k+1],  S31, 0xA4BEEA44);
                            d = HH(d, a, b, c, x[k+4],  S32, 0x4BDECFA9);
                            c = HH(c, d, a, b, x[k+7],  S33, 0xF6BB4B60);
                            b = HH(b, c, d, a, x[k+10], S34, 0xBEBFBC70);
                            a = HH(a, b, c, d, x[k+13], S31, 0x289B7EC6);
                            d = HH(d, a, b, c, x[k+0],  S32, 0xEAA127FA);
                            c = HH(c, d, a, b, x[k+3],  S33, 0xD4EF3085);
                            b = HH(b, c, d, a, x[k+6],  S34, 0x4881D05);
                            a = HH(a, b, c, d, x[k+9],  S31, 0xD9D4D039);
                            d = HH(d, a, b, c, x[k+12], S32, 0xE6DB99E5);
                            c = HH(c, d, a, b, x[k+15], S33, 0x1FA27CF8);
                            b = HH(b, c, d, a, x[k+2],  S34, 0xC4AC5665);
                            a = II(a, b, c, d, x[k+0],  S41, 0xF4292244);
                            d = II(d, a, b, c, x[k+7],  S42, 0x432AFF97);
                            c = II(c, d, a, b, x[k+14], S43, 0xAB9423A7);
                            b = II(b, c, d, a, x[k+5],  S44, 0xFC93A039);
                            a = II(a, b, c, d, x[k+12], S41, 0x655B59C3);
                            d = II(d, a, b, c, x[k+3],  S42, 0x8F0CCC92);
                            c = II(c, d, a, b, x[k+10], S43, 0xFFEFF47D);
                            b = II(b, c, d, a, x[k+1],  S44, 0x85845DD1);
                            a = II(a, b, c, d, x[k+8],  S41, 0x6FA87E4F);
                            d = II(d, a, b, c, x[k+15], S42, 0xFE2CE6E0);
                            c = II(c, d, a, b, x[k+6],  S43, 0xA3014314);
                            b = II(b, c, d, a, x[k+13], S44, 0x4E0811A1);
                            a = II(a, b, c, d, x[k+4],  S41, 0xF7537E82);
                            d = II(d, a, b, c, x[k+11], S42, 0xBD3AF235);
                            c = II(c, d, a, b, x[k+2],  S43, 0x2AD7D2BB);
                            b = II(b, c, d, a, x[k+9],  S44, 0xEB86D391);
                            a = addUnsigned(a, AA);
                            b = addUnsigned(b, BB);
                            c = addUnsigned(c, CC);
                            d = addUnsigned(d, DD);
                        }
                        var tempValue = wordToHex(a) + wordToHex(b) + wordToHex(c) + wordToHex(d);
                        return tempValue.toLowerCase();
                    }
                }
            });
        },
        "assets/js/biz/page/user/login": function () {
            define(function (require) {
                "use strict";
                var i = require("$"),
                t = require("net"),
                n = require("dataStore"),
                a = require("ui/msgbox"),
                e = n.get("urlLogin"),
                o = i("#doc"),
                f = require("assets/js/lang/cookie"),
                v = require("page/user/md5"),
                s = o.find("section.main-user-login");
                return {
                    init: function () {
                        try {
                            localStorage.setItem('isSupport', true);
                        } catch (e) { 
                            a.alert("您处于无痕浏览模式，无法为您保存登陆状态"); 
                        }
                        this.wait()
                    },
                    wait: function () {
                        var n = this;
                        s.find("a.do-login").on("tap",
                        function (k) {
                            k.preventDefault();
                            var o = i(this);
                            if (!o.hasClass("button-disabled")) {
                                var d = i.trim(s.find('input[name="mobile"]').val()),
                                r = i.trim(s.find('input[name="password"]').val());
                                n.isValid(d, r) && (o.addClass("button-disabled"), t.ajax({
                                    url: e,
                                    data: {
                                        userPhone: d,
                                        userPass: v.hex(r),
                                    },
                                    success:function(res){
                                        if(res.code==200){
                                           
                                            var str = window.location.search;
                                            var re = /\=/;
                                            var num = str.search(re)+1;
                                            var str2 = str.substring(num);
                                            window.location.href="http://"+window.location.host+str2;
											
                                        }else{
                                            a.alert(res.msg);
                                        }
                                        o.removeClass("button-disabled");
                                    }
                                }))
                            }
                        })
                    },
                    isValid: function (i, t) {
                        return i ? t ? !0 : (a.alert("请输入登录密码"), !1) : (a.alert("请输入手机号"), !1)
                    }
                }
            });
        },

        "assets/js/biz/page/user/register": function () {
            define(function (require) {
                "use strict";
                require("mod/smscode").init();
                var t = require("$"),
                a = require("net"),
                i = require("dataStore"),
                n = require("ui/msgbox"),
                s = (require("mod/sms"), t("#doc")),
                e = s.find("section.main-user-register"),
                f = require("assets/js/lang/cookie"),
                v = require("page/user/md5"),
                r = i.get("urlRegister");
				
				
				
                return {
                    init: function () {
                        this.wait()
                    },
                    wait: function () {
                        var i = this;
                        e.find("div.action a.button").on("tap",
                        function (k) {
                            k.preventDefault();
                            var s = t(this);
                            if (!s.hasClass("button-disabled") && 1 === s.data("value")) {
                                var e = i.getParams();
                                i.isValid(e) && (s.addClass("button-disabled"), a.ajax({
                                    url: r,
                                    data: e,
                                    success:function(res){

                                        if(res.code==200){
                                            
                                            var str = window.location.search;
                                            var re = /\=/;
                                            var num = str.search(re);
                                            if(num > 0){
                                                var str2 = str.substring(num+1);
                                                window.location.href="http://"+window.location.host+str2+"?callback=success";
                                            }
                                            else{
                                                //.location.href='/mine.html';
                                                window.location.href='../user/success.html';
                                            }
                                        }else{
                                            n.alert(res.msg);
                                        }
                                         s.removeClass("button-disabled")
                                    }
                                    
                                }))
                            }
                        })
                        t('#mima').on('keyup',function(){
                            if((t('.mobile').val() != '') && (t('.smscode').val() != '') && (t('#mima').val().length >= 6)){
                                t('#a1').attr('class','button button-stress')
                            }
                            else{
                                t('#a1').attr('class','button button-stress  button-disabled');
                            }
                        });
                        
                        t('#yanZ').on('keyup',function(){
                            if((t('.mobile').val() != '') && (t('#mima').val() != '')&& (t('#yanZ').val().length >= 4)){
                                t('#a1').attr('class','button button-stress')
                            }
                            else{
                                t('#a1').attr('class','button button-stress  button-disabled');
                            }
                        });
                    },
                    isValid: function (t) {
                        return  t.userPass ? !0 : (n.alert("请输入登录密码"), !1) 
                    },
                    getQueryParams:function(t){
                        var reg = new RegExp("(^|&)" + t + "=([^&]*)(&|$)", "i");
                        var r = window.location.search.substr(1).match(reg);
                        if (r != null) return unescape(r[2]); return null;
                    },
                   
                    getParams: function () {
						 var w = require("assets/js/lang/cookie"),
                             a = t('.smscode').val(),
                             b = t('.mobile').val(),
                             c;
						 var tuig = t('#tuig').val();
						 var tuig1 = tuig.toLowerCase();
                        if(localStorage.getItem("promoteCode")){
                             c = localStorage.getItem("promoteCode");
                        }else {
                            c = w.getCookie("promoteCode")
                        }

                        return {
                            userPass: v.hex(t.trim(e.find("input.password").val())),
                            regCode:a,
                            userPhone:b,
                            promoterCode : tuig1 ? tuig1 : c
                        }
                    }
                }
            });
        }
    };
    seajs.on("request",
    function (data) {
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