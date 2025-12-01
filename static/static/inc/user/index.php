<?php !isset($c) && exit();?>
<?php
$login_module_ary=array('index','download', 'setting');	//需要登录的模块列表
$un_login_module_ary=array('register', 'forgot');	//不需要登录的模块列表 'login',,
if((int)$_SESSION['ly200_user']['UserId']){	//已登录
	$module_ary=$login_module_ary;
}else{	//未登录
	$module_ary=$un_login_module_ary;	//重置模块列表
}
!in_array($a, $module_ary) && $a=$module_ary[0];
ob_start();
if((int)$_SESSION['ly200_user']['UserId']){	//已登录的，架构会员中心页面内容排版
	$user_row=db::get_one('user', "UserId='".(int)$_SESSION['ly200_user']['UserId']."'");
?>
    <div id="lib_user" class="clearfix">
        <?php include('inc/menu.php');?>
        <div id="lib_user_main">
            <?php include("module/{$a}.php");?>
        </div>
    </div>
<?php 
}else{
	include("module/{$a}.php");
}
$user_page_contents=ob_get_contents();
ob_end_clean();

@in_array($a, $un_login_module_ary) && exit($user_page_contents);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?=web::seo_meta();?>
<?php include("{$c['static_path']}/inc/static.php");?>
</head>

<body class="lang<?=$c['lang'];?> g_member">
<?php include("{$c['theme_path']}/inc/header.php");?>
<div id="main" class="wide user_main"><?=$user_page_contents;?></div>
<?php include("{$c['theme_path']}/inc/footer.php");?>
</body>
</html>