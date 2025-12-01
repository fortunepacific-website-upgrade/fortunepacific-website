<?php !isset($c) && exit();?>
<?php
$mess_ary=str::json_data(db::get_value('config', "GroupId='message' and Variable='MessSet'", 'Value'), 'decode');
$set_row=str::str_code(db::get_all('feedback_set', '1', '*', "{$c[my_order]} SetId asc"));
?>
<div id="lib_feedback_form">
	<form method="post" name="feedback">
    	<?php if($mess_ary['Fullname'][0]){?>
		<div class="rows">
			<label><?=$c['lang_pack']['feedback_arr']['name']?>: <?php if($mess_ary['Fullname'][1]){?><font class='fc_red'>*</font><?php }?></label>
			<span><input name="Name" type="text" class="input" size="30" maxlength="50" <?php if($mess_ary['Fullname'][1]){?>notnull<?php }?> /></span>
			<div class="clear"></div>
		</div>
        <?php }?>
        <?php if($mess_ary['Company'][0]){?>
		<div class="rows">
			<label><?=$c['lang_pack']['feedback_arr']['company']?>: <?php if($mess_ary['Company'][1]){?><font class='fc_red'>*</font><?php }?></label>
			<span><input name="Company" type="text" class="input" size="30" maxlength="100" <?php if($mess_ary['Company'][1]){?>notnull<?php }?>/></span>
			<div class="clear"></div>
		</div>
        <?php }?>
        <?php if($mess_ary['Phone'][0]){?>
		<div class="rows">
			<label><?=$c['lang_pack']['feedback_arr']['phone']?>: <?php if($mess_ary['Phone'][1]){?><font class='fc_red'>*</font><?php }?></label>
			<span><input name="Phone" type="text" class="input" size="30" maxlength="20" format="Telephone" <?php if($mess_ary['Phone'][1]){?>notnull<?php }?> /></span>
			<div class="clear"></div>
		</div>
        <?php }?>
        <?php if($mess_ary['Mobile'][0]){?>
		<div class="rows">
			<label><?=$c['lang_pack']['feedback_arr']['mobile']?>: <?php if($mess_ary['Mobile'][1]){?><font class='fc_red'>*</font><?php }?></label>
			<span><input name="Mobile" type="text" class="input" size="30" maxlength="20" format="MobilePhone" <?php if($mess_ary['Mobile'][1]){?>notnull<?php }?> /></span>
			<div class="clear"></div>
		</div>
        <?php }?>
        <?php if($mess_ary['Email'][0]){?>
		<div class="rows">
			<label><?=$c['lang_pack']['feedback_arr']['email']?>: <?php if($mess_ary['Email'][1]){?><font class='fc_red'>*</font><?php }?></label>
			<span><input name="Email" type="text" class="input" size="30" maxlength="100" format="Email" <?php if($mess_ary['Email'][1]){?>notnull<?php }?> /></span>
			<div class="clear"></div>
		</div>
        <?php }?>
        <?php if($mess_ary['Subject'][0]){?>
		<div class="rows">
			<label><?=$c['lang_pack']['feedback_arr']['subject']?>: <?php if($mess_ary['Subject'][1]){?><font class='fc_red'>*</font><?php }?></label>
			<span><input name="Subject" type="text" class="input" size="50" maxlength="50" <?php if($mess_ary['Subject'][1]){?>notnull<?php }?> /></span>
			<div class="clear"></div>
		</div>
        <?php }?>
        <?php if($mess_ary['Message'][0]){?>
		<div class="rows">
			<label><?=$c['lang_pack']['feedback_arr']['message']?>: <?php if($mess_ary['Message'][1]){?><font class='fc_red'>*</font><?php }?></label>
			<span><textarea name="Message" class="form_area contents" <?php if($mess_ary['Message'][1]){?>notnull<?php }?>></textarea></span>
			<div class="clear"></div>
		</div>
        <?php }?>
        <?php foreach((array)$set_row as $k=>$v){?>
        <div class="rows">
            <label for="<?=$v['Name'.$c['lang']]?>"><?=$v['Name'.$c['lang']].($v['IsNotnull'] ? " <font class='fc_red'>*</font>" : "");?></label>
            <?php if($v['TypeId']){?>
            <span><input name="fields_<?=$k;?>" type="text" class="input" size="30" maxlength="50" <?=$v['IsNotnull'] ? "notnull" : "";?> /></span>
            <?php }else{?>
            <span><textarea name="fields_<?=$k;?>" class="form_area contents" <?=$v['IsNotnull'] ? "notnull" : "";?>></textarea></span>
            <?php }?>
            <div class="clear"></div>
        </div>
        <?php }?>
		<div class="rows">
			<label><?=$c['lang_pack']['feedback_arr']['code']?>: <font class='fc_red'>*</font></label>
			<span><input name="VCode" type="text" class="input vcode" size="4" maxlength="4" notnull /><br /><?=v_code::create('feedback');?></span>
			<div class="clear"></div>
		</div>
		<div class="rows">
			<label></label>
			<span><input name="Submit" type="submit" class="form_button" value="<?=$c['lang_pack']['feedback_arr']['submit']?>" /></span>
			<div class="clear"></div>
		</div>
		<input type="hidden" name="Site" value="<?=trim($c['lang'],'_');?>" />
	</form>
</div>