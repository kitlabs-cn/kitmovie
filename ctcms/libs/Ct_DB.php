<?php
/**
 * @Ctcms 3.5 open source management system
 * @copyright 2009-2013 chshcms.com. All rights reserved.
 * @Author:Cheng Jie
 * @Dtime:2013-04-27
 */

//服务器IP 一般为localhost或者127.0.0.1
define('CT_Sqlserver','127.0.0.1');

//服务器端口
define('CT_Sqlport','');

//数据库名称
define('CT_Sqlname','ctcms_free');

//数据库表前缀
define('CT_SqlPrefix','ct_');

//数据库用户名
define('CT_Sqluid','root');

//数据库密码
define('CT_Sqlpwd','root');

//数据库方式
define('CT_Dbdriver','mysqli');

//Mysql数据库编码
define('CT_Sqlcharset','utf8');

//encryption_key密钥
define('CT_Encryption_Key','ctcms_VZuPi9TSnY');

//Cookie 前缀，同一域名下安装多套系统时，请修改Cookie前缀
define('CT_Cookie_Prefix','ctcms_');

//Cookie_Domain 作用域,使用多个二级域名时可以启用，格式如 .chshcms.com
define('CT_Cookie_Domain','');

//Cookie 生命周期，0 表示随浏览器进程
define('CT_Cookie_Ttl',10800);
