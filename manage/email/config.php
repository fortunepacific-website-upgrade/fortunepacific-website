<?php !isset($c) && exit();?>
<?php
manage::check_permit('email.config', 2);//检查权限

$row=db::get_one('config', 'GroupId="email" and Variable="Config"');
$config_row=str::json_data($row['Value'], 'decode');
?>
<script type="text/javascript">$(function(){email_obj.config_init();})</script>
<div id="email" class="r_con_wrap">
	<div class="center_container">
		<div class="big_title">{/module.email.config/}</div>
		<form id="email_form" name="email_form" class="global_form">
			<div class="rows_box">
				<!-- 基本信息 -->
				<div class="rows clean" style="display:none;"><?php /*?> 隐藏自定义选项 <?php */?>
					<label>{/email.config.method/}</label>
					<div class="input"><input type="radio" value="0" name="Module" <?=!$config_row['Module']?'checked="checked"':'';?> />{/email.config.default/} <input type="radio" value="1" name="Module" <?=$config_row['Module']?'checked="checked"':'';?> /> {/email.config.custom_set/}</div>
				</div>
				<div class="rows clean">
					<label>{/email.config.from_email/}</label>
					<div class="input"><input name="FromEmail" value="<?=$config_row['FromEmail'];?>" type="text" class="box_input" size="30" maxlength="100" notnull /></div>
				</div>
				<div class="rows clean">
					<label>{/email.config.from_name/}</label>
					<div class="input"><input name="FromName" value="<?=$config_row['FromName'];?>" type="text" class="box_input" size="30" maxlength="100" notnull /></div>
				</div>
				<div class="rows clean module1">
					<label>{/email.config.smtp/}</label>
					<div class="input"><input name="SmtpHost" value="<?=$config_row['SmtpHost'];?>" type="text" class="box_input" size="30" maxlength="100" /></div>
				</div>
				<div class="rows clean module1">
					<label>{/email.config.port/}</label>
					<div class="input"><input name="SmtpPort" value="<?=$config_row['SmtpPort'];?>" type="text" class="box_input" size="20" maxlength="100" /></div>
				</div>
				<div class="rows clean module1">
					<label>{/email.config.email/}</label>
					<div class="input"><input name="SmtpUserName" value="<?=$config_row['SmtpUserName'];?>" type="text" class="box_input" size="30" maxlength="100" /></div>
				</div>
				<div class="rows clean module1">
					<label>{/email.config.password/}</label>
					<div class="input"><input name="SmtpPassword" value="<?=$config_row['SmtpPassword'];?>" type="password" class="box_input" size="30" maxlength="100" /></div>
				</div>
				<div class="rows clean">
					<label></label>
					<div class="input">
						<input type="button" name="submit_button" class="btn_global btn_submit" value="{/global.submit/}">
					</div>
				</div>
				<input type="hidden" name="do_action" value="email.config" />
			</div>
		</form>
	</div>
</div>