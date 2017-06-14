

var supportsOrientationChange = 'onorientationchange' in window, orientationEvent = supportsOrientationChange ? 'orientationchange' : 'resize';

// 横竖屏切换自动刷新
var screen_status = '';
window.addEventListener(orientationEvent, function(){
	
	var ua = navigator.userAgent;
	
	if(ua.indexOf('Android') > 0){
		deviceType = 'isAndroid';
	}else{
		deviceType = 'isIOS';
	}
	
	if('isIOS' === deviceType){
		if(Math.abs(window.orientation) === 90){
			screen_status = '-';
		}else{
			screen_status = '|';
		}
	}else if('isAndroid' === deviceType){
		if(Math.abs(window.orientation) !== 90){
			screen_status = '|';
		}else{
			screen_status = '-';
		}
	}
	
	if(ua.indexOf('MiuiBrowser') > 0 || ua.indexOf('HUAWEI_P6') > 0){
		setTimeout(function(){
			if(window.location.href.indexOf('?') < 0){
				window.location.href += '?rd=' + new Date().getTime();
			}else{
				window.location.href += '&rd=' + new Date().getTime();
			}
		}, 100);
	}
	
}, false);

// 导航滑动
var myScroll = [];
var nav_pos = 0;
var nav_pos_search = 0;
function loaded(){
	var scrollset = document.getElementsByClassName('iScroll');
	var count = 0;
	for(var i=0; i<scrollset.length; i++){
		var item = scrollset[i];
		if(item.id == ''){
			item.id = 'nav_' + count;
			count++;
		}
		tpmyScroll = new iScroll(item.id, {
			scrollX : true,
			scrollY : false,
			momentum : true,
			keyBindings : true,
			hScrollbar : false,
			hScroll : true,
			vScroll : false
		});
		myScroll.push(tpmyScroll);
		if(location.href.indexOf('search') == -1){
			tpmyScroll.scrollTo(nav_pos, 0, 0, true);
		}
		if(nav_pos_search > 0){
			tpmyScroll.scrollTo(nav_pos_search, 0, 0, true);
		}
	}
}
if(location.href.indexOf('search') == -1){
	document.addEventListener('DOMContentLoaded', loaded, false);
}

// 获取cookie
function getCookie(name){
	
	var _search = name + '=';
	var _offset = document.cookie.indexOf(_search);
	if(_offset != -1){
		_offset += _search.length;
		var _end = document.cookie.indexOf(';', _offset);
		if(_end == -1){
			_end = document.cookie.length;
		}
		return unescape(document.cookie.substring(_offset, _end));
	}else {
		return ''
	};
	
}

// 写入cookie
function setCookie(name, value, hours){
	
	var expireDate = new Date(new Date().getTime() + hours * 3600000);
	var host = 'kankan.com';
	document.cookie = name + "=" + escape(value) + "; path=/; domain="+host+"; expires=" + expireDate.toGMTString();
	
}

// 获取url参数
function getParameter(name){
	
	var search = document.location.search;
	var pattern = new RegExp("[?&]"+name+"\=([^&]+)", "g");
	var matcher = pattern.exec(search);
	var items = null;
	if(null != matcher){
		items = decodeURIComponent(matcher[1]);
	}
	return items;
	
}

// 拉取js
function loadJSData(url, charset, fCallback){
	
	var head = document.getElementsByTagName('head')[0];
	var script = document.createElement('script');
	var id = 'dynamic_script_' + new Date().getTime() + '_' + Math.random();
	var eventType = (undefined !== script.onreadystatechange && undefined !== script.readyState) ? 'onreadystatechange' : 'onload';
	
	script.language = 'javascript';
	script.type = 'text/javascript';
	script.charset = charset;
	script.src = url;
	script.id = id;
	
	try{
		script.addEventListener('error', function(){
			setTimeout(function(){try{fCallback();}catch(e){}}, 0);
		}, false); 
		script.addEventListener('load', function(){
			setTimeout(function(){try{fCallback();}catch(e){}}, 0);
		}, false);
	}catch(e){
		script.attachEvent(eventType, function(){
			var state = script.readyState || 'loaded';
			if('loaded' == state || 'complete' == state){
				setTimeout(function(){try{fCallback();}catch(e){}}, 0);
			}
		});
	}
	
	head.appendChild(script);
	
}

// 过滤空格
function ignoreSpaces(string){
	
	if(string != null){
		var temp = '';
		string = '' + string;
		splitstring = string.replace(/\+/g, ' ').split(' ');
		for(i=0; i<splitstring.length; i++){
			temp += splitstring[i];
		}
		return temp;
	}
	return string;
	
}

// 检测 localStorage 可用性
var use_cookie = false;
try{
	localStorage.setItem('localStorageStatus', 1);
}catch(e){
	use_cookie = true;
}

// 记录最后访问类型页
if(use_cookie){
	if(location.href.indexOf('search.html?') < 0 && document.referrer.indexOf('search.html?') < 0
	&& document.referrer.indexOf('feedback.html') < 0){
		setTimeout(function(){setCookie('urlHistory', document.referrer.indexOf('http://m.kankan.com/') == 0 ? document.referrer : location.href, 24 * 31);},0);
	}
}else{
	if(location.href.indexOf('search.html?') < 0 && document.referrer.indexOf('search.html?') < 0
	&& document.referrer.indexOf('feedback.html') < 0){
		localStorage.setItem('urlHistory', document.referrer.indexOf('http://m.kankan.com/') == 0 ? document.referrer : location.href);
	}
}

// 获取最后访问类型页
function getUrlHistory(){
	
	if(use_cookie){
		var urlHistory = getCookie('urlHistory');
	}else{
		var urlHistory = localStorage.getItem('urlHistory');
	}
	
	if(urlHistory == null || urlHistory == location.href){
		var urlHistory = 'http://m.kankan.com/';
	}
	
	return urlHistory;
	
}

// 筛选器开关
function switchFilter(){
	if(!$('.channel_sort').hasClass('sort_on')){
		$('.channel_sort').addClass('sort_on');
		if(use_cookie){
			setTimeout(function(){setCookie('filter_power', 'on', 24 * 31);}, 0);
		}else{
			localStorage.setItem('filter_power', 'on');
		}
	}else{
		$('.channel_sort').removeClass('sort_on');
		if(use_cookie){
			setTimeout(function(){setCookie('filter_power', 'off', 24 * 31);}, 0);
		}else{
			localStorage.setItem('filter_power', 'off');
		}
	}
}
//滚动至指定位置
function click_scroll(_id) {
     var scroll_offset = $("#"+_id+"").offset();  //得到pos这个div层的offset，包含两个值，top和left  
     $("body,html").animate({
           scrollTop:scroll_offset.top  //让body的scrollTop等于pos的top，就实现了滚动   
     },0);
}
function downlist(cid) {
     if(cid==2 || cid>13){
          $("#down").hide();
     }
}
