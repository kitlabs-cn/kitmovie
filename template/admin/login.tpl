<link href="<?=Base_Path?>admin/css/H-ui.login.css" rel="stylesheet" type="text/css" />
<title>后台登录</title>
</head>
<body>
<input type="hidden" id="TenantId" name="TenantId" value="" />
<div class="header"></div>
<div class="loginWraper">
  <div id="loginform" class="loginBox">
    <div class="form form-horizontal">
      <div class="row cl">
        <label class="form-label col-3"><i class="Hui-iconfont">&#xe60d;</i></label>
        <div class="formControls col-8">
          <input name="name" id="name" type="text" placeholder="账户" class="input-text size-L">
        </div>
      </div>
      <div class="row cl">
        <label class="form-label col-3"><i class="Hui-iconfont">&#xe60e;</i></label>
        <div class="formControls col-8">
          <input name="pass" id="pass" type="password" placeholder="密码" class="input-text size-L">
        </div>
      </div>
      <div class="row cl">
        <label class="form-label col-3"><i class="Hui-iconfont">&#xe63f;</i></label>
        <div class="formControls col-8">
          <input name="code" id="code" class="input-text size-L" type="password" placeholder="认证码" value="" style="width:150px;">
        </div>
      </div>
      <div class="row">
        <div class="formControls col-8 col-offset-3"></div>
      </div>
      <div class="row">
        <div class="formControls col-8 col-offset-3">
          <input name="login" type="button" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
          <input name="nologin" type="reset" class="btn btn-default radius size-L" value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
        </div>
      </div>
    </div>
  </div>
</div>
<div class="footer">Copyright <?=Web_Name?> </div>
<script type="text/javascript" src="<?=Base_Path?>jquery/jquery.min.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>layer/layer.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.admin.js"></script> 
<script type="text/javascript">
var postlink='<?=links('login','save')?>';
$('.btn-success').click(function(){
    var name=$('#name').val();
    var pass=$('#pass').val();
    var code=$('#code').val();
    if(name==''){
	get_tips('#name','账号不能为空');
	$('#name').focus();
    } else if(pass==''){
        get_tips('#pass','密码不能为空');
	$('#pass').focus();
    } else if(code==''){
        get_tips('#code','认证码不能为空');
	$('#code').focus();
    } else {
        layer.load();
        $.post(postlink,{name: name,pass: pass,code: code},function(data) {
	   layer.closeAll('loading');
           var msg=data['error'];
	   if(msg == "ok"){//登陆成功
	       get_msg('恭喜您，登陆成功，页面跳转中...',1000,1);
               window.location.href="<?=links('index')?>"; 
	   }else{
	       get_msg(msg);
	   }
        },"json");
    }
});
</script>
</body>
</html>