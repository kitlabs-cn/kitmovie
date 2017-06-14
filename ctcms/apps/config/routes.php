<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['pages/([a-z]+)']   	= 'pages/index';
$route['index/([0-9]+)']   	= 'index/index';


//加载自定义路由
require CTCMSPATH.'libs/Ct_Rewrite.php';
