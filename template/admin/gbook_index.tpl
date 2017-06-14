<title>留言管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 留言管理 <span class="c-gray en">&gt;</span> 留言列表 <a class="btn btn-success radius r mr-20" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="pd-20">
       <form action="<?=links('gbook','index')?>" method="post" class="form form-horizontal">
       <div class="text-c"> 
            <span class="select-box inline">
	      <select name="yid" class="select">
		<option value="0">留言状态</option>
		<option value="1"<?php if($yid==1) echo ' selected';?>>已审核</option>
		<option value="2"<?php if($yid==2) echo ' selected';?>>未审核</option>
	      </select>
            </span> 日期范围：
            <input name="kstime" value="<?=$kstime?>" type="text" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})" class="input-text Wdate" style="width:120px;">
            -
            <input name="jstime" value="<?=$jstime?>" type="text" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})" class="input-text Wdate" style="width:120px;">
            <span class="select-box inline">
	      <select name="ziduan" class="select">
		<option value="name"<?php if($ziduan=='name') echo ' selected';?>>留言名字</option>
		<option value="content"<?php if($ziduan=='content') echo ' selected';?>>留言内容</option>
		<option value="hfcontent"<?php if($ziduan=='hfcontent') echo ' selected';?>>回复内容</option>
	      </select>
            </span>
            <input type="text" value="<?=$key?>" name="key" placeholder="搜索内容" style="width:200px" class="input-text"><button name="so" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜留言</button>
        </div>
        </form>
	<form action="<?=links('gbook','del',0,'ac=all')?>" method="post" class="form form-horizontal" id="myform" name="myform">
	<div class="cl pd-5 bg-1 bk-gray mt-20"><span class="l">  
	<a class="btn btn-primary radius" href="javascript:;" onclick="pl_cmd(1);"><i class="Hui-iconfont">&#xe600;</i> 批量审核</a> 
	</span> <span class="r"><a href="javascript:;" onclick="pl_cmd(2)" class="btn btn-danger radius"><i class="Hui-iconfont"></i> 批量删除</a></span> </div>
	<div class="dataTables_wrapper no-footer">
	        <table class="table table-border table-bordered table-bg table-hover table-sort dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
		    <thead>
			<tr class="text-c">
                            <th width="25"><input type="checkbox" name="" value=""></th>
			    <th width="70">ID</th>
			    <th width="120">留言者</th>
			    <th>内容</th>
			    <th width="70">状态</th>
			    <th width="120">时间</th>
			    <th width="60">操作</th>
			</tr>
		    </thead>
		    <tbody>
<?php
if(empty($array)) echo '<tr><td colspan="7" class="text-c">没有记录~</td></tr>';
foreach ($array as $row) {
    if($row->yid==1){
        $zt='<span class="label label-danger radius">待审核</span>';
    }else{
        if(!empty($row->hfcontent)){
            $zt='<span class="label label-warning radius">已回复</span>';
	}else{
            $zt='<span class="label label-success radius">已审核</span>';
	}
    }
    $time = date('Y-m-d H:i:s',$row->addtime);
    if(date('Y-m-d')==date('Y-m-d',$row->addtime)) $time = '<font color=red>'.$time.'</font>';

                  echo '
			<tr class="text-c odd">
                                <td><input type="checkbox" value="'.$row->id.'" name="id[]"></td>
				<td class="sorting_1">'.$row->id.'</td>
				<td>'.$row->name.'</td>
				<td>'.$row->content.'</td>
				<td>'.$zt.'</td>
				<td>'.$time.'</td>
				<td class="f-14 td-manage">
				    <a style="text-decoration:none" class="ml-5" onClick="cmd(\'留言回复\',\''.links('gbook','edit',0,'id='.$row->id).'\')" href="javascript:;" title="编辑回复">回复</a> 
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
        $.post('<?=links('gbook','del')?>',{id: id},function(data) {
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
function pl_cmd(id){
  var xuan=0;
  $("td input:checkbox").each(function(){
      if($(this).prop("checked")){
          xuan++;
      }
  });
  if(xuan>0){
      layer.confirm('确认要操作吗？',function(){
          if(id==1){
              $('#myform').attr('action','<?=links('gbook','init')?>');
	  }
	  $('#myform').submit();
      });
  }else{
      get_msg('请选择要操作的数据~!');
  }
}
</script>
</body>
</html>