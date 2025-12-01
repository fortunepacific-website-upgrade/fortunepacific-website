<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

class mobile_module{
	public static function config_init(){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$LogoPath = $p_LogoPath;
		$BtnColor = '#'.trim($p_btn_color, '#');
		$BtnBg = '#'.trim($p_btn_bg, '#');
		
		//提交数据
		$data=array(
			'LogoPath'		=>	$LogoPath,
			'BtnColor'		=>	$BtnColor,
			'BtnBg'			=>	$BtnBg,
		);
		
		//db::get_row_count('mobile_config')?db::update('mobile_config', 1, $data):db::insert('mobile_config', $data);
		if(db::get_row_count('config',"GroupId='mobile' AND Variable='LogoPath'")){//手机导航
			db::update('config',"GroupId='mobile' AND Variable='LogoPath'",array(
				'Value'	=>	$LogoPath,
			));
		}else{
			db::insert('config',array(
				'Value'		=>	$LogoPath,
				'GroupId'	=>	'mobile',
				'Variable'	=>	'LogoPath'
			));
		}
		if(db::get_row_count('config',"GroupId='mobile' AND Variable='BtnColor'")){//手机导航
			db::update('config',"GroupId='mobile' AND Variable='BtnColor'",array(
				'Value'	=>	$BtnColor,
			));
		}else{
			db::insert('config',array(
				'Value'		=>	$BtnColor,
				'GroupId'	=>	'mobile',
				'Variable'	=>	'BtnColor'
			));
		}
		if(db::get_row_count('config',"GroupId='mobile' AND Variable='BtnBg'")){//手机导航
			db::update('config',"GroupId='mobile' AND Variable='BtnBg'",array(
				'Value'	=>	$BtnBg,
			));
		}else{
			db::insert('config',array(
				'Value'		=>	$BtnBg,
				'GroupId'	=>	'mobile',
				'Variable'	=>	'BtnBg'
			));
		}
		
		manage::operation_log('修改手机版基本设置');
		ly200::e_json('', 1);
	}
	public static function header_init(){
		global $c;
		
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$HeadIcon = (int)$p_icon;
		$HeadBg = '#'.trim($p_bg_color, '#');
		$HeadFixed = $p_fixed;
		//提交数据
		$data=array(
			'HeadIcon'		=>	$HeadIcon,
			'HeadBg'		=>	$HeadBg,
			'HeadFixed'		=>	$HeadFixed,
		);
		
		/* 底部导航栏目 */
		$Url = (array)$p_Url;
		foreach ($Url as $k=>$v){
			$_arr = array();
			foreach($c['manage']['language_web'] as $kk=>$vv){//多语言
				$_temp = (array)$_POST['Name_'.$vv];//保存提交的变量
				$_arr['Name_'.$vv] = $_temp[$k];//保存与url索引对应的名称
			}
			$_arr['Url'] = $v;
			$HeadNav[] = $_arr;
		}
		
		$HeadNav = str::json_data($HeadNav);
		if(db::get_row_count('config',"GroupId='mobile' AND Variable='HeadNav'")){//手机导航
			db::update('config',"GroupId='mobile' AND Variable='HeadNav'",array(
				'Value'	=>	addslashes($HeadNav)
			));
		}else{
			db::insert('config',array(
				'Value'		=>	addslashes($HeadNav),
				'GroupId'	=>	'mobile',
				'Variable'	=>	'HeadNav'
			));
		}
		if(db::get_row_count('config',"GroupId='mobile' AND Variable='HeadBg'")){
			db::update('config',"GroupId='mobile' AND Variable='HeadBg'",array(
				'Value'	=>	$HeadBg
			));
		}else{
			db::insert('config',array(
				'Value'		=>	$HeadBg,
				'GroupId'	=>	'mobile',
				'Variable'	=>	'HeadBg'
			));
		}
		if(db::get_row_count('config',"GroupId='mobile' AND Variable='HeadFixed'")){
			db::update('config',"GroupId='mobile' AND Variable='HeadFixed'",array(
				'Value'	=>	$HeadFixed
			));
		}else{
			db::insert('config',array(
				'Value'		=>	$HeadFixed,
				'GroupId'	=>	'mobile',
				'Variable'	=>	'HeadFixed'
			));
		}
		if(db::get_row_count('config',"GroupId='mobile' AND Variable='HeadIcon'")){
			db::update('config',"GroupId='mobile' AND Variable='HeadIcon'",array(
				'Value'	=>	$HeadIcon
			));
		}else{
			db::insert('config',array(
				'Value'		=>	$HeadIcon,
				'GroupId'	=>	'mobile',
				'Variable'	=>	'HeadIcon'
			));
		}
		
		manage::operation_log('修改手机版头部');
		ly200::e_json('', 1);
	}
	
