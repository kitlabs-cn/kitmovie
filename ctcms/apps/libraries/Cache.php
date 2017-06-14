<?php
/**
 * @Ctcms open source management system
 * @copyright 2016-2017 ctcms.cn. All rights reserved.
 * @Author:Chi Tu
 * @Dtime:2016-08-11
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 文件缓存类
 */
class Cache {

    function __construct ()
	{
			$this->_dir  = FCPATH."caches/tpl/";
			$this->_time = (!defined('PLUBPATH')) ? Cache_Time : config('Cache_Time');;
			$this->_is   = (!defined('PLUBPATH')) ? Cache_Is : config('Cache_Is');
	}

    //读取缓存
	function get($cacheid){
	    if(defined('MOBILE')) $cacheid.='-wap';
		$this->_id = md5($cacheid);
		if(file_exists($this->_dir.$this->_id) && ((time() - filemtime($this->_dir.$this->_id)) < $this->_time)){
			$data = @file_get_contents($this->_dir.$this->_id);
			return $data;
		}else{
			return false;
		}
	}  

    //写入缓存
	function save($data){
		if(!is_writable($this->_dir)){
			if(!@mkdir($this->_dir,0777,true)){
				echo 'Cache directory not writable';
				exit;
			}
		}
		@file_put_contents($this->_dir.$this->_id,$data);
		return true;
	}

    //获取缓存
	function start($id,$time=0){
		if($time>0){  //单独页面缓存时间，time大于0则开启，time为时间秒数
			$this->_time = $time;
			$this->_is = 1;		
		}
		if($this->_is==0){ //关闭缓存
		    return false;
		}
		$data = $this->get($id);
		if($data !== false){
			exit($data);
			return true;
		}
		ob_start();
		ob_implicit_flush(false);
		return false;
	}

	function end(){
		if($this->_is==1){
		    $data = ob_get_contents();
		    ob_end_clean();
			$this->save($data);
		    echo($data);
		}
	}
}

