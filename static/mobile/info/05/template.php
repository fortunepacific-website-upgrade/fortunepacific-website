<?php !isset($c) && exit();?>
<ul class="info_list">
    <?php
    foreach($info_list_row[0] as $k=>$v){
        ?>
            <li class="clean <?=$k==0 && $page==0 ? 'first' : ''; ?>">
                <div class="pic pic_box "><a href="<?=web::get_url($v, 'info');?>" title="<?=$v['Title'.$c['lang']];?>"><img src="<?=$v['PicPath'];?>" alt="<?=$v['Title'.$c['lang']];?>"></a><span></span></div>
                <div class="desc">
                    <a href="<?=web::get_url($v, 'info');?>" class="name" title="<?=$v['Title'.$c['lang']];?>"><?=$v['Title'.$c['lang']];?></a>
                    <div class="time"><?=date('M d, Y', $v['AccTime']);?></div>
                    <div class="brief"><?=$v['BriefDescription'.$c['lang']];?></div>
                    <?php if($k==0 && $page==0){ ?>
                        <a href="<?=web::get_url($v, 'info');?>" class="more global_btn"><?=$c['lang_pack']['learn_more']; ?></a>
                    <?php } ?>
                </div>
            </li>
    <?php }?>
</ul>