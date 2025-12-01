<?php
manage::check_permit('content.case', 2);//检查权限

$d_ary=array('index','edit','category','category_edit');
$d = $c['manage']['do'];
!in_array($d, $d_ary) && $d=$d_ary[0];

$CateId=(int)$_GET['CateId'];

$cate_ary=str::str_code(db::get_all('case_category', '1'));
$category_ary=array();
foreach((array)$cate_ary as $v){
	$category_ary[$v['CateId']]=$v;
}
$category_count=count($category_ary);
unset($cate_ary);
?>
<div id="<?=($d=='index' || $d=='edit')?'case':'case_inside'?>" class="r_con_wrap">
	<div class="inside_container">
		<h1>{/module.content.case.module_name/}</h1>
		<ul class="inside_menu">
			<li><a href="./?m=content&a=case"<?=($d=='index' || $d=='edit')?' class="current"':'';?>>{/module.content.case.list/}</a></li>
			<li><a href="./?m=content&a=case&d=category" <?=($d=='category' || $d=='category_edit')?' class="current"':'';?>>{/global.category/}</a></li>
		</ul>
	</div>
	<?php if($d=='index'){
		//获取类别列表
		$cate_ary=str::str_code(db::get_all('case_category', '1', '*'));
		$category_ary=array();
		foreach((array)$cate_ary as $v){
			$category_ary[$v['CateId']]=$v;
		}
		$category_count=count($category_ary);
		unset($cate_ary);

		//产品列表
		$Name=str::str_code($_GET['Name']);
		$CateId=(int)$_GET['CateId'];
		$Other=(int)$_GET['Other'];

		$where='1';//条件
		$page_count=10;//显示数量
		$Name && $where.=" and (Name{$c['lang']} like '%$Name%' or Number='$Name')";
		if($CateId){
			$where.=' and '.category::get_search_where_by_CateId($CateId, 'case_category');
			$category_one=str::str_code(db::get_one('case_category', "CateId='$CateId'"));
			$UId=$category_one['UId'];
			$UId!='0,' && $TopCateId=category::get_top_CateId_by_UId($UId);
		}
		if($Other){
			switch($Other){
				case 1: $where.=' and IsHot=1'; break;
				case 2: $where.=' and IsIndex=1'; break;
			}
		}
		$case_row=str::str_code(db::get_limit_page('`case`', $where, '*', $c['my_order'].'CaseId desc', (int)$_GET['page'], $page_count));
	?>
	<div class="inside_table">
		<div class="list_menu">
			<div class="search_form">
				<form method="get" action="?">
					<div class="k_input">
						<input type="text" name="Name" value="" class="form_input" size="15" autocomplete="off" />
						<input type="button" value="" class="more" />
					</div>
					<input type="submit" class="search_btn" value="{/global.search/}" />
					<div class="ext drop_down">
						<div class="rows item">
							<label>{/global.category/}</label>
							<div class="input">
								<div class="box_select"><?=category::ouput_Category_to_Select('CateId', '', 'case_category', 'UId="0,"');?></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="rows item">
							<label>{/content.case.attribute/}</label>
							<div class="input">
								<div class="box_select">
									<select name="Other">
										<option value="0">{/global.select_index/}</option>
										<option value="1">{/content.case.is_hot/}</option>
										<option value="2">{/content.case.is_index/}</option>
									</select>
								</div>
							</div>
							<div class="clear"></div>
						</div>
					</div>
					<div class="clear"></div>
					<input type="hidden" name="m" value="content" />
					<input type="hidden" name="a" value="case" />
				</form>
			</div>
			<ul class="list_menu_button">
				<li><a class="add" href="./?m=content&a=case&d=edit">{/global.add/}</a></li>
				<li><a class="del" href="javascript:;">{/global.del/}</a></li>
			</ul>
		</div>
		<script type="text/javascript">$(document).ready(function(){content_obj.case_init();});</script>
		<table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
			<thead>
				<tr>
					<td width="1%" nowrap="nowrap"><?=html::btn_checkbox('select_all');?></td>
					<td width="10%" nowrap="nowrap">{/global.pic/}</td>
					<td width="20%" nowrap="nowrap">{/global.name/}</td>
					<td width="20%" nowrap="nowrap">{/content.case.number/}</td>
					<td width="20%" nowrap="nowrap">{/global.category/}</td>
					<td width="15%" nowrap="nowrap">{/global.edit_time/}</td>
					<td width="10%" nowrap="nowrap">{/content.case.attribute/}</td>
					<td width="10%" nowrap="nowrap" class="last">{/global.operation/}</td>
				</tr>
			</thead>
			<tbody>
				<?php
				$i=1;
				foreach($case_row[0] as $v){
					$img=img::get_small_img($v['PicPath_0'], end($c['manage']['resize_ary']['case']));
					$name=$v['Name'.$c['lang']];
					$url=web::get_url($v, 'case');
				?>
				<tr>
					<td nowrap="nowrap"><?=html::btn_checkbox('select', $v['CaseId']);?></td>
					<td nowrap="nowrap"><a href="<?=$url;?>" title="<?=$name;?>" target="_blank"><img class="photo" src="<?=$img;?>" alt="<?=$name;?>" align="absmiddle" /></a></td>
					<td><a href="<?=$url;?>" title="<?=$name;?>" target="_blank"><?=$name;?></a></td>
					<td nowrap="nowrap"><?=$v['Number'];?></td>
					<td nowrap="nowrap">
						<?php
						$UId=$category_ary[$v['CateId']]['UId'];
						if($UId){
							$key_ary=@explode(',',$UId);
							array_shift($key_ary);
							array_pop($key_ary);
							foreach($key_ary as $k2=>$v2){
								echo $category_ary[$v2]['Category'.$c['lang']].'->';
							}
						}
						echo $category_ary[$v['CateId']]['Category'.$c['lang']];
						?>
					</td>
					<td nowrap="nowrap"><?=$v['EditTime']?date('Y-m-d', $v['EditTime']):'N/A';?></td>
					<td nowrap="nowrap" class="other flh_150">
						<?=$v['IsHot']?'<span>{/content.case.is_hot/}</span>':'';?>
						<?=$v['IsIndex']?'<span>{/content.case.is_index/}</span>':'';?>
					</td>
					<td nowrap="nowrap" class="operation">
						<a href="./?m=content&a=case&d=edit&CaseId=<?=$v['CaseId'];?>" title="{/global.edit/}">{/global.edit/}</a>
	                    <a href="./?do_action=content.case_del&id=<?=$v['CaseId'];?>" title="{/global.del/}" class="del" rel="del">{/global.del/}</a>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
		<input type="hidden" name="Type" value="case" />
		<?=html::turn_page($case_row[1], $case_row[2], $case_row[3], '?'.str::query_string('page').'&page=');?>
	</div>
	<?php
	}elseif($d=='edit'){
		$CaseId=(int)$_GET['CaseId'];
		$case_row=$seo_row=str::str_code(db::get_one('`case`', "CaseId='$CaseId'"));
		$case_description_row=str::str_code(db::get_one('case_description', "CaseId='$CaseId'"));

		$case_row['CateId'] && $uid=category::get_UId_by_CateId($case_row['CateId'],'case_category');
		$uid!='0,' && $TopCateId=category::get_top_CateId_by_UId($uid);
		$case_category_row=str::str_code(db::get_one('case_category', "CateId='{$TopCateId}'"));
		echo ly200::load_static('/static/js/plugin/ckeditor/ckeditor.js', '/static/js/plugin/daterangepicker/daterangepicker.css', '/static/js/plugin/daterangepicker/moment.min.js', '/static/js/plugin/daterangepicker/daterangepicker.js', '/static/js/plugin/dragsort/dragsort-0.5.1.min.js')
	?>
	<script type="text/javascript">$(document).ready(function(){content_obj.case_edit_init();});</script>
	<form id="edit_form" name="case_form" class="global_form">
		<div class="center_container_1000">
			<div class="global_container">
				<div class="big_title">{/global.base_info/}</div>
				<div class="rows clean translation">
					<label>{/global.name/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
					<div class="input"><?=manage::form_edit($case_row, 'text', 'Name', 53, 150, 'notnull');?></div>
				</div>
				<div class="rows clean">
					<label>{/global.category/}</label>
					<div class="input">
						<div class="box_select"><?=category::ouput_Category_to_Select('CateId', $case_row['CateId'], 'case_category', 'UId="0,"', 1, 'notnull');?></div>
					</div>
				</div>
	            <div class="rows clean">
	                <label>{/content.external_links/}</label>
	                <div class="input"><input name="Url" value="<?=$case_row['Url'];?>" type="text" class="box_input" size="53" maxlength="150" /></div>
	            </div>
				<div class="rows clean">
					<label>{/content.case.number/}</label>
					<div class="input"><input name="Number" value="<?=$case_row['Number'];?>" type="text" class="box_input" size="53" maxlength="15" /></div>
				</div>
				<!-- 上传图片 -->
				<div class="rows clean">
					<label>{/global.pic/}</label>
					<div class="input">
						<div id="PicDetail" class="multi_img upload_file_multi">
							<?php
							$j=0;
							for($i=0; $i<3; ++$i){
								echo manage::multi_img_item('PicPath[]', $case_row["PicPath_{$i}"], $i ,img::get_small_img($case_row["PicPath_{$i}"], end($c['manage']['resize_ary']['case'])));
								++$j;
							}?>
							<?php if($j<3){?>
								<dl class="img" num="<?=$j;?>">
									<dt class="upload_box preview_pic">
										<input type="button" id="PicUpload_<?=$j;?>" class="btn_ok upload_btn" name="submit_button" value="{/global.upload_pic/}" />
										<input type="hidden" name="PicPath[]" value="" data-value="" save="" />
									</dt>
								</dl>
							<?php }?>
						</div>
					</div>
				</div>

				<!-- 属性 -->
				<div class="rows clean">
					<label>{/content.case.attribute/}</label>
					<div class="input other_btns">
						{/content.case.is_index/}
						<div class="switchery<?=(int)$case_row['IsIndex']?' checked':'';?>">
							<input type="checkbox" name="IsIndex" value="1"<?=(int)$case_row['IsIndex']?' checked':'';?>>
							<div class="switchery_toggler"></div>
							<div class="switchery_inner">
								<div class="switchery_state_on"></div>
								<div class="switchery_state_off"></div>
							</div>
						</div>
						{/content.case.is_hot/}
						<div class="switchery<?=(int)$case_row['IsHot']?' checked':'';?>">
							<input type="checkbox" name="IsHot" value="1"<?=(int)$case_row['IsHot']?' checked':'';?>>
							<div class="switchery_toggler"></div>
							<div class="switchery_inner">
								<div class="switchery_state_on"></div>
								<div class="switchery_state_off"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="rows clean">
					<label>{/global.my_order/}</label>
					<div class="input">
						<div class="box_select width_90"><?=html::form_select(manage::language('{/global.my_order_ary/}'), 'MyOrder', $case_row['MyOrder'], '', '', '', 'class="box_input"');?></div>
					</div>
				</div>

				<!-- 文字描述 -->
				<div class="rows clean translation">
					<label>{/global.brief_description/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
					<div class="input"><?=manage::form_edit($case_row, 'textarea', 'BriefDescription');?></div>
				</div>
				<div class="rows clean translation">
					<label>{/global.description/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
					<div class="input"><?=manage::form_edit($case_description_row, 'editor', 'Description');?></div>
				</div>

				<div class="rows clean">
					<label></label>
					<div class="input">
						<input type="submit" class="btn_global btn_submit" name="submit_button" value="{/global.save/}" />
						<input type="button" class="btn_global btn_translation" value="{/global.translation/}">
						<a href="./?m=content&a=case"><input type="button" class="btn_global btn_cancel" value="{/global.return/}"></a>
					</div>
				</div>
			</div>
			<?php include("static/inc/seo.php");?>
		</div>
		<input type="hidden" id="all_attr" value="" />
		<input type="hidden" id="check_attr" value="" />
		<input type="hidden" id="CaseId" name="CaseId" value="<?=$CaseId;?>" />
		<input type="hidden" name="do_action" value="content.case_edit" />
		<input type="hidden" id="back_action" name="back_action" value="<?=$_SERVER['HTTP_REFERER'];?>" />
	</form>
	<?php include("static/inc/translation.php");?>
	<?php
	}elseif($d=='category'){
		//分类列表
		echo ly200::load_static('/static/js/plugin/dragsort/dragsort-0.5.1.min.js');
	?>
	<div class="center_container_1000">
		<div class="inside_table">
			<div class="list_menu">
				<ul class="list_menu_button">
					<li><a class="add" href="./?m=content&a=case&d=category_edit">{/global.add/}</a></li>
					<li><a class="del" href="javascript:;">{/global.del/}</a></li>
				</ul>
			</div>
			<script type="text/javascript">$(document).ready(function(){content_obj.case_category_init()});</script>
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
					//$Keyword && $where.=" and Category_{$c['manage']['language_web'][0]} like '%$Keyword%'";
					if($CateId){
						$UId=category::get_UId_by_CateId($CateId,'case_category');
						$where.=" and UId='{$UId}'";
					}else{
						$where.=' and UId="0,"';
					}
					$category_row=str::str_code(db::get_all('case_category', $where, '*', $c['my_order'].'CateId asc'));
					$i=1;
					foreach($category_row as $v){
					?>
						<tr id="<?=$v['CateId'];?>">
							<td nowrap="nowrap" class="myorder move_myorder" data="move_myorder"><i class="icon_myorder"></i></td>
							<td nowrap="nowrap"><?=html::btn_checkbox('select', $v['CateId']);?></td>
							<td nowrap="nowrap"><?=$v['CateId'];?></td>
							<td>
								<a href="<?=$v['SubCateCount']?"./?m=content&a=case&d=category&CateId={$v['CateId']}":'javascript:;';?>" title="<?=$v['Category_'.$c['manage']['language_web'][0]];?>"><?=$v['Category_'.$c['manage']['language_web'][0]];?></a>
								<?=$v['SubCateCount']?"({$v['SubCateCount']})":''?>
							</td>
							<td nowrap="nowrap" class="operation">
								<a href="./?m=content&a=case&d=category_edit&CateId=<?=$v['CateId'];?>">{/global.edit/}</a>
								<a class="del item" href="./?do_action=content.case_category_del&id=<?=$v['CateId'];?>" rel="del">{/global.del/}</a>
							</td>
						</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
	</div>
	<?php
	}elseif($d=='category_edit'){
		$category_row=$seo_row=db::get_one('case_category', "CateId='$CateId'");
		$category_row['CateId'] && $category_description_row=db::get_one('case_category_description', "CateId='{$category_row['CateId']}'");
		echo ly200::load_static('/static/js/plugin/ckeditor/ckeditor.js');
	?>
	<script type="text/javascript">$(document).ready(function(){content_obj.case_category_edit_init()});</script>
	<form id="edit_form" class="global_form">
		<div class="center_container_1000">
			<div class="global_container">
				<div class="big_title">{/global.base_info/}</div>
				<div class="rows clean translation">
					<label>{/global.name/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
					<div class="input">
						<?=manage::form_edit($category_row, 'text', 'Category', 53, 255, 'notnull');?>
					</div>
				</div>
				<div class="rows clean">
					<label>{/content.case.children/}</label>
					<div class="input">
						<?php
						$now_dept=$category_row['Dept']+3-(db::get_max('case_category', "UId like '{$category_row['UId']}{$category_row['CateId']},%'", 'Dept'));
						$ext_where="CateId!='{$category_row['CateId']}' and Dept<".($category_row['SubCateCount']?$now_dept:3);
						echo '<div class="box_select">'.category::ouput_Category_to_Select('UnderTheCateId', category::get_CateId_by_UId($category_row['UId']), 'case_category', "UId='0,' and $ext_where", $ext_where, '', '{/global.select_index/}').'</div>';
						?>
					</div>
				</div>
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
						<a href="<?=$_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:'./?m=content&a=case&d=category';?>" class="btn_global btn_cancel">{/global.return/}</a>
					</div>
				</div>
			</div>
			<?php include("static/inc/seo.php");?>
		</div>
		<input type="hidden" name="CateId" value="<?=$CateId;?>" />
		<input type="hidden" name="do_action" value="content.case_category_edit" />
	</form>
	<?php include("static/inc/translation.php");?>
	<?php }?>
</div>