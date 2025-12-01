<?php !isset($c) && exit();?>
<script type="text/javascript">$(document).ready(function(){set_obj.config_language_edit();});</script>
<div class="center_container global_form">
	<a href="javascript:history.back(-1);" class="return_title">
		<span class="return">{/set.config.language.language/}</span>
		<span class="s_return">{/global.edit/}</span>
	</a>
	<?php
	$lang=trim($_GET['lang']);
	$LanguageFlag=str::json_data(htmlspecialchars_decode($c['manage']['config']['LanguageFlag']), 'decode');
	?>
	<form id="language_edit_form">
		<div class="rows">
			<label>{/set.config.language.flag/}</label>
			<div class="input">
				<?=manage::multi_img('FlagDetail', 'FlagPath', $LanguageFlag[$lang]); ?>
			</div>
		</div>
		<?php if(in_array($lang, $c['manage']['config']['Language']) && $c['manage']['config']['LanguageDefault']!=$lang){ ?>
			<div class="rows">
				<label></label>
				<div class="input">
					<span class="input_checkbox_box <?=$c['manage']['config']['LanguageDefault']==$lang ? 'checked' : ''; ?>">
						<span class="input_checkbox">
							<input type="checkbox" name="LanguageDefault" <?=$c['manage']['config']['LanguageDefault']==$lang ? 'checked="checked"' : ''; ?> value="1">
						</span>{/set.config.language.default_language/}
					</span>
				</div>
			</div>
		<?php } ?>
		<div class="rows">
			<label></label>
			<div class="input">
				<input type="button" class="btn_global btn_submit" value="{/global.save/}">
				<a href="javascript:history.back(-1);"><input type="button" class="btn_global btn_cancel" value="{/global.return/}"></a>
			</div>
		</div>
		<input type="hidden" name="do_action" value="set.config_language_edit" />
		<input type="hidden" name="Language" value="<?=$lang;?>" />
	</form>
</div>