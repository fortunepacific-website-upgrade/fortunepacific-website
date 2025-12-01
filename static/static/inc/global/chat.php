<?php !isset($c) && exit();?>
<?php
	$IsFooter = db::get_value('config',"Variable='Is_footer_feedback'","Value");
	$footer_bg = db::get_value('config',"Variable='FooterColor'","Value");
	$_SESSION['feedback_time'] = md5(microtime());
	if($IsFooter){
?>
<div id="footer_feedback" class="up">
	<div class="title" style=" background:#<?=$footer_bg?>;">
    	<?=$c['lang_pack']['chat']['title']?>
        <a class="close" href="javascript:void(0);"></a>
    </div>
	<div id="lib_feedback_form">
        <form method="post" name="feedback">
            <div class="demo">
                <div class="blank6"></div>
                <div class="tips_title"><?=$c['lang_pack']['chat']['name']?><font color="red">*</font>:</div>
                <div class="blank6"></div>
                <input type="text" class="text" name="Name" placeholder="<?=$c['lang_pack']['chat']['name_tips']?>" notnull />
                <div class="blank15"></div>
                <div class="tips_title"><?=$c['lang_pack']['chat']['email']?><font color="red">*</font>:</div>
                <div class="blank6"></div>
                <input type="text" class="text" name="Email" placeholder="<?=$c['lang_pack']['chat']['email_tips']?>" notnull />
                <div class="blank15"></div>
                <div class="tips_title"><?=$c['lang_pack']['chat']['got']?><font color="red">*</font>:</div>
                <div class="blank6"></div>
                <textarea class="text" name="Message" placeholder="<?=$c['lang_pack']['chat']['got_tips']?>" notnull></textarea>
                <div class="blank15"></div>
                <input type="hidden" name="float" value="<?=$_SESSION['feedback_time'];?>" />
                <input type="submit" class="send" value="<?=$c['lang_pack']['chat']['send']?>" style=" background:#<?=$footer_bg?>;" />
                <input type="hidden" name="Site" value="<?=trim($c['lang'],'_');?>" />
            </div>
        </form>
    </div>
</div>
<?php }?>


<?php
$nl_set = $c['config']['global']['NewsletterSet'];
$nl_set_open = $nl_set[0];
$nl_set_seconds = (int)$nl_set[1]?(int)$nl_set[1]*1000:0;
$nl_set_bg = $nl_set[2];
if($c['FunVersion'] && $nl_set_open && !$_SESSION['subsPop']){
	$_SESSION['subsPop']=1;
?>
<div id="newsletter_pop">
	<div class="close_btn"><span><img src="/static/images/global/ns_pop_close.png" alt=""></span></div>
	<div class="main_img"><img src="/static/images/global/ns_pop_main.png" alt=""></div>
	<div class="title"><?=$nl_set['Title']['Title'.$c['lang']]?$nl_set['Title']['Title'.$c['lang']]:$c['lang_pack']['newsletter_t0']?></div>
	<div class="brief"><?=$nl_set['BriefDescription']['BriefDescription'.$c['lang']]?></div>
	<form class="newsletter_form" id="pop_newsletter_form">
		<input type="text" class="text" name="Email" format="Email" notnull placeholder="<?=$c['lang_pack']['letter_text'];?>" />
		<input type="submit" class="sub" value="<?=$c['lang_pack']['newsletter_button'];?>" />
		<div class="clear"></div>
	</form>
</div>
<div class="newsletter_mask"></div>
<script>
	$(function(){
		setTimeout(function(){
			$("#newsletter_pop,.newsletter_mask").addClass("show");
		},<?=$nl_set_seconds;?>);
		$("#newsletter_pop .close_btn span").click(function(){
			$("#newsletter_pop,.newsletter_mask").removeClass("show");
		});
	});
</script>
<?php }?>