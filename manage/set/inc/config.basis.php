<?php !isset($c) && exit();?>
<div class="center_container">
	<div class="big_title rows_hd_part">
		<a href="./?m=set&a=config&d=basis" class="set_edit">{/global.edit/}</a>
		<span>{/set.config.basis.basis/}</span>
	</div>
	<div class="rows rows_static first clean">
		<label>{/set.config.basis.site_name/}</label>
		<div class="input"><?=$c['manage']['config']['SiteName'];?></div>
	</div>
	<div class="rows rows_static clean">
		<label>{/global.logo/}</label>
		<div class="input">
			<div class="img">
				<img src="<?=$c['manage']['config']['LogoPath'];?>">
				<span></span>
			</div>
		</div>
	</div>
	<div class="rows rows_static clean">
		<label>{/set.config.basis.ico/}</label>
		<div class="input">
			<div class="img">
				<img src="<?=$c['manage']['config']['IcoPath'];?>" alt="">
				<span></span>
			</div>
		</div>
	</div>
	<div class="rows rows_static clean">
		<label>{/set.config.basis.web_display/}</label>
		<div class="input">{/set.config.basis.web_display_ary.<?=$c['manage']['config']['WebDisplay'];?>/}</div>
	</div>
	<div class="rows rows_static clean">
		<label>{/set.config.basis.is_footer_feedback/}</label>
		<div class="input">{/global.n_y.<?=(int)$c['manage']['config']['Is_footer_feedback'];?>/}</div>
	</div>
	<div class="rows rows_static clean">
		<label>{/set.config.basis.products_search_tips/}</label>
		<div class="input"><?=$c['manage']['config']['Contact']['ptips_'.$c['manage']['language_web'][0]];?></div>
	</div>
	<div class="rows rows_static clean">
		<label>{/set.config.basis.copyright/}</label>
		<div class="input"><?=$c['manage']['config']['Contact']['copyright_'.$c['manage']['language_web'][0]];?></div>
	</div>
	<?php if($c['FunVersion']==2){?>
		<div class="rows rows_static clean">
			<label>{/set.config.basis.blog_copyright/}</label>
			<div class="input"><?=$c['manage']['config']['Blog'];?></div>
		</div>
	<?php }?>
</div>