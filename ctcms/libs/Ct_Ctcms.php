<?php
/**
 * @Ctcms open source management system
 * @copyright 2009-2015 chshcms.com. All rights reserved.
 * @Author:Cheng Jie
 * @Dtime:2015-12-08
 */
header('Content-Type: text/html; charset=utf-8');
//装载全局配置文件
require_once 'Ct_DB.php';
require_once 'Ct_Config.php';
require_once 'Ct_Version.php';
//手机客户端访问标示
if(preg_match("/(iPhone|iPad|iPod|Android|Linux)/i", strtoupper($_SERVER['HTTP_USER_AGENT']))){
    define('MOBILE', true);	
	if(Wap_Url!=''){
        $wapurl = substr(Wap_Url,0,7)!='http://' ? 'http://'.Wap_Url.Path : Wap_Url.Path;
		header("location:".$wapurl);exit;
	}
}
//判断网站运行状态
if(!defined('IS_ADMIN') && Web_Off==1){
    exit(Web_Onneir);
}
//URL运行模式则自动加上D参数admin
if (defined('IS_ADMIN') && Web_Mode==2){
    $_GET['d']='admin';
}