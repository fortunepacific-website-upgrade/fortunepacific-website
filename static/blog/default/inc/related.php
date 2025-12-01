<?php !isset($c) && exit();?>
<?php $row = str::str_code(db::get_limit('blog', 'IsHot=1', '*', $c['my_order'].'AId desc', 0, 5));;?>
<div class="stick">
    <div class="clean"><div class="title">Popular blog</div></div>
    <div class="ct">
        <ul class="rela_list">
        	<?php foreach ($row as $k=>$v){?>
            <li><a href="<?=ly200::get_url($v, 'blog');?>"><?=$v['Title']?></a></li>
            <?php }?>
        </ul>
    </div>
</div><!-- end of .stick -->