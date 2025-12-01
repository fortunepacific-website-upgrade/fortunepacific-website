<?php !isset($c) && exit();?>
<?php
manage::check_permit('set.country', 2);//检查权限
?>
<div id="country" class="r_con_wrap ">
	<div class="center_container">
		<?php
		if($c['manage']['do']=='index'){
		?>
			<script type="text/javascript">$(document).ready(function(){set_obj.country_init()});</script>
			<div class="list_menu no_fixed">
				<ul class="list_menu_button">
					<li><a class="add" href="./?m=set&a=country&d=edit">{/global.add/}</a></li></ul>
				</ul>
				<div class="search_form">
					<form method="get" action="?">
						<div class="k_input">
							<input type="text" name="Keyword" value="" class="form_input" size="15" autocomplete="off" />
							<input type="button" value="" class="more" />
						</div>
						<input type="submit" class="search_btn" value="{/global.search/}" />
						<div class="clear"></div>
						<input type="hidden" name="m" value="set" />
						<input type="hidden" name="a" value="country" />
					</form>
				</div>
			</div>
			<table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
				<?php
				$where='1';
				$k=$_GET['k'];
				$Keyword=str::str_code($_GET['Keyword']);
				$Continent=(int)$_GET['Continent'];
				$k!='' && $where.=" and Country like '$k%'";
				$Keyword && $where.=" and Country like '%$Keyword%'";
				$Continent && $where.=" and Continent='$Continent'";
				$country_row=str::str_code(db::get_all('country', $where, '*', 'Country asc'));
				$continent_country_ary=array();
				foreach((array)$country_row as $v){
					$continent_country_ary[$v['Continent']][]=$v;
				}
				foreach((array)$continent_country_ary as $k => $v){
				?>
					<thead>
						<tr>
							<th nowrap="nowrap" colspan="4">
								<div class="big_title rows_hd_part"><span>{/set.country.continent_ary.<?=($k-1);?>/}</span></div>
							</th>
						</tr>
						<tr>
							<td width="45%" nowrap="nowrap">{/set.country.country/}</td>
							<td width="35%" nowrap="nowrap">{/global.operation/}</td>
							<td width="20%" nowrap="nowrap">{/global.used/}</td>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach((array)$v as $k1=>$v1){
							$IsUsed=(int)$v1['IsUsed'];
						?>
							<tr cid="<?=$v1['CId'];?>">
								<td nowrap="nowrap" class="img">
									<?=$v1['Country'];?>
									<?=$v1['Acronym']?'('.$v1['Acronym'].')':'';?>
									<?=$v1['CId']<=240?'<div class="icon_flag flag_'.strtolower($v1['Acronym']).'"></div>':'<img src="'.$v1['FlagPath'].'" />';?>
								</td>
								<td nowrap="nowrap" class="operation">
									<a class="" href="./?m=set&a=country&d=edit&CId=<?=$v1['CId'];?>">{/global.edit/}</a>
									<?php if($v1['CId']>240){?>
										<a class="del gray" href="./?do_action=set.country_del&CId=<?=$v1['CId'];?>">{/global.del/}</a>
									<?php }?>
								</td>
								<td nowrap="nowrap" class="used_checkbox">
									<div class="switchery<?=$IsUsed?' checked':'';?>">
										<div class="switchery_toggler"></div>
										<div class="switchery_inner">
											<div class="switchery_state_on"></div>
											<div class="switchery_state_off"></div>
										</div>
									</div>
								</td>
							</tr>
						<?php }?>
					</tbody>
				<?php } ?>
			</table>
		<?php
		}elseif($c['manage']['do']=='edit'){
			$CId=(int)$_GET['CId'];
			$used_checked=' checked';
			$hot_checked=$state_checked='';
			if($CId){
				$country_row=str::str_code(db::get_one('country', "CId='{$CId}'"));
				$used_checked=$country_row['IsUsed']==1?' checked':'';
			}
		?>
			<a href="javascript:history.back(-1);" class="return_title">
				<span class="return">{/module.set.country/}</span><span class="s_return">/ {/global.<?=$CId?'edit':'add'?>/}</span>
			</a>
			<script type="text/javascript">$(document).ready(function(){set_obj.country_edit_init()});</script>
			<form id="country_edit_form" class="global_form">
				<div class="rows clean">
					<label>{/set.country.country/}</label>
					<div class="input">
						<?php
						if(!$CId || $country_row['CId']>240){
						?>
							<input type="text" name="Country" value="<?=$country_row['Country'];?>" class="box_input" size="20" maxlength="50" notnull>
						<?php
						}else{
							echo $country_row['Country'];
						}?>
					</div>
				</div>
				<div class="rows clean">
					<label>{/set.country.acronym/}</label>
					<div class="input"><input type="text" name="Acronym" value="<?=$country_row['Acronym'];?>" class="box_input" size="10" maxlength="2" notnull=""<?=($CId && $country_row['CId']<240)?' readonly':'';?>></div>
				</div>
				<div class="rows clean">
					<label>{/set.country.continent/}</label>
					<div class="input">
						<?php
						if($CId && $country_row['CId']<240){
							echo '{/set.country.continent_ary.'.($country_row['Continent']-1).'/}';
						}else{?>
							<div class="box_select">
								<select name="Continent" class="box_input">
									<?php foreach(range(1, 7) as $v){?>
										<option value="<?=$v;?>"<?=$country_row['Continent']==$v?' selected':'';?>>{/set.country.continent_ary.<?=($v-1);?>/}</option>
									<?php }?>
								</select>
							</div>
						<?php }?>
					</div>
				</div>
				<div class="rows clean">
					<label>{/global.used/}</label>
					<div class="input">
						<div class="switchery<?=$used_checked;?>">
							<input type="checkbox" name="IsUsed" value="1"<?=$used_checked;?>>
							<div class="switchery_toggler"></div>
							<div class="switchery_inner">
								<div class="switchery_state_on"></div>
								<div class="switchery_state_off"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="rows clean">
					<label></label>
					<div class="input">
						<input type="button" class="btn_global btn_submit" value="{/global.submit/}">
						<a href="./?m=set&a=country"><input type="button" class="btn_global btn_cancel" value="{/global.return/}"></a>
					</div>
				</div>
				<input type="hidden" name="CId" value="<?=$CId;?>" />
				<input type="hidden" name="do_action" value="set.country_edit" />
			</form>
		<?php }?>
	</div>
</div>