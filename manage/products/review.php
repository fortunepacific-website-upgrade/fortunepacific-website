<?php
$d_ary=array('list','edit');
$d=$_GET['d'];
!in_array($d, $d_ary) && $d=$d_ary[0];
//$language_default='_'.$c['manage']['language_default'];
$review_cfg=str::json_data(db::get_value('config', "GroupId='products' and Variable='review'", 'Value'), 'decode');
?>
<script type="text/javascript">$(document).ready(function(){products_obj.global_init();});</script>
<div class="r_nav products_nav">
	<h1>{/module.products.review/}</h1>
    <?php
	if($d=='list'){
		//产品列表
		$Name=str::str_code($_GET['Name']);
		
		$where='1';//条件
		$page_count=10;//显示数量
		$Name && $where.=" and p.ProId in(select ProId from products where Name{$c['lang']} like '%$Name%')";
		$review_row=str::str_code(db::get_limit_page('products_review p', $where, '*', 'p.RId desc', (int)$_GET['page'], $page_count));
	?>
    <div class="list_nav fr">
        <ul class="panel fl">
            <li class="page_last"><a class="panel_3 del_bat" href="javascript:void(0);" title="{/global.del_bat/}"></a></li>
        </ul>
        <div id="turn_page_oth" class="turn_page fl"><?=manage::turn_page($review_row[1], $review_row[2], $review_row[3], '?'.ly200::query_string('page').'&page=', '{/global.pre_page/}', '{/global.next_page/}');?></div>
    </div>
    <div class="search fr">
        <form id="search_form">
            {/products.product/}{/products.name/}: <input type="text" name="Name" value="" class="form_input" size="30" />
            <input type="submit" class="sub_btn" value="{/global.search/}" />
        </form>
    </div>
    <?php }?>
</div>
<div id="products" class="r_con_wrap">
	<?php
	if($d=='list'){
		//产品列表
		$Name=str::str_code($_GET['Name']);
		
		$where='1';//条件
		$page_count=10;//显示数量
		$Name && $where.=" and p.ProId in(select ProId from products where Name{$c['lang']} like '%$Name%')";
		$review_row=str::str_code(db::get_limit_page('products_review p', $where, '*', 'p.RId desc', (int)$_GET['page'], $page_count));
	?>
	<table border="0" cellpadding="5" cellspacing="0" class="r_con_table">
		<thead>
			<tr>
				<td width="4%"><input type="checkbox" name="select_all" value="" class="va_m" /></td>
				<td width="20%" nowrap="nowrap">{/products.product/}{/products.name/}</td>
                <td width="10%" nowrap="nowrap">{/global.email/}</td>
				<td width="10%" nowrap="nowrap">{/products.review.ip/}</td>
				<?php if($c['config']['global']['IsReviewDisplay']){ ?>
                	<td width="10%" nowrap="nowrap">{/products.review.display/}</td>
                <?php } ?>
				<td width="10%" nowrap="nowrap">{/products.review.time/}</td>
				<td width="8%" class="last" nowrap="nowrap">{/global.operation/}</td>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=1;
			foreach($review_row[0] as $v){
				$products_row=str::str_code(db::get_one('products', "ProId='{$v['ProId']}'"));
				$rid=$v['RId'];
			?>
			<tr>
				<td><input type="checkbox" name="select" value="<?=$rid;?>" class="va_m sel" /></td>
				<td><a href="<?=ly200::get_url($products_row, 'products');?>" target="_blank"><?=$products_row['Name'.$c['lang']];?></a></td>
                 <td><a href="./?m=email&a=send&Email=<?=urlencode($v['Email'].'/'.$v['Name']);?>" title="{/module.email.send/}" class="blue"><?=$v['Email'];?></a></td>
				<td><?=$v['Ip'];?></td>
				<?php if($c['config']['global']['IsReviewDisplay']){ ?>
                	<td>{/global.n_y.<?=$v['Display'];?>/}</td>
                <?php } ?>
				<td><?=date('Y/m/d H:i:s', $v['AccTime']);?></td>
				<td class="last">
					<a href="./?m=products&a=review&d=edit&RId=<?=$rid;?>" title="{/global.view/}"><img src="/static/images/ico/search.png" alt="{/global.view/}" align="absmiddle" /></a>
					<a href="./?do_action=products.review_del&RId=<?=$rid;?>" title="{/global.del/}" class="del" rel="del"><img src="/static/images/ico/del.png" alt="{/global.del/}" align="absmiddle" /></a>
				</td>
			</tr>
			<?php }?>
		</tbody>
	</table>
	<input type="hidden" name="Type" value="review" />
	<div class="blank20"></div>
	<div id="turn_page_oth"><?=manage::turn_page($review_row[1], $review_row[2], $review_row[3], '?'.ly200::query_string('page').'&page=', '{/global.pre_page/}', '{/global.next_page/}');?></div>
	<div class="blank20"></div>
	<?php
		//销毁变量
		unset($review_row, $products_row);
	}else{
		$RId=(int)$_GET['RId'];
		$review_row=str::str_code(db::get_one('products_review', "RId='$RId'"));
		$products_row=str::str_code(db::get_one('products', "ProId='{$review_row['ProId']}'"));
		$rating_ary=explode(',', $review_row['Assess']);
	?>
    <script type="text/javascript">$(document).ready(function(){products_obj.review_edit();});</script>
	<div class="edit_bd list_box">
		<form id="products_form" name="review_form" class="r_con_form">
			<div class="rows_box">
				<h3 class="rows_hd">{/products.product/}{/products.review_name/}</h3>
				<div class="rows">
					<label>{/products.product/}{/products.name/}:</label>
					<span class="input"><a href="<?=ly200::get_url($products_row, 'products');?>" target="_blank"><?=$products_row['Name'.$c['lang']];?></a></span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/products.review.name/}:</label>
					<span class="input"><?=$review_row['Name'];?></span>
					<div class="clear"></div>
				</div>
                <div class="rows">
					<label>{/global.email/}:</label>
					<span class="input"><a href="./?m=email&a=send&Email=<?=urlencode($review_row['Email'].'/'.$review_row['Name']);?>" title="{/module.email.send/}" class="blue"><?=$review_row['Email'];?></a></span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/products.review.subject/}:</label>
					<span class="input"><?=$review_row['Subject'];?></span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/module.content.module_name/}:</label>
					<span class="input"><?=$review_row['Content'];?></span>
					<div class="clear"></div>
				</div>
				<?php if($c['config']['global']['IsReviewDisplay']){ ?>
	                <div class="rows">
						<label>{/products.review.display/}:</label>
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
				<?php } ?>
				<div class="rows">
					<label>{/products.review.ip/}:</label>
					<span class="input"><?=$review_row['Ip'].' 【'.ly200::ip($review_row['Ip']).'】';?></span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/products.review.time/}:</label>
					<span class="input"><?=date('Y/m/d H:i:s', $review_row['AccTime']);?></span>
					<div class="clear"></div>
				</div>
				
				
				<div class="rows">
					<label></label>
					<span class="input">
						<input type="submit" class="btn_ok submit_btn" name="submit_button" value="{/global.submit/}" />
						<a href="./?m=products&a=review" class="btn_cancel">{/global.return/}</a>
					</span>
					<div class="clear"></div>
				</div>
			</div>
			<input type="hidden" id="RId" name="RId" value="<?=$RId;?>" />
			<input type="hidden" name="ProId" value="<?=$review_row['ProId'];?>" />
			<input type="hidden" name="do_action" value="products.review_edit" />
		</form>
        
	</div>
	<?php
		//销毁变量
		unset($review_row, $products_row);
	}?>
</div>