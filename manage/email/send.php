<?php !isset($c) && exit();?>
<?php
manage::check_permit('email.send', 2);//检查权限
?>
<div id="email" class="r_con_wrap">
	<?php
	if($c['manage']['do']=='group'){
		$member_row=str::str_code(db::get_all('user', '1', 'UserId, Email, FirstName, LastName', 'UserId asc'));//会员列表
	?>
		<script type="text/javascript">$(function(){email_obj.email_group_init();});  window.onresize=function(){email_obj.email_group_init();}</script>
		<div id="user_gr">
			<div class="list_hd"><div class="list_title">{/email.send.member_group/}</div></div>
			<div class="user_list clean">
				<form id="user_list_form">
					<div class="list">
						<?php
						foreach($member_row as $k=>$v){
						?>
							<span class="choice_btn" title="<?=$v['Email'];?>">
								<b><?=($v['FirstName'] || $v['LastName'])?$v['FirstName'].' '.$v['LastName']:$v['Email'];?></b>
								<input type="checkbox" name="User" class="hide" value="<?=$v['UserId'];?>" />
							</span>
						<?php }?>
					</div>
					<input type="hidden" name="do_action" value="email.user_list">
				</form>
				<div class="blank9"></div>
			</div>
			<div class="list_foot clean">
				<input type="button" id="button_add" value="{/global.confirm/}" class="btn_global btn_submit btn_ok" />
				<input type="button" value="{/global.cancel/}" class="btn_global btn_cancel" />
			</div>
		</div>
	<?php
	}else{	//邮件发送
		$mail_default_list=$_GET['Email']?$_GET['Email']:$_GET['email'];
		echo ly200::load_static( '/static/js/plugin/ckeditor/ckeditor.js');
	?>
		<script type="text/javascript">$(document).ready(function(){email_obj.email_send_init()});</script>
		<div class="email_container">
			<form id="email_form" class="global_form">
				<div class="center_container">
					<div class="big_title">{/module.email.send/}</div>
					<div class="rows clean">
						<label>{/email.send.subject/}</label>
						<div class="input"><input type="text" class="box_input" name="Subject" value="" size="53" maxlength="255" notnull /></div>
					</div>
					<div class="rows clean">
						<label>{/email.send.addressee/}</label>
						<div class="input">
							<?php if($c['FunVersion']>=1){?><input type="button" class="btn_global btn_ok user_group" name="" value="{/email.send.member_group/}" /><div class="blank9"></div><?php }?>
							<input name="Email" value="<?=$mail_default_list;?>" type="text" class="box_input MemberToName" size="50" maxlength="100" notnull />
							<div class="blank9"></div>
							{/email.send.remark/}
						</div>
					</div>
					<?php if($c['FunVersion']>=1){?>
						<div class="rows clean">
							<label>{/global.contents/}</label>
							<div class="input"><?=manage::editor('Content');?></div>
						</div>
					<?php }?>
					<div class="rows">
						<label></label>
						<span class="input">
							<input type="submit" class="btn_global btn_submit" name="submit_button" value="{/email.send.send/}" />
						</span>
						<div class="clear"></div>
					</div>
				</div>
				<input type="hidden" name="Arrival" value="<?=$_GET['Arrival'];?>" />
				<input type="hidden" name="do_action" value="email.send" />
			</form>
		</div>
	<?php }?>
</div>