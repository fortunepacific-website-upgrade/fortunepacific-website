<?php
$shipping_cfg=(int)$orders_row['ShippingMethodSId']?db::get_one('shipping', "SId='{$orders_row['ShippingMethodSId']}'"):db::get_one('shipping_config', "Id='1'");
$shipping_row=db::get_one('shipping_area', "AId in(select AId from shipping_country where CId='{$orders_row['ShippingCId']}' and  SId='{$orders_row['ShippingMethodSId']}' and type='{$orders_row['ShippingMethodType']}')");
$total_price=orders::orders_price($orders_row, $isFee);
$isFee && $HandingFee=$total_price-orders::orders_price($orders_row);
?>

<a href="<?=ly200::get_domain().$member_url;?>/account/orders/view<?=$orders_row['OId'];?>.html" target="_blank" style="color:#1E5494; text-decoration:underline; font-family:Arial; font-size:12px;">Check the Order Details here.</a><br /><br />

<div style="border:1px solid #ddd; background:#f7f7f7; border-bottom:none; width:130px; height:26px; line-height:26px; text-align:center; font-size:12px; font-family:Arial;"><strong>Order Details</strong></div>
<div style="border:1px solid #ddd; padding:10px; font-size:12px; font-family:Arial;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="110" style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">Order Number:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=$orders_row['OId'];?></td>
	  </tr>
	  <tr>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">Order DT:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=date('d/m-Y H:i:s', $orders_row['OrderTime']);?></td>
	  </tr>
	  <tr>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">Order Status:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=$c['orders']['status'][$orders_row['OrderStatus']];?></td>
	  </tr>
	  <tr>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">Payment Method:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=$orders_row['PaymentMethod'];?></td>
	  </tr>
	  <tr>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">Shipping Method:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=(int)$orders_row['ShippingMethodSId']?$shipping_cfg['Express']:($orders_row['ShippingMethodType']=='air'?$shipping_cfg['AirName']:$shipping_cfg['OceanName']);?> (<?=$shipping_row['Brief'];?>)</td>
	  </tr>
	  <?php if($orders_row['OrderStatus']==5 || $orders_row['OrderStatus']==6){?>
		  <tr>
			<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">Tracking Number:</td>
			<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=$orders_row['TrackingNumber'];?> (<?=date('m/d-Y', $orders_row['ShippingTime']);?>)</td>
		  </tr>
	  <?php }?>
	  <tr>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">Item Costs:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><em><?=$orders_row['Currency'];?></em><?=cart::iconv_price($orders_row['ProductPrice'], 0, $orders_row['Currency']);?></td>
	  </tr>
	  <?php if($orders_row['Discount']>0){?>
		  <tr>
			<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">Discount:</td>
			<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=$orders_row['Discount']*100;?>%</td>
		  </tr>
		  <tr>
			<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">Save:</td>
			<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><?=cart::iconv_price($orders_row['Discount']*$orders_row['TotalPrice']);?></td>
		  </tr>
	  <?php }?>
	  <tr>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">Shipping Charges<br> &amp; Insurance:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><em><?=$orders_row['Currency'];?></em><?=cart::iconv_price($orders_row['ShippingPrice']+$orders_row['ShippingInsurancePrice'], 0, $orders_row['Currency']);?></td>
	  </tr>
	  <tr>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">Handing Fee:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><em><?=$orders_row['Currency'];?></em><?=cart::iconv_price($HandingFee, 0, $orders_row['Currency']);?></td>
	  </tr>
      <?php
	  if($orders_row['CouponCode'] && ($orders_row['CouponPrice']>0 || $orders_row['CouponDiscount']>0)){
		  $discountPrice=$orders_row['CouponPrice']>0?$orders_row['CouponPrice']:$orders_row['ProductPrice']*$orders_row['CouponDiscount'];
	  ?>
	  <tr>
		  <th>(-) Coupon Savings:<em><?=$orders_row['Currency'];?></em></th>
		  <td><?=cart::iconv_price($discountPrice, 0, $orders_row['Currency']);?></td>
	  </tr>
      <tr>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">(-) Coupon Savings::</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><em><?=$orders_row['Currency'];?></em><?=cart::iconv_price($discountPrice, 0, $orders_row['Currency']);?></td>
	  </tr>
	  <?php }?>
	  <tr>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;">Grand Total:</td>
		<td style="padding:7px; border-bottom:1px solid #ddd; font-size:12px; font-family:Arial;"><em><?=$orders_row['Currency'];?></em><?=cart::iconv_price($total_price, 0, $orders_row['Currency']);?></td>
	  </tr>
	</table>
	<div style="margin:0px auto; clear:both; height:20px; font-size:1px; overflow:hidden;"></div>
	<div style="clear:both; zoom:1;">
		<div style="width:45%; float:left;">
			<div style="font-weight:bold; height:22px; line-height:22px; font-size:12px; font-family:Arial;">Your Shipping Address:</div>
			<div style="border:1px solid #ddd; background:#fdfdfd; padding:8px; line-height:160%; min-height:78px; font-size:12px; font-family:Arial; font-size:12px;">
				<strong><?=$orders_row['ShippingFirstName'].' '.$orders_row['ShippingLastName'];?></strong> (<?=$orders_row['ShippingAddressLine1'].', '.$orders_row['ShippingCity'].', '.$orders_row['ShippingZipCode'].' - '.$orders_row['ShippingState'].', '.$orders_row['ShippingCountry'];?>)<br>
                Phone:<?=$orders_row['ShippingCountryCode'].' '.$orders_row['ShippingPhoneNumber'];?>
			</div>
		</div>
		<div style="width:45%; float:left; margin-left:10px;">
			<div style="font-weight:bold; height:22px; line-height:22px; font-size:12px; font-family:Arial;">Your Billing Address:</div>
			<div style="border:1px solid #ddd; background:#fdfdfd; padding:8px; line-height:160%; min-height:78px; font-size:12px; font-family:Arial; font-size:12px;">
				<strong><?=$orders_row['BillFirstName'].' '.$orders_row['BillLastName'];?></strong> (<?=$orders_row['BillAddressLine1'].', '.$orders_row['BillCity'].', '.$orders_row['BillZipCode'].' - '.$orders_row['BillState'].', '.$orders_row['BillCountry'];?>)<br>
                Phone:<?=$orders_row['BillCountryCode'].' '.$orders_row['BillPhoneNumber'];?>
			</div>
		</div>
		<div style="margin:0px auto; clear:both; height:0px; font-size:0px; overflow:hidden;"></div>
	</div>
	<div style="margin:0px auto; clear:both; height:20px; font-size:1px; overflow:hidden;"></div>
	<div style="border-bottom:2px solid #ddd; height:24px; line-height:24px; font-weight:bold; font-family:Arial; font-size:12px;">Shipping Method:</div>
	<div style="line-height:150%; margin-top:5px; font-family:Arial;"><?=(int)$orders_row['ShippingMethodSId']?$shipping_cfg['Express']:($orders_row['ShippingMethodType']=='air'?$shipping_cfg['AirName']:$shipping_cfg['OceanName']);?> (<?=$shipping_row['Brief'];?>)<br>Shipping Charges &amp; Insurance: <em><?=$orders_row['Currency'];?></em><?=cart::iconv_price($orders_row['ShippingPrice']+$orders_row['ShippingInsurancePrice'], 0, $orders_row['Currency']);?></div>
	<div style="margin:0px auto; clear:both; height:20px; font-size:1px; overflow:hidden;"></div>
	<div style="border-bottom:2px solid #ddd; height:24px; line-height:24px; font-weight:bold; font-family:Arial; font-size:12px;">Special Instructions or Comments:</div>
	<div style="line-height:180%; font-family:Arial; font-size:12px;"><?=str::format($orders_row['Comments']);?></div>
	<div style="margin:0px auto; clear:both; height:20px; font-size:1px; overflow:hidden;"></div>
	<div style="border-bottom:2px solid #ddd; height:24px; line-height:24px; font-weight:bold; font-family:Arial; font-size:12px;">Order Items:</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #ddd; margin:8px 0;">
		<tr>
			<td width="14%" style="border-right:1px solid #ddd; height:28px; font-weight:bold; text-align:center; background:#e1e1e1; font-family:Arial; font-size:12px;">Pictures</td>
			<td width="50%" style="border-right:1px solid #ddd; height:28px; font-weight:bold; text-align:center; background:#e1e1e1; font-family:Arial; font-size:12px;">Product</td>
			<td width="12%" style="border-right:1px solid #ddd; height:28px; font-weight:bold; text-align:center; background:#e1e1e1; font-family:Arial; font-size:12px;">Price</td>
			<td width="12%" style="border-right:1px solid #ddd; height:28px; font-weight:bold; text-align:center; background:#e1e1e1; font-family:Arial; font-size:12px;">Quantity</td>
			<td width="12%" style="border-right:1px solid #ddd; height:28px; font-weight:bold; text-align:center; background:#e1e1e1; font-family:Arial; font-size:12px; border-right:none;">Total</td>
		</tr>
		<?php
		$subtotal=0;
		$order_list_row=db::get_all('orders_products_list o left join products p on o.ProId=p.ProId', "o.OrderId='{$orders_row['OrderId']}'", 'o.*,p.PicPath_0', 'o.LId asc');
		foreach((array)$order_list_row as $v){
			$v['Name'.$c['lang']]=$v['Name'];
			$attr=str::json_data($v['Property'], 'decode');
			$url=ly200::get_url($v, 'products');
			$name=$v['Name'];
			$subtotal+=$v['Qty'];
		?>
		<tr align="center">
			<td valign="top" style="padding:7px 5px; border-top:1px solid #ddd;"><table width="92" border="0" cellpadding="0" cellspacing="0" align="center"><tr><td height="92" align="center" style="border:1px solid #ccc; padding:0; background:#fff;"><a href="<?=ly200::get_domain().$url;?>" title="<?=$name;?>" target="_blank"><img src="<?=ly200::get_domain().$v['PicPath'];?>" width="100" alt="<?=$name;?>" /></a></td></tr></table></td>
			<td align="left" style="line-height:150%; font-size:12px; font-family:Arial; padding:7px 5px; border-top:1px solid #ddd;">
				<a href="<?=ly200::get_domain().$url;?>" title="<?=$name;?>" target="_blank" style="color:#1E5494; text-decoration:underline; font-family:Arial; font-size:12px;"><?=$name;?></a><br />
				<?php foreach((array)$attr as $k=>$v2){?>
                    <div><?=$k.': '.$v2;?></div>
                <?php }?>
			</td>
			<td style="font-family:Arial; font-size:12px; padding:7px 5px; border-top:1px solid #ddd;"><?=cart::iconv_price($v['Price'], 0, $orders_row['Currency']);?></td>
			<td style="font-family:Arial; font-size:12px; padding:7px 5px; border-top:1px solid #ddd;"><?=$v['Qty'];?></td>
			<td style="font-family:Arial; font-size:12px; padding:7px 5px; border-top:1px solid #ddd;"><?=cart::iconv_price($v['Price']*$v['Qty'], 0, $orders_row['Currency']);?></td>
		</tr>
		<?php }?>
		<tr>
			<td colspan="3" style="height:26px; background:#efefef; text-align:center; color:#B50C08; font-size:12px; font-weight:bold; font-family:Arial;">&nbsp;</td>
			<td style="height:26px; background:#efefef; text-align:center; color:#B50C08; font-size:12px; font-weight:bold; font-family:Arial;"><?=$subtotal;?></td>
			<td style="height:26px; background:#efefef; text-align:center; color:#B50C08; font-size:12px; font-weight:bold; font-family:Arial;"><?=cart::iconv_price($orders_row['ProductPrice'], 0, $orders_row['Currency']);?></td>
		</tr>
	</table>
</div><br /><br />