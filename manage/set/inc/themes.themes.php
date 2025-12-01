<?php !isset($c) && exit();?>
<?php !$IsMobile && exit();?>
<script type="text/javascript">$(document).ready(function(){set_obj.themes_themes_edit_init()});</script>
<div class="themes_content">
	<div id="themes_themes" class="themes_themes">
		<div id="themes_box">
			<?php
				if($c['manage']['do']=='home_themes'){
					$HomeTpl=db::get_value('config', "GroupId='mobile' and Variable='HomeTpl'", 'Value');	//当前使用的风格
					for($i=1; $i<12; ++$i){
						$tpl=sprintf('%02s', $i);
						$img=$c['cdn']."static/v1/themes/mobile/index-$tpl.jpg";
					?>
						<div class="item themes_item fl<?=$HomeTpl==$tpl?' current':'';?>" data-name="<?=$tpl;?>"  data-themes="<?=$tpl;?>" title="<?=$tpl;?>" data-img="<?=$img;?>">
							<div class="img"><img src="<?=$img;?>" /><div class="img_mask"></div></div>
							<div class="info"><span><?=$tpl;?></span></div>
						</div>
					<?php
					}
				}else{
					$ListTpl=db::get_value('config', "GroupId='mobile' and Variable='ListTpl'", 'Value');	//当前使用的风格
					for($i=1; $i<10; ++$i){
						$tpl=sprintf('%02s', $i);
						$img=$c['cdn']."static/v1/themes/mobile/list-$tpl.jpg";
					?>
						<div class="item themes_item fl<?=$ListTpl==$tpl?' current':'';?>" data-name="<?=$tpl;?>"  data-themes="<?=$tpl;?>" title="<?=$tpl;?>" data-img="<?=$img;?>">
							<div class="img"><img src="<?=$img;?>" /><div class="img_mask"></div></div>
							<div class="info"><span><?=$tpl;?></span></div>
						</div>
					<?php
					}
				}
			?>
		</div>
	</div>
	<div class="themes_current">
		<div class="themes_set">
			<a href="javascript:;" data-themes="" data-type="<?=$c['manage']['do'];?>" class="use IsMobile">{/set.themes.themes.use/}</a>
			<div class="themes"></div>
		</div>
		<div class="themes_img"><img src="" alt=""></div>
	</div>
	<div class="clear"></div>
</div>