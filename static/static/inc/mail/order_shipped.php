<?php
!isset($orders_row) && $orders_row=db::get_one('orders', "OId='$OId'");
$isFee=($orders_row['OrderStatus']>=4 && $orders_row['OrderStatus']!=7)?1:0;
$total_price=orders::orders_price($orders_row, $isFee);

ob_start();
?>
<div style="width:700px; margin:10px auto;">
	<?php include('inc/header.php');?>
	<div style="font-family:Arial; padding:15px 0; line-height:150%; min-height:100px; _height:100px; color:#333; font-size:12px;">
		Dear <strong><?=htmlspecialchars($orders_row['ShippingFirstName'].' '.$orders_row['ShippingLastName']);?></strong>:<br /><br />

        This is an automated email from <a href="<?=ly200::get_domain();?>" target="_blank" style="color:#1E5494; text-decoration:underline; font-family:Arial; font-size:12px;"><?=ly200::get_domain(0);?></a>. Please do not reply to this email.<br /><br />
        
        Your order#<a href="<?=ly200::get_domain();?>/account/orders/view<?=$orders_row['OId'];?>.html" target="_blank" style="color:#1E5494; text-decoration:underline; font-family:Arial; font-size:12px;"><?=$orders_row['OId'];?></a> has shipped!<br /><br />
        
        <?php include('order_detail.php');?>
        
        Yours sincerely,<br /><br />
        
        <?=ly200::get_domain(0);?> Customer Care Team
	</div>
	<?php include('inc/footer.php');?>
</div>
<?php
$mail_contents=ob_get_contents();
ob_end_clean();
?>