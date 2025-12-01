<?php !isset($c) && exit();?>
<?php 
$InfoId=(int)$_GET['InfoId'];
$info_row=db::get_one('info', "InfoId='{$InfoId}'");

!$info_row && js::back();

$info_contents_row=db::get_one('info_content', "InfoId='{$info_row['InfoId']}'", "Content{$c['lang']}");
$info_category_row=db::get_one('info_category', "CateId='{$info_row['CateId']}'");
$Column = '<a href="/info/">'.$c['lang_pack']['news'].'</a>';
$Column .= web::get_web_position($info_category_row, 'info_category');
?>
<!DOCTYPE HTML>
<html lang="us">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta content="telephone=no" name="format-detection" />
<?=web::seo_meta($info_row, $spare_ary);?>
<?php include $c['theme_path'].'/inc/resource.php';?>
</head>

<body>
<?php include $c['theme_path'].'/inc/header.php';//头部 ?>

<div class="wrapper">
   <div class="page_location"><?=$Column;?></div>
    <div class="page_title art_page_title"><?=$info_row['Title'.$c['lang']];?></div>
    <div class="art_content">
		<?=str::clear_html(str::str_code($info_contents_row['Content'.$c['lang']], 'htmlspecialchars_decode'));?>
    </div>
</div><!-- end of .wrapper -->
<?php include $c['theme_path'].'/inc/footer.php';//底部?>
<script>$(function(){SetMContent(".wrapper .art_content");})</script>
</body>
</html>