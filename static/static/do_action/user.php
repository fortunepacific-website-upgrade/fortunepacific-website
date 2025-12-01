<?php 
class user_module{
	/************************** 功能模块 Start **************************/
	public static function check_login($url='', $type=0){//type 0:跳转返回 1:返回结果
		if((int)$_SESSION['ly200_user']['UserId']){
			$data=array();
			$data=$_SESSION['ly200_user'];
			$data['fetch_where']="UserId={$data[UserId]}";
			return $data;
		}else{
			if($type){
				return false;
			}else{
				js::location('/account/sign-up.html'.($url?"?&jumpUrl={$url}":''), '', '.top');
			}
		}
	}
	
	public static function logout(){
		global $c;
		$_SESSION['ly200_user']='';
		unset($_SESSION['ly200_user'], $_SESSION['LoginReturnUrl']);
		js::location('/');//	account/	/account/sign-up.html
	}
	
	public static function login(){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		if(empty($p_Email) || empty($p_Password) || !preg_match('/^[a-z0-9][a-z\.0-9-_]+@[a-z0-9_-]+(?:\.[a-z]{0,3}\.[a-z]{0,2}|\.[a-z]{0,3}|\.[a-z]{0,2})$/i', $p_Email)){
			ly200::e_json(array($c['lang_pack']['user']['error']['Email']), 0);
			exit;
		}

		$p_Password=str::password($p_Password);
		$time=$c['time'];
		$ip=ly200::get_ip();
		if($user_row=str::str_code(db::get_one('user', "Email='$p_Email' and Password='$p_Password'"))){
			if(($c['FunVersion'] && $c['config']['global']['UserStatus'] && $user_row['Status']==1) || !$c['config']['global']['UserStatus']){//会员审核
				$_SESSION['ly200_user']=$user_row;
				$UserId=$user_row['UserId'];
				
				db::update('user', "UserId='{$UserId}'", array('LastLoginTime'=>$time, 'LastLoginIp'=>$ip, 'LoginTimes'=>$user_row['LoginTimes']+1));
				user::operation_log($UserId, '会员登录');
				$p_jumpUrl=$p_jumpUrl?$p_jumpUrl:$_SESSION['LoginReturnUrl'];
				ly200::e_json(array($p_jumpUrl ? urldecode($p_jumpUrl) : '/account/'), 1);
			}else{
				ly200::e_json(array($c['lang_pack']['user']['error']['LoginStatus']), 0);
			}
		}else{
			ly200::e_json(array($c['lang_pack']['user']['error']['Password']), 0);
		}
	}
	
	public static function register(){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		if(empty($p_Email) || !preg_match('/^[a-z0-9][a-z\.0-9-_]+@[a-z0-9_-]+(?:\.[a-z]{0,3}\.[a-z]{0,2}|\.[a-z]{0,3}|\.[a-z]{0,2})$/i', $p_Email) || strlen($p_Email)>100){
			ly200::e_json(array($c['lang_pack']['user']['error']['EmailEntered']), 0);
			exit;
		}
		if(empty($p_Password)) exit;
		
		$p_Password=str::password($p_Password);
		$p_Other=str::json_data((array)$p_Other);
		
		if(!db::get_row_count('user', "Email='$p_Email'")){
			$time=$c['time'];
			$ip=ly200::get_ip();
			
			$data=array(
				'Language'		=>	'en',
				'Gender'		=>	(int)$p_Gender,
				'FirstName'		=>	$p_FirstName,
				'LastName'		=>	$p_LastName,
				'Email'			=>	$p_Email,
				'Password'		=>	$p_Password,
				'Age'			=>	(int)$p_Age,
				'NickName'		=>	$p_NickName,
				'Telephone'		=>	$p_Telephone,
				'Fax'			=>	$p_Fax,
				'Birthday'		=>	strtotime($p_Birthday),
				'Facebook'		=>	$p_Facebook,
				'Company'		=>	$p_Company,
				'Other'			=>	$p_Other,
				'RegTime'		=>	$time,
				'RegIp'			=>	$ip,
				'LastLoginTime'	=>	$time,
				'LastLoginIp'	=>	$ip,
				'LoginTimes'	=>	1,
				'Status'		=>	0
			);
			db::insert('user', $data);
			$UserId=db::get_insert_id();
			if($c['FunVersion'] && $c['config']['global']['UserStatus']){//开启会员审核
				$_SESSION['ly200_user']='';
				unset($_SESSION['ly200_user']);
				$tips=array($c['lang_pack']['user']['error']['UserStatus']);
				$status=0;
				
				if((int)$c['config']['global']['UserVerification']){
					$tips=array('/account/sign-up.html?userType=1&UserId='.$UserId);
					$status=1;
					include($c['static_path'].'/inc/mail/validate_mail.php');
					ly200::sendmail($data['Email'], "Dear {$p_Email}, Please verify your email address. ".web::get_domain(0), $mail_contents);
				}
			}else{
				$_SESSION['ly200_user']=$data;
				$_SESSION['ly200_user']['UserId']=$UserId;
				$tips=array($p_jumpUrl ? urldecode(stripslashes($p_jumpUrl)) : '/account/');
				$status=1;
				
				user::operation_log($UserId, '会员注册');
				include($c['static_path'].'/inc/mail/create_account.php');
				ly200::sendmail($data['Email'], 'Welcome to '.web::get_domain(0), $mail_contents);
			}
			ly200::e_json($tips, $status);
		}else{
			ly200::e_json(array($c['lang_pack']['user']['error']['Exists']), 0);
		}
	}
	
