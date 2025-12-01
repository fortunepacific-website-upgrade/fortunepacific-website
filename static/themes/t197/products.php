<?php !isset($c) && exit();?>
<?php
$page_count=100;//显示数量
include("{$c['static_path']}/inc/products/query.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<?=web::seo_meta($category_row);?>
<?php include("{$c['static_path']}/inc/static.php");?>
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
            	<span class="fl"><?=$Column;?></span>
                <a href="/"><?=$c['lang_pack']['home'];?></a>
                <?=$CateId?web::get_web_position($category_row, 'products_category', substr($c['lang'], 1), ' > '):' &gt; <a class="po_cur" href="/products/">'.$c['lang_pack']['products'].'</a>';?>
            </div>
        	<div id="products" class="c_contents">
				<?php include("{$c['static_path']}/inc/products/no_products_0.php");?>
                <?php
                	foreach((array)$products_list_row[0] as $k => $v){
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
            <?php if($products_list_row[3]){?>
            	<div class="blank25"></div>
                <div id="turn_page"><?=html::turn_page_html($products_list_row[1], $products_list_row[2], $products_list_row[3], $no_page_url, "&nbsp;","&nbsp;");?></div>
            <?php }?>
        </div>
        <div class="blank25"></div>
        <div class="clear"></div>
    </div>
</div>
<?php include("{$c['theme_path']}/inc/footer.php");?>
</body>
</html>