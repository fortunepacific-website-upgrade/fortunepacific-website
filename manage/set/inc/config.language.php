<?php !isset($c) && exit();?>
<script type="text/javascript">$(document).ready(function(){set_obj.config_language_edit();});</script>
<div class="center_container">
	<div class="big_title rows_hd_part">
		<span>{/set.config.language.language/}</span>
	</div>
	<div class="config_table_body config_table_body_set">
		<?php
		$LanguageStatus=str::json_data($c['manage']['config']['Language_status'], 'decode');
		$LanguageUsing=$c['manage']['config']['Language'];
		$LanguageFlag=str::json_data(htmlspecialchars_decode($c['manage']['config']['LanguageFlag']), 'decode');
		foreach((array)$c['manage']['language_list'] as $v){
			$is_editable=isset($LanguageStatus[$v]) || $c['FunVersion']>1?1:0;
		?>
			<div class="table_item">
				<table border="0" cellpadding="5" cellspacing="0" class="config_table email_config_table">
					<tbody>
						<tr>
							<td width="80%" nowrap="nowrap">
								<span class="color_000">{/language.<?=$v;?>/}</span>
								<?=($LanguageFlag[$v] && is_file($c['root_path'].$LanguageFlag[$v]))?'<span class="img img_small"><img src="'.$LanguageFlag[$v].'" class="small_flag" align="absmiddle" /><span></span></span>':'';?>
								<?=$c['manage']['config']['LanguageDefault']==$v?'<span class="desc">{/set.config.language.default_language/}</span>':"";?>
							</td>
							<td width="30%" nowrap="nowrap">
							<?php if($is_editable){?>
								<a href="./?m=set&a=config&d=language&lang=<?=$v;?>" class="edit">{/global.edit/}</a>
							<?php }?>
							</td>
							<td width="50" nowrap="nowrap" align="center" class="payment_used">
								<?php if($is_editable){?>
								<div class="switchery language_switchery <?=in_array($v, $LanguageUsing)?'checked':'';?>" data-lang="<?=$v;?>">
									<div class="switchery_toggler"></div>
									<div class="switchery_inner">
										<div class="switchery_state_on"></div>
										<div class="switchery_state_off"></div>
									</div>
								</div>
								<?php }?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		<?php }?>
	</div>
	<div class="rows">
		<label></label>
		<div class="input">
			<?php if((int)$c['FunVersion']){?>
				<div class="switchery config_switchery <?=$c['manage']['config']['BrowserLanguage'] ? 'checked' : ''; ?>" data-config="BrowserLanguage">
					<div class="switchery_toggler"></div>
					<div class="switchery_inner">
						<div class="switchery_state_on"></div>
						<div class="switchery_state_off"></div>
					</div>
				</div>
				{/set.config.language.browser_language/}<span class="tool_tips_ico" content="{/set.config.language.browser_language_notes/}"></span>&nbsp;&nbsp;&nbsp;
				<div class="switchery manage_language_switchery <?=$c['manage']['config']['ManageLanguage']=='en' ? 'checked' : ''; ?>" data-lang="en">
					<div class="switchery_toggler"></div>
					<div class="switchery_inner">
						<div class="switchery_state_on"></div>
						<div class="switchery_state_off"></div>
					</div>
				</div>
				{/set.config.language.english_manage/}
			<?php } ?>
		</div>
	</div>
</div>