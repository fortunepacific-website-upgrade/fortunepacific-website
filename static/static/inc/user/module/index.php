<?php !isset($c) && exit();?>
<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/
?>
<dl id="lib_user_welcome">
    <dd><?=$c['lang_pack']['user']['index']['welcome'];?></dd>
</dl>
<div class="index_ml index_boxes">
	<div class="index_item personal">
		<h4><?=$c['lang_pack']['user']['index']['my_detail'];?></h4>
		<ul>
			<li><b><?=$c['lang_pack']['user']['email'];?>:</b><?=$user_row['Email'];?></li>
		</ul>
	</div>
</div>
<div class="blank20"></div>
