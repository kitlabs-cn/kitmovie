<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$route['whole/(.+).html'] = 'whole/index/$1'; 
$route['show/(\d+).html'] = 'show/index/$1'; 
$route['play/(\d+)~(\d+)~(\d+).html'] = 'play/index/$1/$2/$3'; 
$route['list/(\d+)~(\d+).html'] = 'lists/index/$1/$2'; 
