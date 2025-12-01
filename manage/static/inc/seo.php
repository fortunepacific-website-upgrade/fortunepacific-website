<?php
/*  SEO包含文件 */

$colum_lang=$c['manage']['language_default']?'_'.$c['manage']['language_default']:'';
$page_para=array(
    'content'	=>	array(
						'page'		=>	array('art', 'Title'),
						'info'		=>	array('info', 'Title'),
						'case'		=>	array('case', 'Name'),
						'blog'		=>	array('', 'Title')
					),
    'products'	=>	array(
						'products'	=>	array('', 'Name'),
						'category'	=>	array('', 'Category')
					)
);

$pre=$page_para[$c['manage']['module']][$c['manage']['action']][0];
$title_colum=$c['manage']['do']=='category_edit'?'Category':$page_para[$c['manage']['module']][$c['manage']['action']][1];

if($seo_row['CateId']){    //获取分类表名
    switch($c['manage']['action']){
        case 'page':$seo_category_table='article_category'; break;
        case 'info':$seo_category_table='info_category'; break;
        case 'case':$seo_category_table='case_category'; break;
        case 'category':
        case 'products':
            $seo_category_table='products_category';
        break;
        case 'blog':$seo_category_table='blog_category'; break;
    }
}

//非分类页面
$not_category_page=(!in_array($c['manage']['action'],array('blog', 'category')) && $c['manage']['do']!='category_edit');
?>
<script type="text/javascript">$(document).ready(function(){frame_obj.seo_include_init()});</script>
<input type="hidden" class="title_colum" value="<?=$title_colum;?>" />
<div class="seo_output_module_msg" data-m="<?=$c['manage']['module']?>" data-a="<?=$c['manage']['action']?>" data-d="<?=$c['manage']['do']?>"></div>
<div class="seo_container global_container" default-lang="<?=$c['manage']['language_default'];?>">
    <div class="big_title">
        {/global.seo.seo/}
        <span class="tool_tips_ico" content-width='430' content="{/global.seo.custom_url_notes/}"></span>
    </div>
    <div class="seo_show_area">
        <div class="title">
            <input type="text" disabled placeholder="<?=$seo_row['SeoTitle'.$colum_lang]?$seo_row['SeoTitle'.$colum_lang]:'{/global.seo.title/}';?>" />
        </div>
        <div class="link">
            <input disabled type="text" placeholder="<?=web::get_domain().'/'?><?=$not_category_page ? $pre.($seo_row['PageUrl']?@str_replace(array('-'.$Id.'.html','.html'),array('',''),$seo_row['PageUrl']).$seo_url_suf:'{/global.seo.custom_url/}').'.html' : ltrim(web::get_url($seo_row,$seo_category_table), '/');?>" />
            <input type="hidden" class="server_name" value="<?=web::get_domain();?>/<?=$pre?>" />
            <input type="hidden" class="suf" value="<?=$seo_url_suf;?>" />
        </div>
        <div class="brief">
            <textarea disabled contenteditable="false" placeholder="<?=$seo_row['SeoDescription'.$colum_lang]?$seo_row['SeoDescription'.$colum_lang]:'{/global.seo.description/}';?>"></textarea>
        </div>
    </div>
    <div class="rows clean translation">
        <label>{/global.seo.title/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
        <div class="input">
            <div class="middle_inline_block seo_title">
                <?=manage::form_edit($seo_row, 'text', 'SeoTitle', 49, 255, '');?>
            </div>
            <?php if((int)$c['FunVersion']==2){?><div class="middle_inline_block seo_button title_build">{/global.seo.title_build/}</div><?php }?>
        </div>
    </div>
    <?php if($not_category_page){?>
    <div class="rows clean">
        <label>{/global.seo.custom_url/}</label>
        <div class="input">
            <div class="unit_input middle_inline_block">
                <b>/<?=$pre?$pre."/":'';?><div class="arrow"><em></em><i></i></div></b>
                <input name="PageUrl" value="<?=@str_replace('.html','',$seo_row['PageUrl']);?>" type="text" class="box_input" size="53" maxlength="150" />
                <b class="last">.html</b>
            </div>
        </div>
    </div>
    <?php }?>
    <div class="rows clean translation">
        <label>{/global.seo.keyword/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
        <div class="input">
            <div class="middle_inline_block seo_keyword"><?=manage::form_edit($seo_row, 'text', 'SeoKeyword',49,255,'');?></div>
            <div class="middle_inline_block seo_button keyword_build">{/global.seo.keyword_build/}</div>
        </div>
    </div>
    <div class="rows clean translation">
        <label>{/global.seo.description/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
        <div class="input">
            <div class="middle_inline_block seo_description"><?=manage::form_edit($seo_row, 'textarea', 'SeoDescription');?></div>
            <div class="middle_inline_block seo_button desc_build">{/global.seo.desc_build/}</div>
        </div>
    </div>
</div>

<div id="seo_title_build" class="pop_form seo_tkd_build">
    <div id="seo_build" class="form w_1000">
        <div class="t"><h1>{/global.seo.title_build/}</h1><h2>×</h2></div>
        <div class="seo_search_form">
            <input type="text" name="Keyword" value="" class="form_input" size="15" autocomplete="off" />
            <input type="button" class="search_btn" value="{/global.seo.search/}" />
            <div class="clear"></div>
            <input type="hidden" name="do_action" value="action.seo_get_keywords" />
        </div>
        <div id="seo_build_form" class="global_form r_con_form">
            <table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
                <thead>
                    <tr>
                        <td width="30%" nowrap="nowrap">{/global.seo.related/}</td>
                        <td width="25%" nowrap="nowrap">{/global.seo.search_amount/}</td>
                        <td width="25%" nowrap="nowrap">{/global.seo.compete/}</td>
                        <td width="15%" class="center" nowrap="nowrap">{/global.operation/}</td>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <div class="no_data">{/global.seo.search_notes/}</div>
        </div>
        <div class="button">
            <a href="javascript:;" class="btn_global btn_submit">{/global.submit/}</a>
            <a href="javascript:;"><input type="button" class="btn_global btn_cancel" value="{/global.return/}"></a>
        </div>
    </div>
</div>
<div id="seo_description_build" class="pop_form seo_tkd_build">
    <div id="seo_build" class="form w_1000">
        <div class="t"><h1>{/global.seo.desc_build/}</h1><h2>×</h2></div>
        <div id="seo_build_form" class="global_form r_con_form">
            <table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
                <thead>
                    <tr>
                        <td width="90%" nowrap="nowrap">{/global.seo.desc_templet/}</td>
                        <td width="10%" class="center" nowrap="nowrap">{/global.operation/}</td>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <div class="no_data">{/error.no_data/}</div>
        </div>
        <div class="button">
            <a href="javascript:;"><input type="button" class="btn_global btn_cancel" value="{/global.return/}"></a>
        </div>
    </div>
</div>