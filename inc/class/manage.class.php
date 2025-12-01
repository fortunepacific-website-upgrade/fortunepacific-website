<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

class manage{
	public static function language($html){
		$replace=array();
		preg_match_all("/{\/(.*)\/}/isU", $html, $lang_ary);
		foreach($lang_ary[1] as $v){
			$replace[0][]="{/$v/}";
			$replace[1][]=manage::get_language($v);
		}
		return (count($lang_ary[1])==1 && is_array($replace[1][0]))?$replace[1][0]:str_replace($replace[0], $replace[1], $html);
	}

	public static function get_language($language){
		global $c;
		return @eval('return $c[\'manage\'][\'language\'][\''.str_replace('.', '\'][\'', $language).'\'];');
	}

	public static function load_language($module){
		global $c;
		include("static/lang/{$_SESSION['Manage']['Language']}.php");
		is_file("static/lang/{$_SESSION['Manage']['Language']}/$module.php") && $c['manage']['language'][$module]=@include("static/lang/{$_SESSION['Manage']['Language']}/$module.php");
	}

	public static function keywords_filter(){
		global $c;
		@include_once($c['root_path'].'/manage/static/inc/filter.library.php');
		@include_once($c['root_path'].'/inc/un_filter_keywords.php');
		$filter_keywords_ary=$FilterKeyArr['Keyword'];
		$un_filter_keywords_ary=(array)@str::str_code($un_filter_keywords, 'strtolower');
		($ary && !@is_array($ary)) && $ary=(array)$ary;
		if((int)count($ary)){
			$filter_ary=$ary;
		}else{
			$filter_ary=$_POST;
			unset($filter_ary['do_action'], $filter_ary['PicPath'], $filter_ary['FilePath'], $filter_ary['UId'], $filter_ary['ColorPath'], $filter_ary['Number']);
		}
		$str=' '.@implode(' -- ', $filter_ary).' ';
		$key='';
		$in=0;
		foreach($filter_keywords_ary as $k => $v){
			if(@count($un_filter_keywords_ary) && @in_array(strtolower(trim($v)), $un_filter_keywords_ary)) continue;
			if(@substr_count(strtolower(stripslashes($str)), strtolower($v))){
				$key.=($in?' ,':'').$v;
				$in++;
			}
		}
		unset($filter_ary);
		return array(0=>$in, 1=>$key);
	}

	public static function config_operaction($cfg, $global){
		foreach($cfg as $k=>$v){
			db::insert_update('config', "GroupId='$global' and Variable='$k'", array(
					'GroupId'	=>	$global,
					'Variable'	=>	$k,
					'Value'		=>	$v
				)
			);
		}
	}

	public static function operation_log($log){
		global $c;
		if($_SESSION['Manage']['UserId']==-1){return;}
		$data=array();
		$_GET && $data['get']=str::str_code(str::str_cut(str::str_code(ary::ary_remove_password(ary::ary_filter_empty($_GET)), 'stripslashes'), 100), 'str_replace', array(array("\r", "\n"), ' '), 0);
		$_POST && $data['post']=str::str_code(str::str_cut(str::str_code(ary::ary_remove_password(ary::ary_filter_empty($_POST)), 'stripslashes'), 100), 'str_replace', array(array("\r", "\n"), ' '), 0);
		$do_action=@explode('.', (isset($_POST['do_action'])?$_POST['do_action']:$_GET['do_action']));
		db::insert('manage_operation_log', array(
				'UserId'	=>	$_SESSION['Manage']['UserId'],
				'UserName'	=>	addslashes($_SESSION['Manage']['UserName']),
				'Module'	=>	array_shift($do_action),
				'Ip'		=>	ly200::get_ip(),
				'Log'		=>	addslashes($log),
				'Data'		=>	addslashes(str::json_data($data)),
				'AccTime'	=>	$c['time']
			)
		);
	}

	public static function ueeseo_get_data($action, $data=array()){
		global $c;
		$data=(array)$data;
		$data['Action']=$action;
		$result=ly200::api($data, $c['ApiKey'], $c['ueeseo_url']);
		$data['do_action']=='' && $result['msg']=(array)$result['msg'];
		return $result;
	}

