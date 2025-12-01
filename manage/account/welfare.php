<?php !isset($c) && exit();?>
<?php 
if($_SESSION['Manage']['welfare']){
	$result=$_SESSION['Manage']['welfare'];
	
}else{
	$data=array(
		'Action'	=>	'ueeshop_kuihuadao_get_course_list',
	);
	$result=ly200::api($data, $c['ApiKey'], $c['api_url']);
	$_SESSION['Manage']['welfare']=$result;
	$data=array('Action'=>'ueeshop_web_get_data');
	$analytics_row=ly200::api($data, $c['ApiKey'], $c['api_url']);
	if($analytics_row['Service']['QQ'] && $analytics_row['Service']['Contacts']){
		$_SESSION['Manage']['Service']=1;
	}
}
if($result['ret']){
	$category_ary=$result['msg'][0];
	$video_ary=$result['msg'][1];
	$permission_ary=str::json_data($result['msg'][2], 'decode');
	$uid_categroy_ary=$cate_video_ary=array();
	foreach((array)$category_ary as $v){
		$uid_categroy_ary[$v['UId']][]=$v;
	}
	foreach((array)$video_ary as $v){
		$cate_video_ary[$v['CategoryId']][]=$v;
	}
}
?>
<script>$(document).ready(function(){account_obj.welfare_init()});</script>
<div id="account" class="r_con_wrap">
	<div id="welfare">
		<div class="welfare_menu">
			<a href="javascript:;" class="cur" rel="notfollow">营销课程</a>
			<a href="javascript:;" rel="notfollow">营销资源</a>
		</div>
		<div class="video_box">
			<a href="javascript:;" class="cloce"></a>
			<div id="video_play"></div>	
		</div>
		<div class="welfare_box" style="display: block;">
			<div class="category">
				<a href="javascript:;" class="cur" rel="notfollow">已开放</a>
				<?php foreach((array)$uid_categroy_ary['0,'] as $k=>$v){ 
					if(!count($uid_categroy_ary['0,'.$v['CategoryId'].','])) continue;
					?>
					<a href="javascript:;" rel="notfollow"><?=$v['Category']; ?></a>
				<?php } ?>
			</div>
			<div class="category_box" style="display:block;">
				<div class="category_name">已开放</div>
				<div class="category_list video_list">
					<?php foreach((array)$video_ary as $v){ 
						if(!in_array($v['CourseId'], $permission_ary)) continue;
						?>
						<div class="list" data-ccid="<?=$v['CCId']; ?>" title="<?=$v['Name']; ?>">
							<div class="img">
								<img src="<?=$v['Photo']; ?>" alt="">
							</div>
							<div class="name">
								<?=$v['Name']; ?>
							</div>
						</div>
					<?php } ?>
					<div class="clear"></div>
				</div>
			</div>
			<?php foreach((array)$uid_categroy_ary['0,'] as $k=>$v){ 
				if(!count($uid_categroy_ary['0,'.$v['CategoryId'].','])) continue;
				?>
				<div class="category_box">
					<?php foreach((array)$uid_categroy_ary['0,'.$v['CategoryId'].','] as $v1){ 
						if(!count($cate_video_ary[$v1['CategoryId']])) continue;
						?>
						<div class="category_name"><?=$v1['Category']; ?></div>
						<div class="category_list video_list">
							<?php foreach((array)$cate_video_ary[$v1['CategoryId']] as $v2){ 
								$play=in_array($v2['CourseId'], $permission_ary) ? 1 : 0;
								?>
								<div class="list <?=$play ? '' : 'no_play'; ?>" data-ccid="<?=$v2['CCId']; ?>" title="<?=$v2['Name']; ?>">
									<div class="img">
										<img src="<?=$v2['Photo']; ?>" alt="">
									</div>
									<div class="name">
										<?=$v2['Name']; ?>
									</div>
								</div>
							<?php } ?>
							<div class="clear"></div>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
		<div class="welfare_box resource">
			<div class="list">
				<div class="company">广州联雅网络科技有限公司</div>
				<div class="pic"><img src="/static/manage/images/account/img_company_0.jpg" alt=""></div>
				<ul>
					<li class="tit">服务项目</li>
					<li>了解Facebook有那些营销方式</li>
					<li>了解每种营销方式如何运作</li>
					<li>了解免费与付费广告营销的区别</li>
				</ul>
				<ul>
					<li class="tit">用户优惠</li>
					<li>全面了解Gmail广告</li>
					<li>了解Gmail广告设置流程</li>
					<li>使用过程中的注意事项</li>
				</ul>
				<ul>
					<li class="tit">联系方式</li>
					<li class="tel"><span>电话</span>020-83226791</li>
					<li class="wechat"><span>微信</span>15017566325</li>
					<li class="website"><span>网址</span>www.ueeshop.com</li>
				</ul>
				<div class="clear"></div>
			</div>
			<div class="list">
				<div class="company">广州联雅网络科技有限公司</div>
				<div class="pic"><img src="/static/manage/images/account/img_company_1.jpg" alt=""></div>
				<ul>
					<li class="tit">服务项目</li>
					<li>了解Facebook有那些营销方式</li>
					<li>了解每种营销方式如何运作</li>
					<li>了解免费与付费广告营销的区别</li>
				</ul>
				<ul>
					<li class="tit">用户优惠</li>
					<li>全面了解Gmail广告</li>
					<li>了解Gmail广告设置流程</li>
					<li>使用过程中的注意事项</li>
				</ul>
				<ul>
					<li class="tit">联系方式</li>
					<li class="tel"><span>电话</span>020-83226791</li>
					<li class="wechat"><span>微信</span>15017566325</li>
					<li class="website"><span>网址</span>www.ueeshop.com</li>
				</ul>
				<div class="clear"></div>
			</div>
			<div class="list">
				<div class="company">广州联雅网络科技有限公司</div>
				<div class="pic"><img src="/static/manage/images/account/img_company_2.jpg" alt=""></div>
				<ul>
					<li class="tit">服务项目</li>
					<li>了解Facebook有那些营销方式</li>
					<li>了解每种营销方式如何运作</li>
					<li>了解免费与付费广告营销的区别</li>
				</ul>
				<ul>
					<li class="tit">用户优惠</li>
					<li>全面了解Gmail广告</li>
					<li>了解Gmail广告设置流程</li>
					<li>使用过程中的注意事项</li>
				</ul>
				<ul>
					<li class="tit">联系方式</li>
					<li class="tel"><span>电话</span>020-83226791</li>
					<li class="wechat"><span>微信</span>15017566325</li>
					<li class="website"><span>网址</span>www.ueeshop.com</li>
				</ul>
				<div class="clear"></div>
			</div>
		</div>
		<div class="no_play_tips">
			<table class="tips">
				<tr><td>
					<?php if(substr_count($_SERVER['HTTP_HOST'], '.myueeshop.com')){ ?>
						“请联系Ueeshop建站顾问”<br />
						索取观看权限
					<?php }else{ ?>
						友情提醒：进阶课程需先完善网站资料，<br>
						我们的客服专员<?php if($_SESSION['Manage']['Service']){ ?>（QQ：800031052）<?php } ?>会为您网站检查后开启课程
					<?php } ?>
				</td></tr>
			</table>
		</div>
	</div>
</div>
<script>
function get_cc_verification_code(vid){
	return '<?=str::str_crypt(str::rand_code()."|ueeshop|UEESHOP|".str::rand_code());?>';
}
</script>