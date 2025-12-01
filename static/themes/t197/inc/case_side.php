<?php !isset($c) && exit();?>
<?php
$case_catalog_set_time=@filemtime(web::get_cache_path($c['themes']).'/case_catalog.html');//文件生成时间
!$case_catalog_set_time && $case_catalog_set_time=0;
$set_cache=$c['time']-$case_catalog_set_time-$c['cache_timeout'];	//当前时间 - 文件生成时间 - 自动生成静态文件时间间隔

if($set_cache>0 || !is_file(web::get_cache_path($c['themes']).'/case_catalog.html')){
	ob_start();

	$allcate_row=str::str_code(db::get_all('case_category', '1', "CateId,UId,Category{$c['lang']}",  $c['my_order'].'CateId asc'));
	$allcate_ary=array();
	foreach($allcate_row as $k=>$v){
		$allcate_ary[$v['UId']][]=$v;
	}
?>
<div class="leftmenu">
    <div class="t"><?=$c['lang_pack']['case'];?></div>
    <div class="cate_box">
    <?php foreach($allcate_ary["0,"] as $k=>$v){?>
    <div class="row category_<?=$v['CateId']; ?>">
        <div class="n1 <?=$allcate_ary["0,{$v['CateId']},"]?'has':'';?> <?=$k==0?'nor':'';?>">
        	<a href="<?=web::get_url($v,'case_category');?>"title="<?=$name=$v['Category'.$c['lang']];?>"><?=$name=$v['Category'.$c['lang']];?></a>
        </div>
        <?php if ($allcate_ary["0,{$v['CateId']},"]){?>
        <div class="sub">
        	<?php foreach((array)$allcate_ary["0,{$v['CateId']},"] as $k1=>$v1){?>
            <div class="i">
            	<a href="<?=web::get_url($v1,'case_category');?>" class="category_<?=$v1['CateId']; ?>" title="<?=$v1['Category'.$c['lang']];?>"><?=$v1['Category'.$c['lang']];?></a>
            </div>
            <?php }?>
        </div>
        <?php }?>
    </div>
    <?php }?>
    </div>
</div><!-- end of .leftmenu -->
<?php 
	$cache_catalog_contents=ob_get_contents();
	ob_end_clean();
	file::write_file(web::get_cache_path($c['themes'], 0), 'case_catalog.html', $cache_catalog_contents);
	echo $cache_catalog_contents;
	unset($cache_catalog_contents);
}else{
	include(web::get_cache_path($c['themes']).'/case_catalog.html');
}
if($CateId){ ?>
<script>
    $('.category_<?=$TopCateId; ?>,.category_<?=$CateId; ?>').addClass('on');
</script>
<?php } ?>