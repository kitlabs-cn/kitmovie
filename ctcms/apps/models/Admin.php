<?php
/**
 * @Ctcms open source management system
 * @copyright 2016-2017 ctcms.cn. All rights reserved.
 * @Author:Chi Tu
 * @Dtime:2016-05-11
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Model
{
    function __construct (){
	   parent:: __construct ();
	   //判断后台访问IP
	   if(!$this->login_ip()){
           show_404("admin");exit;
	   }
	   $this->load->library('session');
    }
	
    //判断后台是否登入
    function login($key='',$sid=0){
		  if(empty($key)){
              $id = !isset($_SESSION['admin_id']) ? 0 : $_SESSION['admin_id'];
              $login =  !isset($_SESSION['admin_login']) ? '' :  $_SESSION['admin_login'];
		  }else{
			  $str  = unserialize(stripslashes(sys_auth($key,'D')));
              $id   = isset($str['id'])?intval($str['id']):0;
              $login = isset($str['login'])?$str['login']:'';
		  }
          if(empty($id) || empty($login)){
			    if($sid==0){
                    die("<script language='javascript'>top.location='".links('login')."';</script>");
				}else{
                    return 0;
				} 
          }else{
                $admin=$this->csdb->get_row('admin','name,pass',array('id'=>$id));
		        if($admin){
                       if(md5($id.$admin->name.$admin->pass.Admin_Code)!=$login){
					       if($sid==0){
                               die("<script language='javascript'>top.location='".links('login')."';</script>");
					       }else{
						       return 0;
					       }
                       }
                }else{
					if($sid==0){
                        die("<script language='javascript'>top.location='".links('login')."';</script>");
					}else{
						return 0;
					}
                }
          }
		  if($sid==1) return 1;
    }

	//获取角色下所有管理员
    function role_arr($zid){
		  $admin=array();
          $arr=$this->csdb->get_select('admin','name',array('zid'=>$zid),'id DESC');
          foreach ($arr as $row) {
              $admin[]=$row->name;
		  }
		  if(!empty($admin)){
               $admin=implode(',',$admin);
		  }else{
               $admin='暂无';
		  }
		  return $admin;
	}

	//判断后台访问IP
    function login_ip(){
		  $logip=getip();
	      if(Admin_Log_Ip!=''){
              $iparr=explode('|',Admin_Log_Ip);
			  for($i=0;$i<count($iparr);$i++){
                  if($logip==$iparr[$i]){
                      return true;
				  }
			  }
			  return false;
	      }else{
              return true;
		  }
	}
}