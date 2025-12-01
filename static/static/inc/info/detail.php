<?php !isset($c) && exit();?>
<div id="lib_info_detail">
    <h1><?=$info_row['Title'.$c['lang']];?></h1>
    <div class="contents"><div id="global_editor_contents"><?=$info_contents_row['Content'.$c['lang']];?></div></div>
    <div class="blank12"></div>
    <div class="share fr">
		<?php include($c['static_path'].'inc/global/share.php');?>
    </div><!-- .share -->
    <div class="blank12"></div>
</div>