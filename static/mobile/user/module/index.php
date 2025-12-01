<?php !isset($c) && exit();?>
<script type="text/javascript">$(function (){user_obj.user_index();});</script>
<div class="wrapper">
	<div class="user_data clean">
        <div class="bg">
            <span class="img"></span>
        </div>
        <div class="info">
        	<div class="clean">
                <?=$user_row['Email'];?><br />
                <?=$user_row['FirstName'].' &nbsp;&nbsp; '.$user_row['LastName'];?>
            </div>
        </div>
    </div><!-- end of .user_data -->
    <aside class="user_menu">
    	<a href="/account/setting/" class="set"><?=$c['lang_pack']['mobile']['setting'];?></a>
    	<a href="/download/" class="down"><?=$c['lang_pack']['mobile']['downloads'];?></a>
        <a href="/inquiry.html" class="inquiry"><?=$c['lang_pack']['mobile']['inq'];?></a>
    </aside>
    <div class="sign_menu">
        <a href="/account/logout.html" class="sign_out global_button global_btn"><?=$c['lang_pack']['mobile']['sign_out'];?></a>
    </div>
</div>