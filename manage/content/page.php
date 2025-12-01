<?php !isset($c) && exit();?>
<?php
manage::check_permit('content.page', 2);//检查权限

$out=0;
$open_ary=array();
if($out) js::location('?m=content&a=page&d='.$open_ary[0]);//当第一个选项没有权限打开，就跳转能打开的第一个页面

if($c['manage']['do']=='index' || $c['manage']['do']=='edit' || $c['manage']['do']=='category'|| $c['manage']['do']=='category_edit'){
	$cate_ary=str::str_code(db::get_all('article_category', '1'));//获取类别列表
	$category_ary=array();
	foreach((array)$cate_ary as $v){
		$category_ary[$v['CateId']]=$v;
	}
	$category_count=count($category_ary);
	unset($cate_ary);

	$CateId=(int)$_GET['CateId'];
	if($CateId){
		$category_one=str::str_code(db::get_one('article_category', "CateId='$CateId'"));
		!$category_one && js::location('./?m=content&a=page');
		$UId=$category_one['UId'];
		$column=$category_one['Category'.$c['lang']];
	}
	$Keyword=str::str_code($_GET['Keyword']);
}
$top_id_name=($c['manage']['do']=='index' || $c['manage']['do']=='edit'?'page':'page_inside');
?>
<div id="<?=$top_id_name; ?>" class="r_con_wrap">
	<div class="inside_container">
		<h1>{/module.content.page.module_name/}</h1>
		<ul class="inside_menu">
			<li><a href="./?m=content&a=page"<?=($c['manage']['do']=='index' || $c['manage']['do']=='edit')?' class="current"':'';?>>{/module.content.page.list/}</a></li>
			<li><a href="./?m=content&a=page&d=category"<?=($c['manage']['do']=='category' || $c['manage']['do']=='category_edit')?' class="current"':'';?>>{/global.category/}</a></li>
		</ul>
	</div>
	<?php
	if($c['manage']['do']=='index'){
		//单页列表
	?>
		<script type="text/javascript">$(document).ready(function(){content_obj.page_init()});</script>
		<div class="center_container_1000">
			<div class="inside_table">
				<div class="list_menu">
					<div class="search_form">
						<form method="get" action="?">
							<div class="k_input">
								<input type="text" name="Keyword" value="" class="form_input" size="15" autocomplete="off" />
								<input type="button" value="" class="more" />
							</div>
							<input type="submit" class="search_btn" value="{/global.search/}" />
							<div class="ext drop_down">
								<div class="rows item clean">
									<label>{/global.category/}</label>
									<div class="input">
										<div class="box_select"><?=category::ouput_Category_to_Select('CateId', '', 'article_category', 'UId="0,"', 1, '', '{/global.select_index/}');?></div>
									</div>
								</div>
							</div>
							<div class="clear"></div>
							<input type="hidden" name="m" value="content" />
							<input type="hidden" name="a" value="page" />
						</form>
					</div>
					<ul class="list_menu_button">
						<li><a class="add" href="./?m=content&a=page&d=edit">{/global.add/}</a></li>
						<li><a class="del" href="javascript:;">{/global.del/}</a></li>
					</ul>
				</div>
				<table border="0" cellpadding="5" cellspacing="0" class="r_con_table">
					<thead>
						<tr>
							<td width="1%" nowrap="nowrap"><?=html::btn_checkbox('select_all');?></td>
							<td width="41%" nowrap="nowrap">{/global.title/}</td>
							<td width="41%" nowrap="nowrap">{/global.category/}</td>
							<td width="9%" nowrap="nowrap">{/global.my_order/}</td>
							<td width="5%" nowrap="nowrap">{/global.operation/}</td>
						</tr>
					</thead>
					<tbody>
						<?php
						$where='1';//条件
						$page_count=20;//显示数量
						$Keyword && $where.=" and Title{$c['lang']} like '%$Keyword%'";
						$CateId && $where.=" and CateId='$CateId'";
						$page_row=str::str_code(db::get_limit_page('article', $where, '*', 'CateId>1, '.$c['my_order'].'AId desc', (int)$_GET['page'], $page_count));
						$i=1;
						foreach((array)$page_row[0] as $v){
							$title=$v['Title'.$c['lang']];
							$url=web::get_url($v, 'article', $c['lang']);
						?>
							<tr>
								<td nowrap="nowrap"><?=html::btn_checkbox('select', $v['AId']);?></td>
								<td><a href="<?=$url;?>" title="<?=$title;?>" target="_blank"><?=$title;?></a></td>
								<td nowrap="nowrap" class="category_select" cateid="<?=$v['CateId'];?>">
									<?php
									$UId=$category_ary[$v['CateId']]['UId'];
									if($UId){
										$key_ary=@explode(',',$UId);
										array_shift($key_ary);
										array_pop($key_ary);
										foreach((array)$key_ary as $k2=>$v2){
											echo $category_ary[$v2]['Category'.$c['lang']].'->';
										}
									}
									echo $category_ary[$v['CateId']]['Category'.$c['lang']];
									?>
								</td>
								<td nowrap="nowrap"class="myorder_select" data-num="<?=$v['MyOrder'];?>">{/global.my_order_ary.<?=$v['MyOrder'];?>/}</td>
								<td nowrap="nowrap" class="operation">
									<a class="tip_min_ico" href="./?m=content&a=page&d=edit&AId=<?=$v['AId'];?>">{/global.edit/}</a>
									<a class="del item" href="./?do_action=content.page_del&id=<?=$v['AId'];?>" rel="del">{/global.del/}</a>
								</td>
							</tr>
						<?php }?>
					</tbody>
				</table>
				<?=html::turn_page($page_row[1], $page_row[2], $page_row[3], '?'.str::query_string('page').'&page=');?>
			</div>
		</div>
		<div id="myorder_select_hide" class="hide"><?=html::form_select(manage::language('{/global.my_order_ary/}'), "MyOrder[]", '');?></div>
	<?php
	}elseif($c['manage']['do']=='edit'){
		//单页编辑
		$AId=(int)$_GET['AId'];
		if($AId){
			$page_row = $seo_row =str::str_code(db::get_one('article', "AId='$AId'"));
			$page_content_row=str::str_code(db::get_one('article_content', "AId='$AId'"));
		}
	?>
		<?=ly200::load_static('/static/js/plugin/ckeditor/ckeditor.js');?>
		<script type="text/javascript">$(document).ready(function(){content_obj.page_edit_init()});</script>
		<div class="center_container_1000">
			<a href="javascript:history.back(-1);" class="return_title return_title_inside grey">
				<span class="return">{/module.content.page.module_name/}</span>
				<span class="s_return">/ {/module.content.page.list/} / <?=$AId?'{/global.edit/}':'{/global.add/}';?></span>
			</a>
			<form id="edit_form" class="global_form wrap_content">
				<div class="global_container">
					<div class="rows clean translation">
						<label>
							{/global.title/}
							<div class="tab_box"><?=manage::html_tab_button();?></div>
						</label>
						<div class="input"><?=manage::form_edit($page_row, 'text', 'Title', 53, 150, 'notnull');?></div>
					</div>
					<div class="rows clean">
						<label>{/global.category/}</label>
						<div class="input">
							<div class="box_select"><?=category::ouput_Category_to_Select('CateId', $page_row['CateId'], 'article_category', 'UId="0,"', 1, 'notnull class="box_input"', '{/global.select_index/}');?></div>
						</div>
					</div>
					<div class="rows clean">
						<label>{/content.external_links/}</label>
						<div class="input"><input name="Url" value="<?=$page_row['Url'];?>" type="text" class="box_input" size="53" maxlength="150" /><span class="tool_tips_ico" content="{/page.page.links_notes/}"></span></div>
					</div>
					<div class="rows clean">
						<label>{/content.page.is_feedback/}</label>
						<div class="input">
							<div class="switchery<?=$page_row['IsFeed']?' checked':'';?>">
								<input type="checkbox" name="IsFeed" value="1"<?=$page_row['IsFeed']?' checked':'';?>>
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
							<div class="box_select width_90"><?=html::form_select(manage::language('{/global.my_order_ary/}'), 'MyOrder', $page_row['MyOrder'], '', '', '', 'class="box_input"');?></div>
							<span class="tool_tips_ico" content="{/page.page.myorder_notes/}"></span>
						</div>
					</div>
					<div class="rows clean translation">
						<label>
							{/global.description/}
							<div class="tab_box"><?=manage::html_tab_button();?></div>
						</label>
						<div class="input"><?=manage::form_edit($page_content_row, 'editor', 'Content');?></div>
					</div>
					<div class="rows clean">
						<label></label>
						<div class="input">
							<input type="button" class="btn_global btn_submit" value="{/global.submit/}">
							<input type="button" class="btn_global btn_translation" value="{/global.translation/}">
							<a href="./?m=content&a=page"><input type="button" class="btn_global btn_cancel" value="{/global.return/}"></a>
						</div>
					</div>
				</div>
				<?php include("static/inc/seo.php");?>
				<input type="hidden" id="AId" name="AId" value="<?=$AId;?>" />
				<input type="hidden" name="do_action" value="content.page_edit" />
				<input type="hidden" id="back_action" name="back_action" value="<?=$_SERVER['HTTP_REFERER'];?>" />
			</form>
		</div>
		<?php include("static/inc/translation.php");?>
	<?php
	}elseif($c['manage']['do']=='category'){
		//单页分类列表
		echo ly200::load_static('/static/js/plugin/dragsort/dragsort-0.5.1.min.js');
	?>
		<script type="text/javascript">$(document).ready(function(){content_obj.page_category_init()});</script>
		<div class="center_container_1000">
			<div class="inside_table">
				<div class="list_menu">
					<div class="search_form">
						<form method="get" action="?">
							<div class="k_input">
								<input type="text" name="Keyword" value="" class="form_input" size="15" autocomplete="off" />
								<input type="button" value="" class="more" />
							</div>
							<input type="submit" class="search_btn" value="{/global.search/}" />
							<div class="clear"></div>
							<input type="hidden" name="m" value="content" />
							<input type="hidden" name="a" value="page" />
							<input type="hidden" name="d" value="category" />
						</form>
					</div>
					<ul class="list_menu_button">
						<li><a class="add" href="./?m=content&a=page&d=category_edit">{/global.add/}</a></li>
						<li><a class="del" href="javascript:;">{/global.del/}</a></li>
					</ul>
				</div>
				<table border="0" cellpadding="5" cellspacing="0" class="r_con_table">
					<thead>
						<tr>
							<td width="1%" nowrap="nowrap" class="myorder"></td>
							<td width="1%" nowrap="nowrap"><?=html::btn_checkbox('select_all');?></td>
							<td width="4%" nowrap="nowrap">{/global.id/}</td>
							<td width="87%" nowrap="nowrap">{/global.category/}</td>
							<td width="5%" nowrap="nowrap">{/global.operation/}</td>
						</tr>
					</thead>
					<tbody>
						<?php
						$where='1';//条件
						$Keyword && $where.=" and Category{$c['lang']} like '%$Keyword%'";
						$category_row=str::str_code(db::get_all('article_category', $where, '*', $c['my_order'].'CateId asc'));
						$i=1;
						foreach($category_row as $v){
						?>
							<tr id="<?=$v['CateId'];?>">
								<td nowrap="nowrap" class="myorder move_myorder" data="move_myorder"><i class="icon_myorder"></i></td>
								<td nowrap="nowrap"><?=html::btn_checkbox('select', $v['CateId']);?></td>
								<td nowrap="nowrap"><?=$v['CateId'];?></td>
								<td><?=$v['Category'.$c['lang']];?><?=$v['IsHelp']==1?'&nbsp;&nbsp;<span class="fc_red">{/page.page.help_center/}</span>':'';?></td>
								<td nowrap="nowrap" class="operation">
									<a class="" href="./?m=content&a=page&d=category_edit&CateId=<?=$v['CateId'];?>">{/global.edit/}</a>
									<a class="del item" href="./?do_action=content.page_category_del&id=<?=$v['CateId'];?>" rel="del">{/global.del/}</a>
								</td>
							</tr>
						<?php }?>
					</tbody>
				</table>
			</div>
		</div>
	<?php
	}elseif($c['manage']['do']=='category_edit'){
		//单页分类编辑
	?>
		<script type="text/javascript">$(document).ready(function(){content_obj.page_category_edit_init()});</script>
		<div class="center_container_1000">
			<div class="global_container">
				<a href="javascript:history.back(-1);" class="return_title return_title_inside">
					<span class="return">{/module.content.page.list/}</span>
					<span class="s_return">/ {/global.category/} / <?=$CateId?'{/global.edit/}':'{/global.add/}';?></span>
				</a>
				<form id="edit_form" class="global_form wrap_content">
					<div class="rows translation">
						<label>
							{/global.title/}<div class="tab_box"><?=manage::html_tab_button();?></div>
						</label>
						<div class="input"><?=manage::form_edit($category_one, 'text', 'Category', 35, 50, 'notnull');?></div>
					</div>
					<div class="rows clean">
						<label></label>
						<div class="input">
							<input type="button" class="btn_global btn_submit" value="{/global.submit/}">
							<input type="button" class="btn_global btn_translation" value="{/global.translation/}">
							<a href="./?m=content&a=page&d=category"><input type="button" class="btn_global btn_cancel" value="{/global.return/}"></a>
						</div>
					</div>
					<input type="hidden" name="CateId" value="<?=$CateId;?>" />
					<input type="hidden" name="do_action" value="content.page_category_edit">
				</form>
				<?php include("static/inc/translation.php");?>
			</div>
		</div>
	<?php }?>
</div>