<?php !isset($c) && exit();?>
<ul class="info_list">
    <?php
    foreach($info_list_row[0] as $k=>$v){
    ?>
    <li class="clean">
        <div class="pic pic_box "><a href="<?=web::get_url($v, 'info');?>" title="<?=$v['Title'.$c['lang']];?>"><img src="<?=$v['PicPath'];?>" alt="<?=$v['Title'.$c['lang']];?>"></a><span></span></div>
        <div class="desc">
            <div class="msg"><span class="cate"><?=db::get_value('info_category','CateId='.$v['CateId'],'Category'.$c['lang']); ?></span><em></em><span class="time"><?=date('M d, Y', $v['AccTime']);?></span></div>
            <a href="<?=web::get_url($v, 'info');?>" class="name" title="<?=$v['Title'.$c['lang']];?>"><?=$v['Title'.$c['lang']];?></a>
            <div class="brief"><?=$v['BriefDescription'.$c['lang']];?></div>
        </div>
    </li>
    <?php }?>
</ul>