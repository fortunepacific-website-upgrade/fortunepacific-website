<?php
$d_ary=array('list','category','edit');
$d=$_GET['d'];
!in_array($d, $d_ary) && $d=$d_ary[0];
//$language_default='_'.$c['manage']['language_default'];

if($d=='list' || $d=='category'){
	//获取类别列表
	$cate_ary=str::str_code(db::get_all('info_category','1','*'));
	$category_ary=array();
	foreach((array)$cate_ary as $v){
		$category_ary[$v['CateId']]=$v;
	}
	$category_count=count($category_ary);
	unset($cate_ary);
	
	$CateId=(int)$_GET['CateId'];
	if($CateId){
		$category_row=str::str_code(db::get_one('info_category', "CateId='$CateId'"));
		!$category_row && js::location('./?m=content&a=news');
		$UId=$category_row['UId'];
		$column=$category_row['Category'.$c['lang']];
	}
}

$allcate_row=db::get_all('info_category', '1', '*', $c['my_order'].'CateId asc');
$allcate_ary=array();
foreach($allcate_row as $k=>$v){
	$allcate_ary[$v['UId']][]=$v;
}
?>
<?=ly200::load_static('/static/js/plugin/jscrollpane/jquery.mousewheel.js', '/static/js/plugin/jscrollpane/jquery.jscrollpane.js', '/static/js/plugin/jscrollpane/jquery.jscrollpane.css', '/static/js/plugin/dragsort/dragsort-0.5.1.min.js', '/static/js/plugin/operamasks/operamasks-ui.css', '/static/js/plugin/operamasks/operamasks-ui.min.js', '/static/js/plugin/ckeditor/ckeditor.js');?>
<script language="javascript">$(document).ready(function(){news_obj.news_default_init()}); window.onresize=news_obj.frame_init;</script>
<div class="r_con_wrap r_category_wrap">
    <div id="news">
        <div class="sidebar page_menu fl">
            <div class="page_menu_hd">{/news.news.news/}{/news.classify/}<a href="./?m=content&a=news&d=category" class="add_btn fr" id="news_menu_add" title="{/global.add/}"><img src="/static/manage/images/frame/menu_add.png" /></a></div>
            <div class="clear"></div>
            <ul class="page_menu_list">
                <li cateid="0">
                    <div class="menu_one">
                        <h4 class="fl <?=!$CateId?'cur':'';?>"><a href="./?m=content&a=news">{/global.all/}</a></h4>
                    </div>
                </li>
                <?php
                $all_uid='0,';
                foreach((array)$allcate_ary[$all_uid] as $v){
                    $vCateId=$v['CateId'];
                ?>
                <li cateid="<?=$vCateId;?>">
                    <div class="menu_one">
                        <h4 class="fl<?=$CateId==$vCateId?' cur':'';?>"><a href="./?m=content&a=news&d=list&CateId=<?=$vCateId;?>" title="<?=$v['Category'.$c['lang']];?>"><?=$v['Category'.$c['lang']];?></a></h4>
                        <a class="del menu_view fr" href="./?do_action=content.news_category_del&CateId=<?=$vCateId;?>" title="{/global.del/}"><img src="/static/images/ico/del.png" alt="{/global.del/}" /></a>
                        <a class="edit menu_view fr" href="./?m=content&a=news&d=category&CateId=<?=$vCateId;?>" title="{/global.edit/}"><img src="/static/images/ico/edit.png" alt="{/global.edit/}" /></a>
                        <?php if($v['SubCateCount']){?><i class="menu_dot fr"></i><?php }?>
                        <div class="clear"></div>
                    </div>
                    <?php if($v['SubCateCount']){?>
                    <dl style="display:none;">
                        <?php
                        foreach($allcate_ary["{$all_uid}{$vCateId},"] as $v2){
                            $v2CateId=$v2['CateId'];
                        ?>
                        <dt cateid="<?=$v2CateId;?>">
                            <div class="sub menu_to">
                                <h5 class="sub_click fl<?=$CateId==$v2CateId?' cur':'';?>"><a href="./?m=content&a=news&d=list&CateId=<?=$v2CateId;?>" title="<?=$v2['Category'.$c['lang']];?>"><?=$v2['Category'.$c['lang']];?></a></h5>
                                <a class="del menu_view fr" href="./?do_action=content.news_category_del&CateId=<?=$v2CateId;?>" title="{/global.del/}"><img src="/static/images/ico/del.png" alt="{/global.del/}" /></a>
                                <a class="edit menu_view fr" href="./?m=content&a=news&d=category&CateId=<?=$v2CateId;?>" title="{/global.edit/}"><img src="/static/images/ico/edit.png" alt="{/global.edit/}" /></a>
                                <div class="clear"></div>
                            </div>
                        </dt>
                        <?php }?>
                    </dl>
                    <?php }?>
                </li>
                <?php }?>
            </ul>
        </div>
        <div class="view fr" id="news_edit">
        	<?php
        	if($d=='list'){
				//列表
				$Title=$_GET['Title'];
				$where='1';//条件
				$page_count=10;//显示数量
				$page = (int)$_GET['page'];
				$CateId && $where.=' and '.category::get_search_where_by_CateId($CateId, 'info_category');
				$Title && $where.=" and Title{$c['lang']} like '%$Title%'";
				$news_row=str::str_code(db::get_limit_page('info', $where, '*', $c['my_order'].'InfoId desc', $page, $page_count));
			?>
            	<div class="list_title">
                    <h1><?=$column?$column:'{/module.content.news/}';?></h1>
                    <div class="list_nav fr">
                        <ul class="panel fl">
                            <li><a class="panel_0" href="./?m=content&a=news&d=edit" id="news_add" title="{/global.add/}">{/global.add/}</a></li>
                            <li><a class="panel_8 my_order" href="javascript:void(0);" title="{/global.my_order/}">{/global.my_order/}</a></li>
                            <li><a class="panel_3 del_bat" href="javascript:void(0);" title="{/global.del_bat/}">{/global.del_bat/}</a></li>
                        </ul>
                        <div id="turn_page_oth" class="turn_page fl"><?=manage::turn_page($news_row[1], $news_row[2], $news_row[3], '?'.ly200::query_string('page').'&page=', '{/global.pre_page/}', '{/global.next_page/}');?></div>
                    </div>
                    <div class="list_search fr">
                        <form id="list_search_form">
                            <input type="text" name="Title" class="search_txt fl" value="" />
                            <input type="submit" class="search_btn fl" value="" />
                            <div class="clear"></div>
                        </form>
                    </div>
                </div>
                <div class="wrap_content clean news_list">
                	<div class="blank">
                        <table border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                            <thead>
                                <tr>
                                    <td width="4%"><input type="checkbox" name="select_all" value="" class="va_m anti" /></td>
                                    <td width="4%">{/global.serial/}</td>
                                    <td width="32%" nowrap="nowrap">{/news.title/}</td>
                                    <td width="17%" nowrap="nowrap">{/news.classify/}</td>
                                    <td width="8%" nowrap="nowrap">{/news.news.edit_time/}</td>
                                    <td width="8%" nowrap="nowrap">{/news.myorder/}</td>
                                    <td width="4%" nowrap="nowrap">{/global.operation/}</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
								($page<1 || $page>$news_row[3]) && $page=1;
								$start_row=($page-1)*$page_count;
                                $i=1;
                                foreach($news_row[0] as $v){
                                    $title=$v['Title'.$c['lang']];
                                    $url=ly200::get_url($v, 'info');
                                ?>
                                <tr>
                                    <td><input type="checkbox" name="select" value="<?=$v['InfoId'];?>" class="va_m" /></td>
                                    <td><?=$start_row+$i;?></td>
                                    <td><a class="title" href="<?=$url;?>" title="<?=$title;?>" target="_blank"><?=str::cut_str($title,50);?><?=$v['IsIndex']?'&nbsp;<span class="fc_red">({/products.products.is_index/})</span>':'';?></a></td>
                                    <td>
                                        <?php
                                        $UId=$category_ary[$v['CateId']]['UId'];
                                        if($UId){
                                            $key_ary=@explode(',',$UId);
                                            array_shift($key_ary);
                                            array_pop($key_ary);
                                            foreach($key_ary as $k2=>$v2){
                                                echo $category_ary[$v2]['Category'.$c['lang']].' -> ';
                                            }
                                        }
                                        echo $category_ary[$v['CateId']]['Category'.$c['lang']];
                                        ?>
                                    </td>
                                    <td><?=$v['AccTime']?date('Y-m-d', $v['AccTime']):'N/A';?></td>
                                    <td class="myorder" nowrap="nowrap"><?=ly200::form_select($c['manage']['language']['global']['my_order_ary'], "MyOrder[{$v['InfoId']}]", $v['MyOrder']);?></td>
                                    <td><a class="edit" href="./?m=content&a=news&d=edit&InfoId=<?=$v['InfoId'];?>" title="{/global.edit/}"><img src="/static/images/ico/edit.png" align="absmiddle" alt="{/global.edit/}" /></a></td>
                                </tr>
                                <?php ++$i;}?>
                            </tbody>
                        </table>
                    </div>
                    <div id="turn_page_oth" class="turn_page"><?=manage::turn_page($news_row[1], $news_row[2], $news_row[3], '?'.ly200::query_string('page').'&page=', '{/global.pre_page/}', '{/global.next_page/}');?></div>
                </div>
            <?php
			}elseif($d=='category'){
				//文章分类编辑
			?>
            	<script language="javascript">$(function (){news_obj.news_category_edit_init()});</script>
            	<div class="list_title">
                    <h1><?=$CateId?'{/global.edit/}':'{/global.add/}';?>{/news.classify/}</h1>
                </div>
                <div class="wrap_content clean news_list">
                    <form id="news_category_form" class="r_con_form">
                        <div class="rows">
                            <label>{/news.title/}</label>
                            <span class="input"><?=manage::form_edit($category_row, 'text', 'Category', 35, 50, 'notnull');?></span>
                            <div class="clear"></div>
                        </div>
                        <?php 
                            $max_dept=$c['manage']['category_dept']['news'];
                            if($max_dept>1){
                        ?>
                        <div class="rows">
                            <label>{/news.news_category.children/}:</label>
                            <span class="input">
                                <?php
                                $now_dept=$category_row['Dept']+$max_dept-(db::get_max('info_category', "UId like '{$category_row['UId']}{$category_row['CateId']},%'", 'Dept'));
                                $ext_where="CateId!='{$category_row['CateId']}' and Dept<".($category_row['SubCateCount']?$now_dept:$max_dept);
                                echo category::ouput_Category_to_Select('UnderTheCateId', category::get_CateId_by_UId($category_row['UId']), 'info_category', "UId='0,' and $ext_where", $ext_where);
                                ?>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <?php }?>
                        <div class="rows">
                            <label></label>
                            <span class="input">
                                <input type="submit" class="btn_ok" name="submit_button" value="{/global.submit/}" />
                                <a href="./?m=content&a=news&d=list&CateId=<?=$CateId;?>" class="btn_cancel mar_l_10">{/global.return/}</a>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <input type="hidden" name="CateId" value="<?=$CateId;?>" />
                        <input type="hidden" name="do_action" value="content.news_category_edit">
                    </form>
                </div>
			<?php
			}else{
				//文章编辑
				$InfoId=(int)$_GET['InfoId'];
				$news_row=str::str_code(db::get_one('info', "InfoId='$InfoId'"));
				$news_content_row=str::str_code(db::get_one('info_content', "InfoId='$InfoId'"));
			?>
            	<?=ly200::load_static('/static/js/plugin/daterangepicker/daterangepicker.css', '/static/js/plugin/daterangepicker/moment.min.js', '/static/js/plugin/daterangepicker/daterangepicker.js');?>
            	<script language="javascript">$(function (){news_obj.news_edit_init()});</script>
            	<div class="list_title">
                    <h1><?=$InfoId?'{/global.edit/}':'{/global.add/}';?>{/news.news.news/}</h1>
                </div>
            	<div class="wrap_content clean news_list">
                    <form id="news_form" name="news_form" class="r_con_form">
                        <div class="rows_box">
                            <div class="rows">
                                <label>{/news.title/}:</label>
                                <span class="input"><?=manage::form_edit($news_row, 'text', 'Title', 53, 150, 'notnull');?></span>
                                <div class="clear"></div>
                            </div>
                            <div class="rows">
                                <label>{/news.classify/}:</label>
                                <span class="input"><?=category::ouput_Category_to_Select('CateId', $news_row['CateId'], 'info_category', 'UId="0,"', 1, 'notnull');?></span>
                                <div class="clear"></div>
                            </div>
                            <div class="rows">
                                <label>{/news.news.external_links/}:</label>
                                <span class="input"><input name="Url" value="<?=$news_row['Url'];?>" type="text" class="form_input" size="53" maxlength="150" /><span class="notes_icon" content="{/news.news.links_notes/}"></span></span>
                                <div class="clear"></div>
                            </div>
                            <div class="rows">
                                <label>{/page.page.custom_url/}:</label>
                                <span class="input">
                                    <span class="price_input"><b>/info/<div class="arrow"><em></em><i></i></div></b><input name="PageUrl" value="<?=$news_row['PageUrl'];?>" type="text" class="form_input" size="53" maxlength="150" /><b class="last">.html</b></span><span class="notes_icon" content="{/page.page.custom_url_notes/}"></span>
                                </span>
                                <div class="clear"></div>
                            </div>
                            <div class="rows">
                                <label>{/news.news.edit_time/}:</label>
                                <span class="input"><input name="AccTime" value="<?=date('Y/m/d H:i:s', ($news_row['AccTime']?$news_row['AccTime']:$c['time']));?>" type="text" class="form_input" size="20" readonly></span>
                                <div class="clear"></div>
                            </div>
                            <div class="rows">
                                <label>{/products.picture/}:</label>
                                <span class="input">
                                    <span class="upload_file">
                                        <div>
                                            <input type="button" id="PicUpload" class="btn_ok upload_btn" name="submit_button" value="{/global.upload_pic/}" tips="<?=sprintf(manage::language('{/notes.pic_size_tips/}'), '100*100');?>" />
                                            <div class="tips"><?=sprintf(manage::language('{/notes.pic_size_tips/}'), '100*100');?></div>
                                            <div class="clear"></div>
                                        </div>
                                        <div class="img preview_pic" id="PicDetail"></div>
                                    </span>
                                </span>
                                <div class="clear"></div>
                            </div>
                            <div class="rows">
                                <label>{/products.products.briefdescription/}:</label>
                                <span class="input"><?=manage::form_edit($news_row, 'textarea', 'BriefDescription');?></span>
                                <div class="clear"></div>
                            </div>
                            <div class="rows">
                                <label>{/products.products.other/}{/products.products.attributes/}:</label>
                                <span class="input">
                                    <span class="choice_btn<?=$news_row['IsIndex']?' current':'';?> mar_r_0">{/products.products.is_index/}<input type="checkbox" value="1" name="IsIndex"<?=$news_row['IsIndex']?' checked':'';?> /></span><span class="notes_icon" content="{/news.news.index_notes/}"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                    {/products.myorder/}:<?=ly200::form_select($c['manage']['language']['global']['my_order_ary'], 'MyOrder', $news_row['MyOrder']);?><span class="notes_icon" content="{/news.news.myorder_notes/}"></span>
                                </span>
                                <div class="clear"></div>
                            </div>
                            <div class="rows">
                                <label>{/global.seo/}:</label>
                                <span class="input">
                                    <button class="open btn_ok">{/global.open/}</button>
                                    <div class="clear"></div>
                                    <div class="seo_hide" style="display:none;">
                                        <label>{/news.news.seo_title/}:</label>
                                        <div class="clear"></div>
                                        <span class="input"><?=manage::form_edit($news_row, 'text', 'SeoTitle', 35, 150);?></span>
                                        <div class="clear"></div>
                                        <label>{/news.news.seo_keyword/}:</label>
                                        <div class="clear"></div>
                                        <span class="input"><?=manage::form_edit($news_row, 'text', 'SeoKeyword', 35, 150);?></span>
                                        <div class="clear"></div>
                                        <label>{/news.news.seo_brief/}:</label>
                                        <div class="clear"></div>
                                        <span class="input"><?=manage::form_edit($news_row, 'textarea', 'SeoDescription');?></span>
                                        <div class="clear"></div>
                                    </div>
                                </span>
                                <div class="clear"></div>
                            </div>
                            <div class="rows">
                                <label>{/news.news.description/}:</label>
                                <span class="input"><?=manage::form_edit($news_content_row, 'editor', 'Content');?></span>
                                <div class="clear"></div>
                            </div>
                            
                            <div class="rows">
                                <label></label>
                                <span class="input">
                                    <input type="submit" class="btn_ok submit_btn" name="submit_button" value="{/global.submit/}" />
                                    <a href="./?m=content&a=news&d=list" class="btn_cancel mar_l_10">{/global.return/}</a>
                                </span>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <input type="hidden" id="InfoId" name="InfoId" value="<?=$InfoId;?>" />
                        <input type="hidden" name="PicPath" value="<?=$news_row['PicPath'];?>" />
                        <input type="hidden" name="PicPathHide" value="<?=$news_row['PicPath'];?>" />
                        <input type="hidden" name="do_action" value="content.news_edit" />
                    </form>
                </div>
			<?php }?>
        </div><!-- #news_edit end -->
    </div><!-- #news -->
</div>
