<?php
manage::check_permit('seo.sitemap', 2);//检查权限

$accTime=str::str_code(db::get_value('config', "GroupId='sitemap' and Variable='AccTime'", 'Value'));
?>
<script type="text/javascript">
$(document).ready(function(){seo_obj.seo_init();});
</script>
<div id="sitemap" class="r_con_wrap">
	<div class="center_container inside_table">
		<form id="seo_form" name="sitemap_form" class="global_form">
			<div class="rows_box">
				<div class="rows clean">
					<label>{/seo.sitemap.last_generate_time/}</label>
					<div class="input"><?=$accTime?date('Y-m-d H:i:s', $accTime):'';?></div>
				</div>
				<div class="rows clean">
					<label></label>
					<div class="input">
						<input type="submit" class="btn_global btn_submit" name="submit_button" value="{/seo.sitemap.generate/}" />
					</div>
				</div>
				<?php 
				/*$domain_ary=array(
					// 'https://www.fortune-pacific.net/',
					// 'https://es.fortune-pacific.net/',
					'https://www.fortunepacific.net/',
					// 'https://es.fortunepacific.net/',
					//'https://www.fortunemachinetool.com/',
					// 'https://es.fortunemachinetool.com/',
					//'https://www.fortunepacific.vip/',
					// 'https://es.fortunepacific.vip/',
					// 'https://www.fortunepacific.asia/',
					// 'https://es.fortunepacific.asia/',
				);
				foreach((array)$domain_ary as $domain){
					$name=trim(str_replace(array('http://','https://','.'), array('','','_'), $domain),'/');
					?>
					<div class="rows clean">
						<label><?=$domain;?>sitemap_<?=$name; ?>.xml</label>
						<div class="input"><textarea class="xml_txt box_textarea" disabled readonly><?=@is_file($c['root_path'].'/sitemap_'.$name.'.xml')?file_get_contents($c['root_path'].'/sitemap_'.$name.'.xml'):'';?></textarea></div>
					</div>
				<?php }*/ ?>
				<div class="rows clean">
					<label><?=$domain;?>sitemap.xml</label>
					<div class="input"><textarea class="xml_txt box_textarea" disabled readonly><?=@is_file($c['root_path'].'/sitemap.xml')?file_get_contents($c['root_path'].'/sitemap.xml'):'';?></textarea></div>
				</div>
			</div>
			<input type="hidden" name="do_action" value="seo.seo_sitemap_edit">
		</form>
	</div>
</div>