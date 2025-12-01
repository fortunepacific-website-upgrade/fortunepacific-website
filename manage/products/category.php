<?php !isset($c) && exit();?>
<?php
manage::check_permit('products.category', 2);//检查权限

$Keyword=$_GET['Keyword'];
$CateId=(int)$_GET['CateId'];

//获取类别列表
$cate_ary=str::str_code(db::get_all('products_category', '1'));
$category_ary=array();
foreach((array)$cate_ary as $v){
	$category_ary[$v['CateId']]=$v;
}
$category_count=count($category_ary);
unset($cate_ary);

echo ly200::load_static('/static/js/plugin/dragsort/dragsort-0.5.1.min.js');
?>
<script type="text/javascript">$(function(){products_obj.category_init()});</script>
<div id="<?=$c['manage']['do']=='index'?'category':'category_inside';?>" class="r_con_wrap">
	<?php
	if($c['manage']['do']=='index'){	//产品分类列表
	?>
		<div class="inside_container">
			<h1>{/module.products.category/}</h1>
		</div>
		<div class="inside_table">
			<div class="list_menu">
				<ul class="list_menu_button">
					<li><a class="add" href="./?m=products&a=category&d=edit">{/global.add/}</a></li>
					<li><a class="del" href="javascript:;">{/global.del/}</a></li>
				</ul>
				<div class="search_form">
					<form method="get" action="?">
						<div class="k_input">
							<input type="text" name="Keyword" value="" class="form_input" size="15" autocomplete="off" />
							<input type="button" value="" class="more" />
						</div>
						<input type="submit" class="search_btn" value="{/global.search/}" />
						<div class="ext drop_down clean">
							<div class="rows item">
								<label>{/global.category/}</label>
								<div class="input">
									<div class="box_select"><?=category::ouput_Category_to_Select('CateId', '', 'products_category', 'UId="0,"', 'Dept<3', '', '{/global.select_index/}');?></div>
								</div>
							</div>
						</div>
						<div class="clear"></div>
						<input type="hidden" name="m" value="products" />
						<input type="hidden" name="a" value="category" />
					</form>
				</div>
			</div>
			<table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
				<thead>
					<tr>
						<td width="1%" nowrap="nowrap" class="myorder"></td>
						<td width="1%" nowrap="nowrap"><?=html::btn_checkbox('select_all');?></td>
						<td width="4%" nowrap="nowrap">{/global.id/}</td>
						<td width="83%" nowrap="nowrap">{/global.category/}</td>
						<td width="20%" nowrap="nowrap">{/global.operation/}</td>
					</tr>
				</thead>
				<tbody>
					<?php
					$where='1';//条件
					$Keyword && $where.=" and Category_{$c['manage']['language_web'][0]} like '%$Keyword%'";
					if($CateId){
						$UId=category::get_UId_by_CateId($CateId);
						$where.=" and UId='{$UId}'";
					}else{
						$where.=' and UId="0,"';
					}

					$category_row=str::str_code(db::get_all('products_category', $where, '*', $c['my_order'].'CateId asc'));
					$i=1;
					foreach($category_row as $v){
					?>
						<tr id="<?=$v['CateId'];?>">
							<td nowrap="nowrap" class="myorder move_myorder" data="move_myorder"><i class="icon_myorder"></i></td>
							<td nowrap="nowrap"><?=html::btn_checkbox('select', $v['CateId']);?></td>
							<td nowrap="nowrap"><?=$v['CateId'];?></td>
							<td nowrap="nowrap"><a href="<?=$v['SubCateCount']?"./?m=products&a=category&CateId={$v['CateId']}":'javascript:;';?>" title="<?=$v['Category_'.$c['manage']['language_web'][0]];?>"><?=$v['Category_'.$c['manage']['language_web'][0]];?></a> <?=$v['SubCateCount']?"({$v['SubCateCount']})":''?><?=$v['IsIndex']?'&nbsp;&nbsp;<span class="fc_red">{/products.category.is_index/}</span>':'';?></td>
							<td nowrap="nowrap" class="operation">
								<a href="./?m=products&a=category&d=edit&CateId=<?=$v['CateId'];?>">{/global.edit/}</a>
								<a class="del item" href="./?do_action=products.category_del&id=<?=$v['CateId'];?>" rel="del">{/global.del/}</a>
							</td>
						</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
	<?php
	}elseif($c['manage']['do']=='edit'){ //产品分类编辑
		$category_row=$seo_row=db::get_one('products_category', "CateId='$CateId'");
		$category_row['CateId'] && $category_description_row=db::get_one('products_category_description', "CateId='{$category_row['CateId']}'");
		echo ly200::load_static('/static/js/plugin/ckeditor/ckeditor.js');
	?>
	<div class="center_container_1000">
		<a href="javascript:history.back(-1);" class="return_title grey">
			<span class="return">{/module.products.category/}</span><span class="s_return">/ {/global.<?=$CateId?'edit':'add';?>/}</span>
		</a>
		<form id="edit_form" class="global_form clean">
			<div class="global_container">
				<div class="big_title">{/global.base_info/}</div>
				<div class="rows clean translation">
					<label>{/global.name/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
					<div class="input">
						<?=manage::form_edit($category_row, 'text', 'Category', 50, 255, 'notnull');?>
					</div>
				</div>
				<div class="rows clean">
					<label>{/products.category.children/}</label>
					<div class="input">
						<?php
						$now_dept=$category_row['Dept']+3-(db::get_max('products_category', "UId like '{$category_row['UId']}{$category_row['CateId']},%'", 'Dept'));
						$ext_where="CateId!='{$category_row['CateId']}' and Dept<".($category_row['SubCateCount']?$now_dept:3);
						echo '<div class="box_select">'.category::ouput_Category_to_Select('UnderTheCateId', category::get_CateId_by_UId($category_row['UId']), 'products_category', "UId='0,' and $ext_where", $ext_where, '', '{/global.select_index/}').'</div>';
						?>
					</div>
				</div>
				<div class="rows clean">
					<label>{/global.pic/}</label>
					<div class="input">
						<div class="multi_img upload_file_multi" id="PicDetail">
							<?php
							$pic=$category_row['PicPath'];
							$isFile=is_file($c['root_path'].$pic)?1:0;
							?>
							<dl class="img <?=$isFile ? 'isfile' : '';?>" num="0">
								<dt class="upload_box preview_pic">
									<input type="button" id="PicUpload" class="btn_ok upload_btn" name="submit_button" value="{/global.upload_pic/}" tips="" />
									<input type="hidden" name="PicPath" value="<?=$pic;?>" data-value="" save="<?=$isFile;?>" />
								</dt>
								<dd class="pic_btn">
									<a href="javascript:;" class="edit"><i class="icon_edit_white"></i></a>
									<a href="javascript:;" class="del" rel="del"><i class="icon_del_white"></i></a>
									<a href="<?=$isFile ? $pic : 'javascript:;';?>" class="zoom" target="_blank"><i class="icon_search_white"></i></a>
								</dd>
							</dl>
						</div>
					</div>
				</div>
				<?php if(!$CateId || $category_row['Dept']==1){?>
					<div class="rows clean">
						<label>{/products.attribute.attribute/}</label>
						<div class="input">
							<div class="box_select"><?=html::form_select(db::get_all('products_attribute','ParentId=0','*', $c['my_order'].'AttrId asc'), 'AttrId', $category_row['AttrId'], 'Name'.$c['lang'], 'AttrId', "{/global.select_index/}");?></div>
							<div class="attribute"></div>
						</div>
					</div>
					<div class="rows clean">
						<label>{/products.category.is_index/}</label>
						<div class="input">
							<div class="switchery<?=(int)$category_row['IsIndex']?' checked':'';?>">
								<input type="checkbox" name="IsIndex" value="1"<?=(int)$category_row['IsIndex']?' checked':'';?>>
								<div class="switchery_toggler"></div>
								<div class="switchery_inner">
									<div class="switchery_state_on"></div>
									<div class="switchery_state_off"></div>
								</div>
							</div>
						</div>
					</div>
				<?php }?>
				<div class="rows clean translation">
					<label>{/global.description/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
					<div class="input">
						<?=manage::form_edit($category_description_row, 'editor', 'Description');?>
					</div>
				</div>
				<div class="rows clean">
					<label></label>
					<div class="input">
						<input type="submit" class="btn_global btn_submit" name="submit_button" value="{/global.save/}" />
						<input type="button" class="btn_global btn_translation" value="{/global.translation/}">
						<a href="<?=$_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:'./?m=products&a=category';?>" class="btn_global btn_cancel">{/global.return/}</a>
					</div>
				</div>
			</div>
			<?php include("static/inc/seo.php");?>
			<input type="hidden" name="CateId" value="<?=$CateId;?>" />
			<input type="hidden" name="do_action" value="products.category_edit" />
		</form>
		<?php include("static/inc/translation.php");?>
	</div>
	<?php }?>
</div>