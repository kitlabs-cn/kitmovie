<title>基本设置</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 系统管理 <span class="c-gray en">&gt;</span> 系统配置 <a class="btn btn-success radius r mr-20" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="pd-20">
	<form action="<?=links('setting','save')?>" method="post" class="form form-horizontal" id="form-article-add">
		<div id="tab-system" class="HuiTab">
			<div class="tabBar cl">
			    <span class="current">基本配置</span>
			    <span>安全配置</span>
			    <span>留言配置</span>
			    <span>其他配置</span>
			    <span>URL路由配置</span>
			    <span>手机配置</span>
			</div>
			<div class="tabCon" style="display:block;">
				<div class="row cl">
					<label class="form-label col-2"><span class="c-red">*</span>网站名称：</label>
					<div class="formControls col-10">
						<input type="text" name="Web_Name" value="<?=Web_Name?>" style="width:350px" class="input-text">网站名称
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2"><span class="c-red">*</span>网站域名：</label>
					<div class="formControls col-10">
						<input type="text" name="Web_Url" value="<?=Web_Url?>" style="width:350px" class="input-text">网站域名，不要带http://
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2"><span class="c-red">*</span>网站目录：</label>
					<div class="formControls col-10">
						<input type="text" name="Web_Path" value="<?=Web_Path?>" style="width:350px" class="input-text">网站目录
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">网站运行模式：</label>
					<div class="formControls col-10">
                       <select name="Web_Mode" class="select" style="width:190px;padding:6px 12px;">
                         <option value="1"<?php if(Web_Mode==1) echo ' selected="selected"';?>>PATHINFO模式</option>
                         <option value="2"<?php if(Web_Mode==2) echo ' selected="selected"';?>>QUERY_STRING模式</option>
                       </select> Nginx 环境下建议不要使用PATHINFO模式
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">页面缓存开关：</label>
					<div class="formControls col-10">
                        <select name="Cache_Is" class="select" style="width:100px;padding:6px 12px;">
                          <option value="0"<?php if(Cache_Is==0) echo ' selected="selected"';?>>关闭</option>
                          <option value="1"<?php if(Cache_Is==1) echo ' selected="selected"';?>>开启</option>
                        </select> 此功能可以达到生成静态网页功能，需要更多储存空间
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">缓存有效期：</label>
					<div class="formControls col-10">
						<input type="text" name="Cache_Time" value="<?=Cache_Time?>" style="width:100px" class="input-text"> 更新缓存间隔时间，单位-秒
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">视频地区：</label>
					<div class="formControls col-10">
						<input type="text" name="Web_Diqu" value="<?=Web_Diqu?>" style="width:450px" class="input-text"> 多个用|来隔开
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">视频语言：</label>
					<div class="formControls col-10">
						<input type="text" name="Web_Yuyan" value="<?=Web_Yuyan?>" style="width:450px" class="input-text"> 多个用|来隔开
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">视频年份：</label>
					<div class="formControls col-10">
						<input type="text" name="Web_Year" value="<?=Web_Year?>" style="width:450px" class="input-text"> 多个用|来隔开
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">视频类型：</label>
					<div class="formControls col-10">
					        <textarea name="Web_Type" class="textarea" style="width:450px;height:150px;"><?=Web_Type?></textarea> 规则：分类ID#类型，每行1个分类，多个类型用|来隔开
					</div>
				</div>

			</div>
			<div class="tabCon">
				<div class="row cl">
					<label class="form-label col-2">网站开关：</label>
					<div class="formControls col-10">
                       <select name="Web_Off" class="select" style="width:100px;padding:6px 12px;">
                         <option value="0"<?php if(Web_Off==0) echo ' selected="selected"';?>>开启</option>
                         <option value="1"<?php if(Web_Off==1) echo ' selected="selected"';?>>关闭</option>
                       </select> 站点关闭后不能访问
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">网站关闭提示：</label>
					<div class="formControls col-10">
						<textarea name="Web_Onneir" class="textarea" style="width:450px;height:50px;"><?=Web_Onneir?></textarea>5个左右,8汉字以内,用英文,隔开
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2"><span class="c-red">*</span>后台认证码：</label>
					<div class="formControls col-10">
						<input type="text" name="Admin_Code" value="<?=Admin_Code?>" style="width:150px" class="input-text">后台登陆认证码
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2"><span class="c-red">*</span>日志保存天数：</label>
					<div class="formControls col-10">
						<input type="text" name="Admin_Log_Day" value="<?=Admin_Log_Day?>" style="width:150px" class="input-text">后台登陆日志保存天数
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">允许访问后台的IP列表：</label>
					<div class="formControls col-10">
						<textarea name="Admin_Log_Ip" class="textarea" style="width:450px;height:80px;"><?=Admin_Log_Ip?></textarea>多个用|来分割
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">备案号：</label>
					<div class="formControls col-10">
						<input type="text" name="Web_Icp" value="<?=Web_Icp?>" style="width:350px" class="input-text">网站底部显示的备案号
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">客服QQ：</label>
					<div class="formControls col-10">
						<input type="text" name="Admin_QQ" value="<?=Admin_QQ?>" style="width:150px" class="input-text">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">客服邮箱：</label>
					<div class="formControls col-10">
						<input type="text" name="Admin_Mail" value="<?=Admin_Mail?>" style="width:250px" class="input-text">
					</div>
				</div>
			</div>
			<div class="tabCon">
				<div class="row cl">
					<label class="form-label col-2">留言开关：</label>
					<div class="formControls col-10">
                       <select name="Gbook_Is" class="select" style="width:100px;padding:6px 12px;">
                         <option value="1"<?php if(Gbook_Is==1) echo ' selected="selected"';?>>开启</option>
                         <option value="0"<?php if(Gbook_Is==0) echo ' selected="selected"';?>>关闭</option>
                       </select> 关闭后不能打开留言页
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">留言审核：</label>
					<div class="formControls col-10">
                       <select name="Gbook_Sh" class="select" style="width:100px;padding:6px 12px;">
                         <option value="1"<?php if(Gbook_Sh==1) echo ' selected="selected"';?>>需要</option>
                         <option value="0"<?php if(Gbook_Sh==0) echo ' selected="selected"';?>>不需要</option>
                       </select> 关闭后不能打开留言页
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">留言过滤字：</label>
					<div class="formControls col-10">
						<textarea name="Gbook_Str" class="textarea" style="width:450px;height:80px;"><?=Gbook_Str?></textarea>多个用 | 来隔开
					</div>
				</div>
			</div>
			<div class="tabCon">
				<div class="row cl">
					<label class="form-label col-2">默认模板目录：</label>
					<div class="formControls col-10">
                        <select name="Web_Skin" class="select" style="width:120px;padding:6px 12px;">
