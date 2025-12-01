<?php
manage::check_permit('user.add', 2);//检查权限
?>
<script type="text/javascript">$(function(){user_obj.user_view_init(); user_obj.user_add();});</script>
<div id="user_add" class="r_con_wrap">
	<div class="center_container">
		<div class="big_title">{/module.user.add/}</div>
	    <div class="edit_bd list_box">
	        <form id="user_form" name="add_user" class="global_form" method="post">
	            <div class="rows clean">
	                <label>{/user.email/}</label>
	                <span class="input">
	                    <span class="price_input">
	                        <input name="Email" type="text" class="box_input" notnull size="25" />
	                    </span>
	                </span>
	            </div>
	            <div class="rows clean">
	                <label>{/user.password/}</label>
	                <span class="input">
	                    <span class="price_input">
	                        <input name="Password" type="password" class="box_input" notnull size="25" />
	                    </span>
	                </span>
	            </div>
	            <div class="rows clean">
	                <label></label>
	                <span class="input">
	                    <input type="submit" class="btn_global btn_submit" name="submit_button" value="{/global.submit/}" />
	                </span>
	            </div>
	            <input type="hidden" name="do_action" value="user.user_add" />
	        </form>
	    </div>
	</div>
</div>