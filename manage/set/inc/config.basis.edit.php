<?php !isset($c) && exit();?>
<script type="text/javascript">$(document).ready(function(){set_obj.config_basis_edit();});</script>
<form id="basis_edit_form" class="global_form">
	<div class="center_container">
		<a href="javascript:history.back(-1);" class="return_title">
			<span class="return">{/set.config.basis.basis/}</span> 
		</a>
		<div class="rows clean">
			<label>{/set.config.basis.site_name/}</label>
			<div class="input"><input type="text" class="box_input" name="SiteName" value="<?=$c['manage']['config']['SiteName'];?>" size="50" maxlength="255" notnull /> <font class="fc_red">*</font></div>
		</div>
		<div class="rows clean">
			<label>{/global.logo/}</label>
			<div class="input">
				<div class="multi_img upload_file_multi" id="LogoDetail">
					<?php
					$pic=$c['manage']['config']['LogoPath'];
					$isFile=is_file($c['root_path'].$pic)?1:0;
					?>
					<dl class="img <?=$isFile ? 'isfile' : '';?>" num="0">
						<dt class="upload_box preview_pic">
							<input type="button" id="LogoUpload" class="btn_ok upload_btn" name="submit_button" value="{/global.upload_pic/}" tips="" />
							<input type="hidden" name="LogoPath" value="<?=$pic;?>" data-value="" save="<?=$isFile;?>" />
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
		<div class="rows clean">
			<label>{/set.config.basis.ico/}</label>
			<div class="input">
				<div class="multi_img upload_file_multi" id="IcoDetail">
					<?php
					$pic=$c['manage']['config']['IcoPath'];
					$isFile=is_file($c['root_path'].$pic)?1:0;
					?>
					<dl class="img <?=$isFile ? 'isfile' : '';?>" num="0">
						<dt class="upload_box preview_pic">
							<input type="button" id="IcoUpload" class="btn_ok upload_btn" name="submit_button" value="{/global.upload_pic/}" tips="" />
							<input type="hidden" name="IcoPath" value="<?=$pic;?>" data-value="" save="<?=$isFile;?>" />
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
		<div class="rows clean">
			<label>{/set.config.basis.web_display/}</label>
			<div class="input">
				<?php
				for($i=0; $i<3; ++$i){
				?>
					<span class="input_radio_box <?=$c['manage']['config']['WebDisplay']==$i?'checked':'';?>">
						<span class="input_radio">
							<input type="radio" name="WebDisplay" value="<?=$i;?>" <?=$c['manage']['config']['WebDisplay']==$i?'checked':'';?> />
						</span>
						{/set.config.basis.web_display_ary.<?=$i;?>/}
					</span>
				<?php }?>
			</div>
		</div>
		<div class="rows clean">
			<label>{/set.config.basis.is_footer_feedback/}</label>
			<div class="input">
				<span class="input_checkbox_box <?=$c['manage']['config']['Is_footer_feedback']?' checked':'';?>">
					<span class="input_checkbox">
						<input type="checkbox" name="Is_footer_feedback" value="1" <?=$c['manage']['config']['Is_footer_feedback']?' checked':'';?> />
					</span>
				</span>
				<input class="box_input color" type="text" name="FooterColor" value="<?=$c['manage']['config']['FooterColor'];?>" autocomplete="off" size="6">
			</div>
		</div>
		<?php $config_contact=str::json_data(db::get_value('config', 'GroupId="global" and Variable="Contact"', 'Value'), 'decode');?>
		<div class="rows clean translation">
			<label>
				{/set.config.basis.products_search_tips/}
				<div class="tab_box"><?=manage::html_tab_button();?></div>
			</label>
			<div class="input">
				<?=manage::form_edit($config_contact, 'text', 'ptips', 80);?>
			</div>
		</div>
		<div class="rows clean translation">
			<label>
				{/set.config.basis.copyright/}
				<div class="tab_box"><?=manage::html_tab_button();?></div>
			</label>
			<div class="input">
				<?=manage::form_edit($config_contact, 'text', 'copyright', 80);?>
			</div>
		</div>
		<?php if($c['FunVersion']==2){?>
			<div class="rows clean">
				<label>{/set.config.basis.blog_copyright/}</label>
				<div class="input"><input type="text" class="box_input" name="Blog" value="<?=$c['manage']['config']['Blog'];?>" size="50" maxlength="100" /></div>
			</div>
		<?php }?>
		<div class="rows clean">
			<label></label>
			<div class="input">
				<input type="button" class="btn_global btn_submit" value="{/global.save/}" />
				<input type="button" class="btn_global btn_translation" value="{/global.translation/}">
				<a href="./?m=set&a=config" title="{/global.return/}"><input type="button" class="btn_global btn_cancel" value="{/global.return/}" /></a>
			</div>
		</div>
		<input type="hidden" name="do_action" value="set.config_basis_edit">
	</div>
</form>