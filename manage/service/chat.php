<?php !isset($c) && exit();?>
<?php
manage::check_permit('service.chat', 2);//检查权限

if(!$c['manage']['do'] || $c['manage']['do']=='index'){
	$c['manage']['do']='chat';
}

$row=db::get_all('chat', '1', '*', $c['my_order'].'CId asc');
$bgColor=db::get_value('config', "GroupId='chat' and Variable='chat_bg'", 'Value');
$IsFloatChat=(int)db::get_value('config', "GroupId='chat' and Variable='IsFloatChat'", 'Value');
$chatType=(int)db::get_value('config', "GroupId='chat' and Variable='Type'",'Value');
$chat_data=json_decode($bgColor, !0);
$chat_data['Bg3_0']=$chat_data['Bg3_0']?$chat_data['Bg3_0']:'/static/ico/bg3_0.png';
$chat_data['Bg3_1']=$chat_data['Bg3_1']?$chat_data['Bg3_1']:'/static/ico/bg3_1.png';
$chat_data['Bg4_0']=$chat_data['Bg4_0']?$chat_data['Bg4_0']:'/static/ico/bg4_0.png';
$json_data=$type_row_ary=array();
foreach((array)$row as $k=>$v){
	$json_data[$v['CId']]=$v;
	$type_row_ary[$v['Type']][]=$v;
}
$json_data=str::json_data($json_data);
echo ly200::load_static('/static/js/plugin/jscolor/jscolor.js', '/static/js/plugin/dragsort/dragsort-0.5.1.min.js');
?>
<div id="chat" class="r_con_wrap">
	<?php
	if($c['manage']['do']=='set'){
		//在线客服设置
	?>
		<script type="text/javascript">$(document).ready(function(){service_obj.chat_set_init()});</script>
		<div class="fixed">
			<form id="edit_form" class="r_con_form">
				<div class="rows">
					<label>{/global.turn_on/}</label>
					<span class="input">
						<div class="switchery<?=$IsFloatChat?' checked':'';?>">
							<input type="checkbox" name="IsFloatChat" value="1"<?=$IsFloatChat?' checked':'';?>>
							<div class="switchery_toggler"></div>
							<div class="switchery_inner">
								<div class="switchery_state_on"></div>
								<div class="switchery_state_off"></div>
							</div>
						</div>
					</span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/service.chat.pop/}</label>
					<span class="input">
						<div class="switchery<?=$chat_data['IsHide']?' checked':'';?>">
							<input type="checkbox" name="IsHide" value="1"<?=$chat_data['IsHide']?' checked':'';?>>
							<div class="switchery_toggler"></div>
							<div class="switchery_inner">
								<div class="switchery_state_on"></div>
								<div class="switchery_state_off"></div>
							</div>
						</div>
					</span>
					<div class="clear"></div>
				</div>
				<div id="bgcolor" style=" display:<?=$chatType!=1?'block':'none';?>;">
					<div class="rows">
						<label>{/service.chat.color/}</label>
						<span class="input"><div class="classify fl"><input type="text" class='box_input color' name="Color" size="6" value="<?=trim($chat_data['Color']);?>" /></div></span>
						<div class="clear"></div>
					</div>
				</div>
				<div id="mulcolor" style=" display:<?=in_array($chatType, array(1,3))?'block':'none';?>;">
					<?php foreach ((array)$c['chat']['type'] as $k=>$v){?>
					<div class="rows">
						<label><?=$v!='trademanager'?$v:'AliIM';?></label>
						<span class="input"><div class="classify fl"><input type="text" class='box_input color' name="Color<?=$k;?>" size="6" value="<?=$chat_data[$k];?>" /></div></span>
					</div>
					<?php }?>
					<div class="rows">
						<label>Top</label>
						<span class="input"><div class="classify fl"><input type="text" class='box_input color' name="ColorTop" size="6" value="<?=$chat_data['ColorTop'];?>" /></div></span>
					</div>
				</div>
				
				<div id="bg3pic" style="display:<?=$chatType==3?'block':'none';?>;">
					<div class="rows">
						<label>{/global.pic/}<span class="tool_tips_ico" content="{/notes.png_tips/}<?=sprintf(manage::language('{/notes.pic_size_tips/}'), '74*79');?>"></span></label>
						<span class="input upload_file upload_Bg3_0">
							<div class="img">
								<div id="DetailBg3_0" class="upload_box preview_pic"><input type="button" id="Bg3_0" class="upload_btn" name="submit_button" value="{/global.upload_pic/}" tips="<?=sprintf(manage::language('{/notes.png_tips/}{/notes.pic_size_tips/}'), '74*79');?>" /></div>
							</div>
							<a href="javascript:;" label="{/global.edit/}" class="tip_ico tip_min_ico edit"><img src="/static/ico/edit.png" align="absmiddle" /></a>
							<a href="javascript:;" label="{/global.del/}" class="tip_ico tip_min_ico del" rel="del"><img src="/static/ico/del.png" align="absmiddle" /></a>
						</span>
						<div class="clear"></div>
					</div>
					<div class="rows">
						<label>{/global.pic/}<span class="tool_tips_ico" content="{/notes.png_tips/}<?=sprintf(manage::language('{/notes.pic_size_tips/}'), '74*79');?>"></span></label>
						<span class="input upload_file upload_Bg3_1">
							<div class="img">
								<div id="DetailBg3_1" class="upload_box preview_pic"><input type="button" id="Bg3_1" class="upload_btn" name="submit_button" value="{/global.upload_pic/}" tips="<?=sprintf(manage::language('{/notes.png_tips/}{/notes.pic_size_tips/}'), '74*79');?>" /></div>
							</div>
							<a href="javascript:;" label="{/global.edit/}" class="tip_ico tip_min_ico edit"><img src="/static/ico/edit.png" align="absmiddle" /></a>
							<a href="javascript:;" label="{/global.del/}" class="tip_ico tip_min_ico del" rel="del"><img src="/static/ico/del.png" align="absmiddle" /></a>
						</span>
						<div class="clear"></div>
					</div>
				</div>
				<div id="bg4pic" style="display:<?=$chatType==4?'block':'none';?>;">
					<div class="rows">
						<label>{/global.pic/}<span class="tool_tips_ico" content="{/notes.png_tips/}<?=sprintf(manage::language('{/notes.pic_size_tips/}'), '94*60');?>"></span></label>
						<span class="input upload_file upload_Bg4_0">
							<div class="img">
								<div id="DetailBg4_0" class="upload_box preview_pic"><input type="button" id="Bg4_0" class="upload_btn" name="submit_button" value="{/global.upload_pic/}" tips="<?=sprintf(manage::language('{/notes.png_tips/}{/notes.pic_size_tips/}'), '94*60');?>" /></div>
							</div>
							<a href="javascript:;" label="{/global.edit/}" class="tip_ico tip_min_ico edit"><img src="/static/ico/edit.png" align="absmiddle" /></a>
							<a href="javascript:;" label="{/global.del/}" class="tip_ico tip_min_ico del" rel="del"><img src="/static/ico/del.png" align="absmiddle" /></a>
						</span>
						<div class="clear"></div>
					</div>
				</div>
				<div class="rows">
					<label></label>
					<span class="input"><input type="submit" class="btn_ok" name="submit_button" value="{/global.submit/}" /></span>
					<div class="clear"></div>
				</div>
				<input type="hidden" name="do_action" value="set.chat_set" />
				<input type="hidden" name="Bg3_0" value="<?=$chat_data['Bg3_0'];?>" save="<?=is_file($c['root_path'].$chat_data['Bg3_0'])?1:0;?>" />
				<input type="hidden" name="Bg3_1" value="<?=$chat_data['Bg3_1'];?>" save="<?=is_file($c['root_path'].$chat_data['Bg3_1'])?1:0;?>" />
				<input type="hidden" name="Bg4_0" value="<?=$chat_data['Bg4_0'];?>" save="<?=is_file($c['root_path'].$chat_data['Bg4_0'])?1:0;?>" />
			</form>
		</div>
		<div class="style_box">
			<?php
			$chat_row=str::str_code(db::get_all('chat', '1', '*', 'CId asc'));
			for($i=0; $i<5; ++$i){
			?>
			<div class="box fl">
				<div class="box_hd"><input type="radio" name="Type" value="<?=$i;?>"<?=($chatType==$i?' checked':'');?> class="style_select" /></div>
				<div class="box_bd">
					<div class="blank12"></div>
					<?php if ($i==0){?>
						<div id="float_window" class="Color" style="position:inherit; margin:0 auto; background-color:#<?=$chat_data['Color'];?>; top:0; left:0;">
							<div id="inner_window">
								<div id="demo_window" style=" background-color:#<?=$chat_data['Color'];?>;" class="Color">
									<?php 
									foreach($row as $v){
										$link=sprintf($c['chat']['link'][$v['Type']],$v['Account']);
									?>
										<a class="<?=$c['chat']['type'][$v['Type']];?>" href="javascript:;" title="<?=$v['Name'];?>"></a>
										<div class="blank6"></div>
									<?php }?>
								</div>
							</div>
							<a href="javascript:;" id="go_top">TOP</a>
						</div>
					<?php }elseif ($i==1){?>
						<div id="service_0" style=" margin:0 auto; position:inherit;">
							<?php 
								foreach($row as $v){
									$link = sprintf($c['chat']['link'][$v['Type']],$v['Account']);
							?>
								<div class="r r<?=$v['Type'];?> Color<?=$v['Type'];?>" style="background-color:#<?=$chat_data[$v['Type']];?>;"><a href="javascript:;" title="<?=$v['Name'];?>"><?=$v['Name'];?></a></div>
							<?php }?>
							<div class="r top ColorTop" style=" background-color:#<?=$chat_data['ColorTop'];?>;"><a href="javascript:;">TOP</a></div>
						</div>
					<?php }elseif ($i==2){?>
						<div id="service_1" style=" margin:0 auto; position:inherit;">
							<?php 
								foreach($row as $v){
									$link = sprintf($c['chat']['link'][$v['Type']],$v['Account']);
							?>
								<div class="r r<?=$v['Type'];?> Color" style=" background-color:#<?=$chat_data['Color'];?>;"><a href="javascript:;" title="<?=$v['Name'];?>"></a></div>
							<?php }?>
							<div class="r top Color" style=" background-color:#<?=$chat_data['Color'];?>;"><a href="javascript:;"></a></div>
						</div>
					<?php }elseif ($i==3){?>
						<div id="service_2" style=" margin:0 auto; position:inherit;">
							<div class="sert">
								<div class="img0"><img src="<?=$chat_data['Bg3_0'];?>" /></div>
								<div class="img1"><img src="<?=$chat_data['Bg3_1'];?>" /></div>
							</div>
							<?php 
								foreach($row as $v){
									$link = sprintf($c['chat']['link'][$v['Type']],$v['Account']);
							?>
								<div class="r r<?=$v['Type'];?> Color hoverColor<?=$v['Type'];?>" style=" background-color:#<?=$chat_data['Color'];?>;" color="#<?=$chat_data['Color'];?>" hover-color="#<?=$chat_data[$v['Type']];?>"><a href="javascript:;" title="<?=$v['Name'];?>"></a></div>
							<?php }?>
							<div class="r top Color hoverColorTop" style=" background-color:#<?=$chat_data['Color'];?>;" color="#<?=$chat_data['Color'];?>" hover-color="#<?=$chat_data['ColorTop'];?>"><a href="javascript:;"></a></div>
						</div>
					<?php }elseif ($i==4){?>
						<div id="service_3" style=" margin:0 auto; position:inherit;">
							<div class="sert"><img src="<?=$chat_data['Bg4_0'];?>" /></div>
							<?php 
								foreach($row as $v){
									$link = sprintf($c['chat']['link'][$v['Type']],$v['Account']);
							?>
								<div class="r r<?=$v['Type'];?> Color" style=" background-color:#<?=$chat_data['Color'];?>;"><a href="javascript:;" title="<?=$v['Name'];?>"><?=$v['Name'];?></a></div>
							<?php }?>
							<div class="r top Color" style=" background-color:#<?=$chat_data['Color'];?>;"><a href="javascript:;">TOP</a></div>
						</div>
					<?php }?>
				</div><!-- .box_bd -->
			</div>
			<?php }?>
			<div class="clear"></div>
		</div>
	<?php
	}else{
		//在线客户账号管理
	?>
		<script type="text/javascript">$(document).ready(function(){service_obj.chat_init()});</script>
		<div class="chat_center_container">
			<div class="chat_title">
				<a href="javascript:;" class="add set_add fr">{/global.add/}</a>
				{/module.service.chat/}
			</div>
			<div class="chat_box" id="chat_box">
				<?php 
				$j=0;
				foreach((array)$type_row_ary as $k => $v){ ?>
					<div class="chat_list <?=$j%3==0 ? 'first' : ''; ?> <?=strtolower($c['chat']['type'][$k]); ?>">
						<a href="javascript:;" class="move"></a>
						<div class="list_box">
							<?php foreach((array)$v as $v1){ ?>
								<div class="list" id="<?=$v1['CId']; ?>">
									<span class="icon_myorder"></span>
									<div class="name">
										<?=$v1['Name'];?>
										<a href="javascript:;" class="edit" data-cid="<?=$v1['CId'];?>">{/global.edit/}</a>
										<a href="./?do_action=service.chat_del&CId=<?=$v1['CId'];?>" class="del">{/global.del/}</a>
									</div>
									<div class="account"><?=$v1['Account'];?></div>
								</div>
							<?php } ?>
						</div>
					</div>
				<?php $j++; } ?>
			</div>
		</div>
		<?php /***************************** 客服编辑 Start *****************************/?>
		<div id="fixed_right">
			<div class="global_container box_chat_edit" data-chat="<?=htmlspecialchars($json_data);?>">
				<form id="chat_edit_form" class="global_form">
					<div class="top_title">{/module.service.chat/} <a href="javascript:;" class="close"></a></div>
					<div class="rows">
						<label>{/service.chat.name/}</label>
						<span class="input"><input type="text" class='box_input' value="" name="Name" maxlength="50" notnull /></span>
						<div class="clear"></div>
					</div>
					<div class="rows">
						<label>{/service.chat.type/}</label>
						<span class="input">
							<div class="box_select">
								<select name='Type' class="box_input">
									<?php foreach($c['chat']['type'] as $k=>$v){?>
										<option value="<?=$k;?>"><?=$v;?></option>
									<?php }?>
								</select>
							</div>
						</span>
						<div class="clear"></div>
					</div>
					<div class="rows" id="Picture">
						<label>{/global.pic/}:</label>
						<span class="input">
							<div class="ubox">
								<?=manage::multi_img('PicDetail', 'PicPath', $row['PicPath']); ?>
							</div>
						</span>
						<div class="clear"></div>
					</div>
					<div class="rows">
						<label>{/service.chat.account/}</label>
						<span class="input">
                        	<input type="text" class='box_input' value="<?=$row['Account'];?>" name="Account" maxlength="50" notnull />
                            <span class="whatsapp_tips fc_grey">{/service.chat.whatsapp_tips/}</span>
                        </span>
						<div class="clear"></div>
					</div>
					<div class="rows">
						<label></label>
						<div class="input input_button">
							<input type="button" class="btn_global btn_submit" value="{/global.save/}">
							<input type="button" class="btn_global btn_cancel" value="{/global.cancel/}">
						</div>
					</div>
					<input type="hidden" name="CId" value="" />
					<input type="hidden" name="do_action" value="service.chat_edit" />
				</form>
			</div>
		</div>
		<?php /***************************** 客服编辑 End *****************************/?>
	<?php }?>
</div>