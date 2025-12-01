<?php
!(int)$c['FunVersion'] && manage::no_permit();

$d_ary=array('list', 'edit');
$d=$_GET['d'];
!in_array($d, $d_ary) && $d=$d_ary[0];
?>
<?=ly200::load_static('/static/manage/css/feedback.css');?>
<script language="javascript">$(function(){mess_obj.mess_set_init()});</script>
<div class="r_nav">
	<h1>{/module.content.mess_set.default_set/}</h1>
</div>
<div id="message_set" class="r_con_wrap">
	<?php
	if($d=='list'){
	?>
	<div class="fixed fl">
		<table border="0" cellpadding="5" cellspacing="0" class="r_con_table">
			<thead>
				<tr>
					<td width="55%" nowrap="nowrap">{/module.content.mess_set.name/}</td>
					<td width="45%" nowrap="nowrap" class="last">{/global.used/} / {/global.required/}</td>
				</tr>
			</thead>
			<tbody>
				<?php
				$MessSet=db::get_value('config', 'GroupId="message" and Variable="MessSet"', 'Value');
				$feed_ary=str::json_data($MessSet, 'decode');
				foreach($c['manage']['mess_set_fiexd'] as $k=>$v){
					$status=$feed_ary[$k];
				?>
				<tr>
					<td>{/module.content.mess_set.<?=$k;?>/}<?=!$v?'{/set.feed_set.fixed/}':'';?></td>
					<td class="last">
						<div class="switchery<?=(($status[0] && $v) || !$v)?' checked':'';?><?=!$v?' no_drop':'';?>"<?=$v?" field='{$k}' status='{$status[0]}'":'';?>>
							<div class="switchery_toggler"></div>
							<div class="switchery_inner">
								<div class="switchery_state_on">ON</div>
								<div class="switchery_state_off">OFF</div>
							</div>
						</div>&nbsp;&nbsp;
						<div class="switchery<?=(($status[1] && $v) || !$v)?' checked':'';?><?=(($v && !$status[0]) || !$v)?' no_drop':'';?>"<?=$v?" field='{$k}NotNull' status='{$status[1]}'":'';?>>
							<div class="switchery_toggler"></div>
							<div class="switchery_inner">
								<div class="switchery_state_on">ON</div>
								<div class="switchery_state_off">OFF</div>
							</div>
						</div>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</div>
    <?php }?>
</div>