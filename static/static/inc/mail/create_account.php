<?php !isset($c) && exit();?>
<?php
ob_start();
$c['lang_pack_email']=include('lang/'.substr($c['lang'], 1).'.php');//加载语言包
?>
<div style="width:700px; margin:10px auto;">
	<?php include('inc/header.php');?>
	<div style="font-family:Arial; padding:15px 0; line-height:150%; min-height:100px; _height:100px; color:#333; font-size:12px;">
    <?=str_replace('%name%', '<strong>'.htmlspecialchars($_SESSION['ly200_user']['FirstName'].' '.$_SESSION['ly200_user']['LastName']).'</strong>', $c['lang_pack_email']['dear']);?>:<br /><br />
	<?=str_replace('%domain%', '<a href="'.web::get_domain().'" target="_blank" style="color:#1E5494; text-decoration:underline; font-family:Arial; font-size:12px;">'.web::get_domain(0).'</a>', $c['lang_pack_email']['not_reply']);?>.<br /><br />
    <?=str_replace('%domain%', web::get_domain(0), $c['lang_pack_email']['thanks']);?><br /><br />
        
        <?=$c['lang_pack_email']['createTitle']; ?>:<br />
        -------------------------------------------------------------------------------------------<br />
        <div style="height:24px; line-height:24px; clear:both;">
            <div style="float:left; width:92px;"><?=$c['lang_pack_email']['yUsername']; ?></div>
            <div style="float:left; width:400px;">: <?=htmlspecialchars($_SESSION['ly200_user']['FirstName'].' '.$_SESSION['ly200_user']['LastName']);?></div>
        </div>
        <div style="height:24px; line-height:24px; clear:both;">
            <div style="float:left; width:92px;"><?=$c['lang_pack_email']['yEmail']; ?></div>
            <div style="float:left; width:400px;">: <?=htmlspecialchars($_SESSION['ly200_user']['Email']);?></div>
        </div>
        <div style="height:24px; line-height:24px; clear:both;">
            <div style="float:left; width:92px;"><?=$c['lang_pack_email']['yPassword']; ?></div>
            <div style="float:left; width:400px;">: ********</div>
        </div><br /><br />
        
        <?=$c['lang_pack_email']['copy_paste']; ?>:<br />
        <a href="<?=web::get_domain();?>" target="_blank" style="font-family:Arial; color:#1E5494; text-decoration:underline; font-size:12px;"><strong><?=web::get_domain();?></strong></a><br /><br />
        
        <?=$c['lang_pack_email']['sincerely']; ?>,<br /><br />
        
        <?=str_replace('%domain%', web::get_domain(0), $c['lang_pack_email']['customer']);?>
	</div>
	<?php include('inc/footer.php');?>
</div>
<?php
$mail_contents=ob_get_contents();
ob_end_clean();
?>