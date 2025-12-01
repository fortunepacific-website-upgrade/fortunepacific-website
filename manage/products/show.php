<?php
if($c['FunVersion']>=1){
	$show_ary=array('show_price'=>'','share'=>'','inq_type'=>'','member'=>'','pdf'=>'', 'manage_myorder'=>'');// 'price'=>'',
}else{
	$show_ary=array('share'=>'','inq_type'=>'','member'=>'','pdf'=>'', 'manage_myorder'=>'');// 'price'=>'',
}

$show_row=db::get_all('config', 'GroupId="products"');
foreach($show_row as $k=>$v){
	if($v['Variable']=='Config'){
		$show_check=str::json_data($v['Value'], 'decode');
	}elseif($v['Variable']=='symbol'){
		$set_check[$v['Variable']]=$v['Value'];
	}else{
		$set_check[$v['Variable']]=str::json_data(htmlspecialchars_decode($v['Value']), 'decode');
	}
}
?>
<script language="javascript">$(document).ready(function(){products_obj.show_init();});</script>
<div class="r_nav products_nav">
	<h1>{/module.products.show/}</h1>
</div>
<div id="pro_show" class="r_con_wrap">
	<div class="show_list">
		<?php
		foreach($show_ary as $k=>$v){
			if(!(int)$c['FunVersion'] && $k=='member') continue;
		?>
		<div class="box item fl">
			<div class="box child">
				<div class="model">
					<div class="title">{/products.show.<?=$k;?>/}</div>
					<div class="brief">{/products.show.<?=$k;?>_info/}</div>
				</div>
				<div class="view">
					<?php if($v){?><a class="set fl" href="javascript:void(0);">{/global.set/}</a><?php }?>
					<?php if($k=='show_price'){?>
					<div class="number fl">{/products.show.currency_symbol/}: <input name="symbol" value="<?=$set_check['symbol'];?>" type="text" class="form_input" size="8" maxlength="15" notnull /><button class="sub_btn">{/global.submit/}</button></div>
					<?php }?>
					<div class="btn fr">
						<div class="switchery<?=$show_check[$k]?' checked':'';?>" data="<?=$k;?>">
							<div class="switchery_toggler"></div>
							<div class="switchery_inner">
								<div class="switchery_state_on"></div>
								<div class="switchery_state_off"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="txt">
					<?php
					if($v){
						foreach($v as $k2=>$v2){
					?>
						<div name="<?=$k;?>">
							<div class="txt_name">{/products.show.<?=$k;?>_<?=$k2?>.0/}:</div>
							<?php for($i=1; $i<=$v2; ++$i){?>
							<span class="choice_btn<?=$set_check[$k][$k2]==$i?' current':'';?>" data="<?=$k2;?>" value="<?=$i;?>">{/products.show.<?=$k;?>_<?=$k2?>.<?=$i;?>/}</span>
							<?php }?>
						</div>
					<?php
						}
					}?>
				</div>
			</div>
		</div>
		<?php }?>
		<div class="blank15"></div>
	</div>
</div>