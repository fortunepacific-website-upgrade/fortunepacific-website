<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

class user_module{
	public static function user_del(){
		global $c;
		manage::check_permit('user.user', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		$g_id=ary::ary_format($g_id, 2);
		db::delete('user', "UserId in($g_id)");
		db::delete('products_review', "UserId in($g_id)");
		manage::operation_log('删除会员');
		ly200::e_json('', 1);
	}

	public static function user_list_field(){
		global $c;
		manage::check_permit('user.user', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$p_Custom=addslashes(str::json_data(str::str_code($p_Custom, 'stripslashes')));
		$data=array('User'=>$p_Custom);
		manage::config_operaction($data, 'custom_column');
		manage::operation_log('会员自定义列');
		ly200::e_json('', 1);
	}

	public static function user_explode_down(){
		global $c;
		manage::check_permit('user.user', 1);
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		if($g_Status=='ok' && count($_SESSION['UserZip'])){	//开始打包
			$zip=new ZipArchive();
			$zipname='/tmp/user_'.str::rand_code().'.zip';
			if($zip->open($c['root_path'].$zipname, ZIPARCHIVE::CREATE)===TRUE){
				foreach($_SESSION['UserZip'] as $path){
					if(is_file($c['root_path'].$path)) $zip->addFile($c['root_path'].$path, $path);
				}
				$zip->close();
				file::down_file($zipname);
				file::del_file($zipname);
				foreach($_SESSION['UserZip'] as $path){
					if(is_file($c['root_path'].$path)) file::del_file($path);
				}
			}
		}
		unset($_SESSION['UserZip']);
		exit();
	}

	public static function user_explode(){
		global $c;
		manage::check_permit('user.user', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$p_Number=(int)$p_Number;
		if(!$p_Number) unset($_SESSION['UserZip']);
		include($c['root_path'].'/inc/class/excel.class/PHPExcel.php');
		include($c['root_path'].'/inc/class/excel.class/PHPExcel/Writer/Excel5.php');
		include($c['root_path'].'/inc/class/excel.class/PHPExcel/IOFactory.php');

		$page_count=1000;//每次分开导出的数量
		$where='1';
		$other_row = range("M","Z");

		if($p_RegTime){ //注册时间
			$RegTime=@explode('/', $p_RegTime);
			$start_time=(int)@strtotime($RegTime[0]);
			$end_time=(int)@strtotime($RegTime[1]);
			$where.=" and RegTime > {$start_time} and RegTime < $end_time";
		}

		//(int)$_SESSION['Manage']['GroupId']==3 && $where.=" and SalesId='{$_SESSION['Manage']['UserId']}'";//业务员账号过滤
		$row_count=db::get_row_count('user', $where, 'UserId');
		$total_pages=ceil($row_count/$page_count);
		$zipAry=array();//储存需要压缩的文件
		$save_dir='/tmp/';//临时储存目录
		file::mk_dir($save_dir);
		if($p_Number<$total_pages){
			$page=$page_count*$p_Number;
			$user_row=str::str_code(db::get_limit('user', $where, '*', 'UserId desc', $page, $page_count));
			$objPHPExcel=new PHPExcel();
			//Set properties
			$objPHPExcel->getProperties()->setCreator('Ueeshop');
			$objPHPExcel->getProperties()->setLastModifiedBy('Ueeshop');
			$objPHPExcel->getProperties()->setTitle('Ueeshop');
			$objPHPExcel->getProperties()->setSubject('Ueeshop');
			$objPHPExcel->getProperties()->setKeywords('Ueeshop');
			$objPHPExcel->getProperties()->setCategory('Ueeshop');
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->setCellValue('A1', manage::language('{/user.name/}'));
			$objPHPExcel->getActiveSheet()->setCellValue('B1', manage::language('{/user.gender/}'));
			$objPHPExcel->getActiveSheet()->setCellValue('C1', manage::language('{/user.email/}'));
			$objPHPExcel->getActiveSheet()->setCellValue('D1', manage::language('{/user.reg_field.Age/}'));
			$objPHPExcel->getActiveSheet()->setCellValue('E1', manage::language('{/user.reg_field.NickName/}'));
			$objPHPExcel->getActiveSheet()->setCellValue('F1', manage::language('{/user.reg_field.Telephone/}'));
			$objPHPExcel->getActiveSheet()->setCellValue('G1', manage::language('{/user.reg_field.Fax/}'));
			$objPHPExcel->getActiveSheet()->setCellValue('H1', manage::language('{/user.reg_field.Birthday/}'));
			$objPHPExcel->getActiveSheet()->setCellValue('I1', manage::language('{/user.reg_field.Facebook/}'));
			$objPHPExcel->getActiveSheet()->setCellValue('J1', manage::language('{/user.reg_field.Company/}'));
			$objPHPExcel->getActiveSheet()->setCellValue('K1', manage::language('{/user.reg_time/}'));
			$objPHPExcel->getActiveSheet()->setCellValue('L1', manage::language('{/user.reg_ip/}'));

			$set_ary=array();
			$set_row=str::str_code(db::get_all('user_reg_set', '1', '*', "{$c[my_order]}SetId asc"));
			foreach((array)$set_row as $k=>$v){
				$set_ary[$v['SetId']]=$v;
				if($v['TypeId']){
					$set_ary[$v['SetId']]['Option']=explode("\r\n", $v['Option'.$c['lang']]);
				}
				
				$objPHPExcel->getActiveSheet()->setCellValue($other_row[$k].'1', $v['Name_en']);
			}
			
			$i=2;
			foreach($user_row as $v){
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $v['FirstName'].' '.$v['LastName']);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $c['gender'][$v['Gender']]);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $v['Email']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $v['Age']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $v['NickName']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $v['Telephone']);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $v['Fax']);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, @date('Y-m-d',$v['Birthday']));
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $v['Facebook']);
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $v['Company']);
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, date('Y-m-d H:i:s', $v['RegTime']));
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $v['RegIp']);
				
				$other_ary=str::json_data(htmlspecialchars_decode($v['Other']), 'decode');
				$od=0;
				foreach($other_ary as $kk=>$vv){
					if($set_ary[$kk]['TypeId']){
						$vv=$set_ary[$kk]['Option'][$vv];
					}
					$objPHPExcel->getActiveSheet()->setCellValue($other_row[$od].$i, $vv);
					++$od;
				}

				++$i;
			}

			//设置列的宽度
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(5);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
			$objPHPExcel->getActiveSheet()->setTitle('Simple');//Rename sheet
			$objPHPExcel->setActiveSheetIndex(0);
			$ExcelName='user_'.str::rand_code();
			$objWriter=new PHPExcel_Writer_Excel5($objPHPExcel);
			$objWriter->save($c['root_path']."{$save_dir}{$ExcelName}.xls");
			$_SESSION['UserZip'][]="{$save_dir}{$ExcelName}.xls";
			unset($c, $objPHPExcel, $objWriter, $user_row);
			ly200::e_json(array(($p_Number+1), manage::language('{/user.explode_progress/}')."{$save_dir}{$ExcelName}.xls<br />"), 2);
		}else{
			if(count($_SESSION['UserZip'])){
				ly200::e_json('', 1);
			}else{
				ly200::e_json(manage::language('{/error.no_data/}'));
			}
		}
	}

	public static function user_base_info(){
		global $c;
		manage::check_permit('user.user', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$p_UserId=(int)$p_UserId;
		$data=array(
			'Status'		=>	($c['FunVersion'] && $c['manage']['config']['UserStatus'])?(int)$p_Status:0,
			'Gender'		=>	(int)$p_Gender,
			'Age'			=>	(int)$p_Age,
			'NickName'		=>	$p_NickName,
			'Telephone'		=>	$p_Telephone,
			'Fax'			=>	$p_Fax,
			'Birthday'		=>	strtotime($p_Birthday),
			'Facebook'		=>	$p_Facebook,
			'Company'		=>	$p_Company
		);

		db::update('user', "UserId={$p_UserId}", $data);
		user::operation_log($p_UserId, '修改基本信息');
		manage::operation_log('修改会员基本信息');
		ly200::e_json('', 1);
	}

	public static function user_password_info(){
		manage::check_permit('user.user', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		if($p_NewPassword==$p_ReNewPassword){
			$p_UserId=(int)$p_UserId;
			$p_NewPassword=str::password($p_NewPassword);
			db::update('user', "UserId={$p_UserId}", array('password'=>$p_NewPassword));
			user::operation_log($p_UserId, '修改密码');
			manage::operation_log('修改会员密码');
			ly200::e_json('', 1);
		}else{
			ly200::e_json(manage::language('{/user.info.confirm_password_err/}'));
		}
	}

	public static function user_add(){
		global $c;
		manage::check_permit('user.add', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$data=array(
			'Email'		=>	$p_Email,
			'Password'	=>	str::password($p_Password),
			'RegTime'	=>	$c['time']
		);
		if(!db::get_row_count('user',"Email='$p_Email'")){
			db::insert('user',  $data);
			manage::operation_log('增加会员信息');
			ly200::e_json('', 1);
		}else{
			ly200::e_json($p_Email.':'.manage::language('{/user.email_exist_notes/}'), 0);
		}
	}
}
?>