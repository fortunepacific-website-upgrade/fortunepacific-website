<?php !isset($c) && exit();?>
<?php
if ($m=='info-detail'){//详细页查询
	$InfoId=(int)$_GET['InfoId'];
	$info_row=db::get_one('info', "InfoId='{$InfoId}'");
	!$info_row && js::back();
	$CateId=$info_row['CateId'];
	$info_contents_row=db::get_one('info_content', "InfoId='{$info_row['InfoId']}'", "Content{$c['lang']}");
	$info_category_row=db::get_one('info_category', "CateId='{$info_row['CateId']}'");
}else{//列表页查询
	$no_page_url=web::get_query_string(str::query_string('m, a, CateId, Ext, page'));
	$CateId=(int)$_GET['CateId'];
	$Column=$c['lang_pack']['news'];
	$where=1;
	if($CateId){
		$where.=" and ".category::get_search_where_by_CateId($CateId, 'info_category');
		$seo_meta_row=$info_category_row=db::get_one('info_category', "CateId='{$CateId}'");
		$Column=$info_category_row['Category'.$c['lang']];
	}else{
		$seo_meta_row=db::get_one('meta', "Type='info_list'");
	}
	$page_count=$page_count?$page_count:10;
	$page=(int)$_GET['page'];
	$info_list_row=str::str_code(db::get_limit_page('info', $where, '*', $c['my_order'].'InfoId desc', $page, $page_count));
}