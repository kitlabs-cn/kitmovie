<title>视频管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 视频管理 <span class="c-gray en">&gt;</span> 视频列表 <a class="btn btn-success radius r mr-20" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="pd-20">
       <form action="<?=links('vod','index')?>" method="post" class="form form-horizontal">
       <div class="text-c"> 
            <span class="select-box inline">
	      <select name="cid" class="select">
		<option value="0">全部分类</option>
<?php
foreach ($lists as $row2) {
	$cls = $row2->id == $cid ? ' selected="selected"' : '';
	echo '<option value="'.$row2->id.'"'.$cls.'>├&nbsp;'.$row2->name.'</option>';
	$array2 = $this->csdb->get_select('class','id,name',array('fid'=>$row2->id),'xid ASC');
        foreach ($array2 as $row3) {
	    $cls2 = $row3->id == $cid ? ' selected="selected"' : '';
	    echo '<option value="'.$row3->id.'"'.$cls2.'>&nbsp;&nbsp;├&nbsp;'.$row3->name.'</option>';
	}
}
?>
	      </select>
            </span>
            <span class="select-box inline">
	      <select name="tid" class="select">
		<option value="0">是否推荐</option>
		<option value="1"<?php if($tid==1) echo ' selected';?>>未推荐</option>
		<option value="2"<?php if($tid==2) echo ' selected';?>>已推荐</option>
	      </select>
            </span>
            <span class="select-box inline">
	      <select name="yid" class="select">
		<option value="0">是否隐藏</option>
		<option value="1"<?php if($yid==1) echo ' selected';?>>未隐藏</option>
		<option value="2"<?php if($yid==2) echo ' selected';?>>已隐藏</option>
	      </select>
            </span>
            <span class="select-box inline">
	      <select name="zid" class="select">
		<option value="0">幻灯推荐</option>
		<option value="1"<?php if($zid==1) echo ' selected';?>>未幻灯</option>
		<option value="2"<?php if($zid==2) echo ' selected';?>>已幻灯</option>
	      </select>
            </span> 日期：
            <input name="kstime" value="<?=$kstime?>" type="text" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})" class="input-text Wdate" style="width:120px;">
            -
            <input name="jstime" value="<?=$jstime?>" type="text" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})" class="input-text Wdate" style="width:120px;">
            <span class="select-box inline">
	      <select name="ziduan" class="select">
		<option value="name"<?php if($ziduan=='name') echo ' selected';?>>视频名称</option>
		<option value="id"<?php if($ziduan=='id') echo ' selected';?>>视频ID</option>
		<option value="daoyan"<?php if($ziduan=='daoyan') echo ' selected';?>>视频导演</option>
		<option value="zhuyan"<?php if($ziduan=='zhuyan') echo ' selected';?>>视频主演</option>
		<option value="type"<?php if($ziduan=='type') echo ' selected';?>>视频类型</option>
	      </select>
            </span>
            <input type="text" value="<?=$key?>" name="key" placeholder="搜索内容" style="width:150px" class="input-text"><button name="so" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜视频</button>
        </div>
        </form>
	<form action="<?=links('vod','del',0,'ac=all')?>" method="post" class="form form-horizontal" id="myform" name="myform">
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">  
	<?php if(Cache_Is==1){ ?>
	<a href="javascript:;" onclick="pl_cmd(1)" class="btn btn-success radius"><i class="Hui-iconfont"></i> 批量更新</a>
	<?php } ?>
	<a href="javascript:;" onclick="pl_cmd(2)" class="btn btn-warning radius"><i class="Hui-iconfont">&#xe61d;</i> 批量推荐</a>
	<a class="btn btn-primary radius" href="javascript:;" onclick="cmd('添加视频','<?=links('vod','edit')?>')"><i class="Hui-iconfont">&#xe600;</i> 添加视频</a> 
	<a href="javascript:;" onclick="pl_cmd(3)" class="btn btn-success radius"><i class="Hui-iconfont"></i> 批量隐藏</a>
	<a href="javascript:;" onclick="pl_cmd(4)" class="btn btn-primary radius"><i class="Hui-iconfont"></i> 批量显示</a>
	<?=$downpic?>
	</span> <span class="r"><a href="javascript:;" onclick="pl_del()" class="btn btn-danger radius"><i class="Hui-iconfont"></i> 批量删除</a></span> </div>
	<div class="dataTables_wrapper no-footer">
	        <table class="table table-border table-bordered table-bg table-hover table-sort dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
		    <thead>
			<tr class="text-c">
                            <th width="25"><input type="checkbox" name="" value=""></th>
			    <th width="70">ID</th>
			    <th width="50">图片</th>
			    <th>名称</th>
			    <th width="70">人气</th>
			    <th width="70">金币</th>
			    <th width="100">导演</th>
			    <th width="130">类型</th>
			    <th width="70">推荐</th>
			    <th width="70">状态</th>
			    <th width="90">时间</th>
			    <th width="60">操作</th>
			</tr>
		    </thead>
		    <tbody>
