<?php 
/**
 * @Ctcms open source management system
 * @copyright 2016-2017 ctcms.cn. All rights reserved.
 * @Author:Chi Tu
 * @Dtime:2016-08-11
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends Ctcms_Controller {

	function __construct() {
	    parent::__construct();
		//加载后台模型
		$this->load->model('admin');
		$this->load->helper('string');
        //当前模版
		$this->load->get_templates('admin');
	}

	public function index()
	{
		$this->admin->login();
        $ac = $this->input->get('ac',true);
        $dir = array('vod','link','other');
		if(!in_array($ac,$dir)) $ac='other';
        //定义允许上传的文件扩展名
        $ext_arr = array('*.gif', '*.jpg', '*.jpeg', '*.png', '*.bmp');
		$data['types'] = implode(';',$ext_arr);
		$str['id'] = $_SESSION['admin_id'];
		$str['login'] = $_SESSION['admin_login'];
        $data['key'] = sys_auth(addslashes(serialize($str)),'E');
        $data['dir'] = $ac;
        $data['sid'] = $this->input->get('sid',true);
        $data['upsave'] = links('upload','save');
		$this->load->view('upload.tpl',$data);
	}

    //保存附件
	public function save()
	{
            $key=$this->input->post('key',true);
			$login=$this->admin->login($key,1);
			if($login==0) $this->msg(1,'您已登陆超时~!');
            $dir=$this->input->post('dir',true);
            $dir_arr = array('vod','link','other');
			if(!in_array($dir,$dir_arr)) $dir='other';

			//上传目录
			$path = FCPATH.'attachment/'.$dir.'/'.date('Ym').'/'.date('d').'/';
			if (!is_dir($path)) {
                mkdirss($path);
            }
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$file_name = $_FILES['Filedata']['name'];
			$file_size = filesize($tempFile);
	        $file_ext = strtolower(trim(substr(strrchr($file_name, '.'), 1)));

	        //检查扩展名
	        if($file_ext=='jsp' || $file_ext=='aspx' || $file_ext=='php' || $file_ext=='asp'){
                $this->msg(1,'文件格式不支持');
	        }elseif($file_ext=='jpg' || $file_ext=='png' || $file_ext=='gif' || $file_ext=='bmp' || $file_ext=='jpge'){
				list($width, $height, $type, $attr) = getimagesize($tempFile);
				if ( intval($width) < 10 || intval($height) < 10 || $type == 4 ) {
                    $this->msg(1,'图片格式不正确');
				}
			}
            //PHP上传失败
            if (!empty($_FILES['Filedata']['error'])) {
	            switch($_FILES['Filedata']['error']){
		            case '1':
			            $error = '超过php.ini允许的大小。';
			            break;
		            case '2':
			            $error = '超过表单允许的大小。';
			            break;
		            case '3':
			            $error = '图片只有部分被上传。';
			            break;
		            case '4':
			            $error = '请选择图片。';
			            break;
		            case '6':
			            $error = '找不到临时目录。';
			            break;
		            case '7':
			            $error = '写文件到硬盘出错。';
			            break;
		            case '8':
			            $error = 'File upload stopped by extension。';
			            break;
		            case '999':
		            default:
			            $error = '未知错误。';
	            }
	            $this->msg(1,$error);
            }
            //新文件名
			$file_name=random_string('alnum', 20). '.' . $file_ext;
			$file_path=$path.$file_name;
			if (move_uploaded_file($tempFile, $file_path) !== false) { //上传成功
                  $filepath = '/'.date('Ym').'/'.date('d').'/'.$file_name;
				  $filepath = Web_Path.'attachment/'.$dir.$filepath;
				  $this->msg(0,$filepath);
			}else{ //上传失败
				  $this->msg(1,'上传失败');
			}
	}

    //编辑器上传
	public function editor()
	{
			$this->admin->login();
            //文件保存目录路径
            $save_path = './attachment/editor/';
            //文件保存目录URL
            $save_url = 'http://'.Web_Url.Web_Path.'attachment/editor/';
            //定义允许上传的文件扩展名
            $ext_arr = array(
	            'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
	            'flash' => array('swf', 'flv'),
	            'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
	            'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
            );
            //最大文件大小
            $max_size = 10000000;
            //PHP上传失败
            if (!empty($_FILES['imgFile']['error'])) {
	            switch($_FILES['imgFile']['error']){
		            case '1':
			            $error = '超过php.ini允许的大小。';
			            break;
		            case '2':
			            $error = '超过表单允许的大小。';
			            break;
		            case '3':
			            $error = '图片只有部分被上传。';
			            break;
		            case '4':
			            $error = '请选择图片。';
			            break;
		            case '6':
			            $error = '找不到临时目录。';
			            break;
		            case '7':
			            $error = '写文件到硬盘出错。';
			            break;
		            case '8':
			            $error = 'File upload stopped by extension。';
			            break;
		            case '999':
		            default:
			            $error = '未知错误。';
	            }
	            $this->alert($error);
            }
            //有上传文件时
            if (!empty($_FILES) === false) {
                   $this->alert("请选择文件。");
            }
	            //原文件名
	            $file_name = $_FILES['imgFile']['name'];
	            //服务器上临时文件名
	            $tmp_name = $_FILES['imgFile']['tmp_name'];
	            //文件大小
	            $file_size = $_FILES['imgFile']['size'];
	            //检查文件名
	            if (!$file_name) {
		            $this->alert("请选择文件。");
	            }
	            //检查目录
	            if (@is_dir($save_path) === false) {
		            $this->alert("上传目录不存在。");
	            }
	            //检查目录写权限
	            if (@is_writable($save_path) === false) {
		            $this->alert("上传目录没有写权限。");
	            }
	            //检查是否已上传
	            if (@is_uploaded_file($tmp_name) === false) {
	            	$this->alert("上传失败。");
	            }
	            //检查文件大小
	            if ($file_size > $max_size) {
		            $this->alert("上传文件大小超过限制。");
	            }
	            //检查目录名
	            $dir_name = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
	            if (empty($ext_arr[$dir_name])) {
	            	$this->alert("目录名不正确。");
	            }
                    //检查图片文件是否正确
                    if($dir_name=='image'){
                         $aa=getimagesize($tmp_name);
                         $weight=$aa["0"];////获取图片的宽
                         $height=$aa["1"];///获取图片的高
                         if($weight<1 || $height<1){
                                 @unlink($tmp_name);
                                 $this->alert("图片内容不正确。");
                         }
                    }

	            //获得文件扩展名
	            $temp_arr = explode(".", $file_name);
	            $file_ext = array_pop($temp_arr);
	            $file_ext = trim($file_ext);
	            $file_ext = strtolower($file_ext);
	            //检查扩展名
	            if (in_array($file_ext, $ext_arr[$dir_name]) === false) {
		            $this->alert("上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr[$dir_name]) . "格式。");
	            }

                    if($dir_name=='file'){
                         $dir_name='papers';
                    }

	            //创建文件夹
	            if ($dir_name !== '') {
		            $save_path .= $dir_name . "/";
		            $save_url .= $dir_name . "/";
		            if (!file_exists($save_path)) {
			            @mkdir($save_path);
		            }
	            }
	            $ymd = date("Ymd");
	            $save_path .= $ymd . "/";
	            $save_url .= $ymd . "/";
	            if (!file_exists($save_path)) {
	            	@mkdir($save_path);
	            }
	            //新文件名
	            $new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
	            //移动文件
	            $file_path = $save_path . $new_file_name;
	            if (move_uploaded_file($tmp_name, $file_path) === false) {
		            $this->alert("上传文件失败。");
	            }
	            @chmod($file_path, 0644);
                           
	            $file_url = $save_url . $new_file_name;

	            echo json_encode(array('error' => 0, 'url' => $file_url));
	            exit;

    }

	//编辑器上传返回
	public function alert($msg) {
		echo json_encode(array('error' => 1, 'message' => $msg));
		exit;
	}

	//上传返回
	public function msg($code=0,$str='')
	{
            $arr['code']=$code;
            $arr['str']=$str;
			echo json_encode($arr);
			exit;
	}
}