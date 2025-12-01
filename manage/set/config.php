<?php !isset($c) && exit();?>
<?php
manage::check_permit('set.config', 2);//检查权限

echo ly200::load_static('/static/js/plugin/jquery-ui/jquery-ui.min.css', '/static/js/plugin/jquery-ui/jquery-ui.min.js', '/static/js/plugin/ckeditor/ckeditor.js', '/static/js/plugin/jscolor/jscolor.js');
?>
<script type="text/javascript">$(document).ready(function(){set_obj.config_edit_init();});</script>
<div id="config" class="r_con_wrap">
	<?php if($c['manage']['do']=='index'){ ?>
		<form id="edit_form" class="global_form">
			<?php
			include('inc/config.basis.php');
			include('inc/config.seo.php');
			include('inc/config.switch.php');
			include('inc/config.language.php');
			include('inc/config.google_translate.php');
			(int)$c['FunVersion'] && include('inc/config.inquiry.php');
			include('inc/config.contact.php');
			include('inc/config.product.php');
			include('inc/config.user.php');
			include('inc/config.watermark.php');
			include('inc/config.share.php');
			?>
		</form>
	<?php
	}else{
		$file=__DIR__."/inc/config.{$c['manage']['do']}.edit.php";
		@is_file($file) && include($file);
		include('static/inc/translation.php');
	}
	?>
</div>