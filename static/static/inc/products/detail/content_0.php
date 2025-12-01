<?php !isset($c) && exit();?>
<div class="description">
    <div class="hd clean">
        <span class="cur"><?=$c['lang_pack']['description'];?></span>
        <?php for($i=0;$i<$c['description_count'];$i++){if(!$products_description_row['IsOpen_'.$i])continue;?>
        <span><?=$products_description_row['Title_'.$i.$c['lang']]?></span>
        <?php }?>
    </div>
    <div class="bd">
        <div class="desc_txt" style="display:block;"><div id="global_editor_contents" class="clean"><?=str::str_code($products_description_row['Description'.$c['lang']], 'htmlspecialchars_decode');?></div></div>
        <?php for($i=0;$i<$c['description_count'];$i++){if(!$products_description_row['IsOpen_'.$i])continue;?>
        <div class="desc_txt"><div id="global_editor_contents" class="clean"><?=str::str_code($products_description_row['Description_'.$i.$c['lang']], 'htmlspecialchars_decode');?></div></div>
        <?php }?>
    </div>
</div>
