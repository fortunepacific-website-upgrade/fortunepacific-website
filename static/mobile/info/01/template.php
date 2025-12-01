<ul class="info_list">
    <?php
    foreach($info_list_row[0] as $k=>$v){
    ?>
    <li class="clean">
        <div class="pic pic_box "><a href="<?=ly200::get_url($v, 'info');?>" title="<?=$v['Title'.$c['lang']];?>"><img src="<?=$v['PicPath'];?>" alt="<?=$v['Title'.$c['lang']];?>"></a><span></span></div>
        <div class="desc">
            <a href="<?=ly200::get_url($v, 'info');?>" class="name" title="<?=$v['Title'.$c['lang']];?>"><?=$v['Title'.$c['lang']];?></a>
            <span class="time"><?=date('m/d/Y', $v['AccTime']);?></span>
            <div class="brief"><?=$v['BriefDescription'.$c['lang']];?></div>
        </div>
    </li>
    <?php }?>
</ul>