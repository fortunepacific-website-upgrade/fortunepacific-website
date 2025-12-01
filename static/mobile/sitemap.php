<?php !isset($c) && exit();?>
<!DOCTYPE HTML>
<html lang="us">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta content="telephone=no" name="format-detection" />
	<?=web::seo_meta();?>
	<?php include $c['mobile']['theme_path'].'/inc/resource.php';?>
</head>
<style>
	/*网站地图*/
	.sitemap .toptitle{font-size: 20px;font-weight: bold;text-align: center;padding:20px;}
	.sitemap{margin:auto;font-size: 12px;}
	.sitemap a{color: #333;}
	.sitemap_box{padding:20px;}
	.sitemap_box dl{float:left; margin-bottom:30px;width: 49%; overflow:hidden; margin-left: 2%;}
	.sitemap_box dl:nth-child(2n-1){margin-left: 0;clear: both;}
	.sitemap_box dl>dt{margin-bottom:6px; font-weight:bold;font-size: 14px;}
	.sitemap_box dl>dd>p>a{display:block; line-height:160%; height: 25px;line-height: 25px;overflow: hidden;-ms-text-overflow: ellipsis;text-overflow: ellipsis; white-space: nowrap;}
	.sitemap_box dl li>a{display: block;height: 25px;line-height: 25px;overflow: hidden;-ms-text-overflow: ellipsis;text-overflow: ellipsis; white-space: nowrap; text-indent: 10px;}
</style>
<body class="lang<?=$c['lang'];?>">
<?php include $c['theme_path'].'/inc/header.php';//头部 ?>

<div class="wrapper">
	<div class="sitemap">
		<div class="toptitle">
			<?=$c['lang_pack']['products']; ?>
		</div>
		<div class="sitemap_box">
			<?php
			$allcate_row=str::str_code(db::get_all('products_category', '1', '*',  $c['my_order'].'CateId asc'));
			$allcate_ary=array();
			foreach($allcate_row as $k=>$v){
				$allcate_ary[$v['UId']][]=$v;
			}
			foreach((array)$allcate_ary['0,'] as $k => $v){
				?>
				<dl>
					<dt><a href="<?=web::get_url($v);?>" title="<?=$v['Category'.$c['lang']];?>"><?=$v['Category'.$c['lang']];?></a></dt>
					<?php if($allcate_ary["0,{$v['CateId']},"]){?>
						<dd>
							<?php foreach($allcate_ary["0,{$v['CateId']},"] as $k1=>$v1){?>
								<p><a href="<?=web::get_url($v1);?>" title="<?=$v1['Category'.$c['lang']];?>"><?=$v1['Category'.$c['lang']];?></a></p>
								<ul>
									<?php foreach($allcate_ary["0,{$v['CateId']},{$v1['CateId']},"] as $k2=>$v2){?>
										<li><a href="<?=web::get_url($v2);?>" title="<?=$v2['Category'.$c['lang']];?>">&gt; <?=$v2['Category'.$c['lang']];?></a></li>
									<?php } ?>
								</ul>
							<?php } ?>
						</dd>
					<?php } ?>
				</dl>
			<?php } ?>
			<div class="clear"></div>
		</div>
		<div class="toptitle">
			<?=$c['lang_pack']['case']; ?>
		</div>
		<div class="sitemap_box">
			<?php
			$allcate_row=str::str_code(db::get_all('case_category', '1', '*',  $c['my_order'].'CateId asc'));
			$allcate_ary=array();
			foreach($allcate_row as $k=>$v){
				$allcate_ary[$v['UId']][]=$v;
			}
			foreach((array)$allcate_ary['0,'] as $k => $v){
				?>
				<dl>
					<dt><a href="<?=web::get_url($v,'case_category');?>" title="<?=$v['Category'.$c['lang']];?>"><?=$v['Category'.$c['lang']];?></a></dt>
					<?php if($allcate_ary["0,{$v['CateId']},"]){?>
						<dd>
							<?php foreach($allcate_ary["0,{$v['CateId']},"] as $k1=>$v1){?>
								<p><a href="<?=web::get_url($v1,'case_category');?>" title="<?=$v1['Category'.$c['lang']];?>"><?=$v1['Category'.$c['lang']];?></a></p>
							<?php } ?>
						</dd>
					<?php } ?>
				</dl>
			<?php } ?>
			<div class="clear"></div>
		</div>
		<div class="toptitle">
			<?=$c['lang_pack']['news']; ?>
		</div>
		<div class="sitemap_box">
			<?php
			$allcate_row=str::str_code(db::get_all('info_category', '1', '*',  $c['my_order'].'CateId asc'));
			foreach((array)$allcate_row as $k => $v){
				$info_row = db::get_all('info','CateId='.$v['CateId'],'*',$c['my_order'].'InfoId desc')
				?>
				<dl>
					<dt><a href="<?=web::get_url($v,'info_category');?>" title="<?=$v['Category'.$c['lang']];?>"><?=$v['Category'.$c['lang']];?></a></dt>
					<?php if($info_row){?>
						<dd>
							<?php foreach((array)$info_row as $k1=>$v1){
								if($k1>9) continue;
								?>
								<p><a href="<?=web::get_url($v1,'info');?>" title="<?=$v1['Title'.$c['lang']];?>"><?=$v1['Title'.$c['lang']];?></a></p>
							<?php } ?>
						</dd>
					<?php } ?>
				</dl>
			<?php } ?>
			<div class="clear"></div>
		</div>
		<div class="toptitle">
			<?=$c['lang_pack']['other']; ?>
		</div>
		<div class="sitemap_box">
			<?php
			$allcate_row=str::str_code(db::get_all('article_category', '1', '*',  $c['my_order'].'CateId asc'));
			foreach((array)$allcate_row as $k => $v){
				$article_row = db::get_all('article','CateId='.$v['CateId'],'*',$c['my_order'].'AId asc')
				?>
				<dl>
					<dt><a href="javascript:;" title="<?=$v['Category'.$c['lang']];?>"><?=$v['Category'.$c['lang']];?></a></dt>
					<?php if($article_row){?>
						<dd>
							<?php foreach($article_row as $k1=>$v1){?>
								<p><a href="<?=web::get_url($v1,'article');?>" title="<?=$v1['Title'.$c['lang']];?>"><?=$v1['Title'.$c['lang']];?></a></p>
							<?php } ?>
						</dd>
					<?php } ?>
				</dl>
			<?php } ?>
			<div class="clear"></div>
		</div>
	</div>
</div><!-- end of .wrapper -->
<?php include $c['theme_path'].'/inc/footer.php';//底部?>
</body>
</html>