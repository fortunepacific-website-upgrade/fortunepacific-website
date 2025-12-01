<?php !isset($c) && exit();?>
<?php
$where = 1;
$CateId = (int)$_GET['CateId'];
$Column=$c['lang_pack']['procate'];
if ($CateId){
	$UId = category::get_UId_by_CateId($CateId);
	$UId && $where .= " and UId='$UId'";
	$category_row=db::get_one('products_category', "CateId='$CateId'");
	$Column = '<a href="/catalog/">Product</a>';
	$Column .= web::get_web_position($category_row, 'products_category');
}
$allcate_row=str::str_code(db::get_all('products_category', $where, "CateId,UId,Category{$c['lang']},PicPath",  $c['my_order'].'CateId asc'));
$allcate_ary=array();
foreach($allcate_row as $k=>$v){
	$allcate_ary[$v['UId']][]=$v;
}
?>
<!DOCTYPE HTML>
<html lang="us">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta content="telephone=no" name="format-detection" />
<?=web::seo_meta();?>
<?php include $c['theme_path'].'/inc/resource.php';?>
<?=ly200::load_static($c['mobile']['tpl_dir'].'css/catalog.css', $c['mobile']['tpl_dir'].'js/catalog.js');?>
</head>

<body>
<?php include $c['theme_path'].'/inc/header.php';//头部 ?>

<div class="wrapper">
	<div class="page_title">
    	<div class="pos clean"><div class="fl column"><?=$Column;?></div></div>
    </div>
	<div class="category_list">
    	<div class="item">
        	<div class="cate_1 clean">
                <div class="name"><a href="/products/"><?=$c['lang_pack']['mobile']['view_all'];?></a></div>
            </div><!-- end of .cate_1 -->
        </div><!-- end of .item -->
        <?php foreach ($allcate_ary[$UId?$UId:'0,'] as $k=>$v){?>
        <div class="item">
        	<div class="cate_1 clean <?=$allcate_ary["{$v['UId']}{$v['CateId']},"]?'lower':'';?>">
                <div class="name">
                	<?php if (!$allcate_ary["{$v['UId']}{$v['CateId']},"]){?>
                    	<a href="<?=web::get_url($v, 'products_category')?>"><?=$v['Category'.$c['lang']];?></a>
                    <?php }else{?>
                    	<?=$v['Category'.$c['lang']];?>
                    <?php }?>
                </div>
            </div><!-- end of .cate_1 -->
            <div class="cate_2">
            	<?php
				if ($allcate_ary["{$v['UId']}{$v['CateId']},"]){
					foreach ($allcate_ary["{$v['UId']}{$v['CateId']},"] as $kk=>$vv){
						//是否有三级
						if ($allcate_ary["{$vv['UId']}{$vv['CateId']},"]){
							//$url = "/catalog/c_{$vv['CateId']}/";
							$url = web::get_url($vv, 'products_category');
						}else{
							$url = web::get_url($vv, 'products_category');
						}
					?>
					<a href="<?=$url;?>" class="i">- <?=$vv['Category'.$c['lang']]?></a>
				<?php }
				}?>
            </div>
        </div><!-- end of .item -->
        <?php }?>
    </div><!-- end of .category_list -->
</div><!-- end of .wrapper -->

<?php include $c['theme_path'].'/inc/footer.php';//头部?>
</body>
</html>