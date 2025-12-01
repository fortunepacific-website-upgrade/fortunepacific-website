<?php !isset($c) && exit();?>
<?php
$inq_ary=str::json_data(db::get_value('config', "GroupId='inquiry' and Variable='InqSet'", 'Value'), 'decode');
?>
<div id="lib_inquire_list">
	<?php
	if(!@count($_SESSION['InquiryProducts'])){
		echo '<div class="empty">'.$c['lang_pack']['review']['empty'].'!</div>';
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
	<ul>
    	<?php
		foreach($products_row as $v){
			$Name=$v['Name'.$c['lang']];
			$url=web::get_url($v, 'products');
		?>
            <li>
                <div class="img fl pic_box"><a href="<?=$url;?>" target="_blank" title="<?=$Name;?>"><img src="<?=$v['PicPath_0'];?>" alt="<?=$Name;?>" /><em></em></a></div>
                <div class="info fr">
                    <div class="name"><a href="<?=$url;?>" target="_blank" title="<?=$Name;?>"><?=$Name;?></a></div>
                    <?php if($c['config']['products']['Config']['show_price'] && $c['FunVersion']>=1){?>
						<?php if($c['config']['products']['Config']['member']){?>
                            <?php if((int)$_SESSION['ly200_user']['UserId']){?>
                                <div class="price"><?=$c['config']['products']['symbol'].$v['Price_0'];?></div>
                            <?php }?>
                        <?php }else{?>
                            <div class="price"><?=$c['config']['products']['symbol'].$v['Price_0'];?></div>
                        <?php }?>
                    <?php }?>
                    <div class="detail"><?=($v['Number']?'Item No. '.$v['Number'].'<br />':'').str::str_format($v['BriefDescription'.$c['lang']]);?></div>
                    <?php if(!(int)$c['config']['products']['Config']['inq_type']){?>
                    <div class="remove"><a href="javascript:;" data="<?=$v['ProId'];?>"><i></i> <?=$c['lang_pack']['review']['remove'];?></a></div>
                    <?php }?>
                </div>
                <div class="clear"></div>
            </li>
        <?php }?>
	</ul>
    <form name="inquiry">
    	<?php if($inq_ary['FirstName'][0]){?>
        <div class="rows">
            <label><?=$c['lang_pack']['review']['f_name'];?>: <?php if($inq_ary['FirstName'][1]){?><font class='fc_red'>*</font><?php }?></label>
            <span><input name="FirstName" value="<?=$_SESSION['ly200_user']['FirstName']?$_SESSION['ly200_user']['FirstName']:'';?>" type="text" class="input" maxlength="20"<?=$inq_ary['FirstName'][1]?' notnull':'';?> /></span>
            <div class="clear"></div>
        </div>
        <?php }?>
        <?php if($inq_ary['LastName'][0]){?>
        <div class="rows">
            <label><?=$c['lang_pack']['review']['l_name'];?>: <?php if($inq_ary['LastName'][1]){?><font class='fc_red'>*</font><?php }?></label>
            <span><input name="LastName" value="<?=$_SESSION['ly200_user']['LastName']?$_SESSION['ly200_user']['LastName']:'';?>" type="text" class="input" maxlength="20"<?=$inq_ary['LastName'][1]?' notnull':'';?> /></span>
            <div class="clear"></div>
        </div>
        <?php }?>
        <?php if($inq_ary['Email'][0]){?>
        <div class="rows">
            <label><?=$c['lang_pack']['review']['email'];?>: <?php if($inq_ary['Email'][1]){?><font class="fc_red">*</font><?php }?></label>
            <span><input name="Email" value="<?=$_SESSION['ly200_user']['Email']?$_SESSION['ly200_user']['Email']:'';?>" type="text" class="input" maxlength="100"<?=$inq_ary['Email'][1]?' notnull':'';?> /></span>
            <div class="clear"></div>
        </div>
        <?php }?>
        <?php if($inq_ary['Address'][0]){?>
        <div class="rows">
            <label><?=$c['lang_pack']['review']['address'];?>: <?php if($inq_ary['Address'][1]){?><font class="fc_red">*</font><?php }?></label>
            <span><input name="Address" value="" type="text" class="input" maxlength="200"<?=$inq_ary['Address'][1]?' notnull':'';?> /></span>
            <div class="clear"></div>
        </div>
        <?php }?>
        <?php if($inq_ary['City'][0]){?>
        <div class="rows">
            <label><?=$c['lang_pack']['review']['city'];?>: <?php if($inq_ary['City'][1]){?><font class="fc_red">*</font><?php }?></label>
            <span><input name="City" value="" type="text" class="input" maxlength="50"<?=$inq_ary['City'][1]?' notnull':'';?> /></span>
            <div class="clear"></div>
        </div>
        <?php }?>
        <?php if($inq_ary['State'][0]){?>
        <div class="rows">
            <label><?=$c['lang_pack']['review']['state'];?>: <?php if($inq_ary['State'][1]){?><font class="fc_red">*</font><?php }?></label>
            <span><input name="State" value="" type="text" class="input" maxlength="50"<?=$inq_ary['State'][1]?' notnull':'';?> /></span>
            <div class="clear"></div>
        </div>
        <?php }?>
        <?php if($inq_ary['Country'][0]){?>
        <div class="rows">
            <label><?=$c['lang_pack']['review']['country'];?>: <?php if($inq_ary['Country'][1]){?><font class="fc_red">*</font><?php }?></label>
            <span>
            	<select name="Country" <?php if($inq_ary['Country'][1]){?>notnull<?php }?>>
                	<option value="">---<?=$c['lang_pack']['review']['plase'];?>---</option>
					<?php 
                        $country_row=db::get_all('country', "IsUsed=1", 'Country', 'Country asc');
						foreach($country_row as $v){
                    ?>
                    	<option value="<?=$v['Country'];?>"><?=$v['Country'];?></option>
                    <?php }?>
                </select>
            </span>
            <div class="clear"></div>
        </div>
        <?php }?>
        <?php if($inq_ary['PostalCode'][0]){?>
        <div class="rows">
            <label><?=$c['lang_pack']['review']['code'];?>: <?php if($inq_ary['PostalCode'][1]){?><font class="fc_red">*</font><?php }?></label>
            <span><input name="PostalCode" value="" type="text" class="input" maxlength="10"<?=$inq_ary['PostalCode'][1]?' notnull':'';?> /></span>
            <div class="clear"></div>
        </div>
        <?php }?>
        <?php if($inq_ary['Phone'][0]){?>
        <div class="rows">
            <label><?=$c['lang_pack']['review']['phone'];?>: <?php if($inq_ary['Phone'][1]){?><font class="fc_red">*</font><?php }?></label>
            <span><input name="Phone" value="" type="text" class="input" maxlength="20"<?=$inq_ary['Phone'][1]?' notnull':'';?> /></span>
            <div class="clear"></div>
        </div>
        <?php }?>
        <?php if($inq_ary['Fax'][0]){?>
        <div class="rows">
            <label><?=$c['lang_pack']['review']['fax'];?>: <?php if($inq_ary['Fax'][1]){?><font class="fc_red">*</font><?php }?></label>
            <span><input name="Fax" value="" type="text" class="input" maxlength="20"<?=$inq_ary['Fax'][1]?' notnull':'';?> /></span>
            <div class="clear"></div>
        </div>
        <?php }?>
        <?php if($inq_ary['Subject'][0]){?>
        <div class="rows">
            <label><?=$c['lang_pack']['review']['subject'];?>: <?php if($inq_ary['Subject'][1]){?><font class='fc_red'>*</font><?php }?></label>
            <span><input name="Subject" type="text" class="input" maxlength="100"<?=$inq_ary['Subject'][1]?' notnull':'';?> /></span>
            <div class="clear"></div>
        </div>
        <?php }?>
        <?php if($inq_ary['Message'][0]){?>
        <div class="rows">
            <label><?=$c['lang_pack']['review']['message'];?>: <?php if($inq_ary['Message'][1]){?><font class='fc_red'>*</font><?php }?></label>
            <span><textarea name="Message" class="form_area contents"<?=$inq_ary['Message'][1]?' notnull':'';?>></textarea></span>
            <div class="clear"></div>
        </div>
        <?php }?>
        <!-- <div class="rows">
			<label><?=$c['lang_pack']['review']['vcode']?>: <font class='fc_red'>*</font></label>
			<span><input name="VCode" type="text" class="input vcode" size="4" maxlength="4" notnull /><br /><?=v_code::create('inquiry');?></span>
			<div class="clear"></div>
		</div> -->
        <div class="rows">
            <label></label>
            <span><input name="Submit" type="submit" class="form_button" value="<?=$c['lang_pack']['submit'];?>"></span>
            <div class="clear"></div>
        </div>
        <input type="hidden" name="Site" value="<?=trim($c['lang'],'_');?>" />
    </form>
	<?php }?>
</div>
