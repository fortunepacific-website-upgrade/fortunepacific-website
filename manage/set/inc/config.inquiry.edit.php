<?php !isset($c) && exit();?>
<script type="text/javascript">$(document).ready(function(){set_obj.config_inquiry_edit();});</script>
<div id="inquiry_edit_form" class="center_container global_form">
	<a href="javascript:history.back(-1);" class="return_title">
		<span class="return">{/set.config.inquiry.inquiry/}</span>
		<span class="s_return"> / {/set.config.inquiry.<?=$c['manage']['page'];?>/}</span>
	</a>
	<?php if($c['manage']['page']=='feedback'){
		?>
		<table border="0" cellpadding="5" cellspacing="0" class="feedback_set_list r_con_table" width="100%" rel="feedback">
			<thead>
				<tr>
					<td width="70%" nowrap="nowrap">{/global.name/}</td>
					<td width="15%" nowrap="nowrap">{/global.used/}</td>
					<td width="15%" nowrap="nowrap">{/global.required/}</td>
				</tr>
			</thead>
			<tbody>
				<?php
				$MessSet=db::get_value('config', 'GroupId="message" and Variable="MessSet"', 'Value');
				$feed_ary=str::json_data($MessSet, 'decode');
				foreach($c['manage']['feedback_set_field'] as $k=>$v){
					$status=$feed_ary[$k];
				?>
				<tr>
					<td nowrap="nowrap">{/set.config.inquiry.feedback_field.<?=$k;?>/}<?=!$v?'{/set.config.inquiry.fixed/}':'';?></td>
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
						<div class="switchery<?=(($status[1] && $v) || !$v)?' checked':'';?><?=(($v && !$status[0]) || !$v)?' no_drop':'';?>"<?=$v?" field='{$k}NotNull' status='{$status[1]}'":'';?>>
							<div class="switchery_toggler"></div>
							<div class="switchery_inner">
								<div class="switchery_state_on"></div>
								<div class="switchery_state_off"></div>
							</div>
						</div>
					</td>
				</tr>
				<?php }?>
				<tr>
					<td nowrap="nowrap">{/set.config.inquiry.custom_events/}</td>
					<td nowrap="nowrap"></td>
					<td nowrap="nowrap"><a href="./?m=set&a=config&d=inquiry&p=feedback_set" class="go"></a></td>
				</tr>
			</tbody>
		</table>
		<?php
		}elseif($c['manage']['page']=='feedback_set'){
			$row=db::get_all('feedback_set', '1', '*', "{$c[my_order]} SetId asc");
		?>
		<div class="feedback_set">
			<table border="0" cellpadding="5" cellspacing="0" width="100%" class="r_con_table">
				<thead>
					<tr>
						<td width="40%" nowrap="nowrap">{/global.name/}</td>
						<td width="40%" nowrap="nowrap">{/set.config.inquiry.type/}</td>
						<td width="15%" nowrap="nowrap">{/global.operation/}</td>
					</tr>
				</thead>
				<tbody>
					<?php foreach($row as $v){?>
					<tr>
						<td><?=$v['Name'.$c['lang']];?></td>
						<td>{/set.config.inquiry.type_list.<?=$v['TypeId'];?>/}</td>
						<td class="operation">
							<a href="javascript:;" title="{/global.edit/}" data-url="./?m=set&a=config&d=inquiry&p=edit&SetId=<?=$v['SetId']; ?>" class="edit">{/global.edit/}</a>
							<a href="./?do_action=set.config_inquiry_feedback_set_del&SetId=<?=$v['SetId'];?>" title="{/global.del/}" class="del" rel="del">{/global.del/}</a>
						</td>
					</tr>
					<?php }?>
				</tbody>
			</table>
			<a href="javascript:;" data-url="./?m=set&a=config&d=inquiry&p=edit" class="add set_add">{/global.add/}</a>
		</div>
		<div id="fixed_right" class="feedback_set_edit"></div>

	<?php }elseif($c['manage']['page']=='edit'){
		$SetId=(int)$_GET['SetId'];
		$row=db::get_one('feedback_set', "SetId={$SetId}");
		$type_id=(int)$row['TypeId'];
	?>
		<div class="feedback_set_edit">
			<form id="feedback_set_edit_form" class="global_form">
				<div class="top_title">{/set.config.inquiry.custom_events/} <a href="javascript:;" class="close"></a></div>
				<div class="rows clean">
					<label>{/global.name/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
					<div class="input"><?=manage::form_edit($row, 'text', 'Name', 30, 50, 'notnull');?></div>
				</div>

				<div class="rows clean">
					<label>{/set.config.inquiry.is_notnull/}</label>
					<div class="input">
						<div class="switchery<?=$row['IsNotnull']?' checked':'';?>">
							<input type="checkbox" name="IsNotnull" value="1"<?=$row['IsNotnull']?' checked':'';?>>
							<div class="switchery_toggler"></div>
							<div class="switchery_inner">
								<div class="switchery_state_on"></div>
								<div class="switchery_state_off"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="rows clean">
					<label>{/set.config.inquiry.type/}</label>
					<div class="input">
						<div class="box_select">
							<select name="TypeId">
								<?php foreach(manage::language('{/set.config.inquiry.type_list/}') as $k => $v){?>
								<option value="<?=$k;?>" <?=$type_id==$k ? "selected='selected'" : "";?>><?=$v;?></option>
								<?php }?>
							</select>
						</div>
					</div>
				</div>
				<div class="rows clean">
					<label></label>
					<div class="input">
						<input type="button" class="btn_global btn_submit" value="{/global.save/}">
						<input type="button" class="btn_global btn_cancel" value="{/global.cancel/}">
					</div>
				</div>
				<input type="hidden" name="SetId" value="<?=$SetId;?>" />
				<input type="hidden" name="do_action" value="set.config_inquiry_feedback_set_edit" />
			</form>
		</div>
	<?php }elseif($c['manage']['page']=='inquiry'){?>
		<div class="rows clean quick_save_form">
			<label>{/set.config.inquiry.inquiry_btn_color/}</label>
			<div class="input">
				<form>
					<input class="box_input color" type="text" name="Color" value="<?=trim(db::get_value('config', "GroupId='inquiry' and Variable='inquiry_button'",'Value'), '#');?>" autocomplete="off" size="6">
					<input type="button" class="btn_global btn_submit" value="{/global.save/}" />
					<input type="hidden" name="do_action" value="set.config_inquiry_btn_color_edit">
				</form>
			</div>
		</div>
		<div class="blank25"></div>
		<table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%" rel="inquiry">
			<thead>
				<tr>
					<td width="70%" nowrap="nowrap">{/global.name/}</td>
					<td width="15%" nowrap="nowrap">{/global.used/}</td>
					<td width="15%" nowrap="nowrap">{/global.required/}</td>
				</tr>
			</thead>
			<tbody>
				<?php
				$InqSet=db::get_value('config', 'GroupId="inquiry" and Variable="InqSet"', 'Value');
				$feed_ary=str::json_data($InqSet, 'decode');
				foreach($c['manage']['inquiry_set_field'] as $k=>$v){
					$status=$feed_ary[$k];
				?>
				<tr>
					<td nowrap="nowrap">{/set.config.inquiry.inquiry_field.<?=$k;?>/}<?=!$v?'{/set.config.inquiry.fixed/}':'';?></td>
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
			</tbody>
		</table>
	<?php }elseif($c['manage']['page']=='newsletter'){
		$nl_set = $c['manage']['config']['NewsletterSet'];
		$nl_set_used = $nl_set[0];
		$nl_set_seconds = $nl_set[1];
		$nl_set_bg = $nl_set[2];
	?>
		<form id="newsletter_set_form">
			<div class="rows clean">
				<label>{/global.used/}</label>
				<div class="input">
					<div class="switchery<?=$nl_set_used?' checked':'';?>">
						<input type="checkbox" name="IsOpen" value="1"<?=$nl_set_used?' checked':'';?>>
						<div class="switchery_toggler"></div>
						<div class="switchery_inner">
							<div class="switchery_state_on"></div>
							<div class="switchery_state_off"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="rows clean">
				<label>{/global.title/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
				<div class="input"><?=manage::form_edit($nl_set['Title'], 'text', 'Title', 53, 150, 'notnull');?></div>
			</div>
			<div class="rows clean translation">
				<label>{/global.brief_description/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
				<div class="input"><?=manage::form_edit($nl_set['BriefDescription'], 'textarea', 'BriefDescription');?></div>
			</div>
			<div class="rows clean">
				<label>
				{/set.config.inquiry.newsletter_field.seconds/}
				<span class="tool_tips_ico" content="{/set.config.inquiry.newsletter_field.tips/}"></span>
				</label>
				<div class="input"><input name="Seconds" value="<?=$nl_set_seconds;?>" type="text" class="box_input" size="5" maxlength="255" /></div>
			</div>
			<div class="rows clean">
				<label></label>
				<div class="input">
					<input type="submit" class="btn_global btn_submit" name="submit_button" value="{/global.save/}" />
					<a href="javascript:history.back(-1);"><input type="button" class="btn_global btn_cancel" value="{/global.return/}"></a>
				</div>
			</div>
			<input type="hidden" name="do_action" value="set.config_inquiry_newsletter_set" />
		</form>
	<?php }?>
</div>