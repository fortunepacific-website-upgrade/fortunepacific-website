<?php
!isset($c) && exit();
$settings_row=ly200::ad_custom(100);
?>
<div id="ft" class="min">
	<div class="wrap">
    	<div class="list cont fl">
        	<div class="sign"><?=$c['lang_pack']['cont'];?></div>
            <div class="note"><?=$settings_row['Title'][0];?></div>
            <div class="row tel"><?=$c['config']['global']['Contact']['tel'];?></div>
            <div class="row mail"><a href="mailto:<?=$c['config']['global']['Contact']['email']?>" title="<?=$c['config']['global']['Contact']['email']?>"><?=$c['config']['global']['Contact']['email']?></a></div>
            <div class="row add"><?=$c['config']['global']['Contact']['address'.$c['lang']];?></div>
        </div>
        <?php
			$nav_value = db::get_value('config', 'GroupId="nav" and Variable="Footnav"', 'Value');
			$nav_row = str::json_data($nav_value, 'decode');
			$len = count($nav_row);
			$i=0;
			foreach ($nav_row as $key=>$value){
			if ($i>=3){break;}
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
			$i++;
		?>
        <div class="list fl">
        	<div class="sign"><?=$name;?></div>
            <?php
			if ($value['Down'] && $_table){//是否有下拉
				$sub_row = db::get_all($_table, $sub_where, '*', $c['my_order']."{$sub_id} asc");
				if ($sub_row){
					foreach($sub_row as $v){
			?>
            	<div class="cate"><a href="<?=web::get_url($v, $_table);?>" title="<?=$v[$sub_name.$c['lang']];?>"><?=$v[$sub_name.$c['lang']];?></a></div>
            <?php }
				}
			}?>
        </div>
        <?php }?>
        <div class="clear"></div>
    </div>
</div>
<div id="fm" class="min">
	<div class="wrap">
    	<div class="fl copyright">
        	<?=$c['config']['global']['Contact']['copyright'.$c['lang']].($c['config']['global']['powered_by']!=''?'&nbsp;&nbsp;&nbsp;&nbsp;'.$c['config']['global']['powered_by']:'');?>
        </div>
        <div class="fr">
        </div>
        <div class="clear"></div>
    </div>
</div>
<?=web::output_third_code();?>
<?php include($c['static_path']."/inc/global/online_chat.php");?>
<?php include($c['static_path']."/inc/global/chat.php");?>