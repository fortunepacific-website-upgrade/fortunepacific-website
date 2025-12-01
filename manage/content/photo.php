<?php !isset($c) && exit();?>
<?php
$c['manage']['do']!='choice' && manage::check_permit('content.photo', 2);//检查权限

if($c['manage']['do']=='index' || $c['manage']['do']=='photo_upload' || $c['manage']['do']=='category' || $c['manage']['do']=='category_edit' || $c['manage']['do']=='choice'){
	$IsSystem='';
	$CateId=(int)$_GET['CateId'];
	$CateMenu=$_GET['CateMenu'];
	if($CateMenu){
		$CateMenu=explode(':', $CateMenu);
		if($CateMenu[0]=='IsSystem'){
			$IsSystem=$CateMenu[1];
		}elseif($CateMenu[0]=='CateId'){
			$CateId=(int)$CateMenu[1];
		}
	}
	if($CateId){
		$category_one=str::str_code(db::get_one('photo_category', "CateId='$CateId'"));
		!$category_one && js::location('./?m=content&a=photo');
		$UId=$category_one['UId'];
		$UId!='0,' && $TopCateId=category::get_top_CateId_by_UId($UId);
		$column=$category_one['Category'];
	}
	if(in_array($IsSystem, $c['manage']['photo_type'])){
		$column="{/content.photo.photo_type.{$IsSystem}/}";
	}

	$ParentId=(int)$_GET['ParentId'];
}