<?php
foreach ($skin as $dir) {
      $sel = (Web_Skin==$dir) ? ' selected="selected"' : '';
      echo '<option value="'.$dir.'"'.$sel.'>'.$dir.'</option>';
}
?>
                        </select> 前台默认模板，模板位于 template 目录下
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2"><span class="c-red">*</span>插件路径：</label>
					<div class="formControls col-10">
						<input type="text" name="Base_Path" value="<?=Base_Path?>" style="width:350px" class="input-text">默认为/packs/，如：http://cdn.abc.com/
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">网站标题：</label>
					<div class="formControls col-10">
						<input type="text" name="Web_Title" value="<?=Web_Title?>" style="width:350px" class="input-text">网站标题前台显示标题
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">网站关键词：</label>
					<div class="formControls col-10">
						<textarea name="Web_Keywords" class="textarea" style="width:450px;height:50px;"><?=Web_Keywords?></textarea>5个左右,8汉字以内,用英文,隔开
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">网站描述：</label>
					<div class="formControls col-10">
						<textarea name="Web_Description" class="textarea" style="width:450px;height:50px;"><?=Web_Description?></textarea>空制在80个汉字，160个字符以内
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">统计代码：</label>
					<div class="formControls col-10">
						<textarea name="Web_Count" class="textarea" style="width:450px;height:80px;"><?=Web_Count?></textarea>第三方统计代码
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">评论代码：</label>
					<div class="formControls col-10">
						<textarea name="Web_Pl" class="textarea" style="width:450px;height:80px;"><?=Web_Pl?></textarea>第三方评论代码，{id}代表视频ID
					</div>
				</div>
			</div>
			<div class="tabCon">
				<div class="row cl">
					<label class="form-label col-2">URL路由开关：</label>
					<div class="formControls col-10">
                        <select id="uris" name="Uri_Mode" class="select" style="width:100px;padding:6px 12px;" onchange="get_uri();">
                          <option value="0"<?php if(Uri_Mode==0) echo ' selected="selected"';?>>关闭</option>
                          <option value="1"<?php if(Uri_Mode==1) echo ' selected="selected"';?>>开启</option>
                        </select> URL路由，开启后可以美化URL地址，需要配合伪静态规则
					</div>
				</div>
				<div id="uri"<?php if(Uri_Mode==0) echo ' style="display:none;"';?>>
				<div class="row cl">
					<label class="form-label col-2">视频分类路由规则：</label>
					<div class="formControls col-10">
						<input type="text" name="Uri_List" value="<?=Uri_List?>" style="width:350px;" class="input-text"> 可以用标签，[cid]分类ID，[page]分页ID
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">视频内容路由规则：</label>
					<div class="formControls col-10">
						<input type="text" name="Uri_Show" value="<?=Uri_Show?>" style="width:350px;" class="input-text"> 可以用标签，[id]视频ID
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">视频播放路由规则：</label>
					<div class="formControls col-10">
						<input type="text" name="Uri_Play" value="<?=Uri_Play?>" style="width:350px;" class="input-text"> 可以用标签，[id]视频ID，[zu]组ID，[ji]集数ID
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">伪静态规则：</label>
					<div class="formControls col-10">
					<b>htaccess伪静态列子（其他自行编写）</b><br>
					<br>PATHINFO模式规则：<br>
                                        <pre>RewriteEngine On
