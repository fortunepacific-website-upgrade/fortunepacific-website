<?php !isset($c) && exit();?>
<?php
manage::check_permit('content.blog', 2);//检查权限

$Keyword=$_GET['Keyword'];
if(!$c['manage']['do'] || $c['manage']['do']=='index'){//重新指向“风格”页面
	$c['manage']['do']='blog';
}
if($c['manage']['do']=='blog' || $c['manage']['do']=='category'){
	$cate_ary=str::str_code(db::get_all('blog_category','1','*'));
	$category_ary=array();
	foreach((array)$cate_ary as $v){
		$category_ary[$v['CateId']]=$v;
	}
	$category_count=count($category_ary);
	unset($cate_ary);

	$CateId=(int)$_GET['CateId'];
	if($CateId){
		$category_row=str::str_code(db::get_one('blog_category', "CateId='$CateId'"));
		!$category_row && js::location('./?m=content&a=blog&d=blog');
		$UId=$category_row['UId'];
		$UId!='0,' && $TopCateId=category::get_top_CateId_by_UId($UId);
		$column=$category_row['Category'.$c['manage']['language_web'][0]];
	}
}
$top_id_name=($c['manage']['do']=='blog' || $c['manage']['do']=='category' || $c['manage']['do']=='review') && $c['manage']['page']=='index' ?'blog':'blog_inside';
?>
<div id="<?=$top_id_name; ?>" class="r_con_wrap">
	<div class="inside_container">
		<h1>{/module.content.blog.module_name/}</h1>
		<ul class="inside_menu">
			<?php
			$menu_array=array('blog', 'set','category', 'review');
			foreach($menu_array as $k=>$v){
			?>
				<li><a href="./?m=content&a=blog&d=<?=$v;?>"<?=$c['manage']['do']==$v?' class="current"':'';?>>{/module.content.blog.<?=$v;?>/}</a></li>
			<?php }?>
		</ul>
	</div>
	<?php
	if($c['manage']['do']=='set'){
		//博客设置
		$set_ary=array();
		$set_row=db::get_all('config', "GroupId='blog'");
		foreach($set_row as $v){
			$set_ary[$v['Variable']]=$v['Value'];
		}
		?>
		<script type="text/javascript">$(function(){content_obj.blog_set_init()});</script>
		<div class="center_container_1000">
			<div class="global_container">
				<form id="blog_edit_form" class="global_form">
					<div class="rows">
						<label>{/content.blog.set.title/}</label>
						<div class="input"><textarea class="box_textarea" name="Title"><?=$set_ary['Title'];?></textarea></div>
					</div>
					<div class="rows">
						<label>{/global.brief_description/}</label>
						<div class="input"><textarea class="box_textarea" name="BriefDescription"><?=$set_ary['BriefDescription'];?></textarea></div>
					</div>
					<div class="rows">
						<label>{/content.blog.set.nav/}</label>
						<div class="input">
							<div data-name="{/global.name/}" data-link="{/content.blog.set.link/}" class="blog_nav">
								<?php
								$Nav=(array)str::json_data(htmlspecialchars_decode($set_ary['NavData']), 'decode');
								foreach($Nav as $k=>$v){
								?>
									<div>
										<div class="unit_input">
											<b>{/global.name/}</b>
											<input type="text" name="name[]" class="box_input" value="<?=$v[0];?>" size="10" maxlength="30" />
										</div>&nbsp;&nbsp;
										<div class="unit_input">
											<b>{/content.blog.set.link/}</b>
											<input type="text" name="link[]" class="box_input" value="<?=$v[1];?>" size="30" max="150" />
										</div>
										<a href="javascript:void(0);"><img hspace="5" src="/static/ico/del.png"></a>
										<div class="blank6"></div>
									</div>
								<?php }?>
							</div>
						</div>
					</div>
					<div class="rows">
						<label></label>
						<div class="input">
							<a href="javascript:;" class="set_add addNav">{/global.add/}</a>
						</div>
					</div>
					<div class="rows">
						<label>{/content.blog.set.ad/}<span class="tool_tips_ico"  content="{/global.pic_size_tips/}1200*auto"></span></label>
						<div class="input">
							<?=manage::multi_img('AdDetail', 'Banner', $set_ary['Banner']); ?>
						</div>
					</div>
					<div class="rows">
						<label></label>
						<div class="input">
							<input type="button" class="btn_global btn_submit" value="{/global.save/}">
						</div>
					</div>
					<?php /*?><input type="hidden" name="Banner" value="<?=$set_ary['Banner'];?>" save="<?=is_file($c['root_path'].$set_ary['Banner'])?1:0;?>" /><?php */?>
					<input type="hidden" name="do_action" value="content.blog_set" />
				</form>
			</div>
		</div>
	<?php
	}elseif($c['manage']['do']=='blog'){	//博客管理
		if($c['manage']['page']=='index'){	//博客列表
		?>
		<script type="text/javascript">$(document).ready(function(){content_obj.blog_init()});</script>
		<div class="inside_table center_container_1000">
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
									<div class="box_select"><?=category::ouput_Category_to_Select('CateId', '', 'blog_category', 'UId="0,"');?></div>
								</div>
							</div>
						</div>
						<div class="clear"></div>
						<input type="hidden" name="m" value="content" />
						<input type="hidden" name="a" value="blog" />
						<input type="hidden" name="d" value="<?=$c['manage']['do'];?>" />
						<input type="hidden" name="p" value="<?=$c['manage']['page'];?>" />
					</form>
				</div>
				<ul class="list_menu_button">
					<li><a class="add" href="./?m=content&a=blog&d=<?=$c['manage']['do'];?>&p=edit">{/global.add/}</a></li>
					<li><a class="del" href="javascript:;">{/global.del/}</a></li>
				</ul>
			</div>
			<div class="clear"></div>
			<?php
			$where='1';//条件
			$page_count=20;//显示数量
			$CateId && $where.=' and '.category::get_search_where_by_CateId($CateId, 'blog_category');
			$Keyword && $where.=" and Title like '%$Keyword%'";
			$blog_row=str::str_code(db::get_limit_page('blog', $where, '*', $c['my_order'].'AId desc', (int)$_GET['page'], $page_count));

			if($blog_row[0]){
			?>
				<table border="0" cellpadding="5" cellspacing="0" class="r_con_table">
					<thead>
						<tr>
							<td width="1%" nowrap="nowrap"><?=html::btn_checkbox('select_all');?></td>
							<td width="30%" nowrap="nowrap">{/global.title/}</td>
							<td width="30%" nowrap="nowrap">{/global.category/}</td>
							<td width="9%" nowrap="nowrap">{/global.my_order/}</td>
							<td width="10%" nowrap="nowrap">{/global.operation/}</td>
						</tr>
					</thead>
					<tbody>
						<?php
						$i=1;
						foreach((array)$blog_row[0] as $v){
							$title=$v['Title'];
							$url=web::get_url($v, 'blog');
						?>
							<tr>
								<td nowrap="nowrap"><?=html::btn_checkbox('select', $v['AId']);?></td>
								<td><a href="<?=$url;?>" title="<?=$title;?>" target="_blank"><?=$title;?></a><?=(int)$v['IsHot']?'&nbsp;&nbsp;<span class="fc_red">{/content.blog.is_hot/}</span>':'';?></td>
								<td class="category_select" cateid="<?=$v['CateId'];?>">
									<?php
									$UId=$category_ary[$v['CateId']]['UId'];
									if($UId){
										$key_ary=@explode(',',$UId);
										array_shift($key_ary);
										array_pop($key_ary);
										foreach((array)$key_ary as $k2=>$v2){
											echo $category_ary[$v2]['Category_'.$c['manage']['language_web'][0]].'->';
										}
									}
									echo $category_ary[$v['CateId']]['Category_'.$c['manage']['language_web'][0]];
									?>
								</td>
								<td nowrap="nowrap" class="myorder_select" data-num="<?=$v['MyOrder'];?>">{/global.my_order_ary.<?=$v['MyOrder'];?>/}</td>
								<td nowrap="nowrap" class="operation">
									<a href="./?m=content&a=blog&d=blog&p=edit&AId=<?=$v['AId'];?>">{/global.edit/}</a>
									<a class="del item" href="./?do_action=content.blog_del&id=<?=$v['AId'];?>" rel="del">{/global.del/}</a>
								</td>
							</tr>
						<?php }?>
					</tbody>
				</table>
				<?=html::turn_page($blog_row[1], $blog_row[2], $blog_row[3], '?'.str::query_string('page').'&page=');?>
				<div id="myorder_select_hide" class="hide"><?=html::form_select(manage::language('{/global.my_order_ary/}'), 'MyOrder[]', '');?></div>
			<?php
			}else{//没有数据
				echo html::no_table_data(($Keyword?0:1), './?m=content&a=blog&d=blog&p=edit');
			}?>
		</div>
		<?php
		}else{
			//博客编辑
			$AId=(int)$_GET['AId'];
			$blog_row=str::str_code(db::get_one('blog', "AId='$AId'"));
			$blog_content_row=str::str_code(db::get_one('blog_content', "AId='$AId'"));
			?>
			<?=ly200::load_static('/static/js/plugin/ckeditor/ckeditor.js');?>
			<script type="text/javascript">$(document).ready(function(){content_obj.blog_edit_init()});</script>
			<form id="edit_form" class="global_form center_container_1200">
				<div class="left_container">
					<div class="left_container_side">
						<div class="global_container">
							<div class="rows">
								<label>{/global.title/}</label>
								<div class="input"><input name="Title" value="<?=$blog_row['Title'];?>" type="text" class="box_input" maxlength="150" size="53" notnull></div>
							</div>
							<div class="rows">
								<label>{/global.category/}</label>
								<div class="input">
									<div class="box_select">
										<select name="CateId" notnull="" class="box_input">
											<option value="">--{/global.select_index/}--</option>
											<?php
											$blog_category_row=db::get_all('blog_category', '1', 'CateId, Category_en', $c['my_order'].'CateId asc');
											foreach($blog_category_row as $k=>$v){?>
												<option value="<?=$v['CateId'];?>"<?=$blog_row['CateId']==$v['CateId']?' selected':'';?>><?=$v['Category_en']?></option>
											<?php }?>
										</select>
									</div>
			                    </div>
							</div>
			                <div class="rows">
			                    <label>{/global.pic/}</label>
			                    <div class="input">
			                    	<?=manage::multi_img('PicDetail', 'PicPath', $blog_row['PicPath']); ?>
			                    </div>
			                </div>
							<div class="rows">
								<label>{/global.other/}</label>
								<div class="input">
									<span class="input_checkbox_box <?=$blog_row['IsHot']?'checked':'';?>">
										<span class="input_checkbox">
											<input type="checkbox" name="IsHot" value="1" <?=$blog_row['IsHot']?'checked="checked"':'';?>>
										</span>{/content.blog.blog.is_hot/}
									</span>
								</div>
							</div>
							<div class="rows">
								<label>{/content.blog.blog.author/}</label>
								<div class="input"><input name="Author" value="<?=$blog_row['Author'];?>" type="text" class="box_input" maxlength="150" size="53" notnull></div>
							</div>
							<div class="rows">
								<label>{/global.brief_description/}</label>
								<div class="input"><textarea class="box_textarea" name="BriefDescription"><?=$blog_row['BriefDescription'];?></textarea></div>
							</div>
							<div class="rows">
								<label>{/content.blog.blog.tag/}</label>
								<div class="input"><input name="Tag" value="<?=substr($blog_row['Tag'],1,-1);?>" type="text" class="box_input" maxlength="150" size="53"> <span class="tool_tips_ico" content="{/content.blog.blog.tag_notes/}"></span></div>
							</div>
							<div class="rows">
								<label>{/global.description/}</label>
								<div class="input"><?=manage::editor('Content', $blog_content_row['Content']);?></div>
							</div>
							<input type="hidden" id="AId" name="AId" value="<?=$AId;?>" />
							<input type="hidden" name="do_action" value="content.blog_edit" />
							<input type="hidden" id="back_action" name="back_action" value="<?=$_SERVER['HTTP_REFERER'];?>" />
						</div>
					</div>
				</div>
				<div class="right_container">
					<div class="global_container seo_box">
						<div class="big_title">{/global.seo.seo/}</div>
						<div class="rows">
							<label>{/global.seo.title/}</label>
							<div class="input"><input name="SeoTitle" value="<?=$blog_row['SeoTitle'];?>" type="text" class="box_input" maxlength="150" size="49" notnull></div>
						</div>
						<div class="rows">
							<label>{/global.seo.keyword/}</label>
							<div class="input"><input name="SeoKeyword" value="<?=$blog_row['SeoKeyword'];?>" type="text" class="box_input" maxlength="150" size="49" notnull></div>
						</div>
						<div class="rows">
							<label>{/global.seo.description/}</label>
							<div class="input"><textarea class="box_textarea" name="SeoDescription"><?=$blog_row['SeoDescription'];?></textarea></div>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</form>
			<div class="rows fixed_btn_submit">
				<label></label>
				<div class="input">
					<input type="button" class="btn_global btn_submit" value="{/global.save/}">
					<a href="./?m=content&a=blog&d=blog"><input type="button" class="btn_global btn_cancel" value="{/global.return/}"></a>
				</div>
			</div>
		<?php }?>
	<?php
	}elseif($c['manage']['do']=='category'){
		//博客分类
		if($c['manage']['page']=='index'){
			//博客分类列表
			echo ly200::load_static('/static/js/plugin/dragsort/dragsort-0.5.1.min.js');
			?>
			<script type="text/javascript">$(document).ready(function(){content_obj.blog_category_init()});</script>
			<div class="inside_table center_container_1000">
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
							<input type="hidden" name="a" value="blog" />
							<input type="hidden" name="d" value="<?=$c['manage']['do'];?>" />
							<input type="hidden" name="p" value="<?=$c['manage']['page'];?>" />
						</form>
					</div>
					<ul class="list_menu_button">
						<li><a class="add" href="./?m=content&a=blog&d=<?=$c['manage']['do'];?>&p=edit">{/global.add/}</a></li>
						<li><a class="del" href="javascript:;">{/global.del/}</a></li>
					</ul>
				</div>
				<div class="clear"></div>
				<?php
				$where='1';//条件
				$Keyword && $where.=" and Category_en like '%$Keyword%'";
				$category_row=str::str_code(db::get_all('blog_category', $where, '*', $c['my_order'].'CateId desc'));
				if($category_row){
				?>
					<table border="0" cellpadding="5" cellspacing="0" class="r_con_table">
						<thead>
							<tr>
								<td width="1%" nowrap="nowrap" class="myorder"></td>
								<td width="1%" nowrap="nowrap"><?=html::btn_checkbox('select_all');?></td>
								<td width="75%" nowrap="nowrap">{/global.category/}</td>
								<td width="110" nowrap="nowrap">{/global.operation/}</td>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=1;
							foreach($category_row as $v){
							?>
								<tr id="<?=$v['CateId'];?>">
									<td nowrap="nowrap" class="myorder move_myorder" data="move_myorder"><i class="icon_myorder"></i></td>
									<td nowrap="nowrap"><?=html::btn_checkbox('select', $v['CateId']);?></td>
									<td nowrap="nowrap"><?=$v['Category'.$c['lang']];?></td>
									<td nowrap="nowrap" class="operation">
										<a href="./?m=content&a=blog&d=category&p=edit&CateId=<?=$v['CateId'];?>">{/global.edit/}</a>
										<a class="del item" href="./?do_action=content.blog_category_del_bat&id=<?=$v['CateId'];?>" rel="del">{/global.del/}</a>
									</td>
								</tr>
							<?php }?>
						</tbody>
					</table>
				<?php
				}else{//没有数据
					echo html::no_table_data(($Keyword?0:1), './?m=content&a=blog&d=category&p=edit');
				}?>
			</div>
		<?php
		}else{
			//博客分类编辑
		?>
			<script type="text/javascript">$(document).ready(function(){content_obj.blog_category_edit_init()});</script>
			<div class="center_container_1000">
				<div class="global_container">
					<form id="blog_edit_form" class="global_form">
						<h3 class="big_title"><?=$CateId?'{/global.edit/}':'{/global.add/}';?></h3>
						<div class="rows">
							<label>{/global.name/}</label>
							<div class="input"><input name="Category_en" value="<?=$category_row['Category_en'];?>" type="text" class="box_input" maxlength="100" size="35" notnull> <font class="fc_red">*</font></div>
						</div>
						<div class="rows">
							<label></label>
							<div class="input input_button">
								<input type="button" class="btn_global btn_submit" value="{/global.save/}">
								<a href="./?m=content&a=blog&d=category"><input type="button" class="btn_global btn_cancel" value="{/global.return/}"></a>
							</div>
						</div>
						<input type="hidden" name="CateId" value="<?=$CateId;?>" />
						<input type="hidden" name="do_action" value="content.blog_category_edit">
					</form>
				</div>
			</div>
		<?php }?>
	<?php
	}elseif($c['manage']['do']=='review'){
		//博客评论
		if($c['manage']['page']=='index'){ //博客评论列表
		?>
			<script type="text/javascript">$(document).ready(function(){content_obj.blog_review_init()});</script>
			<div class="inside_table center_container_1000">
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
							<input type="hidden" name="a" value="blog" />
							<input type="hidden" name="d" value="<?=$c['manage']['do'];?>" />
							<input type="hidden" name="p" value="<?=$c['manage']['page'];?>" />
						</form>
					</div>
					<ul class="list_menu_button">
						<li><a class="del" href="javascript:;">{/global.del/}</a></li>
					</ul>
				</div>
				<div class="clear"></div>
				<?php
				$page_count=20;
				$where='1';
				$Keyword && $where.=" and (Email like '%$Keyword%' or Name like '%$Keyword%')";
				if($Keyword){
					$blog_id_str = '(0';
					$blog_id_row=db::get_all('blog', "Title like '%$Keyword%'", 'AId');
					foreach((array)$blog_id_row as $k => $v){
						$blog_id_str.=','.$v['AId'];
					}
					$blog_id_str.=')';
					$blog_id_str!='(0)' && $where.="or AId in $blog_id_str";
				}
				$review_row=str::str_code(db::get_limit_page('blog_review', $where, '*', 'RId desc', (int)$_GET['page'], $page_count));

				if($review_row[0]){
				?>
					<table border="0" cellpadding="5" cellspacing="0" class="r_con_table">
						<thead>
							<tr>
								<td width="1%" nowrap="nowrap"><?=html::btn_checkbox('select_all');?></td>
								<td width="30%" nowrap="nowrap">{/global.title/}</td>
								<td width="15%" nowrap="nowrap">{/global.name/}</td>
								<td width="15%" nowrap="nowrap">{/global.email/}</td>
								<td width="5%" nowrap="nowrap">{/content.blog.review.is_reply/}</td>
								<td width="15%" nowrap="nowrap">{/global.time/}</td>
								<td width="10%" nowrap="nowrap" class="last">{/global.operation/}</td>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=1;
							foreach($review_row[0] as $v){
								$blog_row=db::get_one('blog', "AId='{$v['AId']}'");;
							?>
								<tr>
									<td nowrap="nowrap"><?=html::btn_checkbox('select', $v['RId']);?></td>
									<td><a href="<?=web::get_url($blog_row, 'blog')?>" target="_blank"><?=$blog_row['Title'];?></a></td>
									<td><?=$v['Name'];?></td>
									<td nowrap="nowrap"><?=$v['Email'];?></td>
									<td nowrap="nowrap"><?=str::str_color($v['Reply']?'{/global.n_y.1/}':'{/global.n_y.0/}', $v['Reply']?1:0);?></td>
									<td nowrap="nowrap"><?=date('Y-m-d H:i:s', $v['AccTime']);?></td>
									<td nowrap="nowrap" class="operation">
										<a href="./?m=content&a=blog&d=review&p=view&RId=<?=$v['RId'];?>">{/global.edit/}</a>
										<a class="del item" href="./?do_action=content.blog_review_del&id=<?=$v['RId'];?>" rel="del">{/global.del/}</a>
									</td>
								</tr>
							<?php }?>
						</tbody>
					</table>
					<?=html::turn_page($review_row[1], $review_row[2], $review_row[3], '?'.str::query_string('page').'&page=');?>
				<?php
				}else{//没有数据
					echo html::no_table_data(0);
				}?>
			</div>
		<?php
		}else{
			//博客评论编辑
			$RId=(int)$_GET['RId'];
			$review_row=str::str_code(db::get_one('blog_review', "RId='$RId'"));
			!$review_row && js::location('./?m=content&a=blog&d=review');
			$blog_row=db::get_one('blog', "AId='{$review_row['AId']}'");
			?>
			<script type="text/javascript">$(document).ready(function(){content_obj.blog_review_reply_init()});</script>
			<div class="center_container_1000">
				<div class="global_container">
					<form id="blog_review_edit_form" class="global_form">
						<a href="javascript:history.back(-1);" class="return_title">
							<span class="return"><?=$blog_row['Title']; ?></span>
						</a>
						<div class="review_box">
							<div class="msg"><?=$review_row['Content'];?></div>
							<div class="info">
								<?=$review_row['Name'];?>
								(<?=$review_row['Email'];?>)
								<span><?=date('Y-m-d H:i:s', $review_row['AccTime']);?></span>
							</div>
						</div>
						<?php if($review_row['Reply']){ ?>
							<div class="review_box">
								<div class="msg"><?=$review_row['Reply'];?></div>
								<div class="info">
									{/content.blog.review.manager/}
									<span><?=date('Y-m-d H:i:s', $review_row['ReplyTime']);?></span>
								</div>
							</div>
						<?php }else{ ?>
							<div class="form_remark_log" parent_null>
								<div class="form_box">
									<div class="remark_left"><div><input type="text" class="box_input" name="Reply" notnull parent_null="1" placeholder="{/content.blog.review.entry/}"></div></div>
									<input type="button" class="btn_save btn_submit" value="{/content.blog.review.reply/}">
								</div>
							</div>
						<?php } ?>
						<input type="hidden" id="RId" name="RId" value="<?=$RId;?>" />
						<input type="hidden" name="do_action" value="content.blog_review_reply" />
					</form>
				</div>
			</div>
		<?php
		}
	}
	?>
</div>