<?php !isset($c) && exit();?>
<div class="detail_title clean">
    <div class="t fl"><div><?=$c['lang_pack']['description'];?></div></div>
    <?php for($i=0;$i<$c['description_count'];$i++){if(!$products_description_row['IsOpen_'.$i])continue;?>
    <div class="t fl"><div><?=$products_description_row['Title_'.$i.$c['lang']]?></div></div>
    <?php }?>
</div><!-- end of .detail_title -->
<div class="detail_txt">
    <div id="global_editor_contents" class="clean"><?=str::str_code($products_description_row['Description'.$c['lang']], 'htmlspecialchars_decode');?></div>
</div><!-- end of .detail_txt -->
<?php for($i=0;$i<$c['description_count'];$i++){if(!$products_description_row['IsOpen_'.$i])continue;?>
<div class="detail_txt">
    <div id="global_editor_contents" class="clean"><?=str::str_code($products_description_row['Description_'.$i.$c['lang']], 'htmlspecialchars_decode');?></div>
</div><!-- end of .detail_txt -->
<?php }?>