<?php
/**
 * @Ctcms open source management system
 * @copyright 2016-2017 ctcms.cn. All rights reserved.
 * @Author:Chi Tu
 * @Dtime:2016-08-11
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends Ctcms_Controller {

	function __construct(){
	    parent::__construct();
		//加载后台模型
		$this->load->model('admin');
        //当前模版
		$this->load->get_templates('admin');
		//判断是否登陆
		$this->admin->login();
	}

	public function index()
	{
		$this->load->helper('directory');
		//获取所有模板
		$map = directory_map('./template/skins/', 1);
		$skin=array();
        foreach ($map as $dir) {
			$dir=str_replace("\\","/",$dir);
			$dir=str_replace("/","",$dir);
			$skin[]=$dir;
		}
        $data['skin'] = $skin;
		//获取所有手机模板
		$map = directory_map('./template/mobile', 1);
		$wapskin=array();
        foreach ($map as $dir) {
			$dir=str_replace("\\","/",$dir);
			$dir=str_replace("/","",$dir);
			$wapskin[]=$dir;
		}
        $data['wapskin'] = $wapskin;
 		$this->load->view('head.tpl',$data);
		$this->load->view('setting.tpl');
	}

	public function save()
	{
		$Web_Name = $this->input->post('Web_Name', TRUE);
		$Web_Url = $this->input->post('Web_Url', TRUE);
		$Web_Path = $this->input->post('Web_Path', TRUE);
		$Base_Path = $this->input->post('Base_Path', TRUE);
		$Admin_Code = $this->input->post('Admin_Code', TRUE);
		$Admin_Log_Day = intval($this->input->post('Admin_Log_Day'));
		$Admin_Log_Ip = $this->input->post('Admin_Log_Ip', TRUE);
		$Web_Off = intval($this->input->post('Web_Off', TRUE));
		$Web_Onneir = $this->input->post('Web_Onneir', TRUE);
		$Web_Mode = intval($this->input->post('Web_Mode', TRUE));
		$Web_Icp = $this->input->post('Web_Icp', TRUE);
		$Admin_QQ = $this->input->post('Admin_QQ', TRUE);
		$Admin_Mail = $this->input->post('Admin_Mail', TRUE);
		$Web_Count = $_POST['Web_Count'];
		$Web_Title = $this->input->post('Web_Title', TRUE);
		$Web_Keywords = $this->input->post('Web_Keywords', TRUE);
		$Web_Description = $this->input->post('Web_Description', TRUE);
		$Cache_Is = intval($this->input->post('Cache_Is', TRUE));
		$Cache_Time = intval($this->input->post('Cache_Time', TRUE));
		$Web_Skin = $this->input->post('Web_Skin', TRUE);
		$Web_Pl = $_POST['Web_Pl'];
			
		$Wap_Is = intval($this->input->post('Wap_Is', TRUE));
		$Wap_Skin = $this->input->post('Wap_Skin', TRUE);
		$Wap_Url = $this->input->post('Wap_Url', TRUE);

		$Uri_Mode =(int)$this->input->post('Uri_Mode', TRUE);
		$Uri_List = $this->input->post('Uri_List', TRUE);
		$Uri_Show = $this->input->post('Uri_Show', TRUE);
		$Uri_Play = $this->input->post('Uri_Play', TRUE);

		$Web_Diqu = $this->input->post('Web_Diqu', TRUE);
		$Web_Yuyan = $this->input->post('Web_Yuyan', TRUE);
		$Web_Year = $this->input->post('Web_Year', TRUE);
		$Web_Type = str_encode($this->input->post('Web_Type'));

		$Gbook_Is = (int)$this->input->post('Gbook_Is', TRUE);
		$Gbook_Sh = (int)$this->input->post('Gbook_Sh', TRUE);
		$Gbook_Str = $this->input->post('Gbook_Str', TRUE);

        if($Cache_Time==0)  $Cache_Time=600;

        //HTML转码 
        $Web_Title= str_encode($Web_Title); 
        $Web_Keywords= str_encode($Web_Keywords); 
        $Web_Description= str_encode($Web_Description); 
		$Web_Count= str_encode($Web_Count); 
		$Web_Pl= str_encode($Web_Pl);
		$Gbook_Str= str_encode($Gbook_Str);

        //判断主要数据不能为空
		if (empty($Web_Name)||empty($Web_Url)||empty($Web_Path)||empty($Admin_Code)){
		       admin_msg('网站名称、域名、路径、后台认证码不能为空',links('setting'),'no');
		}

		//URL路由
		if($Uri_Mode==1){
			if (empty($Uri_List)||empty($Uri_Show)||empty($Uri_Play)){
		         admin_msg('URL路由规则不能为空',links('setting'),'no');
		    }
            $uri = array(
                    'list'=>$Uri_List,
                    'show'=>$Uri_Show,
                    'play'=>$Uri_Play
			);
            $this->_route_file($uri);
		}

		$strs="<?php"."\r\n";
		$strs.="define('Web_Name','".$Web_Name."'); //站点名称  \r\n";
		$strs.="define('Web_Url','".$Web_Url."'); //站点域名  \r\n";
		$strs.="define('Web_Path','".$Web_Path."'); //站点路径  \r\n";
		$strs.="define('Web_Off',".$Web_Off.");  //网站开关  \r\n";
		$strs.="define('Web_Onneir','".$Web_Onneir."');  //网站关闭内容  \r\n";
		$strs.="define('Web_Mode',".$Web_Mode.");  //网站运行模式  \r\n";
		$strs.="define('Web_Icp','".$Web_Icp."');  //网站ICP  \r\n";
		$strs.="define('Web_Count','".$Web_Count."');  //统计代码  \r\n";
		$strs.="define('Web_Title','".$Web_Title."'); //SEO-标题  \r\n";
		$strs.="define('Web_Keywords','".$Web_Keywords."'); //SEO-Keywords  \r\n";
		$strs.="define('Web_Description','".$Web_Description."'); //SEO-description  \r\n";
		$strs.="define('Web_Skin','".$Web_Skin."'); //网站默认模板  \r\n";
		$strs.="define('Admin_QQ','".$Admin_QQ."');  //站长QQ  \r\n";
		$strs.="define('Admin_Mail','".$Admin_Mail."');  //站长EMAIL  \r\n";
		$strs.="define('Admin_Code','".$Admin_Code."');  //后台验证码  \r\n";
		$strs.="define('Admin_Log_Day',".$Admin_Log_Day.");  //后台登陆日志保存天数  \r\n";
		$strs.="define('Admin_Log_Ip','".$Admin_Log_Ip."');  //允许访问后台的IP列表  \r\n";
		$strs.="define('Cache_Is',".$Cache_Is.");  //缓存开关  \r\n";
		$strs.="define('Cache_Time',".$Cache_Time.");  //缓存时间  \r\n";
		$strs.="define('Base_Path','".$Base_Path."'); //附件路径，包含后台css、js、images  \r\n";
		$strs.="define('Wap_Is',".$Wap_Is.");  //手机版开关\r\n";
		$strs.="define('Wap_Url','".$Wap_Url."');  //手机版地址\r\n";
		$strs.="define('Wap_Skin','".$Wap_Skin."');  //手机版模版\r\n";
		$strs.="define('Uri_Mode',".$Uri_Mode.");  //是否启用Url路由  \r\n";
		$strs.="define('Uri_List','".$Uri_List."');  //分类页路由规则  \r\n";
		$strs.="define('Uri_Show','".$Uri_Show."');  //内容页路由规则  \r\n";
		$strs.="define('Uri_Play','".$Uri_Play."');  //播放页路由规则  \r\n";
		$strs.="define('Web_Diqu','".$Web_Diqu."');  //地区  \r\n";
		$strs.="define('Web_Yuyan','".$Web_Yuyan."');  //语言  \r\n";
		$strs.="define('Web_Year','".$Web_Year."');  //年份  \r\n";
		$strs.="define('Web_Type','".$Web_Type."');  //类型  \r\n";
		$strs.="define('Web_Pl','".$Web_Pl."');  //评论代码  \r\n";
		$strs.="define('Gbook_Is',".$Gbook_Is.");  //留言开关  \r\n";
		$strs.="define('Gbook_Sh',".$Gbook_Sh.");  //留言需要审核  \r\n";
		$strs.="define('Gbook_Str','".$Gbook_Str."');  //留言过滤关键字";
		
        //写文件
        if (!write_file(CTCMSPATH.'libs/Ct_Config.php', $strs)){
             admin_msg('抱歉，修改失败，请检查文件写入权限~!',links('setting'),'no');
		}else{
			 if($Web_Mode!=Web_Mode){
                 die("<script language='javascript'>alert('修改成功~!');top.location='".links('index')."';</script>");
			 }else{
                 admin_msg('恭喜您，配置修改成功~！',links('setting'));
			 }
		}
	}

	//将路由规则生成至文件
	public function _route_file($uri) {
        $yuri = array(
              'list'=>'lists/index/[cid]/[page]',
              'show'=>'show/index/[id]',
              'play'=>'play/index/[id]/[zu]/[ji]'
	    );
		$string = '<?php'.PHP_EOL;
		$string.= 'if (!defined(\'BASEPATH\')) exit(\'No direct script access allowed\');'.PHP_EOL;
		$string.= '$route[\'whole/(.+).html\'] = \'whole/index/$1\'; '.PHP_EOL;
		if($uri) {
			arsort($uri);
			foreach ($uri as $key => $val1) {
				$val2 = $yuri[$key];
				if($key == 'list' ){
					$val1 = str_replace(array('[cid]','[page]'),array('(\d+)','(\d+)'),$val1);
					$val2 = str_replace(array('[cid]','[page]'),array('$1','$2'),$val2);
				    $string.= '$route[\''.$val1.'\'] = \''.$val2.'\'; '.PHP_EOL;
				}elseif($key == 'show' ){
					$val1 = str_replace(array('[id]'),array('(\d+)'),$val1);
					$val2 = str_replace(array('[id]'),array('$1'),$val2);
				    $string.= '$route[\''.$val1.'\'] = \''.$val2.'\'; '.PHP_EOL;
				}elseif($key == 'play' ){
					$val1 = str_replace(array('[id]','[zu]','[ji]'),array('(\d+)','(\d+)','(\d+)'),$val1);
					$val2 = str_replace(array('[id]','[zu]','[ji]'),array('$1','$2','$3'),$val2);
				    $string.= '$route[\''.$val1.'\'] = \''.$val2.'\'; '.PHP_EOL;
				}
			}
		}
		write_file(CTCMSPATH.'libs/Ct_Rewrite.php', $string);
	}
}
