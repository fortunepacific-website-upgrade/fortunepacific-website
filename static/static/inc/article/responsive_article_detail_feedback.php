<?php !isset($c) && exit();?>
<?php
$feedback_config=str::json_data(db::get_value('config', "GroupId='message' and Variable='MessSet'", 'Value'), 'decode');
$feedback_set=str::str_code(db::get_all('feedback_set', '1', '*', "{$c[my_order]} SetId asc"));

$notnull=array(
	'Fullname'	=>	$feedback_config['Fullname'][1]?'notnull':'',
	'Company'	=>	$feedback_config['Company'][1]?'notnull':'',
	'Phone'		=>	$feedback_config['Phone'][1]?'notnull':'',
	'Mobile'	=>	$feedback_config['Mobile'][1]?'notnull':'',
	'Email'		=>	$feedback_config['Email'][1]?'notnull':'',
	'Subject'	=>	$feedback_config['Subject'][1]?'notnull':'',
	'Message'	=>	$feedback_config['Message'][1]?'notnull':''
);
$notnull_star='<font class="fc_red">*</font>';
?>
<div class="ueeshop_responsive_article_feedback <?=$c['themes_article_detail']['feedback']['style'];?>">
	<div class="article_feedback_title">
		<div class="title"><?=$c['lang_pack']['message'];?></div>
		<span></span>
		<div class="txt"><?=$c['lang_pack']['article']['feedback']['message'];?></div>
	</div>
	<form method="post" name="feedback">
		<?php if($feedback_config['Fullname'][0]){?>
			<div class="rows input_rows"><input name="Name" type="text" class="input" size="30" maxlength="50" placeholder="<?=$c['lang_pack']['article']['feedback']['name']?>" <?=$notnull['Fullname'];?> /><?=$notnull['Fullname']?$notnull_star:'';?></div>
        <?php }?>
        <?php if($feedback_config['Company'][0]){?>
			<div class="rows input_rows"><input name="Company" type="text" class="input" size="30" maxlength="100" placeholder="<?=$c['lang_pack']['article']['feedback']['company']?>" <?=$notnull['Company'];?> /><?=$notnull['Company']?$notnull_star:'';?></div>
        <?php }?>
        <?php if($feedback_config['Phone'][0]){?>
			<div class="rows input_rows"><input name="Phone" type="text" class="input" size="30" maxlength="20" placeholder="<?=$c['lang_pack']['article']['feedback']['phone']?>" <?=$notnull['Phone'];?> /><?=$notnull['Phone']?$notnull_star:'';?></div>
        <?php }?>
        <?php if($feedback_config['Mobile'][0]){?>
			<div class="rows input_rows"><input name="Mobile" type="text" class="input" size="30" maxlength="20" placeholder="<?=$c['lang_pack']['article']['feedback']['mobile']?>" <?=$notnull['Mobile'];?> /><?=$notnull['Mobile']?$notnull_star:'';?></div>
        <?php }?>
        <?php if($feedback_config['Email'][0]){?>
			<div class="rows input_rows"><input name="Email" type="text" class="input" size="30" maxlength="100" format="Email" placeholder="<?=$c['lang_pack']['article']['feedback']['email']?>" <?=$notnull['Email'];?> /><?=$notnull['Email']?$notnull_star:'';?></div>
        <?php }?>
        <?php if($feedback_config['Subject'][0]){?>
			<div class="rows input_rows"><input name="Subject" type="text" class="input" size="50" maxlength="50" placeholder="<?=$c['lang_pack']['article']['feedback']['subject']?>" <?=$notnull['Subject'];?> /><?=$notnull['Subject']?$notnull_star:'';?></div>
        <?php }?>
        <?php if($feedback_config['Message'][0]){?>
			<div class="rows textarea_rows"><textarea name="Message" class="form_area contents" placeholder="<?=$c['lang_pack']['article']['feedback']['message']?>" <?=$notnull['Message'];?> /></textarea><?=$notnull['Message']?$notnull_star:'';?></div>
        <?php }?>
        <?php foreach((array)$feedback_set as $k=>$v){?>
			<div class="rows <?=$v['TypeId']?'input_rows':'textarea_rows';?>">
				<?php if($v['TypeId']){?>
					<input name="fields_<?=$k;?>" type="text" class="input" size="30" maxlength="50" placeholder="<?=$v['Name'.$c['lang']];?>" <?=$v['IsNotnull'] ? "notnull" : "";?> /><?=$v['IsNotnull']?$notnull_star:'';?>
				<?php }else{?>
					<textarea name="fields_<?=$k;?>" class="form_area contents" placeholder="<?=$v['Name'.$c['lang']];?>" <?=$v['IsNotnull']?'notnull':'';?> /></textarea><?=$v['IsNotnull']?$notnull_star:'';?>
				<?php }?>
			</div>
        <?php }?>
		<div class="clear"></div>
		<div class="rows vcode">
			<div class="fl"><input name="VCode" type="text" class="input vcode" size="4" maxlength="4" placeholder="<?=$c['lang_pack']['review']['vcode'];?>" notnull /> <font class='fc_red'>*</font></div>
			<div class="fl"><?=v_code::create('feedback');?></div>
			<div class="clear"></div>
		</div>
		<div class="rows"><input name="Submit" type="submit" class="form_button" value="<?=$c['lang_pack']['article']['feedback']['submit']?>" /></div>
		<input type="hidden" name="Site" value="<?=trim($c['lang'],'_');?>" />
        <input type="hidden" name="AId" value="<?=$article_row['AId'];?>" />
	</form>
</div>