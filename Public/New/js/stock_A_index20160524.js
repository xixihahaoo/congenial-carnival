function rdt(){
        var str=Math.random() + new Date().getTime()+'';
        str = str.replace('.', '');
        return str;
};
(function($){
widets = {
    popup: {
        show: function (t, c, callback) {
            $('.level2_popup').empty().remove();
            $('.level2_popup_mask').empty().remove();
            var config = fn.extend({
                width: 600,
                height: 400,
                position: 'center',
                mask: 1
            }, c);
            var newPopup = $('<div class="level2_popup"></div>').css({
                'width': config.width,
                'height': config.height,
                'margin-left': -config.width / 2,
                'margin-top': -config.height / 2
            }).appendTo($('body'));
            if (config.mask) {
                var newPopupMask = $('<div class="level2_popup_mask"></div>').css({
                    'height': $('body').height()
                }).appendTo($('body'));
            }
            var popContent = $('<div class="popContent"></div>').css('height', config.height).appendTo(newPopup),
                popTitle = $('<div class="popTitle"><h3>' + t + '</h3></div>').appendTo(popContent),
                popClose = $('<div class="popClose" title="\u5173\u95ed"></div>').appendTo(popContent),
                popInner = $('<div class="popInner"></div>').appendTo(popContent);
            popClose.on('click', function () {
                widets.popup.close();
            });

            callback && callback.call({dom: popInner, '$': $});
        },
        close: function () {
            $('.level2_popup').empty().remove();
            $('.level2_popup_mask').empty().remove();
        }
    },
    fullscreen: {
        show: function (id, chart, onClose) {
            $('.level2_popup').empty().remove();
            $('.level2_popup_mask').empty().remove();
            var width = $(window).width() - 12,
                height = $(window).height() - 12;
            var newPopup = $('<div class="level2_popup level2_popup_fullscreen"></div>').css({
                'width': width,
                'height': height
            }).appendTo($('body'));
            var popContent = $('<div class="popContent"></div>').css('height', height).appendTo(newPopup),
                        popTitle = $('<div class="popTitle"><h3>' + t + '</h3></div>').appendTo(popContent),
                popClose = $('<div class="popClose" title="\u5173\u95ed"></div>').appendTo(popContent),
                popInner = $('<div class="popInner"></div>').css('height', height).appendTo(popContent);
            chart.show(popInner[0]);
            popClose.on('click', function () {
                onClose && onClose();
                widets.popup.close();
                chart.show($('#' + id)[0]);
            });
        },
        close: function () {
            $('.level2_popup').empty().remove();
            $('.level2_popup_mask').empty().remove();
        }
    },
    alert: function (content, link, time) {
        var url = link || '';
        var t = time || 2;
        $('.level2_alert')?function(){$('.level2_alert').empty().remove()}():false;
        $('.level2_alert_mask')?function(){$('.level2_alert_mask').empty().remove()}():false;
        var wh = Math.max($('body').height(), $(window).height());
        var newAlert = $('<div class="level2_alert"></div>'),
            newAlertMask = $('<div class="level2_alert_mask"></div>').css('height', wh).appendTo($('body'));
        $('<div class="alertContent">' + content + '</div>').appendTo(newAlert);
        newAlert.appendTo($('body')).fadeIn().delay(t * 1000).fadeOut(200, function () {
            $('.level2_alert').remove();
            $('.level2_alert_mask').remove();
            if (url) location.href = url;
        });
    }
};
})(jQuery);
/*\u8ba9ie6\u7f13\u5b58\u80cc\u666f\u56fe*/
if(/ie 6/i.test(navigator.userAgent))
{
	document.execCommand("BackgroundImageCache",false,true);
}
var Conn = {};
!function ($)
{
	var UPCOLOR = 'up',
        DOWNCOLOR = 'down',
        FLATCOLOR = 'flat';
	window.UPCOLOR = UPCOLOR;
	window.DOWNCOLOR = DOWNCOLOR;
	window.FLATCOLOR = FLATCOLOR;
	var hqURL = 'http://hq.sinajs.cn/rn=$rn&list=';
	var hqURL_txt = hqURL.replace('$rn','$rn&format=text');
	var pageURL = 'http://finance.sina.com.cn/realstock/company/$symbol/nc.shtml';

	var h5Test=document.createElement('canvas');
	var h5Status = 0;
	var flStatus = 0;

	//\u5224\u65ad\u652f\u6301FL\u3001H5
	if((h5Test.getContext && h5Test.getContext('2d'))){
		h5Status=1;
	}else{
		h5Status=0;
	}
	var fpVer=swfobject.getFlashPlayerVersion();
	flStatus=fpVer['major']>0 ? 1 : 0;

	clock.init();
	$(function ()
	{
		//clock.init([{ elID: 'time',area: 'CN',template: 'H:M:S'}]);
		holdStatus.init();
		//breakingNewsCtrl.init();
		cjywCtrl.init();
		stockChangePRanking.init();
		plateRanking.init();
		plateFlow.init();
		stockTip.init();
		new Survey('20205');
		new GlobalHQ('globalHQ',
        [
            ['.dji','\u9053\u743c\u65af','us','gup','http://biz.finance.sina.com.cn/suggest/lookup_n.php?q=.dji&country=usstock'],
            ['.ixic','\u7eb3\u65af\u8fbe\u514b','us','gup','http://biz.finance.sina.com.cn/suggest/lookup_n.php?q=ixic&country=usstock'],
            ['.inx','\u6807\u666e500','us','gup','http://biz.finance.sina.com.cn/suggest/lookup_n.php?q=inx&country=usstock'],
            ['SX5E','\u65af\u6258\u514b50','b','gup',''],
            ['UKX','\u82f1\u91d1\u878d\u65f6\u62a5\u6307\u6570','b','gup',''],
            ['NKY','\u65e5\u7ecf\u6307\u6570','b','gup',''],
            ['HSI','\u6052\u751f\u6307\u6570','hk','gup','http://biz.finance.sina.com.cn/suggest/lookup_n.php?country=hk&q=hsi']
        ]);
		new GlobalHQ('globalHf',
        [
            ['CL','NYMEX\u539f\u6cb9','hf','gup','http://finance.sina.com.cn/money/future/CL/quote.shtml'],
            ['GC','COMEX\u9ec4\u91d1','hf','gup','http://finance.sina.com.cn/money/future/quote_hf.html?GC'],
            ['SI','COMEX\u767d\u94f6','hf','gup','http://finance.sina.com.cn/money/future/quote_hf.html?SI'],
            ['CAD','LME\u94dc','hf','gup','http://finance.sina.com.cn/money/future/quote_hf.html?CAD'],
            ['S','CBOT\u9ec4\u8c46','hf','gup','http://finance.sina.com.cn/money/future/quote_hf.html?S']
        ]);
		var _IF = hq_str_CFF_LIST.split(',')[0];
		new GlobalHQ('chinaHF',
        [
            [_IF,'\u671f\u6307' + _IF,'IF','rup','http://finance.sina.com.cn/money/cffex/quotes/' + _IF + '/nc.shtml'],
            ['CU0','\u6caa\u94dc','qh','rup','http://finance.sina.com.cn/money/future/quote.html?CU0'],
            ['SR0','\u767d\u7cd6','qh','rup','http://finance.sina.com.cn/money/future/quote.html?SR0'],
            ['RB0','\u87ba\u7eb9\u94a2','qh','rup','http://finance.sina.com.cn/money/future/quote.html?RB0']
        ]);
		new GlobalHQ('globalForex',
        [
            ['DINIW','\u7f8e\u5143\u6307\u6570','forex','gup','http://finance.sina.com.cn/money/forex/hq/DINIW.shtml'],
            ['USDCNY','\u7f8e\u5143\u4eba\u6c11\u5e01','forex','gup','http://finance.sina.com.cn/money/forex/hq/USDCNY.shtml'],
            ['USDHKD','\u7f8e\u5143\u6e2f\u5143','forex','gup','http://finance.sina.com.cn/money/forex/hq/USDHKD.shtml'],
            ['EURUSD','\u6b27\u5143\u7f8e\u5143','forex','gup','http://finance.sina.com.cn/money/forex/hq/EURUSD.shtml'],
            ['GBPUSD','\u82f1\u9551\u7f8e\u5143','forex','gup','http://finance.sina.com.cn/money/forex/hq/GBPUSD.shtml'],
            ['USDJPY','\u7f8e\u5143\u65e5\u5143','forex','gup','http://finance.sina.com.cn/money/forex/hq/USDJPY.shtml']
        ],
        {
        	now: { key: 'now',digit: 4 },
        	change: { key: 'change',digit: 4,cfg: 4 },
        	changeP: { key: 'changeP',digit: 4,cfg: 4,p: '$1%' }
        });

		var _globalSuggest = new SuggestServer();
		_globalSuggest.bind(
        {
        	"input": "hq_summary_suggest",
        	"default": "\u62fc\u97f3/\u4ee3\u7801/\u540d\u79f0",
        	"type": "stock",
        	"link": "http://biz.finance.sina.com.cn/suggest/lookup_n.php?country=@type@&q=@code@",
        	"callback": null
        });
		$('#globalSearch').change(function ()
		{
			_globalSuggest.changeType(this.value);
		});
		new VSelect('globalSearch');

		aSummary.init();

		initWeiboJS();
		stockAsk.init();
	});

	/*\u4e3b\u884c\u60c5*/
	var hq = window.hq = new function ()
	{
		var _drawer;
		var _cookieCfg = {
                    path: '/',
                    domain: 'finance.sina.com.cn',
                    expires: '7'
                };
        var _cookieKey = 'FINA_V5_HQ';
		this.webSocketInterval = 3;
        this.webSocketObj = null ;
		this.init = function ()
		{
			var that = this;
			var _f_cfg_now = { key: 'now',digit: 2 };
			var _f_cfg_open = { key: 'open',digit: 2 };
			var _f_cfg_preClose = { key: 'preClose',digit: 2 };
			var _f_cfg_high = { key: 'high',digit: 2 };
			var _f_cfg_low = { key: 'low',digit: 2 };
			var _f_cfg_volume = { key: 'volume',digit: 0,'\u4e07/\u4ebf': true,shift: -2,p: '$1\u624b' };
			var _f_cfg_amount = { key: 'amount',digit: 0,'\u4e07/\u4ebf': true,p: '$1\u5143' };
			_drawer = new DataDrawer('hq',{ now: _f_cfg_now,open: _f_cfg_open,preClose: _f_cfg_preClose,high: _f_cfg_high,low: _f_cfg_low,volume: _f_cfg_volume,amount: _f_cfg_amount });
			/*
			if(window['hq_str_' + papercode])
			{
				_gotData(true);
			}
			*/
			if (this.webSocketObj) {
                this.webSocketObj.close();
                this.webSocketObj = null
            }
           	_getData.call(this);
           	loadScript(hqURL.replace('$rn', random()) + papercode, function(){_gotData();}, true);
            Cookie.set(_cookieKey,0, _cookieCfg);
			/*\u4e3b\u884c\u60c5\u62a5\u4ef7\u4e0d\u505a\u9650\u5236\uff0c\u4e00\u76f4\u5237*/
			/*\u7531h\u524d\u7aef\u5b9a\u65f6\u5668\u5237\u65b0\u8f6c\u4e3awebstock\u540e\u7aef\u63a8\u9001\u5f62\u5f0f\uff0c\u4fee\u6539\u65b9\u5f0f\u5982\u4e0b*/
			//setInterval(_getData,5 * 1000);
			//hqFlash.init();
			//webstock\u5bf9\u5e94\u5230--_getData\u5f62\u5f0f
			if(location.search.indexOf('showimg') > -1){
				$('#flashOK').hide();
				hqImg.init();
			}else if(location.search.indexOf('showh5')>-1){
				$('#flashOK').hide();
				if(h5Status==1){
					initH5.init();
					$('#h5Container').show();
				}else{
					hqImg.init();
				}
			}else{
				 if(h5Status ==1)
                {
                	$('#flashOK').hide();
                    initH5.init();
                    $('#h5Container').show();
                }
                else
                {
                    $('#h5Container').hide();
                    if(flStatus ==1)
                    {
                        $('#flashOK').show();
                        hqFlash.init();
                    }
                    else
                    {
                         $('#flashOK').hide();
                          hqImg.init();
                    }
                }
			}
		};
		function _appendScript(src)
		{
			var o = document.createElement('script');
			o.src = src;
			document.getElementsByTagName('head')[0].appendChild(o);
		};
		function _waitfor(exp, cb, time)
		{
			var e, r;
			if (!time)
			{
				time = 100;
			}
			try
			{
				r = eval(exp);
			}
			catch(e)
			{
			}
			if (r)
			{
				return cb();
			}
			//var _t = this;
			setTimeout(function()
			{
				return _waitfor(exp, cb, time);
			}, time * 1.2);
		};
		function _getData()
		{
			//loadScript(hqURL.replace('$rn',random()) + papercode,_gotData,true);
			//\u5224\u65adcookie \u6025\u901f\u7248||\u6162\u901f\u7248
			  if(1||Cookie.get('FINA_V5_HQ')*1)//\u5f00\u542fPUSH
            {
				var self = this;
				if (!window.IO || !window.IO.WebPush4)
				{
					_appendScript('http://woocall.sina.com.cn/lib/IO.WebPush4.js');
					var request_hqstr = hqURL.replace('$rn',random()).replace('http:\/\/','') + papercode;
					//console.log(request_hqstr);
					_waitfor('IO.WebPush4',function(){

							self.webSocketObj = new IO.WebPush4('hq.sinajs.cn',papercode,function(m) {
							_gotData.call(self,m);
							/*var jsontxt = m['dm_'+papercode]?(function(){return m['dm_'+papercode];})():'';
							console.log(jsontxt);
							jsontxt = $.parseJSON($.trim(jsontxt));
							stock_brg&&stock_brg.DMgotdata(jsontxt["content"]);*/
						},{
			                interval: self.webSocketInterval
			                //format:'json'
			        	});

			        },30);
				}
				else
				{
					self.webSocketObj = new IO.WebPush4('hq.sinajs.cn',[papercode,'dm_'+papercode],function(m) {
							_gotData.call(self,m);
						},{
			                interval: self.webSocketInterval
			        });
				}
			}
			else
			{
				loadScript(hqURL.replace('$rn',random()) + papercode,_gotData,true);
				setInterval(function(){
					loadScript(hqURL.replace('$rn',random()) + papercode,_gotData,true);
				},3000);
			}
		}
		function _gotData(m)
		{
			//cookie  window['hq_str_'+papercode]
			var hqstr = m?m[papercode]:window['hq_str_'+papercode]?window['hq_str_'+papercode]:'';
			if(!hqstr) return;
			var _data =  hqParser.a(hqstr,papercode);//\u683c\u5f0f\u5316\u884c\u60c5\u4e32
			_data.open_color = _data.open - _data.preClose;
			_data.high_color = _data.high - _data.preClose;
			_data.low_color = _data.low - _data.preClose;
			document.title = stockname + ' ' + _data.now.toFixed(2) + '(' + _data.changeP.toFixed(2) + '%)_\u80a1\u7968\u884c\u60c5_\u65b0\u6d6a\u8d22\u7ecf_\u65b0\u6d6a\u7f51';
			_drawer.draw(_data);
		}
	} ();
	/*\u56fe\u7247\u7248\u884c\u60c5*/
	var hqImg = new function ()
	{
		var _showingIndex = 0;
		this.init = function ()
		{
			$('#picContainer').show();
			new TabCont('picContainer','click',_show).show(0);
			setInterval(_show,30 * 1000);

			function _changeURL(img)
			{
				img.attr('url',img.attr('url').replace(/newchart\/.*?\/n/,'newchart/' + this.value + '/n'));
				_show();
			}
			$('#selectImgK').change(_changeURL.bindArg($('#imgK')));
			new VSelect('selectImgK');
			$('#selectImgFqK').change(_changeURL.bindArg($('#imgFqK')));
			new VSelect('selectImgFqK');
			$('#selectImgJS').change(_changeURL.bindArg($('#imgJS')));
			new VSelect('selectImgJS');
			attention.init('img');
		};
		function _show(argIndex)
		{
			if(typeof argIndex == 'number')
			{
				_showingIndex = argIndex;
			}
			var _cont = $('#picContainer .cont').eq(_showingIndex);
			var _img = _cont.find('img');
			_img.attr('src',_img.attr('url').replace('$symbol',papercode) + '?' + random());

		}
	} ();
	/*\u884c\u60c5flash*/
	var hqFlash = new function ()
	{
		var _flashOK = false;
		/*flash\u51c6\u5907\u597d\u540e\u4e3b\u52a8\u8c03\u7528*/
		Conn.flashOK = function ()
		{
			_flashOK = true;
			compare.init('flash');
		};
		/*\u63a7\u5236flash\u5237\u65b0\u3002\u76ee\u524d\u4e3a\u81ea\u5237\u65b0\uff0c\u4e0d\u9700\u8981\u4f7f\u7528*/
		function _refresh()
		{
			if(_flashOK)
			{
				swfobject.getObjectById("hqFlash").updateData();
			}
		}
		this.refresh = _refresh;
		this.init = function ()
		{
			if(location.search.indexOf('testimg') > -1 || /\((iPhone|iPad|iPod)/i.test(navigator.userAgent))
			{
				$('#flashOK').hide();
				if(h5Status==1){
					$('#h5Container').show();
					initH5.init();
				}else{
					hqImg.init();
				}

				return;
			}
			$('#flashOK').show();
			var parObj = { allowFullScreen: "true",allowScriptAccess: 'always',wmode: 'transparent' };
			var attObj = {};
			var flashvarsObj = {
				symbol: papercode,
				code: 'iddg64geja6fea4eafh9jbj7c5j4ie5d',
				s: '3'
			};
			var _search = {};
			location.search.replace(/view=([^&]+)/,function ($1,$2)
			{
				flashvarsObj.view = $2;
			});
			//            _search.symbol = papercode;
			/*\u9068\u6e38\u4f1a\u6709flash\u4e0d\u8fd0\u884cbug\uff0c\u9700\u52a0\u968f\u673a\u6570\u52a0\u8f7d\u3002\u817e\u8bafTT\u7684external\u5b9e\u73b0\u6709bug\uff0c\u76f4\u63a5.max_version\u62a5\u9519\u2026\u2026*/
			try
			{
				if(window.external && window.external.max_version)
				{
					_search.rn = random();
				}
			}
			catch(e) { }
			swfobject.embedSWF(flashURL + '?' + Object.toQueryString(_search),"flash","560","490","10","/expressInstall.swf",flashvarsObj,parObj,attObj,function (arg)
			{
				if(arg.success)
				{
					//                    _flashOK = true;compare.init();
				}
				else
				{
					/*\u5982\u679c\u662fflash\u52a0\u8f7d\u5931\u8d25\uff0c\u52a0\u8f7d\u56fe\u7247\u7248\uff0c\u6700\u8fd1\u8bbf\u95ee\u80a1\u9ad8\u5ea6\u8981\u7f29\u5c0f\uff0c\u5bf9\u6bd4\u6a21\u5757\u52a0\u5904\u7406*/
					$('#flashOK').hide();
					if(h5Status==1){
						$('#h5Container').show();
						initH5.init();
					}else{
						hqImg.init();
					}

					/*\u505c\u6b62\u540c\u65f6\u88ab\u5173\u6ce8\u7684\u5237\u65b0*/
					attention.stop();
				}

			});
		};
	} ();

	//init of h5:
    var _compareColor=['#f69931','#f2c700','#3e4de1','#bf58ef'];
    var _cnChart;
    var initH5 = new function() {

        this.init=function(){
            if(!KKE)
            {
                getScript('http://finance.sina.com.cn/sinafinancesdk/js/sf_sdk.js', function() {
                           getH5img();
                });
            }
            else
            {
                getH5img();
            }
            function getH5img(){
            KKE.api('plugins.sinaTKChart.get',{
                compare:{color:_compareColor},
                symbol:papercode,//\u8bc1\u5238\u4ee3\u7801
                dom_id:'h5Figure'//\u653e\u7f6e\u56fe\u5f62\u7684dom\u5bb9\u5668id
            },function(chart_){
                _cnChart=chart_;
                compareH5.init();
                //\u5f39\u5e55\u521d\u59cb\u5316\u5f00\u59cb \u7531\u4e8e\u5f39\u5e55\u662f\u8ddfH5\u884c\u60c5\u56fe\u76f8\u5173\u8054\uff0c\u5c3d\u91cf\u884c\u60c5\u56fe\u52a0\u8f7d\u5b8c\u6bd5\u518d\u5f15\u5165h5\u5f39\u5e55

               /*	if(stock_brg&&!stock_brg.objBrg)
                   stock_brg.init();*/
                   stock_brg = new stockBrg();

            });
            }
        }
    };
    /*\u5bf9\u6bd4\u529f\u80fd*/
    var compareH5 = new function() {
        var _indexs = '#compareIndexH5 a';
        var _comList = [];
        var _max = 4;
        var _msg = '#compareMSGH5';
        var _suggest;

        function _addCompare(argSym) {
            /*\u7a7a\u5185\u5bb9\u4e0d\u54cd\u5e94*/
            if (!argSym || argSym == '\u62fc\u97f3/\u4ee3\u7801/\u540d\u79f0') {
                _noCompare();
                return;
            }
            if (argSym == papercode){
				_addedCompare();
				return;
			}

            var __arrayData = (_suggest._objectData["key_" + argSym] || "").replace(/&amp;/g, "&").replace(/;$/, "").split(";");
            //\u6709\u7684\u8bdd\u53d6\u7b2c\u4e00\u4e2a
            if (__arrayData.length) {

                var xm=__arrayData[0].split(',');
                //23,11,12,41,31
                switch (xm[1]){
                    case '11':
                    case '12':
                    case '23':
                    case '81':
                        argSym=xm[3];
                        break;
                    case '41':
                        argSym='gb_'+xm[2];
                        break;
                    case '31':
                        argSym='rt_hk'+xm[2];
                        break;
                    case '73':
                        argSym='sb'+xm[2];
                        break;
                    case '71':
                        if(xm[2]==='diniw'||xm[2]==='usdcny') {
                            argSym=xm[2];
                            argSym=argSym.toUpperCase();
                        }
                        else argSym='fx_s'+xm[2];
                        break;
                }
            }
            //\u6ca1\u6709\u62a5\u9519
            else {
                _error('\u8bf7\u8f93\u5165\u6b63\u786e\u7684\u80a1\u7968\u4ee3\u7801');
            }

            if(_comList.length >= _max)
            {
                _compareTooMore();
                return;
            }
            for(var i = 0;i < _comList.length;i++)
            {
                if(_comList[i].symbol == argSym)
                {
                    _addedCompare();
                    return;
                }
            }

            KKE&&KKE.api('datas.hq.get',{symbol:argSym},function(obj_){

                if(!obj_.data[0].name){
                    _error('\u6b64\u8bc1\u5238\u5df2\u9000\u5e02');
                    return;
                }
                // var obj={symbol:argSym,name:obj_.data[0].name};
                var name=obj_.data[0].name.length>4?obj_.data[0].name.substring(0,4)+'..':obj_.data[0].name;
                var obj={symbol:argSym,name:name};
                _comList.push(obj);
                _cnChart.compare({symbol:argSym,linecolor:{K_N:_compareColor[_comList.length-1]}});
                $('#h5CompareCon').show();
                cSymbol(obj,_compareColor[_comList.length-1]);
            })

            return false;
        }

        function cSymbol(obj_,color_){
            var d=$C('div'),s1=$C('span'),s2=$C('span');
            d.appendChild(s1);
            d.appendChild(s2);
            $id('h5CompareCon').appendChild(d);

            s1.className='item-span-del';
            s2.className='item-span-name1';

            s2.style.color=color_;
            s2.innerHTML  =obj_.name;
            d.setAttribute('data-symbol',obj_.symbol);

            $(d).click(function(){

                var delSymbol=this.getAttribute('data-symbol');

                _cnChart.compare({symbol:delSymbol},true);

                for(var i = _comList.length - 1;i >= 0;i--){
                    if(_comList[i].symbol == delSymbol){
                        _comList.splice(i,1);

                        _compareColor.push(_compareColor[i]);
                        _compareColor.splice(i,1);
                    }
                }

                $id('h5CompareCon').removeChild(this);

                if(_comList.length<=0)$('#h5CompareCon').hide();
            });

            return d;
        }


        this.addCompare = _addCompare;

        function _noCompare() {
            _msg.html('\u8bf7\u9009\u62e9\u8981\u5bf9\u6bd4\u7684\u80a1\u7968').show();
            setTimeout(function() {
                _msg.hide();
            }, 3 * 1000);
        }

        function _compareTooMore() {
            _error('\u6700\u591a\u53ef\u5bf9\u6bd45\u53ea\u80a1\u7968');
        }

        function _addedCompare() {
            _error('\u5df2\u7ecf\u6dfb\u52a0\u4e86\u8be5\u80a1\u7968');
        }

        function _error(msg) {
            _msg.html(msg).show();
            setTimeout(function() {
                _msg.fadeOut();
            }, 2 * 1000);
        }
        /*\u4f9bflash\u8c03\u7528\uff0c\u5220\u9664\u5bf9\u6bd4*/

        function _delCompare(argSym, argWrong) {
            for (var i = _comList.length - 1; i >= 0; i--) {
                if (_comList[i] == argSym) {
                    _comList.splice(i, 1);
                }
            }
            /*\u5982\u679c\u6709\u9519\u8bef\u63d0\u793a\u663e\u793a*/
            if (argWrong) {
                _error(argWrong);
            }
        }
        window.Conn.delSymbol = _delCompare;
        this.init = function() {
            /*\u6307\u6570\u6d6e\u5c42*/
            $('#compareIndexH5').mouseover(function() {
                $(this).find('.is').show();
            }).mouseleave(function() {
                $(this).find('.is').hide();
            });
            _indexs = $(_indexs);
            _indexs.click(function() {
                var _sym = $(this).attr('symbol');
                _addCompare(_sym);
            });

            _msg = $(_msg);

             if(window.SuggestHtml5)
            {
                 suggestH5();
            }
            else
            {
                getScript('http://n.sinaimg.cn/finance/hqimg20160510/suggestHtml5_20160510.js',function(){
                     suggestH5();
                });
            }
            function suggestH5(){
                _suggest = new SuggestHtml5();//SuggestServer();
                _suggest.bind({
                    // \u9664"input"\u5fc5\u987b\u8bbe\u7f6e\u5916 \u5176\u4ed6\u5747\u4e3a\u53ef\u9009
                    "input": "compareTxtH5", //*(\u5fc5\u9009) \u6307\u5b9asuggest\u7ed1\u5b9a\u7684\u5bf9\u8c61 [string|HTMLElement.input]
                    "default": "\u62fc\u97f3/\u4ee3\u7801/\u540d\u79f0", // \u53ef\u6307\u5b9ainput\u9ed8\u8ba4\u503c [string] \u9ed8\u8ba4\u7a7a
                    "type": "23,11,12,41,31,71,73,81", // \u7c7b\u578b [string] \u4f8b\u5982"stock"\u3001"23"\u3001"11,12"
                    "callback": _addCompare // \u9009\u5b9a\u63d0\u793a\u884c\u65f6\u7684\u56de\u8c03\u65b9\u6cd5\uff0c\u56de\u8c03\u8be5\u65b9\u6cd5\u65f6\u4f20\u5165\u5f53\u524dinput\u5185value [function|null]
                });
            }
            $('#compareBtnH5').click(function() {
                _addCompare($('#compareTxtH5').val());
            });
            attention.init('html5');
        };
    }();
    //end of h5

	//\u5f39\u5e55
	function stockBrg(){
		var brg1;
		this.objBrg = null;
		var that = this;
		this.webSocketObj = null;
		this.arrPush = [];
		this.maxLen = 200;
		this.objId = 0;
    	var _cookieCfg = {
            path: "/",
            domain: "finance.sina.com.cn",
            expires: "7"
        }, _cookieKey = "FINA_DMHQ";
		function _checkStatus(val){
			var _content = $('#barrageContent');
			var on_off = $('#barrageSent .b_controll i').hasClass('on');
			if (!val) {
	          	widets.alert('\u5f39\u5e55\u5185\u5bb9\u4e0d\u80fd\u4e3a\u7a7a');
	            _content.focus();
	            return false;
        	}
        	if (val.length > 50) {
	           	widets.alert('\u5f39\u5e55\u5185\u5bb9\u4e0d\u80fd\u8d85\u8fc750\u4e2a\u5b57\u7b26\uff01');
	            _content.focus();
	            return false;
        	}
        	if(!on_off)
        	{
        		widets.alert('\u8bf7\u70b9\u51fb\u5f39\u5e55\u5f00\u542f\u6309\u94ae');
        		return false;
        	}
        	return true;

		}

		function _getCloseNum(num){
			 _S_uaTrack("hq_barrage", num);
		}
		function bindEvent(){
			$('#barrageSent .sendBtn').bind('click',function(){
				var val = $('#barrageContent').val();
				that.send(val);
				return false;
			});
			$('#barrageContent').bind('keydown',function(event){

					if(event.keyCode == 13)
					{
						var val = $.trim($('#barrageContent').val());
						that.send(val);
					}
			});
			$('#barrageSent .b_controll i').bind('click',function(event){
				var target = $(event.target);
				if(!target.is('i'))return false;
				if(target.is('i'))
				{
					var on_off = target.hasClass('on');
					if(on_off)
					{
						target[0].className = 'off';
            			//console.log(_cookieCfg,_cookieCfg);
            			Cookie.set(_cookieKey, 0, _cookieCfg);
            			_getCloseNum(0);
						that.objBrg.clear();

					}
					else
					{
						target[0].className ='on';
            			Cookie.set(_cookieKey, 1, _cookieCfg);
            			_getCloseNum(1);
						that.objBrg.restart();
						that.arrPush.length = 0;
					}
				}
				return false;
			});
		}
		bindEvent();
		this.init = function(fn){
		getScript('http://n.sinaimg.cn/finance/hqimg20160510/Barrage.js',function(bar){
		//\u5173\u4e8e\u5f39\u5e55\u521d\u59cb\u5316
		 	that.objBrg = new Barrage({
			    element : 'barrageContain',
			    maxTxtLen:100
			});
		fn&&fn();
		},'utf-8');

		};
		this.send = function(val){
			var val = val;
			if(!sinaSSOController)
			{
				sinaSSOController = new SSOController();
				sinaSSOController.init();
			}
			else
			{
				sinaSSOController.checkLoginState(function(data){
					//console.log(data);
					if(!data)
					{
						loginLayer.open();
					}
					else
					{
						if(!_checkStatus(val))
						{
							return;
						}
						that.DMgotdata(val);
            			$('#barrageContent').val('');
				        $.ajax({
				        	url: 'http://stock.finance.sina.com.cn/stock/api/openapi.php/StockBarrageServiceResult.getStockBarrage',
				        	dataType: 'jsonp',
				        	data: {symbol: papercode,content:val},
				        	jsonpCallback:'sendDM'+rdt(),
				        	success:function(data){
				        		if(data.result.data==1)
				        		{
				        			//$('#barrageContent').val('');
				        		}
				        		else
				        		{
				        			//widets.alert('\u53d1\u9001\u5931\u8d25');
				        			console.log(data.result.data);
				        		}
				        	}
				        });

					}
				});
			}
		};
		this.DMgotdata = function(val){
			if(!(this&&this.objBrg&&val))return;
			var len = this.arrPush.length;
			var on_off = $('#barrageSent .b_controll i').hasClass('on');
			if(!on_off){
				this.arrPush.length = 0;
				return ;
			}
			if(len>=200)
			{
				return;
			}
			else
			{
				this.arrPush.push(val);
			}
			//this.objBrg.add({txt:val});
			//$('#barrageContent').val('');
		};
		this.init.call(this,function(){
				var self = that;
        if(Cookie.get('FINA_DMHQ')==='')
        {
          Cookie.set(_cookieKey, 1, _cookieCfg);
          //_getCloseNum(1);
        }
        if(Cookie.get('FINA_DMHQ')*1==0)
        {
          $('#barrageSent .b_controll i')[0].className ='off';
          //_getCloseNum(0);
          //return;
        }
        if (!window.IO || !window.IO.WebPush4)
        {
	        getScript('http://woocall.sina.com.cn/lib/IO.WebPush4.js', function() {
	         	self.webSocketObj = new IO.WebPush4('hq.sinajs.cn','dm_'+papercode,function(m) {
			 	var jsontxt = m['dm_'+papercode]?(function(){return m['dm_'+papercode];})():'';
					//console.log(jsontxt);
		        if(Cookie.get('FINA_DMHQ')*1==0)
		        {
		          return;
		        }
				if(self.objId !=jsontxt["id"])
        		{
        			self&&self.DMgotdata(jsontxt["content"]);
        			self.objId = jsontxt['id'];
        		}
				},{
	                interval: 3,
	                format:'json'
	        	});
	        	setInterval(function(){
						var val = self.arrPush.shift();
						if(!(self&&self.objBrg&&val))return;
						self.objBrg.add({txt:val});
				},500);
	        });
        }
        else
        {
        	self.webSocketObj = new IO.WebPush4('hq.sinajs.cn','dm_'+papercode,function(m) {
			 	var jsontxt = m['dm_'+papercode]?(function(){return m['dm_'+papercode];})():'';
					//console.log(jsontxt);
		        if(Cookie.get('FINA_DMHQ')*1==0)
		        {
		          return;
		        }
				if(self.objId !=jsontxt["id"])
        		{
        			self&&self.DMgotdata(jsontxt["content"]);
        			self.objId = jsontxt['id'];
        		}
				},{
	                interval:3,
	                format:'json'
	        	});
        	setInterval(function(){
						var val = self.arrPush.shift();
						if(!(self&&self.objBrg&&val))return;

						self.objBrg.add({txt:val});
					},500);
        }
		});
	};
    // \u6a21\u62df\u4f20\u8f93\u6570\u636e
    // msgs.simSend(brg1);


	/*\u540c\u65f6\u88ab\u5173\u6ce8*/
    var attention = new function() {
        /*\u80a1\u7968\u5217\u8868\uff0c\u6bcf\u6b21\u5207\u6362\u5220\u9664\u6362\u65b0\u7684\uff0c\u6570\u636e\u52a0\u8f7d\u540e\u6392\u5e8f\u5e76\u663e\u793a\u3002\u6dfb\u52a0\u4e00\u4e2asorted\u5c5e\u6027\u4f5c\u4e3a\u6807\u8bc6*/
        var _stockList = [];
        var _showingIndex = 0;
        /*\u81ea\u52a8\u5237\u65b0\u5b9a\u65f6\u5668\uff0c\u6bcf\u6b21\u5207\u6362\u91cd\u7f6e\uff0c\u5e76\u9a6c\u4e0a\u52a0\u8f7d\u4e00\u6b21\u6570\u636e*/
        var _timer;
        var _maxNum = 9;
        var _type;
        var _requestIndex = 0;
        this.init = function(type) {
            _type = type;
            if (_type == 'img') {
                _maxNum = 30;
                $('#attention .cont').height('205px');
            }
            _show();
        };
        this.stop = function() {
            clearInterval(_timer);
        };

        function _show(argIndex) {
            /*\u786e\u4fdd\u662f\u5207\u6362\u7684*/
            if (typeof argIndex == 'number') {
                _showingIndex = argIndex;
            }
            /*\u8bbe\u7f6e\u597d\u5404\u79cd\u72b6\u6001*/
            clearInterval(_timer);
            _stockList.sorted = false;
            /*\u6e05\u7a7a\u80a1\u7968*/
            while (_stockList.length) {
                _stockList.pop().release();
            }
            /*\u521b\u5efa\u65b0\u7684\u80a1\u7968\u5217\u8868*/
            var _list = (window.attentionList || [])[_showingIndex] || [];
            var _stock;
            for (var i = 0; i < _list.length && i < _maxNum; i++) {
                _stock = new _Stock(_list[i]);
                _stockList.push(_stock);
            }
            if (_stockList.length) {
                _getData();
                _timer = setInterval(function() {
                    if (checkDayTime()) {
                        _getData();
                    }
                }, 5 * 1000);
            } else {
                $('#attention .cont ul').eq(_showingIndex).html('<li>\u6ca1\u6709\u76f8\u5173\u80a1\u7968</li>');
            }
        }

        function _getData() {
            var _list = [];
            for (var i = 0; i < _stockList.length; i++) {
                _list.push(_stockList[i].symbol);
            }
            if (_list.length) {
                _requestIndex++;
                loadScript(hqURL.replace('$rn', random()) + 's_' + _list.join(',s_'), _gotData.bindArg(_requestIndex));
            }
        }

        function _gotData(argRequestIndex) {
            if (_requestIndex != argRequestIndex) {
                return;
            }
            var _datas = {};
            var _d, _ds, _symbol;
            /*\u8f93\u51fa\u6570\u636e*/
            for (var i = 0; i < _stockList.length; i++) {
                _symbol = _stockList[i].symbol;
                _ds = window['hq_str_s_' + _symbol] || '';
                _d = {};
                _datas[_symbol] = _d;
                _ds = _ds.split(',');
                _d.name = _ds[0] || _symbol;
                _d.now = _ds[1] * 1 ? _ds[1].toFixed(isSHB(_symbol) ? 3 : 2) : '--';
                _d.changeP = _ds[1] * 1 ? _ds[3] + '%' : '--';
                _stockList[i].draw(_d);
            }
            /*\u5982\u679c\u6ca1\u6392\u8fc7\u5e8f\u7684\u8bdd\u8bf4\u660e\u662f\u521d\u59cb\u5316\uff0c\u6392\u5e8f\u5e76\u52a0\u5165\u9875\u9762*/
            if (!_stockList.sorted) {
                _stockList.sorted = true;
                //                _stockList.sort(function ($1,$2)
                //                {
                //                    var _d1 = _datas[$1.symbol].changeP;
                //                    var _d2 = _datas[$2.symbol].changeP;
                //                    if(_d1 == '--')
                //                    {
                //                        return '1';
                //                    }
                //                    if(_d2 == '--')
                //                    {
                //                        return '-1';
                //                    }
                //                    return parseFloat(_d2) - parseFloat(_d1);
                //                });
                var _container = $('#attention .cont ul').eq(_showingIndex);
                for (var i = 0; i < _stockList.length; i++) {
                    _container.append(_stockList[i].obj);
                }
            }
        }

        function _Stock(symbol) {
            this.symbol = symbol;
            this.obj;
            this.nameLink;
            this.dataSpan;
            this.compareBtn;
            this.createDom();
            if (_type == 'flash') {
                this.addEvent();
            }else if(_type =='html5'){
                this.addEvent();
            }
        }
        merge(_Stock.prototype, {
            createDom: function() {
                this.obj = $C('li');

                this.nameLink = $C('a');
                this.nameLink.href = pageURL.replace('$symbol', this.symbol);
                this.nameLink.innerHTML = this.symbol;
                this.obj.appendChild(this.nameLink);

                this.obj.appendChild(document.createTextNode('('));

                this.dataSpan = $C('span');
                this.dataSpan.innerHTML = '--.-- --.--';
                this.obj.appendChild(this.dataSpan);

                this.compareBtn = $C('a');
                this.compareBtn.innerHTML = '\u52a0\u5165\u8d70\u52bf\u5bf9\u6bd4';
                this.compareBtn.href = 'javascript:void(0)';
                this.compareBtn.className = 'add_compare';
                this.obj.appendChild(this.compareBtn);

                this.obj.appendChild(document.createTextNode(')'));
            },
            addEvent: function() {
                var _this = this;
                $(this.nameLink).mouseenter(function() {
                    _this.dataSpan.style.display = 'none';
                    _this.compareBtn.style.display = 'inline';
                });
                $(this.obj).mouseleave(function() {
                    _this.dataSpan.style.display = '';
                    _this.compareBtn.style.display = '';
                });

                if(_type=='flash'){
                    $(this.compareBtn).click(compare.addCompare.fnBind(compare, [this.symbol]));
                }else if(_type=='html5'){
                    $(this.compareBtn).click(compareH5.addCompare.fnBind(compareH5, [this.symbol]));
                }

            },
            draw: function(argData) {
                this.nameLink.innerHTML = argData.name || this.symbol;
                this.dataSpan.innerHTML = argData.now + ' ' + argData.changeP;
                this.dataSpan.className = checkUD(undefined, parseFloat(argData.changeP));
            },
            release: function() {
                this.obj.parentNode && this.obj.parentNode.removeChild(this.obj);
                this.obj = null;
                this.dataSpan = null;
                this.compareBtn = null;
            }
        });
    }();

	/*\u5173\u6ce8\u72b6\u6001*/
	var holdStatus = new function ()
	{
		var _statusHolder = [];
		var _hasLogin = false;
		var _loginOKCall = [];
		function _loginChecker(loginOKCall)
		{
			if(_hasLogin)
			{
				return true;
			}
			else
			{
				loginLayer.open();
				_loginOKCall.push(loginOKCall);
				return false;
			}
		}
		this.init = function ()
		{
			LoginManager.add(
            {
            	onLoginSuccess: function ()
            	{
            		_hasLogin = true;
            		for(var i = 0;i < _statusHolder.length;i++)
            		{
            			_statusHolder[i].getStatus();
            		}
            		while(_loginOKCall.length)
            		{
            			_loginOKCall.shift()();
            		}
            	},
            	onUserChanged: function ()
            	{
            		for(var i = 0;i < _statusHolder.length;i++)
            		{
            			_statusHolder[i].getStatus();
            		}
            	},
            	/*\u9000\u51fa\u5207\u6362\u72b6\u6001\uff0c\u5e76\u5220\u9664\u6240\u6709\u81ea\u9009\u80a1DOM*/
            	onLogoutSuccess: function ()
            	{
            		_hasLogin = false;
            		for(var i = 0;i < _statusHolder.length;i++)
            		{
            			_statusHolder[i].hasNotHold();
            		}
            	}
            });

			getScript('http://finance.sina.com.cn/basejs/holdStatus.js',function ()
			{
				_statusHolder.push(new HoldStatus(papercode,'holdStatus',_loginChecker,'','','\u52a0\u5165\u81ea\u9009\u80a1','\u5df2\u6dfb\u52a0\u81ea\u9009'));
				if(_hasLogin)
				{
					for(var i = 0;i < _statusHolder.length;i++)
					{
						_statusHolder[i].getStatus();
					}
				}
			});
		};
	} ();

	var weibo = new function ()
	{
		var _weiboSubmit,_submitNew,_weibo_new_txt,_weiboNewTxtrem,_weiboMore;
		var _pageIndex = 1;
		var _getting = false;
		/*\u6b63\u5728\u7f16\u8f91\u8f6c\u53d1\u8bc4\u8bba\u7684\u5fae\u535aid\uff0c\u540c\u65f6\u4e5f\u7528\u6765\u5224\u65ad\u662f\u5426\u5728\u663e\u793a\u7f16\u8f91\u6846*/
		var _rc_mid;
		/*\u9a8c\u8bc1\u5185\u5bb9\u957f\u5ea6*/
		function _keypress(argID)
		{
			var _value = this.value;
			var _length = _value.replace(/[^\x00-\xff]/g,'**').length;
			var _less = 280 - _length;
			_less = _less / 2;
			if(_less >= 0)
			{
				$('#' + argID).html('\u8fd8\u53ef\u4ee5\u8f93\u5165<span>' + Math.floor(_less) + '</span>\u5b57').removeClass('weibo_new_over');
			}
			else
			{
				$('#' + argID).html('\u5df2\u7ecf\u8d85\u8fc7<span>' + Math.ceil(-_less) + '</span>\u5b57').addClass('weibo_new_over');
			}
			/*\u52a8\u8fc7\u8f93\u5165\u5185\u5bb9\u7684\u8bdd\u5c31\u4e0d\u81ea\u52a8\u53d1\u5e03\u4e86*/
			_loginOKCall = null;
		}
		/*\u8f93\u5165\u6709\u95ee\u9898\u7684\u63d0\u793a*/
		function _error(g,f)
		{
			g = document.getElementById(g || 'pub_editor');
			if(!f)
			{
				f = {};
			}
			var d = f.orbit || ["#fee","#fdd","#fcc","#fdd","#fee","#fff"];
			var i = f.times || 2;
			var c = f.delay || 15;
			var b = 0;
			var h = setInterval(function ()
			{
				if(b / c >= d.length)
				{
					i -= 1;
					if(i > 0)
					{
						b = 0
					} else
					{
						clearInterval(h);
						return false
					}
				}
				g.style.backgroundColor = d[b / c];
				b += 1;
			},1);
			return false;
		}
		/*\u663e\u793a\u8f6c\u53d1\u6846*/
		function _repost(mid)
		{
			/*\u5148\u628a\u4e4b\u524d\u7684\u6846\u5220\u6389\uff0c\u5982\u679c\u5f53\u524d\u662f\u663e\u793a\u72b6\u6001\uff0c\u6307\u5b9a\u4e5f\u662f\u5220\uff0c\u4e0d\u663e\u793a\u4e86\uff0c\u6216\u8005\u4f1a\u6362\u4e2a\u65b0\u5fae\u535a\u4e0b\u9762\u53bb*/
			var _commentDiv = $('#commentDiv');
			var _showingComment = _commentDiv.length;
			$('#commentDiv').remove();
			$('#repostDiv').remove();
			/*\u4e0d\u662f\u5f53\u524d\u7684\u5fae\u535a\u7684\u8bdd\u52a0\u4e2a\u65b0\u7684*/
			if(_rc_mid !== mid || _showingComment)
			{
				_rc_mid = mid;
				$(this).parents('.weibo_s').append('<div id="repostDiv" class="feedback fwrd"><div class="arrcon"><div class="arr"></div><div class="arrin"></div></div>								<div class="feedbackcon">									<div class="txtarea"><textarea id="fc_editor" style="color: rgb(153, 153, 153); "></textarea>									<div class="tips" id="fc_tips" style="display: none; "></div>									</div>									<div class="fdbckspe">										<a id="fc_submit" class="btn_s" href="javascript:void(0)">\u8f6c\u53d1</a>										<p id="fc_limit" class="txtrem">140</p>										<div class="fdbckspein">											<input type="checkbox" id="fc_issync">											<label for="fc_issync">\u540c\u65f6\u8bc4\u8bba</label>										</div>									</div>								</div></div>');
				var _editor = $('#fc_editor').keyup(_keypress.bindArg('fc_limit')).keydown(_keypress.bindArg('fc_limit')).keyup()[0];
				_editor.onfocus = function ()
				{
					this.style.color = '';
				};
				_editor.onblur = function ()
				{
					this.style.color = '#9E9E9E';
				};
				$('#fc_submit').click(_repostSubmit);
			}
			/*\u662f\u7684\u8bdd\u4e3a\u9690\u85cf\u64cd\u4f5c\uff0c\u6e05\u6389mid*/
			else
			{
				_rc_mid = '';
			}
		}
		function _repostSubmit()
		{
			/*\u5148\u66f4\u65b0\u4e0b\u5269\u4f59\u5b57\u6570*/
			_keypress.call(document.getElementById('fc_editor'),'fc_limit');
			/*\u6ca1\u767b\u9646\u7684\u8bdd\u767b\u5f55*/
			if(!weiboLoginManager.userInfo())
			{
				_loginOKCall = arguments.callee;
				weiboLoginManager.login();
				return false;
			}
			var _words = $('#fc_editor').val();
			if(_words.replace(/[^\x00-\xff]/g,'**').length > 280)
			{
				_error('fc_editor');
				return;
			}
			if(!_words)
			{
				_error('fc_editor');
				return;
			}
			WB2.anyWhere(function (W)
			{
				W.parseCMD("/statuses/repost.json",function (sResult,bStatus)
				{
					if(bStatus == true)
					{
						$('#fc_tips').html('<div class="tips" id="pub_error"><em class="icon_ok"></em>\u8f6c\u53d1\u6210\u529f\uff01</div>').show();
						setTimeout(function ()
						{
							$('#repostDiv').slideUp(function ()
							{
								$('#repostDiv').remove();
								_rc_mid = '';
							});
						},2000);
					}
					else
					{
						$('#fc_tips').html('<div class="tips" id="pub_error"><em class="icon_warning"></em>\u8f6c\u53d1\u5931\u8d25\uff0c\u8bf7\u7a0d\u540e\u518d\u8bd5\uff01</div>').show();
						setTimeout(function ()
						{
							$('#fc_tips').empty().hide();
						},2000);
					}
				},{
					source: wbAppKey,
					id: _rc_mid,
					status: encodeURIComponent(_words),
					is_comment: document.getElementById('fc_issync').checked ? '1' : '0'
				},{
					method: 'post'
				});
			});
			return false;
		}
		function _comment(mid)
		{
			/*\u5148\u628a\u4e4b\u524d\u7684\u6846\u5220\u6389\uff0c\u5982\u679c\u5f53\u524d\u662f\u663e\u793a\u72b6\u6001\uff0c\u6307\u5b9a\u4e5f\u662f\u5220\uff0c\u4e0d\u663e\u793a\u4e86\uff0c\u6216\u8005\u4f1a\u6362\u4e2a\u65b0\u5fae\u535a\u4e0b\u9762\u53bb*/
			$('#commentDiv').remove();
			var _repostDiv = $('#repostDiv');
			var _showingRepost = _repostDiv.length;
			_repostDiv.remove();
			/*\u4e0d\u662f\u5f53\u524d\u7684\u5fae\u535a\u7684\u8bdd\u52a0\u4e2a\u65b0\u7684*/
			if(_rc_mid !== mid || _showingRepost)
			{
				_rc_mid = mid;
				$(this).parents('.weibo_s').append('<div id="commentDiv" class="feedback comm"><div class="arrcon"><div class="arr"></div><div class="arrin"></div></div>								<div class="feedbackcon">									<div class="txtarea"><textarea id="fc_editor" style="color: rgb(153, 153, 153); "></textarea>									<div class="tips" id="fc_tips" style="display: none; "></div>									</div>									<div class="fdbckspe">										<a id="fc_submit" class="btn_s" href="javascript:void(0)">\u8bc4\u8bba</a>										<p id="fc_limit" class="txtrem">140</p>										<div class="fdbckspein">											<input type="checkbox" id="fc_issync">											<label for="fc_issync">\u540c\u65f6\u8f6c\u53d1</label>										</div>									</div>								</div></div>');
				var _editor = $('#fc_editor').keyup(_keypress.bindArg('fc_limit')).keydown(_keypress.bindArg('fc_limit')).keyup()[0];
				_editor.onfocus = function ()
				{
					this.style.color = '';
				};
				_editor.onblur = function ()
				{
					this.style.color = '#9E9E9E';
				};
				$('#fc_submit').click(_commentSubmit);
			}
			/*\u662f\u7684\u8bdd\u4e3a\u9690\u85cf\u64cd\u4f5c\uff0c\u6e05\u6389mid*/
			else
			{
				_rc_mid = '';
			}

		}
		function _commentSubmit()
		{
			/*\u5148\u66f4\u65b0\u4e0b\u5269\u4f59\u5b57\u6570*/
			_keypress.call(document.getElementById('fc_editor'),'fc_limit');
			/*\u6ca1\u767b\u9646\u7684\u8bdd\u767b\u5f55*/
			if(!weiboLoginManager.userInfo())
			{
				_loginOKCall = arguments.callee;
				weiboLoginManager.login();
				return false;
			}
			var _words = $('#fc_editor').val();
			if(_words.replace(/[^\x00-\xff]/g,'**').length > 280)
			{
				_error('fc_editor');
				return;
			}
			if(!_words)
			{
				_error('fc_editor');
				return;
			}
			WB2.anyWhere(function (W)
			{
				var _method,_data = {};
				if(document.getElementById('fc_issync').checked)
				{
					_method = '/statuses/repost.json';
					_data =
                    {
                    	source: wbAppKey,
                    	id: _rc_mid,
                    	status: encodeURIComponent(_words),
                    	is_comment: '1'
                    };
				}
				else
				{
					_method = '/comments/create.json';
					_data =
                    {
                    	source: wbAppKey,
                    	id: _rc_mid,
                    	comment: encodeURIComponent(_words)
                    };
				}
				W.parseCMD(_method,function (sResult,bStatus)
				{
					if(bStatus == true)
					{
						$('#fc_tips').html('<div class="tips" id="pub_error"><em class="icon_ok"></em>\u8bc4\u8bba\u6210\u529f\uff01</div>').show();
						setTimeout(function ()
						{
							$('#commentDiv').slideUp(function ()
							{
								$('#commentDiv').remove();
								_rc_mid = '';
							});
						},2000);
					}
					else
					{
						$('#fc_tips').html('<div class="tips" id="pub_error"><em class="icon_warning"></em>\u8bc4\u8bba\u5931\u8d25\uff0c\u8bf7\u7a0d\u540e\u518d\u8bd5\uff01</div>').show();
						setTimeout(function ()
						{
							$('#fc_tips').empty().hide();
						},2000);
					}
				},_data,{
					method: 'post'
				});
			});
			return false;
		}
		function _initJP()
		{
			_getData = _getJP;
			_getData();
		}
		function _getJP()
		{
			if(_getting)
			{
				return false;
			}
			getScript('http://topic.t.sina.com.cn/api/api.php?s=api&a=get_weibo_by_zhuanti&zid=683&cid=2247&format=json&page=' + _pageIndex + '&page_size=25&callback=gotWeiboData',_gotJP);
			_pageIndex++;
			_getting = true;
			_weiboMore.html('\u52a0\u8f7d\u4e2d...');
			return false;
		}
		function _gotJP()
		{
			var _container = $('#weiboList');
			var _datas = window['weiboData'].result.data || [];
			for(var i = 0;i < _datas.length;i++)
			{
				_container.append(_createSingle(_datas[i],'JP'));
			}
			$('#weiboList').append(_weiboMore);
			_weiboMore.html('\u66f4\u591a..');
			_getting = false;
		}
		function _initWHT()
		{
			_getData = _getWHT;
			_getData();
		}
		function _getWHT()
		{
			if(_getting)
			{
				return false;
			}
			getScript('http://stock.finance.sina.com.cn/weibo/api/2/search/statuses.php?callback=gotWeiboData&page=' + _pageIndex + '&count=25&q=' + encodeURIComponent(stockname),_gotWHT);
			_pageIndex++;
			_getting = true;
			_weiboMore.html('\u52a0\u8f7d\u4e2d...');
			return false;
		}
		function _getData()
		{

		}
		function _gotWHT()
		{
			var _container = $('#weiboList');
			var _datas = window['weiboData'].statuses || [];
			for(var i = 0;i < _datas.length;i++)
			{
				_container.append(_createSingle(_datas[i],'WHT'));
			}

			$('#weiboList').append(_weiboMore);
			_weiboMore.html('\u66f4\u591a..');
			_getting = false;
		}
		function _regTime(argT)
		{
			var _postTime = new Date(argT);
			var _now = clock.time();
			var _differ = Math.round((_now - _postTime) / 1000);
			var _showTime;
			if(_differ <= 0)
			{
				_differ = 1;
			}
			if(_differ < 60)
			{
				_showTime = _differ + '\u79d2\u524d';
			}
			else if(_differ < 3600)
			{
				_showTime = Math.floor(_differ / 60) + '\u5206\u949f\u524d';
			}
			else if(_now.getDate() == _postTime.getDate())
			{
				_showTime = '\u4eca\u5929 ' + _postTime.getHours().preFull() + ':' + _postTime.getMinutes().preFull();
			}
			else
			{
				_showTime = (_postTime.getMonth() + 1).preFull() + '\u6708' + _postTime.getDate().preFull() + '\u65e5 ' + _postTime.getHours().preFull() + ':' + _postTime.getMinutes().preFull();
			}
			return _showTime;
		}
		function _createSingle(argData,type)
		{
			if(type == 'JP')
			{
				argData.created_at = argData.created_at * 1000;
				argData.base62_id = argData.mid;
				argData.mid = argData.v_id;
			}
			else
			{
				argData.created_at = argData.created_at.replace('+',/ie/i.test(navigator.userAgent) ? 'UTC +' : '+');
			}
			var _weibo_s = $C('div');
			_weibo_s.className = 'weibo_s';

			var _weibo_head = $C('div');
			_weibo_head.className = 'weibo_head';
			_weibo_s.appendChild(_weibo_head);

			var _a1 = $C('a');
			_a1.href = 'http://weibo.com/' + argData.user.profile_url;
			_a1.target = '_blank';
			_a1.title = argData.user.screen_name;
			_weibo_head.appendChild(_a1);
			var _headPic = $C('img');
			_headPic.height = '30';
			_headPic.width = '30';
			_headPic.src = argData.user.profile_image_url.replace('/50/','/30/');
			_a1.appendChild(_headPic);

			var _weibo_cont = $C('div');
			_weibo_cont.className = 'weibo_cont';
			_weibo_s.appendChild(_weibo_cont);
			var _p1 = $C('p');
			_weibo_cont.appendChild(_p1);
			var _a2 = $C('a');
			_a2.href = 'http://weibo.com/' + argData.user.profile_url;
			_a2.target = '_blank';
			_a2.title = argData.user.screen_name;
			_a2.innerHTML = argData.user.screen_name;
			_p1.appendChild(_a2);
			if(argData.user.verified)
			{
				var _vip = $C('img');
				_vip.title = argData.user.verified_reason;
				_vip.src = 'http://www.sinaimg.cn/cj/realstock/2012/images/transparent.gif';
				if(argData.user.verified_type != '0')
				{
					_vip.className = 'vip_c';
				}
				else
				{
					_vip.className = 'vip';
				}
				_a2.appendChild(_vip);
			}
			var _tt = argData.text;
			_tt = _tt.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
			_tt = _tt.replace(/@([0-9a-zA-Z\u4e00-\u9fa5_-]+)/g,function ($1,$2)
			{
				return '<a target="_blank" href="http://weibo.com/n/' + $2 + '">@' + $2 + '</a>';
			}).replace(/#(.*?)#/g,function ($1,$2)
			{
				return '<a target="_blank" href="http://s.weibo.com/weibo/' + $2 + '">#' + $2 + '#</a>';
			}).replace(/http\:\/\/t.cn\/[a-zA-Z0-9]+/g,function ($1)
			{
				return '<a target="_blank" href="' + $1 + '">' + $1 + '</a>';
			});
			var _txt = $C('span');
			_txt.innerHTML = '\uff1a' + _tt;
			_p1.appendChild(_txt);

			if(argData.thumbnail_pic)
			{
				var _pic = $C('div');
				_pic.className = 'weibo_img';
				_p1.appendChild(_pic);
				if(argData.original_pic)
				{
					var _a3 = $C('a');
					_a3.href = argData.original_pic;
					_a3.target = '_blank';
					_pic.appendChild(_a3);
				}
				var _thumb = $C('img');
				_thumb.src = argData.thumbnail_pic;
				if(argData.original_pic)
				{
					_a3.appendChild(_thumb);
				}
				else
				{
					_pic.appendChild(_thumb);
				}
			}

			var _weibo_info = $C('div');
			_weibo_info.className = 'weibo_info';
			_weibo_cont.appendChild(_weibo_info);
			var _time = $C('a');
			_time.className = 'weibo_time';
			_time.target = '_blank';
			_time.href = 'http://weibo.com/' + argData.user.id + '/' + argData.base62_id;
			_time.innerHTML = _regTime(argData.created_at);
			_weibo_info.appendChild(_time);
			var _span = $C('span');
			_weibo_info.appendChild(_span);
			var _rp = $C('a');
			_rp.href = 'javascript:void(0)';
			_rp.innerHTML = '\u8f6c\u53d1';
			_rp.onclick = _repost.bindArg(argData.mid);
			_span.appendChild(_rp);
			var _t1 = document.createTextNode(' ');
			_span.appendChild(_t1);
			var _i = $C('i');
			_i.innerHTML = '|';
			_span.appendChild(_i);
			var _t2 = document.createTextNode(' ');
			_span.appendChild(_t2);
			var _cmt = $C('a');
			_cmt.href = 'javascript:void(0)';
			_cmt.innerHTML = '\u8bc4\u8bba';
			_cmt.onclick = _comment.bindArg(argData.mid);
			_span.appendChild(_cmt);

			return _weibo_s;
		}
		function _showSubmit()
		{
			var _txt = _weibo_new_txt.val('#' + stockname + '#').keyup();
			_weiboSubmit.show();
		}
		function _publish()
		{
			/*\u6ca1\u767b\u5f55\u7684\u8bdd\u767b\u5f55*/
			if(!weiboLoginManager.userInfo())
			{
				_loginOKCall = arguments.callee;
				weiboLoginManager.login();
				return false;
			}
			/*\u9a8c\u8bc1\u5185\u5bb9\uff0c\u6ca1\u95ee\u9898\u53d1\u5e03*/
			var _words = _weibo_new_txt.val();
			if(_words.replace(/[^\x00-\xff]/g,'**').length > 280)
			{
				_error('weibo_new_txt');
				return false;
			}
			if(!_words)
			{
				_error('weibo_new_txt');
				return false;
			}
			WB2.anyWhere(function (W)
			{
				W.parseCMD('/statuses/update.json',function (sResult,bStatus)
				{
					if(bStatus)
					{
						$('#weiboNewEdit').hide();
						_weibo_new_txt.val('#' + stockname + '#').keyup();
						$('#weiboNewSuccess').show();
						$('#weiboNewLink').attr('href','http://weibo.com/' + weiboLoginManager.userInfo().id + '/profile');
						setTimeout(function ()
						{
							$('#weiboNewSuccess').fadeOut(function ()
							{
								$('#weiboNewEdit').show();
							});
						},3 * 1000);
					}
					else
					{
						var _errorMsg =
                        {
                        	'20016': '\u53d1\u5e03\u5931\u8d25\uff0c\u53d1\u5e03\u5185\u5bb9\u8fc7\u4e8e\u9891\u7e41',
                        	'20017': '\u53d1\u5e03\u5931\u8d25\uff0c\u521a\u521a\u53d1\u5e03\u4e86\u76f8\u4f3c\u7684\u4fe1\u606f',
                        	'20018': '\u53d1\u5e03\u5931\u8d25\uff0c\u5305\u542b\u975e\u6cd5\u7f51\u5740',
                        	'20019': '\u53d1\u5e03\u5931\u8d25\uff0c\u521a\u521a\u53d1\u5e03\u4e86\u76f8\u540c\u7684\u4fe1\u606f',
                        	'20021': '\u53d1\u5e03\u5931\u8d25\uff0c\u5305\u542b\u975e\u6cd5\u5185\u5bb9',
                        	'20111': '\u53d1\u5e03\u5931\u8d25\uff0c\u4e0d\u80fd\u53d1\u5e03\u76f8\u540c\u7684\u5fae\u535a'
                        };
						alert(_errorMsg[sResult.error_code] || '\u53d1\u5e03\u5931\u8d25');
					}
				},
                {
                	source: wbAppKey,
                	status: encodeURIComponent(_words)
                },{
                	method: 'post'
                });
			});
		}
		var _loginOKCall;
		this.init = function ()
		{
			window.gotWeiboData = function (argData)
			{
				window.weiboData = argData;
			};
			_weiboSubmit = $('#weiboSubmit');
			_submitNew = $('#weiboNew');
			_weibo_new_txt = $('#weibo_new_txt');
			_weiboNewTxtrem = $('#weiboNewTxtrem');
			_weiboMore = $('#weiboMore');

			_initJP();
			//            _initWHT();
			_weiboMore.click(_getData);
			/*\u53d1\u5e03\u6846\u952e\u76d8\u4e8b\u4ef6*/
			_weibo_new_txt.keyup(_keypress.bindArg('weiboNewTxtrem')).keydown(_keypress.bindArg('weiboNewTxtrem')).keyup(function (ev)
			{
				ev = ev || window.event;
				if(ev.ctrlKey && ev.keyCode == 13)
				{
					_publish();
				}
			});
			$('#weiboNewPublish').click(_publish);
			/*\u5207\u6362\u53d1\u5e03\u6846\u663e\u793a*/
			$('#weiboNew,#weiboLoginOpener').click(function ()
			{
				if(_weiboSubmit.css('display') != 'none')
				{
					if(this.id == 'weiboLoginOpener')
					{
						weiboLoginManager.login();
						return false;
					}
					_submitNew.html('\u6211\u8981\u53d1\u8a00..');
					_weiboSubmit.hide();
					return false;
				}
				if(weiboLoginManager.userInfo())
				{
					_showSubmit();
					_submitNew.html('\u6536\u8d77');
				}
				else
				{
					weiboLoginManager.login();
					_loginOKCall = arguments.callee;
				}
				return false;
			});
			$('#weiboLogoutBtn').click(function ()
			{
				weiboLoginManager.logout();
			});
			//            LoginManager.add(
			//            {
			//                logoutBtn: 'weiboLogoutBtn'
			//            });

			weiboLoginManager.add(
            {
            	onLoginSuccess: function ()
            	{
            		var _userInfo = weiboLoginManager.userInfo();
            		$('#weiboLogined').show();
            		$('#weiboNotLogin').hide();
            		$('#weiboNick,#weiboNick2').html(_userInfo.screen_name);
            		if(_loginOKCall)
            		{
            			_loginOKCall();
            			_loginOKCall = null;
            		}
            	},
            	onLogoutSuccess: function ()
            	{
            		$('#weiboLogined').hide();
            		$('#weiboNotLogin').show();
            		$('#weiboNick2').html('\u60a8\u5c1a\u672a\u767b\u5f55\uff0c\u53d1\u8a00\u63d0\u4ea4\u540e\u5c06\u8fdb\u5165\u767b\u5f55\u754c\u9762');
            	}
            });

		};
	} ();
	/*\u52a0\u8f7d\u5fae\u535a\u7684js SDK\u7b49*/
	function initWeiboJS()
	{
		var _jsNum = 2;
		function _scriptLoaded()
		{
			_jsNum--;
			if(!_jsNum)
			{
				weiboLoginManager.init();
				weiboRecommend.init();
				weibo.init();
			}
		}
		getScript('http://tjs.sjs.sinajs.cn/open/api/js/wb.js?appkey=' + wbAppKey + '&rn=' + random(),_scriptLoaded,'utf-8');
		getScript('http://finance.sina.com.cn/basejs/wbfollower.js',_scriptLoaded);
	}
	/*\u5fae\u535a\u767b\u9646\u72b6\u6001\u63a7\u5236\u7ec4\u4ef6*/
	var weiboLoginManager = new function ()
	{
		var _logined = false;
		var _userInfo;
		var _components = [];
		this.userInfo = function ()
		{
			return _userInfo;
		};
		this.add = function (com)
		{
			_components.push(com);
			if(_userInfo)
			{
				com.onLoginSuccess(_userInfo);
			}
		};
		this.login = function ()
		{
			WB2.login(_checkStatus);
		};
		this.logout = function ()
		{
			WB2.logout(function ()
			{
				_checkStatus();
			});
		};
		function _checkStatus()
		{
			var _status = WB2.checkLogin();
			/*\u767b\u5f55\u4e86\uff0c\u53d6\u5fae\u535a\u4fe1\u606f\uff0c\u901a\u77e5\u5404\u6a21\u5757\u767b\u9646\u6210\u529f*/
			if(!_logined && _status)
			{
				_logined = true;
				WB2.anyWhere(function (W)
				{
					W.parseCMD('/account/get_uid.json',function (uid)
					{
						W.parseCMD('/users/show.json',function (info)
						{
							_userInfo = info;
							for(var i = 0;i < _components.length;i++)
							{
								_components[i].onLoginSuccess(info);
							}
						},
                        {
                        	source: wbAppKey,
                        	uid: uid.uid
                        },{
                        	method: 'get'
                        });
					},{ source: wbAppKey },{ method: 'get' });
				});
				return;
			}
			if(_logined && !_status)
			{
				_logined = false;
				_userInfo = null;
				for(var i = 0;i < _components.length;i++)
				{
					_components[i].onLogoutSuccess();
				}
				return;
			}
		}
		this.init = function ()
		{
			WB2.checkLogin();
			//            _checkStatus();
			//            LoginManager.add(
			//            {
			//                onLogoutSuccess: this.logout.fnBind(this)
			//            });
			setInterval(_checkStatus,100);
		};
	} ();
	var weiboRecommend = new function ()
	{
		var _followers = [];
		var _timer;
		function _scrollUp()
		{
			$('#weiboRecommend .go_down').css('visibility','visible');
			clearInterval(_timer);
			var _outer = $('#weiboRecommend .wrs')[0];
			_outer.scrollTop -= 1;
			_timer = setInterval(function ()
			{
				if(_outer.scrollTop % 71)
				{
					_outer.scrollTop -= 14;
				}
				else
				{
					clearInterval(_timer);
					if(_outer.scrollTop == 0)
					{
						$('#weiboRecommend .go_up').css('visibility','hidden');
					}
				}
			},30);
		}
		function _scrollDown()
		{
			$('#weiboRecommend .go_up').css('visibility','visible');
			clearInterval(_timer);
			var _outer = $('#weiboRecommend .wrs')[0];
			_outer.scrollTop += 1;
			_timer = setInterval(function ()
			{
				if(_outer.scrollTop % 71)
				{
					_outer.scrollTop += 14;
				}
				else
				{
					clearInterval(_timer);
					if(_outer.scrollTop == _outer.scrollHeight - $(_outer).height())
					{
						$('#weiboRecommend .go_down').css('visibility','hidden');
					}
				}
			},30);

		}
		function _checkStatus()
		{
			if(weiboLoginManager.userInfo())
			{
				for(var i = 0;i < _followers.length;i++)
				{
					_followers[i].getStatus();
				}
			}
			else
			{
				for(var i = 0;i < _followers.length;i++)
				{
					_followers[i].hasNotFollow();
				}
			}
		}
		function _createDom()
		{
			var _wrs = $('#weiboRecommend .wrs').empty();
			var _wr,_wr_head,_a,_img,_wr_details,_p,_a2,_v,_vr,_p3,_btn;
			var _single;
			for(var i = 0;i < recommendList.length;i++)
			{
				_single = recommendList[i];
				_wr = $('<div>').addClass('wr');
				_wr.mouseenter(_getWb.bindArg(_single.sso_uid)).mouseleave(_remove);
				_wr_head = $('<div>').addClass('wr_head').appendTo(_wr);
				_a = $('<a>').attr('href','http://weibo.com/u/' + _single.sso_uid).attr('target','_blank').appendTo(_wr_head);
				_img = $('<img>').attr('width','50').attr('height','50').attr('src',_single.avatar_url).appendTo(_a);
				_wr_details = $('<div>').addClass('wr_details').appendTo(_wr);
				_p = $('<p>').appendTo(_wr_details);
				_a2 = $('<a>').attr('href','http://weibo.com/u/' + _single.sso_uid).attr('target','_blank').html(_single.nick).appendTo(_p);
				if(_single.verified_type !== '' && _single.verified_reason)
				{
					_v = $('<img>').attr('src','http://www.sinaimg.cn/cj/realstock/2012/images/transparent.gif').addClass(_single.verified_type == '0' ? 'vip' : 'vip_c').appendTo(_a2);
				}
				_vr = $('<p>').html('&nbsp;').appendTo(_wr_details);
				if(_single.verified_type !== '' && _single.verified_reason)
				{
					_vr.html(_single.verified_reason).attr('title',_single.verified_reason);
				}
				else
				{
					_vr.css('height','10px');
				}
				_p3 = $('<p>').appendTo(_wr_details);
				_btn = $('<a>').attr('href','javascript:void(0)').addClass('add_follow').html('\u52a0\u5173\u6ce8').appendTo(_p3);
				_followers.push(new Follower(_btn[0],_single.sso_uid,'add_follow','added_follow','\u52a0\u5173\u6ce8','\u5df2\u5173\u6ce8'));
				_wrs.append(_wr);
			}
		}
		var _removeTimer;
		function _remove(immediately)
		{
			clearTimeout(_removeTimer);
			function _remove()
			{
				$('#weiboRecommend').find('.wb_review').remove();
			}
			if(immediately === true)
			{
				_remove();
			}
			else
			{
				_removeTimer = setTimeout(_remove,200);
			}
		}
		var _requestIndex = 0;
		function _getWb(uid)
		{
			_requestIndex++;
			_remove(true);
			window['gotWb' + uid] = _gotWb.bindArg(_requestIndex,$(this).offset().top + 60);
			getScript('http://api.sina.com.cn/weibo/users/show.json?source=' + wbAppKey + '&user_id=' + uid + '&callback=gotWb' + uid);
		}
		function _gotWb(argRequestIndex,top,data)
		{
			if(argRequestIndex != _requestIndex)
			{
				return;
			}
			data = data.result.data;
			var _review = $('<div>').addClass('wb_review a_blue_l_all').appendTo('#weiboRecommend').css('top',top + 'px').mouseenter(function () { clearTimeout(_removeTimer); }).mouseleave(_remove.bindArg(true));
			$('<div>').addClass('top_arr').appendTo(_review);
			var _cont = $('<div>').addClass('cont').appendTo(_review);
			var _time = $('<a>').attr('target','_blank').attr('href','http://weibo.com/' + data.id + '/' + data.status.mid_base62).html(_regTime(data.status.created_at.replace('+',/ie/i.test(navigator.userAgent) ? 'UTC +' : '+'))).appendTo(_cont);
			_cont.append(' ' + data.status.text.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/@([0-9a-zA-Z\u4e00-\u9fa5_-]+)/g,function ($1,$2)
			{
				return '<a target="_blank" href="http://weibo.com/n/' + $2 + '">@' + $2 + '</a>';
			}).replace(/#(.*?)#/g,function ($1,$2)
			{
				return '<a target="_blank" href="http://s.weibo.com/weibo/' + $2 + '">#' + $2 + '#</a>';
			}).replace(/http\:\/\/t.cn\/[a-zA-Z0-9]+/g,function ($1)
			{
				return '<a target="_blank" href="' + $1 + '">' + $1 + '</a>';
			}));
		}
		function _init()
		{
			getScript('http://f2.bar.sina.com.cn/?s=weibo&order=enforce&a=get_weibo_account&callback=var recommendList=&symbol=' + 'sh000001',function ()
			{
				_createDom();
				var _container = $('#weiboRecommend');
				if(recommendList.length > 6)
				{
					_container.find('.go_up').click(_scrollUp);
					_container.find('.go_down').click(_scrollDown);
				}
				else
				{
					_container.find('.go_down').css('visibility','hidden');
				}
				_checkStatus();
			});
		}
		this.init = function ()
		{
			_init();

			weiboLoginManager.add(
            {
            	onLoginSuccess: _checkStatus,
            	onLogoutSuccess: _checkStatus
            });
		}
	} ();

	function _regTime(argT)
	{
		var _postTime = new Date(argT);
		var _now = clock.time();
		var _differ = Math.round((_now - _postTime) / 1000);
		var _showTime;
		if(_differ <= 0)
		{
			_differ = 1;
		}
		if(_differ < 60)
		{
			_showTime = _differ + '\u79d2\u524d';
		}
		else if(_differ < 3600)
		{
			_showTime = Math.floor(_differ / 60) + '\u5206\u949f\u524d';
		}
		else if(_now.getDate() == _postTime.getDate())
		{
			_showTime = '\u4eca\u5929 ' + _postTime.getHours().preFull() + ':' + _postTime.getMinutes().preFull();
		}
		else
		{
			_showTime = (_postTime.getMonth() + 1).preFull() + '\u6708' + _postTime.getDate().preFull() + '\u65e5 ' + _postTime.getHours().preFull() + ':' + _postTime.getMinutes().preFull();
		}
		return _showTime;
	}
	var stockAsk = new function ()
	{

		function _regTime(argT)
		{
			var _postTime = new Date(argT.replace(/\-/g,'/'));
			var _now = clock.time();
			var _differ = Math.round((_now - _postTime) / 1000);
			var _showTime;
			if(_differ <= 0)
			{
				_differ = 1;
			}
			if(_differ < 60)
			{
				_showTime = _differ + '\u79d2\u524d';
			}
			else if(_differ < 3600)
			{
				_showTime = Math.floor(_differ / 60) + '\u5206\u949f\u524d';
			}
			else if(_now.getDate() == _postTime.getDate())
			{
				_showTime = _postTime.getHours().preFull() + ':' + _postTime.getMinutes().preFull();
			}
			else
			{
				_showTime = (_postTime.getMonth() + 1).preFull() + '\u6708' + _postTime.getDate().preFull() + '\u65e5 ';
			}
			return _showTime;
		}
		function _getData()
		{
			var url = 'http://news.sinajs.cn/name=lcs_stock_cn&list=lcs2_stock_cn&maxcnt=20&scnt=20';
			if (papercode == 'sh000001') {
				url = 'http://news.sinajs.cn/list=lcs2_sh000001&maxcnt=20&scnt=20';
			}
			getScript(url, _gotData);
		}
		function _gotData()
		{
			var container = $('#makeSweet').empty();
			var _single, _div,_cont,_info, _name, _time, _from;
			var _arrList = window.finance_news || window.lcs_stock_cn;
			for(var i = 0; i < _arrList.length; i++)
			{
				_single = _arrList[i];
				_single[5] = _single[5].split('|||');
				_div = $('<div>').addClass('r_lcs_pt');
				_cont = $('<div>').addClass('r_lcs_pt_cont').appendTo(_div);
				_name = $('<a>').attr('href', 'http://licaishi.sina.com.cn/web/plannerInfo?p_uid=' + _single[5][0] + '&fr=f_stock_cn').attr('target', '_blank').text(_single[5][1]).attr('title',_single[5][1]).addClass('r_lcs_pt_name').appendTo(_cont);
				_cont.append('\uff1a');
				$('<a>').text(_single[2]).attr('target', '_blank').attr('href', _single[3] + '&fr=f_stock_cn').addClass('r_lcs_pt_title').appendTo(_cont);

				_info = $('<div>').addClass('r_lcs_pt_info clearfix').appendTo(_div);
				_time = $('<span>').addClass('r_lcs_pt_time').html(_regTime(_single[0])).appendTo(_info);
				_from = $('<span>').addClass('r_lcs_pt_from').appendTo(_info);
				$('<span>').addClass('r_lcs_pt_from_t').html('\u6765\u81ea').appendTo(_from);
				$('<a>').attr('target', '_blank').attr('href', 'http://licaishi.sina.com.cn/web/packageInfo?pkg_id=' + _single[5][3] + '&fr=f_stock_cn').text(_single[5][4]).attr('title',_single[5][4]).addClass('r_lcs_pt_pkg').appendTo(_from);

				container.append(_div);
			}
		}
		this.init = function ()
		{
			_getData();
		};
	} ();

	/*\u4e2a\u80a1\u6da8\u5e45\u699c*/
	var stockChangePRanking = new function ()
	{
		/*sort_up\u662f\u4ece\u8d1f\u5f80\u6b63\u6570\uff0c\u6240\u4ee5\u662f\u8dcc\u5e45\u6392\u884c\uff0c\u5bf9\u5e94hq\u662fdown\uff0c\u53cd\u7740\u7684\uff0c\u4ee5\u7bad\u5934\u65b9\u5411\u4e3a\u57fa\u51c6*/
		var _sort = 'down';
		var _drawer;
		var _max = 10;
		this.init = function ()
		{
			_drawer = new DataDrawer('stockRanking');

			$('#stockRanking').click(function (ev)
			{
				ev = ev || window.event;
				var _tag = ev.target || ev.srcElement;
				if(_tag.id == 'stockRankingSortBtn')
				{
					_doSort();
				}
				//return false;
			});
			_getData();
			setInterval(function ()
			{
				if(checkDayTime())
				{
					_getData();
				}
			},5 * 1000);
		};
		function _doSort()
		{
			if(_sort == 'up')
			{
				_sort = 'down';
			}
			else
			{
				_sort = 'up';
			}
			_getData();
		}
		function _getData()
		{
			loadScript(hqURL_txt.replace('$rn',random()) + 'new_all_changepercent_' + { up: 'down',down: 'up'}[_sort],_gotData);
		}
		function _gotData()
		{
			var _data = window['new_all_changepercent_' + { up: 'down',down: 'up'}[_sort]];
			var _ds = [];
			var _d;
			_ds.sort = _sort;
			_ds.sort_word = { up: '\u6da8\u8dcc\u5e45',down: '\u6da8\u8dcc\u5e45'}[_sort];
			for(var i = 0;i < _data.length && i < _max;i++)
			{
				_d = {};
				_d.row_num = i % 2;
				_d.symbol = _data[i][0];
				_d.name = _data[i][1];
				_d.now = _data[i][2];
				_d.changeP = _data[i][3];
				if(isSHB(_d.symbol))
				{
					_d.fieldsImportant = { now: { digit: 3} };
				}
				_ds.push(_d);
			}
			_drawer.draw(_ds);
		}
	} ();

	/*\u677f\u5757\u6da8\u5e45\u699c*/
	var plateRanking = new function ()
	{
		/*sort_up\u662f\u4ece\u8d1f\u5f80\u6b63\u6570\uff0c\u6240\u4ee5\u662f\u8dcc\u5e45\u6392\u884c\uff0c\u5bf9\u5e94hq\u662fdown\uff0c\u53cd\u7740\u7684\uff0c\u4ee5\u7bad\u5934\u65b9\u5411\u4e3a\u57fa\u51c6*/
		var _sort = 'down';
		var _drawer;
		var _max = 5;
		this.init = function ()
		{
			_drawer = new DataDrawer('plateRanking');

			$('#plateRanking').click(function (ev)
			{
				ev = ev || window.event;
				var _tag = ev.target || ev.srcElement;
				if(_tag.id == 'plareRankingSortBtn')
				{
					_doSort();
				}
				//return false;
			});
			_getData();
			setInterval(function ()
			{
				if(checkDayTime())
				{
					_getData();
				}
			},30 * 1000);
		};
		function _doSort()
		{
			if(_sort == 'up')
			{
				_sort = 'down';
			}
			else
			{
				_sort = 'up';
			}
			_getData();
		}
		function _getData()
		{
			loadScript(hqURL_txt.replace('$rn',random()) + 'sinaindustry_' + { up: 'down',down: 'up'}[_sort],_gotData);
		}
		function _gotData()
		{
			var _data = window['sinaindustry_' + { up: 'down',down: 'up'}[_sort]];
			var _ds = [];
			var _d;
			_ds.sort = _sort;
			_ds.sort_word = { up: '\u8dcc',down: '\u6da8'}[_sort];
			for(var i = 0;i < _data.length && i < _max;i++)
			{
				_data[i] = _data[i].split(',');
				_d = {};
				_d.row_num = i % 2;
				_d.pSymbol = _data[i][0];
				_d.pName = _data[i][1];
				_d.changeP = _data[i][5];
				_d.symbol = _data[i][8];
				_d.name = _data[i][12];
				_d.now = _data[i][10];
				//                _d.changeP = _data[i][9];
				_ds.push(_d);
			}
			_drawer.draw(_ds);
		}
	} ();

	/*\u677f\u5757\u8d44\u91d1\u6d41\u5411*/
	var plateFlow = new function ()
	{
		/*sort_up\u662f\u4ece\u8d1f\u5f80\u6b63\u6570\uff0c\u6240\u4ee5\u662f\u8dcc\u5e45\u6392\u884c\uff0c\u5bf9\u5e94hq\u662fdown\uff0c\u53cd\u7740\u7684\uff0c\u4ee5\u7bad\u5934\u65b9\u5411\u4e3a\u57fa\u51c6*/
		/*up1,down0*/
		var _sort = 'down';
		/*\u6392\u5e8f\u5b57\u6bb5*/
		var _sortKey = 'ratioamount';
		var _drawer;
		var _max = 5;
		this.init = function ()
		{
			_drawer = new DataDrawer('plateFlow',{ ratioamount: { key: 'ratioamount',digit: 2,cfg: 4,p: '$1%'} });

			$('#plateFlow').click(function (ev)
			{
				ev = ev || window.event;
				var _tag = ev.target || ev.srcElement;
				if(_tag.id == 'plateFlowSortP')
				{
					_doSort('ratioamount');
				}
				if(_tag.id == 'plateFlowSortA')
				{
					_doSort('netamount');
				}
				//return false;
			});
			_getData();
			setInterval(_getData,60 * 2 * 1000);
		};
		function _doSort(argKey)
		{
			if(argKey && argKey != _sortKey)
			{
				_sortKey = argKey;
			}
			else
			{
				if(_sort == 'up')
				{
					_sort = 'down';
				}
				else
				{
					_sort = 'up';
				}
			}
			setTimeout(_getData,1);
			//_getData();
		}
		function _getData()
		{
			getScript('http://vip.stock.finance.sina.com.cn/quotes_service/api/jsonp_v2.php/var plateFlowData=/MoneyFlow.ssl_bkzj_bk?page=1&num=5&sort=$sortKey&asc=$asc&fenlei=0'.replace('$sortKey',_sortKey).replace('$asc',{ up: '1',down: '0'}[_sort]),_gotData);
		}
		function _gotData()
		{
			var _data = window['plateFlowData'] || [];
			var _ds = [];
			var _d;
			/*ie6class\u4e3a\u7a7a\u65f6\u6709bug\uff0c\u586b\u4e2a\u7ad9\u4f4d\u7528\u7684*/
			_ds.sort_r = _sortKey == 'ratioamount' ? 'sort_' + _sort : 'no_class';
			_ds.sort_a = _sortKey == 'netamount' ? 'sort_' + _sort : 'no_class';
			for(var i = 0;i < _data.length && i < _max;i++)
			{
				_d = {};
				_d.row_num = i % 2;
				_d.pSymbol = _data[i].category;
				_d.pName = _data[i].name;
				_d.netamount = _data[i].netamount;
				_d.ratioamount = _data[i].ratioamount * 100;
				_ds.push(_d);
			}
			_drawer.draw(_ds);
		}
	} ();

	/*\u80a1\u5e02\u6982\u51b5*/
	var hsUD = window.hsUD = new function ()
	{
		var _symbols = ['sh000002','sz399107','sh000003','sz399108','sz399102'];
		this.init = function ()
		{
			_getData();
			setInterval(function ()
			{
				if(checkDayTime())
				{
					_getData();
				}
			},5 * 1000);
		};
		function _getData()
		{
			loadScript(hqURL.replace('$rn',random()) + _symbols.join('_zdp,') + '_zdp',_gotData);
		}
		function _gotData()
		{
			for(var i = 0;i < _symbols.length;i++)
			{
				/*\u5982\u679c\u662fB\u80a1\uff0c\u9700\u8981\u5408\u5e76\u5355\u72ec\u5904\u7406*/
				if(_symbols[i] == 'sh000003' || _symbols[i] == 'sz399108')
				{
					continue;
				}
				new _UD(_symbols[i]).draw();
			}
			_gotDataB();
		}
		function _gotDataB()
		{
			var _data1 = window['hq_str_sh000003_zdp'];
			var _data2 = window['hq_str_sz399108_zdp'];
			var _data = [];
			if(!_data1 && !_data2)
			{
				return;
			}
			_data1 = _data1.split(',');
			_data2 = _data2.split(',');

			_data[0] = parseInt(_data1[0]) + parseInt(_data2[0]);
			_data[1] = parseInt(_data1[1]) + parseInt(_data2[1]);
			_data[2] = parseInt(_data1[2]) + parseInt(_data2[2]);
			window['hq_str_sh000003sz399108_zdp'] = _data.join(',');
			new _UD('sh000003sz399108').draw();
		}
		function _UD(symbol)
		{
			this.symbol = symbol;
		}
		_UD.prototype.draw = function ()
		{
			var _data = window['hq_str_' + this.symbol + '_zdp'];
			if(!_data)
			{
				return;
			}
			_data = _data.split(',');
			var _total = _data[0] * 1 + _data[1] * 1 + _data[2] * 1;
			var _container = $('#ud' + this.symbol);
			var _w0,_w1,_w2;
			/*\u8ba1\u7b97\u6700\u5c0f\u5bbd\u5ea6*/
			function _checkMin(w,n)
			{
				var _min = (n + '').length * 8;
				if(w < _min)
				{
					w = _min;
				}
				return w;
			}
			_w0 = _checkMin(170 * _data[0] / _total,_data[0]);
			_w1 = _checkMin(170 * _data[2] / _total,_data[2]);
			_w2 = 170 - _w0 - _w1;
			var _w2T = _checkMin(_w2,_data[1]);
			/*\u5982\u679c\u7b2c\u4e09\u4e2a\u4e0d\u591f\u5bbd\u4e86\uff0c\u5c31\u4ece\u524d\u4e24\u4e2a\u5bbd\u7684\u90a3\u4e2a\u53d6\u51e0\u4e2a\u50cf\u7d20\u51fa\u6765*/
			if(_w2 < _w2T)
			{
				if(_w0 > _w1)
				{
					_w0 -= _w2T - _w2 + 1;
				}
				else
				{
					_w1 -= _w2T - _w2 + 1;
				}
			}

			_container.find('.hs_up').html(_data[0]).css('width',_w0 + 'px');
			_container.find('.hs_flat').html(_data[2]).css('width',_w1 + 'px');
			_container.find('.hs_down').html(_data[1]);
		}
	} ();

	var visitedAndPort = window.visitedAndPort = new function ()
	{
		var _cookieKey = 'FINA_V_S_2';
		var _cookieCfg = { path: '/',domain: 'finance.sina.com.cn',expires: '365' };
		var _maxVisited = 20;
		var _max = 12;
		var _showHot = true;
		var _portInited = false;
		var _showingPort = false;
		var _visitedList = [];
		var _hotList = [];
		var _portList = [];
		/*1\u4e3a\u5012\u6392\uff0c-1\u6b63\u6392\uff0c0\u4e0d\u6392*/
		var _asc = 0;
		var _hasLogin = false;
		this.init = function ()
		{
			_buildVisited();
			_getData();
			setInterval(function ()
			{
				/*\u5468\u4e00\u5230\u5468\u4e948\u70b9\u523016\u70b9\u5237\u65b0*/
				if(checkDayTime())
				{
					_getData();
				}
			},5 * 1000);

			//            $('#portLogoutBtn').click(weiboLoginManager.logout.fnBind(weiboLoginManager));
			LoginManager.add(
            {
            	logoutBtn: 'portLogoutBtn',
            	/*\u767b\u5f55\u5207\u6362\u81ea\u9009\u80a1\u72b6\u6001*/
            	onLoginSuccess: function (user)
            	{
            		_hasLogin = true;
            		$('#portLoginFalse').hide();
            		$('#portLoginTrue').show();
            		/*\u5982\u679c\u6b63\u5728\u81ea\u9009\u80a1\u9875\u7b7e\u4e2d\uff0c\u76f4\u63a5\u521d\u59cb\u5316*/
            		if(_showingPort)
            		{
            			_buildPort();
            			_showingPort = true;
            		}
            		$('#portNick').html(user.nick).attr('title',user.nick);
            	},
            	onUserChanged: function (user)
            	{
            		if(_portInited)
            		{
            			_buildPort();
            			$('#portNick').html(user.nick).attr('title',user.nick);
            		}
            	},
            	/*\u9000\u51fa\u5207\u6362\u72b6\u6001\uff0c\u5e76\u5220\u9664\u6240\u6709\u81ea\u9009\u80a1DOM*/
            	onLogoutSuccess: function ()
            	{
            		_hasLogin = false;
            		_portInited = false;
            		$('#portLoginFalse').show();
            		$('#portLoginTrue').hide();
            		while(_portList.length)
            		{
            			_portList.pop().release();
            		}
            	}
            });

			loginLayer.addOpener('port_show_login');

			$('#sortBtnV').click(_doSort);
			$('#sortBtnP').click(_doSort);
			var _tabCont = new TabCont('tcVP','mouseenter',function (argIndex)
			{
				/*\u5982\u679c\u4e4b\u524d\u5c31\u662f\u8fd9\u4e2a\u7b7e\uff0c\u4e0d\u64cd\u4f5c*/
				if(!_showingPort ^ argIndex)
				{
					return;
				}
				/*\u5982\u679c\u9009\u7684\u662f\u81ea\u9009\u80a1\uff0c\u5e76\u4e14\u81ea\u9009\u80a1\u6ca1\u6709\u521d\u59cb\u5316\uff0c\u4e5f\u767b\u9646\u4e86\uff0c\u5c31\u521d\u59cb\u5316\u81ea\u9009\u80a1*/
				/*\u81ea\u9009\u80a1\u521d\u59cb\u5316\u6807\u5fd7\u7acb\u5373\u4fee\u6539\uff0c\u4e0d\u505a\u521d\u59cb\u5316\u5931\u8d25\u51c6\u5907*/
				if(argIndex == 1 && !_portInited && _hasLogin)
				{
					_buildPort();
					_portInited = true;
				}
				/*\u628a\u5f53\u524d\u663e\u793a\u72b6\u6001\u5207\u6362*/
				_showingPort = !!argIndex;
				/*\u52a0\u8f7d\u6570\u636e\u3002\u81ea\u9009\u6ca1\u521d\u59cb\u5316\u65f6portList\u4e3a\u7a7a\uff0c\u4e0d\u4f1a\u53d1\u8bf7\u6c42*/
				_getData(true);
				return false;
			});

		}
		function _getData(immediately)
		{
			var _list = [];
			/*\u663e\u793a\u7684\u662f\u81ea\u9009\u7684\u8bdd\u53d6\u81ea\u9009\u5217\u8868*/
			if(_showingPort)
			{
				for(var i = 0,il = _portList.length;i < il;i++)
				{
					_list.push(_portList[i].symbol);
				}
			}
			/*\u5426\u5219\u628a\u6700\u8fd1\u8bbf\u95ee\u80a1\u548c\u70ed\u80a1\u53d6\u4e86*/
			else
			{
				for(var i = 0,il = _visitedList.length;i < il;i++)
				{
					_list.push(_visitedList[i].symbol);
				}

				for(var i = 0,il = _hotList.length;i < il;i++)
				{
					_list.push(_hotList[i].symbol);
				}
			}
			/*\u6ca1\u6709\u5217\u8868\u7684\u8bdd\u4e0d\u8bf7\u6c42\u6570\u636e*/
			if(_list.length)
			{
				loadScript(hqURL.replace('$rn',random()) + 's_' + _list.join(',s_'),_gotData,immediately);
			}
			return false;
		}
		function _gotData()
		{
			var _stockList = [];
			if(_showingPort)
			{
				_stockList = _portList.slice(0);
			}
			else
			{
				_stockList = _visitedList.slice(0).concat(_hotList.slice(0));
			}
			/*\u4e0d\u9700\u8981\u533a\u5206\u5f53\u524d\u80a1\u7968\u5217\u8868\u662f\u5426\u8fd8\u662f\u8fd9\u4e2a\u8bf7\u6c42\u7684\uff0c\u6709\u884c\u60c5\u5c31\u663e\u793a\uff0c\u6ca1\u6709\u5c31\u8df3\u8fc7*/
			for(var i = 0,il = _stockList.length;i < il;i++)
			{
				var _hq_str = window['hq_str_s_' + _stockList[i].symbol];
				if(!_hq_str)
				{
					continue;
				}
				_hq_str = _hq_str.split(',');
				var _data = {};
				_data.name = _hq_str[0] || _stockList[i].symbol;
				_data.now = _hq_str[1] * 1 ? _hq_str[1].toFixed(isSHB(_stockList[i].symbol) ? 3 : 2) : '--';
				_data.changeP = _hq_str[1] * 1 ? _hq_str[3] + '%' : '--';
				_stockList[i].draw(_data);
			}
			_doSort();
		}
		/*\u6392\u5e8f\u3002\u4f7f\u7528\u5171\u540c\u7684\u6392\u5e8f\u65b9\u5f0f\u3002\u4f20\u5165\u53c2\u6570\u624d\u6539\u53d8\u6392\u5e8f\u72b6\u6001\u3002\u70b9\u51fb\u65f6this\u548c\u53c2\u6570\u76f4\u63a5\u4f1a\u81ea\u52a8\u4f20\u5165*/
		function _doSort(argDo)
		{
			var _sortList = [];
			if(argDo)
			{
				_asc++;
				if(_asc > 1)
				{
					_asc = -1;
				}
			}
			if(_showingPort)
			{
				_sortList = _portList.slice(0);
				$id('sortBtnP').className = { '1': 'sort_down','0': '','-1': 'sort_up'}[_asc];
			}
			else
			{
				_sortList = _visitedList.slice(0);
				$id('sortBtnV').className = { '1': 'sort_down','0': '','-1': 'sort_up'}[_asc];
			}
			if(_asc)
			{
				_sortList.sort(function ($1,$2)
				{
					var _data1 = window['hq_str_s_' + $1.symbol];
					/*\u6ca1\u884c\u60c5\u6216\u8005\u5f53\u524d\u4ef7\u4f4d0\u90fd\u6392\u5230\u6700\u540e\u53bb*/
					if(_data1)
					{
						if(!(_data1.split(',')[1] * 1))
						{
							return 1;
						}
						_data1 = parseFloat(_data1.split(',')[3]);
					}
					else
					{
						return 1;
					}
					var _data2 = window['hq_str_s_' + $2.symbol];
					if(_data2)
					{
						if(!(_data2.split(',')[1] * 1))
						{
							return -1;
						}
						_data2 = parseFloat(_data2.split(',')[3]);
					}
					else
					{
						return -1;
					}
					return (_data2 - _data1) * _asc;
				});
			}
			for(var i = 0,il = _sortList.length;i < il;i++)
			{
				_sortList[i].tr.parentNode.appendChild(_sortList[i].tr);
				_sortList[i].tr.className = 'row_' + i % 2;
			}
		}
		/*\u521b\u5efa\u6700\u8fd1\u8bbf\u95ee\u80a1\u3001\u70ed\u80a1DOM*/
		function _buildVisited()
		{
			/*\u5148\u5c1d\u8bd5\u6e05\u7a7a*/
			while(_visitedList.length)
			{
				_visitedList.pop().release();
			}
			while(_hotList.length)
			{
				_hotList.pop().release();
			}
			/*\u521b\u5efa\u6700\u8fd1\u8bbf\u95ee\u80a1*/
			var _tbody = $id('tbodyVisited');
			var _visited = Cookie.get(_cookieKey);
			/*\u8bfb\u53d6\u5e76\u8bbe\u7f6e\u4e00\u4e0bcookie\uff0c\u5254\u9664\u5f53\u524d\u9875\u80a1\u7968*/
			_visited = _visited + ',';
			_visited = _visited.replace(papercode + ',','');
			_visited = _visited.replace(/,$/,'');
			_visited = _visited.split(',');
			var _stock;
			var _v = [];
			for(var i = 0;i < _visited.length;i++)
			{
				if(/^s[hz]\d{6}$/.test(_visited[i]))
				{
					_stock = new _Stock(_visited[i],_delVisited);
					_stock.tr.className = 'row_' + _visitedList.length % 2;
					_tbody.appendChild(_stock.tr);
					_visitedList.push(_stock);
					_v.push(_visited[i]);
					if(_v.length >= _maxVisited - 1)
					{
						break;
					}
				}
			}
			_v.unshift(papercode)
			_v = _v.join(',');
			Cookie.set(_cookieKey,_v,_cookieCfg);
			/*\u9a8c\u8bc1\u4e00\u6b21\u662f\u5426\u663e\u793a\u70ed\u80a1*/
			_checkShowHot();
			/*\u521b\u5efa\u70ed\u80a1*/
			var _tbody = $id('tbodyHot');
			var _stock;
			for(var i = 0,il = hotstock_daily_a.length;_hotList.length <= _max && i < il;i++)
			{
				if(/^s[hz]\d{6}$/.test(hotstock_daily_a[i][0]) && _v.indexOf(hotstock_daily_a[i][0]) == -1)
				{
					_stock = new _Stock(hotstock_daily_a[i][0],null,true);
					_stock.tr.className = 'row_' + _hotList.length % 2;
					_tbody.appendChild(_stock.tr);
					_hotList.push(_stock);
				}
			}
		}
		function _checkShowHot()
		{
			if(_visitedList.length >= _max - 1)
			{
				$('#tbodyHot').hide();
				_showHot = false;
			}
			else
			{
				$('#tbodyHot').show();
				_showHot = true;
			}
		}
		function _buildPort()
		{
			//            getScript('http://vip.stock.finance.sina.com.cn/portfolio/web/api/jsonp.php/var _myPort=/FinanceUserService.getZXByNC?type=stock&rn=' + random(),function ()
			getScript('http://stock.finance.sina.com.cn/portfolio/api/openapi.php/PortfolioInterfaceService.getPyListFace?type=cn&one=first&format=json&callback=var _myPort=&rn=' + random(),function ()
			{
				while(_portList.length)
				{
					_portList.pop().release();
				}
				$('#tbodyPort').empty();
				var _stock;
				var _tbody = $id('tbodyPort');
				_myPort = _myPort.result.data[0].symbols;
				for(var i = 0;i < _myPort.length;i++)
				{
					if(/s[hz]\d{6}/.test(_myPort[i]))
					{
						_stock = new _Stock(_myPort[i],null,true);
						_stock.tr.className = 'row_' + _portList.length % 2;
						_tbody.appendChild(_stock.tr);
						_portList.push(_stock);
					}
				}
				if(!_myPort.length)
				{
					_tr = $C('tr');
					_th = $C('th');
					_th.style.lineHeight = '140px';
					_th.style.textAlign = 'center';
					$(_th).attr('colspan','3');
					_th.innerHTML = '<a href="http://vip.stock.finance.sina.com.cn/portfolio/main.php" target="_blank" class="a_blue_d_all">\u5c1a\u672a\u6dfb\u52a0\u81ea\u9009\uff0c\u70b9\u51fb\u8fdb\u5165..</a>';
					_tr.appendChild(_th);
					_tbody.appendChild(_tr);
				}
				_getData(true);
			});
		}
		/*\u5220\u9664\u6700\u8fd1\u8bbf\u95ee\u80a1*/
		function _delVisited(argSymbol)
		{
			var _visited = Cookie.get(_cookieKey) + ',';
			_visited = _visited.replace(argSymbol + ',','');
			_visited = _visited.replace(/,$/,'');
			Cookie.set(_cookieKey,_visited,_cookieCfg);
			for(var i = _visitedList.length - 1;i >= 0;i--)
			{
				if(_visitedList[i].symbol == argSymbol)
				{
					_visitedList.splice(i,1);
				}
			}
			_checkShowHot();
			_doSort();
		}

		/*\u80a1\u7968\u7c7b*/
		function _Stock(symbol,onDelete,noDel)
		{
			this.symbol = symbol;
			this.dataObj = {};
			this.tr;
			this.onDelete = onDelete;
			this.noDel = noDel || false;
			this.createDom();
		}
		merge(_Stock.prototype,
        {
        	/*\u521b\u5efa\u5143\u7d20*/
        	createDom: function ()
        	{
        		this.tr = $C('tr');
        		var _th = $C('th');
        		this.tr.appendChild(_th);
        		var _a = $C('a');
        		_a.href = pageURL.replace('$symbol',this.symbol);
        		_a.innerHTML = this.symbol;
        		_th.appendChild(_a);
        		this.dataObj.nameLink = _a;

        		var _td = $C('td');
        		_td.innerHTML = '--';
        		this.tr.appendChild(_td);
        		this.dataObj.now = _td;

        		_td = $C('td');
        		this.dataObj.changePTd = _td;
        		this.tr.appendChild(_td);
        		var _span = $C('span');
        		_span.innerHTML = '--';
        		this.dataObj.changeP = _span;
        		_td.appendChild(_span);
        		if(!this.noDel)
        		{
        			var _em = $C('em');
        			_td.appendChild(_em);
        			this.dataObj.del = _em;
        		}

        		this.addEvent();
        	},
        	addEvent: function ()
        	{
        		if(!this.noDel)
        		{
        			var _tr = $(this.tr);
        			_tr.mouseenter(this.showDel.fnBind(this)).mouseleave(this.hideDel.fnBind(this));
        			$(this.dataObj.del).click(this.deleteMe.fnBind(this));
        		}
        	},
        	showDel: function ()
        	{
        		this.dataObj.del.style.display = 'inline-block';
        	},
        	hideDel: function ()
        	{
        		this.dataObj.del.style.display = '';
        	},
        	deleteMe: function ()
        	{
        		this.release();
        		if(this.onDelete)
        		{
        			this.onDelete(this.symbol);
        		}
        		return false;
        	},
        	release: function ()
        	{
        		$(this.tr).remove();
        		this.dataObj = {};
        		this.tr = undefined;
        	},
        	draw: function (argData)
        	{
        		this.dataObj.nameLink.innerHTML = argData.name;
        		this.dataObj.now.innerHTML = argData.now;
        		this.dataObj.changeP.innerHTML = argData.changeP;
        		this.dataObj.changeP.className = checkUD(undefined,parseFloat(argData.changeP));
        	}
        });
	} ();

	var aSummary = new function ()
	{
		var _tabCtrler0;
		var _tabCtrler1;
		var _tabCtrler2;
		var _tabCtrler3;
		this.init = function ()
		{
			var _tabCtrler0 = new TabCtrler();
			var _tabCtrler1 = new TabCtrler();
			var _tabCtrler2 = new TabCtrler();
			var _tabCtrler3 = new TabCtrler();

			/*\u53ef\u4ee5\u5171\u7528\u7684\u5904\u7406\u903b\u8f91*/
			var _processer_hq_ud = dataProcesser.bindArg({ symbol: 0,name: 1,changeP: 3,now: 2 });
			var _processer_hq_5min_ud = dataProcesser.bindArg({ symbol: 'symbol',name: 'name',changeP: 'percent' });
			var _processer_flow = dataProcesser.bindArg({ symbol: 'symbol',category: 'category',name: 'name',ratioamount: 'ratioamount',r0_ratio: 'r0_ratio',cnt_r0x_ratio: 'cnt_r0x_ratio' });

			/*\u628a\u6bcf\u5757\u90fd\u6dfb\u52a0\u8fdb\u6765*/
			_tabCtrler0.add(new TabDrawer('as_0_0',hqURL_txt + 'new_all_changepercent_up','new_all_changepercent_up',_processer_hq_ud));
			_tabCtrler0.add(new TabDrawer('as_0_1',hqURL_txt + 'new_all_changepercent_down','new_all_changepercent_down',_processer_hq_ud));
			_tabCtrler0.add(new TabDrawer('as_0_2',hqURL_txt + 'new_all_turnoverrate','new_all_turnoverrate',dataProcesser.bindArg({ symbol: 0,name: 1,turnover: 3 })));
			_tabCtrler0.add(new TabDrawer('as_0_3',hqURL_txt + 'stock_hs_up_5min_20','stock_hs_up_5min_20',_processer_hq_5min_ud));
			_tabCtrler0.add(new TabDrawer('as_0_4',hqURL_txt + 'stock_hs_down_5min_20','stock_hs_down_5min_20',_processer_hq_5min_ud));
			_tabCtrler0.add(new TabDrawer('as_0_5',hqURL_txt + 'stock_all_amount_d_15','stock_all_amount_d_15',dataProcesser.bindArg({ symbol: 0,name: 1,amount: 2 }),{ amount: { key: 'amount',digit: 2,'\u4e07/\u4ebf': true,shift: 4} }));
			_tabCtrler0.add(new TabDrawer('as_0_6',hqURL_txt + 'stock_all_range_d_15','stock_all_range_d_15',dataProcesser.bindArg({ symbol: 0,name: 1,swing: 2 })));
			_tabCtrler0.add(new TabDrawer('as_0_7',hqURL_txt + 'weibi_all','weibi_all',dataProcesser.bindArg({ symbol: 0,name: 1,weibi: 2 }),{ weibi: { key: 'weibi',p: '$1%'} }));
			_tabCtrler0.add(new TabDrawer('as_0_8',hqURL_txt + 'liangbi_all','liangbi_all',dataProcesser.bindArg({ symbol: 0,name: 1,liangbi: 2 }),{ liangbi: { key: 'liangbi'} }));
			new TabCont('as_tc_0','click',_tabCtrler0).show(0);

			_tabCtrler1.add(new TabDrawer('as_1_0','http://vip.stock.finance.sina.com.cn/quotes_service/api/jsonp_v2.php/var as_1_0_data =/MoneyFlow.ssl_bkzj_ssggzj?page=1&num=10&sort=ratioamount&asc=0&bankuai=&shichang=','as_1_0_data',_processer_flow,{ ratioamount: { key: 'ratioamount',shift: 2,digit: 2,cfg: 4,p: '$1%'} }));
			_tabCtrler1.add(new TabDrawer('as_1_1','http://vip.stock.finance.sina.com.cn/quotes_service/api/jsonp_v2.php/var as_1_1_data =/MoneyFlow.ssl_bkzj_ssggzj?page=1&num=10&sort=ratioamount&asc=1&bankuai=&shichang=','as_1_1_data',_processer_flow,{ ratioamount: { key: 'ratioamount',shift: 2,digit: 2,cfg: 4,p: '$1%'} }));
			_tabCtrler1.add(new TabDrawer('as_1_2','http://vip.stock.finance.sina.com.cn/quotes_service/api/jsonp_v2.php/var as_1_2_data =/MoneyFlow.ssl_bkzj_ssggzj?page=1&num=10&sort=r0_ratio&asc=0&bankuai=&shichang=','as_1_2_data',_processer_flow,{ r0_ratio: { key: 'r0_ratio',shift: 2,digit: 2,cfg: 4,p: '$1%'} }));
			_tabCtrler1.add(new TabDrawer('as_1_3','http://vip.stock.finance.sina.com.cn/quotes_service/api/jsonp_v2.php/var as_1_3_data =/MoneyFlow.ssl_bkzj_ssggzj?page=1&num=10&sort=r0_ratio&asc=1&bankuai=&shichang=','as_1_3_data',_processer_flow,{ r0_ratio: { key: 'r0_ratio',shift: 2,digit: 2,cfg: 4,p: '$1%'} }));
			_tabCtrler1.add(new TabDrawer('as_1_4','http://vip.stock.finance.sina.com.cn/quotes_service/api/jsonp_v2.php/var as_1_4_data =/MoneyFlow.ssl_bkzj_lxjlr?page=1&num=10&sort=cnt_r0x_ratio&asc=0&bankuai=','as_1_4_data',_processer_flow,{ cnt_r0x_ratio: { key: 'cnt_r0x_ratio',cfg: 2} }));
			_tabCtrler1.add(new TabDrawer('as_1_5','http://vip.stock.finance.sina.com.cn/quotes_service/api/jsonp_v2.php/var as_1_5_data =/MoneyFlow.ssl_bkzj_lxjlr?page=1&num=10&sort=cnt_r0x_ratio&asc=1&bankuai=','as_1_5_data',_processer_flow,{ cnt_r0x_ratio: { key: 'cnt_r0x_ratio',cfg: 2} }));
			_tabCtrler1.add(new TabDrawer('as_1_6','http://vip.stock.finance.sina.com.cn/quotes_service/api/jsonp_v2.php/var as_1_6_data =/MoneyFlow.ssl_bkzj_bk?page=1&num=10&sort=ratioamount&asc=0&fenlei=0','as_1_6_data',_processer_flow,{ ratioamount: { key: 'ratioamount',shift: 2,digit: 2,cfg: 4,p: '$1%'} }));
			_tabCtrler1.add(new TabDrawer('as_1_7','http://vip.stock.finance.sina.com.cn/quotes_service/api/jsonp_v2.php/var as_1_7_data =/MoneyFlow.ssl_bkzj_bk?page=1&num=10&sort=ratioamount&asc=1&fenlei=0','as_1_7_data',_processer_flow,{ ratioamount: { key: 'ratioamount',shift: 2,digit: 2,cfg: 4,p: '$1%'} }));
			new TabCont('as_tc_1','click',_tabCtrler1).show(0);

			/*\u4e0b\u62c9\u5217\u8868\u5f71\u54cd\u663e\u793a\u5b57\u6bb5\u7684*/
			function _makeField(baseField,key,valueTemplate,selectID,argData)
			{
				var _fields = {};
				for(var p in baseField)
				{
					_fields[p] = baseField[p];
				}
				_fields[key] = valueTemplate.replace('$value',$('#' + selectID).val());
				return dataProcesser(_fields,argData);
			}
			var _baseFieldJdzd = { symbol: 'symbol',name: 'name' };
			_tabCtrler2.add(new TabDrawer('as_2_0',makeURL.bindArg('http://vip.stock.finance.sina.com.cn/quotes_service/api/jsonp_v2.php/var as_2_0_data=/StatisticsService.getShortList?page=1&num=10&sort=_$valuechanges&asc=0','select_dqzfb'),'as_2_0_data',_makeField.bindArg(_baseFieldJdzd,'changeP','_$valuechanges','select_dqzfb'),{ changeP: { key: 'changeP',shift: 2,digit: 2,cfg: 4,p: '$1%'} }));
			_tabCtrler2.add(new TabDrawer('as_2_1',makeURL.bindArg('http://vip.stock.finance.sina.com.cn/quotes_service/api/jsonp_v2.php/var as_2_1_data=/StatisticsService.getShortList?page=1&num=10&sort=_$valuechanges&asc=1','select_dqdfb'),'as_2_1_data',_makeField.bindArg(_baseFieldJdzd,'changeP','_$valuechanges','select_dqdfb'),{ changeP: { key: 'changeP',shift: 2,digit: 2,cfg: 4,p: '$1%'} }));
			_tabCtrler2.add(new TabDrawer('as_2_2',makeURL.bindArg('http://vip.stock.finance.sina.com.cn/quotes_service/api/jsonp_v2.php/var as_2_2_data=/StatisticsService.getLongList?page=1&num=10&sort=_$valuechanges&asc=0','select_cqzfb'),'as_2_2_data',_makeField.bindArg(_baseFieldJdzd,'changeP','_$valuechanges','select_cqzfb'),{ changeP: { key: 'changeP',shift: 2,digit: 2,cfg: 4,p: '$1%'} }));
			_tabCtrler2.add(new TabDrawer('as_2_3',makeURL.bindArg('http://vip.stock.finance.sina.com.cn/quotes_service/api/jsonp_v2.php/var as_2_3_data=/StatisticsService.getLongList?page=1&num=10&sort=_$valuechanges&asc=1','select_cqdfb'),'as_2_3_data',_makeField.bindArg(_baseFieldJdzd,'changeP','_$valuechanges','select_cqdfb'),{ changeP: { key: 'changeP',shift: 2,digit: 2,cfg: 4,p: '$1%'} }));
			_tabCtrler2.add(new TabDrawer('as_2_4','http://vip.stock.finance.sina.com.cn/quotes_service/api/jsonp_v2.php/var as_2_4_data=/StatisticsService.getStockRiseConList?page=1&num=10&sort=day_con&asc=0','as_2_4_data',dataProcesser.bindArg({ symbol: 'symbol',name: 'name',day_con: 'day_con' })));
			_tabCtrler2.add(new TabDrawer('as_2_5','http://vip.stock.finance.sina.com.cn/quotes_service/api/jsonp_v2.php/var as_2_5_data=/StatisticsService.getStockReduceConList?page=1&num=10&sort=day_con&asc=0','as_2_5_data',dataProcesser.bindArg({ symbol: 'symbol',name: 'name',day_con: 'day_con' })));
			_tabCtrler2.add(new TabDrawer('as_2_6','http://vip.stock.finance.sina.com.cn/quotes_service/api/jsonp_v2.php/var as_2_6_data=/StatisticsService.getNewHighList?page=1&num=10&sort=symbol&asc=1','as_2_6_data',dataProcesser.bindArg({ symbol: 'symbol',name: 'name',preClose: 'close' })));
			_tabCtrler2.add(new TabDrawer('as_2_7','http://vip.stock.finance.sina.com.cn/quotes_service/api/jsonp_v2.php/var as_2_7_data=/StatisticsService.getNewLowList?page=1&num=10&sort=symbol&asc=1','as_2_7_data',dataProcesser.bindArg({ symbol: 'symbol',name: 'name',preClose: 'close' })));
			new VSelect('select_dqzfb');
			new VSelect('select_dqdfb');
			new VSelect('select_cqzfb');
			new VSelect('select_cqdfb');
			$('#as_tc_2 select').change(function ()
			{
				_tabCtrler2();
			});
			new TabCont('as_tc_2','click',_tabCtrler2).show(0);

			_tabCtrler3.add(new TabDrawer('as_3_0','http://vip.stock.finance.sina.com.cn/quotes_service/api/jsonp_v2.php/var as_3_0_data=/StatisticsService.getVolumeRiseConList?page=1&num=10&sort=day_con&asc=0','as_3_0_data',dataProcesser.bindArg({ symbol: 'symbol',name: 'name',day_con: 'day_con' })));
			_tabCtrler3.add(new TabDrawer('as_3_1','http://vip.stock.finance.sina.com.cn/quotes_service/api/jsonp_v2.php/var as_3_1_data=/StatisticsService.getVolumeReduceConList?page=1&num=10&sort=day_con&asc=0','as_3_1_data',dataProcesser.bindArg({ symbol: 'symbol',name: 'name',day_con: 'day_con' })));
			_tabCtrler3.add(new TabDrawer('as_3_2','http://vip.stock.finance.sina.com.cn/quotes_service/api/jsonp_v2.php/var as_3_2_data=/StatisticsService.getVolumeRiseList?page=1&num=10&sort=changes_volume_per&asc=0','as_3_2_data',dataProcesser.bindArg({ symbol: 'symbol',name: 'name',changes_volume_per: 'changes_volume_per' }),{ changes_volume_per: { key: 'changes_volume_per',shift: 2,digit: 2,p: '$1%'} }));
			_tabCtrler3.add(new TabDrawer('as_3_3','http://vip.stock.finance.sina.com.cn/quotes_service/api/jsonp_v2.php/var as_3_3_data=/StatisticsService.getVolumeReduceList?page=1&num=10&sort=changes_volume_per&asc=1','as_3_3_data',dataProcesser.bindArg({ symbol: 'symbol',name: 'name',changes_volume_per: 'changes_volume_per' }),{ changes_volume_per: { key: 'changes_volume_per',shift: 2,digit: 2,p: '$1%'} }));
			new TabCont('as_tc_3','click',_tabCtrler3).show(0);

			/*hq\u76845\u79d2\u4e00\u5237*/
			setInterval(function ()
			{
				if(checkDayTime())
				{
					/*\u53ea\u6709\u884c\u60c5\u533a\u57df\u663e\u793a\u65f6\u624d\u5237\u65b0\u6570\u636e*/
					var vt = window.pageYOffset || document.body.scrollTop || document.documentElement.scrollTop;
					var vb = vt + Math.min(document.documentElement.clientHeight,document.body.clientHeight) + 100;
					var _top = $('#as_tc_0').offset().top;
					if(vb >= _top)
					{
						_tabCtrler0();
					}
				}
			},5 * 1000);

			/*php\u76842\u5206\u949f\u4e00\u5237*/
			setInterval(function ()
			{
				if(checkDayTime())
				{
					/*\u53ea\u6709\u884c\u60c5\u533a\u57df\u663e\u793a\u65f6\u624d\u5237\u65b0\u6570\u636e*/
					var vt = window.pageYOffset || document.body.scrollTop || document.documentElement.scrollTop;
					var vb = vt + Math.min(document.documentElement.clientHeight,document.body.clientHeight) + 100;
					var _top = $('#as_tc_1').offset().top;
					if(vb >= _top)
					{
						_tabCtrler1();
					}
				}
			},60 * 2 * 1000);
		};
		/*\u6570\u636e\u5904\u7406\u903b\u8f91*/
		function dataProcesser(cfg,argData)
		{
			var _datas = [];
			var _data;
			for(var i = 0;i < argData.length && i < 10;i++)
			{
				_data = {};
				for(var p in cfg)
				{
					_data[p] = argData[i][cfg[p]];
				}
				if(_data.symbol && isSHB(_data.symbol))
				{
					_data.fieldsImportant = { now: { digit: 3 },preClose: { digit: 3} };
				}
				_datas.push(_data);
			}
			return _datas;
		}
		function makeURL(urlTemplate,selectID)
		{
			return urlTemplate.replace('$value',$('#' + selectID).val());
		}
		/*\u9875\u7b7e\u5207\u6362\u7684\u56de\u8c03\u51fd\u6570*/
		function TabCtrler()
		{
			var _drawers = [];
			var _showingIndex = 0;
			var _return = function (argIndex)
			{
				if(typeof argIndex == 'number')
				{
					_showingIndex = argIndex;
				}
				_drawers[_showingIndex].getData();
			};
			_return.add = function (argDrawer)
			{
				_drawers.push(argDrawer);
			};
			return _return;
		};
		/*\u6bcf\u4e2a\u9875\u7b7e\u7684\u8bf7\u6c42url\u3001\u53d8\u91cf\u540d\u7b49\u7b49*/
		function TabDrawer(container,url,dataName,dataProcesser,fieldCfg)
		{
			this.drawer = new DataDrawer(container,fieldCfg);
			this.url = url;
			this.dataName = dataName;
			this.dataProcesser = dataProcesser;
		}
		merge(TabDrawer.prototype,
        {
        	getData: function ()
        	{
        		var _url = this.url;
        		if(typeof _url == 'function')
        		{
        			_url = _url();
        		}
        		if(_url.indexOf('hq.sinajs') > -1)
        		{
        			loadScript(_url.replace('$rn',random()),this.gotData.fnBind(this));
        		}
        		else
        		{
        			getScript(_url.replace('$rn',random()),this.gotData.fnBind(this));
        		}
        	},
        	gotData: function ()
        	{
        		this.draw(this.dataProcesser(window[this.dataName]));
        	},
        	draw: function (argData)
        	{
        		this.drawer.draw(argData);
        	}
        });
	} ();

	/*\u73af\u7403\u5e02\u573a\u6458\u8981\uff0c\u6bcf\u4e2a\u5757new\u4e00\u4e2a\u5bf9\u8c61\u51fa\u6765*/
	function GlobalHQ(containerID,list,fieldCfg)
	{
		this.drawer = new DataDrawer(containerID,fieldCfg);
		this.list = [];
		for(var i = 0;i < list.length;i++)
		{
			this.list.push(new dataParser(list[i]));
		}
		this.getData();
		var _this = this;
		setInterval(function ()
		{
			/*\u53ea\u6709\u884c\u60c5\u533a\u57df\u663e\u793a\u65f6\u624d\u5237\u65b0\u6570\u636e*/
			var vt = window.pageYOffset || document.body.scrollTop || document.documentElement.scrollTop;
			var vb = vt + Math.min(document.documentElement.clientHeight,document.body.clientHeight) + 100;
			var _top = $('#' + containerID).offset().top;
			if(vb >= _top)
			{
				_this.getData();
			}
		},5 * 1000);
	}
	merge(GlobalHQ.prototype,
    {
    	getData: function ()
    	{
    		var _list = [];
    		for(var i = 0;i < this.list.length;i++)
    		{
    			_list.push(this.list[i].makeHqKey());
    		}
    		loadScript(hqURL.replace('$rn',random()) + _list.join(','),this.gotData.fnBind(this));
    	},
    	gotData: function ()
    	{
    		var _datas = [];
    		for(var i = 0;i < this.list.length;i++)
    		{
    			_datas.push(this.list[i].processData());
    		}
    		this.drawer.draw(_datas);
    	}
    });

	/*\u7528\u4e8e\u5904\u7406\u5404\u79cdhq\u7684\u524d\u7f00\u548c\u6570\u636e\u5904\u7406*/
	function dataParser(cfg)
	{
		this.cfg = cfg;
	}
	merge(dataParser.prototype,
    {
    	/*\u628a\u5404\u79cd\u7c7b\u578b\u7684\u4ee3\u7801\u52a0\u4e0a\u524d\u7f00*/
    	makeHqKey: function ()
    	{
    		switch(this.cfg[2])
    		{
    			case 'cn':
    				return 's_' + this.cfg[0];
    				break;
    			case 'hk':
    				return 'rt_hk' + this.cfg[0];
    				break;
    			case 'us':
    				return 'gb_' + this.cfg[0].replace(/\./g,'$');
    				break;
    			case 'hf':
    				return 'hf_' + this.cfg[0];
    				break;
    			case 'forex':
    			case 'qh':
    				return this.cfg[0];
    				break;
    			case 'IF':
    				return 'CFF_RE_' + this.cfg[0];
    				break;
    			case 'b':
    				return 'b_' + this.cfg[0];
    				break;
    			default:
    				alert('\u65b0\u7684\u7c7b\u578b\uff0c\u9700\u6dfb\u52a0\u4ee3\u7801');
    				break;
    		}
    	},
    	/*\u5904\u7406\u5404\u79cd\u7c7b\u578b\u7684\u6570\u636e*/
    	processData: function ()
    	{
    		var _hqStr = window['hq_str_' + this.makeHqKey()];
    		var _data = {};
    		var _ds = _hqStr.split(',');
    		_data.colorType = this.cfg[3];
    		switch(this.cfg[2])
    		{
    			case 'cn':
    				_data.now = _ds[1];
    				_data.change = _ds[2];
    				_data.changeP = _ds[3];
    				_data.volume = _ds[4];
    				_data.amount = _ds[5];
    				break;
    			case 'hk':
    				_data.now = _ds[6];
    				_data.change = _ds[6] - _ds[3];
    				_data.changeP = (_ds[6] - _ds[3]) / _ds[3] * 100;
    				break;
    			case 'us':
    				_data.now = _ds[1];
    				_data.change = _ds[4];
    				_data.changeP = _ds[2];
    				_data.volume = _ds[10];
    				break;
    			case 'hf':
    				_data.now = _ds[0];
    				_data.change = _ds[0] - _ds[7];
    				_data.changeP = _data.change / _ds[7] * 100;
    				break;
    			case 'forex':
    				_data.now = _ds[8];
    				_data.change = _ds[8] - _ds[3];
    				_data.changeP = _data.change / _ds[3] * 100;
    				break;
    			case 'IF':
    				_data.now = _ds[3];
    				_data.change = _ds[3] - _ds[14];
    				_data.changeP = _data.change / _ds[14] * 100;
    				break;
    			case 'b':
    				_data.now = _ds[1];
    				_data.change = _ds[2];
    				_data.changeP = _ds[3];
    				break;
    			case 'qh':
    				_data.now = _ds[8];
    				_data.change = _data.now - _ds[10];
    				_data.changeP = _data.change / _ds[10] * 100;
    				break;
    		}
    		_data.name = this.cfg[1];
    		_data.name = this.cfg[4] ? '<a href="$link" target="_blank">$name</a>'.replace('$link',this.cfg[4]).replace('$name',_data.name) : _data.name;
    		return _data;
    	}
    });

	var breakingNewsCtrl = new function ()
	{
		var _timer;
		var _hovering = false;
		function _get()
		{
			getScript('http://finance.sina.com.cn/js/stock/breakingnews.js?rn' + random(),_got);
		}
		function _got()
		{
			if(_hovering)
			{
				setTimeout(arguments.callee,1000);
				return;
			}
			var _container = $('#breakingNews');
			_container.fadeOut(function ()
			{
				clearInterval(_timer);
				_container.empty();
				var _a,_span;
				for(var i = 0;i < breaking_news.length;i++)
				{
					_a = $('<a>').attr('target','_blank').attr('href',breaking_news[i].url).html(breaking_news[i].title).appendTo(_container);
					_span = $('<span>').html('(' + breaking_news[i].date.replace(/^\d{4}\-/,'') + ' ' + breaking_news[i].time + ')').appendTo(_container);
				}
				_container.show();
				_start();
			});
		}
		function _start()
		{
			var _container = document.getElementById('breakingNews');
			var _width = $('#breakingNews *:first').width();
			var _left = 430;
			_container.style.left = _left + 'px';
			_timer = setInterval(function ()
			{
				if(_hovering)
				{
					return;
				}
				_left -= 2;
				if(_left + _width < 0)
				{
					_container.style.left = '0px';
					$('#breakingNews *:first').appendTo('#breakingNews');
					_left += _width;
					_width = $('#breakingNews *:first').width();
				}
				_container.style.left = _left + 'px';
			},30);
		}
		this.init = function ()
		{
			_get();
			setInterval(_get,60 * 2 * 1000);
			$('#breakingNews').mouseenter(function ()
			{
				_hovering = true;
			}).mouseleave(function ()
			{
				_hovering = false;
			});
		};
	} ();

	var cjywCtrl = new function ()
	{
		var cyb = {
			'sz399006' : 1,
			'sz399012' : 1,
			'sz399606' : 1,
			'sz399635' : 1
		};
		function _get()
		{
			var url = (papercode in cyb) ? 'http://finance.sina.com.cn/js/api/689/2013/0808/cjyw.js' : 'http://finance.sina.com.cn/flash/api/cjyw.js';
			getScript(url + '?rn=' + random(),_got,'utf-8');
		}
		function _got()
		{
			var _container = $('#cjyw').empty();
			var _ul,_li,_span,_a;
			var _single;
			for(var i = 0;i < cjyw.result.data.length && i < 18;i++)
			{
				_single = cjyw.result.data[i];
				if(i % 9 == 0)
				{
					_ul = $('<ul>').appendTo(_container);
				}
				_li = $('<li>').appendTo(_ul);
				_span = $('<span>').html('(' + _single.date + ' ' + _single.time + ')').appendTo(_li);
				_a = $('<a>').attr('target','_blank').attr('href',_single.url).attr('title',_single.title).html(_single.title.length > 30 ? _single.title.substring(0,29) + '..' : _single.title).appendTo(_li);
				if(i == 8)
				{
					_container.append('<div class="dotted_line"></div>');
				}
			}
		}
		this.init = function ()
		{
			_get();
			setInterval(_get,60 * 2 * 1000);
		};
	} ();
	//\u8bc1\u5238\u8981\u95fb\u9644\u8fd1\u4eba\u5de5\u63a8\u8350
	var stockTip = new function ()
	{
		function _getData()
		{
			getScript('http://finance.sina.com.cn/api/437/2013/1018/json/breaknews_153.js',_gotData);
		}
		function _gotData()
		{
			var _container = $('#stockTip').empty();
			var _single;
			_single = index_tip;
			$('<a>').attr('target','_blank').attr('href',_single.url).html(_single.title.replace('###','')).appendTo(_container);
		}
		function _getSpecial()
		{
			var _container = $('#stockTip').empty();
			//$('<a>').attr('target','_blank').attr('href','http://finance.sina.com.cn/focus/15qgcgcgds/rank.html').html('<span style="color:#ff0000;padding-left:28px;display:inline-block;background:url(http://n.sinaimg.cn/finance/zt/15qgcgcgds/images/hot.png) no-repeat 0 5px;">\u9ad8\u624b\u91cd\u4ed3\u94f6\u79a7\u79d1\u6280\u5373\u83b7\u62c9\u5347\uff0c\u6536\u76ca\u7ffb\u756a\u8749\u8054\u699c\u9996</span>').appendTo(_container);
		}
		this.init = function ()
		{
			//_getData();
            try{
            //_getSpecial();
            }catch(e){}
		};
	} ();

	function Survey(surveyID)
	{
		this.surveyID = surveyID;
		this.getData();
	}
	merge(Survey.prototype,
    {
    	getData: function ()
    	{
    		var _date = clock.time();
    		if(_date.getHours() < 15 && _date.getHours() >= 9)
    		{
    			getScript('http://vip.stock.finance.sina.com.cn/quotes_service/view/get_survey_all.php',this.gotPre.fnBind(this));
    		}
    		else
    		{
    			getScript('http://survey.news.sina.com.cn/survey_js.php?dpc=1&pid=' + this.surveyID,this.gotNow.fnBind(this));
    		}
    	},
    	gotPre: function ()
    	{
    		for(var i = 0;i < question_yesterday.length;i++)
    		{
    			for(var j = 0;j < question_yesterday[i][2].length;j++)
    			{
    				$('#survey_a_' + question_yesterday[i][2][j][3]).html(question_yesterday[i][2][j][1] + '(' + question_yesterday[i][2][j][2] + '%)');
    			}
    		}
    	},
    	gotNow: function ()
    	{
    		if(!window.question)
    		{
    			return;
    		}
    		for(var i = 0;i < question.length;i++)
    		{
    			for(var j = 0;j < question[i][2].length;j++)
    			{
    				$('#survey_a_' + question[i][2][j][3]).html(question[i][2][j][1] + '(' + question[i][2][j][2] + '%)');
    			}
    		}
    	}
    });
	/*\u9875\u7b7e\u5207\u6362*/
	/*repeatCall\u5982\u679c\u4f20true\u5219\u6bcf\u6b21\u5212\u8fc7\u90fd\u8c03\u7528\u51fd\u6570\uff0c\u53ef\u4f5c\u4e3a\u65f6\u95f4\u54cd\u5e94*/
	function TabCont(container,evType,callback,repeatCall)
	{
		this.tabs = $('#' + container + ' .tab');
		this.conts = $('#' + container + ' .cont');
		this.evType = evType || 'mouseenter';
		this.callback = callback;
		this.repeatCall = repeatCall;
		if(this.tabs.length != this.conts.length)
		{
			error(container + '\u6807\u7b7e\u4e0e\u5185\u5bb9\u6570\u76ee\u4e0d\u5bf9\u5e94');
		}
		this.addEvent();
	}
	merge(TabCont.prototype,
    {
    	addEvent: function ()
    	{
    		for(var i = 0;i < this.tabs.length;i++)
    		{
    			this.tabs.eq(i)[this.evType](this.show.fnBind(this,[i]));
    		}
    	},
    	/*\u663e\u793a\u7b2c\u51e0\u4e2a\u9875\u7b7e\uff0c\u5916\u9732\uff0c\u53ef\u76f4\u63a5\u8c03\u7528*/
    	show: function (argIndex)
    	{
    		if(!/(\s|^)on(\s|$)?/.test(this.tabs[argIndex].className))
    		{
    			this.tabs.removeClass('on');
    			this.tabs.eq(argIndex).addClass('on');
    			this.conts.hide();
    			this.conts.eq(argIndex).show();

    			this.callback && this.callback(argIndex);
    		}
    		else if(this.repeatCall)
    		{
    			this.callback && this.callback(argIndex);
    		}
    	}
    });
	/*\u865a\u62df\u4e0b\u62c9\u5217\u8868*/
	function VSelect(selectID)
	{
		this.selectID = selectID;
		this.vselect;
		this.showout;
		this.createDom();
		this.addEvent();
	}
	merge(VSelect.prototype,
    {
    	createDom: function ()
    	{
    		var _select = $('#' + this.selectID);
    		/*\u9690\u6389\u539f\u751fselect*/
    		_select.hide();
    		this.vselect = $C('div');
    		this.vselect.className = 'vselect';
    		this.showout = $C('span');
    		this.vselect.appendChild(this.showout);
    		_select.after(this.vselect);
    		this.setWord();
    	},
    	addEvent: function ()
    	{
    		$(this.vselect).click(this.show.fnBind(this));
    	},
    	show: function (ev)
    	{
    		ev = ev || window.event;
    		/*\u5982\u679c\u5df2\u662f\u663e\u793a\u72b6\u6001\u4e86\u5c31\u4e0d\u505a\u64cd\u4f5c\uff0c\u4e0a\u6b21\u6dfb\u52a0\u7684hide\u51fd\u6570\u4f1a\u81ea\u52a8\u8fdb\u884c\u9690\u85cf\u64cd\u4f5c*/
    		/*\u6240\u6709\u5df2\u663e\u793a\u72b6\u6001\u4e0b\u7684\u70b9\u51fb\u90fd\u5e94\u8be5\u662f\u9690\u85cf\u64cd\u4f5c*/
    		if($(this.vselect).find('voptions').length)
    		{
    			return;
    		}
    		/*\u5c55\u5f00\u65f6\u7684\u70b9\u51fb\u9700\u8981\u628a\u4e8b\u4ef6\u5192\u6ce1\u505c\u6389\uff0c\u5426\u5219documentElement\u7684\u70b9\u51fb\u4e8b\u4ef6\u4f1a\u9a6c\u4e0a\u9690\u85cf\u5c42*/
    		/*\u591a\u4e2avselect\u8054\u52a8\uff0c\u6240\u4ee5\u4e0d\u80fd\u518d\u505c\u6b62\u5192\u6ce1\u4e86\uff0c\u5ef6\u540e\u7ed1\u5b9a\u4e8b\u4ef6\u6765\u907f\u514d\u8fd9\u4e2a\u95ee\u9898*/
    		//            else
    		//            {
    		//                ev.stopPropagation && ev.stopPropagation();
    		//                ev.cancelBubble = true;
    		//            }
    		function _hide()
    		{
    			$(_voptions).remove();
    			$(document.documentElement).unbind('click',_hide);
    		}
    		setTimeout(function ()
    		{
    			$(document.documentElement).click(_hide);
    		},10);

    		var _voptions = $C('voptions');
    		_voptions.className = 'voptions';
    		var _select = $id(this.selectID);
    		var _options = $(_select).find('option');
    		var _selectedIndex = _select.selectedIndex;
    		var _a;
    		for(var i = 0;i < _options.length;i++)
    		{
    			_a = $C('a');
    			_a.href = 'javascript:void(0)';
    			_a.innerHTML = _options[i].innerHTML;
    			if(i == _selectedIndex)
    			{
    				_a.className = 'on';
    			}
    			_a.onclick = this.select.fnBind(this,[i]);
    			_voptions.appendChild(_a);
    		}
    		this.vselect.appendChild(_voptions);
    		_voptions.style.display = 'block';
    	},
    	/*\u9009\u62e9\u67d0\u4e00\u4e2a\u9009\u9879\uff0c\u7b2c\u4e8c\u4e2a\u53c2\u6570true\u5219\u4e0d\u4f1a\u89e6\u53d1onchange\u4e8b\u4ef6\u3002\u4e5f\u53ef\u4ee5\u76f4\u63a5\u8c03\u7528\u6765\u6539\u53d8\u9009\u62e9*/
    	select: function (argIndex,argNocall)
    	{
    		var _select = $id(this.selectID);
    		var _selectedIndex = _select.selectedIndex;
    		if(_selectedIndex !== argIndex)
    		{
    			_select.selectedIndex = argIndex;
    			this.setWord();
    			if(argNocall !== true)
    			{
    				$(_select).change();
    			}
    		}
    		return false;
    	},
    	setWord: function ()
    	{
    		this.showout.innerHTML = $('#' + this.selectID).find('option:selected').html();
    	}
    });


	/*\u5224\u65ad\u662f\u5426\u662f\u4ea4\u6613\u65f6\u95f4*/
	function checkDayTime()
	{
		var _hour = clock.time().getHours();
		var _day = clock.time().getDay();
		if(_hour >= 8 && _hour < 16 && _day != 0 && _day != 6)
		{
			return true;
		}
		return false;
	}

	/*\u5408\u5e76hq\u8bf7\u6c42\u53d1\u9001*/
	var loadScript = new function ()
	{
		var _list = [];
		var _call = [];
		var _list_txt = [];
		var _call_txt = [];
		var _timer,_timerTxt;
		/*\u53d1\u8bf7\u6c42\uff0c\u628a\u5217\u8868\u6e05\u7a7a\uff0c\u4ee5\u540e\u7684\u91cd\u65b0\u7d2f\u79ef*/
		function _get()
		{
			if(!_list.length || !_list.join(','))
			{
				return;
			}
			getScript(hqURL.replace('$rn',random()) + _list.join(','),_got.bindArg(_call));
			_call = [];
			_list = [];
		}
		function _getTxt()
		{
			if(!_list_txt.length || !_list_txt.join(','))
			{
				return;
			}
			getScript(hqURL_txt.replace('$rn',random()) + _list_txt.join(','),_got.bindArg(_call_txt));
			_call_txt = [];
			_list_txt = [];
		}
		function _got(argCall)
		{
			for(var i = 0;i < argCall.length;i++)
			{
				argCall[i]();
			}
		}
		/*\u7b2c\u4e09\u4e2a\u53c2\u6570\u4f20\u5165true\u5219\u7acb\u5373\u53d1\u9001\u8bf7\u6c42*/
		return function (arr,callback,immediately)
		{
			var _isTxt;
			var _listTmp,_callTmp,_getTmp;
			if(typeof arr == 'string' && arr.indexOf('format=text') > -1)
			{
				_listTmp = _list_txt;
				_callTmp = _call_txt;
				_getTmp = _getTxt;
				_isTxt = true;
			}
			else
			{
				_listTmp = _list;
				_callTmp = _call;
				_getTmp = _get;
				_isTxt = false;
			}
			var _arr = arr;
			if(typeof _arr == 'string')
			{
				_arr = _arr.replace(/^[\s\S]*list=/,'').split(',');
			}
			/*\u5982\u679c\u52a0\u4e00\u8d77\u4f1a\u8d85\u51faurl\u957f\u5ea6\u5219\u9a6c\u4e0a\u628a\u4e4b\u524d\u7684\u8bf7\u6c42\u53d1\u51fa\u53bb*/
			if((_listTmp.join(',') + _arr.join(',')).length > 750)
			{
				_getTmp();
			}
			var _sList = ',' + _listTmp.join(',') + ',';
			for(var i = 0;i < _arr.length;i++)
			{
				if(_sList.indexOf(',' + _arr[i] + ',') == -1)
				{
					_listTmp.push(_arr[i]);
					_sList += _arr[i] + ',';
				}
			}
			_callTmp.push(callback);
			/*\u5ef6\u540e\u53d1\u9001\u8bf7\u6c42\uff0c\u5982\u679c\u6709\u5176\u4ed6hq\u8bf7\u6c42\u5219\u4f1a\u7d2f\u79ef\u5230\u4e00\u8d77*/

			clearTimeout(_isTxt ? _timerTxt : _timer);
			if(immediately)
			{
				_getTmp();
			}
			else
			{
				if(_isTxt)
				{
					_timerTxt = setTimeout(_getTmp,50);
				}
				else
				{
					_timer = setTimeout(_getTmp,50);
				}
			}
		};
	} ();

	function $id(id)
	{
		return document.getElementById(id);
	}
	function $C(tag)
	{
		return document.createElement(tag);
	}
	function random()
	{
		return new Date().getTime();
	}
	function error(msg)
	{
		window.console && console.error && console.error(msg);
	}
	function isSHB(symbol)
	{
		return /^sh900/.test(symbol);
	}
} (jQuery);