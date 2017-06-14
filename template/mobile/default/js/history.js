
function switchHistory(){
	if(!$('.history').hasClass('history_on')){
		$('.clean_history').hide();
		$('.history').addClass('history_on');
		$('.ico_history').addClass('ico_history_on');
		$('.head').addClass('head_on');
		$('.nav').fadeOut(0);
                $('.no_history').show();
		
		setTimeout(function(){
			var cookie_info = get_cookie("ttyy_tv_play");
                        get_history();
			if(cookie_info != '' && cookie_info != null && cookie_info != undefined){
				$('.no_history').hide();
				$('.clean_history').show();
			}else{
				$('.no_history').show();
			}
		},0);

	}else{
		$('.history').removeClass('history_on');
		$('.ico_history').removeClass('ico_history_on');
		$('.head').removeClass('head_on');
		$('.nav').fadeIn(0);
	}

}

$(document).ready(function(){
	$('.clean_history').click(function(){
		$('#history_content').empty();
		$('.clean_history').hide();
		$('.no_history').show();
		setTimeout(function(){del_history();},0);
	});
});

function get_cookie(_name){
	var Res=eval('/'+_name+'=([^;]+)/').exec(document.cookie);
	return Res==null?'':unescape(Res[1]);
}

function set_cookie(_name, _value, _hours){
    var expdate = new Date();
    if( null != _hours ) expdate.setTime(expdate.getTime() + _hours * 3600000);
   document.cookie = _name + '=' + escape (_value) + '; path=/;domain=top.location.hostname;' +((_hours == null) ? '' : ('; expires='+ expdate.toGMTString()));
}
function SetCookie(name, value){
	var expdate = new Date();
	var argv = SetCookie.arguments;
	var argc = SetCookie.arguments.length;
	var expires = (argc > 2) ? argv[2] : null;
	var path = (argc > 3) ? argv[3] : null;
	var domain = (argc > 4) ? argv[4] : null;
	var secure = (argc > 5) ? argv[5] : false;
	if(expires!=null) expdate.setTime(expdate.getTime() + ( expires * 1000 ));
	document.cookie = name + "=" + escape (value) +((expires == null) ? "" : ("; expires="+ expdate.toGMTString()))+((path == null) ? "" : ("; path=" + path)) +((domain == null) ? "" : ("; domain=" + domain))+((secure == true) ? "; secure" : "");
}
function set_history(_url, _name, _id){
    var current_str = _id + "#" + _name + "#" + _url + "*ttyy*";
    var cookie_info = get_cookie("ylmvHistory");
    var deal_cookie="";
    if( "" != cookie_info){
	    cookie_info = cookie_info.split("*ttyy*");
            var N = (cookie_info.length > 18) ? 18 : cookie_info.length - 1;
	    for(var i=0; i<N; i++){
                if(current_str != cookie_info[i] + "*ttyy*" && '' != cookie_info[i]) deal_cookie += (cookie_info[i] + "*ylmv*");
            }
    }
    current_str = ('' == deal_cookie) ? current_str : current_str + deal_cookie;
    SetCookie("ttyy_tv_play", current_str, 48 * 3600, "/", top.location.hostname, false);
}
function get_history(){
    var cookie_info=get_cookie("ttyy_tv_play").split("*ttyy*");
    var N = cookie_info.length - 1;
    var history_list = "", infos, s;
    for(var i=0; i<N; i++){
           var ii = i+1;
           infos = cookie_info[i].split("#");
           history_list += '<li><a href="'+infos[2]+'"><strong>'+infos[1]+'</strong><em></em><span aria-hidden="true" data-icon="p"></span></a></li>';
    }
    $("#history_content").html(history_list);
}	
function del_history(){
    SetCookie("ttyy_tv_play", "", null, "/", top.location.hostname, false);
}
