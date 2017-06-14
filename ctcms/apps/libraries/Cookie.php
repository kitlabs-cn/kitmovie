<?php
/**
 * @Ctcms open source management system
 * @copyright 2016-2017 ctcms.cn. All rights reserved.
 * @Author:Chi Tu
 * @Dtime:2016-08-11
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Cookie类
 */
class Cookie {
	function __construct()
	{
		log_message('debug', "Native Session Class Initialized");
	}
	//设置 cookie
	public static function set_cookie($var, $value = '', $time = 0) {
		$time = $time > 0 ? $time : ($value == '' ? time() - 3600 : 0);
		$s = $_SERVER['SERVER_PORT'] == '443' ? 1 : 0;
		$var = CT_Cookie_Prefix.$var;
        $ips=explode(':',$_SERVER['HTTP_HOST']);
		$Domain = CT_Cookie_Domain;
		setcookie($var,sys_auth($value,'E',$var.CT_Encryption_Key),$time, Web_Path, $Domain, $s);
	}
    //获取cookie
    public static function get_cookie($var, $default = '') {
		$var = CT_Cookie_Prefix.$var;
		$value = isset($_COOKIE[$var]) ? sys_auth($_COOKIE[$var],'D',$var.CT_Encryption_Key) : $default;
		$value = safe_replace($value);
		return $value;
	}
}