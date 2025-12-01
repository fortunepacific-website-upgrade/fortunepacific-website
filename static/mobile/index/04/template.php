<?php !isset($c) && exit();?>
<?php
$category_row=str::str_code(db::get_all('products_category', 'UId = "0,"', "CateId,UId,Category{$c['lang']},PicPath",  $c['my_order'].'CateId asc'));
$ad_row = ly200::ad_custom(1);
?>
<div class="wrapper">
	<div class="banner" id="banner_box">
        <ul>
            <?php
            for ($i=$sum=0; $i<$ad_row['Count']; $i++){
				if (!is_file($c['root_path'].$ad_row['PicPath'][$i])){continue;}
				$sum++;
            ?>
            <li><a href="<?=$ad_row['Url'][$i]?$ad_row['Url'][$i]:'javascript:void(0)';?>"><img src="<?=$ad_row['PicPath'][$i];?>" alt="<?=$ad_row['Title'][$i];?>"></a></li>
            <?php }?>
        </ul>
        <div class="btn">
        	<?php for ($i=0; $i<$sum; $i++){?>
            <span class="<?=$i==0?'on':'';?>"></span>
            <?php }?>
        </div>
    </div>
    
    <div class="home_list">
		<?php
        $nav_value = db::get_value('config', 'GroupId="nav" and Variable="Headnav"', 'Value');
        $nav_row = str::json_data($nav_value, 'decode');
        foreach ($nav_row as $key=>$value){
            if($value['Nav']==8) continue;
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
                    $_cate = db::get_one('products_category', "CateId='{$value['Cate']}'", "CateId,UId,Category{$c['lang']}");
                    $name = $_cate['Category'.$c['lang']];
                    $url = web::get_url($_cate, 'products_category');
                    //下拉
                    $sub_where = "UId='{$_cate['UId']}{$_cate['CateId']},'";
                }
                //if Nav 结束
            }//if 结束
            if(!$name) continue;
            if($value['Nav']==0) continue;
            $sub_row = array();
            if ($value['Down'] && $_table){//是否有下拉
                $sub_row = db::get_all($_table, $sub_where, '*', $c['my_order']."{$sub_id} asc");
            }
            ?>
            <div class="item"><a href="<?=$url;?>"><?=$name;?></a></div>
        <?php }?>
    </div><!-- end of .home_list -->
    
</div><!-- end of .wrapper -->
