<title>充值管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 充值管理 <span class="c-gray en">&gt;</span> 充值列表 <a class="btn btn-success radius r mr-20" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="pd-20">
       <form action="<?=links('pay','index')?>" method="post" class="form form-horizontal">
       <div class="text-c"> 
            <span class="select-box inline">
	      <select name="cid" class="select">
		<option value="">充值类型</option>
		<option value="1"<?php if($cid==1) echo ' selected';?>>金币</option>
		<option value="2"<?php if($cid==2) echo ' selected';?>>Vip</option>
	      </select>
            </span>  
            <span class="select-box inline">
	      <select name="pid" class="select">
		<option value="">付款状态</option>
		<option value="2"<?php if($pid==2) echo ' selected';?>>已完成</option>
		<option value="1"<?php if($pid==1) echo ' selected';?>>未完成</option>
	      </select>
            </span>
            <span class="select-box inline">
	      <select name="sid" class="select">
		<option value="">付款方式</option>
		<option value="1"<?php if($sid==1) echo ' selected';?>>支付宝</option>
		<option value="2"<?php if($sid==2) echo ' selected';?>>微信支付</option>
	      </select>
            </span> 日期范围：
            <input name="kstime" value="<?=$kstime?>" type="text" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})" class="input-text Wdate" style="width:120px;">
            -
            <input name="jstime" value="<?=$jstime?>" type="text" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})" class="input-text Wdate" style="width:120px;">
            <span class="select-box inline">
	      <select name="ziduan" class="select">
		<option value="dingdan"<?php if($ziduan=='dingdan') echo ' selected';?>>订单号</option>
		<option value="user"<?php if($ziduan=='user') echo ' selected';?>>会员名称</option>
		<option value="uid"<?php if($ziduan=='uid') echo ' selected';?>>会员ID</option>
		<option value="rmb"<?php if($ziduan=='rmb') echo ' selected';?>>充值金额</option>
		<option value="day"<?php if($ziduan=='day') echo ' selected';?>>vip天数</option>
	      </select>
            </span>
            <input type="text" value="<?=$key?>" name="key" placeholder="搜索内容" style="width:200px" class="input-text"><button name="so" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜记录</button>
        </div>
        </form>
	<form action="<?=links('pay','del',0,'ac=all')?>" method="post" class="form form-horizontal" id="myform" name="myform">
	<div class="cl pd-5 bg-1 bk-gray mt-20">
	<span class="r"><a href="javascript:;" onclick="pl_del()" class="btn btn-danger radius"><i class="Hui-iconfont"></i> 批量删除</a></span> </div>
	<div class="dataTables_wrapper no-footer">
	        <table class="table table-border table-bordered table-bg table-hover table-sort dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
		    <thead>
			<tr class="text-c">
                            <th width="25"><input type="checkbox" name="" value=""></th>
			    <th width="70">ID</th>
			    <th width="180">订单号</th>
			    <th>充值类型</th>
			    <th width="130">会员</th>
			    <th width="60">金额</th>
			    <th width="50">状态</th>
			    <th width="60">付款方式</th>
			    <th width="150">时间</th>
			    <th width="60">操作</th>
			</tr>
		    </thead>
		    <tbody>
<?php
if(empty($array)) echo '<tr><td colspan="10" class="text-c">没有记录~</td></tr>';
foreach ($array as $row) {
    if($row->sid==0){
        $lx='<span class="label label-danger radius">支付宝</span>';
    }else{
        $lx='<span class="label label-success radius">微信支付</span>';
    }
    if($row->pid==0){
        $zt='<span class="label label-danger radius">失败</span>';
    }else{
        $zt='<span class="label label-success radius">成功</span>';
    }
    if($row->cid==0){
	$name = '购买 '.$row->rmb*CT_Rmb_To_Cion.' 个金币';
    }else{
	$name = '购买 '.$row->day.' 天VIP';
    }
    $user = '--';
    if($row->uid>0) $user = getzd('user','name',$row->uid);
    $time = date('Y-m-d H:i:s',$row->addtime);
    if(date('Y-m-d')==date('Y-m-d',$row->addtime)) $time = '<font color=red>'.$time.'</font>';

                  echo '
			<tr class="text-c odd">
                                <td><input type="checkbox" value="'.$row->id.'" name="id[]"></td>
				<td class="sorting_1">'.$row->id.'</td>
				<td>'.$row->dingdan.'</td>
				<td>'.$name.'</td>
				<td>'.$user.'</td>
				<td>'.$row->rmb.'</td>
				<td>'.$zt.'</td>
				<td>'.$lx.'</td>
				<td>'.$time.'</td>
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
/*删除*/
function del(obj,id){
    layer.confirm('删除后不能恢复，确认要删除吗？',function(index){
        $.post('<?=links('card','del')?>',{id: id},function(data) {
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