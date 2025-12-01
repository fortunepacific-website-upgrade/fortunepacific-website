<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

class set_module{
	public static function config_basis_edit(){
		global $c;
		manage::check_permit('set.config', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$contact_ary=$c['manage']['config']['Contact'];
		foreach($c['manage']['language_list'] as $v){
			$contact_ary['ptips_'.$v] = $_POST['ptips_'.$v];
			$contact_ary['copyright_'.$v] = $_POST['copyright_'.$v];
		}
		$data=array(
			'SiteName'				=>	$p_SiteName,
			'LogoPath'				=>	$p_LogoPath,
			'IcoPath'				=>	$p_IcoPath,
			'WebDisplay'			=>	(int)$p_WebDisplay,
			'Is_footer_feedback'	=>	(int)$p_Is_footer_feedback,
			'FooterColor'			=>	$p_FooterColor,
			'Contact'				=>	addslashes(str::json_data(str::str_code($contact_ary, 'stripslashes'))),
			'Blog'					=>	$p_Blog
		);
		manage::config_operaction($data, 'global');
		manage::operation_log('基本设置');
		ly200::e_json(manage::language('{/global.save_success/}'), 1);
	}
	
	public static function config_seo_edit(){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$alone_ary=array('home', 'tuan', 'seckill', 'blog', 'new', 'hot', 'best_deals', 'special_offer');
		$much_ary=array('article'=>array('Title', 'AId'), 'info_category'=>array('Category', 'CateId'), 'info'=>array('Title', 'InfoId'), 'products_category'=>array('Category', 'CateId'), 'products'=>array('Name', 'ProId'));
		if(in_array($p_Type, $alone_ary)){
			$Id=(int)$p_MId;
			if(!$Id){
				db::insert('meta', array('Type'=>$p_Type));
				$Id=db::get_insert_id();
			}
			manage::database_language_operation('meta', "MId='$Id'", array('SeoTitle'=>1, 'SeoKeyword'=>1, 'SeoDescription'=>2));
		}else{
			$Id=(int)${'p_'.$much_ary[$p_Type][1]};
			manage::database_language_operation($p_Type=='products'?'products_seo':$p_Type, "{$much_ary[$p_Type][1]}='$Id'", array('SeoTitle'=>1, 'SeoKeyword'=>1, 'SeoDescription'=>2));
		}
		manage::operation_log('修改页面标题与标签管理');
		ly200::e_json(manage::language('{/global.save_success/}'), 1);
	}

	public static function config_switch(){
		global $c;
		manage::check_permit('set.config', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'p');
		$p_status=(int)$p_status?0:1;
		$switch_ary=array('IsIP', 'IsChineseBrowser', 'BrowserLanguage', 'IsOpenInq', 'IsCopy', 'PromptSteps', '301', 'PNew', 'CNew', 'INew', 'IsCloseWeb', 'IsReview', 'IsReviewDisplay');
		if((int)$c['FunVersion']){
			$switch_ary[]='IsIP';
			$switch_ary[]='IsChineseBrowser';
			$switch_ary[]='IsOpenMobileVersion';
		}
		!in_array($p_field, $switch_ary) && ly200::e_json(manage::language('{/error.operating_illegal/}'));
		manage::config_operaction(array($p_field=>$p_status), 'global');
		manage::operation_log('快捷开关');
		ly200::e_json(manage::language('{/global.'.($p_status==1?'open':'close').'_success/}'), 1);
	}

	public static function config_switch_close_web(){	//自定义关闭网站
		global $c;
		manage::check_permit('set.config', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$close_web_ary=array();
		foreach($c['manage']['language_list'] as $k=>$v){
			$close_web_ary['CloseWeb_'.$v]=${'p_CloseWeb_'.$v};
		}
		$data=addslashes(str::json_data(str::str_code($close_web_ary, 'stripslashes')));
		manage::config_operaction(array('CloseWeb'=>$data), 'global');
		manage::operation_log('关闭网站提示');
		ly200::e_json('', 1);
	}

	public static function config_language_edit(){
		global $c;
		manage::check_permit('set.config', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$flag_ary=str::json_data(htmlspecialchars_decode($c['manage']['config']['LanguageFlag']), 'decode');
		$flag_ary[$p_Language]=$p_FlagPath;
		$data=array('LanguageFlag'=>addslashes(str::json_data(str::str_code($flag_ary, 'stripslashes'))));
		if($p_LanguageDefault){
			$data['LanguageDefault']=$p_Language;
			manage::turn_on_language_database_operation($p_Language, $p_Language);	//添加新增语言版多语言字段、默认内容
		}
		manage::config_operaction($data, 'global');
		manage::operation_log('修改语言设置');
		ly200::e_json('', 1);
	}

	public static function config_language_used(){
		global $c;
		manage::check_permit('set.config', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$p_IsUsed=(int)$p_IsUsed;
		if((int)$c['FunVersion']==0){	//当只能使用一种语言的时候，选择语言版本，把默认语言也同时切换过去
			$language_default=$p_Language;
			$language_list=array($p_Language);
		}else{
			$language_default=$c['manage']['config']['LanguageDefault'];
			$language_list=$c['manage']['config']['Language'];
			$Language_status=str::json_data($c['manage']['config']['Language_status'], 'decode');
			if($p_IsUsed){
				$language_list[]=$p_Language;
				$Language_status[$p_Language]=1;
			}else{
				$language_list=@array_diff($language_list, array($p_Language));
				$Language_status[$p_Language]=0;
			}
			!$language_list && ly200::e_json(manage::language('{/set.config.language.close_all_notes/}'));
			!in_array($language_default, $language_list) && $language_default=$language_list[0];
			!$language_default && ly200::e_json(manage::language('{/set.config.language.cur_lang_colse_notes/}'));
			$language_list=@array_unique($language_list); //去除重复值
			if($p_IsUsed){
				$language_count_ary=array(1, 2, 8);	//各版本能选择的语言版本数量
				$language_count=$language_count_ary[(int)$c['FunVersion']];
				count($language_list)>$language_count && ly200::e_json(sprintf(manage::language('{/set.config.language.choose_count_notes/}'), $language_count));
			}
		}
		$data=array(
			'Language'			=>	@implode(',', $language_list),
			'LanguageDefault'	=>	$language_default,
			'Language_status'	=>	str::json_data($Language_status)
		);
		manage::config_operaction($data, 'global');
		manage::turn_on_language_database_operation($data['LanguageDefault'], $language_list);//添加新增语言版多语言字段、默认内容
		manage::operation_log(($p_IsUsed?'开启':'关闭').'语言-'.$p_Language);
		ly200::e_json(manage::language('{/global.'.($p_IsUsed==1?'open':'close').'_success/}'), 1);
	}

	public static function config_language_manage_set(){
		global $c;
		manage::check_permit('set.config', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$data=array('ManageLanguage'=>((int)$p_IsUsed && $p_Language)?$p_Language:'cn');
		manage::config_operaction($data, 'global');
		manage::operation_log('设置后台语言-'.$data['ManageLanguage']);
		ly200::e_json('', 1);
	}

	public static function config_language_browse_set(){
		global $c;
		manage::check_permit('set.config', 1);
		!(int)$c['FunVersion'] && ly200::e_json(manage::language('{/error.no_permit/}'));
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$p_IsUsed=(int)$p_IsUsed;
		$data=array($p_config=>$p_IsUsed);
		manage::config_operaction($data, 'global');
		manage::operation_log(($p_IsUsed?'开启':'关闭').'基础设置-'.$p_config);
		ly200::e_json(manage::language('{/global.'.($p_IsUsed==1?'open':'close').'_success/}'), 1);
	}

	public static function config_google_translate_lang_set(){
		global $c;
		manage::check_permit('set.config', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$p_Status=(int)$p_Status;
		$p_Lang=trim($p_Lang);
		if(!db::get_row_count('config', "GroupId='translate' and Variable='TranLangs'")){
			db::insert('config', array(
					'GroupId'	=>	'translate',
					'Variable'	=>	'TranLangs',
					'Value'		=>	'[]'
				)
			);
		}
		$rows=db::get_value('config', "GroupId='translate' and Variable='TranLangs'", 'Value');
		$LangArr=str::json_data($rows, 'decode');
		if($p_Status==1){
			$LangArr[]=$p_Lang;
		}else{
			foreach($LangArr as $k=>$v){
				if($v==$p_Lang) unset($LangArr[$k]);
			}
		}
		db::update('config', "GroupId='translate' and Variable='TranLangs'", array('Value'=>str::json_data($LangArr)));
		ly200::e_json(manage::language('{/global.'.($p_Status==1?'open':'close').'_success/}'), 1);
	}

	public static function config_google_translate_set(){
		global $c;
		manage::check_permit('set.config', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');

		$where = "GroupId='translate' and Variable='IsTranslate'";
		if(db::get_row_count('config', $where)){
			db::update('config', $where, array('Value'=>(int)$p_key));
		}else{
			db::insert('config', array(
					'GroupId'	=>	'translate',
					'Variable'	=>	'IsTranslate',
					'Value'		=>	(int)$p_key
				)
			);
		}

		manage::operation_log('修改 Google 翻译设置');
		ly200::e_json(manage::language('{/global.'.($p_key==1?'open':'close').'_success/}'), 1);
	}

	public static function config_inquiry_switch(){
		global $c;
		manage::check_permit('set.config', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_status=(int)$g_status?0:1;
		$key=strpos($g_field, 'NotNull')?1:0;
		$g_field=str_replace('NotNull', '', $g_field);
		$set_ary=array(
			'feedback'	=>	array('message', 'MessSet', $c['manage']['feedback_set_field'], '修改在线留言事项'),
			'inquiry'	=>	array('inquiry', 'InqSet', $c['manage']['inquiry_set_field'], '修改询盘事项')
		);
		!array_key_exists($g_type, $set_ary) && exit;
		$w="GroupId='{$set_ary[$g_type][0]}' and Variable='{$set_ary[$g_type][1]}'";
		$set=db::get_value('config', $w, 'Value');
		if($set){
			$inq_ary=str::json_data($set, 'decode');
		}else{
			$inq_ary=array();
			foreach($set_ary[$g_type][2] as $k=>$v){
				$inq_ary[$k]=$v?array(0, 0):array(1, 1);
			}
		}
		$inq_ary[$g_field][$key]=$g_status;
		if(!$inq_ary[$g_field][0]) $inq_ary[$g_field][1]=0;
		$set=addslashes(str::json_data(str::str_code($inq_ary, 'stripslashes')));
		db::update('config', $w, array('Value'=>$set));
		manage::operation_log($set_ary[$g_type][3]);
		ly200::e_json(manage::language('{/global.'.($g_status==1?'open':'close').'_success/}'), 1);
	}

	public static function config_inquiry_btn_color_edit(){
		global $c;
		manage::check_permit('set.config', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		if(db::get_row_count('config', 'GroupId="inquiry" and Variable="inquiry_button"')){
			db::update('config', 'GroupId="inquiry" and Variable="inquiry_button"',array('Value'=>'#'.$p_Color));
		}else{
			db::insert('config', array(
				'GroupId'	=>	"inquiry",
				'Variable'	=>	"inquiry_button",
				'Value'		=>	'#'.$p_Color
			));
		}
		manage::operation_log('修改询盘按钮颜色');
		ly200::e_json(manage::language('{/global.save_success/}'), 1);
	}

	public static function config_inquiry_feedback_set_edit(){
		global $c;
		manage::check_permit('set.config', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$SetId=(int)$p_SetId;
		$TypeId=(int)$p_TypeId;
		$IsNotnull=(int)$p_IsNotnull;
		$data = array();
		$data['TypeId'] = $TypeId;
		$data['IsNotnull'] = $IsNotnull;
		if($p_SetId){
			db::update('feedback_set',"SetId={$SetId}",$data);
		}else{
			db::insert('feedback_set',$data);
			$SetId=db::get_insert_id();
		}

		manage::database_language_operation('feedback_set', "SetId='$SetId'", array('Name'=>0));
		ly200::e_json('', 1);
	}

	public static function config_inquiry_feedback_set_del(){
		manage::check_permit('set.config', 1);
		$SetId=(int)$_GET['SetId'];
		db::delete('feedback_set', "SetId={$SetId}");
		manage::operation_log('删除留言自定义字段');
		ly200::e_json('', 1);
	}
	
	public static function config_inquiry_newsletter_set(){
		global $c;
		manage::check_permit('set.config', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		
		$arr=array($p_IsOpen,$p_Seconds,$p_PicPath);
		foreach($c['manage']['language_list'] as $k=>$v){
			$arr['Title']['Title_'.$v]=$_POST['Title_'.$v];
			$arr['BriefDescription']['BriefDescription_'.$v]=$_POST['BriefDescription_'.$v];
		}
		manage::config_operaction(array('NewsletterSet'=>addslashes(str::json_data(str::str_code($arr, 'stripslashes')))), 'global');
		manage::operation_log('修改订阅设置');
		ly200::e_json(manage::language('{/global.save_success/}'), 1);
	}

	public static function config_contact_edit(){
		global $c;
		manage::check_permit('set.config', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$contact_ary=$c['manage']['config']['Contact'];
		foreach($c['manage']['language_list'] as $v){
			$contact_ary['company_'.$v] = $_POST['company_'.$v];
			$contact_ary['address_'.$v] = $_POST['address_'.$v];
		}
		$contact_ary['tel']=$p_tel;
		$contact_ary['fax']=$p_fax;
		$contact_ary['email']=$p_email;
		$contact_ary['contact']=$p_contact;
		$contact_ary['links']=$p_links;
		manage::config_operaction(array('Contact'=>addslashes(str::json_data(str::str_code($contact_ary, 'stripslashes')))), 'global');
		manage::operation_log('联系方式设置');
		ly200::e_json(manage::language('{/global.save_success/}'), 1);
	}

	public static function config_product_switch(){
		global $c;
		manage::check_permit('set.config', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'p');
		$p_status=(int)$p_status?0:1;
		if($c['FunVersion']>=1){
			$switch_ary=array('show_price', 'share', 'inq_type', 'member','pdf', 'manage_myorder');
		}else{
			$switch_ary=array('share', 'inq_type', 'pdf', 'manage_myorder');
		}
		!in_array($p_field, $switch_ary) && ly200::e_json(manage::language('{/error.operating_illegal/}'));
		$config=str::json_data(db::get_value('config', 'GroupId="products" and Variable="Config"', 'Value'), 'decode');
		$config[$p_field]=$p_status;
		manage::config_operaction(array('Config'=>addslashes(str::json_data($config))), 'products');
		manage::operation_log('产品设置');
		ly200::e_json(manage::language('{/global.'.($p_status==1?'open':'close').'_success/}'), 1);
	}

	public static function config_product_currency_symbol_edit(){
		global $c;
		manage::check_permit('set.config', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		manage::config_operaction(array('symbol'=>$p_symbol), 'products');
		manage::operation_log('产品价格货币符号设置');
		ly200::e_json(manage::language('{/global.edit_success/}'), 1);
	}
	
	/****** 会员设置 start ******/
	public static function config_user_set(){
		global $c;
		manage::check_permit('set.config', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$RegTips=array();
		foreach($c['manage']['language_list'] as $v){
			$RegTips['regtips_'.$v] = str_replace("\r\n",'!-~',$_POST['regtips_'.$v]);
		}
		$data=array(
			'RegTips'			=>	addslashes(str::json_data(str::str_code($RegTips, 'stripslashes'))), //注册页提示语
			'IsOpenMember'		=>	(int)$p_IsOpenMember,
			'UserStatus'		=>	$c['FunVersion']?(int)$p_UserStatus:0,
			'UserVerification'	=>	$c['FunVersion']?(int)$p_UserVerification:0,
		);
		manage::config_operaction($data, 'global');
		manage::operation_log('会员设置');
		ly200::e_json(manage::language('{/global.edit_success/}'), 1);
	}

	public static function config_user_reg_set(){
		global $c;
		manage::check_permit('set.config', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_field=$g_field;
		$g_status=(int)$g_status;
		if(strpos($g_field, 'NotNull')){
			$field=str_replace('NotNull', '', $g_field);
			$key=1;
		}else{
			$field=$g_field;
			$key=0;
		}
		$RegSet=db::get_value('config', 'GroupId="user" and Variable="RegSet"', 'Value');
		if($RegSet){
			$reg_ary=str::json_data($RegSet, 'decode');
		}else{
			$reg_ary=array();
			foreach($c['manage']['user_reg_field'] as $k=>$v){
				$reg_ary[$k]=$v?array(0, 0):array(1, 1);
			}
		}
		$reg_ary[$field][$key]=$g_status?0:1;
		if(!$reg_ary[$field][0]) $reg_ary[$field][1]=0;
		$RegSet=addslashes(str::json_data(str::str_code($reg_ary, 'stripslashes')));
		db::update('config', 'GroupId="user" and Variable="RegSet"', array('Value'=>$RegSet));
		manage::operation_log('修改固定注册事项');
		ly200::e_json(manage::language('{/global.'.($g_status==1?'open':'close').'_success/}'), 1);
	}

	public static function config_user_reg_set_edit(){
		manage::check_permit('set.config', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$p_SetId=(int)$p_SetId;
		$p_TypeId=(int)$p_TypeId;
		$data=array('TypeId'=>$p_TypeId);
		if($p_SetId){
			db::update('user_reg_set', "SetId={$p_SetId}", $data);
			manage::operation_log('修改注册事项');
		}else{
			db::insert('user_reg_set', $data);
			$p_SetId=db::get_insert_id();
			manage::operation_log('添加注册事项');
		}
		manage::database_language_operation('user_reg_set', "SetId={$p_SetId}", array('Name'=>0, 'Option'=>3));
		ly200::e_json('', 1);
	}

	public static function config_user_reg_set_del(){
		manage::check_permit('set.config', 1);
		$SetId=(int)$_GET['SetId'];
		db::delete('user_reg_set', "SetId={$SetId}");
		manage::operation_log('删除注册事项');
		ly200::e_json('', 1);
	}
	/****** 会员设置 end ******/
	
 	public static function config_watermark_edit(){
		global $c;
		manage::check_permit('set.config', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$data=array(
			//******************水印设置******************
			'IsWater'			=>	(int)$p_IsWater,
			'Alpha'				=>	$p_Alpha,
			'WatermarkPath'		=>	$p_WatermarkPath,
			'WaterPosition'		=>	$p_WaterPosition
			);
		manage::config_operaction($data, 'global');
		manage::operation_log('修改水印设置');
		ly200::e_json(manage::language('{/global.save_success/}'), 1);
	}
	
	public static function config_share_edit(){
		global $c;
		manage::check_permit('set.config', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$contact_ary=$c['manage']['config']['Contact'];
		foreach((array)$c['share'] as $v){
			$contact_ary[$v] = $_POST[$v];
		}
		$p_tax_code_type && $contact_ary[$p_tax_code_type] = $p_Add;
		manage::config_operaction(array('Contact'=>addslashes(str::json_data(str::str_code($contact_ary, 'stripslashes')))), 'global');
		manage::operation_log('社交媒体设置');
		ly200::e_json('', 1);
	}

	public static function themes_index_set_edit(){
		global $c;
		manage::check_permit('set.themes', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$WId=(int)$p_WId;
		$web_setting_row=db::get_one('web_settings', "WId='{$WId}'");
		$web_setting_row['Type']=explode('_', $web_setting_row['Type']);
		$web_setting_row['Config']=str::json_data($web_setting_row['Config'], 'decode');
		!(int)$web_setting_row['Config'][2] && $web_setting_row['Config'][2]=1;	//数量
		$data=array();
		(int)$web_setting_row['Config'][3] && $data['Data']['ShowType']=(int)$p_ShowType;	//允许设置显示方式
		foreach($web_setting_row['Type'] as $v){
			for($i=0; $i<$web_setting_row['Config'][2]; ++$i){
				foreach($c['manage']['config']['Language'] as $k=>$v1){
					$data['Data'][$v][$i][$v1]=$_POST[$v.'_'.$v1][$i];
				}
				$data['Data'][$v][$i]=array_filter($data['Data'][$v][$i]);
			}
		}
		$data['Data']=addslashes(str::json_data(str::str_code($data['Data'], 'stripslashes')));
		db::update('web_settings', "WId='{$WId}'", $data);
		manage::operation_log('网站设置-'.$WId);
		ly200::e_json('', 1);
	}

	public static function themes_mobile_themes_edit(){
		global $c;
		manage::check_permit('set.themes', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$field=$g_type=='home_themes'?'HomeTpl':'ListTpl';
		manage::config_operaction(array($field=>$g_themes), 'mobile');
		manage::operation_log('手机模板选择');
		ly200::e_json('', 1);
	}

	public static function themes_nav_edit(){
		global $c;
		manage::check_permit('set.themes', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$p_Id=(int)$p_Id;
		$p_Page=(int)$p_Page;
		$p_Info=(int)$p_Info;
		$p_Cate=(int)$p_Cate;
		$p_Down=(int)$p_Down;
		$p_DownWidth=(int)$p_DownWidth;
		$p_NewTarget=(int)$p_NewTarget;
		$field=$p_Type=='nav'?'Headnav':($p_Type=='footer_nav'?'Footnav':'Topnav');
		$nav_row=db::get_value('config', "GroupId='nav' and Variable='$field'", 'Value');
		$nav_data=str::json_data($nav_row, 'decode');

		if($p_Nav==-1){//自定义项
			$data=array();
			$data['Custom']=1;
			foreach($c['manage']['config']['Language'] as $k2=>$v2){
				$data["Name_{$v2}"]=${'p_Name_'.$v2};
			}
			$data['Url']=$p_Url;
			$data['CusNewTarget']=$p_NewTarget;
		}else{//固定项
			$data=array(
				'Nav'		=>	$p_Nav,//导航栏目，详细请看 $c['nav_cfg']
				'Page'		=>	$p_Nav==6?$p_Page:0,//单页
				'Cate'		=>	$p_Nav==5?$p_Cate:0,//产品
				'Down'		=>	$p_Down,//下拉
				'DownWidth'	=>	$p_DownWidth,//下拉框宽度
				'NewTarget'	=>	$p_NewTarget,//新窗口
				'NewTarget'	=>	$p_NewTarget,//新窗口
			);
		}
		if($p_Id==0){//添加
			$nav_data[]=$data;
		}else{//修改
			$nav_data[$p_Id-1]=$data;
		}
		$NavData=addslashes(str::json_data(str::str_code($nav_data, 'stripslashes')));
		manage::config_operaction(array($field=>$NavData), 'nav');
		manage::operation_log('修改导航设置');
		ly200::e_json('', 1);
	}

	public static function themes_nav_order(){//导航排序
		global $c;
		manage::check_permit('set.themes', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'p');
		$field=$p_Type=='nav'?'Headnav':($p_Type=='footer_nav'?'Footnav':'Topnav');
		$nav_row=db::get_value('config', "GroupId='nav' and Variable='{$field}'", 'Value');
		$nav_data=str::json_data($nav_row, 'decode');
		$sort_order=@explode('|', $p_sort_order);
		$data_ary=array();
		foreach((array)$sort_order as $v){
			$data_ary[]=$nav_data[$v];
		}
		$NavData=addslashes(str::json_data(str::str_code($data_ary, 'stripslashes')));
		manage::config_operaction(array($field=>$NavData), 'nav');
		manage::operation_log('导航排序');
		ly200::e_json('', 1);
	}

	public static function themes_nav_del(){
		global $c;
		manage::check_permit('set.themes', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$field=$g_Type=='nav'?'Headnav':($g_Type=='footer_nav'?'Footnav':'Topnav');
		$g_Id=(int)$g_Id;
		$nav_row=db::get_value('config', "GroupId='nav' and Variable='$field'", 'Value');
		$nav_data=str::json_data($nav_row, 'decode');
		unset($nav_data[$g_Id-1]);
		$NavData=addslashes(str::json_data(str::str_code($nav_data, 'stripslashes')));
		manage::config_operaction(array($field=>$NavData), 'nav');
		manage::operation_log('删除导航');
		ly200::e_json('', 1);
	}

	public static function themes_header_set(){
		global $c;
		manage::check_permit('set.themes', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$HeadIcon = (int)$p_icon;
		$HeadBg = '#'.trim($p_bg_color, '#');
		$HeadFixed = $p_fixed;
		manage::config_operaction(array(
			'HeadIcon'	=>	$HeadIcon,
			'HeadBg'	=>	$HeadBg,
			'HeadFixed'	=>	$HeadFixed
		), 'mobile');
		manage::operation_log('修改手机版头部');
		ly200::e_json('', 1);
	}

	public static function themes_footer_set(){
		global $c;
		manage::check_permit('set.themes', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$FootFont='#'.trim($p_font_color, '#'); //字体颜色
		$FootBg='#'.trim($p_bg_color, '#');
		$FootNav=array();
		/* 底部导航栏目 */
		$Url=(array)$p_Url;
		foreach($Url as $k=>$v){
			$_arr=array();
			foreach($c['manage']['language_web'] as $kk=>$vv){//多语言
				$_temp=(array)$_POST['Name_'.$vv];//保存提交的变量
				$_arr['Name_'.$vv]=$_temp[$k];//保存与url索引对应的名称
			}
			$_arr['Url']=$v;
			$FootNav[]=$_arr;
		}
		$FootNav = str::json_data($FootNav);
		manage::config_operaction(array(
			'FootFont'	=>	$FootFont,
			'FootBg'	=>	$FootBg,
			'FootNav'	=>	$FootNav
		), 'mobile');
		manage::operation_log('修改手机版底部');
		ly200::e_json('', 1);
	}

	public static function country_edit(){
		global $c;
		manage::check_permit('set.country', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$CId=(int)$p_CId;
		$p_IsUsed=(int)$p_IsUsed;
		$data=array(
			'Acronym'	=>	strtoupper($p_Acronym),
			'Code'		=>	$p_Code,
			'IsUsed'	=>	$p_IsUsed
		);
		(int)$p_Continent && $data['Continent']=$p_Continent;
		if(!$CId || $CId>240){
			$data['Country']=$p_Country;
		}
		if($CId){
			$logs='修改国家信息：'.str::str_code(db::get_value('country', "CId='{$CId}'", 'Country'));
			db::update('country', "CId='{$CId}'", $data);
		}else{
			$logs='添加国家：'.$p_Country;
			db::insert('country', $data);
		}
		manage::operation_log($logs);
		ly200::e_json('', 1);
	}

	public static function country_switch(){
		global $c;
		manage::check_permit('set.country', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_CId=(int)$g_CId;
		$g_Check=(int)$g_Check;
		$country_row=db::get_one('country', "CId='{$g_CId}'");
		$logs=($g_Check?'开启':'关闭').'国家：'.$country_row['Country'];
		if($g_Check==1){//开启
			$data=array('IsUsed'=>1);
		}else{//关闭
			$data=array('IsUsed'=>0);
		}
		db::update('country', "CId='{$g_CId}'", $data);
		manage::operation_log($logs);
		ly200::e_json(manage::language('{/global.'.($g_Check==1?'open':'close').'_success/}'), 1);
	}

	public static function country_del(){
		global $c;
		manage::check_permit('set.country', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$CId=(int)$g_CId;
		$logs='删除国家：'.str::str_code(db::get_value('country', "CId='{$CId}'", 'Country'));
		db::delete('country', "CId='{$CId}'");
		manage::operation_log($logs);
		ly200::e_json('', 1);
	}

	public static function third_party_code_edit(){
		global $c;
		manage::check_permit('set.third_party_code', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$p_TId=(int)$p_TId;
		$data=array(
			'Title'		=>	$p_Title,
			'Code'		=>	$p_Code,
			'CodeType'	=>	(int)$p_CodeType,
			'IsUsed'	=>	(int)$p_IsUsed,
			'IsMeta'	=>	(int)$p_IsMeta
		);
		if($p_TId){
			db::update('third', "TId='$p_TId'", $data);
			manage::operation_log('修改第三方代码');
		}else{
			$data['AccTime']=$c['time'];
			db::insert('third', $data);
			manage::operation_log('添加第三方代码');
		}
		ly200::e_json('', 1);
	}
	
	public static function third_party_code_used(){
		global $c;
		manage::check_permit('set.third_party_code', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$TId=(int)$p_TId;
		$p_IsUsed=(int)$p_IsUsed;
		$data=array('IsUsed'=>$p_IsUsed);
		db::update('third', "TId='$TId'", $data);
		manage::operation_log(($p_IsUsed?'开启':'关闭').'第三方代码-'.$TId);
		ly200::e_json(manage::language('{/global.'.($p_IsUsed==1?'open':'close').'_success/}'), 1);
	}

	public static function third_party_code_del(){
		global $c;
		manage::check_permit('set.third_party_code', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_id=ary::ary_format($g_id, 2);
		db::delete('third', "TId in($g_id)");
		manage::operation_log('删除第三方代码');
		ly200::e_json('', 1);
	}

	/******************************************************************************************************************************************************************/
	public static function manage_edit(){
		global $c;
		manage::check_permit('set.manage', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		substr_count($p_UserName, '.') && ly200::e_json('用户名不能带有“.”');
		$p_Locked=(int)$p_Locked==1?1:0;
		$p_GroupId=(int)$p_GroupId==1?1:2;
		$p_Method=(int)$p_Method==1?1:0;
		
		if($p_Method==1){
			$p_Password!='' && strlen($p_Password)<6 && ly200::e_json(manage::get_language('manage.manage.password_len_tips'));
		}else{
			(strlen($p_UserName)<6 || strlen($p_Password)<6) && ly200::e_json(manage::get_language('manage.manage.len_tips'));
		}
		$data=array(
			'Action'	=>	'ueeshop_web_manage_edit',
			'UserName'	=>	$p_UserName,
			'Locked'	=>	$p_Locked,
			'GroupId'	=>	$p_GroupId,
			'Method'	=>	$p_Method
		);
		$p_Password!='' && $data['Password']=str::password($p_Password);
		$result=ly200::api($data, $c['ApiKey'], $c['api_url']);
		
		if($p_GroupId==2){
			$Permit=addslashes(str::json_data((array)$p_permit));
			if(db::get_row_count('manage_permit', "UserName='$p_UserName'")){
				db::update('manage_permit', "UserName='$p_UserName'", array('Permit'=>$Permit));
			}else{
				db::insert('manage_permit', array('UserName'=>$p_UserName,'Permit'=>$Permit));
			}
		}
		
		manage::operation_log($p_Method==1?'编辑管理员':'添加管理员');
		ly200::e_json('', 1);
	}
	
	public static function manage_del(){
		global $c;
		manage::check_permit('set.manage', 1);
		$UserName=trim($_GET['u']);
		($_SESSION['Manage']['UserName'] && $_SESSION['Manage']['UserName']==$UserName) && js::location('./?m=set&a=manage', manage::get_language('set.manage.del_current_user'));
		$w="UserName='$UserName'";
		db::delete('manage_operation_log', $w);
		db::delete('manage_permit', $w);
		
		$data=array(
			'Action'	=>	'ueeshop_web_manage_del',
			'UserName'	=>	$UserName
		);
		$result=ly200::api($data, $c['ApiKey'], $c['api_url']);
		
		manage::operation_log('删除管理员');
		ly200::e_json('', 1);
	}
	/******************************************************************************************************************************************************************/
}
?>