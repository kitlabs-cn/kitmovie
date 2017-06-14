<title>采集</title>
</head>
<body>
<!--背景灰色变暗-->
<div id="showbg" style="position:absolute;left:0px;top:0px;filter:Alpha(Opacity=20);opacity:0.2;background-color:#fff;z-index:8;"></div>
<!--绑定分类表单框-->
<div id="setbind" style="position:absolute;display:none;background:#ddd;border:1px solid #999;padding:4px 5px 5px 5px;z-index:9;"></div>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 视频管理 <span class="c-gray en">&gt;</span> 视频采集 <a class="btn btn-success radius r mr-20" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="pd-20">
    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
<table class="table table-border table-bordered table-bg table-hover table-sort dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
  <thead>
	<tr>
	<th align="center" colspan="7">分类绑定&nbsp;&nbsp;(点击<font color="#ff0033">×</font>可绑定分类)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="logs" href="<?=links('caiji','jie_bind',0,$api_url)?>"><font color=red>解除分类全部绑定</font></a>
	<span style="float:right"><a class="logs" href="<?=links('caiji')?>">&laquo;&nbsp;返回资源站列表&nbsp;&nbsp;</a></span>
	</th>
	</tr>
 </thead>
	<tr>
<?php
 $count=count($vod_list)>76?76:count($vod_list);
 for ($i=0; $i<$count; $i++) {
     $val=arr_key_value($LIST,$ac.'_'.$vod_list[$i]['id']);
	 if($val){
             $zt="&nbsp;&nbsp;√";
     }else{
             $zt="&nbsp;&nbsp;<font color='#ff0033'>×</font>";
     }
	 echo '<td height="25" align="center"><a class="logs" href="'.links('caiji','index',0,$api_url.'&cid='.$vod_list[$i]['id']).'">'.$vod_list[$i]['name'].'</a><a href="javascript:void(0)" onClick="setbind(event,\''.$ac.'\',\''.$vod_list[$i]['id'].'\');" id="bind_'.$vod_list[$i]['id'].'">'.$zt.'</a></td>';
     if($i==6||$i==13||$i==20||$i==27||$i==34||$i==41||$i==48||$i==55||$i==62||$i==69||$i==76) echo '</tr><tr>';
 }
?>
            <td align="center"><a class="logs" href="<?=links('caiji','index',0,$api_url)?>"><font color=red>全部视频</font></a></td>
	</tr>
</table>
<form action="" method="post" id="myform" name="myform">
<table class="table table-border table-bordered table-bg table-hover table-sort dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
	<tr><th colspan='5'>
	<div class="cl pd-5 bg-1 bk-gray"> 
	  <span class="l"> 
	    <a sid="1" id="checkbox" class="btn radius" href="javascript:;">全选</a>
	    <a class="btn radius" href="javascript:;" onClick="xuan('<?=links('caiji','index',0,'api='.$api.'&ac='.$ac.'&rid='.$rid.'&cid='.$cid.'&op=all&do=caiji')?>');">采集所选</a> 
	    <a class="btn radius" href="<?=links('caiji','index',0,'api='.$api.'&ac='.$ac.'&rid='.$rid.'&cid='.$cid.'&op=day&do=caiji')?>">采集今日更新</a> 
	    <a class="btn radius" href="<?=links('caiji','index',0,'api='.$api.'&ac='.$ac.'&rid='.$rid.'&cid='.$cid.'&op=all&do=caiji')?>">采集当前分类</a> 
	  </span>  
	  <span class="r">
	        <input type="text" id="key" value="<?=$key?>" name="key" placeholder="搜索内容" style="width:200px" class="input-text">
		<button name="so" class="btn btn-success" type="button" onClick="sos('<?=links('caiji','index',0,$api_url)?>')"><i class="Hui-iconfont">&#xe665;</i> 搜视频</button>
	  </span> 
	</div>
        </th>
	</tr>
			<tr>
				<td height="30" width="10%" align="center"><label>选</label></td>
				<td width="*" align="center">名称</td>
				<td width="10%" align="center"><span>来源</span></td>
				<td width="10%" align="center"><span>分类</span></td>
				<td width="20%" align="center"><span>更新时间</span></td>
			</tr>
