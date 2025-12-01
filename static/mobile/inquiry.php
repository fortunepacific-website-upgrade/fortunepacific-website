<?php !isset($c) && exit();?>
<?php $inq_ary=str::json_data(db::get_value('config', "GroupId='inquiry' and Variable='InqSet'", 'Value'), 'decode');?>
<!DOCTYPE HTML>
<html lang="us">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta content="telephone=no" name="format-detection" />
<?=web::seo_meta($products_row, $spare_ary);?>
<?php include $c['theme_path'].'/inc/resource.php';?>
<?=ly200::load_static($c['mobile']['tpl_dir'].'js/feedback.js');?>
<script type="text/javascript">$(function (){feedback_obj.inquiry_init();})</script>
</head>

<body>
<?php include $c['theme_path'].'/inc/header.php';//头部 ?>

<div class="wrapper">
    <div class="page_title"><?=$c['lang_pack']['mobile']['inq'];?></div>
    <?php
	if(!@count($_SESSION['InquiryProducts'])){
		echo '<div class="empty">'.$c['lang_pack']['mobile']['empty'].'!</div>';
	}else{
		if((int)$c['config']['products']['Config']['inq_type']){
			if(is_array($_SESSION['InquiryProducts'])){
				unset($_SESSION['InquiryProducts']);	
				ly200::js_location('/inquiry.html');
			}
			$ProId=(int)$_SESSION['InquiryProducts'];
		}else{
			if(!is_array($_SESSION['InquiryProducts'])){
				unset($_SESSION['InquiryProducts']);	
				ly200::js_location('/inquiry.html');
			}
			$ProId=@implode(',', $_SESSION['InquiryProducts']);
		}
		!$ProId && $ProId=0;
		$products_row=str::str_code(db::get_all('products', "ProId in(0,$ProId,0)", "ProId,Name{$c['lang']},Number,PicPath_0,BriefDescription{$c['lang']},Price_0", $c['my_order'].'ProId desc'));
	?>
    <div class="inquiry_info">
    	<?php
        foreach ($products_row as $k=>$v){
			$Name = $v['Name'.$c['lang']];
		?>
    	<div class="row clean">
            <div class="img fl pic_box"><img src="<?=img::get_small_img($v['PicPath_0'], '240X240');?>" /><span></span></div>
            <div class="desc fr">
                <div class="name"><a href="<?=web::get_url($v, 'products');?>" title="<?=$Name;?>"><?=$Name;?></a></div>
                <?php if ($v['Number']){?>
                <?php }?>
                <div class="txt">Item No. <?=$v['Number'];?></div>
                <?php if($c['config']['products']['Config']['show_price'] && $c['FunVersion']>=1){?>
                    <?php if($c['config']['products']['Config']['member']){?>
                        <?php if((int)$_SESSION['ly200_user']['UserId']){?>
                            <?php $Price = $c['config']['products']['symbol'].$v['Price_0'];?>
                        <?php }?>
                    <?php }else{?>
                        <?php $Price = $c['config']['products']['symbol'].$v['Price_0'];?>
                    <?php }?>
                <?php }?>
                <div class="price">
                    <?php if(!(int)$c['config']['products']['Config']['inq_type']){?>
                    <a href="javascript:void(0);" class="del" proid="<?=$v['ProId']?>"><?=$c['lang_pack']['review']['remove'];?></a>
                    <?php }?>
                    <?=$Price; ?>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <?php }?>
    </div>
    
    <div class="m_editAddr">
    	<form name="inquiry" id="inquiry_form">
            <?php if($inq_ary['FirstName'][0]){?>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['mobile']['fir_name'];?>: <?php if($inq_ary['FirstName'][1]){?> <span class="font">*</span> <?php }?></div>
                <div class="input clean">
                    <span class="input_span"><input type="text" class="input_text form_input" name="FirstName" <?php if($inq_ary['FirstName'][1]){?>notnull<?php }?> /></span>
                </div>
            </div>
            <?php }?>
            <?php if($inq_ary['LastName'][0]){?>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['mobile']['last_name'];?>: <?php if($inq_ary['LastName'][1]){?> <span class="font">*</span> <?php }?></div>
                <div class="input clean">
                    <span class="input_span"><input type="text" class="input_text form_input" name="LastName" <?php if($inq_ary['LastName'][1]){?>notnull<?php }?> /></span>
                </div>
            </div>
            <?php }?>
            <?php if($inq_ary['Email'][0]){?>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['mobile']['email'];?>: <?php if($inq_ary['Email'][1]){?> <span class="font">*</span> <?php }?></div>
                <div class="input clean">
                    <span class="input_span"><input type="email" class="input_text form_input" name="Email" <?php if($inq_ary['Email'][1]){?>notnull<?php }?> /></span>
                </div>
            </div>
            <?php }?>
            <?php if($inq_ary['Address'][0]){?>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['mobile']['address'];?>: <?php if($inq_ary['Address'][1]){?> <span class="font">*</span> <?php }?></div>
                <div class="input clean">
                    <span class="input_span"><input type="text" class="input_text form_input" name="Address" <?php if($inq_ary['Address'][1]){?>notnull<?php }?> /></span>
                </div>
            </div>
            <?php }?>
            <?php if($inq_ary['City'][0]){?>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['mobile']['city'];?>: <?php if($inq_ary['City'][1]){?> <span class="font">*</span> <?php }?></div>
                <div class="input clean">
                    <span class="input_span"><input type="text" class="input_text form_input" name="City" <?php if($inq_ary['City'][1]){?>notnull<?php }?> /></span>
                </div>
            </div>
            <?php }?>
            <?php if($inq_ary['State'][0]){?>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['mobile']['state'];?>: <?php if($inq_ary['State'][1]){?> <span class="font">*</span> <?php }?></div>
                <div class="input clean">
                    <span class="input_span"><input type="text" class="input_text form_input" name="State" <?php if($inq_ary['State'][1]){?>notnull<?php }?> /></span>
                </div>
            </div>
            <?php }?>
            <?php if($inq_ary['Country'][0]){?>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['mobile']['country'];?>: <?php if($inq_ary['Country'][1]){?> <span class="font">*</span> <?php }?></div>
                <div class="input clean form_select_arrow">
                    <select class="addr_select form_select" name="Country" <?php if($inq_ary['Country'][1]){?>notnull<?php }?>>
                        <option value="">---<?=$c['lang_pack']['mobile']['plz_country'];?>---</option>
                        <?php 
                            $country_row=db::get_all('country', "IsUsed=1", 'Country', 'Country asc');
                            foreach($country_row as $v){
                        ?>
                            <option value="<?=$v['Country'];?>"><?=$v['Country'];?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <?php }?>
            <?php if($inq_ary['PostalCode'][0]){?>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['mobile']['postal_code'];?>: <?php if($inq_ary['PostalCode'][1]){?> <span class="font">*</span> <?php }?></div>
                <div class="input clean">
                    <span class="input_span"><input type="text" class="input_text form_input" name="PostalCode" <?php if($inq_ary['PostalCode'][1]){?>notnull<?php }?> /></span>
                </div>
            </div>
            <?php }?>
            <?php if($inq_ary['Phone'][0]){?>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['mobile']['phone'];?>: <?php if($inq_ary['Phone'][1]){?> <span class="font">*</span> <?php }?></div>
                <div class="input clean">
                    <span class="input_span"><input type="text" class="input_text form_input" name="Phone" <?php if($inq_ary['Phone'][1]){?>notnull<?php }?> /></span>
                </div>
            </div>
            <?php }?>
            <?php if($inq_ary['Fax'][0]){?>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['mobile']['fax'];?>: <?php if($inq_ary['Fax'][1]){?> <span class="font">*</span> <?php }?></div>
                <div class="input clean">
                    <span class="input_span"><input type="text" class="input_text form_input" name="Fax" <?php if($inq_ary['Fax'][1]){?>notnull<?php }?> /></span>
                </div>
            </div>
            <?php }?>
            <?php if($inq_ary['Subject'][0]){?>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['mobile']['subject'];?>: <?php if($inq_ary['Subject'][1]){?> <span class="font">*</span> <?php }?></div>
                <div class="input clean">
                    <span class="input_span"><input type="text" class="input_text form_input" name="Subject" <?php if($inq_ary['Subject'][1]){?>notnull<?php }?> /></span>
                </div>
            </div>
            <?php }?>
            <?php if($inq_ary['Message'][0]){?>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['mobile']['message'];?>: <?php if($inq_ary['Message'][1]){?> <span class="font">*</span> <?php }?></div>
                <div class="input clean">
                    <span class="input_span"><textarea name="Message" class="input_text form_input input_area" <?php if($inq_ary['Message'][1]){?>notnull<?php }?>></textarea></span>
                </div>
            </div>
            <?php }?>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['review']['vcode']; ?>: <span class="font">*</span></div>
                <div class="input clean">
                    <span class="input_span"><input name="VCode" type="text" class="input_text form_input vcode" size="4" maxlength="4" notnull /><br /></span>
                    <?=v_code::create('inquiry');?>
                </div>
            </div>
            <div class="addr_row">
                <div class="input clean">
                    <span class="input_btn global_btn global_button" id="sub_btn"><?=$c['lang_pack']['mobile']['submit'];?></span>
                </div>
            </div>
            <input type="hidden" name="Site" value="<?=substr($c['lang'], 1);?>" />
        </form>
    </div><!-- end of .m_editAddr -->
    <?php }?>
    
</div><!-- end of .wrapper -->

<?php include $c['theme_path'].'/inc/footer.php';//底部?>
</body>
</html>