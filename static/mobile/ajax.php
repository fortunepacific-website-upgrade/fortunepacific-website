<?php !isset($c) && exit();?>
<?php if($a=='products_list'){
	//产品列表页
	$_GET=str::json_data(htmlspecialchars_decode(stripslashes($_POST['Data'])), 'decode');
	$page_type = 'products';
	$page_count=10;
	$page=(int)$_POST['page'];
	$CateId=(int)$_GET['CateId'];
	$Keyword=$_GET['Keyword'];
	$Sort=($_GET['Sort'] && $c['products_sort'][$_GET['Sort']])?$_GET['Sort']:'1a';
	$where=$c['where']['products'];
	if($CateId){
		$where.=" and (".category::get_search_where_by_CateId($CateId).' or '.category::get_search_where_by_ExtCateId($CateId).')';
		$category_row=db::get_one('products_category', "CateId='$CateId'");
	}
	$Keyword && $where.=" and (Name{$c['lang']} like '%$Keyword%' or Number like '%$Keyword%')";
	$list_row = $products_list_row=str::str_code(db::get_limit_page('products', $where, '*', $c['my_order'].'ProId desc', $page, $page_count));
	include("{$c['mobile']['theme_path']}products/{$c['mobile']['ListTpl']}/template.php");
	
	if(!$products_list_row[3]){
		//echo '<div class="content_blank">'.$c['lang_pack']['mobile']['no_data'].'</div>';
	}elseif(($page==0 && $products_list_row[3]==1) || ($page && $page>=$products_list_row[3])){ //总共只有一页 或者 最后一页
		//echo '<div class="content_more">'.$c['lang_pack']['mobile']['no_data'].'</div>';
	}else{
		echo '<div class="btn_global btn_view"><button class="FontBgColor global_btn">'.$c['lang_pack']['mobile']['load_more'].'</button></div>';
	}

}else if($a=='case_list'){
	//产品列表页
	$_GET=str::json_data(htmlspecialchars_decode(stripslashes($_POST['Data'])), 'decode');
	$page_type = 'case';
	$page_count=10;
	$page=(int)$_POST['page'];
	$CateId=(int)$_GET['CateId'];
	$Keyword=$_GET['Keyword'];
	$where=1;
	if($CateId){
		$where.=" and ".category::get_search_where_by_CateId($CateId, 'case_category');
		$category_row=db::get_one('case_category', "CateId='$CateId'");
	}
	$Keyword && $where.=" and (Name{$c['lang']} like '%$Keyword%'";
	$list_row = $case_list_row=str::str_code(db::get_limit_page('`case`', $where, '*', $c['my_order'].'CaseId desc', $page, $page_count));
	include("{$c['mobile']['theme_path']}products/{$c['mobile']['ListTpl']}/template.php");
	
	if(!$case_list_row[3]){
		//echo '<div class="content_blank">'.$c['lang_pack']['mobile']['no_data'].'</div>';
	}elseif(($page==0 && $case_list_row[3]==1) || ($page && $page>=$case_list_row[3])){ //总共只有一页 或者 最后一页
		//echo '<div class="content_more">'.$c['lang_pack']['mobile']['no_data'].'</div>';
	}else{
		echo '<div class="btn_global btn_view"><button class="FontBgColor global_btn">'.$c['lang_pack']['mobile']['load_more'].'</button></div>';
	}

}else if($a=='download_list'){
	//下载列表页
	$_GET=str::json_data(htmlspecialchars_decode(stripslashes($_POST['Data'])), 'decode');
	$page_count=10;
	$page=(int)$_POST['page'];
	$CateId=(int)$_GET['CateId'];
	if($c['FunVersion']>=1){
		if((int)$_SESSION['ly200_user']['UserId']){
			$where=1;
		}else{
			$where="IsMember=0";
		}
	}else{
		$where=1;
	}
	if($CateId){
		$where.=" and ".category::get_search_where_by_CateId($CateId, 'download_category');
		$category_row=db::get_one('download_category', "CateId='$CateId'");
	}
	$download_list_row=str::str_code(db::get_limit_page('download', $where, '*', $c['my_order'].'DId desc', $page, $page_count));
	?>
		<ul class="down_list">
			<?php
			foreach($download_list_row[0] as $k=>$v){
			?>
			<li class="clean">
	        	<a class="fr down_btn global_btn <?=$v['Password'] ? 'pwd' : ''; ?>" href="<?=$v['IsOth']?$v['FilePath']:'javascript:void(0);';?>" <?=$v['IsOth']?'target="_blank"':'';?> l="<?=$v['DId']?>"><?=$c['lang_pack']['mobile']['view_all'];?></a>
	        	<?=$v['Name'.$c['lang']];?>
	        </li>
			<?php }?>
		</ul>
	<?php 
	if(!$download_list_row[3]){
		//echo '<div class="content_blank">'.$c['lang_pack']['mobile']['no_data'].'</div>';
	}elseif(($page==0 && $download_list_row[3]==1) || ($page && $page>=$download_list_row[3])){ //总共只有一页 或者 最后一页
		//echo '<div class="content_more">'.$c['lang_pack']['mobile']['no_data'].'</div>';
	}else{
		echo '<div class="btn_global btn_view"><button class="FontBgColor global_btn">'.$c['lang_pack']['mobile']['load_more'].'</button></div>';
	}

}else if($a=='info_list'){
	//下载列表页
	$_GET=str::json_data(htmlspecialchars_decode(stripslashes($_POST['Data'])), 'decode');
	$page_count=10;
	$page=(int)$_POST['page'];
	$CateId=(int)$_GET['CateId'];
	$where=1;
	if($CateId){
		$where.=' and '.category::get_search_where_by_CateId($CateId,'info_category');
		$category_row=db::get_one('info_category', "CateId='$CateId'");
	}
	$info_list_row=str::str_code(db::get_limit_page('info', $where, '*', $c['my_order'].'InfoId desc', $page, $page_count));
	$c['mobile']['InfoListTpl'] = '02';
	include("{$c['mobile']['theme_path']}info/{$c['mobile']['InfoListTpl']}/template.php");

	if(!$info_list_row[3]){
		//echo '<div class="content_blank">'.$c['lang_pack']['mobile']['no_data'].'</div>';
	}elseif(($page==0 && $info_list_row[3]==1) || ($page && $page>=$info_list_row[3])){ //总共只有一页 或者 最后一页
		//echo '<div class="content_more">'.$c['lang_pack']['mobile']['no_data'].'</div>';
	}else{
		echo '<div class="btn_global btn_view"><button class="FontBgColor global_btn">'.$c['lang_pack']['mobile']['load_more'].'</button></div>';
	}

}
?>