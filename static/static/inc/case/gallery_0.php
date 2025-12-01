<?php !isset($c) && exit();?>
<div class="dtl fl">
    <div id="case_big" class="bigimg"><a href="<?=$case_row['PicPath_0'];?>" target="_blank"><img src="<?=img::get_small_img($case_row['PicPath_0'], '500x500');?>" alt="<?=$case_row['Name'.$c['lang']];?>" /><span></span></a></div>
    <div id="case_small" class="small">
        <ul>
            <?php for($i=0;$i<5;$i++){?>
                <?php if(is_file($c['root_path'].$case_row['PicPath_'.$i])){?>
                    <li <?=$i==0?'class="cur"':'';?>><a href="javascript:void(0);" data-big="<?=$case_row['PicPath_'.$i];?>" data-nor="<?=img::get_small_img($case_row['PicPath_'.$i], '500x500');?>"><img src="<?=img::get_small_img($case_row['PicPath_'.$i], '240x240');?>" alt="<?=$case_row['Name'.$c['lang']];?>" /><span></span></a></li>
                <?php }?>
            <?php }?>
            <div class="clear"></div>
        </ul>
    </div>
</div>
<script>
$(function(){
	$("#case_small a").click(function(){
		var img_nor = $(this).data("nor");
		var img_big = $(this).data("big");
		$(this).parent().addClass("cur").siblings().removeClass("cur");
		$("#case_big a").attr("href",img_big);
		$("#case_big img").attr("src",img_nor);
	});		
})
</script>