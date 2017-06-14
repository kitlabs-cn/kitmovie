<?php
/**
 * @Ctcms open source management system
 * @copyright 2016-2017 ctcms.cn. All rights reserved.
 * @Author:Chi Tu
 * @Dtime:2016-08-11
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends Ctcms_Controller {

	function __construct(){
	    parent::__construct();
        //当前模版
		$this->load->get_templates();
		$this->load->library('parser');
		//判断是否安装
		if(!file_exists(FCPATH.'caches/install.lock')){
	        header("location:".links('install'));exit;
		}
	}

	public function index($page=1)
	{
		$page=(int)$page;
		if($page==0) $page=(int)$this->input->get('page');
		
		if($page==0) $page=1;
	    $cache_id ="index_home_".$page;
	    if(!($this->cache->start($cache_id))){

                //这里可以自定义数组内容到模板 ，$data['title'] = '内容';
			    $data = array();

		        //获取模板
		        $str = load_file('index.html');
                //预先解析分页标签
				preg_match_all('/{ctcms:([\S]+)\s+(.*?page=\"([\S]+)\".*?)}([\s\S]+?){\/ctcms:\1}/',$str,$page_arr);
		        if(!empty($page_arr) && !empty($page_arr[3])){
                      //每页数量
					  $per_page = (int)$page_arr[3][0];
				      //组装SQL数据
					  $sqlstr = $this->parser->ctcms_sql($page_arr[1][0],$page_arr[2][0],$page_arr[0][0],$page_arr[4][0]);
					  //总数量
					  $total = $this->csdb->get_sql_nums($sqlstr);
					  //总页数
	                  $pagejs = ceil($total / $per_page);
					  if($total<$per_page) $per_page=$total;
					  $sqlstr .= ' limit '.$per_page*($page-1).','.$per_page;
					  $str = $this->parser->ctcms_skins($page_arr[1][0],$page_arr[2][0],$page_arr[0][0],$page_arr[4][0],$str, $sqlstr);
                      //解析分页
					  $pagenum = getpagenum($str);
					  $pagearr = get_page($total,$pagejs,$page,$pagenum,'index'); 
			          $pagearr[] = $per_page;$pagearr[] = $total;$pagearr[] = $pagejs;$pagearr[] = $page;
			          $str = getpagetpl($str,$pagearr);
				}
				//全局解析
		        $str=$this->parser->parse_string($str,$data,true);
				echo $str;
		        $this->cache->end();
		}
	}

	//保存到桌面
	public function short()
	{
            $Shortcut = "[InternetShortcut] 
                URL=http://".Web_Url.Web_Path."
                IDList= 
                [{000214A0-0000-0000-C000-000000000046}] 
                Prop3=19,2 
            "; 
            Header("Content-type: application/octet-stream"); 
            header("Content-Disposition: attachment; filename=".Web_Name.".url;"); 
            echo $Shortcut;
	}
}
