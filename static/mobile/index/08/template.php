<?php !isset($c) && exit();?>
<?php
$ad_row = ly200::ad_custom(1);
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
    </div><!-- end of .banner -->
	<div class="homebar">
    	<div class="btn fl"></div>
        <div class="list fl">
        	<div class="c clean">
            	<?php
                $art_cate_row = db::get_limit('article_category', '1', 'CateId', $c['my_order'].'CateId asc', 0, 2);
				foreach ($art_cate_row as $k=>$v){
					$row = db::get_one('article', "CateId='{$v['CateId']}'", '*', $c['my_order'].'AId desc');
					if(!$row) continue;
				?>
            	<div class="item fl"><a href="<?=web::get_url($row, 'article');?>"><?=$row['Title'.$c['lang']];?></a></div>
                <?php }?>
                <div class="item fl"><a href="/products/"><?=$c['lang_pack']['mobile']['products'];?></a></div>
                <div class="item fl"><a href="/info/"><?=$c['lang_pack']['mobile']['news'];?></a></div>
            </div>
        </div>
        <div class="btn fr"></div>
    </div>
    <div class="home_title"><a href="/products/" class="more fr global_btn"><?=$c['lang_pack']['mobile']['more'];?></a><?=$c['lang_pack']['mobile']['feat_pro'];?></div>
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
                    <div class="img pic_box"><a href="<?=$url;?>" title="<?=$name;?>"><img src="<?=$img;?>"></a><span></span></div>
                    <div class="proname"><a href="<?=$url;?>" title="<?=$name;?>"><?=$name;?></a></div>
                    <?php if($showCfg['prod']['show_price'] && $c['FunVersion']>=1 && (int)$_SESSION['ly200_user']['UserId']){?>
                    <div class="price"><?=$showCfg['symbol'].$v['Price_0'];?></div>
                    <?php }?>
                </div>
            </div>
        <?php if (($i+1)%2==0 || $i==count($list_row[0])-1){?></div><!-- end of .home_box --><?php }?>
    <?php }?>
</div><!-- end of .wrapper -->
