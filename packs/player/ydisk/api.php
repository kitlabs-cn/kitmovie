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

//判断防盗链
if(!is_referer()){
	 header('HTTP/1.1 403 Forbidden');
     exit('403');
}

//接收参数
$url = empty($_GET['url']) ? $_POST['url'] : $_GET['url'];
$vid = get_key($url,'D');
$hd = empty($_GET['hd']) ? VOD_HD : $_GET['hd'];
$up = (int)$_POST['up'];

//判断地址解密
if(empty($vid)){
    get_json(array('msg'=>'Url非法操作~!'));
}

//判断http地址模式
if(stristr($vid,'http://')){
	$type = '';
}elseif(stristr($vid,'~')){
	$type = end(explode('~',$vid));
	$vid = str_replace('~'.$type,'',$vid);
}

//组装URL参数
$param = 'apiurl='.YOU_URL.'&url='.$vid.'&type='.$type.'&hd='.$hd.'&wap='.$wap;

//判断缓存是否存在
$cache=0;
$filemd5=FCPATH.'cache/'.md5($param);
if($up==0 && file_exists($filemd5)){
     $json = file_get_contents($filemd5);
	 $arr = json_decode($json,1);
	 $ext = $arr['ext'];
	 $ctime = $arr['ctime'];
	 $vodurl = $arr['url'];
	 if($ctime > time()) $cache++;
}
if($cache==0){
     $json = get_url(API_URL.'?uid='.USER_ID.'&up='.$up.'&token='.USER_TOKEN.'&'.$param);
     $arr = json_decode($json,1);
	 $ext = $arr['ext'];
	 $vodurl = $arr['url'];
	 if(empty($vodurl) || $arr['success']==0){
		 get_json(array('msg'=>$arr['msg']));
	 }else{
	     file_put_contents($filemd5,$json);
	 }
}

//解析输出
if($_GET['url']){
	if($ext=='xml'){
		  get_xml($arr);
	}elseif($ext=='m3u8_list'){
		  header('Content-type: application/vnd.apple.mpegurl');
		  header('Content-disposition: attachment; filename=video.m3u8');
		  exit(base64_decode($vodurl));
	}else{
		  $data['msg'] = '缺少必须参数ext~!';
		  get_json($data);
	}
}else{
	if($ext=='xml' && $wap==0){
		$data['url'] = YOU_URL.'api.php?url='.$url;
	}elseif($ext=='m3u8_list'){
		$data['url'] = YOU_URL.'api.php?url='.$url;
		if($type=='bdyun'){
			$ext = 'link';
		    $data['url'] = $arr['play_swf'].'?file='.rawurlencode(YOU_URL.'api.php?url='.$url);
		}
	}else{
		if($ext=='m3u8' && $wap==0){
			$vodurl = rawurlencode($vodurl);
		}
		$data['url'] = $vodurl;
	}
    $data['ext'] = $ext;
    $data['msg'] = 'ok';
	get_json($data);
}
