<?php
/*
  Yun Parse 云解析,QQ:157503886
  请在下面地址查询统计情况。
  http://120.27.155.106/login
*/

//文件名称
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
// 网站根目录
define('FCPATH', str_replace("\\", "/", str_replace(SELF, '', __FILE__)));
//加载配置文件
require_once FCPATH.'config.php';
//接收参数
$url = empty($_GET['vid']) ? $_GET['url'] : $_GET['vid'];
if(empty($url)) exit('URL参数错误~!');
//兼容老版本
if(!empty($_GET['type'])) $url.='~'.$_GET['type'];
//防盗链判断
if(!is_referer()) exit('403');
//判断缓存目录是否可写
if(!is_writable(FCPATH.'cache')) exit(FCPATH.'cache 目录不可写~!');
//报错次数
$errid = (int)$_GET['err'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" /> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Yun Parse—视频在线播放</title>
<style type="text/css">body,html,div{background-color:#000;padding: 0;margin: 0;width:100%;height:100%;color:#aaa;}</style>
<script src="http://apps.bdimg.com/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="../ckplayer/ckplayer.js"></script>
</head>
<body style="overflow-y:hidden;">
<div id="loading" style="font-weight:bold;padding-top:90px;" align="center">正在加载播放中,请稍等...</div>
<div id="a1" style="display:none;"></div>
<div id="error" style="display:none;font-weight:bold;padding-top:90px;" align="center"></div>
<script type="text/javascript">
var errid = <?php echo $errid;?>;
var isiPad = navigator.userAgent.match(/iPad|iPhone|Android|Linux|iPod/i) != null;
function player(){
	 $('#a1').html('<iframe width="100%" height="100%" allowTransparency="true" frameborder="0" scrolling="no" src="http://www.wmxz.wang/video.php?url=<?php echo $url;?>" id=aaaa></iframe>');
	  $('#loading').hide();
      $('#a1').show();
  
   
}
function error(){
	if(isiPad){
	    var vod = document.getElementById("vod");
	    if(vod.error.code==4) play_up();
	}else{
        CKobject.getObjectById('ckplayer_a1').addListener('error','play_up');
	}
}
function play_up(){
	errid++;
	if(errid < 4){ //最多只重新加载3次
		$.post("api.php", {"url": "<?php echo get_key($url);?>","up": "1"},
		function(data){
			if(data['msg'] == 'ok'){
				location.href = '?url=<?php echo $url;?>&err='+errid;
			}else{
				$('#loading').hide();
				$('#a1').hide();
				$('#error').show();
				$('#error').html(data['msg']);
			}
		},"json");
	}
}
player();
</script>
</body>
</html>
