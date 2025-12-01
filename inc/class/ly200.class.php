<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

class ly200{
	public static function ad($number){
		global $c;
		$lang=substr($c['lang'], 1);
		$themes=$c['is_mobile_client']==0?$c['themes']:'mobile-'.$c['mobile']['HomeTpl'];
		$web_setting_row=db::get_one('web_settings', "Position='$number' and Themes='$themes'");
		$config=str::json_data($web_setting_row['Config'], 'decode');
		$width=(int)$config[0];
		$_width=$width?"{$width}px":'auto';
		$height=(int)$config[1];
		$_height=$height?"{$height}px":'auto';
		$count=(int)$config[2]?$config[2]:1;	//数量
		$data=str::json_data($web_setting_row['Data'], 'decode');
		$str="<div class='bxSlide-outter' style='overflow:hidden;margin-left:auto;margin-right:auto; width:$_width; max-width:100%; max-height:$_height'>";	//加上宽度，高度限定最大高度
		if($count==1){
			$data['Url'][0][$lang]!='' && $str.="<a href='{$data['Url'][0][$lang]}' target='_blank'>";
			@is_file($c['root_path'].$data['PicPath'][0][$lang]) && $str.="<img src='{$data['PicPath'][0][$lang]}' width='100%'>";
			$data['Url'][0][$lang]!='' && $str.="</a>";
		}else{
			$show_type_ary=array('', 'fade', 'vertical', 'horizontal');
			$show_type=$show_type_ary[(int)$data['ShowType']];
			$show_type=='' && $show_type='horizontal';
			$adaptive_height=$c['is_responsive']==1?'true':'false';	//响应式自适应高度
			$str.=ly200::load_static('/static/js/plugin/bxslider/jquery.bxslider.js', '/static/js/plugin/bxslider/jquery.bxslider.css');
			$str.="<div class='bxslider_{$number}'>";
			for($i=0; $i<$count; $i++){
				$target='target="_blank"';
				$img=$data['PicPath'][$i][$lang];
				$url=$data['Url'][$i][$lang];
				$title=$data['Title'][$i][$lang];
				if(!is_file($c['root_path'].$img)){continue;}
				if($url==''){
					$url='javascript:;';
					$target='';
				}
				$str.="<div>";
				if($c['is_responsive'] || $c['is_mobile_client']){
					$str.="<a href='$url' $target><img src='$img' alt='$title' width='100%'></a>";
				}else{
					$str.="<a href='$url' class='bg-mode' $target style='height:{$_height};background-image:url($img);'></a>";
				}
				$str.="</div>";
			}
			$str.='</div>';
			$str.="<script type='text/javascript'>\$(document).ready(function(){\$('.bxslider_{$number}').bxSlider({slideWidth:$width, adaptiveHeight:$adaptive_height, mode:'$show_type'});});</script>";
		}
		$str.='</div>';
		return $str;
	}
	
	public static function ad_custom($number, $style=''){	//自定义广告图样式
		global $c;
		$lang=substr($c['lang'], 1);
		$themes=$c['is_mobile_client']==0?$c['themes']:'mobile-'.$c['mobile']['HomeTpl'];
		$web_setting_row=db::get_one('web_settings', "Position='$number' and Themes='$themes'");
		$config=str::json_data($web_setting_row['Config'], 'decode');
		$count=(int)$config[2]?$config[2]:1;	//数量
		$data=str::json_data($web_setting_row['Data'], 'decode');
		$result=array('Count'=>$count);
		for($i=0; $i<$count; $i++){
			$result['Title'][$i]=$data['Title'][$i][$lang];
			$result['Contents'][$i]=$data['Contents'][$i][$lang];
			$result['PicPath'][$i]=$data['PicPath'][$i][$lang];
			$result['Url'][$i]=$data['Url'][$i][$lang];
			$result['Html'][$i]=($result['Url'][$i]!=''?"<a href='' target='_blank'>":'').("<img src='{$result['PicPath'][$i]}' class='$style'>").($result['Url'][$i]!=''?'</a>':'');
		}
		return $result;
	}
	
	public static function get_table_data_to_ary($table, $w, $key, $return_field='', $query_field=''){	//从数据表中获取数据，生成一个以指定字段为下标的数组
		global $c;
		$data=array();
		$row=str::str_code(db::get_all($table, $w, $query_field?$query_field:($return_field?"{$key},{$return_field}":'*')));
		foreach((array)$row as $v){
			$data[$v[$key]]=$return_field?$v[$return_field]:$v;
		}
		return $data;
	}
	
	public static function get_ip(){	//浏览者IP
		if($_SERVER['HTTP_X_FORWARDED_FOR']){
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}elseif($_SERVER['HTTP_CLIENT_IP']){
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		}else{
			$ip=$_SERVER['REMOTE_ADDR'];
		}
		return preg_match('/^[\d]([\d\.]){5,13}[\d]$/', $ip)?$ip:'';
	}
	
	public static function ip($ip){	//IP地址转换为地理地址
		if(!$ip){return;}
		$iploca=new ip;
		@$iploca->init();
		@$iploca->getiplocation($ip);
		$area=array();
		$area['country']=str_replace(array('未知', 'CZ88.NET'), '', $iploca->get('country'));
		$area['area']=str_replace(array('未知', 'CZ88.NET'), '', $iploca->get('area'));
		$area['country']=='' && $area['country']='未知';
		$area['area']=='' && $area['area']='未知';
		return @iconv('GBK', 'UTF-8', implode($area));
	}
	
