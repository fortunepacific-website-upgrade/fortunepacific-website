<?php !isset($c) && exit();?>
<?php
$i=0;
foreach($list_row[0] as $k=>$v){
	$url=web::get_url($v, $page_type);
	$img=img::get_small_img($v['PicPath_0'], '500x500');
	$name=$v['Name'.$c['lang']];
?>
    <?php if ($i%2==0){?><div class="home_box clean"><?php }?>
        <div class="small_pro fl">
            <div class="c">
                <div class="img pic_box"><a href="<?=$url;?>" title="<?=$name;?>"><img src="<?=$img;?>"></a><span></span></div>
                <div class="proname"><a href="<?=$url;?>" title="<?=$name;?>"><?=$name;?></a></div>
                <?php if($c['config']['products']['Config']['show_price'] && $c['FunVersion']>=1 && $page_type=='products'){?>
					<?php if($c['config']['products']['Config']['member']){?>
                        <?php if((int)$_SESSION['ly200_user']['UserId']){?>
                             <div class="price"><?=$c['config']['products']['symbol'].$v['Price_0'];?></div>
                        <?php }?>
                    <?php }else{?>
                         <div class="price"><?=$c['config']['products']['symbol'].$v['Price_0'];?></div>
                    <?php }?>
                <?php }?>
            </div>
        </div>
    <?php if (($i+1)%2==0 || $i==count($list_row[0])-1){?></div><!-- end of .home_box --><?php }?>
<?php 
	$i++;
}?>