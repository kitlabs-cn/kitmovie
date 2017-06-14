<?php
/**
 * @Ctcms open source management system
 * @copyright 2016-2017 ctcms.cn. All rights reserved.
 * @Author:Chi Tu
 * @Dtime:2016-08-11
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Gbook extends Ctcms_Controller {

	function __construct(){
	    parent::__construct();
		//加载后台模型
		$this->load->model('admin');
        //当前模版
		$this->load->get_templates('admin');
		//判断是否登陆
		$this->admin->login();
	}

    //列表
	public function index()
	{
 	    $page = intval($this->input->get('page'));
 	    $ziduan = $this->input->get_post('ziduan',true);
 	    $key = $this->input->get_post('key',true);
 	    $yid = (int)$this->input->get_post('yid',true);
 	    $kstime = $this->input->get_post('kstime',true);
 	    $jstime = $this->input->get_post('jstime',true);
        if($page==0) $page=1;

	    $data['key'] = $key;
	    $data['ziduan'] = $ziduan;
	    $data['kstime'] = $kstime;
	    $data['jstime'] = $jstime;
	    $data['page'] = $page;
	    $data['yid'] = $yid;

		$where=$like='';
		if(!empty($kstime)){
			$where['addtime>']=strtotime($kstime);
		}
		if(!empty($jstime)){
			$where['addtime<']=strtotime($jstime);
		}
		if(!empty($key)){
			$like[$ziduan]=$key;
		}
		if($yid>0){
			$where['yid']=$yid-1;
		}

        //总数量
	    $total = $this->csdb->get_nums('gbook',$where,$like);
		//每页数量
	    $per_page = 15; 
		//总页数
	    $pagejs = ceil($total / $per_page);
	    if($total<$per_page) $per_page=$total;
		$limit=array($per_page,$per_page*($page-1));
        //记录数组
	    $data['array'] = $this->csdb->get_select('gbook','*',$where,'addtime DESC',$limit,$like);
		//当前链接
		$base_url = links('gbook','index',0,'yid='.$yid.'&ziduan='.$ziduan.'&key='.urlencode($key).'&kstime='.$kstime.'&jstime='.$jstime);
		//分页
	    $data['pages'] = admin_page($base_url,$total,$pagejs,$page);  //获取分页类
	    $data['nums'] = $total;
		$this->load->view('head.tpl',$data);
		$this->load->view('gbook_index.tpl');
	}

	//批量审核
	public function init()
	{
 	    $id = $this->input->post('id');
        $data['yid'] = 0;
		$this->csdb->get_update('gbook',$id,$data);
        admin_msg('恭喜您，审核完成~！',links('gbook'));
	}

	//回复
	public function edit()
	{
 	    $id = intval($this->input->get('id'));
		$data = $this->csdb->get_row_arr("gbook","*",array('id'=>$id)); 
        $this->load->view('head.tpl',$data);
        $this->load->view('gbook_edit.tpl',$data);
	}

	//回复入库
	public function save()
	{
		$id = (int)$this->input->post('id');
		$data['name'] = $this->input->post('name',true);
		$data['content'] = $this->input->post('content',true);
		$data['hfcontent'] = $this->input->post('hfcontent',true);
		$data['yid'] = (int)$this->input->post('yid');

		if(empty($data['name']) || empty($data['content'])){
             admin_msg('名字、内容不能为空~！','javascript:history.back();','no');
		}        preg_match_all('/id:([0-9]+)/',$data['hfcontent'],$arr);		if(!empty($arr[1][0])){			$link = 'http://'.Web_Url.links('show','index',$arr[1][0],0,1);            $data['hfcontent'] = str_replace($arr[0][0],'<a href="'.$link.'">'.$link.'</a>',$data['hfcontent']);		}
		$this->csdb->get_update('gbook',$id,$data);
        echo "<script>
		      parent.layer.msg('恭喜您，操作成功~!');
              setInterval('parent.location.reload()',1000); 
              </script>";
	}

    //删除
	public function del()
	{
 	    $ac = $this->input->get('ac');
 	    $id = $this->input->post('id');
		$res=$this->csdb->get_del('gbook',$id);
		if($ac=='all'){
			if($res){
                admin_msg('恭喜您，删除完成~！',links('gbook'));
			}else{
                admin_msg('删除失败，请稍后再试~！','javascript:history.back();','no');
			}
		}else{
		    $data['error']=$res ? 'ok' : '删除失败~!';
		    echo json_encode($data);
		}
	}
}