	public static function footer_init(){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$FootFont = '#'.trim($p_font_color, '#'); //字体颜色
		$FootBg = '#'.trim($p_bg_color, '#');
		$Link = (array)$p_Link;
		$FootNav = array();
		
		/* 底部导航栏目 */
		$Url = (array)$p_Url;
		foreach ($Url as $k=>$v){
			$_arr = array();
			foreach($c['manage']['language_web'] as $kk=>$vv){//多语言
				$_temp = (array)$_POST['Name_'.$vv];//保存提交的变量
				$_arr['Name_'.$vv] = $_temp[$k];//保存与url索引对应的名称
			}
			$_arr['Url'] = $v;
			$FootNav[] = $_arr;
		}
		
		$FootNav = str::json_data($FootNav);
		
		//提交数据
		$data=array(
			'FootFont'		=>	$FootFont,
			'FootBg'		=>	$FootBg,
			'FootNav'		=>	$FootNav,
		);
		
		//db::get_row_count('mobile_config')?db::update('mobile_config', 1, $data):db::insert('mobile_config', $data);
		if(db::get_row_count('config',"GroupId='mobile' AND Variable='FootNav'")){//手机导航
			db::update('config',"GroupId='mobile' AND Variable='FootNav'",array(
				'Value'	=>	$FootNav
			));
		}else{
			db::insert('config',array(
				'Value'		=>	$FootNav,
				'GroupId'	=>	'mobile',
				'Variable'	=>	'FootNav'
			));
		}
		if(db::get_row_count('config',"GroupId='mobile' AND Variable='FootBg'")){
			db::update('config',"GroupId='mobile' AND Variable='FootBg'",array(
				'Value'	=>	$FootBg
			));
		}else{
			db::insert('config',array(
				'Value'		=>	$FootBg,
				'GroupId'	=>	'mobile',
				'Variable'	=>	'FootBg'
			));
		}
		if(db::get_row_count('config',"GroupId='mobile' AND Variable='FootFont'")){
			db::update('config',"GroupId='mobile' AND Variable='FootFont'",array(
				'Value'	=>	$FootFont
			));
		}else{
			db::insert('config',array(
				'Value'		=>	$FootFont,
				'GroupId'	=>	'mobile',
				'Variable'	=>	'FootFont'
			));
		}
		manage::operation_log('修改手机版底部');
		ly200::e_json('', 1);
	}
	
	public static function themes_init(){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$HomeTpl = $p_tpl;
		//提交数据
		$data=array(
			'HomeTpl'		=>	$HomeTpl,
		);
		
		//db::get_row_count('mobile_config')?db::update('mobile_config', 1, $data):db::insert('mobile_config', $data);
		if(db::get_row_count('config',"GroupId='mobile' AND Variable='HomeTpl'")){
			db::update('config',"GroupId='mobile' AND Variable='HomeTpl'",array(
				'Value'	=>	$HomeTpl
			));
		}else{
			db::insert('config',array(
				'Value'		=>	$HomeTpl,
				'GroupId'	=>	'mobile',
				'Variable'	=>	'HomeTpl'
			));
		}
		
		manage::operation_log('修改手机模板首页');
		ly200::e_json('', 1);
	}
	
