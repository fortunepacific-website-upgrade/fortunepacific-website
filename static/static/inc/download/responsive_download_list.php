<?php !isset($c) && exit();?>
<div class="ueeshop_responsive_download_list <?=$c['themes_download_list']['style'];?>">
    <ul>
        <?php
        foreach($download_list_row[0] as $k=>$v){
            $Title=$v['Name'.$c['lang']];
        ?>
            <li>
                <div class="name"><?=$v['Name'.$c['lang']];?></div>
                <a href="<?=($v['IsOth'] && !$v['Password'])?$v['FilePath']:'javascript:void(0);';?>" <?=($v['IsOth'] && !$v['Password'])?'target="_blank"':'';?> class="fr <?=$c['themes_download_list']['download_btn']['style']?> <?=$v['Password']?'pwd':'';?>" l="<?=$v['DId'];?>"><em></em></a>
            </li>
        <?php }?>
    </ul>
	<div class="clear"></div>
	<?php if($download_list_row[3]){?>
		<div class="ueeshop_responsive_turn_page <?=$c['themes_download_list']['turn_page']['style'];?>"><?=html::turn_page_html($download_list_row[1], $download_list_row[2], $download_list_row[3], $no_page_url, "&nbsp;","&nbsp;");?></div>
	<?php }?>
</div>