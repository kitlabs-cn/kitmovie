<link href="<?=Base_Path?>admin/css/style.css" rel="stylesheet" type="text/css" />
<title>网站后台管理</title>
</head>
<body>
<header class="Hui-header cl">
    <a class="Hui-logo l" title="<?=Web_Name?>" href="<?=Web_Path?>" target="_blank">Ctcms</a> 
    <a class="Hui-logo-m l" href="<?=Web_Path?>" title="<?=Web_Name?>" target="_blank">Ctcms</a> 
    <span class="Hui-subtitle l">后台管理</span>
    <ul class="Hui-userbar">
		<li></li>
		<li><a href="javascript:void(0)" onClick="cache();">更新缓存</a></li>
		<li class="dropDown dropDown_hover"><a href="#" class="dropDown_A"><?=$_SESSION['admin_nichen']?> <i class="Hui-iconfont">&#xe6d5;</i></a>
			<ul class="dropDown-menu radius box-shadow">
				<li><a href="<?=links('logout')?>">退出</a></li>
			</ul>
		</li>
		<li id="Hui-skin" class="dropDown right dropDown_hover"><a href="javascript:;" title="换肤"><i class="Hui-iconfont" style="font-size:18px">&#xe62a;</i></a>
			<ul class="dropDown-menu radius box-shadow">
				<li><a href="javascript:;" data-val="default" title="默认（黑色）">默认（黑色）</a></li>
				<li><a href="javascript:;" data-val="blue" title="蓝色">蓝色</a></li>
				<li><a href="javascript:;" data-val="green" title="绿色">绿色</a></li>
				<li><a href="javascript:;" data-val="red" title="红色">红色</a></li>
				<li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
				<li><a href="javascript:;" data-val="orange" title="绿色">橙色</a></li>
			</ul>
		</li>
    </ul>
    <a href="javascript:;" class="Hui-nav-toggle Hui-iconfont" aria-hidden="false">&#xe667;</a>
</header>
<aside class="Hui-aside">
  <input runat="server" id="divScrollValue" type="hidden" value="" />
  <div class="menu_dropdown bk_2">
    <dl id="menu-product">
      <dt><i class="Hui-iconfont">&#xe6c2;</i> 视频库管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd style="display:block;">
        <ul>
          <li><a _href="<?=links('vod')?>" href="javascript:void(0)">视频管理</a></li>
          <li><a _href="<?=links('vod','lists')?>" href="javascript:void(0)">分类管理</a></li>
          <li><a _href="<?=links('caiji')?>" href="javascript:void(0)">视频采集</a></li>
          <li><a _href="<?=links('player')?>" href="javascript:void(0)">播放器管理</a></li>
        </ul>
      </dd>
    </dl>
    <dl id="menu-product">
      <dt><i class="Hui-iconfont">&#xe654;</i> 营运管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          <li><a _href="<?=links('ads')?>" href="javascript:void(0)">广告管理</a></li>
          <li><a _href="<?=links('pages')?>" href="javascript:void(0)">页面管理</a></li>
          <li><a _href="<?=links('gbook')?>" href="javascript:void(0)">留言管理</a></li>
          <li><a _href="<?=links('links')?>" href="javascript:void(0)">友情链接</a></li>
        </ul>
      </dd>
    </dl>
    <dl id="menu-system">
      <dt><i class="Hui-iconfont">&#xe62e;</i> 系统配置<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          <li><a _href="<?=links('setting')?>" href="javascript:void(0)">系统配置</a></li>
        </ul>
      </dd>
    </dl>
    <dl id="menu-admin">
      <dt><i class="Hui-iconfont">&#xe62d;</i> 管理员管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          <li><a _href="<?=links('sys')?>" href="javascript:void(0)">管理员列表</a></li>
          <li><a _href="<?=links('sys','log')?>" href="javascript:void(0)">登陆日志</a></li>
          <li><a _href="<?=links('basedb')?>" href="javascript:void(0)">备份还原</a></li>
        </ul>
      </dd>
    </dl>
  </div>
</aside>
<div class="dislpayArrow"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
<section class="Hui-article-box">
  <div id="Hui-tabNav" class="Hui-tabNav">
    <div class="Hui-tabNav-wp">
      <ul id="min_title_list" class="acrossTab cl">
        <li class="active"><span title="后台首页" data-href="<?=links('main');?>">后台首页</span><em></em></li>
      </ul>
    </div>
    <div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a></div>
  </div>
  <div id="iframe_box" class="Hui-article">
    <div class="show_iframe">
      <div style="display:none" class="loading"></div>
      <iframe scrolling="yes" frameborder="0" src="<?=links('main');?>"></iframe>
    </div>
  </div>
</section>
<script type="text/javascript" src="<?=Base_Path?>jquery/jquery.min.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>layer/layer.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.admin.js"></script> 
<script type="text/javascript">
/*添加*/
function cmd_add(title,url){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}
if($(window).height() < $('.menu').height()) {
   var height =  $(window).height();
} else {
   var height = $('aside').height();
}
$(".menu_dropdown").slimScroll({
   height: height,
   wheelStep: 10,
   size: "1px",
   color: '#999'
});
//更新缓存
function cache(){
    $.post('<?=links('cache')?>',function(data) {
           var msg=data;
	   if(msg == "ok"){//成功
		get_msg('缓存更新成功!',2000,1);
	   }else{
	        get_msg(msg);
	   }
    });
}
</script> 
</body>
</html>