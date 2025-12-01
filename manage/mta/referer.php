<?php !isset($c) && exit();?>
<?php
manage::check_permit('mta.referer', 2);//检查权限

echo ly200::load_static('/static/js/plugin/daterangepicker/daterangepicker.css', '/static/js/plugin/daterangepicker/moment.min.js', '/static/js/plugin/daterangepicker/daterangepicker.js');
?>
<div id="mta" class="r_con_wrap">
	<?php if($c['manage']['do']=='index'){?>
		<div class="inside_container">
			<h1>{/module.mta.referer/}</h1>
		</div>
	<?php }else{?>
		<div class="blank9"></div>
		<div class="inside_table referer_inside_table">
			<a href="javascript:history.back(-1);" class="return_title return_title_inside grey">
				<span class="return">{/module.mta.referer/}</span>
				<span class="s_return">/ {/mta.page_type_ary.<?=$c['manage']['page']=='search_engine'?0:($c['manage']['page']=='share_platform'?1:2);?>/}</span>
			</a>
		</div>
	<?php }?>
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
		<?php if($c['manage']['do']=='index'){?>
			<script type="text/javascript">$(document).ready(function(){mta_obj.referer_init()});</script>
			<div class="mta_parent_top_box visits_parent_top_box">
				<div class="mta_parent_box">
					<div class="global_container box_detail mr5" id="visits_referrer_detail">
						<div class="big_title">{/mta.traffic_source/}</div>
						<table border="0" cellpadding="5" cellspacing="0" class="r_con_table data_table">
							<thead>
								<tr>
									<td width="20%" nowrap="nowrap">{/mta.country/}</td>
									<td width="20%" nowrap="nowrap">{/mta.pv/}</td>
									<td width="20%" nowrap="nowrap">{/mta.average_pv/}</td>
									<td width="20%" nowrap="nowrap">{/mta.ip/}</td>
									<td width="20%" nowrap="nowrap">{/mta.uv/}</td>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
				<div class="mta_parent_box">
					<div class="global_container box_url_info ml5">
						<div class="big_title">{/mta.source_url/}<a href="./?m=mta&a=referer&d=referer&p=url" class="more fr">{/global.more/}</a></div>
						<table border="0" cellpadding="0" cellspacing="0" class="table_report_list">
							<thead>
								<tr>
									<td width="60%" nowrap></td>
									<td width="20%" nowrap></td>
									<td width="20%" nowrap></td>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
						<div class="no_data">{/mta.no_data/}</div>
					</div>
				</div>
			</div>
		<?php }elseif($c['manage']['do']=='from'){?>
			<script type="text/javascript">var type='<?=$c['manage']['page'];?>';$(document).ready(function(){mta_obj.referer_from_init()});</script>
			<table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
				<thead>
					<tr>
						<td width="40%" nowrap="nowrap">{/mta.page_type_ary.<?=$c['manage']['page']=='search_engine'?0:1;?>/}</td>
						<td width="12%" nowrap="nowrap">{/mta.pv/}</td>
						<td width="12%" nowrap="nowrap">{/mta.average_pv/}</td>
						<td width="12%" nowrap="nowrap">{/mta.ip/}</td>
						<td width="12%" nowrap="nowrap">{/mta.uv/}</td>
						<td width="12%" nowrap="nowrap">{/mta.percent/}</td>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
			<div class="no_data">{/error.no_data/}</div>
		<?php }else{?>
			<script type="text/javascript">$(document).ready(function(){mta_obj.referer_url_init()});</script>
			<table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
				<thead>
					<tr>
						<td width="40%" nowrap="nowrap">{/mta.page_type_ary.2/}</td>
						<td width="12%" nowrap="nowrap">{/mta.pv/}</td>
						<td width="12%" nowrap="nowrap">{/mta.average_pv/}</td>
						<td width="12%" nowrap="nowrap">{/mta.ip/}</td>
						<td width="12%" nowrap="nowrap">{/mta.uv/}</td>
						<td width="12%" nowrap="nowrap">{/mta.percent/}</td>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
			<div class="no_data">{/error.no_data/}</div>
		<?php }?>
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