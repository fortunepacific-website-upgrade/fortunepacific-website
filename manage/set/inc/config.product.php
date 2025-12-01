<?php !isset($c) && exit();?>
<div class="center_container">
	<div class="big_title rows_hd_part">
		<a href="./?m=set&a=config&d=product" class="set_edit">{/global.edit/}</a>
		<span>{/set.config.product.product/}</span>
	</div>
	<div class="rows rows_static first clean">
		<label>{/global.set/}</label>
		<div class="input">
			<ul class="data_list">
				<?php
				if($c['FunVersion']>=1){
					$show_ary=array('show_price', 'share', 'inq_type', 'member','pdf', 'manage_myorder');
				}else{
					$show_ary=array('share', 'inq_type', 'pdf', 'manage_myorder');
				}
				$show_row=db::get_all('config', 'GroupId="products"');
				foreach($show_row as $v){
					if($v['Variable']=='Config'){
						$show_check=str::json_data($v['Value'], 'decode');
					}elseif($v['Variable']=='symbol'){
						$set_check[$v['Variable']]=$v['Value'];
					}else{
						$set_check[$v['Variable']]=str::json_data(htmlspecialchars_decode($v['Value']), 'decode');
					}
				}
				foreach($show_ary as $v){
				?>
					<li><span class="ico <?=(int)$show_check[$v]?'':'off';?>"></span> {/set.config.product.<?=$v;?>/}</li>
				<?php }?>
			</ul>
		</div>
	</div>
</div>