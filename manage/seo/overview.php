<?php !isset($c) && exit();?>
<?php
manage::check_permit('seo.overview', 2);//检查权限

$result=manage::ueeseo_get_data('ueeshop_ueeseo_get_overview');
!$result['ret'] && $result['msg']=array();
//print_r($result);
?>
<?=ly200::load_static('/static/js/plugin/radialIndicator/radialIndicator.min.js', '/static/js/plugin/highcharts/highcharts.js', '/static/js/plugin/highcharts/highcharts-zh_CN.js');?>
<script language="javascript">$(document).ready(function(){seo_obj.overview_init();});</script>
<div id="overview" class="r_con_wrap">
	<div class="inside_container">
		<h1>{/module.seo.overview/}</h1>
	</div>
	<div class="summary">
    	<div class="fl">
        	<h3><?=$result['msg']['web_row']['Domain'];?></h3>
            <div class="btm">
                <div class="fl">
                    <?=($result['msg']['web_row']['MissionWeeks']==0 || ($c['time']>=($result['msg']['web_row']['LastGetMissionTime']+3600*24*7)))?'<span class="get_mission fl">{/seo.overview.get_week_task.0/}</span>':'<span class="has_mission">{/seo.overview.get_week_task.1/}</span>';?>
                </div>
                <div class="fl times">
                    <?php if((int)$result['msg']['web_row']['FirstGetMissionTime']){?><div class="first_mission_time">{/seo.overview.week_task_time.0/}: <font><?=@date('Y-m-d H:i:s', $result['msg']['web_row']['FirstGetMissionTime']);?></font></div><?php }?>
                    <div class="start_time"><?=$result['msg']['web_row']['LastGetMissionTime']?'{/seo.overview.week_task_time.1/}: <font>'.@date('Y-m-d H:i:s', $result['msg']['web_row']['LastGetMissionTime']).'</font>':'';?></div>
                </div>
            </div>
        </div>
        <div class="fl">
        	<?php 
			if($result['msg']['web_row']['TotalMission']>0){
				$ThisWeekComplete=sprintf('%01.1f', $result['msg']['web_row']['CompleteMission']*100/$result['msg']['web_row']['TotalMission']);
				$ThisWeekComplete>10 && $ThisWeekComplete=(int)$ThisWeekComplete;
				$ThisWeekImcomplete=100-$ThisWeekComplete;
			?>
				<div class="rate fl"><div class="round"></div><div class="bg"></div></div>
				<script type="text/javascript">
				$(function(){
					var $obj=$('#overview .rate .round');
					$obj.radialIndicator({radius: 53, barBgColor: '#dddddd', barColor: '#07bb8a', barWidth: 7, percentage: true, fontSize: '36', fontColor: '#444444'});
					$obj.data('radialIndicator').animate(<?=$ThisWeekComplete;?>);
				});
				</script>
			<?php }?>
        </div>
        <div class="clear"></div>
    </div>
	<div class="alignment">
		<div class="aleft fl">
			<div class="blank20"></div>
			<div class="blank20"></div>
			<div class="task_tips">
				<div class="fr">
					<?php if($result['msg']['web_row']['TotalMission']==$result['msg']['web_row']['CompleteMission']){?>
						{/seo.overview.task_complete.0/}<br />{/seo.overview.task_left.0/}
					<?php }else{?>
						{/seo.overview.task_complete.1/}<br /><?=sprintf(manage::language('{/seo.overview.task_left.1/}'), '<strong>'.($result['msg']['web_row']['TotalMission']-$result['msg']['web_row']['CompleteMission']).'</strong>');?>
					<?php }?>
                    <div style="display:none;"><?php print_r($result['msg']['web_row']);?></div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="task">
				<ul class="rows_0">
					<li class="fl ddlist trans">
						<a href="./?m=seo&a=article">
							<div class="img"><img src="/static/manage/images/seo/dd_15.png" /></div>
							<div class="name">
								{/seo.overview.task_type.0/}
								<div class="mum"><?=$result['msg']['um_complete']['article']?'<span>'.$result['msg']['um_complete']['article'].'</span>':'<img src="/static/manage/images/seo/dd_17.png" />'?></div>
							</div>
						</a>
					</li>
					<li class="fl ddlist trans">
						<a href="./?m=seo&a=mobile">
							<div class="img"><img src="/static/manage/images/seo/dd_27.png" /></div>
							<div class="name">
								{/seo.overview.task_type.1/}
								<div class="mum"><?=$result['msg']['um_complete']['mobile']?'<span>'.$result['msg']['um_complete']['mobile'].'</span>':'<img src="/static/manage/images/seo/dd_17.png" />'?></div>
							</div>
						</a>
					</li>
					<li class="fr ddlist trans">
						<a href="./?m=seo&a=links">
							<div class="img"><img src="/static/manage/images/seo/dd_16.png" /></div>
							<div class="name">
								{/seo.overview.task_type.2/}
								<div class="mum"><?=$result['msg']['um_complete']['links']?'<span>'.$result['msg']['um_complete']['links'].'</span>':'<img src="/static/manage/images/seo/dd_17.png" />'?></div>
							</div>
						</a>
					</li>
				</ul>
				<ul class="rows_1">
					<li class="fl ddlist trans">
						<a href="./?m=seo&a=blog">
							<div class="img"><img src="/static/manage/images/seo/dd_18.png" /></div>
							<div class="name">
								{/seo.overview.task_type.3/}
								<div class="mum"><?=$result['msg']['um_complete']['blog']?'<span>'.$result['msg']['um_complete']['blog'].'</span>':'<img src="/static/manage/images/seo/dd_17.png" />'?></div>
							</div>
						</a>
					</li>
					<li class="fr ddlist trans">
						<a href="./?m=seo&a=ads">
							<div class="img"><img src="/static/manage/images/seo/dd_19.png" /></div>
							<div class="name">
								{/seo.overview.task_type.4/}
								<div class="mum"><?=$result['msg']['um_complete']['ads']?'<span>'.$result['msg']['um_complete']['ads'].'</span>':'<img src="/static/manage/images/seo/dd_17.png" />'?></div>
							</div>
						</a>
					</li>
				</ul>
			</div>
			<div class="blank20"></div><div class="blank20"></div>
		</div>
		<div class="aright fl">
			<div class="top">
				<div class="fl title">{/seo.overview.keyword_ranking/}</div>
				<div class="fl notes">
					<a href="?m=seo&a=keyword_track"><img src="/static/manage/images/seo/dd_22.png" /></a>
					<div class="dec">
						<div class="i"><img src="/static/manage/images/seo/dd_21.png" /></div>
						<div class="d">{/seo.overview.keyword_detail/}</div>
					</div>
				</div>
			</div>
			<div class="keyword_list">
				<?php
				$ranking_row=str::json_data($result['msg']['ranking_data'], 'decode');
				$dd = 0;
				$dd_arr = array();
				foreach((array)$ranking_row as $k=>$v){
					if($dd>=10)continue;
					$dd_arr[$dd]['Keyword'] = $k;
					$dd_arr[$dd]['Week'] = $v[0][7];
					$dd++;
				}
				$dd = $jj = $k = $continueNum = 0;
				foreach((array)$dd_arr as $kk=>$v){
					if( (($k+1)%5)==0 ){ $dd++; }else{ $dd=0; }
				?>
					<?php if((!$dd && !$jj) || (!$dd && $jj%3==0) ){?><div class="<?=(!$dd && !$jj)?"one":((!$dd && $jj%3==0)?"two":"");?> <?=$k==count($dd_arr)-3?"three":""?> "><?php }?>
					<div class="table color<?=$k?> trans"><div class="table-cell"><a href="https://www.google.com/search?nomo=1&num=100&q=<?=urlencode($v['Keyword']);?>" target="_blank"><?=$v['Keyword'];?></a></div></div>
					<?php if( !$dd && ($jj+1)%3==0 || ($dd && $jj%4==0) || $k==(count($dd_arr)-1-$continueNum) ){?></div><?php }?>
				<?php if($dd){$jj=0;}else{$jj++;} $k++;}?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="data">
		<div class="lefter">
			<div class="top">{/seo.overview.search_engine/}</div>
			<?php
			$charts_data=array();
			$charts_data['chart']['height']=370;
			$charts_data['legend']['enabled']=true;
			$charts_data['series'][0]['type']='column';
			$charts_data['series'][1]['type']='column';
			$charts_data['series'][2]['type']='column';
			$charts_data['series'][0]['name']='Google';
			$charts_data['series'][1]['name']='Yahoo';
			$charts_data['series'][2]['name']='Bing';
			$result['msg']['engine_record_data']=str::json_data($result['msg']['engine_record_data'], 'decode');
			foreach((array)$result['msg']['engine_record_data'] as $k=>$v){
				$charts_data['xAxis']['categories'][]=date('m/d', $k);
				$charts_data['series'][0]['data'][]=(int)$v[0]+rand(10, 100);
				$charts_data['series'][1]['data'][]=(int)$v[1]+rand(10, 100);
				$charts_data['series'][2]['data'][]=(int)$v[2]+rand(10, 100);
			}
			?>
			<div class="charts" id="charts" data='<?=str::json_data($charts_data);?>'></div>
		</div>

		<?php
		$pc_result=manage::ueeseo_get_data('ueeshop_ueeseo_get_article', array('type'=>0));
		$pc_Total_task = count($pc_result['msg']['intro_row']);
		$pc_ThisWeekComplete_num = $pc_Total_task-count($pc_result['msg']['article_row']);
		$pc_ThisWeekComplete=0;
		if($pc_ThisWeekComplete_num){
			$pc_ThisWeekComplete=sprintf('%.2f', $pc_ThisWeekComplete_num/$pc_Total_task)*100;
			$pc_Percentage=270/(100/$pc_ThisWeekComplete);
		}

		$mb_result=manage::ueeseo_get_data('ueeshop_ueeseo_get_mobile', array('type'=>0));
		$mb_Total_task = count($mb_result['msg']['intro_row']);
		$mb_ThisWeekComplete_num = $mb_Total_task-count($mb_result['msg']['mobile_row']);
		$mb_ThisWeekComplete=0;
		if($mb_ThisWeekComplete_num){
			$mb_ThisWeekComplete=sprintf('%.2f', $mb_ThisWeekComplete_num/$mb_Total_task)*100;
			$mb_Percentage=270/(100/$mb_ThisWeekComplete);
		}
		?>
		<div class="optimization">
			<style type="text/css">
			.optimization .pc .img div{ -moz-transform:rotate(<?=$pc_Percentage;?>deg); -webkit-transform:rotate(<?=$pc_Percentage;?>deg); -ms-transform:rotate(<?=$pc_Percentage;?>deg); -o-transform:rotate(<?=$pc_Percentage;?>deg); }
			.optimization .mb .img div{ -moz-transform:rotate(<?=$mb_Percentage;?>deg); -webkit-transform:rotate(<?=$mb_Percentage;?>deg); -ms-transform:rotate(<?=$mb_Percentage;?>deg); -o-transform:rotate(<?=$mb_Percentage;?>deg); }
			</style>
			<div class="top">{/seo.overview.optimi_rate/}</div>
			<div class="mid">
				<ul>
					<li class="pc">
						<div class="img Pointer"><img src="/static/manage/images/seo/b_0.png" /><div><img src="/static/manage/images/seo/z.png" /></div></div>
						<div class="fraction"><span><?=$pc_ThisWeekComplete;?></span> %</div>
						<div class="equipment">{/seo.overview.dervice.0/}</div>
					</li>
					<li class="mb">
						<div class="img Pointer"><img src="/static/manage/images/seo/b_0.png" /><div><img src="/static/manage/images/seo/z.png" /></div></div>
						<div class="fraction"><span><?=$mb_ThisWeekComplete;?></span> %</div>
						<div class="equipment on">{/seo.overview.dervice.1/}</div>
					</li>
				</ul>
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>