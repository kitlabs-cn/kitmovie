<title>页面编辑</title>
</head>
<body>
<div class="pd-20">
	<form action="<?=links('pages','save')?>" method="post" class="form form-horizontal" id="form-admin-add">
		<div class="row cl">
			<label class="form-label col-2"><span class="c-red">*</span>标题：</label>
			<div class="formControls col-8">
				<input type="text" class="input-text" value="<?=$name?>" name="name" datatype="*" nullmsg="标题不能为空">
			</div>
			<div class="col-2"> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-2"><span class="c-red">*</span>标识：</label>
			<div class="formControls col-8">
				<input type="text" class="input-text" value="<?=$bs?>" style="width:150px;" name="bs" datatype="/^[a-z]{2,16}$/" nullmsg="页面标识不能为空" errormsg="只能为2-16位字母">
			</div>
			<div class="col-2"> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-2">状态：</label>
			<div class="formControls col-8"> <span class="select-box" style="width:150px;">
				<select class="select" name="yid" size="1">
				<option value="0"<?php if($yid==0) echo ' selected';?>>显示</option>
				<option value="1"<?php if($yid==1) echo ' selected';?>>隐藏</option>
				</select>
				</span>  
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-2">内容：</label>
			<div class="formControls col-8"> 
				<textarea class="textarea" style="width:100%;height:350px;" name="text"><?=$text?></textarea>
			</div>
			<div class="col-2"> </div>
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
<script type="text/javascript" src="<?=Base_Path?>editor/kindeditor.js"></script> 
<script type="text/javascript">
$(function(){
    $("#form-admin-add").Validform({tiptype:2});
});
var editor;
var editor_upsave='<?=links('upload','editor')?>';
KindEditor.ready(function(K) {
    editor = K.create('textarea[name="text"]', {
        allowFileManager : true,
        items : [
            'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
            'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
            'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
            'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
            'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
            'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image',
            'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
            'anchor', 'link', 'unlink'
        ],
        afterBlur: function(){this.sync();}
    });
});
</script>
</body>
</html>