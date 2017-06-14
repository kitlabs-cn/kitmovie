<?php
/**
 * @Ctcms open source management system
 * @copyright 2016-2017 ctcms.cn. All rights reserved.
 * @Author:Chi Tu
 * @Dtime:2016-08-11
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Play extends Ctcms_Controller {

	function __construct(){
	    parent::__construct();
        //当前模版
		$this->load->get_templates();
		$this->load->library('parser');
	}

	public function index($id=0,$zu=0,$ji=0)
	{
		if((int)$id==0){
		    $id=(int)$this->input->get('id');
		    $zu=(int)$this->input->get('zu');
		    $ji=(int)$this->input->get('ji');
		}
		if($id==0) msg_url('参数错误',Web_Path);
		$zu = (int)$zu;
		$ji = (int)$ji;

        $row=$this->csdb->get_row_arr('vod','*',$id);
		if(!$row) msg_url('视频不存在~!',Web_Path);
		if(!defined('MOBILE') && $row['yid']==1) msg_url('视频不存在~!',Web_Path);
	    $cache_id ="play_".$id."_".$zu."_".$ji;
	    if(!($this->cache->start($cache_id))){

                //站点标题
			    $jname = $row['cid']==2 ? ' - 第'.($ji+1).'集' : '';
		        $data['ctcms_title'] = '在线播放'.$row['name'].$jname.'  - '.Web_Name;
				//当前CID
				$data['ctcms_cid'] = $row['cid'];

                //播放组
		        $arr = explode("#ctcms#",$row['url']);
		        $zuarr=array();
		        for($i=0;$i<count($arr);$i++){
			          $arr2 = explode("###",$arr[$i]);
                      $zuarr[$i]['ly'] = $arr2[0];
                      $zuarr[$i]['name'] = getzd('player','name',$arr2[0],'bs');
                      $zuarr[$i]['xu'] = $i+1;
			          $arr3 = explode("\n",$arr2[1]);
			          $jiarr=array();
			          for($k=0;$k<count($arr3);$k++){
                            $arr4 = explode("$",$arr3[$k]);
							$jiarr[$k]['zu'] = $i+1;
							$jiarr[$k]['xu'] = $k+1;
							$jiarr[$k]['xus'] = $k+1;
					        $jiarr[$k]['name'] = $arr4[0];
					        $jiarr[$k]['url'] = trim($arr4[1]);
					        $jiarr[$k]['link'] = links('play','index',$id.'/'.$i.'/'.$k);
			          }
			          $zuarr[$i]['ctcms_ji']=$jiarr;
		        }
		        $data['ctcms_zu']=$zuarr;

				//视频地址
				$purl = $zuarr[$zu]['ctcms_ji'][$ji]['url'];

				//当前播放地址
		        $row['playurl'] = $zuarr[$zu]['ctcms_ji'][$ji]['url'];
				//当前组、集
		        $row['zu'] = $zu+1;
		        $row['ji'] = $ji+1;
				$row['laiy'] = $zuarr[$zu]['ly'];
				$row['zname'] = $zuarr[$zu]['name'];
		        $row['jname'] = $jiarr[$ji]['name'];
				//视频上下集
				$sji = ($ji==0) ? $ji : $ji-1;
				$data['ctcms_slink'] = links('play','index',$id.'/'.$zu.'/'.$sji);
				$xji = ($ji==(count($jiarr)-1)) ? 0 : $ji+1;
				$data['ctcms_xlink'] = links('play','index',$id.'/'.$zu.'/'.$xji);

		        //视频播放器
		        $rowp = $this->csdb->get_row_arr('player','*',array('bs'=>$zuarr[$zu]['ly']));
		        $player = str_replace("{url}",$purl,str_decode($rowp['js']));
				$data['ctcms_player'] = $this->parser->parse_string($player,$data,true,false);

		        //获取模板
		        $skin = empty($row['skin']) ? 'play.html' : $row['skin'];
		        $str = load_file($skin);
				//全局解析
		        $str=$this->parser->parse_string($str,$data,true,false);
				//评论
		        $str=str_replace('{ctcms_pl}',str_replace('{id}',$id,str_decode(Web_Pl)),$str);
				//当前数据
		        $str=$this->parser->ctcms_tpl('vod',$str,$str,$row);
				//IF判断解析
		        $str=$this->parser->labelif($str);
				//增加人气
				$arr = explode('</body>',$str);
				$jsurl = '<script type="text/javascript" src="'.links('hits','index',$row['id']).'"></script></body>';
				echo $arr[0].$jsurl.$arr[1];
		        $this->cache->end();
		}
	}
}
