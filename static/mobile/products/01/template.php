<?php !isset($c) && exit();?>
<?php
foreach($list_row[0] as $k=>$v){
	$url=web::get_url($v, $page_type);
	$img=img::get_small_img($v['PicPath_0'], '500x500');
    $name=$v['Name'.$c['lang']];
	$brief=$v['BriefDescription'.$c['lang']];
?>
<div class="pro_cbox">
	<div class="img pic_box"><a href="<?=$url;?>" title="<?=$name;?>"><img src="<?=$img;?>"></a><span></span></div>
    <div class="name clean">
    	<div class="n"><a href="<?=$url;?>" title="<?=$name;?>"><?=$name;?></a></div>
        <div class="brief"><?=$brief; ?></div>
        <?php if($c['config']['products']['Config']['show_price'] && $c['FunVersion']>=1 && $page_type=='products'){?>
			<?php if($c['config']['products']['Config']['member']){?>
                <?php if((int)$_SESSION['ly200_user']['UserId']){?>
                     <div class="p"><?=$c['config']['products']['symbol'].$v['Price_0'];?></div>
                <?php }?>
            <?php }else{?>
                 <div class="p"><?=$c['config']['products']['symbol'].$v['Price_0'];?></div>
            <?php }?>
        <?php }?>
    </div>
</div>
<?php }?>