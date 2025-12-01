<?php !isset($c) && exit();?>
<?php
manage::check_permit('user.user', 2);//检查权限

$d_ary=array('list', 'base_info', 'log_info', 'password_info', 'explode');
$d = $c['manage']['do'];
!in_array($d, $d_ary) && $d=$d_ary[0];
?>
<div id="user" class="r_con_wrap">
	<?php if(in_array($d,array('index','list'))){
		$query_string_all=str::query_string();
		//自定义列
		$column_row=db::get_value('config', "GroupId='custom_column' and Variable='User'", 'Value');
		$custom_ary=str::json_data($column_row, 'decode');
		$column_fixed_ary=array('user.name', 'user.email', 'user.reg_time', 'user.last_login_time', 'user.consumption_price');
		$column_ary=array('user.name', 'user.email', 'user.gender', 'user.reg_time', 'user.reg_ip', 'user.last_login_time', 'user.last_login_ip', 'user.login_times');

		$Name=str::str_code($_GET['Name']);
		$Level=(int)$_GET['Level'];

		$where='1';//条件
		$page_count=10;//显示数量
		$Name && $where.=" and (FirstName like '%$Name%' or LastName like '%$Name%' or concat(FirstName, LastName) like '%$Name%' or Email like '%$Name%')";
		$Level && $where.=" and Level='$Level'";
		$user_row=str::str_code(db::get_limit_page('user', $where, '*', 'UserId desc', (int)$_GET['page'], 20));
	?>
		<div class="inside_container">
			<h1>{/module.user.user/}</h1>
		</div>
		<div class="inside_table">
			<div class="list_menu">
				<div class="search_form">
					<form method="get" action="?">
						<div class="k_input">
							<input type="text" name="Name" placeholder="" value="" class="form_input" size="15" autocomplete="off" />
							<input type="button" value="" class="more" />
						</div>
						<input type="submit" class="search_btn" value="{/global.search/}" />
						<div class="clear"></div>
						<input type="hidden" name="m" value="user" />
						<input type="hidden" name="a" value="user" />
					</form>
				</div>
				<ul class="list_menu_button">
					<li><a class="explode_bat export" href="./?m=user&a=user&d=explode">{/global.explode/}</a></li>
					<li class="custom_column page_last" style="display:;">
		                <a class="custom_click panel_4" href="javascript:void(0);" title="{/user.custom_column/}">{/user.custom_column/}</a>
		                <div class="custom_body">
		                    <form id="user_custom_form">
			                    <?php
			                    foreach($column_ary as $v){
			                        if(in_array($v, $column_fixed_ary) || in_array($v, $custom_ary)){
			                            $checked=' checked';
			                        }else $checked='';
			                        if(in_array($v, $column_fixed_ary)){
			                            $disabled=' disabled';
			                        }else $disabled='';
			                    ?>
								<div class="user_input_checkbox_box <?=$checked.$disabled;?>">
									<div class="input_checkbox">
					                    <input type="checkbox" name="Custom[]" class="custom_list" value="<?=$v;?>"<?=$checked.$disabled;?>  />
									</div>
									{/<?=$v?>/}
								</div>
			                    <?php }?>
			                    <div class="blank12"></div>
			                    <input type="button" class="btn_global btn_submit custom_btn" value="{/global.submit/}" />
								&nbsp;&nbsp;
								<div class="input_checkbox_box">
									<div class="input_checkbox"><input type="checkbox" name="custom_all" value="" class="va_m" /></div>
									{/global.select_all/}
								</div>
			                    <input type="hidden" name="do_action" value="user.user_list_field" />
		                    </form>
		                </div>
		            </li>
					<li><a class="del" href="javascript:;">{/global.del/}</a></li>
				</ul>
			</div>

			<script type="text/javascript">$(document).ready(function(){user_obj.user_init()});</script>
			<table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
				<thead>
					<tr>
						<td width="1%" nowrap="nowrap"><?=html::btn_checkbox('select_all');?></td>
						<td width="20%" nowrap="nowrap">{/user.email/}</td>
						<?php if(in_array('user.gender', $custom_ary)){?><td width="5%" nowrap="nowrap">{/user.gender/}</td><?php }?>
						<td width="15%" nowrap="nowrap">{/user.reg_time/}</td>
						<?php if(in_array('user.reg_ip', $custom_ary)){?><td width="15%" nowrap="nowrap">{/user.reg_ip/}</td><?php }?>
						<td width="15%" nowrap="nowrap">{/user.last_login_time/}</td>
						<?php if(in_array('user.last_login_ip', $custom_ary)){?><td width="15%" nowrap="nowrap">{/user.last_login_ip/}</td><?php }?>
						<?php if(in_array('user.login_times', $custom_ary)){?><td width="10%" nowrap="nowrap">{/user.login_times/}</td><?php }?>
						<?php if($c['FunVersion'] && $c['manage']['config']['UserStatus']){?><td width="10%" nowrap="nowrap">{/user.verify/}</td><?php }?>
						<td width="8%" class="last" nowrap="nowrap">{/global.operation/}</td>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach($user_row[0] as $v){
						$level_img=$level_ary[$v['Level']]['PicPath'];
						$level_name=$level_ary[$v['Level']]['Name'.$c['lang']];
					?>
					<tr>
						<td nowrap="nowrap"><?=html::btn_checkbox('select', $v['UserId']);?></td>
						<td nowrap="nowrap"><?=$v['Email'];?></td>
						<?php if(in_array('user.gender', $custom_ary)){?><td nowrap="nowrap"><?=$c['gender'][$v['Gender']];?></td><?php }?>
						<td nowrap="nowrap"><?=$v['RegTime']?date('Y-m-d H:i:s', $v['RegTime']):'';?></td>
						<?php if(in_array('user.reg_ip', $custom_ary)){?><td nowrap="nowrap"><?=$v['RegIp'].'<br />'.ly200::ip($v['RegIp']);?></td><?php }?>
						<td nowrap="nowrap"><?=$v['LastLoginTime']?date('Y-m-d H:i:s', $v['LastLoginTime']):'';?></td>
						<?php if(in_array('user.last_login_ip', $custom_ary)){?><td nowrap="nowrap"><?=$v['LastLoginIp'].'<br />'.ly200::ip($v['LastLoginIp']);?></td><?php }?>
						<?php if(in_array('user.login_times', $custom_ary)){?><td nowrap="nowrap"><?=$v['LoginTimes'];?></td><?php }?>
						<?php if($c['FunVersion'] && $c['manage']['config']['UserStatus']){?><td nowrap="nowrap"><?=$v['Status']?'{/global.n_y.1/}':'{/global.n_y.0/}';?></td><?php }?>
						<td nowrap="nowrap" class="operation">
							<a class="tip_min_ico" href="./?m=user&a=user&d=base_info&UserId=<?=$v['UserId'];?>">{/global.edit/}</a>
							<a class="del item" href="./?do_action=user.user_del&id=<?=$v['UserId'];?>" rel="del">{/global.del/}</a>
						</td>
					</tr>
					<?php }?>
				</tbody>
			</table>
			<?=html::turn_page($user_row[1], $user_row[2], $user_row[3], '?'.str::query_string('page').'&page=');?>
		</div>
	<?php
	}elseif($d=='explode'){
		echo ly200::load_static('/static/js/plugin/drag/drag.js', '/static/js/plugin/daterangepicker/daterangepicker.css', '/static/js/plugin/daterangepicker/moment.min.js', '/static/js/plugin/daterangepicker/daterangepicker.js');
	?>
		<script>$(document).ready(function(){user_obj.explode_init()});</script>
		<div class="center_container">
			<div class="big_title"><span>{/global.explode/}{/module.user.module_name/}</span></div>
			<div class="edit_bd list_box">
				<form id="explode_edit_form" class="global_form">
					<div class="rows clean">
						<label>{/user.reg_time/}</label>
						<div class="input">
							<input name="RegTime" type="text" value="" class="box_input input_time" size="55" />
						</div>
					</div>
					<div class="rows clean">
						<label></label>
						<div class="input input_button">
							<input type="button" class="btn_global btn_submit" value="{/global.explode/}">
							<a href="./?m=user&a=user"><input type="button" class="btn_global btn_cancel" value="{/global.return/}"></a>
						</div>
					</div>
					<div id="explode_progress"></div>
					<input type="hidden" name="do_action" value="user.user_explode" />
					<input type="hidden" name="Number" value="0" />
				</form>
			</div>
		</div>
	<?php }else{
		$UserId=(int)$_GET['UserId'];
		$user=str::str_code(db::get_one('user', "UserId={$UserId}"));

		$g_Page=(int)$_GET['page'];
		$g_Page<1 && $g_Page=1;

		if($d=='base_info'){
			$RegSet=db::get_value('config', "GroupId='user' and Variable='RegSet'", 'Value');
			$set_ary=array();
			$set_row=str::str_code(db::get_all('user_reg_set', '1', '*', "{$c[my_order]}SetId asc"));
			foreach((array)$set_row as $v){
				$set_ary[$v['SetId']]=$v;
				if($v['TypeId']){
					$set_ary[$v['SetId']]['Option']=explode("\r\n", $v['Option'.$c['lang']]);
				}
			}
		}elseif($d=='log_info'){
			$row_count=10;
			$row=str::str_code(db::get_limit_page('user_operation_log', "UserId='{$UserId}'", '*', 'LId desc', $g_Page, $row_count));
		}
	?>
	<script language="javascript">$(document).ready(function(){user_obj.user_view_init();});</script>
	<div class="inside_container">
		<h1>{/module.user.user/}</h1>
		<ul class="inside_menu">
			<?php
			foreach($d_ary as $v){
				if($v=='list' || $v=='explode')continue;
			?>
				<li><a <?=$d==$v?'class="current"':'';?> href="./?m=user&a=user&d=<?=$v;?>&UserId=<?=$UserId;?>">{/user.info.<?=$v;?>/}</a></li>
			<?php }?>
		</ul>
	</div>
	<div class="<?=$d?>">
		<?php
		/******************** 基本信息 ********************/
		if($d=='base_info'){
		?>
			<div class="center_container">
				<div class="big_title">{/global.base_info/}</div>
				<div class="edit_bd list_box">
					<form id="user_form" name="user_form" class="global_form clean">
						<div class="base fl">
							<div class="rows clean">
								<label>{/user.name/}</label>
								<span class="input"><?=$user['FirstName'].' '.$user['LastName'];?></span>
							</div>
							<div class="rows email clean">
								<label>{/user.email/}</label>
								<span class="input">
									<a href="./?m=email&a=send&Email=<?=urlencode($user['Email'].'/'.$user['FirstName'].' '.$user['LastName']);?>" target="_blank" title="{/module.email.send/}"><?=$user['Email'];?></a>
								</span>
							</div>
							<?php if($c['FunVersion'] && $c['manage']['config']['UserStatus']){?>
								<div class="rows clean">
									<label>{/user.verify/}</label>
									<span class="input">
										<div class="switchery<?=$user['Status']?' checked':'';?>">
											<input type="checkbox" name="Status" value="1"<?=$user['Status']?' checked':'';?>>
											<div class="switchery_toggler"></div>
											<div class="switchery_inner">
												<div class="switchery_state_on"></div>
												<div class="switchery_state_off"></div>
											</div>
										</div>
									</span>
								</div>
							<?php }?>
							<?php
							$reg_ary=str::json_data($RegSet, 'decode');
							foreach($reg_ary as $k=>$v){
								if($k=='Name' || $k=='Email' || !$v[0]) continue;
							?>
								<div class="rows clean">
									<label class="user.reg_field.<?=$k;?>">{/user.reg_field.<?=$k;?>/}</label>
									<span class="input"><?=user::user_reg_edit($k, $v[1], 'box_input', $user);?></span>
								</div>
							<?php }?>
							<?php if($user['Other']){?>
								<div class="rows clean">
									<label>{/global.other/}:</label>
									<div class="input">
										<?php
										$other_ary=str::json_data(htmlspecialchars_decode($user['Other']), 'decode');
										foreach($other_ary as $k=>$v){
											if($set_ary[$k]['TypeId']){
												$v=$set_ary[$k]['Option'][$v];
											}
											echo "【".$set_ary[$k]['Name'.$c['lang']]."】 {$v}<div class='blank6'></div>";
										}
										?>
									</div>
								</div>
							<?php }?>
						</div>
						<div class="log-info fr">
							<div class="rows clean">
								<label>{/user.reg_time/}</label>
								<span class="input"><?=date('Y-m-d H:i:s', $user['RegTime']).'<br />'.$user['RegIp'].'【'.ly200::ip($user['RegIp']).'】';?></span>
							</div>
							<div class="rows clean">
								<label>{/user.last_login_time/}</label>
								<span class="input"><?=date('Y-m-d H:i:s', $user['LastLoginTime']).'<br />'.$user['RegIp'].'【'.ly200::ip($user['LastLoginIp']).'】';?></span>
							</div>
						</div>
						<div class="clear"></div>
						<div class="rows clean">
							<label></label>
							<span class="input">
								<input type="submit" class="btn_global btn_submit" name="submit_button" value="{/global.save/}" />
								<a href="?m=user&a=user"><input type="button" class="btn_global btn_cancel" value="{/global.return/}"></a>
							</span>
						</div>
						<input type="hidden" name="UserId" value="<?=$UserId;?>" />
						<input type="hidden" name="do_action" value="user.user_base_info" />
					</form>
				</div>
			</div>
		<?php
		/******************** 操作记录 ********************/
		}elseif($d=='log_info'){
		?>
			<div class="global_container inside_table">
				<div class="clear"></div>
				<table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
					<thead>
						<tr>
							<td width="20%" nowrap="nowrap">{/user.log.title/}</td>
							<td width="20%" nowrap="nowrap">{/user.log.time/}</td>
							<td width="30%" nowrap="nowrap">{/user.log.content/}</td>
							<td width="30%" nowrap="nowrap" class="last">{/user.log.ip/}</td>
						</tr>
					</thead>
					<tbody>
						<?php foreach($row[0] as $v){?>
						<tr>
							<td nowrap="nowrap"><?=$v['Log'];?></td>
							<td nowrap="nowrap"><?=$v['AccTime']?date('Y-m-d H:i:s', $v['AccTime']):'N/A';?></td>
							<td nowrap="nowrap" class="left"><pre class="opt_log"><?=$v['Data'];?></pre></td>
							<td nowrap="nowrap" class="last"><?=$v['Ip'].'<br />【'.ly200::ip($v['Ip']).'】';?></td>
						</tr>
						<?php }?>
					</tbody>
				</table>
				<?=html::turn_page($row[1], $row[2], $row[3], '?'.str::query_string('page').'&page=');?>
			</div>
		<?php
		/******************** 修改密码 ********************/
		}elseif($d=='password_info'){
		?>
			<div class="center_container">
				<div class="big_title">{/user.info.password_info/}</div>
				<form id="user_form" name="user_form" class="global_form">
					<div class="rows clean">
						<label>{/user.info.new_password/}</label>
						<span class="input"><input type="password" name="NewPassword" class="box_input" size="25" maxlength="16" notnull /></span>
					</div>
					<div class="rows clean">
						<label>{/user.info.confirm_password/}</label>
						<span class="input"><input type="password" name="ReNewPassword" class="box_input" size="25" maxlength="16" notnull /></span>
					</div>
					<div class="rows clean">
						<label></label>
						<span class="input"><input type="submit" class="btn_global btn_submit" name="submit_button" value="{/global.save/}" /></span>
					</div>
					<input type="hidden" name="UserId" value="<?=$UserId;?>" />
					<input type="hidden" name="do_action" value="user.user_password_info" />
				</form>
			</div>
		<?php }?>
	</div>
	<?php }?>
</div>