<?php !isset($c) && exit();?>
<?php
$rows=db::get_all('config', "GroupId='translate'");
$translate=array();
foreach($rows as $k=>$v){
	$translate[$v['Variable']]=$v['Value'];
}
?>
<script type="text/javascript">$(document).ready(function(){set_obj.translate_init();});</script>
<div class="center_container">
	<div class="big_title rows_hd_part">
		<span>{/set.config.google_translate.google_translate/}</span>
	</div>
	<div class="rows rows_static clean">
		<label>
			{/global.used/}
			<div class="switchery google_translate_switchery <?=$translate['IsTranslate']?' checked':'';?>">
				<div class="switchery_toggler"></div>
				<div class="switchery_inner">
					<div class="switchery_state_on"></div>
					<div class="switchery_state_off"></div>
				</div>
			</div>
		</label>
		<div class="input"><a style="<?=$translate['IsTranslate']?'opacity:1;':'display:none;';?>" href="./?m=set&a=config&d=google_translate" class="set_edit">{/global.edit/}</a></div>
	</div>
</div>