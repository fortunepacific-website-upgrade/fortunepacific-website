<?php !isset($c) && exit();?>
<div class="detail_desc">
    <div class="title">
        <span><?=$c['lang_pack']['description'];?></span>
        <?php for($i=0;$i<$c['description_count'];$i++){if(!$products_description_row['IsOpen_'.$i])continue;?>
        <span><?=$products_description_row['Title_'.$i.$c['lang']]?></span>
        <?php }?>
    </div>
    
    <div class="page_content">
        <div id="global_editor_contents" class="clean"><?=str::str_code($products_description_row['Description'.$c['lang']], 'htmlspecialchars_decode');?></div>
    </div>
    <?php for($i=0;$i<$c['description_count'];$i++){if(!$products_description_row['IsOpen_'.$i])continue;?>
    <div class="page_content">
        <div id="global_editor_contents" class="clean"><?=str::str_code($products_description_row['Description_'.$i.$c['lang']], 'htmlspecialchars_decode');?></div>
    </div>
    <?php }?>
</div><!-- end of .detail_desc -->