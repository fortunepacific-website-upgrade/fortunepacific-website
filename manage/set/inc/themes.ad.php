<?php !isset($c) && exit();?>
<script type="text/javascript">$(document).ready(function(){set_obj.themes_ad_edit_init()});</script>
<div id="themes_ad">
	<div class="center_container">
		<?php if($c['manage']['page']=='index'){ ?>
			<?php
			$ad_row=str::str_code(db::get_all('web_settings', "Themes='{$c['themes']}' and PageName!='index'", '*', 'PageName asc,WId asc'));
			foreach($ad_row as $v){
			?>
				<table border="0" cellpadding="5" cellspacing="0" class="r_con_table gory" width="100%">
					<tbody>
						<tr>
							<td width="40%" nowrap="nowrap" class="page_name">{/set.themes.ad.page.<?=$v['PageName'];?>/}</td>
							<td width="40%" nowrap="nowrap"><?=$v['PositionName'];?></td>
							<td width="20%" nowrap="nowrap"><a href="./?m=set&a=themes&d=ad&p=edit&WId=<?=$v['WId'];?>">{/global.edit/}</a></td>
						</tr>
					</tbody>
				</table>
			<?php }?>
		<?php
		}else{
			$WId=(int)$_GET['WId'];
			$web_setting_row=str::str_code(db::get_one('web_settings', "Themes='{$c['themes']}' and PageName!='index' and WId='$WId'"));
			!$web_setting_row && js::location('./?m=set&a=themes&d=ad');
			$web_setting_row['Type']=explode('_', $web_setting_row['Type']);
			$web_setting_row['Config']=str::json_data($web_setting_row['Config'], 'decode');
			!(int)$web_setting_row['Config'][2] && $web_setting_row['Config'][2]=1;	//数量
			$web_setting_row['Data']=str::json_data(htmlspecialchars_decode($web_setting_row['Data']), 'decode');
		?>
			<form id="ad_edit_form" class="global_form">
				<div class="rows clean <?=(int)$web_setting_row['Config'][3]?'':'hide';?>">
					<label>{/set.themes.ad.show_type/}</label>
					<div class="input">
						<div class="show_type">
							<div class="ty_list <?=$web_setting_row['Data']['ShowType']<2?'cur':'';?>">
								<input type="radio" name="ShowType" class="hide" value="1" <?=$web_setting_row['Data']['ShowType']<2?'checked="checked"':'';?> />
								{/set.themes.ad.show_type.1/}
							</div>
							<div class="ty_list ty_list_2 <?=$web_setting_row['Data']['ShowType']==2?'cur':'';?>" >
								<input type="radio" name="ShowType" class="hide" value="2" <?=$web_setting_row['Data']['ShowType']==2?'checked="checked"':'';?> />
								{/set.themes.ad.show_type.2/}
							</div>
							<div class="ty_list ty_list_3 <?=$web_setting_row['Data']['ShowType']==3?'cur':'';?>">
								<input type="radio" name="ShowType" class="hide" value="3" <?=$web_setting_row['Data']['ShowType']==3?'checked="checked"':'';?> />
								{/set.themes.ad.show_type.3/}
							</div>
							<div class="clear"></div>
						</div>
					</div>
				</div>
				<div class="rows clean">
					<label>{/set.themes.ad.pic/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
					<div class="input">
						<?php foreach($c['manage']['config']['Language'] as $k=>$v){?>
							<div class="tab_txt tab_txt_<?=$v;?>" <?=$c['manage']['config']['LanguageDefault']==$v?'style="display:block;"':''?>>
								<ul id="PicDetail_<?=$v;?>"  class="ad_drag multi_img upload_file_multi" >
									<?php
									for($i=0; $i<$web_setting_row['Config'][2]; ++$i){
										$pic=@is_file($c['root_path'].$web_setting_row['Data']['PicPath'][$i][$v])?$web_setting_row['Data']['PicPath'][$i][$v]:'';
									?>
									<li class="adpic_row clean <?=@in_array('PicPath', $web_setting_row['Type'])?'':'no_img';?>">
										<?php if(@in_array('PicPath', $web_setting_row['Type'])){?>
											<div class="l_img fl">
												<dl class="img <?=$pic?'isfile':'';?>" num="<?=$i;?>" data-lang="<?=$v;?>">
													<dt class="upload_box preview_pic">
														<input type="button" id="PicUpload_<?=$i;?>" data-lang="<?=$v;?>" class="btn_ok upload_btn" name="submit_button" value="{/global.upload_pic/}" />
														<input type="hidden" class="picpath" name="PicPath_<?=$v;?>[]" value="<?=$pic;?>" save="<?=$pic?1:0;?>" />
													</dt>
													<dd class="pic_btn">
														<a href="javascript:;" class="edit"><i class="icon_edit_white"></i></a>
														<a href="javascript:;" class="del" rel="del"><i class="icon_del_white"></i></a>
														<a href="<?=$pic?$pic:'javascript:;';?>" class="zoom" target="_blank"><i class="icon_search_white"></i></a>
													</dd>
													<dd class="size"><?=sprintf(manage::language('{/global.pic_size_notes/}'), ((int)$web_setting_row['Config'][0]?$web_setting_row['Config'][0]:'auto').'*'.((int)$web_setting_row['Config'][1]?$web_setting_row['Config'][1]:'auto')); ?></dd>
												</dl>
											</div>
										<?php }?>
										<div class="fl ad_info">
											<?php if(@in_array('Title', $web_setting_row['Type'])){ ?>
												<div class="rows clean">
													<label>{/global.title/}</label>
													<div class="input"><input type="text" class="box_input" name="Title_<?=$v;?>[]" value="<?=$web_setting_row['Data']['Title'][$i][$v];?>" size="50"></div>
												</div>
											<?php } ?>
											<?php if(@in_array('Contents', $web_setting_row['Type'])){ ?>
												<div class="rows clean">
													<label>{/set.themes.ad.description/}</label>
													<div class="input">
														<input type="text" class="box_input" name="Contents_<?=$v;?>[]" value="<?=$web_setting_row['Data']['Contents'][$i][$v];?>" size="50">
													</div>
												</div>
											<?php } ?>
											<?php if(@in_array('Url', $web_setting_row['Type'])){ ?>
												<div class="rows clean">
													<label>{/set.themes.ad.url/}</label>
													<div class="input"><input type="text" class="box_input" name="Url_<?=$v;?>[]" value="<?=$web_setting_row['Data']['Url'][$i][$v]; ?>" size="50"></div>
												</div>
											<?php } ?>
										</div>
										<?php if($web_setting_row['Config'][2]>1){?><div class="drag_bg"></div><?php }?>
									</li>
									<?php }?>
								</ul>
							</div>
						<?php }?>
					</div>
				</div>
				<div class="rows clean">
					<div class="input">
						<input type="submit" class="btn_global btn_submit" value="{/global.save/}" name="submit_button">
						<a href="./?m=set&a=themes&d=ad" title="{/global.return/}"><input type="button" class="btn_global btn_cancel" value="{/global.return/}" /></a>
					</div>
				</div>
				<input type="hidden" name="WId" value="<?=$WId;?>">
				<input type="hidden" name="do_action" value="set.themes_index_set_edit"><!--【do_action】由于参数与themes_index_set_init完全一样，同一数据表，所以直接提交到这里-->
			</form>
		<?php }?>
	</div>
</div>