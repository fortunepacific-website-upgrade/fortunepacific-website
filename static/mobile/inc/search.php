<?php !isset($c) && exit();?>
<div class="goods_search wrapper">
    <div class="form">
        <form action="/search/" method="get">
            <button class="global_btn"></button>
            <input type="search" value="" name="Keyword" placeholder="<?=$c['lang_pack']['search'];?>" class="text">
        </form>
    </div>
</div>
<div class="goods_searchbg"></div>