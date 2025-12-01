<?php !isset($c) && exit();?>
<?php
$ad_row = ly200::ad_custom(1);
$ad_row_left = ly200::ad_custom(2);
$ad_row_right = ly200::ad_custom(3);
?>
<div class="wrapper">
    
	<div class="banner" id="banner_box">
        <ul>
            <?php
            for ($i=$sum=0; $i<$ad_row['Count']; $i++){
				if (!is_file($c['root_path'].$ad_row['PicPath'][$i])){continue;}
				$sum++;
            ?>
            <li><a href="<?=$ad_row['Url'][$i]?$ad_row['Url'][$i]:'javascript:void(0)';?>"><img src="<?=$ad_row['PicPath'][$i];?>" alt="<?=$ad_row['Title'][$i];?>"></a></li>
            <?php }?>
        </ul>
        <div class="btn">
        	<?php for ($i=0; $i<$sum; $i++){?>
            <span class="<?=$i==0?'on':'';?>"></span>
            <?php }?>
        </div>
    </div>
    <div class="ad clean">
    	<div class="fl a1"><a href="<?=$ad_row_left['Url'][0]?$ad_row_left['Url'][0]:'javascript:void(0)';?>"><img src="<?=$ad_row_left['PicPath'][0];?>" alt="<?=$ad_row_left['Title'][0];?>" /></a></div>
        <div class="fr a2"><a href="<?=$ad_row_right['Url'][0]?$ad_row_right['Url'][0]:'javascript:void(0)';?>"><img src="<?=$ad_row_right['PicPath'][0];?>" alt="<?=$ad_row_right['Contents'][0];?>" /></a></div>
    </div>
    <div class="home_t clean">
    	<a class="more fr global_btn" href="/catalog/"><?=$c['lang_pack']['mobile']['more'];?></a><?=$c['lang_pack']['mobile']['feat_pro'];?>
    </div>
	<?php
    $products_list_row=str::str_code(db::get_limit('products', $c['where']['products'].' and IsIndex=1', '*', $c['my_order'].'ProId desc', 0, 4));
    for ($i=0,$len=count($products_list_row); $i<$len; $i++){
        $url=web::get_url($products_list_row[$i], 'products');
        $img=img::get_small_img($products_list_row[$i]['PicPath_0'], '500x500');
        $name=$products_list_row[$i]['Name'.$c['lang']];
    ?>
		<?php if ($i%2==0){?><div class="home_box clean"><?php }?>
            <div class="small_pro fl">
                <div class="c">
                    <div class="img pic_box"><a href="<?=$url;?>"><img src="<?=$img;?>"></a><span></span></div>
                    <div class="proname"><a href="<?=$url;?>"><?=$name;?></a></div>
                    <?php if($showCfg['prod']['show_price'] && $c['FunVersion']>=1 && (int)$_SESSION['ly200_user']['UserId']){?>
                    <div class="price"><?=$showCfg['symbol'].$products_list_row[$i]['Price_0'];?></div>
                    <?php }?>
                </div>
            </div>
        <?php if (($i+1)%2==0 || $i==$len-1){?></div><!-- end of .home_box --><?php }?>
    <?php }?>
</div><!-- end of .wrapper -->
