<?php !isset($c) && exit();?>
<div class="ueeshop_responsive_case_list <?=$c['themes_case_list']['style'];?>">
	<?php
	foreach((array)$case_list_row[0] as $k=>$v){
		$url=web::get_url($v, 'case');
		$img=img::get_small_img($v['PicPath_0'], '500X500');
		$name=$v['Name'.$c['lang']];
		$desc=str::str_cut($v['BriefDescription'.$c['lang']],180);
	?>
		<div class="item">
			<div class="img"><a href="<?=$url;?>" <?=$c['config']['global']['CNew']?"target='_blank'":"";?> title="<?=$v['Name'.$c['lang']];?>"><img src="<?=$img?>" title="<?=$v['Name'.$c['lang']];?>" alt="<?=$v['Name'.$c['lang']];?>" /></a></div>
			<div class="info">
				<div class="name"><a href="<?=$url;?>" <?=$c['config']['global']['CNew']?"target='_blank'":"";?> title="<?=$v['Name'.$c['lang']];?>"><?=$name?></a></div>
				<div class="desc"><?=$desc;?></div>
			</div>
			<div class="clear"></div>
		</div>
	<?php }?>
	<div class="clear"></div>
	<?php if($case_list_row[3]){?>
		<div class="ueeshop_responsive_turn_page <?=$c['themes_case_list']['turn_page']['style'];?>"><?=html::turn_page_html($case_list_row[1], $case_list_row[2], $case_list_row[3], $no_page_url, "&nbsp;","&nbsp;");?></div>
	<?php }?>
</div>