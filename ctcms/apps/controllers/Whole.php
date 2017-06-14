<?php
/**
 * @Ctcms open source management system
 * @copyright 2008-2016 chshcms.com. All rights reserved.
 * @Author:Cheng Kai Jie
 * @Dtime:2015-12-11
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Whole extends Ctcms_Controller {

	function __construct(){
	    parent::__construct();
        //当前模版
		$this->load->get_templates();
		$this->load->library('parser');
	}

	public function index($key='')
	{
		if(empty($key)) $key = $this->input->get('key',true);
		$key = rawurldecode(get_bm($key));
		$arr = explode('~',$key); //分割,1分类ID、2地区、3类型、4语言、5时间、6清晰度、7状态、8收费、9排序、10分页
		$cid=$buy=$page=0;$diqu=$type=$year=$state=$info=$yuyan='';$sort='addtime';$order='desc';
		$sortarr = array('hits','yhits','zhits','rhits','addtime','id');
		if(!empty($arr[0])) $cid=(int)$arr[0];
		if(!empty($arr[1])) $diqu=safe_replace($arr[1]);
		if(!empty($arr[2])) $type=safe_replace($arr[2]);
		if(!empty($arr[3])) $yuyan=safe_replace($arr[3]);
		if(!empty($arr[4])) $year=safe_replace($arr[4]);
		if(!empty($arr[5])) $info=safe_replace($arr[5]);
		if(!empty($arr[6])) $state=safe_replace($arr[6]);
		if(!empty($arr[7])) $buy=$arr[7];
		if(!empty($arr[8])) $sort=$arr[8];
		if(!empty($arr[9])) $page=(int)$arr[9];
		if(!in_array($sort, $sortarr)) $sort='addtime';
		if($page==0) $page=1;
		$where = $cid.'~'.$diqu.'~'.$type.'~'.$yuyan.'~'.$year.'~'.$info.'~'.$state.'~'.$buy.'~'.$sort.'~';

		//当前搜索字段输出
		$data['ctcms_cid'] = $cid; //分类ID
		$data['ctcms_diqu'] = $diqu; //地区
		$data['ctcms_yuyan'] = $yuyan; //语言
		$data['ctcms_type'] = $type; //类型
		$data['ctcms_year'] = $year; //年份
		$data['ctcms_info'] = $info; //清晰度
		$data['ctcms_state'] = $state; //状态
		$data['ctcms_buy'] = $buy; //是否收费
		$data['ctcms_sort'] = $sort; //排序

        //网站标题
        $data['ctcms_title'] = '视频智能检索 - '.Web_Name;

        //获取模板
        $str = load_file('whole.html');
        //预先解析分页标签
        preg_match_all('/{ctcms:([\S]+)\s+(.*?page=\"([\S]+)\".*?)}([\s\S]+?){\/ctcms:\1}/',$str,$page_arr);
        if(!empty($page_arr) && !empty($page_arr[3])){
              //每页数量
        	  $per_page = (int)$page_arr[3][0];
	          //组装SQL数据
        	  $sql = 'select {field} from '.CT_SqlPrefix.'vod where 1=1';
			  if($cid>0) $sql.=" and cid=".$cid;
			  if(!empty($diqu)) $sql.=" and diqu like '%".$diqu."%'";
			  if(!empty($type)) $sql.=" and type like '%".$type."%'";
			  if(!empty($year)) $sql.=" and year like '%".$year."%'";
			  if(!empty($info)) $sql.=" and info like '%".$info."%'";
			  if(!empty($yuyan)) $sql.=" and yuyan like '%".$yuyan."%'";
			  if(!empty($state)){
				  if($state=='全集' || $state=='完结'){
				      $sql.=" and (state like '%".$state."%' or state like '%完结%')";
				  }elseif($state=='更新' || $state=='预告'){
				      $sql.=" and state like '%".$state."%'";
				  }else{
				      $sql.=" and (state NOT like '%更新%' and state NOT like '%全集%' and state NOT like '%完结%')";
				  }
			  }
			  if($buy==1) $sql.=" and (vip=0 and cion=0)"; //免费
			  if($buy==2) $sql.=" and (vip=1 or cion>0)"; //收费
			  if($buy==3) $sql.=" and cion>0"; //点播
			  if($buy==4) $sql.=" and vip=1"; //包月

        	  $sqlstr = $this->parser->ctcms_sql($page_arr[1][0],$page_arr[2][0],$page_arr[0][0],$page_arr[4][0],$sql);
			  $sqlstr = current(explode('order by',$sqlstr)).'order by '.$sort.' desc';
        	  //总数量
        	  $total = $this->csdb->get_sql_nums($sqlstr);
        	  //总页数
	          $pagejs = ceil($total / $per_page);
        	  if($total<$per_page) $per_page=$total;
        	  $sqlstr .= ' limit '.$per_page*($page-1).','.$per_page;
			  //exit($sqlstr);
        	  $str = $this->parser->ctcms_skins($page_arr[1][0],$page_arr[2][0],$page_arr[0][0],$page_arr[4][0],$str, $sqlstr);
              //解析分页
        	  $pagenum = getpagenum($str);
        	  $pagearr = get_page($total,$pagejs,$page,$pagenum,'whole','index',0,$where);
			  $pagearr[] = $per_page;$pagearr[] = $total;$pagearr[] = $pagejs;$pagearr[] = $page;
			  $str = getpagetpl($str,$pagearr);
        }
        //全局解析
        $str = $this->parser->parse_string($str,$data,true,false);
		//解析智能检索链接
        preg_match_all('/\[whole:url\s+([0-9a-zA-Z]+)=(.*?)\]/',$str,$u_arr);
        for($i=0;$i<count($u_arr[0]);$i++){
               $wheres = whole_url($u_arr[1][$i],$u_arr[2][$i],$where);
			   $str = str_replace($u_arr[0][$i],links('whole','index',0,$wheres),$str);
		}
		//IF判断解析
		$str=$this->parser->labelif($str);
		echo $str;
	}
}
