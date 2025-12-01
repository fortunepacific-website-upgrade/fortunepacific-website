<?php if((int)$c['FunVersion']>1){?>
	<div id="translation" class="pop_form">
		<form>
			<div class="t"><h1>{/global.translation/}</h1>&nbsp;<span class="g_hide"></span><h2>×</h2></div>
			<div class="r_con_form">
				<table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
					<thead>
						<tr>
							<td width="40%" nowrap="nowrap">{/global.contents/}</td>
							<?php
							foreach($c['manage']['config']['Language'] as $k=>$v){
								if($k==0){continue;}
							?>
								<td width="10%" nowrap="nowrap">{/language.<?=$v;?>/}</td>
							<?php }?>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
			<div class="button">
				<input type="button" class="btn_global btn_submit" value="{/global.translation/}" />
				<a href="javascript:;"><input type="button" class="btn_global btn_cancel" value="{/global.close/}"></a>
			</div>
		</form>
	</div>
<?php }else{?>
	<script type="text/javascript">$(function(){$('.btn_translation').hide();});</script>
<?php }?>