<?php
if(empty($array)) echo '<tr><td colspan="10" class="text-c">没有记录~</td></tr>';
foreach ($array as $row) {
    if(!empty($row->pic)){
        $pic='<img src="'.getpic($row->pic).'" style="height:40px;">';
    }else{
        $pic='---';
    }
    if($row->tid==0){  //未推荐
        $tj='<span class="label label-danger radius">未推荐</span>';
    }else{
        $tj='<span class="label label-success radius">已推荐</span>';
    }
    if($row->yid==0){  //未隐藏
        $zt='<span class="label label-success radius">正常</span>';
    }else{
        $zt='<span class="label label-danger radius">隐藏</span>';
    }
    $bz = !empty($row->info) ? ' ['.$row->info.']' : '';
    $time = date('Y-m-d',$row->addtime);
    if(date('Y-m-d')==$time) $time = '<font color=red>'.$time.'</font>';
                  echo '
			<tr class="text-c odd">
                                <td><input type="checkbox" value="'.$row->id.'" name="id[]"></td>
				<td class="sorting_1">'.$row->id.'</td>
				<td>'.$pic.'</td>
				<td class="text-l"><a href="http://'.Web_Url.links('show','index',$row->id,0,1).'" target="_blank"><u class="text-primary">'.$row->name.$bz.'</u></a></td>
				<td>'.$row->hits.'</td>
				<td>'.$row->cion.'</td>
				<td>'.$row->daoyan.'</td>
				<td>'.$row->type.'</td>
				<td>'.$tj.'</td>
				<td>'.$zt.'</td>
				<td>'.$time.'</td>
				<td class="f-14 td-manage">
				    <a style="text-decoration:none" class="ml-5" onClick="cmd(\'视频编辑\',\''.links('vod','edit',0,'id='.$row->id).'\')" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a> 
				    <a style="text-decoration:none" class="ml-5" onClick="del(this,'.$row->id.')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
				</td>
			</tr>';
}
?>
		    </tbody>
		</table>
                <?=$pages?>
	</div>
        </form>
</div>
<footer class="footer"><p>页面执行时间{elapsed_time}秒，消耗内存{memory_usage}</p></footer>
<script type="text/javascript" src="<?=Base_Path?>jquery/jquery.min.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>layer/layer.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>datepicker/wdatepicker.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.admin.js"></script> 
<script type="text/javascript">
/*修改、查看*/
function cmd(title,links){
    var index = layer.open({
	type: 2,
	title: title,
	content: links
    });
    layer.full(index);
}
/*删除*/
function del(obj,id){
    layer.confirm('删除后不能恢复，确认要删除吗？',function(index){
        $.post('<?=links('vod','del')?>',{id: id},function(data) {
           var msg=data['error'];
	   if(msg == "ok"){//成功
		$(obj).parents("tr").remove();
		get_msg('已删除!',2000,1);
	   }else{
	        get_msg(msg);
	   }
        },"json");		
    });
}
function pl_del(obj,id){
  var xuan=0;
  $("td input:checkbox").each(function(){
      if($(this).prop("checked")){
          xuan++;
      }
  });
  if(xuan>0){
      layer.confirm('确认要删除吗？',function(){
	  $('#myform').submit();
      });
  }else{
      get_msg('请选择要删除的数据~!');
  }
}
function pl_cmd(sid){
  var xuan=0;
  $("td input:checkbox").each(function(){
      if($(this).prop("checked")){
          xuan++;
      }
  });
  if(xuan>0){
      if(sid==3){
          $('#myform').attr('action','<?=links('vod','yc')?>');
	  $('#myform').submit();
      } else if(sid==4){
          $('#myform').attr('action','<?=links('vod','xs')?>');
	  $('#myform').submit();
      } else if(sid==1){
          $('#myform').attr('action','<?=links('vod','html')?>');
	  $('#myform').submit();
      } else {
          $('#myform').attr('action','<?=links('vod','reco')?>');
	  $('#myform').submit();
      }
  }else{
      get_msg('请选择要操作的数据~!');
  }
}
</script>
</body>
</html>