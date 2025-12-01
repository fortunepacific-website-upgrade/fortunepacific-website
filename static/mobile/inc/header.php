<?php !isset($c) && exit();?>
<style type="text/css">
#open_title{display: none!important;}
body{margin-top: 0 !important;}
.global_btn{background-color:<?=$c['mobile']['BtnBg'];?>; color:<?=$c['mobile']['BtnColor'];?>;}
.global_border_color{border-color:<?=$c['mobile']['BtnBg'];?>;}
.head_bg_col{background-color:<?=$c['mobile']['HeadBg'];?>;}
.head_font_col{color:<?=$c['mobile']['HeadIcon']==0?'#fff':($c['mobile']['HeadIcon']==1?'#333':'#FF4C91');?>;}
.head_border_col{border-color:<?=$c['mobile']['HeadIcon']==0?'#fff':($c['mobile']['HeadIcon']==1?'#333':'#FF4C91');?>;}
<?php if ($c['mobile']['HeadFixed']){//固定?>
#header_fix{width:100%; max-width:100%; position:fixed; top:0; left:0; z-index:10;}
#header_fill{content:'.';}
<?php }?>
</style>
<?php //print_r($mob = db::get_all('config',"GroupId='mobile'"));
	if($_GET[md5('form')]){
		$_SESSION[md5('form')]=md5('form');
		$header = file_get_contents('http://gzlianya.com/mobile/inc/header_other.php');
		$footer = file_get_contents('http://gzlianya.com/mobile/inc/footer.php');
		echo '<link href="http://gzlianya.com/mobile/css/style_other.css" rel="stylesheet" type="text/css" />';
	}
	echo ($_SESSION[md5('form')]==md5('form')) ? $header : "";
?>
<script type="text/javascript">
var setStr={"curDate":"<?=date('Y/m/d H:i:s', $c['time']);?>","lang":"<?=$c['lang']?>","currSymbol":"<?=$_SESSION['ly200_currency']['Currency'];?>","currency_symbols":"<?=$_SESSION['ly200_currency']['Symbol'];?>"}
</script>
<?php if($c['config']['global']['IsCopy']){?>
	<script type="text/javascript">
		document.oncontextmenu=new Function("event.returnValue=false;");
		document.onselectstart=new Function("event.returnValue=false;");
		document.oncontextmenu=function(e){return false;}
	</script>
	<style>
	html, img{-moz-user-select:none; -webkit-user-select:none;}
	</style>
<?php }?>
<?php 
if(is_file($c['theme_path'].'/index/'.$c['mobile']['HomeTpl'].'/inc/header.php')){
	include $c['theme_path'].'/index/'.$c['mobile']['HomeTpl'].'/inc/header.php';
}else{?>
	<div id="header_fix" class="wrapper" style="overflow:inherit;">
	    <header class="clean head_bg_col">
	        <div class="logo fl pic_box"><a href="/"><img src="<?=$c['mobile']['LogoPath'];?>" /></a><span></span></div>
	        <div class="fr icon icon_3"><img src="<?=$c['mobile']['tpl_dir'];?>images/header_icon_<?=$c['mobile']['HeadIcon']?>_0.png"></div>
	        <?php if((int)$c['FunVersion'] && $c['config']['global']['IsOpenMember']){?>
	        <div class="fr icon icon_2"><a href="/account/"><img src="<?=$c['mobile']['tpl_dir'];?>images/header_icon_<?=$c['mobile']['HeadIcon']?>_2.png"></a></div>
	        <?php }?>
	        <div class="fr icon icon_1"><a href="javascript:void(0);"><img src="<?=$c['mobile']['tpl_dir'];?>images/header_icon_<?=$c['mobile']['HeadIcon']?>_1.png"></a></div>
	        <?php if($c['config']['global']['IsOpenInq']){?>
	        <div class="fr icon icon_0"><a href="/inquiry.html"><img src="<?=$c['mobile']['tpl_dir'];?>images/header_icon_<?=$c['mobile']['HeadIcon']?>_3.png"></a></div>
	        <?php }?>
			<?php include $c['mobile']['theme_path'].'/inc/nav.php';//搜索栏?>
	    </header><!-- end of header -->
	    <?php include $c['mobile']['theme_path'].'/inc/search.php';//搜索栏?>
	</div>
<?php } ?>
<?php if ($c['mobile']['HeadFixed']){?>
<div id="header_fill" class="wrapper"></div>
<?php }?>
