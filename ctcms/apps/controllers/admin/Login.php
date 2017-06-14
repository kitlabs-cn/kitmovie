<?php
/**
 * @Ctcms open source management system
 * @copyright 2016-2017 ctcms.cn. All rights reserved.
 * @Author:Chi Tu
 * @Dtime:2016-08-11
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Ctcms_Controller {

	function __construct() {
	    parent::__construct();
		//加载后台模型
		$this->load->model('admin');
        //当前模版
		$this->load->get_templates('admin');
	}

	public function index()
	{
		$this->load->view('head.tpl');
		$this->load->view('login.tpl');
	}
	
	public function save()
	{
	    $adminname = $this->input->post('name', TRUE);
	    $adminpass = $this->input->post('pass', TRUE);
	    $admincode = $this->input->post('code', TRUE);

		if(empty($adminname)){
			$error='账号不能为空!';  
		}elseif(empty($adminpass)){
			$error='密码不能为空!'; 
		}elseif(empty($admincode)){
			$error='认证码不能为空!'; 
        }elseif($admincode!=Admin_Code){
			$error='认证码错误!'; 
		}else{
            $where = array('name'=>$adminname,'pass'=>md5($adminpass));
		    $row=$this->csdb->get_row('admin','*',$where);
		    if($row){

				//写入登陆日志
			    $this->load->library('user_agent');
				$agent = ($this->agent->is_mobile() ? $this->agent->mobile() : $this->agent->platform()).'&nbsp;/&nbsp;'.$this->agent->browser().' v'.$this->agent->version();
				$add['uid']=$row->id;
				$add['ip']=getip();
				$add['ua']=$agent;
				$add['logtime']=time();
                $this->csdb->get_insert('admin_log',$add);

				//删除日志
				if(Admin_Log_Day>0){
                     $times=time()-Admin_Log_Day*86400;
					 $this->csdb->get_del('admin_log',$times,'logtime<');
				}

                //保存SESSION
				$login = md5($row->id.$row->name.$row->pass.Admin_Code);
				$logip = empty($row->logip) ? '未登陆' : $row->logip;
				$logtime = empty($row->logtime) ? '未登陆' : date('Y-m-d H:i:s',$row->logtime);
				$this->session->set_tempdata('admin_id', $row->id, 86400);
				$this->session->set_tempdata('admin_nichen', $row->nichen, 86400);
				$this->session->set_tempdata('admin_login', $login, 86400);
				//上次登陆时间和IP
				$this->session->set_tempdata('admin_logip', $logip, 86400);
				$this->session->set_tempdata('admin_logtime', $logtime, 86400);

                //修改登陆次数
                $updata['lognum']=$row->lognum+1;
                $updata['logip']=getip();
                $updata['logtime']=time();
                $this->csdb->get_update('admin',$row->id,$updata);

		        $error='ok';				
		    }else{
				$error='账号密码不匹配';
			}
		}
		$data['error']=$error;
		echo json_encode($data);
	}
}