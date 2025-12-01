<?php !isset($c) && exit();?>
<?php
$HeadIcon=db::get_value('config', "GroupId='mobile' and Variable='HeadIcon'", 'Value');
$HeadBg=db::get_value('config', "GroupId='mobile' and Variable='HeadBg'", 'Value');
$HeadFixed=db::get_value('config', "GroupId='mobile' and Variable='HeadFixed'", 'Value');
echo ly200::load_static('/static/js/plugin/jscolor/jscolor.js');
?>
<script type="text/javascript">$(document).ready(function(){set_obj.themes_header_set_init()});</script>
<div class="blank25"></div>
<div id="themes_header_set">
	<div class="center_container">
		<form id="header_set_form" class="global_form">
			<div class="rows clean">
				<label>{/set.themes.header_set.icon_color/}</label>
				<div class="input">
                    <div class="fl headicon">
                        <div class="img g_img_box <?=$HeadIcon==0?'cur':'';?>" data-icon="0"><img src="/static/manage/images/mobile/white_icon.png" /></div>
                        {/set.themes.header_set.icon_color_ary.0/}
                    </div>
                    <div class="fl headicon">
                        <div class="img g_img_box <?=$HeadIcon==1?'cur':'';?>" data-icon="1"><img src="/static/manage/images/mobile/gray_icon.png" /></div>
                        {/set.themes.header_set.icon_color_ary.1/}
                    </div>
                    <div class="fl headicon">
                        <div class="img g_img_box <?=$HeadIcon==2?'cur':'';?>" data-icon="2"><img src="/static/manage/images/mobile/pink_icon.png" /></div>
                        {/set.themes.header_set.icon_color_ary.2/}
                    </div>
                    <input type="hidden" name="icon" value="<?=$HeadIcon?>" />
				</div>
			</div>
            <div class="rows">
                <label>{/set.themes.header_set.bg_color/}</label>
                <div class="input"><input type="text" id="bg_color" class="box_input color" name="bg_color" size="7" value="<?=$HeadBg?$HeadBg:'#000'?>" autocomplete="off"/></div>
            </div>
            <div class="rows">
                <label>{/set.themes.header_set.fixed/}</label>
                <div class="input">
                    <div class="switchery<?=$HeadFixed?' checked':'';?>">
                        <input type="checkbox" name="fixed" value="1"<?=$HeadFixed?' checked':'';?>>
                        <div class="switchery_toggler"></div>
                        <div class="switchery_inner">
                            <div class="switchery_state_on"></div>
                            <div class="switchery_state_off"></div>
                        </div>
                    </div>
                </div>
            </div>
			<div class="rows clean">
				<div class="input">
					<input type="submit" class="btn_global btn_submit" value="{/global.save/}" name="submit_button">
				</div>
			</div>
			<input type="hidden" name="do_action" value="set.themes_header_set">
		</form>
	</div>
</div>