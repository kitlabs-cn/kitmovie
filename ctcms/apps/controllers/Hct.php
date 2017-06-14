<?php
/** * 
@Ctcms open source management system * 
@copyright 2008-2016 chshcms.com. All rights reserved. * 
@Author:Cheng Kai Jie * 
@Dtime:2015-12-11 
*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Hct extends Ctcms_Controller {	
	function __construct(){	    
		parent::__construct();        
		//当前模版		
		$this->load->get_templates();
		$this->load->library('parser');
		//免登入接口密码,默认为1234，请自行修改
		$this->pass='1234';	
	}    
	//分类列表	
	public function lists()	{        
		echo "<select name='list'>";              
		$sqlstr="select id,name from ".CT_SqlPrefix."class";		      
		$result=$this->db->query($sqlstr);              
		foreach ($result->result() as $row) {                   
			echo "<option value='".$row->id."'>".$row->name."</option>\n";			  
		}        
		echo '</select>';	
	}    
	//入库	
	public function ruku()	{        
		//判断密码		
		$pass=$this->input->get_post('pass',TRUE);        
		if($this->pass=='1234' || $pass!=$this->pass){            
			exit('密码错误');        
		}        
		// INSERT INTO Table_Name (name,pic,cid,tid,daoyan,zhuyan,type,diqu,yuyan,year,info,text,url) VALUES ('[标签:标题]','[标签:图片]','[分类ID]','[标签:推荐]','[标签:导演]','[标签:主演]','[标签:类型]','[标签:地区]','[标签:语言]','[标签:年份]','[标签:状态]','[标签:介绍]','[标签:地址]')        
		//------------------------------------------//		
		$data['name']=$this->input->post('name',TRUE); //[标签:标题]		
		$data['pic']=$this->input->post('pic',TRUE); //[标签:图片]		
		$data['cid']=$this->input->post('cid',TRUE);//[标签:分类]		
		$data['tid']=$this->input->post('tid',TRUE);//[标签:推荐]		
		$data['daoyan']=$this->input->post('daoyan',TRUE);//[标签:导演]		
		$data['zhuyan']=$this->input->post('zhuyan',TRUE);//[标签:主演]		
		$data['type']=$this->input->post('type',TRUE);//[标签:类型]		
		$data['diqu']=$this->input->post('diqu',TRUE);//[标签:地区]		
		$data['yuyan']=$this->input->post('yuyan',TRUE);//[标签:语言]		
		$data['year']=$this->input->post('year',TRUE);//[标签:年份]		
		$data['state']=$this->input->post('state',TRUE);//[标签:状态]		
		$data['text']=$this->input->post('text',TRUE);//[标签:介绍]		
		$play=$this->input->post('play',TRUE);//[标签:来源]		
		$url=$this->input->post('url',TRUE);//[标签:地址]		
		$jname=$this->input->post('jname',TRUE);//[标签:集数]        
		//组装地址		
		$arr1 = explode("-ctcms-",$jname);		
		$arr2 = explode("-ctcms-",$url);        
		$uarr = array();		
		for($i=0;$arr2<count($arr2)-1;$i++){			 
			if(empty($arr1[$i])){                 
				$uarr[] = '第'.($i+1).'集\$'.$arr2[$i];			 
			}else{
				$uarr[] = $arr1[$i].'\$'.$arr2[$i];
			}		
		}		
		$data['url'] = implode("\n",$uarr);
		//开始处理数据	    
		if(empty($data['name'])){
			echo "数据不完整";		
		}else{		       
			//判断数据是否相同
			$row=$this->db->query("select id,url from ".CT_SqlPrefix."vod where name='".$data['name']."'")->row();               if($row){ //存在同名数据则修改
				$s=0;						
				if(strpos($row->url,'&type='.$play) === FALSE){
					$vod2['url']=$row->url.'#ctcms#'.$data['url'];
					$vod2['addtime']=time();
					$vod2['state']=$data['state'];
					$s++;
				}else{
					$arr = explode("#ctcms#",$row->url);
					$ypurl = $arr[0];
					for($i=0;$i<count($arr);$i++){										
						if(strpos($arr[$i],'&type='.$play) !== FALSE){
							$ypurl=$arr[$i];
							break;										
						}								
					}								
					$vod2['url']=str_replace($ypurl,$data['url'],$row->url);					            $vod2['addtime']=time();
					$vod2['state']=$data['state'];
					$s++;	   						
				}                        
				if($s>0){								
					$this->db->where('id',$row->id);
					$this->db->update('vod',$vod2);
					echo("数据存在,覆盖成功");
				}else{
					echo "数据相同,跳过";
				}
			}else{ //不存在则新增   
				$data['addtime']=time();  
				$this->db->insert('vod',$data); 
				$id=$this->db->insert_id();  
				if($id>0){       
					echo("增加成功"); 
				}else{              
					echo("增加失败");
				}			   
			}		
		}	
	}
}