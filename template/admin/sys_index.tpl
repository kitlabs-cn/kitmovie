<title>管理员管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 管理员列表 <a class="btn btn-success radius r mr-20" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="pd-20">
	<div class="cl pd-5 bg-1 bk-gray"> <span class="l"> <a class="btn btn-primary radius" href="javascript:;" onclick="admin_role_add('添加管理员','<?=links('sys','edit')?>','400','280')"><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a> </span> <span class="r">共有数据：<strong><?=$nums?></strong> 条</span> </div>
	<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
	        <table class="table table-border table-bordered table-bg table-hover table-sort dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
		    <thead>
			<tr class="text-c">
			    <th width="40" class="sorting_desc">ID</th>
			    <th width="200" class="sorting">账号</th>
			    <th class="sorting">昵称</th>
			    <th width="100" class="sorting">登陆次数</th>
			    <th width="130" class="sorting">最后登陆IP</th>
			    <th width="160" class="sorting">最后登陆时间</th>
			    <th width="70" class="sorting_disabled">操作</th>
			</tr>
		    </thead>
		    <tbody>
<?php
if(empty($array)) echo '<tr><td colspan="7" class="text-c">没有记录~</td></tr>';
foreach ($array as $row) {
         $logtime=$row->logtime==0?'未登陆':date('Y-m-d H:i:s',$row->logtime);
                  echo '
			<tr class="text-c odd">
				<td class="sorting_1">'.$row->id.'</td>
				<td>'.$row->name.'</td>
				<td>'.$row->nichen.'</td>
				<td>'.$row->lognum.'</td>
				<td>'.$row->logip.'</td>
				<td>'.$logtime.'</td>
				<td class="f-14 td-manage"><a title="编辑" href="javascript:;" onclick="admin_role_edit(\'管理员编辑\',\''.links('sys','edit',0,'id='.$row->id).'\','.$row->id.',400,280)" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_role_del(this,'.$row->id.')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
			</tr>';
}
?>
		    </tbody>
		</table>
                <?=$pages?>
	</div>
</div>
<footer class="footer"><p>页面执行时间{elapsed_time}秒，消耗内存{memory_usage}</p></footer>
<script type="text/javascript" src="<?=Base_Path?>jquery/jquery.min.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>layer/layer.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.admin.js"></script> 
<script type="text/javascript">
/*管理员-添加*/
function admin_role_add(title,url,w,h){
    layer_show(title,url,w,h);
}
/*管理员-编辑*/
function admin_role_edit(title,url,id,w,h){
    layer_show(title,url,w,h);
}
/*管理员-删除*/
function admin_role_del(obj,id){
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
</script>
</body>
</html>