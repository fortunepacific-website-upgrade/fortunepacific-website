<?php !isset($c) && exit();?>
<div class="fr info">
    <h3 class="name"><?=$Name;?></h3>
    <div class="brief"><?=str::str_format($case_row['BriefDescription'.$c['lang']]);?></div>
    <div class="blank12"></div>
    <div class="share">
		<?php include($c['static_path'].'inc/global/share.php');?>
    </div><!-- .share -->
    <div class="blank25"></div>
</div>
<div class="clear"></div>