<?php !isset($c) && exit();?>
<div class="pro_list">
	<?php
	foreach($list_row[0] as $k=>$v){
		$url=web::get_url($v, $page_type);
		$img=img::get_small_img($v['PicPath_0'], '240x240');
        $name=$v['Name'.$c['lang']];
		$brief=$v['BriefDescription'.$c['lang']];
	?>
	<div class="item clean">
    	<div class="img pic_box"><a href="<?=$url;?>" title="<?=$name;?>"><img src="<?=$img;?>"></a><span></span></div>
        <div class="desc fr">
            <a href="<?=$url;?>" class="name" title="<?=$name;?>"><?=$name;?></a>
            <div class="brief"><?=$brief; ?></div>
            <?php if($c['config']['products']['Config']['show_price'] && $c['FunVersion']>=1 && $page_type=='products'){?>
                <?php if($c['config']['products']['Config']['member']){?>
                    <?php if((int)$_SESSION['ly200_user']['UserId']){?>
                         <div class="price"><?=$c['config']['products']['symbol'].$v['Price_0'];?></div>
                    <?php }?>
                <?php }else{?>
                     <div class="price"><?=$c['config']['products']['symbol'].$v['Price_0'];?></div>
                <?php }?>
            <?php }?>
            <a href="<?=$url; ?>" class="more global_btn"><?=$c['lang_pack']['learn_more']; ?></a>
        </div>
    </div>
    <?php }?>
</div><!-- end of .pro_list -->