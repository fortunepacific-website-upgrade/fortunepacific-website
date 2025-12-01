<?php !isset($c) && exit();?>
<!DOCTYPE HTML>
<html lang="us">
<head>
<meta charset="utf-8">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<meta name="format-detection" content="telephone=no,email=no">
<meta content="fullscreen=yes,useHistoryState=yes,transition=yes" name="App-Config">
<meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">


<?=web::seo_meta();?>
<?php include $c['mobile']['theme_path'].'/inc/resource.php';?>
<?=ly200::load_static($c['mobile']['tpl_dir'].'js/swipe.js', $c['mobile']['tpl_dir'].'index/'.$c['mobile']['HomeTpl'].'/css/style.css', $c['mobile']['tpl_dir'].'index/'.$c['mobile']['HomeTpl'].'/js/index.js');?>
</head>
<body class="lang<?=$c['lang'];?>">
<?php include $c['theme_path'].'/inc/header.php';//头部 ?>

<?php include $c['theme_path'].'/index/'.$c['mobile']['HomeTpl'].'/template.php';//内容?>

<?php include $c['theme_path'].'/inc/footer.php';//底部?>
</body>
</html>