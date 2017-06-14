<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @Ctcms open source management system
 * @copyright 2016-2017 ctcms.cn. All rights reserved.
 * @Author:Chi Tu
 * @Dtime:2016-07-11
 */
class CT_Loader extends CI_Loader {
	public function __construct()
	{
		parent::__construct();
		log_message('debug', "MY_Loader Class Initialized");
	}
	//ÍøÕ¾Ä£°æÇÐ»»
    public function get_templates($dir='')
    {
		//ÅÐ¶ÏÊÖ»ú
		if(Wap_Is==1 && defined('MOBILE') && !defined('IS_ADMIN')){
            $this->_ci_view_paths = array(VIEWPATH.Wap_Skin.DIRECTORY_SEPARATOR => TRUE);
		}else{
		    if($dir=='') $dir=Web_Skin;
            $this->_ci_view_paths = array(VIEWPATH.$dir.DIRECTORY_SEPARATOR => TRUE);
		}
    }
}
/* End of file MY_Loader.php */
/* Location: ./application/core/MY_Loader.php */
