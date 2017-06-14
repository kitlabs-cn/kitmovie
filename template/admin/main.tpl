<title>管理首页</title>
</head>
<body>
<div class="pd-20" style="padding-top:20px;">
<style>
.tbtitle td{border: 1px solid #dadada;}
</style>
<table align="center" width="98%" class="table">
  <tr>
    <td width="50%" style="padding-right:13px" valign="top"><table width="100%" border="0"  cellpadding="1" cellspacing="1" class="tbtitle" style="margin-left:1%;">
        <tr>
          <td bgcolor="#F2F4F6"><strong>登陆信息</strong></td>
        </tr>
	<tr>
          <td bgcolor="#FFFFFF" >&nbsp;&nbsp;<?=$admin->nichen?> ,上次登录时间:<?=$_SESSION['admin_logtime']?> 上次登录IP:<?=$_SESSION['admin_logip']?></td>
        </tr>
        <tr>
          <td bgcolor="#F2F4F6" style="padding:6px 6px 8px 8px;"><strong>视频统计</strong></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF" >今日数量:<?=$count[0];?>个&nbsp;&nbsp;昨日数量:<?=$count[1];?>个&nbsp;&nbsp;本月数量:<?=$count[2];?>个&nbsp;&nbsp;上月数量:<?=$count[3];?>个&nbsp;&nbsp;总数量:<?=$count[4];?>个&nbsp;&nbsp;</td>
        </tr>
	</table>
        <table width="100%" border="0"  cellpadding="1" cellspacing="1" class="tbtitle" style="margin-left:1%;">
        <tr>
          <td bgcolor="#F2F4F6"><strong>系统信息</strong>&nbsp;&nbsp;&nbsp; </td>
        </tr>		
        <br>
	<tr>
          <td bgcolor="#FFFFFF" >系统名称：Ctcms video system (简称ctcms) &nbsp;&nbsp;官网：<a href="http://www.ctcms.cn/" target="_blank">www.ctcms.cn</a></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF" >当前版本: Ctcms <span id="yver">v<?=Ct_Version?></span><span id="xver"></span></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF" >操作系统：<?php $os = explode(" ", php_uname()); echo $os[0];?></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF" >主 机 名：<?=$_SERVER["HTTP_HOST"]?><span id="stcms_sq"></span></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF" >内核版本：<?php if('/'==DIRECTORY_SEPARATOR){echo $os[2];}else{echo $os[1];} ?> /   <?php echo $_SERVER['SERVER_SOFTWARE'];?></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF" >系统时间：<?=date('Y-m-d H:i:s')?></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF" >服务器IP：<?=GetHostByName($_SERVER['SERVER_NAME'])?></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF" >PHP版本：<?=PHP_VERSION?></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF" >Mysql版本：<?=$this->db->version()?></td>
        </tr>
      </table>
      </td>
      <td width="50%" height="100%" valign="top">
      <table width="100%" border="0"  cellpadding="1" cellspacing="1" class="tbtitle" style="margin-left:1%;">
        <tr>
          <td bgcolor="#F2F4F6"><strong>系统简介</strong></td>
        </tr>
        <tr>
          <td height="64" bgcolor="#FFFFFF" style="line-height:195%;" id="gg">Ctcms(Ctcms video system) 是一套PHP+Mysql开发的视频管理系统,采用CI框架核心开发，体积小、运行快，强大缓存处理，自主研发的模板引擎标签简单易用，后台支持一键增加视频，附带官方资源库，支持会员点播、包月观看，点卡、广告、在线支付、留言求片、友情链接，只要略懂HTML的就可搭建一个强大的视频网站，  了解更多可到 <A href="http://bbs.ctcms.cn/" target="_blank"><font color=blue>论坛与大家交流</font></A></td>
        </tr>
      </table>
      <br>
      <table width="100%" border="0"  cellpadding="1" cellspacing="1" class="tbtitle" style="margin-left:1%;">
        <tr>
          <td bgcolor="#F2F4F6"><strong>最新资讯</strong></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF" id="news">
	      <table width="100%" border="0" cellpadding="1" cellspacing="1">
	          <tr>
			<td width="47%" height="33" bgcolor="#FFFFFF">&nbsp;<a href="http://www.ctcms.cn/" target="_blank"><font color="#FF0000"><b><u>Ctcms v1.0.0正式开源发布了</u></b></font></a></td>
			<td width="53%" bgcolor="#FFFFFF"><a href="http://120.27.155.106/user" target="_blank"><font color="#0000ff"><u>官方推荐视频云解析</u></font></a></td>
		  </tr>
              </table>
	  </td>
        </tr>
      </table>
      </td>
  </tr>
</table>
</div>
<footer class="footer">
  <p>Copyright &copy;2016 Ctcms All Rights Reserved.<br></p>
</footer>
<script>
var VER = '<?=Ct_Version?>';
var WEB_MODE = <?=Web_Mode?>;
var SELF_PATH='<?=Web_Path.SELF?>';
</script>
<script type="text/javascript" src="<?=Base_Path?>jquery/jquery.min.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.js"></script>
<script type="text/javascript" src="<?=Ct_Upurl?>"></script>
</body>
</html>