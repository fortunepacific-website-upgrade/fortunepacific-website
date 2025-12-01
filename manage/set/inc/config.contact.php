<?php !isset($c) && exit();?>
<div class="center_container">
	<div class="big_title rows_hd_part">
		<a href="./?m=set&a=config&d=contact" class="set_edit">{/global.edit/}</a>
		<span>{/set.config.contact.contact/}</span>
	</div>
	<div class="rows rows_static clean">
		<label>{/set.config.contact.company/}</label>
		<div class="input"><?=$c['manage']['config']['Contact']['company_'.$c['manage']['language_web'][0]];?></div>
	</div>
	<div class="rows rows_static clean">
		<label>{/set.config.contact.email/}</label>
		<div class="input"><?=$c['manage']['config']['Contact']['email'];?></div>
	</div>
	<div class="rows rows_static clean">
		<label>{/set.config.contact.tel/}</label>
		<div class="input"><?=$c['manage']['config']['Contact']['tel'];?></div>
	</div>
	<div class="rows rows_static clean">
		<label>{/set.config.contact.fax/}</label>
		<div class="input"><?=$c['manage']['config']['Contact']['fax'];?></div>
	</div>
	<div class="rows rows_static clean">
		<label>{/set.config.contact.address/}</label>
		<div class="input"><?=$c['manage']['config']['Contact']['address_'.$c['manage']['language_web'][0]];?></div>
	</div>
	<div class="rows rows_static clean">
		<label>{/set.config.contact.contact_us/}</label>
		<div class="input"><?=$c['manage']['config']['Contact']['contact'];?></div>
	</div>
	<div class="rows rows_static clean">
		<label>{/set.config.contact.home_page/}</label>
		<div class="input"><?=$c['manage']['config']['Contact']['links'];?></div>
	</div>
</div>