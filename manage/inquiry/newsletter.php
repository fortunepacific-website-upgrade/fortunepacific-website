<?php !isset($c) && exit();?>
<?php
manage::check_permit('inquiry.newsletter', 2);//检查权限
?>
<div id="newsletter" class="r_con_wrap">
	<div class="center_container_1000">
		<div class="inside_container">
			<h1>{/module.inquiry.newsletter/}</h1>
		</div>
		<div class="inside_table">
			<div class="list_menu">
				<ul class="list_menu_button">
					<li><a class="del" href="javascript:;">{/global.del/}</a></li>
					<li><a class="explode export" href="javascript:;">{/global.explode/}</a></li>
				</ul>
				<div class="search_form">
					<form method="get" action="?">
						<div class="k_input">
							<input type="text" name="Keyword" value="" class="form_input" size="15" autocomplete="off" />
							<input type="button" value="" class="more" />
						</div>
						<input type="submit" class="search_btn" value="{/global.search/}" />
						<div class="clear"></div>
						<input type="hidden" name="m" value="inquiry" />
						<input type="hidden" name="a" value="newsletter" />
					</form>
				</div>
			</div>
			<script type="text/javascript">$(document).ready(function(){inquiry_obj.newsletter_init()});</script>
			<table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
				<thead>
					<tr>
						<td width="1%" nowrap="nowrap"><?=html::btn_checkbox('select_all');?></td>
						<td width="50%" nowrap="nowrap">{/global.email/}</td>
						<td width="35%" nowrap="nowrap" class="last">{/global.time/}</td>
					</tr>
				</thead>
				<tbody>
					<?php
					$Email=str::str_code($_GET['Keyword']);
					$where='1';
					$Email && $where.=" and Email like '%$Email%'";
					$newsletter_row=db::get_limit_page('newsletter', $where, '*', 'NId desc', (int)$_GET['page'], 20);
					foreach($newsletter_row[0] as $v){
					?>
						<tr>
							<td nowrap="nowrap"><?=html::btn_checkbox('select', $v['NId']);?></td>
							<td nowrap="nowrap"><a target="_blank" href="?m=email&a=send&email=<?=$v['Email'];?>" title="{/inquiry.send_email/}"><?=$v['Email'];?></a></td>
							<td nowrap="nowrap" class="last"><?=date('Y-m-d H:i:s', $v['AccTime']);?></td>
						</tr>
					<?php }?>
				</tbody>
			</table>
			<?=html::turn_page($newsletter_row[1], $newsletter_row[2], $newsletter_row[3], '?'.str::query_string('page').'&page=');?>
		</div>
	</div>
</div>