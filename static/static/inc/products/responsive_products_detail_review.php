<?php !isset($c) && exit();?>
<?php
if($c['config']['global']['IsReview']){
	$page=(int)$_GET['page'];
    $review_where="ProId='{$products_row['ProId']}'";
    $c['config']['global']['IsReviewDisplay'] && $review_where.=' and Display=1';
	$products_review=str::str_code(db::get_limit_page('products_review', $review_where, '*','AccTime desc', $page, 5));
	(!$page || $page>$products_review[3]) && $page=1;
	(int)$_SESSION['ly200_user']['UserId'] && $member_row=str::str_code(db::get_one('user',"UserId='{$_SESSION['ly200_user']['UserId']}'"));
?>
	<div class="ueeshop_responsive_products_detail_review <?=$c['themes_products_detail']['review']['style'];?>">
		<div class="review_form">
			<h1><?=$c['lang_pack']['review']['review_title'];?></h1>
			<form method="post" name="review">	
				<div class="rows input_rows">
					<label><span>*</span> <?=$c['lang_pack']['review']['name']?></label>
					<span><input type="text" class="input" size="70" name="Name" notnull value="<?=$member_row['NickName'];?>" /></span>
				</div>
				<div class="rows input_rows">
					<label><span>*</span> <?=$c['lang_pack']['email']?></label>
					<span><input type="text" class="input" size="70" name="Email" notnull format="Email" value="<?=$member_row['Email'];?>" /></span>
				</div>
				<div class="rows input_rows">
					<label><span>*</span> <?=$c['lang_pack']['review']['subject']?></label>
					<span><input type="text" class="input" size="70" name="Subject" notnull value="<?=$products_row['Name'.trim($c['lang'],'_')];?>" /></span>
				</div>
				<div class="rows textarea_rows">
					<label><span>*</span> <?=$c['lang_pack']['review']['message']?></label>
					<span><textarea name="Content" notnull></textarea></span>
				</div>
				<div class="rows">
					<label><span>*</span> <?=$c['lang_pack']['review']['vcode']?></label>
					<span class="vcode">
						<div class="fl"><input name="VCode" type="text" class="input" size="15" maxlength="4" notnull /></div>
						<div class="fl"><?=v_code::create('review');?></div>
						<div class="clear"></div>
					</span>
				</div>
				<div class="rows">
					<span><input name="Submit" type="submit" class="form_button" value="<?=$c['lang_pack']['review']['submit']?>" /></span>
				</div>
				<input type="hidden" name="Site" value="<?=trim(trim($c['lang'],'_'),'_');?>" />
				<input type="hidden" name="ProId" value="<?=$products_row['ProId'];?>" />
				<input type="hidden" name="UserId" value="<?=(int)$_SESSION['ly200_user']['UserId'];?>" />
			</form>
		</div>
		<div class="review_list">
			<?php 
			foreach((array)$products_review[0] as $v){
				$m=str::str_code(db::get_one('user', "UserId='{$v['UserId']}'", 'Email,NickName,FirstName'));
				$n=$v['Name']?$v['Name']:'Website visitors';
				($m['NickName'] || $m['FirstName']) &&  $n=$m['NickName']?$m['NickName']:($m['FirstName']?$m['FirstName']:'Website visitors');
			?>
				<div class="item">
					<div class="name"><?=$n;?></div>
					<div class="time"><?=date('M d, Y', $v['AccTime']);?></div>
					<div class="contents"><?=$v['Content'];?></div>
				</div>
			<?php }?>
		</div>
	</div>
<?php }?>