<?php !isset($c) && exit();?>
<div class="ueeshop_responsive_case_detail <?=$c['themes_case_detail']['style'];?>">
	<div class="name"><?=$case_row['Name'.$c['lang']];?></div>
    <div class="share"><?php include($c['static_path'].'inc/global/share.php');?></div>
	<div id="global_editor_contents" class="desc"><?=str::str_code($case_description_row['Description'.$c['lang']], 'htmlspecialchars_decode');?></div>
</div>
