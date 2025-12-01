<?php
$d_ary=array('list','edit');
$d=$_GET['d'];
!in_array($d, $d_ary) && $d=$d_ary[0];
?>
<script type="text/javascript">
$(document).ready(function(){
	feedback_other_obj.feedback_other_init();
});
</script>
<div class="r_nav feedback_nav">
	<h1>{/module.content.page.feedback_other/}</h1>
    <?php
	if($d=='list'){
		$where='1';//条件
		$page_count=20;//显示数量
		$feedback_other_row=str::str_code(db::get_limit_page('feedback_other', $where, '*', 'FId desc', (int)$_GET['page'], $page_count));
	?>
    <div class="list_nav fr">
        <ul class="panel fl">
        	<li><a class="panel_2 explode_bat" href="javascript:void(0);" title="{/global.explode/}"></a></li>
            <li><a class="panel_3 del_bat" href="javascript:void(0);" title="{/global.del_bat/}"></a></li>
        </ul>
        <div id="turn_page_oth" class="turn_page fl"><?=manage::turn_page($feedback_other_row[1], $feedback_other_row[2], $feedback_other_row[3], '?'.ly200::query_string('page').'&page=', '{/global.pre_page/}', '{/global.next_page/}');?></div>
    </div>
    <?php }?>
</div>
<div id="feedback_other" class="r_con_wrap">
	<?php
	if($d=='list'){
	?>
    <div class="list_box">
    	<form action="?" method="post" name="feedback_other_explode">
            <table border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                <thead>
                    <tr>
                        <td width="4%"><input type="checkbox" name="select_all" value="" class="va_m" /></td>
                        <td width="16%" nowrap="nowrap">{/global.title/}</td>
                        <td width="12%" nowrap="nowrap">{/products.inquiry.customer_name/}</td>
                        <td width="15%" nowrap="nowrap">{/global.email/}</td>
                        <td width="10%" nowrap="nowrap">{/products.inquiry.tel/}</td>
                        <td width="10%" nowrap="nowrap">{/manage.log.ip/}</td>
                        <td width="10%" nowrap="nowrap">{/global.time/}</td>
                        <td width="8%" class="last" nowrap="nowrap">{/global.operation/}</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($feedback_other_row[0] as $v){
                        $fid=$v['FId'];
                    ?>
                    <tr class="<?=(int)$v['IsRead']?'':'fc_red';?>">
                        <td><input type="checkbox" name="select" value="<?=$fid;?>" class="va_m" /></td>
                        <td><?=$v['Subject'];?></td>
                        <td><?=$v['Name'];?></td>
                        <td><a href="./?m=email&a=send&Email=<?=urlencode($v['Email'].'/'.$v['Name']);?>" title="{/module.email.send/}" class="blue" target="_blank"><?=$v['Email'];?></a></td>
                        <td><?=$v['Phone'];?></td>
                        <td><?=$v['Ip'];?></td>
                        <td><?=date('Y/m/d H:i:s', $v['AccTime']);?></td>
                        <td class="last">
                            <a href="./?m=content&a=page.feedback_other&d=edit&FId=<?=$fid;?>" title="{/global.view/}"><img src="/static/images/ico/search.png" alt="{/global.view/}" align="absmiddle" /></a>
                            <a href="./?do_action=content.feedback_other_del&FId=<?=$fid;?>" title="{/global.del/}" class="del" rel="del"><img src="/static/images/ico/del.png" alt="{/global.del/}" align="absmiddle" /></a>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        	<input type="hidden" name="do_action" value="content.feedback_other_explode" />
            <input type="hidden" name="IdStr" value="" />
        	<input type="hidden" name="Type" value="feedback_other" />
        </form>
        <div class="blank20"></div>
        <div id="turn_page_oth"><?=manage::turn_page($feedback_other_row[1], $feedback_other_row[2], $feedback_other_row[3], '?'.ly200::query_string('page').'&page=', '{/global.pre_page/}', '{/global.next_page/}');?></div>
        <div class="blank20"></div>
    </div>
	<?php
		//销毁变量
		unset($feedback_other_row);
	}else{
		$FId=(int)$_GET['FId'];
		$feedback_other_row=str::str_code(db::get_one('feedback_other', "FId='$FId'"));
		!$feedback_other_row && js::location('./m=content&a=page.feedback_other');
		
		db::update('feedback_other', "FId='$FId'", array('IsRead'=>1));
		$email=urlencode($feedback_other_row['Email'].'/'.$feedback_other_row['Name']);
	?>
	<div class="edit_bd list_box">
		<form id="feedback_other_form" name="feedback_other_form" class="r_con_form">
			<div class="rows_box">
				<h3 class="rows_hd">{/module.content.feedback_other/}</h3>
				<div class="rows">
					<label>{/products.inquiry.title/}:</label>
					<span class="input"><?=$feedback_other_row['Subject'];?></span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/products.inquiry.customer_name/}:</label>
					<span class="input"><?=$feedback_other_row['Name'];?></span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/feedback_other.company/}:</label>
					<span class="input"><?=$feedback_other_row['Company'];?></span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/products.inquiry.mail/}:</label>
					<span class="input"><?=$feedback_other_row['Email'];?><a href="./?m=email&a=send&Email=<?=$email;?>" class="blue mar_l_10" target="_blank">{/products.inquiry.mail_reply/}</a></span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/products.inquiry.tel/}:</label>
					<span class="input"><?=$feedback_other_row['Phone'];?></span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/feedback_other.mobile/}:</label>
					<span class="input"><?=$feedback_other_row['Mobile'];?></span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/manage.log.ip/}:</label>
					<span class="input"><?=$feedback_other_row['Ip'].' 【'.ly200::ip($feedback_other_row['Ip']).'】';?></span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/global.time/}:</label>
					<span class="input"><?=date('Y/m/d H:i:s', $feedback_other_row['AccTime']);?></span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/feedback_other.content/}:</label>
					<span class="input"><?=str::format($feedback_other_row['Message']);?></span>
					<div class="clear"></div>
				</div>
                <?php 
					$CustValue = explode("---",$feedback_other_row['CustValue']);
					foreach((array)$CustValue as $k => $v){
						$value = explode(':',$v);
						$SetId = (int)$value[0];
						$row = db::get_one('feedback_set',"SetId='$SetId'","Name{$c['lang']}");
						if(!$v){
							continue;
						}
				?>
				<div class="rows">
					<label><?=$row['Name'.$c['lang']];?>:</label>
					<span class="input"><?=str_replace('<br />','',$value[1]);?></span>
					<div class="clear"></div>
				</div>
                <?php }?>
				<div class="rows">
					<label></label>
					<span class="input"><a href="./?m=content&a=page.feedback_other" class="btn_cancel">{/global.return/}</a></span>
					<div class="clear"></div>
				</div>
			</div>
		</form>
        
	</div>
	<?php
		//销毁变量
		unset($feedback_other_row);
	}?>
</div>