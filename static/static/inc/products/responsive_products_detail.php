<?php !isset($c) && exit();?>
<?=ly200::load_static('/static/js/plugin/bxslider/jquery.bxslider.js', '/static/js/plugin/bxslider/jquery.bxslider.css');?>
<div class="ueeshop_responsive_products_detail <?=$c['themes_products_detail']['style'];?>">
	<div class="gallery">
		<div class="bigimg"><a href="<?=$products_row['PicPath_0'];?>" class="MagicZoom" id="zoom" rel="zoom-position:custom; zoom-width:350px; zoom-height:350px;"><img src="<?=img::get_small_img($products_row['PicPath_0'], '500x500');?>" id="bigimg_src" alt="<?=$Name;?>" /></a></div>
		
		<div id="zoom-big"></div>
		<div class="left_small_img">
			<?php
			$img_count=0;
			for($i=0; $i<5; $i++){
				if(!is_file($c['root_path'].$products_row['PicPath_'.$i])){continue;}
				$img_count++;
			?>
				<span class="slide pic_box<?=$i==0?' on':'';?>" pic="<?=img::get_small_img($products_row['PicPath_'.$i], '500x500');?>" big="<?=$products_row['PicPath_'.$i];?>">
					<a href="javascript:;"><img src="<?=img::get_small_img($products_row['PicPath_'.$i], '240x240');?>" alt="<?=$Name;?>" /><em></em></a>
					<img src="<?=img::get_small_img($products_row['PicPath_'.$i], '500x500');?>" style="display:none;" />
					<img src="<?=$products_row['PicPath_'.$i];?>" style="display:none;" />
				</span>
			<?php }?>
		</div>
		
		<div class="products_img">
			<ul>
				<?php
				for($i=0; $i<5; $i++){
					if(!is_file($c['root_path'].$products_row['PicPath_'.$i])){continue;}
				?>
					<li><img src="<?=$products_row['PicPath_'.$i];?>" /></li>
				<?php }?>
			</ul>
		</div>
	</div>
	<div class="info">
		<h1 class="name"><?=$Name;?></h1>
		<?php if($products_row['Number']){?>
			<div class="number"><span><?=$c['lang_pack']['item_no'];?>:</span> <?=$products_row['Number'];?></div>
		<?php }?>
		<?php if($c['config']['products']['Config']['share']){?>
			<div class="share">
				<?php include($c['static_path'].'inc/global/share.php');?>
			</div><!-- .share -->
		<?php }?>
		<div class="desc"><?=str::str_format($products_row['BriefDescription'.$c['lang']]);?></div>
		<?php 
		//产品属性
		$products_attr=str::str_code(db::get_all('products_attribute', 1, "AttrId, Name{$c['lang']}, CartAttr, ColorAttr, Value{$c['lang']}", $c['my_order'].'AttrId asc'));
		$attr=str::json_data(str::str_code($products_row['Attr'], 'htmlspecialchars_decode'),'decode');
		$cur_lang=substr($c['lang'], 1);
		foreach((array)$attr as $key => $val){
			if ( array_key_exists($cur_lang, $val) ){
				$is_val = $val[$cur_lang];
			}else{
				$is_val = $val;
			}
			if($is_val) break;
		}
		if($is_val && $products_attr){
		?>
			<div class="attribute">
				<?php
				foreach((array)$products_attr as $k=>$v){
					if(@array_key_exists($cur_lang, $attr[$v['AttrId']])){
						$val=$attr[$v['AttrId']][$cur_lang];
					}else{
						$val=$attr[$v['AttrId']];
					}
					if($val==''){continue;}
				?>
					<li><?=$v['Name'.$c['lang']];?>: <span><?=$val;?></span></li>
				<?php }?>
			</div>
		<?php }?>
		
		<?php if($c['config']['products']['Config']['show_price'] && $c['FunVersion']>=1){?>
			<?php if($c['config']['products']['Config']['member']){?>
				<?php if((int)$_SESSION['ly200_user']['UserId']){?>
					 <div class="price"><?=$c['config']['products']['symbol'].$products_row['Price_0'];?></div>
				<?php }?>
			<?php }else{?>
				 <div class="price"><?=$c['config']['products']['symbol'].$products_row['Price_0'];?></div>
			<?php }?>
		<?php }?>
		<div class="button">
			<?php if($c['config']['global']['IsOpenInq']){?>
				<a href="javascript:;" class="add_to_inquiry" data="<?=$ProId;?>" <?=$background?"style='background:$background !important'":'';?>><?=$c['lang_pack']['inq'];?></a>
			<?php }?>
			<?php if($c['config']['products']['Config']['pdf']){?>
				<a href="javascript:;" class="prod_info_pdf" <?=$background?"style='background:$background !important'":'';?>><?=$c['lang_pack']['pdf'];?></a>
				<iframe id="export_pdf" class="export_pdf" src="" name="export_pdf"></iframe>
			<?php }?>
				<div class="download_button">
					<?php 
					$i=$file_exit=0;
					while($i<5){
						if(is_file($c['root_path'].$products_row["FilePath_$i"])){
							$file_exit = 1;
							break;
						}
						$i++;
					}
					?>
					<?php if($file_exit){?>
					<span <?=!$file_exit?"class='no_file'":""?> <?=$background?"style='background-color:$background !important'":'';?>></span>
					<ul class="down_list">
						<?php
						for($i=0; $i<5; ++$i){
							if(!is_file($c['root_path'].$products_row["FilePath_$i"])){continue;}
						?>
							<li><a href="javascript:;" class="<?=$products_row['FilePwd_'.$i]?'pwd':'';?>" path="<?=$i;?>" proid="<?=$products_row['ProId'];?>"><?=$products_row["FileName_$i"];?></a></li>
						<?php }?>
					</ul>
					<?php }?>
				</div>
			<div class="clear"></div>
		</div>
		<?php
		//平台导流
		$platform=str::json_data($products_row['Platform'],'decode');
		if($platform){
		?>
			<div class="platform">
				<?php
				foreach((array)$platform as $k => $v){
				?>
					<a href="<?=$v?>" target="_blank" class="<?=$k?>_btn"></a>
				<?php }?>
			</div>
		<?php }?>
	</div>
	<div class="clear"></div>
	<div class="description">
		<div class="title">
			<span><?=$c['lang_pack']['description'];?></span>
			<?php for($i=0;$i<$c['description_count'];$i++){if(!$products_description_row['IsOpen_'.$i])continue;?>
				<span><?=$products_description_row['Title_'.$i.$c['lang']]?></span>
			<?php }?>
		</div>
		<div class="contents">
			<div id="global_editor_contents"><?=str::str_code($products_description_row['Description'.$c['lang']], 'htmlspecialchars_decode');?></div>
		</div>
		<?php
		for($i=0; $i<$c['description_count'];$i++){
			if(!$products_description_row['IsOpen_'.$i]){continue;}
		?>
			<div class="contents">
				<div id="global_editor_contents"><?=str::str_code($products_description_row['Description_'.$i.$c['lang']], 'htmlspecialchars_decode');?></div>
			</div>
		<?php }?>
	</div>
</div>
<script>
$(document).ready(function(){
	product_gallery();
	$('.ueeshop_responsive_products_detail .products_img ul').bxSlider({ 
		slideWidth:$('.ueeshop_responsive_products_detail .products_img ul').width(),
		pager:false
	});
	$('.ueeshop_responsive_products_detail .title span').click(function(){
		showthis('.ueeshop_responsive_products_detail .title span', '.ueeshop_responsive_products_detail .description .contents', $(this).index(), 'cur');
	});
	$('.ueeshop_responsive_products_detail .description .contents:first').show();
});
</script>