<title>采集</title>
</head>
<body>
<script type="text/javascript" src="<?=Base_Path?>jquery/jquery.min.js"></script> 
<script type="text/javascript" src="<?=Base_Path?>admin/js/H-ui.js"></script>
<script language="JavaScript">
$(document).ready(function(){
    $('#api_tip').hide();
    $('#api_list').show();
});
var jumpurl = '<?=$jumpurl?>';
var adminurl = '<?=links('caiji','index')?><?=(Web_Mode==2)?'&':'?';?>';
</script>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 视频管理 <span class="c-gray en">&gt;</span> 视频采集 <a class="btn btn-success radius r mr-20" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="pd-20">
    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
        <div id="api_tip"><br>资源列表载入中……</div>
        <div id="api_list" style="display:none"><script language="JavaScript" type="text/javascript" src="<?=$api?>"></script></div>
    </div>
</div>
<footer class="footer"><p>页面执行时间{elapsed_time}秒，消耗内存{memory_usage}</p></footer>
</body>
</html>