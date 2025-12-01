<?php !isset($c) && exit();?>
<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/
js::jump_301();	//301跳转

//判断域名 fortunepacific.vip fortunemachinetool.com  都跳转到 fortunepacific.net
if(substr_count($_SERVER['HTTP_HOST'],'fortunepacific.vip') || substr_count($_SERVER['HTTP_HOST'],'fortunemachinetool.com')){
		$http=($_SERVER['SERVER_PORT']==443?'https://':'http://');
		@header( "HTTP/1.1 301 Moved Permanently");
		@header("Location: {$http}www.fortunepacific.net{$_SERVER['REQUEST_URI']}");
		exit;	
}

//网站基本设置
$config_row=db::get_all('config', "GroupId='global' or GroupId='translate' or (GroupId='products' and Variable='Config') or (GroupId='project' and Variable='Config') or (GroupId='article' and Variable='Config') or GroupId='chat' or Variable='symbol'");

foreach($config_row as $v){
	if(in_array("{$v['GroupId']}|{$v['Variable']}", array('article|Config', 'products|Config', 'global|CopyRight', 'global|IndexContent', 'global|HeaderContent', 'global|TopMenu', 'global|Contact', 'global|ShareMenu', 'translate|TranLangs', 'project|Config', 'global|Contact', 'global|CloseWeb','global|NewsletterSet'))){
		$c['config'][$v['GroupId']][$v['Variable']]=str::json_data(htmlspecialchars_decode($v['Value']), 'decode');
	}elseif("{$v['GroupId']}|{$v['Variable']}"=='global|Language'){
		$c['config'][$v['GroupId']][$v['Variable']]=explode(',', $v['Value']);
	}else{
		$c['config'][$v['GroupId']][$v['Variable']]=$v['Value'];
	}
}
//设置语言版
$c['lang']='_'.(@in_array(array_shift(explode('.', $_SERVER['HTTP_HOST'])), $c['config']['global']['Language'])?array_shift(explode('.', $_SERVER['HTTP_HOST'])):$c['config']['global']['LanguageDefault']);
$products_lang=substr($c['lang'], 1);

//网站关闭
web::close_website() && exit($c['config']['global']['CloseWeb']['CloseWeb'.$c['lang']]);

$c['pro_ext_where']	=array(
	1	=>	' and IsNew=1',
	2	=>	' and IsHot=1',
	3	=>	' and IsBestDeals=1',
);

$config_module_row=db::get_one('config_module', "IsDefault=1");
if((int)$c['FunVersion']==0 && (int)$config_module_row['IsResponsive']){
	@header( "HTTP/1.1 404 Not Found");
	exit;
}
$c['themes']=$config_module_row['Themes'];
$c['is_responsive']=$config_module_row['IsResponsive'];
$c['font']=$config_module_row['Font'];


//前台风格设置
if(!(int)$c['FunVersion'] || !web::is_mobile_client(1) || $c['is_responsive']==1){	//网页版设置
	$c['is_mobile_client']=0;
	$c['theme_path']=$c['root_path']."/static/themes/{$c['themes']}/";//当前风格的物理路径
	if(in_array(reset(explode('.', $_SERVER['HTTP_HOST'])), $c['config']['global']['Language']) || reset(explode('.', $_SERVER['HTTP_HOST']))=='www'){
		$dir=preg_replace('/^'.reset(explode('.', $_SERVER['HTTP_HOST'])).'\./i', '', $_SERVER['HTTP_HOST']);
	}else{
		$dir=$_SERVER['HTTP_HOST'];
	}
}else{	//手机版设置
	$c['is_mobile_client']=1;
	$c['theme_path']=$c['root_path'].$c['mobile']['tpl_dir'];	//手机版当前风格的物理路径
	$mobile_config_row=db::get_all('config',"GroupId='mobile'");//新的手机版配置
	foreach((array)$mobile_config_row as $v){
		$v['Value']!='' && $mobile_config[$v['Variable']]=$v['Value'];
	}
	$c['mobile']=array_merge($c['mobile'], array(
			'theme_path'=>	$c['root_path'].$c['mobile']['tpl_dir'],//手机版物理路径
			'HeadBg'	=>	$mobile_config['HeadBg'],//头部背景色
			'HeadIcon'	=>	$mobile_config['HeadIcon'],//图标 0 白色 1 黑色
			'HeadFixed'	=>	$mobile_config['HeadFixed'],//固定头部
			'LogoPath'	=>	@is_file($c['root_path'].$mobile_config['LogoPath'])?$mobile_config['LogoPath']:$c['config']['global']['LogoPath'],//Logo
			'FootBg'	=>	$mobile_config['FootBg'],//底部背景色
			'FootFont'	=>	$mobile_config['FootFont'],//字体颜色
			'FootNav'	=>	$mobile_config['FootNav'],//底部导航
			'BtnColor'	=>	$mobile_config['BtnColor'],//按钮字体颜色
			'BtnBg'		=>	$mobile_config['BtnBg'],//按钮背景颜色
			'CBtnColor'	=>	$mobile_config['CBtnColor'],//购物车按钮字体颜色
			'CBtnBg'	=>	$mobile_config['CBtnBg'],//购物车按钮背景颜色
			'HomeTpl'	=>	@is_file("{$c['theme_path']}index/{$mobile_config['HomeTpl']}/template.php")?$mobile_config['HomeTpl']:'01',//首页模板
			'ListTpl'	=>	@is_file("{$c['theme_path']}products/{$mobile_config['ListTpl']}/template.php")?$mobile_config['ListTpl']:'01'//列表页模板
		)
	);
}

