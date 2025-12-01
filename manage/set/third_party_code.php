<?php !isset($c) && exit();?>
<?php
manage::check_permit('set.third_party_code', 2);//检查权限
?>
<div id="third_party_code" class="r_con_wrap">
	<div class="center_container">
		<?php if($c['manage']['do']=='index'){?>
			<script type="text/javascript">$(document).ready(function(){set_obj.third_party_code_init()});</script>
			<div class="big_title">
				<span>{/module.set.third_party_code/}</span>
			</div>
			<div class="blank9"></div>
			<div class="myorder_box">
				<div class="config_table_body">
					<?php
					$third_row=str::str_code(db::get_all('third', '1', '*', 'TId desc'));
					foreach($third_row as $v){
					?>
						<div class="table_item" data-id="<?=$v['TId'];?>">
							<table border="0" cellpadding="5" cellspacing="0" class="r_con_table config_table"  data-id="<?=$v['TId'];?>">
								<tr>
									<td width="45%" nowrap="nowrap">
										<div class="name"><?=$v['Title'];?></div>
									</td>
									<td width="25%" nowrap="nowrap">
										{/set.third_party_code.code_type_ary.<?=$v['CodeType'];?>/}
										<?=$v['IsMeta']?'<br /><span class="gary">{/seo.third.is_meta/}</span>':'';?>
									</td>
									<td width="15" nowrap="nowrap">
										<a class="edit" href="./?m=set&a=third_party_code&d=edit&TId=<?=$v['TId'];?>" label="">{/global.edit/}</a>
										<a class="del" href="./?do_action=set.third_party_code_del&id=<?=$v['TId'];?>" rel="del">{/global.del/}</a>
									</td>
									<td width="10%" nowrap="nowrap" align="center">
										<div class="used_checkbox">
											<div class="switchery<?=$v['IsUsed']?' checked':'';?>" data-tid="<?=$v['TId']; ?>">
												<div class="switchery_toggler"></div>
												<div class="switchery_inner">
													<div class="switchery_state_on"></div>
													<div class="switchery_state_off"></div>
												</div>
											</div>
										</div>
									</td>
								</tr>
							</table>
						</div>
					<?php }?>
				</div>
				<a class="add set_add" href="./?m=set&a=third_party_code&d=edit">{/global.add/}</a><br />
			</div>
		<?php
		}else{
			$TId=(int)$_GET['TId'];
			$TId && $third_row=str::str_code(db::get_one('third', "TId='$TId'"));
		?>
			<a href="javascript:history.back(-1);" class="return_title">
				<span class="return">{/module.set.third_party_code/}</span><span class="s_return">/ {/global.<?=$TId?'edit':'add'?>/}</span>
			</a>
			<script type="text/javascript">$(document).ready(function(){set_obj.third_party_code_edit_init()});</script>
			<form id="third_party_code_edit_form" name="third_party_code_form" class="global_form">
				<div class="rows">
					<label>{/global.title/}</label>
					<div class="input"><input name="Title" value="<?=$third_row['Title'];?>" type="text" class="box_input" size="53" maxlength="100" notnull /></div>
				</div>
				<div class="rows">
					<label>{/set.third_party_code.code/}</label>
					<div class="input"><textarea name="Code" class="box_textarea" notnull><?=$third_row['Code'];?></textarea></div>
				</div>
				<div class="rows">
					<label>{/set.third_party_code.code_type/}</label>
					<div class="input"><div class="box_select"><?=html::form_select(manage::language('{/set.third_party_code.code_type_ary/}'), 'CodeType', (int)$third_row['CodeType']);?></div></div>
				</div>
				<div class="rows">
					<label>{/global.used/}</label>
					<div class="input">
						<div class="switchery<?=$third_row['IsUsed']==1?' checked':'';?>">
							<input type="checkbox" name="IsUsed" value="1"<?=$third_row['IsUsed']==1?' checked':'';?>>
							<div class="switchery_toggler"></div>
							<div class="switchery_inner">
								<div class="switchery_state_on"></div>
								<div class="switchery_state_off"></div>
							</div>
						</div>
						<span class="tool_tips_ico" content="{/set.third_party_code.used_notes/}"></span>
					</div>
				</div>
				<div class="rows">
					<label>{/set.third_party_code.is_meta/}</label>
					<div class="input">
						<div class="switchery<?=$third_row['IsMeta']==1?' checked':'';?>">
							<input type="checkbox" name="IsMeta" value="1"<?=$third_row['IsMeta']==1?' checked':'';?>>
							<div class="switchery_toggler"></div>
							<div class="switchery_inner">
								<div class="switchery_state_on"></div>
								<div class="switchery_state_off"></div>
							</div>
						</div>
						<span class="tool_tips_ico" content="{/set.third_party_code.meta_notes/}"></span>
					</div>
				</div>
				<div class="rows clean">
					<label></label>
					<div class="input">
						<input type="button" class="btn_global btn_submit" value="{/global.submit/}">
						<a href="./?m=set&a=third_party_code"><input type="button" class="btn_global btn_cancel" value="{/global.return/}"></a>
					</div>
				</div>
				<div class="blank15"></div>
				<input type="hidden" id="TId" name="TId" value="<?=$TId;?>" />
				<input type="hidden" name="do_action" value="set.third_party_code_edit" />
			</form>
		<?php }?>
	</div>
</div>