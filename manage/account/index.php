<?php !isset($c) && exit();?>
<?php
$days_ary=array(0, -1, -7, -30);
echo ly200::load_static('/static/js/plugin/highcharts/highcharts.js', '/static/js/plugin/highcharts/highcharts-zh_CN.js');
?>
<div id="account" class="r_con_wrap">
	<?php 
		$guide_row=db::get_all('config', 'GroupId="guide_pages"');
		$guide_status=0;
		$guide_ary=array();
		foreach((array)$guide_row as $v){
			$guide_ary[$v['Variable']]=(int)$v['Value'];
			if((int)$v['Value']) continue;
			$guide_status++;
		}
		if($guide_status && !substr_count($_SERVER['HTTP_HOST'], '.myueeshop.com') && !(int)$_GET['isdata']){
			if($_SESSION['Manage']['welfare']){
				$result=$_SESSION['Manage']['welfare'];
				
			}else{
				$data=array(
					'Action'	=>	'ueeshop_kuihuadao_get_course_list',
				);
				$result=ly200::api($data, $c['ApiKey'], $c['api_url']);
				$_SESSION['Manage']['welfare']=$result;
				$data=array('Action'=>'ueeshop_web_get_data');
				$analytics_row=ly200::api($data, $c['ApiKey'], $c['api_url']);
				if($analytics_row['Service']['QQ'] && $analytics_row['Service']['Contacts']){
					$_SESSION['Manage']['Service']=1;
				}
			}
			if($result['ret']){
				$category_ary=$result['msg'][0];
				$video_ary=$result['msg'][1];
				$permission_ary=str::json_data($result['msg'][2], 'decode');
			}
		?>
		<script>$(document).ready(function(){account_obj.welfare_init();});</script>
		<div id="guide_pages">
			<div class="open_store">
				<div class="top_title">{/account.open_store/}</div>
				<?php if(!$guide_ary['themes']){ ?>
				<div class="list">
					<a href="./?m=set&a=themes&d=themes">{/account.go_set/}</a>
					<img src="/static/manage/images/account/guide_img_themes.png" alt="">
					<span class="title">{/account.set_themes/}</span>
				</div>
				<?php } ?>
				<?php if(!$guide_ary['products']){ ?>
				<div class="list">
					<a href="./?m=products&a=products">{/account.add_now/}</a>
					<img src="/static/manage/images/account/guide_img_products.png" alt="">
					<span class="title">{/account.add_pro/}</span>
				</div>
				<?php } ?>
				<div class="clear"></div>
			</div>
			<div class="open_store suggest">
				<div class="top_title">{/account.suggest/}</div>
				<div class="list">
					<a href="./?isdata=1">{/account.enter/}</a>
					<img src="/static/manage/images/account/guide_sug_data.png" alt="">
					<div class="info">
						<div class="tit">{/account.analysis/}</div>
						<div class="desc">{/account.analysis_desc/}</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="course">
				<div class="video_box">
					<a href="javascript:;" class="cloce"></a>
					<div id="video_play"></div>	
				</div>
				<div class="top_title">{/account.course/}</div>
				<div class="box video_list">
					<?php 
						$i=0;
						foreach((array)$video_ary as $v){ 
						if(!in_array($v['CourseId'], $permission_ary)) continue;
						?>
						<div class="list <?=$i%2==0 ? 'fl' : 'fr'; ?>" data-ccid="<?=$v['CCId']; ?>" title="<?=$v['Name']; ?>">
							<div class="img">
								<img src="<?=$v['Photo']; ?>" alt="">
							</div>
							<div class="info">
								<div class="tit"><?=$v['Name']; ?></div>
								<div class="desc"><?=nl2br($v['LearnPoint']); ?></div>				
							</div>
							<div class="clear"></div>
						</div>
					<?php $i++; } ?>
					<div class="clear"></div>
				</div>
			</div>
			<a href="./?m=account&a=welfare" class="more_video">{/account.view_more/}</a>
			<div class="no_play_tips">
				<table class="tips">
					<tr><td>
						<?php if(substr_count($_SERVER['HTTP_HOST'], '.myueeshop.com')){ ?>
							“请联系Ueeshop建站顾问”<br />
							索取观看权限
						<?php }else{ ?>
							友情提醒：进阶课程需先完善网站资料，<br>
							我们的客服专员<?php if($_SESSION['Manage']['Service']){ ?>（QQ：800031052）<?php } ?>会为您网站检查后开启课程
						<?php } ?>
					</td></tr>
				</table>
			</div>
		</div>
		<script>
		function get_cc_verification_code(vid){
			return '<?=str::str_crypt(str::rand_code()."|ueeshop|UEESHOP|".str::rand_code());?>';
		}
		</script>
	<?php }else{ ?>
		<script type="text/javascript">$(document).ready(function(){account_obj.index_init()});</script>
		<div class="home_container clean">
	        <dl class="home_choice_day">
	            <dt><strong>{/account.index.day_ary.0/}</strong><em><i></i></em></dt>
	            <dd class="drop_down">
	                <?php
	                foreach($days_ary as $k=>$v){
	                ?>
	                    <a href="javascript:;" data-rel="<?=$v;?>"<?=$v==0?' class="current"':'';?>>{/account.index.day_ary.<?=$k;?>/}</a>
	                <?php }?>
	            </dd>
	        </dl>
	        <div class="clear"></div>

	        <div class="home_parent_box home_parent_top_box mb20">
				<!-- 流量 Start -->
				<div class="global_container home_big_data home_visits mr10">
					<div class="title">{/account.index.traffic/}</div>
					<div class="content">
						<table border="0" cellpadding="0" cellspacing="0" class="table_data fl">
							<thead>
								<tr>
									<td width="31%" nowrap></td>
									<td width="40%" nowrap>{/account.index.pv/}</td>
									<td width="29%" nowrap>{/account.index.uv/}</td>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
						<div class="chart_data fl ml20" id="visits_charts"></div>
					</div>
				</div>
				<!-- 流量 End -->
			</div>

	        <div class="home_parent_box home_parent_top_box mb20">
				<div class="clean">
					<div class="home_parent_box">
						<!-- 流量来源 Start -->
						<div class="global_container home_visits_referrer ml10 mr10">
							<div class="title">{/account.index.traffic_source/}</div>
							<div class="content">
								<div id="referrer_charts"></div>
							</div>
						</div>
						<!-- 流量来源 End -->
					</div>
					<div class="home_parent_box">
						<!-- 来源网址 Start -->
						<div class="global_container home_referrer_url">
							<div class="title">{/account.index.source_url/}</div>
							<div class="content">
								<table border="0" cellpadding="0" cellspacing="0" class="table_report_list">
									<tbody></tbody>
								</table>
								<div class="no_data">{/error.no_data/}</div>
							</div>
						</div>
						<!-- 来源网址 End -->
					</div>
				</div>
			</div>

	        <div class="clear"></div>

			<!-- 最新询盘 Start -->
			<div class="home_parent_box home_parent_top_box mb20">
				<div class="global_container new_inquiry mr10">
					<div class="title">
						{/account.index.new_inquiry/}
						<a class="fr" href="./?m=inquiry&a=inquiry">{/global.more/}</a>
					</div>
					<div class="content">
						<table border="0" cellpadding="0" cellspacing="0" class="table_report_list">
							<thead>
								<tr>
									<td width="40" nowrap></td>
									<td width="20%" nowrap>{/global.email/}</td>
									<td width="20%" nowrap>{/account.index.inquiry_type/}</td>
									<td width="30%" nowrap>{/global.title/}</td>
									<td width="150" nowrap>{/global.time/}</td>
									<td width="25" nowrap></td>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
						<div class="no_data">{/error.no_data/}</div>
					</div>
				</div>
			</div>
			<!-- 最新询盘 End -->

	        <div class="home_parent_box home_parent_top_box mb20">
	           <div class="clean">
				   <div class="home_parent_box">
						<!-- 访问分布、搜索排行 Start -->
						<div class="global_container <?=$c['FunVersion']>1?'home_search':'home_sources_country';?> ml10 mr10">
							<div class="title">
								{/account.index.<?=$c['FunVersion']>1?'keyword_ranking':'views_source';?>/}
								<a class="fr" href="./?<?=$c['FunVersion']>1?'m=seo&a=keyword_track':'m=mta&a=country';?>">{/global.more/}</a>
							</div>
							<div class="content">
								<table border="0" cellpadding="0" cellspacing="0" class="table_report_list">
									<tbody></tbody>
								</table>
								<div class="no_data">{/error.no_data/}</div>
							</div>
						</div>
						<!-- 访问分布、搜索排行 End -->
					</div>
					<div class="home_parent_box">
						<!-- 访问终端 Start -->
						<div class="global_container home_terminal">
							<div class="title">{/account.index.views_device/}</div>
							<div class="content">
								<ul class="terminal_list">
									<li><p>{/mta.terminal_ary.1/}</p><strong>0%</strong></li>
									<li><p>{/mta.terminal_ary.2/}</p><strong>0%</strong></li>
								</ul>
							</div>
						</div>
						<!-- 访问终端 End -->
					</div>
				</div>
	        </div>

	    </div>
    <?php } ?>
</div>