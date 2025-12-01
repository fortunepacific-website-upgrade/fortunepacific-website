<?php
//$language_default='_'.$c['manage']['language_default'];
?>
<div class="r_nav">
	<h1>{/module.email.arrival/}</h1>
</div>
<div id="email" class="r_con_wrap">
	<div class="list_box">
		<form class="r_con_form">
			<div class="blank9"></div>
			<div class="rows_box">
				<!-- 基本信息 -->
                <div class="newsletter">
                    <table border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                        <thead>
                            <tr>
                                <td width="5%">{/global.serial/}</td>
								<td width="20%">{/products.product/}{/products.name/}</td>
                                <td width="20%">{/global.email/}</td>
                                <td width="15%">{/global.time/}</td>
								<td width="10%">{/email.email.send_status/}</td>
								<td width="15%" class="last">{/email.email.send_time/}</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i=1;
							$arrival_row=str::str_code(db::get_limit_page('arrival_notice a left join products p on a.ProId=p.ProId left join user u on a.UserId=u.UserId', '1', "a.*, p.ProId, p.Name{$c['lang']}, u.Email", 'a.AId desc', (int)$_GET['page'], 20));
                            foreach($arrival_row[0] as $v){
                            ?>
							<tr>
								<td><?=$newsletter_row[4]+$i++;?></td>
								<td><a href="<?=ly200::get_url($v, 'products');?>" target="_blank"><?=$v['Name'.$c['lang']];?></a></td>
								<td><a href="?m=email&a=send&email=<?=$v['Email'];?>"><?=$v['Email'];?></a></td>
								<td><?=date('Y-m-d H:i:s', $v['AccTime']);?></td>
								<td><?=$v['IsSend']?'<span class="fc_red">{/email.email.send_status_ary.1/}</span>':'{/email.email.send_status_ary.0/}';?></td>
								<td class="last"><?=$v['SendTime']?date('Y-m-d H:i:s', $v['SendTime']):'N/A';?></td>
							</tr>
                            <?php }?>
                        </tbody>
                    </table>
                    <div class="blank20"></div>
                    <div id="turn_page_oth"><?=manage::turn_page($arrival_row[1], $arrival_row[2], $arrival_row[3], '?'.ly200::query_string('page').'&page=', '{/global.pre_page/}', '{/global.next_page/}');?></div>
                </div>
			</div>
		</form>
	</div>
</div>
