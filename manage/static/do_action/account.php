<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

class account_module{
	/*********************************************************************************************************************************************************/
	public static function login(){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		
		$data=array(
			'Action'	=>	'ueeshop_web_manage_login',
			'UserName'	=>	$p_UserName,
			'Password'	=>	str::password(trim($p_Password)),
			'Ip'		=>	ly200::get_ip()
		);
		$result=ly200::api($data, $c['ApiKey'], $c['api_url']);

		if($result['ret']==1 && $result['msg'] && count($result['msg'])){
			$userinfo=$result['msg'];
			if($userinfo['Locked']==1){	//账号被锁定
				ly200::e_json(manage::language('{/account.locking/}'));
			}else{
				$_SESSION['Manage']=@is_array($_SESSION['Manage'])?@array_merge($_SESSION['Manage'], $userinfo):$userinfo;
				$_SESSION['Manage']['PromptSteps']=1;//提示步骤，防止刷新后立即执行
				//---------------------------------非超级管理员加载权限(Start)--------------------------------------
				if($userinfo['GroupId']!=1){
					$_SESSION['Manage']['Permit']=str::json_data(db::get_value('manage_permit', "UserName='{$userinfo['UserName']}'", 'Permit'), 'decode');
				}
				//---------------------------------非超级管理员加载权限(End)--------------------------------------
				manage::operation_log("管理员登录【{$p_UserName}】");
				$cache_time=(int)db::get_value('config', 'GroupId="tmp" and Variable="CacheTime"', 'Value');
				$set_cache=$c['time']-$cache_time-$c['manage']['cache_timeout'];
				if($set_cache>0){//超出缓存保存期限
					file::del_dir($c['tmp_dir'].'manage/');//清空后台数据统计
					file::del_dir($c['tmp_dir'].'photo/');//清空图片临时文件夹
					manage::config_operaction(array('CacheTime'=>$c['time']), 'tmp');
				}
				ly200::e_json('', 1);
			}
		}else{
			ly200::e_json(manage::language('{/account.error/}'));
		}
	}

	public static function logout(){
		global $c;
		$log="退出登录【{$_SESSION['Manage']['UserName']}】";
		$c['manage']=$_SESSION['Manage']='';
		unset($c['manage'], $_SESSION['Manage']);
		manage::operation_log($log);
		js::location('./');
	}
	/*********************************************************************************************************************************************************/

	public static function video_play(){
		global $c;
		@extract($_GET, EXTR_PREFIX_ALL, 'p');
		if($p_ccid){
			$data=array(
				'Action'	=>	'ueeshop_kuihuadao_get_play_code',
				'CCId'		=>	$p_ccid,
			);
			$result=ly200::api($data, $c['ApiKey'], $c['api_url']);
			ly200::e_json($result['msg'], 1);
		}else{
			echo 0;
		}
	}

