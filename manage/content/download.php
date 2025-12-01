<?php
manage::check_permit('content.download', 2);//检查权限

$d_ary=array('index','edit','category','category_edit');
$d = $c['manage']['do'];
!in_array($d, $d_ary) && $d=$d_ary[0];
?>
<div id="<?=($d=='index' || $d=='edit')?'download':'download_inside';?>" class="r_con_wrap">
	<div class="inside_container">
		<h1>{/module.content.download.module_name/}</h1>
		<ul class="inside_menu">
			<li><a href="./?m=content&a=download"<?=($d=='index' || $d=='edit')?' class="current"':'';?>>{/module.content.download.list/}</a></li>
			<li><a href="./?m=content&a=download&d=category"<?=($d=='category' || $d=='category_edit')?' class="current"':'';?>>{/global.category/}</a></li>
		</ul>
	</div>

	<?php
	if($d=='index'){
		//获取类别列表
		$cate_ary=str::str_code(db::get_all('download_category', '1', '*'));
		$category_ary=array();
		foreach((array)$cate_ary as $v){
			$category_ary[$v['CateId']]=$v;
		}
		$category_count=count($category_ary);
		unset($cate_ary);

		//下载文件列表
		$Name=str::str_code($_GET['Name']);
		$CateId=(int)$_GET['CateId'];
		//$Other=(int)$_GET['Other'];

		$where='1';//条件
		$page_count=10;//显示数量
		$Name && $where.=" and (Name{$c['lang']} like '%$Name%')";
		if($CateId){
			$where.=' and '.category::get_search_where_by_CateId($CateId, 'download_category');
			$category_one=str::str_code(db::get_one('download_category', "CateId='$CateId'"));
			$UId=$category_one['UId'];
			$UId!='0,' && $TopCateId=category::get_top_CateId_by_UId($UId);
		}
		$download_row=str::str_code(db::get_limit_page('`download`', $where, '*', $c['my_order'].'DId desc', (int)$_GET['page'], $page_count));
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
								<div class="box_select"><?=category::ouput_Category_to_Select('CateId', '', 'download_category', 'UId="0,"');?></div>
							</div>
							<div class="clear"></div>
						</div>
					</div>
					<div class="clear"></div>
					<input type="hidden" name="m" value="content" />
					<input type="hidden" name="a" value="download" />
				</form>
			</div>
			<ul class="list_menu_button">
				<li><a class="add" href="./?m=content&a=download&d=edit">{/global.add/}</a></li>
				<li><a class="del" href="javascript:;">{/global.del/}</a></li>
			</ul>
		</div>
		<script type="text/javascript">$(document).ready(function(){content_obj.download_init();});</script>
		<table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
			<thead>
				<tr>
					<td width="5%" nowrap="nowrap"><?=html::btn_checkbox('select_all');?></td>
					<td width="10%" nowrap="nowrap">{/global.pic/}</td>
					<td width="20%" nowrap="nowrap">{/global.name/}</td>
					<td width="20%" nowrap="nowrap">{/content.download.file/}</td>
					<td width="15%" nowrap="nowrap">{/global.category/}</td>
					<td width="10%" nowrap="nowrap">{/global.edit_time/}</td>
					<td width="10%" nowrap="nowrap">{/content.download.download/}</td>
					<td width="10%" nowrap="nowrap">{/global.operation/}</td>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($download_row[0] as $v){
					$extname=file::get_ext_name($v['FilePath']);
				?>
				<tr>
					<td nowrap="nowrap"><?=html::btn_checkbox('select', $v['DId']);?></td>
					<td nowrap="nowrap" <?=@is_file($c['root_path'].$v['PicPath'])?'style="height:70px;"':'';?>>
						<img class="photo" src="<?=$v['PicPath'];?>" alt="<?=$v['Name'.$c['lang']];?>" align="absmiddle" />
					</td>
					<td><?=$v['Name'.$c['lang']];?></td>
					<td><?=$v['IsOth']?'{/content.download.external_link/}':$v['FileName'].'.'.$extname;?></td>
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
					<td nowrap="nowrap"><a href="<?=$v['IsOth']?$v['FilePath']:'javascript:void(0);';?>" <?=$v['IsOth']?'target="_blank"':'';?> name="download" id="<?=$v['DId'];?>">{/content.download.download/}</a></td>
					<td nowrap="nowrap" class="operation">
						<a href="./?m=content&a=download&d=edit&DId=<?=$v['DId'];?>" title="{/global.edit/}">{/global.edit/}</a>
	                    <a href="./?do_action=content.download_del&id=<?=$v['DId'];?>" title="{/global.del/}" class="del" rel="del">{/global.del/}</a>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
		<input type="hidden" name="Type" value="download" />
		<?=html::turn_page($download_row[1], $download_row[2], $download_row[3], '?'.str::query_string('page').'&page=');?>
	</div>
	<?php
	}elseif($d=='edit'){
		//下载文件编辑
		$DId=(int)$_GET['DId'];
		$download_row=str::str_code(db::get_one('`download`', "DId='$DId'"));
		$download_description_row=str::str_code(db::get_one('download_description', "DId='$DId'"));

		$download_row['CateId'] && $uid=category::get_UId_by_CateId($download_row['CateId']);
		$uid!='0,' && $TopCateId=category::get_top_CateId_by_UId($uid);
		$download_category_row=str::str_code(db::get_one('download_category', "CateId='{$TopCateId}'"));
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
	<script src="/static/js/plugin/file_upload/js/jquery.fileupload-ui.js"></script>
	<!--[if (gte IE 8)&(lt IE 10)]><script src="/static/js/plugin/file_upload/js/cors/jquery.xdr-transport.js"></script><![endif]-->
	<script type="text/javascript">$(document).ready(function(){content_obj.download_edit_init();});</script>
	<div class="center_container">
		<div class="blank12"></div>
		<form id="download_form" name="download_form" class="global_form" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
			<!-- 基本信息 -->
			<a href="javascript:history.back(-1);" class="return_title">
				<span class="return">{/module.content.download.module_name/}</span>
				<span class="s_return">/ {/global.<?=$DId?'edit':'add'?>/}</span>
			</a>
			<div class="rows_box">
				<div class="rows clean translation">
					<label>{/global.name/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
					<div class="input"><?=manage::form_edit($download_row, 'text', 'Name', 53, 150, 'notnull');?></div>
				</div>
				<div class="rows clean">
					<label>{/global.category/}</label>
					<div class="input">
						<div class="box_select"><?=category::ouput_Category_to_Select('CateId', $download_row['CateId'], 'download_category', 'UId="0,"', 1);?></div>
					</div>
				</div>
				<?php if($c['FunVersion']>=1){?>
                <div class="rows clean">
                    <label>{/content.download.is_member/}</label>
                    <div class="input">
                        <div class="switchery<?=$download_row['IsMember']?' checked':'';?>">
                            <input type="checkbox" name="IsMember" value="1"<?=$download_row['IsMember']?' checked':'';?>>
                            <div class="switchery_toggler"></div>
                            <div class="switchery_inner">
                                <div class="switchery_state_on"></div>
                                <div class="switchery_state_off"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
			<!-- 上传图片 -->
			<div class="rows_box">
                <div class="rows clean">
                    <label>{/global.pic/}</label>
                    <div class="input">
						<?=manage::multi_img('PicDetail', 'PicPath', $download_row['PicPath']); ?>
                    </div>
                </div>
			</div>

			<!-- 上传文件 -->
			<div class="rows_box">
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
                    <label>{/content.download.is_external_link/}</label>
                    <div class="input">
                        <div class="switchery<?=$download_row['IsOth']?' checked':'';?>">
                            <input type="checkbox" name="IsOth" value="1"<?=$download_row['IsOth']?' checked':'';?>>
                            <div class="switchery_toggler"></div>
                            <div class="switchery_inner">
                                <div class="switchery_state_on"></div>
                                <div class="switchery_state_off"></div>
                            </div>
                        </div>
                        <span class="tool_tips_ico" content="{/content.download.link_notes/}"></span>
                    </div>
                </div>
				<div class="rows clean">
					<label>{/content.download.filepath/}</label>
					<div class="input">
						<input name="FilePath" value="<?=$download_row['FilePath'];?>" type="text" class="box_input" id="FilePath" size="50" maxlength="100" />
					</div>
				</div>
				<div class="rows clean">
					<label>{/global.my_order/}</label>
					<div class="input"><div class="box_select width_90"><?=html::form_select(manage::language('{/global.my_order_ary/}'), 'MyOrder', $download_row['MyOrder']);?></div><span class="notes_icon" content="{/download.list.myorder_notes/}"></span></div>
				</div>
				<div class="rows clean">
					<label>{/content.download.download_password/}</label>
					<div class="input">
						<input name="Password" value="<?=$download_row['Password'];?>" type="text" class="box_input" size="20" maxlength="50" />
					</div>
				</div>
				<div class="rows clean">
					<label></label>
					<div class="input">
						<input type="submit" class="btn_global btn_submit" name="submit_button" value="{/global.save/}" />
						<input type="button" class="btn_global btn_translation" value="{/global.translation/}">
						<a href="./?m=content&a=download"><input type="button" class="btn_global btn_cancel" value="{/global.return/}"></a>
					</div>
				</div>
                <div class="blank20"></div>
			</div>
			<input type="hidden" id="DId" name="DId" value="<?=$DId;?>" />
			<input type="hidden" id="FileName" name="FileName" value="<?=$download_row['FileName'];?>" />
			<input type="hidden" name="sFilePath" value="<?=$download_row['FilePath'];?>" />
			<input type="hidden" name="sFileName" value="<?=$download_row['FileName'];?>" />
			<input type="hidden" name="do_action" value="content.download_edit" />
			<input type="hidden" id="back_action" name="back_action" value="<?=$_SERVER['HTTP_REFERER'];?>" />
		</form>
		<?php include("static/inc/translation.php");?>
	</div>
	<?php
	}elseif($d=='category'){
		echo ly200::load_static('/static/js/plugin/dragsort/dragsort-0.5.1.min.js');
	?>
	<div class="center_container_1000">
		<div class="inside_table">
			<div class="list_menu">
				<ul class="list_menu_button">
					<?php if(1 || $permit_ary['add']){?><li><a class="add" href="./?m=content&a=download&d=category_edit">{/global.add/}</a></li><?php }?>
					<?php if(1 || $permit_ary['del']){?><li><a class="del" href="javascript:;">{/global.del/}</a></li><?php }?>
				</ul>
			</div>
			<script type="text/javascript">$(document).ready(function(){content_obj.download_category_init()});</script>
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
						$UId=category::get_UId_by_CateId($CateId,'download_category');
						$where.=" and UId='{$UId}'";
					}else{
						$where.=' and UId="0,"';
					}
					$category_row=str::str_code(db::get_all('download_category', $where, '*', $c['my_order'].'CateId asc'));
					$i=1;
					foreach($category_row as $v){
						$url = "./?m=content&a=download&d=category_edit&CateId=".$v['CateId'];
					?>
						<tr id="<?=$v['CateId'];?>">
							<td nowrap="nowrap" class="myorder move_myorder" data="move_myorder"><i class="icon_myorder"></i></td>
							<td nowrap="nowrap"><?=html::btn_checkbox('select', $v['CateId']);?></td>
							<td nowrap="nowrap"><?=$v['CateId'];?></td>
							<td><?=$v['Category_'.$c['manage']['language_web'][0]];?></td>
							<td nowrap="nowrap" class="operation">
								<a href="<?=$url;?>">{/global.edit/}</a>
								<a class="del item" href="./?do_action=content.download_category_del&id=<?=$v['CateId'];?>" rel="del">{/global.del/}</a>
							</td>
						</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
	</div>
	<?php
	}elseif($d=='category_edit'){
		$CateId=(int)$_GET['CateId'];
		$category_row=db::get_one('download_category', "CateId='$CateId'");
		$category_row['CateId'] && $category_description_row=db::get_one('download_category_description', "CateId='{$category_row['CateId']}'");
		echo ly200::load_static('/static/js/plugin/ckeditor/ckeditor.js');
	?>
	<script type="text/javascript">$(document).ready(function(){content_obj.download_category_edit_init()});</script>
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
					<label></label>
					<div class="input">
						<input type="submit" class="btn_global btn_submit" name="submit_button" value="{/global.save/}" />
						<input type="button" class="btn_global btn_translation" value="{/global.translation/}">
						<a href="<?=$_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:'./?m=content&a=download&d=category';?>" class="btn_global btn_cancel">{/global.return/}</a>
					</div>
				</div>
			</div>
			<?php include("static/inc/seo.php");?>
		</div>
		<input type="hidden" name="CateId" value="<?=$CateId;?>" />
		<input type="hidden" name="do_action" value="content.download_category_edit" />
	</form>
	<?php include("static/inc/translation.php");?>
	<?php }?>
</div>