<?php !isset($c) && exit();?>
<?php
$ad_row = ly200::ad_custom(1);
?>
<div class="wrapper">
	<div class="banner" id="banner_box">
        <?=ly200::ad(1); ?>
    </div><!-- end of .banner -->
    <div class="home_pic">
        <div class="picA">
            <div class="pict"><?=ly200::ad(2); ?></div>
            <div class="picb"><?=ly200::ad(3); ?></div>
        </div>
        <div class="picB">
            <div class="pic"><?=ly200::ad(4); ?></div>
        </div>
        <div class="picA">
            <div class="pict"><?=ly200::ad(5); ?></div>
            <div class="picb"><?=ly200::ad(6); ?></div>
        </div>
        <div class="clear"></div>
    </div>
    <?php $ad_info_row = ly200::ad_custom(7); ?>
    <div class="home_title home_title2"><?=$ad_info_row['Title']; ?></div>
    <div class="home_info"><?=ly200::ad(7); ?></div>
    <div class="home_title"><?=$c['lang_pack']['mobile']['feat_pro'];?></div>
    <div class="home_box">
        <?php
        $home_products = db::get_limit('products',$c['where']['products'].' and IsIndex=1','*',$c['my_order'].'ProId desc',0,12);
        $home_products_row = array(); 
        foreach((array)$home_products as $k=>$v){
            if($k % 4 ==0) $home_products_row[] = array_slice($home_products,$k,4);
        }
        ?>
        <div id="picScroll" class="picScroll">
            <div class="hd">
                <ul><li></li></ul>
            </div>
            <div class="bd">
                <?php foreach((array)$home_products_row as $k=>$v){ ?>
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
    <div class="home_title"><?=$c['lang_pack']['inf']; ?></div>
    <div class="home_news">
        <?php 
        $info_row = db::get_limit('info','IsIndex=1','*',$c['my_order'].'InfoId desc',0,3); 
        foreach((array)$info_row as $v){
            $name = $v['Title'.$c['lang']];
            $date = date('Y-m-d',$v['AccTime']);
            $img = $v['PicPath'];
            $url = web::get_url($v,'info');
            ?>
            <div class="list">
                <div class="pic_box">
                    <a href="<?=$url; ?>" title="<?=$name; ?>"><img src="<?=$img; ?>" /></a><span></span>
                </div>
                <a href="<?=$url; ?>" class="name"><?=$name; ?></a>
                <div class="date"><?=$date; ?></div>
            </div>
        <?php } ?>
        <div class="clear"></div>
    </div>
</div><!-- end of .wrapper -->