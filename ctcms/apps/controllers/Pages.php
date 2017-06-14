<?php
/**
 * @Ctcms open source management system
 * @copyright 2008-2016 chshcms.com. All rights reserved.
 * @Author:Cheng Kai Jie
 * @Dtime:2015-12-11
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends Ctcms_Controller {

	function __construct(){
	    parent::__construct();
        //当前模版
		$this->load->get_templates();
		$this->load->library('parser');
	}

	public function index($bs='')
	{
		//标识
		if(empty($bs)){
		    $bs=$this->input->get('id');
		}
		$bs=str_checkhtml($bs,1);
		if(empty($bs)) msg_url('参数错误',Web_Path);

	    $cache_id ="pages_".$bs;
	    if(!($this->cache->start($cache_id))){

              $row=$this->csdb->get_row_arr('pages','*',array('bs'=>$bs));
		      if(!$row) msg_url('页面不存在~!',Web_Path);

		      $data['ctcms_title'] = $row['name'].' - '.Web_Name;

		      //获取模板
		      $str=load_file('pages.html');
			  //全局解析
		      $str=$this->parser->parse_string($str,$data,true,false);
			  //当前数据
		      $str=$this->parser->ctcms_tpl('pages',$str,$str,$row);
			  //IF判断解析
		      $str=$this->parser->labelif($str);
		      echo $str;
		      $this->cache->end();
		}
	}
}
