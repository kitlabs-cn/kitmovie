<?php
/**
 * @Ctcms open source management system
 * @copyright 2016-2017 ctcms.cn. All rights reserved.
 * @Author:Chi Tu
 * @Dtime:2016-08-11
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Ads extends Ctcms_Controller {

	function __construct(){
		parent::__construct();
	}

	public function index($id=0)
	{
		header('Content-Type: application/x-javascript; charset=utf-8');
		if((int)$id==0) $id=(int)$this->input->get('id');
		$str='';
		$row=$this->csdb->get_row_arr('ads','yid,neir',$id);
		if($row && $row['yid']==0) $str=str_decode($row['neir']);
		echo htmltojs($str);
	}
}

