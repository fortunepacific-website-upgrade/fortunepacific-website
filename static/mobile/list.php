<?php !isset($c) && exit();?>
<!DOCTYPE HTML>
<html lang="us">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta content="telephone=no" name="format-detection" />
<?=web::seo_meta($category_row, $spare_ary);?>
<?php include $c['mobile']['theme_path'].'/inc/resource.php';?>
<?=ly200::load_static($c['mobile']['tpl_dir'].'products/'.$c['mobile']['ListTpl'].'/css/style.css');?>
<script type="text/javascript">
$(function (){
	$('.img a img').load(function (){
		$(this).parent().parent('.img').css('background-image', 'none');
	});
});
</script>
</head>

<body class="lang<?=$c['lang'];?>">
<?php include $c['theme_path'].'/inc/header.php';//头部 ?>
<div class="wrapper">
	<div class="page_location">
    	<?=$Column;?>
    </div>
	<div id="pro_box" class="clean">
		<div id="prolist" class="over" data-pro="<?=htmlspecialchars(str::json_data($_GET));?>" data-number="0" data-page="1" data-total="<?=$list_row[3];?>"></div>
		<ul id="prolist_mask"></ul>
	</div>
</div>
<?php include $c['theme_path'].'/inc/footer.php';//底部?>
</body>
</html>

<script>
	ajax_products_list({"page":0, "Data":$("#prolist").attr("data-pro")}, 1);
	function ajax_products_init(){
		$('#prolist .btn_view').off().on('tap', function(){
			var $Num=parseInt($("#prolist").attr('data-number'));
			if($Num==0){
				$(this).remove();
				$("#prolist").attr('data-number', '1');
				var page=parseInt($("#prolist").attr("data-page"));
				if(!isNaN(page)){
					var Total=parseInt($("#prolist").attr('data-total'));
					if(page>=Total){
						return false;
					}
					$("#prolist").attr('data-page', page+1);
					ajax_products_list({"page":page+1, "Data":$("#prolist").attr("data-pro")}, 0);
				}
			}
		});
		
		if($("#prolist .content_more").length){
			setTimeout(function(){
				$("#prolist .content_more").fadeOut();
			}, 2000);
		}
	}
	
	function ajax_products_list(data, clear){
		clear && $("#prolist").html('');
		// $("#prolist").loading();
		$(".loading_msg").css({"top":0, "position":"initial", "width":"auto", "height":'4rem', "background-position":"center"});
		setTimeout(function(){
			$.ajax({
				url:"/?m=ajax&a=<?=$page_type == 'products' ? 'products_list' : 'case_list'; ?>",
				async:false,
				type:'post',
				data:data,
				dataType:'html',
				success:function(result){
					if(result){
						$("#prolist").append(result);//.unloading()
						$("#prolist").attr('data-number', '0');
						ajax_products_init();
					}
				}
			});
		}, 300);
	}
</script>