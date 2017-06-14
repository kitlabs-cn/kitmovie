<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Ctcms 友情提示</title>
<style type="text/css">
body,code,dd,div,dl,dt,fieldset,form,h1,h2,h3,h4,h5,h6,input,legend,li,ol,p,pre,td,textarea,th,ul{margin:0;padding:0}
body{font:14px/1.5 'Microsoft YaHei','微软雅黑',Helvetica,Sans-serif;min-width:1200px;background:#f0f1f3;}
:focus{outline:0}
ul,ol,dl{list-style-type:none}
h1,h2,h3,h4,h5,h6,strong{font-weight:700}
a{color:#428bca;text-decoration:none}
a:hover{text-decoration:underline}
.error-page{background:#f0f1f3;padding:80px 0 180px}
.error-page-container{position:relative;z-index:1}
.error-page-main{position:relative;background:#f9f9f9;margin:0 auto;width:617px;-ms-box-sizing:border-box;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;padding:50px 50px 70px;}
.error-page-main:before{content:'';display:block;background:url(http://ww1.sinaimg.cn/mw690/005DiYL9gw1f3zky2zq07j30h50070fn.jpg);height:7px;position:absolute;top:-7px;width:100%;left:0}
.error-page-main h3{font-size:24px;font-weight:400;border-bottom:1px solid #d0d0d0}
.error-page-main h3 strong{font-size:54px;font-weight:400;margin-right:20px}
.error-page-main h4{font-size:20px;font-weight:400;color:#333}
.error-page-actions{font-size:0;z-index:100}
.error-page-actions div{font-size:14px;display:inline-block;padding:30px 0 0 10px;width:50%;-ms-box-sizing:border-box;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;color:#838383}
.error-page-actions ol{list-style:decimal;padding-left:20px}
.error-page-actions li{line-height:2.5em}
.error-page-actions:before{content:'';display:block;position:absolute;z-index:-1;bottom:17px;left:50px;width:200px;height:10px;-moz-box-shadow:4px 5px 31px 11px #999;-webkit-box-shadow:4px 5px 31px 11px #999;box-shadow:4px 5px 31px 11px #999;-moz-transform:rotate(-4deg);-webkit-transform:rotate(-4deg);-ms-transform:rotate(-4deg);-o-transform:rotate(-4deg);transform:rotate(-4deg)}
.error-page-actions:after{content:'';display:block;position:absolute;z-index:-1;bottom:17px;right:50px;width:200px;height:10px;-moz-box-shadow:4px 5px 31px 11px #999;-webkit-box-shadow:4px 5px 31px 11px #999;box-shadow:4px 5px 31px 11px #999;-moz-transform:rotate(4deg);-webkit-transform:rotate(4deg);-ms-transform:rotate(4deg);-o-transform:rotate(4deg);transform:rotate(4deg)}
</style>
</head>
<body>
<div class="error-page">
    <div class="error-page-container">
        <div class="error-page-main">
            <h3>Ctcms 友情提示</h3>
            <div class="error-page-actions">
                <div>
                    <h4>{msg}：</h4>
                    <ol>
                        <li style="color:{color};">{title}</li>
                    </ol>
                </div>
                <div>
                    <ul>
					    <li id="div_time">请稍等，页面将在 <span id="time" style="font-weight:bold;color:red;">{time}</span> 秒后跳转...</li>
                        <li><a href="{url}">立即转到</a><a style="margin-left:60px;" href="{path}">返回首页</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
		   function run(){
			   var s = document.getElementById("time");
			   if(s.innerHTML == 1){
				   document.getElementById("div_time").style.visibility="hidden";
				   return false;
			   }
			   s.innerHTML = s.innerHTML * 1 - 1;
		   }
		   window.setInterval("run();", 1000);
		   window.setTimeout(function (){location.href="{url}";},{time}000);
</script>
</body>
</html>