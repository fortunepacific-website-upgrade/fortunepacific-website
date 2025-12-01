<?php !isset($c) && exit();?>
<div class="gallery fl">
    <div class="bigimg pic_box"><a href="<?=$case_row['PicPath_0'];?>" class="case" title="<?=$Name;?>" target="_blank"><img src="<?=img::get_small_img($case_row['PicPath_0'], '500x500');?>" id="bigimg_src" alt="<?=$Name;?>" /><em></em></a></div>
    <div id="small_img">
        <div id="case_small" class="small_img_list">
            <div class="bd clean">
                <?php
                $img_count=0;
                for($i=0; $i<5; $i++){
                    if(!is_file($c['root_path'].$case_row['PicPath_'.$i])){
                        continue;
                    }
                    $img_count++;
                ?>
                    <span class="pic_box<?=$i==0?' on':'';?>" pic="<?=img::get_small_img($case_row['PicPath_'.$i], '500x500');?>" big="<?=$case_row['PicPath_'.$i];?>" >
                    	<a href="javascript:;"><img src="<?=img::get_small_img($case_row['PicPath_'.$i], '240x240');?>" alt="<?=$Name;?>" /><em></em></a>
                    </span>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">case_gallery();</script><?php //static/js/themes.js 中定义?>