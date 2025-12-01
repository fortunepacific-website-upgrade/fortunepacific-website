<?php !isset($c) && exit();?>
<div class="stick">
    <div class="clean"><div class="title">Archives</div></div>
    <div class="ct">
        <ul class="stlist">
            <?php
            for ($i=0; $i<6; $i++){
				$_date = strtotime("+{$i} month");
				$_date = strtotime(date('Y-m-01', $_date));
			?>
            <li>&bull; <a href="/blog/?p=list&date=<?=$_date;?>"><?=date('F Y', $_date);?></a></li>
            <?php }?>
        </ul>
    </div>
</div><!-- end of .stick -->