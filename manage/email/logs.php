<?php !isset($c) && exit();?>
<?php
manage::check_permit('email.logs', 2);//检查权限

if(!$c['manage']['do'] || $c['manage']['do']=='index'){//重新指向“邮件发送”页面
	$c['manage']['do']='send';
}
?>
<div id="logs" class="r_con_wrap">
	<div class="<?=$c['manage']['page']!='view'?'center_container_1000':''?>">
		<?php
		if($c['manage']['page']=='view'){
			//邮件发送记录查看
			$LId=(int)$_GET['LId'];
			$log_row=db::get_one('email_log', "LId='$LId'");
			?>
			<div class="global_form">
				<div class="left_container">
					<div class="left_container_side">
						<div class="global_container">
							<a href="javascript:history.back(-1);" class="return_title">
								<span class="return">{/module.email.logs/}</span>
								<span class="s_return">/ {/global.view/}</span>
							</a>
							<div class="rows">
								<label>{/email.logs.content/}</label>
								<div class="input email_content"><?=$log_row['Body'];?></div>
							</div>
						</div>
					</div>
				</div>
				<div class="right_container">
					<div class="global_container">
						<div class="rows">
							<label>{/email.logs.to_email/}</label>
							<div class="input"><?=$log_row['Email'];?></div>
						</div>
						<div class="rows">
							<label>{/email.logs.status/}</label>
							<div class="input">{/email.logs.status_ary.0/}</div>
						</div>
						<div class="rows">
							<label>{/global.time/}</label>
							<div class="input"><?=date('Y-m-d H:i:s', $log_row['AccTime']);?></div>
						</div>
						<div class="rows">
							<label>{/email.logs.subject/}</label>
							<div class="input"><?=$log_row['Subject'];?></div>
						</div>
					</div>
				</div>
			</div>
		<?php }else{ ?>
			<div class="inside_container">
				<h1>{/module.email.logs/}</h1>
			</div>
			<div class="inside_table">
				<table border="0" cellpadding="5" cellspacing="0" class="r_con_table">
					<thead>
						<tr>
							<td width="5%" nowrap="nowrap">{/global.serial/}</td>
							<td width="15%" nowrap="nowrap">{/email.logs.to_email/}</td>
							<td width="30%" nowrap="nowrap">{/email.logs.subject/}</td>
							<td width="10%" nowrap="nowrap">{/email.logs.status/}</td>
							<td width="10%" nowrap="nowrap">{/global.time/}</td>
							<td width="10%" nowrap="nowrap" class="last center">{/global.operation/}</td>
						</tr>
					</thead>
					<tbody>
						<?php
						$w='1';
						$UserId=$_GET['UserId'];
						$Keyword=$_GET['Keyword'];
						$Module=$_GET['Module'];
						$UserId && $w.=" and UserId='$UserId'";
						$Module && $w.=" and Module='$Module'";
						$Keyword && $w.=" and Log like '%$Keyword%'";
						$manage_logs_row=db::get_limit_page('email_log', $w, '*', 'LId desc', (int)$_GET['page'], 20);
						$i=1;
						foreach($manage_logs_row[0] as $v){
						?>
							<tr>
								<td nowrap="nowrap"><?=$manage_logs_row[4]+$i++;?></td>
								<td nowrap="nowrap"><?=$v['Email'];?></td>
								<td nowrap="nowrap"><?=$v['Subject'];?></td>
								<td nowrap="nowrap">{/email.logs.status_ary.0/}</td>
								<td nowrap="nowrap"><?=date('Y-m-d H:i:s', $v['AccTime']);?></td>
								<td nowrap="nowrap" class="operation center">
									<a class="" href="./?m=email&a=logs&d=logs&p=view&LId=<?=$v['LId'];?>">{/global.view/}</a>
								</td>
							</tr>
						<?php }?>
					</tbody>
				</table>
				<?=html::turn_page($manage_logs_row[1], $manage_logs_row[2], $manage_logs_row[3], '?'.str::query_string('page').'&page=');?>
			</div>
		<?php } ?>
	</div>
</div>