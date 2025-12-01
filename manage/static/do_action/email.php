<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

class email_module{
	public static function send(){
		global $c;
		manage::check_permit('email.send', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$p_Content=stripslashes($p_Content);
		$same=(substr_count($p_Subject, '{Email}') || substr_count($p_Subject, '{FullName}') || substr_count($p_Content, '{Email}') || substr_count($p_Content, '{FullName}'))?0:1;
		$to_ary=$to_name_ary=$send_list=array();
		$email_ary=explode("\r\n", $p_Email);
		$p_Content=preg_replace("~([\"|'|(|=])/u_file/~i", '$1'.web::get_domain(1).'/u_file/', $p_Content);
		
		$email_ary=array_unique($email_ary);//删除重复
		count($email_ary)>1 && ly200::e_json(manage::language('{/email.send.bat_send_notes/}'));
		
		foreach($email_ary as $k=>$v){
			if($v!=''){
				$list_ary=explode('/', str_replace(';', '', $v));
				if(in_array(trim($list_ary[0]), $send_list)){
					continue;
				}else{
					$send_list[]=trim($list_ary[0]);
				}
				$to=$list_ary[0];
				$to_name=$list_ary[1];
				if($same==0){	//邮件内容不相同
					$ToAry[]=trim($list_ary[0]);
					$name[]=trim($list_ary[1]);
					$subject[]=str_replace(array('{Email}', '{FullName}'), array($to, $to_name), $p_Subject);
					$body[]=str_replace(array('{Email}', '{FullName}'), array($to, $to_name), $p_Content);
				}else{	//邮件内容全部相同的
					$ToAry[]=trim($list_ary[0]);
					$name[]=trim($list_ary[1]);
					$subject[]=$p_Subject;
					$body[]=$p_Content;
				}
			}
		}
		foreach($ToAry as $v){	//邮件发送记录
			db::insert('email_log', array(
					'Email'		=>	$v,
					'Subject'	=>	addslashes($subject[0]),
					'Body'		=>	addslashes($body[0]),
					'AccTime'	=>	$c['time']
				)
			);
		}
		manage::operation_log('发送邮件');
		ly200::sendmail($ToAry, $subject[0], $body[0]);//不批量发送
		ly200::e_json('', 1, 0);
	}

	public static function config(){
		global $c;
		manage::check_permit('email.config', 1);
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$data=array(
			'FromEmail'		=>	$p_FromEmail,
			'FromName'		=>	$p_FromName,
			'SmtpHost'		=>	$p_SmtpHost,
			'SmtpPort'		=>	$p_SmtpPort,
			'SmtpUserName'	=>	$p_SmtpUserName,
			'SmtpPassword'	=>	$p_SmtpPassword
		);
		manage::config_operaction(array('Config'=>str::json_data($data)), 'email');
		manage::operation_log('修改邮件系统设置');
		ly200::e_json(manage::language('{/global.edit_success/}'), 1);
	}
}
?>