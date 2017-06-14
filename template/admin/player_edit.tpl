<title>添加播放器</title>
</head>
<body>
<div class="pd-20">
	<form action="<?=links('player','save')?>" method="post" class="form form-horizontal" id="form-admin-add">
		<div class="row cl">
			<label class="form-label col-2"><span class="c-red">*</span>排序：</label>
			<div class="formControls col-8">
				<input type="text" class="input-text" value="<?=$xid?>" placeholder="排序ID、越小越前" name="xid">
			</div>
			<div class="col-2"> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-2"><span class="c-red">*</span>名称：</label>
			<div class="formControls col-8">
				<input type="text" class="input-text" value="<?=$name?>" placeholder="名称" name="name" datatype="*" nullmsg="名称不能为空">
			</div>
			<div class="col-2"> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-2"><span class="c-red">*</span>标示：</label>
			<div class="formControls col-8">
				<input name="bs" type="text" placeholder="只能字母、数字、下划线" value="<?=$bs?>" class="input-text" datatype="s" nullmsg="标示不能为空">
			</div>
			<div class="col-2"> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-2"><span class="c-red">*</span>介绍：</label>
			<div class="formControls col-8">
				<input type="text" class="input-text" value="<?=$text?>" placeholder="简单介绍" name="text">
			</div>
			<div class="col-2"> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-2"><span class="c-red">*</span>代码：</label>
			<div class="formControls col-8">
				<textarea name="js" class="textarea" style="width:100%;height:200px;" datatype="*" nullmsg="代码不能为空"><?=$js?></textarea>
			</div>
			<div class="col-2"> 可用标签：视频地址 {url}，网站路径 {ctcms_path}</div>
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
<script type="text/javascript" src="<?=Base_Path?>validform/validform.min.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>layer/layer.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.admin.js"></script> 
<script type="text/javascript">
$(function(){
    $("#form-admin-add").Validform({tiptype:2});
});
</script>
</body>
</html>