	public static function mod_profile(){
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$user=self::check_login();
		(empty($p_FirstName) || empty($p_LastName)) && js::location('/account/setting/');
		$p_Other=str::json_data((array)$p_Other);
		$data=array(
			'Language'		=>	'en',
			'Gender'		=>	(int)$p_Gender,
			'FirstName'		=>	$p_FirstName,
			'LastName'		=>	$p_LastName,
			'Age'			=>	(int)$p_Age,
			'NickName'		=>	$p_NickName,
			'Telephone'		=>	$p_Telephone,
			'Fax'			=>	$p_Fax,
			'Birthday'		=>	strtotime($p_Birthday),
			'Facebook'		=>	$p_Facebook,
			'Company'		=>	$p_Company,
			'Other'			=>	$p_Other,
		);
		db::update('user', "UserId='{$user['UserId']}'", $data);
		
		foreach($data as $k=>$v) $_SESSION['ly200_user'][$k]=$v;
		js::location('/account/setting/');
	}
	
	public static function mod_email(){
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$user=self::check_login();
		(empty($p_NewEmail) || empty($p_ExtPassword) || !preg_match('/^[a-z0-9][a-z\.0-9-_]+@[a-z0-9_-]+(?:\.[a-z]{0,3}\.[a-z]{0,2}|\.[a-z]{0,3}|\.[a-z]{0,2})$/i', $p_NewEmail)) && js::location('/account/setting/');
		
		if(db::get_row_count('user', "Email='$p_Email'")){
			js::location('/account/setting/', 'Sorry, this email address has already been used!');
		}else{
			$p_ExtPassword=str::password($p_ExtPassword);
			if(db::get_row_count('user', "UserId='{$user['UserId']}' and Password='$p_ExtPassword'")){
				db::update('user', "UserId='{$user['UserId']}'", array('Email'=>$p_NewEmail));		
				$_SESSION['ly200_user']['Email']=$p_NewEmail;
				js::location('/account/setting/');
			}else{
				js::location('/account/setting/', 'Sorry, existing password is wrong!');
			}
		}
	}
	
	public static function mod_password(){
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$user=self::check_login();
		(empty($p_ExtPassword) || empty($p_NewPassword) || empty($p_NewPassword2)) && js::location('/account/setting/');
		
		if($p_NewPassword!=$p_NewPassword2){
			js::location('/account/setting/', 'Sorry, your passwords do not match, please try again!');
		}else{
			$p_ExtPassword=str::password($p_ExtPassword);
			if(db::get_row_count('user', "UserId='{$user['UserId']}' and Password='$p_ExtPassword'")){
				$p_NewPassword=str::password($p_NewPassword);
				db::update('user', "UserId='{$user['UserId']}'", array('Password'=>$p_NewPassword));
				js::location('/account/setting/');
			}else{
				js::location('/account/setting/', 'Sorry, existing password is wrong!');
			}
		}
	}
	/************************** 收藏模块 End **************************/
	public static function forgot(){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$Email=$p_Email;
		$user_row=db::get_one('user', "Email='$Email'", 'UserId,Email,FirstName,LastName');
		if ($user_row){
			$EmailEncode=base64_encode($user_row['Email']);
			$Expiry=base64_encode(str::rand_code(15));
			
			if(!db::get_row_count('user_forgot', "UserId='{$user_row['UserId']}' and IsReset=0")){
				db::insert('user_forgot', array(
						'UserId'		=>	$user_row['UserId'],
						'EmailEncode'	=>	$EmailEncode,
						'Expiry'		=>	$Expiry,
						'ResetTime'		=>	$c['time'],
						'IsReset'		=>	0
					)
				);
			}else{
				db::update('user_forgot', "UserId='{$user_row['UserId']}' and IsReset=0", array(
						'EmailEncode'	=>	$EmailEncode,
						'Expiry'		=>	$Expiry,
						'ResetTime'		=>	$c['time']
					)
				);
			}
			
			include($c['static_path'].'/inc/mail/forgot_password.php');
			ly200::sendmail($Email, web::get_domain(0).' Password Recovery', $mail_contents);
			ly200::e_json(array('/account/forgot.html?forgot_success=1'), 1);
		}else{
			ly200::e_json(array($c['lang_pack']['user']['error']['Forgot']), 0);
		}
	}
	
	public static function reset_password(){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$Password=str::password($p_Password);
		$Password2=str::password($p_Password2);
		$email=$p_email;
		$expiry=$p_expiry;
		$user_row=db::get_one('user_forgot', "EmailEncode='$email' and Expiry='$expiry' and IsReset=0");
		if ($Password==$Password2 && $user_row){
			db::update('user', "UserId='{$user_row['UserId']}'", array(
					'Password'	=>	$Password
				)
			);
			db::update('user_forgot', "FId='{$user_row['FId']}'", array(
					'IsReset'	=>	1
				)
			);
			ly200::e_json(array('/account/forgot.html?reset_success=1'), 1);
		}else{
			ly200::e_json(array($c['lang_pack']['user']['error']['Forgot']), 0);
		}
		
	}	
}
?>