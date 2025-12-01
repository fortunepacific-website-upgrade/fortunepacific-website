<?php !isset($c) && exit();?>
<?php 
include("{$c['static_path']}/inc/info/query.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<?=web::seo_meta($info_row);?>
<?php include("{$c['static_path']}/inc/static.php");?>
</head>
<body class="lang<?=$c['lang'];?>">
<?php include("{$c['theme_path']}/inc/header.php");?>
<div class="page min">
	<div class="wrap">
    	<div class="blank25"></div>
    	<div class="page_l fl">
        	<?php include("{$c['theme_path']}/inc/info_side.php");?>
            <?php include("{$c['theme_path']}/inc/pop.php");?>
        </div>
        <div class="page_r fr">
        	<div id="page_ban"><?=ly200::ad(7);?></div>
            <div id="position" class="position">
            	<span class="fl"><?=$info_category_row['Category'.$c['lang']];?></span>
                <a href="/"><?=$c['lang_pack']['home'];?></a> > 
                <?php if($CateId){?>
                    <a href="/info/"><?=$c['lang_pack']['news'];?></a> > 
                    <a class="po_cur" href="#"><?=$info_category_row['Category'.$c['lang']];?></a>
                <?php }else{?>
                	<a class="po_cur" href="/info/"><?=$c['lang_pack']['news'];?></a>
                <?php }?>
            </div>
        	<div id="d_info" class="c_contents">
                <?php include($c['static_path'].'inc/info/detail.php');?>
            </div>
        </div>
        <div class="blank25"></div>
        <div class="clear"></div>
    </div>
</div>
<?php include("{$c['theme_path']}/inc/footer.php");?>
</body>
</html>