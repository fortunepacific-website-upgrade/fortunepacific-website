<?php 
	$all_thide_row = db::get_all('products_category','Dept=3','CateId,Dept,UId');
	// print_r('<pre>');
	// print_r($all_thide_row);
	// print_r('</pre>');
	foreach ($all_thide_row as $k => $v) {
		$UId = $v['UId'];
		$new_uid = str_replace('27,','',$UId);
		db::update('products_category', "CateId = '{$v['CateId']}' ",array(
				'UId'	=>	$new_uid,
				'Dept'	=>	2
			)
		);	
	}
?>