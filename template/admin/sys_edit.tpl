<title>添加管理员</title>
</head>
<body>
<div class="pd-20">
	<form action="<?=links('sys','save')?>" method="post" class="form form-horizontal" id="form-admin-add">
		<div class="row cl">
			<label class="form-label col-3"><span class="c-red">*</span>账号：</label>
			<div class="formControls col-5">
				<input type="text" class="input-text" value="<?=$name?>" placeholder="账号" name="name" datatype="*" nullmsg="账号不能为空">
			</div>
			<div class="col-4"> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-3"><span class="c-red">*</span>密码：</label>
			<div class="formControls col-5">
				<input name="pass" type="password" placeholder="<?=$id==0?'密码':'不修改，请留空';?>" autocomplete="off" value="" class="input-text"<?=$id==0?' datatype="*" nullmsg="密码不能为空"':'';?>>
			</div>
			<div class="col-4"> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-3"><span class="c-red">*</span>昵称：</label>
			<div class="formControls col-5">
				<input type="text" class="input-text" value="<?=$nichen?>" placeholder="称呼、昵称" name="nichen"  datatype="*" nullmsg="昵称不能为空">
			</div>
			<div class="col-4"> </div>
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