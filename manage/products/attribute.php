<?php !isset($c) && exit();?>
<?php
manage::check_permit('products.attribute', 2);//检查权限
?>
<div id="attribute" class="r_con_wrap">
	<div class="center_container_1000">
		<?php
		if($c['manage']['do']=='index'){
		?>
		<div class="inside_container">
			<h1>{/module.products.attribute/}</h1>
		</div>
		<div class="inside_table">
			<script type="text/javascript">$(document).ready(function(){products_obj.attribute_init()});</script>
			<div class="list_menu no_fixed">
				<ul class="list_menu_button">
					<li><a class="add" href="./?m=products&a=attribute&d=edit">{/global.add/}</a></li></ul>
				</ul>
			</div>
			<table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
				<thead>
					<tr>
						<td width="20%" nowrap="nowrap">{/products.attribute.group/}</td>
						<td width="60%" nowrap="nowrap">{/products.attribute.list/}</td>
						<td width="20%" nowrap="nowrap">{/global.operation/}</td>
					</tr>
				</thead>
				<tbody>
					<?php
					$products_attribute=str::str_code(db::get_all('products_attribute', 'ParentId=0', '*', $c['my_order'].'AttrId asc'));
					foreach($products_attribute as $v){
						$vAttrId=$v['AttrId'];
						$vName=$v['Name_'.$c['manage']['language_web'][0]];
					?>
						<tr>
							<td nowrap="nowrap"><?=$vName;?></td>
							<td nowrap="nowrap" class="attr_list">
								<?php
								$attribute_ext_row=str::str_code(db::get_all('products_attribute', "ParentId='{$vAttrId}'", '*', $c['my_order'].'AttrId asc'));
								foreach((array)$attribute_ext_row as $vv){
									echo $vv['Name_'.$c['manage']['language_web'][0]].'<br>';
								}
								?>
							</td>
							<td nowrap="nowrap" class="operation">
								<a href="./?m=products&a=attribute&d=edit&AttrId=<?=$v['AttrId'];?>">{/global.edit/}</a>
								<a class="del item" href="./?do_action=products.attribute_del&id=<?=$v['AttrId'];?>" rel="del">{/global.del/}</a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<?php
		}elseif($c['manage']['do']=='edit'){
			$AttrId=(int)$_GET['AttrId'];
			if($AttrId){
				$attribute_row=str::str_code(db::get_one('products_attribute', "AttrId='{$AttrId}'"));
				$attribute_ext_row=str::str_code(db::get_all('products_attribute', "ParentId='{$AttrId}'", '*', $c['my_order'].'AttrId asc'));
			}
			!$attribute_ext_row && $attribute_ext_row=array(array());
		?>
		<a href="javascript:history.back(-1);" class="return_title grey">
			<span class="return">{/module.products.attribute/}</span>
			<span class="s_return">/ {/global.add/}</span>
		</a>
		<div class="inside_table">
			<script type="text/javascript">$(document).ready(function(){products_obj.attribute_edit_init()});</script>
			<form id="attribute_edit_form" class="global_form">
				<div class="rows clean translation">
					<label>{/products.attribute.group/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
					<div class="input"><?=manage::form_edit($attribute_row, 'text', 'Name', 35, 50, 'notnull');?></div>
				</div>
				<div class="rows clean">
					<label>{/products.attribute.list/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
					<div class="input list_input">
						<?php
						foreach($attribute_ext_row as $v){
							echo '<div class="item">'.str_replace("name='Name", "name='AttrName", manage::form_edit($v, 'text', 'Name[]', 35, 50))."<input type='hidden' name='AttrIdList[]' value='{$v['AttrId']}'></div>";
						}
						?>
					</div>
				</div>
				<div class="rows clean">
					<label></label>
					<div class="input">
						<input type="button" class="btn_global btn_submit" value="{/global.submit/}">
						<input type="button" class="btn_global btn_translation" value="{/global.translation/}">
						<a href="./?m=products&a=attribute"><input type="button" class="btn_global btn_cancel" value="{/global.return/}"></a>
					</div>
				</div>
				<input type="hidden" name="AttrId" value="<?=$AttrId;?>" />
				<input type="hidden" name="do_action" value="products.attribute_edit" />
			</form>
			<?php include("static/inc/translation.php");?>
		</div>
		<?php }?>
	</div>
</div>