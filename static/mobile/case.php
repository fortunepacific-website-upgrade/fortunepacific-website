<?php !isset($c) && exit();?>
<?php
$no_page_url=web::get_query_string(str::query_string('m, a, CateId, page'));

$CateId=(int)$_GET['CateId'];
$where=1;

$page_count=10;
if($CateId){
	$where.=" and ".category::get_search_where_by_CateId($CateId, 'case_category');
	$case_category_row=db::get_one('case_category', "CateId='{$CateId}'");
}
$page=(int)$_GET['page'];
$case_list_row=str::str_code(db::get_limit_page('`case`', $where, '*', $c['my_order'].'CaseId desc', $page, $page_count));
$Column = '<a href="/case/">'.$c['lang_pack']['case'].'</a>';
$Column .= web::get_web_position($case_category_row, 'case_category');

$page_type = 'case';
$list_row = $case_list_row;
$category_row = $case_category_row;
include('list.php');