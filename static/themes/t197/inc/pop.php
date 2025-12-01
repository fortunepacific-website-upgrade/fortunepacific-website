<?php !isset($c) && exit();?>
<?php
	$pop_where = $c['where']['products'];
	$pop = db::get_limit('products',$pop_where.' and IsBestDeals=1','*','MyOrder desc,ProId asc',0,5);
?>
<div class="in_sign"><?=$c['lang_pack']['pop'];?> <?=$c['lang_pack']['products'];?></div>
<?php if($pop){?>
<div class="pop_box">
	<?php
		foreach((array)$pop as $k => $v){
			$url=web::get_url($v, 'products');
			$img=img::get_small_img($v['PicPath_0'], '240x240');
			$name=$v['Name'.$c['lang']];
	?>
    	<div class="p_list">
        	<div class="pic fl">
            	<a href="<?=$url;?>" <?=$c['config']['global']['PNew'] ? "target='_blank'" : "";?> title="<?=$name;?>"><img src="<?=$img;?>" title="<?=$name;?>" alt="<?=$name;?>" /><span></span></a>
            </div>
            <div class="con fl">
            	<div class="name"><h3><a href="<?=$url;?>" <?=$c['config']['global']['PNew'] ? "target='_blank'" : "";?> title="<?=$name;?>"><?=$name;?></a></h3></div>
				<?php if($c['config']['products']['Config']['show_price'] && $c['FunVersion']>=1){?>
                    <?php if($c['config']['products']['Config']['member']){?>
                        <?php if((int)$_SESSION['ly200_user']['UserId']){?>
                             <div class="price"><?=$c['config']['products']['symbol'].$v['Price_0'];?></div>
                        <?php }?>
                    <?php }else{?>
                         <div class="price"><?=$c['config']['products']['symbol'].$v['Price_0'];?></div>
                    <?php }?>
                <?php }?>
            </div>
            <div class="clear"></div>
        </div>
    <?php }?>
</div>
<?php }?>