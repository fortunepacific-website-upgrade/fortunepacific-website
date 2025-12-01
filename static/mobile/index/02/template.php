<?php !isset($c) && exit();?>
<?php
$ad_row = ly200::ad_custom(1);
$ad_oth_row = ly200::ad_custom(2);
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
    
    <div class="home_box">
    	<?php
        for ($i=0; $i<4; $i++){
			if (!is_file($c['root_path'].$ad_oth_row['PicPath'][$i])){continue;}
		?>
    	<div class="clean item">
        	<div class="<?=$i%2==0?'fl':'fr';?> img">
            	<a href="<?=$ad_oth_row['Url'][$i];?>"><img src="<?=$ad_oth_row['PicPath'][$i];?>" /></a>
            </div>
            <div class="<?=$i%2==0?'fr':'fl';?> c">
            	<h2><?=$ad_oth_row['Title'][$i];?></h2>
                <div class="txt">
                	<?=$ad_oth_row['Contents'][$i];?>
                </div>
            </div>
        </div><!-- end of .item -->
        <?php }?>
    </div><!-- end of .home_box -->
    
    <div class="home_oth">
    	<div class="t"><?=db::get_value('article_category', 'CateId=1', 'Category'.$c['lang']);?></div>
        <div class="txt">
        	<?php
				$AId = db::get_value('article', "CateId=1", 'AId', $c['my_order'].'AId asc');
				echo str::str_cut(strip_tags(str_replace('&nbsp;', ' ', db::get_value('article_content', "AId='$AId'", 'Content'.$c['lang']))), 320);
			?>...
        </div>
    </div>
    
</div><!-- end of .wrapper -->
