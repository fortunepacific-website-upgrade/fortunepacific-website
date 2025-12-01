<?php
!isset($c) && exit();
manage::check_permit('seo.keyword_track', 2);//检查权限
?>
<div id="keyword_track" class="r_con_wrap">
	<div class="inside_container">
		<h1>{/module.seo.keyword_track/}</h1>
	</div>
	<div class="inside_table">
		<table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
			<thead>
				<tr>
					<td width="30%" nowrap="nowrap">{/seo.keyword_text/}</td>
					<td width="10%" nowrap="nowrap">{/seo.keyword_track.time.0/}</td>
					<td width="10%" nowrap="nowrap">{/seo.keyword_track.time.1/}</td>
					<td width="10%" nowrap="nowrap">{/seo.keyword_track.time.2/}</td>
					<td width="10%" nowrap="nowrap">{/seo.keyword_track.time.3/}</td>
					<td width="10%" nowrap="nowrap">{/seo.keyword_track.time.4/}</td>
					<td width="10%" nowrap="nowrap">{/seo.keyword_track.time.5/}</td>
					<td width="10%" nowrap="nowrap">{/seo.keyword_track.time.6/}</td>
				</tr>
			</thead>
			<tbody>
				<?php
				$result=manage::ueeseo_get_data('ueeshop_ueeseo_get_keyword_track');
				!$result['ret'] && $result['msg']=array();
				$start=0;
				$startAry=array(0,0,0,0,0,0,0,0);
				foreach($result['msg'] as $k=>$v){$v=(array)$v;for($i=1;$i<=7;$i++){$startAry[$i]+=$v[0][$i];}}
				for($i=1;$i<=7;$i++){if($startAry[$i]+count($result['msg'])>0){$start=$i;break;}}//找出第一列不全为0的下标
				
				$i=1;
				foreach($result['msg'] as $k=>$v){
					$v=(array)$v;
				?>
					<tr<?=$i++%2==1?' class="gray"':'';?>>
						<td nowrap="nowrap"><a href="https://www.google.com/search?nomo=1&num=100&q=<?=urlencode($k);?>" target="_blank"><?=$k;?></a></td>
						<?php 
							foreach((array)$v[0] as $k1=>$v1){
								if(!$k1) continue;
								(($v1>$v[0][$k1-1] || $v1==0) && $v[0][$k1-1]>0) && $class='down';
								(($v1<$v[0][$k1-1] || $v[0][$k1-1]==0) && $v1>0) && $class='up';
								$v[0][$k1-1]==-1 && $class='';
						?>
							<td nowrap="nowrap"><label class="<?=$class;?>"><?=$v1==-1?($k1>=$start?0:''):$v1;?></label></td>
						<?php }?>
					</tr>
				<?php }?>
			</tbody>
		</table>
	</div>
</div>