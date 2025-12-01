<?php !isset($c) && exit();?>
<?php
$allcate_row=str::str_code(db::get_all('products_category', '1', "CateId,UId,Category{$c['lang']}",  $c['my_order'].'CateId asc'));
$allcate_ary=array();
foreach($allcate_row as $k=>$v){
	$allcate_ary[$v['UId']][]=$v;
}
?>
<div class="leftmenu">
    <div class="t"><?=$c['lang_pack']['cate'];?></div>
    <div class="cate_box">
    <?php foreach($allcate_ary["0,"] as $k=>$v){?>
    <?php if($k>7) continue;?>
    <div class="row">
        <div class="n1 <?=$allcate_ary["0,{$v['CateId']},"]?'has':'';?> <?=$k==0?'nor':'';?> cate_<?=$v['CateId'];?> f_<?=$v['CateId'];?>">
        	<a href="<?=web::get_url($v);?>"title="<?=$name=$v['Category'.$c['lang']];?>"><?=$name=$v['Category'.$c['lang']];?></a>
        </div>
    </div>
    <?php }?>
    </div>
</div><!-- end of .leftmenu -->