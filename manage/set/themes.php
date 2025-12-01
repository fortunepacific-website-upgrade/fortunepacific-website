<?php !isset($c) && exit();?>
<?php
manage::check_permit('set.themes', 2);//检查权限

$IsMobile=(int)$_GET['IsMobile'];
if(!$c['manage']['do'] || $c['manage']['do']=='index'){//重新指向“风格”页面
	$c['manage']['do']='index_set';
}
echo ly200::load_static('/static/js/plugin/dragsort/dragsort-0.5.1.min.js');
?>
<div id="themes" class="r_con_wrap">
	<div class="inside_container">
		<h1>
			{/module.set.themes/}
			<?php if(db::get_value('config_module', "Themes='{$c['themes']}'", 'IsResponsive')==0 && $c['FunVersion']){?>
				<dl>
					<dt><img src="/static/manage/images/set/icon_<?=$IsMobile ? 'mobile' : 'pc'; ?>.png" alt=""><i></i></dt>
					<dd class="drop_down">
						<a href="./?m=set&a=themes&d=index_set" class="item"><img src="/static/manage/images/set/icon_pc.png">{/set.themes.device.0/}</a>
						<a href="./?m=set&a=themes&d=index_set&IsMobile=1" class="item"><img src="/static/manage/images/set/icon_mobile.png">{/set.themes.device.1/}</a>
					</dd>
				</dl>
			<?php }?>
		</h1>
		<ul class="inside_menu">
		<?php
		$menu=array(
			array('index_set', 'nav', 'footer_nav', 'toper_nav', 'ad'),
			array('index_set', 'home_themes', 'list_themes', 'header_set', 'footer_set')
		);
		foreach($menu[$IsMobile] as $v){
		?>
			<li><a href="./?m=set&a=themes&d=<?=$v.($IsMobile?'&IsMobile=1':'');?>" <?=$c['manage']['do']==$v?'class="current"':'';?>>{/set.themes.menu.<?=$v;?>/}</a></li>
		<?php
		}
		?>
		</ul>
	</div>
	<?php
	if(substr_count($c['manage']['do'], 'themes')){
		$file='themes.themes.php';
	}elseif(substr_count($c['manage']['do'], 'nav')){
		$file='themes.nav.php';
	}else{
		$file="themes.{$c['manage']['do']}.php";
	}
	$file=__DIR__.'/inc/'.$file;
	@is_file($file) && include($file);
	?>
</div>