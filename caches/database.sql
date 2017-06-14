
DROP TABLE IF EXISTS `{Prefix}admin`;#ctcms#

CREATE TABLE `{Prefix}admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT '',
  `nichen` varchar(64) DEFAULT '',
  `pass` varchar(64) NOT NULL DEFAULT '',
  `logip` varchar(20) DEFAULT '',
  `lognum` int(10) DEFAULT '0',
  `logtime` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#ctcms#


DROP TABLE IF EXISTS `{Prefix}admin_log`;#ctcms#

CREATE TABLE `{Prefix}admin_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned DEFAULT '0',
  `ip` varchar(20) DEFAULT '',
  `ua` varchar(255) DEFAULT '',
  `logtime` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#ctcms#

DROP TABLE IF EXISTS `{Prefix}ads`;#ctcms#

CREATE TABLE `{Prefix}ads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT '',
  `yid` tinyint(1) DEFAULT '0',
  `bs` varchar(64) DEFAULT '',
  `neir` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#ctcms#

DROP TABLE IF EXISTS `{Prefix}class`;#ctcms#

CREATE TABLE `{Prefix}class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT '',
  `xid` int(10) unsigned DEFAULT '0',
  `fid` int(10) unsigned DEFAULT '0',
  `skin` varchar(64) DEFAULT 'list.html',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#ctcms#

DROP TABLE IF EXISTS `{Prefix}gbook`;#ctcms#

CREATE TABLE `{Prefix}gbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `yid` tinyint(1) DEFAULT '0',
  `name` varchar(64) DEFAULT '',
  `content` text,
  `hfcontent` text,
  `addtime` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#ctcms#


DROP TABLE IF EXISTS `{Prefix}link`;#ctcms#

CREATE TABLE `{Prefix}link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(10) unsigned DEFAULT '0',
  `name` varchar(64) DEFAULT '',
  `link` varchar(255) DEFAULT '',
  `pic` varchar(64) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#ctcms#

DROP TABLE IF EXISTS `{Prefix}pages`;#ctcms#

CREATE TABLE `{Prefix}pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bs` varchar(30) DEFAULT '',
  `name` varchar(64) DEFAULT '',
  `yid` tinyint(1) DEFAULT '0',
  `text` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#ctcms#

DROP TABLE IF EXISTS `{Prefix}player`;#ctcms#

CREATE TABLE `{Prefix}player` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT '',
  `text` varchar(255) DEFAULT '',
  `bs` varchar(64) DEFAULT '',
  `js` text,
  `xid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `bs` (`bs`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#ctcms#

DROP TABLE IF EXISTS `{Prefix}vod`;#ctcms#

CREATE TABLE `{Prefix}vod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '',
  `pic` varchar(255) DEFAULT '',
  `pic2` varchar(255) DEFAULT '',
  `cid` int(10) unsigned DEFAULT '0',
  `tid` tinyint(1) DEFAULT '0',
  `zid` tinyint(1) DEFAULT '0',
  `yid` tinyint(1) DEFAULT '0',
  `state` varchar(64) DEFAULT '',
  `daoyan` varchar(128) DEFAULT '',
  `zhuyan` varchar(128) DEFAULT '',
  `type` varchar(128) DEFAULT '',
  `diqu` varchar(128) DEFAULT '',
  `yuyan` varchar(128) DEFAULT '',
  `year` varchar(64) DEFAULT '',
  `info` varchar(64) DEFAULT '',
  `hits` int(10) unsigned DEFAULT '0',
  `yhits` int(10) unsigned DEFAULT '0',
  `zhits` int(10) unsigned DEFAULT '0',
  `rhits` int(10) unsigned DEFAULT '0',
  `text` text,
  `skin` varchar(64) DEFAULT 'play.html',
  `url` longtext,
  `addtime` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `addtime` (`addtime`),
  KEY `cid` (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#ctcms#


INSERT INTO `{Prefix}link` (`id`, `cid`, `name`, `link`, `pic`) VALUES (1, 0, '赤兔cms', 'http://www.ctcms.cn/', '');#ctcms#
INSERT INTO `{Prefix}class` (`id`, `name`, `fid`, `xid`) VALUES (1, '电影', 0, 1);#ctcms#
INSERT INTO `{Prefix}class` (`id`, `name`, `fid`, `xid`) VALUES (2, '电视剧', 0, 2);#ctcms#
INSERT INTO `{Prefix}class` (`id`, `name`, `fid`, `xid`) VALUES (3, '动漫', 0, 3);#ctcms#
INSERT INTO `{Prefix}class` (`id`, `name`, `fid`, `xid`) VALUES (4, '综艺', 0, 4);#ctcms#
INSERT INTO `{Prefix}player` (`id`, `name`, `text`, `bs`, `js`, `xid`) VALUES (1, '视频云',  '云解析各大视频站',  'ydisk', '&lt;iframe src=&quot;{ctcms_path}packs/player/ydisk/?url={url}&quot; marginwidth=&quot;0&quot; marginheight=&quot;0&quot; border=&quot;0&quot; scrolling=&quot;no&quot; frameborder=&quot;0&quot; topmargin=&quot;0&quot; width=&quot;100%&quot; height=&quot;100%&quot;&gt;&lt;/iframe&gt;', 1);#ctcms#
INSERT INTO `{Prefix}player` (`id`, `name`, `text`, `bs`, `js`, `xid`) VALUES (2, '优酷云',  '优酷云',  'ykyun', '&lt;iframe src=&quot;{ctcms_path}packs/player/ydisk/?url={url}~ykyun&quot; marginwidth=&quot;0&quot; marginheight=&quot;0&quot; border=&quot;0&quot; scrolling=&quot;no&quot; frameborder=&quot;0&quot; topmargin=&quot;0&quot; width=&quot;100%&quot; height=&quot;100%&quot;&gt;&lt;/iframe&gt;', 2);#ctcms#
INSERT INTO `{Prefix}player` (`id`, `name`, `text`, `bs`, `js`, `xid`) VALUES (3, 'CK播放器',  'CK播放器',  'ck', '&lt;div id=&quot;a1&quot; style=&quot;width:100%;height:100%;&quot;&gt;&lt;/div&gt;
&lt;script type=&quot;text/javascript&quot; src=&quot;{ctcms_path}packs/player/ckplayer/ckplayer.js&quot; charset=&quot;utf-8&quot;&gt;&lt;/script&gt;
&lt;script type=&quot;text/javascript&quot;&gt;
var flashvars={f:&#039;{url}&#039;,c:0,p:1};
var isiPad = navigator.userAgent.match(/iPad|iPhone|Linux|Android|iPod/i) != null;
if(isiPad){
document.getElementById(&quot;a1&quot;).innerHTML=&#039;&lt;video src=&quot;{url}&quot; controls=&quot;controls&quot; autoplay=&quot;autoplay&quot; width=&quot;100%&quot; height=&quot;100%&quot;&gt;&lt;/video&gt;&#039;;
}else{
var params={bgcolor:&#039;#000000&#039;,allowFullScreen:true,allowScriptAccess:&#039;always&#039;,wmode:&#039;transparent&#039;};
CKobject.embedSWF(&#039;{ctcms_path}packs/player/ckplayer/ckplayer.swf&#039;,&#039;a1&#039;,&#039;ckplayer_a1&#039;,&#039;100%&#039;,&#039;100%&#039;,flashvars,params);
}
&lt;/script&gt;', 3);#ctcms#
