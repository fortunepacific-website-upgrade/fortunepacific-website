<?php !isset($c) && exit();?>
<ul id="lib_info_list">
    <?php
    foreach($info_list_row[0] as $k=>$v){
        $Title=$v['Title'.$c['lang']];
    ?>
        <li>
            <i class="fl">•</i>
            <h3><a href="<?=web::get_url($v, 'info');?>" class="fl" <?=$c['config']['global']['INew'] ? "target='_blank'" : "";?> title="<?=$Title;?>"><?=$Title;?></a></h3>
            <span class="fr"><?=date('Y-m-d', $v['AccTime']);?></span>
        </li>
    <?php }?>
</ul>
<?php if($info_list_row[3]){?>
    <div class="blank25"></div>
    <div id="turn_page"><?=html::turn_page_html($info_list_row[1], $info_list_row[2], $info_list_row[3], $no_page_url, "&nbsp;","&nbsp;");?></div>
<?php }?>   