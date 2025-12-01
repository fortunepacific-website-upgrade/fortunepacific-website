<?php !isset($c) && exit();?>
<script type="text/javascript">$(document).ready(function(){account_obj.login_init();});</script>
<div id="login">
	<div class="w-1200">
		<form>
			<h2>{/account.welcome/}</h2>
			<div class="input username"><input name="UserName" id="UserName" type="text" maxlength="50" value="" autocomplete="off" placeholder="{/account.username/}"></div>
			<div class="input password"><input name="Password" id="Password" type="password" maxlength="50" value="" autocomplete="off" placeholder="{/account.password/}"></div>
			<div class="tips"></div>
			<input type="submit" class="submit" value="{/account.login_btn/}">
			<input type="hidden" name="do_action" value="account.login">
		</form>
	</div>
</div>
