<?php !isset($c) && exit();?>
<div class="dtl fl">
    <div class="bigimg"><a href="<?=$products_row['PicPath_0'];?>" class="MagicZoom" id="zoom" rel="zoom-position:custom; zoom-width:380px; zoom-height:380px;"><img src="<?=img::get_small_img($products_row['PicPath_0'], '500x500');?>" alt="<?=$products_row['Name'.$c['lang']];?>" id="bigimg_src" /></a><div id="zoom-big"></div></div>
    <div class="d_small">
        <a class="t_l" href="javascript:void(0);"></a>
        <div class="small_re">
            <div class="small_ab">
                <ul>
                    <?php for($i=0;$i<5;$i++){?>
                        <?php if(is_file($c['root_path'].$products_row['PicPath_'.$i])){?>
                            <li <?=$i==0?'class="cur"':'';?> pic="<?=$products_row['PicPath_'.$i];?>" big="<?=$products_row['PicPath_'.$i];?>"><a href="javascript:void(0);"><img src="<?=img::get_small_img($products_row['PicPath_'.$i], '240x240');?>" alt="<?=$products_row['Name'.$c['lang']];?>" /><span></span><div class="bg"></div></a></li>
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
		/*Switch*/				
			var Links_div = jQuery(".dtl .d_small .small_ab");				//绝对定位DIV
			var Links_left_button = jQuery(".dtl .d_small .t_l");				//左按钮
			var Links_right_button = jQuery(".dtl .d_small .t_r");				//右按钮	
			var Links_see_length = 3 ;												// 一栏的显示个数
		
			var Links_li = Links_div.find("li");									//绝对定位子元素LI
			var Links_li_length = Links_li.length;
			var Links_li_width = Links_li.height();
			var Links_li_padding_left = Links_li.css("padding-top");
			var Links_li_padding_right = Links_li.css("padding-bottom");
			var Links_li_padding = parseInt(Links_li_padding_left) + parseInt(Links_li_padding_right);	
			var Links_li_margin_left = Links_li.css("margin-top");
			var Links_li_margin_right = Links_li.css("margin-bottom");
			var Links_li_margin = parseInt(Links_li_margin_left) + parseInt(Links_li_margin_right);
			var Links_li_truewidth = Links_li_width + Links_li_padding + Links_li_margin + 2;
			var Links_ul_width = Links_li_truewidth * Links_li_length;
			var Links_switcLinks_width = Links_li_truewidth;						//移动一个数量	
			Links_div.height(Links_ul_width);
			Links_left_button.click(function(){								 
				if(!Links_div.is(":animated")){
					var Links_cur_left = parseInt(Links_div.css("top"));
					if(Links_cur_left != 0){
						Links_div.animate({top:'+='+Links_switcLinks_width});
					}	
				}						   							   
			});
			Links_right_button.click(function(){
				if(!Links_div.is(":animated")){
					var Links_last_left = Links_ul_width - Links_li_truewidth;
					var Links_cur_left = parseInt(Links_div.css("top")) - Links_switcLinks_width*Links_see_length;
					if(Links_cur_left >= -Links_last_left){
						Links_div.animate({top:'-='+Links_switcLinks_width});
					}	
				}					   						   
			});	
		/*Switch*/
    </script>
</div>