$c['static_path']=$c['root_path']."/static/static/";	//风格入口的物理路径
$c['lang_pack']=include("{$c['static_path']}/lang/".substr($c['lang'], 1).".php");//加载语言包
$c['gender']=array($c['lang_pack']['Mr'],$c['lang_pack']['Ms']);

//查询条件
$c['where']=array(
	'products' => (int)$_SESSION['ly200_user']['UserId']?"SaleOut!=1 and Lang_{$products_lang} = 1 ":"IsMember=0 and SaleOut!=1 and Lang_{$products_lang}=1",
);

//程序处理
$do_action=isset($_POST['do_action'])?$_POST['do_action']:$_GET['do_action'];
if($do_action){
	$_=@explode('.', $do_action);
	$do_action_file="{$c['static_path']}/do_action/".$_[0].".php";
	if(@is_file($do_action_file)){
		include($do_action_file);
		if(method_exists($_[0].'_module', $_[1])){
			eval("{$_[0]}_module::{$_[1]}();");
			exit;
		}
	}
}

//开启"仅会员浏览"功能，非会员自动跳转会员登录页
($c['config']['global']['UserView']==1 && !(int)$_SESSION['User']['UserId'] && !substr_count($_SERVER['REQUEST_URI'], '/account/')) && js::location('/account/sign-up.html');
$c['config']['global']['powered_by']=web::powered_by((int)$c['HideSupport']);

//加载内容
$m=$_GET['m'];
$a=$_GET['a']?$_GET['a']:($_POST['a']?$_POST['a']:'index');
$d=$_GET['d']?$_GET['d']:$_POST['d'];


//第三方分享代码
$c['share'] = array(
	'facebook'	=>	"https://api.addthis.com/oexchange/0.8/forward/facebook/offer?url=".web::get_domain().$_SERVER['REQUEST_URI']."&pubid=ra-52b80aeb367a2886&ct=1&title=".$c['config']['global']['SiteName']."&pco=tbxnj-1.0",
	'twitter'	=>	"https://api.addthis.com/oexchange/0.8/forward/twitter/offer?url=".web::get_domain().$_SERVER['REQUEST_URI']."&pubid=ra-52b80aeb367a2886&ct=1&title=".$c['config']['global']['SiteName']."&pco=tbxnj-1.0",
	'linkedin'	=>	"https://api.addthis.com/oexchange/0.8/forward/linkedin/offer?url=".web::get_domain().$_SERVER['REQUEST_URI']."&pubid=ra-52b80aeb367a2886&ct=1&title=".$c['config']['global']['SiteName']."&pco=tbxnj-1.0",
	'pinterest'	=>	"https://api.addthis.com/oexchange/0.8/forward/pinterest/offer?url=".web::get_domain().$_SERVER['REQUEST_URI']."&pubid=ra-52b80aeb367a2886&ct=1&title=".$c['config']['global']['SiteName']."&pco=tbxnj-1.0",
	'google'	=>	"https://api.addthis.com/oexchange/0.8/forward/google_plusone_share/offer?url=".web::get_domain().$_SERVER['REQUEST_URI']."&pubid=ra-52b80aeb367a2886&ct=1&title=".$c['config']['global']['SiteName']."&pco=tbxnj-1.0",
	'bookmark'	=>	"https://www.addthis.com/bookmark.php?source=tbx32nj-1.0&v=300&url=".web::get_domain().$_SERVER['REQUEST_URI']."&pubid=ra-52b80aeb367a2886&ct=1&title=".$c['config']['global']['SiteName']."&pco=tbxnj-1.0"
);

ob_start();
if($c['is_mobile_client']==1){//是否为手机版
	if($m=='blog'){
		$file=$c['root_path'].'static/blog/index.php';
	}else{
		$file="{$c['theme_path']}{$m}.php";
	}
	if(@is_file($file) && !web::lock_china_ip() && !web::lock_china_browser()){
		include($file);
	}else if(web::lock_china_ip() || web::lock_china_browser()){//屏蔽国内IP跳转到404
		include($c['static_path'].'inc/global/shield.php');
	}else{
		include($c['static_path'].'inc/global/404.php');
	}
}else{
	$shield=1;
	if(web::lock_china_ip() || web::lock_china_browser()){//屏蔽国内IP跳转到404
		include($c['static_path'].'inc/global/shield.php');
	}else{
		if($c['config']['translate']['IsTranslate']==1){	//设置Google翻译部分
			$tranLangs=str::json_data($c['config']['translate']['TranLangs'], 'decode');
			foreach($tranLangs as $k=>$v){
				if(@in_array($v, (array)$langArr)){
					unset($tranLangs[$k]);
				}else if($v=='zh-ch' && @in_array('cn', (array)$langArr)){
					unset($tranLangs[$k]);
				}else if($v=='ja' && @in_array('jp', (array)$langArr)){
					unset($tranLangs[$k]);
				}
			}
		}
		if($m=='user'){
			$file=$c['static_path'].'inc/user/index.php';
		}elseif($m=='sitemap'){
			$file=$c['static_path'].'inc/global/sitemap.php';
		}elseif($m=='blog'){
			$file=$c['root_path'].'static/blog/index.php';
		}else{
			$file="{$c['theme_path']}$m.php";
		}
		if(@is_file($file)){//判断当前风格文件是否存在
			include($file);
		}else{//页面不存在跳转到404
			include($c['static_path'].'inc/global/404.php');
		}
	}
}
$html=ob_get_contents();
ob_end_clean();
web::load_cdn_contents($html);
?>