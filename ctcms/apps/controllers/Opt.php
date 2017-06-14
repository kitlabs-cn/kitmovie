<?php
/**
 * @Ctcms open source management system
 * @copyright 2008-2016 chshcms.com. All rights reserved.
 * @Author:Cheng Kai Jie
 * @Dtime:2015-12-11
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Opt extends Ctcms_Controller {

	function __construct(){
	    parent::__construct();
        //当前模版
		$this->load->get_templates();
		$this->load->library('parser');
	}

	public function index($bs='')
	{
		//标识
		if(empty($bs)){
		    $bs=$this->input->get('id');
		}
		$bs=str_checkhtml($bs,1);
		if(empty($bs)) msg_url('参数错误',Web_Path);

		$data = array();
		if($bs=='hotest'){
		    //抓取页面内容，缓存到明天凌晨
		    $cachefile=FCPATH."caches/tpl/".md5("Hotest_157503886");
		    if(file_exists($cachefile) && date('Y-m-d',filemtime($cachefile))==date('Y-m-d')){
		         $hotest=file_get_contents($cachefile);
		    }else{
		         $hotest=$this->get_neir();
			     @file_put_contents($cachefile,$hotest);
		    }
			$data['hotest'] = $hotest;
		}

	    $cache_id ="opt_".$bs;
	    if(!($this->cache->start($cache_id))){
		      //获取模板
		      $str=load_file('opt-'.$bs.'.html');
			  //全局解析
		      $str=$this->parser->parse_string($str,$data,true);
		      echo $str;
		      $this->cache->end();
		}
	}

    //抓取电影排行
	function get_neir(){
        $neir=file_get_contents('http://www.mtime.com/hotest/index.html');
        preg_match_all('/<div class="mtipmid">([\s\S]+?)<div id="PageNavigator" class="pagenav mt30 pt12">/',$neir,$arr);
        preg_match_all('/<div class="showmtip">([\s\S]+?)<\/div>/',$neir,$arr2);
        $html=$arr[1][0];
        for($i=0;$i<count($arr2[0]);$i++){
            $html=str_replace($arr2[0][$i],"",$html);
        }
		$qian=array("  ","		","	","?",' target="_blank"');$hou=array("","","","","");
        $html=str_replace($qian,$hou,$html);  
        $html=preg_replace('/href=".*?"/i','href="javascript:void(0);"',$html);
        preg_match_all('/<dt><a href="([\s\S]+?)">([\s\S]+?)<\/a><\/dt>/',$html,$arr3);
        for($i=0;$i<count($arr3[2]);$i++){
            $all=explode("&nbsp;",$arr3[2][$i]);
			$nameall=$arr3[0][$i];
			if(!empty($all[0])){
				$row=$this->db->query("SELECT id FROM ".CT_SqlPrefix."vod where name='".$all[0]."'")->row();
				if($row){
                      $nameall=str_replace($arr3[1][$i],links('show','index',$row->id).'" style="color:#0074a9"  target="_blank',$nameall);
				}else{
                      $nameall=strip_tags($nameall,'<dt>');
				}
            }
            $html=str_replace($arr3[0][$i],$nameall,$html);
        }
        return $html;
	}
}
