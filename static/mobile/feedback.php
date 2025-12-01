<?php !isset($c) && exit();?>
<?php
$_SESSION['Global']['v_code'][md5('feedback')] = 'ly200';
$mess_ary=str::json_data(db::get_value('config', "GroupId='message' and Variable='MessSet'", 'Value'), 'decode');
?>
<!DOCTYPE HTML>
<html lang="us">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta content="telephone=no" name="format-detection" />
<?=web::seo_meta();?>
<?php include $c['mobile']['theme_path'].'/inc/resource.php';?>
<?=ly200::load_static($c['mobile']['tpl_dir'].'js/feedback.js');?>
<script type="text/javascript">$(function (){feedback_obj.feedback_init();})</script>
</head>

<body class="lang<?=$c['lang'];?>">
<?php include $c['theme_path'].'/inc/header.php';//头部 ?>

<div class="wrapper">
    <div class="page_title"><?=$c['lang_pack']['mobile']['feedback'];?></div>
    <div class="m_editAddr">
    	<form name="feedback" id="feedback_form">
        	<?php if($mess_ary['Fullname'][0]){?>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['mobile']['name'];?>: <?php if($mess_ary['Fullname'][1]){?><span class="font">*</span><?php }?></div>
                <div class="input clean">
                    <span class="input_span"><input type="text" class="form_input" name="Name" <?php if($mess_ary['Fullname'][1]){?>notnull<?php }?> /></span>
                </div>
            </div>
            <?php }?>
            <?php if($mess_ary['Company'][0]){?>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['mobile']['company'];?>: <?php if($mess_ary['Company'][1]){?><span class="font">*</span><?php }?></div>
                <div class="input clean">
                    <span class="input_span"><input type="text" class="form_input" name="Company" <?php if($mess_ary['Company'][1]){?>notnull<?php }?> /></span>
                </div>
            </div>
            <?php }?>
			<?php if($mess_ary['Phone'][0]){?>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['mobile']['phone'];?>: <?php if($mess_ary['Phone'][1]){?><span class="font">*</span><?php }?></div>
                <div class="input clean">
                    <span class="input_span"><input type="text" class="form_input" name="Phone" <?php if($mess_ary['Phone'][1]){?>notnull<?php }?> /></span>
                </div>
            </div>
            <?php }?>
	        <?php if($mess_ary['Mobile'][0]){?>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['mobile']['mobile'];?>: <?php if($mess_ary['Mobile'][1]){?><span class="font">*</span><?php }?></div>
                <div class="input clean">
                    <span class="input_span"><input type="text" class="form_input" name="Mobile" <?php if($mess_ary['Mobile'][1]){?>notnull<?php }?> /></span>
                </div>
            </div>
            <?php }?>
	        <?php if($mess_ary['Email'][0]){?>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['mobile']['email'];?>: <?php if($mess_ary['Email'][1]){?><span class="font">*</span><?php }?></div>
                <div class="input clean">
                    <span class="input_span"><input type="email" class="form_input" name="Email" <?php if($mess_ary['Email'][1]){?>notnull<?php }?> /></span>
                </div>
            </div>
            <?php }?>
			<?php if($mess_ary['Subject'][0]){?>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['mobile']['subject'];?>: <?php if($mess_ary['Subject'][1]){?><span class="font">*</span><?php }?></div>
                <div class="input clean">
                    <span class="input_span"><input type="text" class="form_input" name="Subject" <?php if($mess_ary['Subject'][1]){?>notnull<?php }?> /></span>
                </div>
            </div>
            <?php }?>
            <?php if($mess_ary['Message'][0]){?>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['mobile']['message'];?>: <?php if($mess_ary['Message'][1]){?><span class="font">*</span><?php }?></div>
                <div class="input clean">
                    <span class="input_span"><textarea name="Message" class="form_input input_area" <?php if($mess_ary['Message'][1]){?>notnull<?php }?>></textarea></span>
                </div>
            </div>
            <?php }?>
            <div class="addr_row">
            	<div class="form_laber"><?=$c['lang_pack']['review']['vcode']; ?>: <span class="font">*</span></div>
                <div class="input clean">
                    <span class="input_span"><input name="VCode" type="text" class="form_input vcode" size="4" maxlength="4" notnull /><br /></span>
                    <?=v_code::create('feedback');?>
                </div>
            </div>
            <div class="addr_row">
                <div class="input clean">
                    <span class="input_btn global_btn global_button" id="sub_btn"><?=$c['lang_pack']['mobile']['submit'];?></span>
                </div>
            </div>
            <input type="hidden" name="Site" value="<?=substr($c['lang'], 1);?>" />
        </form>
    </div><!-- end of .m_editAddr -->
</div><!-- end of .wrapper -->

<?php include $c['theme_path'].'/inc/footer.php';//底部?>
</body>
</html>