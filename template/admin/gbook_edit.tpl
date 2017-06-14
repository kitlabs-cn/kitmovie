<title>回复留言</title>
</head>
<body>
<div class="pd-20">
	<form action="<?=links('gbook','save')?>" method="post" class="form form-horizontal" id="form-admin-add">
		<div class="row cl">
			<label class="form-label col-2"><span class="c-red">*</span>留言者：</label>
			<div class="formControls col-7">
				<input type="text" class="input-text" value="<?=$name?>" name="name" datatype="*" nullmsg="留言者不能为空">
			</div>
			<div class="col-2"> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-2">手机：</label>
			<div class="formControls col-7">
				<textarea name="content" class="textarea" style="height:90px;" datatype="*" nullmsg="留言内容不能为空"><?=$content?></textarea>
			</div>
			<div class="col-2"> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-2">回复：</label>
			<div class="formControls col-7">
				<textarea name="hfcontent" class="textarea" style="height:90px;"><?=$hfcontent?></textarea>
			</div>
			<div class="col-2"> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-2">状态：</label>
			<div class="formControls col-7">
            <span class="select-box inline">
	      <select name="yid" class="select">
		<option value="1"<?php if($yid==1) echo ' selected';?>>待审核</option>
		<option value="0"<?php if($yid==0) echo ' selected';?>>已审核</option>
	      </select>
            </span>
			</div>
			<div class="col-7"> </div>
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
<script type="text/javascript" src="<?=Base_Path?>datepicker/wdatepicker.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.admin.js"></script> 
<script type="text/javascript">
$(function(){
    $("#form-admin-add").Validform({tiptype:2});
});
</script>
</body>
</html>