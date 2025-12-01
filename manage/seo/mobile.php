<?php !isset($c) && exit();?>
<?php
manage::check_permit('seo.mobile', 2);//检查权限

$type=(int)$_GET['type'];
$result=manage::ueeseo_get_data('ueeshop_ueeseo_get_mobile', array('type'=>$type));
!$result['ret'] && $result['msg']=array();

$count_result=manage::ueeseo_get_data('ueeshop_ueeseo_get_mobile', array('type'=>0));
$Total_task = count($count_result['msg']['intro_row']);
$ThisWeekComplete_num = $Total_task-count($count_result['msg']['mobile_row']);
if($ThisWeekComplete_num){
	$ThisWeekComplete=sprintf('%.2f', $ThisWeekComplete_num/$Total_task)*100;
	$Percentage=270/(100/$ThisWeekComplete);
}

?>
<?=ly200::load_static('/static/js/plugin/lightbox/lightbox.css', '/static/js/plugin/lightbox/jquery.lightbox.js');?>
<script language="javascript">$(document).ready(function(){seo_obj.mobile_init();});</script>
<div id="mobile" class="r_con_wrap">
	<div class="inside_container">
		<h1>{/module.seo.mobile/}</h1>
	</div>
	<style>.optimize .oleft .img div{ -moz-transform:rotate(<?=$Percentage?>deg); -webkit-transform:rotate(<?=$Percentage?>deg); -ms-transform:rotate(<?=$Percentage?>deg); -o-transform:rotate(<?=$Percentage?>deg);}</style>
    <div class="optimize">
		<div class="oleft fl">
			<ul>
				<li>
					<div class="img Pointer"><img src="/static/manage/images/seo/b_0.png" /><div><img src="/static/manage/images/seo/z.png" /></div></div>
					<div class="fraction"><span><?=$result['msg']['web_row']['TotalMission']?$ThisWeekComplete:'0'?></span> %</div>
					<div class="equipment">{/seo.optimi_rate/}</div>
                    <div class="ol"></div>
				</li>
			</ul>
		</div>
        <div class="oright fl">
        	<ul>
            	<?php
				foreach((array)$result['msg']['intro_row'] as $k=>$v){
				?>
					<li class="<?=$v['ArticleId']==$v['t_ArticleId']?'light':'';?> <?=$k%2=='1'?'mrnone':''?>"><?=$v['Title'];?></li>
                <?php }?>
            </ul>
            <div class="clear"></div>
        </div>
		<div class="clear"></div>
	</div>
	<div class="global_container">
        <div class="cCards">
        	<ul>
                <li class="<?=$type==0?'on':'';?>"><a href="./?m=seo&a=mobile&type=0">{/seo.complete_ary.0/}</a></li>
                <li class="<?=$type==1?'on':'';?>"><a href="./?m=seo&a=mobile&type=1">{/seo.complete_ary.1/}</a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="cLists">
        	<ul class="r_con_list">
				<?php
				foreach((array)$result['msg']['mobile_row'] as $k=>$v){
				?>
                    <li data="<?=$v['ArticleId'];?>">
                        <dl>
                            <dt class="<?=$type?'offTop':''?> <?=($k+1)%2=='0'?'on':''?>">
                                <div class="title fl">
                                    <h3><?=$v['Title'];?></h3>
                                    <div class="clear"></div>
                                    <h4><?=$v['SubTitle'];?></h4>
                                </div>
                                <div class="time fr">
									<?=$v['CompleteTime'];?> min
                                    <div class="dec">
                                        <div class="i"><img src="/static/manage/images/seo/dd_21.png" /></div>
                                        <div class="d">{/seo.complete_time/}</div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </dt>
                            <dd class="offBtm">
                                <div class="fr oBright">
                                    <?php if($type!=1){?>
										<div class="fr state">
											<div class="close"><a href="#" class="close btn_global">{/seo.close/}</a></div>
											<div class="finish"><a href="#" class="finish btn_global">{/seo.complete/}</a></div>
										</div>
                                        <div class="fr remind btn_global">
											<span>{/seo.notes/}</span>
                                            <ul>
                                                <li><a href="#" class="five">{/seo.notes_ary.0/}</a></li>
                                                <li><a href="#" class="ten">{/seo.notes_ary.1/}</a></li>
                                                <li><a href="#" class="month">{/seo.notes_ary.2/}</a></li>
                                            </ul>
                                        </div>
                                    <?php }?>
                                    <div class="clear"></div>
                                </div>
                                <div class="contents">
                                    <?php
                                    $imgAry=str::json_data(htmlspecialchars_decode($v['PicPath']), 'decode');
                                    $BriefAry=str::str_code(str::json_data(htmlspecialchars_decode($v['PicContents']), 'decode'));
                                    foreach((array)$imgAry as $k1=>$v1){
                                    ?>
                                        <div class="img_list pic_box"><a href="<?=$result['msg']['domain'].$v1;?>" data-lightbox="lightbox-img-<?=$v['ArticleId'];?>" data-title="<?=$BriefAry[$k1];?>"><img src="/images/ico/blank.gif" _src="<?=$result['msg']['domain'].$v1;?>" alt="<?=$BriefAry[$k1];?>" /><span></span></a></div>
                                    <?php }?>
                                    <div class="clear"></div>
                                </div>
                                <div class="clear"></div>
                            </dd>
                        </dl>
                    </li>
                <?php }?>
            </ul>
        </div>
    </div>
</div>