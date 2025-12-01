<?php !isset($c) && exit();?>
<?php
$seo_row=str::str_code(db::get_one('meta', 'Type="home"'));
$MId=(int)$seo_row['MId'];
?>
<script type="text/javascript">$(document).ready(function(){set_obj.config_seo_edit();});</script>
<form id="seo_edit_form" class="global_form">
	<div class="center_container">
		<a href="javascript:history.back(-1);" class="return_title">
			<span class="return">{/global.seo.seo/}</span>
		</a>
		<div class="rows clean">
			<label>{/global.seo.title/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
			<div class="input">
				<?=manage::form_edit($seo_row, 'text', 'SeoTitle', 65);?>
			</div>
		</div>
		<div class="rows clean">
			<label>{/global.seo.keyword/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
			<div class="input">
				<?=manage::form_edit($seo_row, 'textarea', 'SeoKeyword', 70);?>
			</div>
		</div>
		<div class="rows clean">
			<label>{/global.seo.description/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
			<div class="input">
				<?=manage::form_edit($seo_row, 'textarea', 'SeoDescription', 70);?>
			</div>
		</div>
		<div class="rows clean">
			<label></label>
			<div class="input input_button">
				<input type="button" class="btn_global btn_submit" style="margin-right:15px;" value="{/global.save/}" />
				<a href="./?m=set&a=config" title="{/global.return/}"><input type="button" class="btn_global btn_cancel" value="{/global.return/}" /></a>
			</div>
		</div>
	</div>
	<input type="hidden" name="do_action" value="set.config_seo_edit" />
	<input type="hidden" name="MId" value="<?=$MId;?>" />
	<input type="hidden" name="Type" value="home" />
</form>