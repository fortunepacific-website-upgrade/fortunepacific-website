<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

class case_module{
	//案例分类管理 Start
	public static function case_category_edit(){
		global $c;
		
		//----------------------------过滤敏感词-------------------------------
		$resultArr=str::key_filter();
		$resultArr[0]==1 && ly200::e_json($c['manage']['language']['global']['sensitive_word'].$resultArr[1], 0);
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
		ly200::e_json(array('txt'=>$c['manage']['language']['global']['saved']), 1);
	}
	
	public static function case_category_del(){
		global $c;
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$CateId=(int)$g_CateId;
		$row = db::get_one('case_category', "CateId='$CateId'", 'Category_'.$c['config']['global']['LanguageDefault'].', UId');
		$del_where=category::get_search_where_by_CateId($CateId, 'case_category');
		db::delete('case_category_description', $del_where);
		db::delete('case_category', $del_where);
		manage::operation_log('删除案例分类:'.$row['Category_'.$c['config']['global']['LanguageDefault']]);
		
		if($row['UId']!='0,'){
			$CateId=category::get_top_CateId_by_UId($row['UId']);
			$statistic_where=category::get_search_where_by_CateId($CateId, 'case_category');
			category::category_subcate_statistic('case_category', $statistic_where);
		}
		js::location('./?m=case&a=category');
	}
	
	public static function case_category_order(){
		global $c;
		$order=1;
		$sort_order=@array_filter(@explode('|', $_GET['sort_order']));
		foreach($sort_order as $v){
			db::update('case_category', "CateId='$v'", array('MyOrder'=>$order++));
		}
		manage::operation_log('案例分类排序');
	}
	//案例分类管理 End
	
	//案例显示管理 Start
	public static function show_edit(){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$share_row = str::json_data(db::get_value('config',"GroupId='project' AND Variable='Config'",'Value'),'decode');
		$data['share']=(int)trim(trim($p_Checked,'{\"share\":'),'}');
		db::update('config',"GroupId='project' AND Variable='Config'",array('Value'=>str::json_data($data)));
		manage::operation_log('修改案例显示设置');
		ly200::e_json(array('ok'=>1), 1);
	}
	
	//案例管理 Start
	public static function case_edit(){
		global $c;
		
		//----------------------------过滤敏感词-------------------------------
		$resultArr=str::key_filter();
		$resultArr[0]==1 && ly200::e_json($c['manage']['language']['global']['sensitive_word'].$resultArr[1], 0);
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
		
		$data = array(
			'CateId'				=>	$CateId,
			'Number'				=>	$p_Number,
			'PicPath_0'				=>	$ImgPath[0],
			'PicPath_1'				=>	$ImgPath[1],
			'PicPath_2'				=>	$ImgPath[2],
			'PicPath_3'				=>	$ImgPath[3],
			'PicPath_4'				=>	$ImgPath[4],
			'Url'					=>	@substr_count($p_Url, 'http://')?$p_Url:'',
			'PageUrl'				=>	ly200::str_to_url($p_PageUrl),
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
		ly200::e_json('', 1);
	}
	
	public static function case_img_del(){	//删除单个案例图片
		global $c;
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$Model=$g_Model;
		$PicPath=$g_Path;
		$Index=(int)$g_Index;
		$resize_ary=$c['manage']['resize_ary'][$Model];	//case
		if(is_file($c['root_path'].$PicPath)){
			foreach($resize_ary as $v){
				$ext_name=file::get_ext_name($PicPath);
				file::del_file($PicPath.".{$v}.{$ext_name}");
			}
			file::del_file($PicPath);
		}
		ly200::e_json(array($Index), 1);
	}
	
	public static function case_del(){
		global $c;
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$CaseId=(int)$g_CaseId;
		$row=str::str_code(db::get_one('`case`', "CaseId='$CaseId'", 'Name_'.$c['config']['global']['LanguageDefault'].', PicPath_0, PicPath_1, PicPath_2, PicPath_3, PicPath_4'));
		$resize_ary=$c['manage']['resize_ary']['case'];
		for($i=0; $i<5; $i++){
			$PicPath=$row["PicPath_$i"];
			if(is_file($c['root_path'].$PicPath)){
				foreach($resize_ary as $v){
					$ext_name=file::get_ext_name($PicPath);
					file::del_file($PicPath.".{$v}.{$ext_name}");
				}
				file::del_file($PicPath);
			}
		}
		
		db::delete('`case`', "CaseId='$CaseId'");
		db::delete('case_description', "CaseId='$CaseId'");
		manage::operation_log('删除案例:'.$row['Name_'.$c['config']['global']['LanguageDefault']]);
		js::location('./?m=case&a=case');
	}
	
	public static function case_del_bat(){
		global $c;
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		!$g_group_proid && js::location('./?m=case&a=case');
		$del_where="CaseId in(".str_replace(array('-', '|'),',',$g_group_proid).")";
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
		manage::operation_log('批量删除案例');
		js::location('./?m=case&a=case');
	}
	//案例管理 End
}
?>