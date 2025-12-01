<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

class seo_module{
	public static function overview_get_new_mission(){
		manage::check_permit('seo.overview', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$_POST=array('do_action'=>'process.get_new_mission');
		$result=manage::ueeseo_get_data('ueeshop_ueeseo_post_data', $_POST);
		manage::operation_log('领取本周任务');
		ly200::e_json($result['msg'], $result['ret']);
	}
	
	public static function keyword_add(){
		manage::check_permit('seo.keyword', 1);
		$_POST['do_action']='process.keyword_add';
		$result=manage::ueeseo_get_data('ueeshop_ueeseo_post_data', $_POST);
		manage::operation_log('添加关键词');
		ly200::e_json($result['msg'], $result['ret']);
	}

	public static function keyword_del(){
		manage::check_permit('seo.keyword', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$_POST=array(
			'do_action'	=>	'process.keyword_remove',
			'Id'		=>	(int)$g_id
		);
		$result=manage::ueeseo_get_data('ueeshop_ueeseo_post_data', $_POST);
		manage::operation_log('删除关键词');
		ly200::e_json($result['msg'], $result['ret']);
	}

	public static function article_close(){
		manage::check_permit('seo.article', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$_POST=array(
			'do_action'	=>	'process.article_close',
			'ArticleId'	=>	(int)$p_ArticleId
		);
		$result=manage::ueeseo_get_data('ueeshop_ueeseo_post_data', $_POST);
		manage::operation_log('站内优化永久关闭');
		ly200::e_json($result['msg'], $result['ret']);
	}

	public static function article_finish(){
		manage::check_permit('seo.article', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$_POST=array(
			'do_action'	=>	'process.article_finish',
			'ArticleId'	=>	(int)$p_ArticleId
		);
		$result=manage::ueeseo_get_data('ueeshop_ueeseo_post_data', $_POST);
		manage::operation_log('站内优化完成');
		ly200::e_json($result['msg'], $result['ret']);
	}

	public static function article_remind(){
		manage::check_permit('seo.article', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		!in_array($p_time, array('five', 'ten', 'month')) && $p_time='five';
		$_POST=array(
			'do_action'	=>	'process.article_'.$p_time,
			'ArticleId'	=>	(int)$p_ArticleId
		);
		$result=manage::ueeseo_get_data('ueeshop_ueeseo_post_data', $_POST);
		manage::operation_log('站内优化选时间提醒');
		ly200::e_json($result['msg'], $result['ret']);
	}

	public static function mobile_close(){
		manage::check_permit('seo.mobile', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$_POST=array(
			'do_action'	=>	'process.mobile_article_close',
			'ArticleId'	=>	(int)$p_ArticleId
		);
		$result=manage::ueeseo_get_data('ueeshop_ueeseo_post_data', $_POST);
		manage::operation_log('手机端优化永久关闭');
		ly200::e_json($result['msg'], $result['ret']);
	}

	public static function mobile_finish(){
		manage::check_permit('seo.mobile', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$_POST=array(
			'do_action'	=>	'process.mobile_article_finish',
			'ArticleId'	=>	(int)$p_ArticleId
		);
		$result=manage::ueeseo_get_data('ueeshop_ueeseo_post_data', $_POST);
		manage::operation_log('手机端优化完成');
		ly200::e_json($result['msg'], $result['ret']);
	}

	public static function mobile_remind(){
		manage::check_permit('seo.mobile', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		!in_array($p_time, array('five', 'ten', 'month')) && $p_time='five';
		$_POST=array(
			'do_action'	=>	'process.mobile_article_'.$p_time,
			'ArticleId'	=>	(int)$p_ArticleId
		);
		$result=manage::ueeseo_get_data('ueeshop_ueeseo_post_data', $_POST);
		manage::operation_log('手机端优化选时间提醒');
		ly200::e_json($result['msg'], $result['ret']);
	}

	public static function links_complete(){
		manage::check_permit('seo.links', 1);
		$_POST['do_action']='process.links_complete';
		$result=manage::ueeseo_get_data('ueeshop_ueeseo_post_data', $_POST);
		manage::operation_log('链接优化完成');
		ly200::e_json($result['msg'], $result['ret']);
	}

	public static function links_skip(){
		manage::check_permit('seo.links', 1);
		$_POST['do_action']='process.links_skip';
		$result=manage::ueeseo_get_data('ueeshop_ueeseo_post_data', $_POST);
		manage::operation_log('链接优化放弃');
		ly200::e_json($result['msg'], $result['ret']);
	}

	public static function ads_complete(){
		manage::check_permit('seo.ads', 1);
		$_POST['do_action']='process.ads_complete';
		$result=manage::ueeseo_get_data('ueeshop_ueeseo_post_data', $_POST);
		manage::operation_log('商机发布完成');
		ly200::e_json($result['msg'], $result['ret']);
	}

	public static function ads_skip(){
		manage::check_permit('seo.ads', 1);
		$_POST['do_action']='process.ads_skip';
		$result=manage::ueeseo_get_data('ueeshop_ueeseo_post_data', $_POST);
		manage::operation_log('商机发布放弃');
		ly200::e_json($result['msg'], $result['ret']);
	}

	public static function blog_reg(){
		manage::check_permit('seo.blog', 1);
		$_POST['do_action']='process.create_blog';
		$result=manage::ueeseo_get_data('ueeshop_ueeseo_post_data', $_POST);
		manage::operation_log('博客优化完成博客注册');
		ly200::e_json($result['msg'], $result['ret']);
	}

	public static function blog_complete(){
		manage::check_permit('seo.blog', 1);
		$_POST['do_action']='process.post_blog';
		$result=manage::ueeseo_get_data('ueeshop_ueeseo_post_data', $_POST);
		manage::operation_log('博客优化完成');
		ly200::e_json($result['msg'], $result['ret']);
	}

	//网站地图 Start
	public static function seo_sitemap_edit(){
		global $c;
		manage::check_permit('seo.sitemap', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		include("{$c['root_path']}/inc/class/sitemap/sitemap.inc.php");
		include("{$c['root_path']}/inc/class/sitemap/config.inc.php");
		include("{$c['root_path']}/inc/class/sitemap/url_factory.inc.php");
		$obj=new Sitemap();
		$domain_ary=array(
			//'https://www.fortune-pacific.net',
			//'https://es.fortune-pacific.net',
			'https://www.fortunepacific.net',
			// 'https://es.fortunepacific.net',
			//'https://www.fortunemachinetool.com',
			// 'https://es.fortunemachinetool.com',
			//'https://www.fortunepacific.vip',
			// 'https://es.fortunepacific.vip',
			//'https://www.fortunepacific.asia',
			//'https://es.fortunepacific.asia',
		);
		$products_category_row=str::str_code(db::get_all('products_category', '1', '*', $c['my_order'].'CateId asc'));
		$products_row=str::str_code(db::get_limit('products', '1', 'ProId,PageUrl,Name_en', $c['my_order'].'ProId desc', 0, 1500));
		$article_row=str::str_code(db::get_all('article', '1', '*', $c['my_order'].'AId asc'));
		$info_row=str::str_code(db::get_all('info', '1', '*', $c['my_order'].'CateId asc, InfoId desc'));
		foreach((array)$domain_ary as $domain){
			$xmlHtml='';
			//header('Content-type: text/xml');
			$xmlHtml.='<?xml version="1.0" encoding="UTF-8"?>';
			$xmlHtml.='<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

			//首页
			$xmlHtml.='<url>';
				$xmlHtml.='<loc>'.$obj->_escapeXML($domain).'</loc>';
				$xmlHtml.='<changefreq>weekly</changefreq>';
			$xmlHtml.='</url>';

			//产品列表页			
			foreach($products_category_row as $v){
				$xmlHtml.='<url>';
					$xmlHtml.='<loc>'.$obj->_escapeXML($domain.web::get_url($v, 'products_category')).'</loc>';
					$xmlHtml.='<changefreq>weekly</changefreq>';
				$xmlHtml.='</url>';
			}

			//产品详细页			
			foreach($products_row as $v){
				$xmlHtml.='<url>';
					$xmlHtml.='<loc>'.$obj->_escapeXML($domain.web::get_url($v, 'products')).'</loc>';
					$xmlHtml.='<changefreq>weekly</changefreq>';
				$xmlHtml.='</url>';
			}

			//信息页			
			foreach($article_row as $v){
				if($v['Url']) continue;
				$xmlHtml.='<url>';
					$xmlHtml.='<loc>'.$obj->_escapeXML($domain.web::get_url($v, 'article')).'</loc>';
					$xmlHtml.='<changefreq>weekly</changefreq>';
				$xmlHtml.='</url>';
			}

			//文章页			
			foreach($info_row as $v){
				if($v['Url']) continue;
				$xmlHtml.='<url>';
					$xmlHtml.='<loc>'.$obj->_escapeXML($domain.web::get_url($v, 'info')).'</loc>';
					$xmlHtml.='<changefreq>weekly</changefreq>';
				$xmlHtml.='</url>';
			}


			$xmlHtml.='<url>';
				$xmlHtml.='<loc>'.$obj->_escapeXML($domain.'/sitemap.html').'</loc>';
				$xmlHtml.='<changefreq>weekly</changefreq>';
			$xmlHtml.='</url>';

			$xmlHtml.='</urlset>';
			$name=trim(str_replace(array('http://','https://','.'), array('','','_'), $domain),'/');
			//file::write_file('/', 'sitemap_'.$name.'.xml', $xmlHtml);
			file::write_file('/', 'sitemap.xml', $xmlHtml);
			manage::config_operaction(array('AccTime'=>$c['time']), 'sitemap');
			manage::operation_log('生成网站地图'.$domain);
			unset($xmlHtml);
		}
		ly200::e_json('', 1);
	}
	//网站地图 End

	// 描述管理 Start
	public static function description_del(){
		global $c;
		manage::check_permit('seo.description', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_id=ary::ary_format($g_id, 2);
		db::delete('seo_description', "DId in($g_id)");
		manage::operation_log('删除SEO描述');
		ly200::e_json('', 1);
	}

	public static function description_edit(){
		global $c;
		manage::check_permit('seo.description', 1);
		foreach((array)$c['manage']['language_web'] as $k=>$v){
			$_POST['Description_'.$v] = str_replace(array('【', '】'),array('[', ']'),$_POST['Description_'.$v]);
		}
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$DId = (int)$p_DId;
		if($DId){
			manage::operation_log('修改SEO描述');
		}else{
			db::insert('seo_description', array());
			$DId=db::get_insert_id();
			manage::operation_log('添加SEO描述');
		}
		manage::database_language_operation('seo_description', "DId='$DId'", array('Description'=>2));
		ly200::e_json('', 1);
	}
	//描述管理 End
}
?>