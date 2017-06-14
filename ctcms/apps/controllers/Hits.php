<?php
/**
 * @Ctcms open source management system
 * @copyright 2008-2016 chshcms.com. All rights reserved.
 * @Author:Cheng Kai Jie
 * @Dtime:2015-12-11
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Hits extends Ctcms_Controller {

	function __construct(){
	    parent::__construct();
	}

	public function index()
	{
		   $id=(int)$this->input->get('id');
		   if($id==0){
		       $id=(int)$this->uri->segment(3);
		   }
		   if($id==0) exit();

		   //清空月人气
           $month=file_get_contents(FCPATH."caches/month.txt");
		   if($month!=date('m')){
			    $this->db->query("update ".CT_SqlPrefix."vod set yhits=0");
                write_file(FCPATH."caches/month.txt",date('m'));
		   }
		   //清空周人气
		   $week=file_get_contents(FCPATH."caches/week.txt");
		   if($week!=date('W',time())){
			    $this->db->query("update ".CT_SqlPrefix."vod set zhits=0");
                write_file(FCPATH."caches/week.txt",date('W',time()));
		   }
		   //清空日人气
		   $day=file_get_contents(FCPATH."caches/day.txt");
		   if($day!=date('d')){
			    $this->db->query("update ".CT_SqlPrefix."vod set rhits=0");
                write_file(FCPATH."caches/day.txt",date('d'));
		   }

		   //增加人气
		   $this->db->query("update ".CT_SqlPrefix."vod set hits=hits+1,yhits=yhits+1,zhits=zhits+1,rhits=rhits+1 where id=".$id."");
	}

	public function article()
	{
		   $id=(int)$this->input->get('id');
		   if($id==0){
		       $id=(int)$this->uri->segment(3);
		   }
		   if($id==0) exit();

		   //增加人气
		   $this->db->query("update ".CT_SqlPrefix."comm set pvnum=pvnum+1 where id=".$id."");
	}
}
