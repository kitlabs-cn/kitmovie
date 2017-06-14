<?php
/**
 * @Ctcms open source management system
 * @copyright 2008-2016 chshcms.com. All rights reserved.
 * @Author:Cheng Kai Jie
 * @Dtime:2015-12-11
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Sys extends Ctcms_Controller {

	function __construct(){
	    parent::__construct();
		//加载后台模型
		$this->load->model('admin');
        //当前模版
		$this->load->get_templates('admin');
		//判断是否登陆
		$this->admin->login();
	}

	//管理员列表
	public function index()
	{
 	    $page = intval($this->input->get('page'));
        if($page==0) $page=1;
	
	    $data['page'] = $page;
        //总数量
	    $total = $this->csdb->get_nums('admin',$where);
		//每页数量
	    $per_page = 15; 
		//总页数
	    $pagejs = ceil($total / $per_page);
	    if($total<$per_page) $per_page=$total;
	    $limit=array($per_page,$per_page*($page-1));
        //记录数组
	    $data['array'] = $this->csdb->get_select('admin','*',$where,'id DESC',$limit);
		//当前链接
		$base_url = links('sys','index');
		//分页
	    $data['pages'] = admin_page($base_url,$total,$pagejs,$page);  //获取分页类
	    $data['nums'] = $total;
		$this->load->view('head.tpl',$data);
		$this->load->view('sys_index.tpl');
	}

	//管理员增加编辑
	public function edit()
	{
 	    $id = intval($this->input->get('id'));
		if($id==0){
            $data['id'] = 0;
            $data['name'] = '';
            $data['nichen'] = '';
		}else{
            $data = $this->csdb->get_row_arr("admin","*",array('id'=>$id)); 
		}
        $this->load->view('head.tpl',$data);
        $this->load->view('sys_edit.tpl',$data);
	}

	//管理员修改
	public function save()
	{
		$id = (int)$this->input->post('id');
		$data['name'] = $this->input->post('name',true);
		$data['nichen'] = $this->input->post('nichen',true);
		$pass = $this->input->post('pass',true);
		if(!empty($pass)){
		    $data['pass'] = md5($pass);
		}
		if(empty($data['name']) || empty($data['nichen'])){
             admin_msg('账号和昵称不能为空~！','javascript:history.back();','no');
		}
		if(empty($pass) && $id==0){
             admin_msg('密码不能为空~！','javascript:history.back();','no');
		}
		if($id==0){
             $this->csdb->get_insert('admin',$data);
		}else{
             $this->csdb->get_update('admin',$id,$data);
		}
        echo "<script>
		      parent.layer.msg('恭喜您，操作成功~!');
		      setInterval('parent.location.reload()',1000); 
              </script>";
	}

    //删除管理员
	public function del()
	{
 	    $id = $this->input->post('id');
		$res=$this->csdb->get_del('admin',$id);
		$data['error']=$res ? 'ok' : '删除失败~!';
		echo json_encode($data);
	}

	//登陆日志列表
	public function log()
	{
 	    $user = $this->input->get_post('user',true);
 	    $kstime = $this->input->get_post('kstime',true);
 	    $jstime = $this->input->get_post('jstime',true);
 	    $page = intval($this->input->get('page'));
        if($page==0) $page=1;

	    $data['user'] = $user;
	    $data['kstime'] = $kstime;
	    $data['jstime'] = $jstime;
	    $data['page'] = $page;

		$where='';
		if(!empty($kstime)){
			$where['logtime>']=strtotime($kstime);
		}
		if(!empty($jstime)){
			$where['logtime<']=strtotime($jstime);
		}
		if(!empty($user)){
			$uid=getzd('admin','id',$user,'name');
			if((int)$uid>0){
			    $where['uid']=$uid;
			}
		}

        //总数量
	    $total = $this->csdb->get_nums('admin_log',$where);
		//每页数量
	    $per_page = 15; 
		//总页数
	    $pagejs = ceil($total / $per_page);
	    if($total<$per_page) $per_page=$total;
		$limit=array($per_page,$per_page*($page-1));
        //记录数组
	    $data['array'] = $this->csdb->get_select('admin_log','*',$where,'id DESC',$limit);
		//当前链接
		$base_url = links('sys','log',0,'user='.$user.'&kstime='.$kstime.'&jstime='.$jstime);
		//分页
	    $data['pages'] = admin_page($base_url,$total,$pagejs,$page);  //获取分页类
	    $data['nums'] = $total;
		$this->load->view('head.tpl',$data);
		$this->load->view('sys_log.tpl');
	}

    //删除日志
	public function log_del()
	{
 	    $ac = $this->input->get('ac');
 	    $id = $this->input->post('id');
		$res=$this->csdb->get_del('admin_log',$id);
		if($ac=='all'){
			if($res){
                admin_msg('恭喜您，删除完成~！',links('sys','log'));
			}else{
                admin_msg('删除失败，请稍后再试~！','javascript:history.back();','no');
			}
		}else{
		    $data['error']=$res ? 'ok' : '删除失败~!';
		    echo json_encode($data);
		}
	}
}
