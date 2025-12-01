<?php !isset($c) && exit();?>
<?php
ob_start();
$c['lang_pack_email']=include('lang/'.substr($c['lang'], 1).'.php');//加载语言包

$backUrl=web::get_domain().'/account/sign-up.html?uniqueid='.str::rand_code(30).'&userType=2&UserId='.$UserId.'&userTypeBase=Reseller';
?>
<div style="width:700px; margin:10px auto;">
	<?php include('inc/header.php');?>
	<div style="font-family:Arial; padding:15px 0; line-height:150%; min-height:100px; _height:100px; color:#333; font-size:12px;">
		<?=str_replace('%name%', '<strong>'.htmlspecialchars($_SESSION['User']['FirstName'].' '.$_SESSION['User']['LastName']).'</strong>', $c['lang_pack_email']['dear']);?>:<br /><br />

        <?=str_replace('%domain%', '<a href="'.web::get_domain().'" target="_blank" style="color:#1E5494; text-decoration:underline; font-family:Arial; font-size:12px;">'.web::get_domain(0).'</a>', $c['lang_pack_email']['not_reply']);?><br /><br />
        <?=str_replace('%domain%', web::get_domain(0), $c['lang_pack_email']['thanks']);?><br /><br />
        
        <?=str_replace('%url%', $backUrl, $c['lang_pack_email']['validateInfo_1']);?><br />
		<?=$c['lang_pack_email']['validateDetail'];?><br />
		<a href="<?=$backUrl;?>" target="_blank" style="text-decoration:underline;"><?=$backUrl;?></a><br /><br /><br />
		
		
		<?=str_replace('%url%', ($c['config']['global']['ContactUrl']?$c['config']['global']['ContactUrl']:'javascript:;'), $c['lang_pack_email']['validateInfo_2']);?><br /><br />
        
        <?=$c['lang_pack_email']['sincerely'];?>,<br /><br />
        
        <?=str_replace('%domain%', web::get_domain(0), $c['lang_pack_email']['customer']);?>
	</div>
	<?php include('inc/footer.php');?>
</div>
<?php
$mail_contents=ob_get_contents();
ob_end_clean();
?>