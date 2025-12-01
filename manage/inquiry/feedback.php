<?php !isset($c) && exit();?>
<?php
manage::check_permit('inquiry.feedback', 2);//检查权限
?>
<div id="feedback" class="r_con_wrap">
	<?php if($c['manage']['do']=='index'){ ?>
		<div class="inside_container">
			<h1>{/module.inquiry.feedback/}</h1>
		</div>
		<div class="inside_table">
			<div class="list_menu">
				<div class="search_form">
					<form method="get" action="?">
						<div class="k_input">
							<input type="text" name="Keyword" placeholder="" value="" class="form_input" size="15" autocomplete="off" />
							<input type="button" value="" class="more" />
						</div>
						<input type="submit" class="search_btn" value="{/global.search/}" />
						<div class="clear"></div>
						<input type="hidden" name="m" value="inquiry" />
						<input type="hidden" name="a" value="feedback" />
					</form>
				</div>
				<ul class="list_menu_button">
					<li><a class="explode_bat export" href="javascript:;">{/global.explode/}</a></li>
					<li><a class="del" href="javascript:;">{/global.del/}</a></li>
				</ul>
			</div>
			<script type="text/javascript">$(document).ready(function(){inquiry_obj.feedback_init()});</script>
			<form action="?" method="post" name="feedback_explode">
				<table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
					<thead>
						<tr>
							<td width="1%" nowrap="nowrap"><?=html::btn_checkbox('select_all');?></td>
							<td width="25%" nowrap="nowrap">{/global.title/}</td>
							<td width="10%" nowrap="nowrap">{/inquiry.device/}</td>
							<td width="12%" nowrap="nowrap">{/global.name/}</td>
							<td width="12%" nowrap="nowrap">{/global.email/}</td>
							<td width="12%" nowrap="nowrap">{/inquiry.tel/}</td>
							<td width="12%" nowrap="nowrap">{/global.time/}</td>
							<td width="10%" nowrap="nowrap" class="last">{/global.operation/}</td>
						</tr>
					</thead>
					<tbody>
						<?php
						$Keyword=$_GET['Keyword'];
						$where='1';
						$Keyword!='' && $where.=" and (Subject like '%$Keyword%' or Name like '%$Keyword%' or Email like '%$Keyword%' or Phone like '%$Keyword%')";
						
						$page_count=10;
						$feedback_row=str::str_code(db::get_limit_page('feedback', $where, '*', 'FId desc', (int)$_GET['page'], $page_count));
						foreach($feedback_row[0] as $v){
							$fid=$v['FId'];
							$url="./?m=inquiry&a=feedback&d=edit&FId=".$fid;
						?>
						<tr>
							<td nowrap="nowrap"><?=html::btn_checkbox('select', $fid);?></td>
							<td><a href="<?=$url;?>"><?php if($v['IsRead']==0){?><img src="/static/manage/images/inquiry/not_read.png" width="20" hspace="5" /><?php }?><?=$v['Subject'];?></a></td>
							<td nowrap="nowrap"><img src="/static/manage/images/inquiry/source_<?=(int)$v['Source'];?>.png"></td>
							<td><?=$v['Name'];?></td>
							<td nowrap="nowrap"><a href="./?m=email&a=send&Email=<?=urlencode($v['Email'].'/'.$v['Name']);?>" title="{/inquiry.send_email/}" class="blue" target="_blank"><?=$v['Email'];?></a></td>
							<td nowrap="nowrap"><?=$v['Phone'];?></td>
							<td nowrap="nowrap"><?=date('Y/m/d H:i:s', $v['AccTime']);?></td>
							<td nowrap="nowrap" class="operation">
								<a class="tip_min_ico" href="<?=$url;?>">{/global.view/}</a>
								<a class="del item" href="./?do_action=inquiry.feedback_del&id=<?=$fid;?>" rel="del">{/global.del/}</a>
							</td>
						</tr>
						<?php }?>
					</tbody>
				</table>
				<input type="hidden" name="do_action" value="inquiry.feedback_explode" />
				<input type="hidden" name="IdStr" value="" />
			</form>
			<?=html::turn_page($feedback_row[1], $feedback_row[2], $feedback_row[3], '?'.str::query_string('page').'&page=');?>
		</div>
	<?php
	}else{
		$FId=(int)$_GET['FId'];
		$feedback_row=str::str_code(db::get_one('feedback', "FId='$FId'"));
		!$feedback_row && js::location('./m=inquiry&a=feedback');
		db::update('feedback', "FId='$FId'", array('IsRead'=>1));
		$email=urlencode($feedback_row['Email'].'/'.$feedback_row['Name']);
	?>
		<div class="inquiry-detail">
			<div class="center_container_1000">
				<a href="javascript:history.back(-1);" class="return_title grey">
					<span class="return">{/module.inquiry.feedback/}</span>
				</a>
				<div class="global_container center_container_1000">
					<div class="inquiry-row">
						<div class="rows clean">
							<label>{/global.title/}</label>
							<div class="input"><?=$feedback_row['Subject'];?></div>
						</div>
						<div class="rows clean">
							<label>{/global.name/}</label>
							<div class="input"><?=$feedback_row['Name'];?></div>
						</div>
						<div class="rows clean">
							<label>{/inquiry.company/}</label>
							<div class="input"><?=$feedback_row['Company'];?></div>
						</div>
						<div class="rows clean">
							<label>{/global.email/}</label>
							<div class="input">
								<?=$feedback_row['Email'];?><a href="./?m=email&a=send&Email=<?=$email;?>" class="icon_mail" target="_blank">{/inquiry.send_email/}</a>
							</div>
						</div>
						<div class="rows clean">
							<label>{/inquiry.tel/}</label>
							<div class="input"><?=$feedback_row['Phone'];?></div>
						</div>
						<div class="rows clean">
							<label>{/inquiry.mobile/}</label>
							<div class="input"><?=$feedback_row['Mobile'];?></div>
						</div>
						<div class="rows clean">
							<label>{/global.ip/}</label>
							<div class="input pic_box">
								<img src="/static/manage/images/inquiry/source_<?=(int)$feedback_row['Source'];?>.png">
								<?=$feedback_row['Ip'].' 【'.ly200::ip($feedback_row['Ip']).'】';?>
							</div>
						</div>
						<div class="rows clean">
							<label>{/global.time/}</label>
							<div class="input"><?=date('Y/m/d H:i:s', $feedback_row['AccTime']);?></div>
						</div>
						<div class="rows clean">
							<label>{/global.contents/}</label>
							<div class="input"><?=str::str_format($feedback_row['Message']);?></div>
						</div>
						<?php
							$CustValue = explode("---",$feedback_row['CustValue']);
							foreach((array)$CustValue as $k => $v){
								$value = explode(':',$v);
								$SetId = (int)$value[0];
								$row = db::get_one('feedback_set',"SetId='$SetId'","Name{$c['lang']}");
								if(!$v){
									continue;
								}
						?>
						<div class="rows clean">
							<label><?=$row['Name'.$c['lang']];?></label>
							<div class="input"><?=str_replace('<br />','',$value[1]);?></div>
						</div>
		                <?php }?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	<?php }?>
</div>