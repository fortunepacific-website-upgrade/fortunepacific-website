<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/
$config_row=db::get_all('config', "GroupId='global'");
foreach($config_row as $v){
	if(in_array("{$v['GroupId']}|{$v['Variable']}", array('global|Contact', 'global|RegTips', 'global|CloseWeb','global|NewsletterSet'))){
		$c['manage']['config'][$v['Variable']]=str::json_data(htmlspecialchars_decode($v['Value']), 'decode');
	}elseif("{$v['GroupId']}|{$v['Variable']}"=='global|Language'){
		$c['manage']['config'][$v['Variable']]=@explode(',', $v['Value']);
	}else{
		$c['manage']['config'][$v['Variable']]=$v['Value'];
	}
}
$pre_domain=@array_shift(explode('.', $_SERVER['HTTP_HOST']));
$c['lang']='_'.(@in_array($pre_domain, $c['manage']['config']['Language'])?$pre_domain:$c['manage']['config']['LanguageDefault']);	//设置语言版
if(!$_SESSION['Manage']['Language'] || !$_SESSION['Manage']['Language']!=$c['manage']['config']['ManageLanguage']) $_SESSION['Manage']['Language']=$c['manage']['config']['ManageLanguage'];	//后台语言

$c['manage']['cache_timeout']=3600*24;//清除后台缓存文件间隔(s)
if(!is_array($_SESSION['Manage']) || !$_SESSION['Manage']['UserName']){	//未登录
	manage::load_language('account');	//后台语言包
	if($_POST['do_action']){
		include('static/do_action/account.php');
		account_module::login();
		exit;
	}else{
		$c['manage']['module']='account';
		$c['manage']['action']='login';
	}
}else{
	$c['manage']=array_merge($c['manage'], array(
			'module'			=>	isset($_POST['m'])?$_POST['m']:$_GET['m'],
			'action'			=>	isset($_POST['a'])?$_POST['a']:$_GET['a'],
			'do'				=>	isset($_POST['d'])?$_POST['d']:$_GET['d'],
			'page'				=>	isset($_POST['p'])?$_POST['p']:$_GET['p'],
			'iframe'			=>	(int)$_GET['iframe'],
			'upload_dir'		=>	'/u_file/'.date('ym/'),   //网站所有上传的文件保存的基本目录
			'module'			=>	isset($_POST['m'])?$_POST['m']:$_GET['m'],	//模块名称
			'lang'				=>	$_SESSION['Manage']['Language']=='cn'?'':'_'.$_SESSION['Manage']['Language'],
			'language_list'		=>	array('en', 'cn', 'es', 'ru', 'jp', 'de', 'fr', 'pt'),	//可用的语言列表
			'language_default'	=>	@trim($c['manage']['config']['LanguageDefault']),//'en',	//默认的语言版本
			'language_web'		=>	$c['manage']['config']['Language'],	//网站启用的语言
			'm_language_list'	=>	array('cn', 'en'),	//后台可用的语言列表
			'field_ext'			=>	array('VARCHAR(50)', 'VARCHAR(150)', 'VARCHAR(255)', 'TEXT', 'TINYINT(1)'), //数据库添加字段参数
			'is_watermark'		=>	$c['manage']['config']['IsWater'],	//是否开启水印添加
			'is_thumbnail'		=>	$c['manage']['config']['IsThumbnail'],	//是否开启缩略图水印添加
			'is_watermark_pro'	=>	$c['manage']['config']['IsWaterPro'],	//是否开启只有产品图片水印添加
			'permit'			=>	include('static/inc/permit.php'),
			'resize_ary'		=>	array(	//各系统的缩略图尺寸
										'products'	=>	array('default', '500x500', '240x240'),
										'case'		=>	array('default', '500x500', '240x240')
									),
			'sub_save_dir'		=>	array(	//各系统的缩略图存放位置
										'products'	=>	'products/',
										'case'		=>	'case/'
									),
			'photo_type'		=>	array('other', 'products', 'editor', 'case'),	//图片银行基本系统图片类型
			'user_reg_set_field'=>	array(	//会员注册事项，请勿改动 1:可改 0:固定
										'Email'		=>	0,
										'Name'		=>	1,
										'Gender'	=>	1,
										'Age'		=>	1,
										'NickName'	=>	1,
										'Telephone'	=>	1,
										'Fax'		=>	1,
										'Birthday'	=>	1,
										'Facebook'	=>	1,
										'Company'	=>	1
									),
			'langs_table'		=>	array(
										'article'						=>	array('Title'=>1, 'SeoTitle'=>1, 'SeoKeyword'=>1, 'SeoDescription'=>2),
										'article_category'				=>	array('Category'=>1),
										'article_content'				=>	array('Content'=>3),

										'case_category'					=>	array('Category'=>1, 'SeoTitle'=>1, 'SeoKeyword'=>1, 'SeoDescription'=>2),
										'case_category_description'		=>	array('Description'=>3),
										'case_description'				=>	array('Description'=>3),
										'`case`'						=>	array('Name'=>1, 'BriefDescription'=>2, 'SeoTitle'=>1, 'SeoKeyword'=>1, 'SeoDescription'=>2),

										'download'						=>	array('Name'=>1, 'BriefDescription'=>2, 'SeoTitle'=>1, 'SeoKeyword'=>1, 'SeoDescription'=>2),
										'download_category'				=>	array('Category'=>1, 'SeoTitle'=>1, 'SeoKeyword'=>1, 'SeoDescription'=>2),
										'download_category_description'	=>	array('Description'=>3),
										'download_description'			=>	array('Description'=>3),

										'info'							=>	array('Title'=>1, 'BriefDescription'=>2, 'SeoTitle'=>1, 'SeoKeyword'=>1, 'SeoDescription'=>2),
										'info_category'					=>	array('Category'=>1),
										'info_content'					=>	array('Content'=>3),

										'feedback_set'					=>	array('Name'=>0),
										'link'							=>	array('Keyword'=>1),
										'meta'							=>	array('SeoTitle'=>1, 'SeoKeyword'=>1, 'SeoDescription'=>2),
										'partners'						=>	array('Name'=>1),

										'products'						=>	array('Lang'=>4, 'Name'=>2, 'BriefDescription'=>2),
										'products_attribute'			=>	array('Name'=>0, 'Value'=>3),
										'products_category'				=>	array('Category'=>1, 'SeoTitle'=>1, 'SeoKeyword'=>1, 'SeoDescription'=>2),
										'products_category_description'	=>	array('Description'=>3),
										'products_description'			=>	array('Description'=>3),
										'products_seo'					=>	array('SeoTitle'=>1, 'SeoKeyword'=>1, 'SeoDescription'=>2),

										'user_reg_set'					=>	array('Name'=>0, 'Option'=>3),

										'seo_description'				=>	array('Description'=>1)
									),
			'inquiry_set_field'	=>	array(	//询盘字段 1:可改 0:固定
										'FirstName'	=>	1,
										'LastName'	=>	1,
										'Email'		=>	1,
										'Address'	=>	1,
										'City'		=>	1,
										'State'		=>	1,
										'Country'	=>	1,
										'PostalCode'=>	1,
										'Phone'		=>	1,
										'Fax'		=>	1,
										'Subject'	=>	1,
										'Message'	=>	1
									),
			'feedback_set_field'=>	array(	//留言字段 1:可改 0:固定
										'Fullname'	=>	1,
										'Company'	=>	1,
										'Phone'		=>	1,
										'Mobile'	=>	1,
										'Email'		=>	1,
										'Subject'	=>	1,
										'Message'	=>	1
									)
		)
	);

	//------------------------------------------------------------------------------------------------------
	$c['themes']='t197';
	//------------------------------------------------------------------------------------------------------

	//干活....
	$do_action=isset($_POST['do_action'])?$_POST['do_action']:$_GET['do_action'];
	$_GET['do_action']=='action.file_upload_plugin' && $do_action=$_GET['do_action'];// 通过文件上传进来的直接用get
	if($do_action){
		$_=@explode('.', $do_action);
		manage::load_language($_[0]);
		$do_action_file="static/do_action/{$_[0]}.php";
		if(@is_file($do_action_file)){
			include($do_action_file);
			if(method_exists($_[0].'_module', $_[1])){
				eval("{$_[0]}_module::{$_[1]}();");
				exit;
			}
		}
	}

	!$c['manage']['module'] && $c['manage']['module']='account';
	!@is_dir($c['manage']['module']) && js::location('./');
	!@is_file("{$c['manage']['module']}/{$c['manage']['action']}.php") && $c['manage']['action']='index';
	!$c['manage']['do'] && $c['manage']['do']='index';
	!$c['manage']['page'] && $c['manage']['page']='index';
	manage::load_language($c['manage']['module']);
}


