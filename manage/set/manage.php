<?php !isset($c) && exit();?>
<?php
manage::check_permit('set.manage', 2);//检查权限
?>
<div id="manage" class="r_con_wrap">
	<div class="center_container_1000">
		<?php if($c['manage']['do']=='index'){?>
		<div class="inside_container">
			<h1>{/module.set.manage/}</h1>
		</div>
		<div class="inside_table">
			<script type="text/javascript">$(document).ready(function(){set_obj.manage_init()});</script>
			<div class="list_menu">
				<ul class="list_menu_button">
					<li><a class="add" href="./?m=set&a=manage&d=edit">{/global.add/}</a></li>
					<li><a class="del" href="javascript:;">{/global.del/}</a></li>
				</ul>
			</div>
			<table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
				<thead>
					<tr>
						<td width="15%" nowrap="nowrap">{/set.manage.username/}</td>
						<td width="15%" nowrap="nowrap">{/set.manage.group/}</td>
						<td width="15%" nowrap="nowrap">{/set.manage.last_login_time/}</td>
						<td width="15%" nowrap="nowrap">{/set.manage.last_login_ip/}</td>
						<td width="10%" nowrap="nowrap">{/set.manage.locked/}</td>
						<td width="10%" nowrap="nowrap">{/set.manage.create_time/}</td>
						<td width="12%" nowrap="nowrap" class="last">{/global.operation/}</td>
					</tr>
				</thead>
                <tbody>
                    <?php
                    $data=array('Action'=>'ueeshop_web_manage_list');
                    $result=ly200::api($data, $c['ApiKey'], $c['api_url']);
                    if($result['ret']==1){
                        foreach($result['msg'] as $k=>$v){
                            $u=$v['UserName'].'.'.$v['GroupId'].'.'.$v['Locked'];
                    ?>
                        <tr>
                            <td nowrap="nowrap"><?=$v['UserName'];?></td>
                            <td nowrap="nowrap">{/set.manage.group_ary.<?=$v['GroupId'];?>/}</td>
                            <td nowrap="nowrap"><?=$v['LastLoginTime']?date('Y-m-d H:i:s', $v['LastLoginTime']):'';?></td>
                            <td nowrap="nowrap"><?=$v['LastLoginIp'];?></td>
                            <td nowrap="nowrap">{/global.n_y.<?=$v['Locked'];?>/}</td>
                            <td nowrap="nowrap"><?=date('Y-m-d', $v['AccTime']);?></td>
							<td nowrap="nowrap" class="operation">
								<a class="tip_min_ico" href="./?m=set&a=manage&d=edit&u=<?=$u;?>">{/global.edit/}</a>
								<?php if($_SESSION['Manage']['UserName']!=$v['UserName']){?>
									<a class="del item" href="./?do_action=set.manage_del&u=<?=$v['UserName'];?>" rel="del">{/global.del/}</a>
								<?php }?>
							</td>
                        </tr>
                    <?php 
                        }
                    }
                    ?>
                </tbody>
			</table>
		</div>
		<?php
		}elseif($c['manage']['do']=='edit'){
			$data=$permit=array();
			if($_GET['u']){
				$data=@explode('.', $_GET['u']);
				$is_yourself_manager = $data[0]==$_SESSION['Manage']['UserName']?1:0;
				$data[1]!=1 && $permit=str::json_data(db::get_value('manage_permit', "UserName='{$data[0]}'", 'Permit'), 'decode');
			}
			$is_this_check = $is_yourself_manager?'checked disabled':'checked';
			$is_this_no_check = $is_yourself_manager?'disabled no_checked':'';
		?>
		<script type="text/javascript">$(document).ready(function(){set_obj.manage_edit_init()});</script>
		<div class="global_container">
			<a href="javascript:history.back(-1);" class="return_title">
                <span class="return">{/module.set.manage/}</span><span class="s_return">/ <?=$UserId?'{/global.edit/}':'{/global.add/}';?></span>
            </a>
			<form id="manage_edit_form" name="manage_form" class="global_form">
				<div class="rows">
					<label>{/set.manage.username/}</label>
					<span class="input">
						<?php if(!$data[0]){?>
							<input name="UserName" value="<?=$data[0];?>" type="text" class="box_input" maxlength="30" size="30" notnull> <font class="fc_red">*</font>
						<?php }else{?>
							<span class="tips"><?=$data[0];?></span>
                            <input name="UserName" value="<?=$data[0];?>" type="hidden" notnull>
						<?php }?>
					</span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/set.manage.password/}</label>
					<span class="input"><input name="Password" value="" type="password" class="box_input" maxlength="30" size="30" <?=$data[0]?'':'notnull';?>> <?=$UserId?'<font class="tips">{/set.manage.password_un_mod/}</font>':'<font class="fc_red">*</font>';?></span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/set.manage.confirm_password/}</label>
					<span class="input"><input name="ConfirmPassword" value="" type="password" class="box_input" maxlength="30" size="30" <?=$data[0]?'':'notnull';?>> <?=$UserId?'':'<font class="fc_red">*</font>';?></span>
					<div class="clear"></div>
				</div>
				<?php if((int)$c['FunVersion']){?>
					<div class="rows">
						<label>{/set.manage.group/}</label>
						<span class="input">
							<div class="box_select">
								<select name="GroupId" <?=$is_yourself_manager?"disabled":"";?>>
									<option value="1"<?=$data[1]==1?' selected="selected"':'';?>>{/set.manage.group_ary.1/}</option>
									<?php if($c['FunVersion']>=1){?><option value="2"<?=$data[1]!=1?' selected="selected"':'';?>>{/set.manage.group_ary.2/}</option><?php }?>
								</select>
							</div>
						</span>
						<div class="clear"></div>
					</div>
				<?php }?>
				<div class="rows">
					<label>{/set.manage.locked/}</label>
					<span class="input">
						<span class="input_checkbox_box <?=$is_yourself_manager?'disabled':'';?> <?=$data[2]?$is_this_check:$is_this_no_check;?>">
							<span class="input_checkbox">
								<input type="checkbox" name="Locked" value="1" <?=$data[2]?'checked="checked" ':'';?>/>
							</span>
						</span>
					</span>
					<div class="clear"></div>
				</div>
				<?php if((int)$c['FunVersion']){?>
					<div class="rows permit"<?=$data[1]==1?' style="display:none;"':'';?>>
						<label>{/set.manage.permit/}</label>
						<span class="input">
							<?php
							foreach($c['manage']['permit'] as $k=>$v){
								if($k=='account'){continue;}
							?>
								<dd class="list">
									<span class="input_checkbox_box <?=in_array($k, $permit)?$is_this_check:$is_this_no_check;?>">
										<span class="input_checkbox">
											<input type="checkbox" name="permit[]" <?=in_array($k, $permit)?'checked':'';?> value="<?=$k;?>" />
										</span><font>{/module.<?=$k;?>.module_name/}</font>
									</span>
									<div class="ext">
										<?php
										foreach($v as $k1=>$v1){
											$key=$k.'.'.(is_array($v1)?$k1:$v1);
										?>
											<div class="item">
												<span class="input_checkbox_box <?=in_array($key, $permit)?$is_this_check:$is_this_no_check;?>">
													<span class="input_checkbox">
														<input type="checkbox" name="permit[]" <?=in_array($key, $permit)?'checked':'';?> value="<?=$key;?>" />
													</span><font>{/module.<?=$k;?>.<?=is_array($v1)?$k1.'.module_name':$v1;?>/}</font>
												</span>
											</div>
										<?php }?>
										<div class="clear"></div>
									</div>
								</dd>
							<?php }?>
						</span>
						<div class="clear"></div>
					</div>
				<?php }?>
				<div class="rows clean">
					<label></label>
					<div class="input">
						<input type="button" class="btn_global btn_submit" value="{/global.submit/}">
						<a href="./?m=set&a=manage"><input type="button" class="btn_global btn_cancel" value="{/global.return/}"></a>
					</div>
				</div>
                <input type="hidden" name="Method" value="<?=$data[0]?1:0;?>" />
				<input type="hidden" name="do_action" value="set.manage_edit" />
			</form>
		</div>
		<?php }?>
	</div>
</div>