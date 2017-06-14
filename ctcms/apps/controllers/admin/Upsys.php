<?php
/**
 * @Ctcms open source management system
 * @copyright 2008-2016 chshcms.com. All rights reserved.
 * @Author:Cheng Kai Jie
 * @Dtime:2015-12-11
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Upsys extends Ctcms_Controller {

	function __construct(){
	    parent::__construct();
		//加载后台模型
		$this->load->model('admin');
        //当前模版
		$this->load->get_templates('admin');
		//判断是否登陆
		$this->admin->login();
	}

	//更新版本
	public function index()
	{
 	    $v = $this->input->get('v');
	    if(empty($v)) admin_msg('参数错误~！','javascript:history.back();','no');
		
		//获取官方版本
		$zipurl = Ct_Upurl.'upsys/v'.$v.'.zip';
		//保存路径
		$filename = FCPATH."attachment/zip/v_".$v.".zip";
		$this->down($zipurl,$filename);
		//解压缩
	    $this->load->library('ctzip');
		$this->ctzip->PclZip($filename);
		if ($this->ctzip->extract(PCLZIP_OPT_PATH, FCPATH, PCLZIP_OPT_REPLACE_NEWER) == 0) {
              @unlink($filename);
			  admin_msg('文件解压失败，或者没有权限~！','javascript:history.back();','no');
		}else{
			  @unlink($filename);
			  admin_msg('版本升级成功~！',links('main'));
		}
	}

    //下载zip到本地
    function down($file,$filename) {   
        if (! $file) {  
           admin_msg('地址错误~！','javascript:history.back();','no');
        }   
        if (ini_get('allow_url_fopen')) {
            $data=@file_get_contents($file);
        }
        if (empty($data) && function_exists('curl_init') && function_exists('curl_exec')) {
			$curl = curl_init(); //初始化curl
			curl_setopt($curl, CURLOPT_URL, $file); //设置访问的网站地址
			curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); //模拟用户使用的浏览器
			curl_setopt($curl, CURLOPT_AUTOREFERER, 1);    //自动设置来路信息
			curl_setopt($curl, CURLOPT_TIMEOUT, 30);      //设置超时限制防止死循环
			curl_setopt($curl, CURLOPT_HEADER, 0);         //显示返回的header区域内容
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //获取的信息以文件流的形式返回
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 
			$data = curl_exec($curl);
			curl_close($curl);
        }
        if(empty($data)){
            admin_msg('该版本附件不存在，请稍后~！','javascript:history.back();','no');
        }else{
            if (!@file_put_contents($filename, $data)){
                 admin_msg('版本附件保存失败，请检查/attachment/zip/目录权限~！','javascript:history.back();','no');
            }
        }
    } 
}
