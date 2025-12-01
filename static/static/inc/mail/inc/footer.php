<?php !isset($c) && exit();?>
<div style="padding:20px 0; line-height:180%; font-family:Arial; font-size:12px; color:#000; border-top:1px solid #ccc; border-bottom:1px solid #ccc;">
	<?=str_replace('%domain%', web::get_domain(0), $c['lang_pack_email']['footer_0']);?><br />
	<?=str_replace('%domain%', '<a href="'.web::get_domain().'" target="_blank" style="font-family:Arial; font-size:12px; color:#1E5494; text-decoration:underline;">'.web::get_domain().'</a>', $c['lang_pack_email']['footer_1']);?>
</div>