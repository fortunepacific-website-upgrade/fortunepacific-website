<?php
manage::check_permit('content.partner', 2);//检查权限

$d_ary=array('list','edit');
$d = $c['manage']['do'];
!in_array($d, $d_ary) && $d=$d_ary[0];
?>
<div id="partner" class="r_con_wrap">
	<?php
	if($d=='list'){
		$where='1';//条件
		$page_count=20;//显示数量
		$partner_row=str::str_code(db::get_limit_page('partners', $where, '*', $c['my_order'].'PId desc', (int)$_GET['page'], $page_count));
	?>
	<div class="inside_container">
		<h1>{/module.content.partner/}</h1>
	</div>
	<div class="inside_table">
		<div class="list_menu">
			<ul class="list_menu_button">
				<li><a class="add" href="./?m=content&a=partner&d=edit">{/global.add/}</a></li>
				<li><a class="del" href="javascript:;">{/global.del/}</a></li>
			</ul>
		</div>
	    <script type="text/javascript">$(document).ready(function(){content_obj.partner_init();});</script>
	    <table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
	        <thead>
	            <tr>
	                <td width="1%" nowrap="nowrap"><?=html::btn_checkbox('select_all');?></td>
	                <td width="16%" nowrap="nowrap">{/global.name/}</td>
	                <td width="9%" nowrap="nowrap">{/global.pic/}</td>
	                <td width="18%" nowrap="nowrap">{/content.partner.url/}</td>
	                <td width="10%" nowrap="nowrap">{/global.time/}</td>
	                <td width="8%" nowrap="nowrap" class="last">{/global.operation/}</td>
	            </tr>
	        </thead>
	        <tbody>
	            <?php
	            foreach($partner_row[0] as $v){
	                $PId=$v['PId'];
	            ?>
	            <tr>
					<td nowrap="nowrap"><?=html::btn_checkbox('select', $PId);?></td>
	                <td><?=$v['Name'.$c['lang']];?></td>
	                <td nowrap="nowrap"><a href="<?=$v['PicPath'];?>" title="<?=$v['Name'.$c['lang']];?>" target="_blank"><img class="photo" src="<?=$v['PicPath'];?>" alt="<?=$v['Name'.$c['lang']];?>" align="absmiddle" /></a></td>
	                <td><a href="<?=$v['Url'];?>" target="_blank"><?=$v['Url'];?></a></td>
	                <td nowrap="nowrap"><?=date('Y/m/d H:i:s', $v['AccTime']);?></td>
	                <td nowrap="nowrap" class="operation">
	                    <a href="./?m=content&a=partner&d=edit&PId=<?=$PId;?>" title="{/global.edit/}">{/global.edit/}</a>
	                    <a href="./?do_action=content.partner_del&id=<?=$PId;?>" title="{/global.del/}" class="del" rel="del">{/global.del/}</a>
	                </td>
	            </tr>
	            <?php }?>
	        </tbody>
	    </table>
	    <?=html::turn_page($partner_row[1], $partner_row[2], $partner_row[3], '?'.str::query_string('page').'&page=');?>
	</div>
	<?php
	}else{
		$PId=(int)$_GET['PId'];
		$PId && $partner_row=str::str_code(db::get_one('partners', "PId='$PId'"));
	?>
    <script type="text/javascript">$(document).ready(function(){content_obj.partner_edit_init();});</script>

	<div class="center_container">
		<a href="javascript:history.back(-1);" class="return_title">
			<span class="return">{/module.content.partner/}</span>
			<span class="s_return">/ {/global.<?=$PId?'edit':'add'?>/}</span>
		</a>
		<form id="partner_form" name="partner_form" class="global_form">
			<div class="rows clean">
                <label>{/global.name/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
                <div class="input"><?=manage::form_edit($partner_row, 'text', 'Name', 50, 150);?></div>
            </div>
            <div class="rows clean">
                <label>{/content.partner.url/}</label>
                <div class="input"><input name="Url" value="<?=$partner_row['Url'];?>" type="text" class="box_input" size="50" maxlength="150" notnull="notnull" /> <span class="fc_red">*</span></div>
            </div>
            <div class="rows clean">
                <label>{/global.pic/}</label>
                <div class="input">
					<?=manage::multi_img('PicDetail', 'PicPath', $partner_row['PicPath']); ?>
                </div>
            </div>
            <div class="rows clean">
                <label>{/global.my_order/}</label>
                <div class="input">
					<div class="box_select width_90"><?=html::form_select(manage::language('{/global.my_order_ary/}'), 'MyOrder', $partner_row['MyOrder']);?></div>
				</div>
            </div>
			<div class="rows clean">
				<label></label>
				<div class="input">
					<input type="submit" class="btn_global btn_submit" name="submit_button" value="{/global.save/}" />
					<a href="./?m=content&a=partner" class="btn_global btn_cancel">{/global.return/}</a>
				</div>
			</div>
            <input type="hidden" id="PId" name="PId" value="<?=$PId;?>" />
            <input type="hidden" name="do_action" value="content.partner_edit" />
            <input type="hidden" id="back_action" name="back_action" value="<?=$_SERVER['HTTP_REFERER'];?>" />
		</form>
		<div class="blank12"></div>
	</div>
	<?php }?>
</div>