<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

class service_module{
	public static function chat_edit(){
		global $c;
		manage::check_permit('service.chat', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$p_CId=(int)$p_CId;
		$data=array(
			'Name'		=>	$p_Name,
			'Type'		=>	$p_Type,
			'PicPath'	=>	$p_PicPath,
			'Account'	=>	$p_Account
		);
		if($p_CId){
			db::update('chat', "CId='{$p_CId}'", $data);
			$log='修改在线客服: '.$p_Name;
		}else{
			db::insert('chat', $data);
			$log='添加在线客服: '.$p_Name;
		}
		manage::operation_log($log);
		ly200::e_json('', 1);
	}

	public static function chat_my_order(){
		global $c;
		manage::check_permit('service.chat', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$order=1;
		$sort_order=@array_filter(@explode(',', $g_sort_order));
		if($sort_order){
			$sql="update chat set MyOrder = case CId";
			foreach((array)$sort_order as $v){
				$sql.=" when $v then ".$order++;
			}
			$sql.=" end where CId in($g_sort_order)";
			db::query($sql);
		}
		manage::operation_log('批量在线客服排序');
		ly200::e_json('', 1);
	}

	public static function chat_del(){
		global $c;
		manage::check_permit('service.chat', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_CId=(int)$g_CId;
		$name=db::get_value('chat', "CId='{$g_CId}'", 'Name');
		db::delete('chat', "CId='{$g_CId}'");
		manage::operation_log('删除在线客服: '.$name);
		ly200::e_json('', 1);
	}
}
?>