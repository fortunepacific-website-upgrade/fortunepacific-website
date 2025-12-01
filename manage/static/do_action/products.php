<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

class products_module{
	public static function products_edit(){
		global $c;
		manage::check_permit('products.products', 1);
		//----------------------------过滤敏感词-------------------------------
		$resultArr=manage::keywords_filter();
		$resultArr[0]==1 && ly200::e_json(manage::language('{/global.sensitive_word/}').$resultArr[1]);
		//----------------------------过滤敏感词-------------------------------

		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$ProId=(int)$p_ProId;
		//基本信息
		$CateId=(int)$p_CateId;
		$PicPath=$p_PicPath;
		$ColorPath=$p_ColorPath;
		//$p_UpdateWater=(int)$p_UpdateWater;
		//产品属性
		$AttrId=(int)$p_AttrId;
		$p_SoldOut=(int)$p_SoldOut;
		$Description=$p_Description;

		if($p_Number && db::get_row_count('products', "ProId!='$ProId' and Number='$p_Number'")) ly200::e_json(manage::language('{/products.products.number_notes/}'));
		if(!count($PicPath)) ly200::e_json(manage::get_language('products.products.pic_tips'));

		//扩展分类
		if($p_ExtCateId){
			$p_ExtCateId=array_filter(array_unique($p_ExtCateId));
			$p_ExtCateId && $ExtCateId=','.implode(',',$p_ExtCateId).',';
		}

		//图片上传
		$ImgPath=array();
		$resize_ary=$c['manage']['resize_ary']['products'];
		$save_dir=$c['manage']['upload_dir'].$c['manage']['sub_save_dir']['products'].date('d/');
		file::mk_dir($save_dir);
		foreach((array)$PicPath as $k=>$v){
			$ImgPath[$k]=file::photo_tmp_upload($v, $save_dir);
			$ext_name=file::get_ext_name($ImgPath[$k]);
			if(!is_file($c['root_path'].$ImgPath[$k].".default.{$ext_name}")){
				@copy($c['root_path'].$ImgPath[$k], $c['root_path'].$ImgPath[$k].".default.{$ext_name}");
			}
			if(substr_count($v, '/tmp') && $c['manage']['is_watermark']){//缩略图加水印，大图加水印后再生成缩略图
				img::img_add_watermark($ImgPath[$k]);
			}
			foreach((array)$resize_ary as $v2){
				if(!is_file($c['root_path'].$ImgPath[$k].".{$v2}.{$ext_name}")){
					$size_w_h=explode('x', $v2);
					$resize_path=img::resize($ImgPath[$k], $size_w_h[0], $size_w_h[1]);
				}
			}
			if(substr_count($v, '/tmp') && $c['manage']['is_watermark'] && !$c['manage']['is_thumbnail']){//新上传图片加水印
				img::img_add_watermark($ImgPath[$k]);
			}
		}

		/*if($p_UpdateWater){//更新水印图片
			foreach((array)$ImgPath as $k=>$v){
				$water_ary=array($v);
				$ext_name=file::get_ext_name($v);
				@copy($c['root_path'].$v.".default.{$ext_name}", $c['root_path'].$v);//覆盖大图
				if($c['manage']['is_watermark']){//缩略图加水印
					img::img_add_watermark($v);
					$water_ary=array();
				}
				foreach($resize_ary as $v2){
					if($v=='default') continue;
					$size_w_h=explode('x', $v2);
					$resize_path=img::resize($v, $size_w_h[0], $size_w_h[1]);
				}
				if ($c['manage']['is_watermark']){
					foreach((array)$water_ary as $v2){
						img::img_add_watermark($v2);
					}
				}
			}
		}*/

		//产品属性
		if($AttrId){
			$attr_ary=$ext_ary=array();
			foreach($c['manage']['language_web'] as $key=>$val){
				$row=str::str_code(db::get_all('products_attribute', "ParentId='$AttrId'", '*', $c['my_order'].'AttrId asc'));
				foreach((array)$row as $v){
					$id=$v['AttrId'];
					$attr_ary[$id][$val]=${'p_Attr_'.$id.'_'.$val};
				}
			}
			$Attr=addslashes(str::json_data(str::str_code($attr_ary, 'stripslashes')));
		}

		//平台导流
		$platform_ary=array('amazon','aliexpress','wish','ebay','alibaba');
		$platform_url=array();
		foreach($platform_ary as $k => $v){
			$Url='p_Platform_'.$k;
			if(!$$Url) continue;
			$platform_url[$v]=$$Url;
		}

		$data=array(
			'CateId'		=>	$CateId,
			'ExtCateId'		=>	$ExtCateId,
			'Number'		=>	$p_Number,
			'Price_0'		=>	$p_Price_0,
			'PicPath_0'		=>	$ImgPath[0],
			'PicPath_1'		=>	$ImgPath[1],
			'PicPath_2'		=>	$ImgPath[2],
			'PicPath_3'		=>	$ImgPath[3],
			'PicPath_4'		=>	$ImgPath[4],
			'AttrId'		=>	$AttrId,
			'Attr'			=>	$Attr,
			'ExtAttr'		=>	$ExtAttr,
			'PageUrl'		=>	str::str_to_url($p_PageUrl),
			'IsNew'			=>	(int)$p_IsNew,
			'IsHot'			=>	(int)$p_IsHot,
			'SaleOut'		=>	(int)$p_SaleOut,
			'IsBestDeals'	=>	(int)$p_IsBestDeals,
			'IsIndex'		=>	(int)$p_IsIndex,
			'IsMember'		=>	(int)$p_IsMember,
			'FilePath_0'	=>	$p_FilePath_0,
			'FilePath_1'	=>	$p_FilePath_1,
			'FilePath_2'	=>	$p_FilePath_2,
			'FilePath_3'	=>	$p_FilePath_3,
			'FilePath_4'	=>	$p_FilePath_4,
			'FileName_0'	=>	$p_FileName_0,
			'FileName_1'	=>	$p_FileName_1,
			'FileName_2'	=>	$p_FileName_2,
			'FileName_3'	=>	$p_FileName_3,
			'FileName_4'	=>	$p_FileName_4,
			'FilePwd_0'		=>	$p_FilePath_0?$p_FilePwd_0:'',
			'FilePwd_1'		=>	$p_FilePath_1?$p_FilePwd_1:'',
			'FilePwd_2'		=>	$p_FilePath_2?$p_FilePwd_2:'',
			'FilePwd_3'		=>	$p_FilePath_3?$p_FilePwd_3:'',
			'FilePwd_4'		=>	$p_FilePath_4?$p_FilePwd_4:'',
			'MyOrder'		=>	(int)$p_MyOrder,
			'Platform'		=>	str::json_data($platform_url)
		);

		$IsOpenData=array(
			'IsOpen_0'	=>	(int)$p_IsOpen_0,
			'IsOpen_1'	=>	(int)$p_IsOpen_1,
			'IsOpen_2'	=>	(int)$p_IsOpen_2,
		);

		//文件上传
		for($i=0; $i<5; ++$i){
			if($data["FilePath_$i"]=='' && ${'p_sFilePath_'.$i}){
				file::del_file(${'p_sFilePath_'.$i});//删掉旧文件
			}else if(is_file($c['root_path'].$data["FilePath_$i"])){//判断新文件存在不
				if($data["FilePath_$i"]!=${'p_sFilePath_'.$i} && is_file($c['root_path'].${'p_sFilePath_'.$i})){//旧文件存在不
					file::del_file(${'p_sFilePath_'.$i});//删掉旧文件
				}
			}else{//新文件不存在，用旧文件替换回去
				$data["FilePath_$i"]=${'p_FilePath_'.$i}!=''?${'p_sFilePath_'.$i}:'';
				$data["FileName_$i"]=${'p_FileName_'.$i}!=''?${'p_sFileName_'.$i}:'';
			}
		}
		if($ProId){
			$data['EditTime']=$c['time'];
			db::update('products', "ProId='$ProId'", $data);
			if(!db::get_row_count('products_seo', "ProId='$ProId'")){
				db::insert('products_seo', array('ProId'=>$ProId));
			}
			if(!db::get_row_count('products_description', "ProId='$ProId'")){
				$IsOpenData['ProId']=$ProId;
				db::insert('products_description', $IsOpenData);
			}else{
				db::update('products_description',"ProId='$ProId'", $IsOpenData);
			}
			manage::operation_log('修改产品:'.$_POST['Name_'.$c['config']['global']['LanguageDefault']]);
		}else{
			$data['AccTime']=$data['EditTime']=$c['time'];
			db::insert('products', $data);
			$ProId=db::get_insert_id();
			db::insert('products_seo', array('ProId'=>$ProId));
			$IsOpenData['ProId']=$ProId;
			db::insert('products_description', $IsOpenData);
			manage::operation_log('添加产品:'.$_POST['Name_'.$c['config']['global']['LanguageDefault']]);
		}

		//判断新用户已经添加产品
		if(db::get_row_count('config', 'GroupId="guide_pages" and Variable="products"')){
			db::update('config', 'GroupId="guide_pages" and Variable="products"', array('Value'=>1));
		}
		manage::database_language_operation('products', "ProId='$ProId'", array('Lang'=>4, 'Name'=>2, 'BriefDescription'=>2));
		!db::get_row_count('products_seo', "ProId='$ProId'") && db::insert('products_description', array('ProId'=>$ProId));
		manage::database_language_operation('products_seo', "ProId='$ProId'", array('SeoTitle'=>1, 'SeoKeyword'=>1, 'SeoDescription'=>2));
		$description_data=array('Description'=>3);
		for($i=0;$i<$c['description_count'];$i++){
			$description_data['Title_'.$i]=2;
			$description_data['Description_'.$i]=3;
		}
		!db::get_row_count('products_description', "ProId='$ProId'") && db::insert('products_description', array('ProId'=>$ProId));
		manage::database_language_operation('products_description', "ProId='$ProId'", $description_data);
		ly200::e_json(array('jump'=>$p_back_action?$p_back_action:"?m=products&a=products&CateId=$CateId"), 1);
	}

