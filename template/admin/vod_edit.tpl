<title>视频编辑</title>
</head>
<body>
<div class="pd-20">
	<form action="<?=links('vod','save')?>" method="post" class="form form-horizontal" id="form-admin-add">
		<div class="row cl">
			<label class="form-label col-2"><span class="c-red">*</span>分类：</label>
			<div class="formControls col-8"> <span class="select-box" style="width:130px;">
				<select class="select" name="cid" size="1">
				<?php 
				   foreach ($lists as $row) {
				        $cls = $row->id == $cid ? ' selected="selected"' : '';
					echo '<option value="'.$row->id.'"'.$cls.'>├&nbsp;'.$row->name.'</option>';
					$array2 = $this->csdb->get_select('class','id,name',array('fid'=>$row->id),'xid ASC');
                                        foreach ($array2 as $row3) {
	                                    $cls2 = $row3->id == $cid ? ' selected="selected"' : '';
	                                    echo '<option value="'.$row3->id.'"'.$cls2.'>&nbsp;&nbsp;├&nbsp;'.$row3->name.'</option>';
	                                }
				   }
				?>
				</select>
				</span>
				<span class="select-box" style="width:80px;">
				<select class="select" name="tid" size="1">
				<option value="1"<?php if($tid==1) echo ' selected';?>>推荐</option>
				<option value="0"<?php if($tid==0) echo ' selected';?>>不推荐</option>
				</select>
				</span>
				<span class="select-box" style="width:100px;">
				<select class="select" name="zid" size="1">
				<option value="1"<?php if($zid==1) echo ' selected';?>>主页幻灯</option>
				<option value="0"<?php if($zid==0) echo ' selected';?>>不上幻灯</option>
				</select>
				</span>
				<span class="select-box" style="width:80px;">
				<select class="select" name="yid" size="1">
				<option value="0"<?php if($yid==0) echo ' selected';?>>显示</option>
				<option value="1"<?php if($yid==1) echo ' selected';?>>隐藏</option>
				</select>
				</span>
				<input class="box" name="addtime" type="checkbox" value="ok" checked="checked">&nbsp;更新时间
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-2"><span class="c-red">*</span>名称：</label>
			<div class="formControls col-8">
				<input placeholder="视频名称" type="text" class="input-text" value="<?=$name?>" name="name" datatype="*" nullmsg="名称不能为空">
			</div>
			<div class="col-2"> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-2">缩略图：</label>
			<div class="formControls col-8">
				<input placeholder="视频图片" type="text" id="pic1" name="pic" class="input-text" value="<?=$pic?>" style="width:470px;">
				<a href="javascript:;" class="file" onClick="upload(1);">上传图片
				<input type="button" name="userfile">
				</a>
			</div>
			<div class="col-2"> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-2">幻灯图：</label>
			<div class="formControls col-8">
				<input placeholder="主页幻灯图片" type="text" id="pic2" name="pic2" class="input-text" value="<?=$pic2?>" style="width:470px;">
				<a href="javascript:;" class="file" onClick="upload(2);">上传图片
				<input type="button" name="userfile">
				</a>
			</div>
			<div class="col-2"> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-2">清晰度：</label>
			<div class="formControls col-8">
				<input style="width:300px;" type="text" placeholder="视频清晰度" class="input-text" value="<?=$info?>" name="info">
				状态：<input style="width:300px;" placeholder="视频更新状态" type="text" class="input-text" value="<?=$state?>" name="state">
			</div>
			<div class="col-2"> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-2">导演：</label>
			<div class="formControls col-8">
				<input style="width:300px;" type="text" placeholder="视频导演" class="input-text" value="<?=$daoyan?>" name="daoyan">
				主演：<input style="width:300px;" placeholder="视频主演" type="text" class="input-text" value="<?=$zhuyan?>" name="zhuyan">
			</div>
			<div class="col-2"> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-2">地区：</label>
			<div class="formControls col-8">
				<input style="width:300px;" placeholder="视频地区" type="text" class="input-text" value="<?=$diqu?>" name="diqu">
				类型：<input style="width:300px;" placeholder="视频类型" type="text" class="input-text" value="<?=$type?>" name="type">
			</div>
			<div class="col-2"> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-2">语言：</label>
			<div class="formControls col-8">
			        <input style="width:300px;" placeholder="视频语言" type="text" class="input-text" value="<?=$yuyan?>" name="yuyan">
				年份：<input style="width:300px;" placeholder="视频年份" type="text" class="input-text" value="<?=$year?>" name="year">
			</div>
			<div class="col-2"> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-2">模板：</label>
			<div class="formControls col-8">
				<input style="width:300px;" placeholder="播放模板" type="text" class="input-text" value="<?=$skin?>" name="skin">
				人气：<input style="width:300px;" placeholder="视频人气" type="text" class="input-text" value="<?=$hits?>" name="hits">
			</div>
			<div class="col-2"> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-2">
			播放地址：<br><br>
			<input style="width:70px;" type="button" class="input-text addzu" value="+增加组">
			</label>
			<div class="formControls col-8" id="player">
