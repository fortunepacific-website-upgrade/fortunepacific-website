<?php !isset($c) && exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?=web::seo_meta();?>
<?php include("{$c['static_path']}/inc/static.php");?>
</head>
<body class="lang<?=$c['lang'];?>">
<?php include("{$c['theme_path']}/inc/header.php");?>
<div class="sitemap">
    <div class="toptitle">
        <?=$c['lang_pack']['products']; ?>
    </div>
    <div class="sitemap_box">
        <?php 
        $allcate_row=str::str_code(db::get_all('products_category', '1', '*',  $c['my_order'].'CateId asc'));
        $allcate_ary=array();
        foreach($allcate_row as $k=>$v){
            $allcate_ary[$v['UId']][]=$v;
        }
        foreach((array)$allcate_ary['0,'] as $k => $v){
        ?>
        <dl>
            <dt><a href="<?=web::get_url($v);?>" title="<?=$v['Category'.$c['lang']];?>"><?=$v['Category'.$c['lang']];?></a></dt>
            <?php if($allcate_ary["0,{$v['CateId']},"]){?>
                <dd>
                    <?php foreach($allcate_ary["0,{$v['CateId']},"] as $k1=>$v1){?>
                    <p><a href="<?=web::get_url($v1);?>" title="<?=$v1['Category'.$c['lang']];?>"><?=$v1['Category'.$c['lang']];?></a></p>
                    <ul>
                        <?php foreach($allcate_ary["0,{$v['CateId']},{$v1['CateId']},"] as $k2=>$v2){?>
                            <li><a href="<?=web::get_url($v2);?>" title="<?=$v2['Category'.$c['lang']];?>">&gt; <?=$v2['Category'.$c['lang']];?></a></li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                </dd>
            <?php } ?>
        </dl>
        <?php if($k%5==4){ ?>
            <div class="clear"></div>
        <?php } ?>
        <?php } ?>
        <div class="clear"></div>
    </div>
    <div class="toptitle">
        <?=$c['lang_pack']['case']; ?>
    </div>
    <div class="sitemap_box">
        <?php 
        $allcate_row=str::str_code(db::get_all('case_category', '1', '*',  $c['my_order'].'CateId asc'));
        $allcate_ary=array();
        foreach($allcate_row as $k=>$v){
            $allcate_ary[$v['UId']][]=$v;
        }
        foreach((array)$allcate_ary['0,'] as $k => $v){
        ?>
        <dl>
            <dt><a href="<?=web::get_url($v,'case_category');?>" title="<?=$v['Category'.$c['lang']];?>"><?=$v['Category'.$c['lang']];?></a></dt>
            <?php if($allcate_ary["0,{$v['CateId']},"]){?>
                <dd>
                    <?php foreach($allcate_ary["0,{$v['CateId']},"] as $k1=>$v1){?>
                    <p><a href="<?=web::get_url($v1,'case_category');?>" title="<?=$v1['Category'.$c['lang']];?>"><?=$v1['Category'.$c['lang']];?></a></p>
                    <?php } ?>
                </dd>
            <?php } ?>
        </dl>
        <?php if($k%5==4){ ?>
            <div class="clear"></div>
        <?php } ?>
        <?php } ?>
        <div class="clear"></div>
    </div>      
    <div class="toptitle">
        <?=$c['lang_pack']['news']; ?>
    </div>
    <div class="sitemap_box">
        <?php 
        $allcate_row=str::str_code(db::get_all('info_category', '1', '*',  $c['my_order'].'CateId asc'));
        foreach((array)$allcate_row as $k => $v){
            $info_row = db::get_all('info','CateId='.$v['CateId'],'*',$c['my_order'].'InfoId desc')
        ?>
        <dl>
            <dt><a href="<?=web::get_url($v,'info_category');?>" title="<?=$v['Category'.$c['lang']];?>"><?=$v['Category'.$c['lang']];?></a></dt>
            <?php if($info_row){?>
                <dd>
                    <?php foreach((array)$info_row as $k1=>$v1){
                        if($k1>9) continue;
                        ?>
                    <p><a href="<?=web::get_url($v1,'info');?>" title="<?=$v1['Title'.$c['lang']];?>"><?=$v1['Title'.$c['lang']];?></a></p>
                    <?php } ?>
                </dd>
            <?php } ?>
        </dl>
        <?php if($k%5==4){ ?>
            <div class="clear"></div>
        <?php } ?>
        <?php } ?>
        <div class="clear"></div>
    </div>     
    <div class="toptitle">
        <?=$c['lang_pack']['other']; ?>
    </div>
    <div class="sitemap_box">
        <?php 
        $allcate_row=str::str_code(db::get_all('article_category', '1', '*',  $c['my_order'].'CateId asc'));
        foreach((array)$allcate_row as $k => $v){
            $article_row = db::get_all('article','CateId='.$v['CateId'],'*',$c['my_order'].'AId asc')
        ?>
        <dl>
            <dt><a href="javascript:;" title="<?=$v['Category'.$c['lang']];?>"><?=$v['Category'.$c['lang']];?></a></dt>
            <?php if($article_row){?>
                <dd>
                    <?php foreach($article_row as $k1=>$v1){?>
                    <p><a href="<?=web::get_url($v1,'article');?>" title="<?=$v1['Title'.$c['lang']];?>"><?=$v1['Title'.$c['lang']];?></a></p>
                    <?php } ?>
                </dd>
            <?php } ?>
        </dl>
        <?php if($k%5==4){ ?>
            <div class="clear"></div>
        <?php } ?>
        <?php } ?>
        <div class="clear"></div>
    </div> 
</div>
<?php include("{$c['theme_path']}/inc/footer.php");?>
</body>
</html>