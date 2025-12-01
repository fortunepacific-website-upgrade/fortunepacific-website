<?php !isset($c) && exit();?>
<div class="info_list_0">
	<?php
	foreach($info_list_row[0] as $k=>$v){
		$Title=$v['Title'.$c['lang']];
		$url = web::get_url($v, 'info');
	?>
	<div class="item clean">
    	<div class="img pic_box fl"><a href="<?=$url;?>" <?=$c['config']['global']['INew'] ? "target='_blank'" : "";?> title="<?=$Title;?>"><img src="<?=$v['PicPath'];?>" alt="<?=$Title;?>" /></a><em></em></div>
        <div class="ir fr">
        	<h3 class="name"><a href="<?=$url;?>" <?=$c['config']['global']['INew'] ? "target='_blank'" : "";?> title="<?=$Title;?>"><?=$Title;?></a></h3>
            <div class="brief">
				<div class="more fr"><a href="<?=$url;?>"><?=$c['lang_pack']['more'];?></a></div>
				<?=str::str_format($v['BriefDescription'.$c['lang']]);?>
            </div>
			<div class="time"><?=date('Y-m-d', $v['AccTime']);?></div>
        </div>
    </div>
    <?php }?>
</div>
<?php if($info_list_row[3]){?>
    <div id="turn_page"><?=html::turn_page_html($info_list_row[1], $info_list_row[2], $info_list_row[3], $no_page_url, "&nbsp;","&nbsp;");?></div>
<?php }?>