<?php
$play='';
foreach ($player as $rowp) {
    $play.='<option value="'.$rowp->bs.'">'.$rowp->name.'</option>';
}
$arr = explode('#ctcms#',$url);
for($i=0;$i<count($arr);$i++){
    $parr = explode('###',$arr[$i]);
    $bs = $parr[0];
    $url = !empty($parr[1]) ? $parr[1] : '';
    if(!empty($bs)){
        $pname='<option value="'.$bs.'">'.getzd('player','name',$bs,'bs').'</option>';
    }else{
        $pname='';
    }
                           echo '
				<div id="player_'.($i+1).'">
				    <div style="width:100%;margin-bottom:10px;">
				        <span class="select-box" style="width:200px;">
				        <select class="select" name="play[]" size="1">
				            '.$pname.str_replace($pname,'',$play).'
				        </select>
				        </span>
					<input zid="'.($i+1).'" style="width:70px;" type="button" class="input-text xiao" value="校正格式">
				        <input zid="'.($i+1).'" style="width:50px;" type="button" class="delzu input-text" value="-删除">
				    </div>
				    <textarea name="url[]" class="textarea" style="width:100%;height:100px;" placeholder="视频地址">'.$url.'</textarea>
				</div>';
}
?>
			</div>
			<div class="col-2"> </div>
		</div>

		<div class="row cl">
			<label class="form-label col-2">介绍：</label>
			<div class="formControls col-8">
				<textarea name="text" class="textarea" style="width:100%;height:280px;" placeholder="视频介绍"><?=$text?></textarea>
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
    var zid=<?=$i?>;
    $("#form-admin-add").Validform({tiptype:2});
    //增加组
    $('.addzu').click(function(){
         zid++;
	 var html = '<div id="player_'+zid+'"><div style="width:100%;margin-bottom:10px;"><span class="select-box" style="width:200px;"><select class="select" name="play[]" size="1"><?=$play?></select></span> <input zid="'+zid+'" style="width:70px;" type="button" class="input-text xiao" value="校正格式"> <input zid="'+zid+'" style="width:50px;" type="button" class="delzu input-text" value="-删除"></div><textarea name="url[]" class="textarea" style="width:100%;height:100px;" placeholder="视频地址"></textarea></div>';
         $("#player").append(html); 
    });
    //删除组
    $(document).on('click', '.delzu', function(e){
          var sid = $(this).attr('zid');
          $("#player_"+sid).remove();
    });
    //格式校正
    $(document).on('click', '.xiao', function(e){
          var sid = $(this).attr('zid');
          repairUrl(sid);
    });
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
function repairUrl(i){
    var urlStr=$("#player_"+i+" textarea").val();
    if (urlStr.length==0){alert('请填写地址');return false;}
    var urlArray=urlStr.split("\n");
    var newStr="";
    for(j=0;j<urlArray.length;j++){
	if(urlArray[j].length>0){
		t=urlArray[j].split('$'),flagCount=t.length-1
		switch(flagCount){
			case 0:
				urlArray[j]='第'+(j<9 ? '0' : '')+(j+1)+'集$'+urlArray[j];
				break;
			case 1:
				if(t[0]==''){
				      urlArray[j]=t[0]+'$'+urlArray[j];
				}else{
			              urlArray[j]=t[0]+'$'+t[1];
                                }
				break;
		}
		newStr+=urlArray[j]+"\n";
	}
    }
    $("#player_"+i+" textarea").val(trimOuterStr(newStr,"\n"));
}
function trimOuterStr(str,outerstr){
	var len1
	len1=outerstr.length;
	if(str.substr(0,len1)==outerstr){str=str.substr(len1)}
	if(str.substr(str.length-len1)==outerstr){str=str.substr(0,str.length-len1)}
	return str
}
/*上传图片*/
function upload(n){
    layer_show('上传图片','<?=links('upload','',0,'ac=vod&sid=')?>'+n,400,200);
}
</script>
</body>
</html>