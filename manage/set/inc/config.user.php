<?php !isset($c) && exit();?>
<?php if((int)$c['FunVersion']){?>
	<div class="center_container">
		<div class="big_title rows_hd_part">
			<a href="./?m=set&a=config&d=user&p=config" class="set_edit">{/global.edit/}</a>
			<span>{/set.config.user.user/}</span>
		</div>
		<div class="rows rows_static clean">
			<label>{/set.config.user.is_open/}</label>
			<div class="input">{/global.n_y.<?=(int)$c['manage']['config']['IsOpenMember'];?>/}</div>
		</div>
		<div class="rows rows_static clean">
			<label>{/set.config.user.verify/}</label>
			<div class="input">{/global.n_y.<?=(int)$c['manage']['config']['UserStatus'];?>/}</div>
		</div>
		<div class="rows rows_static clean">
			<label>{/set.config.user.email_verify/}</label>
			<div class="input">{/global.n_y.<?=(int)$c['manage']['config']['UserVerification'];?>/}</div>
		</div>
		<div class="rows rows_static clean">
			<label>{/set.config.user.reg_page_notes/}</label>
			<div class="input"><?=$c['manage']['config']['RegTips']['regtips_'.$c['manage']['language_web'][0]];?></div>
		</div>
		<div class="rows rows_static clean">
			<label>{/set.config.user.reg_field_set/}</label>
			<div class="input">
				<a href="./?m=set&a=config&d=user" class="set_edit">{/global.edit/}</a>
				<?php
				$RegSet=db::get_value('config', 'GroupId="user" and Variable="RegSet"', 'Value');
				$reg_ary=str::json_data($RegSet, 'decode');
				foreach((array)$c['manage']['user_reg_set_field'] as $k=>$v){
					$status=$reg_ary[$k];
					if(!($status[0] && $v)) continue;
					?>
					<!--{/user.reg_set.<?=$k;?>/} <br />-->
				<?php } ?>
				<?php
				$row=str::str_code(db::get_all('user_reg_set', '1', '*', "{$c['my_order']} SetId asc"));
				foreach((array)$row as $v){
				?>
					<!--<?=$v['Name_'.$c['manage']['language_web'][0]];?> <br />-->
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>