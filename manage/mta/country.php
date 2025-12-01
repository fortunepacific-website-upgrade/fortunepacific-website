<?php !isset($c) && exit();?>
<?php
manage::check_permit('mta.country', 2);//检查权限

echo ly200::load_static('/static/js/plugin/highcharts/highcharts.js', '/static/js/plugin/highcharts/highcharts-zh_CN.js', '/static/js/plugin/daterangepicker/daterangepicker.css', '/static/js/plugin/daterangepicker/moment.min.js', '/static/js/plugin/daterangepicker/daterangepicker.js');
?>
<script type="text/javascript">$(document).ready(function(){mta_obj.country_init()});</script>
<div id="mta" class="r_con_wrap">
	<div class="inside_container"><h1>{/module.mta.country/}</h1></div>
	<div class="inside_table">
		<div class="mta_menu clean">
			<dl class="box_time box_drop_down_menu fl">
				<dt class="more"><span>{/mta.time_ary.0/}</span><em></em></dt>
				<dd class="more_menu drop_down">
					<?php
					foreach(array(0,-1,-7,-30,6=>-100,4=>-99) as $k=>$v){
					?>
						<a href="javascript:;" class="item color_000<?=$k==0?' current':'';?>" data-value="<?=$v;?>" data-time="<?=date('Y-m-d', $c['time']+86400*$v).'/'.date('Y-m-d', $c['time']);?>">{/mta.time_ary.<?=$k;?>/}</a>
					<?php }?>
				</dd>
			</dl>
			<ul class="legend fl">
				<li class="time_1 fl"></li>
				<li class="time_2 fl"></li>
			</ul>
			<?php if((int)$c['FunVersion']){?>
			<dl class="box_terminal box_drop_down_menu fl">
				<dt class="more"><i class="icon_terminal_all"></i><em></em></dt>
				<dd class="more_menu drop_down">
					<?php
					foreach(array('all', 'pc', 'mobile') as $k=>$v){
					?>
						<a href="javascript:;" class="item color_000<?=$k==0?' current':'';?>" data-value="<?=$k;?>"><em class="icon_terminal_<?=$v;?>"></em>{/mta.terminal_ary.<?=$k;?>/}</a>
					<?php }?>
				</dd>
			</dl>
			<?php }?>
			<input type="hidden" name="TimeS" value="" />
			<input type="hidden" name="TimeE" value="" />
		</div>
		<div class="global_container">
			<div class="big_title">{/mta.country_distribution/}</div>
			<div class="box_charts" id="country_charts"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="pop_form pop_compared">
		<form id="compared_form">
			<div class="t"><h1>{/mta.compared/}</h1><h2>×</h2></div>
			<div class="compared_bodyer">
				<span class="unit_input"><b>{/global.time/} <font>1</font></b><input type="text" class="box_input input_time" name="TimeS" value="<?=date('Y-m-d', $c['time']).'/'.date('Y-m-d', $c['time']);?>" size="15" maxlength="10" readonly /></span>
				<span class="unit_input"><b>{/global.time/} <font>2</font></b><input type="text" class="box_input input_time" name="TimeE" value="<?=date('Y-m-d', $c['time']).'/'.date('Y-m-d', $c['time']);?>" size="15" maxlength="10" readonly /></span>
			</div>
			<div class="button">
				<input type="button" value="{/global.view/}" class="btn_global btn_submit" />
				<input type="button" value="{/global.cancel/}" class="btn_global btn_cancel" />
			</div>
		</form>
	</div>
</div>