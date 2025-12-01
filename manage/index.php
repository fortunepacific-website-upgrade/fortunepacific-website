<?php
include('../inc/global.php');
include('static/inc/init.php');
ob_start();

$isHome=($c['manage']['module']=='account'?1:0);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta content="telephone=no" name="format-detection" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="robots" content="noindex,nofollow">
<meta name="renderer" content="webkit">
<link rel="shortcut icon" href="<?=$c['manage']['config']['IcoPath'];?>" />
<title>{/frame.system_name/}</title>
<?=ly200::load_static('/static/css/global.css', '/static/manage/css/frame.css', '/static/manage/css/animate.css');?>
<?php
if($c['manage']['module']=="content" && $c['manage']['action']=="photo"){
	echo ly200::load_static('/static/js/jquery-1.8.3.js'); // 图片银行插件用的jq版本
}else if($c['manage']['module']=="account" && ($c['manage']['action']=="welfare" || $c['manage']['action']=="index" && db::get_row_count('config', 'GroupId="guide_pages" and Value="0"'))){
	echo ly200::load_static('/static/js/jquery-3.7.1.min.js', '/static/js/jquery-migrate-3.4.1.min.js', '/static/js/jquery-compatibility-fix.js'); // 视频播放要用新版的jq
}else{
	echo ly200::load_static('/static/js/jquery-3.7.1.min.js', '/static/js/jquery-migrate-3.4.1.min.js', '/static/js/jquery-compatibility-fix.js');
}
?>
<?=ly200::load_static("/static/js/lang/{$c['manage']['config']['ManageLanguage']}.js", "/static/manage/lang/{$c['manage']['config']['ManageLanguage']}.js", '/static/js/global.js', '/static/manage/js/frame.js');?>
<?=ly200::load_static("/static/manage/css/{$c['manage']['module']}.css", "/static/manage/js/{$c['manage']['module']}.js"); ?>
<?=ly200::load_static('/static/js/plugin/tool_tips/tool_tips.js', '/static/js/plugin/jscrollpane/jquery.mousewheel.js', '/static/js/plugin/jscrollpane/jquery.jscrollpane.js', '/static/js/plugin/jscrollpane/jquery.jscrollpane.css');?>
<style type="text/css">body,html,h1,h2,h3,h4,h5,h6,input,select,textarea{<?=$c['manage']['config']['ManageLanguage']=='cn'?'font-family:"微软雅黑"':'font-size:12px';?>;}</style>
<script type="text/javascript">
var session_id='<?=session_id();?>';
var ueeshop_config={"curDate":"<?=date('Y/m/d H:i:s', $c['time']);?>","lang":"<?=substr($c['manage']['web_lang'], 1);?>","manage_language":"<?=$c['manage']['config']['ManageLanguage'];?>","currency":"<?=$c['manage']['currency_symbol'];?>","currSymbol":"<?=$c['manage']['currency_symbol'];?>","language":<?=str::json_data($c['manage']['config']['Language']);?>,"FunVersion":<?=(int)$c['FunVersion'];?>};
$(document).ready(function(){
	frame_obj.page_init();
	<?php
	if((int)$c['manage']['config']['PromptSteps']){
		db::update('config', "GroupId='global' and Variable='PromptSteps'", array('Value'=>0));
		echo 'frame_obj.prompt_steps();';
	}
	?>
});
</script>
</head>