	//产品属性
	public static function products_get_attr(){
		global $c;
		manage::check_permit('products.products', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$attr_html='';
		$CateId=(int)$g_CateId;
		$Attr=$g_Attr;
		$attr_ary=array();
		$attr_ary=@json_decode(stripslashes($Attr),true);
		$all_attr_ary=array();
		$category_row=str::str_code(db::get_one('products_category', "CateId='$CateId'", 'UId, AttrId'));
		if($category_row['UId']!='0,'){
			$CateId=category::get_top_CateId_by_UId($category_row['UId']);
			$category_row=str::str_code(db::get_one('products_category', "CateId='$CateId'", 'AttrId'));
		}
		$AttrId=$category_row['AttrId'];
		//同一大分类属性不更新
		$OldAttrId=(int)$g_OldAttrId;
		$OldAttrId==$AttrId && exit;
		if($AttrId){
			$attr_row=str::str_code(db::get_one('products_attribute', "AttrId='$AttrId'"));
			$row=str::str_code(db::get_all('products_attribute', "ParentId='$AttrId'", '*', $c['my_order'].'AttrId asc'));
			foreach((array)$row as $v){
				$attr_html.="<div class='rows clean'><label>{$v['Name_'.$c['manage']['language_default']]}<div class='tab_box'>".manage::html_tab_button('',1)."</div></label><div class='input'>";
				$id=$v['AttrId'];
				$name="Attr_$id";
				foreach($c['manage']['language_web'] as $k3=>$v3){
					$attr_ary[$id][$v3]=htmlspecialchars($attr_ary[$id][$v3]);
					$attr_html.="<div class='tab_txt tab_txt_$v3' lang='$v3' ".($v3==$c['manage']['language_default'] ? "style='display:block;'" : '')."><input type='text' name='{$name}_$v3' value='{$attr_ary[$id][$v3]}' class='box_input' size='70' maxlength='255'></div>";
				}
				$attr_html.='</div></div>';
			}
		}
		ly200::e_json(array($attr_html, str::json_data($all_attr_ary), $AttrId, $attr_row['Name_'.$c['manage']['language_default']]), 1);
	}

	public static function products_del(){
		global $c;
		manage::check_permit('products.products', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_id=ary::ary_format($g_id, 2);
		$del_where="ProId in($g_id)";
		$row=str::str_code(db::get_all('products', $del_where, 'PicPath_0, PicPath_1, PicPath_2, PicPath_3, PicPath_4'));
		$resize_ary=$c['manage']['resize_ary']['products'];
		foreach((array)$row as $v){
			for($i=0; $i<5; $i++){
				$PicPath=$v["PicPath_$i"];
				if(is_file($c['root_path'].$PicPath)){
					foreach((array)$resize_ary as $v2){
						$ext_name=file::get_ext_name($PicPath);
						file::del_file($PicPath.".{$v2}.{$ext_name}");
					}
					file::del_file($PicPath);
				}
			}
		}
		db::delete('products', $del_where);
		db::delete('products_seo', $del_where);
		db::delete('products_description', $del_where);
		manage::operation_log('删除产品');
		ly200::e_json('', 1);
	}

	public static function products_img_del(){//删除单个产品图片
		global $c;
		manage::check_permit('products.products', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$Model=$g_Model;
		$PicPath=$g_Path;
		$Index=(int)$g_Index;
		$resize_ary=$c['manage']['resize_ary'][$Model];	//products
		if(is_file($c['root_path'].$PicPath)){
			foreach($resize_ary as $v){
				$ext_name=file::get_ext_name($PicPath);
				file::del_file($PicPath.".{$v}.{$ext_name}");
			}
			file::del_file($PicPath);
		}
		manage::operation_log('删除产品图片');
		ly200::e_json(array($Index), 1);
	}

	public static function products_copy(){
		global $c;
		manage::check_permit('products.products', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$ProId=(int)$g_ProId;
		$row=db::get_one('products', "ProId='$ProId'");
		foreach((array)$row as $k=>$v){
			$data[$k]=addslashes($v);
		}
		unset($data['ProId'], $data['Number']);
		$seo_row=db::get_one('products_seo', "ProId='$ProId'");
		if($seo_row){
			foreach((array)$seo_row as $k=>$v){
				$seo_data[$k]=addslashes($v);
			}
			unset($seo_data['SId']);
		}
		$desc_row=db::get_one('products_description', "ProId='$ProId'");
		if($desc_row){
			foreach((array)$desc_row as $k=>$v){
				$desc_data[$k]=addslashes($v);
			}
			unset($desc_data['DId']);
		}

		$resize_ary=$c['manage']['resize_ary']['products'];
		$temp_dir=$c['manage']['upload_dir'];
		file::mk_dir($temp_dir);
		for($i=0; $i<5; ++$i){
			$PicPath=$row["PicPath_$i"];
			if(is_file($c['root_path'].$PicPath)){
				$ext_name=file::get_ext_name($PicPath);
				$data["PicPath_$i"]=$temp=$temp_dir.str::rand_code().'.'.$ext_name;
				foreach((array)$resize_ary as $v){
					$RePicPath=$PicPath.".{$v}.{$ext_name}";
					@copy($c['root_path'].$RePicPath, $c['root_path'].ltrim($temp.".{$v}.{$ext_name}", '/'));
				}
				@copy($c['root_path'].$PicPath, $c['root_path'].ltrim($temp, '/'));
			}
		}

		db::insert('products', $data);
		$proid=db::get_insert_id();
		$seo_data['ProId']=$desc_data['ProId']=$proid;
		db::insert('products_seo', $seo_data);
		db::insert('products_description', $desc_data);
		manage::operation_log('复制产品');
		js::location("./?m=products&a=products&d=edit&ProId=$proid");
	}

	public static function products_edit_myorder(){
		global $c;
		manage::check_permit('products.products', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$p_Number=(int)$p_Number;
		db::update('products', "ProId='{$p_ProId}'", array('MyOrder'=>$p_Number));
		manage::operation_log('产品修改排序');
		ly200::e_json(manage::language(manage::language("{/global.my_order_ary.$p_Number/}")), 1);
	}

	public static function products_explode(){
		global $c;
		manage::check_permit('products.products', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$language_default='_'.$c['manage']['language_default'];

		include($c['root_path'].'/inc/class/excel.class/PHPExcel.php');
		include($c['root_path'].'/inc/class/excel.class/PHPExcel/Writer/Excel5.php');
		include($c['root_path'].'/inc/class/excel.class/PHPExcel/IOFactory.php');

		$objPHPExcel=new PHPExcel();

		//Set properties
		$objPHPExcel->getProperties()->setCreator('Ueeshop');
		$objPHPExcel->getProperties()->setLastModifiedBy('Ueeshop');
		$objPHPExcel->getProperties()->setTitle('Ueeshop');
		$objPHPExcel->getProperties()->setSubject('Ueeshop');
		$objPHPExcel->getProperties()->setKeywords('Ueeshop');
		$objPHPExcel->getProperties()->setCategory('Ueeshop');

		//Add some data
		//(A ~ Z)
		$arr=range('A', 'Z');
		$ary=$arr;
		for($i=0; $i<5; ++$i){
			$num=$arr[$i];
			foreach((array)$arr as $v){
				$ary[]=$num.$v;
			}
		}
		$g_id=ary::ary_format($g_id, 2);
		!$g_id && js::location('./?m=products&a=products', manage::language('{/products.products.select_notes/}'));
		$where = "p.ProId=pd.ProId";
		$where .= " and p.ProId in($g_id)";
		$row=str::str_code(db::get_all('products as p,products_description as pd', $where, "p.*,pd.*", $c['my_order'].'p.ProId desc'));
		$seo_row=str::str_code(db::get_all('products_seo', "ProId in($g_id)", '*', 'SId asc'));
		$seo_ary = array();
		foreach ($seo_row as $k=>$v){
			$seo_ary[$v['ProId']] = $v;
		}
		unset($seo_row);
		$num=0;

		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+0].'1', manage::language('{/global.name/}'));
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+1].'1', manage::language('{/global.pic/}'));
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+2].'1', manage::language('{/products.products.number/}'));
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+3].'1', manage::language('{/global.category/}'));
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+4].'1', manage::language('{/global.sub_category/}'));
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+5].'1', manage::language('{/global.other/}'));
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+6].'1', manage::language('{/products.products.price/}'));
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+7].'1', manage::language('{/global.seo.seo/}{/global.seo.title/}'));
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+8].'1', manage::language('{/global.seo.seo/}{/global.seo.keyword/}'));
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+9].'1', manage::language('{/global.seo.seo/}{/global.seo.description/}'));
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+10].'1', manage::language('{/global.brief_description/}'));
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+11].'1', manage::language('{/global.description/}'));
		$num+=11;

		$columnNumber=$num+$j;
		$allcate_row=db::get_all('products_category', '1', "CateId, Category_{$c['manage']['language_default']}", $c['my_order'].'CateId asc');
		$allcate_ary=array();
		$symbol = db::get_value('config',"GroupId='products' AND Variable='symbol'","Value");
		foreach((array)$allcate_row as $k=>$v) $allcate_ary[$v['CateId']]=$v['Category_'.$c['manage']['language_default']];//2017-06-29
		$i=3;
		foreach((array)$row as $v){
			$Name_str = '';
			$BriefDescription_str = '';
			$Description_str = '';
			$SeoTitle_str = '';
			$SeoKeyword_str = '';
			$SeoDescription_str = '';
			$other_fields = '';
			$num=0;
			foreach((array)$c['manage']['language_web'] as $key=>$val){
				$Name_str .= $v['Name_'.$val]."\r\n";
				$BriefDescription_str .= $v['BriefDescription_'.$val]."\r\n";
				$Description_str .= $v['Description_'.$val]."\r\n";
				$SeoTitle_str .= $seo_ary[$v['ProId']]['SeoTitle_'.$val]."\r\n";
				$SeoKeyword_str .= $seo_ary[$v['ProId']]['SeoKeyword_'.$val]."\r\n";
				$SeoDescription_str .= $seo_ary[$v['ProId']]['SeoDescription_'.$val]."\r\n";
			}
			$v['IsNew'] && $other_fields .= manage::language('{/products.products.is_new/}')."\r\n";
			$v['IsHot'] && $other_fields .= manage::language('{/products.products.is_hot/}')."\r\n";
			$v['IsBestDeals'] && $other_fields .= manage::language('{/products.products.is_best_deals/}')."\r\n";
			$v['IsIndex'] && $other_fields .= manage::language('{/products.products.is_index/}')."\r\n";
			$v['SaleOut'] && $other_fields .= manage::language('{/products.products.is_sold_out/}')."\r\n";
			$v['IsMember'] && $other_fields .= manage::language('{/products.products.is_member/}')."\r\n";
			$v['MyOrder'] && $other_fields .= manage::language("{/global.my_order/}:{/global.my_order_ary.{$v['MyOrder']}/}")."\r\n";

			$objPHPExcel->getActiveSheet()->getCell($ary[$num+1].$i)->getHyperlink()->setUrl(web::get_domain().$v['PicPath_0']);//添加超链接
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+0].$i, $Name_str);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+1].$i, $v['PicPath_0']);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+2].$i, $v['Number']);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+3].$i, $allcate_ary[$v['CateId']]);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+4].$i, trim($v['ExtCateId'], ','));
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+5].$i, $other_fields);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+6].$i, $symbol.$v['Price_0']);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+7].$i, $SeoTitle_str);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+8].$i, $SeoKeyword_str);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+9].$i, $SeoDescription_str);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+10].$i, $BriefDescription_str);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+11].$i, htmlspecialchars_decode($Description_str));
			$num+=11;

			$j=1;
			++$i;
		}

		//设置列的宽度
		for($i=0; $i<=$columnNumber; ++$i){
			$objPHPExcel->getActiveSheet()->getColumnDimension($ary[$i])->setWidth($i?20:30);
			$objPHPExcel->getActiveSheet()->getStyle($ary[$i].'1')->getAlignment()->setWrapText(true);//自动换行
			$objPHPExcel->getActiveSheet()->getStyle($ary[$i].'1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);//垂直居中
			$objPHPExcel->getActiveSheet()->mergeCells("{$ary[$i]}1:{$ary[$i]}2");//合并标题
		}

		//Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle('Simple');

		//Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		//Save Excel 2007 file
		$ExcelName='products_'.str::rand_code();
		$objWriter=new PHPExcel_Writer_Excel5($objPHPExcel);
		$objWriter->save($c['root_path']."/tmp/{$ExcelName}.xls");

		file::down_file("/tmp/{$ExcelName}.xls");
		file::del_file("/tmp/{$ExcelName}.xls");
		unset($c, $row, $objPHPExcel);
		exit;
	}

	public static function attribute_edit(){
		global $c;
		manage::check_permit('products.attribute', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$p_AttrId=(int)$p_AttrId;
		$data=array();
		if($p_AttrId){
			manage::operation_log('修改产品类型');
		}else{
			db::insert('products_attribute', $data);
			$p_AttrId=db::get_insert_id();
			manage::operation_log('添加产品类型');
		}
		manage::database_language_operation('products_attribute', "AttrId='$p_AttrId'", array('Name'=>0));
		$data=array('ParentId'=>$p_AttrId,);
		$p_AttrIdList=ary::ary_format($p_AttrIdList, 2);
		db::delete('products_attribute', "ParentId='$p_AttrId' and AttrId not in($p_AttrIdList)");
		$p_AttrIdList=ary::ary_format($p_AttrIdList, 1);
		foreach(${'p_AttrName_'.$c['manage']['language_web'][0]} as $k=>$v){
			$AttrId=(int)$p_AttrIdList[$k];
			if($v==''){
				$AttrId && db::delete('products_attribute', "AttrId='$AttrId'");
				continue;
			}
			if(!$AttrId){
				db::insert('products_attribute', $data);
				$AttrId=db::get_insert_id();
			}
			foreach($c['manage']['language_web'] as $k1=>$v1){
				$_POST['Name_'.$v1]=${'p_AttrName_'.$v1}[$k];
			}
			manage::database_language_operation('products_attribute', "AttrId='$AttrId'", array('Name'=>0, 'Value'=>2));
		}
		ly200::e_json('', 1);
	}

	public static function attribute_del(){
		global $c;
		manage::check_permit('products.attribute', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_id=ary::ary_format($g_id, 2);
		db::delete('products_attribute', "AttrId in($g_id) or ParentId in($g_id)");
		ly200::e_json('', 1);
	}

	//产品分类管理 Start
	public static function category_edit(){
		global $c;
		manage::check_permit('products.category', 1);
		//----------------------------过滤敏感词-------------------------------
		$resultArr=manage::keywords_filter();
		$resultArr[0]==1 && ly200::e_json(manage::language('{/global.sensitive_word/}').$resultArr[1]);
		//----------------------------过滤敏感词-------------------------------
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$CateId=(int)$p_CateId;
		$UnderTheCateId=(int)$p_UnderTheCateId;
		$p_AttrId=(int)$p_AttrId;
		$PicPath=$p_PicPath;
		$Old_UId=$CateId?db::get_value('products_category', "CateId='$CateId'","UId").$CateId.',':'';
		
		if($UnderTheCateId==0){
			$UId='0,';
			$Dept=1;
			$IsIndex=(int)$p_IsIndex;
		}else{
			$UId=category::get_UId_by_CateId($UnderTheCateId, 'products_category');
			$Dept=substr_count($UId, ',');
			$IsIndex=$p_AttrId=0;
		}
		$data=array(
			'UId'		=>	$UId,
			'AttrId'	=>	$p_AttrId,
			'PicPath'	=>	$PicPath,
			'Dept'		=>	$Dept,
			'IsIndex'	=>	$IsIndex,
		);
		if($CateId){
			db::update('products_category', "CateId='$CateId'", $data);
			manage::operation_log('修改产品分类:'.$_POST['Category_'.$c['config']['global']['LanguageDefault']]);
		}else{
			db::insert('products_category', $data);
			$CateId=db::get_insert_id();
			db::insert('products_category_description', array('CateId'=>$CateId));
			manage::operation_log('添加产品分类:'.$_POST['Category_'.$c['config']['global']['LanguageDefault']]);
		}
		manage::database_language_operation('products_category', "CateId='$CateId'", array('Category'=>1, 'SeoTitle'=>1, 'SeoKeyword'=>1, 'SeoDescription'=>2));
		manage::database_language_operation('products_category_description', "CateId='$CateId'", array('Description'=>3));

		if($Old_UId && $Old_UId!='0,'){	//修改子分类
			$child_where=" and UId like '%{$Old_UId}%'";
			$child_row=db::get_all('products_category', "CateId!='$CateId'".$child_where,"CateId");
			$subCateId='0';
			foreach((array)$child_row as $v){
				$subCateId.=','.$v['CateId'];
			}
			$new_uid=$UId.$CateId.",";
			db::update('products_category', "CateId in($subCateId)",array(
					'UId'	=>	$new_uid,
					'Dept'	=>	substr_count($new_uid, ',')
				)
			);
			$tcId=category::get_top_CateId_by_UId($Old_UId);
			$arr_UId=@explode(',', $Old_UId);
			$fcId=$arr_UId[2];

			db::update('products_category', "CateId='$tcId'", array('SubCateCount'=>db::get_row_count('products_category', "UId like '%,{$tcId},%'")));
			if($tcId!=$fcId){
				db::update('products_category', "CateId='$fcId'", array('SubCateCount'=>db::get_row_count('products_category', "UId like '%{$tcId},{$fcId},%'")));
			}
		}

		$UId!='0,' && $CateId=category::get_top_CateId_by_UId($UId);
		category::category_subcate_statistic('products_category', "CateId='$CateId' or UId like '%,{$CateId},%'");
		ly200::e_json('', 1);
	}

	public static function category_del(){
		global $c;
		manage::check_permit('products.category', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_id=ary::ary_format($g_id, 1);
		foreach($g_id as $v){
			$row=db::get_one('products_category', "CateId='$v'");
			$del_where=category::get_search_where_by_CateId($v, 'products_category');
			db::delete('products_category_description', $del_where);
			db::delete('products_category', $del_where);
			manage::operation_log('删除产品分类:'.$row['Category_'.$c['manage']['config']['LanguageDefault']]);
			if($row['UId']!='0,'){
				$v=category::get_top_CateId_by_UId($row['UId']);
				category::category_subcate_statistic('products_category', "CateId='$v' or UId like '%,{$v},%'");//$statistic_where
			}
		}
		ly200::e_json('', 1);
	}

	public static function category_order(){
		global $c;
		manage::check_permit('products.category', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$order=1;
		$g_sort_order=ary::ary_format($g_sort_order, 1);
		foreach((array)$g_sort_order as $v){
			db::update('products_category', "CateId='$v'", array('MyOrder'=>$order++));
		}
		manage::operation_log('产品分类排序');
		ly200::e_json('', 1);
	}
	//产品分类管理 End

	public static function upload_excel_file(){
		global $c;
		manage::check_permit('products.upload', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		include($c['root_path'].'/inc/class/excel.class/PHPExcel.php');
		include($c['root_path'].'/inc/class/excel.class/PHPExcel/Writer/Excel5.php');
		include($c['root_path'].'/inc/class/excel.class/PHPExcel/IOFactory.php');

		$objPHPExcel=new PHPExcel();

		//Set properties
		$objPHPExcel->getProperties()->setCreator('Ueeshop');//创建人
		$objPHPExcel->getProperties()->setLastModifiedBy('Ueeshop');//最后修改人
		$objPHPExcel->getProperties()->setTitle('Ueeshop');//标题
		$objPHPExcel->getProperties()->setSubject('Ueeshop');//题目
		$objPHPExcel->getProperties()->setKeywords('Ueeshop');//关键字
		$objPHPExcel->getProperties()->setDescription('Ueeshop');//描述
		$objPHPExcel->getProperties()->setCategory('Ueeshop');//种类

		//Add some data
		//(A ~ EZ)
		$arr=range('A', 'Z');
		$ary=$arr;
		for($i=0; $i<5; ++$i){
			$num=$arr[$i];
			foreach($arr as $v){
				$ary[]=$num.$v;
			}
		}

		$fixed_ary=array(
			array(manage::language('{/products.upload.excel_field_0/}'), 'test'),
			array(manage::language('{/products.upload.excel_field_1/}'), '55'),
			array(manage::language('{/products.upload.excel_field_2/}'), '64,65,86'),
			array(manage::language('{/products.upload.excel_field_3/}'), 'EZ019384'),
			array(manage::language('{/products.upload.excel_field_4/}'), '9.99'),
			array(manage::language('{/products.upload.excel_field_5/}'), 'iphone x'),
			array(manage::language('{/products.upload.excel_field_6/}'), 'pro_1.jpg', 'pro_2.jpg'),
			array(manage::language('{/products.upload.excel_field_7/}'), 'Conditionff[High Xiaoju esters]', 'asg[spraying for killing Blattella germanica and flies]'),
			array(manage::language('{/products.upload.excel_field_8/}'), 1),
			array(manage::language('{/products.upload.excel_field_9/}'), 1),
			array(manage::language('{/products.upload.excel_field_10/}'), 1),
			array(manage::language('{/products.upload.excel_field_11/}'), 1),
			array(manage::language('{/products.upload.excel_field_12/}'), 1),
			array(manage::language('{/products.upload.excel_field_13/}'), 1),
			array(manage::language('{/products.upload.excel_field_14/}'), 'test'),
			array(manage::language('{/products.upload.excel_field_15/}'), 'test'),
			array(manage::language('{/products.upload.excel_field_16/}'), 'test'),
			array(manage::language('{/products.upload.excel_field_17/}'), 'test'),
			array(manage::language('{/products.upload.excel_field_18/}'), 'test')
		);
		$fixed_number=count($fixed_ary);

		//按语言版本
		$objPHPExcel->setActiveSheetIndex(0);//设置当前的sheet
		$objPHPExcel->getActiveSheet()->setTitle('upload');//设置sheet的name

		$colmun_ary=$fixed_ary;
		$attr_column=array();//初始化

		foreach($colmun_ary as $k=>$v){//固定项
			$attr_column[$k]=$v[0];
		}
		ksort($attr_column);

		foreach($attr_column as $k=>$v){
			//设置单元格的值(第一二行标题)
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$k].'1', $v);
			$objPHPExcel->getActiveSheet()->getStyle($ary[$k].'1')->getAlignment()->setWrapText(true);//自动换行
			$objPHPExcel->getActiveSheet()->getStyle($ary[$k].'1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);//垂直居中

			//设置单元格的值
			for($i=0; $i<2; ++$i){
				$value=$colmun_ary[$k][$i+1];
				$objPHPExcel->getActiveSheet()->setCellValue($ary[$k].($i+2), $value);
			}

			//设置列的宽度
			$objPHPExcel->getActiveSheet()->getColumnDimension($ary[$k])->setWidth($k==6?30:13);
		}

		//设置行的高度
		$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(40);
		$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);//默认行高

		$objPHPExcel->setActiveSheetIndex(0);//指针返回第一个工作表

		$ExcelName='upload_'.str::rand_code();
		$objWriter=new PHPExcel_Writer_Excel5($objPHPExcel);
		$objWriter->save($c['root_path']."/tmp/{$ExcelName}.xls");

		file::down_file("/tmp/{$ExcelName}.xls");
		file::del_file("/tmp/{$ExcelName}.xls");
		unset($c, $objPHPExcel, $ary, $attr_column, $fixed_ary);
		exit;
	}

	public static function upload(){
		global $c;
		manage::check_permit('products.upload', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$p_Number=(int)$p_Number;//当前分开数
		$p_Worksheet=(int)$p_Worksheet;
		include($c['root_path'].'/inc/class/excel.class/PHPExcel/IOFactory.php');
		$errerTxt='';
		!file_exists($c['root_path'].$p_ExcelFile) && ly200::e_json(manage::language('{/products.upload.no_file/}'));

		$objPHPExcel=PHPExcel_IOFactory::load($c['root_path'].$p_ExcelFile);
		$sheet=$objPHPExcel->getSheet(0);//工作表0
		$highestRow=$sheet->getHighestRow();//取得总行数
		$highestColumn=$sheet->getHighestColumn();//取得总列数

		//初始化第一阶段
		$Start=0;//开始执行位置
		$page_count=50;//每次分开导入的数量
		$total_pages=ceil(($highestRow-1)/$page_count);
		if($p_Number<$total_pages){//继续执行
			$Start=$page_count*$p_Number;
		}else{
			file::del_file($p_ExcelFile);
			manage::operation_log('产品批量上传');
			ly200::e_json(manage::language('{/products.upload.upload_success/}'), 1);
		}
		//初始化第二阶段
		$language=$p_Language;//语言版本
		if(!$language || !in_array($language, $c['manage']['language_list'])){//找不到相对应的语言，默认为可用语言里面的第一个
			$language=$c['manage']['language_list'][0];
		}
		$insert_ary=$update_ary=$category_ary=$category_cateid_ary=$category_uid_ary=$category_top_ary=$attribute_ary=$attribute_top_ary=array();
		//产品分类
		$category_row=db::get_all('products_category', '1', "CateId, Category_{$language}, UId, AttrId");
		foreach((array)$category_row as $v){
			$category_ary[md5($v['Category_'.$language])]=array('CateId'=>$v['CateId'], 'AttrId'=>$v['AttrId']);
			$category_cateid_ary[$v['CateId']]=array('CateId'=>$v['CateId'], 'AttrId'=>$v['AttrId']);
			$category_uid_ary[$v['CateId']]=$v['UId'];
			if($v['UId']=='0,'){//顶级分类
				$category_top_ary[$v['CateId']]=$v['AttrId'];
			}
		}
		//产品属性
		$attribute_row=str::str_code(db::get_all('products_attribute', '1', "AttrId, Name_{$language}, Value_{$language}, ParentId"));
		foreach($attribute_row as $v){
			$attribute_ary[$v['AttrId']]=$v["Name_{$language}"];
			if($v['ParentId']){//收录父亲属性
				$attribute_top_ary[$v['ParentId']][$v["Name_{$language}"]]=$v['AttrId'];
			}
		}
		//内容转换为数组
		$data=$sheet->toArray();
		$num=count($c['manage']['web_lang_list']);
		$un_data_ary=$data_ary=array();
		$i=-1;
		foreach($data as $k=>$v){//行
			if($k<1) continue;
			if($v[0] && $v[3]){//一个产品的资料
				++$i;
				$un_data_ary[$i]=$v;
			}else{//产品的附属参数
				$v[6] && $un_data_ary[$i][6].=','.trim($v[6]);//图片
				$v[7] && $un_data_ary[$i][7].=';'.$v[7];//属性
			}
		}
		foreach($un_data_ary as $k=>$v){//产品
			if($Start<=$k && $k<($Start+$page_count)){
				$v[3] = addslashes($v[3]);
				if(db::get_row_count('products', "Number='{$v[3]}'")){//更新数据库
					$data_ary['update'][]=$v;
				}else{//插入数据库
					$data_ary['insert'][]=$v;
				}
			}elseif($k>=($Start+$page_count)){
				break;
			}
		}
		unset($data, $un_data_ary);
		//图片储存位置
		$resize_ary=$c['manage']['resize_ary']['products'];
		$save_dir=$c['manage']['upload_dir'].$c['manage']['sub_save_dir']['products'].date('d/');
		file::mk_dir($save_dir);
		//开始导入
		foreach((array)$data_ary as $a=>$b){
			$No=0;
			$insert_sql=$update_sql=$database_sql=array();
			foreach($b as $key=>$val){
				$Name=trim($val[0]);//名称
				$category_name=md5(trim($val[1]));//分类
				$CateId=(int)$category_ary[$category_name]['CateId']?(int)$category_ary[$category_name]['CateId']:(int)$category_cateid_ary[(int)trim($val[1])]['CateId'];//分类名或ID
				if(!$CateId){ $errerTxt.='<p>('.manage::language('{/products.upload.upload_failed/}').") {$Name} ".manage::language('{/products.upload.no_category/}').'</p>'; continue;}
				//产品多分类
				$ExtCateId=trim($val[2], ',');
				$ExtCateId && $ExtCateId=','.$ExtCateId.',';
				//产品多分类 end
				$Number=trim($val[3]);
				if(!$Number){ $errerTxt.='<p>('.manage::language('{/products.upload.upload_failed/}').") {$Name} ".manage::language('{/products.upload.no_number/}').'</p>'; continue;}
				$Price=(float)trim($val[4]);//价格
				$PageUrl=trim($val[5]);//自定义地址
				$PicPath=@explode(',', trim($val[6]));
				$Attr=trim($val[7]);//属性
				$IsIndex=(int)trim($val[8]);//首页显示
				$SaleOut=(int)trim($val[9]);//下架
				$IsNew=(int)trim($val[10]);//新品
				$IsHot=(int)trim($val[11]);//热卖
				$IsBestDeals=(int)trim($val[12]);//推荐
				$IsMember=(int)trim($val[13]);//仅会员可见
				$SeoTitle=trim($val[14]);//SEO标题
				$SeoKeyword=trim($val[15]);//SEO关键词
				$SeoDescription=trim($val[16]);//SEO简述
				$BriefDescription=trim($val[17]);//简单介绍
				$Description=trim($val[18]);//详细介绍
				$MyOrder=0;
				//更新代码
				if($a=='update'){
					$prod_row=db::get_one('products', "Number='{$Number}'", 'ProId, PicPath_0, PicPath_1, PicPath_2, PicPath_3, PicPath_4, Attr');
					$attr_data=str::json_data(htmlspecialchars_decode($prod_row['Attr']), 'decode');
				}
				//产品属性
				if($category_uid_ary[$CateId]=='0,'){
					$AttrId=(int)$category_top_ary[$CateId];
				}else{
					$TopCateId=(int)category::get_top_CateId_by_UId($category_uid_ary[$CateId]);//获取顶级分类ID
					$AttrId=(int)$category_top_ary[$TopCateId];
				}
				if($AttrId){
					$attr_ary=array();
					if($Attr){//属性
						$Attr=explode(';', $Attr);
						foreach((array)$Attr as $v){
							$ary=@explode('[', substr($v, 0, -1));
							$id=$attribute_top_ary[$AttrId][$ary[0]];
							$attr_ary[$id][$language]=trim($ary[1]);
							if($a=='update'){
								$attr_data[$id][$language]=trim($ary[1]);
								$attr_ary[$id]=$attr_data[$id];
							}
						}
					}
					$Attr=addslashes(str::json_data(str::str_code($attr_ary, 'stripslashes')));
				}
				//图片上传
				$ImgPath=array();
				foreach((array)$PicPath as $k=>$v){
					$water_ary=array();
					$filepath='/tmp/madeimg/'.$v;
					if(is_file($c['root_path'].$filepath)){//检查图片是否存在
						$ext_name=file::get_ext_name($filepath);//图片文件后缀名
						$new_path=$save_dir.str::rand_code().'.'.$ext_name;//图片重新命名
						@copy($c['root_path'].$filepath, $c['root_path'].$new_path);//先把目标图片复制到u_file
						if($c['manage']['config']['IsWater']) $water_ary[]=$new_path;
						if($resize_ary){
							if(in_array('default', $resize_ary)){//保存不加水印的原图
								@copy($new_path, $new_path.".default.{$ext_name}");
							}
							if($c['manage']['is_watermark']){//缩略图加水印
								img::img_add_watermark($new_path);
								$water_ary=array();
							}
							foreach((array)$resize_ary as $v2){
								if($v2=='default') continue;
								$size_w_h=explode('x', $v2);
								$resize_path=img::resize($new_path, $size_w_h[0], $size_w_h[1]);
							}
						}
						foreach((array)$water_ary as $v2){
							img::img_add_watermark($v2);
						}
						$ImgPath[$k]=$new_path;
						//删除原图片
						foreach($resize_ary as $v2){
							$ext_name=file::get_ext_name($prod_row['PicPath_'.$k]);
							file::del_file($prod_row['PicPath_'.$k].".{$v2}.{$ext_name}");
						}
						file::del_file($prod_row['PicPath_'.$k]);
					}else{
						$ImgPath[$k]=$prod_row['PicPath_'.$k];
					}
				}
				foreach((array)$ImgPath as $k=>$v){
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
				//记录数据资料
				$data=array(
					"Name_{$language}"	=>	$Name,
					'CateId'			=>	$CateId,
					'ExtCateId'			=>	$ExtCateId,
					'Number'			=>	$Number,
					'Price_0'			=>	$Price,
					'PicPath_0'			=>	$ImgPath[0]?$ImgPath[0]:'',
					'PicPath_1'			=>	$ImgPath[1]?$ImgPath[1]:'',
					'PicPath_2'			=>	$ImgPath[2]?$ImgPath[2]:'',
					'PicPath_3'			=>	$ImgPath[3]?$ImgPath[3]:'',
					'PicPath_4'			=>	$ImgPath[4]?$ImgPath[4]:'',
					'AttrId'			=>	$AttrId,
					'Attr'				=>	$Attr,
					'IsIndex'			=>	$IsIndex,
					'SaleOut'			=>	$SaleOut,
					'IsNew'				=>	$IsNew,
					'IsHot'				=>	$IsHot,
					'IsBestDeals'		=>	$IsBestDeals,
					'IsMember'			=>	$IsMember,
					'PageUrl'			=>	str::str_to_url($PageUrl),
					"BriefDescription_{$language}"=>$BriefDescription,
					'MyOrder'			=>	$MyOrder,
					"Lang_{$language}"	=>	1,
				);
				$database_sql[$data['Number']]=array(
					'Seo'	=>	array(//标题与标签
									"SeoTitle_{$language}"		=>	addslashes($SeoTitle),
									"SeoKeyword_{$language}"	=>	addslashes($SeoKeyword),
									"SeoDescription_{$language}"=>	addslashes($SeoDescription)
								),
					'Desc'	=>	array("Description_{$language}"	=>	addslashes($Description)),//详细介绍
				);
				$data=str::str_code(str::str_code($data, 'stripslashes'), 'addslashes');
				$database_sql[$data['Number']]=str::str_code(str::str_code($database_sql[$data['Number']], 'stripslashes'), 'addslashes');

				if($a=='update'){//更新数据库
					$ProId=$prod_row['ProId'];
					unset($data['Number']);//不更新产品编号
					foreach($data as $k=>$v){
						$update_sql[$k][$ProId]=$v;
					}
				}else{//插入数据库
					$insert_sql['Product'].=($No?',':'')."('".$data["Name_{$language}"]."', '{$data['CateId']}', '{$data['ExtCateId']}', '{$data['Number']}', '{$data['Price_0']}', '{$data['PicPath_0']}', '{$data['PicPath_1']}', '{$data['PicPath_2']}', '{$data['PicPath_3']}', '{$data['PicPath_4']}', '{$data['AttrId']}', '{$data['Attr']}', '{$data['IsIndex']}', '{$data['SaleOut']}', '{$data['IsNew']}', '{$data['IsHot']}', '{$data['IsBestDeals']}', '{$data['IsMember']}', '{$data['PageUrl']}', '".$data["BriefDescription_{$language}"]."', '{$data['MyOrder']}', '{$c['time']}', '{$c['time']}', '".$data["Lang_{$language}"]."')";
				}
				++$No;
			}

			if($a=='update'){//更新数据库
				if(is_array($update_sql)){
					$ides=implode(',', array_keys($update_sql['CateId']));
					$len=count($update_sql);
					$i=0;
					$sql="update products set";
						foreach($update_sql as $k=>$v){
							$sql.=" {$k} = case ProId";
							foreach($v as $k2=>$v2){
								$sql.=sprintf(" when %s then '%s' ", $k2, $v2);
							}
							$sql.='end'.(++$i<$len?',':'');
						}
					$sql.=" where ProId in($ides)";
					$sql && db::query($sql);
				}
			}else{//插入数据库
				$insert_sql['Product'] && db::query('insert into products (Name_'.$language.', CateId, ExtCateId, Number, Price_0, PicPath_0, PicPath_1, PicPath_2, PicPath_3, PicPath_4, AttrId, Attr, IsIndex, SaleOut, IsNew, IsHot, IsBestDeals, IsMember, PageUrl, BriefDescription_'.$language.', MyOrder, AccTime, EditTime, Lang_'.$language.') values'.$insert_sql['Product']);
			}

			//其他数据表的内容更新
			if($database_sql){
				$proid_where=$sid_where=$did_where='';
				$insert_sql=$update_sql=$proid_ary=array();
				reset($database_sql);
				$num_where=@implode("','", array_keys($database_sql));
				$row=str::str_code(db::get_all('products', "Number in('{$num_where}')", 'ProId, Number'));
				foreach((array)$row as $k=>$v){
					$proid_ary[htmlspecialchars_decode($v['Number'])]=$v['ProId'];
				}
				$proid_where=@implode(',', $proid_ary);
				if($proid_where){
					if($a=='update'){//更新数据库
						$sid_ary=$did_ary=$update_ary=array();
						//列出SEO资料
						$seo_row=str::str_code(db::get_all('products_seo', "ProId in($proid_where)", 'SId, ProId'));
						foreach($seo_row as $k=>$v){
							$sid_ary[$v['ProId']]=$v['SId'];
						}
						$sid_where=@implode(',', $sid_ary);
						//列出详细介绍资料
						$desc_row=str::str_code(db::get_all('products_description', "ProId in($proid_where)", 'DId, ProId'));
						foreach($desc_row as $k=>$v){
							$did_ary[$v['ProId']]=$v['DId'];
						}
						$did_where=@implode(',', $did_ary);
						$i=$j=0;
						$len=count($database_sql);
						//更新数值重新排列
						foreach($database_sql as $k=>$v){
							foreach($v as $k2=>$v2){
								foreach($v2 as $k3=>$v3){
									$update_ary[$k2][$k3][$k]=$v3;
								}
							}
						}
						foreach($update_ary as $k=>$v){
							if($k=='Seo'){//SEO
								$j=0;
								foreach($v as $k2=>$v2){
									$update_sql['Seo'].=($j?',':'')." {$k2} = case SId";
									foreach($v2 as $k3=>$v3){
										$id=$proid_ary[$k3];//产品ID
										$update_sql['Seo'].=sprintf(" when %s then '%s' ", $sid_ary[$id], addslashes($v3));
									}
									$update_sql['Seo'].='end';
									++$j;
								}
							}
							if($k=='Desc'){//详细介绍
								$j=0;
								foreach($v as $k2=>$v2){
									$update_sql['Desc'].=($j?',':'')." {$k2} = case DId";
									foreach($v2 as $k3=>$v3){
										$id=$proid_ary[$k3];//产品ID
										$update_sql['Desc'].=sprintf(" when %s then '%s' ", $did_ary[$id], addslashes($v3));
									}
									$update_sql['Desc'].='end';
									++$j;
								}
							}
							++$i;
						}
						//var_dump("update products_seo set".$update_sql['Seo']." where ProId in({$sid_where})");
						//var_dump("update products_description set".$update_sql['Desc']." where ProId in($did_where)");
						$sid_where && $update_sql['Seo'] && db::query("update products_seo set".$update_sql['Seo']." where SId in({$sid_where})");
						$did_where && $update_sql['Desc'] && db::query("update products_description set".$update_sql['Desc']." where DId in($did_where)");
					}else{//插入数据库
						$insert_sql['Seo']=$insert_sql['Desc']='';
						$i=0;
						$len=count($database_sql);
						foreach($database_sql as $k=>$v){
							$id=$proid_ary[$k];//产品ID
							foreach($v as $k2=>$v2){
								if($k2=='Seo'){//SEO
									$insert_sql['Seo'].=($i?',':'')."({$id}";
									foreach($v2 as $k3=>$v3){
										$insert_sql['Seo'].=",'{$v3}'";
									}
									$insert_sql['Seo'].=')';
								}
								if($k2=='Desc'){//详细介绍
									$insert_sql['Desc'].=($i?',':'')."({$id}";
									foreach($v2 as $k3=>$v3){
										$insert_sql['Desc'].=",'{$v3}'";
									}
									$insert_sql['Desc'].=')';
								}
							}
							++$i;
						}
						//var_dump("insert into products_seo (ProId, SeoTitle_{$language}, SeoKeyword_{$language}, SeoDescription_{$language}) values".$insert_sql['Seo']);
						//var_dump("insert into products_description (ProId, Description_{$language}) values".$insert_sql['Desc']);
						$insert_sql['Seo'] && db::query("insert into products_seo (ProId, SeoTitle_{$language}, SeoKeyword_{$language}, SeoDescription_{$language}) values".$insert_sql['Seo']);
						$insert_sql['Desc'] && db::query("insert into products_description (ProId, Description_{$language}) values".$insert_sql['Desc']);
					}
				}
			}
		}

		if($p_Number<$total_pages){//继续执行
			$item=($No+1<$page_count)?($page_count*$p_Number+$No):($page_count*($p_Number+1));
			ly200::e_json(array(($p_Number+1), $errerTxt.'<p>'.sprintf(manage::language('{/products.upload.upload_progress/}'), $item).'</p>'), 2);
		}
	}
	//产品批量上传管理 End
	
	//批量更新水印 Start
	public static function watermark_update(){	//批量更新水印
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$CateId=(int)$p_CateId;//当前分类
		$p_Number=(int)$p_Number;//当前分开数
		
		if($CateId){
			$where="CateId in(select CateId from products_category where UId like '".category::get_UId_by_CateId($CateId)."%') or CateId='{$CateId}'";
			$prod_count=db::get_row_count('products', $where);//产品总数
		}
		
		//初始化
		$Start=0;//开始执行位置
		$page_count=10;//每次分开更新的数量
		$total_pages=ceil($prod_count/$page_count);
		if($p_Number<$total_pages){//继续执行
			$Start=$page_count*$p_Number;
		}else{
			manage::operation_log('产品水印图片批量更新');
			ly200::e_json('<p>'.$c['manage']['language']['products']['watermark']['complete_tips'].'</p>', 1);
		}
		$data_ary=$pro_id_ary=array();
		$products_row=db::get_limit('products', $where, 'ProId, PicPath_0, PicPath_1, PicPath_2, PicPath_3, PicPath_4', 'ProId desc', $Start, $page_count);
		foreach($products_row as $v){
			$pro_id_ary[]=$v['ProId'];
			$data_ary[$v['ProId']]['pro']=$v;
		}
		/*$products_color_row=db::get_all('products_color', 'ProId in ('.implode(',', $pro_id_ary).')', '*', 'ProId desc');
		foreach($products_color_row as $v){
			$data_ary[$v['ProId']]['color'][$v['ColorId']]=$v;
		}*/
		//图片储存位置
		$resize_ary=$c['manage']['resize_ary']['products'];
		$save_dir=$c['manage']['upload_dir'].$c['manage']['sub_save_dir']['products'].date('d/');
		file::mk_dir($save_dir);
		//开始更新
		$No=0;
		foreach((array)$data_ary as $ProId=>$obj){
			$ImgPath=$CPath=array();
			foreach($obj['pro'] as $key=>$val){	//产品主图片
				if($key=='ProId') continue;
				if(!is_file($c['root_path'].$val)) continue;
				//图片上传
				$ImgPath[]=$val;
				$water_ary=array($val);
				$ext_name=file::get_ext_name($val);
				@copy($c['root_path'].$val.".default.{$ext_name}", $c['root_path'].$val);//覆盖大图
				if(1){//缩略图加水印
					img::img_add_watermark($val);
					$water_ary=array();
				}
				foreach($resize_ary as $v2){
					if($v2=='default') continue;
					$size_w_h=explode('x', $v2);
					$resize_path=img::resize($val, $size_w_h[0], $size_w_h[1]);
				}
				foreach((array)$water_ary as $v2){
					img::img_add_watermark($v2);
				}
			}
			/*foreach((array)$obj['color'] as $ColorId=>$row){	//产品颜色图片
				foreach($row as $key=>$val){
					if($key=='CId' || $key=='ProId' || $key=='ColorId') continue;
					if(!is_file($c['root_path'].$val)) continue;
					$CPath[$ColorId][]=$val;
					$water_ary=array($val);
					$ext_name=file::get_ext_name($val);
					@copy($c['root_path'].$val.".default.{$ext_name}", $c['root_path'].$val);//覆盖大图
					if($c['manage']['config']['IsThumbnail']){//缩略图加水印
						img::img_add_watermark($val);
						$water_ary=array();
					}
					foreach($resize_ary as $v2){
						if($v2=='default') continue;
						$size_w_h=explode('x', $v2);
						$resize_path=img::resize($val, $size_w_h[0], $size_w_h[1]);
					}
					foreach((array)$water_ary as $v2){
						img::img_add_watermark($v2);
					}
				}
			}*/
			++$No;
		}
		if($p_Number<$total_pages){//继续执行
			$item=($No<$page_count)?($page_count*$p_Number+$No):($page_count*($p_Number+1));
			ly200::e_json(array(($p_Number+1), '<p>'.$c['manage']['language']['products']['watermark']['updated_tips'].$item.'</p>'), 2);
		}
	}
	//批量更新水印 End
}
?>