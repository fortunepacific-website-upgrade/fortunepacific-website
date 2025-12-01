<?php !isset($c) && exit();?>
<script type="text/javascript">$(document).ready(function(){set_obj.config_switch_edit();});</script>
<form id="switch_edit_form" class="global_form">
	<div class="center_container">
		<a href="/manage/?m=set&a=config" class="return_title">
			<span class="return">{/set.config.switch.switch/}</span> 
		</a>
		<div class="rows first clean">
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
						<li>
                            <div class="switchery<?=$c['manage']['config'][$k]?' checked':'';?>" field="<?=$k;?>" status="<?=(int)$c['manage']['config'][$k];?>">
                                <input type="checkbox" name="<?=$k;?>" value="1"<?=$c['manage']['config'][$k]?' checked':'';?>>
                                <div class="switchery_toggler"></div>
                                <div class="switchery_inner">
                                    <div class="switchery_state_on"></div>
                                    <div class="switchery_state_off"></div>
                                </div>
                            </div>
							{/set.config.switch.<?=$v;?>/}
                            <span class="tool_tips_ico" content="{/set.config.switch.<?=$v;?>_notes/}"></span>
						</li>
					<?php }?>
				</ul>
			</div>
		</div>
		<div class="rows clean translation IsCloseWeb <?=$c['manage']['config']['IsCloseWeb']?'':'hide';?>">
			<label>{/set.config.switch.close_web/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
			<div class="input"><?=manage::form_edit($c['manage']['config']['CloseWeb'], 'editor', 'CloseWeb');?></div>
		</div>
		<div class="rows clean button <?=$c['manage']['config']['IsCloseWeb']?'':'hide';?>">
			<label></label>
			<div class="input">
				<input type="button" class="btn_global btn_submit" value="{/global.save/}" />
				<input type="button" class="btn_global btn_translation" value="{/global.translation/}">
				<a href="./?m=set&a=config" title="{/global.return/}"><input type="button" class="btn_global btn_cancel" value="{/global.return/}" /></a>
			</div>
		</div>
		<input type="hidden" name="do_action" value="set.config_switch_close_web">
	</div>
</form>