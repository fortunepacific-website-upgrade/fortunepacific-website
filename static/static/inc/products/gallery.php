<?php !isset($c) && exit();?>
<div class="gallery fl">
    <div class="bigimg"><a href="<?=$products_row['PicPath_0'];?>" class="MagicZoom" id="zoom" rel="zoom-position:custom; zoom-width:350px; zoom-height:350px;"><img src="<?=img::get_small_img($products_row['PicPath_0'], '500x500');?>" id="bigimg_src" alt="<?=$Name;?>" /></a></div>
    <div id="small_img">
        <div class="small_img_list">
            <div class="bd clean">
                <?php
                $img_count=0;
                for($i=0; $i<5; $i++){
                    if(!is_file($c['root_path'].$products_row['PicPath_'.$i])){
                        continue;
                    }
                    $img_count++;
                ?>
                    <span class="pic_box<?=$i==0?' on':'';?>" pic="<?=img::get_small_img($products_row['PicPath_'.$i], '500x500');?>" big="<?=$products_row['PicPath_'.$i];?>">
						<a href="javascript:;"><img src="<?=img::get_small_img($products_row['PicPath_'.$i], '240x240');?>" alt="<?=$Name;?>" /><em></em></a>
                        <img src="<?=img::get_small_img($products_row['PicPath_'.$i], '500x500');?>" style="display:none;" />
                        <img src="<?=$products_row['PicPath_'.$i];?>" style="display:none;" />
                    </span>
                <?php }?>
            </div>
        </div>
    </div>
    <div id="zoom-big"></div>
</div>
<script type="text/javascript">product_gallery();</script><?php //static/js/themes.js 中定义?>