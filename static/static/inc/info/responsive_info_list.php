<?php !isset($c) && exit();?>
<div class="ueeshop_responsive_info_list <?=$c['themes_info_list']['style'];?>">
	<?php
	foreach($info_list_row[0] as $k=>$v){
		$Title=$v['Title'.$c['lang']];
		$url=web::get_url($v, 'info');
	?>
		<div class="item <?=@is_file($c['root_path'].$v['PicPath'])?'':'no_img';?>">
			<div class="img"><a href="<?=$url;?>" <?=$c['config']['global']['INew']?'target="_blank"':'';?> title="<?=$Title;?>"><img src="<?=$v['PicPath'];?>" alt="<?=$Title;?>" /></a></div>
			<div class="info fr">
				<h3 class="title"><a href="<?=$url;?>" <?=$c['config']['global']['INew']?'target="_blank"':'';?> title="<?=$Title;?>"><?=$Title;?></a></h3>
				<div class="time"><h1><?=date('M d, Y', $v['AccTime']);?></h1><h2><?=date('m-d', $v['AccTime']);?><span><?=date('Y', $v['AccTime']);?></span></h2></div>
				<a href="<?=$url;?>" <?=$c['config']['global']['INew']?'target="_blank"':'';?> title="<?=$Title;?>" class="desc"><?=str::str_format($v['BriefDescription'.$c['lang']]);?></a>
			</div>
			<a class="link" href="<?=$url;?>" <?=$c['config']['global']['INew']?'target="_blank"':'';?> title="<?=$Title;?>"></a>
			<div class="clear"></div>
		</div>
    <?php }?>
	<div class="clear"></div>
	<?php if($info_list_row[3]){?>
		<div class="ueeshop_responsive_turn_page <?=$c['themes_info_list']['turn_page']['style'];?>"><?=html::turn_page_html($info_list_row[1], $info_list_row[2], $info_list_row[3], $no_page_url, "&nbsp;","&nbsp;");?></div>
	<?php }?>
</div>