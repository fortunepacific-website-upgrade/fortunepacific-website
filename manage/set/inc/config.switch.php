<?php !isset($c) && exit();?>
<div class="center_container">
	<div class="big_title rows_hd_part">
		<a href="./?m=set&a=config&d=switch" class="set_edit">{/global.edit/}</a>
		<span>{/set.config.switch.switch/}</span>
	</div>
	<div class="rows rows_static first clean">
		<label>{/global.set/}</label>
		<div class="input">
			<ul class="data_list">
				<?php
				$switch_ary=array(
					'IsOpenInq'			=>	'open_inquiry',
					'IsCopy'			=>	'cannot_copy',
					'PromptSteps'		=>	'prompt_steps',
					'301'				=>	'301',
					'PNew'				=>	'product_open_new',
					'CNew'				=>	'case_open_new',
					'INew'				=>	'info_open_new',
					'IsCloseWeb'		=>	'close_web',
					'IsReview'			=>	'open_review',
					'IsReviewDisplay'	=>	'open_review_verify'
				);
				$version_process=db::get_value('config', 'GroupId="version_process" and Variable="shield"', 'Value');
				if((int)$c['FunVersion'] || (!$c['FunVersion'] && $version_process)){
					$switch_ary=array(
						'IsIP'				=>	'shield_ip',
						'IsChineseBrowser'	=>	'shield_browser',
					)+$switch_ary;	//301是数字键名，不能使用array_merge
					$switch_ary['IsOpenMobileVersion']='mobile_version';
				}
				foreach($switch_ary as $k=>$v){
				?>
					<li><span class="ico <?=(int)$c['manage']['config'][$k]?'':'off';?>"></span> {/set.config.switch.<?=$v;?>/}</li>
				<?php }?>
			</ul>
		</div>
	</div>
</div>