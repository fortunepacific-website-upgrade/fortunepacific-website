<?php !isset($c) && exit();?>
<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/
$email=$_GET['email'];
$expiry=$_GET['expiry'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?=web::seo_meta();?>
<?=ly200::load_static('/static/css/global.css', '/static/themes/'.$c['themes'].'/css/style.css', '/static/css/user.css', '/static/js/jquery-3.7.1.min.js', '/static/js/global.js', '/static/js/lang/'.substr($c['lang'], 1).'.js', '/static/js/user.js');?>
<script type="text/javascript">
$(document).ready(function(){
	account_obj.sign_in_init();
	account_obj.forgot_init();
});
</script>
</head>

<body>
<div id="customer">
	<?php include($c['static_path']."/inc/user/inc/header.php");?>
    <div id="signup">
        <form class="register fl">
            <h3 class="title"><?=$c['lang_pack']['user']['forgot']['reset_pass'];?></h3>
            <div class="clear"></div>
            <div id="error_register_box" class="error_note_box"></div>
            <div class="clear"></div>
            <?php if ($_GET['forgot_success']==1){?>
            	<dl class="intro">
                    <dd><?=$c['lang_pack']['user']['forgot']['tips1'];?></dd>
                </dl>
                <dl class="intro">
                	<dt><?=$c['lang_pack']['user']['forgot']['haven_email'];?></dt>
                    <dd><?=$c['lang_pack']['user']['forgot']['tips2'];?></dd>
                </dl>
                <a href="/" class="signbtn signup NavBgColor"><?=$c['lang_pack']['user']['forgot']['continue'];?></a>
            <?php }else if ($_GET['reset_success']==1){?>
            	<div class="forgot_tips">
                	<dl class="intro">
                        <dd><?=$c['lang_pack']['user']['forgot']['tips3'];?></dd>
                    </dl>
                    <input type="button" value="<?=$c['lang_pack']['user']['forgot']['sign_in'];?>" class="signbtn signup NavBgColor SignInButton" />
                </div>
            <?php }else if($email=='' || $expiry==''){?>
                <div class="row">
                    <label for="Email"><?=$c['lang_pack']['user']['forgot']['enter_email'];?></label>
                    <input name="Email" id="Email" class="lib_txt" type="text" autocomplete="off" size="40" maxlength="100" format="Email" notnull />
                    <p class="on_error"><?=$c['lang_pack']['user']['forgot']['tips4'];?></p>
                </div>
                
                <dl class="intro">
                    <dd><?=$c['lang_pack']['user']['forgot']['tips5'];?></dd>
                    <dd><?=$c['lang_pack']['user']['forgot']['tips6'];?></dd>
                </dl>
                <div class="row"><button class="signbtn signup NavBgColor fotgotbtn" type="button"><?=$c['lang_pack']['user']['forgot']['send_eamil'];?></button></div>
            <?php
            }else{
				!db::get_row_count('user_forgot', "EmailEncode='$email' and Expiry='$expiry' and IsReset=0") && ly200::js_location('/account/forgot.html');
			?>
                <div class="row">
                    <label for="Password"><?=$c['lang_pack']['user']['forgot']['new_password'];?></label>
                    <input name="Password" id="Password" class="lib_txt" autocomplete="off" type="password" size="40" notnull />
                </div>
                <div class="row">
                    <label for="Password2"><?=$c['lang_pack']['user']['con_password'];?></label>
                    <input name="Password2" id="Password2" class="lib_txt" autocomplete="off" type="password" size="40" notnull />
                    <p class="on_error"><?=$c['lang_pack']['user']['forgot']['tips7'];?></p>
                </div>
                <dl class="intro">
                    <dd><?=$c['lang_pack']['user']['forgot']['tips8'];?></dd>
                </dl>
                <div class="row"><button class="signbtn signup NavBgColor resetbtn" type="button"><?=$c['lang_pack']['submit']; ?></button></div>
                <input type="hidden" name="email" value="<?=htmlspecialchars($email);?>" />
                <input type="hidden" name="expiry" value="<?=htmlspecialchars($expiry);?>" />
            <?php }?>
        </form>
        <?php include($c['static_path']."/inc/user/inc/rightside.php");?>
        <div class="blank20"></div>
    </div>
	<?php include($c['static_path']."/inc/user/inc/footer.php");?>
</div>
</body>
</html>
