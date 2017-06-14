<?php 
/**
 * @Ctcms open source management system
 * @copyright 2016-2017 ctcms.cn. All rights reserved.
 * @Author:Chi Tu
 * @Dtime:2016-08-11
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Basedb extends Ctcms_Controller {
	function __construct(){
	    parent::__construct();
		//加载后台模型
		$this->load->model('admin');
		$this->load->model('backup');
        //当前模版
		$this->load->get_templates('admin');
		//判断是否登陆
		$this->admin->login();
	}
	public function index()
	{
			$data['tables']=$this->db->query("SHOW TABLE STATUS FROM `".CT_Sqlname."`")->result_array();
            $this->load->view('head.tpl',$data);
            $this->load->view('basedb.tpl');
	}

    //还原数据库
	public function restore()
	{
			$this->load->helper('directory');
            $data['map'] = directory_map(FCPATH.'attachment/backup/', 1);
            $this->load->view('head.tpl',$data);
            $this->load->view('basedb_hy.tpl',$data);
	}
    //优化表
	public function optimize()
	{
			$error=array();
		    $this->load->dbutil();
		    $tables = $this->input->get('table',true);
			if(empty($tables)){
		        $tables = $this->input->post('id',true);
			    if(empty($tables)) admin_msg('请选择要操作的数据表','javascript:history.back();','no');
			    foreach($tables as $table) {
				    if(!$this->dbutil->optimize_table($table)){
                         $error[]=$table;
				    }
			    }
			}else{
				if(!$this->dbutil->optimize_table($tables)){
                     $error[]=$tables;
				}
			}
			if(!empty($error)){
                admin_msg('抱歉，表：'.implode(',', $error).'优化失败~!',site_url('basedb'),'no');
			}else{
                admin_msg('恭喜您，优化完成。',links('basedb'));
			}
	}
    //修复表
	public function repair()
	{
			$error=array();
		    $this->load->dbutil();
		    $tables = $this->input->get('table',true);
			if(empty($tables)){
		        $tables = $this->input->post('id',true);
			    if(empty($tables)) admin_msg('请选择要操作的数据表','javascript:history.back();','no');
			    foreach($tables as $table) {
				    if(!$this->dbutil->repair_table($table)){
                         $error[]=$table;
				    }
			    }
			}else{
				if(!$this->dbutil->repair_table($tables)){
                     $error[]=$tables;
				}
			}
			if(!empty($error)){
                admin_msg('抱歉，表：'.implode(',', $error).'修复失败~!','javascript:history.back();','no');
			}else{
                admin_msg('恭喜您，修复完成。',links('basedb'));
			}
	}
    //备份数据库
	public function backup()
	{
			$tables = $this->input->post('id',true);
			if(empty($tables)) admin_msg('请选择要备份的数据表','javascript:history.back();','no');
            $res=$this->backup->backup($tables);
			if($res){
                 admin_msg('恭喜您，数据全部备份完成。',links('basedb','restore'));
			}else{
                 admin_msg('抱歉，数据表结构备份失败~!','javascript:history.back();','no');
			}
	}

	//还原数据库
	public function restore_save()
	{
			$dirs = $this->input->get('dir',true);
			if(empty($dirs)) admin_msg('抱歉，请选择要还原的数据~!','javascript:history.back();','no');
			$this->backup->restore($dirs);
            admin_msg('恭喜您，数据还原成功。',links('basedb','restore'));
	}
	//备份打包下载
	public function zip()
	{
			$dirs = $this->input->get('dir',true);
			if(empty($dirs)) admin_msg('抱歉，请选择要打包的数据~!','javascript:history.back();','no');
		    $this->load->library('zip');
            $path = FCPATH.'attachment/backup/'.$dirs.'/';
		    $this->zip->read_dir($path, FALSE);
		    $this->zip->download($dirs.'.zip'); 
	}

	//备份删除
	public function del()
	{
			$dir = $this->input->get('dir',true);
			if(empty($dir)){
			    $dirs = $this->input->post('id',true);
			}else{
			    $dirs[]=$dir;
			}
			if(empty($dirs)) admin_msg('抱歉，请选择要删除的数据~!','javascript:history.back();','no');
			foreach($dirs as $dir) {
                    deldir(FCPATH.'attachment/backup/'.$dir);
			}
            admin_msg('恭喜您，备份删除成功。',links('basedb','restore'));
	}
}

