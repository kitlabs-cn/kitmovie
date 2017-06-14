<?php
/**
 * @Ctcms open source management system
 * @copyright 2016-2017 ctcms.cn. All rights reserved.
 * @Author:Chi Tu
 * @Dtime:2016-05-11
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Backup extends CI_Model
{
    function __construct (){
	       parent:: __construct ();
    }

    //备份数据
    function backup($tables){

	    $bkpath = FCPATH."attachment/backup/Ctcms_".date('Ymd')."_".date('His')."/";
	    $bkname = "ctcms_".substr(md5(time().mt_rand(1000,5000)),0,16).".sql"; //名称
		$this->load->dbutil();
		$prefs = array(
			'tables'    => $tables,
			'format'    => 'txt',
		);
		$backup = $this->dbutil->backup($prefs);
        //写文件
		$bkfile = $bkpath.$bkname;
        if (!write_file($bkfile, $backup)){
                  return FALSE;
        }else{
                  return TRUE;
        }
	}

    //还原数据
    function restore($name)
    {

		$this->load->helper('file');
        $path=FCPATH."attachment/backup/".$name."/";
        $strs=get_dir_file_info($path, $top_level_only = TRUE);
        foreach ($strs as $value) {
            if(!is_dir($path.$value['name'])){
			     $fullpath=$path.$value['name'];
			     //还原表结构
			     if(substr($value['name'],0,6)=="ctcms_"){
					    $tabel_stru=file_get_contents($fullpath);
					    $tabelarr=explode(";\n",$tabel_stru);
						for($i=0;$i<count($tabelarr)-1;$i++){
							if(!empty($tabelarr[$i])) $this->db->query($tabelarr[$i]);
						}
			     } 
			}
		}
        return TRUE;
    }
}

