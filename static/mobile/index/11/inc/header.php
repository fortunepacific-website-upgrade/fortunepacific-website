<?php !isset($c) && exit();?>
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<?php 
$head_account = 1;
echo ly200::load_static($c['mobile']['tpl_dir'].'index/'.$c['mobile']['HomeTpl'].'/css/global.css'); 
?>
<div id="header_fix" class="wrapper" style="overflow:inherit;">
    <header class="clean head_bg_col">
        <div class="logo pic_box"><a href="/"><img src="<?=$c['mobile']['LogoPath'];?>" /></a><span></span></div>
        <div class="fr icon icon_1"></div>
        <?php include $c['mobile']['theme_path'].'/inc/nav.php';?>
    </header><!-- end of header -->
    <?php include $c['mobile']['theme_path'].'/inc/search.php';//搜索栏?>
</div>