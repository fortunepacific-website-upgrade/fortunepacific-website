<?php !isset($c) && exit();?>
<div class="wrapper">
	<div class="banner" id="banner_box">
        <?=ly200::ad(1) ?>
    </div><!-- end of .banner -->
    <div class="home_title"><?=$c['lang_pack']['mobile']['feat_pro'];?></div>
    <?php
    $products_list_row=str::str_code(db::get_limit('products', $c['where']['products'].' and IsIndex=1', '*', $c['my_order'].'ProId desc', 0, 4));
    for ($i=0,$len=count($products_list_row); $i<$len; $i++){
        $url=web::get_url($products_list_row[$i], 'products');
        $img=img::get_small_img($products_list_row[$i]['PicPath_0'], '500x500');
        $name=$products_list_row[$i]['Name'.$c['lang']];
        $brief=$products_list_row[$i]['BriefDescription'.$c['lang']];
    ?>
        <?php if ($i%2==0){?><div class="home_box clean"><?php }?>
            <div class="small_pro fl">
                <div class="c">
                    <div class="img pic_box small_height"><a href="<?=$url;?>" title="<?=$name;?>"><img src="<?=$img;?>"></a><span></span></div>
                    <div class="proname"><a href="<?=$url;?>" title="<?=$name;?>"><?=$name;?></a></div>
                    <div class="probrief"><?=$brief; ?></div>
                    <?php if($c['config']['products']['Config']['show_price'] && $c['FunVersion']>=1){?>
                        <?php if($c['config']['products']['Config']['member']){?>
                            <?php if((int)$_SESSION['ly200_user']['UserId']){?>
                                 <div class="price"><?=$c['config']['products']['symbol'].$products_list_row[$i]['Price_0'];?></div>
                            <?php }?>
                        <?php }else{?>
                             <div class="price"><?=$c['config']['products']['symbol'].$products_list_row[$i]['Price_0'];?></div>
                        <?php }?>
                    <?php }?>
                    <a href="<?=$url;?>" class="promore global_btn"><?=$c['lang_pack']['desc']; ?></a>
                </div>
            </div>
        <?php if (($i+1)%2==0 || $i==count($list_row[0])-1){?></div><!-- end of .home_box --><?php }?>
    <?php }?>
    <?php 
    $ad_info_name_pic = ly200::ad_custom(2);
    $ad_info_desc = ly200::ad_custom(3);
    ?>
    <div class="home_title home_title2"><?=$ad_info_name_pic['Title'][0];?></div>
    <div class="home_info">
        <div class="pic"><a href="<?=$ad_info_name_pic['Url'][0];?>"><img src="<?=$ad_info_name_pic['PicPath'][0];?>" alt=""></a></div>
        <div class="desc"><?=$ad_info_desc['Contents']; ?></div>
    </div>
    <div class="home_title"><?=$c['lang_pack']['partner']; ?></div>
    <?=ly200::load_static($c['mobile']['tpl_dir'].'js/TouchSlide.1.1.js');?>
    <div class="home_partners">
        <?php
        $partners = db::get_limit('partners','1','*',$c['my_order'].'PId desc',0,12);
        $partners_row = array(); 
        foreach((array)$partners as $k=>$v){
            if($k % 3 ==0) $partners_row[] = array_slice($partners,$k,3);
        }
        ?>
        <div id="picScroll" class="picScroll">
            <div class="hd">
                <ul><li></li></ul>
            </div>
            <div class="bd">
                <?php foreach((array)$partners_row as $k=>$v){ ?>
                    <ul>
                        <?php foreach((array)$v as $v1){ 
                            $img = $v1['PicPath'];
                            $url = $v1['Url'];
                            $name = $v['Name'.$c['lang']];
                            ?>
                            <li class="pic_box"><a href="<?=$url; ?>" target="_blank" title="<?=$name; ?>"><img src="<?=$img; ?>" /></a><span></span></li>
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
</div><!-- end of .wrapper -->