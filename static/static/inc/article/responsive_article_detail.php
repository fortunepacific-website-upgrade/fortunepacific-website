<?php !isset($c) && exit();?>
<div class="ueeshop_responsive_article_detail <?=$c['themes_article_detail']['style'];?> <?=!$article_row['IsFeed']?'content-100':''?>">
	<div class="contents">
		<?=str::str_code($article_contents_row['Content'.$c['lang']], 'htmlspecialchars_decode');?>
		<div class="share"><?php include($c['static_path'].'inc/global/share.php');?></div>
	</div>
	<?php
	$article_row['IsFeed'] && include($c['static_path'].'/inc/article/responsive_article_detail_feedback.php');
	?>
</div>