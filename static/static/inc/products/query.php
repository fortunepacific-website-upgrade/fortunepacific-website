<?php !isset($c) && exit();?>
<?php
if ($m=='goods'){//详细页查询
	$ProId=(int)$_GET['ProId'];
	$where = $c['where']['products'];
	$where.=" and ProId='$ProId'";
	$products_row=db::get_one('products', "ProId='$ProId'");
	if(!$products_row){
		web::get_theme_file('404.php');
		exit;
	}
	
	//产品显示设置
	$show_row=str::str_code(db::get_one('config', "GroupId='products' and Variable='Config'"));
	$show_ary=str::json_data($show_row['Value'], 'decode');
	
	$Name=$products_row['Name'.$c['lang']];
	$CateId=(int)$products_row['CateId'];
	$CateId && $category_row=db::get_one('products_category', "CateId='$CateId'");
	$products_description_row=db::get_one('products_description', "ProId='$ProId'");
	$TopCateId = $SecCateId = $category_row['CateId'];
	//产品分类
	if($category_row['UId']!='0,'){
		$TopCateId=category::get_top_CateId_by_UId($category_row['UId']);
		$SecCateId=$category_row['Dept']==3?category::get_FCateId_by_UId($category_row['UId']):$category_row['CateId'];
		$TopCategory_row=db::get_one('products_category', "CateId='$TopCateId'");
		$SecCategory_row=db::get_one('products_category', "CateId='$SecCateId'");
	}
	$UId_ary=@explode(',', $category_row['UId']);
	
	//产品属性
	$products_attr=str::str_code(db::get_all('products_attribute', 1, "AttrId, Name{$c['lang']}, CartAttr, ColorAttr, Value{$c['lang']}", $c['my_order'].'AttrId asc'));
	$all_attr_ary=array();
	foreach((array)$products_attr as $k=>$v){
		$v['Value'.$c['lang']]=explode("\r\n",$v['Value'.$c['lang']]);
		$all_attr_ary[$v['AttrId']]=$v;
	}
	$AttrValue=array();
	
	//SEO
	$products_seo_row=str::str_code(db::get_one('products_seo', "ProId='$ProId'"));
	$spare_ary=array(
		'SeoTitle'		=>	$Name.','.$category_row['Category'.$c['lang']],
		'SeoKeyword'	=>	$Name.','.$category_row['Category'.$c['lang']],
		'SeoDescription'=>	$Name.','.$category_row['Category'.$c['lang']].','.$TopCategory_row['Category'.$c['lang']].','.$SecCategory_row['Category'.$c['lang']]
	);
	$background = db::get_value('config',"GroupId='inquiry' AND Variable='inquiry_button'",'Value');
}else{//列表页查询
	$no_page_url=web::get_query_string(str::query_string('m, a, CateId, Ext, page'));
	
	$Ext=(int)$_GET['Ext'];
	$CateId=(int)$_GET['CateId'];
	
	$Column=$c['lang_pack']['products'];
	$where = $c['where']['products'];
	$page_count=$page_count?$page_count:8;//显示数量
	if(substr_count($_SERVER['REQUEST_URI'], '/search/')){//产品搜索无筛选
		$Keyword=$_GET['Keyword'];
		$where.=" and (Name{$c['lang']} like '%$Keyword%' or Number like '%$Keyword%')";
		$Column=str_replace('xxx', $Keyword, $c['lang_pack']['key_count']);
	}

	
	
	if($CateId){
		$UId=category::get_UId_by_CateId($CateId);
		$where.=" and (".category::get_search_where_by_CateId($CateId).' or '.category::get_search_where_by_ExtCateId($CateId).')';
		$seo_meta_row=$category_row=db::get_one('products_category', "CateId='$CateId'");
		$TopCateId = $category_row['CateId'];
		if($category_row['UId']!='0,'){
			$TopCateId=category::get_top_CateId_by_UId($category_row['UId']);
			$SecCateId=$category_row['Dept']==3?category::get_FCateId_by_UId($category_row['UId']):$category_row['CateId'];
			$TopCategory_row=db::get_one('products_category', "CateId='$TopCateId'");
			$SecCategory_row=db::get_one('products_category', "CateId='$SecCateId'");
		}
		$Column=$category_row['Category'.$c['lang']];
		$cate_desc = db::get_one('products_category_description', "CateId='$CateId'", 'CateId, Description'.$c['lang']);
	}else{
		$seo_meta_row=db::get_one('meta', "Type='products_list'");
	}
	if($Ext){
		$Ext=($Ext<1 || $Ext>3)?1:$Ext;
		$where.=$c['pro_ext_where'][$Ext];
	}
	$page=(int)$_GET['page'];
	$products_list_row=str::str_code(db::get_limit_page('products', $where, '*', $c['my_order'].'ProId desc', $page, $page_count));
	(!$page || $page>$products_list_row[3]) && $page=1;
	if (substr_count($_SERVER['REQUEST_URI'], '/search/')){
		$Column=sprintf($Column, $products_list_row[1]?$products_list_row[4]+1:0, $products_list_row[4]+count($products_list_row[0]), $products_list_row[1]);
	}
}