	public static function get_account_data(){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');

		$p_TimeS=$p_TimeS!=''?$p_TimeS:0;
		$days_ary=array(0, -1, -7, -30);

		if(!file::check_cache($c['root_path']."tmp/manage/get_account_data{$p_TimeS}.json", 0)){
			ob_start();
			$time_s=where::time($p_TimeS, '', !in_array($p_TimeS, array(0,-1)));
			$data=array(
				'inquiry'		=>	array(),
				'device_percent'=>	array(),
				'visits'		=>	array(),
				'visits_country'=>	array(),
				'referrer'		=>	array(),
				'keyword_rank'	=>	array(),
				'time_s'		=>	date('Y-m-d', $time_s[0]).date('/Y-m-d', $time_s[1]),
				'time_e'		=>	''
			);

			//最新询盘
			$data['inquiry']=array();
			$sql='select * from (
					(select FId as Id,Email,Subject,AccTime,"0" as Type from feedback order by FId desc limit 0,6) union all
					(select IId as Id,Email,Subject,AccTime,"1" as Type from products_inquiry order by IId desc limit 0,6) union all
					(select RId as Id,Email,Subject,AccTime,"2" as Type from products_review order by RId desc limit 0,6)
			) i order by i.AccTime desc limit 0, 6';
			$rs=db::query($sql);
			$url=array(
				'./?m=inquiry&a=feedback&d=edit&FId=',
				'./?m=inquiry&a=inquiry&d=edit&IId=',
				'./?m=inquiry&a=review&d=edit&RId='
			);
			while($row=@mysql_fetch_assoc($rs)){
				$data['inquiry'][]=array(
					'new'		=>	!$row['IsRead']?'<span>NEW</span>':'',
					'email'		=>	$row['Email'],
					'type'		=>	manage::language("{/account.index.inquiry_type_ary.{$row['Type']}/}"),
					'subject'	=>	$row['Subject'],
					'time'		=>	date('Y/m/d H:i:s', $row['AccTime']),
					'url'		=>	$url[$row['Type']].$row['Id']
				);
			}

			//流量
			foreach($days_ary as $k=>$v){
				$visits=ly200::api(array('Action'=>'ueeshop_analytics_get_visits_data', 'TimeS'=>$v, 'Terminal'=>0), $c['ApiKey'], $c['api_url']);
				$data['visits'][$k]=array(
					'key'	=>	$days_ary[$k],
					'title'	=>	manage::language("{/account.index.day_ary.$k/}"),
					'pv'	=>	(int)$visits['msg']['total']['pv'],
					'uv'	=>	(int)$visits['msg']['total']['uv']
				);
			}

			//流量统计
			$data['visits_charts']['colors'][0]='#4489ff';
			$data['visits_charts']['series'][0]=array(
				'name'		=>	'Pv',
				'pointWidth'=>	15
			);
			$visits=ly200::api(array('Action'=>'ueeshop_analytics_get_analytics_month_data', 'Terminal'=>0), $c['ApiKey'], $c['api_url']);
			$j=0;
			if(is_array($visits['msg'])){
				for($i=count($visits['msg'])-1; $i>=0; --$i){
					$visits_ary[$j]=$visits['msg'][$i];
					++$j;
				}
				foreach((array)$visits_ary as $k=>$v){
					$month=@date('m', $v['AccTime']);
					$data['visits_charts']['series'][0]['data'][]=$v['PcPv']+$v['MobilePv'];
					$data['visits_charts']['xAxis']['categories'][]=($c['manage']['config']['ManageLanguage']=='en'?@date('F', $v['AccTime']):@sprintf(manage::language('{/account.index.account_month/}'), $month));

				}
			}

			//流量来源  访问分布  来源网址
			$share_ary=$referrer_ary=array();
			$visits_referrer=ly200::api(array('Action'=>'ueeshop_analytics_get_visits_referrer_data', 'TimeS'=>$p_TimeS, 'Terminal'=>0), $c['ApiKey'], $c['api_url']);
			if($visits_referrer['msg']){
				foreach((array)$visits_referrer['msg']['detail']['search_engine'] as $k=>$v){
					$referrer_ary['uv'][$v['title']]+=$v['uv'];
				}
				foreach((array)$referrer_ary['uv'] as $k=>$v){
					$referrer_ary['total'][$k]=($uv?sprintf('%01.1f', ($v/$uv)*100).'%':0);
				}
			}
			$data['referrer']=$referrer_ary;//来源网址

			//访问分布
			$visits_country=ly200::api(array('Action'=>'ueeshop_analytics_get_visits_country_data', 'TimeS'=>$p_TimeS, 'Terminal'=>0), $c['ApiKey'], $c['api_url']);
			$country_total = 0;
			if($visits_country['msg']){
				foreach((array)$visits_country['msg']['detail'] as $k=>$v){
					$data['visits_country']['list'][] = array($v['title'],$v['pv']);
					$country_total+=$v['pv'];
				}
				$data['visits_country']['total']=$country_total;
			}

			//流量来源
			$data['referrer_charts']['title']['floating']=true;
			$data['referrer_charts']['chart']['spacingTop']=0;
			$data['referrer_charts']['chart']['spacingBottom']=30;
			$data['referrer_charts']['colors']=array('#4388ff', '#ff870f', '#fcdb50', '#24d39a');
			$data['referrer_charts']['series'][0]['type']='pie';
			$data['referrer_charts']['series'][0]['innerSize']='80%';
			$data['referrer_charts']['series'][0]['name']='Pv';
			$visits_referrer_ary=array();
			$total=0;
			foreach($visits_referrer['msg']['total'] as $k=>$v){
				$visits_referrer_ary[]=$v['pv'];
				$total+=$v['pv'];
			}
			$max=max($visits_referrer_ary);
			$is_max=0;
			foreach($visits_referrer['msg']['total'] as $k=>$v){
				$percent=(float)($total?sprintf('%01.1f', ($v['pv']/$total)*100):'0');
				$ary=array('name'=>$v['title'], 'y'=>$percent);
				if($is_max==0 && $max==$v['pv']){
					$ary['sliced']=true;
					$ary['selected']=true;
					$is_max=1;
					$data['referrer_charts']['title']['text']="{$v['title']} {$percent}%";
				}
				$data['referrer_charts']['series'][0]['data'][]=$ary;
				++$i;
			}

			//前十关键词
			$search_rank = manage::ueeseo_get_data('ueeshop_ueeseo_get_keyword_track');
			$search_total = 0;
			foreach((array)$search_rank['msg'] as $k=>$v){
				foreach((array)$v[0] as $k1=>$v1){
					if(!$k1) continue;
					$search_total += ($v1==-1?0:$v1);
				}
			}
			foreach($search_rank['msg'] as $k=>$v){
				$this_search_total = 0;
				foreach((array)$v[0] as $k1=>$v1){
					if(!$k1) continue;
					$this_search_total += ($v1==-1?0:$v1);
				}
				$data['keyword_rank'][] = array(
					'name'=>$k,
					'percent'=>$search_total?round($this_search_total/$search_total*100,2)."%":0,
					'nums'=>$this_search_total,
				);
			}

			//访问终端
			$terminal=ly200::api(array('Action'=>'ueeshop_analytics_get_visits_data', 'TimeS'=>$p_TimeS, 'Terminal'=>0), $c['ApiKey'], $c['api_url']);
			$terminal_total = array();
			$t_total_nums = 0;
			foreach((array)$terminal['msg']['browser_all_charts'] as $k=>$v){
				foreach((array)$v as $k2=>$v2){
					$terminal_total[$k] += $v2;
				}
			}
			$t_total_nums = $terminal_total[0] + $terminal_total[1];
			$data['device_percent']['pc'] = @round($terminal_total[0]/$t_total_nums*100,2)."%";
			$data['device_percent']['mobile'] = @round($terminal_total[1]/$t_total_nums*100,2)."%";
			echo str::json_data($data);
			$cache_contents=ob_get_contents();
			ob_end_clean();
			file::write_file('tmp/manage/', "get_account_data{$p_TimeS}.json", $cache_contents);
		}
		//加载统计json
		$data_object=@file_get_contents($c['root_path']."tmp/manage/get_account_data{$p_TimeS}.json");
		$data=str::json_data($data_object, 'decode');

		ly200::e_json($data, 1);
	}
}
?>