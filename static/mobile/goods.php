<?php !isset($c) && exit();?>
<?php
$ProId=(int)$_GET['ProId'];
$products_row=str::str_code(db::get_one('products', "ProId='$ProId'"));

//产品显示设置
$show_row=str::str_code(db::get_one('config', "GroupId='products' and Variable='Config'"));
$show_ary=str::json_data($show_row['Value'], 'decode');

if(!$products_row){
	js::location("/");
	exit;
}

$Name=$products_row['Name'.$c['lang']];
$CateId=$TopCateId=(int)$products_row['CateId'];
$CateId && $category_row=str::str_code(db::get_one('products_category', "CateId='$CateId'"));
$products_description_row=str::str_code(db::get_one('products_description', "ProId='$ProId'"));

//产品分类
if($category_row['UId']!='0,'){
	$TopCateId=category::get_top_CateId_by_UId($category_row['UId']);
	$TopCategory_row=str::str_code(db::get_one('products_category', "CateId='$TopCateId'"));
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

$products_seo_row=str::str_code(db::get_one('products_seo', "ProId='$ProId'"));
?>
<!DOCTYPE HTML>
<html lang="us">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta content="telephone=no" name="format-detection" />
<?=web::seo_meta($products_seo_row, $spare_ary);?>
<?php
    include $c['mobile']['theme_path'].'/inc/resource.php';
    $c['mobile']['GoodsListTpl'] = '05';
?>
<?=ly200::load_static($c['mobile']['tpl_dir'].'goods/'.$c['mobile']['GoodsListTpl'].'/js/goods.js',$c['mobile']['tpl_dir'].'goods/'.$c['mobile']['GoodsListTpl'].'/css/style.css');?>
</head>

<body class="lang<?=$c['lang'];?>">
<?php include $c['theme_path'].'/inc/header.php';//头部 ?>

<div class="wrapper">
    <div class="position"><a href="/"><?=$c['lang_pack']['mobile']['products'];?></a><?=web::get_web_position($category_row, 'products_category', substr($c['lang'], 1));?></div>
    <?php
        include("{$c['mobile']['theme_path']}goods/{$c['mobile']['GoodsListTpl']}/template.php");
    ?>

</div><!-- end of .wrapper -->
<?php include $c['theme_path'].'/inc/footer.php';//底部?>
</body>
</html>
<style>
	#float_chat,.to_top{display: none !important;}
</style>