<?php !isset($c) && exit();?>
<script type="text/javascript">$(document).ready(function(){set_obj.config_user_edit();});</script>
<div id="reg_set" class="center_container global_form">
	<a href="javascript:history.back(-1);" class="return_title">
		<span class="return">{/set.config.user.user/}</span>
		<?php if($c['manage']['page']!='config'){?><span class="s_return">/ {/set.config.user.reg_field_set/}</span><?php }?>
		<?php if($c['manage']['page']=='list'){ ?>
			<span class="s_return">/ {/set.config.user.custom_field/}</span>
		<?php } ?>
	</a>
	<?php if($c['manage']['page']=='config'){ ?>
		<form id="user_config_form" class="global_form">
			<div class="rows clean">
				<div class="input">
					<ul class="data_list">
						<li>
							<div class="switchery <?=$c['manage']['config']['IsOpenMember']?' checked':'';?>">
								<input type="checkbox" name="IsOpenMember" value="1"<?=$c['manage']['config']['IsOpenMember']?' checked':'';?>>
								<div class="switchery_toggler"></div>
								<div class="switchery_inner">
									<div class="switchery_state_on"></div>
									<div class="switchery_state_off"></div>
								</div>
							</div>
							{/set.config.user.is_open/}
						</li>
						<li>
							<div class="switchery <?=$c['manage']['config']['UserStatus']?' checked':'';?>">
								<input type="checkbox" name="UserStatus" value="1"<?=$c['manage']['config']['UserStatus']?' checked':'';?>>
								<div class="switchery_toggler"></div>
								<div class="switchery_inner">
									<div class="switchery_state_on"></div>
									<div class="switchery_state_off"></div>
								</div>
							</div>
							{/set.config.user.verify/}
						</li>
						<li>
							<div class="switchery <?=$c['manage']['config']['UserVerification']?' checked':'';?>">
								<input type="checkbox" name="UserVerification" value="1"<?=$c['manage']['config']['UserVerification']?' checked':'';?>>
								<div class="switchery_toggler"></div>
								<div class="switchery_inner">
									<div class="switchery_state_on"></div>
									<div class="switchery_state_off"></div>
								</div>
							</div>
							{/set.config.user.email_verify/}
						</li>
					</ul>
				</div>
			</div>
			<div class="rows clean translation">
				<label>
					{/set.config.user.reg_page_notes/}
					<div class="tab_box"><?=manage::html_tab_button();?></div>
				</label>
				<div class="input">
					<?php foreach($c['manage']['config']['Language'] as $k=>$v){?>
						<div class="tab_txt tab_txt_<?=$v;?>" lang="<?=$v;?>" <?=$c['manage']['config']['LanguageDefault']==$v?'style="display:block;"':''?>>
							<textarea name="regtips_<?=$v;?>" class="box_textarea"><?=htmlspecialchars(htmlspecialchars_decode($c['manage']['config']['RegTips']["regtips_{$v}"]), ENT_QUOTES);?></textarea>
						</div>
					<?php }?>
				</div>
			</div>
			<div class="rows clean">
				<label></label>
				<div class="input">
					<input type="button" class="btn_global btn_submit" value="{/global.save/}" />
					<input type="button" class="btn_global btn_translation" value="{/global.translation/}">
					<a href="javascript:history.back(-1);" title="{/global.return/}"><input type="button" class="btn_global btn_cancel" value="{/global.return/}" /></a>
				</div>
			</div>
			<input type="hidden" name="do_action" value="set.config_user_set">
		</form>
	<?php
	}elseif($c['manage']['page']=='list'){
		$row=str::str_code(db::get_all('user_reg_set', '1', '*', "{$c['my_order']} SetId asc"));
	?>
		<table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
			<thead>
				<tr>
					<td width="25%" nowrap="nowrap">{/global.name/}</td>
					<td width="15%" nowrap="nowrap">{/set.config.user.field_type/}</td>
					<td width="25%" nowrap="nowrap">{/set.config.user.field_option/}</td>
					<td width="15%" nowrap="nowrap">{/global.operation/}</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach((array)$row as $v){?>
				<tr>
					<td nowrap="nowrap"><?=$v['Name_'.$c['manage']['language_web'][0]];?></td>
					<td nowrap="nowrap">{/set.config.user.field_type_ary.<?=$v['TypeId'];?>/}</td>
					<td nowrap="nowrap" class="line_h_20"><?=str::str_format($v['Option_'.$c['manage']['language_web'][0]]);?></td>
					<td nowrap="nowrap" class="operation">
						<a href="javascript:;" data-url="./?m=set&a=config&d=user&p=edit&SetId=<?=$v['SetId']; ?>" class="edit">{/global.edit/}</a>
						<a href="./?do_action=set.config_user_reg_set_del&SetId=<?=$v['SetId']; ?>" class="del">{/global.del/}</a>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
		<a href="javascript:;" data-url="./?m=set&a=config&d=user&p=edit" class="add set_add">{/global.add/}</a>
		<div id="fixed_right" class="reg_set_edit"></div>
	<?php }elseif($c['manage']['page']=='edit'){ ?>
		<div class="reg_set_edit">
			<?php
			$SetId=(int)$_GET['SetId'];
			$row=str::str_code(db::get_one('user_reg_set', "SetId={$SetId}"));
			$type_id=(int)$row['TypeId'];
			?>
			<div class="top_title"><?=$SetId?'{/global.edit/}':'{/global.add/}';?>{/user.reg_set.custom_events/} <a href="javascript:;" class="close"></a></div>
			<form id="reg_set_form" class="global_form">
				<div class="rows">
					<label>{/set.config.user.field_type/}</label>
					<div class="input"><?=str_replace('<select', '<select id="type_select" class="box_input"', html::form_select(manage::language('{/set.config.user.field_type_ary/}'), 'TypeId', $type_id));?></div>
				</div>
				<div class="rows">
					<label>
						{/global.name/}
						<div class="tab_box"><?=manage::html_tab_button();?></div>
					</label>
					<div class="input"><?=manage::form_edit($row, 'text', 'Name', 30, 50, 'notnull');?></div>
				</div>
				<div class="rows row_option" style="display:<?=$type_id==1?'':'none';?>;">
					<label>
						{/set.config.user.field_option/}
						<div class="tab_box"><?=manage::html_tab_button();?></div>
						<span class="fc_red">{/set.config.user.field_option_notes/}</span>
					</label>
					<div class="input">
						<?=str_replace('<textarea', '<textarea class="box_textarea"', manage::form_edit($row, 'textarea', 'Option'));?>
					</div>
				</div>
				<div class="rows clean">
					<label></label>
					<div class="input">
						<input type="button" class="btn_global btn_submit" value="{/global.save/}">
						<input type="button" class="btn_global btn_cancel" value="{/global.cancel/}">
					</div>
				</div>
				<input type="hidden" name="SetId" value="<?=$SetId; ?>" />
				<input type="hidden" name="do_action" value="set.config_user_reg_set_edit" />
			</form>
		</div>
	<?php }else{ ?>
		<table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
			<thead>
				<tr>
					<td width="70%" nowrap="nowrap">{/global.name/}</td>
					<td width="15%" nowrap="nowrap">{/global.used/}</td>
					<td width="15%" nowrap="nowrap">{/global.required/}</td>
				</tr>
			</thead>
			<tbody>
				<?php
				$RegSet=db::get_value('config', 'GroupId="user" and Variable="RegSet"', 'Value');
				$reg_ary=str::json_data($RegSet, 'decode');
				foreach($c['manage']['user_reg_set_field'] as $k=>$v){
					if($k=='Email') continue;
					$status=$reg_ary[$k];
				?>
					<tr>
						<td nowrap="nowrap">{/set.config.user.reg_field.<?=$k;?>/}<?=!$v?'{/set.config.user.fixed/}':'';?></td>
						<td nowrap="nowrap">
							<div class="switchery<?=(($status[0] && $v) || !$v)?' checked':'';?><?=!$v?' no_drop':'';?>"<?=$v?" field='{$k}' status='{$status[0]}'":'';?>>
								<div class="switchery_toggler"></div>
								<div class="switchery_inner">
									<div class="switchery_state_on"></div>
									<div class="switchery_state_off"></div>
								</div>
							</div>
						</td>
						<td nowrap="nowrap">
							<?php if($k!='Code'){?>
								<div class="switchery<?=(($status[1] && $v) || !$v)?' checked':'';?><?=(($v && !$status[0]) || !$v)?' no_drop':'';?>"<?=$v?" field='{$k}NotNull' status='{$status[1]}'":'';?>>
									<div class="switchery_toggler"></div>
									<div class="switchery_inner">
										<div class="switchery_state_on"></div>
										<div class="switchery_state_off"></div>
									</div>
								</div>
							<?php }?>
						</td>
					</tr>
				<?php }?>
				<tr>
					<td nowrap="nowrap">{/set.config.user.custom_field/}</td>
					<td nowrap="nowrap"></td>
					<td nowrap="nowrap"><a href="./?m=set&a=config&d=user&p=list" class="go"></a></td>
				</tr>
			</tbody>
		</table>
	<?php } ?>
</div>