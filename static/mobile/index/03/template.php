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
    </div>
    
    <div class="home_menu">
        <?php
		//产品
		$category_row=str::str_code(db::get_all('products_category', '1=1', "CateId,UId,Category{$c['lang']},PicPath",  $c['my_order'].'CateId asc'));
		$allcate_ary=array();
		foreach($category_row as $k=>$v){
			$allcate_ary[$v['UId']][]=$v;
		}
		foreach ((array)$allcate_ary['0,'] as $k=>$v){?>
        <div class="item <?=$allcate_ary["{$v['UId']}{$v['CateId']},"]?'lower':'';?>">
        	<h2><a href="<?=web::get_url($v, 'products_category')?>"><?=$v['Category'.$c['lang']];?></a></h2>
            <?php if ($allcate_ary["{$v['UId']}{$v['CateId']},"]){?>
            <div class="sub">
            	<?php foreach ($allcate_ary["{$v['UId']}{$v['CateId']},"] as $kk=>$vv){?>
            	<div class="i"><a href="<?=web::get_url($vv, 'products_category');?>"><?=$vv['Category'.$c['lang']];?></a></div>
                <?php }?>
            </div>
            <?php }?>
        </div>
        <?php }?>
    </div><!-- end of .home_menu -->
    
</div><!-- end of .wrapper -->
