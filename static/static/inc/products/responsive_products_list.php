<?php !isset($c) && exit();?>
<div class="ueeshop_responsive_products_list <?=$c['themes_products_list']['style'];?>">
	<?php if(!$products_list_row[0]){?>
		<div class="no_products"><?=$c['config']['global']['Contact']['ptips'.$c['lang']];?></div>
	<?php }?>
	<?php
	foreach((array)$products_list_row[0] as $k => $v){
		$url=web::get_url($v, 'products');
		$img=img::get_small_img($v['PicPath_0'], '500x500');
		$name=$v['Name'.$c['lang']];
	?>
		<div class="item">
			<div class="pro">
				<div class="img"><a href="<?=$url;?>" <?=$c['config']['global']['PNew'] ? "target='_blank'" : "";?> title="<?=$name;?>"><img src="<?=$img;?>" class="trans5 delay" alt="<?=$name;?>" /></a></div>
				<div class="info">
					<h3 class="name"><a href="<?=$url;?>" title="<?=$name;?>"><?=$name;?></a></h3>
					<a href="<?=$url;?>" <?=$c['config']['global']['PNew'] ? "target='_blank'" : "";?> title="<?=$name;?>" class="more">VIEW DETAIL</a>
				</div>
			</div>
		</div>
	<?php }?>
	<div class="clear"></div>
	<?php if($products_list_row[3]){?>
		<div class="ueeshop_responsive_turn_page <?=$c['themes_products_list']['turn_page']['style'];?>"><?=html::turn_page_html($products_list_row[1], $products_list_row[2], $products_list_row[3], $no_page_url, "&nbsp;","&nbsp;");?></div>
	<?php }?>
</div>