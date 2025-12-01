<?php
$d_ary=array('edit','attr_edit');
$d=$_GET['d'];
!in_array($d, $d_ary) && $d=$d_ary[0];
//$language_default='_'.$c['manage']['language_default'];

$AttrId=(int)$_GET['AttrId'];
if($AttrId){
	$attribute_one=str::str_code(db::get_one('products_attribute', "AttrId='$AttrId'"));
	!$attribute_one && js::location('./?m=products&a=model');
	$column=$attribute_one['Name'];
}
?>
<?=ly200::load_static('/static/js/plugin/jscrollpane/jquery.mousewheel.js', '/static/js/plugin/jscrollpane/jquery.jscrollpane.js', '/static/js/plugin/jscrollpane/jquery.jscrollpane.css', '/static/js/plugin/dragsort/dragsort-0.5.1.min.js');?>
<script type="text/javascript">
$(document).ready(function(){
	products_obj.global_init();
	products_obj.model_frame_init();
});
window.onresize=function(){products_obj.model_frame_init();}
</script>
<div class="r_con_wrap r_category_wrap">
    <div id="category">
        <div class="page_menu fl">
            <div class="page_menu_hd">{/module.products.model/}<a href="./?m=products&a=model&d=edit" class="add_btn fr" id="model_add" title="{/global.add/}{/products.model.model/}"><img src="/static/manage/images/frame/menu_add.png" /></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="./?m=products&a=model&d=attr_edit" class="add_btn fr" id="attr_add" title="{/global.add/}{/products.attribute/}"><img src="/static/manage/images/frame/menu_add.png" /></a></div>
            <div class="clear"></div>
            <ul class="page_menu_list">
                <?php
                $products_attribute=str::str_code(db::get_all('products_attribute', 'ParentId=0', '*', $c['my_order'].'AttrId asc'));
                foreach($products_attribute as $v){
                    $vAttrId=$v['AttrId'];
                    $vName=$v['Name_'.$c['manage']['language_default']];
                    $products_to_attribute=str::str_code(db::get_all('products_attribute', "ParentId='{$vAttrId}'", '*', $c['my_order'].'AttrId asc'));
                ?>
                <li attrid="<?=$vAttrId;?>">
                    <div class="menu_one">
                        <h4 class="fl<?=$AttrId==$vAttrId?' cur':'';?>"><a href="javascript:void(0);" title="<?=$vName?>"><?=$vName?><?=$products_to_attribute?'('.count($products_to_attribute).')':'';?></a></h4>
                        <a class="del menu_view fr" href="./?do_action=products.products_model_del&AttrId=<?=$vAttrId;?>" title="{/global.del/}"><img src="/static/images/ico/del.png" alt="{/global.del/}" /></a>
                        <a class="edit menu_view fr" href="./?m=products&a=model&d=edit&AttrId=<?=$vAttrId;?>" title="{/global.edit/}"><img src="/static/images/ico/edit.png" alt="{/global.edit/}" /></a>
                        <?php if($products_to_attribute){?><i class="menu_dot fr"></i><?php }?>
                    </div>
                    <?php if($products_to_attribute){?>
                    <dl style="display:none;">
                        <?php
                        foreach($products_to_attribute as $v2){
                            $v2AttrId=$v2['AttrId'];
                            $v2Name=$v2['Name_'.$c['manage']['language_default']].($v2['CartAttr']?" ({/products.model.cart_attr/})":'').($v2['ColorAttr']?" ({/products.model.color_attr/})":'');
                        ?>
                        <dt attrid="<?=$v2AttrId;?>">
                            <div class="sub menu_to">
                                <h5 class="sub_click fl<?=$AttrId==$v2AttrId?' cur':'';?>" title="<?=$v2Name;?>"><?=$v2Name;?></h5>
                                <a class="del menu_view fr" href="./?do_action=products.products_model_del&AttrId=<?=$v2AttrId;?>" title="{/global.del/}"><img src="/static/images/ico/del.png" alt="{/global.del/}" /></a>
                                <a class="copy menu_view fr" href="./?m=products&a=model&do_action=products.products_attribute_copy&d=attr_edit&AttrId=<?=$v2AttrId;?>" title="{/global.copy/}"><img src="/static/images/ico/copy.png" alt="{/global.copy/}" /></a>
                            <a class="edit menu_view fr" href="./?m=products&a=model&d=attr_edit&AttrId=<?=$v2AttrId;?>" title="{/global.edit/}"><img src="/static/images/ico/edit.png" alt="{/global.edit/}" /></a>
                            </div>
                        </dt>
                        <?php }?>
                    </dl>
                    <?php }?>
                </li>
                <?php }?>
            </ul>
        </div>
        <div class="view fr" id="model_edit">
            <?php
            if($d=='edit'){
            ?>
            <div class="list_title">
                <h1><?=$attribute_one?$attribute_one['Name'.$c['lang']].' &gt; ':'';?><?=$AttrId?'{/global.edit/}':'{/global.add/}';?>{/products.model.model/}</h1>
            </div>
            <div class="wrap_content clean category_list">
                <form id="products_form" name="model_form" class="r_con_form">
                    <div class="rows">
                        <label>{/products.title/}</label>
                        <span class="input"><?=manage::form_edit($attribute_one, 'text', 'Name', 35, 50, 'notnull');?></span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows">
                        <label></label>
                        <span class="input">
                            <input type="submit" class="btn_ok" name="submit_button" value="{/global.save/}" />
                        </span>
                        <div class="clear"></div>
                    </div>
                    <input type="hidden" name="AttrId" value="<?=$AttrId;?>" />
                    <input type="hidden" name="do_action" value="products.products_model_edit">
                </form>
            </div>
            <?php
            }elseif($d=='attr_edit'){
                $copy=(int)$_GET['copy'];
                $Type=($attribute_one['Type']?$attribute_one['Type']:0);
                if($attribute_one){
                    $parent_attr_row=str::str_code(db::get_one('products_attribute', "AttrId='{$attribute_one['ParentId']}'"));
                }
                if($copy==1){
                    $column='{/global.copy/}';
                }elseif($AttrId){
                    $column='{/global.edit/}';
                }else{
                    $column='{/global.add/}';
                }
            ?>
            <div class="list_title">
                <h1><?=$parent_attr_row?$parent_attr_row['Name'.$c['lang']].' &gt; ':'';?><?=$column;?>{/products.attribute/}</h1>
            </div>
            <div class="wrap_content clean news_list">
                <form id="products_form" name="model_form" class="r_con_form">
                    <div class="rows">
                        <label>{/products.title/}</label>
                        <span class="input"><?=manage::form_edit($attribute_one, 'text', 'Name', 35, 50, 'notnull');?></span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows">
                        <label>{/products.model.children/}:</label>
                        <span class="input"><?=ly200::form_select(db::get_all('products_attribute','ParentId=0','*','AttrId asc'), 'ParentId', $attribute_one['ParentId'], 'Name_'.$c['manage']['language_default'], 'AttrId', "{/global.select_index/}", 'notnull');?> <font class="fc_red">*</font></span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows">
                        <label></label>
                        <span class="input">
                            <input type="submit" class="btn_ok" name="submit_button" value="{/global.save/}" />
                        </span>
                        <div class="clear"></div>
                    </div>
                    <input type="hidden" name="AttrId" value="<?=$AttrId;?>" />
                    <input type="hidden" name="do_action" value="products.products_attribute_edit">
                </form>
            </div>
            <?php
            }
            ?>
        </div>
    </div><!-- #category -->
	<?php
    //销毁变量
    unset($attribute_one);
    ?>
</div>