$(function() {
	$("#floatPanel > .ctrolPanel > a.arrow").eq(0).click(function() {
		$("html,body").animate({
			scrollTop: 0
		}, 800);
		return false;
	});
	$("#floatPanel > .ctrolPanel > a.arrow").eq(1).click(function() {
		$("html,body").animate({
			scrollTop: $(document).height()
		}, 800);
		return false;
	});
	var objPopPanel = $("#floatPanel > .popPanel");
	var w = objPopPanel.outerWidth();
	$("#floatPanel > .ctrolPanel > a.qrcode").bind({
		mouseover: function() {
			objPopPanel.css("width", "0px").show();
			objPopPanel.animate({
				"width": w + "px"
			}, 135);
			return false;
		},
		mouseout: function() {
			objPopPanel.animate({
				"width": "0px"
			}, 135);
			return false;
			objPopPanel.css("width", w + "px");
		}
	});
	$('.am-form-inline').submit(function() {
		if ($('#seh_v').val() == '') {
			$('#seh_v').focus();
			return false;
		}
	});
	$('.ac_results li').live('click', function() {
		var key = $(this).attr('title');
		$("#seh_v").val(key);
		$('.am-form-inline').submit();
	});
	$(document).bind("click", function(e) {
		if ($(e.target).closest(".ac_results").length > 0) {
			$(".ac_results").show();
		} else {
			$(".ac_results").hide();
		}
	});
	$("form").submit(function() {
		$(":submit", this).attr("disabled", "disabled");
	});
	$("input,textarea").live('click', function() {
		$("button[type=submit]").removeAttr("disabled");
	});
	//智能检索下拉
	$("#xiala").live('click', function() {
		var sid = $(this).attr('sid');
		if(sid==1){
            $(this).addClass('xiala').removeClass('shangla');
			$(this).attr('sid','0');
			$(this).html('展开选项<b></b>');
			$('#xuan').addClass('hide').removeClass('block');
			setCookie('ctcms_xiala','no');
		}else{
            $(this).addClass('shangla').removeClass('xiala');
			$(this).attr('sid','1');
			$(this).html('收起选项<b></b>');
			$('#xuan').addClass('block').removeClass('hide');
			setCookie('ctcms_xiala','ok');
		}
	});
	//获取下拉选择
	var xiala=getCookie('ctcms_xiala');
	if(xiala=='ok'){
          $("#xiala").addClass('shangla').removeClass('xiala');
	      $("#xiala").attr('sid','1');
		  $("#xiala").html('收起选项<b></b>');
		  $('#xuan').addClass('block').removeClass('hide');
	}
	//关不浮动窗口
    $('.am-close').live('click', function() {
	    $('#weixin').hide();
	    $('.am-dimmer').hide();
    });
	//充值提交
    $("#paysave").live('click', function() {
        var sid = $('#paysid').val();
        var type = $('#type').val();
        var rmb=$('#rmb').val();
	    if(type=='cion' && rmb<1){
            alert('充值金额不能小于1元~');
	    }else{
            $('form').attr('target','_self');
	        if(sid==1){
                $('form').attr('target','pay-iframe');
			    $('#weixin').show();
			    $('.am-dimmer').show();
	        }
	        $('form').submit();
	    }
    });
	//自定义金额
    $('.rmbs').bind('input propertychange', function() { 
        var rmb=$('#rmbs').val();
	    $('#rmb').val(rmb);
    });
	//支付方式切换
    $(".xuan").live('click', function() {
        var sid = $(this).attr('sid');
        if(sid==0){
	        $('#type').val('cion');
		    $('.yue').removeClass('am-block').addClass('am-hide');
		    $('.cion').addClass('am-block').removeClass('am-hide');
	    }else{
	        $('#type').val('yue');
		    $('.cion').removeClass('am-block').addClass('am-hide');
		    $('.yue').addClass('am-block').removeClass('am-hide');
	    }
		getxuan('type',sid,0,2);
    });
	//支付类型切换
    $(".pay").live('click', function() {
        var sid = $(this).attr('sid');
        $('#paysid').val(sid);
		getxuan('sid',sid,0,2);
    });
	//天数、月数切换
    $(".day").live('click', function() {
        var day = $(this).attr('day');
        var xu = $(this).attr('xu');
        $('#day').val(day);
        getxuan('day',xu,1,5);
    });
	//金额切换
    $(".rmb").live('click', function() {
        var rmb = $(this).attr('rmb');
        var xu = $(this).attr('xu');
        $('#rmb').val(rmb);
        getxuan('rmb',xu,1,5);
    });
	//性别切换
	$(".sex").live('click', function() {
        var sex = $(this).attr('sex');
        $('#sex').val(sex);
        getxuan('sex',sex,0,3);
    });
});
function getxuan(op,n,i,len){
  for(var i;i<len;i++){
     if(i==n){
        $('#'+op+'-'+i).addClass('on');
     }else{
        $('#'+op+'-'+i).removeClass('on');
	 }
  }
}
function light(){
    var str=$('.light_switch span').html();
	var h=window.screen.height;
	if(str=='开灯'){
		$('body').removeAttr("style");
		$('.player').removeAttr("style");
        $('.light_switch span').html('关灯');
        $('.light_switch span').css('color','#111');
        $('.light_switch').css('z-index','999');
		$('.playshow_mask').hide();
	}else{
	    $('html,body').animate({scrollTop:200},1000);
        $('body').css("height",h);
		$('body').css("overflow","hidden");
        $('.light_switch span').html('开灯');
        $('.light_switch span').css('color','#ddd');
        $('.light_switch').css('z-index','1002');
        $('.playshow_mask').show();
		$('.player').css("position","relative");
		$('.player').css("width","965px");
		$('.player').css("top","70px");
        $('.player').css("z-index","8000");
	}
}
function get_url(url) {
	setCookie('ctcms_xiala','ok');
	location.href = url;
}
function fav(url) {
	$.get(url, function(data) {
		if (data == 'ok') {
			alert('恭喜你，收藏成功！')
		} else {
			alert(data);
		}
	})
}
function getCookie(name){
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
    if(arr=document.cookie.match(reg))
       return unescape(arr[2]);
    else
       return null;
}
//写cookies
function setCookie(name,value){
    var Days = 30;
    var exp = new Date();
    exp.setTime(exp.getTime() + Days*24*60*60*1000);
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}