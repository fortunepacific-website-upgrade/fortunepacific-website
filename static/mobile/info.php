<?php !isset($c) && exit();?>
<?php 
$no_page_url=web::get_query_string(str::query_string('m, a, CateId, Ext, page'));

$CateId=(int)$_GET['CateId'];
$where=1;

$page_count=10;
if($CateId){
	$where.=" and ".category::get_search_where_by_CateId($CateId, 'info_category');
	$info_category_row=db::get_one('info_category', "CateId='{$CateId}'");
}
$Column = '<a href="/info/">'.$c['lang_pack']['news'].'</a>';
$Column .= web::get_web_position($info_category_row, 'info_category');
$page=(int)$_GET['page'];
$info_list_row=str::str_code(db::get_limit_page('info', $where, '*', $c['my_order'].'InfoId desc', $page, $page_count));
$c['mobile']['InfoListTpl'] = '02';
?>
<!DOCTYPE HTML>
<html lang="us">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta content="telephone=no" name="format-detection" />
<?=web::seo_meta($info_category_row, $spare_ary);?>
<?=ly200::load_static($c['mobile']['tpl_dir'].'info/'.$c['mobile']['InfoListTpl'].'/css/style.css');?>
<?php include $c['theme_path'].'/inc/resource.php';?>
</head>

<body>
<?php include $c['theme_path'].'/inc/header.php';//头部 ?>

<div class="wrapper">
    <div class="art_content">
		<?php
		if($InfoId){
			echo str::clear_html(str::str_code($info_content_row['Content'.$c['lang']], 'htmlspecialchars_decode'));
		}else{
		?>
		<div id="info_box" class="clean">
			<div id="infolist" class="over" data-info="<?=htmlspecialchars(str::json_data($_GET));?>" data-number="0" data-page="1" data-total="<?=$info_list_row[3];?>"></div>
			<ul id="infolist_mask"></ul>
		</div>
		<?php }?>
    </div>
</div><!-- end of .wrapper -->

<?php include $c['theme_path'].'/inc/footer.php';//底部?>
</body>
</html>

<script>
	ajax_info_list({"page":0, "Data":$("#infolist").attr("data-info")}, 1);
	function ajax_info_init(){
		$('#infolist .btn_view').off().on('tap', function(){
			var $Num=parseInt($("#infolist").attr('data-number'));
			if($Num==0){
				$(this).remove();
				$("#infolist").attr('data-number', '1');
				var page=parseInt($("#infolist").attr("data-page"));
				if(!isNaN(page)){
					var Total=parseInt($("#infolist").attr('data-total'));
					if(page>=Total){
						return false;
					}
					$("#infolist").attr('data-page', page+1);
					ajax_info_list({"page":page+1, "Data":$("#infolist").attr("data-info")}, 0);
				}
			}
		});
		
		if($("#infolist .content_more").length){
			setTimeout(function(){
				$("#infolist .content_more").fadeOut();
			}, 2000);
		}
	}
	
	function ajax_info_list(data, clear){
		clear && $("#infolist").html('');
		// $("#infolist").loading();
		$(".loading_msg").css({"top":0, "position":"initial", "width":"auto", "height":'4rem', "background-position":"center"});
		setTimeout(function(){
			$.ajax({
				url:"/?m=ajax&a=info_list",
				async:false,
				type:'post',
				data:data,
				dataType:'html',
				success:function(result){
					if(result){
						$("#infolist").append(result);//.unloading()
						$("#infolist").attr('data-number', '0');
						ajax_info_init();
					}
				}
			});
		}, 300);
	}
</script>