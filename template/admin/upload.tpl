<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>附件上传</title>
<link href="<?=Base_Path?>uploadify/upload.css" rel="stylesheet" type="text/css" />
<script>var base_path='<?=Base_Path?>';</script>
<script type="text/javascript" src="<?=Base_Path?>jquery/jquery.min.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>layer/layer.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.admin.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>uploadify/jquery.uploadify.min.js"></script>
</head>
<body>
<div id="content">
	<form class="left">
		<div id="queue"></div>
		<input type="button" id="start" class="uploadify-button" value="上传" />
		<input id="file" name="Filedata" type="file" multiple="true" />
	</form>
</div>
<script type="text/javascript">
$(function(){
    $('#file').uploadify({
        'fileSizeLimit': '20480',
        'queueSizeLimit': 1,
        'multi': true,
        'buttonText': '选择文件',
        'auto': false,
        'width':85,
        'fileTypeDesc':'All Files',
        'fileTypeExts':'<?=$types?>',
        'swf': '<?=Base_Path?>uploadify/uploadify.swf',
        'uploader': '<?=$upsave?>',
	'formData': {'key':'<?=$key?>','dir':'<?=$dir?>'},
        'onUploadSuccess': function(file, data, response){
	    var msg=eval('(' + data + ')');
	    var code = msg.code;
            if(code==0){
	          parent.$('#pic<?=$sid?>').val(msg.str);
	         layer_close();
            }else{
                 get_msg(msg.str);
            }
        }
    });
    $('#start').click(function(){
        $('#file').uploadify('upload', '*');
    });
});
</script>
</body>
</html>