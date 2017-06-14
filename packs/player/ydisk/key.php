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
$vid = $_GET['vid'];
//接收参数
$keyurl = $_GET['keyurl'];

//判断缓存是否存在
$cache = 0;
$file_key=FCPATH.'cache/115-key-'.md5($vid);
//KEY 输出
$key = '';
if(file_exists($file_key)){
   $key = file_get_contents($file_key);
}else{
   $key = get_url(API_URL.'?uid='.USER_ID.'&token='.USER_TOKEN.'&type=115&url='.$vid.'&keyurl='.rawurlencode($keyurl));
   if(!empty($key)) file_put_contents($file_key,$key);
}
echo $key;