	public static function google_translation($text, $target='', $source=''){
		global $c;
		if($target==''){return $text;}
		$source=='' && $source=$c['manage']['language_default'];
		$data=array(
			'ApiName'	=>	'google',
			'Action'	=>	'translation',
			'Text'		=>	$text,
			'Source'	=>	$source,
			'Target'	=>	$target
		);
		return ly200::api($data, $c['ApiKey'], $c['sync_url']);
	}

	public static function google_get_keyword_ideas($keyword){
		global $c;
		if($keyword==''){return array();}
		$data=array(
			'ApiName'	=>	'google',
			'Action'	=>	'get_keyword_ideas',
			'Keyword'	=>	$keyword
		);
		return ly200::api($data, $c['ApiKey'], $c['sync_url']);
	}

	public static function time_between($start_time, $end_time){
		if(date('H:i:s', $start_time)=='00:00:00' && date('H:i:s', $end_time)=='00:00:00'){
			$format='Y-m-d';
			$separator=' ~ ';
		}elseif(date('s', $start_time)=='00' && date('s', $end_time)=='00'){
			$format='Y-m-d H:i';
			$separator='<br>~<br>';
		}else{
			$format='Y-m-d H:i:s';
			$separator='<br>~<br>';
		}
		return date($format, $start_time).$separator.date($format, $end_time);
	}

	public static function form_edit($row, $type='text', $name, $size=0, $max=0, $attr=''){
		global $c;
		$result='';
		foreach($c['manage']['config']['Language'] as $k=>$v){
			if(substr($name, -2, 2)=='[]'){
				$field_name=substr($name, 0, -2).'_'.$v;
				$value=isset($row[$field_name])?$row[$field_name]:'';
				$field_name.='[]';
			}else{
				$field_name=$name.'_'.$v;
				$value=isset($row[$field_name])?$row[$field_name]:'';
			}
			$result.='<div class="tab_txt tab_txt_'.$v.'" '.($c['manage']['config']['LanguageDefault']==$v?'style="display:block;"':'').' lang="'.$v.'">';
			if($type=='text'){
				$value=htmlspecialchars(htmlspecialchars_decode($value), ENT_QUOTES);
				$result.="<input type='text' name='$field_name' value='$value' class='box_input' size='$size' ".($max ? "maxlength='$max'" : '')." $attr>";
				$attr=='notnull' && $result.=' <font class="fc_red">*</font>';
			}elseif($type=='textarea'){
				$result.="<span><textarea name='$field_name' class='box_textarea' $attr>$value</textarea></span>";
			}else{
				$result.="<div class='fl'></div>".manage::editor($field_name, $value);
			}
			$result.='</div>';
		}
		return $result;
	}

	public static function editor($name, $content=''){
		global $c;
		$html='<div class="blank6"></div>';
		$html.="<textarea id='{$name}' name='{$name}'>".htmlspecialchars_decode($content)."</textarea>";
		$html.='<script type="text/javascript">';
		$html.="CKEDITOR.replace('{$name}', {'language':'".($c['manage']['config']['ManageLanguage']=="cn"?"zh-cn":$c['manage']['config']['ManageLanguage'])."'});";
		$html.='</script>';
		return $html;
	}

	public static function html_tab_button($class='',$lang_mode=0){
		global $c;
		$default=$c['manage']['config']['LanguageDefault'];
		$html='';
		$html.='<dl class="tab_box_row'.(count($c['manage']['config']['Language'])==1?' hide':'').($class?" {$class}":'').'">';
			$html.="<dt><span>{/language.$default/}</span><i></i></dt>";
			$html.='<dd class="drop_down">';
			foreach($c['manage']['config']['Language'] as $k=>$v){
				$html.='<a class="tab_box_btn item"'.($default==$v?' style="display:none;"':'').' data-lang="'.$v.'"><span>'.($lang_mode?$c['manage']['language']['language'][$v]:'{/language.'.$v.'/}').'</span><i></i></a>';
			}
			$html.='</dd>';
			$html.='<dd class="tips">{/error.supplement_lang/}</dd>';
		$html.='</dl>';
		return $html;
	}

	public static function database_language_operation($table, $where, $input_field){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$column_ary=db::get_table_fields($table, 1);
		$data=array();
		foreach($c['manage']['language_web'] as $k=>$v){
			foreach($input_field as $k2=>$v2){
				$field_name=$k2.'_'.$v;
				$data[$field_name]=${'p_'.$field_name};
				if(!in_array($field_name, $column_ary)){
					$f=$c['manage']['field_ext'][$v2];
					db::query("alter table {$table} add {$field_name} {$f}");
				}
			}
		}
		db::update($table, $where, $data);
	}

