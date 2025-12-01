<?php
$d_ary=array('list','view');
$d=$_GET['d'];
!in_array($d, $d_ary) && $d=$d_ary[0];

$email_logs_row=db::get_limit_page('email_log', '1=1', '*', 'LId desc', (int)$_GET['page'], 20);		
?>
<script type="text/javascript">$(function(){email_obj.email_config_init();})</script>
<div class="r_nav email_nav">
	<h1>{/module.email.email_logs/}</h1>
    <?php if($d=='list'){?>
    <div class="list_nav fr">
        <div id="turn_page_oth" class="turn_page fl"><?=manage::turn_page($email_logs_row[1], $email_logs_row[2], $email_logs_row[3], '?'.ly200::query_string('page').'&page=', '{/global.pre_page/}', '{/global.next_page/}');?></div>
    </div>
    <?php }?>
</div>
<div id="email" class="r_con_wrap">
	<?php if($d=='list'){?>
	<div class="list_box">
		<form class="r_con_form">
			<div class="rows_box">
				<!-- 基本信息 -->
                <div class="newsletter">
                    <table border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                        <thead>
                            <tr>
                            	<td width="5%" nowrap="nowrap">{/global.serial/}</td>
                                <td width="15%" nowrap="nowrap">{/email.email_logs.to_email/}</td>
                                <td width="30%" nowrap="nowrap">{/email.email_logs.subject/}</td>
                                <td width="10%" nowrap="nowrap">{/email.email_logs.status/}</td>
                                <td width="10%" nowrap="nowrap">{/global.time/}</td>
                                <td width="8%" class="last" nowrap="nowrap">{/global.operation/}</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
							$i=1;
                           	foreach($email_logs_row[0] as $v){
                            ?>
                                <tr>
                                    <td nowrap="nowrap"><?=$manage_logs_row[4]+$i++;?></td>
                                    <td nowrap="nowrap"><?=$v['Email'];?></td>
                                    <td nowrap="nowrap"><?=$v['Subject'];?></td>
                                    <td nowrap="nowrap">{/email.email_logs.status_ary.0/}</td>
                                    <td nowrap="nowrap"><?=date('Y-m-d H:i:s', $v['AccTime']);?></td>
                                    <td nowrap="nowrap">
                                        <a class="tip_ico tip_min_ico" href="./?m=email&a=email_logs&d=view&LId=<?=$v['LId'];?>" label="{/global.view/}"><img src="/static/images/ico/search.png" align="absmiddle" /></a>
                                    </td>
                                </tr>
                            <?php }?>
                        </tbody>
                    </table>
                    <div class="blank20"></div>
                    <div id="turn_page_oth"><?=manage::turn_page($newsletter_row[1], $newsletter_row[2], $newsletter_row[3], '?'.ly200::query_string('page').'&page=', '{/global.pre_page/}', '{/global.next_page/}');?></div>
                </div>
			</div>
		</form>
	</div>
    <?php }else{
		//邮件发送记录查看
		$LId=(int)$_GET['LId'];
		$log_row=db::get_one('email_log', "LId='$LId'");
	?>
    <div class="edit_bd list_box">
		<form id="inquiry_form" name="inquiry_form" class="r_con_form">
			<div class="rows_box">
				<div class="rows">
					<label>{/email.email_logs.to_email/}:</label>
					<span class="input"><?=$log_row['Email'];?></span>
					<div class="clear"></div>
				</div>
            <div class="rows">
				<label>{/email.email_logs.status/}</label>
				<span class="input">{/email.email_logs.status_ary.0/}</span>
				<div class="clear"></div>
			</div>
			<div class="rows">
				<label>{/global.time/}</label>
				<span class="input"><?=date('Y-m-d H:i:s', $log_row['AccTime']);?></span>
				<div class="clear"></div>
			</div>
			<div class="rows">
				<label>{/email.email_logs.subject/}</label>
				<span class="input"><?=$log_row['Subject'];?></span>
				<div class="clear"></div>
			</div>
            <div class="rows">
				<label>{/email.email_logs.content/}</label>
				<span class="input email_content"><?=$log_row['Body'];?></span>
				<div class="clear"></div>
			</div>
				<div class="rows">
					<label></label>
					<span class="input"><a href="./?m=email&a=email_logs" class="btn_cancel">{/global.return/}</a></span>
					<div class="clear"></div>
				</div>
			</div>
		</form>
        
	</div>
    <?php }?>
</div>