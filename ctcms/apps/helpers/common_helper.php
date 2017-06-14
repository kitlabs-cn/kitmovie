<?php
/**
 * @Ctcms open source management system
 * @copyright 2016-2017 ctcms.cn. All rights reserved.
 * @Author:Chi Tu
 * @Dtime:2016-08-11
 */

/**
 * 全局通用函数
 */

//解析多个分类ID  如 cid=1,2,3,4,5,6
function getcid($CID,$type='news_list',$zd='fid'){
	 $ci = &get_instance();
	 if (!isset($ci->db)){
        $ci->load->database();
	 }
     if(!empty($CID)){
            $ClassArr=explode(',',$CID);
            for($i=0;$i<count($ClassArr);$i++){
				$sql="select id from ".CT_SqlPrefix.$type." where ".$zd."='$ClassArr[$i]'";//sql语句的组织返回
				$result=$ci->db->query($sql)->result();
				if(!empty($result)){
                       foreach ($result as $row) {
                            $ClassArr[]=$row->id;
                       }
                }
          		$CID=implode(',',$ClassArr);
       		}
	 }
	 return $CID;
}

//获取任意字段信息
function getzd($table,$ziduan,$id,$cha='id'){
	 $ci = &get_instance();
	 if (!isset($ci->db)){
        $ci->load->database();
	 }
     if($table && $ziduan && $id){
	     $ci->db->where($cha,$id);
	   	 $ci->db->select($ziduan);
	   	 $row=$ci->db->get($table)->row();
		 if($row){
			  $str=$row->$ziduan;
		 }else{
			  $str="";	
		 }
		 if($ziduan=='pic'){
              $str=getpic($str);
		 }
		 return $str;
	 }
}
//截取字符串的函数
function sub_str($str, $length, $start=0, $suffix="...", $charset="utf-8"){
	     $str=str_checkhtml($str);
		 if(($length+2) >= strlen($str)){
            return $str;
         }
         if(function_exists("mb_substr")){
             return mb_substr($str, $start, $length, $charset).$suffix;
         }elseif(function_exists('iconv_substr')){
             return iconv_substr($str,$start,$length,$charset).$suffix;
         }
         $re['utf-8']  = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
         $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
         $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
         $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
         preg_match_all($re[$charset], $str, $match);
         $slice = join("",array_slice($match[0], $start, $length));
         return $slice.$suffix;
}
//读文件
function load_file($skin,$dir='index'){
	if(Wap_Is==1 && defined('MOBILE')){
	    $path = VIEWPATH.'mobile'.DIRECTORY_SEPARATOR.Wap_Skin.DIRECTORY_SEPARATOR.$skin;
	}else{
	    $path = VIEWPATH.'skins'.DIRECTORY_SEPARATOR.Web_Skin.DIRECTORY_SEPARATOR.$skin;
	}
	if(!file_exists($path)){
		exit('缺少模板文件：'.$skin);
	}
	return file_get_contents($path);
}
//写文件
function write_file($path, $data, $mode = FOPEN_WRITE_CREATE_DESTRUCTIVE){
		$dir = dirname($path);
		if(!is_dir($dir)){
			mkdirss($dir);
		}
		if ( ! $fp = @fopen($path, $mode))
		{
			return FALSE;
		}
		flock($fp, LOCK_EX);
		fwrite($fp, $data);
		flock($fp, LOCK_UN);
		fclose($fp);
		return TRUE;
}
//递归创建文件夹
function mkdirss($dir) {
    if (!$dir) {
        return FALSE;
    }
    if (!is_dir($dir)) {
        mkdirss(dirname($dir));
        if (!file_exists($dir)) {
            mkdir($dir, 0777);
        }
    }
    return true;
}
//时间格式转换
function datetime($TimeTime){
    	$limit=time()-$TimeTime;
    	if ($limit <5) {$show_t = '刚刚';}
    	if ($limit >= 5 and $limit <60) {$show_t = $limit.'秒前';}
    	if ($limit >= 60 and $limit <3600) {$show_t = sprintf("%01.0f",$limit/60).'分钟前';}
    	if ($limit >= 3600 and $limit <86400) {$show_t = sprintf("%01.0f",$limit/3600).'小时前';}
    	if ($limit >= 86400 and $limit <2592000) {$show_t = sprintf("%01.0f",$limit/86400).'天前';}
   		if ($limit >= 2592000 and $limit <31104000) {$show_t = sprintf("%01.0f",$limit/2592000).'个月前';}
    	if ($limit >= 31104000) {$show_t = '1年以前';}
  	    return $show_t;
}
//删除所有空格
function trimall($str){
    $qian=array(" ","　","\t","\n","\r");$hou=array("","","","","");
    return str_replace($qian,$hou,$str);    
}
//HTML转字符
function str_encode($str){
	     if(is_array($str)) {
             foreach($str as $k => $v) {
                  $str[$k] = str_encode($v); 
			 }
		 }else{
                  $str=str_replace("<","&lt;",$str);
                  $str=str_replace(">","&gt;",$str);
                  $str=str_replace("\"","&quot;",$str);
				  $str=str_replace("'",'&#039;',$str);
		 }
         return $str;
}
//字符转HTML
function str_decode($str){
	     if(is_array($str)) {
             foreach($str as $k => $v) {
                  $str[$k] = str_decode($v); 
			 }
		 }else{
                  $str=str_replace("&lt;","<",$str);
                  $str=str_replace("&gt;",">",$str);
                  $str=str_replace("&quot;","\"",$str);
				  $str=str_replace("&#039;","'",$str);
		 }
         return $str;
}
//SQL过滤
function safe_replace($string){
	     if(is_array($string)) {
             foreach($string as $k => $v) {
                  $string[$k] = safe_replace($v); 
			 }
		 }else{
			      if(!is_numeric($string)){
	                    $string = str_replace('%20','',$string);
	                    $string = str_replace('%27','',$string);
	                    $string = str_replace('%2527','',$string);
						$string = str_replace("'",'&#039;',$string);
	                    $string = str_replace('"','&quot;',$string);
	                    $string = str_replace(';','',$string);
	                    $string = str_replace('*','',$string);
	                    $string = str_replace('<','&lt;',$string);
	                    $string = str_replace('>','&gt;',$string);
	                    $string = str_replace('\\','',$string);
	                    $string = str_replace('%','\%',$string);
	                    //$string = preg_replace("/ /","", $string);
	                    //$string = preg_replace("/　/","", $string);
						$string = str_encode($string);
				  }
		 }
	     return $string;
}
//屏蔽所有html
function str_checkhtml($str,$sql=0) {
	     if(is_array($str)) {
             foreach($str as $k => $v) {
                  $str[$k] = str_checkhtml($v); 
			 }
		 }else{
	              $str = preg_replace("/\s+/"," ", $str);
	              $str = preg_replace("/&nbsp;/","",$str);
	              $str = preg_replace("/\r\n/","",$str);
	              $str = preg_replace("/\n/","",$str);
	              $str = str_replace(chr(13),"",$str);
	              $str = str_replace(chr(10),"",$str);
	              $str = str_replace(chr(9),"",$str);
	              $str = strip_tags($str);
	              $str = str_encode($str);
		 }
		 if($sql==1){
	           $str = safe_replace($str);
		 }
	     return $str;
}
//xss过滤函数
function remove_xss($val) { 
	     if(is_array($val)) {
             foreach($val as $k => $v) { 
                  $val[$k] = remove_xss($v); 
             } 
		 }else{
		     if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0') !== false ){
                 $val=str_checkhtml($val);
		     }else{
                 $ci = &get_instance();
		         //加载库类
			     $params['html']=$val;
                 $ci->load->library('xsshtml',$params);
			     $val = $ci->xsshtml->getHtml();
			 }
		 }
         return $val; 
}
//编码转换
function get_bm($string,$s1='gbk',$s2='utf-8') {
	     if(is_array($string)) {
             foreach($string as $k => $v) { 
                  $string[$k] = get_bm($v); 
             } 
		 }else{
	         if(strtolower($s1)=='gbk'){
                  if(is_utf8($string)){
                      return $string;
			      }
		     }
	         if(function_exists("mb_convert_encoding")){
				$string = mb_convert_encoding($string, $s2, $s1);
             }else{
                $string = iconv($s1, $s2, $string);
             }
		 }
         return $string;
}
//urlencode解码
function rurlencode($string) {
         $key=rawurldecode($string);
         if(!is_utf8($key)){
			  $key = get_bm($key,'gbk', 'utf-8');
         }
         return $key;
}
//判断字符是否是UTF-8
function is_utf8($liehuo_net) { 
         if (preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$liehuo_net) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$liehuo_net) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$liehuo_net) == true) { 
                return true; 
         } else { 
                return false; 
         } 
}
//escape编码
function escape($string, $in_encoding = 'UTF-8',$out_encoding = 'UCS-2') { 
    $return = ''; 
    if (function_exists('mb_get_info')) { 
        for($x = 0; $x < mb_strlen ( $string, $in_encoding ); $x ++) { 
            $str = mb_substr ( $string, $x, 1, $in_encoding ); 
            if (strlen ( $str ) > 1) { // 多字节字符 
                $return .= '%u' . strtoupper ( bin2hex ( mb_convert_encoding ( $str, $out_encoding, $in_encoding ) ) ); 
            } else { 
                $return .= '%' . strtoupper ( bin2hex ( $str ) ); 
            } 
        } 
    } 
    return $return; 
}
//escape编码解析
function unescape($str) { 
    $ret = ''; 
    $len = strlen($str); 
    for ($i = 0; $i < $len; $i ++) { 
        if ($str[$i] == '%' && $str[$i + 1] == 'u') { 
            $val = hexdec(substr($str, $i + 2, 4)); 
            if ($val < 0x7f) 
                $ret .= chr($val); 
            else  
                if ($val < 0x800) 
                    $ret .= chr(0xc0 | ($val >> 6)) . 
                     chr(0x80 | ($val & 0x3f)); 
                else 
                    $ret .= chr(0xe0 | ($val >> 12)) . 
                     chr(0x80 | (($val >> 6) & 0x3f)) . 
                     chr(0x80 | ($val & 0x3f)); 
            $i += 5; 
        } else  
            if ($str[$i] == '%') { 
                $ret .= urldecode(substr($str, $i, 3)); 
                $i += 2; 
            } else 
                $ret .= $str[$i]; 
    } 
    return $ret; 
}
//获取IP
function getip(){ 
         $ci = &get_instance();
		 $ip = $ci->input->ip_address();
         if(preg_match("/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/",$ip)){
                return $ip; 
         }else{
                return "";
         }
} 
//获取远程内容
function htmlall($url,$codes='utf-8',$gzip=0){
         if(empty($url)) return '';
         // curl模式
         if (function_exists('curl_init') && function_exists('curl_exec')) {
		      $curl = curl_init(); //初始化curl
		      curl_setopt($curl, CURLOPT_URL, $url); //设置访问的网站地址
		      curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); //模拟用户使用的浏览器
			  curl_setopt($curl, CURLOPT_REFERER, "http://".Web_Url.Web_Path.SELF);
		      curl_setopt($curl, CURLOPT_AUTOREFERER, 1);    //自动设置来路信息
		      curl_setopt($curl, CURLOPT_TIMEOUT, 100);      //设置超时限制防止死循环
		      curl_setopt($curl, CURLOPT_HEADER, 0);         //显示返回的header区域内容
		      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //获取的信息以文件流的形式返回
			  if($gzip) curl_setopt($curl, CURLOPT_ENCODING, "gzip"); // 关键在这里   
		      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
		      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 
		      $data = curl_exec($curl);
		      curl_close($curl);
	      }
          // fopen模式
          if (empty($data) && ini_get('allow_url_fopen')) {
              $data = @file_get_contents($url);
          }
          if(strtolower($codes)=='gbk'){
               $data=get_bm($data);
          }
          $data=str_replace('</textarea>','&lt;/textarea&gt;',$data);
          return $data;
}
// HTML转JS  
function htmltojs($str){
            $re='';
            $str=str_replace('\\','\\\\',$str);
            $str=str_replace("'","\'",$str);
            $str=str_replace('"','\"',$str);
            $str=str_replace("\t",'',$str);
            $str=str_replace("\r",'',$str);
            $str= explode("\n",$str);
            for($i=0;$i<count($str);$i++){
                $re.="document.writeln(\"".$str[$i]."\");\r\n";
            }
            return $re;
}
//删除目录和文件
function deldir($dir,$sid=1) {
         //先删除目录下的文件：
		 if(!is_dir($dir)){
              return true;
		 }
         $dh=opendir($dir);
         while ($file=readdir($dh)) {
           if($file!="." && $file!="..") {
             $fullpath=$dir."/".$file;
             if(!is_dir($fullpath)) {
                 @unlink($fullpath);
             } else {
                 deldir($fullpath);
             }
           }
         }
         closedir($dh);
         //删除当前文件夹：
         if($sid==1){
            if(@rmdir($dir)) {
                return true;
            } else {
                return false;
            }
         }else{
            return true;
         }
}
//获取当前目录总大小
function getdirsize($dir){ 
        $handle = opendir($dir);
        $sizeResult=0;
        while (false!==($FolderOrFile = readdir($handle))){ 
            if($FolderOrFile != "." && $FolderOrFile != ".."){ 
                if(is_dir("$dir/$FolderOrFile")){ 
                    $sizeResult += getDirSize("$dir/$FolderOrFile"); 
                }else{ 
                    $sizeResult += filesize("$dir/$FolderOrFile"); 
                }
            }    
        }
        closedir($handle);
        return $sizeResult;
}
//大小转换
function formatsize($size, $dec=2){
    $a = array("B", "KB", "MB", "GB", "TB", "PB");
    $pos = 0;
    while ($size >= 1024) {
         $size /= 1024;
         $pos++;
    }
    return round($size,$dec)." ".$a[$pos];
}
//Base64加密
function base64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return $data;
}
//Base64解密
function base64decode($string) {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data.= substr('====', $mod4);
        }
        return base64_decode($data);
}
//字符加密、解密
function sys_auth($string,$operation,$key=''){
	     $key=($key=='')?CT_Encryption_Key:$key;
         $key=md5($key);
         $key_length=strlen($key);
         $string=$operation=='D'?base64_decode(str_replace('-','/',str_replace('_','+',$string))):substr(md5($string.$key),0,8).$string;
         $string_length=strlen($string);
         $rndkey=$box=array();
         $result='';
         for($i=0;$i<=255;$i++){
                   $rndkey[$i]=ord($key[$i%$key_length]);
                   $box[$i]=$i;
         }
         for($j=$i=0;$i<256;$i++){
                   $j=($j+$box[$i]+$rndkey[$i])%256;
                   $tmp=$box[$i];
                   $box[$i]=$box[$j];
                   $box[$j]=$tmp;
		 }
         for($a=$j=$i=0;$i<$string_length;$i++){
                   $a=($a+1)%256;
                   $j=($j+$box[$a])%256;
                   $tmp=$box[$a];
                   $box[$a]=$box[$j];
                   $box[$j]=$tmp;
                   $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
		 }
         if($operation=='D'){
               if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8)){
                       return substr($result,8);
               }else{
                       return'';
			   }
		 }else{
               return str_replace('+','_',str_replace('=','',base64_encode($result)));
		 }
}
//通过key查找数组的value
function arr_key_value($arr,$key){
	     if(is_array($arr)){
            foreach ($arr as $keys => $value) {
                if($key==$keys){
                      return $value;
	            }
            }
		 }
         return false;
}
//写入新数组到文件
function arr_file_edit($arr,$file=''){
	     if($file=='') $file=CTCMSPATH.'libs/Ct_Bind.php';
	     if(is_array($arr)){
		        $con = var_export($arr,true);
	     } else{
		        $con = $arr;
	     }
	     $strs="<?php if (!defined('FCPATH')) exit('No direct script access allowed');".PHP_EOL;
	     $strs.="return $con;";
	     $strs.="?>";
         return write_file($file, $strs);
}
//后台提示信息
function admin_msg($title, $url, $zt='ok'){
		$class1=($zt=='ok')?'#dcdcdc':'#FF6633';
		$class2=($zt=='ok')?'#090':'red';
		$bt=($zt=='ok')?4:2;
        echo "<html>
		<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gbk\" />
		<title>提示信息</title>
		<style>
		*{ word-wrap:break-word; outline:none; }
		body{background-color:#f3f3f3; text-align:center; color:#555; font:12px \"Lucida Grande\", Verdana, Lucida, Helvetica, Arial, 'Simsun', sans-serif; }
		body, h3 { margin:0; padding:0; }
		h3{ font-size:12px;margin-bottom:10px; font-size:14px; color:#333; }
		a{ color:#2366A8; text-decoration:none; }
		a:hover { text-decoration:underline; }
		.container{ padding:9px 20px 20px; text-align:left; }
        .infotitle2{ margin-bottom:10px; color:".$class2."; font-size:14px; font-weight:700; }
		.infobox{ clear:both; margin-bottom:10px; padding:30px; text-align:center; border-top:".$bt."px solid ".$class1."; border-bottom:".$bt."px solid ".$class1."; background:#f9f9f9; zoom:1; }
		.marginbot{ margin-bottom:10px; }
		.lightlink{ color:#666; text-decoration:underline;}
		</style>
		<base target='_self'/>
		</head>
		<body>
		<div class='container'>
		<h3>友情提示</h3>
		<div class='infobox'>
		<h4 class='infotitle2'>".$title."</h4>
		<p class='marginbot'><a href='".$url."' class='lightlink'>如果您的浏览器没有自动跳转，请点击这里</a></p>
		<script type='text/JavaScript'>setTimeout('JumpUrl()', 3000);</script>
		</div>
        </div>
		<script>
		function JumpUrl(){
		       location.href='".$url."';
		}
		</script>
		</body>
		</html>";
        exit();
}
//前台页面返回信息
function msg_url($title,$url,$zt='no',$time=3) {
	    if(defined('MOBILE')){
		    $html = file_get_contents(VIEWPATH."errors/html/wap_error.php");
		}else{
		    $html = file_get_contents(VIEWPATH."errors/html/error.php");
		}
		$msg = $zt=='no' ? '错误原因' : '提示';
		$color = $zt=='no' ? 'red' : '#333';
		$arr1 = array('{msg}','{title}','{url}','{time}','{path}','{color}');
		$arr2 = array($msg,$title,$url,$time,Web_Path,$color);
		$html = str_replace($arr1,$arr2,$html);
		exit($html);
}