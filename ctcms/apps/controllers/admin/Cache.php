<?php
/**
 * @Ctcms open source management system
 * @copyright 2008-2016 chshcms.com. All rights reserved.
 * @Author:Cheng Kai Jie
 * @Dtime:2015-12-11
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cache extends Ctcms_Controller {

	function __construct() {
	    parent::__construct();
		//加载后台模型
		$this->load->model('admin');
        //当前模版
		$this->load->get_templates('admin');
	}

	//清空页面库缓存
	public function index()
	{
		deldir('./caches/tpl/','no'); 
		echo 'ok';
		//admin_msg('缓存更新成功~！','javascript:history.back();');
	}
}