<?php !isset($c) && exit();?>
<?php
$where = $c['where']['products'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="msvalidate.01" content="4316C9E5FB815368E618ED003BF90DDF" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<?=web::seo_meta();?>
<?php include("{$c['static_path']}/inc/static.php");?>
<?=ly200::load_static('/static/themes/'.$c['themes'].'/css/index.css');?>
</head>
<body class="lang<?=$c['lang'];?>">
<?php include("{$c['theme_path']}/inc/header.php");?>
<div class="blank20"></div>
<div id="int" class="min">
	<div class="wrap">
    	<div class="intl fl"><?php include("{$c['theme_path']}/inc/in_cate.php");?></div>
        <div id="banner" class="fr"><?=ly200::ad(1);?></div>
        <div class="clear"></div>
    </div>
</div>
<div id="inm" class="min">
	<div class="wrap">
    	<div class="inml fl">
        	<div class="in_sign">
            	<a class="more fr" href="/products/"><?=$c['lang_pack']['more'];?>+</a>
                <?=$c['lang_pack']['feat'];?> <?=$c['lang_pack']['cate'];?>
            </div>
            <div class="box">
            	<?php
					$in_cate = db::get_limit('products_category','IsIndex=1','*',$c['my_order'].'CateId asc',0,4);
					foreach((array)$in_cate as $k => $v){
						$img = $v['PicPath'];
						$name = $v['Category'.$c['lang']];
						$url = web::get_url($v,'products_category');
				?>
                	<div class="list fl">
                    	<div class="pic">
                        	<a href="<?=$url;?>" title="<?=$name;?>"><img src="<?=$img;?>" title="<?=$naem;?>"  alt="<?=$name;?>" /><span></span></a>
                        </div>
                        <div class="name"><h3><a href="<?=$url;?>" title="<?=$name;?>"><?=$name;?></a></h3></div>
                        <?php
							$sec_cate = db::get_limit('products_category',"UId='0,{$v['CateId']},'",'*',$c['my_order'].'CateId asc',0,4);
							foreach((array)$sec_cate as $kk => $vv){
								$c_name = $vv['Category'.$c['lang']];
								$c_url = web::get_url($vv,'products_category');
						?>
                        	<div class="row"><h3><a href="<?=$c_url;?>" title="<?=$c_name;?>"><?=$c_name;?></a></h3></div>
                        <?php }?>
                    </div>
                <?php }?>
                <div class="blank20"></div>
                <div class="ad">
                	<?php
                    	$in_ad = ly200::ad_custom(2);
						for($i=0;$i<2;$i++){
							$url = $in_ad['Url'][$i];
							$img = $in_ad['PicPath'][$i];
							$name = $in_ad['Title'][$i];
					?>
                    	<div class="a_list <?=$i==0?'fl':'fr';?>">
                        	<?php if($url){?><a href="<?=$url;?>" target="_blank"><?php }?>
                            	<img class="delay" src="<?=$img;?>" title="<?=$name;?>" alt="<?=$name;?>" /><span></span>
                            <?php if($url){?></a><?php }?>
                        </div>
                    <?php }?>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <div class="inmr fr">
        	<?php include("{$c['theme_path']}/inc/pop.php");?>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div id="inb" class="min">
	<div class="wrap">
    	<div class="in_sign"><?=$c['lang_pack']['new'];?> <?=$c['lang_pack']['products'];?></div>
        <div class="box">
        	<?php
				$in_pro = db::get_limit('products',$where.' and IsNew=1','*',$c['my_order'].'ProId desc',0,10);
				foreach((array)$in_pro as $k => $v){
					$url=web::get_url($v, 'products');
					$img=img::get_small_img($v['PicPath_0'], '240x240');
					$name=$v['Name'.$c['lang']];
					$brief=$v['BriefDescription'.$c['lang']];
			?>
				<div class="item in_item fl <?=$k%5==0?'i_nor':'';?> <?=$k<5?'i_top':'';?>">
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
    </div>
</div>
<div class="blank25"></div>
<?php include("{$c['theme_path']}/inc/footer.php");?>
</body>
</html>