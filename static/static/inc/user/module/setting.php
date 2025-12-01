<?php !isset($c) && exit();?>
<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/
$regset_row=db::get_one('config', "GroupId='user' and Variable='RegSet'");
$reg_ary=str::json_data($regset_row['Value'], 'decode');
$set_row=str::str_code(db::get_all('user_reg_set', '1', '*', "{$c[my_order]} SetId asc"));
?>
<?=ly200::load_static('/static/js/plugin/daterangepicker/daterangepicker.css', '/static/js/plugin/daterangepicker/moment.min.js', '/static/js/plugin/daterangepicker/daterangepicker.js');?>
<h1 class="lib_user_title"><?=$c['lang_pack']['user']['setting']['my_account'];?></h1>
<div id="lib_user_setting">
	<h3><?=$c['lang_pack']['user']['setting']['change_pro'];?></h3>
	<form id="frm_profile" method="post" action="/account/">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr><th nowrap="nowrap"><?=$c['lang_pack']['user']['f_name'];?>:<span class="fc_red">*</span> </th>
				<td><input name="FirstName" class="form_input" type="text" size="40" maxlength="40" value="<?=$user_row['FirstName'];?>"<?=$reg_ary['Name'][1]?' notnull':'';?> /></td>
			</tr>
			<tr><th nowrap="nowrap"><?=$c['lang_pack']['user']['l_name'];?>:<span class="fc_red">*</span> </th>
				<td><input name="LastName" class="form_input" type="text" size="40" maxlength="40" value="<?=$user_row['LastName'];?>"<?=$reg_ary['Name'][1]?' notnull':'';?> /></td>
			</tr>
			<?php
			foreach((array)$reg_ary as $k=>$v){
				if($k=='Name'||$k=='Email'||$k=='Phone'||$k=='Shipping'||$k=='Address'||!$v[0]|| !isset($v[1])) continue;
				?>
				<?php if($k=='Gender'){ ?>
				<tr><th width="172" nowrap="nowrap"><?=$c['lang_pack']['user']['setting']['gender'];?>: </th>
					<td><?=html::form_select($c['gender'], 'Gender', $user_row['Gender'], '', '', $c['lang_pack']['user']['setting']['please'].' ...', 'notnull')?></td>
				</tr>
				<?php }else{ 
					$kn = $k;
	                if($k=='Birthday'){
	                    $kn=$c['lang_pack']['user']['Birthday'];
	                }
				?>
				<tr><th nowrap="nowrap"><?=$kn?>:<?php if($v[1]){?><span class="fc_red">*</span><?php }?> </th>
					<td><?=user::user_reg_edit($k, $v[1], 'form_input', $user_row);?></td>
				</tr>
			<?php }
			}
			$Other = json_decode($user_row['Other'], true);
			foreach((array)$set_row as $k=>$v){
				if ($v['TypeId']){
            ?>
            	<tr><th nowrap="nowrap"><?=$v['Name'.$c['lang']]?></th>
                    <td>
                    	<select name="Other[<?=$v['SetId'];?>]" class="form_input">
                            <?php
							foreach ((array)explode("\r\n", $v['Option'.$c['lang']]) as $k=>$v){?>
                            <option value="<?=$k;?>" <?=$Other[$v['SetId']]==$k?'selected="selected"':'';?>><?=$v?></option>
                            <?php }?>
                        </select>
                	</td>
                </tr>
            <?php
				}else{?>
                <tr><th nowrap="nowrap"><?=$v['Name'.$c['lang']];?></th>
                    <td><input type="text" class="form_input" value="<?=$Other[$v['SetId']];?>" name="Other[<?=$v['SetId'];?>]" placeholder="<?=$v['Name'.$c['lang']];?>"></td>
                </tr>
            <?php
				}
			}?>
			<tr><th nowrap="nowrap">&nbsp;</th>
				<td><button type="submit" class="textbtn"><?=$c['lang_pack']['user']['setting']['save'];?></button></td>
			</tr>
		</table>
        <input type="hidden" name="do_action" value="user.mod_profile" />
	</form>
    <div class="line"></div>
	<h3><?=$c['lang_pack']['user']['setting']['change_eamil'];?></h3>
	<form id="frm_email" method="post" action="/account/">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr><th nowrap="nowrap"><?=$c['lang_pack']['user']['setting']['exist_pass'];?>:<span class="fc_red">*</span> </th>
				<td><input name="ExtPassword" class="form_input" type="password" size="40" notnull /></td>
			</tr>
			<tr><th nowrap="nowrap"><?=$c['lang_pack']['user']['setting']['new_eamil'];?>:<span class="fc_red">*</span> </th>
				<td><input name="NewEmail" value="<?=$user_row['Email'];?>" class="form_input" type="text" size="40" maxlength="100" format="Email" notnull /></td>
			</tr>
			<tr><th nowrap="nowrap">&nbsp;</th>
				<td><button type="submit" class="textbtn"><?=$c['lang_pack']['user']['setting']['save'];?></button></td>
			</tr>
		</table>
        <input type="hidden" name="do_action" value="user.mod_email" />
	</form>
    <div class="line"></div>
	<h3><?=$c['lang_pack']['user']['setting']['change_pass'];?></h3>
	<form id="frm_password" method="post" action="/account/">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr><th nowrap="nowrap"><?=$c['lang_pack']['user']['setting']['exist_pass'];?>:<span class="fc_red">*</span> </th>
				<td><input name="ExtPassword" class="form_input" type="password" size="40" notnull /></td>
			</tr>
			<tr><th nowrap="nowrap"><?=$c['lang_pack']['user']['setting']['new_pass'];?>:<span class="fc_red">*</span> </th>
				<td><input name="NewPassword" id="NewPassword" class="form_input" type="password" size="40" notnull /></td>
			</tr>
			<tr><th nowrap="nowrap"><?=$c['lang_pack']['user']['setting']['re_pass'];?>:<span class="fc_red">*</span> </th>
				<td><input name="NewPassword2" id="NewPassword2" class="form_input" type="password" size="40" notnull /></td>
			</tr>
			<tr><th nowrap="nowrap">&nbsp;</th>
				<td><button type="submit" class="textbtn"><?=$c['lang_pack']['user']['setting']['save'];?></button></td>
			</tr>
		</table>
        <input type="hidden" name="do_action" value="user.mod_password" />
	</form>
    <div class="clear"></div>
