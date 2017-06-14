<?php
/**
 * @Ctcms open source management system
 * @copyright 2016-2017 ctcms.cn. All rights reserved.
 * @Author:Chi Tu
 * @Dtime:2016-04-11
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Csdb extends CI_Model{

    function __construct (){
	       parent:: __construct ();
		   //加载数据库连接
           $this->load->database();
	}

    //SQL语句查询
    function get_sql($sql,$arr=0){
	       $query=$this->db->query($sql);
		   if($arr==0){
	           return $query->result();
		   }else{
	           return $query->result_array();
		   }
	}

    //SQL语句查询总数量
    function get_sql_nums($sql='')  {
           if(!empty($sql)){
			   preg_match('/select\s*(.+)from/i', strtolower($sql),$sqlarr);
			   if(!empty($sqlarr[1])){
                   $sql=str_replace($sqlarr[1],' count(*) as counta ',strtolower($sql));
				   $rows=$this->db->query($sql)->result_array();
				   $nums=(int)$rows[0]['counta'];
			   }else{
				   $query=$this->db->query($sql);
				   $nums=(int)$query->num_rows();
			   }
           }else{
               $nums=0;
           }
	       return $nums;
	}

    //查询总数量
    function get_nums($table,$arr='',$like=''){
           if($arr){
              foreach($arr as $k=>$v){
				 if(strpos($v,',') !== FALSE){
					 $v = explode(',',$v);
	                 $this->db->where_in($k,$v); //条件
				 }else{
	                 $this->db->where($k,$v); //条件
				 }
			  }
           }
           if($like){
              foreach ($like as $k=>$v){
	             $this->db->like($k,$v); //搜索条件
			  }
           }
	       $this->db->select('count(*) as count');
	       $query=$this->db->get($table);
		   $rows=$query->result_array();
		   $nums=(int)$rows[0]['count'];
	       return $nums;
	}

    //按条件查询单一对象
    function get_row($table,$fzd='*',$arr='',$order=''){
          if(is_array($arr)){
             foreach($arr as $k=>$v){
				 if(strpos($v,',') !== FALSE){
					 $v = explode(',',$v);
	                 $this->db->where_in($k,$v); //条件
				 }else{
	                 $this->db->where($k,$v); //条件
				 }
			 }
          }else{
             $this->db->where('id',$arr);
		  }
	      $this->db->select($fzd);
		  if($order!=''){
              $this->db->order_by($order); //排序
		  }
	      $query=$this->db->get($table);
	      return $query->row();
	}

    //按条件查询单一数组
    function get_row_arr($table,$fzd='*',$arr=''){
          if(is_array($arr)){
             foreach ($arr as $k=>$v){
				 if(strpos($v,',') !== FALSE){
					 $v = explode(',',$v);
	                 $this->db->where_in($k,$v); //条件
				 }else{
	                 $this->db->where($k,$v); //条件
				 }
			 }
          }else{
             $this->db->where('id',$arr);
		  }
	      $this->db->select($fzd);
	      $query=$this->db->get($table);
	      return $query->row_array();
	}

    //生成查询列表结果，带分页
    function get_select($table,$fzd='*',$arr='',$order='id DESC',$limit='15',$like='',$rarr=0){
          if($arr){
              foreach ($arr as $k=>$v){
				 if(strpos($v,',') !== FALSE){
					 $v = explode(',',$v);
	                 $this->db->where_in($k,$v); //条件
				 }else{
	                 $this->db->where($k,$v); //条件
				 }
			  }
          }
          if($like){
              foreach ($like as $k=>$v){
	             $this->db->like($k,$v); //搜索条件
			  }
          }
	      $this->db->select($fzd); //查询字段
		  if(is_array($limit)){
	          $this->db->limit($limit[0],$limit[1]);  //分页
		  }else{
	          $this->db->limit($limit);  //分页
		  }
		  if(is_array($order)){
		  	for($i=0; $i < sizeof($order)/2; $i++) {

		  		$this->db->order_by($order[2*$i],$order[2*$i+1]);

		  	}
	           //排序
		  }else{
	          $this->db->order_by($order); //排序
		  }
	      $query=$this->db->get($table); //查询表
		  if($rarr==0){
	           return $query->result();
		  }else{
	           return $query->result_array();
		  }
	}

    //增加
    function get_insert($table,$arr){
          if($arr){
	         $this->db->insert($table,$arr);
             $ids = $this->db->insert_id();
		     return $ids;
          }else{
		     return false;
          }
	}

    //修改
    function get_update($table,$id,$arr,$zd='id'){
          if(!empty($id)){
	            if(is_array($id)){
		          $this->db->where_in($zd,$id);
	            }else{
		          $this->db->where($zd,$id);
	            }
	            if($this->db->update($table,$arr)){
	                 return true;
                }else{
		             return false;
                }
          }else{
		         return false;
          }
    }

    //删除
    function get_del ($table,$ids,$zd='id'){
	       if(is_array($ids)){
		          $this->db->where_in($zd,$ids);
	       }else{
		          $this->db->where($zd,$ids);
	       }
	       if($this->db->delete($table)){
	              return true;
           }else{
		          return false;
           }
	}
}

