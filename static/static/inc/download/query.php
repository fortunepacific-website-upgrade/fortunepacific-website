<?php !isset($c) && exit();?>
<?php 
$no_page_url=web::get_query_string(str::query_string('m, a, CateId, page'));

$CateId=(int)$_GET['CateId'];
if($c['FunVersion']>=1){
	if((int)$_SESSION['ly200_user']['UserId']){
		$where=1;
	}else{
		$where="IsMember=0";
	}
}else{
	$where=1;
}
$page_count=10;
$Column=$c['lang_pack']['download'];
if($CateId){
	$where.=" and ".category::get_search_where_by_CateId($CateId, 'download_category');
	$download_category_row=db::get_one('download_category', "CateId='{$CateId}'");
	$Column=$download_category_row['Category'.$c['lang']];
}
$page=(int)$_GET['page'];
$download_list_row=str::str_code(db::get_limit_page('download', $where, '*', $c['my_order'].'DId desc', $page, $page_count));