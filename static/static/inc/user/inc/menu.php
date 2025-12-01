<?php !isset($c) && exit();?>
<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/
?>
<div id="lib_user_menu">
	<h3 class="title"><?=$c['lang_pack']['user']['account'];?></h3>
	<ul>
		<li><a href="/account/"><?=$c['lang_pack']['user']['info'];?></a></li>
        <li><a href="/account/setting/"><?=$c['lang_pack']['user']['setting']['my_account'];?></a></li>
        <li><a href="/account/download.html"><?=$c['lang_pack']['user']['download'];?></a></li>
        <li><a href="/inquiry.html"><?=$c['lang_pack']['user']['pro_inq'];?></a></li>
		<li><a href="/account/logout.html"><?=$c['lang_pack']['user']['logout'];?></a></li>
	</ul>
</div>