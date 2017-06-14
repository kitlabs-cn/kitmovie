<?php
/**
 * @Ctcms open source management system
 * @copyright 2008-2016 www.ctcms.cn. All rights reserved.
 * @Author:Cheng Kai Jie
 * @Dtime:2016-09-03
 */
define('IS_ADMIN', TRUE); // 后台标识
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME)); // 后台文件名
define('FCPATH', str_replace("\\", "/", dirname(__FILE__).'/')); // 网站根目录
require('index.php'); // 引入主文件