	public static function turn_on_language_database_operation($default_language, $language){
		global $c;
		$langs=$c['manage']['config']['Language'];
		$diff=@array_diff($language, $langs);
		$default=@in_array($default_language, $diff)?$c['manage']['config']['LanguageDefault']:$default_language;
		if(!count($diff)) return;
		$tables=$c['manage']['langs_table'];
		foreach($tables as $tb=>$field){
			$column_ary=db::get_table_fields($tb, 1);
			$update_sql='';
			foreach($diff as $k=>$v){
				foreach($field as $k2=>$v2){
					$field_name=$k2.'_'.$v;
					if(!in_array($field_name, $column_ary)){
						$update_sql.=($update_sql!=''?',':'')."`$field_name`=`{$k2}_{$default}`";
						$f=$c['manage']['field_ext'][$v2];
						db::query("alter table {$tb} add {$field_name} {$f}");
					}
				}
			}
			$update_sql!='' && db::query("update $tb set $update_sql");
		}
	}

	public static function check_permit($module, $return_type=0){
		global $c;
		if((int)$c['FunVersion']==0){return true;}
		$seo_module_array = array('overview', 'keyword', 'keyword_track', 'article', 'mobile', 'links', 'blog', 'ads');
		if((int)$_SESSION['Manage']['GroupId']!=1 && !in_array($module, $_SESSION['Manage']['Permit']) || (in_array(str_replace("seo.","",$module),$seo_module_array) && !$c['manage']['config']['IsSEO'])){
			if($return_type==0){
				return false;
			}elseif($return_type==1){
				ly200::e_json('no_permit');
			}else{
				js::location('./', '', '.top');
			}
		}
		return true;
	}

	public static function multi_img($box_id, $input_name, $picpath=''){
		global $c;
		$is_file=is_file($c['root_path'].$picpath)?1:0;
		$html='<div class="multi_img upload_file_multi" id="'.$box_id.'">';
			$html.='<dl class="img '.($is_file?'isfile':'').'" num="0">';
				$html.='<dt class="upload_box preview_pic">';
					$html.='<input type="button" id="PicUpload" class="btn_ok upload_btn" name="submit_button" value="{/global.upload_pic/}" tips="" />';
					$html.='<input type="hidden" name="'.$input_name.'" value="'.$picpath.'" data-value="" save="'.$is_file.'" />';
				$html.='</dt>';
				$html.='<dd class="pic_btn">';
					$html.='<a href="javascript:;" class="edit"><i class="icon_edit_white"></i></a>';
					$html.='<a href="'.($is_file?$picpath:'javascript:;').'" class="zoom" target="_blank"><i class="icon_search_white"></i></a>';
					$html.='<a href="javascript:;" class="del" rel="del"><i class="icon_del_white"></i></a>';
				$html.='</dd>';
			$html.='</dl>';
		$html.='</div>';
		return $html;
	}

	public static function multi_img_item($input_name, $picpath='', $num, $s_picpath=''){
		global $c;
		$is_file=is_file($c['root_path'].$picpath)?1:0;
		$html.='<dl class="img '.($is_file?'isfile':'').'" num="'.$num.'">';
			$html.='<dt class="upload_box preview_pic">';
				$html.='<input type="button" id="PicUpload_'.$num.'" class="btn_ok upload_btn" name="submit_button" value="{/global.upload_pic/}" tips="" />';
				$html.='<input type="hidden" name="'.$input_name.'" value="'.$picpath.'" data-value="'.$s_picpath.'" save="'.$is_file.'" />';
			$html.='</dt>';
			$html.='<dd class="pic_btn">';
				$html.='<a href="javascript:;" class="edit"><i class="icon_edit_white"></i></a>';
				$html.='<a href="'.($is_file?$picpath:'javascript:;').'" class="zoom" target="_blank"><i class="icon_search_white"></i></a>';
				$html.='<a href="javascript:;" class="del" rel="del"><i class="icon_del_white"></i></a>';
			$html.='</dd>';
		$html.='</dl>';
		return $html;
	}
}
?>