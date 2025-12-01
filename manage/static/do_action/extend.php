<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

class extend_module{
	//内部链接管理 Start
	public static function seo_link_edit(){
		global $c;

		//----------------------------过滤敏感词-------------------------------
		$resultArr=str::key_filter();
		$resultArr[0]==1 && ly200::e_json($c['manage']['language']['global']['sensitive_word'].$resultArr[1], 0);
		//----------------------------过滤敏感词-------------------------------

		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$LId=(int)$p_LId;
		
		$data=array(
			'Url'		=>	$p_Url,
			'MyOrder'	=>	(int)$p_MyOrder
		);
		
		if($LId){
			db::update('link', "LId='$LId'", $data);
			manage::operation_log('修改内部链接');
		}else{
			$data['AccTime']=$c['time'];
			db::insert('link', $data);
			$LId=db::get_insert_id();
			manage::operation_log('添加内部链接');
		}
		manage::database_language_operation('link', "LId='$LId'", array('Keyword'=>1));
		ly200::e_json('', 1);
	}
	
	public static function seo_link_del(){
		global $c;
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_LId=(int)$g_LId;
		
		db::delete('link', "LId='$g_LId'");
		manage::operation_log('删除内部链接');
		js::location('./?m=extend&a=seo.link');
	}
	
	public static function seo_link_del_bat(){
		global $c;
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		!$g_group_lid && js::location('./?m=extend&a=seo.link');
		$del_where="LId in(".str_replace(array('-', '|'), ',', $g_group_lid).")";
		
		db::delete('link', $del_where);
		manage::operation_log('批量删除内部链接');
		js::location('./?m=extend&a=seo.link');
	}
	//内部链接管理 End
	
	//页面标题与标签管理 Start
	public static function seo_meta_edit(){
		global $c;

		//----------------------------过滤敏感词-------------------------------
		$resultArr=str::key_filter();
		$resultArr[0]==1 && ly200::e_json($c['manage']['language']['global']['sensitive_word'].$resultArr[1], 0);
		//----------------------------过滤敏感词-------------------------------

		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$alone_ary=array('home','products_list','case_list','info_list','blog', 'tuan', 'seckill');
		$much_ary=array('article'=>array('Title', 'AId'), 'info_category'=>array('Category', 'CateId'), 'info'=>array('Title', 'InfoId'), 'products_category'=>array('Category', 'CateId'), 'products'=>array('Name', 'ProId'));
		if(in_array($p_Type, $alone_ary)){
			$Id=(int)$p_MId;
			manage::database_language_operation('meta', "MId='$Id'", array('SeoTitle'=>1, 'SeoKeyword'=>1, 'SeoDescription'=>2));
		}else{
			$Id=(int)${'p_'.$much_ary[$p_Type][1]};
			!db::get_row_count($p_Type=='products'?'products_seo':$p_Type, "{$much_ary[$p_Type][1]}='$Id'") && db::insert($p_Type=='products'?'products_seo':$p_Type, array($much_ary[$p_Type][1] => $Id));
			manage::database_language_operation($p_Type=='products'?'products_seo':$p_Type, "{$much_ary[$p_Type][1]}='$Id'", array('SeoTitle'=>1, 'SeoKeyword'=>1, 'SeoDescription'=>2));
		}
		manage::operation_log('修改页面标题与标签管理');
		ly200::e_json($p_JumpUrl, 1);
	}
	//页面标题与标签管理 End
	
