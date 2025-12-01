<?php !isset($c) && exit();?>
<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/
$userType=(int)$_GET['userType'];
if($userType){
	$UserId=(int)$_GET['UserId'];
	$user_row=str::str_code(db::get_one('user', "UserId='{$UserId}'"));
	if($userType==2 && $user_row && !(int)$user_row['Status']){//邮件验证成功
		$data=array();
		$_SESSION['ly200_user']=$user_row;
		$_SESSION['ly200_user']['UserId']=$UserId;
		$user_row['Status']=$data['Status']=1;
		db::update('user', "UserId='$UserId'", $data);
		user::operation_log($UserId, '会员注册');
		include($c['static_path'].'/inc/mail/create_account.php');
		ly200::sendmail($user_row['Email'], 'Welcome to '.web::get_domain(0), $mail_contents);
		js::location('/account/');
	}
}else{
	$jumpUrl=$_POST['jumpUrl']?$_POST['jumpUrl']:$_GET['jumpUrl'];
	$jumpUrl=='' && $jumpUrl=$_SERVER['HTTP_REFERER'];	//进入登录页面之前的页面
	if($jumpUrl){
		$_SESSION['LoginReturnUrl']=$jumpUrl;
	}else{
		unset($_SESSION['LoginReturnUrl']);
	}
	$reg_ary=str::json_data(db::get_value('config', "GroupId='user' and Variable='RegSet'", 'Value'), 'decode');
	$set_row=str::str_code(db::get_all('user_reg_set', '1', '*', "{$c[my_order]} SetId asc"));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?=web::seo_meta();?>
<?php include("{$c['static_path']}/inc/static.php");?>
<?=ly200::load_static('/static/js/plugin/daterangepicker/daterangepicker.css', '/static/js/plugin/daterangepicker/moment.min.js', '/static/js/plugin/daterangepicker/daterangepicker.js');?>
<script type="text/javascript">
$(document).ready(function(){
	account_obj.sign_in_init();
	account_obj.sign_up_init();
});
</script>
</head>

<body class="lang<?=$c['lang'];?>">
<div id="customer">
	<?php include($c['static_path']."/inc/user/inc/header.php");?>
    <div id="signup">
        <form class="register fl">
            <h3 class="title"><?=$c['lang_pack']['user']['register']['reg_account'];?></h3>
            <div class="clear"></div>
            <div id="error_register_box" class="error_note_box"></div>
            <div class="clear"></div>
            <?php
            if($reg_ary['Name'][0]){
            ?>
            <div class="row fl">
                <label for="FirstName"><?=$c['lang_pack']['user']['f_name'];?><?=$reg_ary['Name'][1]?' <span class="fc_red">*</span>':'';?></label>
                <input name="FirstName" id="FirstName" class="lib_txt" type="text" size="30" maxlength="20"<?=$reg_ary['Name'][1]?' notnull':'';?> />
            </div>
            <div class="row fl">
                <label for="LastName"><?=$c['lang_pack']['user']['l_name'];?><?=$reg_ary['Name'][1]?' <span class="fc_red">*</span>':'';?></label>
                <input name="LastName" id="LastName" class="lib_txt" type="text" size="30" maxlength="20"<?=$reg_ary['Name'][1]?' notnull':'';?> />
            </div>
            <div class="clear"></div>
            <?php }?>
            <div class="row">
                <label for="Email"><?=$c['lang_pack']['user']['email'];?> <span class="fc_red">*</span></label>
                <input name="Email" id="Email" class="lib_txt" type="text" size="40" maxlength="100" format="Email" notnull />
                <p class="on_error"><?=$c['lang_pack']['user']['register']['tips1'];?></p>
            </div>
            <div class="row">
                <label for="Password"><?=$c['lang_pack']['user']['register']['create_pass'];?> <span class="fc_red">*</span></label>
                <input name="Password" id="Password" class="lib_txt" type="password" size="40" notnull />
                <p class="on_error"><?=$c['lang_pack']['mobile']['at_6_char'];?></p>
            </div>
            <div class="row">
                <label for="Password2"><?=$c['lang_pack']['user']['con_password'];?> <span class="fc_red">*</span></label>
                <input name="Password2" id="Password2" class="lib_txt" type="password" size="40" notnull />
                <p class="on_error"><?=$c['lang_pack']['user']['register']['match_pass'];?></p>
            </div>
            <div class="clear"></div>
            <?php
            foreach((array)$reg_ary as $k=>$v){
                if($k=='Name' || $k=='Email' || !$v[0] || !isset($v[1])) continue;
				$k=='Birthday' && $value_ary['Birthday']=$c['time'];
            ?>
            <div class="row">
                <label for="<?=$k?>"><?=$menuLang[trim($c['lang'])][$k];?><?=$c['lang_pack']['user'][$k];?> <?=$v[1]?'<span class="fc_red">*</span>':'';?></label>
                <?=user::user_reg_edit($k, $v[1], 'lib_txt', $value_ary);?>
            </div>
            <?php
            }
            foreach((array)$set_row as $k=>$v){
            ?>
            <div class="row">
                <label for="<?=$v['Name'.$c['lang']]?>"><?=$v['Name'.$c['lang']]?></label>
                <?php
                if($v['TypeId']){
                    echo html::form_select(explode("\r\n", $v['Option'.$c['lang']]), "Other[{$v['SetId']}]", '');
                }else{
                    echo user::form_edit('', 'text', "Other[{$v['SetId']}]", 30, 50, 'class="lib_txt"');
                }
                ?>
            </div>
            <?php }?>
            <dl class="intro">
            	<?php 
					$RegTips=str::json_data(htmlspecialchars_decode($c['config']['global']['RegTips']), 'decode');
					$result = @explode('!-~',$RegTips['regtips'.$c['lang']]);
					foreach($result as $k => $v){
						echo !$k ? "<dt>$v</dt>" : "<dd>$v</dd>";	
					}
				?>
            </dl>
            <div class="row"><button class="signbtn signup NavBgColor" type="submit"><?=$c['lang_pack']['user']['register']['creat_account'];?></button></div>
            <input type="hidden" name="jumpUrl" value="<?=$jumpUrl;?>" />
        </form>
        <?php include($c['static_path']."/inc/user/inc/rightside.php");?>
        <div class="blank20"></div>
    </div>
    <?php include($c['static_path']."/inc/user/inc/footer.php");?>
</div>
</body>
</html>
