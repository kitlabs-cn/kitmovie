<title>广告管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 广告管理 <span class="c-gray en">&gt;</span> 广告列表 <a class="btn btn-success radius r mr-20" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="pd-20">
	<form action="<?=links('ads','del')?>?ac=all" method="post" class="form form-horizontal" id="myform" name="myform">
	<div class="cl pd-5 bg-1 bk-gray"> <span class="l"> 
	<a class="btn btn-primary radius" href="javascript:;" onclick="cmd('添加广告','<?=links('ads','edit')?>')"><i class="Hui-iconfont">&#xe600;</i> 添加广告</a> 
	</span> <span class="r"><a href="javascript:;" onclick="pl_del()" class="btn btn-danger radius"><i class="Hui-iconfont"></i> 批量删除</a></span> </div>
	<div class="dataTables_wrapper no-footer">
	        <table class="table table-border table-bordered table-bg table-hover table-sort dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
		    <thead>
			<tr class="text-c">
                            <th width="25"><input type="checkbox" name="" value=""></th>
			    <th width="80">ID</th>
			    <th width="250">标题</th>
			    <th>标签</th>
			    <th width="100">标识</th>
			    <th width="80">状态</th>
			    <th width="80">操作</th>
			</tr>
		    </thead>
		    <tbody>
<?php
if(empty($array)) echo '<tr><td colspan="7" class="text-c">没有记录~</td></tr>';
foreach ($array as $row) {
        $zt = ($row->yid==0) ? '<span class="label label-success radius">显示</span>' : '<span class="label label-primary radius">隐藏</span>';
                  echo '
			<tr class="text-c odd">
                                <td><input type="checkbox" value="'.$row->id.'" name="id[]"></td>
				<td class="sorting_1">'.$row->id.'</td>
				<td><a href="'.links('ads','index',$row->id,'',1).'" target="_blank">'.$row->name.'</a></td>
				<td>{ctcms_js_'.$row->id.'}</td>
				<td>'.$row->bs.'</td>
				<td>'.$zt.'</td>
				<td class="f-14 td-manage">
				    <a style="text-decoration:none" class="ml-5" onClick="cmd(\'编辑修改\',\''.links('ads','edit',0,'id='.$row->id).'\')" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a> 
				    <a style="text-decoration:none" class="ml-5" onClick="del(this,'.$row->id.')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
				</td>
			</tr>';
}
?>
		    </tbody>
		</table>
                <?=$ads?>
	</div>
        </form>
</div>
<footer class="footer"><p>广告执行时间{elapsed_time}秒，消耗内存{memory_usage}</p></footer>
<script type="text/javascript" src="<?=Base_Path?>jquery/jquery.min.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>layer/layer.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>datepicker/wdatepicker.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.admin.js"></script> 
<script type="text/javascript">
/*修改*/
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
        $.post('<?=links('ads','del')?>',{id: id},function(data) {
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
</script>
</body>
</html>