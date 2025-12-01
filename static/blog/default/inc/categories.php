<?php !isset($c) && exit();?>
<?php $row = str::str_code(db::get_all('blog_category', 1, '*', $c['my_order'].'CateId asc'));;?>
<div class="stick">
    <div class="clean"><div class="title">Categories</div></div>
    <div class="ct">
        <ul class="stlist">
            <?php foreach ($row as $k=>$v){?>
            <li>&bull; <a href="/blog/?p=list&CateId=<?=$v['CateId'];?>"><?=$v['Category_en'];?></a></li>
            <?php }?>
        </ul>
    </div>
</div><!-- end of .stick -->