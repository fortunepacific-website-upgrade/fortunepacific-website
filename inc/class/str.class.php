<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

class str{
	public static function str_code($data, $fun='htmlspecialchars', $params=array(), $data_is_first=1){	//文本编码
		if(!is_array($data)){return call_user_func_array($fun, $data_is_first?array_merge(array($data), $params):array_merge($params, array($data)));}
		$new_data=array();
		foreach((array)$data as $k=>$v){
			$new_data[$k]=is_array($v)?str::str_code($v, $fun, $params, $data_is_first):call_user_func_array($fun, $data_is_first?array_merge(array($v), $params):array_merge($params, array($v)));
		}
		return $new_data;
	}
	
	public static function str_cut($data, $length=30){
		if(!is_array($data)){return mb_substr(html_entity_decode($data), 0, $length,'utf-8').(mb_strlen($data)>$length?'...':'');}
		$new_data=array();
		foreach((array)$data as $k=>$v){
			$new_data[$k]=is_array($v)?str::str_cut($v, $length):(mb_substr(html_entity_decode($v), 0, $length).(mb_strlen($v)>$length?'...':''));
		}
		return $new_data;
	}
	
	public static function str_color($str='', $key=0, $return_type=0){
		$key>15 && $key=$key%15;
		return $return_type==0?"<font class='fc_$key'>$str</font>":"fc_$key";
	}
	
	public static function str_format($str){	//格式化文本
		$str=htmlspecialchars(htmlspecialchars_decode($str));
		$str=str_replace('  ', '&nbsp; ', $str);
		$str=nl2br($str);
		return $str;
	}

	public static function str_to_url($str){	//字符串转换成合法的url路径
		$url=strtolower(trim($str));
		$url=str_replace(array(' ', '/'), '-', $url);
		$url=str_replace(array('`','~','!','@','#','$','%','^','&','*','(',')','_','=','+','[','{',']','}',';',':','\'','"','\\','|','<',',','.','>','?',"\r","\n","\t"), '', $url);
		$url=preg_replace('/[^\x00-\x7F]+/', '', $url);	//去掉中文
		$url=preg_replace('/-{2,}/', '-', $url);
		!@eregi('^[a-z0-9]', $url) && $url='';
		return $url;
	}
	
	public static function password($password){	//密码加密
		$password=md5($password);
		$password=substr($password, 0, 5).substr($password, 10, 20).substr($password, -5).'www.ly200.com';
		return md5($password.$password);
	}
	
	public static function query_string($un=''){	//组织url参数	'a', 'b'
		!is_array($un) && $un=explode(',', str_replace(' ','',$un));//$un=array($un);
		if($_SERVER['QUERY_STRING']){
			$q=@explode('&', $_SERVER['QUERY_STRING']);
			$v='';
			for($i=0; $i<count($q); $i++){
				$t=@explode('=', $q[$i]);
				if(in_array($t[0], $un)){continue;}
				$v.=$t[0].'='.$t[1].'&';
			}
			$v=substr($v, 0, -1);
			$v=='=' && $v='';
			return $v;
		}else{
			return '';
		}
	}
	
	public static function rand_code($length=10){	//随机命名
		global $c;
		return substr(md5($c['time']+mt_rand(100000, 999999)), mt_rand(0, 32-$length), $length);	
	}
	
	public static function json_data($data, $action='encode'){	//json数据编码
		if($action=='encode'){
			if(!function_exists('unidecode')){
				function unidecode($match){
					return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
				}
			}
			return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'unidecode', json_encode($data));
		}else{
			return (array)json_decode($data, true);
		}
	}
	
	public static function clear_html($content) {//手机版清除格式
		$content=preg_replace("/<!--[^>]*-->/i", '', $content);//注释内容  
		$content=preg_replace("/style=.+?['|\"]/i",'',$content);//去除样式       
		$content=preg_replace("/lang=.+?['|\"]/i",'',$content);//去除样式      
		$content=preg_replace("/width=.+?['|\"]/i",'',$content);//去除样式   
		$content=preg_replace("/height=.+?['|\"]/i",'',$content);//去除样式   
		$content=preg_replace("/face=.+?['|\"]/i",'',$content);//去除样式
		$content=preg_replace("/&nbsp;/i", ' ', $content);
		return $content;
	}

	public static function str_crypt($str, $action='encrypt', $key='www-ly200-com'){//字符串加密
		if(!$str){return;}
		$action!='encrypt' && $str=base64_decode($str);
		$keylen=strlen($key);
		$strlen=strlen($str);
		$new_str='';
		for($i=0; $i<$strlen; $i++){
			$k=$i%$keylen;
			$new_str.=$str[$i]^$key[$k];
		}
		return $action!='decrypt'?base64_encode($new_str):$new_str;
	}
}
?>