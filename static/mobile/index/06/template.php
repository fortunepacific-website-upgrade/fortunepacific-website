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
        <div class="btn">
        	<?php for ($i=0; $i<$sum; $i++){?>
            <span class="<?=$i==0?'on':'';?>"></span>
            <?php }?>
        </div>
    </div><!-- end of .banner -->
	
    <div class="hmenu clean">
    	<?php 
			$m_about_row=db::get_one('article', "CateId=1", '*', $c['my_order'].'AId asc');
			$m_about_url=!$m_about_row?'javascript:;':web::get_url($m_about_row, 'article');
			
			$m_contact_row=db::get_one('article', "CateId=2", '*', $c['my_order'].'AId asc');
			$m_contact_url=!$m_contact_row?'javascript:;':web::get_url($m_contact_row, 'article');
		?>
    	<div class="i fl"><a href="<?=$m_about_url;?>"><?=db::get_value('article_category', "CateId='1'", "Category{$c['lang']}");?></a></div>
        <div class="i fl"><a href="/products/"><?=$c['lang_pack']['mobile']['products'];?></a></div>
        <div class="i fl"><a href="<?=$m_contact_url;?>"><?=db::get_value('article_category', "CateId='2'", "Category{$c['lang']}");?></a></div>
    </div>
    
    <div class="home_pro">
    	<div class="home_t"><?=$c['lang_pack']['mobile']['our_pro'];?></div>
        <div class="list clean">
        	<?php
			$products_list_row=str::str_code(db::get_limit('products', $c['where']['products'].' and IsIndex=1', '*', $c['my_order'].'ProId desc', 0, 6));
			for ($i=0,$len=count($products_list_row); $i<$len; $i++){
				$url=web::get_url($products_list_row[$i], 'products');
				$img=img::get_small_img($products_list_row[$i]['PicPath_0'], '240X240');
				$name=$products_list_row[$i]['Name'.$c['lang']];
			?>
            <div class="item fl">
                <div class="img pic_box"><a href="<?=$url;?>" title="<?=$name;?>"><img src="<?=$img;?>" alt="<?=$name;?>" /></a><span></span></div>
                <div class="name"><a href="<?=$url;?>" title="<?=$name;?>"><?=$name;?></a></div>
                <?php if($showCfg['prod']['show_price'] && $c['FunVersion']>=1 && (int)$_SESSION['ly200_user']['UserId']){?>
                <div class="price"><?=$showCfg['symbol'].$products_list_row[$i]['Price_0'];?></div>
                <?php }?>
            </div>
            <?php }?>
        </div>
    </div>
    
</div><!-- end of .wrapper -->
