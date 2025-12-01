<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

class download_module{
	//下载分类管理 Start
	public static function download_category_edit(){
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
		ly200::e_json(array('txt'=>$c['manage']['language']['global']['saved']), 1);
	}
	
	public static function download_category_del(){
		global $c;
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$CateId=(int)$g_CateId;
		$del_where=category::get_search_where_by_CateId($CateId, 'download_category');
		db::delete('download_category_description', $del_where);
		db::delete('download_category', $del_where);
		manage::operation_log('删除下载分类');
		
		if($row['UId']!='0,'){
			$CateId=category::get_top_CateId_by_UId($row['UId']);
			$statistic_where=category::get_search_where_by_CateId($CateId, 'download_category');
			category::category_subcate_statistic('download_category', $statistic_where);
		}
		js::location('./?m=download&a=category');
	}
	
	public static function download_category_order(){
		global $c;
		$order=1;
		$sort_order=@array_filter(@explode('|', $_GET['sort_order']));
		foreach($sort_order as $v){
			db::update('download_category', "CateId='$v'", array('MyOrder'=>$order++));
		}
		manage::operation_log('下载分类排序');
	}
	//下载分类管理 End
	
	//下载管理 Start
	public static function download_edit(){
		global $c;
		
		//----------------------------过滤敏感词-------------------------------
		$resultArr=str::key_filter();
		$resultArr[0]==1 && ly200::e_json($c['manage']['language']['global']['sensitive_word'].$resultArr[1], 0);
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
		
		$data = array(
			'CateId'				=>	$CateId,
			'IsMember'				=>	$IsMember,
			'PicPath'				=>	$PicPath,
			'FilePath'				=>	$FilePath,
			'FileName'				=>	$p_FileName,
			'MyOrder'				=>	(int)$p_MyOrder,
			'IsOth'					=>	$IsOth,
			'Password'				=>	$p_Password,
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
		ly200::e_json('', 1);
	}
	
	public static function download_del(){
		global $c;
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$DId=(int)$g_DId;
		$FilePath=str::str_code(db::get_value('download', "DId='$DId'", 'FilePath'));
		file::del_file($FilePath);
		
		db::delete('download', "DId='$DId'");
		db::delete('download_description', "DId='$DId'");
		manage::operation_log('删除下载');
		js::location('./?m=download&a=download');
	}
	
	public static function download_del_bat(){
		global $c;
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		!$g_group_proid && js::location('./?m=download&a=download');
		$del_where="DId in(".str_replace(array('-', '|'),',',$g_group_proid).")";
		$row=str::str_code(db::get_all('download', $del_where, 'FilePath'));
		foreach($row as $v){
			file::del_file($v['FilePath']);
		}
		
		db::delete('download', $del_where);
		db::delete('download_description', $del_where);
		manage::operation_log('批量删除下载');
		js::location('./?m=download&a=download');
	}
	//下载管理 End
}
?>