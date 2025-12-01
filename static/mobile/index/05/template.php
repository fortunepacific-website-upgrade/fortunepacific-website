<?php !isset($c) && exit();?>
<?php
$ad_row = ly200::ad_custom(1);
?>
<div class="wrapper">
	<div class="home_bg" style="background-image:url(<?=$ad_row['PicPath'][0];?>);">
    	<div class="box clean">
        	<a class="fl item" href="/catalog/">
            	<div class="icon0 icon"></div>
                <div class="name"><?=$c['lang_pack']['mobile']['find_pro'];?></div>
            </a>
            <a class="fr item" href="/info/">
            	<div class="icon1 icon"></div>
                <div class="name"><?=$c['lang_pack']['mobile']['news'];?></div>
            </a>
            <?php $row = db::get_one('article', "CateId='1'", "AId,CateId,Title{$c['lang']},Url,PageUrl", $c['my_order']."AId desc");?>
            <a class="fl item" href="<?=web::get_url($row, 'article');?>">
            	<div class="icon2 icon"></div>
                <div class="name"><?=$c['lang_pack']['mobile']['about_us'];?></div>
            </a>
            <?php $row = db::get_one('article', "CateId='2'", "AId,CateId,Title{$c['lang']},Url,PageUrl", $c['my_order']."AId desc");?>
            <a class="fr item" href="<?=web::get_url($row, 'article');?>">
            	<div class="icon3 icon"></div>
                <div class="name"><?=$c['lang_pack']['mobile']['contact_us'];?></div>
            </a>
        </div><!-- end of .box -->
    </div><!-- end of .home_bg -->
    
    <div class="home_menu">
    	<div class="i i0"><a href="mailto:<?=$c['config']['global']['Contact']['email'];?>"><?=$c['config']['global']['Contact']['email'];?></a></div>
    </div><!-- end of .home_menu -->
    
</div><!-- end of .wrapper -->
