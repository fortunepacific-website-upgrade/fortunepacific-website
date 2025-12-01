<script language="javascript">$(document).ready(function(){email_obj.email_default_init()});</script>
<?php 
	$i=1;
	$Email = $_GET['Email'];
	$w='1';
	$Email && $w.=" and Email='$Email'";
	$newsletter_row=db::get_limit_page('newsletter', $w, '*', 'NId desc', (int)$_GET['page'], 20);
?>
<div class="r_nav email_nav">
	<h1>{/module.email.newsletter/}</h1>
    <div class="list_nav fr">
        <span class="choice_btn fl anti" onselectstart="return false"><b>{/global.anti/}</b><input type="checkbox" name="select_all" value=""></span>
        <ul class="panel fl">
            <li><a class="panel_3 del_bat" href="javascript:void(0);" title="{/global.del_bat/}">{/global.del_bat/}</a></li>
        </ul>
        <div id="turn_page_oth" class="turn_page fl"><?=manage::turn_page($newsletter_row[1], $newsletter_row[2], $newsletter_row[3], '?'.ly200::query_string('page').'&page=', '{/global.pre_page/}', '{/global.next_page/}');?></div>
    </div>
    <div class="email_search fr">
        <form id="list_search_form">
            <input type="text" name="Email" class="search_txt fl" value="" />
            <input type="submit" class="search_btn fl" value="" />
            <div class="clear"></div>
        </form>
    </div>
</div>
<div id="email" class="r_con_wrap">
	<div class="list_box">
		<form class="r_con_form">
			<div class="rows_box">
				<!-- 基本信息 -->
                <div class="newsletter">
                    <table border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                        <thead>
                            <tr>
                            	<td width="3%"></td>
                                <td width="10%">{/global.serial/}</td>
                                <td width="60%">{/global.email/}</td>
                                <td width="30%" class="last">{/global.time/}</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($newsletter_row[0] as $v){
                            ?>
                                <tr>
                                	<td><input type="checkbox" name="select" value="<?=$v['NId'];?>" class="va_m" /></td>
                                    <td><?=$newsletter_row[4]+$i++;?></td>
                                    <td><a href="?m=email&a=send&email=<?=$v['Email'];?>"><?=$v['Email'];?></a></td>
                                    <td class="last"><?=date('Y-m-d H:i:s', $v['AccTime']);?></td>
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
</div>
