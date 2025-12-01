<?php !isset($c) && exit();?>
<?php
$art_catalog_set_time=@filemtime(web::get_cache_path($c['themes']).'/art_catalog_'.$article_row['CateId'].'.html');//文件生成时间
!$art_catalog_set_time && $art_catalog_set_time=0;
$set_cache=$c['time']-$art_catalog_set_time-$c['cache_timeout'];	//当前时间 - 文件生成时间 - 自动生成静态文件时间间隔

if($set_cache>0 || !is_file(web::get_cache_path($c['themes']).'/art_catalog_'.$article_row['CateId'].'.html')){
	ob_start();
	$art_row=db::get_all('article', "CateId='{$article_row['CateId']}'", "AId,CateId,Title{$c['lang']},Url,PageUrl", $c['my_order']."AId asc");
	?>
	<div class="leftmenu">
	    <div class="t"><?=db::get_value('article_category',"CateId='$article_row[CateId]'","Category".$c['lang']);?></div>
	    <div class="cate_box">
	   <?php foreach($art_row as $k=>$v){?>
	    <div class="row AId_<?=$v['AId']; ?>">
	        <div class="n1 <?=$k==0?'nor':'';?>"><a href="<?=web::get_url($v, 'article');?>" title="<?=$v['Title'.$c['lang']];?>"><?=$v['Title'.$c['lang']];?></a></div>
	    </div>
	    <?php }?>
	    </div>
	</div><!-- end of .leftmenu -->
	<?php 
	$cache_catalog_contents=ob_get_contents();
	ob_end_clean();
	file::write_file(web::get_cache_path($c['themes'], 0), 'art_catalog_'.$article_row['CateId'].'.html', $cache_catalog_contents);
	echo $cache_catalog_contents;
	unset($cache_catalog_contents);
}else{
	include(web::get_cache_path($c['themes']).'/art_catalog_'.$article_row['CateId'].'.html');
}
if($article_row['AId']){ ?>
<script>
    $('.AId_<?=$article_row['AId']; ?>').addClass('on');
</script>
<?php } ?>