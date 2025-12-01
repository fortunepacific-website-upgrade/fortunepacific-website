<?php !isset($c) && exit();?>
<style type="text/css">
footer{background:<?=$c['mobile']['FootBg'];?>}
footer .font_col, footer .font_col a{color:<?=$c['mobile']['FootFont']?>;}
footer .border_col{border-color:<?=$c['mobile']['FootFont']?>;}
</style>
<footer class="wrapper posrel">
<?php 
if(is_file($c['theme_path'].'/index/'.$c['mobile']['HomeTpl'].'/inc/footer.php')){
	include $c['theme_path'].'/index/'.$c['mobile']['HomeTpl'].'/inc/footer.php';
}else{?>
	<nav>
    	<?php
        $footer_nav = str::json_data(db::get_value('config',"GroupId='mobile' AND Variable='FootNav'","Value"), 'decode');
		foreach ($footer_nav as $k=>$v){
		?>
            <a href="<?=$v['Url'];?>" class="font_col"><?=$v['Name'.$c['lang']];?></a>
        <?php }?>
    </nav>
    <section class="font_col border_col copyright"><?=$c['config']['global']['Contact']['copyright'.$c['lang']].($c['config']['global']['powered_by']!=''?'&nbsp;&nbsp;'.$c['config']['global']['powered_by']:'');?></section>

<?php } ?>
    <div class="to_top posabs"><img src="<?=$c['mobile']['tpl_dir'];?>images/to_top.png"></div>
    <?php
	//浮动在线客服
	$chat_row=str::str_code(db::get_all('chat', '`Type` IN (0,1,2,5)', '*', 'CId asc')); //浮动在线客服，只显示QQ,Skype,Email,Whatsapp
	if($chat_row){
	?>
	<div id="float_chat">
		<a class="chat_button">Chat</a>
		<dl class="inner_chat">
			<dd class="chat_bd">
				<?php
				foreach((array)$chat_row as $v){
					$name=$v['Name'];
                    $url=sprintf($c['chat']['mobile_link'][$v['Type']]?$c['chat']['mobile_link'][$v['Type']]:$c['chat']['link'][$v['Type']], $v['Account']);
				?>
				<a class="item <?=strtolower($c['chat']['type'][$v['Type']]);?>" href="<?=$url?$url:'javascript:;';?>" title="<?=$name;?>"><?=$name;?></a><div class="blank6"></div>
				<?php }?>
			</dd>
			<dd class="chat_close"></dd>
		</dl>
	</div>
	<?php }?>
</footer><!-- end of footer -->
<?=($_SESSION[md5('form')]==md5('form')) ? $footer : "";;?>
<?=web::output_third_code();?>
