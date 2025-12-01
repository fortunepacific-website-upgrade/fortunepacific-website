<?php !isset($c) && exit();?>
<?php
include("{$c['static_path']}/inc/products/query.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<?=web::seo_meta($products_seo_row, $spare_ary);?>
<?php include("{$c['static_path']}/inc/static.php");?>
<?=ly200::load_static('/static/js/plugin/effect/magiczoom.js','/static/js/plugin/effect/Zslide.min.js');?>
</head>
<body class="lang<?=$c['lang'];?>">
<?php include("{$c['theme_path']}/inc/header.php");?>
<div class="page min">
	<div class="wrap">
    	<div class="blank25"></div>
    	<div class="page_l fl">
        	<?php include("{$c['theme_path']}/inc/pro_side.php");?>
            <?php include("{$c['theme_path']}/inc/pop.php");?>
        </div>
        <div class="page_r fr">
        	<div id="page_ban"><?=ly200::ad(6);?></div>
            <div id="position" class="position">
                <span class="fl"><?=$category_row['Category'.$c['lang']];?></span>
                <a href="/"><?=$c['lang_pack']['home'];?></a>
                <?=$CateId?web::get_web_position($category_row, 'products_category', substr($c['lang'], 1), ' > '):' &gt; <a href="/products/">'.$c['lang_pack']['products'].'</a>';?>
            </div>
        	<div id="d_products" class="c_contents">
                <div class="dt">
                    <?php include($c['static_path'].'inc/products/gallery_0.php');//放大镜?>
                    <div class="dtr fr">
                    	<?php include($c['static_path'].'inc/products/righter.php');?>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="blank25"></div>
                <?php include($c['static_path'].'inc/products/detail/content_3.php');?>
                <div class="dm clean">
                    <div class="nav fl cur"><?=$c['lang_pack']['also_like'];?></div>
                </div>
                <div id="products">
                    <?php
						$row = db::get_limit('products', "CateId = '{$CateId}' and ProId!='{$products_row['ProId']}'", '*', $c['my_order'].'ProId desc', 0, 4);
                        foreach((array)$row as $k => $v){
                            $url=web::get_url($v, 'products');
                            $img=img::get_small_img($v['PicPath_0'], '240x240');
                            $name=$v['Name'.$c['lang']];
                    ?>
                        <div class="item fl <?=$k%4==0?'i_nor':'';?> <?=$k<4?'i_top':'';?>">
                            <div class="pic"><a href="<?=$url;?>" <?=$c['config']['global']['PNew'] ? "target='_blank'" : "";?> title="<?=$name;?>"><img src="<?=$img;?>" title="<?=$name;?>" alt="<?=$name;?>" /><span></span></a></div>
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
                    <?php }?>
                    <div class="clear"></div>
                </div>
                <?php if($c['config']['global']['IsReview']){?>
                <div class="dm">
                    <div class="nav fl cur"><span class="review_t"></span></div>
                    <div class="clear"></div>
                </div>
                <div class="db">
                    <div class="con cur"><?php include("{$c['static_path']}/inc/products/review.php");?></div>
                </div>
                <?php }?>
                <div class="clear"></div>
            </div>
        </div>
        <div class="blank25"></div>
        <div class="clear"></div>
    </div>
</div>
<?php include("{$c['theme_path']}/inc/footer.php");?>
</body>
</html>