<?php !isset($c) && exit();?>
<?php
manage::check_permit('products.watermark', 2);//检查权限
echo ly200::load_static('/static/js/plugin/operamasks/operamasks-ui.css', '/static/js/plugin/operamasks/operamasks-ui.min.js');
?>
<script type="text/javascript">$(document).ready(function(){products_obj.watermark_init();});</script>
<div id="watermark" class="r_con_wrap">
	<div class="center_container">
		<form id="edit_form" class="global_form not_fixed" name="upload_form">
			<h3 class="big_title">{/products.watermark.watermark_title/}</h3>
			<div class="rows clean">
				<label>{/products.category.children/}</label>
				<div class="input">
				<div class="box_select"><?=category::ouput_Category_to_Select('CateId', '', 'products_category', 'UId="0,"', 1, 'notnull', '{/global.select_index/}');?></div>
				</div>
			</div>
			<div class="rows clean">
				<label></label>
				<div class="input">
					<input type="submit" class="btn_global btn_submit" name="submit_button" value="{/global.submit/}" />
				</div>
			</div>

			<h3 class="rows_hd">{/products.watermark.progress/}</h3>
			<div id="explode_progress"></div>
			<input type="hidden" name="do_action" value="products.watermark_update" />
			<input type="hidden" name="Number" value="0" />
		</form>
    </div>
</div>