<title>备份还原</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 系统管理 <span class="c-gray en">&gt;</span> 备份还原 <a class="btn btn-success radius r mr-20" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<form action="<?=links('basedb','del')?>" method="post" id="myform" name="myform">
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
				<th scope="col" colspan="6">数据库还原</th>
			</tr>
			<tr class="text-c">
				<th width="25"><input type="checkbox" value="" name=""></th>
				<th>文件名</th>
				<th width="100">文件大小</th>
				<th width="120">备份时间</th>
				<th width="100">卷数量</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
<?php
if(empty($map)) echo '<tr><td colspan="6" class="text-c">没有备份文件~</td></tr>';
foreach ($map as $dir) {
   if (is_dir(FCPATH.'attachment/backup/'.$dir) && substr($dir,0,6)=='Ctcms_') {
        $dirs = directory_map(FCPATH.'attachment/backup/'.$dir, 1);
	$this->load->helper('file');
	$fine=get_file_info(FCPATH.'attachment/backup/'.$dir, $file_information='date');
	$dir = str_replace("\\","",$dir);
	$dir = str_replace("/","",$dir);
                    echo '
			<tr class="text-c">
				<td><input type="checkbox" value="'.$dir.'" name="id[]"></td>
				<td>'.$dir.'</td>
				<td>'.formatsize(getdirsize('./attachment/backup/'.$dir)).'</td>
				<td>'.date('Y-m-d H:i:s',$fine['date']).'</td>
				<td>'.count($dirs).'</td>
				<td class="f-14">
				   <a title="打包下载" href="'.links('basedb','zip',0,'dir='.$dir).'" class="label-success radius cmd">下载</a> 
				   <a title="还原数据库" href="javascript:;" onclick="cmd(\''.links('basedb','restore_save',0,'dir='.$dir).'\');" class="ml-5 label-danger radius cmd">还原</a>
				</td>
			</tr>';
   }
}
?>
		</tbody>
	</table>
	<div class="cl pd-5 bg-1 bk-gray"> 
	  <span class="l"> 
	    <a sid="1" id="checkbox" class="btn radius" href="javascript:;">全选</a>
	    <a class="btn radius" href="javascript:;" onclick="pl_cmd();">批量删除</a> 
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
function pl_cmd(){
  var xuan=0;
  $("td input:checkbox").each(function(){
      if($(this).prop("checked")){
          xuan++;
      }
  });
  if(xuan>0){
      layer.confirm('确认要操作吗？',function(){
	  $('#myform').submit();
      });
  }else{
      layer.msg('请选择要删除的数据~!');
  }
}
function cmd(links){
  layer.confirm('数据不可逆转，您确定要还原吗？',function(){
	get_msg('数据还原中，请稍后...',1000*60*60*60,16);
	setTimeout("location.href='"+links+"'",1000); 
  });
}
</script> 
</body>
</html>