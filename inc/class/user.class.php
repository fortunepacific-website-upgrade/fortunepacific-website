<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

class user{
	public static function user_reg_edit($name, $notnull, $class, $row=''){
		global $c;
		$result='';
		$notnull=$notnull?' notnull=""':'';
		switch($name){
			case 'Gender':
				$result="<div class='box_select'>".html::form_select($c['gender'], $name, $row['Gender'], '', '', '--'.$c['lang_pack']['user']['setting']['please'].'--', $notnull)."</div>";
				break;
			case 'Age':
				$result=user::form_edit($row, 'text', $name, 10, 3, "class='{$class} amount'".$notnull);
				break;
			case 'NickName':
				$result=user::form_edit($row, 'text', $name, 30, 50, "class='{$class}'".$notnull);
				break;
			case 'Telephone':
				$result=user::form_edit($row, 'text', $name, 30, 20, "class='{$class} amount' format='Telephone'".$notnull);
				break;
			case 'Fax':
				$result=user::form_edit($row, 'text', $name, 30, 20, "class='{$class} amount' format='Fax'".$notnull);
				break;
			case 'Birthday':
				$row[$name]=@date('Y-m-d',$row[$name]);
				$result=user::form_edit($row, 'text', $name, 30, 20, "class='{$class}'".$notnull);
				break;
			case 'Facebook':
				$result=user::form_edit($row, 'text', $name, 30, 50, "class='{$class}'".$notnull);
				break;
			case 'Company':
				$result=user::form_edit($row, 'text', $name, 30, 50, "class='{$class}'".$notnull);
				break;
		}
		return $result;
	}
	
	public static function form_edit($row, $type='text', $name, $size=0, $max=0, $attr=''){
		global $c;
		$result='';
		$value=$row[$name];
		if($type=='text'){
			if($name=='Birthday'){
				$result.="<input type='text' name='{$name}' value='{$value}' size='{$size}' maxlength='{$max}' placeholder='2015-01-01' {$attr}><span class='notes_icon' content='{/user.reg_set.date_tips/}'></span></span>";
			}else{
				$result.="<input type='text' name='{$name}' value='{$value}' size='{$size}' maxlength='{$max}' {$attr}>";
			}
			$attr=='notnull' && $result.=' <font class="fc_red">*</font>';
		}elseif($type=='textarea'){
			$result.="<textarea name='{$name}' {$attr}>{$value}</textarea>";
		}
		return $result;
	}
	
	public static function operation_log($userid, $log){
		global $c;
		if($_SESSION['Manage']['UserId']==-1){return;}
		$data=array();
		$_GET && $data['get']=str::str_code(str::str_cut(str::str_code(ary::ary_remove_password(ary::ary_filter_empty($_GET)), 'stripslashes'), 100), 'str_replace', array(array("\r", "\n"), ' '), 0);
		$_POST && $data['post']=str::str_code(str::str_cut(str::str_code(ary::ary_remove_password(ary::ary_filter_empty($_POST)), 'stripslashes'), 100), 'str_replace', array(array("\r", "\n"), ' '), 0);
		db::insert('user_operation_log', array(
				'UserId'	=>	$userid,
				'Log'		=>	addslashes($log),
				'Data'		=>	addslashes(str::json_data($data)),
				'AccTime'	=>	$c['time'],
				'Ip'		=>	ly200::get_ip()
			)
		);
	}
}