RewriteBase /
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [QSA,PT,L]</pre>
					<br>QUERY_STRING模式规则（如果你修改了上面的URL路由那么下面的规则也需要修改）：
                                        <pre>RewriteEngine On
RewriteBase /
RewriteRule ^whole/(.+).html$ index.php?c=whole&key=$1
RewriteRule ^show/(\d+).html$ index.php?c=show&id=$1
RewriteRule ^play/(\d+)~(\d+)~(\d+).html$ index.php?c=play&id=$1&zu=$2&ji=$3
RewriteRule ^play/(\d+).html$ index.php?c=play&id=$1
RewriteRule ^list/(\d+)~(\d+).html$ index.php?c=lists&id=$1&page=$2 </pre>
					</div>
				</div>
				</div>
			</div>
			<div class="tabCon">
				<div class="row cl">
					<label class="form-label col-2">手机版开关：</label>
					<div class="formControls col-10">
                        <select name="Wap_Is" class="select" style="width:100px;padding:6px 12px;">
                          <option value="0"<?php if(Wap_Is==0) echo ' selected="selected"';?>>关闭</option>
                          <option value="1"<?php if(Wap_Is==1) echo ' selected="selected"';?>>开启</option>
                        </select> 手机版关闭后，手机访问则是电脑版
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">手机模板目录：</label>
					<div class="formControls col-10">
                        <select name="Wap_Skin" class="select" style="width:120px;padding:6px 12px;">
<?php
foreach ($wapskin as $dir) {
      $sel = (Wap_Skin==$dir) ? ' selected="selected"' : '';
      echo '<option value="'.$dir.'"'.$sel.'>'.$dir.'</option>';
}
?>
                        </select> 手机默认模板，模板位于 template/mobile/ 目录下
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">手机版域名：</label>
					<div class="formControls col-10">
						<input type="text" name="Wap_Url" value="<?=Wap_Url?>" style="width:350px" class="input-text">留空则不区分，自适应
					</div>
				</div>
			</div>
		</div>
		<div class="row cl">
			<div class="col-10 col-offset-2">
				<button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存</button>
			</div>
		</div>
	</form>
</div>
<footer class="footer"><p>页面执行时间{elapsed_time}秒，消耗内存{memory_usage}</p></footer>
<script type="text/javascript" src="<?=Base_Path?>jquery/jquery.min.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>layer/layer.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.admin.js"></script> 
<script type="text/javascript">
$(function(){
    $.Huitab("#tab-system .tabBar span","#tab-system .tabCon","current","click","0");
});
function get_up(){
    var up = $('#ups').val();
    if(up==1){
	$('#ftp').show();
	$('#ttk').hide();
    } else if(up==2){
	$('#ftp').hide();
	$('#ttk').show();
    } else { 
	$('#ftp').hide();
	$('#ttk').hide();
    }
}
function get_uri(){
    var uri = $('#uris').val();
    if(uri==1){
	$('#uri').show();
    } else { 
	$('#uri').hide();
    }
}
</script>
</body>
</html>