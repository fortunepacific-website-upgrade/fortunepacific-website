<?php !isset($c) && exit();?>
<script type="text/javascript">$(document).ready(function(){set_obj.config_product_edit();});</script>
<form id="product_edit_form" class="global_form">
	<div class="center_container">
		<a href="javascript:history.back(-1);" class="return_title">
			<span class="return">{/set.config.product.product/}</span> 
		</a>
		<div class="rows first clean">
			<div class="input">
				<ul class="data_list">
					<?php
					if($c['FunVersion']>=1){
						$show_ary=array('show_price', 'share', 'inq_type', 'member','pdf', 'manage_myorder');
					}else{
						$show_ary=array('share', 'inq_type', 'pdf', 'manage_myorder');
					}
					$checked=array();
					$show_row=db::get_all('config', 'GroupId="products"');
					foreach($show_row as $v){
						if($v['Variable']=='Config'){
							$checked['config']=array_merge($checked, str::json_data($v['Value'], 'decode'));
						}elseif($v['Variable']=='symbol'){
							$checked[$v['Variable']]=$v['Value'];
						}else{
							$checked[$v['Variable']]=str::json_data(htmlspecialchars_decode($v['Value']), 'decode');
						}
					}
					foreach($show_ary as $v){
					?>
						<li>
                            <div class="switchery<?=$checked['config'][$v]?' checked':'';?>" field="<?=$v;?>" status="<?=(int)$checked['config'][$v];?>">
                                <input type="checkbox" name="<?=$v;?>" value="1"<?=$checked['config'][$v]?' checked':'';?>>
                                <div class="switchery_toggler"></div>
                                <div class="switchery_inner">
                                    <div class="switchery_state_on"></div>
                                    <div class="switchery_state_off"></div>
                                </div>
                            </div>
							{/set.config.product.<?=$v;?>/}
                            <span class="tool_tips_ico" content="{/set.config.product.<?=$v;?>_notes/}"></span>
						</li>
					<?php }?>
				</ul>
			</div>
		</div>
		<div class="rows clean currency_symbol <?=$checked['config']['show_price']?'':'g_hide';?>">
			<label>{/set.config.product.currency_symbol/}</label>
			<div class="input"><input type="text" class="box_input" name="symbol" value="<?=$checked['symbol'];?>" size="5" maxlength="5" /></div>
		</div>
		<div class="rows clean currency_symbol <?=$checked['config']['show_price']?'':'g_hide';?>">
			<label></label>
			<div class="input">
				<input type="button" class="btn_global btn_submit" value="{/global.save/}" />
				<a href="./?m=set&a=config" title="{/global.return/}"><input type="button" class="btn_global btn_cancel" value="{/global.return/}" /></a>
			</div>
		</div>
		<input type="hidden" name="do_action" value="set.config_product_currency_symbol_edit">
	</div>
</form>