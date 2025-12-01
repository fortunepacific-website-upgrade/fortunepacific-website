<?php !isset($c) && exit();?>
<?php
manage::check_permit('seo.keyword', 2);//检查权限

$result=manage::ueeseo_get_data('ueeshop_ueeseo_get_keyword');
//print_r($result);
!$result['ret'] && $result['msg']=array();
?>
<script language="javascript">$(document).ready(function(){seo_obj.keyword_init();});</script>
<div id="keyword" class="r_con_wrap">
	<div class="inside_container">
		<h1>{/module.seo.keyword/}</h1>
	</div>
	<div class="inside_table">
		<table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
			<thead>
				<tr>
					<td width="20%" nowrap="nowrap">{/seo.keyword_text/}</td>
					<td width="40%" nowrap="nowrap">{/seo.keyword.url/}</td>
					<td width="15%" nowrap="nowrap">{/seo.keyword.from_type/}</td>
					<td width="15%" nowrap="nowrap">{/global.operation/}</td>
				</tr>
			</thead>
			<tbody>
				<?php
				$counts=0;
				foreach($result['msg'] as $k=>$v){
					$v[0]==1 && $counts++;
				?>
					<tr>
						<td nowrap="nowrap"><?=$v[2];?></td>
						<td><a href="<?=$v[3];?>" target="_blank"><?=$v[3];?></a></td>
						<td nowrap="nowrap">{/seo.keyword.from_type_ary.<?=$v[0];?>/}</td>
						<td nowrap="nowrap" class="operation"><?php if($v[0]==1){?><a href="./?do_action=seo.keyword_del&id=<?=$v[1];?>" title="{/global.del/}" class="del" rel="del">{/global.del/}</a><?php }?></td>
					</tr>
				<?php }?>
			</tbody>
			<?php if(10-$counts>0){?>
				<tbody>
					<tr>
						<td nowrap="nowrap"><a href="#" class="add">+ {/seo.keyword.add_keyword/}</a></td>
						<td nowrap="nowrap"></td>
						<td nowrap="nowrap"></td>
					</tr>
				</tbody>
			<?php }?>
		</table>
		<script language="javascript">var counts=<?=10-$counts;?>;</script>
	</div>
	<div class="keyword_edit_form">
		<h3>{/seo.keyword.add_keyword/}</h3>
		<div class="global_container">
			<div class="tips">{/seo.keyword.add_notes/}</div>
			<form class="global_form">
				<div class="rows clean">
					<div class="input list_input">
						<div class="item">
							<div>
								<input type="text" name="Keyword[]" class="box_input" size="40" placeholder="{/seo.keyword_text/}" />
								<input type="text" name="Url[]" class="box_input" size="50" placeholder="{/seo.keyword.url/}" />
							</div>
							<span class="del"></span>
							<span class="add">+ {/global.add/}</span>
						</div>
					</div>
				</div>
				<div class="rows clean">
					<label></label>
					<div class="input">
						<input type="button" class="btn_global btn_submit" value="{/global.submit/}">
					</div>
				</div>
				<input type="hidden" name="do_action" value="seo.keyword_add" />
			</form>
		</div>
	</div>
</div>