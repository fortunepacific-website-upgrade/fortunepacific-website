<?php !isset($c) && exit();?>
<script type="text/javascript">
<?php if($c['config']['global']['WebDisplay']==0){?>
	var websiteDisplay=function(){
		if($(window).width()>=1250){$('body').addClass('w_1200');}
		$(window).resize(function(){
			if($(window).width()>=1250){
				$('body').addClass('w_1200');
			}else{
				$('body').removeClass('w_1200');
			}
		});
	}
<?php }elseif($c['config']['global']['WebDisplay']==2){?>
	var websiteDisplay=function(){
		$('body').addClass('w_1200');
	}
<?php }?>
$(window).resize(function(){websiteDisplay();});
websiteDisplay();
</script>
<div id="header" class="min">
	<div class="wrap">
        <?=web::logo();?>
		<div class="hr fr">
            <div class="h_lang fr"><?php web::get_theme_file("top_language.php");?></div>
            <div class="clear"></div>
            <div class="search fr">
                <form action="/search/" method="get">
                    <input type="text" name="Keyword" class="sea_t" placeholder="<?=$c['lang_pack']['search'];?>" />
                    <input type="submit" class="sea_b" value="" />
                </form>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php
$nav_set_time=@filemtime(web::get_cache_path(THEMES).'/nav.html');//文件生成时间
!$nav_set_time && $nav_set_time=0;
$set_cache=$c['time']-$nav_set_time-$c['cache_timeout'];	//当前时间 - 文件生成时间 - 自动生成静态文件时间间隔

if($set_cache>0 || !is_file(web::get_cache_path(THEMES).'/nav.html')){
	ob_start();
?>
<div id="nav" class="min">
	<div class="wrap">
		<?php
        $nav_value = db::get_value('config', 'GroupId="nav" and Variable="Headnav"', 'Value');
        $nav_row = str::json_data($nav_value, 'decode');
        foreach ($nav_row as $key=>$value){
            if ($value['Custom']){//自定义
                $url = $value['Url'];
                $name = $value['Name'.$c['lang']];
                $target = $value['CusNewTarget']?'target="_blank"':'';
            }else{
                $url = $c['nav_cfg'][$value['Nav']]['url'];
                $name = $c['nav_cfg'][$value['Nav']]['name'.$c['lang']];
                $target = $value['NewTarget']?'target="_blank"':'';
                //信息页，产品页要单独处理
                //下拉查询初始化
                $_table = $c['nav_cfg'][$value['Nav']]['table'];
                $sub_name = 'Category';
                $sub_id = 'CateId';//主键
                $sub_where = 'UId="0,"';
                if ($value['Nav']==6){//信息页
                    $name = db::get_value('article_category', "CateId='{$value['Page']}'", 'Category'.$c['lang']);
                    $temp_row = db::get_one('article', "CateId='{$value['Page']}'", "AId,CateId,Title{$c['lang']},Url,PageUrl", $c['my_order']."AId asc");//查询一条用于显示连接
                    $temp_row && $url = web::get_url($temp_row, 'article');
                    //下拉
                    $sub_name = 'Title';
                    $sub_id = 'AId';
                    $sub_where = "CateId='{$value['Page']}'";
                }else if ($value['Nav']==5 && $value['Cate']){//产品页并且设置了分类
                    $_cate = db::get_one('products_category', "CateId='{$value['Cate']}'", "CateId,UId,Category{$c['lang']}", $c['my_order'].'CateId asc');
                    $name = $_cate['Category'.$c['lang']];
                    $url = web::get_url($_cate, 'products_category');
                    //下拉
                    $sub_where = "UId='{$_cate['UId']}{$_cate['CateId']},'";
                }
                //if Nav 结束
            }//if 结束
            if(!$name) continue;
        ?>
            <div class="tem fl">
                <a href="<?=$url;?>" <?=$target;?> class="tem_a"><?=$name;?></a>
                <?php
                if ($value['Down'] && $_table){//是否有下拉
                    $sub_row = db::get_all($_table, $sub_where, '*', $c['my_order']."{$sub_id} asc");
                    if ($sub_row){
                ?>
                <div class="sub navigation">
                    <div class="list">
                        <?php foreach ($sub_row as $k=>$v){?>
                        	<div class="box">
                            	<div class="sign"><a href="<?=web::get_url($v, $_table);?>" title="<?=$v[$sub_name.$c['lang']];?>"><?=$v[$sub_name.$c['lang']];?></a></div>
                                <?php
									$__table=$_table=='article'?'article_category':$_table;
									$nav_sec = db::get_limit($__table,"UId='0,{$v['CateId']},'",'*',$c['my_order'].'CateId asc',0,5);
									foreach((array)$nav_sec as $kk => $vv){
										$name = $vv['Category'.$c['lang']];
										$url = web::get_url($vv,$__table);
								?>
                                	<div class="row"><a href="<?=$url;?>" title="<?=$name;?>"><?=$name;?></a></div>
                                <?php }?>
                            </div>
                        <?php }?>
                        <div class="clear"></div>
                    </div>
                </div><!-- end of .sub -->
                <?php }
                }?>
            </div>
        <?php }?>
        <div class="clear"></div>
    </div>
</div>
<?php 
	$cache_contents=ob_get_contents();
	ob_end_clean();
	file::write_file(web::get_cache_path(THEMES, 0), 'nav.html', $cache_contents);
	echo $cache_contents;
	unset($cache_contents);
}else{
	include(web::get_cache_path(THEMES).'/nav.html');
}
?>