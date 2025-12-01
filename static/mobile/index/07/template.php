<?php !isset($c) && exit();?>
<?php
$contactInfo=str::str_code(db::get_value('config', "GroupId='global' and Variable='Contact'", 'Value'));
$contactInfo=str::json_data(htmlspecialchars_decode($contactInfo), 'decode');
$contactArr=array();
foreach($contactInfo as $k=>$v) $contactArr[$k]=$v;
?>
<div class="wrapper">
	<div class="topbar">
    	<div class="c">
        	<a href="/products/" class="bar_a0 bar_a"><?=$c['lang_pack']['mobile']['visit_us'];?></a>
            <div class="clean">
            	<a href="tel:<?=$contactArr['tel']?>" class="bar_a1 bar_a fl bg0"><?=$c['lang_pack']['mobile']['call_us'];?></a>
                <a href="mailto:<?=$contactArr['email']?>" class="bar_a1 bar_a fr bg1"><?=$c['lang_pack']['mobile']['contact_us'];?></a>
            </div>
            <div class="opentime"><?=$c['lang_pack']['mobile']['work_time'];?>:<?=strip_tags(db::get_value('web_settings','`Themes` = "07" and `Position` = 1',"Data"));?></div>
        </div>
    </div>
	
    <section class="home_pro">
    	<?php
		$products_list_row=str::str_code(db::get_limit('products', $c['where']['products'].' and IsIndex=1', '*', $c['my_order'].'ProId desc', 0, 6));
		for ($i=0,$len=count($products_list_row); $i<$len&&$i<3; $i++){
			$url=web::get_url($products_list_row[$i], 'products');
			$img=img::get_small_img($products_list_row[$i]['PicPath_0'], '500x500');
			$name=$products_list_row[$i]['Name'.$c['lang']];?>
    	<div class="item clean">
        	<div class="img"><a href="<?=$url;?>"><img src="<?=$img;?>"></a></div>
            <div class="name"><a href="<?=$url;?>"><?=$name;?></a></div>
            <div class="brief">
            	<a class="more fr" href="<?=$url;?>"><?=$c['lang_pack']['mobile']['read_more'];?></a>
            	<?=$products_list_row[$i]['BriefDescription'.$c['lang']];?>
            </div>
            <?php if($showCfg['prod']['show_price'] && $c['FunVersion']>=1 && (int)$_SESSION['ly200_user']['UserId']){?>
            <div class="price"><?=$showCfg['symbol'].$products_list_row[$i]['Price_0'];?></div>
            <?php }?>
        </div>
        <?php }?>
        <?php for ($i=3,$len=count($products_list_row); $i<$len; $i++){
			$url=web::get_url($products_list_row[$i], 'products');
			$img=img::get_small_img($products_list_row[$i]['PicPath_0'], '500x500');
			$name=$products_list_row[$i]['Name'.$c['lang']];?>
        <div class="item clean">
            <div class="name"><a href="<?=$url;?>"><?=$name;?></a></div>
            <div class="brief">
            	<?=$products_list_row[$i]['BriefDescription'.$c['lang']];?>
            </div>
            <div class="read_more"><a href="<?=$url;?>"><?=$c['lang_pack']['mobile']['read_more'];?></a><i></i></div>
        </div>
        <?php }?>
    </section>
    
</div><!-- end of .wrapper -->
