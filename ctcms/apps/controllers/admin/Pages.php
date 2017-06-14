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
        if($page==0) $page=1;

	    $data['page'] = $page;

        //总数量
	    $total = $this->csdb->get_nums('pages');
		//每页数量
	    $per_page = 15; 
		//总页数
	    $pagejs = ceil($total / $per_page);
	    if($total<$per_page) $per_page=$total;
		$limit=array($per_page,$per_page*($page-1));
        //记录数组
	    $data['array'] = $this->csdb->get_select('pages','*','','id DESC',$limit);
		//当前链接
		$base_url = links('pages','index');
		//分页
	    $data['pages'] = admin_page($base_url,$total,$pagejs,$page);  //获取分页类
	    $data['nums'] = $total;
		$this->load->view('head.tpl',$data);
		$this->load->view('pages_index.tpl');
	}

	//页面编辑
	public function edit()
	{
 	    $id = intval($this->input->get('id'));
		if($id==0){
		     $data['id'] = 0;
		     $data['yid'] = 0;
		     $data['name'] = '';
		     $data['text'] = '';
		     $data['bs'] = '';
		}else{
		     $row = $this->csdb->get_row("pages","*",array('id'=>$id)); 
		     $data['id'] = $id;
		     $data['yid'] = $row->yid;
		     $data['name'] = $row->name;
		     $data['text'] = $row->text;
		     $data['bs'] = $row->bs;
		}
        $this->load->view('head.tpl',$data);
        $this->load->view('pages_edit.tpl',$data);
	}

	//修改入库
	public function save()
	{
		$id = (int)$this->input->post('id');
		$data['name'] = $this->input->post('name',true);
		$data['text'] = $this->input->post('text');
		$data['bs'] = $this->input->post('bs',true);
		$data['yid'] = (int)$this->input->post('yid');
		if(empty($data['name']) || empty($data['bs'])){
             admin_msg('数据不完整~！','javascript:history.back();','no');
		}
		if($id==0){
             $this->csdb->get_insert('pages',$data);
		}else{
             $this->csdb->get_update('pages',$id,$data);
		}
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
		$res=$this->csdb->get_del('pages',$id);
		if($ac=='all'){
			if($res){
                admin_msg('恭喜您，删除完成~！',links('pages'));
			}else{
                admin_msg('删除失败，请稍后再试~！','javascript:history.back();','no');
			}
		}else{
		    $data['error']=$res ? 'ok' : '删除失败~!';
		    echo json_encode($data);
		}
	}
}
