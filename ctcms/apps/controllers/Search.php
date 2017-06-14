<?php
/**
 * @Ctcms open source management system
 * @copyright 2008-2016 chshcms.com. All rights reserved.
 * @Author:Cheng Kai Jie
 * @Dtime:2015-12-11
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends Ctcms_Controller {

	function __construct(){
	    parent::__construct();
        //当前模版
		$this->load->get_templates();
		$this->load->library('parser');
	}

	public function index()
	{
		$array = array('wd','py','zhuyan','daoyan','diqu','yuyan','year','cid');
		$keyarr = array('zhuyan','daoyan','diqu','yuyan','year','wd');
		$sortarr = array('hits','addtime','id');
		$soarr = array();
		$key = '';
		foreach ($array as $k) {
		    $v = $this->input->get_post($k,true);
			if($k=='cid') $v = (int)$v;
			if(!empty($v)) $soarr[$k] = safe_replace($v);
			if(!empty($v) && in_array($k, $keyarr)) $key = $v;
			//当前搜索字段输出
			$data['ctcms_'.$k] = !empty($soarr[$k]) ? $soarr[$k] : '';
		}
		$sort = $this->input->get_post('sort',true);
		$order = $this->input->get_post('order',true);
		$page=(int)$this->input->get('page');
		if($page==0) $page=1;
		if(!in_array($sort, $sortarr)) $sort='addtime';
		if($order!='asc') $order='desc';
		$data['ctcms_sort'] = $sort;
		$data['ctcms_order'] = $order;

        //网站标题
        $data['ctcms_title'] = '搜索：'.$key.' - '.Web_Name;
		$data['ctcms_key'] = $key;

        //获取模板
        $str = load_file('search.html');
        //预先解析分页标签
        preg_match_all('/{ctcms:([\S]+)\s+(.*?page=\"([\S]+)\".*?)}([\s\S]+?){\/ctcms:\1}/',$str,$page_arr);
        if(!empty($page_arr) && !empty($page_arr[3])){
              //每页数量
        	  $per_page = (int)$page_arr[3][0];
	          //组装SQL数据
        	  $sql = 'select {field} from '.CT_SqlPrefix.'vod where 1=1';
			  $where = '';
			  foreach ($soarr as $k=>$v) {
				    if($k=='wd'){ //标题和主演
                        $sql.=" and (name like '%".$v."%' or zhuyan like '%".$v."%')";
					}elseif($k=='py'){ //首字母
			            $zimu_arr=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
			            $zimu_arr1=array(-20319,-20283,-19775,-19218,-18710,-18526,-18239,-17922,-1,-17417,-16474,-16212,-15640,-15165,-14922,-14914,-14630,-14149,-14090,-13318,-1,-1,-12838,-12556,-11847,-11055);
			            $zimu_arr2=array(-20284,-19776,-19219,-18711  ,-18527,-18240,-17923,-17418,-1,-16475,-16213,-15641,-15166,-14923,-14915,-14631,-14150,-14091,-13319,-12839,-1,-1,-12557,-11848,-11056,-2050);
                        if(!in_array(strtoupper($v),$zimu_arr)){
						     $sql.=" and substring( name, 1, 1 ) NOT REGEXP '^[a-zA-Z]' and substring( name, 1, 1 ) REGEXP '^[u4e00-u9fa5]'";
						}else{
			                 $posarr=array_keys($zimu_arr,strtoupper($v));
			                 $pos=$posarr[0];
			                 $sql.=" and (((ord( substring(convert(name USING gbk), 1, 1 ) ) -65536>=".($zimu_arr1[$pos])." and  ord( substring(convert(name USING gbk), 1, 1 ) ) -65536<=".($zimu_arr2[$pos]).")) or UPPER(substring(convert(name USING gbk), 1, 1 ))='".$zimu_arr[$pos]."')";
						}
					}else{ //其他
                        $sql.=" and ".$k." like '%".$v."%'";
					}
					$where .= '&'.$k.'='.urlencode($v);
			  }
			  $where .= '&sort='.$sort.'&order='.$order;

        	  $sqlstr = $this->parser->ctcms_sql($page_arr[1][0],$page_arr[2][0],$page_arr[0][0],$page_arr[4][0],$sql);
			  $sqlstr = current(explode('order by',$sqlstr)).'order by '.$sort.' '.$order;
        	  //总数量
        	  $total = $this->csdb->get_sql_nums($sqlstr);
        	  //总页数
	          $pagejs = ceil($total / $per_page);
        	  if($total<$per_page) $per_page=$total;
        	  $sqlstr .= ' limit '.$per_page*($page-1).','.$per_page;
        	  $str = $this->parser->ctcms_skins($page_arr[1][0],$page_arr[2][0],$page_arr[0][0],$page_arr[4][0],$str, $sqlstr);
              //解析分页
        	  $pagenum = getpagenum($str);
        	  $pagearr = get_page($total,$pagejs,$page,$pagenum,'search','index',0,$where);
			  $pagearr[] = $per_page;$pagearr[] = $total;$pagearr[] = $pagejs;$pagearr[] = $page;
			  $str = getpagetpl($str,$pagearr);
        }
        //全局解析
        echo $this->parser->parse_string($str,$data,true);
	}
}
