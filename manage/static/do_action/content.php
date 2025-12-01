<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

class content_module{
	public static function page_del(){
		global $c;
		manage::check_permit('content.page', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_id=ary::ary_format($g_id, 2);
		$del_where="AId in($g_id)";
		db::delete('article', $del_where);
		db::delete('article_content', $del_where);
		manage::operation_log('删除单页');
		ly200::e_json('', 1);
	}

	public static function page_my_order(){
		global $c;
		manage::check_permit('content.page', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$p_Number=(int)$p_Number;
		db::update('article', "AId='{$p_AId}'", array('MyOrder'=>$p_Number));
		manage::operation_log('单页排序');
		ly200::e_json(manage::language("{/global.my_order_ary.$p_Number/}"), 1);
	}

	public static function page_edit(){
		global $c;
		manage::check_permit('content.page', 1);
		//----------------------------过滤敏感词-------------------------------
		$resultArr=manage::keywords_filter();
		$resultArr[0]==1 && ly200::e_json(manage::language('{/global.sensitive_word/}').$resultArr[1]);
		//----------------------------过滤敏感词-------------------------------

		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$AId=(int)$p_AId;

		$data=array(
			'CateId'	=>	(int)$p_CateId,
			'IsFeed'	=>	(int)$p_IsFeed,
			//'Url'		=>	@substr_count($p_Url, 'http://')||@substr_count($p_Url, 'https://')?$p_Url:'',
			'Url'		=>	$p_Url,
			'AccTime'	=>	$c['time'],
			'MyOrder'	=>	(int)$p_MyOrder
		);

		if($AId){
			$data['PageUrl']=str::str_to_url($_POST['Title_en'])."-{$AId}.html";
			db::update('article', "AId='$AId'", $data);
			manage::operation_log('修改单页:'.$_POST['Title_'.$c['config']['global']['LanguageDefault']]);
		}else{
			db::insert('article', $data);
			$AId=db::get_insert_id();
			db::update('article', "AId='$AId'", array('PageUrl'=>str::str_to_url($_POST['Title_en'])."-{$AId}.html"));
			db::insert('article_content', array('AId'=>$AId));
			manage::operation_log('添加单页:'.$_POST['Title_'.$c['config']['global']['LanguageDefault']]);
		}
		manage::database_language_operation('article', "AId='$AId'", array('Title'=>1, 'SeoTitle'=>1, 'SeoKeyword'=>1, 'SeoDescription'=>2));
		manage::database_language_operation('article_content', "AId='$AId'", array('Content'=>3));
		ly200::e_json(array('jump'=>$p_back_action?$p_back_action:"?m=content&a=page&CateId=$p_CateId"), 1);
	}

	public static function page_category_del(){
		global $c;
		manage::check_permit('content.page', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_id=ary::ary_format($g_id, 2);
		$cant_delete=@array_intersect(@explode(',',$g_id), array(1,2,3,13));
		count($cant_delete) && ly200::e_json(manage::language('{/content.page.category_del_notes/}'));
		db::delete('article_category', "CateId in ($g_id)");
		manage::operation_log('删除单页分类');
		ly200::e_json('', 1);
	}
	public static function page_category_order(){
		global $c;
		manage::check_permit('content.page', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$order=1;
		$g_sort_order=ary::ary_format($g_sort_order, 1);
		foreach((array)$g_sort_order as $v){
			db::update('article_category', "CateId='$v'", array('MyOrder'=>$order++));
		}
		manage::operation_log('单页分类排序');
		ly200::e_json('', 1);
	}

	public static function page_category_edit(){
		global $c;
		manage::check_permit('content.page', 1);
		manage::keywords_filter();
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$CateId=(int)$p_CateId;
		$data=array(
			'UId'	=>	'0,',
			'Dept'	=>	1,
		);
		if($CateId){
			db::update('article_category', "CateId='$CateId'", $data);
			manage::operation_log('修改单页分类');
		}else{
			db::insert('article_category', $data);
			$CateId=db::get_insert_id();
			manage::operation_log('添加单页分类');
		}
		//manage::database_language_operation('article_category', "CateId='$CateId'", array('Category'=>1, 'SeoTitle'=>1, 'SeoKeyword'=>1, 'SeoDescription'=>2));
		manage::database_language_operation('article_category', "CateId='$CateId'", array('Category'=>1));
		ly200::e_json('', 1);
	}

	public static function info_del(){
		global $c;
		manage::check_permit('content.info', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_id=ary::ary_format($g_id, 2);
		$del_where="InfoId in($g_id)";
		db::delete('info', $del_where);
		db::delete('info_content', $del_where);
		manage::operation_log('删除删除文章');
		ly200::e_json('', 1);
	}

	public static function info_edit(){
		global $c;
		manage::check_permit('content.info', 1);
		//----------------------------过滤敏感词-------------------------------
		$resultArr=manage::keywords_filter();
		$resultArr[0]==1 && ly200::e_json(manage::language('{/global.sensitive_word/}').$resultArr[1]);
		//----------------------------过滤敏感词-------------------------------

		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$InfoId=(int)$p_InfoId;
		$ImgPath=$p_PicPath;
		$AccTime=strtotime($p_AccTime);
		$data=array(
			'CateId'	=>	(int)$p_CateId,
			'Url'		=>	$p_Url,
			'PicPath'	=>	$ImgPath,
			'PageUrl'	=>	str::str_to_url($p_PageUrl),
			'IsIndex'	=>	(int)$p_IsIndex,
			'AccTime'	=>	$AccTime,
			'MyOrder'	=>	(int)$p_MyOrder
		);

		if($InfoId){
			db::update('info', "InfoId='$InfoId'", $data);
			manage::operation_log('修改文章:'.$_POST['Title_'.$c['config']['global']['LanguageDefault']]);
		}else{
			$data['AccTime']=$c['time'];
			db::insert('info', $data);
			$InfoId=db::get_insert_id();
			db::insert('info_content', array('InfoId'=>$InfoId));
			manage::operation_log('添加文章:'.$_POST['Title_'.$c['config']['global']['LanguageDefault']]);
		}
		manage::database_language_operation('info', "InfoId='$InfoId'", array('Title'=>1, 'SeoTitle'=>1, 'SeoKeyword'=>1, 'SeoDescription'=>2, 'BriefDescription'=>2));
		manage::database_language_operation('info_content', "InfoId='$InfoId'", array('Content'=>3));
		ly200::e_json(array('jump'=>$p_back_action?$p_back_action:"?m=content&a=info&CateId=$p_CateId"), 1);
	}

	public static function info_category_del(){
		global $c;
		manage::check_permit('content.info', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_id=ary::ary_format($g_id, 2);
		db::delete('info_category', "CateId in($g_id)");
		manage::operation_log('删除文章分类');
		ly200::e_json('', 1);
	}

	public static function info_category_order(){
		global $c;
		manage::check_permit('content.info', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$order=1;
		$g_sort_order=ary::ary_format($g_sort_order, 1);
		foreach((array)$g_sort_order as $v){
			db::update('info_category', "CateId='$v'", array('MyOrder'=>$order++));
		}
		manage::operation_log('文章分类排序');
		ly200::e_json('', 1);
	}

	public static function info_category_edit(){
		global $c;
		manage::check_permit('content.info', 1);
		//----------------------------过滤敏感词-------------------------------
		$resultArr=manage::keywords_filter();
		$resultArr[0]==1 && ly200::e_json(manage::language('{/global.sensitive_word/}').$resultArr[1]);
		//----------------------------过滤敏感词-------------------------------

		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$CateId=(int)$p_CateId;
		$UnderTheCateId=(int)$p_UnderTheCateId;

		if($UnderTheCateId==0){
			$UId='0,';
			$Dept=1;
		}else{
			$UId=category::get_UId_by_CateId($UnderTheCateId, 'info_category');
			$Dept=substr_count($UId, ',');
		}

		$data=array(
			'UId'		=>	$UId,
			'Dept'		=>	$Dept
		);

		if($CateId){
			db::update('info_category', "CateId='$CateId'", $data);
			manage::operation_log('修改文章分类:'.$_POST['Category_'.$c['config']['global']['LanguageDefault']]);
		}else{
			db::insert('info_category', $data);
			$CateId=db::get_insert_id();
			manage::operation_log('添加文章分类:'.$_POST['Category_'.$c['config']['global']['LanguageDefault']]);
		}
		manage::database_language_operation('info_category', "CateId='$CateId'", array('Category'=>1,'SeoTitle'=>1, 'SeoKeyword'=>1, 'SeoDescription'=>2));

		$UId!='0,' && $CateId=category::get_top_CateId_by_UId($UId);
		$statistic_where.=category::get_search_where_by_CateId($CateId, 'info_category');
		category::category_subcate_statistic('info_category', $statistic_where);
		ly200::e_json('', 1);
	}

	public static function partner_del(){
		global $c;
		manage::check_permit('content.partner', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_id=ary::ary_format($g_id, 2);
		db::delete('partners', "PId in($g_id)");
		manage::operation_log('删除友情链接');
		ly200::e_json('', 1);
	}

	public static function partner_edit(){
		global $c;
		manage::check_permit('content.partner', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$PId=(int)$p_PId;
		$Url=$p_Url;
		$MyOrder=$p_MyOrder;
		$PicPath=$p_PicPath;

		$data=array(
			'Url'		=>	$Url,
			'PicPath'	=>	$PicPath,
			'AccTime'	=>	$c['time'],
			'MyOrder'	=>	(int)$MyOrder
		);

		if($PId){
			db::update('partners', "PId='$PId'", $data);
			manage::operation_log('修改友情链接');
		}else{
			db::insert('partners', $data);
			$PId=db::get_insert_id();
			manage::operation_log('添加友情链接');
		}
		manage::database_language_operation('partners', "PId='$PId'", array('Name'=>2));
		ly200::e_json(array('jump'=>$p_back_action?$p_back_action:"?m=content&a=partner"), 1);
	}
	
	public static function case_del(){
		global $c;
		manage::check_permit('content.case', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_id=ary::ary_format($g_id, 2);
		$del_where="CaseId in($g_id)";
		$row=str::str_code(db::get_all('`case`', $del_where, 'PicPath_0, PicPath_1, PicPath_2, PicPath_3, PicPath_4'));
		$resize_ary=$c['manage']['resize_ary']['case'];
		foreach($row as $v){
			for($i=0; $i<5; $i++){
				$PicPath=$v["PicPath_$i"];
				if(is_file($c['root_path'].$PicPath)){
					foreach($resize_ary as $v2){
						$ext_name=file::get_ext_name($PicPath);
						file::del_file($PicPath.".{$v2}.{$ext_name}");
					}
					file::del_file($PicPath);
				}
			}
		}
		db::delete('`case`', $del_where);
		db::delete('case_description', $del_where);
		manage::operation_log('删除案例');
		ly200::e_json('', 1);
	}

	public static function case_edit(){
		global $c;
		manage::check_permit('content.case', 1);
		//----------------------------过滤敏感词-------------------------------
		$resultArr=manage::keywords_filter();
		$resultArr[0]==1 && ly200::e_json(manage::language('{/global.sensitive_word/}').$resultArr[1]);
		//----------------------------过滤敏感词-------------------------------

		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		//基本信息
		$CaseId=(int)$p_CaseId;//案例Id
		$CateId=(int)$p_CateId;//分类Id
		$PicPath=$p_PicPath;
		$Description=$p_Description;

		if(!count($PicPath)) ly200::e_json(manage::get_language('case.list.pic_tips'));

		//图片上传
		$ImgPath=array();
		$resize_ary=$c['manage']['resize_ary']['case'];
		$save_dir=$c['manage']['upload_dir'].$c['manage']['sub_save_dir']['case'].date('d/');
		file::mk_dir($save_dir);
		foreach((array)$PicPath as $k=>$v){
			$ImgPath[$k]=file::photo_tmp_upload($v, $save_dir, $resize_ary);
		}
		foreach((array)$PicPath as $k=>$v){
			$ext_name=file::get_ext_name($v);
			foreach($resize_ary as $v2){
				if(!is_file($c['root_path'].$v.".{$v2}.{$ext_name}")){
					$size_w_h=explode('x', $v2);
					$resize_path=img::resize($v, $size_w_h[0], $size_w_h[1]);
				}
			}
			if(!is_file($c['root_path'].$v.".default.{$ext_name}")){
				@copy($c['root_path'].$v, $c['root_path'].$v.".default.{$ext_name}");
			}
		}

		$data=array(
			'CateId'				=>	$CateId,
			'Number'				=>	$p_Number,
			'PicPath_0'				=>	$ImgPath[0],
			'PicPath_1'				=>	$ImgPath[1],
			'PicPath_2'				=>	$ImgPath[2],
			'PicPath_3'				=>	$ImgPath[3],
			'PicPath_4'				=>	$ImgPath[4],
			'Url'					=>	@substr_count($p_Url, 'http://')?$p_Url:'',
			'PageUrl'				=>	str::str_to_url($p_PageUrl),
			'IsHot'					=>	(int)$p_IsHot,
			'IsIndex'				=>	(int)$p_IsIndex,
			'MyOrder'				=>	(int)$p_MyOrder
		);

		if($CaseId){
			$data['EditTime']=$c['time'];
			db::update('`case`', "CaseId='$CaseId'", $data);
			if(!db::get_row_count('case_description', "CaseId='$CaseId'")){
				db::insert('case_description', array('CaseId'=>$CaseId));
			}
			manage::operation_log('修改案例:'.$_POST['Name_'.$c['config']['global']['LanguageDefault']]);
		}else{
			$data['AccTime']=$c['time'];
			db::insert('`case`', $data);
			$CaseId=db::get_insert_id();
			db::insert('case_description', array('CaseId'=>$CaseId));
			manage::operation_log('添加案例:'.$_POST['Name_'.$c['config']['global']['LanguageDefault']]);
		}

		manage::database_language_operation('`case`', "CaseId='$CaseId'", array('Name'=>1, 'BriefDescription'=>2, 'SeoTitle'=>1, 'SeoKeyword'=>1, 'SeoDescription'=>2));
		manage::database_language_operation('case_description', "CaseId='$CaseId'", array('Description'=>3));
		ly200::e_json(array('jump'=>$p_back_action?$p_back_action:"?m=content&a=case&CateId=$CateId"), 1);
	}

	public static function case_img_del(){	//删除单个案例图片
		global $c;
		manage::check_permit('content.case', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$Model=$g_Model;
		$PicPath=$g_Path;
		$Index=(int)$g_Index;
		$resize_ary=$c['manage']['resize_ary']['case'];	//case
		if(is_file($c['root_path'].$PicPath)){
			foreach($resize_ary as $v){
				$ext_name=file::get_ext_name($PicPath);
				file::del_file($PicPath.".{$v}.{$ext_name}");
			}
			file::del_file($PicPath);
		}
		ly200::e_json(array($Index), 1);
	}

	public static function case_category_del(){
		global $c;
		manage::check_permit('content.case', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_id=ary::ary_format($g_id, 1);
		foreach($g_id as $v){
			$row=db::get_one('case_category', "CateId='$v'");
			$del_where=category::get_search_where_by_CateId($v, 'case_category');
			db::delete('case_category_description', $del_where);
			db::delete('case_category', $del_where);
			manage::operation_log('删除案例分类:'.$row['Category_'.$c['manage']['config']['LanguageDefault']]);
			if($row['UId']!='0,'){
				$v=category::get_top_CateId_by_UId($row['UId']);
				category::category_subcate_statistic('case_category', "CateId='$v' or UId like '%,{$v},%'");//$statistic_where
			}
		}
		ly200::e_json('', 1);
	}

	public static function case_category_order(){
		global $c;
		manage::check_permit('content.case', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$order=1;
		$g_sort_order=ary::ary_format($g_sort_order, 1);
		foreach((array)$g_sort_order as $v){
			db::update('case_category', "CateId='$v'", array('MyOrder'=>$order++));
		}
		manage::operation_log('案例分类排序');
		ly200::e_json('', 1);
	}

	public static function case_category_edit(){
		global $c;
		manage::check_permit('content.case', 1);
		//----------------------------过滤敏感词-------------------------------
		$resultArr=manage::keywords_filter();
		$resultArr[0]==1 && ly200::e_json(manage::language('{/global.sensitive_word/}').$resultArr[1]);
		//----------------------------过滤敏感词-------------------------------

		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$CateId=(int)$p_CateId;
		$UnderTheCateId=(int)$p_UnderTheCateId;
		$PicPath=$p_PicPath;
		if($UnderTheCateId==0){
			$UId='0,';
			$Dept=1;
		}else{
			$UId=category::get_UId_by_CateId($UnderTheCateId, 'case_category');
			$Dept=substr_count($UId, ',');
		}

		$data=array(
			'UId'		=>	$UId,
			'PicPath'	=>	$PicPath,
			'Dept'		=>	$Dept,
		);

		if($CateId){
			db::update('case_category', "CateId='$CateId'", $data);
			manage::operation_log('修改案例分类:'.$_POST['Category_'.$c['config']['global']['LanguageDefault']]);
		}else{
			db::insert('case_category', $data);
			$CateId=db::get_insert_id();
			db::insert('case_category_description', array('CateId'=>$CateId));
			manage::operation_log('添加案例分类:'.$_POST['Category_'.$c['config']['global']['LanguageDefault']]);
		}
		manage::database_language_operation('case_category', "CateId='$CateId'", array('Category'=>1, 'SeoTitle'=>1, 'SeoKeyword'=>1, 'SeoDescription'=>2));
		manage::database_language_operation('case_category_description', "CateId='$CateId'", array('Description'=>3));

		$UId!='0,' && $CateId=category::get_top_CateId_by_UId($UId);
		$statistic_where.=category::get_search_where_by_CateId($CateId, 'case_category');
		category::category_subcate_statistic('case_category', $statistic_where);
		ly200::e_json('', 1);
	}

	public static function download_del(){
		global $c;
		manage::check_permit('content.download', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_id=ary::ary_format($g_id, 2);
		$del_where="DId in($g_id)";
		$row=str::str_code(db::get_all('download', $del_where, 'FilePath'));
		foreach($row as $v){
			file::del_file($v['FilePath']);
		}
		db::delete('download', $del_where);
		db::delete('download_description', $del_where);
		manage::operation_log('删除下载');
		ly200::e_json('', 1);
	}

	public static function download_edit(){
		global $c;
		manage::check_permit('content.download', 1);
		//----------------------------过滤敏感词-------------------------------
		$resultArr=manage::keywords_filter();
		$resultArr[0]==1 && ly200::e_json(manage::language('{/global.sensitive_word/}').$resultArr[1]);
		//----------------------------过滤敏感词-------------------------------

		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		//基本信息
		$DId=(int)$p_DId;//下载Id
		$CateId=(int)$p_CateId;//分类Id
		$PicPath=$p_PicPath;
		$IsMember=(int)$p_IsMember;//是否会员可见
		$IsOth=(int)$p_IsOth;
		$FilePath=$p_FilePath;
		if(@is_file($c['root_path'].$p_FilePath)){
			$save_dir=str_replace('/u_file/', '/u_file/file/', $c['manage']['upload_dir']).date('d/');
			file::mk_dir($save_dir);
			$FilePath=file::photo_tmp_upload($p_FilePath, $save_dir);
		}

		$data=array(
			'CateId'	=>	$CateId,
			'IsMember'	=>	$IsMember,
			'PicPath'	=>	$PicPath,
			'FilePath'	=>	$FilePath,
			'FileName'	=>	$p_FileName,
			'MyOrder'	=>	(int)$p_MyOrder,
			'IsOth'		=>	$IsOth,
			'Password'	=>	$p_Password,
		);

		if($DId){
			$sFilePath=$p_sFilePath;
			$sFileName=$p_sFileName;
			if ($data['FilePath']==''){
				$data['FileName']='';
				$sFilePath && file::del_file($sFilePath);//删除旧文件
			}elseif($data['FilePath']!=$sFilePath){
				file::del_file($sFilePath);
			}
			$data['EditTime']=$c['time'];
			db::update('download', "DId='$DId'", $data);
			if(!db::get_row_count('download_description', "DId='$DId'")){
				db::insert('download_description', array('DId'=>$DId));
			}
			manage::operation_log('修改下载');
		}else{
			$data['AccTime']=$c['time'];
			db::insert('download', $data);
			$DId=db::get_insert_id();
			db::insert('download_description', array('DId'=>$DId));
			manage::operation_log('添加下载');
		}

		manage::database_language_operation('download', "DId='$DId'", array('Name'=>1, 'BriefDescription'=>2, 'SeoTitle'=>1, 'SeoKeyword'=>1, 'SeoDescription'=>2));
		manage::database_language_operation('download_description', "DId='$DId'", array('Description'=>3));
		ly200::e_json(array('jump'=>$p_back_action?$p_back_action:"?m=content&a=download&CateId=$CateId"), 1);
	}

	public static function download_category_edit(){
		global $c;
		manage::check_permit('content.download', 1);
		//----------------------------过滤敏感词-------------------------------
		$resultArr=manage::keywords_filter();
		$resultArr[0]==1 && ly200::e_json(manage::language('{/global.sensitive_word/}').$resultArr[1]);
		//----------------------------过滤敏感词-------------------------------

		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$CateId=(int)$p_CateId;
		$UnderTheCateId=(int)$p_UnderTheCateId;
		$PicPath=$p_PicPath;
		if($UnderTheCateId==0){
			$UId='0,';
			$Dept=1;
		}else{
			$UId=category::get_UId_by_CateId($UnderTheCateId, 'download_category');
			$Dept=substr_count($UId, ',');
		}

		$data=array(
			'UId'		=>	$UId,
			'PicPath'	=>	$PicPath,
			'Dept'		=>	$Dept,
		);

		if($CateId){
			db::update('download_category', "CateId='$CateId'", $data);
			manage::operation_log('修改下载分类');
		}else{
			db::insert('download_category', $data);
			$CateId=db::get_insert_id();
			db::insert('download_category_description', array('CateId'=>$CateId));
			manage::operation_log('添加下载分类');
		}
		manage::database_language_operation('download_category', "CateId='$CateId'", array('Category'=>1, 'SeoTitle'=>1, 'SeoKeyword'=>1, 'SeoDescription'=>2));
		manage::database_language_operation('download_category_description', "CateId='$CateId'", array('Description'=>3));

		$UId!='0,' && $CateId=category::get_top_CateId_by_UId($UId);
		$statistic_where.=category::get_search_where_by_CateId($CateId, 'download_category');
		category::category_subcate_statistic('download_category', $statistic_where);
		ly200::e_json('', 1);
	}

	public static function download_category_del(){
		global $c;
		manage::check_permit('content.download', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_id=ary::ary_format($g_id, 1);
		foreach($g_id as $v){
			$row=db::get_one('download_category', "CateId='$v'");
			$del_where=category::get_search_where_by_CateId($v, 'download_category');
			db::delete('download_category_description', $del_where);
			db::delete('download_category', $del_where);
			manage::operation_log('删除下载分类:'.$row['Category_'.$c['manage']['config']['LanguageDefault']]);
			if($row['UId']!='0,'){
				$CateId=category::get_top_CateId_by_UId($row['UId']);
				$statistic_where=category::get_search_where_by_CateId($CateId, 'download_category');
				category::category_subcate_statistic('download_category', $statistic_where);
			}
		}
		ly200::e_json('', 1);
	}

	public static function download_category_order(){
		global $c;
		manage::check_permit('content.download', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$order=1;
		$g_sort_order=ary::ary_format($g_sort_order, 1);
		foreach((array)$g_sort_order as $v){
			db::update('download_category', "CateId='$v'", array('MyOrder'=>$order++));
		}
		manage::operation_log('下载分类排序');
		ly200::e_json('', 1);
	}

	/* blog start*/
	public static function blog_set(){
		global $c;
		manage::check_permit('content.blog', 1);
		manage::keywords_filter();
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$name=(array)$p_name;
		$link=(array)$p_link;
		$Nav=array();
		foreach($name as $k=>$v){//导航
			$v && $Nav[]=array($v, $link[$k]);
		}
		$Nav=addslashes(str::json_data(str::str_code($Nav, 'stripslashes')));
		$data=array(
			'Title'				=>	$p_Title,
			'BriefDescription'	=>	$p_BriefDescription,
			'NavData'			=>	$Nav,
			'Banner'			=>	$p_Banner
		);
		manage::config_operaction($data, 'blog');
		manage::operation_log('修改博客设置');
		ly200::e_json('', 1);
	}

	public static function blog_edit(){
		global $c;
		manage::check_permit('content.blog', 1);
		manage::keywords_filter();
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$p_AId=(int)$p_AId;
		$p_CateId=(int)$p_CateId;
		$p_IsHot=(int)$p_IsHot;

		$Tags=explode('|',$p_Tag);
		$Tags=array_filter($Tags);
		$Tags=$Tags?'|'.implode('|',$Tags).'|':'';

		$data=array(
			'CateId'			=>	(int)$p_CateId,
			'Title'				=>	$p_Title,
			'PicPath'			=>	$p_PicPath,
			'Author'			=>	$p_Author,
			'SeoTitle'			=>	$p_SeoTitle,
			'SeoKeyword'		=>	$p_SeoKeyword,
			'SeoDescription'	=>	$p_SeoDescription,
			'BriefDescription'	=>	$p_BriefDescription,
			'IsHot'				=>	$p_IsHot,
			'Tag'				=>	$Tags,
			'AccTime'			=>	$c['time'],
		);
		if($p_AId){
			db::update('blog', "AId='$p_AId'", $data);
			db::update('blog_content', "AId='$p_AId'", array('Content'=>$p_Content));
			manage::operation_log('修改博客');
		}else{
			db::insert('blog', $data);
			$AId=db::get_insert_id();
			db::insert('blog_content', array('AId'=>$AId, 'Content'=>$p_Content));
			manage::operation_log('添加博客');
		}
		ly200::e_json(array('jump'=>$p_back_action?$p_back_action:"?m=content&a=blog&d=blog&CateId=$p_CateId"), 1);
	}

	public static function blog_edit_myorder(){
		global $c;
		manage::check_permit('content.blog', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$p_Number=(int)$p_Number;
		db::update('blog', "AId='{$p_Id}'", array('MyOrder'=>$p_Number));
		manage::operation_log('博客修改排序');
		ly200::e_json(manage::language(manage::language("{/global.my_order_ary.$p_Number/}")), 1);
	}

	public static function blog_del(){
		global $c;
		manage::check_permit('content.blog', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_id=ary::ary_format($g_id, 2);
		$del_where="AId in ($g_id)";
		db::delete('blog', $del_where);
		db::delete('blog_content', $del_where);
		manage::operation_log('删除博客');
		ly200::e_json('', 1);
	}

	public static function blog_category_edit(){
		global $c;
		manage::check_permit('content.blog', 1);
		manage::keywords_filter();
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$p_CateId=(int)$p_CateId;
		$p_UnderTheCateId=(int)$p_UnderTheCateId;
		if($p_UnderTheCateId==0){
			$UId='0,';
			$Dept=1;
		}else{
			$UId=category::get_UId_by_CateId($p_UnderTheCateId, 'blog_category');
			$Dept=substr_count($UId, ',');
		}
		$data=array(
			'UId'			=>	$UId,
			'Category_en'	=>	$p_Category_en,
			'Dept'			=>	$Dept
		);
		if($p_CateId){
			db::update('blog_category', "CateId='$p_CateId'", $data);
			manage::operation_log('修改博客分类');
		}else{
			db::insert('blog_category', $data);
			$p_CateId=db::get_insert_id();
			manage::operation_log('添加博客分类');
		}
		$UId!='0,' && $p_CateId=category::get_top_CateId_by_UId($UId);
		$statistic_where.=category::get_search_where_by_CateId($p_CateId, 'blog_category');
		category::category_subcate_statistic('blog_category', $statistic_where);
		ly200::e_json('', 1);
	}

	public static function blog_category_order(){
		global $c;
		manage::check_permit('content.blog', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$order=1;
		$sort_order=@array_filter(@explode(',', $g_sort_order));
		if($sort_order){
			$sql="UPDATE `blog_category` SET `MyOrder`:CASE `CateId`";
			foreach((array)$sort_order as $v){
				$sql.=" WHEN $v THEN ".$order++;
			}
			$sql.=" END WHERE `CateId` IN ($g_sort_order)";
			db::query($sql);
		}
		manage::operation_log('批量博客分类排序');
		ly200::e_json('', 1);
	}

	public static function blog_category_del_bat(){
		global $c;
		manage::check_permit('content.blog', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_id=ary::ary_format($g_id, 2);
		$del_where="CateId in ($g_id)";
		$row=str::str_code(db::get_all('blog_category', $del_where));
		db::delete('blog_category', $del_where);
		manage::operation_log('批量删除博客分类');
		foreach($row as $v){
			if($v['UId']!='0,'){
				$CateId=category::get_top_CateId_by_UId($v['UId']);
				$statistic_where=category::get_search_where_by_CateId($CateId, 'blog_category');
				category::category_subcate_statistic('blog_category', $statistic_where);
			}
		}
		ly200::e_json('', 1);
	}

	public static function blog_review_del(){
		global $c;
		manage::check_permit('content.blog', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_id=ary::ary_format($g_id, 2);
		$g_id && db::delete('blog_review', "RId in ($g_id)");
		manage::operation_log('删除博客评论');
		ly200::e_json('', 1);
	}

	public static function blog_review_reply(){
		global $c;
		manage::check_permit('content.blog', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$p_RId=(int)$p_RId;
		if($p_Reply){//管理员回复
			db::update('blog_review', "RId='$p_RId'", array('Reply'=>$p_Reply,'ReplyTime'=>time()));
			manage::operation_log('修改博客评论');
		}
		ly200::e_json('', 1);
	}
	/*blog end*/
	
	public static function photo_choice(){//图片银行选择图片
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$CateId=(int)$p_CateId;
		$PId=(array)$p_PId;
		$type=$p_type;//type类型,例如products,editor
		$maxpic=$p_maxpic;//最大允许图片数，0未不允许再上传图片，-1为没有数量限制
		$sum=0;//图片数量
		$Path=array('ret'=>1, 'msg'=>'', 'type'=>$type, 'Pic'=>array());//保存图片路径
		if($maxpic==0){
			$Path['ret']=0;
			$Path['msg']='超过允许上传图片的数量';
			exit(str::json_data($Path));
		}
		$save_dir='';
		$sub_save_dir=$c['manage']['sub_save_dir'];
		if($sub_save_dir[$type]){//来自缩略图，先保存到tmp临时文件夹
			$save_dir=$c['tmp_dir'].'photo/';
		}
		$save_dir && file::mk_dir($save_dir);
		if($p_sort){
			$id_ary=array();
			$p_sort=explode('|', $p_sort);
			foreach((array)$p_sort as $k=>$v){
				if(in_array($v, $PId)){
					$id_ary[]=$v;
				}
			}
			$PId=$id_ary;
		}
		foreach($PId as $k=>$v){//复制选择的图片到指定路径
			$sPic=db::get_value('photo', "PId='$v'", 'PicPath');
			$Pic=str_replace('\\', '/', $c['root_path']).ltrim($sPic, '/');
			if(is_file($Pic)){
				if ($save_dir){//有缩略图的保存到临时文件，没有使用图片银行路径
					$ext_name=file::get_ext_name($Pic);
					$temp=$Path['Pic'][]=$save_dir.str::rand_code().'.'.$ext_name;
					@copy($Pic, $c['root_path'].ltrim($temp, '/'));
				}else{
					$Path['Pic'][]=$sPic;
				}
				$sum++;
			}
			if($sum>=$maxpic && $maxpic>0){break;}//判断是否已超过允许图片数量
		}
		if(!$sum){//没有上传任何图片
			$Path['ret']=0;
			$Path['msg']='没有添加任何图片';
		}elseif ($type!='editor' && $save_dir){//非编辑器时，根据配置生成压缩图片
			$water_ary=array();
			$resize_ary=$c['manage']['resize_ary'];
			if(array_key_exists($type, $resize_ary)){
				foreach($Path['Pic'] as $key=>$value){
					(!$c['manage']['config']['IsWaterPro'] && $c['manage']['config']['IsWater']) && $water_ary[$key]=$value;
					if(in_array('default', $resize_ary[$type])){//保存不加水印的原图
						$ext_name=file::get_ext_name($value);
						@copy($c['root_path'].$value, $c['root_path'].$value.".default.{$ext_name}");
					}
					if(!$c['manage']['config']['IsWaterPro'] && $c['manage']['config']['IsWater'] && $c['manage']['config']['IsThumbnail']){//缩略图加水印
						img::img_add_watermark($value);
						unset($water_ary[$key]);
					}
					foreach((array)$resize_ary[$type] as $v){
						if($v=='default') continue;
						$size_w_h=explode('x', $v);
						$resize_path=img::resize($value, $size_w_h[0], $size_w_h[1]);
					}
				}
			}
			foreach((array)$water_ary as $v){
				img::img_add_watermark($v);
			}
		}
		exit(str::json_data($Path));
	}

	public static function photo_category(){//图片银行分类
		global $c;
		manage::check_permit('content.photo', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$CateId=(int)$p_CateId;
		$Category=$p_Category;
		$UnderTheCateId=(int)$p_UnderTheCateId;
		if($UnderTheCateId==0){
			$UId='0,';
			$Dept=1;
		}else{
			$UId=category::get_UId_by_CateId($UnderTheCateId, 'photo_category');
			$Dept=substr_count($UId, ',');
		}
		$data=array(
			'Category'	=>	$Category,
			'UId'		=>	$UId,
			'Dept'		=>	$Dept
		);
		if($CateId){
			db::update('photo_category', "CateId='$CateId'", $data);
			manage::operation_log('修改图片银行分类');
		}else{
			db::insert('photo_category', $data);
			$CateId=db::get_insert_id();
			manage::operation_log('添加图片银行分类');
		}
		$UId!='0,' && $CateId=category::get_top_CateId_by_UId($UId);
		$statistic_where.=category::get_search_where_by_CateId($CateId, 'photo_category');
		category::category_subcate_statistic('photo_category', $statistic_where);
		ly200::e_json('', 1);
	}

	public static function photo_category_edit_myorder(){
		global $c;
		manage::check_permit('content.photo', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$order=1;
		$sort_order=@array_filter(@explode('|', $g_sort_order));
		if($sort_order){
			$sql="UPDATE `photo_category` SET `MyOrder`:CASE `CateId`";
			foreach((array)$sort_order as $v){
				$sql.=" WHEN $v THEN ".$order++;
			}
			$sql.=" END WHERE `CateId` IN (".str_replace('|', ',', $g_sort_order).")";
			db::query($sql);
		}
		manage::operation_log('图片管理分类修改排序');
		ly200::e_json('', 1);
	}

	public static function photo_category_order(){
		global $c;
		manage::check_permit('content.photo', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$order=1;
		$sort_order=@array_filter(@explode('|', $g_sort_order));
		if($sort_order){
			$sql='update photo_category set MyOrder:case CateId';
			foreach((array)$sort_order as $v){
				$sql.=" when $v then ".$order++;
			}
			$sql.=' end where CateId in ('.str_replace('|', ',', $g_sort_order).')';
			db::query($sql);
		}
		manage::operation_log('批量图片管理分类排序');
		ly200::e_json('', 1);
	}

	public static function photo_category_del(){//图片银行分类删除
		global $c;
		manage::check_permit('content.photo', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$CateId=(int)$g_CateId;
		$row=db::get_one('photo_category', "CateId='$CateId'", 'UId');
		$del_where=category::get_search_where_by_CateId($CateId, 'photo_category');
		db::delete('photo_category', $del_where);
		//删除分类下的图片
		$photo_row=db::get_all('photo', $del_where, 'PicPath');
		foreach($photo_row as $k=>$v){
			file::del_file($v['PicPath']);
		}
		db::delete('photo', $del_where);
		if($row['UId']!='0,'){
			$CateId=category::get_top_CateId_by_UId($row['UId']);
			$statistic_where=category::get_search_where_by_CateId($CateId, 'photo_category');
			category::category_subcate_statistic('photo_category', $statistic_where);
		}
		manage::operation_log('删除图片管理分类');
		ly200::e_json('', 1);
	}

	public static function photo_category_del_bat(){
		global $c;
		manage::check_permit('content.photo', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		!$g_group_id && ly200::e_json(manage::language('{/error.operating_illegal/}'));
		$del_where="CateId in(".str_replace('-',',',$g_group_id).")";
		$row=str::str_code(db::get_all('photo_category', $del_where));
		db::delete('photo_category', $del_where);
		//删除分类下的图片
		$photo_row=db::get_all('photo', $del_where, 'PicPath');
		foreach($photo_row as $k=>$v){
			file::del_file($v['PicPath']);
		}
		db::delete('photo', $del_where);
		manage::operation_log('批量删除图片管理分类');
		foreach($row as $v){
			if($v['UId']!='0,'){
				$CateId=category::get_top_CateId_by_UId($v['UId']);
				$statistic_where=category::get_search_where_by_CateId($CateId, 'photo_category');
				category::category_subcate_statistic('photo_category', $statistic_where);
			}
		}
		ly200::e_json('', 1);
	}

	public static function photo_category_select(){
		global $c;
		manage::check_permit('content.photo', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$p_ParentId=(int)$p_ParentId;
		$p_CateId=(int)$p_CateId;
		$category_one=str::str_code(db::get_one('photo_category', "CateId='$p_CateId'"));
		$ext_where="CateId!='{$category_one['CateId']}' and Dept<2";
		echo category::ouput_Category_to_NewSelect('UnderTheCateId', ($ParentId?$ParentId:category::get_CateId_by_UId($category_one['UId'])), 'photo_category', "UId='0,' and $ext_where", $ext_where, 'class="box_input"', $c['manage']['lang_pack']['global']['select_index']);
		exit;
	}

	public static function photo_file_upload(){//图片银行图片上传
		global $c;
		exit(file::file_upload_plugin($c['tmp_dir'].'photo/', '', false));
	}

	public static function photo_upload(){//图片银行图片添加提交处理函数
		global $c;
		manage::check_permit('content.photo', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$CateId=(int)$p_CateId;
		$CateId && $CurName=db::get_value('photo_category', "CateId='{$CateId}'", 'Category');
		$CategoryName=trim($p_SelectValue);
		if($CurName!=$CategoryName){
			$where="Category='{$CategoryName}'";
			$NewCateId=db::get_value('photo_category', $where, 'CateId');
			if($NewCateId){
				$CateId=$NewCateId;
			}else{
				$data=array(
					'Category'	=>	$CategoryName,
					'UId'		=>	'0,',
					'Dept'		=>	1
				);
				db::insert('photo_category', $data);
				$CateId=db::get_insert_id();
			}
		}
		//上传图片
		$PicPath=$p_PicPath;
		$Name=$p_Name;
		//检查图片
		foreach((array)$PicPath as $k=>$v){
			file::photo_add_item($v, $Name[$k], 0, $CateId);
		}
		ly200::e_json(array('jump'=>'./?m=content&a=photo&CateId='.$CateId), 1);
	}

	public static function photo_list_del(){//图片银行批量删除图片
		global $c;
		manage::check_permit('content.photo', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$CateId=(int)$p_CateId;
		$PId=(array)$p_PId;
		$count=count($PId);
		foreach($PId as $k=>$v){
			$Pic=db::get_value('photo', "PId='$v'", 'PicPath');
			$ext_name=file::get_ext_name($Pic);
			file::del_file($Pic.".120x120.{$ext_name}");
			file::del_file($Pic);
			db::delete('photo', "PId='$v'");
		}
		manage::operation_log('图片银行批量删除图片 数目：'.$count);
		ly200::e_json('', 1);
	}

	public static function photo_upload_del(){
		global $c;
		manage::check_permit('content.photo', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$Model=$g_Model;
		$PicPath=$g_Path;
		$Index=(int)$g_Index;
		if(is_file($c['root_path'].$PicPath)){
			file::del_file($PicPath);
		}
		ly200::e_json(array($Index), 1);
	}

	public static function photo_move(){//图片移动
		global $c;
		manage::check_permit('content.photo', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$p_PId=(array)$p_PId;
		$p_CateId=(int)$p_CateId;
		foreach($p_PId as $k=>$PId){
			$photo_row=str::str_code(db::get_one('photo', "PId='$PId'"));
			if($photo_row['CateId']!=$p_CateId){
				db::update('photo', "PId='$PId'", array('CateId'=>$p_CateId));
			}
		}
		ly200::e_json(array('jump'=>'./?m=content&a=photo&CateId='.$p_CateId), 1);
	}
}
?>