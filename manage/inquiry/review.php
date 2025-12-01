<?php !isset($c) && exit();?>
<?php
manage::check_permit('inquiry.review', 2);//检查权限
?>
<div id="review" class="r_con_wrap">
	<script type="text/javascript">$(document).ready(function(){inquiry_obj.review_init()});</script>
	<?php if($c['manage']['do']=='index'){ ?>
	<div class="inside_container">
		<h1>{/module.inquiry.review/}</h1>
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
					<input type="hidden" name="a" value="review" />
				</form>
			</div>
			<ul class="list_menu_button">
				<li><a class="del" href="javascript:;">{/global.del/}</a></li>
			</ul>
		</div>
		<table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
			<thead>
				<tr>
					<td width="1%" nowrap="nowrap"><?=html::btn_checkbox('select_all');?></td>
					<td width="12%" nowrap="nowrap">{/global.name/}</td>
					<td width="30%" nowrap="nowrap">{/global.contents/}</td>
					<td width="10%" nowrap="nowrap">{/inquiry.device/}</td>
					<td width="30%" nowrap="nowrap">{/inquiry.product/}</td>
	                <td width="11%" nowrap="nowrap">{/global.email/}</td>
	                	<td width="10%" nowrap="nowrap">{/inquiry.display/}</td>
					<td width="11%" nowrap="nowrap">{/global.time/}</td>
					<td width="8%" nowrap="nowrap" class="last">{/global.operation/}</td>
				</tr>
			</thead>
			<tbody>
				<?php
				$Name=str::str_code($_GET['Keyword']);
				$where='1';
				$page_count=10;
				$Name && $where.=" and p.ProId in(select ProId from products where Name{$c['lang']} like '%$Name%')";
				$review_row=str::str_code(db::get_limit_page('products_review p', $where, '*', 'p.RId desc', (int)$_GET['page'], $page_count));
				foreach($review_row[0] as $v){
					$products_row=str::str_code(db::get_one('products', "ProId='{$v['ProId']}'"));
					$rid=$v['RId'];
				?>
				<tr>
					<td nowrap="nowrap"><?=html::btn_checkbox('select', $rid);?></td>
					<td><?php if($v['IsRead']==0){?><img src="/static/manage/images/inquiry/not_read.png" width="20" hspace="5" /><?php }?><?=$v['Name'];?></td>
					<td><?=str::str_cut($v['Content'], 170);?></td>
					<td nowrap="nowrap"><img src="/static/manage/images/inquiry/source_<?=(int)$v['Source'];?>.png"></td>
					<td class="clean">
						<a class="list-img-size" href="<?=web::get_url($products_row, 'products');?>"><img src="<?=img::get_small_img($products_row['PicPath_0'], '240x240');?>" /></a>
						<a href="<?=web::get_url($products_row, 'products');?>" target="_blank"><?=$products_row['Name'.$c['lang']];?></a>
					</td>
	                 <td nowrap="nowrap"><a href="./?m=email&a=send&Email=<?=urlencode($v['Email'].'/'.$v['Name']);?>" title="{/inquiry.send_email/}"><?=$v['Email'];?></a></td>
	                	<td nowrap="nowrap">{/global.n_y.<?=$v['Display'];?>/}</td>
					<td nowrap="nowrap"><?=date('Y/m/d H:i:s', $v['AccTime']);?></td>
					<td nowrap="nowrap" class="operation">
						<a class="tip_min_ico" href="./?m=inquiry&a=review&d=edit&RId=<?=$rid;?>">{/global.view/}</a>
						<a class="del item" href="./?do_action=inquiry.review_del&id=<?=$rid;?>" rel="del">{/global.del/}</a>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
		<?=html::turn_page($review_row[1], $review_row[2], $review_row[3], '?'.str::query_string('page').'&page=');?>
	</div>
	<?php
	}else{
		$RId=(int)$_GET['RId'];
		$review_row=str::str_code(db::get_one('products_review', "RId='$RId'"));
		db::update('products_review', "RId='$RId'", array('IsRead'=>1));
		$products_row=str::str_code(db::get_one('products', "ProId='{$review_row['ProId']}'"));
		$email=urlencode($review_row['Email'].'/'.$review_row['Name']);
		?>
		<div class="inquiry-w1200 clean inquiry-row">
			<a href="javascript:history.back(-1);" class="return_title grey">
				<span class="return">{/module.inquiry.review/}</span>
			</a>
			<form id="review_form" name="review_form">
				<div class="left_container">
					<div class="left_container_side">
						<div class="global_container">
							<div class="rows">
								<label>{/inquiry.product/}</label>
								<span class="input"><a href="<?=web::get_url($products_row, 'products');?>" target="_blank"><?=$products_row['Name'.$c['lang']];?></a></span>
								<div class="clear"></div>
							</div>
							<div class="rows">
								<label>{/global.name/}</label>
								<span class="input"><?=$review_row['Name'];?></span>
								<div class="clear"></div>
							</div>
							<div class="rows">
								<label>{/global.email/}</label>
								<span class="input"><?=$review_row['Email'];?><a href="./?m=email&a=send&Email=<?=$email;?>" class="icon_mail" target="_blank">{/inquiry.send_email/}</a></span>
								<div class="clear"></div>
							</div>
							<div class="rows">
								<label>{/global.title/}</label>
								<span class="input"><?=$review_row['Subject'];?></span>
								<div class="clear"></div>
							</div>
							<div class="rows">
								<label>{/global.contents/}</label>
								<span class="input"><?=$review_row['Content'];?></span>
								<div class="clear"></div>
							</div>
							<div class="rows">
								<label>{/inquiry.display/}</label>
								<span class="input">
									<div class="switchery<?=$review_row['Display']?' checked':'';?>">
										<input type="checkbox" name="Display" value="1"<?=$review_row['Display']?' checked':'';?>>
										<div class="switchery_toggler"></div>
										<div class="switchery_inner">
											<div class="switchery_state_on"></div>
											<div class="switchery_state_off"></div>
										</div>
									</div>
								</span>
								<div class="clear"></div>
							</div>
							<div class="rows clean">
								<div class="input">
									<input type="submit" class="btn_global btn_submit" name="submit_button" value="{/global.save/}" />
									<a href="javascript:history.back(-1);"><input type="button" class="btn_global btn_cancel" value="{/global.return/}"></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="right_container">
					<div class="global_container">
						<div class="pro-row">
							<?php
								$url=web::get_url($products_row, 'products');
								$pic = img::get_small_img($products_row['PicPath_0'], '240x240');
								$name = $products_row['Name'.$c['lang']];
							?>
							<div class="plist clean">
								<?php if($pic){?>
								<div class="img pic_box fl"><a href="<?=$url;?>" target="_blank"><img src="<?=$pic;?>" /><em></em></a></div>
								<?php }?>
								<?php if($name){?>
								<div class="name fl">
									<a href="<?=$url;?>" target="_blank"><?=$name;?></a>
								</div>
								<?php }?>
							</div>
						</div>
						<div class="oth">
							<div class="rows clean">
								<label>{/global.ip/}</label>
								<span class="input pic_box">
									<img src="/static/manage/images/inquiry/source_<?=(int)$review_row['Source'];?>.png" alt="">
									<?=$review_row['Ip'].'<br /><br /> 【'.ly200::ip($review_row['Ip']).'】';?>
								</span>
							</div>
							<div class="rows">
								<label>{/global.time/}</label>
								<span class="input"><?=date('Y/m/d H:i:s', $review_row['AccTime']);?></span>
								<div class="clear"></div>
							</div>
						</div>
					</div>
				</div>
				<input type="hidden" id="RId" name="RId" value="<?=$RId;?>" />
				<input type="hidden" name="ProId" value="<?=$review_row['ProId'];?>" />
				<input type="hidden" name="do_action" value="inquiry.review_edit" />
				<input type="hidden" id="back_action" name="back_action" value="<?=$_SERVER['HTTP_REFERER'];?>" />
			</form>
			<div class="clear"></div>
		</div>
	<?php }?>
</div>