<?php
if(empty($vod) || count($vod)==0){
       echo " <tr><td colspan='5' align='center'>暂无记录！</td></tr>";
}else{
       for ($j=0; $j<count($vod); $j++) {
	      $times=(date('Y-m-d',strtotime($vod[$j]['addtime']))==date('Y-m-d'))?'<font color=red>'.$vod[$j]['addtime'].'</font>':$vod[$j]['addtime'];
              echo '
		        <tr>
				<td height="25">&nbsp;&nbsp;<input type="checkbox" value="'.$vod[$j]['id'].'" name="id[]">&nbsp;'.$vod[$j]['id'].'</td>
				<td>&nbsp;&nbsp;'.$vod[$j]['name'].'</td>
				<td align="center">'.$vod[$j]['laiy'].'</td>
				<td align="center">'.$vod[$j]['cname'].'</td>
				<td align="center">'.$times.'</td>
			</tr>';

       }
}
?>
	<tr><td colspan='5'>&nbsp;&nbsp;
	<div class="cl pd-5 bg-1 bk-gray"> 
	  <span class="l"> 
	    <a sid="1" id="checkbox2" class="btn radius" href="javascript:;">全选</a>
	    <a class="btn radius" href="javascript:;" onClick="xuan('<?=links('caiji','index',0,'api='.$api.'&ac='.$ac.'&rid='.$rid.'&cid='.$cid.'&op=all&do=caiji')?>');">采集所选</a> 
	    <a class="btn radius" href="<?=links('caiji','index',0,'api='.$api.'&ac='.$ac.'&rid='.$rid.'&cid='.$cid.'&op=day&do=caiji')?>">采集今日更新</a> 
	    <a class="btn radius" href="<?=links('caiji','index',0,'api='.$api.'&ac='.$ac.'&rid='.$rid.'&cid='.$cid.'&op=all&do=caiji')?>">采集当前分类</a> 
	  </span>  
	</div>
        </td>
	</tr>
</table>
</form>
    <?=$pages?>
    </div>
</div>
<footer class="footer"><p>页面执行时间{elapsed_time}秒，消耗内存{memory_usage}</p></footer>
<script type="text/javascript" src="<?=Base_Path?>jquery/jquery.min.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>layer/layer.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.admin.js"></script> 
<script> 
<?php if(Web_Mode==1){ ?>
var fh = '?';
<?php }else{ ?>
var fh = '&';
<?php } ?>
function xuan(links){
  var xuan=0;
  var t=[];
  $("td input:checkbox").each(function(){
      if($(this).prop("checked")){
          xuan++;
	  t.push($(this).val());
      }
  });
  if(xuan>0){
      var ids=t.join(',');
      location.href=links+'&ids='+ids;
  }else{
      layer.msg('请选择要入库的数据~!');
  }
}
//绑定分类
function setbind(event,ac,csid){
	$('#showbg').css({width:$(window).width(),height:$(window).height()});	
	var left = event.clientX+document.body.scrollLeft-70;
	var top = event.clientY+document.body.scrollTop+5;
	$.ajax({
		url: '<?=links('caiji','bind')?>'+fh+'ac='+ac+'&csid='+csid+'&random='+Math.random(),
		cache: false,
		async: false,
		success: function(res){
		    $("#setbind").css({left:left,top:top,display:""});			
		    $("#setbind").html(res);
	            $(".select").uedSelect({width : 160,clas:'uew-select2'});
		}
	});
}
//取消绑定
function hidebind(){
	$('#showbg').css({width:0,height:0});
	$('#setbind').hide();
}
//提交绑定分类
function submitbind(ac,csid){
	var cid=$('#cid').val();
	//alert(ac+csid+cid);
	$.ajax({
		url: '<?=links('caiji','bind_save')?>'+fh+'ac='+ac+'&cid='+cid+'&csid='+csid+'&random='+Math.random(),
		success: function(res){
		    if(res=='ok'){
			 $("#bind_"+csid).html("&nbsp;&nbsp;√");
		    }else{
			 $("#bind_"+csid).html("&nbsp;&nbsp;<font color='#ff0033'>×</font>");
		    }
		    hidebind();
		}
	});	
}
//搜索
function sos(link){
    var key=$('#key').val();
    if(key){
         location.href=link+'&key='+key;
    }else{
         layer.msg('请输入关键词~!');
    }
}
</script>
</body>
</html>