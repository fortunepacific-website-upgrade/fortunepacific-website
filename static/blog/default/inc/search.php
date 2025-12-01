<?php !isset($c) && exit();?>
<div class="search clean">
    <form action="/blog/" method="get">
        <input class="fl btn" type="submit" value="" />
        <input class="fl text" name="Keyword" type="text" placeholder="Search tutorials and articles..." />
        <input type="hidden" name="p" value="list" />
    </form>
</div>