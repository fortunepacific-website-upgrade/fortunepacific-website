<?php !isset($c) && exit();?>
<div class="goods_pic">
    <ul class="clean">
        <?php
        $j=0;
        for($i=0; $i<5; $i++){
            $pic=$products_row['PicPath_'.$i];
            if(!is_file($c['root_path'].$pic)) continue;
            $j++;
            $bigpic = img::get_small_img($pic, '500x500');
        ?>
        <li class="fl pic_box"><img src="<?=$bigpic;?>"><span></span></li>
        <?php }?>
    </ul>
</div>
<div class="goods_small_pic clean">
    <div class="list clean">
        <?php
        for($i=$sum=0; $i<5; $i++){
            $pic=$products_row['PicPath_'.$i];
            if(!is_file($c['root_path'].$pic)) continue;
            $pic = img::get_small_img($pic, '240x240');
            $sum++;
        ?>
        <div class="pic fl pic_box <?=$sum==1?'on':'';?>"><img src="<?=$pic;?>"><span></span></div>
        <?php }?>
    </div>
</div>
<?php if($j<2){ ?>
<style>
    .goods_small_pic{display: none !important;}
</style>
<?php } ?>
<div class="goods_info clean">
    <div class="name"><?=$Name;?></div>
    <div class="brief"><?=$products_row['BriefDescription'.$c['lang']];?></div>
    <?php if($c['config']['products']['Config']['show_price'] && $c['FunVersion']>=1  && $v['Price_0']>0){?>
        <?php if($c['config']['products']['Config']['member']){?>
            <?php if((int)$_SESSION['ly200_user']['UserId']){?>
                 <div class="price"><?=$c['config']['products']['symbol'].$products_row['Price_0'];?></div>
            <?php }?>
        <?php }else{?>
             <div class="price"><?=$c['config']['products']['symbol'].$products_row['Price_0'];?></div>
        <?php }?>
    <?php }?>
    <?php
	//平台导流
	$platform=str::json_data(htmlspecialchars_decode($products_row['Platform']),'decode');
	foreach((array)$platform as $k => $v){
	?>
    <a href="<?=$v?>" target="_blank" class="platform_btn <?=$k?>_btn"><i></i><?=$c['lang_pack']['buy_'.$k]?></a>
    <?php }?>
</div><!-- end of .goods_info -->
<?php if($c['config']['global']['IsOpenInq']){ ?>
<div id="goods_inquiry" class="clean">
    <a href="javascript:void(0);" class="global_btn inquiry_btn" data="<?=$products_row['ProId'];?>"><?=$c['lang_pack']['mobile']['inq'];?></a>
    <div class="clear"></div>
</div>
<div class="clear"></div>
<?php } ?>
<?php if($c['config']['products']['Config']['share']){?>
    <div class="share"> <?php include($c['static_path'].'inc/global/share.php');?> </div>
<?php }?>
<?php if($products_row['Attr']){?>
<section class="detail_desc">
    <div class="t"><?=$c['lang_pack']['mobile']['par'];?></div>
    <table border="0" cellpadding="1" cellspacing="5" width="90%" id="cust_table">
        <?php
        $products_attr=str::str_code(db::get_all('products_attribute', 1, "AttrId, Name{$c['lang']}, CartAttr, ColorAttr, Value{$c['lang']}", $c['my_order'].'AttrId asc'));
        $attr=str::json_data(str::str_code($products_row['Attr'], 'htmlspecialchars_decode'),'decode');
        $cur_lang=substr($c['lang'], 1);
        foreach((array)$attr as $key => $val){
            $is_val = $val;
            if($is_val) break;
        }
        if($is_val){
            foreach((array)$products_attr as $k=>$v){
                if (!$attr[$v['AttrId']][$cur_lang]){continue;}
        ?>
            <tr>
                <td width="30%"><?=$v['Name'.$c['lang']];?>:</td>
                <td width="70%"><?=$attr[$v['AttrId']][$cur_lang];?></td>
            </tr>
        <?php
            }
        }
        ?>
    </table>
</section>
<?php }?>
<?php
$isDown = 0;//下载
for($i=0; $i<5; ++$i){
    if(is_file($c['root_path'].$products_row["FilePath_$i"])){
        $isDown = 1;
        break;
    }
}
if ($isDown){
?>
<section class="detail_desc">
    <div class="t"><?=$c['lang_pack']['download'];?></div>
    <ul class="pro_down">
        <?php
        for($i=0; $i<5; ++$i){
            if(!is_file($c['root_path'].$products_row["FilePath_$i"])) continue;
        ?>
        <li><a href="javascript:;"  class="<?=$products_row['FilePwd_'.$i]?'pwd':'';?>" path="<?=$i;?>" proid="<?=$products_row['ProId'];?>">&bull; <?=$products_row["FileName_$i"];?><span class="down_btn"></span></a></li>
        <?php }?>
    </ul>
</section><!-- end of .detail_desc -->
<?php }?>

<section class="detail_desc">
    <div class="t"><?=$c['lang_pack']['mobile']['pro_details'];?></div>
    <div class="text">
        <?=(str::str_code($products_description_row['Description'.$c['lang']], 'htmlspecialchars_decode'));?>
    </div>
</section><!-- end of .detail_desc -->
<?php for($i=0;$i<$c['description_count'];$i++){if(!$products_description_row['IsOpen_'.$i])continue;?>
<section class="detail_desc">
    <div class="t"><?=$products_description_row['Title_'.$i.$c['lang']]?></div>
    <div class="text">
        <?=(str::str_code($products_description_row['Description_'.$i.$c['lang']], 'htmlspecialchars_decode'));?>
    </div>
</section><!-- end of .detail_desc -->
<?php }?>
<?=ly200::load_static($c['mobile']['tpl_dir'].'js/TouchSlide.1.1.js');?>
<div class="hot_title"><?=$c['lang_pack']['hot'];?></div>
<div class="hot_box">
    <?php
    $hot_products = db::get_limit('products',$c['where']['products'].' and IsHot=1','*',$c['my_order'].'ProId desc',0,12);
    $hot_products_row = array(); 
    foreach((array)$hot_products as $k=>$v){
        if($k % 3 ==0) $hot_products_row[] = array_slice($hot_products,$k,3);
    }
    ?>
    <div id="picScroll" class="picScroll">
        <div class="hd">
            <ul><li></li></ul>
        </div>
        <div class="bd">
            <?php foreach((array)$hot_products_row as $k=>$v){ ?>
                <ul>
                    <?php foreach((array)$v as $v1){ 
                        $img = img::get_small_img($v1['PicPath_0'], '500x500');
                        $url = web::get_url($v1,'products');
                        $name = $v1['Name'.$c['lang']];
                        ?>
                        <li>
                            <div class="pic_box">
                                <a href="<?=$url; ?>" target="_blank" title="<?=$name; ?>"><img src="<?=$img; ?>" /></a><span></span>
                            </div>
                            <a href="<?=$url; ?>" class="proname"><?=$name; ?></a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
    </div>
    <script type="text/javascript">
        TouchSlide({ 
            slideCell:"#picScroll",
            titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
            autoPage:true, //自动分页
            pnLoop:"false", // 前后按钮不循环
        });
    </script>
</div>
<script>$(function(){SetMContent(".wrapper .detail_desc .text");})</script>