</div>
<script type="text/javascript">
	var frm_profile = $('#frm_profile');
	frm_profile.find('button:submit').click(function(){
		if(global_obj.check_form(frm_profile.find('*[notnull]'))){return false;};
	});
	
	var frm_email = $('#frm_email');
	frm_email.find('button:submit').click(function(){
		if(global_obj.check_form(frm_email.find('*[notnull]'), frm_email.find('*[format]'))){return false;};
	});
	
	var frm_password = $('#frm_password');
	frm_password.find('button:submit').click(function(){
		if(global_obj.check_form(frm_password.find('*[notnull]'))){return false;};
		var status = 0;
		//密码长度大于6位
		if($('#NewPassword').val().length<6){
			$('#NewPassword').css('border', '1px solid red');
			status=1;
		}else{
			$('#NewPassword').removeAttr('style');
		}
		
		if($('#NewPassword').val()!=$('#NewPassword2').val()){
			$('#NewPassword2').css('border', '1px solid red');
			status=1;
		}else{
			$('#NewPassword2').removeAttr('style');
		}
		if (status=1){
			return false;
		}
	});
	var frm_register=$('form#frm_profile');
	$('input[name=Birthday]', frm_register).daterangepicker({
		showDropdowns:true,
		singleDatePicker:true,
		timePicker:false,
		format:'YYYY-MM-DD'
	});
</script>