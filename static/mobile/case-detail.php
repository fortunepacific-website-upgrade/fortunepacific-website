<?php !isset($c) && exit();?>
<?php
$CaseId=(int)$_GET['CaseId'];
$case_row=str::str_code(db::get_one('`case`', "CaseId='$CaseId'"));

if(!$case_row){
	js::location('/404.html');
	exit;
}

$Name=$case_row['Name'.$c['lang']];
$CateId=(int)$case_row['CateId'];
$CateId && $category_row=str::str_code(db::get_one('case_category', "CateId='$CateId'"));
$case_description_row=db::get_one('case_description', "CaseId='$CaseId'");

//产品分类
if($category_row['UId']!='0,'){
	$TopCateId=category::get_FCateId_by_UId($category_row['UId']);
	$TopCategory_row=str::str_code(db::get_one('case_category', "CateId='$TopCateId'"));
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
<?=web::seo_meta($case_row, $spare_ary);?>
<?php include $c['mobile']['theme_path'].'/inc/resource.php';?>
<?=ly200::load_static($c['mobile']['tpl_dir'].'css/goods.css', $c['mobile']['tpl_dir'].'js/goods.js');?>
</head>

<body class="lang<?=$c['lang'];?>">
<?php include $c['theme_path'].'/inc/header.php';//头部 ?>

<div class="wrapper">
    <div class="goods_pic">
    	<ul class="clean">
        	<?php
			for($i=0; $i<5; $i++){
				$pic=$case_row['PicPath_'.$i];
				if(!is_file($c['root_path'].$pic)) continue;
				$bigpic = img::get_small_img($pic, '500x500');
			?>
        	<li class="fl pic_box"><img src="<?=$bigpic;?>"><span></span></li>
            <?php }?>
        </ul>
    </div>
    
    <div class="goods_small_pic clean">
    	<div class="list clean">
        	<?php
			for($i=$sum=0; $i<5; $i++){
				$pic=$case_row['PicPath_'.$i];
				if(!is_file($c['root_path'].$pic)) continue;
				$pic = img::get_small_img($pic, '240x240');
				$sum++;
			?>
        	<div class="pic fl pic_box <?=$sum==1?'on':'';?>"><img src="<?=$pic;?>"><span></span></div>
            <?php }?>
        </div>
    </div>
    <div class="goods_info clean">
        <div class="name"><?=$Name;?></div>
    </div><!-- end of .goods_info -->
    
    <section class="detail_desc">
    	<div class="t">- <?=$c['lang_pack']['mobile']['case_details'];?></div>
        <div class="text">
        	<?=str::clear_html(str::str_code($case_description_row['Description'.$c['lang']], 'htmlspecialchars_decode'));?>
        </div>
    </section><!-- end of .detail_desc -->

</div><!-- end of .wrapper -->
<?php include $c['theme_path'].'/inc/footer.php';//底部?>
<script>$(function(){SetMContent(".wrapper .detail_desc .text");})</script>
</body>
</html>