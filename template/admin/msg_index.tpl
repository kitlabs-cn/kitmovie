<title>回复管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 回复管理 <span class="c-gray en">&gt;</span> 回复列表 <a class="btn btn-success radius r mr-20" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="pd-20">
       <form action="<?=links('msg','index')?>" method="post" class="form form-horizontal">
       <div class="text-c"> 
            日期范围：
            <input name="kstime" value="<?=$kstime?>" type="text" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})" class="input-text Wdate" style="width:120px;">
            -
            <input name="jstime" value="<?=$jstime?>" type="text" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})" class="input-text Wdate" style="width:120px;">
            <span class="select-box inline">
	      <select name="ziduan" class="select">
			<option value="id"<?php if($ziduan=='id') echo ' selected';?>>回复ID</option>
			<option value="uid"<?php if($ziduan=='uid') echo ' selected';?>>用户ID</option>
			<option value="tid"<?php if($ziduan=='tid') echo ' selected';?>>文章ID</option>
			<option value="content"<?php if($ziduan=='content') echo ' selected';?>>回复内容</option>
			<option value="title"<?php if($ziduan=='title') echo ' selected';?>>文章标题</option>
	      </select>
            </span>
            <input type="text" value="<?=$key?>" name="key" placeholder="搜索内容" style="width:200px" class="input-text"><button name="so" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜回复</button>
        </div>
        </form>
	<form action="<?=links('msg','del',0,'ac=all')?>" method="post" class="form form-horizontal" id="myform" name="myform">
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">  
	<a class="btn btn-primary radius" href="javascript:;" onclick="cmd('添加回复','<?=links('msg','edit')?>')"><i class="Hui-iconfont">&#xe600;</i> 添加回复</a> 
	</span> <span class="r"><a href="javascript:;" onclick="pl_del()" class="btn btn-danger radius"><i class="Hui-iconfont"></i> 批量删除</a></span> </div>
	<div class="dataTables_wrapper no-footer">
	        <table class="table table-border table-bordered table-bg table-hover table-sort dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
		    <thead>
			<tr class="text-c">
                            <th width="25"><input type="checkbox" name="" value=""></th>
			    <th width="40">ID</th>
			    <th width="40">文章ID</th>
			    <th width="40">用户ID</th>
			    <th width="60">用户昵称</th>
			    <th width="70">被回复者ID</th>
			    <th width="75">被回复者昵称</th>
			    <th >文章标题</th>
			    <th >回复内容</th>
			    <th width="120">回复时间</th>
			    <th width="80">操作</th>
			</tr>
		    </thead>
		    <tbody>
<?php
if(empty($array)) echo '<tr><td colspan="10" class="text-c">没有记录~</td></tr>';
foreach ($array as $row) {
                  echo '
			<tr class="text-c odd">
                                <td><input type="checkbox" value="'.$row->id.'" name="id[]"></td>
				<td class="sorting_1">'.$row->id.'</td>
				<td>'.$row->tid.'</td>
				<td>'.$row->uid.'</td>
				<td>'.$row->nichen.'</td>
				<td>'.$row->ruid.'</td>
				<td>'.$row->rnichen.'</td>
				<td>'.$row->title.'</td>
				<td>'.$row->content.'</td>
				<td>'.date('Y-m-d,H:i:s',$row->addtime).'</td>
				<td class="f-14 td-manage"> 
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
function cmd(title,url){
    layer_show(title,url,700,450);
}
/*删除*/
function del(obj,id){
    layer.confirm('删除后不能恢复，确认要删除吗？',function(index){
        $.post('<?=links('msg','del')?>',{id: id},function(data) {
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