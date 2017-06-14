<?php
/**
 * @Ctcms open source management system
 * @copyright 2016-2017 ctcms.cn. All rights reserved.
 * @Author:Chi Tu
 * @Dtime:2016-08-11
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Caiji extends Ctcms_Controller {

	function __construct() {
	    parent::__construct();
		//加载后台模型
		$this->load->model('admin');
        //当前模版
		$this->load->get_templates('admin');
	}

    //资源库列表
	public function index()
	{
            $ac = $this->input->get('ac',true);
            $op = $this->input->get('op',true);
            $do = $this->input->get('do',true);
			$rid  = intval($this->input->get('rid'));

			if($do=='caiji'){ //入库

 	                $api  = $this->input->get('api',TRUE);
 	                $page = intval($this->input->get('page'));
 	                $cid  = intval($this->input->get('cid'));
 	                $ac   = $this->input->get('ac',TRUE);
 	                $ops   = $this->input->get('op',TRUE);
 	                $key  = $keys = $this->input->get('key',TRUE);
 	                $ids  = $this->input->get('ids',TRUE);
		            if($page==0) $page=1;
		            if($ops=='24') $ops='day';
		            if($ops=='day'){
			            $op=24;
		            }elseif($ops=='week'){
			            $op=98;
		            }else{
			            $op=0;
		            }
					//绑定分类数组
                    $LIST = require_once(CTCMSPATH.'libs/Ct_Bind.php');

		            $api_url ='api='.$api.'&rid='.$rid.'&op='.$op.'&ac='.$ac.'&do=caiji&key='.$key.'&cid='.$cid;
                    if($api){
                          $API_URL=base64_decode($api).'?ac=videolist&rid='.$rid.'&wd='.$key.'&t='.$cid.'&h='.$op.'&ids='.$ids.'&pg='.$page;
                          $strs=htmlall($API_URL);

			              if(empty($strs)) admin_msg('<font color=red>采集失败，请多试几次，如一直出现该错误，通常为网络不稳定或禁用了采集！</font>','javascript:history.go(-1);');

			              //组合分页信息
			              preg_match('<list page="([0-9]+)" pagecount="([0-9]+)" pagesize="([0-9]+)" recordcount="([0-9]+)">',$strs,$page_array);
						  if(!empty($page_array)){
			                   $recordcount = $page_array[4];
			                   $pagecount = $page_array[2];
			                   $pagesize = $page_array[3];
			                   $pageindex = $page_array[1];	
						  }else{
			                   $recordcount = 0;
			                   $pagecount = 0;
			                   $pagesize = 0;
			                   $pageindex = 0;	
						  }


                          echo '<LINK href="'.base_url().'packs/admin/css/H-ui.min.css" type="text/css" rel="stylesheet"><br>';
						  echo '<div id="loading" style="display:none;position: absolute;left:40%;top:300px;z-index:10;background-color:#ccc;"><span style="width:120px;height:40px;line-height:40px;background-color:#ccc;">&nbsp;&nbsp;<img align="absmiddle" src="'.Web_Path.'packs/admin/images/loading.gif">数据加载中...</span></div>';
			              echo "&nbsp;&nbsp;<b><font color=#0000ff>当前页共有".$recordcount."个数据，需要采集".$pagecount."次，每一次采集".$pagesize."个，正在执行第".$pageindex."次采集任务</font></b><br/>";

			              //组合列表
			              $vod='';
			              preg_match_all('/<video><last>([\s\S]*?)<\/last><id>([0-9]+)<\/id><tid>([0-9]+)<\/tid><name><\!\[CDATA\[([\s\S]*?)\]\]><\/name><type>([\s\S]*?)<\/type><pic>([\s\S]*?)<\/pic><lang>([\s\S]*?)<\/lang><area>([\s\S]*?)<\/area><year>([\s\S]*?)<\/year><state>([\s\S]*?)<\/state><note><\!\[CDATA\[([\s\S]*?)\]\]><\/note><actor><\!\[CDATA\[([\s\S]*?)\]\]><\/actor><director><\!\[CDATA\[([\s\S]*?)\]\]><\/director><dl>([\s\S]*?)<\/dl><des><\!\[CDATA\[([\s\S]*?)\]\]><\/des>([\s\S]*?)<\/video>/',$strs,$vod_array);
                          $s=1;
						  //print_r($vod_array);exit($strs);
			              foreach($vod_array[1] as $key=>$value){

                                  $p=($pageindex-1)*$pagesize+$s;

				                  $add['name']     = str_replace("'","",htmlspecialchars_decode($vod_array[4][$key]));
				                  $add['type']     = str_replace(" ","/",str_replace("'","",htmlspecialchars_decode($vod_array[5][$key])));
				                  $add['pic']      = $vod_array[6][$key];
                                  $add['daoyan']   = str_replace(" ","/",str_replace("'","",htmlspecialchars_decode($vod_array[13][$key])));
                                  $add['zhuyan']     = str_replace(" ","/",str_replace("'","",htmlspecialchars_decode($vod_array[12][$key])));
                                  $add['year']     = $vod_array[9][$key];
                                  $add['diqu']     = $vod_array[8][$key];
                                  $add['yuyan']    = $vod_array[7][$key];
					              $add['state']   = (empty($vod_array[10][$key]))?'完结':$vod_array[10][$key];
                                  $add['text']  = str_replace("'","",htmlspecialchars_decode($vod_array[15][$key]));
                                  $add['addtime']  = time();

                                  $add['daoyan']   = str_replace("//","/",$add['daoyan']);
                                  $add['zhuyan']   = str_replace("//","/",$add['zhuyan']);
                                  $add['type']   = str_replace("//","/",$add['type']);

								  //替换标题
								  $add['name']=str_replace("--电视剧","",$add['name']);
								  $add['name']=str_replace("--微电影","",$add['name']);
								  $add['name']=str_replace("--综艺","",$add['name']);
								  $add['name']=str_replace("--动漫","",$add['name']);
								  $add['name']=str_replace(" 电视剧","",$add['name']);
								  $add['name']=str_replace(" 微电影","",$add['name']);
								  $add['name']=str_replace(" 综艺","",$add['name']);
								  $add['name']=str_replace(" 动漫","",$add['name']);

                                  preg_match_all('/<dd flag="([\s\S]*?)"><\!\[CDATA\[([\s\S]*?)\]\]><\/dd>/',$vod_array[14][$key],$url_arr);

								  $purl_arr=array();
								  for($j=0;$j<count($url_arr[2]);$j++){

									  $laiy = $laiy2 = $url_arr[1][$j];

									  //资源站来源替换
									  $laiy=str_replace("youkuyun","ykyun",$laiy);
									  $laiy=str_replace("cloud","ykyun",$laiy);
									  $laiy=str_replace("优酷云","ykyun",$laiy);
									  $laiy=str_replace("xigua","xgvod",$laiy);
					                  $laiy=str_replace("xfplay","yyxf",$laiy);
					                  $laiy=str_replace("百度影音","bdhd",$laiy);
									  //粉丝多资源来源替换
									  $laiy=str_replace("乐视网","letv",$laiy);
									  $laiy=str_replace("优酷","youku",$laiy);
									  $laiy=str_replace("影音先锋","yyxf",$laiy);
									  $laiy=str_replace("吉吉影音","jjvod",$laiy);
									  //凡高资源来源替换
									  $laiy=str_replace("hdbaofeng1080P","baofeng",$laiy);
									  $laiy=str_replace("hdbaofeng720P","baofeng",$laiy);
									  $laiy=str_replace("hdbaofeng480P","baofeng",$laiy);
									  $laiy=str_replace("hdbaofeng240P","baofeng",$laiy);
									  $laiy=str_replace("yinyuetai","yyt",$laiy);


                                      $purl = $url_arr[2][$j];
					                  $purl=htmlspecialchars_decode($purl);
					                  $purl=str_replace("xigua","xgvod",$purl);
					                  $purl=str_replace("xfplay","yyxf",$purl);
					                  $purl=str_replace("yyxf://","xfplay://",$purl);
					                  $purl=str_replace("百度影音","bdhd",$purl);
					                  $purl=str_replace("#","&type=".$laiy."\n",$purl);
					                  $purl=str_replace("$".$laiy2,"",$purl);


									  //判断集数
									  if(strpos($purl,'$') === FALSE){
                                          $purl='正片$'.$purl;
									  }
									  if(!empty($purl)){
										  if($laiy=='ykyun'){
									          $purl_arr[]="ykyun###".$purl;
										  }else{
									          $purl=$purl."&type=".$laiy;
											  $purl_arr[]="ydisk###".$purl;
										  }
									  }
								   }
								   $purl = implode('#ctcms#',$purl_arr);
                                   $add['url'] = $purl;

                                  //判断绑定
			                      $val=arr_key_value($LIST,$ac.'_'.$vod_array[3][$key]);
			                      if(!$val){

			                                   echo "&nbsp;&nbsp;&nbsp;第".$p."个影片&nbsp;<font color=red>".$vod_array[4][$key]."</font>&nbsp;&nbsp;数据没有绑定分类，不进行入库处理！<br/>";

                                  //判断数据完整性
					              }elseif(empty($vod_array[4][$key]) || empty($purl)){

			                                   echo "&nbsp;&nbsp;&nbsp;第".$p."个影片&nbsp;<font color=red>".$vod_array[4][$key]."</font>&nbsp;&nbsp;数据不完整，不进行入库处理！<br/>";

					              }else{

				                        $add['cid']  = $val;

							            //判断数据是否存在
					                    $sql="SELECT id,url,state FROM ".CT_SqlPrefix."vod where name='".$add['name']."'";
	 		                            $row=$this->db->query($sql)->row();
			                            if(!$row){

                                               $this->csdb->get_insert('vod',$add);
					                           echo "&nbsp;&nbsp;&nbsp;第".$p."个影片&nbsp;<font color=#ff00ff>".$vod_array[4][$key]."</font>数据库中没有记录，已入库完成！<br/>";

							            }else{

								             //判断更新状态
								             if($row->url==$purl){

			                                      echo "&nbsp;&nbsp;&nbsp;第".$p."个影片&nbsp;<font color=#ff6600>".$vod_array[4][$key]."</font>&nbsp;&nbsp;数据相同，暂无不需要更新<br/>";

								             }else{
                                                 if($row->state!='完结' && (int)$add['state']>(int)$row->state){
					                                 $edit['state']  = $add['state'];
												 }
                                                 $edit['url'] = $this->isdata($purl,$row->url);
                                                 echo "&nbsp;&nbsp;&nbsp;第".$p."个影片&nbsp;<font color=#ff00ff>".$vod_array[4][$key]."</font>&nbsp;&nbsp;数据存在，数据更新成功~!<br/>";

									              //更新数据
                                                  $edit['addtime'] = time();
									              $this->csdb->get_update('vod',$row->id,$edit);
								             }
							            }
					              }
			              $s++;
			              }

			              if($pageindex < $pagecount){
					            //缓存断点续采
					            $jumpurl = links('caiji','index',0,$api_url.'&page='.($page+1));
					            write_file(FCPATH."caches/jumpurl.txt", $jumpurl);
					            //跳转到下一页
					            echo("</br>&nbsp;&nbsp;&nbsp;<a href='".links('caiji','index',0,'api='.$api.'&op='.$ops.'&ac='.$ac.'&key='.$keys.'&cid='.$cid)."'>紧急停止</a>&nbsp;&nbsp;&nbsp;<b>&nbsp;第<font color=red>".$page."</font>页入库完毕,暂停<font color=red>3</font>秒继续。。。。。</b><script>setTimeout('updatenext();',3000);
								function updatenext(){
									document.getElementById('loading').style.display = 'block';
									location.href='".$jumpurl."';
								}
								</script></br></br>");
			              }else{
					            //清除断点续采
					            write_file(FCPATH."caches/jumpurl.txt", "0");
					            echo("</br>&nbsp;&nbsp;&nbsp;&nbsp;<b>恭喜您，全部入库完成啦。。。。。</b><script>
								setTimeout('updatenext();',3000);
								function updatenext(){
									document.getElementById('loading').style.display = 'block';
									location.href='".links('caiji','index',0,str_replace('&do=caiji','',$api_url))."';
								}
								</script>");				
			              }
		            }else{
                           exit($api);
						  admin_msg('<font color=red>API错误！</font>','javascript:history.go(-1);');
		            }

			}elseif(!empty($ac)){  //资源库查看

 	    		$api  = $this->input->get('api',TRUE);
 	    		$page = intval($this->input->get('page'));
 	   		    $cid  = intval($this->input->get('cid'));
 	    		$ac   = $this->input->get('ac',TRUE);
 	    		$op   = $this->input->get('op',TRUE);
 	    		$key  = $this->input->get('key',TRUE);
				if($page==0) $page=1;
				if($op=='all') $op=0;

				$data['api_url'] ='api='.$api.'&rid='.$rid.'&op='.$op.'&ac='.$ac.'&key='.$key.'&cid='.$cid;
				$data['key'] = $key;
				$data['op']  = $op;
				$data['cid'] = $cid;
				$data['rid'] = $rid;
				$data['api'] = $api;
        		if($api){
              		 $API_URL=base64_decode($api).'?ac=list&rid='.$rid.'&wd='.$key.'&t='.$cid.'&h=0&ids=&pg='.$page;
					 $strs=htmlall($API_URL);
					 if(empty($strs)) admin_msg('<font color=red>获取列表失败，请多试几次，如一直出现该错误，通常为网络不稳定或禁用了采集！</font>','javascript:history.go(-1);');

			  		 //组合分页信息
			  		 preg_match('<list page="([0-9]+)" pagecount="([0-9]+)" pagesize="([0-9]+)" recordcount="([0-9]+)">',$strs,$page_array);
			  		 $data['recordcount'] = $page_array[4];
			 		 $data['pagecount'] = $page_array[2];
			  		 $data['pagesize'] = $page_array[3];
			  		 $data['pageindex'] = $page_array[1];	

			 		 $path=links('caiji','index',0,$data['api_url'].'&key='.$key.'&cid='.$cid.'&');
			 		 $data['pages'] = admin_page($path,$data['recordcount'],$data['pagecount'],$page);
			  
			  		 //组合列表
			  		 $vod='';
			  		 preg_match_all('/<video>([\s\S]*?)<\/video>/',$strs,$vod_array);
			  		 foreach($vod_array[1] as $key=>$value){
                         preg_match_all('/<last>([\s\S]*?)<\/last>/',$value,$times);
                         preg_match_all('/<id>([0-9]+)<\/id>/',$value,$ids);
                         preg_match_all('/<tid>([0-9]+)<\/tid>/',$value,$cids);
                         preg_match_all('/<name><\!\[CDATA\[([\s\S]*?)\]\]><\/name>/',$value,$names);
                         preg_match_all('/<type>([\s\S]*?)<\/type>/',$value,$cnames);
                         preg_match_all('/<dt>([\s\S]*?)<\/dt>/',$value,$dts);
						 $vod[$key]['addtime'] = $times[1][0];
						 $vod[$key]['id'] = $ids[1][0];
						 $vod[$key]['cid'] = intval($cids[1][0]);
						 $vod[$key]['name'] = $names[1][0];
						 $vod[$key]['laiy'] = (!empty($dts[1][0]))?$dts[1][0]:$ac;
						 $vod[$key]['cname'] = $cnames[1][0];
			  		 }
             		 $data['vod']=$vod;

			 		  //组合分类
			 		  preg_match_all('/<ty id="([0-9]+)">([\s\S]*?)<\/ty>/',$strs,$list_array);
			 		  foreach($list_array[1] as $key=>$value){
						   $vod_list[$key]['id'] = $value;
						   $vod_list[$key]['name'] = $list_array[2][$key];
			 		  }
             		  $data['vod_list']=$vod_list;
            		  $data['ac']=$ac;
            		  $data['page']=$page;

                      $data['LIST'] = require_once(CTCMSPATH.'libs/Ct_Bind.php');
            		  $this->load->view('head.tpl',$data);
            		  $this->load->view('caiji_list.tpl');

        		}else{
            		  admin_msg('<font color=red>API错误！</font>','javascript:history.go(-1);');
				}

			}elseif(empty($do)){  //资源库首页
				 $data['jumpurl']=@file_get_contents(FCPATH."caches/jumpurl.txt");
                 $data['api']='http://api.ctcms.cn/vodapi/ctcms_free_utf8.js';
                 $this->load->view('head.tpl',$data);
                 $this->load->view('caiji.tpl');
			}
	}

    //绑定分类
	public function bind()
	{
	        $csid = intval($this->input->get('csid'));
 	        $ac  = $this->input->get('ac',TRUE);

            $LIST = require_once(CTCMSPATH.'libs/Ct_Bind.php');
			$val=arr_key_value($LIST,$ac.'_'.$csid);
            $strs='<option value="0">&nbsp;|—选择目标分类</option>';
            $query = $this->db->query("SELECT id,name FROM ".CT_SqlPrefix."class where fid=0 order by xid asc"); 
            foreach ($query->result() as $row) {
                        $clas=($row->id==$val)?' selected="elected"':'';
			            $strs.='<option value="'.$row->id.'"'.$clas.'>&nbsp;|—'.$row->name.'</option>';
                        $query2 = $this->db->query("SELECT id,name FROM ".CT_SqlPrefix."class where fid=".$row->id." order by xid asc"); 
                        foreach ($query2->result() as $row2) {
                            $clas2=($row2->id==$val)?' selected="elected"':'';
			                $strs.='<option value="'.$row2->id.'"'.$clas2.'>&nbsp;|&nbsp;&nbsp;&nbsp;|—'.$row2->name.'</option>';
			            }
            }
            echo '<span class="select-box inline"><select class="select" name="cid" id="cid">'.$strs.'
                 </select></span><input style="width:50px;" type="button" value="提 交" onClick="submitbind(\''.$ac.'\',\''.$csid.'\');" style="cursor:pointer"> <input name="button" type="button" value="取 消" style="width:50px;" onClick="hidebind();" style="cursor:pointer">
				 ';
    }

    //绑定分类存储
	public function bind_save()
	{
 	    $ac   = $this->input->get('ac',TRUE);
	    $csid = intval($this->input->get_post('csid'));
	    $id = intval($this->input->get_post('cid'));

	    $LIST = require_once(CTCMSPATH.'libs/Ct_Bind.php');
	    $LIST[$ac.'_'.$csid] = $id;
		arr_file_edit($LIST,CTCMSPATH.'libs/Ct_Bind.php');
        echo 'ok';
	}

	//解除全部绑定
	public function jie_bind()
	{
 	        $api  = $this->input->get('api',TRUE);
 	        $ac   = $this->input->get('ac',TRUE);
	        $LIST = require_once(CTCMSPATH.'libs/Ct_Bind.php');
            foreach ($LIST as $k=>$v) {
                 if(strpos($k,$ac.'_') !== FALSE){
                     unset($LIST[$k]);
				 }
			}
			arr_file_edit($LIST,CTCMSPATH.'libs/Ct_Bind.php');
            header("Location: ".links('caiji','index',0,'api='.$api.'&ac='.$ac)); 
    }

	//合并新老数据
	public function isdata($xpurl,$ypurl)
	{
		    $news=$old=array();
			$xarr=explode("#ctcms#",$xpurl);
			$xcount=count($xarr);
			for($i=0;$i<$xcount;$i++){
                 $ly=explode("###",$xarr[$i]);
                 $news[$ly[0]]=$xarr[$i];
			}
			$yarr=explode("#ctcms#",$ypurl);
			$ycount=count($yarr);
			for($i=0;$i<$ycount;$i++){
                 $ly=explode("###",$yarr[$i]);
                 $old[$ly[0]]=$yarr[$i];
			}
			$xinarr = array();
			foreach (array_merge($old,$news) as $k=>$v) {
			    $xinarr[] = $v;
			}
			$str=implode('#ctcms#',$xinarr);
			return $str;
	}
}