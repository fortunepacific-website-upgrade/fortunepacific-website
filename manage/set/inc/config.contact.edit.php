<?php !isset($c) && exit();?>
<script type="text/javascript">$(document).ready(function(){set_obj.config_contact_edit();});</script>
<form id="contact_edit_form" class="global_form">
	<div class="center_container">
		<a href="javascript:history.back(-1);" class="return_title">
			<span class="return">{/set.config.contact.contact/}</span> 
		</a>
		<?php $config_contact=str::json_data(db::get_value('config', 'GroupId="global" and Variable="Contact"', 'Value'), 'decode');?>
		<div class="rows clean">
			<label>
				{/set.config.contact.company/}
				<div class="tab_box"><?=manage::html_tab_button();?></div>
			</label>
			<div class="input">
				<?=manage::form_edit($config_contact, 'text', 'company', 50,100);?>
			</div>
		</div>
		<div class="rows clean">
			<label>{/set.config.contact.email/}</label>
			<div class="input"><input type="text" class="box_input" name="email" value="<?=$c['manage']['config']['Contact']['email'];?>" size="50" maxlength="255" format="Email" /></div>
		</div>
		<div class="rows clean">
			<label>{/set.config.contact.tel/}</label>
			<div class="input"><input type="text" class="box_input" name="tel" value="<?=$c['manage']['config']['Contact']['tel'];?>" size="50" maxlength="255" /></div>
		</div>
		<div class="rows clean">
			<label>{/set.config.contact.fax/}</label>
			<div class="input"><input type="text" class="box_input" name="fax" value="<?=$c['manage']['config']['Contact']['fax'];?>" size="50" maxlength="255" /></div>
		</div>
		<div class="rows clean translation">
			<label>
				{/set.config.contact.address/}
				<div class="tab_box"><?=manage::html_tab_button();?></div>
			</label>
			<div class="input">
				<?=manage::form_edit($config_contact, 'text', 'address', 80);?>
			</div>
		</div>
		<div class="rows clean">
			<label>{/set.config.contact.contact_us/}</label>
			<div class="input"><input type="text" class="box_input" name="contact" value="<?=$c['manage']['config']['Contact']['contact'];?>" size="50" maxlength="255" /><span class="tool_tips_ico" content="{/set.config.contact.contact_us_notes/}"></span></div>
		</div>
		<div class="rows clean">
			<label>{/set.config.contact.home_page/}</label>
			<div class="input"><input type="text" class="box_input" name="links" value="<?=$c['manage']['config']['Contact']['links'];?>" size="50" maxlength="255" /><span class="tool_tips_ico" content="{/set.config.contact.home_page_notes/}"></span></div>
		</div>
		<div class="rows clean">
			<label></label>
			<div class="input">
				<input type="button" class="btn_global btn_submit" value="{/global.save/}" />
				<input type="button" class="btn_global btn_translation" value="{/global.translation/}">
				<a href="javascript:history.back(-1);" title="{/global.return/}"><input type="button" class="btn_global btn_cancel" value="{/global.return/}" /></a>
			</div>
		</div>
		<input type="hidden" name="do_action" value="set.config_contact_edit">
	</div>
</form>