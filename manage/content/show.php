<?php
$show_ary=array('article_share'=>'','info_share'=>'');// 'price'=>'',

$show_row=db::get_all('config', 'GroupId="article"');
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
<script language="javascript">$(document).ready(function(){show_obj.show_init();});</script>
<div class="r_nav feedback_nav">
	<h1>{/module.content.show/}</h1>
</div>
<div id="page_show" class="r_con_wrap">
	<div class="show_list">
		<?php
		foreach($show_ary as $k=>$v){
		?>
		<div class="box item fl">
			<div class="box child">
				<div class="model">
					<div class="title">{/page.show.<?=$k;?>/}</div>
					<div class="brief">{/page.show.<?=$k;?>_info/}</div>
				</div>
				<div class="view">
					<?php if($v){?><a class="set fl" href="javascript:void(0);">{/global.set/}</a><?php }?>
					<div class="btn fr">
						<div class="switchery<?=$show_check[$k]?' checked':'';?>" data="<?=$k;?>">
							<div class="switchery_toggler"></div>
							<div class="switchery_inner">
								<div class="switchery_state_on">ON</div>
								<div class="switchery_state_off">OFF</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php }?>
		<div class="blank15"></div>
	</div>
</div>