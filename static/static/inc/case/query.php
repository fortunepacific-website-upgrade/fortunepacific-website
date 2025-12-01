<?php !isset($c) && exit();?>
<?php
if ($m=='case-detail'){//详细页查询
	$CaseId=(int)$_GET['CaseId'];
	$case_row=str::str_code(db::get_one('`case`', "CaseId='$CaseId'"));
	if(!$case_row){
		web::get_theme_file('404.php');
		exit;
	}
	$Name=$case_row['Name'.$c['lang']];
	$CateId=(int)$case_row['CateId'];
	$CateId && $category_row=str::str_code(db::get_one('case_category', "CateId='$CateId'"));
	$case_description_row=db::get_one('case_description', "CaseId='$CaseId'");
	$TopCateId = $category_row['CateId'];
	//产品分类
	if($category_row['UId']!='0,'){
		$TopCateId=category::get_top_CateId_by_UId($category_row['UId']);
		$TopCategory_row=str::str_code(db::get_one('case_category', "CateId='$TopCateId'"));
	}
}else{//列表页
	$no_page_url=web::get_query_string(str::query_string('m, a, CateId, page'));
	$CateId=(int)$_GET['CateId'];
	$where=1;
	$Column=$c['lang_pack']['case'];
	$page_count=$page_count?$page_count:20;
	if($CateId){
		$where.=" and ".category::get_search_where_by_CateId($CateId, 'case_category');
		$seo_meta_row=$case_category_row=db::get_one('case_category', "CateId='{$CateId}'");
		$TopCateId = $case_category_row['CateId'];
		$case_category_row['UId']!='0,' && $TopCateId=category::get_top_CateId_by_UId($case_category_row['UId']);
		if($case_category_row['UId']!='0,'){
			$TopCategory_row=str::str_code(db::get_one('case_category', "CateId='$TopCateId'"));
		}
		$Column=$case_category_row['Category'.$c['lang']];
	}else{
		$seo_meta_row=db::get_one('meta', "Type='case_list'");
	}
	$page=(int)$_GET['page'];
	$case_list_row=str::str_code(db::get_limit_page('`case`', $where, '*', $c['my_order'].'CaseId desc', $page, $page_count));
}