<body class="<?=$c['manage']['config']['ManageLanguage'];?>">
<?php
if($c['manage']['action']=='login'){
	include('account/login.php');
}elseif($c['manage']['iframe']==1){	//弹窗
	include("{$c['manage']['module']}/{$c['manage']['action']}.php");
}else{
	$LogoPath='/static/manage/images/frame/logo.png';
	(int)$c['UeeshopAgentId'] && $LogoPath='http://a.vgcart.com/agent/?do_action=action.agent_logo&AgentId='.(int)$c['UeeshopAgentId'];	//代理商LOGO
?>
	<div id="header">
		<div class="logo pic_box"><a href="./"><img src="<?=$LogoPath;?>" /></a><span></span></div>
		<ul class="menu">
			<li class="menu_welfare"><a href="./?m=account&a=welfare"><span>{/global.welfare/}</span><em>New</em></a></li>
			<li class="menu_help"><a href="http://help.web.ueeshop.com" target="_blank"><span>{/global.help/}</span></a></li>
			<li class="menu_home"><a href="<?=web::get_domain();?>" target="_blank"><em class="icon_head_menu_home"></em></a></li>
			<li class="menu_user">
				<dl class="user_info fl">
					<dt><strong><?=$_SESSION['Manage']['UserName'];?></strong><em></em></dt>
					<dd>
						<div class="drop_down">
							<a class="item" href="?m=set&a=manage&d=edit&UserId=<?=$_SESSION['Manage']['UserId'];?>">{/frame.edit_password/}</a>
							<a class="item" href="?do_action=account.logout">{/frame.logout/}</a>
						</div>
					</dd>
				</dl>
			</li>
		</ul>
	</div>
	<div id="main">
		<div class="fixed_loading">
			<div class="load">
				<div><div class="load_image">Ueeshop</div><div class="load_loader"></div></div>
			</div>
		</div>
		<div class="menu">
			<div class="menu_ico<?=$isHome?' home_menu_ico':'';?>">
				<?php
				//规划左侧栏
				$menu_name_ary=array();
				foreach($c['manage']['permit'] as $k=>$v){
					if(!manage::check_permit($k) || $k=='account'){continue;}

					$m_a_count = count($v);
					for($mak=0;$mak<$m_a_count;$mak++){
						$first_module=array_slice($v,$mak,1);
						$menu_a=count($first_module)==count($first_module,1)?$first_module[0]:key($first_module);
						if(manage::check_permit($k.".".$menu_a)) break;
					}
					$url="./?m=$k&a=$menu_a";
					$menu_name_ary[]=array(manage::language("{/module.$k.module_name/}"), $url);
				?>
					<div class="menu_item" data-title="{/module.<?=$k;?>.module_name/}">
						<a href="<?=$url;?>">
							<i class="icon_menu icon_menu_<?=$k;?><?=$c['manage']['module']==$k?' current':'';?>"><?=$isHome?'<span>{/module.'.$k.'.module_name/}</span>':'';?></i>
						</a>
					</div>
				<?php }?>
			</div>
			<div class="menu_ico_name">
				<?php
				foreach($menu_name_ary as $k=>$v){
					echo "<div class='menu_item'><a href='{$v[1]}'>{$v[0]}</a></div>";
				}
				?>
			</div>
			<?php if(!in_array($c['manage']['module'], array('account'))){?>
				<div class="menu_list">
					<div class="menu_title">{/module.<?=$c['manage']['module'];?>.module_name/}</div>
					<dl>
						<?php
						foreach($c['manage']['permit'][$c['manage']['module']] as $k=>$v){
							$action_ary=@explode('.', $c['manage']['action']);
							if(!manage::check_permit($c['manage']['module'].'.'.(is_array($v)?$k:$v))){continue;}
							$not_read='';
							if($c['manage']['module']=='inquiry' && in_array($v, array('inquiry', 'feedback', 'review'))){
								$table=array(
									'inquiry'	=>	'products_inquiry',
									'feedback'	=>	'feedback',
									'review'	=>	'products_review'
								);
								$not_read_count=(int)db::get_row_count($table[$v], 'IsRead=0');
								$not_read_count > 99 && $not_read_count="99+";
								$not_read_count && $not_read='<font class="not_read">'.$not_read_count.'</font>';
							}
						?>
							<dt<?=((reset($action_ary)==$k && !is_numeric($k)) || $c['manage']['action']==$v)?' class="current"':'';?>><a href="./?m=<?=$c['manage']['module'];?>&a=<?=is_array($v)?$k:$v;?>"><span>{/module.<?=$c['manage']['module'];?>.<?=is_array($v)?$k.'.module_name':$v;?>/}</span><?=$not_read;?></a></dt>
						<?php }?>
					</dl>
				</div>
			<?php }?>
		</div>
		<div id="righter" class="righter<?=$isHome?' home_righter':'';?>">
			<?php include("{$c['manage']['module']}/{$c['manage']['action']}.php");?>
        </div>
		<div class="clear"></div>
	</div>
<?php
}
$html=ob_get_contents();
ob_end_clean();
echo manage::language($html);
?>
</body>
</html>