<?php
/**
 * @Ctcms open source management system
 * @copyright 2016-2017 ctcms.cn. All rights reserved.
 * @Author:Chi Tu
 * @Dtime:2016-08-11
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Vod extends Ctcms_Controller {

	function __construct(){
	    parent::__construct();
		//加载后台模型
		$this->load->model('admin');
        //当前模版
		$this->load->get_templates('admin');
		//判断是否登陆
		$this->admin->login();
	}

    //视频列表
	public function index()
	{
 	    $page = intval($this->input->get('page'));
 	    $ziduan = $this->input->get_post('ziduan',true);
 	    $key = $this->input->get_post('key',true);
 	    $cid = (int)$this->input->get_post('cid',true);
 	    $yid = (int)$this->input->get_post('yid',true);
 	    $tid = (int)$this->input->get_post('tid',true);
 	    $zid = (int)$this->input->get_post('zid',true);
 	    $kstime = $this->input->get_post('kstime',true);
 	    $jstime = $this->input->get_post('jstime',true);
        if($page==0) $page=1;

	    $data['key'] = $key;
	    $data['ziduan'] = $ziduan;
	    $data['kstime'] = $kstime;
	    $data['jstime'] = $jstime;
	    $data['page'] = $page;
	    $data['tid'] = $tid;
	    $data['zid'] = $zid;
	    $data['cid'] = $cid;
	    $data['yid'] = $yid;

		$where=$like='';
		if(!empty($kstime)){
			$where['addtime>']=strtotime($kstime);
		}
		if(!empty($jstime)){
			$where['addtime<']=strtotime($jstime);
		}
		if(!empty($key)){
			$like[$ziduan]=$key;
		}
		if($tid>0){
			$where['tid']=$tid-1;
		}
		if($zid>0){
			$where['zid']=$zid-1;
		}
		if($cid>0){
			$where['cid']=$cid;
		}
		if($yid>0){
			$where['yid']=($yid-1);
		}

        //总数量
	    $total = $this->csdb->get_nums('vod',$where,$like);
		//每页数量
	    $per_page = 15; 
		//总页数
	    $pagejs = ceil($total / $per_page);
	    if($total<$per_page) $per_page=$total;
		$limit=array($per_page,$per_page*($page-1));
        //记录数组
	    $data['array'] = $this->csdb->get_select('vod','*',$where,'addtime DESC',$limit,$like);
		//当前链接
		$base_url = links('vod','index',0,'cid='.$cid.'&yid='.$yid.'&tid='.$tid.'&zid='.$zid.'&ziduan='.$ziduan.'&key='.urlencode($key).'&kstime='.$kstime.'&jstime='.$jstime);
		//分页
	    $data['pages'] = admin_page($base_url,$total,$pagejs,$page);  //获取分页类
	    $data['nums'] = $total;
		//分类
		$data['lists'] = $this->csdb->get_select('class','id,name',array('fid'=>0),'xid ASC');
		//获取远程图片
		$picnums = $this->csdb->get_sql_nums("SELECT id FROM ".CT_SqlPrefix."vod where Lower(Left(pic,7))='http://'");
        $data['downpic'] = $picnums==0 ? '' : '&nbsp;&nbsp;<font color=red>发现有 <b>'.$picnums.'</b> 部视频调用外部图片，<a href="'.links('vod','downpic').'" style="color:#060;">同步到本地</a></font>';
		$this->load->view('head.tpl',$data);
		$this->load->view('vod_index.tpl');
	}

	//视频编辑
	public function edit()
	{
 	    $id = intval($this->input->get('id'));
        if($id==0){
		    $data['name'] = ''; 
		    $data['cid'] = 0; 
		    $data['tid'] = 0; 
		    $data['zid'] = 0; 
		    $data['yid'] = 0; 
		    $data['daoyan'] = ''; 
		    $data['pic'] = ''; 
		    $data['pic2'] = ''; 
		    $data['zhuyan'] = ''; 
		    $data['type'] = ''; 
		    $data['text'] = '';
		    $data['url'] = '';
		    $data['diqu'] = '';
		    $data['yuyan'] = '';
		    $data['state'] = '';
		    $data['hits'] = 0;
		    $data['year'] = date('Y');
		    $data['info'] = '';
		    $data['skin'] = 'play.html';
		}else{
		    $row = $this->csdb->get_row_arr("vod","*",array('id'=>$id)); 
		    $data['name'] = $row['name']; 
		    $data['tid'] = $row['tid']; 
		    $data['cid'] = $row['cid']; 
		    $data['zid'] = $row['zid']; 
		    $data['yid'] = $row['yid']; 
		    $data['daoyan'] = $row['daoyan']; 
		    $data['pic'] = $row['pic']; 
		    $data['pic2'] = $row['pic2']; 
		    $data['zhuyan'] = $row['zhuyan']; 
		    $data['type'] = $row['type'];  
		    $data['text'] = $row['text'];  
		    $data['diqu'] = $row['diqu'];  
		    $data['yuyan'] = $row['yuyan'];  
		    $data['hits'] = $row['hits'];  
		    $data['skin'] = $row['skin']; 
		    $data['state'] = $row['state']; 
		    $data['url'] = $row['url']; 
		    $data['year'] = $row['year']; 
		    $data['info'] = $row['info']; 
		}
		$data['id'] = $id; 
		//分类
		$data['lists'] = $this->csdb->get_select('class','id,name',array('fid'=>0),'xid ASC');
		//播放器
		$data['player'] = $this->csdb->get_select('player','id,name,bs','','xid ASC');
        $this->load->view('head.tpl',$data);
        $this->load->view('vod_edit.tpl',$data);
	}

	//修改入库
	public function save()
	{
		$id = (int)$this->input->post('id');
		$addtime = $this->input->post('addtime');
		$data['name'] = $this->input->post('name',true);
		$data['pic'] = $this->input->post('pic',true);
		$data['pic2'] = $this->input->post('pic2',true);
		$data['tid'] = (int)$this->input->post('tid');
		$data['cid'] = (int)$this->input->post('cid');
		$data['zid'] = (int)$this->input->post('zid');
		$data['yid'] = (int)$this->input->post('yid');
		$data['hits'] = (int)$this->input->post('hits');
		$data['daoyan'] = $this->input->post('daoyan',true);
		$data['zhuyan'] = $this->input->post('zhuyan',true); 
		$data['type'] = $this->input->post('type',true);
		$data['skin'] = $this->input->post('skin',true);
		$data['year'] = $this->input->post('year',true);
		$data['info'] = $this->input->post('info',true);
		$data['state'] = $this->input->post('state',true);
		$data['diqu'] = $this->input->post('diqu',true);
		$data['yuyan'] = $this->input->post('yuyan',true);
		$data['text'] = $this->input->post('text');
		if(empty($data['skin'])) $data['skin']='play.html';

		if(empty($data['name']) || empty($data['cid'])){
             admin_msg('数据不完整~！','javascript:history.back();','no');
		}

		//播放器和播放地址
		$play = $this->input->post('play',true);
		$url = $this->input->post('url');
        $purl=array();
		foreach ($play as $k=>$v) {
			 $ji=array();
			 $arr = explode("\n",$url[$k]);
			 for($i=0;$i<count($arr);$i++){
				 if(!empty($arr[$i])){
                     $arr2 = explode("$",$arr[$i]);
				     if(!empty($arr2[0]) && !empty($arr2[1])){
                         $ji[]=$arr[$i];
				     }elseif(empty($arr2[0])){
                         $ji[]='第1集$'.$arr2[1];
				     }else{
                         $ji[]='第1集$'.$arr2[0];
				     }
				 }
			 }
             $purl[]=$v.'###'.implode("\n",$ji);
		}
		$data['url'] = implode("#ctcms#",$purl);
		if($id>0){
			if($addtime=='ok') $data['addtime']=time();
            $this->csdb->get_update('vod',$id,$data);
		}else{
			$data['addtime']=time();
            $this->csdb->get_insert('vod',$data);
		}
        echo "<script>
		      parent.layer.msg('恭喜您，操作成功~!');
              setInterval('parent.location.reload()',1000); 
              </script>";
	}

	//批量推荐视频
	public function reco()
	{
 	    $id = $this->input->post('id');
		$edit['tid']=1;
		$this->csdb->get_update('vod',$id,$edit);
		admin_msg('恭喜您，操作完成~！','javascript:history.back();');
	}

	//批量隐藏视频
	public function yc()
	{
 	    $id = $this->input->post('id');
		$edit['yid']=1;
		$this->csdb->get_update('vod',$id,$edit);
		admin_msg('恭喜您，操作完成~！','javascript:history.back();');
	}

	//批量显示视频
	public function xs()
	{
 	    $id = $this->input->post('id');
		$edit['yid']=0;
		$this->csdb->get_update('vod',$id,$edit);
		admin_msg('恭喜您，操作完成~！','javascript:history.back();');
	}

    //删除视频
	public function del()
	{
 	    $ac = $this->input->get('ac');
 	    $id = $this->input->post('id');
		$res=$this->csdb->get_del('vod',$id);
		if($ac=='all'){
			if($res){
                admin_msg('恭喜您，删除完成~！',links('vod'));
			}else{
                admin_msg('删除失败，请稍后再试~！','javascript:history.back();','no');
			}
		}else{
		    $data['error']=$res ? 'ok' : '删除失败~!';
		    echo json_encode($data);
		}
	}

    //分类列表
	public function lists()
	{
 	    $page = intval($this->input->get('page'));
        if($page==0) $page=1;

	    $data['page'] = $page;
        //总数量
	    $total = $this->csdb->get_nums('class',array('fid'=>0));
		//每页数量
	    $per_page = 100; 
		//总页数
	    $pagejs = ceil($total / $per_page);
	    if($total<$per_page) $per_page=$total;
	    $limit=array($per_page,$per_page*($page-1));
        //记录数组
	    $data['array'] = $this->csdb->get_select('class','*',array('fid'=>0),'xid ASC',$limit);
		//当前链接
		$base_url = links('vod','lists');
		//分页
	    $data['pages'] = admin_page($base_url,$total,$pagejs,$page);  //获取分页类
	    $data['nums'] = $total;
		$this->load->view('head.tpl',$data);
		$this->load->view('vod_list.tpl');
	}

	//分类增加编辑
	public function lists_edit()
	{
 	    $id = intval($this->input->get('id'));
		if($id==0){
            $data['id'] = 0;
            $data['name'] = '';
            $data['skin'] = 'list.html';
            $data['fid'] = 0;
            $data['xid'] = 0;
		}else{
            $data = $this->csdb->get_row_arr("class","*",array('id'=>$id)); 
		}
		//分类
	    $data['array'] = $this->csdb->get_select('class','*',array('fid'=>0),'xid ASC');
        $this->load->view('head.tpl',$data);
        $this->load->view('vod_list_edit.tpl',$data);
	}

	//分类修改
	public function lists_save()
	{
		$id = (int)$this->input->post('id');
		$data['name'] = $this->input->post('name',true);
		$data['fid'] = (int)$this->input->post('fid');
		$data['xid'] = (int)$this->input->post('xid');
		$data['skin'] = $this->input->post('skin',true);
		if(empty($data['name'])){
             admin_msg('名称不能为空~！','javascript:history.back();','no');
		}
		if($id==0){
             $this->csdb->get_insert('class',$data);
		}else{
             $this->csdb->get_update('class',$id,$data);
		}
        echo "<script>
		      parent.layer.msg('恭喜您，操作成功~!');
		      setInterval('parent.location.reload()',1000); 
              </script>";
	}

	//分类批量修改
	public function lists_plpx()
	{
		$ids = $this->input->post('id',true);
		$xids = $this->input->post('xid',true);
		if(empty($ids) || empty($xids)){
             admin_msg('请选择要操作的数据~！','javascript:history.back();','no');
		}
        for($i=0;$i<count($ids);$i++){
             $id=(int)$ids[$i];
			 if($id>0){
                $data['xid']=(int)$xids[$i];
				$this->csdb->get_update('class',$id,$data);
			 }
		}
        admin_msg('恭喜您，排序成功~！',links('vod','lists'));
	}

    //删除分类
	public function lists_del()
	{
 	    $ac = $this->input->get('ac');
 	    $id = $this->input->post('id');
		$res=$this->csdb->get_del('class',$id);
		if($ac=='all'){
			if($res){
                admin_msg('恭喜您，删除完成~！',links('vod','lists'));
			}else{
                admin_msg('删除失败，请稍后再试~！','javascript:history.back();','no');
			}
		}else{
		    $data['error']=$res ? 'ok' : '删除失败~!';
		    echo json_encode($data);
		}
	}

	//批量生成视频
	public function html()
	{
 	    $ids = $this->input->post('id');
        foreach ($ids as $id) {
            $cacheid1 = FCPATH.'caches/tpl/'.md5('play_'.$id.'_0_0');
            $cacheid2 = FCPATH.'caches/tpl/'.md5('show_'.$id);
            unlink($cacheid1);
			unlink($cacheid2);
		}
		admin_msg('恭喜您，全部更新完成~！','javascript:history.back();');
	}

    //同步远程图片到本地
	public function downpic()
	{
            $page = intval($this->input->get('page'));
            $pagejs = intval($this->input->get('pagejs'));
            $sql_string = "SELECT id,pic FROM ".CT_SqlPrefix."vod where Lower(Left(pic,7))='http://' order by addtime desc";
	        $total = $this->csdb->get_sql_nums($sql_string);
            if($total==0) admin_msg('恭喜您，所有远程图片全部同步完成~!',links('vod'),'ok');  //操作完成

            if($page==0) $page = 1;
	        $per_page = 20; 
            $totalPages = ceil($total / $per_page); // 总页数
            if($total<$per_page){
               $per_page=$total;
            }
			if($pagejs==0) $pagejs=$totalPages;
            $sql_string.=' limit 20';
	        $query = $this->db->query($sql_string); 

			//保存目录
			$pathpic = FCPATH.'attachment/vod/'.date('Ym').'/'.date('d').'/';
			if(!is_dir($pathpic)) mkdirss($pathpic);

            echo '<link href="'.Base_Path.'admin/css/H-ui.min.css" rel="stylesheet" type="text/css" /><br>';
	        echo "<div style='font-size:14px;'>&nbsp;&nbsp;&nbsp;<b>正在开始同步第<font style='color:red; font-size:12px; font-style:italic'>".$page."</font>页，共<font style='color:red; font-size:12px; font-style:italic'>".$pagejs."</font>页，剩<font style='color:red; font-size:12px; font-style:italic'>".$totalPages."</font>页</b><br><br>";
           
            foreach ($query->result() as $row) {
				ob_end_flush();//关闭缓存 
				$up='no';
				if(!empty($row->pic)){
                       $picdata=htmlall($row->pic);
					   $file_ext = strtolower(trim(substr(strrchr($row->pic, '.'), 1)));
                       if($file_ext!='jpg' && $file_ext!='png' && $file_ext!='gif'){
					       $file_ext = 'jpg';
					   }
                       //新文件名
                       $file_name=date("YmdHis") . rand(10000, 99999) . '.' . $file_ext;
			           $file_path=$pathpic.$file_name;
                       if(!empty($picdata)){
						   //保存图片
                           if(write_file($file_path, $picdata)){
                                $up='ok';
								$filepath = str_replace(FCPATH,Web_Path,$file_path);
						   }
					   }
				}
				//成功
				if($up=='ok'){
                       //修改数据库
                       $this->db->query("update ".CT_SqlPrefix."vod set pic='".$filepath."' where id=".$row->id."");
                       echo "&nbsp;&nbsp;&nbsp;&nbsp;同步<font color=red>".$row->pic."</font>&nbsp;图片成功!&nbsp;&nbsp;新图片名：<a href=\"".getpic($filepath)."\" target=_blank>".$file_name."</a></br>";
				}else{
                       //修改数据库
                       $this->db->query("update ".CT_SqlPrefix."vod set pic='' where id=".$row->id."");
                       echo "&nbsp;&nbsp;&nbsp;&nbsp;<font color=red>".$row->pic."</font>远程图片不存在!</br>";
				}
				ob_flush();flush();
			}
	        echo "&nbsp;&nbsp;&nbsp;&nbsp;第".$page."页图片同步完毕,暂停3秒后继续同步．．．．．．<script language='javascript'>setTimeout('ReadGo();',".(3000).");function ReadGo(){location.href='".links('vod','downpic',0,'page="'.($page+1).'&pagejs='.$pagejs)."';}</script></div>";
	}
}
        