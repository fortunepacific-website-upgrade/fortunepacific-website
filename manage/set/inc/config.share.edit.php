<?php !isset($c) && exit();?>
<script type="text/javascript">$(document).ready(function(){set_obj.config_share_edit();});</script>
<form id="share_edit_form" class="global_form">
	<div class="center_container">
		<div class="big_title">{/set.config.share.share/}</div>
		<?php
		$ShareMenuAry = $c['manage']['config']['Contact'];
		foreach((array)$c['share'] as $v){
		?>
			<table border="0" cellpadding="5" cellspacing="0" class="config_table share_item <?=$ShareMenuAry[$v] ? '' : 'hide' ; ?>" data-share="<?=$v; ?>">
				<tr>
					<td width="30%" nowrap="nowrap">
						<div class="share_div share_<?=strtolower($v); ?>"></div>
						<span class="share_str"><?=$v; ?></span>
					</td>
					<td width="55%" nowrap="nowrap">
						<input type="text" class="box_input" name="<?=$v;?>" value="<?=$ShareMenuAry[$v]; ?>" maxlength="255" />
					</td>
					<td width="15%" nowrap="nowrap" align="center">
						<a href="javascript:;" data-share="<?=$v; ?>" class="share_del"></a>
					</td>
				</tr>
			</table>
		<?php } ?>
		<table border="0" cellpadding="5" cellspacing="0" class="config_table share_add">
			<tr>
				<td width="30%" nowrap="nowrap">
					<select name="tax_code_type" class="box_input">
						<option value="0">{/global.select_index/}</option>
						<?php foreach((array)$c['share'] as $v){ ?>
							<option value="<?=$v; ?>" class="<?=$ShareMenuAry[$v] ? 'hide' : '' ; ?>" <?=$ShareMenuAry[$v] ? 'disable' : '' ; ?>><?=$v; ?></option>
						<?php } ?>
					</select>
				</td>
				<td width="55%" nowrap="nowrap">
					<input type="text" class="box_input" name="Add" maxlength="255" />
				</td>
				<td width="15%" nowrap="nowrap" align="center"></td>
			</tr>
		</table>
		<div class="rows clean">
			<label></label>
			<div class="input clean">
				<a href="javascript:;" class="fl add set_add btn_add_share">{/global.add/}</a>
				<input type="button" class="btn_global btn_submit" value="{/global.save/}" />
				<a href="javascript:history.back(-1);" title="{/global.return/}"><input type="button" class="btn_global btn_cancel" value="{/global.return/}" /></a>
			</div>
		</div>
		<input type="hidden" name="do_action" value="set.config_share_edit">
	</div>
</form>