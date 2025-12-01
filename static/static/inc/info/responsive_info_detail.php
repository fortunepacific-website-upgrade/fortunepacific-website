<?php !isset($c) && exit();?>
<div class="ueeshop_responsive_info_detail <?=$c['themes_info_detail']['style'];?>">
	<h1 class="title"><?=$info_row['Title'.$c['lang']];?></h1>
    <div class="share"><?php include($c['static_path'].'inc/global/share.php');?></div>
    <div id="global_editor_contents" class="contents"><?=$info_contents_row['Content'.$c['lang']];?></div>
</div>