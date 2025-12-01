<?php !isset($c) && exit();?>
<div class="dm">
    <div class="nav fl cur"><?=$c['lang_pack']['description'];?></div>
    <?php for($i=0;$i<$c['description_count'];$i++){if(!$products_description_row['IsOpen_'.$i])continue;?>
    <div class="nav fl"><?=$products_description_row['Title_'.$i.$c['lang']]?></div>
    <?php }?>
    <div class="clear"></div>
</div>

<div class="db db_contents">
    <div class="con"><div id="global_editor_contents" class="clean"><?=str::str_code($products_description_row['Description'.$c['lang']], 'htmlspecialchars_decode');?></div></div>
</div>
<?php for($i=0;$i<$c['description_count'];$i++){if(!$products_description_row['IsOpen_'.$i])continue;?>
<div class="db db_contents">
    <div class="con"><div id="global_editor_contents" class="clean"><?=str::str_code($products_description_row['Description_'.$i.$c['lang']], 'htmlspecialchars_decode');?></div></div>
</div>
<?php }?>