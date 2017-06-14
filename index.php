<?php
/**
 * @Ctcms open source management system
 * @copyright 2008-2016 www.ctcms.cn. All rights reserved.
 * @Author:Cheng Kai Jie
 * @Dtime:2016-09-03
 */
//默认时区
date_default_timezone_set("Asia/Shanghai");
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'production');
switch (ENVIRONMENT)
{
	case 'development':
		error_reporting(-1);
		ini_set('display_errors', 1);
	break;
	case 'testing':
	case 'production':
		ini_set('display_errors', 0);
		if (version_compare(PHP_VERSION, '5.3', '>='))
		{
			error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
		}
		else
		{
			error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
		}
	break;
	default:
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'The application environment is not set correctly.';
		exit(1); // EXIT_ERROR
}
$application_folder = 'ctcms/apps';
$system_path = 'ctcms/system';
$view_folder = 'template';
if (defined('STDIN')){
	chdir(dirname(__FILE__));
}
if (($_temp = realpath($system_path)) !== FALSE){
	$system_path = $_temp.'/';
}else{
	$system_path = rtrim($system_path, '/').'/';
}

if ( ! is_dir($system_path)){
	header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
	echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: '.pathinfo(__FILE__, PATHINFO_BASENAME);
	exit(3); // EXIT_CONFIG
}
// The name of THIS file
if (!defined('SELF')) {
	define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
}
// Path to the system folder
define('BASEPATH', str_replace('\\', '/', $system_path));
// Path to the front controller (this file)
if (!defined('FCPATH')) {
	define('FCPATH', dirname(__FILE__).'/');
}
// Name of the "system folder"
define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));
//ctcms path
define('CTCMSPATH', str_replace('\\', '/', dirname(BASEPATH).DIRECTORY_SEPARATOR));
// The path to the "application" folder
if (is_dir($application_folder)){
	if (($_temp = realpath($application_folder)) !== FALSE){
		$application_folder = $_temp;
	}
	define('APPPATH', $application_folder.DIRECTORY_SEPARATOR);
}else{
	if ( ! is_dir(BASEPATH.$application_folder.DIRECTORY_SEPARATOR)){
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
		exit(3); // EXIT_CONFIG
	}
	define('APPPATH', BASEPATH.$application_folder.DIRECTORY_SEPARATOR);
}
// The path to the "views" folder
if ( ! is_dir($view_folder)){
	if ( ! empty($view_folder) && is_dir(APPPATH.$view_folder.DIRECTORY_SEPARATOR)){
		$view_folder = APPPATH.$view_folder;
	}elseif ( ! is_dir(APPPATH.'views'.DIRECTORY_SEPARATOR)){
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
		exit(3); // EXIT_CONFIG
	}else{
		$view_folder = APPPATH.'views';
	}
}
if (($_temp = realpath($view_folder)) !== FALSE){
	$view_folder = $_temp.DIRECTORY_SEPARATOR;
}else{
	$view_folder = rtrim($view_folder, '/\\').DIRECTORY_SEPARATOR;
}
define('VIEWPATH', $view_folder);
//ctcms
require_once CTCMSPATH.'libs/Ct_Ctcms.php';
//CI 
require_once BASEPATH.'core/CodeIgniter.php';