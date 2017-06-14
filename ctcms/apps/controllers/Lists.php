<?php
/**
 * @Ctcms open source management system
 * @copyright 2008-2016 chshcms.com. All rights reserved.
 * @Author:Cheng Kai Jie
 * @Dtime:2015-12-11
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Lists extends Ctcms_Controller {

	function __construct(){
	    parent::__construct();
        //当前模版
		$this->load->get_templates();
		$this->load->library('parser');
	}

	public function index($cid=0,$page=1)
	{
		if((int)$cid==0){
		    $cid=(int)$this->input->get('id');
		    $page=(int)$this->input->get('page');
		}
		if($page==0) $page=1;
		if($cid==0) msg_url('参数错误',Web_Path);

	    $cache_id ="list_".$cid."_".$page;
	    if(!($this->cache->start($cache_id))){
                $row=$this->csdb->get_row_arr('class','*',$cid);
		        if(!$row) msg_url('分类不存在~!',Web_Path);
		        $skin = empty($row['skin']) ? 'list.html' : $row['skin'];

			    //网站标题
		        $data['ctcms_title'] = $row['name'].' - '.Web_Name;
				//当前ID
				$data['ctcms_cid']=$cid;

		        //获取模板
		        $str = load_file($skin);
                //预先解析分页标签
				preg_match_all('/{ctcms:([\S]+)\s+(.*?page=\"([\S]+)\".*?)}([\s\S]+?){\/ctcms:\1}/',$str,$page_arr);
		        if(!empty($page_arr) && !empty($page_arr[3])){
                      //每页数量
					  $per_page = (int)$page_arr[3][0];
				      //组装SQL数据
					  $sql = 'select {field} from '.CT_SqlPrefix.'vod where cid='.$cid;
					  $sqlstr = $this->parser->ctcms_sql($page_arr[1][0],$page_arr[2][0],$page_arr[0][0],$page_arr[4][0],$sql);
					  //总数量
					  $total = $this->csdb->get_sql_nums($sqlstr);
					  //总页数
	                  $pagejs = ceil($total / $per_page);
					  if($total<$per_page) $per_page=$total;
					  $sqlstr .= ' limit '.$per_page*($page-1).','.$per_page;
					  $str = $this->parser->ctcms_skins($page_arr[1][0],$page_arr[2][0],$page_arr[0][0],$page_arr[4][0],$str, $sqlstr);
                      //解析分页
					  $pagenum = getpagenum($str);
					  $pagearr = get_page($total,$pagejs,$page,$pagenum,'lists','index',$cid); 
			          $pagearr[] = $per_page;$pagearr[] = $total;$pagearr[] = $pagejs;$pagearr[] = $page;
			          $str = getpagetpl($str,$pagearr);
				}
				//全局解析
		        $str=$this->parser->parse_string($str,$data,true,false);
				//当前数据
		        $str=$this->parser->ctcms_tpl('class',$str,$str,$row);
				//IF判断解析
		        $str=$this->parser->labelif($str);
				echo $str;
		        $this->cache->end();
		}  
	}
}
