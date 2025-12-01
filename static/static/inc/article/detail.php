<?php !isset($c) && exit();?>
<div id="global_editor_contents"><?=str::str_code($article_contents_row['Content'.$c['lang']], 'htmlspecialchars_decode');?></div>
    <div class="blank25"></div>
    <div class="share fr"><?php include($c['static_path'].'inc/global/share.php');?></div>
    <div class="clear"></div>
<?php if($article_row['IsFeed']){?>
	<div class="blank25"></div>
	<?php include("{$c['static_path']}/inc/article/feedback.php");?>
<?php }?>