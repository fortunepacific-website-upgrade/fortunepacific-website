<?php
!(int)$c['FunVersion'] && manage::no_permit();

$d_ary=array('list', 'edit');
$d=$_GET['d'];
!in_array($d, $d_ary) && $d=$d_ary[0];

$type_ary=$c['manage']['language']['page']['feed_set']['type_list'];
?>
<script src="/static/manage/js/set.js"></script>
<script language="javascript">$(function(){frame_obj.switchery_checkbox();set_obj.feed_set_init();});</script>
<div class="r_nav feedback_nav">
	<h1>{/module.content.page.feed_set/}</h1>
</div>
<div class="r_con_wrap">
	<div id="feedback_set">
		<?php
        if($d=='list'){
            $row=db::get_all('feedback_set', '1', '*', "{$c[my_order]} SetId asc");
        ?>
        <div class="fixed fl">
            <div class="r_nav feedback_nav">
                <h1>{/page.feed_set.default_set/}</h1>
            </div>
            <table border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                <thead>
                    <tr>
                        <td width="55%" nowrap="nowrap">{/page.feed_set.name/}</td>
                        <td width="45%" nowrap="nowrap" class="last">{/global.used/} / {/global.required/}</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $FeedSet=db::get_value('config', 'GroupId="feedback_other" and Variable="FeedSetOther"', 'Value');
                    $feed_ary=str::json_data($FeedSet, 'decode');
                    foreach($c['manage']['feed_set_fiexd'] as $k=>$v){
                        $status=$feed_ary[$k];
                    ?>
                    <tr>
                        <td>{/page.feed_set.<?=$k;?>/}<?=!$v?'{/set.feed_set.fixed/}':'';?></td>
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
        <div class="custom fl">
            <div class="r_nav feedback_nav">
                <h1>{/page.feed_set.custom_events/}</h1>
            </div>
            <table border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                <thead>
                    <tr>
                        <td width="25%" nowrap="nowrap">{/page.feed_set.name/}</td>
                        <td width="55%" nowrap="nowrap">{/page.feed_set.type/}</td>
                        <td width="15%" nowrap="nowrap">{/global.operation/}</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($row as $v){?>
                    <tr>
                        <td><?=$v['Name'.$c['lang']];?></td>
                        <td><?=$type_ary[$v['TypeId']];?></td>
                        <td>
                            <a href="./?m=content&a=page.feed_set&d=edit&SetId=<?=$v['SetId'];?>" title="{/global.edit/}"><img src="/static/images/ico/edit.png" alt="{/global.edit/}" align="absmiddle" /></a>
                            <a href="./?do_action=set.feed_set_del&SetId=<?=$v['SetId'];?>" title="{/global.del/}" class="del" rel="del"><img src="/static/images/ico/del.png" alt="{/global.del/}" align="absmiddle" /></a>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
            <div class="blank15"></div>
            <div class="control_btn">
                <a href="./?m=content&a=page.feed_set&d=edit" class="btn_ok">{/global.add/}</a>
            </div>
        </div>
        <?php
        }elseif($d='edit'){
            $SetId=(int)$_GET['SetId'];
            $row=db::get_one('feedback_set', "SetId={$SetId}");
            $type_id=(int)$row['TypeId'];
        ?>
        
            <script language="javascript">$(function(){set_obj.feed_set_edit_init()});</script>
            <form id="frm" class="r_con_form">
                <div class="rows_hd"><?=$SetId?'{/global.edit/}':'{/global.add/}';?>{/page.feed_set.custom_events/}</div>
                
                <div class="rows">
                    <label>{/page.feed_set.name/}:</label>
                    <span class="input"><?=manage::form_edit($row, 'text', 'Name', 30, 50, 'notnull');?></span>
                    <div class="clear"></div>
                </div>
                
                <div class="rows">
                    <label>{/page.feed_set.is_notnull/}:</label>
                    <span class="input">
                        <div class="switchery<?=$row['IsNotnull']?' checked':'';?>">
                            <input type="checkbox" name="IsNotnull" value="1"<?=$row['IsNotnull']?' checked':'';?>>
                            <div class="switchery_toggler"></div>
                            <div class="switchery_inner">
                                <div class="switchery_state_on"></div>
                                <div class="switchery_state_off"></div>
                            </div>
                        </div>
                        <span class="notes_icon" content="{/set.config.ip_notes/}"></span>
                    </span>
                    <div class="clear"></div>
                </div>
                
                <div class="rows">
                    <label>{/page.feed_set.type/}:</label>
                    <span class="input">
                        <select name="TypeId">
                            <?php foreach($type_ary as $k => $v){?>
                            <option value="<?=$k;?>" <?=$type_id==$k ? "selected='selected'" : "";?>><?=$v;?></option>
                            <?php }?>
                        </select>
                    </span>
                    <div class="clear"></div>
                </div>
                
                <div class="rows">
                    <label></label>
                    <span class="input">
                        <input type="submit" class="btn_ok" name="submit_button" value="{/global.submit/}" />
                        <a href="./?m=content&a=page.feed_set" class="btn_cancel">{/global.return/}</a>
                    </span>
                    <div class="clear"></div>
                </div>
                <input type="hidden" name="SetId" value="<?=$SetId;?>" />
                <input type="hidden" name="do_action" value="set.feed_set_edit" />
            </form>
        <?php }?>
    </div>
</div>