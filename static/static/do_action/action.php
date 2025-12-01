<?php
class action_module{
	//订阅提交
	public static function newsletter(){//订阅提交
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$status=-1;
		if(!db::get_row_count('newsletter', "Email='{$p_Email}'")){
			$status=1;
			db::insert('newsletter', array(
					'Email'		=>	$p_Email,
					'AccTime'	=>	$c['time']
				)
			);
		}
		exit(str::json_data(array('status'=>$status, 'msg'=>$p_Email)));
	}

	public static function add_inquiry(){//加入询盘篮
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$isopeninq = !$c['FunVersion'] ? 1 : (int)$c['config']['global']['IsOpenInq'];//标准版直接跳过
		if($isopeninq){
			$status=-1;
			$is_there=-1;
			$ProId=(int)$p_ProId;
			if($c['config']['products']['Config']['inq_type']){
				$status=1;
				$is_there=1;
				$_SESSION['InquiryProducts']=$ProId;
			}else{
				$ProIdList=(array)$_SESSION['InquiryProducts'];
				if(!@in_array($ProId, $ProIdList)){//不在询盘篮里面
					$status=1;
					$is_there=1;
					$_SESSION['InquiryProducts'][]=$ProId;
				}
			}
			exit(str::json_data(array('status'=>$status,'inq_type'=>(int)$c['config']['products']['Config']['inq_type'],'is_there'=>$is_there)));
		}
	}

	public static function del_inquiry(){//删除询盘篮
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$status=-1;
		$ProId=(int)$p_ProId;
		if($c['config']['products']['Config']['inq_type']){
			unset($_SESSION['InquiryProducts']);
		}else{
			foreach($_SESSION['InquiryProducts'] as $k=>$v){
				if($ProId==$v){
					$status=1;
					unset($_SESSION['InquiryProducts'][$k]);
				}
			}
		}
		$_SESSION['InquiryProducts'] || $status=2;
		exit(str::json_data(array('status'=>$status)));
	}

	public static function submit_inquiry(){//提交询盘篮
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$isopeninq = !$c['FunVersion'] ? 1 : (int)$c['config']['global']['IsOpenInq'];//标准版直接跳过
		if($isopeninq){
			$p_Site=@substr($c['lang'], 1);
			switch($p_Site){
				case 'cn':
					$vcode_tips='验证码错误，请正确填写验证码！';
					$success_tips='留言提交成功，谢谢您的支持！';
					break;
				case 'es':
					$vcode_tips='Lo siento, por favor, escriba los caracteres que ve en la imagen!';
					$success_tips='Presentada. Gracias por su consulta!';
					break;
				case 'ru':
					$vcode_tips='Прости,пожалуйста, введите символы в картину вижу тебя!';
					$success_tips='Отправлено. Благодарим Вас за запрос!';
					break;
				case 'jp':
					$vcode_tips='申し訳ありませんが、タイプしてください、あなたが絵の中で見る文字！';
					$success_tips='提出されました。 あなたのお問い合わせありがとう！';
					break;
				case 'de':
					$vcode_tips='Tut Mir leid, bitte geben sie die Zeichen in den bildern sehen SIE！';
					$success_tips='Gesendet. Vielen Dank für Ihre Anfrage!';
					break;
				case 'fr':
					$vcode_tips="Désolé, saisissez le caractère dans l'image de vous voir！";
					$success_tips='Soumis. Merci pour votre demande!';
					break;
				default:
					$vcode_tips='Sorry, Please type the characters you see in the picture!';
					$success_tips='Submitted. Thanks for your inquiry!';
					$p_Site='en';
					break;
			}

			$ProId=$c['config']['products']['Config']['inq_type']?(int)$_SESSION['InquiryProducts']:@trim(@implode(',', $_SESSION['InquiryProducts']), ',');
			!$ProId && exit(str::json_data(array('status'=>-1))); //没有产品信息

			$in=0;
			$un_keyword_ary=array('www', 'http');	//带有本关键词的内容不存入数据库
			$str=$p_FirstName.$p_LastName.$p_Email.$p_Address.$p_City.$p_State.$p_Country.$p_PostalCode.$p_Phone.$p_Fax.$p_Subject.$p_Message;	//过滤内容
			foreach($un_keyword_ary as $v){if(@substr_count($str, $v)){$in=1;break;}}

			// if(strtoupper($p_VCode)!=strtoupper($_SESSION['Global']['v_code'][md5('inquiry')]) || $_SESSION['Global']['v_code'][md5('inquiry')]==''){	//验证码错误
			// 	$_SESSION['Global']['v_code'][md5('inquiry')]='';
			// 	unset($_SESSION['Global']['v_code'][md5('inquiry')]);

			// 	exit(str::json_data(array('status'=>-1, 'msg'=>$vcode_tips)));
			// }
			$data=array(
				'ProId'			=>	$ProId,
				'Source'		=>	$c['is_mobile_client'],
				'FirstName'		=>	$p_FirstName,
				'LastName'		=>	$p_LastName,
				'Email'			=>	$p_Email,
				'Address'		=>	$p_Address,
				'City'			=>	$p_City,
				'State'			=>	$p_State,
				'Country'		=>	$p_Country,
				'PostalCode'	=>	$p_PostalCode,
				'Phone'			=>	$p_Phone,
				'Fax'			=>	$p_Fax,
				'Subject'		=>	$p_Subject,
				'Message'		=>	$p_Message,
				'Site'			=>	$p_Site,
				'Ip'			=>	ly200::get_ip(),
				'AccTime'		=>	$c['time']
			);
			db::insert('products_inquiry', $data);
			$iid = db::get_insert_id();

			include("{$c['static_path']}/inc/mail/inquiry.php");
			$name = db::get_value('products',"ProId in ($ProId)","Name{$c['lang']}", 'ProId asc');
			ly200::sendmail($c['config']['global']['Contact']['email'],$name,$table);
			unset($_SESSION['InquiryProducts']);

			exit(str::json_data(array('status'=>1, 'msg'=>$success_tips)));
		}
	}

