<?php !isset($c) && exit();?>
<?php
$no_page_url=web::get_query_string(str::query_string('m, a, CateId, Ext, page'));
$Ext=(int)$_GET['Ext'];
$CateId=(int)$_GET['CateId'];

$Column=$c['lang_pack']['products'];
$page_count=10;//显示数量
$where = $c['where']['products'];
if(substr_count($_SERVER['REQUEST_URI'], '/search/')){//产品搜索无筛选
	$Keyword=$_GET['Keyword'];
	$where.=" and (Name{$c['lang']} like '%$Keyword%' or Number like '%$Keyword%')";
	$Column=str_replace('xxx', $Keyword, $c['lang_pack']['key_count']);
}

if($CateId){
	$UId=category::get_UId_by_CateId($CateId);
	$where.=" and (".category::get_search_where_by_CateId($CateId).' or '.category::get_search_where_by_ExtCateId($CateId).')';
	$category_row=db::get_one('products_category', "CateId='$CateId'");
	$Column = '<a href="/catalog/">'.$c['lang_pack']['products'].'</a>';
	$Column .= web::get_web_position($category_row, 'products_category', substr($c['lang'], 1));
	$TopCateId = $CateId;
	if($category_row['UId']!='0,'){
		$TopCateId=category::get_FCateId_by_UId($category_row['UId']);
		$TopCategory_row=str::str_code(db::get_one('products_category', "CateId='$TopCateId'"));
	}
}
if($Ext){
	$Ext=($Ext<1 || $Ext>3)?1:$Ext;
	$where.=$c['pro_ext_where'][$Ext];
}
$page=(int)$_GET['page'];
$products_list_row=str::str_code(db::get_limit_page('products', $where, '*', $c['my_order'].'ProId desc', $page, $page_count));
(!$page || $page>$products_list_row[3]) && $page=1;
$Column = sprintf($Column, ($page_count*($page-1)+1), $page_count*($page-1)+count($products_list_row[0]), $products_list_row[1]);
$page_type = 'products';
$list_row = $products_list_row;
include('list.php');