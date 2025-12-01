<?php !isset($c) && exit();?>
<div class="wrapper index">
	<div class="banner" id="banner_box">
        <?=ly200::ad(1); ?>
    </div><!-- end of .banner -->
    <div class="home_title"><?=$c['lang_pack']['mobile']['feat_pro'];?></div>
    <div class="home_pic">
        <div class="picA"><?=ly200::ad(2); ?></div>
        <div class="picB">
            <div class="pic pict"><?=ly200::ad(3); ?></div>
            <div class="pic picb"><?=ly200::ad(4); ?></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="home_title"><?=$c['lang_pack']['new_pro'];?></div>
    <div class="home_box clean">
        <?php
        $products_list_row=str::str_code(db::get_limit('products', $c['where']['products'].' and IsIndex=1', '*', $c['my_order'].'ProId desc', 0, 4));
        foreach((array)$products_list_row as $k => $v){
            $url=web::get_url($v, 'products');
            $img=img::get_small_img($v['PicPath_0'], '500x500');
            $name=$v['Name'.$c['lang']];
            $brief=$v['BriefDescription'.$c['lang']];
            ?>
            <div class="small_pro fl">
                <div class="c">
                    <div class="img pic_box small_height"><a href="<?=$url;?>" title="<?=$name;?>"><img src="<?=$img;?>"></a><span></span></div>
                    <div class="proname"><a href="<?=$url;?>" title="<?=$name;?>"><?=$name;?></a></div>
                    <div class="probrief"><?=$brief; ?></div>
                    <?php if($c['config']['products_show']['Config']['show_price'] && $c['FunVersion']>=1){?>
                        <?php if($c['config']['products_show']['Config']['member']){?>
                            <?php if((int)$_SESSION['ly200_user']['UserId']){?>
                                 <div class="price"><?=$c['config']['products_show']['symbol'].$v['Price_0'];?></div>
                            <?php }?>
                        <?php }else{?>
                             <div class="price"><?=$c['config']['products_show']['symbol'].$v['Price_0'];?></div>
                        <?php }?>
                    <?php }?>
                </div>
            </div>
            <?php if($k%2==1){ ?>
                <div class="clear"></div>
            <?php } ?>
        <?php }?>
        <div class="clear"></div>
    </div>
    <?php 
    $ad_row_5 = ly200::ad_custom(5);
    $ad_row_6 = ly200::ad_custom(6);
    ?>
    <div class="home_contact">
        <div class="contact" style="background:url(<?=$ad_row_5['PicPath'][0]; ?>) no-repeat center center / 100% 100%;">
            <div class="con">
                <a href="<?=$ad_row_5['Url'][0];?>" class="name"><?=$ad_row_5['Title'][0]; ?></a>
                <div class="desc"><?=$ad_row_5['Contents'][0]; ?></div>
            </div>
        </div>
        <div class="contact" style="background:url(<?=$ad_row_6['PicPath'][0]; ?>) no-repeat center center / 100% 100%;">
            <div class="con">
                <a href="<?=$ad_row_6['Url'][0];?>" class="name"><?=$ad_row_6['Title'][0]; ?></a>
                <div class="desc"><?=$ad_row_6['Contents'][0]; ?></div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div><!-- end of .wrapper -->