	public static function submit_feedback(){//提交留言
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		switch($p_Site){
			case 'cn':
				$vcode_tips='验证码错误，请正确填写验证码！';
				$success_tips='留言提交成功，谢谢您的支持！';
				break;
			case 'es':
				$vcode_tips='Lo siento, por favor, escriba los caracteres que ve en la imagen！';
				$success_tips='Gracias por tu presente investigación！';
				break;
			case 'ru':
				$vcode_tips='Прости,пожалуйста, введите символы в картину вижу тебя!';
				$success_tips='представления запросов от тебя поблагодарить！';
				break;
			case 'jp':
				$vcode_tips='申し訳ありませんが、タイプしてください、あなたが絵の中で見る文字！';
				$success_tips='お問い合わせからの提出ありがとう！';
				break;
			case 'de':
				$vcode_tips='Tut Mir leid, bitte geben sie die Zeichen in den bildern sehen SIE！';
				$success_tips='Aus ihrer anfrage Danken！';
				break;
			case 'fr':
				$vcode_tips="Désolé, saisissez le caractère dans l'image de vous voir！";
				$success_tips='De remercier votre demande est présentée！';
				break;
			default:
				$vcode_tips='Sorry, Please type the characters you see in the picture!';
				$success_tips='Thanks for submitting your feedback!';
				$p_Site='en';
				break;
		}

		if(!$p_float){
			if(strtoupper($p_VCode)!=strtoupper($_SESSION['Global']['v_code'][md5('feedback')]) || $_SESSION['Global']['v_code'][md5('feedback')]==''){	//验证码错误
				$_SESSION['Global']['v_code'][md5('feedback')]='';
				unset($_SESSION['Global']['v_code'][md5('feedback')]);
				exit(str::json_data(array('status'=>-1, 'msg'=>$vcode_tips)));
			}
		}

		$in=0;
		$un_keyword_ary=array('www', 'http');	//带有本关键词的内容不存入数据库
		$str=$p_Name.$p_Company.$p_Phone.$p_Mobile.$p_Email.$p_Subject.$p_Message;	//过滤内容
		foreach($un_keyword_ary as $v){if(@substr_count($str, $v)){$in=1;break;}}

		$data=array(
			'Name'		=>	$p_Name,
			'Company'	=>	$p_Company,
			'Phone'		=>	$p_Phone,
			'Mobile'	=>	$p_Mobile,
			'Email'		=>	$p_Email,
			'Subject'	=>	$p_Subject,
			'Message'	=>	$p_Message,
			'Site'		=>	$p_Site,
			'Ip'		=>	ly200::get_ip(),
			'AccTime'	=>	$c['time'],
			'AId'		=>	$p_AId,
			'Source'	=>	$c['is_mobile_client']
		);
		$set_row=str::str_code(db::get_all('feedback_set', '1', '*', "{$c[my_order]} SetId asc"));
		foreach((array)$set_row as $k=>$v){
			$fields .= $v['SetId'].":".$_POST['fields_'.$k]."---";
		}
		$data['CustValue']=$fields;

		db::insert('feedback', $data);

		exit(str::json_data(array('status'=>1, 'msg'=>$success_tips)));
	}

