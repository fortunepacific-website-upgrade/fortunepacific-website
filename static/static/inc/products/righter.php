<?php !isset($c) && exit();?>
<div class="fr info pro_right">
	<div class="pro_prev_next clean">
		<?php //上一个
		$proid_where=((int)$_SESSION['ly200_user']['UserId']?'1':'IsMember=0')." and SaleOut!=1 and CateId='{$products_row['CateId']}'";
		$prev_where=$proid_where." and ((MyOrder='{$products_row['MyOrder']}' and ProId>'{$products_row['ProId']}')";
		$products_row['MyOrder'] && $prev_where.=" or (MyOrder>0 and MyOrder<'{$products_row['MyOrder']}')";
		($products_row['MyOrder']==-1 || $products_row['MyOrder']==0) && $prev_where.=" or MyOrder>'{$products_row['MyOrder']}'";
		$prev_where.=")";
        $prev_row = db::get_one('products', $prev_where, '*', 'if(MyOrder>0, MyOrder, if(MyOrder=0, 1000000, 1000001)) desc, ProId asc');
        if($prev_row){
        ?>
            <a href="<?=web::get_url($prev_row, 'products');?>" title="<?=$prev_row['Name'.$c['lang']]?>" class="prev"></a>
        <?php }?>
        <?php //*下一个
 		$next_where=$proid_where." and ((MyOrder='{$products_row['MyOrder']}' and ProId<'{$products_row['ProId']}')";
		$products_row['MyOrder']>0 && $next_where.=" or MyOrder>'{$products_row['MyOrder']}' or MyOrder=0 or MyOrder=-1";
		$products_row['MyOrder']==0 && $next_where.=" or MyOrder=-1";
		$next_where.=")";
		$next_row = db::get_one('products', $next_where, '*', 'if(MyOrder>0, MyOrder, if(MyOrder=0, 1000000, 1000001)) asc, ProId desc');
        if($next_row){
        ?>
            <a href="<?=web::get_url($next_row, 'products');?>" title="<?=$next_row['Name'.$c['lang']]?>" class="next"></a>
        <?php }?>
    </div>
    <h1 class="name"><?=$Name;?></h1>
    <?php if($products_row['Number']){?>
		<div class="blank9"></div>
		<div class="itemno"><strong><?=$c['lang_pack']['item_no'];?>:</strong> <?=$products_row['Number'];?></div>
		<div class="blank9"></div>
    <?php }?>
    <div class="brief"><?=str::str_format($products_row['BriefDescription'.$c['lang']]);?></div>
    <?php 
	//产品属性
	$products_attr=str::str_code(db::get_all('products_attribute', 1, "AttrId, Name{$c['lang']}, CartAttr, ColorAttr, Value{$c['lang']}", $c['my_order'].'AttrId asc'));
	$attr=str::json_data(str::str_code($products_row['Attr'], 'htmlspecialchars_decode'),'decode');
	$cur_lang=substr($c['lang'], 1);
	foreach((array)$attr as $key => $val){
		if ( array_key_exists($cur_lang, $val) ){
			$is_val = $val[$cur_lang];
		}else{
			$is_val = $val;
		}
		if($is_val) break;
	}
	if($is_val && $products_attr){
    ?>
		<div id="attribute">
			<table width="100%" cellpadding="0" cellspacing="0" border="1">
			<tr>
				<td colspan="2"><strong><?=$c['lang_pack']['mobile']['par'];?></strong></td>
			</tr>
            <?php
			foreach((array)$products_attr as $k=>$v){
				if ( @array_key_exists($cur_lang, $attr[$v['AttrId']]) ){
					$val = $attr[$v['AttrId']][$cur_lang];
				}else{
					$val = $attr[$v['AttrId']];
				}
				if (!$val){continue;}
			?>
			<tr>
				<td width="45%"><?=$v['Name'.$c['lang']];?>:</td>
				<td width="55%"><?=$val;?></td>
			</tr>
			<?php 
				}
			?>
			</table>
		</div>
    <?php }?>
	<div class="blank6"></div>
	<ul class="down_list">
		<?php
		for($i=0; $i<5; ++$i){
			if(!is_file($c['root_path'].$products_row["FilePath_$i"])) continue;
		?>
		<li class="clean">
			<span class="fl"><?=$products_row["FileName_$i"];?></span><a href="javascript:;" class="fr <?=$products_row['FilePwd_'.$i]?'pwd':'';?>" path="<?=$i;?>" proid="<?=$products_row['ProId'];?>"><em></em><?=$c['lang_pack']['download'];?></a>
		</li>
		<?php }?>
	</ul>
    <div class="blank6"></div>
    <?php if($c['config']['products']['Config']['show_price'] && $c['FunVersion']>=1){?>
        <?php if($c['config']['products']['Config']['member']){?>
            <?php if((int)$_SESSION['ly200_user']['UserId']){?>
                 <div class="price"><?=$c['config']['products']['symbol'].$products_row['Price_0'];?></div>
            <?php }?>
        <?php }else{?>
             <div class="price"><?=$c['config']['products']['symbol'].$products_row['Price_0'];?></div>
        <?php }?>
    <?php }?>
    <div class="blank15"></div>
    <?php if($c['config']['global']['IsOpenInq']){?>
    <a href="javascript:;" id="add_to_inquiry" data="<?=$ProId;?>" class="btn" <?=$background ? "style='background:$background'" : "";?>><?=$c['lang_pack']['inq'];?></a>
    <?php }?>
    <?php if($c['config']['products']['Config']['pdf']){?>
    <?php /*
    <ul class="prod_info_group">
        <li><a href="javascript:;" class="prod_info_pdf btn" <?=$background ? "style='background:$background'" : "";?>><?=$c['lang_pack']['pdf'];?></a></li>
    </ul>
    */?>
    <iframe id="export_pdf" class="export_pdf" style="width:0px; height:0px; display:none;" src="" name="export_pdf"></iframe>
    <?php }?>
    <div class="clear"></div>
    <?php
	//平台导流
	$platform=str::json_data($products_row['Platform'],'decode');
	foreach((array)$platform as $k => $v){
	?>
    <a href="<?=$v?>" target="_blank" class="platform_btn <?=$k?>_btn"><?=$c['lang_pack']['buy_'.$k]?></a>
    <?php }?>
    <?php if($c['config']['products']['Config']['share']){?>
    <div class="blank12"></div>
    <div class="share">
		<?php include($c['static_path'].'inc/global/share.php');?>
    </div><!-- .share -->
    <?php }?>
    <div class="blank25"></div>
</div>
<div class="clear"></div>