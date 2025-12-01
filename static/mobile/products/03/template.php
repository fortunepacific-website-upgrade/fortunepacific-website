<?php !isset($c) && exit();?>
<div class="pro_list">
	<?php
	foreach($list_row[0] as $k=>$v){
		$url=web::get_url($v, $page_type);
		$img=img::get_small_img($v['PicPath_0'], '240x240');
		$name=$v['Name'.$c['lang']];
	?>
	<div class="item clean">
    	<div class="desc fl">
        	<div class="n1"><a href="<?=$url;?>" title="<?=$name;?>"><?=$name;?></a></div>
            <div>
                <?php if ($v['Number']){?>
                    <div class="number"><?=$c['lang_pack']['item'];?>: <?=$v['Number'];?></div>
                <?php }?>
                <?php if($c['config']['products']['Config']['show_price'] && $c['FunVersion']>=1 && $page_type=='products'){?>
                    <?php if($c['config']['products']['Config']['member']){?>
                        <?php if((int)$_SESSION['ly200_user']['UserId']){?>
                             <div class="price"><?=$c['config']['products']['symbol'].$v['Price_0'];?></div>
                        <?php }?>
                    <?php }else{?>
                         <div class="price"><?=$c['config']['products']['symbol'].$v['Price_0'];?></div>
                    <?php }?>
                <?php }?>
                <div class="clear"></div>
            </div>
            <?php if($c['config']['global']['IsOpenInq']){?>
            <div class="inquiry">
            	<a href="javascript:void(0);" class="global_btn inquiry_btn" data="<?=$v['ProId'];?>"><?=$c['lang_pack']['mobile']['inquiry'];?></a>
            </div>
            <?php }?>
        </div>
        <div class="img fr pic_box">
        	<a href="<?=$url;?>" title="<?=$name;?>"><img src="<?=$img?>"></a><span></span>
        </div>
    </div><!-- end of .item -->
    <?php }?>
</div><!-- end of .pro_list -->

