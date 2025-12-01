<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

$system_module=array(
	'account'	=>	array('index', 'password'),
	'inquiry'	=>	array('inquiry', 'feedback', 'review', 'newsletter'),
	'products'	=>	array('products', 'attribute', 'category', 'upload','watermark'),
	'content'	=>	array(
						'page'		=>	array('list', 'category'),
						'info'		=>	array('list', 'category'),
						'partner',
						'case'		=>	array('list', 'category'),
						'download'	=>	array('list', 'category'),
						'blog'		=>	array('blog', 'set', 'category', 'review'),
						'photo'		=>	array('list', 'category')
					),
	'seo'		=>	array('overview', 'keyword', 'keyword_track', 'article', 'mobile', 'links', 'blog', 'ads', 'sitemap', 'description'),
	'mta'		=>	array('visits', 'country', 'referer'),
	'user'		=>	array('user', 'add'),
	'service'	=>	array('chat'),
	'email'		=>	array('send', 'config', 'logs'),
	'set'		=>	array('config', 'themes', 'country', 'third_party_code', 'manage', 'manage_logs')
);

if(!(int)$c['FunVersion']){
	unset($system_module['user']);
}
if($c['FunVersion']!=2){
	$system_module['seo']=array('sitemap', 'description');
	unset($system_module['content']['blog']);
}
if(!$c['manage']['config']['IsSEO']){
	$system_module['seo']=array('sitemap', 'description');
}

return $system_module;


