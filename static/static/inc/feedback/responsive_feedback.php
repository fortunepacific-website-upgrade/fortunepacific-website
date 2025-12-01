<?php !isset($c) && exit();?>
<?php
$mess_ary=str::json_data(db::get_value('config', "GroupId='message' and Variable='MessSet'", 'Value'), 'decode');
$feedback_set=str::str_code(db::get_all('feedback_set', '1', '*', "{$c[my_order]} SetId asc"));
?>
<div class="ueeshop_responsive_feedback <?=$c['themes_feedback']['style'];?>">
	<form method="post" name="feedback">
    	<?php if($mess_ary['Fullname'][0]){?>
			<div class="rows input_rows">
				<label><?php if($mess_ary['Fullname'][1]){?><span>*</span> <?php }?><?=$c['lang_pack']['feedback_arr']['name']?></label>
				<span><input name="Name" type="text" class="input" size="30" maxlength="50" <?php if($mess_ary['Fullname'][1]){?>notnull<?php }?> /></span>
				<div class="clear"></div>
			</div>
        <?php }?>
        <?php if($mess_ary['Company'][0]){?>
			<div class="rows input_rows">
				<label><?php if($mess_ary['Company'][1]){?><span>*</span> <?php }?><?=$c['lang_pack']['feedback_arr']['company']?></label>
				<span><input name="Company" type="text" class="input" size="30" maxlength="100" <?php if($mess_ary['Company'][1]){?>notnull<?php }?>/></span>
				<div class="clear"></div>
			</div>
        <?php }?>
        <?php if($mess_ary['Phone'][0]){?>
			<div class="rows input_rows">
				<label><?php if($mess_ary['Phone'][1]){?><span>*</span> <?php }?><?=$c['lang_pack']['feedback_arr']['phone']?></label>
				<span><input name="Phone" type="text" class="input" size="30" maxlength="20" format="Telephone" <?php if($mess_ary['Phone'][1]){?>notnull<?php }?> /></span>
				<div class="clear"></div>
			</div>
        <?php }?>
        <?php if($mess_ary['Mobile'][0]){?>
			<div class="rows input_rows">
				<label><?php if($mess_ary['Mobile'][1]){?><span>*</span> <?php }?><?=$c['lang_pack']['feedback_arr']['mobile']?></label>
				<span><input name="Mobile" type="text" class="input" size="30" maxlength="20" format="MobilePhone" <?php if($mess_ary['Mobile'][1]){?>notnull<?php }?> /></span>
				<div class="clear"></div>
			</div>
        <?php }?>
        <?php if($mess_ary['Email'][0]){?>
			<div class="rows input_rows">
				<label><?php if($mess_ary['Email'][1]){?><span>*</span> <?php }?><?=$c['lang_pack']['feedback_arr']['email']?></label>
				<span><input name="Email" type="text" class="input" size="30" maxlength="100" format="Email" <?php if($mess_ary['Email'][1]){?>notnull<?php }?> /></span>
				<div class="clear"></div>
			</div>
        <?php }?>
        <?php if($mess_ary['Subject'][0]){?>
			<div class="rows input_rows">
				<label><?php if($mess_ary['Subject'][1]){?><span>*</span> <?php }?><?=$c['lang_pack']['feedback_arr']['subject']?></label>
				<span><input name="Subject" type="text" class="input" size="50" maxlength="50" <?php if($mess_ary['Subject'][1]){?>notnull<?php }?> /></span>
				<div class="clear"></div>
			</div>
        <?php }?>
        <?php if($mess_ary['Message'][0]){?>
			<div class="rows textarea_rows">
				<label><?php if($mess_ary['Message'][1]){?><span>*</span> <?php }?><?=$c['lang_pack']['feedback_arr']['message']?></label>
				<span><textarea name="Message" class="form_area contents" <?php if($mess_ary['Message'][1]){?>notnull<?php }?>></textarea></span>
				<div class="clear"></div>
			</div>
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
		<div class="rows">
			<label><span>*</span> <?=$c['lang_pack']['feedback_arr']['code']?></label>
			<span class="vcode">
				<div class="fl"><input name="VCode" type="text" class="input vcode" size="4" maxlength="4" notnull /></div>
				<div class="fl"><?=v_code::create('feedback');?></div>
				<div class="clear"></div>
			</span>
		</div>
		<div class="rows">
			<label></label>
			<span><input name="Submit" type="submit" class="form_button" value="<?=$c['lang_pack']['feedback_arr']['submit']?>" /></span>
			<div class="clear"></div>
		</div>
		<input type="hidden" name="Site" value="<?=trim($c['lang'],'_');?>" />
	</form>
</div>