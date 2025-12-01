<?php !isset($c) && exit();?>
<?php
$do_action=isset($_POST['do_action'])?$_POST['do_action']:$_GET['do_action'];
if($do_action &&  method_exists(user, $do_action)){
	eval("user::{$do_action}();");
	exit;
}

$a=$_GET['a']?$_GET['a']:$_POST['a'];	//页面名称

$login_module_ary=array('index', 'setting');	//需要登录的模块列表
$un_login_module_ary=array('login');	//不需要登录的模块列表 'login',

if((int)$_SESSION['ly200_user']['UserId']){	//已登录
	$module_ary=$login_module_ary;
	$user_where="UserId='{$_SESSION['ly200_user']['UserId']}'";
}else{	//未登录
	in_array($a, $login_module_ary) && js::location("/account/login.html?&JumpUrl=".urlencode($_GET['JumpUrl']));
	$module_ary=$un_login_module_ary;	//重置模块列表
}

($a=='' || !in_array($a, $module_ary)) && $a=$module_ary[0];
if((int)$_SESSION['ly200_user']['UserId']){
	$UserId=$_SESSION['ly200_user']['UserId'];
	$user_where="UserId={$UserId}";
	$user_row=db::get_one('user', $user_where);
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
<?=ly200::load_static($c['mobile']['tpl_dir'].'js/user.js');?>
</head>

<body class="user">
<?php include $c['theme_path'].'/inc/header.php';//头部 ?>

<?php include $c['theme_path']."/user/module/$a.php";//内容?>

<?php include $c['theme_path'].'/inc/footer.php';//底部?>
</body>
</html>