	public static function e_json($msg='', $ret=0, $exit=1){
		is_bool($ret) && $ret=$ret?1:0;
		echo str::json_data(array(
				'msg'	=>	$msg,
				'ret'	=>	$ret
			)
		);
		$exit && exit;
	}
	
	public static function load_static(){
		global $c;
		$static='';
		$refresh='?v'.$c['ProjectVersion'].'20';//.time();
		$args=func_get_args();
		foreach((array)$args as $v){
			if(is_array($v)){
				$attr=$v[1];
				$v=$v[0];
			}
			$ext_name=file::get_ext_name($v);
			if($ext_name=='css'){
				$static.="<link href='{$v}$refresh' rel='stylesheet' type='text/css' $attr />\r\n";
			}elseif($ext_name=='js'){
				$static.="<script type='text/javascript' src='{$v}$refresh' $attr></script>\r\n";
			}
		}
		return $static;
	}
	
	public static function load_font($font_array){
		global $c;
		$font='';
		foreach((array)$font_array as $v){
			$font.="<link href='/static/font/$v/font.css' rel='stylesheet' type='text/css' />\r\n";
		}
		return $font;
	}
		
	public static function sendmail($to, $subject, $body){	//发送邮件
		global $c;
		$config_row=str::json_data(db::get_value('config', 'GroupId="email" and Variable="config"', 'Value'), 'decode');
		$data=array(
			'Action'	=>	'send_mail',
			'From'		=>	$config_row['FromEmail']?$config_row['FromEmail']:'admin@domain.com',
			'FromName'	=>	$config_row['FromName']?$config_row['FromName']:'noreply',
			'To'		=>	$to,
			'Subject'	=>	$subject,
			'Body'		=>	$body
		);
		if($config_row['SmtpHost'] && $config_row['SmtpPort'] && $config_row['SmtpUserName'] && $config_row['SmtpPassword']){
			$data['SmtpHost']=$config_row['SmtpHost'];
			$data['SmtpPort']=$config_row['SmtpPort'];
			$data['SmtpUserName']=$config_row['SmtpUserName'];
			$data['SmtpPassword']=$config_row['SmtpPassword'];
		}
		return ly200::api($data, $c['ApiKey'], $c['api_url']);
	}

	public static function api($data, $key, $url){	//返回结果如果是数组，则表示成功，非数组，则是错误的提示语
		global $c;
		$data['Domain']=$_SERVER['HTTP_HOST'];
		$data['AgentId']=(int)$c['UeeshopAgentId'];
		$data['QcloudUserId']=(int)$c['UeeshopQcloudUserId'];
		$c['manage']['config']['ManageLanguage'] && $data['lang']=$c['manage']['config']['ManageLanguage'];
		$data['Number']=$c['Number'];
		$data['timestamp']=$c['time'];
		$data['sign']=ly200::sign($data, $key);
		for($i=0;$i<5;$i++){
			$result=ly200::curl($url, $data);
			if($result) break;//返回结果不为空则退出
		}
		if(!$result){
			$return['msg']='connection error';
			return $return;
		}else{
			$json_data=str::json_data($result, 'decode');
			if($json_data['ret']==1){
				return $json_data;
			}else{
				$return['msg']=$json_data['msg']?$json_data['msg']:$result;
				return $return;
			}
		}
	}
	
	public static function sign($data, $key){	//生成签名
		$str='';
		$data=str::str_code($data, 'trim');
		ksort($data);
		foreach((array)$data as $k=>$v){
			if($k=='sign' || $v===''){continue;}
			$str.="$k=$v&";
		}
		return md5($str.'key='.$key);
	}
	
	public static function curl($url, $post='', $referer='', $curl_opt=array(), $return_cookie=false){	//post或get，读取数据
		$options=array(
			CURLOPT_URL				=>	$url,
			CURLOPT_RETURNTRANSFER	=>	true,
			CURLOPT_CONNECTTIMEOUT	=>	60,
			CURLOPT_TIMEOUT			=>	60,
			CURLOPT_POST			=>	$post?true:false,
			CURLOPT_SSL_VERIFYPEER	=>	false,
			CURLOPT_REFERER			=>	$referer
		);
		$post && $options[CURLOPT_POSTFIELDS]=is_array($post)?http_build_query($post):$post;
		$return_cookie && $options[CURLOPT_HEADER]=true;
		foreach((array)$curl_opt as $k=>$v){	//测试过不能直接用array_merge方式，未知原因
			$v=addslashes($v);
			@eval("\$options[$k]='$v';");
		}
		$ch=curl_init();
		curl_setopt_array($ch, $options);
		$result=curl_exec($ch);
		if($return_cookie){
			$ch_info=curl_getinfo($ch);
			$header_size=$ch_info['header_size'];
			$raw_header=substr($result, 0, $ch_info['header_size']);
			$cookies=array();
			if(preg_match_all('/Set-Cookie:(?:\s*)([^=]*?)=([^\;]*?);/i', $raw_header, $cookie_match)){
				for($i=0; $i<count($cookie_match[0]); $i++){
					$cookies[$cookie_match[1][$i]]=$cookie_match[2][$i];
				}
			}
			curl_close($ch);
			return array(substr($result, -$ch_info['download_content_length']), $cookies);
		}
		curl_close($ch);
		return $result;
	}
}
?>