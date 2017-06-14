<title>添加友情链接</title>
</head>
<body>
<div class="pd-20">
	<form action="<?=links('links','save')?>" method="post" class="form form-horizontal" id="form-admin-add">
		<div class="row cl">
			<label class="form-label col-2"><span class="c-red">*</span>名称：</label>
			<div class="formControls col-6">
				<input type="text" class="input-text" value="<?=$name?>" placeholder="名称" name="name" datatype="*" nullmsg="名称不能为空">
			</div>
			<div class="col-4"> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-2"><span class="c-red">*</span>链接：</label>
			<div class="formControls col-6">
				<input type="text" class="input-text" value="<?=$link?>" placeholder="链接" name="link" datatype="*" nullmsg="链接不能为空">
			</div>
			<div class="col-4"> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-2"><span class="c-red">*</span>类型：</label>
			<div class="formControls col-6"> <span class="select-box">
				<select class="select" name="cid" size="1">
				<option value="0"<?php if($cid==0) echo ' selected';?>>文字</option>
				<option value="1"<?php if($cid==1) echo ' selected';?>>图片</option>
				</select>
				</span>
			</div>
			<div class="col-4"> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-2"><span class="c-red">*</span>图片：</label>
			<div class="formControls col-6">
				<input placeholder="图片" type="text" id="pic" name="pic" class="input-text" value="<?=$pic?>">
			</div>
			<div class="col-4"> 
				<a href="javascript:;" class="file" onClick="upload();">上传图片
				<input type="button" name="userfile">
				</a>
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
<script type="text/javascript" src="<?=Base_Path?>validform/validform.min.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>layer/layer.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.admin.js"></script> 
<script type="text/javascript">
$(function(){
    $("#form-admin-add").Validform({tiptype:2});
});
/*上传图片*/
function upload(){
    layer_show('上传图片','<?=links('upload','',0,'ac=link')?>',400,200);
}
</script>
</body>
</html>