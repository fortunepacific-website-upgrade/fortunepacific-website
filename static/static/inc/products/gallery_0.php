<?php !isset($c) && exit();?>
<?php
if(in_array($c['themes'],array('t193','t179'))){
	$gallery_border	= 6;
}else{
	$gallery_border	= 2;
}
?>
<?=ly200::load_static('/static/js/plugin/effect/Zslide.min.js');?>
<div class="dtl fl">
    <div class="bigimg"><a href="<?=$products_row['PicPath_0'];?>" class="MagicZoom" id="zoom" rel="zoom-position:custom; zoom-width:380px; zoom-height:380px;"><img src="<?=img::get_small_img($products_row['PicPath_0'], '500x500');?>" alt="<?=$products_row['Name'.$c['lang']];?>" id="bigimg_src" /></a><div id="zoom-big"></div></div>
    <?php /*?><div class="blank15"></div><?php */?>
    <div class="d_small">
        <a class="t_l" href="javascript:void(0);"></a>
        <div class="small_re">
            <div class="small_ab">
                <ul>
                    <?php for($i=0;$i<5;$i++){?>
                        <?php if(is_file($c['root_path'].$products_row['PicPath_'.$i])){?>
                            <li <?=$i==0?'class="cur"':'';?> pic="<?=img::get_small_img($products_row['PicPath_'.$i], '500x500');?>" big="<?=$products_row['PicPath_'.$i];?>">
                            	<a href="javascript:void(0);"><img src="<?=img::get_small_img($products_row['PicPath_'.$i], '240x240');?>" alt="<?=$products_row['Name'.$c['lang']];?>" /><span></span></a>
                            </li>
                        <?php }?>
                    <?php }?>
                    <div class="clear"></div>
                </ul>
            </div>        
        </div>
        <a class="t_r" href="javascript:void(0);"></a>
    </div>
    <script type="text/javascript">
    $('.dtl .d_small').delegate('li', 'click', function(){
        var img=$(this).attr('pic');
		var big_img=$(this).attr('big');
        $('#bigimg_src').attr('src', img).parent().attr('href', big_img);
        $(this).addClass('cur').siblings('li').removeClass('cur');							
        $('#zoom').css('width', 'auto');
        var_j(document).a('domready', MagicZoom.refresh);
        var_j(document).a('mousemove', MagicZoom.z1);
        });   
		$(function(){$("#d_products .dtl .d_small").Zslide({boxRe:".small_re",boxAb:".small_ab",seeNum:3,border:<?=$gallery_border;?>,left:"#d_products .dtl .t_l",right:"#d_products .dtl .t_r"});})
    </script>
</div>