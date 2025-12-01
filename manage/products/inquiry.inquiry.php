<?php
$d_ary=array('list','edit');
$d=$_GET['d'];
!in_array($d, $d_ary) && $d=$d_ary[0];
//$language_default='_'.$c['manage']['language_default'];
?>
<script type="text/javascript">
$(document).ready(function(){
	products_obj.global_init();
});
</script>
<div class="r_nav products_nav">
	<h1>{/global.all/}{/products.inquiry_name/}</h1>
    <?php
	if($d=='list'){
		//产品列表
		$Name=str::str_code($_GET['Name']);
		
		$where='1';//条件
		$page_count=20;//显示数量
		$Name && $where.=" and ProId in(select ProId from products where Name{$c['lang']} like '%$Name%')";
		$inquiry_row=str::str_code(db::get_limit_page('products_inquiry', $where, '*', 'IId desc', (int)$_GET['page'], $page_count));
	?>
    <div class="list_nav fr">
        <ul class="panel fl">
            <li><a class="panel_2 explode_bat" href="javascript:void(0);" title="{/global.explode/}"></a></li>
            <li><a class="panel_3 del_bat" href="javascript:void(0);" title="{/global.del_bat/}"></a></li>
        </ul>
        <div id="turn_page_oth" class="turn_page fl"><?=manage::turn_page($inquiry_row[1], $inquiry_row[2], $inquiry_row[3], '?'.ly200::query_string('page').'&page=', '{/global.pre_page/}', '{/global.next_page/}');?></div>
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
	?>
    <form action="?" name="products_explode" method="get">
    <input type="hidden" name="do_action" value="products.inquiry_explode" />
	<table border="0" cellpadding="5" cellspacing="0" class="r_con_table">
		<thead>
			<tr>
				<td width="4%"><input type="checkbox" name="select_all" value="" class="va_m" /></td>
				<td width="16%" nowrap="nowrap">{/products.inquiry.title/}</td>
				<td width="12%" nowrap="nowrap">{/products.inquiry.customer_name/}</td>
				<td width="15%" nowrap="nowrap">{/global.email/}</td>
				<td width="10%" nowrap="nowrap">{/products.inquiry.tel/}</td>
				<td width="15%" nowrap="nowrap">{/set.country.country/}</td>
				<td width="10%" nowrap="nowrap">{/manage.log.ip/}</td>
				<td width="10%" nowrap="nowrap">{/global.time/}</td>
				<td width="8%" class="last" nowrap="nowrap">{/global.operation/}</td>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach($inquiry_row[0] as $v){
				$iid=$v['IId'];
			?>
			<tr class="<?=(int)$v['IsRead']?'':'fc_red';?>">
				<td><input type="checkbox" name="select[]" value="<?=$iid;?>" class="va_m sel" /></td>
				<td><?=$v['Subject'];?></td>
				<td><?=$v['FirstName'].' '.$v['LastName'];?></td>
				<td><a href="./?m=email&a=send&Email=<?=urlencode($v['Email'].'/'.$v['FirstName'].' '.$v['LastName']);?>" title="{/module.email.send/}" class="blue"><?=$v['Email'];?></a></td>
				<td><?=$v['Phone'];?></td>
				<td><?=$v['Country'];?></td>
				<td><?=$v['Ip'];?></td>
				<td><?=date('Y/m/d H:i:s', $v['AccTime']);?></td>
				<td class="last">
					<a href="./?m=products&a=inquiry.inquiry&d=edit&IId=<?=$iid;?>" title="{/global.view/}"><img src="/static/images/ico/search.png" alt="{/global.view/}" align="absmiddle" /></a>
					<a href="./?do_action=products.inquiry_del&IId=<?=$iid;?>" title="{/global.del/}" class="del" rel="del"><img src="/static/images/ico/del.png" alt="{/global.del/}" align="absmiddle" /></a>
				</td>
			</tr>
			<?php }?>
		</tbody>
	</table>
    </form>
	<input type="hidden" name="Type" value="inquiry" />
	<div class="blank20"></div>
	<div id="turn_page_oth"><?=manage::turn_page($inquiry_row[1], $inquiry_row[2], $inquiry_row[3], '?'.ly200::query_string('page').'&page=', '{/global.pre_page/}', '{/global.next_page/}');?></div>
	<div class="blank20"></div>
	<?php
		//销毁变量
		unset($inquiry_row, $products_row);
	}else{
		$IId=(int)$_GET['IId'];
		$inquiry_row=str::str_code(db::get_one('products_inquiry', "IId='$IId'"));
		!$inquiry_row && js::location('./m=products&a=inquiry.inquiry');
		
		db::update('products_inquiry', "IId='$IId'", array('IsRead'=>1));
		$ProId=trim((!$inquiry_row['ProId']?0:$inquiry_row['ProId']),',');
		$products_row=str::str_code(db::get_all('products', "ProId in(0,{$ProId},0)"));
		$email=urlencode($inquiry_row['Email'].'/'.$inquiry_row['FirstName'].' '.$inquiry_row['LastName']);
	?>
	<div class="edit_bd list_box">
		<form id="inquiry_form" name="inquiry_form" class="r_con_form">
			<div class="rows_box">
				<h3 class="rows_hd">{/products.product/}{/products.inquiry_name/}</h3>
				<div class="rows">
					<label>{/products.product/}{/products.name/}:</label>
					<span class="input">
                    	<?php 
						foreach($products_row as $v){
							$url=ly200::get_url($v, 'products');
						?>
                        	<div class="plist">
                            	<div class="img pic_box"><a href="<?=$url;?>" target="_blank"><img src="<?=ly200::get_size_img($v['PicPath_0'], '240x240');?>" /><em></em></a></div>
                                <div class="name">
                                	<a href="<?=$url;?>" target="_blank"><?=$v['Name'.$c['lang']];?></a><br />
                                    {/products.products.number/}: <?=$v['Number'];?>
                                </div>
                            </div>
                        <?php }?>
                    </span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/products.inquiry.title/}:</label>
					<span class="input"><?=$inquiry_row['Subject'];?></span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/products.inquiry.customer_name/}:</label>
					<span class="input"><?=$inquiry_row['FirstName'].' '.$inquiry_row['LastName'];?></span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/products.inquiry.mail/}:</label>
					<span class="input"><?=$inquiry_row['Email'];?><a href="./?m=email&a=send&Email=<?=$email;?>" class="blue mar_l_10" target="_blank">{/products.inquiry.mail_reply/}</a></span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/products.inquiry.tel/}:</label>
					<span class="input"><?=$inquiry_row['Phone'];?></span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/products.inquiry.fax/}:</label>
					<span class="input"><?=$inquiry_row['Fax'];?></span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/set.country.country/}:</label>
					<span class="input"><?=$inquiry_row['City'].', '.$inquiry_row['State'].', '.$inquiry_row['Country'];?></span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/products.inquiry.address/}:</label>
					<span class="input"><?=$inquiry_row['Address'];?></span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/products.inquiry.postcode/}:</label>
					<span class="input"><?=$inquiry_row['PostalCode'];?></span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/manage.log.ip/}:</label>
					<span class="input"><?=$inquiry_row['Ip'].' 【'.ly200::ip($inquiry_row['Ip']).'】';?></span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/global.time/}:</label>
					<span class="input"><?=date('Y/m/d H:i:s', $inquiry_row['AccTime']);?></span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label>{/products.inquiry.content/}:</label>
					<span class="input"><?=str::format($inquiry_row['Message']);?></span>
					<div class="clear"></div>
				</div>
				
				<div class="rows">
					<label></label>
					<span class="input"><a href="./?m=products&a=inquiry.inquiry" class="btn_cancel">{/global.return/}</a></span>
					<div class="clear"></div>
				</div>
			</div>
		</form>
        
	</div>
	<?php
		//销毁变量
		unset($inquiry_row, $products_row);
	}?>
</div>