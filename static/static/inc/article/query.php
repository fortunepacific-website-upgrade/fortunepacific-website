<?php !isset($c) && exit();?>
<?php
$PageUrl=$_GET['PageUrl'];
if($PageUrl){
	$article_row=db::get_one('article', "PageUrl='{$PageUrl}'");
}else{
	$AId=(int)$_GET['AId'];
	$article_row=db::get_one('article', "AId='{$AId}'");
}

if(!$article_row){
	web::get_theme_file('404.php');
	exit();
}

$article_contents_row=db::get_one('article_content', "AId='{$article_row['AId']}'", "Content{$c['lang']}");
$article_category_row=db::get_one('article_category', "CateId='{$article_row['CateId']}'", "Category{$c['lang']}");