	public static function submit_review(){//提交评论
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		switch($p_Site){
			case 'cn':
				$vcode_tips='验证码错误，请正确填写验证码！';
				$success_tips='留言提交成功，谢谢您的支持！';
				$mem_tips='请登录会员账号！';
				break;
			case 'es':
				$vcode_tips='Lo siento, por favor, escriba los caracteres que ve en la imagen！';
				$success_tips='Gracias por tu presente investigación！';
				$mem_tips='Plase Login Member！';
				break;
			case 'ru':
				$vcode_tips='Прости,пожалуйста, введите символы в картину вижу тебя!';
				$success_tips='представления запросов от тебя поблагодарить！';
				$mem_tips='Plase Login Member！';
				break;
			case 'jp':
				$vcode_tips='申し訳ありませんが、タイプしてください、あなたが絵の中で見る文字！';
				$success_tips='お問い合わせからの提出ありがとう！';
				$mem_tips='Plase Login Member！';
				break;
			case 'de':
				$vcode_tips='Tut Mir leid, bitte geben sie die Zeichen in den bildern sehen SIE！';
				$success_tips='Aus ihrer anfrage Danken！';
				$mem_tips='Plase Login Member！';
				break;
			case 'fr':
				$vcode_tips="Désolé, saisissez le caractère dans l'image de vous voir！";
				$success_tips='De remercier votre demande est présentée！';
				$mem_tips='Plase Login Member！';
				break;
			default:
				$vcode_tips='Sorry, Please type the characters you see in the picture!';
				$success_tips='Thank you for your comments!';
				$mem_tips='Plase Login Member！';
				$p_Site='en';
				break;
		}
		if(strtoupper($p_VCode)!=strtoupper($_SESSION['Global']['v_code'][md5('review')]) || $_SESSION['Global']['v_code'][md5('review')]==''){	//验证码错误
			$_SESSION['Global']['v_code'][md5('review')]='';
			unset($_SESSION['Global']['v_code'][md5('review')]);
			exit(str::json_data(array('status'=>-1, 'msg'=>$vcode_tips)));
		}
		$data=array(
			'Name'		=>	$p_Name,
			'ProId'		=>	$p_ProId,
			'UserId'	=>	$p_UserId,
			'Subject'	=>	$p_Subject,
			'Content'	=>	$p_Content,
			'Ip'		=>	ly200::get_ip(),
			'AccTime'	=>	$c['time'],
			'Display'	=>	0,
			'Email'		=>	$p_Email,
			'Source'	=>	$c['is_mobile_client']
		);
		db::insert('products_review', $data);
		exit(str::json_data(array('status'=>1, 'msg'=>$success_tips)));
	}

	public static function download(){//下载
		$status=-1;
		$DId=(int)$_GET['DId'];
		$form=$_GET['form'];//通过后台打开
		$pwd=$_GET['pwd'];//密码
		$download_row=db::get_one('download', "DId='$DId'");
		if ($download_row['Password']!=$pwd && $_GET['form']!='manage'){//判断是否需要密码下载，后台下载无需密码
			js::back();
		}
		//下载文件
		$rename=$download_row['FileName']?($download_row['FileName'].'.'.file::get_ext_name($download_row['FilePath'])):'';
		if( ($download_row['IsMember'] && (int)$_SESSION['ly200_user']['UserId']) || $_GET['form']=='manage' || !$download_row['IsMember'] ){
			file::down_file($download_row['FilePath'], $rename);
		}else{
			js::back();
		}
		db::update('download', "DId='$DId'", array('ViewCount'=>$download_row['ViewCount']+1));
	}

	public static function download_pwd(){//密码下载，返回json前端处理
		global $c;
		$DId=(int)$_GET['DId'];
		$pwd=$_GET['pwd'];//密码
		$download_row=db::get_one('download', "DId='$DId'");
		if ($download_row['Password']==$pwd){
			$data = array();
			if ($download_row['IsOth']){//返回外链的网址
				$data['url'] = $download_row['FilePath'];
			}else{
				$data['url'] = 0;
			}
			ly200::e_json($data, 1);
		}else{//密码错误
			ly200::e_json(array($c['lang_pack']['user']['forgot']['tips7']), 0);
		}
	}

	public static function products_download(){//产品页下载
		global $c;
		$ProId=(int)$_GET['ProId'];
		$Path=(int)$_GET['Path'];
		$pwd=$_GET['pwd'];//密码
		$Path=($Path<0 || $Path>4)?0:$Path;
		$row = db::get_one('products', "ProId='$ProId'", "`ProId`, `FileName_{$Path}`, `FilePath_{$Path}`, `FilePwd_{$Path}`");
		$Name = $row["FileName_{$Path}"];
		if($row["FilePwd_{$Path}"]==$pwd && is_file($c['root_path'].$row["FilePath_{$Path}"])){
			file::down_file($row["FilePath_{$Path}"], ($Name?$Name:'File').'.'.file::get_ext_name($row["FilePath_{$Path}"]));
		}else{
			ly200::e_json(array("aaa"), 0);
		}
		return false;
	}

