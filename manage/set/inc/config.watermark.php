<?php !isset($c) && exit();?>
<div class="center_container">
	<div class="big_title rows_hd_part">
		<a href="./?m=set&a=config&d=watermark" class="set_edit">{/global.edit/}</a>
		<span>{/set.config.watermark.watermark/}</span>
	</div>
	<?php if($c['manage']['config']['IsWater']){ ?>
		<div class="rows rows_static first clean">
			<label>{/set.config.watermark.alpha/}</label>
			<div class="input"><?=$c['manage']['config']['Alpha'];?>%</div>
		</div>
		<div class="rows rows_static clean">
			<label>{/set.config.watermark.position/}</label>
			<div class="input">
				{/set.config.watermark.position_ary.<?=$c['manage']['config']['WaterPosition'];?>/}
				<br/> <img src="/static/manage/images/set/watermark_position_<?=$c['manage']['config']['WaterPosition']; ?>.png" alt="">
			</div>
		</div>
	<?php } ?>
</div>