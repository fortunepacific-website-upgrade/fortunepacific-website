<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

$c=array(
	'root_path'		=>	substr(dirname(__FILE__), 0, -4).DIRECTORY_SEPARATOR,
	'time'			=>	time(),
	'tmp_dir'		=>	'/tmp/',
	'api_url'		=>	'https://api.ly200.com/gateway/',
	'sync_url'		=>	'https://sync.ly200.com/gateway/',
	'ueeseo_url'	=>	'http://www.ueeseo.com/gateway/',
	'analytics'		=>	'//analytics.ly200.com/js/analytics.js',
	'cdn'			=>	'//ueeshop.ly200-cdn.com/',
	'my_order'		=>	'if(MyOrder>0, MyOrder, if(MyOrder=0, 1000000, 1000001)) asc,',
	'gender'		=>	array('Mr', 'Ms'),
	'cache_timeout'	=>	0,//3600*2,	//更新静态文件间隔(s)
	'description_count'	=>	3,
	'share'			=>	array('Facebook', 'Twitter', 'Pinterest', 'YouTube', 'Google', 'LinkedIn', 'Instagram'), //第三方分享项目
	'chat'			=> 	array(
							'type'	=>	array('QQ', 'Skype', 'Email', 'trademanager', 'WeChat', 'WhatsApp'),
							'link'	=>	array('//wpa.qq.com/msgrd?v=3&uin=%s&menu=yes', 'skype:%s?chat', 'mailto:%s', '//amos.alicdn.com/msg.aw?v=2&uid=%s&site=enaliint&s=24&charset=UTF-8', '', 'https://api.whatsapp.com/send?phone=%s'),
							'mobile_link'=>array('mqqwpa://im/chat?chat_type=wpa&uin=%s&version=1&src_type=web&web_src=oicqzone.com')
						),
	'mobile'		=>	array(
							'tpl_dir'	=>	'/static/mobile/'	//手机模板目录
						),
	'lang_name'		=>	array(	//语言版本
							'en'	=>	'English',
							'jp'	=>	'日本語',
							'de'	=>	'Deutsch',
							'fr'	=>	'Français',
							'es'	=>	'Español',
							'ru'	=>	'Русский',
							'pt'	=>	'Português',
							'cn'	=>	'中文版'
						)
);

@include('config.php');
@include('nav_config.php');
ly200_web_init::init();
$c['session_id']=(int)$_SESSION['ly200_user']['UserId']?'':substr(md5(md5(session_id())), 0, 10);

if($_SESSION['Manage']['UserId']>0 || $_SESSION['Manage']['UserId']=='-1'){//后台管理员上线
	$c['cache_timeout']=10;
}

//系统设置类
class ly200_web_init{
	public static function init(){
		header('Content-Type: text/html; charset=utf-8');
		@error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT);
		self::slashes_gpcf($_GET);
		self::slashes_gpcf($_POST);
		self::slashes_gpcf($_COOKIE);
		self::slashes_gpcf($_FILES);
		self::slashes_gpcf($_REQUEST);
		phpversion()<'5.3.0' && set_magic_quotes_runtime(0);
		date_default_timezone_set('PRC');	//5.1.0
		spl_autoload_register('self::class_auto_load');	//5.1.2
		$host_ary=explode('.', $_SERVER['HTTP_HOST']);
		@ini_set('session.cookie_domain', in_array(reset($host_ary), web::get_sub_domain())?implode('.', array_slice($host_ary, 1)):$_SERVER['HTTP_HOST']);
		$_GET['session_id'] && @session_id($_GET['session_id']);
		@session_start();
	}

	private static function class_auto_load($class_name){
		global $c;
		$file=$c['root_path'].'inc/class/'.$class_name.'.class.php';
		@is_file($file) && include($file);
	}

	private static function slashes_gpcf(&$ary){
		foreach($ary as $k=>$v){
			if(is_array($v)){
				self::slashes_gpcf($ary[$k]);
			}else{
				$ary[$k]=trim($ary[$k]);
				!get_magic_quotes_gpc() && $ary[$k]=addslashes($ary[$k]);
			}
		}
	}
}
