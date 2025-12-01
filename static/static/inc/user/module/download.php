<?php !isset($c) && exit();?>
<div class="contenter fr">
    <div id="adetail">
        <ul id="lib_down_list">
            <?php
			$download_list_row = db::get_all('download','IsMember=1','*',  $c['my_order'].'CateId asc');
            foreach($download_list_row as $k=>$v){
                $Title=$v['Name'.$c['lang']];
            ?>
                <li>
                    <i class="fl">•</i>
                    <span class="fl"><?=$v['Name'.$c['lang']];?></span>
                    <a href="javascript:;" class="fr" l="<?=$v['DId'];?>"><em></em><?=$c['lang_pack']['download'];?></a>
                </li>
            <?php }?>
        </ul>
        <?php if($download_list_row[3]){?>
            <div class="clear"></div>
            <div id="page"><?=html::turn_page_html($download_list_row[1], $download_list_row[2], $download_list_row[3], $no_page_url);?></div>
        <?php }?>   
        <div class="blank25"></div>         
    </div>
</div>