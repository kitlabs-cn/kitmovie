<?php
/**
 * @Ctcms open source management system
 * @copyright 2016-2017 ctcms.cn. All rights reserved.
 * @Author:Chi Tu
 * @Dtime:2016-08-11
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Show extends Ctcms_Controller {

	function __construct(){
	    parent::__construct();
        //当前模版
		$this->load->get_templates();
		$this->load->library('parser');
	}

	public function index($id=0)
	{
		if((int)$id==0){
		    $id=(int)$this->input->get('id');
		}
		if($id==0) msg_url('参数错误',Web_Path);

	    $cache_id ="show_".$id;
	    if(!($this->cache->start($cache_id))){

                $row=$this->csdb->get_row_arr('vod','*',$id);
		        if(!$row) msg_url('视频不存在~!',Web_Path);		        if(!defined('MOBILE') && $row['yid']==1) msg_url('视频不存在~!',Web_Path);

                //站点标题
		        $data['ctcms_title'] = $row['name'].' - '.Web_Name;
				//当前CID
				$data['ctcms_cid'] = $row['cid'];

                //播放组
		        $arr = explode("#ctcms#",$row['url']);
		        $zu=array();
		        for($i=0;$i<count($arr);$i++){
			          $arr2 = explode("###",$arr[$i]);
                      $zu[$i]['ly'] = $arr2[0];
                      $zu[$i]['name'] = getzd('player','name',$arr2[0],'bs');
                      $zu[$i]['xu'] = $i+1;
			          $arr3 = explode("\n",$arr2[1]);
			          $ji=array();
			          for($k=0;$k<count($arr3);$k++){
                            $arr4 = explode("$",$arr3[$k]);
							$ji[$k]['xu'] = $k+1;
							$ji[$k]['xus'] = $k+1;
					        $ji[$k]['name'] = $arr4[0];
					        $ji[$k]['url'] = trim($arr4[1]);
							if($arr4[0]=='版权限制'){
					            $ji[$k]['link'] = '###';
							}else{
					            $ji[$k]['link'] = links('play','index',$id.'/'.$i.'/'.$k);
							}
			          }
			          $zu[$i]['ctcms_ji']=$ji;
		        }
		        $data['ctcms_zu']=$zu;
		        //视频播放器
		        $rowp = $this->csdb->get_row_arr('player','*',array('bs'=>$zu[0]['ly']));
		        $data['ctcms_player'] = str_replace("{url}",$zu[0]['ctcms_ji'][0]['url'],str_decode($rowp['js']));
				//当前播放地址
		        $data['ctcms_url'] = $zu[0]['ctcms_ji'][0]['url'];
		        //获取模板
		        $str = load_file('show.html');
				//全局解析
		        $str=$this->parser->parse_string($str,$data,true,false);
				//评论
		        $str=str_replace('{ctcms_pl}',str_replace('{id}',$id,str_decode(Web_Pl)),$str);
				//当前数据
		        $str=$this->parser->ctcms_tpl('vod',$str,$str,$row);
				//IF判断解析
		        $str=$this->parser->labelif($str);
				echo $str;
		        $this->cache->end();
		}
	}
}
