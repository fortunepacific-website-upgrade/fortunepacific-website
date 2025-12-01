<?php !isset($c) && exit();?>
<div id="lib_down_list">
    <ul>
        <?php
        foreach($download_list_row[0] as $k=>$v){
            $Title=$v['Name'.$c['lang']];
        ?>
            <li>
                <i class="fl">•</i>
                <span class="fl"><?=$v['Name'.$c['lang']];?></span>
                <a href="<?=($v['IsOth'] && !$v['Password'])?$v['FilePath']:'javascript:void(0);';?>" <?=($v['IsOth'] && !$v['Password'])?'target="_blank"':'';?> class="fr <?=$v['Password']?'pwd':'';?>" l="<?=$v['DId'];?>"><em></em><?=$c['lang_pack']['download'];?></a>
            </li>
        <?php }?>
    </ul>
</div>
<?php if($download_list_row[3]){?>
    <div class="blank25"></div>
    <div id="turn_page"><?=html::turn_page_html($download_list_row[1], $download_list_row[2], $download_list_row[3], $no_page_url, "&nbsp;","&nbsp;");?></div>
<?php }?>   