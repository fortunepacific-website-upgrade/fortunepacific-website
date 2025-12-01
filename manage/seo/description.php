<?php
manage::check_permit('seo.description', 2);//检查权限

$d_ary=array('list','edit');
$d = $c['manage']['do'];
!in_array($d, $d_ary) && $d=$d_ary[0];
?>
<div id="description" class="r_con_wrap">
	<?php
	if($d=='list'){
		$where='1';//条件
		$page_count=20;//显示数量
		$description_row=str::str_code(db::get_limit_page('seo_description', $where, '*', $c['my_order'].'DId desc', (int)$_GET['page'], $page_count));
	?>
	<div class="inside_container">
		<h1>{/module.seo.description/}</h1>
	</div>
	<div class="inside_table">
		<div class="list_menu">
			<ul class="list_menu_button">
				<li><a class="add" href="./?m=seo&a=description&d=edit">{/global.add/}</a></li>
				<li><a class="del" href="javascript:;">{/global.del/}</a></li>
			</ul>
		</div>
	    <script type="text/javascript">$(document).ready(function(){seo_obj.description_init();});</script>
	    <table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
	        <thead>
	            <tr>
	                <td width="1%" nowrap="nowrap"><?=html::btn_checkbox('select_all');?></td>
	                <td width="85%" nowrap="nowrap">{/global.contents/}</td>
	                <td width="8%" nowrap="nowrap" class="last">{/global.operation/}</td>
	            </tr>
	        </thead>
	        <tbody>
	            <?php
	            foreach($description_row[0] as $v){
	                $DId=$v['DId'];
	            ?>
	            <tr>
					<td nowrap="nowrap"><?=html::btn_checkbox('select', $DId);?></td>
	                <td><?=$v['Description'.$c['lang']];?></td>
	                <td nowrap="nowrap" class="operation">
	                    <a href="./?m=seo&a=description&d=edit&DId=<?=$DId;?>" title="{/global.edit/}">{/global.edit/}</a>
	                    <a href="./?do_action=seo.description_del&id=<?=$DId;?>" title="{/global.del/}" class="del" rel="del">{/global.del/}</a>
	                </td>
	            </tr>
	            <?php }?>
	        </tbody>
	    </table>
	    <?=html::turn_page($description_row[1], $description_row[2], $description_row[3], '?'.str::query_string('page').'&page=');?>
	</div>
	<?php
	}else{
		$DId=(int)$_GET['DId'];
		$DId && $description_row=str::str_code(db::get_one('seo_description', "DId='$DId'"));
	?>
    <script type="text/javascript">$(document).ready(function(){seo_obj.description_edit_init();});</script>

	<div class="center_container_1000 center_container">
		<a href="javascript:history.back(-1);" class="return_title">
			<span class="return">{/module.seo.description/}</span>
			<span class="s_return">/ {/global.<?=$DId?'edit':'add'?>/}</span>
		</a>
		<form id="description_form" name="description_form" class="global_form">
			<div class="rows clean">
                <label>
					{/global.contents/}
					<div class="tab_box"><?=manage::html_tab_button();?></div>
				</label>
                <div class="input clean">
                	<div class="fl left">
                		<div class="seo_desc_manage_tips">{/seo.description.notes/}</div>
						<?=manage::form_edit($description_row, 'textarea', 'Description','','','notnull');?>
					</div>
					<div class="fr right">{/seo.description.example/}</div>
				</div>
            </div>
			<div class="rows clean">
				<label></label>
				<div class="input">
					<input type="submit" class="btn_global btn_submit" name="submit_button" value="{/global.save/}" />
					<a href="./?m=seo&a=description" class="btn_global btn_cancel">{/global.return/}</a>
				</div>
			</div>
            <input type="hidden" id="DId" name="DId" value="<?=$DId;?>" />
            <input type="hidden" name="do_action" value="seo.description_edit" />
		</form>
		<?php include("static/inc/translation.php");?>
		<div class="blank12"></div>
	</div>
	<?php }?>
</div>