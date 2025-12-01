<?php
class ary{
	public static function ary_remove_password($data){	//删除密码
		foreach($data as $k=>$v){
			if(substr_count(strtolower($k), 'password')){
				$data[$k]='removed';
			}elseif(is_array($v)){
				$data[$k]=ary::ary_remove_password($v);
			}
		}
		return $data;
	}
	
	public static function ary_filter_empty($data){	//删除数组中的空值
		if(!is_array($data)){return $data;}
		foreach($data as $k=>$v){
			is_array($v) && $data[$k]=ary::ary_filter_empty($v);
		}
		return array_filter($data, function($v){
			return !is_array($v)?(($v!='' || $v===0)?true:false):(count($v)?true:false);
		});
	}
	
	public static function ary_format($data, $return=0, $unset='', $explode_char=',', $implode_char=','){	//$return，0：字符串，1：数组，2：in查询语句，3：or查询语句，4：返回第一个值
		!is_array($data) && $data=explode($explode_char, $data);
		foreach($data as $k=>$v){
			$data[$k]=trim($v);
		}
		$data=array_filter($data, function($v){
			return !is_array($v)?(($v!='' || $v===0)?true:false):(count($v)?true:false);
		});
		if($unset){
			$unset=ary::ary_format($unset, 1, '', $explode_char, $implode_char);
			foreach($data as $k=>$v){
				if(in_array($v, $unset)){
					unset($data[$k]);
				}
			}
		}
		if($return==0){	
			return $data?($implode_char.implode($implode_char, $data).$implode_char):'';
		}elseif($return==1){
			return $data;
		}elseif($return==2 || $return==3){
			if(!$data){return '"0"';}
			if($return==2){
				$is_numeric=true;
				foreach($data as $v){
					if(!is_numeric($v)){
						$is_numeric=false;
						break;
					}
				}
				return ($is_numeric?'':"'").implode($is_numeric?',':"','", $data).($is_numeric?'':"'");
			}else{
				return implode(' or ', $data);
			}
		}elseif($return==4){
			return array_shift($data);
		}
	}
	
	public static function ary_key_rand($data, $num=1){
		return (!$num || !is_array($data) || !count($data))?array():@(array)array_rand($data, ($num<=count($data)?$num:count($data)));
	}
}
?>