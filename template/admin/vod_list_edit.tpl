<title>文章栏目设置</title>
</head>
<body>
<div class="pd-10">
	<form action="<?=links('vod','lists_save')?>" method="post" class="form form-horizontal" id="form-admin-add" enctype="multipart/form-data">
		<div id="tab-category" class="HuiTab">
			<div class="tabCon" style="display:block;">
				<div class="row cl">
					<label class="form-label col-3"><span class="c-red">*</span>上级栏目：</label>
					<div class="formControls col-6"> <span class="select-box">
						<select class="select" name="fid">
							<option value="0">顶级分类</option>
<?php
foreach ($array as $row) {
     $clas = ($fid==$row->id) ? ' selected="selected"' : '';
     echo '<option value="'.$row->id.'"'.$clas.'>'.$row->name.'</option>';
}
?>
						</select>
						</span> </div>
					<div class="col-3"> </div>
				</div>
				<div class="row cl">
					<label class="form-label col-3"><span class="c-red">*</span>分类名称：</label>
					<div class="formControls col-6">
						<input type="text" class="input-text" value="<?=$name?>" placeholder="分类名称" name="name" datatype="*2-16" nullmsg="分类名称不能为空">
					</div>
					<div class="col-3"> </div>
				</div>
				<div class="row cl">
					<label class="form-label col-3">模板：</label>
					<div class="formControls col-6">
						<input type="text" class="input-text" value="<?=$skin?>" placeholder="列表模板" name="skin">
					</div>
					<div class="col-3"> </div>
				</div>
				<div class="row cl">
					<label class="form-label col-3">排序：</label>
					<div class="formControls col-6">
						<input type="text" class="input-text" value="<?=$xid?>" placeholder="越小越靠前" name="xid">
					</div>
					<div class="col-3"> </div>
				</div>
			</div>
		</div>
		<div class="row cl">
			<div class="col-9 col-offset-3">
		                <input name="id" type="hidden" value="<?=$id?>">
				<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
			</div>
		</div>
	</form>
</div>
<script type="text/javascript" src="<?=Base_Path?>jquery/jquery.min.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>layer/layer.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>validform/validform.min.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.admin.js"></script> 
<script type="text/javascript">
$(function(){
    $("#form-admin-add").Validform({tiptype:2});
});
</script>
</body>
</html>