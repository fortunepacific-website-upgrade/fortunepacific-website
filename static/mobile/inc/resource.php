<?php !isset($c) && exit();?>
<?php 
echo ly200::load_static(
	$c['mobile']['tpl_dir'].'css/global.css',
	$c['mobile']['tpl_dir'].'css/style.css',
	$c['mobile']['tpl_dir'].'js/jquery-min.js',
	'/static/js/global.js',
	'/static/js/lang/'.substr($c['lang'], 1).'.js',
	$c['mobile']['tpl_dir'].'js/rye-touch.js',
	$c['mobile']['tpl_dir'].'js/global.js'
);