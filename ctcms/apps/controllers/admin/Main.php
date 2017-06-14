<?php 
/**
 * @Ctcms open source management system
 * @copyright 2008-2016 chshcms.com. All rights reserved.
 * @Author:Cheng Kai Jie
 * @Dtime:2015-12-11
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends Ctcms_Controller {

	function __construct() {
	    parent::__construct();
		//加载后台模型
		$this->load->model('admin');
        //当前模版
		$this->load->get_templates('admin');
		//判断是否登陆
		$this->admin->login();
	}

	public function index()
	{
        $where = array('id'=>$_SESSION['admin_id']);
		$data['admin']=$this->csdb->get_row('admin','*',$where);
		//今日
		$arr=array('addtime>'=>strtotime(date('Y-m-d 0:0:0')));
		$data['count'][]=$this->csdb->get_nums('vod',$arr);
		//昨日
		$times=strtotime(date('Y-m-d 0:0:0'));
		$arr=array('addtime<'=>$times,'addtime>'=>$times-86400);
		$data['count'][]=$this->csdb->get_nums('vod',$arr);
		//本月
		$times=strtotime(date('Y-m-01 0:0:0'));
		$arr=array('addtime>'=>$times);
		$data['count'][]=$this->csdb->get_nums('vod',$arr);
		//上月
		$time=strtotime('-1 month');
		$time1=strtotime(date('Y-m-1 0:0:0',$time));
		$time2=strtotime(date('Y-m-1 0:0:0'));
		$arr=array('addtime>'=>$time1,'addtime<'=>$time2);
		$data['count'][]=$this->csdb->get_nums('vod',$arr);
		//总统计
		$data['count'][]=$this->csdb->get_nums('vod');

		$this->load->view('head.tpl',$data);
		$this->load->view('main.tpl');
	}
}