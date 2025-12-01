<?php !isset($c) && exit();?>
<script type="text/javascript">$(document).ready(function(){set_obj.config_watermark_edit();});</script>
<form id="watermark_edit_form" class="global_form">
	<div class="center_container">
		<a href="javascript:history.back(-1);" class="return_title">
			<span class="return">{/set.config.watermark.watermark/}</span> 
		</a>
		<div class="rows clean">
			<label></label>
			<div class="input">
				{/set.config.watermark.is_watermark/}
				<div class="switchery<?=$c['manage']['config']['IsWater']?' checked':'';?>">
					<input type="checkbox" name="IsWater" value="1"<?=$c['manage']['config']['IsWater']?' checked':'';?>>
					<div class="switchery_toggler"></div>
					<div class="switchery_inner">
						<div class="switchery_state_on"></div>
						<div class="switchery_state_off"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="rows clean">
			<label>{/set.config.watermark.upload_file/}</label>
			<div class="input">
				<div class="multi_img upload_file_multi" id="WatermarkDetail">
					<?php
					$pic=$c['manage']['config']['WatermarkPath'];
					$isFile=is_file($c['root_path'].$pic)?1:0;
					?>
					<dl class="img <?=$isFile ? 'isfile' : '';?>" num="0">
						<dt class="upload_box preview_pic">
							<input type="button" id="WatermarkUpload" class="btn_ok upload_btn" name="submit_button" value="{/global.upload_pic/}" tips="" />
							<input type="hidden" name="WatermarkPath" value="<?=$pic;?>" data-value="" save="<?=$isFile;?>" />
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
			<label>{/set.config.watermark.alpha/}</label>
			<div class="input">
				<div id="slider_box">
					<div id="slider" class="fl"></div>
					<div id="slider_value" class="fl"><?=$c['manage']['config']['Alpha'];?>%</div>
					<span>{/set.config.watermark.alpha_notes/}</span>
				</div>
				<input type="hidden" name="Alpha" value="<?=$c['manage']['config']['Alpha'];?>" />
			</div>
		</div>
		<div class="rows clean">
			<label>{/set.config.watermark.position/}</label>
			<div class="input">
				<?php 
				$position_ary=array(1,5,9);
				foreach((array)$position_ary as $v){ 
				?>
				<div class="watermark_position watermark_position_<?=$v; ?> <?=$c['manage']['config']['WaterPosition']==$v ? 'cur' : ''; ?>" data-position="<?=$v; ?>"></div>
				<?php } ?>
			</div>
			<input type="hidden" name="WaterPosition" value="<?=$c['manage']['config']['WaterPosition'];?>" />
		</div>
		<div class="rows clean">
			<label></label>
			<div class="input">
				<input type="button" class="btn_global btn_submit" value="{/global.save/}" />
				<a href="javascript:history.back(-1);" title="{/global.return/}"><input type="button" class="btn_global btn_cancel" value="{/global.return/}" /></a>
			</div>
		</div>
		<input type="hidden" name="do_action" value="set.config_watermark_edit" />
	</div>
</form>