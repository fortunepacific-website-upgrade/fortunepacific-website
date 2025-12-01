<?php
/*
Powered by ueeshop.com		http://www.ueeshop.com
广州联雅网络科技有限公司		020-83226791
*/

class mta_module{
	public static function api_get_data(){
		global $c;
		manage::check_permit('mta', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		ksort($_POST);
		$save_dir=$c['tmp_dir'].'manage/';
		$filename=$p_Action.'-'.md5(implode('&', $_POST)).'.json';
		if(!file::check_cache($c['root_path'].$save_dir.$filename, 0)){//文件是否存在、是否到更新时间
			unset($_POST['do_action']);
			$result=ly200::api($_POST, $c['ApiKey'], $c['api_url']);
			if($result['ret']==1){
				@file::write_file($save_dir, $filename, str::json_data($result));
			}else{
				ly200::e_json('', 0);
			}
		}
		echo @file_get_contents($c['root_path'].$save_dir.$filename);
		exit;
	}
}
?>