<?php !isset($c) && exit();?>
<?php
manage::check_permit('seo.blog', 2);//检查权限

$type=(int)$_GET['type'];
$BlogId=(int)$_GET['BlogId'];
$result=manage::ueeseo_get_data('ueeshop_ueeseo_get_blog', array('type'=>$type, 'BlogId'=>$BlogId));
!$result['ret'] && $result['msg']=array();
!$BlogId && $BlogId=$result['msg']['blog_row'][0]['BlogId'];
//print_r($result);
?>
<?=ly200::load_static('/static/js/plugin/lightbox/lightbox.css', '/static/js/plugin/lightbox/jquery.lightbox.js');?>
<script language="javascript">$(document).ready(function(){seo_obj.blog_init();});</script>
<div id="blog" class="r_con_wrap">
	<div class="inside_container">
		<h1>{/module.seo.blog/}</h1>
		<ul class="inside_menu">
			<li><a href="./?m=seo&a=blog&type=0" <?=$type==0?'class="current"':'';?>>{/seo.complete_ary.0/}</a></li>
			<li><a href="./?m=seo&a=blog&type=1" <?=$type==1?'class="current"':'';?>>{/seo.complete_ary.1/}</a></li>
		</ul>
	</div>
	<div class="global_container">
		<div class="cCards">
			<ul class="blog">
				<?php
				foreach((array)$result['msg']['blog_row'] as $k=>$v){
					$BlogId==$v['BlogId'] && $list_row=$v;
					$tips=(3-(int)$result['msg']['complete_count'][$v['BlogId']])>0?'<span>'.(3-(int)$result['msg']['complete_count'][$v['BlogId']]).'</span>':'';
				?>
					<li><a href="./?m=seo&a=blog&type=<?=$type;?>&BlogId=<?=$v['BlogId'];?>" class="<?=$BlogId==$v['BlogId']?'on':'';?>"><?=$k=='0'?'{/seo.blog.local_blog/}':preg_replace('/^www\./i', '', $v['Domain']);?></a><?=$tips;?></li>
				<?php }?>
			</ul>
			<div class="clear"></div>
		</div>
		<div class="blank15"></div>
        <div class="content">
			<div class="cLists">
				<ul class="r_con_list">
					<?php if($result['ret']==1){?>
						<?php if(!$result['msg']['blog_account_row'][$BlogId]){?>
							<li class="create" data="<?=$BlogId;?>">
								<dl>
									<dt><div class="title"><label>{/seo.blog.reg_notes/}</label></div></dt>
									<dd class="offBtm">
										<div class="toper">
											<h3>{/seo.blog.reg/}</h3>
											<span><?=$list_row['Domain'];?></span>
											<label><?=$list_row['CompleteTime'];?> min</label>
											<div class="clear"></div>
										</div>
										<?php if($list_row['Effect']!=''){echo "<h4>{$list_row['Effect']}</h4>";}?>
										<div class="list">
											<label>{/seo.blog.reg_url/}:</label>
											<span><a href="<?=$list_row['EnterUrl'];?>" target="_blank"><?=$list_row['EnterUrl'];?></a></span>
											<div class="clear"></div>
										</div>
										<div class="list"><label>{/seo.blog.reg_step/}:</label></div>
										<div class="contents">
											<?php
											$imgAry=str::json_data(htmlspecialchars_decode($list_row['PostPicPath']), 'decode');
											foreach((array)$imgAry as $k=>$v){
												//if(!is_file($c['root_path'].$v)) continue;
												$img=$result['msg']['domain'].$v;
												$ext_name=file::get_ext_name($img.$v);
											?>
												<div class="img_list pic_box"><a href="<?=$img;?>" data-lightbox="blog-images" data-title="{/seo.step/} <?=$k+1;?>"><img src="<?=$img.'.240x180.'.$ext_name;?>" /><span></span></a></div>
											<?php }?>
											<div class="clear"></div>
										</div>
										<div class="finish"><a href="#" class="btn_global complete">{/seo.complete/}</a></div>
									</dd>
								</dl>
							</li>
						<?php }else{?>
							<?php
							if($type==0){ //未完成
								$imgAry=str::json_data(htmlspecialchars_decode($list_row['PublishPicPath']), 'decode');
								foreach((array)$imgAry as $k=>$v){
								?>
									<a href="<?=$result['msg']['domain'].$v;?>" data-lightbox="blog-images" data-title="{/seo.step/} <?=$k+1;?>" class="lightbox-images"></a>
								<?php }?>
								<?php
								for($i=0; $i<(2+$result['msg']['no_links_complete']-$result['msg']['complete_count'][$BlogId]); $i++){
									$keyAry=ary::ary_key_rand($result['msg']['keyword_row'], (int)$list_row['LinksQuantity']);
									$keywordData=array();
									foreach((array)$keyAry as $num){
										$keywordData[$result['msg']['keyword_row'][$num]['Keywords']]=$result['msg']['keyword_row'][$num]['Url'];
									}
								?>
									<li class="post" data="<?=$BlogId;?>" num="<?=$i;?>">
										<dl>
											<dt class="<?=($i+1)%2=='0'?'on':''?>">
												<div class="title fl"><label>{/seo.blog.put_notes/}</label><span><?=$result['msg']['blog_account'];?></span><em class="new">NEW</em></div>
												<div class="time fr"><?=$list_row['CompleteTime'];?> min</div>
												<div class="clear"></div>
											</dt>
											<dd class="offBtm">
												<div class="toper">
													<h3>{/seo.blog.put_url/}</h3>
													<span class="domain"><a href="<?=$result['msg']['blog_account'];?>" target="_blank" title="<?=$result['msg']['blog_account'];?>"><?=$result['msg']['blog_account'];?></a></span>
													<a href="#" class="lightbox-rel">{/seo.blog.put_step/}</a>
													<div class="clear"></div>
												</div>
												<h4>{/seo.blog.has_keyword_notes/}</h4>
												<div class="contents">
													<table width="100%" cellpadding="0" cellspacing="0" border="0">
														<?php foreach((array)$keywordData as $k=>$v){?>
															<tr>
																<td nowrap class="name">{/seo.keyword_text/}:</td>
																<td nowrap class="key"><font><?=$k;?></font></td>
																<td width="98%" class="links">{/seo.local_url/}: <?=$v;?></td>
															</tr>
														<?php }?>
													</table>
												</div>
												<div class="finish" data="<?=str::str_code(str::json_data($keywordData));?>"><a href="#" class="btn_global complete">{/seo.complete/}</a></div>
											</dd>
										</dl>
									</li>
								<?php }?>
								<?php if(!$result['msg']['no_links_complete']){?>
									<li class="post" data="<?=$BlogId;?>" num="-1">
										<dl>
											<dt class="<?=($i+1)%2=='0'?'on':''?>">
												<div class="title fl"><label>{/seo.blog.update_notes/}</label><span><?=$result['msg']['blog_account'];?></span><em class="new">NEW</em></div>
												<div class="time fr"><?=$list_row['CompleteTime'];?> min</div>
												<div class="clear"></div>
											</dt>
											<dd class="offBtm">
												<div class="toper">
													<h3>{/seo.blog.update_url/}</h3>
													<span class="domain"><a href="<?=$result['msg']['blog_account'];?>" target="_blank" title="<?=$result['msg']['blog_account'];?>"><?=$result['msg']['blog_account'];?></a></span>
													<a href="#" class="lightbox-rel">{/seo.blog.put_step/}</a>
													<div class="clear"></div>
												</div>
												<h4>{/seo.blog.no_keyword_notes/}</h4>
												<div class="finish" data=""><a href="#" class="btn_global complete">{/seo.complete/}</a></div>
											</dd>
										</dl>
									</li>
								<?php }?>
							<?php
							}else{//已完成
								$g=0;
								foreach((array)$result['msg']['complete_row'] as $v){
									$g++;
								?>
									<li class="post">
										<dl>
											<dt class="<?=$g%2=='0'?'on':''?>">
												<div class="title fl"><label><?=$v['BlogType']==1?'{/seo.blog.put_complete/}':'{/seo.blog.update_complete/}';?></label><span><?=$v['Url'];?></span><?=$v['MissionWeeks']==$result['msg']['mission_weeks']?'<em class="new">NEW</em>':'';?></div>
												<div class="time fr"><?=$list_row['CompleteTime'];?> min</div>
												<div class="clear"></div>
											</dt>
											<dd class="offBtm">
												<div class="rows">
													<label>{/seo.blog.put_complete_url/}</label>
													<span class="complete">
														<a href="<?=$v['Url'];?>" class="domain" target="_blank"><?=$v['Url'];?></a>
														<a href="<?=$v['Url'];?>" class="view" target="_blank">{/seo.blog.view/}</a>
													</span>
													<div class="clear"></div>
												</div>
												<h4><?=$v['BlogType']==1?'{/seo.blog.has_keyword_notes/}':'{/seo.blog.no_keyword_notes/}';?></h4>
												<?php
												if($v['BlogType']==1){
													$keywordData=str::json_data(htmlspecialchars_decode($v['Keywords']), 'decode');
												?>
													<div class="contents">
														<table width="100%" cellpadding="0" cellspacing="0" border="0">
															<?php foreach((array)$keywordData as $k1=>$v1){?>
															<tr>
																<td nowrap class="name">{/seo.keyword_text/}:</td>
																<td nowrap class="key"><font><?=$k1;?></font></td>
																<td width="98%" class="links">{/seo.local_url/}: <?=$v1;?></td>
															</tr>
															<?php }?>
														</table>
													</div>
												<?php }?>
											</dd>
										</dl>
									</li>
								<?php }?>
							<?php }?>
						<?php }?>
					<?php }?>
				</ul>
			</div>
		</div>
    </div>
</div>
<form class="complete_form">
	<h3><?=!$result['msg']['blog_account_row'][$BlogId]?'{/seo.blog.input_reg_complete/}':'{/seo.blog.input_put_complete/}';?></h3>
	<div class="rows"><input type="text" name="Url" class="box_input" value="" size="70" notnull /></div>
	<div class="rows">
		<input type="submit" class="btn_global btn_submit" value="{/global.submit/}" />
		<a href="#" class="btn_global btn_cancel">{/global.cancel/}</a>
	</div>
	<input type="hidden" name="key" value="" />
	<?php if(!$result['msg']['blog_account_row'][$BlogId]){?>
		<input type="hidden" name="do_action" value="seo.blog_reg" />
	<?php }else{?>
		<input type="hidden" name="do_action" value="seo.blog_complete" />
		<input type="hidden" name="keywords" value="" />
		<input type="hidden" name="num" value="" />
	<?php }?>
</form>