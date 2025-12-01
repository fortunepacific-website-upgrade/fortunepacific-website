<?php !isset($c) && exit();?>
<?php
manage::check_permit('seo.ads', 2);//检查权限

$type=(int)$_GET['type'];
$result=manage::ueeseo_get_data('ueeshop_ueeseo_get_ads', array('type'=>$type));
!$result['ret'] && $result['msg']=array();
//print_r($result);
?>
<?=ly200::load_static('/static/js/plugin/lightbox/lightbox.css', '/static/js/plugin/lightbox/jquery.lightbox.js');?>
<script language="javascript">
$(document).ready(function(){
	seo_obj.ads_init();
	$("#ThisWeek .ThisWeekBg").animate({width:<?=intval($result['msg']['rate'][0]);?>+"%"});
	$(".summary dl dd .Thismum").animate({left:(<?=intval($result['msg']['rate'][0]);?>+2)+"%"});
	<?php if($result['msg']['last_mission_weeks']){?>
		$("#LastWeek .LastWeekBg").animate({width:<?=$LastWeekComplete;?>+"%"});
		$(".summary dl dd .Lastmum").animate({left:(<?=$LastWeekComplete;?>+2)+"%"});
	<?php }?>
});
</script>
<div id="ads" class="r_con_wrap">
	<div class="inside_container">
		<h1>{/module.seo.ads/}</h1>
	</div>
	<div class="summary">
		<dl id="ThisWeek">
			<dt>{/seo.week_task_ary.0/}</dt>
			<dd>
				<div class="ThisWeekBg proportionbg"></div>
				<div class="proportionmum Thismum"><?=intval($result['msg']['rate'][0]);?>%</div>
			</dd>
		</dl>
		<div class="clear"></div>
		<?php if($result['msg']['last_mission_weeks']){?>
			<div class="blank20"></div>
			<dl id="LastWeek">
				<dt>{/seo.week_task_ary.1/}</dt>
				<dd>
					<div class="LastWeekBg proportionbg"></div>
					<div class="proportionmum Lastmum"><?=$result['msg']['rate'][1];?>%</div>
				</dd>
			</dl>
			<div class="clear"></div>
		<?php }?>
	</div>
	<div class="global_container">
        <div class="cCards">
        	<ul>
                <li class="btn_global <?=$type==0?'on':'';?>"><a href="./?m=seo&a=ads&type=0">{/seo.do_status_ary.0/}</a></li>
                <li class="finish btn_global <?=$type==1?'on':'';?>"><a href="./?m=seo&a=ads&type=1">{/seo.do_status_ary.1/}</a></li>
                <li class="close btn_global <?=$type==2?'on':'';?>"><a href="./?m=seo&a=ads&type=2">{/seo.do_status_ary.2/}</a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="cLists">
        	<ul class="r_con_list">
				<?php
                foreach((array)$result['msg']['ads_row'] as $k=>$v){
                ?>
                <li data="<?=$v['AdsId'];?>">
                    <dl>
                        <dt class="<?=($k+1)%2=='1'?'on':''?>">
                            <div class="title fl"><label>{/seo.put_info/}</label><span><?=$v['Domain'];?></span><?=$v['MissionWeeks']==$result['msg']['mission_weeks']?'<em class="new">NEW</em>':'';?></div>
                            <div class="times fr"><label><?=$v['CompleteTime'];?> min</label></div>
                            <div class="clear"></div>
                        </dt>
                        <dd class="offBtm">
                            <?php if($v['Effect']!=''){echo "<div class='effect'>{$v['Effect']}</div>";}?>
                            <div class="contents">
                                <div class="img pic_box"><a href="<?=$result['msg']['domain'].$v['PicPath'];?>" data-lightbox="links-pic-<?=$k;?>"><img src="/static/js/plugin/lightbox/images/loading.gif" _src="<?=$result['msg']['domain'].$v['PicPath'];?>" /><span></span></a></div>
                                <div class="list">
                                    <?php if($c['member']['do']=='complete'){?>
                                        <div class="rows">
                                            <label>{/seo.url/}:</label>
                                            <span class="complete"><a href="<?=$v['Url'];?>" class="domain" target="_blank"><?=$v['Url'];?></a></span>
                                            <div class="clear"></div>
                                        </div><?php /*?><?php */?>
                                    <?php }else{?>
                                        <div class="rows">
                                            <label>{/seo.url/}:</label>
                                            <span class="complete"><a href="<?=$v['EnterUrl'];?>" class="domain" target="_blank"><?=$v['Domain'];?></a>{/seo.need_reg/}</span>
                                            <div class="clear"></div>
                                        </div>
                                    <?php }?>
                                    <div class="rows">
                                        <label>{/seo.put_notes/}:</label>
                                        <span class="nocomplete">
                                        	<?php if($v['IsVideo']==1){?>
                                                <div class="img_list pic_box video">
                                                    <a href="javascript:;" data-video-url="<?=$v['VideoUrl'];?>"><img src="/static/manage/images/seo/play1.png" /><span></span></a>
                                                </div>
                                                <div class="img_list pic_box video">
                                                    <a href="javascript:;" data-video-url="<?=$v['VideoUrlTwo'];?>"><img src="/static/manage/images/seo/play2.png" /><span></span></a>
                                                </div>
                                            <?php 
											}else{
												$imgAry=str::json_data(htmlspecialchars_decode($v['PostPicPath']), 'decode');
												foreach((array)$imgAry as $k1=>$v1){
                                            ?>
                                                <div class="img_list pic_box">
                                                    <a href="<?=$result['msg']['domain'].$v1;?>" data-lightbox="links-images-<?=$v['AdsId'];?>" data-title="{/seo.step/} <?=$k1+1;?>"><img src="/static/js/plugin/lightbox/images/loading.gif" _src="<?=$result['msg']['domain'].$v1;?>" /><span></span></a>
                                                </div>
                                            <?php 
												}
											}
											?>
                                        </span>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <?php if($type==0){?><div class="finish"><a href="#" class="btn_global skip">{/seo.give_up/}</a><a href="#" class="btn_global complete">{/seo.complete/}</a></div><?php }?>
                        </dd>
                    </dl>
                </li>
                <?php }?>
            </ul>
        </div>
    </div>
</div>
<form class="complete_form">
	<h3>{/seo.put_complete_url/}</h3>
	<div class="rows"><input type="text" name="Url" class="box_input" value="" size="70" notnull /></div>
	<div class="rows">
		<input type="submit" class="btn_global btn_submit" value="{/global.submit/}" />
		<a href="#" class="btn_global btn_cancel">{/global.cancel/}</a>
	</div>
	<input type="hidden" name="do_action" value="seo.ads_complete" />
	<input type="hidden" name="key" value="" />
</form>