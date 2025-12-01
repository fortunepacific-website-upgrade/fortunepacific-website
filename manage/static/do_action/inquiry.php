<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

class inquiry_module{
	public static function inquiry_del(){
		global $c;
		manage::check_permit('inquiry.inquiry', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_id=ary::ary_format($g_id, 2);
		db::delete('products_inquiry', "IId in($g_id)");
		manage::operation_log('删除产品询盘');
		ly200::e_json('', 1);
	}
	/*inquiry-END*/

	public static function feedback_del(){
		global $c;
		manage::check_permit('inquiry.feedback', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_id=ary::ary_format($g_id, 2);
		db::delete('feedback', "FId in($g_id)");
		manage::operation_log('删除在线留言');
		ly200::e_json('', 1);
	}
	
	public static function feedback_explode(){//导出留言
		global $c;
		manage::check_permit('inquiry.feedback', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$Id = trim($p_IdStr, ',');
		!$Id && js::location('./?m=inquiry&a=feedback', manage::language('{/inquiry.select_notes/}'));

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
		/************* 查询 ***********/
		//Add some data
		//(A ~ EZ)
		$arr=range('A', 'Z');
		$ary=$arr;
		for($i=0; $i<5; ++$i){
			$num=$arr[$i];
			foreach((array)$arr as $v){
				$ary[]=$num.$v;
			}
		}
		$where = "`FId` IN ({$Id})";
		$feedback_row = str::str_code(db::get_all('feedback', $where, '*', 'FId desc'));
		/********************/
		$num=0;
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+0].'1', '主题');
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+1].'1', '姓名');
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+2].'1', '公司');
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+3].'1', '电话');
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+4].'1', '手机');
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+5].'1', '邮箱');
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+6].'1', '内容');
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+7].'1', 'IP地址');
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+8].'1', '时间');
		$num+=9;
		$columnNumber=$num;

		$i=2;
		foreach((array)$feedback_row as $v){
			$num=0;
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+0].$i, $v['Subject']);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+1].$i, $v['Name']);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+2].$i, $v['Company']);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+3].$i, $v['Phone']);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+4].$i, $v['Mobile']);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+5].$i, $v['Email']);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+6].$i, $v['Message']);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+7].$i, $v['Ip'].' ['.ly200::ip($v['Ip']).']');
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+8].$i, date('Y-m-d H:i:s', $v['AccTime']));
			$num+=9;
			++$i;
		}

		//设置列的宽度
		for($i=0; $i<$columnNumber; ++$i){
			$objPHPExcel->getActiveSheet()->getColumnDimension($ary[$i])->setWidth(20);
			$objPHPExcel->getActiveSheet()->getStyle($ary[$i].'1')->getAlignment()->setWrapText(true);//自动换行
			$objPHPExcel->getActiveSheet()->getStyle($ary[$i].'1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);//垂直居中
		}

		//Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle('Simple');

		//Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		//Save Excel 2007 file
		$ExcelName='feedback_'.str::rand_code();
		$objWriter=new PHPExcel_Writer_Excel5($objPHPExcel);
		$objWriter->save($c['root_path']."/tmp/{$ExcelName}.xls");

		file::down_file("/tmp/{$ExcelName}.xls");
		file::del_file("/tmp/{$ExcelName}.xls");
		unset($c, $objPHPExcel);
		exit;
	}
	/*feedback-END*/

	public static function review_del(){
		global $c;
		manage::check_permit('inquiry.review', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_id=ary::ary_format($g_id, 2);
		db::delete('products_review', "RId in($g_id)");
		manage::operation_log('删除产品评论');
		ly200::e_json('', 1);
	}
	/*review-END*/

	public static function newsletter_del(){
		global $c;
		manage::check_permit('inquiry.newsletter', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_id=ary::ary_format($g_id, 2);
		db::delete('newsletter', "NId in($g_id)");
		manage::operation_log('删除邮件订阅');
		ly200::e_json('', 1);
	}
	/*newsletter-END*/
	
	public static function newsletter_explode(){
		global $c;
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$Id = trim($g_IdStr, ',');
		!$Id && js::location('./?m=inquiry&a=newsletter', manage::language('{/inquiry.select_notes/}'));
		
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
		/************* 查询 ***********/
		//Add some data
		//(A ~ EZ)
		$arr=range('A', 'Z');
		$ary=$arr;
		for($i=0; $i<5; ++$i){
			$num=$arr[$i];
			foreach((array)$arr as $v){
				$ary[]=$num.$v;
			}
		}
		$where = "`NId` IN ({$Id})";
		$newsletter_row = str::str_code(db::get_all('newsletter', $where, '*', 'NId desc'));
		/********************/
		$num=0;
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+0].'1', manage::language('{/global.email/}'));
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+1].'1', manage::language('{/global.time/}'));
		$num+=2;
		$columnNumber=$num;
		
		$i=2;
		foreach((array)$newsletter_row as $v){
			$num=0;
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+0].$i, $v['Email']);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+1].$i, date('Y-m-d H:i:s', $v['AccTime']));
			$num+=2;
			++$i;
		}
		
		//设置列的宽度
		for($i=0; $i<$columnNumber; ++$i){
			$objPHPExcel->getActiveSheet()->getColumnDimension($ary[$i])->setWidth(20);
			$objPHPExcel->getActiveSheet()->getStyle($ary[$i].'1')->getAlignment()->setWrapText(true);//自动换行
			$objPHPExcel->getActiveSheet()->getStyle($ary[$i].'1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);//垂直居中
		}
		
		//Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle('Simple');
		
		//Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		//Save Excel 2007 file
		$ExcelName='newsletter_'.str::rand_code();
		$objWriter=new PHPExcel_Writer_Excel5($objPHPExcel);
		$objWriter->save($c['root_path']."/tmp/{$ExcelName}.xls");
		
		file::down_file("/tmp/{$ExcelName}.xls");
		file::del_file("/tmp/{$ExcelName}.xls");
		unset($c, $objPHPExcel);
		exit;
	}
	
	public static function inquiry_explode(){//导出询盘
		global $c;
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$Id = trim($g_IdStr, ',');
		!$Id && js::location('./?m=inquiry&a=inquiry', manage::language('{/inquiry.select_notes/}'));
		
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
		/************* 查询 ***********/
		//Add some data
		//(A ~ EZ)
		$arr=range('A', 'Z');
		$ary=$arr;
		for($i=0; $i<5; ++$i){
			$num=$arr[$i];
			foreach((array)$arr as $v){
				$ary[]=$num.$v;
			}
		}
		$where = "IId in({$Id})";
		$inquiry_row = str::str_code(db::get_all('products_inquiry', $where, '*', 'IId desc'));
		/********************/
		$num=0;
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+0].'1', manage::language('{/global.title/}'));
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+1].'1', manage::language('{/global.contents/}'));
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+2].'1', manage::language('{/global.email/}'));
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+3].'1', manage::language('{/global.name/}'));
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+4].'1', manage::language('{/inquiry.country/}'));
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+5].'1', manage::language('{/inquiry.tel/}'));
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+6].'1', manage::language('{/inquiry.fax/}'));
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+7].'1', manage::language('{/inquiry.address/}'));
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+8].'1', manage::language('{/inquiry.postcode/}'));
		$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+9].'1', manage::language('{/inquiry.products/}'));
		$num+=10;
		$columnNumber=$num;
		
		$i=2;
		foreach((array)$inquiry_row as $v){
			$Name_str = '';
			$ProId = $v['ProId'];
			$ProId && $product_row = db::get_one("products","ProId = '$ProId'",'*');
			if($product_row){
				foreach((array)$c['manage']['language_web'] as $key=>$val){
					$Name_str .= $product_row['Name_'.$val]."\r\n";
				}
			}
			$num=0;
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+0].$i, $v['Subject']);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+1].$i, $v['Message']);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+2].$i, $v['Email']);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+3].$i, $v['FirstName']." ".$v['LastName']);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+4].$i, $v['City']." ".$v['State']." ".$v['Country']);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+5].$i, $v['Phone']);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+6].$i, $v['Fax']);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+7].$i, $v['Address']);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+8].$i, $v['PostalCode']);
			$objPHPExcel->getActiveSheet()->setCellValue($ary[$num+9].$i, $Name_str);
			$num+=10;
			++$i;
		}
		
		//设置列的宽度
		for($i=0; $i<$columnNumber; ++$i){
			$objPHPExcel->getActiveSheet()->getColumnDimension($ary[$i])->setWidth(20);
			$objPHPExcel->getActiveSheet()->getStyle($ary[$i].'1')->getAlignment()->setWrapText(true);//自动换行
			$objPHPExcel->getActiveSheet()->getStyle($ary[$i].'1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);//垂直居中
		}
		
		//Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle('Simple');
		
		//Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		//Save Excel 2007 file
		$ExcelName='inquiry_'.str::rand_code();
		$objWriter=new PHPExcel_Writer_Excel5($objPHPExcel);
		$objWriter->save($c['root_path']."/tmp/{$ExcelName}.xls");
		
		file::down_file("/tmp/{$ExcelName}.xls");
		file::del_file("/tmp/{$ExcelName}.xls");
		unset($c, $objPHPExcel);
		exit;
	}
	
	public static function review_edit(){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$p_RId=(int)$p_RId;
		$p_Display=(int)$p_Display;
		
		db::update('products_review', "RId='$p_RId'", array('Display'=>$p_Display));
		
		manage::operation_log('修改产品评论');
		ly200::e_json(array('jump'=>$p_back_action?$p_back_action:"?m=inquiry&a=review"), 1);
	}
}
?>