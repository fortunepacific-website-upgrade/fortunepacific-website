<?php !isset($c) && exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Global 404</title>
<?php include("{$c['static_path']}/inc/static.php");?>
</head>

<body>
<?php //include("{$c['theme_path_lang']}/inc/header.php");?>
<div id="main">
    <div id="error_page" class="w">
		<div class="error_logo sw"></div>
		<div class="error_warning sw"><?=$c['lang_pack']['404tips'];?></div>
		<div class="error_nav sw"><a href="/"><?=$c['lang_pack']['homepage'];?></a>|<a href="#"><?=$c['lang_pack']['goback'];?></a></div>
	</div>
</div>
<?php //include("{$c['theme_path_lang']}/inc/footer.php");?>
</body>
</html>