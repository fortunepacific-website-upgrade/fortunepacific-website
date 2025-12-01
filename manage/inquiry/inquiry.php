<?php !isset($c) && exit();?>
<?php
manage::check_permit('inquiry.inquiry', 2);//检查权限
?>
<div id="inquiry" class="r_con_wrap">
	<?php if($c['manage']['do']=='index'){ ?>
		<div class="inside_container">
			<h1>{/module.inquiry.inquiry/}</h1>
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
						<input type="hidden" name="a" value="inquiry" />
					</form>
				</div>
				<ul class="list_menu_button">
					<li><a class="del" href="javascript:;">{/global.del/}</a></li>
					<li><a class="explode export" href="javascript:;">{/global.explode/}</a></li>
				</ul>
			</div>
			<script type="text/javascript">$(document).ready(function(){inquiry_obj.inquiry_init()});</script>
			<table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
				<thead>
					<tr>
						<td width="1%" nowrap="nowrap"><?=html::btn_checkbox('select_all');?></td>
						<td width="25%" nowrap="nowrap">{/global.title/}</td>
						<td width="10%" nowrap="nowrap">{/inquiry.device/}</td>
						<td width="14%" nowrap="nowrap">{/global.name/}</td>
						<td width="13%" nowrap="nowrap">{/global.email/}</td>
						<td width="8%" nowrap="nowrap">{/inquiry.country/}</td>
						<td width="13%" nowrap="nowrap">{/global.time/}</td>
						<td width="10%" nowrap="nowrap" class="last">{/global.operation/}</td>
					</tr>
				</thead>
				<tbody>
					<?php
					$Keyword=str::str_code($_GET['Keyword']);
					$where='1';
					$page_count=10;
					$Keyword!='' && $where.=" and (ProId in(select ProId from products where Name{$c['lang']} like '%$Keyword%') or Subject like '%$Keyword%' or CONCAT(FirstName,' ',LastName) like '%$Keyword%' or FirstName like '%$Keyword%' or LastName like '%$Keyword%')";
					$inquiry_row=str::str_code(db::get_limit_page('products_inquiry', $where, '*', 'IId desc', (int)$_GET['page'], $page_count));
					foreach($inquiry_row[0] as $v){
						$url="./?m=inquiry&a=inquiry&d=edit&IId=".$v['IId'];
					?>
					<tr>
						<td nowrap="nowrap"><?=html::btn_checkbox('select', $v['IId']);?></td>
						<td><a href="<?=$url;?>"><?php if($v['IsRead']==0){?><img src="/static/manage/images/inquiry/not_read.png" width="20" hspace="5" /><?php }?><?=$v['Subject'];?></a></td>
						<td nowrap="nowrap"><img src="/static/manage/images/inquiry/source_<?=(int)$v['Source'];?>.png" alt=""></td>
						<td><?=$v['FirstName'].' '.$v['LastName'];?></td>
						<td nowrap="nowrap"><a href="./?m=email&a=send&Email=<?=urlencode($v['Email'].'/'.$v['FirstName'].' '.$v['LastName']);?>" title="{/inquiry.send_email/}" class="blue"><?=$v['Email'];?></a></td>
						<td nowrap="nowrap"><?=$v['Country'];?></td>
						<td nowrap="nowrap"><?=date('Y/m/d H:i:s', $v['AccTime']);?></td>
						<td nowrap="nowrap" class="operation">
							<a class="tip_min_ico" href="<?=$url;?>">{/global.view/}</a>
							<a class="del item" href="./?do_action=inquiry.inquiry_del&id=<?=$v['IId'];?>" rel="del">{/global.del/}</a>
						</td>
					</tr>
					<?php }?>
				</tbody>
			</table>
			<?=html::turn_page($inquiry_row[1], $inquiry_row[2], $inquiry_row[3], '?'.str::query_string('page').'&page=');?>
		</div>
	<?php
	}else{
		$IId=(int)$_GET['IId'];
		$inquiry_row=str::str_code(db::get_one('products_inquiry', "IId='$IId'"));
		!$inquiry_row && js::location('./m=inquiry&a=inquiry');

		db::update('products_inquiry', "IId='$IId'", array('IsRead'=>1));
		$ProId=trim((!$inquiry_row['ProId']?0:$inquiry_row['ProId']),',');
		$products_row=str::str_code(db::get_all('products', "ProId in(0,{$ProId},0)"));
		$email=urlencode($inquiry_row['Email'].'/'.$inquiry_row['FirstName'].' '.$inquiry_row['LastName']);
	?>
		<div class="inquiry-w1200 clean inquiry-row">
			<a href="javascript:history.back(-1);" class="return_title grey">
				<span class="return">{/module.inquiry.inquiry/}</span>
			</a>
			<div class="left_container">
				<div class="left_container_side">
					<div class="global_container">
						<div class="rows clean">
							<label>{/global.title/}</label>
							<span class="input"><?=$inquiry_row['Subject'];?></span>
						</div>
						<div class="rows clean">
							<label>{/global.contents/}</label>
							<span class="input"><?=str::str_format($inquiry_row['Message']);?></span>
						</div>
						<div class="rows clean">
							<label>{/global.email/}</label>
							<span class="input"><?=$inquiry_row['Email'];?><a href="./?m=email&a=send&Email=<?=$email;?>" class="icon_mail" target="_blank">{/inquiry.send_email/}</a></span>
						</div>
						<div class="rows clean">
							<label>{/global.name/}</label>
							<span class="input"><?=$inquiry_row['FirstName'].' '.$inquiry_row['LastName'];?></span>
						</div>
						<div class="rows clean">
							<label>{/inquiry.country/}</label>
							<span class="input"><?=$inquiry_row['City'].', '.$inquiry_row['State'].', '.$inquiry_row['Country'];?></span>
						</div>
						<div class="rows clean">
							<label>{/inquiry.tel/}</label>
							<span class="input"><?=$inquiry_row['Phone'];?></span>
						</div>
						<div class="rows clean">
							<label>{/inquiry.fax/}</label>
							<span class="input"><?=$inquiry_row['Fax'];?></span>
						</div>
						<div class="rows clean">
							<label>{/inquiry.address/}</label>
							<span class="input"><?=$inquiry_row['Address'];?></span>
						</div>
						<div class="rows clean">
							<label>{/inquiry.postcode/}</label>
							<span class="input"><?=$inquiry_row['PostalCode'];?></span>
						</div>
					</div>
				</div>
			</div>
			<div class="right_container">
				<div class="global_container">
					<div class="pro-row">
						<?php
						foreach($products_row as $v){
							$url=web::get_url($v, 'products');
							$pic = img::get_small_img($v['PicPath_0'], '240x240');
						?>
                        	<div class="plist clean">
								<?php if($pic){?>
                            	<div class="img pic_box fl"><a href="<?=$url;?>" target="_blank"><img src="<?=$pic;?>" /><em></em></a></div>
								<?php }?>
                                <div class="name fl">
                                	<a href="<?=$url;?>" target="_blank"><?=$v['Name'.$c['lang']];?></a>
                                </div>
                            </div>
                        <?php }?>
					</div>
					<div class="oth">
						<div class="rows clean">
							<label>{/global.ip/}</label>
							<span class="input pic_box">
								<img src="/static/manage/images/inquiry/source_<?=(int)$inquiry_row['Source'];?>.png" alt="">
								<?=$inquiry_row['Ip'].'<br /><br /> 【'.ly200::ip($inquiry_row['Ip']).'】';?>
							</span>
						</div>
						<div class="rows clean">
							<label>{/global.time/}</label>
							<span class="input"><?=date('Y/m/d H:i:s', $inquiry_row['AccTime']);?></span>
						</div>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	<?php }?>
</div>