	//第三方代码管理 Start
	public static function seo_third_edit(){
		global $c;
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
	
	public static function seo_third_del(){
		global $c;
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_TId=(int)$g_TId;
		
		db::delete('third', "TId='$g_TId'");
		manage::operation_log('删除第三方代码');
		js::location('./?m=extend&a=seo.third');
	}
	
	public static function seo_third_del_bat(){
		global $c;
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		!$g_group_tid && js::location('./?m=extend&a=seo.third');
		$del_where="TId in(".str_replace(array('-', '|'), ',', $g_group_tid).")";
		
		db::delete('third', $del_where);
		manage::operation_log('批量删除第三方代码');
		js::location('./?m=extend&a=seo.third');
	}
	//第三方代码管理 End
	
	//网站地图 Start
	public static function seo_sitemap_edit(){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		include("{$c['root_path']}/inc/class/sitemap/sitemap.inc.php");
		include("{$c['root_path']}/inc/class/sitemap/config.inc.php");
		include("{$c['root_path']}/inc/class/sitemap/url_factory.inc.php");
		

		$obj=new Sitemap();
		$xmlHtml='';
		
		//header('Content-type: text/xml');
		$xmlHtml.='<?xml version="1.0" encoding="UTF-8"?>';
		$xmlHtml.='<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
		
		//首页
		$xmlHtml.='<url>';
			$xmlHtml.='<loc>'.$obj->_escapeXML(SITE_DOMAIN).'</loc>';
			$xmlHtml.='<changefreq>weekly</changefreq>';
		$xmlHtml.='</url>';
			  
		//产品列表页
		$row=str::str_code(db::get_all('products_category', '1', '*', $c['my_order'].'CateId asc'));
		foreach($row as $v){
			$xmlHtml.='<url>';
				$xmlHtml.='<loc>'.$obj->_escapeXML(SITE_DOMAIN.ly200::get_url($v, 'products_category')).'</loc>';
				$xmlHtml.='<changefreq>weekly</changefreq>';
			$xmlHtml.='</url>';
		}
				  
		//产品详细页
		$row=str::str_code(db::get_limit('products', '1', '*', $c['my_order'].'ProId desc', 0, 500));
		foreach($row as $v){
			$xmlHtml.='<url>';
				$xmlHtml.='<loc>'.$obj->_escapeXML(SITE_DOMAIN.ly200::get_url($v, 'products')).'</loc>';
				$xmlHtml.='<changefreq>weekly</changefreq>';
			$xmlHtml.='</url>';
		}
		
		//信息页
		$row=str::str_code(db::get_all('article', '1', '*', $c['my_order'].'AId asc'));
		foreach($row as $v){
			if($v['Url']) continue;
			$xmlHtml.='<url>';
				$xmlHtml.='<loc>'.$obj->_escapeXML(SITE_DOMAIN.ly200::get_url($v, 'article')).'</loc>';
				$xmlHtml.='<changefreq>weekly</changefreq>';
			$xmlHtml.='</url>';
		}
		
		//文章页
		$row=str::str_code(db::get_all('info', '1', '*', $c['my_order'].'CateId asc, InfoId desc'));
		foreach($row as $v){
			if($v['Url']) continue;
			$xmlHtml.='<url>';
				$xmlHtml.='<loc>'.$obj->_escapeXML(SITE_DOMAIN.ly200::get_url($v, 'info')).'</loc>';
				$xmlHtml.='<changefreq>weekly</changefreq>';
			$xmlHtml.='</url>';
		}
		
		$xmlHtml.='</urlset>';
		
		file::write_file('/', 'sitemap.xml', $xmlHtml);
		manage::config_operaction(array('AccTime'=>$c['time']), 'sitemap');
		manage::operation_log('生成网站地图');
		unset($xmlHtml);
		ly200::e_json('', 1);
	}
	//网站地图 End
	
	//博客设置
	public static function blog_set(){
		global $c;
		
		//----------------------------过滤敏感词-------------------------------
		$resultArr=str::key_filter();
		$resultArr[0]==1 && ly200::e_json($c['manage']['language']['global']['sensitive_word'].$resultArr[1], 0);
		//----------------------------过滤敏感词-------------------------------
		
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$Title=$p_Title;
		$Brief=$p_Brief;
		$name = (array)$p_name;
		$link = (array)$p_link;
		$Nav = array();
		$Ad=$p_Ad;
		
		//导航
		foreach ($name as $k=>$v){
			if ($v){
				$Nav[] = array(0=>$v,1=>$link[$k]);
			}
		}
		$Nav = str::json_data($Nav);
		
		//提交数据
		$data=array(
			'Title'		=>	$Title,
			'Brief'		=>	$Brief,
			'Nav'		=>	$Nav,
			'Ad'		=>	$Ad,
		);

		db::get_row_count('blog_config')?db::update('blog_config', 1, $data):db::insert('blog_config', $data);
		
		manage::operation_log('修改博客设置');
		ly200::e_json('', 1);
	}
	
	//博客管理 Start
	public static function blog_category_edit(){
		global $c;
		
		//----------------------------过滤敏感词-------------------------------
		$resultArr=str::key_filter();
		$resultArr[0]==1 && ly200::e_json($c['manage']['language']['global']['sensitive_word'].$resultArr[1], 0);
		//----------------------------过滤敏感词-------------------------------
		
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$CateId=(int)$p_CateId;
		$Category_en=$p_Category_en;
		$UnderTheCateId=(int)$p_UnderTheCateId;
		
		if($UnderTheCateId==0){
			$UId='0,';
			$Dept=1;
		}else{
			$UId=category::get_UId_by_CateId($UnderTheCateId, 'blog_category');
			$Dept=substr_count($UId, ',');
		}
		
		$data=array(
			'UId'			=>	$UId,
			'Category_en'	=>	$Category_en,
			'Dept'			=>	$Dept
		);
		
		if($CateId){
			db::update('blog_category', "CateId='$CateId'", $data);
			manage::operation_log('修改博客分类');
		}else{
			db::insert('blog_category', $data);
			$CateId=db::get_insert_id();
			manage::operation_log('添加博客分类');
		}
		//manage::database_language_operation('blog_category', "CateId='$CateId'", array('Category'=>1));
		
		$UId!='0,' && $CateId=category::get_top_CateId_by_UId($UId);
		$statistic_where.=category::get_search_where_by_CateId($CateId, 'blog_category');
		category::category_subcate_statistic('blog_category', $statistic_where);
		ly200::e_json('', 1);
	}
	
	public static function blog_category_del(){
		global $c;
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$CateId=(int)$g_CateId;
		$row=str::str_code(db::get_one('blog_category', "CateId='$CateId'", 'UId'));
		$del_where=category::get_search_where_by_CateId($CateId, 'blog_category');
		
		db::delete('blog_category', $del_where);
		manage::operation_log('删除博客分类');
		
		if($row['UId']!='0,'){
			$CateId=category::get_top_CateId_by_UId($row['UId']);
			$statistic_where=category::get_search_where_by_CateId($CateId, 'blog_category');
			category::category_subcate_statistic('blog_category', $statistic_where);
		}
		js::location('./?m=extend&a=blog.blog');
	}
	
	public static function blog_category_order(){
		global $c;
		$order=1;
		$sort_order=@array_filter(@explode('|', $_GET['sort_order']));
		foreach($sort_order as $v){
			db::update('blog_category', "CateId='$v'", array('MyOrder'=>$order++));
		}
		manage::operation_log('博客分类排序');
	}
	
	public static function blog_edit(){
		global $c;
		
		//----------------------------过滤敏感词-------------------------------
		$resultArr=str::key_filter();
		$resultArr[0]==1 && ly200::e_json($c['manage']['language']['global']['sensitive_word'].$resultArr[1], 0);
		//----------------------------过滤敏感词-------------------------------
		
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$AId=(int)$p_AId;
		$CateId=(int)$p_CateId;
		$Title=$p_Title;
		$Author=$p_Author;
		$SeoTitle=$p_SeoTitle;
		$SeoKeyword=$p_SeoKeyword;
		$SeoDescription=$p_SeoDescription;
		$BriefDescription=$p_BriefDescription;
		$IsHot=(int)$p_IsHot;
		$Tag=$p_Tag;
		$Content=$p_Content;
		$data=array(
			'CateId'			=>	(int)$p_CateId,
			'Title'				=>	$Title,
			'Author'			=>	$Author,
			'SeoTitle'			=>	$SeoTitle,
			'SeoKeyword'		=>	$SeoKeyword,
			'SeoDescription'	=>	$SeoDescription,
			'BriefDescription'	=>	$BriefDescription,
			'IsHot'				=>	$IsHot,
			'Tag'				=>	$Tag,
			'AccTime'			=>	$c['time'],
		);
		
		if($AId){
			db::update('blog', "AId='$AId'", $data);
			db::update('blog_content', "AId='$AId'", array('Content'=>$Content));
			manage::operation_log('修改博客');
		}else{
			db::insert('blog', $data);
			$AId=db::get_insert_id();
			db::insert('blog_content', array('AId'=>$AId, 'Content'=>$Content));
			manage::operation_log('添加博客');
		}
		
		ly200::e_json('', 1);
	}
	
	public static function blog_del(){
		global $c;
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_AId=(int)$g_AId;
		db::delete('blog', "AId='$g_AId'");
		db::delete('blog_content', "AId='$g_AId'");
		manage::operation_log('删除博客');
		js::location('./?m=extend&a=blog.blog');
	}
	
	public static function blog_del_bat(){
		global $c;
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		!$g_group_aid && js::location('./?m=extend&a=blog.blog');
		$del_where="AId in(".str_replace(array('-', '|'),',',$g_group_aid).")";
		db::delete('blog', $del_where);
		db::delete('blog_content', $del_where);
		manage::operation_log('批量删除博客');
		js::location('./?m=extend&a=blog.blog');
	}
	
	public static function blog_review(){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$RId = (int)$p_RId;
		$Reply = $p_Reply;
		db::update('blog_review', "RId='$RId'", array('Reply'=>$Reply));
		ly200::e_json('', 1);
	}
	
	public static function blog_review_del(){
		global $c;
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$RId = (int)$g_RId;
		$RId && db::delete('blog_review', "RId='$RId'");
		manage::operation_log('删除博客评论');
		js::location('./?m=extend&a=blog.review');
	}
	
	public static function blog_del_review_bat(){
		global $c;
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		!$g_group_rid && js::location('./?m=extend&a=blog.review');
		$del_where="RId in(".str_replace(array('-', '|'),',',$g_group_rid).")";
		db::delete('blog_review', $del_where);
		manage::operation_log('批量删除评论');
		js::location('./?m=extend&a=blog.review');
	}
	
	public static function analytics_set(){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		
		if(db::get_row_count('config', "GroupId='GoogleAnalytics' and Variable='client_id'")){
			db::update('config', "GroupId='GoogleAnalytics' and Variable='client_id'", array('Value'=>$p_Value));
		}else{
			db::insert('config', array(
					'GroupId'	=>	'GoogleAnalytics',
					'Variable'	=>	'client_id',
					'Value'		=>	$p_Value
				)
			);
		}
		
		manage::operation_log('修改 Google Analytics 设置');
		ly200::e_json('', 1);
	}
	
	public static function translate_set(){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		
		if(db::get_row_count('config', "GroupId='translate' and Variable='IsTranslate'")){
			db::update('config', "GroupId='translate' and Variable='IsTranslate'", array('Value'=>(int)$p_key));
		}else{
			db::insert('config', array(
					'GroupId'	=>	'translate',
					'Variable'	=>	'IsTranslate',
					'Value'		=>	(int)$p_key
				)
			);
		}
		
		manage::operation_log('修改 Google 翻译设置');
		ly200::e_json('', 1);
	}

	public static function translate_init(){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		
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
		if((int)$p_key==1){
			$LangArr[]=trim($p_lang);
		}else{
			foreach($LangArr as $k=>$v){
				if($v==@trim($p_lang)) unset($LangArr[$k]);
			}
		}
		
		db::update('config', "GroupId='translate' and Variable='TranLangs'", array('Value'=>str::json_data($LangArr)));
		
		ly200::e_json('', 1);
	}
}