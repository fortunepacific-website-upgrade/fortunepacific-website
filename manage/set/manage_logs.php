<?php !isset($c) && exit();?>
<?php
manage::check_permit('set.manage_logs', 2);//检查权限
?>
<div id="manage_logs" class="r_con_wrap">
	<div class="center_container_1000">
		<div class="inside_container">
			<h1>{/module.set.manage_logs/}</h1>
		</div>
		<div class="inside_table">
			<div class="list_menu">
				<div class="search_form">
					<form method="get" action="?">
						<div class="k_input">
							<input type="text" name="Keyword" placeholder="" value="" class="form_input" size="15" autocomplete="off" />
							<input type="button" value="" class="more" />
						</div>
						<input type="submit" class="search_btn" value="{/global.search/}" />
						<div class="clear"></div>
						<input type="hidden" name="m" value="set" />
						<input type="hidden" name="a" value="manage_logs" />
					</form>
				</div>
			</div>
			<table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
				<thead>
					<tr>
						<td width="10%" nowrap="nowrap">{/global.serial/}</td>
						<td width="10%" nowrap="nowrap">{/set.manage_logs.username/}</td>
						<td width="10%" nowrap="nowrap">{/set.manage_logs.module/}</td>
						<td width="10%" nowrap="nowrap">{/set.manage_logs.log_contents/}</td>
						<td width="10%" nowrap="nowrap">{/set.manage_logs.ip/}</td>
						<td width="10%" nowrap="nowrap" class="last">{/global.time/}</td>
					</tr>
				</thead>
				<tbody>
					<?php
					$i=1;
					$w='1';
					$Keyword=$_GET['Keyword'];
					$Module=$_GET['Module'];
					$Module && $w.=" and Module='$Module'";
					$Keyword && $w.=" and Log like '%$Keyword%'";
					$operation_log_row=db::get_limit_page('manage_operation_log', $w, '*', 'LId desc', (int)$_GET['page'], 20);
					foreach($operation_log_row[0] as $v){
					?>
						<tr>
							<td nowrap="nowrap"><?=$operation_log_row[4]+$i++;?></td>
							<td nowrap="nowrap"><?=$v['UserName'];?></td>
							<td nowrap="nowrap">{/set.log.<?=$v['Module'];?>/}</td>
							<td><?=$v['Log'];?></td>
							<td nowrap="nowrap"><?=$v['Ip'];?><br /><?=ly200::ip($v['Ip']);?></td>
							<td nowrap="nowrap" class="last"><?=date('Y-m-d H:i:s', $v['AccTime']);?></td>
						</tr>
					<?php }?>
				</tbody>
			</table>
			<?=html::turn_page($operation_log_row[1], $operation_log_row[2], $operation_log_row[3], '?'.str::query_string('page').'&page=');?>
		</div>
	</div>
</div>