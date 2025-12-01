<?php !isset($c) && exit();?>
<?php
echo ly200::load_static(
	'/static/css/global.css',
	'/static/css/themes.css',
	($c['FunVersion'] ? '/static/css/user.css' : ''),
	'/static/themes/'.$c['themes'].'/css/style.css',
	'/static/js/jquery-3.7.1.min.js',
	'/static/js/jquery-migrate-3.4.1.min.js',
	'/static/js/jquery.bxslider.min.js',
	'/static/js/jquery-compatibility-fix.js',
	'/static/js/jquery-compatibility-fix.js',
	'/static/js/lang/'.substr($c['lang'], 1).'.js',
	'/static/js/global.js',
	'/static/js/themes.js',
	($c['FunVersion'] ? '/static/js/user.js' : ''),
	'/static/themes/'.$c['themes'].'/js/main.js'
);
if($c['is_responsive']){	//响应式公共文件样式
	echo ly200::load_static('/static/css/responsive.css');
}
echo "<link href='/static/font/OpenSans-Bold/font.css' rel='stylesheet' type='text/css' />\r\n";
echo ly200::load_font(str::json_data($c['font'], 'decode'));