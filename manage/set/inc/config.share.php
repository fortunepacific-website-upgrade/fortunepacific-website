<?php !isset($c) && exit();?>
<div class="center_container">
	<div class="big_title rows_hd_part">
		<a href="./?m=set&a=config&d=share" class="set_edit">{/global.edit/}</a>
		<span>{/set.config.share.share/}</span>
	</div>
	<?php
	foreach((array)$c['share'] as $k=>$v){?>
		<div class="rows rows_static <?=!$k?'first':''?> clean">
			<label><div class="share_div share_<?=strtolower($v); ?>"></div>&nbsp;&nbsp;<?=$v;?></label>
			<div class="input"><?=$c['manage']['config']['ShareMenu'][$v];?></div>
		</div>
	<?php } ?>
</div>