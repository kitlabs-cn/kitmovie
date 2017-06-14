<?php 
/**
 * @Ctcms open source management system
 * @copyright 2016-2017 ctcms.cn. All rights reserved.
 * @Author:Chi Tu
 * @Dtime:2016-06-10
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CT_Parser extends CI_Parser {

    //模板解析
	public function parse_string($template, $data, $return = FALSE, $IF = TRUE)
	{
		return $this->_parse($template, $data, $return, $IF);
	}
    //全局解析
	protected function _parse($template, $data = array(), $return = FALSE, $IF = TRUE)
	{
		if ($template === '')
		{
			return FALSE;
		}

		//解析顶部和底部
		$head = $left = $right = $bottom = '';
		if(Wap_Is==1 && defined('MOBILE')){
			$templets_path = Web_Path.'template/mobile/'.Wap_Skin;
            if(preg_match('/{ctcms_head}/',$template))
				$head = file_get_contents(FCPATH.'template/mobile/'.Wap_Skin.'/head.html');
            if(preg_match('/{ctcms_left}/',$template))
				$left = file_get_contents(FCPATH.'template/mobile/'.Wap_Skin.'/left.html');
            if(preg_match('/{ctcms_right}/',$template))
				$right = file_get_contents(FCPATH.'template/mobile/'.Wap_Skin.'/right.html');
            if(preg_match('/{ctcms_bottom}/',$template))
				$bottom = file_get_contents(FCPATH.'template/mobile/'.Wap_Skin.'/bottom.html');
		}else{
			$templets_path = Web_Path.'template/skins/'.Web_Skin;
            if(preg_match('/{ctcms_head}/',$template))
				$head = file_get_contents(FCPATH.'template/skins/'.Web_Skin.'/head.html');
            if(preg_match('/{ctcms_left}/',$template))
				$left = file_get_contents(FCPATH.'template/skins/'.Web_Skin.'/left.html');
            if(preg_match('/{ctcms_right}/',$template))
				$right = file_get_contents(FCPATH.'template/skins/'.Web_Skin.'/right.html');
            if(preg_match('/{ctcms_bottom}/',$template))
				$bottom = file_get_contents(FCPATH.'template/skins/'.Web_Skin.'/bottom.html');
		}
		$template = str_replace('{ctcms_head}',$head,$template);
		$template = str_replace('{ctcms_left}',$left,$template);
		$template = str_replace('{ctcms_right}',$right,$template);
		$template = str_replace('{ctcms_bottom}',$bottom,$template);
		$indexskin = (Wap_Is==1 && defined('MOBILE')) ? 'mobile/'.Wap_Skin : 'skins/'.Web_Skin;
        if(preg_match('/{ctcms_indexhead}/',$template)){
			$head = file_get_contents(FCPATH.'template/'.$indexskin.'/head.html');
		    $template = str_replace('{ctcms_indexhead}',$head,$template);
		}
        if(preg_match('/{ctcms_indexleft}/',$template)){
			$left = file_get_contents(FCPATH.'template/'.$indexskin.'/left.html');
		    $template = str_replace('{ctcms_indexleft}',$left,$template);
		}
        if(preg_match('/{ctcms_indexright}/',$template)){
			$right = file_get_contents(FCPATH.'template/'.$indexskin.'/right.html');
		    $template = str_replace('{ctcms_indexright}',$right,$template);
		}
        if(preg_match('/{ctcms_indexbottom}/',$template)){
			$bottom = file_get_contents(FCPATH.'template/'.$indexskin.'/bottom.html');
		    $template = str_replace('{ctcms_indexbottom}',$bottom,$template);
		}
		//常用标签
		$template = str_replace('{ctcms_templets}',$templets_path,$template);
		$template = str_replace('{ctcms_indextemplets}',Web_Path.'template/'.$indexskin,$template);
		$template = str_replace('{ctcms_url}',Web_Url,$template);
		$template = str_replace('{ctcms_name}',Web_Name,$template);
		$template = str_replace('{ctcms_icp}',Web_Icp,$template);
		$template = str_replace('{ctcms_stat}',str_decode(Web_Count),$template);
		$template = str_replace('{ctcms_qq}',Admin_QQ,$template);
		$template = str_replace('{ctcms_mail}',Admin_Mail,$template);
		$template = str_replace('{ctcms_basepath}',Base_Path,$template);
		$template = str_replace('{ctcms_path}',Web_Path,$template);
		$template = str_replace('{ctcms_searchlink}',links('search'),$template);
		$template = str_replace('{ctcms_gbooklink}',links('gbook'),$template);
		$template = str_replace('{ctcms_shortlink}',links('index','short'),$template);

		$replace = array();
		foreach ($data as $key => $val)
		{
			$replace = array_merge(
				$replace,
				is_array($val)
					? $this->_parse_pair($key, $val, $template)
					: $this->_parse_single($key, (string) $val, $template)
			);
		}

		$template = strtr($template, $replace);

		//sql解析
		preg_match_all('/{ctcms:([\S]+)\s+(.*?)}([\s\S]+?){\/ctcms:\1}/',$template,$str_arr);
		if(!empty($str_arr)){
			 for($i=0;$i<count($str_arr[0]);$i++){
                     $template=$this->ctcms_skins($str_arr[1][$i],$str_arr[2][$i],$str_arr[0][$i],$str_arr[3][$i],$template);
			 }
		}
		unset($str_arr);

		//站点标题、关键字、描述
		$template = str_replace('{ctcms_title}',Web_Title,$template);
		$template = str_replace('{ctcms_keywords}',Web_Keywords,$template);
		$template = str_replace('{ctcms_description}',Web_Description,$template);
		//当前分类ID
		$template = str_replace('{ctcms_cid}',0,$template);

		//自定义链接
		preg_match_all('/{ctcms_url\s+([0-9a-zA-Z]+)=(.*?)}/',$template,$u_arr);
		if(!empty($u_arr)){
			 for($i=0;$i<count($u_arr[0]);$i++){
				   if($u_arr[1][$i]=='whole'){
				       $links = links($u_arr[1][$i],'index',0,$u_arr[2][$i]);
				   }elseif($u_arr[1][$i]=='user' || $u_arr[1][$i]=='opt'){
				       $links = links($u_arr[1][$i],$u_arr[2][$i]);
				   }else{
					   $arr = explode("/",$u_arr[2][$i]);
					   $op = $arr[0];
					   $id = empty($arr[1])? 0 : (int)$arr[1];
					   $where = empty($arr[2])? 0 : $arr[2];
				       $links = links($u_arr[1][$i],$op,$id,$where);
				   }
                   $template=str_replace($u_arr[0][$i],$links,$template);
			 }
		}
		unset($u_arr);

		//语言、地区、类型、年份
		preg_match_all('/{ctcms:([0-9a-zA-Z]+)}([\s\S]+?){\/ctcms:\1}/',$template,$y_arr);
		if(!empty($y_arr)){
			 for($i=0;$i<count($y_arr[0]);$i++){
                   $template=$this->ctcms_array($y_arr[1][$i],$y_arr[2][$i],$y_arr[0][$i],$template,$data);
			 }
		}
		unset($y_arr);
		unset($data);

		//js标签
		preg_match_all('/{ctcms_js_([0-9a-zA-Z]+)}/',$template,$str_arr);
		if(!empty($str_arr)){
			 for($i=0;$i<count($str_arr[0]);$i++){
                   $js = '<script src="'.links('ads','index',$str_arr[1][$i]).'"></script>';
                   $template=str_replace($str_arr[0][$i],$js,$template);
			 }
		}
		unset($str_arr);

		//解析if标签
		if($IF) $template=$this->labelif($template);

		if ($return === FALSE)
		{
			$this->CI->output->append_output($template);
		}
		return $template;
	}

	//解析ctcms大标签
	public function ctcms_skins($fields, $para, $str_arr, $label, $str, $sql='') 
	{
		     if($sql==''){
		         $sql=$this->ctcms_sql($fields, $para, $str_arr, $label);
			 }
		     $result_array=$this->CI->db->query($sql)->result_array();
			 if(!$result_array){
					$Data_Content="";
					$str=str_replace($str_arr,$Data_Content,$str);
			 }else{
					$Data_Content='';$sorti=1;
					foreach ($result_array as $row) {
                          $Data_Content.=$this->ctcms_tpl($fields,$str,$label,$row,$sorti);
						  $sorti++;
					}
			 }
			 $str=str_replace($str_arr,$Data_Content,$str);	
		     return $str;
	}

	//解析CSCMS标签
	public function ctcms_tpl($field, $str, $label, $row, $sorti=1) 
	{
		     preg_match_all('/\['.$field.':\s*([0-9a-zA-Z\_\-]+)([\s]*[len|style|count|zdy|url]*)[=]??([\d0-9a-zA-Z\,\_\{\}\/\-\\\\:\s]*)\]/',$str,$field_arr);
		     if(!empty($field_arr)){
			     for($i=0;$i<count($field_arr[0]);$i++){
					 $type=$field_arr[1][$i];
					 if(array_key_exists($type,$row)){
							//判断自定义标签
                            if(!empty($field_arr[2][$i]) && !empty($field_arr[3][$i])){
                                 //格式化时间
								 if(trim($field_arr[2][$i])=='style' && trim($field_arr[3][$i])=='time'){
									 $label=str_replace($field_arr[0][$i],datetime($row[$type]),$label);
                                 //自定义时间
								 }elseif(trim($field_arr[2][$i])=='style'){
									 $label=str_replace($field_arr[0][$i],date(str_replace('f','i',$field_arr[3][$i]),$row[$type]),$label);
								 }
								 //字符截取
                                 if(trim($field_arr[2][$i])=='len'){
									 $label=str_replace($field_arr[0][$i],sub_str(str_checkhtml($row[$type]),$field_arr[3][$i]),$label);
								 }
								 //字符加链接
                                 if(trim($field_arr[2][$i])=='url' && !empty($field_arr[3][$i])){
									 $label=str_replace($field_arr[0][$i],taglink($row[$type],$type,$field_arr[3][$i]),$label);
								 }
							}
						    if($type=='pic' || $type=='pic2'){
						         $label=str_replace($field_arr[0][$i],getpic($row[$type]),$label);
						    }elseif($type=='addtime'){
						         $label=str_replace($field_arr[0][$i],date('Y-m-d H:i:s',$row[$type]),$label);
							}elseif($type=='state'){
								 if(is_numeric($row[$type])){
						             $label=str_replace($field_arr[0][$i],'更新至'.$row[$type].'集',$label);
								 }else{
						             $label=str_replace($field_arr[0][$i],$row[$type],$label);
								 }
							}else{
						         $label=str_replace($field_arr[0][$i],$row[$type],$label);
							}

					 }else{  //外部字段

            			 	switch($type){
								  //序
				    			  case 'i'  :  
								          //判断从几开始
                                          if(trim($field_arr[2][$i])=='len'){
									          $label=str_replace($field_arr[0][$i],($sorti+$field_arr[3][$i]),$label);
										  }else{
									          $label=str_replace($field_arr[0][$i],$sorti,$label);
										  }
								  break;
								  //分类名称
				    			  case 'classname'  : 
									      $cid = empty($row['cid'])? $row['id'] : $row['cid'];
                                          $label=str_replace($field_arr[0][$i],getzd('class','name',$cid),$label);
								  break;
								  //分类链接
				    			  case 'classlink'  : 
									      if($field=='class'){
                                              $label=str_replace($field_arr[0][$i],links('lists','index',$row['id']),$label);
								          }else{
											  $cid = empty($row['cid'])? $row['id'] : $row['cid'];
                                              $label=str_replace($field_arr[0][$i],links('lists','index',$cid),$label);
										  }
				    			  break;
								  //内容链接
				    			  case 'link'  : 
									      if($field=='class'){
                                              $label=str_replace($field_arr[0][$i],links('lists','index',$row['id']),$label);
								          }else{
								          		$label=str_replace($field_arr[0][$i],links('show','index',$row['id']),$label);
										  }
				    			  break;
								  //播放链接
				    			  case 'playlink'  : 
                                          $label=str_replace($field_arr[0][$i],links('play','index',$row['id']),$label);
				    			  break;
								  //自定义字段
				    			  case 'zdy'  :  
                                           if(trim($field_arr[2][$i])=='zd' && !empty($field_arr[3][$i])){
									            $arr=explode(',',$field_arr[3][$i]);
                                                if(array_key_exists($arr[2],$row)){
                                                    $czd=empty($arr[3])?'id':$arr[3];
													$szd=$row[$arr[2]];
									                $label=str_replace($field_arr[0][$i],getzd($arr[0],$arr[1],$szd,$czd),$label);
												}
								           }
								  break;
								  //自定义统计字段
				    			  case 'count'  :  
                                           if(trim($field_arr[2][$i])=='zd' && !empty($field_arr[3][$i])){
									            $arr=explode(',',$field_arr[3][$i]);
                                                if(array_key_exists($arr[1],$row)){
                                                    $czd=empty($arr[2])?'id':$arr[2];
													$szd=$row[$arr[1]];
													$nums = $this->CI->Csdb->get_nums($arr[0],array($czd=>$szd));
									                $label=str_replace($field_arr[0][$i],$nums,$label);
												}
								           }
								  break;
		     			 	}
					 }
				 }
                 //判断是否嵌套二级
				 preg_match_all('/{ctcmstype:([\S]+)\s+(.*?)}([\s\S]+?){\/ctcmstype:\1}/',$label,$type_arr);
			     if(!empty($type_arr)){
					 for($i=0;$i<count($type_arr[0]);$i++){
			             $label=$this->ctcms_skins($type_arr[1][$i],$type_arr[2][$i],$type_arr[0][$i],$type_arr[3][$i],$label);
					 }
				 }
		         unset($type_arr);
			 }
		     unset($field_arr);
		     return $label;
	}

	//组装SQL标签
	public function ctcms_sql($fields, $para, $str_arr, $label, $sql='') 
	{
             preg_match_all("/([a-z]+)\=[\"]?([^\"]+)[\"]?/i", stripslashes($para), $matches, PREG_SET_ORDER);
		     $arr = array('field', 'table', 'page', 'where', 'limit', 'order');
			 //获取数据表
			 $table=$this->arr_val('table',$matches);
             if($table==''){  //模板标签错误，缺少table参数
				 $strs=str_replace($label,".....",$str_arr);
                 exit($strs.'标签中缺少 table ');
			 }
			 //获取要查询的字段
			 $field=$this->arr_val('field',$matches);
			 if(!$field) $field="*";
			 if(!$this->CI->db->table_exists(CT_SqlPrefix.$table)){  //数据表不存在
				   $strs=str_replace($label,".....",$str_arr);
                   exit($strs.'标签中 数据库表《'.$table.'》不存在~');
			 }
		     if($sql==''){
				 $sql = "select ".$field." from ".CT_SqlPrefix.$table;
			 }else{
				 $sql = str_replace("{field}",$field,$sql);
			 }
			 //获取要查询条件
			 $where=$this->arr_val('where',$matches);
			 if(!empty($where)){
                 $arr=explode("|",$where);
				 $w=array();
				 for($i=0;$i<count($arr);$i++){
					 $w[]=$arr[$i];
				 }
				 $where = implode(' and ', $w);
				 if(strpos(strtolower($sql),'where') === FALSE ){
				     $sql.= ' where '.$where;
				 }else{
				     $sql.= ' and '.$where;
				 }
			 }
			 //只显示审核通过的视频
			 if($table=='vod'){
				 if(strpos(strtolower($sql),'where') === FALSE ){
				     $sql.= ' where yid=0';
				 }else{
				     $sql.= ' and yid=0';
				 }
			 }
			 //排序方式
			 $order=$this->arr_val('order',$matches);
			 if(!empty($order)) $sql.=' order by '.$order; 
			 //显示数量
			 $limit=$this->arr_val('limit',$matches);
			 if(!empty($limit)) $sql.=' limit '.$limit;
		     unset($matches);
		     return $sql;
	}

	//解析地区、语言、类型、年份
	public function ctcms_array($key,$val,$str,$Mark_Text,$data=array()){
		switch($key){
			case 'diqu'  :  $arr = explode('|',Web_Diqu); break;
			case 'yuyan'  :  $arr = explode('|',Web_Yuyan); break;
			case 'type'  :  
				$arr1 = explode("\n",Web_Type);
			    $newarr = array();
			    for($i=0;$i<count($arr1);$i++){
					$arr2 = explode("#",$arr1[$i]);
					$cid = $arr2[0];
                    $newarr[$cid]=$arr2[1];
				}
				$type = implode('|',$newarr);
				if((int)$data['ctcms_cid']>0){
					$cid = (int)$data['ctcms_cid'];
				    $type = $newarr[$cid];
				}
				$arr = explode('|',$type); 
			break;
			case 'year'  :  $arr = explode('|',Web_Year); break;
		}
        //获取当前URL
		if(empty($_GET['key'])){
            $url = get_bm($_SERVER['REQUEST_URI']);
            $as = explode('whole',$url);
			$uri = str_replace('/index/','',$as[1]);
            $uri = str_replace('/','',$uri);
		}else{
            $uri = get_bm($_GET['key']);
		}
        $uri = str_replace('.html','',$uri);
		$xstr = '';
        for($i=0;$i<count($arr);$i++){
			$where = whole_url($key,$arr[$i],$uri);
            $link = links('whole','index',0,$where);
            $xstr.= str_replace(array('['.$key.':name]','['.$key.':link]'),array($arr[$i],$link),$val);
		}
		$Mark_Text = str_replace($str,$xstr,$Mark_Text);
		return $Mark_Text;
	}

	//if标签处理
	public function labelif($Mark_Text)
	{
		$Mark_Text = $this->labelif2($Mark_Text);
		$ifRule = "{if:(.*?)}(.*?){end if}";
		$ifRule2 = "{elseif";
		$ifRule3 = "{else}";
		$elseIfFlag = false;
		$ifFlag = false;
		preg_match_all('/'.$ifRule.'/is',$Mark_Text,$arr);
		if(!empty($arr[1])){
			     for($i=0;$i<count($arr[1]);$i++){
			         $strIf = $arr[1][$i];
			         $strThen = $arr[2][$i];
					 if (strpos($strThen, $ifRule2) !== FALSE) {
				         $elseIfArr = explode($ifRule2, $strThen);
						 $elseIfNum = count($elseIfArr);
						 $elseIfSubArr = explode($ifRule3, $elseIfArr[$elseIfNum-1]);
				         $resultStr = $elseIfSubArr[1];
				         $elseIfstr = $elseIfArr[0];
				         @eval("if($strIf){\$resultStr=\"$elseIfstr\";}");
				         for ($k = 1;$k < $elseIfNum;$k++){
							 $temp = explode(":", $elseIfArr[$k], 2);$content = explode("}", $temp[1], 2);
					         $strElseIf = $content[0];
							 $temp1 = strpos($elseIfArr[$k],"}")+strlen("}");$temp2 = strlen($elseIfArr[$k])+1;
					         $strElseIfThen = substr($elseIfArr[$k],$temp1,$temp2-$temp1);
					         @eval("if($strElseIf){\$resultStr=\"$strElseIfThen\";}");
					         @eval("if($strElseIf){\$elseIfFlag=true;}else{\$elseIfFlag=false;}");
					         if ($elseIfFlag) {break;}
				         }
						 $temp = explode(":", $elseIfSubArr[0], 2);$content = explode("}", $temp[1], 2);
				         $strElseIf0 = $content[0];
						 $temp1 = strpos($elseIfSubArr[0],"}")+strlen("}");$temp2 = strlen($elseIfSubArr[0])+1;
				         $strElseIfThen0 = substr($elseIfSubArr[0],$temp1,$temp2-$temp1);
				         @eval("if($strElseIf0){\$resultStr=\"$strElseIfThen0\";\$elseIfFlag=true;}");
						 $Mark_Text=str_replace($arr[0][$i],$resultStr,$Mark_Text);
					 }else{
                         if(strpos($strThen, "{else}") !== FALSE) {
					         $elsearray = explode($ifRule3, $strThen);
					         $strThen1 = $elsearray[0];
					         $strElse1 = $elsearray[1];
					         @eval("if($strIf){\$ifFlag=true;}else{\$ifFlag=false;}");
					         if ($ifFlag){
								 $Mark_Text=str_replace($arr[0][$i],$strThen1,$Mark_Text);
							 }else{
								 $Mark_Text=str_replace($arr[0][$i],$strElse1,$Mark_Text);
							 }
				         } else {
				             @eval("if  ($strIf) { \$ifFlag=true;} else{ \$ifFlag=false;}");
					         if ($ifFlag){
								 $Mark_Text=str_replace($arr[0][$i],$strThen,$Mark_Text);
							 }else{
								 $Mark_Text=str_replace($arr[0][$i],"",$Mark_Text);
							 }
			             }
					 }
			     }
		}
		return $Mark_Text;
	}

	//if嵌套标签处理
	public function labelif2($Mark_Text){
		$ifRule = "{toif:(.*?)}(.*?){end toif}";
		$ifRule2 = "{elsetoif";
		$ifRule3 = "{elseto}";
		$elseIfFlag = false;
		$ifFlag = false;
		preg_match_all('/'.$ifRule.'/is',$Mark_Text,$arr);
		if(!empty($arr[1])){
			     for($i=0;$i<count($arr[1]);$i++){
			         $strIf = $arr[1][$i];
			         $strThen = $arr[2][$i];
					 if (strpos($strThen, $ifRule2) !== FALSE) {
				         $elseIfArr = explode($ifRule2, $strThen);
						 $elseIfNum = count($elseIfArr);
						 $elseIfSubArr = explode($ifRule3, $elseIfArr[$elseIfNum-1]);
				         $resultStr = $elseIfSubArr[1];
				         $elseIfstr = $elseIfArr[0];
				         @eval("if($strIf){\$resultStr=\"$elseIfstr\";}");
				         for ($k = 1;$k < $elseIfNum;$k++){
							 $temp = explode(":", $elseIfArr[$k], 2);$content = explode("}", $temp[1], 2);
					         $strElseIf = $content[0];
							 $temp1 = strpos($elseIfArr[$k],"}")+strlen("}");$temp2 = strlen($elseIfArr[$k])+1;
					         $strElseIfThen = substr($elseIfArr[$k],$temp1,$temp2-$temp1);
					         @eval("if($strElseIf){\$resultStr=\"$strElseIfThen\";}");
					         @eval("if($strElseIf){\$elseIfFlag=true;}else{\$elseIfFlag=false;}");
					         if ($elseIfFlag) {break;}
				         }
						 $temp = explode(":", $elseIfSubArr[0], 2);$content = explode("}", $temp[1], 2);
				         $strElseIf0 = $content[0];
						 $temp1 = strpos($elseIfSubArr[0],"}")+strlen("}");$temp2 = strlen($elseIfSubArr[0])+1;
				         $strElseIfThen0 = substr($elseIfSubArr[0],$temp1,$temp2-$temp1);
				         @eval("if($strElseIf0){\$resultStr=\"$strElseIfThen0\";\$elseIfFlag=true;}");
						 $Mark_Text=str_replace($arr[0][$i],$resultStr,$Mark_Text);
					 }else{
                         if(strpos($strThen, $ifRule3) !== FALSE) {
					         $elsearray = explode($ifRule3, $strThen);
					         $strThen1 = $elsearray[0];
					         $strElse1 = $elsearray[1];
					         @eval("if($strIf){\$ifFlag=true;}else{\$ifFlag=false;}");
					         if ($ifFlag){
								 $Mark_Text=str_replace($arr[0][$i],$strThen1,$Mark_Text);
							 }else{
								 $Mark_Text=str_replace($arr[0][$i],$strElse1,$Mark_Text);
							 }
				         } else {
				             @eval("if  ($strIf) { \$ifFlag=true;} else{ \$ifFlag=false;}");
					         if ($ifFlag){
								 $Mark_Text=str_replace($arr[0][$i],$strThen,$Mark_Text);
							 }else{
								 $Mark_Text=str_replace($arr[0][$i],"",$Mark_Text);
							 }
			             }
					 }
			     }
		}
		return $Mark_Text;
	}

	//查找数组指定元素
	protected function arr_val($key,$array)
	{
		     foreach ($array as $v) {
                  if(strtolower($v[1])==$key){
                       return $v[2];
					   break;
				  }
			 }
			 return NULL;
	}
}
