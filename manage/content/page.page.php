<?php
$d_ary=array('list','category','edit');
$d=$_GET['d'];
!in_array($d, $d_ary) && $d=$d_ary[0];
//$language_default='_'.$c['manage']['language_default'];

if($d=='list' || $d=='category'){
	//获取类别列表
	$cate_ary=str::str_code(db::get_all('article_category','1','*'));
	$category_ary=array();
	foreach((array)$cate_ary as $v){
		$category_ary[$v['CateId']]=$v;
	}
	$category_count=count($category_ary);
	unset($cate_ary);
	
	$CateId=(int)$_GET['CateId'];
	if($CateId){
		$category_one=str::str_code(db::get_one('article_category', "CateId='$CateId'"));
		!$category_one && js::location('./?m=content&a=page');
		$UId=$category_one['UId'];
		$column=$category_one['Category'.$c['lang']];
	}
}
?>
<?=ly200::load_static('/static/js/plugin/jscrollpane/jquery.mousewheel.js', '/static/js/plugin/jscrollpane/jquery.jscrollpane.js', '/static/js/plugin/jscrollpane/jquery.jscrollpane.css', '/static/js/plugin/dragsort/dragsort-0.5.1.min.js', '/static/js/plugin/operamasks/operamasks-ui.css', '/static/js/plugin/operamasks/operamasks-ui.min.js', '/static/js/plugin/ckeditor/ckeditor.js');?>
<script type="text/javascript">
$(document).ready(function(){page_obj.page_default_init();window.onresize=page_obj.frame_init;});
</script>
<div class="r_con_wrap r_category_wrap">
    <div id="page">
        <div class="sidebar page_menu fl">
            <div class="page_menu_hd">{/page.page.page/}{/page.classify/}<a href="./?m=content&a=page.page&d=category" class="add_btn fr" id="page_menu_add" title="{/global.add/}"><img src="/static/manage/images/frame/menu_add.png" /></a></div>
            <ul class="page_menu_list">
                <li cateid="0">
                    <div class="menu_one">
                        <h4 class="fl <?=!$CateId?'cur':'';?>"><a href="./?m=content&a=page.page&d=list">{/global.all/}</a></h4>
                    </div>
                </li>
                <?php
                $page_category=str::str_code(db::get_all('article_category', 'UId="0,"', '*', $c['my_order'].'CateId asc'));
                foreach($page_category as $v){
                    $vCateId=$v['CateId'];
                ?>
                <li cateid="<?=$vCateId;?>">
                    <div class="menu_one">
                        <h4 class="fl<?=$CateId==$vCateId?' cur':'';?>"><a href="./?m=content&a=page.page&d=list&CateId=<?=$vCateId;?>" title="<?=$v['Category'.$c['lang']];?>"><?=$v['Category'.$c['lang']];?></a></h4>
                        <?php if($vCateId>3){?><a class="del menu_view fr" href="./?do_action=content.page_category_del&CateId=<?=$vCateId;?>" title="{/global.del/}"><img src="/static/images/ico/del.png" alt="{/global.del/}" /></a><?php }?>
                        <a class="edit menu_view fr" href="./?m=content&a=page.page&d=category&CateId=<?=$vCateId;?>" title="{/global.edit/}"><img src="/static/images/ico/edit.png" alt="{/global.edit/}" /></a>
                    </div>
                </li>
                <?php }?>
            </ul>
        </div>
        <div class="view fr" id="page_edit">
            <?php
            if($d=='list'){
                //供应商列表
                $where='1';//条件
                $page_count=10;//显示数量
				$page = (int)$_GET['page'];
                $CateId && $where.=" and CateId='$CateId'";
                $page_row=str::str_code(db::get_limit_page('article', $where, '*', $c['my_order'].'AId desc', $page, $page_count));
            ?>
                <div class="list_title">
                	<h1><?=$column?$column:'{/page.page.all/}';?></h1>
                    <div class="list_nav fr">
                        <ul class="panel fl">
                            <li><a class="panel_0" href="./?m=content&a=page.page&d=edit" id="page_add" title="{/global.add/}">{/global.add/}</a></li>
                            <li><a class="panel_8 my_order" href="javascript:void(0);" title="{/global.my_order/}">{/global.my_order/}</a></li>
                            <li><a class="panel_3 del_bat" href="javascript:void(0);" title="{/global.del_bat/}">{/global.del_bat/}</a></li>
                        </ul>
                        <div id="turn_page_oth" class="turn_page fl"><?=manage::turn_page($page_row[1], $page_row[2], $page_row[3], '?'.ly200::query_string('page').'&page=', '{/global.pre_page/}', '{/global.next_page/}');?></div>
                    </div>
                </div>
                <div class="wrap_content clean news_list">
                	<div class="blank">
                        <table border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                            <thead>
                                <tr>
                                    <td width="4%"><input type="checkbox" name="select_all" value="" class="va_m anti" /></td>
                                    <td width="4%">{/global.serial/}</td>
                                    <td width="35%" nowrap="nowrap">{/page.title/}</td>
                                    <td width="20%" nowrap="nowrap">{/page.classify/}</td>
                                    <td width="8%" nowrap="nowrap">{/page.myorder/}</td>
                                    <td width="4%" nowrap="nowrap">{/global.operation/}</td>
                                </tr>
                            </thead>
                            <tbody>
								<?php
								($page<1 || $page>$page_row[3]) && $page=1;
								$start_row=($page-1)*$page_count;
								$i=1;
								foreach($page_row[0] as $v){
									$title=$v['Title'.$c['lang']];
									$url=ly200::get_url($v, 'article');
								?>
                                <tr>
                                    <td><input type="checkbox" name="select" value="<?=$v['AId'];?>" class="va_m" /></td>
                                    <td><?=$start_row+$i;?></td>
                                    <td><a class="title" href="<?=$url;?>" title="<?=$title;?>" target="_blank"><?=$title;?></a></td>
                                    <td><?=$category_ary[$v['CateId']]['Category'.$c['lang']];?></td>
                                    <td class="myorder" nowrap="nowrap"><?=ly200::form_select($c['manage']['language']['global']['my_order_ary'], "MyOrder[{$v['AId']}]", $v['MyOrder']);?></td>
                                    <td><a class="edit" href="./?m=content&a=page.page&d=edit&AId=<?=$v['AId'];?>" title="{/global.edit/}"><img src="/static/images/ico/edit.png" alt="{/global.edit/}" align="absmiddle" /></a></td>
                                </tr>
                                <?php ++$i;}?>
                            </tbody>
                    	</table>
                    </div>
                    <?php /*?><div class="list_bd">
                        <?php
                        $i=1;
                        foreach($page_row[0] as $v){
                            $title=$v['Title'.$c['lang']];
                            $url=ly200::get_url($v, 'article');
                        ?>
                        <div class="rows">
                            <div class="checkbox fl"><input type="checkbox" name="select" value="<?=$v['AId'];?>" class="va_m" /></div>
                            <div class="box fr">
                                <a class="title" href="<?=$url;?>" title="<?=$title;?>" target="_blank"><?=$title;?></a>
                                <p><?='From '.$category_ary[$v['CateId']]['Category'.$c['lang']].' | '.date('d F Y', $v['AccTime']);?></p>
                                <div class="myorder">{/global.myorder/}: <?=ly200::form_select($c['manage']['language']['global']['my_order_ary'], "MyOrder[{$v['AId']}]", $v['MyOrder']);?></div>
                                <a class="edit" href="./?m=content&a=page.page&d=edit&AId=<?=$v['AId'];?>" title="{/global.edit/}"><img src="/static/images/ico/edit.png" alt="{/global.edit/}" align="absmiddle" /></a>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <?php }?>
                    </div>
                    <div class="blank20"></div>
                    <div id="turn_page_oth" class="turn_page"><?=manage::turn_page($page_row[1], $page_row[2], $page_row[3], '?'.ly200::query_string('page').'&page=', '{/global.pre_page/}', '{/global.next_page/}');?></div><?php */?>
                </div>
            <?php
            }elseif($d=='category'){
                //单页分类编辑
            ?>
            	<script type="text/javascript">
				$(document).ready(function(){page_obj.page_category_edit_init();});
				</script>
            	<div class="list_title">
                    <h1><?=$CateId?'{/global.edit/}':'{/global.add/}';?>{/page.classify/}</h1>
                </div>
            	<div class="wrap_content clean news_list">
                    <form id="page_category_form" class="r_con_form">
                        <div class="rows">
                            <label>{/page.title/}:</label>
                            <span class="input"><?=manage::form_edit($category_one, 'text', 'Category', 35, 50, 'notnull');?></span>
                            <div class="clear"></div>
                        </div>
                        <?php /*?><div class="rows">
                            <label>{/global.seo/}:</label>
                            <span class="input">
                                <div class="seo_hide">
                                    <label>{/page.page.seo_title/}:</label>
                                    <div class="clear"></div>
                                    <span class="input"><?=manage::form_edit($category_one, 'text', 'SeoTitle', 35, 150);?></span>
                                    <div class="clear"></div>
                                    <label>{/page.page.seo_keyword/}:</label>
                                    <div class="clear"></div>
                                    <span class="input"><?=manage::form_edit($category_one, 'text', 'SeoKeyword', 35, 150);?></span>
                                    <div class="clear"></div>
                                    <label>{/page.page.seo_brief/}:</label>
                                    <div class="clear"></div>
                                    <span class="input"><?=manage::form_edit($category_one, 'textarea', 'SeoDescription');?></span>
                                    <div class="clear"></div>
                                </div>
                            </span>
                            <div class="clear"></div>
                        </div><?php */?>
                        <div class="rows">
                            <label></label>
                            <span class="input">
                                <input type="submit" class="btn_ok" name="submit_button" value="{/global.submit/}" />
                                <a href="./?m=content&a=page.page&d=list&CateId=<?=$CateId;?>" class="btn_cancel mar_l_10">{/global.return/}</a>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <input type="hidden" name="CateId" value="<?=$CateId;?>" />
                        <input type="hidden" name="do_action" value="content.page_category_edit">
                    </form>
                </div>
            <?php
            }else{
                //单页编辑
                $AId=(int)$_GET['AId'];
                $page_row=str::str_code(db::get_one('article', "AId='$AId'"));
                $page_content_row=str::str_code(db::get_one('article_content', "AId='$AId'"));
            ?>
				<script type="text/javascript">
                $(document).ready(function(){page_obj.page_edit_init()});
                </script>
            	<div class="list_title">
                    <h1><?=$AId?'{/global.edit/}':'{/global.add/}';?>{/page.page.page/}</h1>
                </div>
            	<div class="wrap_content clean news_list">
                    <form id="page_form" name="page_form" class="r_con_form">
                        <div class="rows_box">
                            <div class="rows">
                                <label>{/page.title/}:</label>
                                <span class="input"><?=manage::form_edit($page_row, 'text', 'Title', 53, 150, 'notnull');?></span>
                                <div class="clear"></div>
                            </div>
                            <div class="rows">
                                <label>{/page.classify/}:</label>
                                <span class="input"><?=category::ouput_Category_to_Select('CateId', $page_row['CateId'], 'article_category', 'UId="0,"', 1, 'notnull');?></span>
                                <div class="clear"></div>
                            </div>
                            <div class="rows">
                                <label>{/page.page.external_links/}:</label>
                                <span class="input"><input name="Url" value="<?=$page_row['Url'];?>" type="text" class="form_input" size="53" maxlength="150" /><span class="notes_icon" content="{/page.page.links_notes/}"></span></span>
                                <div class="clear"></div>
                            </div>
                            <?php /*?><div class="rows">
                                <label>{/page.page.custom_url/}:</label>
                                <span class="input"><input name="PageUrl" value="<?=$page_row['PageUrl'];?>" type="text" class="form_input" size="53" maxlength="150" /><span class="notes_icon" content="{/page.page.custom_url_notes/}"></span></span>
                                <div class="clear"></div>
                            </div>
                            <?php */?>
                            <div class="rows">
                                <label>{/page.page.isfeed/}:</label>
                                <span class="input">
                                    <div class="switchery<?=$page_row['IsFeed']?' checked':'';?>">
                                        <input type="checkbox" name="IsFeed" value="1"<?=$page_row['IsFeed']?' checked':'';?>>
                                        <div class="switchery_toggler"></div>
                                        <div class="switchery_inner">
                                            <div class="switchery_state_on"></div>
                                            <div class="switchery_state_off"></div>
                                        </div>
                                    </div>
                                </span>
                                <div class="clear"></div>
                            </div>
                            
                            <div class="rows">
                                <label>{/products.myorder/}:</label>
                                <span class="input"><?=ly200::form_select($c['manage']['language']['global']['my_order_ary'], 'MyOrder', $page_row['MyOrder']);?><span class="notes_icon" content="{/page.page.myorder_notes/}"></span></span>
                                <div class="clear"></div>
                            </div>
                            <div class="rows">
                                <label>{/global.seo/}:</label>
                                <span class="input">
                                    <button class="open btn_ok">{/global.open/}</button>
                                    <div class="clear"></div>
                                    <div class="seo_hide" style="display:none;">
                                        <label>{/page.page.seo_title/}:</label>
                                        <div class="clear"></div>
                                        <span class="input"><?=manage::form_edit($page_row, 'text', 'SeoTitle', 35, 150);?></span>
                                        <div class="clear"></div>
                                        <label>{/page.page.seo_keyword/}:</label>
                                        <div class="clear"></div>
                                        <span class="input"><?=manage::form_edit($page_row, 'text', 'SeoKeyword', 35, 150);?></span>
                                        <div class="clear"></div>
                                        <label>{/page.page.seo_brief/}:</label>
                                        <div class="clear"></div>
                                        <span class="input"><?=manage::form_edit($page_row, 'textarea', 'SeoDescription');?></span>
                                        <div class="clear"></div>
                                    </div>
                                </span>
                                <div class="clear"></div>
                            </div>
                            <div class="rows">
                                <label>{/page.page.description/}:</label>
                                <span class="input"><?=manage::form_edit($page_content_row, 'editor', 'Content');?></span>
                                <div class="clear"></div>
                            </div>
                            
                            <div class="rows">
                                <label></label>
                                <span class="input">
                                    <input type="submit" class="btn_ok submit_btn" name="submit_button" value="{/global.submit/}" />
                                    <a href="./?m=content&a=page.page&d=list" class="btn_cancel mar_l_10">{/global.return/}</a>
                                </span>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <input type="hidden" id="AId" name="AId" value="<?=$AId;?>" />
                        <input type="hidden" name="do_action" value="content.page_edit" />
                    </form>
				</div>
            <?php }?>
            
        </div><!-- #page_edit -->
    </div><!-- #page -->
</div>