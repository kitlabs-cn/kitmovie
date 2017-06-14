<?php
/**
 * @Ctcms open source management system
 * @copyright 2008-2016 chshcms.com. All rights reserved.
 * @Author:Cheng Kai Jie
 * @Dtime:2015-12-11
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends Ctcms_Controller {

	function __construct(){
	    parent::__construct();
        //当前模版
		$this->load->get_templates('install');
        $this->load->helper('file');
		//判断是否安装
		if(strpos($_SERVER['REQUEST_URI'],'setup7') === FALSE && file_exists(FCPATH.'caches/install.lock')){
	        echo $this->load->view('install_ok.html',null,true);exit;
		}
	}

	public function index()
	{
        $SELF = !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF']; 
        $basepath = ltrim($SELF,'/');
        $arr = explode("index.php",$basepath);
        $data['web_path'] = substr($arr[0],0,1)!='/' ? '/'.$arr[0] : $arr[0];

        //修改配置文件
	    $config=read_file("./ctcms/libs/Ct_Config.php");
	    $config=preg_replace("/'Web_Mode',(.*?)\)/","'Web_Mode',2)",$config);
		$config=preg_replace("/'Web_Path','(.*?)'/","'Web_Path','".$data['web_path']."'",$config);
		$config=preg_replace("/'Base_Path','(.*?)'/","'Base_Path','".$data['web_path']."packs/'",$config);
	    write_file('./ctcms/libs/Ct_Config.php', $config);
	    $this->load->view('install_1.html',$data);
	}

	public function setup()
	{
        $SELF = !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF']; 
        $basepath = ltrim($SELF,'/');
        $arr = explode("index.php",$basepath);
        $data['web_path'] = substr($arr[0],0,1)!='/' ? '/'.$arr[0] : $arr[0];
	    $this->load->view('install_2.html',$data);
	}

	public function setup2()
	{
        $webname = $this->input->post('name',true);
        $weburl = $this->input->post('url',true);
        $webpath = $this->input->post('path',true);
		if(empty($weburl)) $weburl = $_SERVER['HTTP_HOST'];
		if(empty($webpath)) $webpath = '/';
        //修改配置文件
	    $config=read_file("./ctcms/libs/Ct_Config.php");
	    $config=preg_replace("/'Web_Name','(.*?)'/","'Web_Name','".$webname."'",$config);
	    $config=preg_replace("/'Web_Url','(.*?)'/","'Web_Url','".$weburl."'",$config);
	    $config=preg_replace("/'Web_Path','(.*?)'/","'Web_Path','".$webpath."'",$config);
	    if(!write_file('./ctcms/libs/Ct_Config.php', $config)){
			 exit("<script>alert('./ctcms/libs/Ct_Config.php文件没有修改权限');location.href='".links('install','setup')."';</script>");
		}
        header("location:".links('install','setup3'));exit;
	}

	public function setup3()
	{
	    $this->load->view('install_3.html');
	}

	public function setup4()
	{
        $driver = $this->input->post('driver',true);
        $host = $this->input->post('server',true);
        $name = $this->input->post('name',true);
        $user = $this->input->post('user');
        $pass = $this->input->post('pass');
        $prefix = $this->input->post('prefix',true);

		if(empty($driver) || empty($host) || empty($name) || empty($user)){
             exit("<script>alert('请把资料填写完整');history.go(-1);</script>");
		}

		//修改数据库配置
        $this->load->helper('string');
        $CT_Encryption_Key='ctcms_'.random_string('alnum',10);
	    $config=read_file("./ctcms/libs/Ct_DB.php");
	    $config=preg_replace("/'CT_Sqlserver','(.*?)'/","'CT_Sqlserver','".$host."'",$config);
	    $config=preg_replace("/'CT_Sqlport','(.*?)'/","'CT_Sqlport','".$port."'",$config);
	    $config=preg_replace("/'CT_Sqlname','(.*?)'/","'CT_Sqlname','".$name."'",$config);
	    $config=preg_replace("/'CT_Sqluid','(.*?)'/","'CT_Sqluid','".$user."'",$config);
	    $config=preg_replace("/'CT_Sqlpwd','(.*?)'/","'CT_Sqlpwd','".$pass."'",$config);
	    $config=preg_replace("/'CT_Dbdriver','(.*?)'/","'CT_Dbdriver','".$driver."'",$config);
	    $config=preg_replace("/'CT_SqlPrefix','(.*?)'/","'CT_SqlPrefix','".$prefix."'",$config);
	    $config=preg_replace("/'CT_Encryption_Key','(.*?)'/","'CT_Encryption_Key','".$CT_Encryption_Key."'",$config);
	    if(!write_file('./ctcms/libs/Ct_DB.php', $config)){
			exit("<script>alert('./ctcms/libs/Ct_DB.php文件没有修改权限');history.go(-1);</script>");
		}

        //导入数据表
        $msg=$this->dbsql($driver, $host, $user, $pass, $name, $prefix);
        if($msg!='ok') exit("<script>alert('".$msg."');history.go(-1);</script>");

        header("location:".links('install','setup5'));exit;
	}

	public function setup5()
	{
	    $this->load->view('install_4.html');
	}

	public function setup6()
	{
        $user = $this->input->post('user',true);
        $pass = $this->input->post('pwd',true);
        $code = $this->input->post('code',true);
        $mode = (int)$this->input->post('mode',true);
		if($mode==0) $mode=2;

		if(empty($user) || empty($pass) || empty($code)){
             exit("<script>alert('请把资料填写完整');history.go(-1);</script>");
		}
        $this->load->model('csdb');
		$add['name']=$user;
		$add['nichen']='管理员';
		$add['pass']=md5($pass);
		$res=$this->csdb->get_insert('admin',$add);
		if(!$res) exit("<script>alert('管理员增加失败!');history.go(-1);</script>");

		if(!write_file('./caches/install.lock', 'ctcms')){
			exit("<script>alert('./caches/目录没有写入权限!');history.go(-1);</script>");
        }

        //修改配置文件
	    $config=read_file("./ctcms/libs/Ct_Config.php");
	    $config=preg_replace("/'Web_Mode',(.*?)\)/","'Web_Mode',".$mode.")",$config);
	    $config=preg_replace("/'Admin_Code','(.*?)'/","'Admin_Code','".$code."'",$config);
	    write_file('./ctcms/libs/Ct_Config.php', $config);

		$links = $mode==1 ? Web_Path.'index.php/install/setup7' : links('install','setup7');
        header("location:".$links);exit;
	}

	public function setup7()
	{
	    $this->load->view('install_5.html');
	}

    //导入数据库
	protected function dbsql($driver, $host, $user, $pass, $name, $prefix)
	{
		if($driver=='mysqli'){
            $mysqli = new mysqli($host,$user,$pass);
            //检查连接是否成功
            if (mysqli_connect_errno()){
	            return '数据库链接失败~';
            }
			if(!$mysqli->select_db($name)){
				if(!$mysqli->query("CREATE DATABASE `".$name."`")){
				    return '数据库表《'.$name.'》不存在，请手动创建~';
				}
				$mysqli->select_db($name);
			}
			$mysqli->query("SET NAMES utf8");
            //导入数据表
	        $sql=read_file("./caches/ctcms.sql");
            $sql=str_replace('{Prefix}',$prefix,$sql);
	        $sqlarr=explode("#ctcms#",$sql);
	        for($i=0;$i<count($sqlarr);$i++){
				  if(!empty($sqlarr[$i])){
		               $mysqli->query($sqlarr[$i]);
				  }
	        }
		}else{
			$lnk=mysql_connect($host,$user,$pass);
			if(!$lnk) return '数据库连接失败';
			if(!mysql_select_db($name,$lnk)){
				if(!mysql_query("CREATE DATABASE `".$name."`")){
				    return '数据库表《'.$name.'》不存在，请手动创建~';
				}
				mysql_select_db($name,$lnk);
			}
	        mysql_query("SET NAMES utf8", $lnk);
            //导入数据表
	        $sql=read_file("./caches/ctcms.sql");
            $sql=str_replace('{Prefix}',$prefix,$sql);
	        $sqlarr=explode("#ctcms#",$sql);
	        for($i=0;$i<count($sqlarr);$i++){
				  if(!empty($sqlarr[$i])){
		               mysql_query($sqlarr[$i]);
				  }
	        }
		}
		return 'ok';
	}
}
