<?php !isset($c) && exit();?>
<div class="center_container">
	<?php $seo_row=str::str_code(db::get_one('meta', 'Type="home"')); ?>
	<div class="big_title rows_hd_part">
		<a href="./?m=set&a=config&d=seo" class="set_edit">{/global.edit/}</a>
		<span>{/global.seo.seo/}</span>
	</div>
	<div class="rows rows_static first clean">
		<label>{/global.seo.title/}</label>
		<div class="input"><?=$seo_row['SeoTitle_'.$c['manage']['language_web'][0]];?></div>
	</div>
	<div class="rows rows_static clean">
		<label>{/global.seo.keyword/}</label>
		<div class="input"><?=$seo_row['SeoKeyword_'.$c['manage']['language_web'][0]];?></div>
	</div>
	<div class="rows rows_static clean">
		<label>{/global.seo.description/}</label>
		<div class="input"><?=$seo_row['SeoDescription_'.$c['manage']['language_web'][0]];?></div>
	</div>
</div>