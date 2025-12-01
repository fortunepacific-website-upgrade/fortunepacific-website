<?php !isset($c) && exit();?>
<?php
manage::check_permit('operation', 1, array('a'=>'translate'));//检查权限

$rows=db::get_all('config', "GroupId='translate'");
$translate=array();
foreach($rows as $k=>$v){
	$translate[$v['Variable']]=$v['Value'];
}
?>
<script type="text/javascript">$(document).ready(function(){set_obj.translate_init();});</script>
<div id="translate" class="center_container">
	<a href="javascript:history.back(-1);" class="return_title">
		<span class="return">{/set.config.google_translate.google_translate/}</span>
	</a>
	<?php
	$key=$c['manage']['config']['ManageLanguage']=='en'?1:0;
	$LangArr=str::json_data($translate['TranLangs'], 'decode');
	foreach((array)$c['translate'] as $k=>$v){
		$Used=@in_array($k, (array)$LangArr)?1:0;
	?>
		<table border="0" cellpadding="5" cellspacing="0" class="config_table">
			<tr data-lang="<?=$k;?>">
				<td width="50%" nowrap="nowrap">
					<span class="info">
						<span class="pay"><?=$v[$key];?></span>
					</span>
				</td>
				<td width="50%" nowrap="nowrap" align="right" class="translate_used">
					<div class="switchery<?=$Used?' checked':'';?>" data-pid="<?=$v['PId'];?>">
						<input type="checkbox" name="IsUsed" value="1"<?=$Used?' checked':'';?>>
						<div class="switchery_toggler"></div>
						<div class="switchery_inner">
							<div class="switchery_state_on"></div>
							<div class="switchery_state_off"></div>
						</div>
					</div>
				</td>
			</tr>
		</table>
	<?php }?>
</div>