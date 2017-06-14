<title>备份还原</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 系统管理 <span class="c-gray en">&gt;</span> 备份还原 <a class="btn btn-success radius r mr-20" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<form action="<?=site_url('basedb/optimize')?>" method="post" id="myform" name="myform">
<div class="pd-20">
	<div class="cl pd-5 bg-1 bk-gray"> 
	  <span class="l"> 
	    <a class="btn btn-danger radius" href="<?=links('basedb')?>">数据备份</a> 
	    <a class="btn btn-primary radius" href="<?=links('basedb','restore')?>">数据还原</a> 
	  </span> 
	  <span class="r"></span> 
	</div>
	<table class="table table-border table-bordered table-hover table-bg">
		<thead>
			<tr>
				<th scope="col" colspan="9">数据库管理</th>
			</tr>
			<tr class="text-c">
				<th width="25"><input type="checkbox" value="" name=""></th>
				<th width="40">ID</th>
				<th>表名</th>
				<th width="100">类型</th>
				<th width="120">编码</th>
				<th width="100">记录数</th>
				<th width="100">使用空间</th>
				<th width="100">碎片</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
<?php
$i=1;
foreach ($tables as $row) {
        if(strpos($row['Name'],CT_SqlPrefix) !== FALSE){
                    echo '
			<tr class="text-c">
				<td><input type="checkbox" value="'.$row['Name'].'" name="id[]"></td>
				<td>'.$i.'</td>
				<td>'.$row['Name'].'</td>
				<td>'.$row['Engine'].'</td>
				<td>'.$row['Collation'].'</td>
				<td>'.$row['Rows'].'</td>
				<td>'.formatsize($row['Data_length']).'</td>
				<td>'.formatsize($row['Data_free']).'</td>
				<td class="f-14">
				   <a title="优化表" href="javascript:;" onclick="cmd(\''.links('basedb','optimize',0,'table='.$row['Name']).'\');" class="label-success radius cmd">优化</a> 
				   <a title="修复表" href="javascript:;" onclick="cmd(\''.links('basedb','repair',0,'table='.$row['Name']).'\');" class="ml-5 label-danger radius cmd">修复</a>
				</td>
			</tr>';
             $i++;
	 }
}
?>
		</tbody>
	</table>
	<div class="cl pd-5 bg-1 bk-gray"> 
	  <span class="l"> 
	    <a sid="1" id="checkbox" class="btn radius" href="javascript:;">全选</a>
	    <a class="btn radius" href="javascript:;" onclick="pl_cmd('<?=links('basedb','optimize')?>');">批量优化</a> 
	    <a class="btn radius" href="javascript:;" onclick="pl_cmd('<?=links('basedb','repair')?>');">批量修复</a> 
	    <a class="btn radius" href="javascript:;" onclick="pl_cmd('<?=links('basedb','backup')?>');"><font color=#0000ff>开始备份数据库</font></a> 
	  </span>  
	</div>
</div>
</form>
<footer class="footer"><p>页面执行时间{elapsed_time}秒，消耗内存{memory_usage}</p></footer>
<script type="text/javascript" src="<?=Base_Path?>jquery/jquery.min.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>layer/layer.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.admin.js"></script> 
<script> 
function pl_cmd(links){
  var xuan=0;
  $("td input:checkbox").each(function(){
      if($(this).prop("checked")){
          xuan++;
      }
  });
  if(xuan>0){
      layer.confirm('确认要操作吗？',function(){
	  $('#myform').attr('action',links);
	  $('#myform').submit();
      });
  }else{
      layer.msg('请选择要操作的数据表~!');
  }
}
function cmd(links){
  layer.confirm('确认要操作吗？',function(){
	window.location.href=links;
  });
}
</script> 
</body>
</html>