<title>管理员管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 管理员列表 <a class="btn btn-success radius r mr-20" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="pd-20">
       <form action="<?=links('sys','log')?>" method="post" class="form form-horizontal">
       <div class="text-c"> 日期范围：
            <input name="kstime" value="<?=$kstime?>" type="text" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})" class="input-text Wdate" style="width:120px;">
            -
            <input name="jstime" value="<?=$jstime?>" type="text" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})" class="input-text Wdate" style="width:120px;">
            <input type="text" value="<?=$user?>" name="user" placeholder="管理员名称" style="width:150px" class="input-text"><button name="so" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜日志</button>
        </div>
        </form>
	<form action="<?=links('sys','log_del',0,'ac=all')?>" method="post" class="form form-horizontal" id="myform" name="myform">
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"> 
	<a href="javascript:;" onclick="pl_del()" class="btn btn-danger radius"><i class="Hui-iconfont"></i> 批量删除</a>
	</span> <span class="r">共有数据：<strong><?=$nums?></strong> 条</span> </div>
	<div class="dataTables_wrapper no-footer">
	        <table class="table table-border table-bordered table-bg table-hover table-sort dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
		    <thead>
			<tr class="text-c">
                            <th width="25"><input type="checkbox" name="" value=""></th>
			    <th width="40">ID</th>
			    <th width="200">账号</th>
			    <th>客户端信息</th>
			    <th width="120">登陆IP</th>
			    <th width="120">登陆时间</th>
			    <th width="70" class="sorting_disabled">操作</th>
			</tr>
		    </thead>
		    <tbody>
<?php
if(empty($array)) echo '<tr><td colspan="6" class="text-c">没有记录~</td></tr>';
foreach ($array as $row) {
                  echo '
			<tr class="text-c odd">
                                <td><input type="checkbox" value="'.$row->id.'" name="id[]"></td>
				<td class="sorting_1">'.$row->id.'</td>
				<td>'.getzd('admin','name',$row->uid).'</td>
				<td>'.$row->ua.'</td>
				<td>'.$row->ip.'</td>
				<td>'.date('Y-m-d H:i:s',$row->logtime).'</td>
				<td class="f-14 td-manage"><a title="删除" href="javascript:;" onclick="del(this,'.$row->id.')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
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
/*删除*/
function del(obj,id){
    layer.confirm('删除后不能恢复，确认要删除吗？',function(index){
        $.post('<?=links('sys','del')?>',{id: id},function(data) {
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