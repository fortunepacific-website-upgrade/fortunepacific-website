<?php !isset($c) && exit();?>
<nav>
	<?php
    $footer_nav = str::json_data(db::get_value('config',"GroupId='mobile' AND Variable='FootNav'","Value"), 'decode');
	foreach ($footer_nav as $k=>$v){
	?>
        <?php if($k!=0){ ?><em class="bor"></em><?php } ?>
        <a href="<?=$v['Url'];?>" class="font_col"><?=$v['Name'.$c['lang']];?></a>
    <?php }?>
</nav>
<div class="share">
	<?php $row = $c['config']['global']['Contact']; ?>
    <?php if ($row['Facebook']){?>
    	<a rel="nofollow" href="<?=$row['Facebook'];?>" class="Facebook" target="_blank"></a>
    <?php }?>
    <?php if ($row['Twitter']){?>
    	<a rel="nofollow" href="<?=$row['Twitter'];?>" class="Twitter" target="_blank"></a>
    <?php }?>
    <?php if ($row['Pinterest']){?>
    	<a rel="nofollow" href="<?=$row['Pinterest'];?>" class="Pinterest" target="_blank"></a>
    <?php }?>
    <?php if ($row['LinkedIn']){?>
    	<a rel="nofollow" href="<?=$row['LinkedIn'];?>" class="LinkedIn" target="_blank"></a>
    <?php }?>
    <?php if ($row['YouTube']){?>
    	<a rel="nofollow" href="<?=$row['YouTube'];?>" class="YouTube" target="_blank"></a>
    <?php }?>
    <?php if ($row['Google']){?>
    	<a rel="nofollow" href="<?=$row['Google'];?>" class="Google" target="_blank"></a>
    <?php }?>
</div>
<section class="font_col border_col copyright"><?=$c['config']['global']['Contact']['copyright'.$c['lang']].($c['config']['global']['powered_by']!=''?'&nbsp;&nbsp;'.$c['config']['global']['powered_by']:'');?></section>
