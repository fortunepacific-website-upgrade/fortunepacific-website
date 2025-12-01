<?php !isset($c) && exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<?=web::seo_meta();?>
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
        	<div id="page_ban"><?=ly200::ad(8);?></div>
            <div id="position" class="position">
            	<span class="fl"><?=$c['lang_pack']['feedback'];?></span>
                <a href="/"><?=$c['lang_pack']['home'];?></a> > 
                <a class="po_cur" href="#"><?=$c['lang_pack']['feedback'];?></a>
            </div>
        	<div id="article" class="c_contents">
                <div class="con">
                	<?php include("{$c['static_path']}/inc/feedback/list.php");?>
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