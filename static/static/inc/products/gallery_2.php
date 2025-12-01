<?php !isset($c) && exit();?>
<div class="gallery">
    <div class="bigimg pic_box"><a href="<?=$products_row['PicPath_0'];?>" target="_blank"><img src="<?=$products_row['PicPath_0'];?>" id="bigimg_src" alt="<?=$Name;?>" /><em></em></a></div>
    <div id="small_img">
        <div class="small_img_list">
            <div class="bd">
                <?php
                $img_count=0;
                for($i=0; $i<5; $i++){
                    if(!is_file($c['root_path'].$products_row['PicPath_'.$i])){
                        continue;
                    }
                    $img_count++;
                ?>
                    <span class="pic_box<?=$i==0?' on':'';?>" pic="<?=$products_row['PicPath_'.$i];?>"><a href="javascript:;"><img src="<?=img::get_small_img($products_row['PicPath_'.$i], '240x240');?>" alt="<?=$Name;?>" /><em></em></a></span>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<script>
$(function(){
	$('#small_img .small_img_list .bd').delegate('span', 'click', function(){
		var img=$(this).attr('pic');
		$('#bigimg_src').attr('src', img).parent().attr('href', img);
		$(this).addClass('on').siblings('span').removeClass('on');
		$('#zoom').css('width', 'auto');
	});	
})
</script>