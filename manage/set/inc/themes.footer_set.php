<?php !isset($c) && exit();?>
<?php
$FootFont=db::get_value('config', "GroupId='mobile' and Variable='FootFont'", 'Value');
$FootBg=db::get_value('config', "GroupId='mobile' and Variable='FootBg'", 'Value');
$FootNav=str::json_data(db::get_value('config', "GroupId='mobile' and Variable='FootNav'", 'Value'), 'decode');
echo ly200::load_static('/static/js/plugin/jscolor/jscolor.js');
?>
<script type="text/javascript">$(document).ready(function(){set_obj.themes_footer_set_init()});</script>
<div class="blank25"></div>
<div id="themes_footer_set">
	<div class="center_container">
		<form id="footer_set_form" class="global_form">
            <div class="rows">
                <label>{/set.themes.footer_set.preview/}</label>
                <div class="input clean">
                    <div class="fl preview" id="foot_preview">
                        {/set.themes.footer_set.font_family/}
                    </div>
                </div>
            </div>
            <div class="rows">
                <label>{/set.themes.footer_set.font_color/}</label>
                <div class="input">
                    <input type="text" id="font_color" class="box_input color" name="font_color" size="6" value="<?=$FootFont?$FootFont:'#000'?>" autocomplete="off"/>
                </div>
            </div>
            <div class="rows">
                <label>{/set.themes.footer_set.bg_color/}</label>
                <div class="input">
                    <input type="text" id="bg_color" class="box_input color" name="bg_color" size="7" value="<?=$FootBg?$FootBg:'#000'?>" autocomplete="off"/>
                </div>
            </div>
            <div class="rows">
                <label>{/set.themes.footer_set.nav/}</label>
            </div>
            <div id="Linkrow">
                <?php
                foreach ($FootNav as $key=>$value){
                ?>
					<div class="rows">
						<label>{/global.name/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
						<div class="input list_input">
							<?php
							foreach($c['manage']['language_web'] as $k=>$v){?>
								<div class="tab_txt tab_txt_<?=$v;?> fl">
									<div class='item'><input type='text' name='Name_<?=$v;?>[]' value='<?=$value['Name_'.$v];?>' class='box_input' size='25' maxlength='50'></div>
								</div>
							<?php }?>
							<div>{/set.themes.footer_set.url/}: <input type="text" size="40" maxlength="150" class="box_input" value="<?=$value['Url'];?>" name="Url[]"></div>
						</div>
					</div>
                <?php }?>
            </div>
			<div class="blank15"></div>
			<div class="rows clean">
				<div class="input">
					<input type="submit" class="btn_global btn_submit" value="{/global.save/}" name="submit_button">
				</div>
			</div>
			<input type="hidden" name="do_action" value="set.themes_footer_set">
		</form>
	</div>
</div>