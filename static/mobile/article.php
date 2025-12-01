<?php !isset($c) && exit();?>
<?php
//$article_category_row=str::str_code(db::get_all('article_category', 'CateId not in(1)', "CateId, Category{$c['lang']}", 'CateId asc'));
$art_row=str::str_code(db::get_all('article', 'CateId not in(1)', "AId, CateId, Title{$c['lang']}"));
$article_ary=array();
foreach($art_row as $v){
	$article_ary[$v['CateId']][$v['AId']]=$v;
}

$PageUrl=$_GET['PageUrl'];
$AId=(int)$_GET['AId'];
if($PageUrl){
	$article_row=str::str_code(db::get_one('article', "PageUrl='$PageUrl'"));
	$AId=$article_row['AId'];
}elseif($AId){
	$article_row=str::str_code(db::get_one('article', "AId='$AId'"));
}

if(!$article_row){
	js::location('/404.html');
	exit;
}

$Title=$article_row['Title'.$c['lang']];
$CateId=(int)$article_row['CateId'];
$article_content_row=db::get_one('article_content', "AId='$AId'");
$article_category_row=str::str_code(db::get_all('article', "CateId='$CateId'"));

//SEO
//$category_row=db::get_one('article_category', "CateId='$CateId'", "CateId, Category{$c['lang']}");
$spare_ary=array(
	'SeoTitle'		=>	$Title,//.','.$category_row['Category'.$c['lang']]
	'SeoKeyword'	=>	$Title,//.','.$category_row['Category'.$c['lang']]
	'SeoDescription'=>	$Title//.','.$category_row['Category'.$c['lang']]
);
?>
<!DOCTYPE HTML>
<html lang="us">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta content="telephone=no" name="format-detection" />
<?=web::seo_meta($article_row, $spare_ary);?>
<?php include $c['mobile']['theme_path'].'/inc/resource.php';?>
</head>

<body class="lang<?=$c['lang'];?>">
<?php include $c['theme_path'].'/inc/header.php';//头部 ?>

<div class="wrapper">
    <div class="page_title art_page_title"><?=$Title;?></div>
    <div class="art_content pd_content"><?=str::clear_html(str::str_code($article_content_row['Content'.$c['lang']], 'htmlspecialchars_decode'));?></div>
    <div class="oth_art_list">
    	<?php foreach ($article_category_row as $k=>$v){?>
    	<div class="item"><a href="<?=web::get_url($v, 'article');?>"><?=$v['Title'.$c['lang']];?></a></div>
        <?php }?>
    </div>
</div><!-- end of .wrapper -->
<?php include $c['theme_path'].'/inc/footer.php';//底部?>
<script>$(function(){SetMContent(".wrapper .art_content");})</script>
</body>
</html>