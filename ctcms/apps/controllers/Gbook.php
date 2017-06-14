<?php
/**
 * @Ctcms open source management system
 * @copyright 2016-2017 ctcms.cn. All rights reserved.
 * @Author:Chi Tu
 * @Dtime:2016-08-11
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Gbook extends Ctcms_Controller {

	function __construct(){
	    parent::__construct();
        //当前模版
		$this->load->get_templates();
		$this->load->library('parser');
		if(Gbook_Is==0) msg_url('留言已关闭~!','javascript:history.back();');
	}

	public function index($page=1)
	{
		$page=(int)$page;
		if($page==0) $page=(int)$this->input->get('page');
		if($page==0) $page=1;

		$data['ctcms_formurl'] = links('gbook','save');
		$data['ctcms_codeurl'] = links('code');
		//网站标题
		$data['ctcms_title'] = '意见留言 - '.Web_Name;

		//获取模板
        $skin = 'gbook.html';
		$str = load_file($skin);
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
					  $pagearr = get_page($total,$pagejs,$page,$pagenum,'gbook','index'); 
			          $pagearr[] = $per_page;$pagearr[] = $total;$pagearr[] = $pagejs;$pagearr[] = $page;
			          $str = getpagetpl($str,$pagearr);
		}
		//全局解析
		$this->parser->parse_string($str,$data);
	}

	public function save()
	{
		$add['name'] = $this->input->post('name', TRUE);
		$add['content'] = $this->input->post('content', TRUE);
        $code = $this->input->post('code',true);
		if(empty($add['name']) || empty($add['content'])) msg_url('名字、内容不能为空~!','javascript:history.back();');
		if(strtolower($code)!=$_SESSION['codes'] && strtolower($code)!=$_COOKIE['codes']) msg_url('验证码不正确~!','javascript:history.back();');

		//判断留言时间
		if(isset($_SESSION['book_time']) && $_SESSION['book_time']>time()){
           msg_url('距离上次留言时间太短，视为灌水~!','javascript:history.back();');
		}

		//过滤留言内容
		$arr = explode('|',Gbook_Str);
		for($i=0;$i<count($arr);$i++){
		    $add['content'] = str_replace($arr[$i],'***',$add['content']);
		}

		//入库
		$add['yid'] = Gbook_Sh;
		$add['addtime'] = time();
		$res = $this->csdb->get_insert('gbook',$add);
		if($res){
            $_SESSION['book_time'] = time()+60;
		    //直接跳转
            if(Gbook_Sh==1){
		        msg_url('留言成功，请等待管理员审核~!',links('gbook'));
			}else{
                header("location:".links('gbook'));
			}
		}else{
            msg_url('留言失败，稍候再试~!','javascript:history.back();');
		}
	}
}