	public static function list_init(){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$ListTpl = $p_tpl;
		//提交数据
		$data=array(
			'ListTpl'		=>	$ListTpl,
		);
		
		//db::get_row_count('mobile_config')?db::update('mobile_config', 1, $data):db::insert('mobile_config', $data);
		if(db::get_row_count('config',"GroupId='mobile' AND Variable='ListTpl'")){
			db::update('config',"GroupId='mobile' AND Variable='ListTpl'",array(
				'Value'	=>	$ListTpl
			));
		}else{
			db::insert('config',array(
				'Value'		=>	$ListTpl,
				'GroupId'	=>	'mobile',
				'Variable'	=>	'ListTpl'
			));
		}
		
		manage::operation_log('修改手机模板产品列表页');
		ly200::e_json('', 1);
	}
	/*******************广告*******************/
	public static function ad_add(){
		global $c;
		
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$PageName = $p_PageName;
		$AdPosition = $p_AdPosition;
		$AdType = (int)$p_AdType;
		$PicCount = (int)$p_PicCount;
		$Width = (int)$p_Width;
		$Height = (int)$p_Height;
		$MHomeTpl = $p_MType;
		//提交数据
		$data=array(
			'MThemesHome'	=>	$MHomeTpl,//手机首页
			'PageName'		=>	$PageName,
			'AdPosition'	=>	$AdPosition,
			'AdType'		=>	$AdType,
			'ShowType'		=>	$AdType==0?1:'',
			'PicCount'		=>	$PicCount,
			'Width'			=>	$Width,
			'Height'		=>	$Height,
		);
		db::insert('ad', $data);
		$AId = db::get_insert_id();
		$Number = db::get_max('ad',"MThemesHome='{$MHomeTpl}'",'Number');
		if(!$Number){
			$Number=1;	
		}else{
			$Number +=1;
		}
		db::update('ad',"AId='$AId'",array('Number'=>$Number));
		
		manage::operation_log('添加广告图片');
		ly200::e_json('', 1);
	}
	
	public static function ad_edit(){
		global $c;
		
		//----------------------------过滤敏感词-------------------------------
		$resultArr=str::key_filter();
		$resultArr[0]==1 && ly200::e_json($c['manage']['language']['global']['sensitive_word'].$resultArr[1], 0);
		//----------------------------过滤敏感词-------------------------------
		
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$AId = (int)$p_AId;
		$PicCount = $p_PicCount;
		$AdType = $p_AdType;
		$ShowType = (int)$p_ShowType;
		$Name = $p_Name;
		$Contents = $p_Contents;
		
		if($AdType==0){//图片
			$NameAry=$BriefAry=$UrlAry=$PicPathAry=array();
			$FormatAry=array();
			foreach($c['manage']['language_web'] as $k=>$v){
				for($i=0; $i<$PicCount; ++$i){
					$FormatAry['NameAry'][$i][$v]=${'p_Name_'.$v}[$i];
					$FormatAry['BriefAry'][$i][$v]=${'p_Brief_'.$v}[$i];
					$FormatAry['UrlAry'][$i][$v]=${'p_Url_'.$v}[$i];
					$FormatAry['PicPathAry'][$i][$v]=${'p_PicPath_'.$v}[$i];
				}
			}
			foreach($FormatAry as $k=>$v){
				for($i=0; $i<$PicCount; ++$i){
					${$k}[$i]=addslashes(str::json_data(str::str_code($v[$i], 'stripslashes')));
				}
			}
		}
		
		$data=array(
			'Name'			=>	$Name,
			'Contents'		=>	$Contents,
			'ShowType'		=>	$ShowType,
			'Name_0'		=>	$NameAry[0],
			'Name_1'		=>	$NameAry[1],
			'Name_2'		=>	$NameAry[2],
			'Name_3'		=>	$NameAry[3],
			'Name_4'		=>	$NameAry[4],
			'Brief_0'		=>	$BriefAry[0],
			'Brief_1'		=>	$BriefAry[1],
			'Brief_2'		=>	$BriefAry[2],
			'Brief_3'		=>	$BriefAry[3],
			'Brief_4'		=>	$BriefAry[4],
			'Url_0'			=>	$UrlAry[0],
			'Url_1'			=>	$UrlAry[1],
			'Url_2'			=>	$UrlAry[2],
			'Url_3'			=>	$UrlAry[3],
			'Url_4'			=>	$UrlAry[4],
			'PicPath_0'		=>	$PicPathAry[0],
			'PicPath_1'		=>	$PicPathAry[1],
			'PicPath_2'		=>	$PicPathAry[2],
			'PicPath_3'		=>	$PicPathAry[3],
			'PicPath_4'		=>	$PicPathAry[4]
		);
		
		db::update('ad', "AId='$AId'", $data);
		ly200::e_json('', 1);
	}
	
	public static function ad_del(){
		global $c;
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$AId=(int)$g_AId;
		
		db::delete('ad', "AId='$AId'");
		manage::operation_log('删除广告图片');
		js::location('./?m=content&a=ad');
	}
	
	public static function ad_img_del(){	//删除单个产品图片
		global $c;
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$PicPath=$g_Path;
		$Index=(int)$g_Index;
		db::update('ad',"AId=".$g_AId,array(
			$g_field	=> ''
		));
		//file::del_file($PicPath);
		ly200::e_json(array($Index), 1);
		//ly200::e_json('', 1);
	}
	/*******************广告*******************/
}
?>
