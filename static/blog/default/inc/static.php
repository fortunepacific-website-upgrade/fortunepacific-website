<?php !isset($c) && exit();?>
<?=ly200::load_static(
	'/static/css/global.css',
	//'/static/themes/default/css/global.css',
	'/static/js/jquery-3.7.1.min.js',
	'/static/js/jquery-compatibility-fix.js',
	'/static/js/lang/'.substr($c['lang'], 1).'.js',
	'/static/js/global.js',
	'/static/blog/default/css/style.css',
	'/static/blog/default/js/blog.js'
);?>
