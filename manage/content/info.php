<?php
manage::check_permit('content.info', 2);//检查权限

$d_ary=array('index','edit','category','category_edit');
$d = $c['manage']['do'];
!in_array($d, $d_ary) && $d=$d_ary[0];

$CateId=(int)$_GET['CateId'];

$cate_ary=str::str_code(db::get_all('info_category', '1'));
$category_ary=array();
foreach((array)$cate_ary as $v){
	$category_ary[$v['CateId']]=$v;
}
$category_count=count($category_ary);
unset($cate_ary);
?>
<div id="<?=($d=='index' || $d=='edit')?'info':'info_inside';?>" class="r_con_wrap">
	<div class="inside_container">
		<h1>{/module.content.info.module_name/}</h1>
		<ul class="inside_menu">
			<li><a href="./?m=content&a=info"<?=($d=='index' || $d=='edit')?' class="current"':'';?>>{/module.content.info.list/}</a></li>
			<li><a href="./?m=content&a=info&d=category"<?=($d=='category' || $d=='category_edit')?' class="current"':'';?>>{/global.category/}</a></li>
		</ul>
	</div>
	<?php if($d=='index'){
		//获取类别列表
		$cate_ary=str::str_code(db::get_all('info_category', '1', '*'));
		$category_ary=array();
		foreach((array)$cate_ary as $v){
			$category_ary[$v['CateId']]=$v;
		}
		$category_count=count($category_ary);
		unset($cate_ary);

		//产品列表
		$Title=str::str_code($_GET['Title']);
		$CateId=(int)$_GET['CateId'];

		$where='1';//条件
		$page_count=10;//显示数量
		$Title && $where.=" and Title{$c['lang']} like '%$Title%'";
		if($CateId){
			$where.=' and '.category::get_search_where_by_CateId($CateId, 'info_category');
			$category_one=str::str_code(db::get_one('info_category', "CateId='$CateId'"));
			$UId=$category_one['UId'];
			$UId!='0,' && $TopCateId=category::get_top_CateId_by_UId($UId);
		}
	?>
	<div class="center_container_1000">
		<div class="inside_table">
			<div class="list_menu">
				<div class="search_form">
					<form method="get" action="?">
						<div class="k_input">
							<input type="text" name="Title" value="" class="form_input" size="15" autocomplete="off" />
							<input type="button" value="" class="more" />
						</div>
						<input type="submit" class="search_btn" value="{/global.search/}" />
						<div class="ext drop_down">
							<div class="rows item clean">
								<label>{/global.category/}</label>
								<div class="input">
									<div class="box_select"><?=category::ouput_Category_to_Select('CateId', '', 'info_category', 'UId="0,"');?></div>
								</div>
							</div>
						</div>
						<div class="clear"></div>
						<input type="hidden" name="m" value="content" />
						<input type="hidden" name="a" value="info" />
					</form>
				</div>
				<ul class="list_menu_button">
					<li><a class="add" href="./?m=content&a=info&d=edit">{/global.add/}</a></li>
					<li><a class="del" href="javascript:;">{/global.del/}</a></li>
				</ul>
			</div>
			<script type="text/javascript">$(document).ready(function(){content_obj.info_init();});</script>
			<table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
				<thead>
					<tr>
						<td width="1%" nowrap="nowrap"><?=html::btn_checkbox('select_all');?></td>
						<td width="32%" nowrap="nowrap">{/global.title/}</td>
						<td width="17%" nowrap="nowrap">{/global.category/}</td>
						<td width="8%" nowrap="nowrap">{/global.edit_time/}</td>
						<td width="10%" nowrap="nowrap" class="last">{/global.operation/}</td>
					</tr>
				</thead>
				<tbody>
					<?php
					$i=1;
					$info_row=str::str_code(db::get_limit_page('`info`', $where, '*', $c['my_order'].'InfoId desc', (int)$_GET['page'], $page_count));
					foreach($info_row[0] as $v){
						$name=$v['Title'.$c['lang']];
						$url=web::get_url($v, 'info');
					?>
					<tr>
						<td nowrap="nowrap"><?=html::btn_checkbox('select', $v['InfoId']);?></td>
						<td><a href="<?=$url;?>" title="<?=$name;?>" target="_blank"><?=$name;?></a></td>
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
						<td nowrap="nowrap"><?=$v['AccTime']?date('Y-m-d', $v['AccTime']):'N/A';?></td>
						<td nowrap="nowrap" class="operation">
							<a href="./?m=content&a=info&d=edit&InfoId=<?=$v['InfoId'];?>" title="{/global.edit/}">{/global.edit/}</a>
							<a href="./?do_action=content.info_del&id=<?=$v['InfoId'];?>" title="{/global.del/}" class="del" rel="del">{/global.del/}</a>
						</td>
					</tr>
					<?php }?>
				</tbody>
			</table>
			<input type="hidden" name="Type" value="info" />
			<?=html::turn_page($info_row[1], $info_row[2], $info_row[3], '?'.str::query_string('page').'&page=');?>
		</div>
	</div>
	<?php
	}elseif($d=='edit'){
		$InfoId=(int)$_GET['InfoId'];
		$info_row = $seo_row = str::str_code(db::get_one('`info`', "InfoId='$InfoId'"));
		$info_content_row=str::str_code(db::get_one('info_content', "InfoId='$InfoId'"));

		$info_row['CateId'] && $uid=category::get_UId_by_CateId($info_row['CateId'],'info_category');
		$uid!='0,' && $TopCateId=category::get_top_CateId_by_UId($uid);
		$info_category_row=str::str_code(db::get_one('info_category', "CateId='{$TopCateId}'"));
		echo ly200::load_static('/static/js/plugin/ckeditor/ckeditor.js', '/static/js/plugin/daterangepicker/daterangepicker.css', '/static/js/plugin/daterangepicker/moment.min.js', '/static/js/plugin/daterangepicker/daterangepicker.js', '/static/js/plugin/dragsort/dragsort-0.5.1.min.js')
	?>
	<script type="text/javascript">$(document).ready(function(){content_obj.info_edit_init();});</script>
	<form id="edit_form" name="info_form" class="global_form">
		<div class="center_container_1000">
			<div class="global_container">
				<div class="big_title">{/global.base_info/}</div>
				<div class="rows clean translation">
					<label>{/global.title/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
					<div class="input"><?=manage::form_edit($info_row, 'text', 'Title', 53, 150, 'notnull');?></div>
				</div>
				<div class="rows clean">
					<label>{/global.category/}</label>
					<div class="input">
						<div class="box_select"><?=category::ouput_Category_to_Select('CateId', $info_row['CateId'], 'info_category', 'UId="0,"', 1, 'notnull');?></div>
					</div>
				</div>
	            <div class="rows clean">
	                <label>{/content.external_links/}</label>
	                <div class="input"><input name="Url" value="<?=$info_row['Url'];?>" type="text" class="box_input" size="53" maxlength="150" /><span class="tool_tips_ico" content="{/info.list.links_notes/}"></span></div>
	            </div>
				<div class="rows">
					<label>{/global.edit_time/}</label>
					<div class="input">
						<input name="AccTime" value="<?=date('Y/m/d H:i:s', ($info_row['AccTime']?$info_row['AccTime']:$c['time']));?>" type="text" class="box_input" size="20" readonly>
					</div>
				</div>

				<!-- 上传图片 -->
				<div class="rows clean">
					<label>{/global.pic/}</label>
					<div class="input">
						<?=manage::multi_img('PicDetail', 'PicPath', $info_row['PicPath']); ?>
					</div>
				</div>

				<div class="rows clean">
					<label>{/global.other/}</label>
					<div class="input other_btns">
						{/content.info.is_index/}
						<div class="switchery<?=(int)$info_row['IsIndex']?' checked':'';?>">
							<input type="checkbox" name="IsIndex" value="1"<?=(int)$info_row['IsIndex']?' checked':'';?>>
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
						<div class="box_select width_90"><?=html::form_select(manage::language('{/global.my_order_ary/}'), 'MyOrder', $info_row['MyOrder'], '', '', '', 'class="box_input"');?></div>
					</div>
				</div>

				<!-- 文字描述 -->
				<div class="rows clean translation">
					<label>{/global.brief_description/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
					<div class="input"><?=manage::form_edit($info_row, 'textarea', 'BriefDescription');?></div>
				</div>
				<div class="rows clean translation">
					<label>{/global.description/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
					<div class="input"><?=manage::form_edit($info_content_row, 'editor', 'Content');?></div>
				</div>

				<div class="rows clean">
					<label></label>
					<div class="input">
						<input type="submit" class="btn_global btn_submit" name="submit_button" value="{/global.save/}" />
						<input type="button" class="btn_global btn_translation" value="{/global.translation/}">
						<a href="./?m=content&a=info"><input type="button" class="btn_global btn_cancel" value="{/global.return/}"></a>
					</div>
				</div>
			</div>
			<?php include("static/inc/seo.php");?>
		</div>
		<input type="hidden" id="InfoId" name="InfoId" value="<?=$InfoId;?>" />
		<input type="hidden" name="do_action" value="content.info_edit" />
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
					<li><a class="add" href="./?m=content&a=info&d=category_edit">{/global.add/}</a></li>
					<li><a class="del" href="javascript:;">{/global.del/}</a></li>
				</ul>
			</div>
			<script type="text/javascript">$(document).ready(function(){content_obj.info_category_init()});</script>
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
						$UId=category::get_UId_by_CateId($CateId,'info_category');
						$where.=" and UId='{$UId}'";
					}else{
						$where.=' and UId="0,"';
					}
					$category_row=str::str_code(db::get_all('info_category', $where, '*', $c['my_order'].'CateId asc'));
					$i=1;
					foreach($category_row as $v){
					?>
						<tr id="<?=$v['CateId'];?>">
							<td nowrap="nowrap" class="myorder move_myorder" data="move_myorder"><i class="icon_myorder"></i></td>
							<td nowrap="nowrap"><?=html::btn_checkbox('select', $v['CateId']);?></td>
							<td nowrap="nowrap"><?=$v['CateId'];?></td>
							<td><?=$v['Category_'.$c['manage']['language_web'][0]];?></td>
							<td nowrap="nowrap" class="operation">
								<a href="./?m=content&a=info&d=category_edit&CateId=<?=$v['CateId'];?>">{/global.edit/}</a>
								<a class="del item" href="./?do_action=content.info_category_del&id=<?=$v['CateId'];?>" rel="del">{/global.del/}</a>
							</td>
						</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
	</div>
	<?php
	}elseif($d=='category_edit'){
		$category_row=$seo_row=db::get_one('info_category', "CateId='$CateId'");
	?>
	<script type="text/javascript">$(document).ready(function(){content_obj.info_category_edit_init()});</script>
	<div class="center_container_1200">
		<form id="edit_form" class="global_form clean">
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
						<label></label>
						<div class="input">
							<input type="submit" class="btn_global btn_submit" name="submit_button" value="{/global.save/}" />
							<input type="button" class="btn_global btn_translation" value="{/global.translation/}">
							<a href="<?=$_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:'./?m=content&a=info&d=category';?>" class="btn_global btn_cancel">{/global.return/}</a>
						</div>
					</div>
				</div>
				<?php include("static/inc/seo.php");?>
			</div>
			<input type="hidden" name="CateId" value="<?=$CateId;?>" />
			<input type="hidden" name="do_action" value="content.info_category_edit" />
		</form>
		<?php include("static/inc/translation.php");?>
	</div>
	<?php }?>
</div>