<?php !isset($c) && exit();?>
<?php
if($IsMobile){
	$c['themes']=db::get_value('config', 'GroupId="mobile" and Variable="HomeTpl"', 'Value');
	!$c['themes'] && $c['themes']='01';
	$all_web_setting_row=db::get_all('web_settings', "Themes='mobile-{$c['themes']}' and PageName='index'");
}else{
	$all_web_setting_row=db::get_all('web_settings', "Themes='{$c['themes']}' and PageName='index'");
}
$WId=(int)$_GET['WId'];
!$WId && $WId=$all_web_setting_row[0]['WId'];
if($WId){
	$web_setting_row=str::str_code(db::get_one('web_settings', "WId='{$WId}'"));
	$web_setting_row['Type']=explode('_', $web_setting_row['Type']);
	$web_setting_row['Config']=str::json_data($web_setting_row['Config'], 'decode');
	!(int)$web_setting_row['Config'][2] && $web_setting_row['Config'][2]=1;	//数量
	$web_setting_row['PositionStyle']=str::json_data($web_setting_row['PositionStyle'], 'decode');
	$web_setting_row['Data']=str::json_data(htmlspecialchars_decode($web_setting_row['Data']), 'decode');
}
?>
<script type="text/javascript">$(document).ready(function(){set_obj.themes_index_set_init()});</script>
<div id="index_set">
	<div class="themes_box">
		<img src="<?=$c['cdn'].'static/v1/themes/'.($IsMobile?'mobile/index-':'').$c['themes'];?>.jpg" class="themes_pic" alt="">
		<?php
		foreach((array)$all_web_setting_row as $v){
			$postion=str::json_data($v['PositionStyle'], 'decode');
		?>
			<div class="abs_item <?=$WId==$v['WId']?'cur':'';?>" data-type="<?=$v['Type'];?>" data-wid="<?=$v['WId'];?>" style="top:<?=$postion[0];?>px; left:<?=$postion[1];?>px; width:<?=$postion[2];?>px; height:<?=$postion[3];?>px; z-index:<?=$postion[4];?>"></div>
		<?php } ?>
		<input type="hidden" name="return_url" value="./?m=set&a=themes&d=index_set<?=$IsMobile ? '&IsMobile=1' : ''; ?>" />
	</div>
	<div class="global_container index_set_exit">
		<form id="index_set_edit_form" class="global_form">
			<!--top: <input type="text" class="box_input" name="top" value="<?=$web_setting_row['PositionStyle'][0];?>" size="10">
			left: <input type="text" class="box_input" name="left" value="<?=$web_setting_row['PositionStyle'][1];?>" size="10">
			width: <input type="text" class="box_input" name="width" value="<?=$web_setting_row['PositionStyle'][2];?>" size="10">
			height: <input type="text" class="box_input" name="height" value="<?=$web_setting_row['PositionStyle'][3];?>" size="10">
			z-index: <input type="text" class="box_input" name="z_index" value="<?=$web_setting_row['PositionStyle'][4];?>" size="10">
			<style>#index_set .themes_box .abs_item{min-width:30px; min-height:15px; background:blue; color:#fff;}</style>-->
			<div class="rows clean <?=(int)$web_setting_row['Config'][3]?'':'hide';?>">
				<label>{/set.themes.ad.show_type/}</label>
				<div class="input">
					<div class="show_type">
						<div class="ty_list <?=$web_setting_row['Data']['ShowType']<2?'cur':'';?>">
							<input type="radio" name="ShowType" class="hide" value="1" <?=$web_setting_row['Data']['ShowType']<2?'checked="checked"':'';?> />
							{/set.themes.ad.show.1/}
						</div>
						<div class="ty_list ty_list_2 <?=$web_setting_row['Data']['ShowType']==2?'cur':'';?>" >
							<input type="radio" name="ShowType" class="hide" value="2" <?=$web_setting_row['Data']['ShowType']==2?'checked="checked"':'';?> />
							{/set.themes.ad.show.2/}
						</div>
						<div class="ty_list ty_list_3 <?=$web_setting_row['Data']['ShowType']==3?'cur':'';?>">
							<input type="radio" name="ShowType" class="hide" value="3" <?=$web_setting_row['Data']['ShowType']==3?'checked="checked"':'';?> />
							{/set.themes.ad.show.3/}
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
							<ul id="PicDetail_<?=$v;?>"  class="ad_drag multi_img upload_file_multi">
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
												<div class="input"><input type="text" class="box_input" name="Title_<?=$v;?>[]" value="<?=htmlspecialchars($web_setting_row['Data']['Title'][$i][$v]);?>" size="50"></div>
											</div>
										<?php } ?>
										<?php if(@in_array('Contents', $web_setting_row['Type'])){ ?>
											<div class="rows clean">
												<label>{/set.themes.ad.description/}</label>
												<div class="input">
													<textarea name="Contents_<?=$v;?>[]" class='box_textarea'><?=htmlspecialchars($web_setting_row['Data']['Contents'][$i][$v]);?></textarea>
												</div>
											</div>
										<?php } ?>
										<?php if(@in_array('Url', $web_setting_row['Type'])){ ?>
											<div class="rows clean">
												<label>{/set.themes.ad.url/}</label>
												<div class="input"><input type="text" class="box_input" name="Url_<?=$v;?>[]" value="<?=htmlspecialchars($web_setting_row['Data']['Url'][$i][$v]);?>" size="50"></div>
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
				<div class="input"><input type="submit" class="btn_global btn_submit" value="{/global.save/}" name="submit_button"></div>
			</div>
			<input type="hidden" name="WId" value="<?=$WId; ?>">
			<input type="hidden" name="do_action" value="set.themes_index_set_edit">
		</form>
	</div>
</div>