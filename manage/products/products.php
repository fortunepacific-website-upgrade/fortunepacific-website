<?php !isset($c) && exit();?>
<?php
manage::check_permit('products.products', 2);//检查权限

if($c['manage']['do']=='index'){
	//产品列表页面
	$prod_show=array();
	$cfg_row=str::str_code(db::get_all('config', 'GroupId="products_show"'));
	foreach($cfg_row as $v){
		$prod_show[$v['Variable']]=$v['Value'];
	}
	$used_row=str::json_data(htmlspecialchars_decode($prod_show['Config']), 'decode');

	//获取类别列表
	$cate_ary=str::str_code(db::get_all('products_category', '1', '*'));
	$category_ary=array();
	foreach((array)$cate_ary as $v){
		$category_ary[$v['CateId']]=$v;
	}
	$category_count=count($category_ary);
	unset($cate_ary);

	//产品列表
	$Keyword=str::str_code($_GET['Keyword']);
	$CateId=(int)$_GET['CateId'];
	$Other=(int)$_GET['Other'];

	$where='1';//条件
	$page_count=10;//显示数量
	$Keyword && $where.=" and (Name{$c['lang']} like '%$Keyword%' or Number like '%$Keyword%')";
	if($CateId){
		$where.=' and '.category::get_search_where_by_CateId($CateId, 'products_category');
		$category_one=str::str_code(db::get_one('products_category', "CateId='$CateId'"));
		$UId=$category_one['UId'];
		$UId!='0,' && $TopCateId=category::get_top_CateId_by_UId($UId);
	}
	if($Other){
		switch($Other){
			case 1: $where.=' and IsNew=1'; break;
			case 2: $where.=' and IsHot=1'; break;
			case 3: $where.=' and IsBestDeals=1'; break;
			case 4: $where.=' and IsIndex=1'; break;
			case 5: $where.=' and IsMember=1'; break;
		}
	}
	$products_row=str::str_code(db::get_limit_page('products', $where, '*', ((int)$used_row['manage_myorder']?$c['my_order']:'').'ProId desc', (int)$_GET['page'], $page_count));
}
?>
<div id="products" class="r_con_wrap">
	<?php if($c['manage']['do']=='index'){?>
		<script type="text/javascript">$(document).ready(function(){products_obj.products_init();});</script>
		<div class="inside_container">
			<h1>{/module.products.products/}</h1>
		</div>
		<div class="inside_table">
			<div class="list_menu">
				<ul class="list_menu_button">
					<li><a class="add" href="./?m=products&a=products&d=edit">{/global.add/}</a></li>
					<li><a class="del" href="javascript:;">{/global.del/}</a></li>
					<li><a class="explode export" href="javascript:;">{/global.explode/}</a></li>
				</ul>
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
									<div class="box_select"><?=category::ouput_Category_to_Select('CateId', '', 'products_category', 'UId="0,"', 1, '', '{/global.select_index/}');?></div>
								</div>
							</div>
							<div class="rows item clean">
								<label>{/products.attribute.attribute/}</label>
								<div class="input">
									<div class="box_select">
										<select name="Other">
											<option value="0">{/global.select_index/}</option>
											<option value="1">{/products.products.is_new/}</option>
											<option value="2">{/products.products.is_hot/}</option>
											<option value="3">{/products.products.is_best_deals/}</option>
											<option value="4">{/products.products.is_index/}</option>
											<option value="5">{/products.products.is_member/}</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="clear"></div>
						<input type="hidden" name="m" value="products" />
						<input type="hidden" name="a" value="products" />
					</form>
				</div>
			</div>
			<?php
			if($products_row[0]){
			?>
				<table border="0" cellpadding="5" cellspacing="0" class="r_con_table">
				<thead>
					<tr>
						<td width="1%" nowrap="nowrap"><?=html::btn_checkbox('select_all');?></td>
						<td width="3%" nowrap="nowrap">{/global.pic/}</td>
						<td width="50%" nowrap="nowrap">{/global.name/}</td>
						<td width="10%" nowrap="nowrap">{/global.edit_time/}</td>
						<td width="10%" nowrap="nowrap">{/global.my_order/}</td>
						<td width="6%" nowrap="nowrap">{/global.operation/}</td>
					</tr>
				</thead>
				<tbody>
					<?php
					$i=1;
					foreach($products_row[0] as $v){
						$img=img::get_small_img($v['PicPath_0'], end($c['manage']['resize_ary']['products']));
						$name=$v['Name'.$c['lang']];
						$url=web::get_url($v, 'products', $c['lang']);
					?>
						<tr>
							<td nowrap="nowrap"><?=html::btn_checkbox('select', $v['ProId']);?></td>
							<td nowrap="nowrap"><div class="g_img_box"><a href="<?=$url;?>" target="_blank"><img src="<?=$img;?>" /></a></div></td>
							<td class="info">
								<a class="name" href="<?=$url;?>" target="_blank"><?=$name;?></a>
								<?=$v['Number']?"<div class='number'>#{$v['Number']}</div>":'';?>
								<div class="classify" cateid="<?=$v['CateId'];?>">
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
								</div>
                                <div class="clean">
									<?=$v['IsNew']?'<div class="other_box fl">{/products.products.is_new/}</div>':'';?>
									<?=$v['IsHot']?'<div class="other_box fl">{/products.products.is_hot/}</div>':'';?>
									<?=$v['IsBestDeals']?'<div class="other_box fl">{/products.products.is_best_deals/}</div>':'';?>
									<?=$v['IsIndex']?'<div class="other_box fl">{/products.products.is_index/}</div>':'';?>
									<?=$v['SaleOut']?'<div class="other_box fl">{/products.products.is_sold_out/}</div>':'';?>
									<?=$v['IsMember']?'<div class="other_box fl">{/products.products.is_member/}</div>':'';?>
                                </div>
							</td>
							<td nowrap="nowrap"><?=$v['EditTime']?date('Y-m-d', $v['EditTime']):'N/A';?></td>
							<td nowrap="nowrap"class="myorder_select" data-num="<?=$v['MyOrder'];?>">{/global.my_order_ary.<?=$v['MyOrder'];?>/}</td>
							<td nowrap="nowrap" class="operation">
								<a href="./?m=products&a=products&d=edit&ProId=<?=$v['ProId'];?>">{/global.edit/}</a>
								<dl>
									<dt><a href="javascript:;">{/global.more/}<i></i></a></dt>
									<dd class="drop_down">
										<a class="copy item" href="./?do_action=products.products_copy&ProId=<?=$v['ProId'];?>">{/products.products.copy/}</a>
										<a class="del item" href="./?do_action=products.products_del&id=<?=$v['ProId'];?>" rel="del">{/global.del/}</a>
									</dd>
								</dl>
							</td>
						</tr>
					<?php }?>
				</tbody>
			</table>
				<?=html::turn_page($products_row[1], $products_row[2], $products_row[3], '?'.str::query_string('page').'&page=');?>
			<?php
			}else{//没有数据
				echo html::no_table_data(($Keyword?0:1), './?m=products&a=products&d=edit');
			}
			?>
		</div>
		<div id="myorder_select_hide" class="hide"><?=html::form_select(manage::language('{/global.my_order_ary/}'), "MyOrder[]", '');?></div>
	<?php
	}else{
		//产品编辑
		$ProId=(int)$_GET['ProId'];
		if($ProId){
			$products_row=str::str_code(db::get_one('products', "ProId='$ProId'"));
			$products_seo_row=str::str_code(db::get_one('products_seo', "ProId='$ProId'"));
			$seo_row = $products_row + $products_seo_row;
			$products_description_row=str::str_code(db::get_one('products_description', "ProId='$ProId'"));
		}
		//产品显示设置
		$products_config=db::get_all('config', "GroupId='products'");
		foreach($products_config as $k=>$v){
			$c['manage']['config'][$v['GroupId']][$v['Variable']]=$v['Variable']=='Config'?str::json_data($v['Value'], 'decode'):$v['Value'];
		}

		$products_row['CateId'] && $uid=category::get_UId_by_CateId($products_row['CateId']);
		$uid!='0,' && $TopCateId=category::get_top_CateId_by_UId($uid);
		if($products_row['AttrId']){
			$AttrId=$products_row['AttrId'];
		}else{
			$products_category_row=str::str_code(db::get_one('products_category', "CateId='{$TopCateId}'"));
			$AttrId=$products_category_row['AttrId'];
		}
	?>
		<?=ly200::load_static('/static/js/plugin/ckeditor/ckeditor.js', '/static/js/plugin/dragsort/dragsort-0.5.1.min.js');?>
		<script src="/static/js/plugin/file_upload/js/vendor/jquery.ui.widget.js"></script>
		<script src="/static/js/plugin/file_upload/js/external/tmpl.js"></script>
		<script src="/static/js/plugin/file_upload/js/external/load-image.js"></script>
		<script src="/static/js/plugin/file_upload/js/external/canvas-to-blob.js"></script>
		<script src="/static/js/plugin/file_upload/js/external/jquery.blueimp-gallery.js"></script>
		<script src="/static/js/plugin/file_upload/js/jquery.iframe-transport.js"></script>
		<script src="/static/js/plugin/file_upload/js/jquery.fileupload.js?v=1"></script>
		<script src="/static/js/plugin/file_upload/js/jquery.fileupload-process.js"></script>
		<script src="/static/js/plugin/file_upload/js/jquery.fileupload-image.js"></script>
		<script src="/static/js/plugin/file_upload/js/jquery.fileupload-audio.js"></script>
		<script src="/static/js/plugin/file_upload/js/jquery.fileupload-video.js"></script>
		<script src="/static/js/plugin/file_upload/js/jquery.fileupload-validate.js"></script>
		<script src="/static/js/plugin/file_upload/js/jquery.fileupload-ui.js?v=1"></script>
		<!--[if (gte IE 8)&(lt IE 10)]><script src="/static/js/plugin/file_upload/js/cors/jquery.xdr-transport.js"></script><![endif]-->
		<script type="text/javascript">$(document).ready(function(){products_obj.products_edit_init()});</script>
		<form id="edit_form" name="products_form" class="global_form" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
			<div class="left_container">
				<div class="left_container_side">
					<?php /***************************** 产品图片 Start *****************************/?>
					<div class="global_container">
						<div class="big_title">{/products.products.pic/}</div>
						<div class="rows clean">
							<div class="input">
								<div class="tips">{/products.products.pic_notes/}</div>
								<div class="multi_img upload_file_multi pro_multi_img" id="PicDetail">
									<?php
									$j=0;
									for($i=0; $i<5; ++$i){
										$pic=$products_row["PicPath_{$i}"];
										$isFile=is_file($c['root_path'].$pic)?1:0;
									?>
										<dl class="img<?=$isFile?' isfile':'';?>" num="<?=$i;?>">
											<dt class="upload_box preview_pic">
												<input type="button" id="PicUpload_<?=$i;?>" class="btn_ok upload_btn" name="submit_button" value="{/global.upload_pic/}" />
												<input type="hidden" name="PicPath[]" value="<?=$pic;?>" data-value="<?=img::get_small_img($pic, '240x240');?>" save="<?=$isFile;?>" />
											</dt>
											<dd class="pic_btn">
												<a href="javascript:;" class="edit"><i class="icon_edit_white"></i></a>
												<a href="javascript:;" class="del" rel="del"><i class="icon_del_white"></i></a>
												<a href="<?=$isFile?$pic:'javascript:;';?>" class="zoom" target="_blank"><i class="icon_search_white"></i></a>
											</dd>
										</dl>
									<?php
										++$j;
									}
									?>
									<?php if($j<5){?>
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
					</div>
					<?php /***************************** 产品图片 End *****************************/?>
					<?php /***************************** 基础信息 Start *****************************/?>
					<div class="global_container">
						<div class="big_title">{/global.base_info/}</div>
						<div class="rows clean">
							<label>{/products.language/}</label>
							<div class="input lang_list">
								<?php
								$this_pro_default_lang = $c['manage']['config']['LanguageDefault'];
								$first_lang = "";
								foreach($c['manage']['language_web'] as $k=>$v){
									(!$ProId || $products_row['Lang_'.$v]) && !$first_lang && $first_lang = $v;
									
								?>
									<span class="input_checkbox_box <?=!$ProId || $products_row['Lang_'.$v]?'checked':'';?>">
										<span class="input_checkbox">
											<input type="checkbox" name="Lang_<?=$v;?>" value="1" <?=!$ProId || $products_row['Lang_'.$v]?'checked':'';?> lang="<?=$v;?>" />
										</span><font>{/language.<?=$v;?>/}</font>
									</span>
								<?php }?>
							</div>
						</div>
						<?php
						foreach($c['manage']['language_web'] as $k=>$v){
							if($v==$c['manage']['config']['LanguageDefault'] && !$products_row['Lang_'.$v]){
								$this_pro_default_lang = $first_lang;
								break;
							}
						}
						?>
						<input class="pro_default_lang" type="hidden" value="<?=$this_pro_default_lang;?>" />
						<div class="rows clean translation">
							<label>{/global.name/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
							<div class="input"><?=manage::form_edit($products_row, 'text', 'Name', 50, 255, 'notnull');?></div>
						</div>
						<div class="rows clean">
							<label>{/global.category/}<span class="tool_tips_ico" content='{/products.products.category_notes/}'></span></label>
							<div class="input">
								<div class="classify">
									<div class="box_select fl"><?=category::ouput_Category_to_Select('CateId', $products_row['CateId'], 'products_category', 'UId="0,"', 1, 'notnull', '{/global.select_index/}');?></div>
									<a href="javascript:;" class="btn_global btn_add_item btn_expand fl" id="btn_expand">{/global.add/}</a>
								</div>
								<div class="clear"></div>
								<ul class="expand_list">
									<?php
									if($products_row['ExtCateId']){
										$ext_ary=explode(',',substr($products_row['ExtCateId'], 1, -1));
										foreach((array)$ext_ary as $v){
											echo '<li><div class="box_select fl">'.category::ouput_Category_to_Select('ExtCateId[]', $v, 'products_category', 'UId="0,"', 1, 'notnull', '{/global.select_index/}').'</div><a href="javascript:;" class="close fl"><img src="/static/ico/no.png" /></a></li>';
										}
									}?>
								</ul>
							</div>
						</div>
						<div class="rows clean">
							<label>{/products.products.number/}</label>
							<div class="input"><input type="text" class="box_input" name="Number" value="<?=$products_row['Number'];?>" size="50" maxlength="255" /></div>
						</div>
						<?php if($c['manage']['config']['products']['Config']['show_price'] && $c['FunVersion']>=1){?>
							<div class="rows clean">
								<label>{/products.products.price/}</label>
								<div class="input">
									<span class="unit_input"><b><?=$c['manage']['config']['products']['symbol'];?></b><input type="text" class="box_input" name="Price_0" value="<?=$products_row['Price_0'];?>" size="5" maxlength="10" /></span>
								</div>
							</div>
						<?php }?>
						<div class="rows clean">
							<label>{/global.my_order/}<span class="tool_tips_ico" content="{/products.products.myorder_notes/}"></span></label>
							<div class="input">
								<div class="box_select width_90"><?=html::form_select(manage::language('{/global.my_order_ary/}'), 'MyOrder', $products_row['MyOrder']);?></div>
							</div>
						</div>
						<div class="rows clean translation">
							<label>{/global.brief_description/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
							<div class="input"><?=manage::form_edit($products_row, 'textarea', 'BriefDescription');?></div>
						</div>
						<div class="rows clean translation">
							<label>{/global.description/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
							<div class="input"><?=manage::form_edit($products_description_row, 'editor', 'Description');?></div>
						</div>
						<div class="rows clean">
							<label>{/products.products.tab/}</label>
							<span class="input">
								<?php for($i=0; $i<$c['description_count']; ++$i){?>
									{/products.products.tab/}<?=$i+1;?> <div class="switchery<?=$products_description_row['IsOpen_'.$i]?' checked':'';?>" rel="description_<?=$i;?>">
										<input type="checkbox" name="IsOpen_<?=$i;?>" value="1"<?=$products_description_row['IsOpen_'.$i]?' checked':'';?>>
										<div class="switchery_toggler"></div>
										<div class="switchery_inner">
											<div class="switchery_state_on"></div>
											<div class="switchery_state_off"></div>
										</div>
									</div>&nbsp;&nbsp;&nbsp;&nbsp;
								<?php }?>
							</span>
							<div class="clear"></div>
						</div>
						<?php for($i=0; $i<$c['description_count']; ++$i){?>
							<div class="description_<?=$i;?> <?=$products_description_row['IsOpen_'.$i]?'':'g_hide';?>">
								<div class="rows clean translation">
									<label>{/products.products.tab/}<?=$i+1;?> ({/global.title/})<div class="tab_box"><?=manage::html_tab_button();?></div></label>
									<span class="input"><?=manage::form_edit($products_description_row, 'text', 'Title_'.$i, 35, 150);?></span>
									<div class="clear"></div>
								</div>
								<div class="rows clean translation">
									<label>{/products.products.tab/}<?=$i+1;?> ({/global.contents/})<div class="tab_box"><?=manage::html_tab_button();?></div></label>
									<span class="input"><?=manage::form_edit($products_description_row, 'editor', 'Description_'.$i);?></span>
									<div class="clear"></div>
								</div>
							</div>
						<?php }?>
					</div>
					<?php /***************************** 基础信息 End *****************************/?>
					<?php /***************************** 产品属性 Start *****************************/?>
					<div class="global_container">
						<div class="big_title">{/products.attribute.attribute/}</div>
						<input type="hidden" name="AttrId" id="attribute_hide" value="<?=$AttrId;?>" />
						<div class="attribute"></div>
					</div>
					<?php
					if($AttrId){
						$Attr=htmlspecialchars_decode($products_row['Attr']);
					?>
						<script type="text/javascript">products_obj.products_edit_attr_select('<?=$TopCateId;?>', '<?=urlencode($Attr);?>');</script>
					<?php }?>
					<?php /***************************** 产品属性 End *****************************/?>
					<?php /***************************** SEO Start *****************************/?>
					<?php include("static/inc/seo.php");?>
					<?php /***************************** SEO End *****************************/?>
				</div>
			</div>
			<div class="right_container">
				<div class="global_container">
					<?php /***************************** 标签 Start *****************************/?>
					<div class="big_title">{/products.products.label/}</div>
					<div class="rows tags_row clean">
						<label>{/products.products.label/}</label>
						<div class="input">
							<?php
							$tags_ary=array('IsIndex'=>'is_index', 'IsNew'=>'is_new', 'IsHot'=>'is_hot', 'IsBestDeals'=>'is_best_deals');
							foreach($tags_ary as $k=>$v){
							?>
								<span class="btn_choice <?=$products_row[$k]?'current':'';?>"><b>{/products.products.<?=$v;?>/}</b><input type="radio" name="<?=$k;?>" class="hide" value="1" <?=$products_row[$k]?'checked':'';?> /><i></i></span>
							<?php }?>
						</div>
					</div>
					<div class="rows tags_row clean">
						<label>{/global.other/}</label>
						<div class="input">
							<?php
							$tags_ary=array('IsMember'=>'is_member', 'SaleOut'=>'is_sold_out');
							foreach($tags_ary as $k=>$v){
							?>
								<span class="btn_choice <?=$products_row[$k]?'current':'';?>"><b>{/products.products.<?=$v;?>/}</b><input type="radio" name="<?=$k;?>" class="hide" value="1" <?=$products_row[$k]?'checked':'';?> /><i></i></span>
							<?php }?>
						</div>
					</div>
					<?php /***************************** 标签 End *****************************/?>
					<div class="blank25"></div>
					<?php /***************************** 文件上传 Start *****************************/?>
					<div class="rows_box">
						<div class="big_title">{/products.download.download/}</div>
						<div class="rows clean">
							<div class="input">
								<div class="row fileupload-buttonbar">
									<span class="btn_file btn-success fileinput-button">
										<i class="glyphicon glyphicon-plus"></i>
										<span>{/global.upload_file/}</span>
										<input type="file" name="Filedata" multiple>
									</span>
									<div class="fileupload-progress fade"><div class="progress-extended">&nbsp;</div></div>
									<div class="clear"></div>
									<div class="photo_multi_img template-box files"></div>
									<div class="photo_multi_img" id="PicDetail"></div>
								</div>
								<script id="template-upload" type="text/x-tmpl">
								{% for (var i=0, file; file=o.files[i]; i++) { %}
									<div class="template-upload fade">
										<div class="clear"></div>
										<div class="items">
											<p class="name">{%=file.name%}</p>
											<strong class="error text-danger"></strong>
										</div>
										<div class="items">
											<p class="size">Processing...</p>
											<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
										</div>
										<div class="items">
											{% if (!i) { %}
												<button class="btn_file btn-warning cancel">
													<i class="glyphicon glyphicon-ban-circle"></i>
													<span>{/global.cancel/}</span>
												</button>
											{% } %}
										</div>
										<div class="clear"></div>
									</div>
								{% } %}
								</script>
								<script id="template-download" type="text/x-tmpl">
								{% for (var i=0, file; file=o.files[i]; i++) { %}
									{% if (file.thumbnailUrl) { %}
										<div class="pic template-download fade hide">
											<div>
												<a href="javascript:;" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}" /><em></em></a>
												<a href="{%=file.url%}" class="zoom" target="_blank"></a>
												{% if (file.deleteUrl) { %}
													<button class="btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>{/global.del/}</button>
													<input type="checkbox" name="delete" value="1" class="toggle" style="display:none;">
												{% } %}
												<input type="hidden" name="PicPath[]" value="{%=file.url%}" disabled />
											</div>
											<input type="text" maxlength="30" class="form_input" value="{%=file.name%}" name="Name[]" placeholder="'+lang_obj.global.picture_name+'" disabled notnull />
										</div>
									{% } else { %}
										<div class="template-download fade hide">
											<div class="clear"></div>
											<div class="items">
												<p class="name">
													{% if (file.url) { %}
														<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
													{% } else { %}
														<span>{%=file.name%}</span>
													{% } %}
												</p>
												{% if (file.error) { %}
													<div><span class="label label-danger">Error</span> {%=file.error%}</div>
												{% } %}
											</div>
											<div class="items">
												<span class="size">{%=o.formatFileSize(file.size)%}</span>
											</div>
											<div class="items">
												{% if (file.deleteUrl) { %}
													<button class="btn_file btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
														<i class="glyphicon glyphicon-trash"></i>
														<span>{/global.del/}</span>
													</button>
													<input type="checkbox" name="delete" value="1" class="toggle" style="display:none;">
												{% } else { %}
													<button class="btn_file btn-warning cancel">
														<i class="glyphicon glyphicon-ban-circle"></i>
														<span>{/global.cancel/}</span>
													</button>
												{% } %}
											</div>
											<div class="clear"></div>
										</div>
									{% } %}
								{% } %}
								</script>
							</div>
						</div>
						<div class="rows file_download_row clean">
							<div class="input">
								<ul>
									<li><div>{/products.download.file_path/}</div><div class="pwd">{/products.download.download_password/}</div></li>
									<?php for($i=0; $i<5; ++$i){?>
										<li>
											<div><input type="text" name="FilePath_<?=$i;?>" id="FilePath_<?=$i;?>" class="box_input filepath" value="<?=$products_row["FilePath_$i"];?>" maxlength="100" /></div>
											<div class="pwd"><input type="text" name="FilePwd_<?=$i;?>" class="box_input" value="<?=$products_row["FilePwd_$i"];?>" maxlength="50" /></div>
											<input type="hidden" name="FileName_<?=$i;?>" id="FileName_<?=$i;?>" value="<?=$products_row["FileName_$i"];?>" />
											<input type="hidden" name="sFilePath_<?=$i;?>" value="<?=$products_row["FilePath_$i"];?>" />
											<input type="hidden" name="sFileName_<?=$i;?>" value="<?=$products_row["FileName_$i"];?>" />
										</li>
									<?php }?>
								</ul>
							</div>
						</div>
					</div>
					<?php /***************************** 文件上传 End *****************************/?>
					<div class="blank25"></div>
					<?php /***************************** 平台导流 Start *****************************/?>
					<?php
					$platform_ary=array('amazon','aliexpress','wish','ebay','alibaba');
					$platform=str::json_data(str::str_code($products_row['Platform'],'htmlspecialchars_decode'),'decode');
					?>
					<div class="big_title">{/products.products.platform/}</div>
					<div class="rows platform_rows clean">
						<?php foreach($platform_ary as $k=>$v){?>
							<span class="item<?=$platform[$v]?' current':'';?>"><img src="/static/manage/images/products/icon_platform_<?=$v;?>.png" /></span>
						<?php }?>
					</div>
					<div class="blank15"></div>
					<?php foreach($platform_ary as $k=>$v){?>
						<div class="rows clean platform_url_rows"<?=$platform[$v]?'':' style="display:none;"'?>>
							<label>{/products.products.platform_url/}<div><img src="/static/manage/images/products/icon_platform_<?=$v;?>.png" /></div></label>
							<div class="input"><input type="text" name="Platform_<?=$k;?>" value="<?=$platform[$v];?>" class="box_input" size="45" /></div>
						</div>
					<?php }?>
					<?php /***************************** 平台导流 End *****************************/?>
				</div>
			</div>
			<div class="rows">
				<label></label>
				<span class="input">
					<input type="submit" class="btn_global btn_submit" name="submit_button" value="{/global.submit/}" />
					<input type="button" class="btn_global btn_drafts" value="{/products.products.save_drafts/}" style="display:none;" />
					<input type="button" class="btn_global btn_translation" value="{/global.translation/}">
					<a href="<?=$_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:'./?m=products&a=products';?>" class="btn_global btn_cancel">{/global.return/}</a>
				</span>
				<div class="clear"></div>
			</div>
			<input type="hidden" id="all_attr" value="" />
			<input type="hidden" id="check_attr" value="" />
			<input type="hidden" id="ext_attr" value="<?=$products_row['ExtAttr'];?>" />
			<input type="hidden" id="ProId" name="ProId" value="<?=$ProId;?>" />
			<input type="hidden" name="do_action" value="products.products_edit" />
			<input type="hidden" id="back_action" name="back_action" value="<?=$_SERVER['HTTP_REFERER'];?>" />
		</form>
		<?php include("static/inc/translation.php");?>
	<?php }?>
</div>