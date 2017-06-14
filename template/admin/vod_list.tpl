<title>视频管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 视频管理 <span class="c-gray en">&gt;</span> 分类列表 <a class="btn btn-success radius r mr-20" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="pd-20">
	<form action="<?=links('vod','lists_del')?>?ac=all" method="post" class="form form-horizontal" id="myform" name="myform">
	<div class="cl pd-5 bg-1 bk-gray"> <span class="l"> 
	<a href="javascript:;" onclick="pl_cmd(0)" class="btn btn-danger radius"><i class="Hui-iconfont"></i> 批量删除</a>
	<a href="javascript:;" onclick="pl_cmd(1)" class="btn btn-success radius"><i class="Hui-iconfont">&#xe6df;</i> 批量排序</a>
	<a class="btn btn-primary radius" href="javascript:;" onclick="edit('添加分类','<?=links('vod','lists_edit')?>')"><i class="Hui-iconfont">&#xe600;</i> 添加分类</a> 
	</span> <span class="r">共有数据：<strong><?=$nums?></strong> 条</span> </div>
	<div class="dataTables_wrapper no-footer">
	        <table class="table table-border table-bordered table-bg table-hover table-sort dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
		    <thead>
			<tr class="text-c">
                            <th width="25"><input type="checkbox" name="" value=""></th>
			    <th width="40">ID</th>
			    <th width="100">排序</th>
			    <th>分类名称</th>
			    <th width="100" class="sorting_disabled">操作</th>
			</tr>
		    </thead>
		    <tbody>
<?php
if(empty($array)) echo '<tr><td colspan="5" class="text-c">没有记录~</td></tr>';
foreach ($array as $row) {
                  echo '
			<tr class="text-c odd">
                                <td><input type="checkbox" value="'.$row->id.'" name="id[]"></td>
				<td class="sorting_1">'.$row->id.'</td>
				<td><input class="input-text" style="width:90px;text-align:center;" type="text" value="'.$row->xid.'" name="xid[]"></td>
				<td class="text-l">├&nbsp;'.$row->name.'</td>
				<td class="f-14"><a title="编辑" href="javascript:;" onclick="edit(\'分类编辑\',\''.links('vod','lists_edit',0,'id='.$row->id).'\','.$row->id.')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="del(this,'.$row->id.')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
			</tr>';
                  $array2 = $this->csdb->get_select('class','*',array('fid'=>$row->id),'xid ASC');
                  foreach ($array2 as $row2) {
                      echo '
			<tr class="text-c odd">
                                <td><input type="checkbox" value="'.$row2->id.'" name="id[]"></td>
				<td class="sorting_1">'.$row2->id.'</td>
				<td><input class="input-text" style="width:90px;text-align:center;" type="text" value="'.$row2->xid.'" name="xid[]"></td>
				<td class="text-l">&nbsp;&nbsp;&nbsp;&nbsp;|———&nbsp;'.$row2->name.'</td>
				<td class="f-14"><a title="编辑" href="javascript:;" onclick="edit(\'分类编辑\',\''.links('vod','lists_edit',0,'id='.$row2->id).'\')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="del(this,'.$row2->id.')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
			</tr>';
		  }
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
/*新增-编辑*/
function edit(title,url){
    layer_show(title,url,500,300);
}
/*删除*/
function del(obj,id){
    layer.confirm('删除后不能恢复，确认要删除吗？',function(index){
        $.post('<?=links('vod','lists_del')?>',{id: id},function(data) {
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
function pl_cmd(sid){
  var xuan=0;
  $("td input:checkbox").each(function(){
      if($(this).prop("checked")){
          xuan++;
      }
  });
  if(xuan>0){
      if(sid==0){
          layer.confirm('删除后不能恢复，确认要删除吗？',function(){
	      $('#myform').submit();
          });
      }else{
          $('#myform').attr('action','<?=links('vod','lists_plpx')?>');
	  $('#myform').submit();
      }
  }else{
      get_msg('请选择要操作的数据~!');
  }
}
</script>
</body>
</html>