<?php !isset($c) && exit();?>
<?=ly200::load_static($c['mobile']['tpl_dir'].'js/TouchSlide.1.1.js');?>
<div id="tabBox_goods" style="overflow: hidden;height: 240px;">      
    <div class="goods_pic bd" id="tabBox_goods_bd">
        <?php
        for($i=0; $i<5; $i++){
            $pic=$products_row['PicPath_'.$i];
            if(!is_file($c['root_path'].$pic)) continue;
            $bigpic = img::get_small_img($pic, '500x500');
        ?>
        <div class="fl con pic_box"><img src="<?=$bigpic;?>"><span></span></div>
        <?php }?>
    </div>
    <div class="hd">
        <ul>
            <?php
            for($i=0; $i<5; $i++){
                $pic=$products_row['PicPath_'.$i];
                if(!is_file($c['root_path'].$pic)) continue;
                $bigpic = img::get_small_img($pic, '500x500');
            ?>
            <li></li>
            <?php }?>
        </ul>
    </div>
    <a href="javascript:;" class="prev"></a>
    <a href="javascript:;" class="next"></a>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#tabBox_goods').removeAttr('style');
        TouchSlide( { slideCell:"#tabBox_goods",effect:"leftLoop",
            endFun:function(i){ //高度自适应
                var bd = document.getElementById("tabBox_goods_bd");
                i++;
                bd.parentNode.style.height = bd.children[i].children[0].offsetHeight+"px";
                if(i>0)bd.parentNode.style.transition="200ms";//添加动画效果
            }

        } );
    });
</script>
<div class="goods_info clean">
    <div class="name"><?=$Name;?></div>
    <div class="brief"><?=$products_row['BriefDescription'.$c['lang']];?></div>
    <?php if($c['config']['products']['Config']['show_price'] && $c['FunVersion']>=1 && $v['Price_0']>0){?>
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
    <a href="javascript:void(0);" class="global_btn inquiry_btn" data="<?=$products_row['ProId'];?>"><img src="<?=$c['mobile']['tpl_dir'].'goods/'.$c['mobile']['GoodsListTpl'].'/images/inquiry.png'; ?>" alt=""><?=$c['lang_pack']['mobile']['inq'];?></a>
    <a href="/feedback.html" class="feedback_btn"><img src="<?=$c['mobile']['tpl_dir'].'goods/'.$c['mobile']['GoodsListTpl'].'/images/contact.png'; ?>" alt=""><?=$c['lang_pack']['contact']; ?></a>
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
    <div class="text clean">
        <?=(str::str_code($products_description_row['Description'.$c['lang']], 'htmlspecialchars_decode'));?>
    </div>
</section><!-- end of .detail_desc -->
<?php for($i=0;$i<$c['description_count'];$i++){if(!$products_description_row['IsOpen_'.$i])continue;?>
<section class="detail_desc">
    <div class="t"><?=$products_description_row['Title_'.$i.$c['lang']]?></div>
    <div class="text clean">
        <?=(str::str_code($products_description_row['Description_'.$i.$c['lang']], 'htmlspecialchars_decode'));?>
    </div>
</section><!-- end of .detail_desc -->
<?php }?>
<div class="hot_pro">
    <div class="title"><?=$c['lang_pack']['hot']; ?></div>
    <div class="hot_list">
        <?php
        $hot_products = db::get_limit('products',$c['where']['products'].' and IsHot=1','*',$c['my_order'].'ProId desc',0,4);
        foreach($hot_products as $k=>$v){
            $url=web::get_url($v, 'products');
            $img=img::get_small_img($v['PicPath_0'], '240x240');
            $name=$v['Name'.$c['lang']];
            $brief=$v['BriefDescription'.$c['lang']];
        ?>
        <div class="item clean">
            <div class="img pic_box"><a href="<?=$url;?>" title="<?=$name;?>"><img src="<?=$img;?>"></a><span></span></div>
            <div class="desc fr">
                <a href="<?=$url;?>" class="name" title="<?=$name;?>"><?=$name;?></a>
                <div class="brief"><?=$brief; ?></div>
                <?php if($c['config']['products']['Config']['show_price'] && $c['FunVersion']>=1 && $v['Price_0']>0){?>
                    <?php if($c['config']['products']['Config']['member']){?>
                        <?php if((int)$_SESSION['ly200_user']['UserId']){?>
                             <div class="price"><?=$c['config']['products']['symbol'].$v['Price_0'];?></div>
                        <?php }?>
                    <?php }else{?>
                         <div class="price"><?=$c['config']['products']['symbol'].$v['Price_0'];?></div>
                    <?php }?>
                <?php }?>
                <a href="<?=$url; ?>" class="more global_btn"><?=$c['lang_pack']['learn_more']; ?></a>
            </div>
        </div>
        <?php }?>
    </div>
</div>
<script>$(function(){SetMContent(".wrapper .detail_desc .text");})</script>