if($c['manage']['do']=='index' || $c['manage']['do']=='choice'){
?>
	<script src="/static/js/plugin/file_upload/js/vendor/jquery.ui.widget.js"></script>
	<script src="/static/js/plugin/file_upload/js/external/tmpl.js"></script>
	<script src="/static/js/plugin/file_upload/js/external/load-image.js"></script>
	<script src="/static/js/plugin/file_upload/js/external/canvas-to-blob.js"></script>
	<script src="/static/js/plugin/file_upload/js/external/jquery.blueimp-gallery.js"></script>
	<script src="/static/js/plugin/file_upload/js/jquery.iframe-transport.js"></script>
	<script src="/static/js/plugin/file_upload/js/jquery.fileupload.js"></script>
	<script src="/static/js/plugin/file_upload/js/jquery.fileupload-process.js"></script>
	<script src="/static/js/plugin/file_upload/js/jquery.fileupload-image.js"></script>
	<script src="/static/js/plugin/file_upload/js/jquery.fileupload-audio.js"></script>
	<script src="/static/js/plugin/file_upload/js/jquery.fileupload-video.js"></script>
	<script src="/static/js/plugin/file_upload/js/jquery.fileupload-validate.js"></script>
	<script src="/static/js/plugin/file_upload/js/jquery.fileupload-ui.js?v=1"></script>
	<!--[if (gte IE 8)&(lt IE 10)]><script src="/static/js/plugin/file_upload/js/cors/jquery.xdr-transport.js"></script><![endif]-->
<?php }?>
<?php if($c['manage']['do']=='index'||$c['manage']['do']=='choice'){
	$Keyword=$_GET['Keyword'];
	$where='1';//条件
	$page_count=100;//显示数量
	if($CateId){
		$where.=' and '.category::get_search_where_by_CateId($CateId, 'photo_category');
	}elseif(in_array($IsSystem, $c['manage']['photo_type'])){
		$where.=" and CateId=0 and IsSystem='$IsSystem'";
	}
	$Keyword && $where.=" and Name like '%$Keyword%'";
	$row_count=db::get_row_count('photo',$where);
	$total_pages=ceil($row_count/$page_count);
} ?>
<div id="photo" class="r_con_wrap <?=$c['manage']['do']=='index' ? 'auto_load_photo' : ''; ?>" <?=$c['manage']['do']=='index' ? 'data-page="1" data-total-pages="'.$total_pages.'"' : ''; ?>>
	<?php if($c['manage']['do']!='choice'){?>
	<div class="inside_container">
		<h1><?=$c['manage']['do']=='move'?'{/global.move_to/}':'{/module.content.photo.module_name/}';?></h1>
		<?php if($c['manage']['do']!='choice' && $c['manage']['do']!='move'){?>
			<ul class="inside_menu">
				<li><a href="./?m=content&a=photo"<?=($c['manage']['do']=='index' || $c['manage']['do']=='photo_upload' || $c['manage']['do']=='choice')?' class="current"':'';?>>{/module.content.photo.list/}<?=$column?" ($column)":'';?></a></li>
				<li><a href="./?m=content&a=photo&d=category"<?=($c['manage']['do']=='category' || $c['manage']['do']=='category_edit')?' class="current"':'';?>>{/global.category/}</a></li>
			</ul>
		<?php }?>
	</div>
	<?php }?>
	<div class="list_menu <?=$c['manage']['do']=='choice' ? 'list_menu_photo': ''; ?> <?=$c['manage']['do']=='index' ? 'list_menu_photo_index': ''; ?>">
		<?php if($c['manage']['do']=='index'){?>
			<div class="search_form">
				<form method="get" action="?">
					<div class="k_input">
						<input type="text" name="Keyword" value="" class="form_input" size="15" autocomplete="off" />
						<input type="button" value="" class="more" />
					</div>
					<input type="submit" class="search_btn" value="{/global.search/}" />
					<div class="ext drop_down">
						<div class="rows item">
							<label>{/global.category/}</label>
							<span class="input">
								<div class="box_select">
									<select name="CateMenu">
										<option value="">{/global.select_index/}</option>
										<?php
										foreach($c['manage']['photo_type'] as $k=>$v){	//系统图片分类
										?>
											<option value="IsSystem:<?=$v;?>"<?=$IsSystem==$v?' selected':'';?>>├{/content.photo.photo_type.<?=$v;?>/}</option>
										<?php
										}
										$photo_category=str::str_code(db::get_all('photo_category', '1', '*', 'CateId asc'));
										$allcate_ary=array();
										foreach($photo_category as $k=>$v) $allcate_ary[$v['UId']][]=$v;
										foreach((array)$allcate_ary['0,'] as $v){
										?>
											<option value="CateId:<?=$v['CateId'];?>"<?=$CateId==$v['CateId']?' selected':'';?>>├<?=$v['Category'];?></option>
											<?php
											if($v['SubCateCount']){
												$len=count($allcate_ary["0,{$v['CateId']},"]);
												foreach((array)$allcate_ary["0,{$v['CateId']},"] as $v2){
											?>
												<option value="CateId:<?=$v2['CateId'];?>"<?=$CateId==$v2['CateId']?' selected':'';?>><?=$len>1?'｜├':'｜└'?><?=$v2['Category'];?></option>
										<?php
												}
											}
										}?>
									</select>
								</div>
							</span>
							<div class="clear"></div>
						</div>
					</div>
					<div class="clear"></div>
					<input type="hidden" name="m" value="content" />
					<input type="hidden" name="a" value="photo" />
				</form>
			</div>
			<ul class="list_menu_button">
				<li><a class="add" href="./?m=content&a=photo&d=add">{/global.upload_file/}</a></li>
				<li><a class="bat_open" href="javascript:;">{/global.select_all/}</a></li>
				<li><a class="un_bat_open" href="javascript:;">{/global.un_select_all/}</a></li>
				<li><a class="move" href="javascript:;">{/global.move/}</a></li>
				<li><a class="del" href="javascript:;">{/global.del/}</a></li>
			</ul>
		<?php
		}elseif($c['manage']['do']=='choice'){
			$obj=$_GET['obj'];
			$save=$_GET['save'];
			$id=$_GET['id'];//元素ID，可以是编译器，div等等。。
			$maxpic=(int)$_GET['maxpic'];//最大允许图片数，0为没有限制，1为单张上传
			$type=$_GET['type'];//记录根据那种类型尺寸压缩图片，例如products，info
		?>
			<div class="search_form">
				<form method="get" action="?">
					<div class="k_input">
						<input type="text" name="Keyword" value="" class="form_input" size="15" autocomplete="off" />
						<input type="button" value="" class="more" />
					</div>
					<input type="submit" class="search_btn" value="{/global.search/}" />
					<div class="ext drop_down">
						<div class="rows item">
							<label>{/global.category/}</label>
							<span class="input">
								<div class="box_select">
									<select name="CateMenu">
										<option value="">{/global.select_index/}</option>
										<?php
										foreach($c['manage']['photo_type'] as $k=>$v){	//系统图片分类
										?>
											<option value="IsSystem:<?=$v;?>"<?=$IsSystem==$v?' selected':'';?>>├{/content.photo.photo_type.<?=$v;?>/}</option>
										<?php
										}
										$photo_category=str::str_code(db::get_all('photo_category', '1', '*', 'CateId asc'));
										$allcate_ary=array();
										foreach($photo_category as $k=>$v) $allcate_ary[$v['UId']][]=$v;
										foreach((array)$allcate_ary['0,'] as $v){
										?>
											<option value="CateId:<?=$v['CateId'];?>"<?=$CateId==$v['CateId']?' selected':'';?>>├<?=$v['Category'];?></option>
											<?php
											if($v['SubCateCount']){
												$len=count($allcate_ary["0,{$v['CateId']},"]);
												foreach((array)$allcate_ary["0,{$v['CateId']},"] as $v2){
											?>
												<option value="CateId:<?=$v2['CateId'];?>"<?=$CateId==$v2['CateId']?' selected':'';?>><?=$len>1?'｜├':'｜└'?><?=$v2['Category'];?></option>
										<?php
												}
											}
										}?>
									</select>
								</div>
							</span>
							<div class="clear"></div>
						</div>
					</div>
					<div class="clear"></div>
					<input type="hidden" name="m" value="content" />
					<input type="hidden" name="a" value="photo" />
					<input type="hidden" name="d" value="choice" />
					<input type="hidden" name="id" value="<?=$id;?>" />
					<input type="hidden" name="type" value="<?=$type;?>" />
					<input type="hidden" name="maxpic" value="<?=$maxpic;?>" />
					<input type="hidden" name="obj" value="<?=$obj;?>" />
					<input type="hidden" name="save" value="<?=$save;?>" />
					<input type="hidden" name="iframe" value="1" />
				</form>
			</div>
			<div class="upload">
				<form name="upload_form" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data" class="up_input">
					<noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
					<div class="fileupload-buttonbar">
						<span class="btn_file btn-success fileinput-button">
							<i class="glyphicon glyphicon-plus"></i>
							<span>{/global.upload_file/}</span>
							<input type="file" name="Filedata" multiple>
						</span>
						<div class="fileupload-progress fade"><div class="progress-extended">&nbsp;</div></div>
						<div class="clear"></div>
						<div class="photo_multi_img template-box files"></div>
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
							<div class="pic template-download fade">
								<div>
									<a href="javascript:;" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}" /><em></em></a>
									<a href="{%=file.url%}" class="zoom" target="_blank"></a>
									{% if (file.deleteUrl) { %}
										<button class="btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>{/global.del/}</button>
										<input type="checkbox" name="delete" value="1" class="toggle" style="display:none;">
									{% } %}
									<input type="hidden" name="PicPath[]" value="{%=file.url%}" disabled />
								</div>
								<input type="text" maxlength="30" class="box_input" value="{%=file.name%}" name="Name[]" placeholder="'+lang_obj.global.picture_name+'" disabled notnull />
							</div>
						{% } else { %}
							<div class="template-download fade">
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
				</form>
				<div class="tips"></div>
			</div>
		<?php }elseif($c['manage']['do']=='category'){?>
			<ul class="list_menu_button">
				<li><a class="add" href="javascript:;" data-id="0">{/global.add/}</a></li>
				<li><a class="del" href="javascript:;">{/global.del/}</a></li>
			</ul>
		<?php }?>
	</div>
	<?php
	if($c['manage']['do']=='index'){
		//图片银行主页
	?>
		<script type="text/javascript">$(document).ready(function(){content_obj.photo_init(); content_obj.photo_upload_init()});</script>
		<div class="wrap_content photo_list">
			<form id="photo_list_form">
				<div class="photo_list_box" data-page-url="./?m=content&a=photo&d=index&CateId=<?=$CateId; ?>&Keyword=<?=$Keyword; ?>">
					<?php
					$photo_row=str::str_code(db::get_limit_page('photo', $where, '*', 'PId desc', (int)$_GET['page'], $page_count));
					foreach($photo_row[0] as $v){
						$small_img=img::get_small_img($v['PicPath'], '120x120');
						$small_img==$v['PicPath'] && $small_img=img::resize($v['PicPath'], 120, 120);
					?>
						<div class="item">
							<div class="img"><img src="<?=$small_img;?>" /><span></span><input type="checkbox" name="PId[]" class="PIds" value="<?=$v['PId'];?>" /><div class="img_mask"></div></div>
							<div class="name"><a href="<?=$v['PicPath']?>" target="_blank" title="<?=$v['Name'];?>"><?=$v['Name'];?></a></div>
						</div>
					<?php }?>
				</div>
				<div class="clear"></div>
				<input type="hidden" name="IsSystem" value="<?=$IsSystem;?>" />
				<input type="hidden" name="CateId" value="<?=$CateId;?>" />
				<input type="hidden" name="Page" value="<?=(int)$_GET['page'];?>" />
				<input type="hidden" name="do_action" value="content.photo_list_del">
			</form>
			<div class="clear"></div>
		</div>
		<?php /***************************** 图片银行编辑 Start *****************************/?>
		<div id="fixed_right">
			<div class="global_container box_photo_edit">
				<div class="top_title">{/global.upload_file/} <a href="javascript:;" class="close"></a></div>
				<form id="box_photo_edit" name="upload_form" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
					<div class="global_form">
						<div class="rows clean">
							<label>{/content.photo.category/}</label>
							<div class="input">
								<?=category::ouput_Category_to_NewSelect('CateId', $CateId, 'photo_category', 'UId="0,"', 1, 'class="box_input"', '{/content.photo.select_index/}', 1);?>
							</div>
						</div>
						<div class="rows clean">
							<label>{/global.upload_file/}</label>
							<div class="input">
								<noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
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
											<input type="text" maxlength="30" class="box_input" value="{%=file.name%}" name="Name[]" placeholder="'+lang_obj.global.picture_name+'" disabled notnull />
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
						<div class="rows clean">
							<label></label>
							<div class="input">
								<input type="button" class="btn_global btn_submit" value="{/global.save/}">
								<input type="button" class="btn_global btn_cancel" value="{/global.cancel/}">
							</div>
						</div>
						<input type="hidden" name="do_action" value="content.photo_upload" />
					</div>
				</form>
			</div>
			<div class="global_container box_move_edit">
				<form id="move_edit_form">
					<div class="top_title">{/content.photo.move_bat/}<a href="javascript:;" class="close"></a></div>
					<div class="global_form">
						<div class="rows clean">
							<label>{/global.move_to/}</label>
							<span class="input"><?=category::ouput_Category_to_NewSelect('CateId', '', 'photo_category', 'UId="0,"',1,'class="box_input"','{/global.select_index/}');?></span>
							<div class="clear"></div>
						</div>
						<input type="hidden" name="do_action" value="content.photo_move" />
						<div class="rows clean">
							<label></label>
							<div class="input">
								<input type="button" class="btn_global btn_submit" value="{/global.save/}">
								<input type="button" class="btn_global btn_cancel" value="{/global.cancel/}">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

		<?php /***************************** 图片银行编辑 End *****************************/?>
	<?php
	}elseif($c['manage']['do']=='choice'){
		//选择器，文件框调用页面
	?>
		<script type="text/javascript">$(document).ready(function(){content_obj.photo_choice_init()});</script>
		<div class="wrap_content photo_list auto_load_photo" data-page="1" data-total-pages="<?=$total_pages; ?>">
			<form id="photo_list_form">
				<div class="photo_list_box" data-page-url="./?m=content&a=photo&d=choice&CateId=<?=$CateId;?>&Keyword=<?=$Keyword;?>">
					<?php
					//图片银行列表
					$photo_row=str::str_code(db::get_limit_page('photo', $where, '*', 'PId desc', (int)$_GET['page'], $page_count));
					foreach($photo_row[0] as $v){
						$small_img=img::get_small_img($v['PicPath'], '120x120');
						$small_img==$v['PicPath'] && $small_img=img::resize($v['PicPath'], 120, 120);
					?>
						<div class="item">
							<div class="img"><img src="<?=$small_img;?>"<span></span><input type="checkbox" name="PId[]" value="<?=$v['PId'];?>" /><div class="img_mask"></div></div>
							<div class="name"><a href="<?=$v['PicPath']?>" target="_blank" title="<?=$v['Name'];?>"><?=$v['Name'];?></a></div>
						</div>
					<?php }?>
				</div>
				<input type="hidden" name="id" value="<?=$id;?>" />
				<input type="hidden" name="type" value="<?=$type;?>" />
				<input type="hidden" name="maxpic" value="<?=$maxpic;?>" />
				<input type="hidden" name="CateId" value="<?=$CateId;?>" />
				<input type="hidden" name="obj" value="<?=$obj;?>" />
				<input type="hidden" name="save" value="<?=$save;?>" />
				<input type="hidden" name="sort" value="|" />
				<input type="hidden" name="do_action" value="content.photo_choice" />
				<input type="hidden" name="file2BigName_hidden_text" value="" />
			</form>
			<div class="clear"></div>
		</div>
	<?php
	}elseif($c['manage']['do']=='category'){
		echo ly200::load_static('/static/js/plugin/dragsort/dragsort-0.5.1.min.js');
	?>
		<script type="text/javascript">$(document).ready(function(){content_obj.photo_category_init()});</script>
		<div class="inside_table">
			<div class="clear"></div>
			<table border="0" cellpadding="5" cellspacing="0" class="r_con_table">
				<thead>
					<tr>
						<td width="1%" nowrap="nowrap"></td>
						<td width="1%" nowrap="nowrap"><?=html::btn_checkbox('select_all');?></td>
						<td width="21%" nowrap="nowrap">{/global.category/}</td>
						<td width="65%" nowrap="nowrap">{/global.sub_category/}</td>
						<td width="5%" nowrap="nowrap">{/global.operation/}</td>
					</tr>
				</thead>
				<tbody>
					<?php
					//获取类别列表
					$cate_ary=str::str_code(db::get_all('photo_category', '1', '*', $c['my_order'].'CateId asc'));
					$all_cate_ary=$category_ary=array();
					foreach((array)$cate_ary as $v){
						$category_ary[$v['CateId']]=$v;
						$all_cate_ary[$v['UId']][]=$v;
					}
					$category_count=count($category_ary);
					unset($cate_ary);

					foreach((array)$all_cate_ary['0,'] as $v){
						$Name=$v['Category'];
						if($Keyword && !stripos($Name, $Keyword)) continue;
					?>
						<tr cateid="<?=$v['CateId'];?>" data="<?=htmlspecialchars(str::json_data($v));?>">
							<td nowrap="nowrap" class="myorder move_myorder" data="move_myorder"><i class="icon_myorder"></i></td>
							<td nowrap="nowrap"><?=html::btn_checkbox('select', $v['CateId']);?></td>
							<td nowrap="nowrap"><?=$Name;?></td>
							<td class="attr_list">
								<dl class="attr_box hide"></dl><?php /* 不要删掉 是用来处理兼容的 */?>
								<?php
								foreach((array)$all_cate_ary["{$v['UId']}{$v['CateId']},"] as $vv){
									$vv['TopCateId']=category::get_top_CateId_by_UId($vv['UId']);
								?>
									<dl class="attr_box" cateid="<?=$vv['CateId'];?>" data="<?=htmlspecialchars(str::json_data($vv));?>">
										<dd class="attr_ico"></dd>
										<dd class="attr_txt"><?=$vv['Category'];?></dd>
										<dd class="attr_menu">
											<a class="edit" href="javascript:;" label="{/global.edit/}" data-id="<?=$vv['CateId'];?>"><img src="/static/ico/edit.png" align="absmiddle" /></a>
											<a class="del" href="./?do_action=content.photo_category_del&CateId=<?=$vv['CateId'];?>" label="{/global.del/}" rel="del"><img src="/static/ico/del.png" align="absmiddle" /></a>
										</dd>
									</dl>
								<?php }?>
								<div class="attr_add"><a class="add" href="javascript:;" data-id="0">+</a></div>
							</td>
							<td nowrap="nowrap" class="operation">
								<a href="javascript:;" class="edit" data-id="<?=$v['CateId'];?>">{/global.edit/}</a>
								<a class="del item" href="./?do_action=content.photo_category_del&CateId=<?=$v['CateId'];?>" rel="del">{/global.del/}</a>
							</td>
						</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
		<?php /***************************** 图片管理分类编辑 Start *****************************/?>
		<div id="fixed_right">
			<div class="global_container box_photo_category_edit">
				<form id="box_photo_category_edit">
					<div class="top_title"><span>{/content.category/}</span><a href="javascript:;" class="close"></a></div>
					<div class="global_form">
						<div class="rows clean">
							<label>{/global.name/}</label>
							<span class="input"><input name="Category" value="<?=$category_one['Category'];?>" type="text" class="box_input" maxlength="100" size="30" notnull> <font class="fc_red">*</font></span>
							<div class="clear"></div>
						</div>
						<div class="rows clean">
							<label>{/content.photo.children/}</label>
							<span class="input">
								<?php
								$ext_where="CateId!='{$category_one['CateId']}' and Dept<2";
								echo category::ouput_Category_to_NewSelect('UnderTheCateId', ($ParentId?$ParentId:category::get_CateId_by_UId($category_one['UId'])), 'photo_category', "UId='0,' and $ext_where", $ext_where, 'class="box_input"', '{/global.select_index/}');
								?>
							</span>
							<div class="clear"></div>
						</div>
						<div class="rows clean">
							<label></label>
							<div class="input">
								<input type="button" class="btn_global btn_submit" value="{/global.save/}">
								<input type="button" class="btn_global btn_cancel" value="{/global.cancel/}">
							</div>
						</div>
						<input type="hidden" name="CateId" value="<?=$CateId;?>" />
						<input type="hidden" name="do_action" value="content.photo_category" />
					</div>
				</form>
			</div>
		</div>
		<?php /***************************** 图片管理分类编辑 End *****************************/?>
	<?php }?>
</div>