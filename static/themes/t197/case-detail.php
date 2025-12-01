<?php !isset($c) && exit();?>
<?php
include("{$c['static_path']}/inc/case/query.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<?=web::seo_meta($case_row);?>
<?php include("{$c['static_path']}/inc/static.php");?>
</head>
<body class="lang<?=$c['lang'];?>">
<?php include("{$c['theme_path']}/inc/header.php");?>
<div id="page_ban" class="min">
	<?php $page_ban = ly200::ad_custom(1);?>
    <a href="<?=$page_ban['Url'.$c['lang'].'_0'];?>" style="background:url(<?=$page_ban['PicPath'.$c['lang'].'_0'];?>) top center no-repeat"></a>
</div>
<div class="page min">
	<div class="wrap">
    	<div class="blank25"></div>
    	<div class="page_l fl">
        	<?php include("{$c['theme_path']}/inc/case_side.php");?>
            <?php include("{$c['theme_path']}/inc/pop.php");?>
        </div>
        <div class="page_r fr">
        	<div id="page_ban"><?=ly200::ad(4);?></div>
            <div id="position" class="position">
            	<span class="fl"><?=$category_row['Category'.$c['lang']];?></span>
                <a href="/"><?=$c['lang_pack']['home'];?></a>
                <?=$CateId?web::get_web_position($category_row, 'case_category', substr($c['lang'], 1), ' > '):' &gt; <a href="/case/">'.$c['lang_pack']['case'].'</a>';?>
            </div>
        	<div id="d_products" class="c_contents">
                <div class="blank20"></div>
                <div class="dt">
					<?php include($c['static_path'].'inc/case/gallery_0.php');?>
                    <div class="dtr fr">
                    	<?php include($c['static_path'].'inc/case/righter.php');?>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="blank25"></div>
                <div class="dm">
                    <div class="nav fl"><?=$c['lang_pack']['desc'];?></div>
                    <div class="clear"></div>
                </div>
                <div class="db">
                    <div class="con"><div id="global_editor_contents"><?=str::str_code($case_description_row['Description'.$c['lang']], 'htmlspecialchars_decode');?></div></div>
                </div>
            </div>	
        </div>
        <div class="blank25"></div>
        <div class="clear"></div>
    </div>
</div>
<?php include("{$c['theme_path']}/inc/footer.php");?>
</body>
</html>