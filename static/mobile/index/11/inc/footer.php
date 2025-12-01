<?php !isset($c) && exit();?>
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
<div class="message">
	<?php if($c['config']['global']['Contact']['address'.$c['lang']]){ ?><div class="addr global_border_color font_col"><?=$c['config']['global']['Contact']['address'.$c['lang']];?></div><?php } ?>
	<?php if($c['config']['global']['Contact']['email']){ ?><div class="email global_border_color font_col"><?=$c['config']['global']['Contact']['email'];?></div><?php } ?>
	<?php if($c['config']['global']['Contact']['tel']){ ?><div class="tel global_border_color font_col"><?=$c['config']['global']['Contact']['tel'];?></div><?php } ?>
</div>
<section class="font_col border_col copyright"><?=$c['config']['global']['Contact']['copyright'.$c['lang']].($c['config']['global']['powered_by']!=''?'&nbsp;&nbsp;'.$c['config']['global']['powered_by']:'');?></section>

  