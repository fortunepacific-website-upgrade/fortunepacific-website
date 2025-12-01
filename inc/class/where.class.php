<?php
/*
Powered by ueeshop.com		http://www.ueeshop.com
广州联雅网络科技有限公司		020-83226791
*/

class where{
	public static function equal($data){
		$w='';
		foreach($data as $k=>$v){
			if((!is_array($v) && $v!='') || (is_array($v) && $v[0]!='')){
				is_array($v) && $v=$v[0];
				$w.=" and $k='$v'";
			}
		}
		if($w){return $w;}
	}
	
	public static function keyword($keyword, $field){
		if(!$keyword){return;};
		$w=array();
		foreach($field as $v){
			if(is_array($v)){
				$w[]="{$v[0]} like '%,$keyword,%'";
			}else{
				$w[]="$v like '%$keyword%'";
			}
		}
		$w=ary::ary_format($w, 3);
		return " and ($w)";
	}
	
	public static function time($time, $field='', $is_range=0){	//时间范围
		global $c;
		substr($time, 0, 1)!='-' && $time=str_replace('-', '', $time);
		$ts=$te=0;
		if(substr_count($time, '/')){
			$t=@explode('/', $time);
			$ts=@strtotime($t[0]);
			$te=@strtotime($t[1])+86399;
			$t[0]==$t[1] && $time=$t[0];
		}elseif(is_numeric($time)){
			$time=(int)$time;
			if($time<=0){
				$ts=@strtotime(date('Y-m-d', strtotime("$time days")));
				$te=$is_range?$c['time']:$ts+86399;
			}elseif(strlen($time)==4){
				$ts=@strtotime($time.'0101');
				$te=@strtotime($time.'1231')+86399;
			}elseif(strlen($time)==6){
				$ts=@strtotime($time.'01');
				$te=@strtotime(date('Y-m-'.date('t', $ts), $ts))+86399;
			}elseif(strlen($time)==8){
				$ts=@strtotime($time);
				$te=$ts+86399;
			}
		}
		if($ts && $te){return $field!=''?" and $field between $ts and $te":array($ts, $te, $time);}
	}
}
?>