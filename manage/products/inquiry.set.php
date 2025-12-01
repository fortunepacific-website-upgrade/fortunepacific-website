<?php
$d_ary=array('list', 'edit');
$d=$_GET['d'];
!in_array($d, $d_ary) && $d=$d_ary[0];
$background = db::get_value('config',"GroupId='inquiry' AND Variable='inquiry_button'",'Value');
echo ly200::load_static('/static/js/plugin/jscolor/jscolor.js', '/static/manage/css/inquiry.css');
?>
<script language="javascript">$(function(){inquiry_set_obj.inq_set_init()});</script>
<div class="r_nav products_nav">
	<h1>{/products.inq_set.default_set/}</h1>
</div>
<div class="r_con_wrap">
    <div id="feedback_set">
        <div class="fixed">
            <form id="inquiry_set_form" class="r_con_form" style="overflow:hidden; margin-top:20px;">
                <div class="rows">
                    <label>{/products.inq_set.button/}:</label>
                    <span class="input">
                        <div class="classify fl">
                            <input type="text" class='form_input color' name="Color" value="<?=trim($background,'#');?>" />
                        </div>
                    </span>
                </div>
                <div class="rows">
                    <label></label>
                    <span class="input">
                        <input type="button" class="btn_ok" name="submit_button" value="{/global.submit/}" />
                    </span>
                    <div class="clear"></div>
                </div>
            </form>
        </div>
    </div>        
    <div id="inquiry_set">
        <?php
        if($d=='list'){
        ?>
        <div class="fixed fl">
            <div class="rows_hd">{/products.inq_set.default_set/}</div>
            <table border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                <thead>
                    <tr>
                        <td width="55%" nowrap="nowrap">{/products.inq_set.name/}</td>
                        <td width="45%" nowrap="nowrap" class="last">{/global.used/} / {/global.required/}</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $InqSet=db::get_value('config', 'GroupId="inquiry" and Variable="InqSet"', 'Value');
                    $feed_ary=str::json_data($InqSet, 'decode');
                    foreach($c['manage']['inq_set_fiexd'] as $k=>$v){
                        $status=$feed_ary[$k];
                    ?>
                    <tr>
                        <td>{/products.inq_set.<?=$k;?>/}<?=!$v?'{/set.feed_set.fixed/}':'';?></td>
                        <td class="last">
                            <div class="switchery<?=(($status[0] && $v) || !$v)?' checked':'';?><?=!$v?' no_drop':'';?>"<?=$v?" field='{$k}' status='{$status[0]}'":'';?>>
                                <div class="switchery_toggler"></div>
                                <div class="switchery_inner">
                                    <div class="switchery_state_on">ON</div>
                                    <div class="switchery_state_off">OFF</div>
                                </div>
                            </div>&nbsp;&nbsp;
                            <div class="switchery<?=(($status[1] && $v) || !$v)?' checked':'';?><?=(($v && !$status[0]) || !$v)?' no_drop':'';?>"<?=$v?" field='{$k}NotNull' status='{$status[1]}'":'';?>>
                                <div class="switchery_toggler"></div>
                                <div class="switchery_inner">
                                    <div class="switchery_state_on">ON</div>
                                    <div class="switchery_state_off">OFF</div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
        <?php }?>
    </div>
</div>