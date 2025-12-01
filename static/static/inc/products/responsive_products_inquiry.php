<?php !isset($c) && exit();?>
<?php
$inquiry_config=str::json_data(db::get_value('config', "GroupId='inquiry' and Variable='InqSet'", 'Value'), 'decode');
?>
<div class="ueeshop_responsive_products_inquiry <?=$c['themes_products_inquiry']['style'];?>">
	<?php
	if(!@count($_SESSION['InquiryProducts'])){
		echo '<div class="empty">'.$c['lang_pack']['review']['empty'].'!</div>';
	}else{
    ?>
	<ul class="list">
		<?php
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
		foreach($products_row as $v){
			$Name=$v['Name'.$c['lang']];
			$url=web::get_url($v, 'products');
		?>
			<li>
				<div class="img pic_box"><a href="<?=$url;?>" target="_blank" title="<?=$Name;?>"><img src="<?=$v['PicPath_0'];?>" alt="<?=$Name;?>" /><em></em></a></div>
				<div class="info">
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
					<div class="desc"><?=($v['Number']?'Item No. '.$v['Number'].'<br />':'').str::str_format($v['BriefDescription'.$c['lang']]);?></div>
					<?php if(!(int)$c['config']['products']['Config']['inq_type']){?>
						<div class="remove"><a href="javascript:;" data="<?=$v['ProId'];?>"><i></i> <?=$c['lang_pack']['review']['remove'];?></a></div>
					<?php }?>
				</div>
				<div class="clear"></div>
			</li>
		<?php }?>
	</ul>
	<form name="inquiry">
		<?php if($inquiry_config['FirstName'][0]){?>
			<div class="rows input_rows">
				<label><?php if($inquiry_config['FirstName'][1]){?><span>*</span><?php }?> <?=$c['lang_pack']['review']['f_name'];?></label>
				<span><input name="FirstName" value="<?=$_SESSION['ly200_user']['FirstName']?$_SESSION['ly200_user']['FirstName']:'';?>" type="text" class="input" maxlength="20"<?=$inquiry_config['FirstName'][1]?' notnull':'';?> /></span>
				<div class="clear"></div>
			</div>
		<?php }?>
		<?php if($inquiry_config['LastName'][0]){?>
			<div class="rows input_rows">
				<label><?php if($inquiry_config['LastName'][1]){?><span>*</span><?php }?> <?=$c['lang_pack']['review']['l_name'];?></label>
				<span><input name="LastName" value="<?=$_SESSION['ly200_user']['LastName']?$_SESSION['ly200_user']['LastName']:'';?>" type="text" class="input" maxlength="20"<?=$inquiry_config['LastName'][1]?' notnull':'';?> /></span>
				<div class="clear"></div>
			</div>
		<?php }?>
		<?php if($inquiry_config['Email'][0]){?>
			<div class="rows input_rows">
				<label><?php if($inquiry_config['Email'][1]){?><span>*</span><?php }?> <?=$c['lang_pack']['review']['email'];?></label>
				<span><input name="Email" value="<?=$_SESSION['ly200_user']['Email']?$_SESSION['ly200_user']['Email']:'';?>" type="text" class="input" maxlength="100"<?=$inquiry_config['Email'][1]?' notnull':'';?> /></span>
				<div class="clear"></div>
			</div>
		<?php }?>
		<?php if($inquiry_config['Address'][0]){?>
			<div class="rows input_rows">
				<label><?php if($inquiry_config['Address'][1]){?><span>*</span><?php }?> <?=$c['lang_pack']['review']['address'];?></label>
				<span><input name="Address" value="" type="text" class="input" maxlength="200"<?=$inquiry_config['Address'][1]?' notnull':'';?> /></span>
				<div class="clear"></div>
			</div>
		<?php }?>
		<?php if($inquiry_config['City'][0]){?>
			<div class="rows input_rows">
				<label><?php if($inquiry_config['City'][1]){?><span>*</span><?php }?> <?=$c['lang_pack']['review']['city'];?></label>
				<span><input name="City" value="" type="text" class="input" maxlength="50"<?=$inquiry_config['City'][1]?' notnull':'';?> /></span>
				<div class="clear"></div>
			</div>
		<?php }?>
		<?php if($inquiry_config['State'][0]){?>
			<div class="rows input_rows">
				<label><?php if($inquiry_config['State'][1]){?><span>*</span><?php }?> <?=$c['lang_pack']['review']['state'];?></label>
				<span><input name="State" value="" type="text" class="input" maxlength="50"<?=$inquiry_config['State'][1]?' notnull':'';?> /></span>
				<div class="clear"></div>
			</div>
		<?php }?>
		<?php if($inquiry_config['Country'][0]){?>
			<div class="rows input_rows">
				<label><?php if($inquiry_config['Country'][1]){?><span>*</span><?php }?> <?=$c['lang_pack']['review']['country'];?></label>
				<span>
					<select name="Country" <?php if($inquiry_config['Country'][1]){?>notnull<?php }?>>
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
		<?php if($inquiry_config['PostalCode'][0]){?>
			<div class="rows input_rows">
				<label><?php if($inquiry_config['PostalCode'][1]){?><span>*</span><?php }?> <?=$c['lang_pack']['review']['code'];?></label>
				<span><input name="PostalCode" value="" type="text" class="input" maxlength="10"<?=$inquiry_config['PostalCode'][1]?' notnull':'';?> /></span>
				<div class="clear"></div>
			</div>
		<?php }?>
		<?php if($inquiry_config['Phone'][0]){?>
			<div class="rows input_rows">
				<label><?php if($inquiry_config['Phone'][1]){?><span>*</span><?php }?> <?=$c['lang_pack']['review']['phone'];?></label>
				<span><input name="Phone" value="" type="text" class="input" maxlength="20"<?=$inquiry_config['Phone'][1]?' notnull':'';?> /></span>
				<div class="clear"></div>
			</div>
		<?php }?>
		<?php if($inquiry_config['Fax'][0]){?>
			<div class="rows input_rows">
				<label><?php if($inquiry_config['Fax'][1]){?><span>*</span><?php }?> <?=$c['lang_pack']['review']['fax'];?></label>
				<span><input name="Fax" value="" type="text" class="input" maxlength="20"<?=$inquiry_config['Fax'][1]?' notnull':'';?> /></span>
				<div class="clear"></div>
			</div>
		<?php }?>
		<?php if($inquiry_config['Subject'][0]){?>
			<div class="rows input_rows">
				<label><?php if($inquiry_config['Subject'][1]){?><span>*</span><?php }?> <?=$c['lang_pack']['review']['subject'];?></label>
				<span><input name="Subject" type="text" class="input" maxlength="100"<?=$inquiry_config['Subject'][1]?' notnull':'';?> /></span>
				<div class="clear"></div>
			</div>
		<?php }?>
		<?php if($inquiry_config['Message'][0]){?>
			<div class="rows textarea_rows">
				<label><?php if($inquiry_config['Message'][1]){?><span>*</span><?php }?> <?=$c['lang_pack']['review']['message'];?></label>
				<span><textarea name="Message" class="form_area contents"<?=$inquiry_config['Message'][1]?' notnull':'';?>></textarea></span>
				<div class="clear"></div>
			</div>
		<?php }?>
		<div class="rows">
			<label><span>*</span> <?=$c['lang_pack']['review']['vcode']?></label>
			<span class="vcode">
				<div class="fl"><input name="VCode" type="text" class="input vcode" size="4" maxlength="4" notnull /></div>
				<div class="fl"><?=v_code::create('inquiry');?></div>
				<div class="clear"></div>
			</span>
		</div>
		<div class="rows">
			<label></label>
			<span><input name="Submit" type="submit" class="form_button" value="<?=$c['lang_pack']['submit'];?>"></span>
			<div class="clear"></div>
		</div>
		<input type="hidden" name="Site" value="<?=trim($c['lang'],'_');?>" />
	</form>
	<?php }?>
</div>