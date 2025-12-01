<?php !isset($c) && exit();?>
<?php
$no_page_url=web::get_query_string(str::query_string('m, a, CateId, page'));

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

$page_count=10;
if($CateId){
	$where.=" and ".category::get_search_where_by_CateId($CateId, 'download_category');
	$download_category_row=db::get_one('download_category', "CateId='{$CateId}'");
}
$Column = '<a href="/download/">'.$c['lang_pack']['mobile']['downloads'].'</a>';
$Column .= web::get_web_position($download_category_row, 'download_category');
$page=(int)$_GET['page'];
$download_list_row=str::str_code(db::get_limit_page('download', $where, '*', $c['my_order'].'DId desc', $page, $page_count));
?>
<!DOCTYPE HTML>
<html lang="us">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta content="telephone=no" name="format-detection" />
<?=web::seo_meta($download_category_row, $spare_ary);?>
<?php include $c['theme_path'].'/inc/resource.php';?>
</head>

<body>
<?php include $c['theme_path'].'/inc/header.php';//头部 ?>

<div class="wrapper">
    <div class="page_location"><?=$Column;?></div>
    <div class="m_editAddr"><div class="subtitle"><?=$c['lang_pack']['download']; ?></div></div>
    <div class="art_content">
        <div id="down_box" class="clean">
			<div id="downlist" class="over" data-down="<?=htmlspecialchars(str::json_data($_GET));?>" data-number="0" data-page="1" data-total="<?=$download_list_row[3];?>"></div>
			<ul id="downlist_mask"></ul>
		</div>
    </div>
</div><!-- end of .wrapper -->

<?php include $c['theme_path'].'/inc/footer.php';//底部?>
</body>
</html>
<script>
	ajax_download_list({"page":0, "Data":$("#downlist").attr("data-down")}, 1);
	function ajax_download_init(){
		$('#downlist .btn_view').off().on('tap', function(){
			var $Num=parseInt($("#downlist").attr('data-number'));
			if($Num==0){
				$(this).remove();
				$("#downlist").attr('data-number', '1');
				var page=parseInt($("#downlist").attr("data-page"));
				if(!isNaN(page)){
					var Total=parseInt($("#downlist").attr('data-total'));
					if(page>=Total){
						return false;
					}
					$("#downlist").attr('data-page', page+1);
					ajax_download_list({"page":page+1, "Data":$("#downlist").attr("data-down")}, 0);
				}
			}
		});
		
		if($("#downlist .content_more").length){
			setTimeout(function(){
				$("#downlist .content_more").fadeOut();
			}, 2000);
		}
	}
	
	function ajax_download_list(data, clear){
		clear && $("#downlist").html('');
		// $("#downlist").loading();
		$(".loading_msg").css({"top":0, "position":"initial", "width":"auto", "height":'4rem', "background-position":"center"});
		setTimeout(function(){
			$.ajax({
				url:"/?m=ajax&a=download_list",
				async:false,
				type:'post',
				data:data,
				dataType:'html',
				success:function(result){
					if(result){
						$("#downlist").append(result);//.unloading()
						$("#downlist").attr('data-number', '0');
						ajax_download_init();
					}
				}
			});
		}, 300);
	}
</script>