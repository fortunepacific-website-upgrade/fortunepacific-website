<?php !isset($c) && exit();?>
<?php
//导航管理
$field=array(
	'nav'		=>	'Headnav',
	'footer_nav'=>	'Footnav',
	'toper_nav'	=>	'Topnav'
);
$nav_row=db::get_value('config', "GroupId='nav' and Variable='{$field[$c['manage']['do']]}'", 'Value');
$nav_data=str::json_data(htmlspecialchars_decode($nav_row), 'decode');
?>
<script type="text/javascript">$(document).ready(function(){set_obj.themes_nav_init()});</script>
<div class="blank12"></div>
<div class="center_container" Type="<?=$c['manage']['do'];?>">
	<div class="">
		<?php if($c['manage']['page']=='index'){ ?>
			<div class="config_table_body move_box">
				<?php
				//获取类别列表
				$PageCateAry=$ProdCateAry=$category_ary=array();
				$page_cate_ary=str::str_code(db::get_all('article_category', '1', 'CateId, Category_'.$c['manage']['language_default']));
				$products_cate_ary=str::str_code(db::get_all('products_category', '1', 'CateId, Category_'.$c['manage']['language_default']));
				foreach((array)$page_cate_ary as $v) $category_ary['Page'][$v['CateId']]=$v;
				foreach((array)$products_cate_ary as $v) $category_ary['Cate'][$v['CateId']]=$v;
				foreach((array)$nav_data as $k=>$v){
					$Name=(isset($v['Custom']) && $v['Custom'])?$v['Name_'.$c['manage']['language_default']]:$c['nav_cfg'][$v['Nav']]['name_'.$c['manage']['language_default']];
					if(isset($v['Page']) && $v['Page']){
						$Name=$category_ary['Page'][$v['Page']]['Category_'.$c['manage']['language_default']]." ({/set.themes.nav.page_type_ary.0/})";
					}elseif(isset($v['Cate']) && $v['Cate']){
						$Name=$category_ary['Cate'][$v['Cate']]['Category_'.$c['manage']['language_default']]." ({/set.themes.nav.page_type_ary.1/})";
					}
					$Id=$k+1;
					?>
					<div class="table_item move_item" data-id="<?=$k;?>">
						<table border="0" cellpadding="5" cellspacing="0" class="config_table" width="100%">
							<thead>
								<tr><td nowrap="nowrap" class="move_myorder move myorder"><span class="icon_myorder"></span></td></tr>
							</thead>
							<tbody>
								<tr>
									<td width="80%" nowrap="nowrap" class="myorder_left"><?=$Name;?></td>
									<td width="15%" nowrap="nowrap" align="center">
										<a class="edit" href="./?m=set&a=themes&d=<?=$c['manage']['do'];?>&p=edit&Id=<?=$Id;?>" data-id="<?=$Id;?>">{/global.edit/}</a>
										<a class="del" href="./?do_action=set.themes_nav_del&Type=<?=$c['manage']['do'];?>&Id=<?=$Id;?>" rel="del">{/global.del/}</a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				<?php }?>
			</div>
			<a href="./?m=set&a=themes&d=<?=$c['manage']['do'];?>&p=add" class="add set_add">{/global.add/}</a>
			<br />
		<?php }else{
			$Id=(int)$_GET['Id'];
			$nav_edit_row=$nav_data[$Id-1];
			$c['manage']['page']=='add' && $nav_edit_row = array();
			?>
			<div class="box_nav_edit">
				<form id="nav_edit_form" class="themes_nav_form global_form">
					<div class="r_con_form">
						<a href="javascript:history.back(-1);" class="return_title">
							<span class="return">{/set.themes.menu.<?=$c['manage']['do'];?>/}</span>
							<span class="s_return">  /  {/global.<?=$c['manage']['page']; ?>/}</span>
						</a>
						<div class="rows clean">
							<label>{/global.name/} <div class="tab_box" style="display:<?=$nav_edit_row['Custom'] ? 'inline-block' : 'none'; ?>;"><?=manage::html_tab_button();?></div></label>
							<div class="input">
								<div class="box_select">
									<select name="Nav" class="box_input">
										<option value="-1" <?=$nav_edit_row['Custom'] ? 'selected' : '';  ?> down="0">{/set.themes.nav.custom/}</option>
										<?php
										foreach($c['nav_cfg'] as $k=>$v){
										?>
											<option value="<?=$k;?>" <?=!$nav_edit_row['Custom'] && $nav_edit_row['Nav']==$k ? 'selected' : ''; ?> down="<?=$v['down'];?>"><?=$v['name_'.$c['manage']['language_default']];?></option>
										<?php }?>
									</select>
								</div>
								<div class="blank6"></div>
								<div class="nav_oth box_select" style="display:<?=$nav_edit_row['Nav']==6 ? 'block' : 'none'; ?>;">
									<select name="Page" class="box_input">
									<?php
									$page_category=str::str_code(db::get_all('article_category', 'UId="0,"', '*', 'CateId asc'));
									foreach($page_category as $k=>$v){
									?>
										<option value="<?=$v['CateId'];?>"><?=$v['Category_'.$c['manage']['language_default']];?></option>
									<?php }?>
									</select>
								</div>
								<div class="nav_oth box_select" style="display:<?=$nav_edit_row['Nav']==5 ? 'block' : 'none'; ?>;"><?=category::ouput_Category_to_Select('Cate', $nav_edit_row['Cate'], 'products_category', 'UId="0,"', 'Dept<=2', 'class="box_input"');?></div>
								<div class="nav_oth" style="display:<?=$nav_edit_row['Custom'] ? 'block' : 'none'; ?>;"><?=manage::form_edit($nav_edit_row, 'text', 'Name', 25, 100, 'class="box_input"');?></div>
							</div>
						</div>
						<div class="rows url clean" style="display:<?=$nav_edit_row['Custom'] ? 'block' : 'none'; ?>;">
							<label>{/set.themes.nav.url/}</label>
							<div class="input"><input name="Url" type="text" value="<?=$nav_edit_row['Url']; ?>" class="box_input" size="45" maxlength="200" /></div>
						</div>
						<?php if($c['manage']['do']!='toper_nav'){?>
							<div class="rows clean">
								<label>{/set.themes.nav.down/}</label>
								<div class="input">
									<div class="box_select">
										<select name="Down" class="box_input">
											<option value="0">{/global.n_y.0/}</option>
											<?php if($c['nav_cfg'][$nav_edit_row['Nav']]['down']){?><option value="1" <?=$nav_edit_row['Down']?'selected="selected"':''; ?> >{/global.n_y.1/}</option><?php }?>
										</select>
									</div>
								</div>
							</div>
							<div class="rows clean down_width" style="display:<?=$c['nav_cfg'][$nav_edit_row['Nav']]['down']?'':'none';?>;">
								<label>{/set.themes.nav.down_width/}</label>
								<div class="input">
									<div class="box_select">
										<select name="DownWidth" class="box_input">
											<?php for($i=0; $i<3; ++$i){?>
												<option value="<?=$i;?>" <?=$nav_edit_row['DownWidth']==$i?'selected="selected"':''; ?> >{/set.themes.nav.down_width_ary.<?=$i;?>/}</option>
											<?php }?>
										</select>
									</div>
								</div>
							</div>
						<?php }?>
						<div class="rows clean">
							<label>{/set.themes.nav.new_target/}</label>
							<div class="input">
								<div class="box_select">
									<select name="NewTarget" class="box_input"><option value="0">{/global.n_y.0/}</option><option value="1" <?=$nav_edit_row['NewTarget']?'selected="selected"':''; ?>>{/global.n_y.1/}</option></select>
								</div>
							</div>
						</div>
						<input type="hidden" id="Id" name="Id" value="<?=$Id;?>" />
						<input type="hidden" name="do_action" value="set.themes_nav_edit" />
						<input type="hidden" name="Type" value="<?=$c['manage']['do'];?>" />
						<div class="rows clean">
							<label></label>
							<div class="input">
								<input type="button" class="btn_global btn_submit" value="{/global.save/}">
								<a href="./?m=set&a=themes&d=<?=$c['manage']['do'];?>"><input type="button" class="btn_global btn_cancel" value="{/global.return/}"></a>
							</div>
						</div>
					</div>
				</form>
			</div>
		<?php } ?>
	</div>
</div>