	public static function products_download_pwd(){//密码下载，返回json前端处理
		global $c;
		$ProId=(int)$_GET['ProId'];
		$Path=(int)$_GET['Path'];
		$pwd=$_GET['pwd'];//密码
		$Path=($Path<0 || $Path>4)?0:$Path;
		$row = db::get_one('products', "ProId='$ProId'", "`FilePwd_{$Path}`");
		if ($row["FilePwd_{$Path}"]==$pwd){
			ly200::e_json('', 1);
		}else{//密码错误
			ly200::e_json(array($c['lang_pack']['user']['forgot']['tips7']), 0);
		}
	}

	//博客列表加载
	public static function blog_list_loading(){
		global $c;

		$date=(int)$_GET['date'];
		$Keyword=$_GET['Keyword'];
		$CateId=(int)$_GET['CateId'];
		$Tags=$_GET['Tags'];
		$page=(int)$_GET['page'];

		$where='1';//条件
		$page_count=10;//显示数量
		$CateId && $where.=' and '.category::get_search_where_by_CateId($CateId, 'blog_category');
		$Keyword && $where.=" and Title like '%$Keyword%'";
		$Tags && $where.=" and Tag like '%|$Tags|%'";
		if($date){
			if(date('m', $date)==12){
				$next_m=mktime(0,0,0,1,1,date('Y',$date)+1);
			}else $next_m=mktime(0,0,0,date('m',$date)+1,1,date('Y',$date));
			$where.=" and AccTime BETWEEN $date and $next_m";
		}
		$blog_row=str::str_code(db::get_limit_page('blog', $where, '*', $c['my_order'].'AId desc', $page, $page_count));
		$blog_row_new=array();
		foreach((array)$blog_row[0] as $k => $v){
			$blog_row_new[$k]['Author']=$v['Author'];
			$blog_row_new[$k]['Day']=date('d', $v['AccTime']);
			$blog_row_new[$k]['YearMonth']=date('F Y', $v['AccTime']);
			$blog_row_new[$k]['Comments']=(int)db::get_row_count('blog_review', "AId='{$v['AId']}'");
			$blog_row_new[$k]['Url']=web::get_url($v, 'blog');
			$blog_row_new[$k]['Title']=$v['Title'];
			$blog_row_new[$k]['BriefDescription']=str::str_format($v['BriefDescription']);
			$blog_row_new[$k]['PicPath']=$v['PicPath'];
		}
		$blog_row[0]=$blog_row_new;
		ly200::e_json($blog_row, 1);
	}
	//博客评论加载
	public static function blog_review_loading(){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$p_AId=(int)$p_AId;
		$p_page=(int)$p_page;
		$review_row=str::str_code(db::get_limit_page('blog_review', "AId='$p_AId'", '*', 'RId desc', $p_page, 10));
		foreach((array)$review_row[0] as $k => $v){
			$review_row[0][$k]['AccTime']=date('F m,Y H:i',$v['AccTime']);
		}
		ly200::e_json($review_row, 1);
	}

	//博客评论
	public static function blog_review(){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');

		$vcode_tips='Sorry, Please type the characters you see in the picture!';
		if(strtoupper($p_VCode)!=strtoupper($_SESSION['Global']['v_code'][md5('blog')]) || $_SESSION['Global']['v_code'][md5('blog')]==''){	//验证码错误

			exit(str::json_data(array('status'=>-1, 'msg'=>$vcode_tips)));	
		}
		$_SESSION['Global']['v_code'][md5('blog')]='';
		unset($_SESSION['Global']['v_code'][md5('blog')]);
		
		$AId=(int)$p_AId;
		$Name=$p_Name;
		$Email=$p_Email;
		$Content=$p_Content;
		/*$p_VCode=trim($p_VCode);
		if(strtoupper($p_VCode)!=strtoupper($_SESSION['Ueeshop']['VerCode'][md5('blog')])){
			ly200::e_json('Verification code error 1!', 0);
		}
		if($_SESSION['Ueeshop']['VerCode'] && $_SESSION['v_code_check']=='ok'){
			$VerCode=base64_decode($_SESSION['Ueeshop']['VerCode']);
			$VerCode=@explode('_', $VerCode);
			$Time=60; //有效时间为60秒
			$VerTime=($c['time']+$Time)*1000;
			if($VerCode[0]!=$_COOKIE['PHPSESSID'] && $VerCode[1]>$VerTime){
				ly200::e_json('Verification code error 2!', 0);
			}
		}else{
			ly200::e_json('Verification code error!', 0);
		}
		unset($_SESSION['Ueeshop']['VerCode']);*/
		$data=array(
			'AId'		=>	$AId,//博客ID
			'Name'		=>	$Name,
			'Email'		=>	$Email,
			'Content'	=>	$Content,
			'AccTime'	=>	$c['time'],
			'Praise'	=>	0
		);

		db::insert('blog_review', $data);
		ly200::e_json('Submit Success', 1);
	}

}

