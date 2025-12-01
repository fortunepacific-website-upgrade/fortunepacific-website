<?php !isset($c) && exit();?>
<?php
ob_start();
$c['lang_pack_email']=include('lang/'.substr($c['lang'], 1).'.php');//加载语言包
?>
<div style="width:700px; margin:10px auto;">
	<?php include('inc/header.php');?>
	<div style="font-family:Arial; padding:15px 0; line-height:150%; min-height:100px; _height:100px; color:#333; font-size:12px;">
        <?=str_replace('%name%', '<strong>'.htmlspecialchars($fullname).'</strong>', $c['lang_pack_email']['dear']);?>:<br /><br />
        <?=str_replace('%domain%', '<a href="'.web::get_domain().'" target="_blank" style="color:#1E5494; text-decoration:underline; font-family:Arial; font-size:12px;">'.web::get_domain(0).'</a>', $c['lang_pack_email']['not_reply_pwd']);?><br /><br />
        
        <strong><?=str_replace('%domain%', '<a href="'.web::get_domain().'" target="_blank" style="color:#1E5494; text-decoration:underline; font-family:Arial; font-size:12px;">'.web::get_domain(0).'</a>', $c['lang_pack_email']['steps']);?>:</strong><br /><br />
        
        <div style="font-family:Arial; line-height:180%; padding-left:20px;">1)&nbsp;&nbsp;<?=$c['lang_pack_email']['pwdInfo_0']; ?><br /><a href="<?=web::get_domain();?>/account/forgot.html?&email=<?=urlencode($EmailEncode);?>&expiry=<?=urlencode($Expiry);?>" target="_blank" style="color:#1E5494; text-decoration:underline; font-family:Arial; font-size:12px;"><?=web::get_domain();?>/account/forgot.html?&amp;email=<?=urlencode($EmailEncode);?>&amp;expiry=<?=urlencode($Expiry);?></a></div><br />
        <div style="font-family:Arial; line-height:180%; padding-left:20px;">2)&nbsp;&nbsp;<?=$c['lang_pack_email']['pwdInfo_1']; ?></div><br />
        <?=$c['lang_pack_email']['queries']; ?><br /><br />
        <?=$c['lang_pack_email']['sincerely']; ?>,<br /><br />
        <?=str_replace('%domain%', web::get_domain(0), $c['lang_pack_email']['customer']);?>
	</div>
	<?php include('inc/footer.php');?>
</div>
<?php
$mail_contents=ob_get_contents();
ob_end_clean();
?>