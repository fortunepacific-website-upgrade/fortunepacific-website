<?php !isset($c) && exit();?>
<?php
if($c['config']['global']['IsReview']){
	$page=(int)$_GET['page'];
    $review_where = "ProId='$products_row[ProId]'";
    $c['config']['global']['IsReviewDisplay'] && $review_where.=' and Display=1';
	$products_review=str::str_code(db::get_limit_page('products_review', $review_where, '*','AccTime desc', $page, 5));
	(!$page || $page>$products_review[3]) && $page=1;
?>
<div id="review_list">
	<?php 
		foreach((array)$products_review[0] as $v){
			$m = db::get_one('user',"UserId='$v[UserId]'","Email,NickName,FirstName");
			$n = $v['Name'] ? $v['Name'] : 'Website visitors';
            if($m['NickName']||$m['FirstName']){
                 $n = $m['NickName'] ? $m['NickName'] : ($m['FirstName'] ? $m['FirstName'] : 'Website visitors');
            }
	?>
    <div class="r">
    	<div class="date">
        	<div class="n">
            	<font color="#000000">by</font>
                <font color="#ef4135"><?=$n;?></font>
            </div>
            <div class="d">
            	<font color="#000000"><?=date('M',$v['AccTime']).' '.date('d',$v['AccTime']).','.date('Y',$v['AccTime']);?></font>
            </div>
        </div>
        <div class="text">
        	<div class="n"><?=$v['Subject'];?></div>
            <div class="d"><?=$v['Content'];?></div>
        </div>
    </div>
    <?php }?>
</div>
<?php $member = db::get_one('user',"UserId='".(int)$_SESSION['ly200_user']['UserId']."'");?>
<div id="lib_review_form">
	<h1><div><?=$c['lang_pack']['review']['review_title'];?></div></h1>
    <div class="clear"></div>
	<form method="post" name="review">	
    	<label><?=$c['lang_pack']['review']['name']?></label>
        <span><input type="text" class="input" size="70" name="Name" notnull value="<?=$member['NickName'];?>" /></span>
    	<div class="blank25"></div>
        <label><?=$c['lang_pack']['email']?></label>
        <span><input type="text" class="input" size="70" name="Email" notnull format="Email" value="<?=$member['Email'];?>" /></span>
    	<div class="blank25"></div>
        <label><?=$c['lang_pack']['review']['subject']?></label>
        <span><input type="text" class="input" size="70" name="Subject" notnull value="<?=$products_row['Name'.trim($c['lang'],'_')];?>" /></span>
    	<div class="blank25"></div>
        <label><?=$c['lang_pack']['review']['message']?></label>
        <span><textarea rows="10" cols="100" name="Content" notnull></textarea></span>
    	<div class="blank25"></div>
        <label><?=$c['lang_pack']['review']['vcode']?></label>
        <span><input name="VCode" type="text" class="input vcode" size="15" maxlength="4" notnull /><br /><?=v_code::create('review');?></span>
        
		<div class="rows">
			<label></label>
			<span><input name="Submit" type="submit" class="form_button" value="<?=$c['lang_pack']['review']['submit']?>" /></span>
			<div class="clear"></div>
		</div>
		<input type="hidden" name="Site" value="<?=trim(trim($c['lang'],'_'),'_');?>" />
        <input type="hidden" name="ProId" value="<?=$ProId;?>" />
        <input type="hidden" name="UserId" value="<?=(int)$_SESSION['ly200_user']['UserId'];?>" />
	</form>
</div>
<?php }?>