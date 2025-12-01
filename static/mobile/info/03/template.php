<?php !isset($c) && exit();?>
<ul class="info_list">
    <?php
    foreach($info_list_row[0] as $k=>$v){
    ?>
    <li class="clean">
        <div class="pic pic_box "><a href="<?=web::get_url($v, 'info');?>" title="<?=$v['Title'.$c['lang']];?>"><img src="<?=$v['PicPath'];?>" alt="<?=$v['Title'.$c['lang']];?>"></a><span></span></div>
        <div class="desc">
            <span class="time"><?=date('Y/m/d', $v['AccTime']);?></span>
            <a href="<?=web::get_url($v, 'info');?>" class="name" title="<?=$v['Title'.$c['lang']];?>"><?=$v['Title'.$c['lang']];?><?=$v['Title'.$c['lang']];?><?=$v['Title'.$c['lang']];?><?=$v['Title'.$c['lang']];?><?=$v['Title'.$c['lang']];?></a>
            <a href="<?=web::get_url($v, 'info');?>" class="more global_btn"><?=$c['lang_pack']['more']; ?>+</a>
        </div>
    </li>
    <?php }?>
</ul>