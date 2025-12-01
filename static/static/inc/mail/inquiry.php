<?php !isset($c) && exit();?>
<?php
	$domain = web::get_domain();
	$theme = $c['themes'];
	//$banner = db::get_one('ad',"Themes='$theme'",'*','AId asc');
	$inquiry_row=str::str_code(db::get_one('products_inquiry', "IId='$iid'"));
	$ProId=$inquiry_row['ProId'];
	$products_row=str::str_code(db::get_all('products', "ProId in(0,{$ProId},0)"));
	$Num=count(explode(',',$ProId));
	ob_start();
?>
<table width="650" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td width="" height="75"><a target="_blank" href="<?=$domain;?>"><img style="vertical-align:middle; max-height:50px;" src="<?=$domain.$c['config']['global']['LogoPath'];?>" /><span style="height:100%; display:inline-block; vertical-align:middle;"></span></a></td>
        <td style="text-align:right;"><a target="_blank" href="<?=$domain;?>" style="font-size:14px;"><?=$_SERVER['HTTP_HOST'];?></a></td>
    </tr>
</table>
<?php if(is_file($c['root_path'].$banner['PicPath'.$c['lang'].'_0'])){?>
<table width="650" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td>
        	<a target="_blank" href="<?=$domain;?>"><img style="max-width:650px;" src="<?=$domain.$banner['PicPath'.$c['lang'].'_0'];?>" /></a>
        </td>
    </tr>
</table>
<?php }?>
<table width="650" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr><td height="60" style="font-family:'微软雅黑'; font-size:16px; color:#000;">We are interested in the following products, please reply to us by email.</td></tr>
</table>
<table width="650" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td width="240" height="40" style="background:#51b987; color:#fff; font-size:18px; font-family:'微软雅黑'; text-align:center;">Interested product</td>
        <td style="background:#d5c495; text-align:right; font-family:'微软雅黑'; font-size:14px; color:#fff; padding-right:20px;">一共<?=$Num;?>个产品</td>
    </tr>
</table>
<?php if($inquiry_row){?>
	<?php
        foreach((array)$products_row as $k => $v){
            $url=web::get_url($v, 'products');
            $name=$v['Name'.$c['lang']];
            $img=img::get_small_img($v['PicPath_0'], '240x240');
			$brief=$v['BriefDescription'.$c['lang']];
			$number=$v['Number'];
			$price=$v['Price_0'];

    ?>
		<table width="650" align="center" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px dotted #d5d5d5;">
            <tr>
                <td width="161" style="padding:15px;"><div style="width:159px; height:159px; border:1px solid #dcdcdc; text-align:center;"><a href="<?=$domain.$url;?>" target="_blank"><img style="vertical-align:middle; max-width:100%; max-height:100%;" src="<?=$domain.$img;?>" alt="<?=$name;?>" /><span style="height:100%; display:inline-block; vertical-align:middle;"></span></a></div></td>
                <td style="padding:15px">
                    <div style="width:428px; height:159px;">
                        <div style="max-height:40px; line-height:20px; overflow:hidden;"><a style="font-size:14px;" href="<?=$domain.$url;?>" title="<?=$name;?>"><?=$name;?></a></div>
                        <?php if($number){?><div style="margin-top:5px; font-size:14px;">No. <?=$number;?></div><?php }?>
                        <div style="font-size:14px; line-height:20px; max-height:60px; overflow:hidden; margin-top:5px;"><?=$brief;?></div>
                        <?php if($price){?><div style="font-size:14px;"><?=$c['config']['products']['symbol'].$price;?></div><?php }?>
                    </div>
                </td>
            </tr>
		</table>
    <?php }?>
<?php }?>
<table width="650" align="center" border="0" cellpadding="0" cellspacing="0" style="margin-top:20px;">
	<?php if($inquiry_row['FirstName'] || $inquiry_row['LastName']){?>
	<tr>
    	<td width="70" height="30" style="font-family:'微软雅黑'; font-size:16px;">My name：</td>
        <td style="font-size:14px;"><?=$inquiry_row['FirstName'].' '.$inquiry_row['LastName'];?></td>
    </tr>
    <?php }?>
    <?php if($inquiry_row['Email']){?>
    <tr>
    	<td width="70" height="30" style="font-family:'微软雅黑'; font-size:16px;">Email：</td>
        <td style="font-size:14px;"><?=$inquiry_row['Email'];?></td>
    </tr>
    <?php }?>
    <?php if($inquiry_row['Phone']){?>
    <tr>
    	<td width="70" height="30" style="font-family:'微软雅黑'; font-size:16px;">电话：</td>
        <td style="font-size:14px;"><?=$inquiry_row['Phone'];?></td>
    </tr>
    <?php }?>
    <?php if($inquiry_row['Fax']){?>
    <tr>
    	<td width="70" height="30" style="font-family:'微软雅黑'; font-size:16px;">传真：</td>
        <td style="font-size:14px;"><?=$inquiry_row['Fax'];?></td>
    </tr>
    <?php }?>
    <?php if($inquiry_row['City'] || $inquiry_row['State'] || $inquiry_row['Country']){?>
    <tr>
    	<td width="80" height="30" style="font-family:'微软雅黑'; font-size:16px;">Our country：</td>
        <td><?=/*$inquiry_row['City'].', '.$inquiry_row['State'].', '.*/$inquiry_row['Country'];?></td>
    </tr>
    <?php }?>
    <?php if($inquiry_row['Ip']){?>
    <tr>
        <td width="70" height="30" style="font-family:'微软雅黑'; font-size:16px;">IP：</td>
        <td style="font-size:14px;"><?=str::str_format($inquiry_row['Ip']);?></td>
    </tr>
    <?php }?>
    <?php if($inquiry_row['Address']){?>
    <tr>
        <td width="70" height="30" style="font-family:'微软雅黑'; font-size:16px;">地址：</td>
        <td style="font-size:14px;"><?=$inquiry_row['Address'];?></td>
    </tr>
    <?php }?>
    <?php if($inquiry_row['PostalCode']){?>
    <tr>
        <td width="70" height="30" style="font-family:'微软雅黑'; font-size:16px;">邮编：</td>
        <td style="font-size:14px;"><?=$inquiry_row['PostalCode'];?></td>
    </tr>
    <?php }?>
    <?php if($inquiry_row['Subject']){?>
    <tr>
        <td width="70" height="30" style="font-family:'微软雅黑'; font-size:16px;">主题：</td>
        <td style="font-size:14px;"><?=$inquiry_row['Subject'];?></td>
    </tr>
    <?php }?>
    <?php if($inquiry_row['Message']){?>
    <tr>
        <td width="70" height="30" style="font-family:'微软雅黑'; font-size:16px;">Descriptions：</td>
        <td style="font-size:14px;"><?=str::str_format($inquiry_row['Message']);?></td>
    </tr>
    <?php }?>
</table>
<?php
	$table=ob_get_contents();
	ob_end_clean();
?>