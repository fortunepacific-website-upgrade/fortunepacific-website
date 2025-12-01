<?php !isset($c) && exit();?>
<div class="navbg"><em></em></div>
<nav class="nav trans3">
    <?php if(count($c['config']['global']['Language'])>1||$c['config']['translate']['IsTranslate']){?>
    <div class="item c_lang font_col border_col <?=((int)$c['FunVersion'] && count($c['config']['global']['Language'])>1) || ($c['config']['translate']['TranLangs'] && $c['config']['translate']['IsTranslate']) ? 'hasub' : ''; ?>">
        <a href="javascript:;"><?=$c['lang_name'][trim($c['lang'],'_')];?></a>
        <div class="sub trans3">
            <div class="si cate_close">
                <a href="javascript:;" class="trans3 ovauto" title="<?//=$c['lang_pack']['all'].' '.$c['lang_pack']['cate']; ?>"><?//=$c['lang_pack']['all'].' '.$c['lang_pack']['cate']; ?></a>
            </div>
            <?php
            if(in_array(reset(explode('.', $_SERVER['HTTP_HOST'])), $c['config']['global']['Language']) || reset(explode('.', $_SERVER['HTTP_HOST']))=='www'){
                $dir=preg_replace('/^'.reset(explode('.', $_SERVER['HTTP_HOST'])).'\./i', '', $_SERVER['HTTP_HOST']);
            }else{
                $dir=$_SERVER['HTTP_HOST'];
            }
            $BrowserLanguage=(int)db::get_value('config', 'GroupId="global" and Variable="BrowserLanguage"', 'Value');
            foreach($c['config']['global']['Language'] as $v){
                if($v==$cur_lang){continue;}
                $dir_url='http://'.(($v==$c['config']['global']['LanguageDefault'] && !$BrowserLanguage)?'':$v.'.').$dir.($_SERVER['REQUEST_URI']!='/'?$_SERVER['REQUEST_URI']:'');
            ?>
            <div class="si">
                <a href='<?=$dir_url;?>'><?=$c['lang_name'][$v];?></a>
            </div>
            <?php }?>
           <?php 
            if($c['config']['translate']['IsTranslate']){
                $translate_url=urlencode(web::get_domain().$_SERVER['REQUEST_URI']);
                $from_lang=$cur_lang=='cn'?'cn':($cur_lang=='jp'?'ja':$cur_lang);
                $lang_link="https://translate.google.com/translate?sl=$from_lang&tl=%s&u=";
                foreach($c['config']['translate']['TranLangs'] as $v){
                    if ( @in_array($v, $c['config']['global']['Language']) || ($v=='ja' && @in_array('jp', $c['config']['global']['Language'])) ){continue;}
            ?>
            <div class="si">
                <a href="<?=sprintf($lang_link, $v).$translate_url;?>" target="_blank" title="<?=$c['translate'][$v][1];?>"><?=$c['translate'][$v][1];?></a>
            </div>
             <?php 
                }
            }
            ?>
        </div>
    </div>
    <?php }?>
    <?php if($head_account){ ?>
    	<?php if((int)$c['FunVersion'] && $c['config']['global']['IsOpenMember']){$h_bor =1; ?>
        <div class="head_account">
        	<span>
                <?php if((int)$_SESSION['ly200_user']['UserId']){?>
                    <a href="/account/"><?=$c['lang_pack']['user']['account'];?></a>
                    <em></em>
                    <a href="/account/logout.html"><?=$c['lang_pack']['mobile']['sign_out'];?></a>
                <?php }else{?>
            		<a href="/account/"><?=$c['lang_pack']['mobile']['sign_in'];?></a>
            		<em></em>
            		<a href="/account/sign-up.html"><?=$c['lang_pack']['mobile']['sign_up'];?></a>
                <?php } ?>
        	</span>
        </div>
        <?php } ?>
        <?php if($h_bor){ ?>
    	<div class="bor"></div>
        <?php } ?>
    <?php } 
    $all_category_row = db::get_all('products_category', '1', '*', $c['my_order'].'CateId asc');
    $uid_category_row = array();
    foreach((array)$all_category_row as $v){
        $uid_category_row[$v['UId']][] = $v;
    }
    $nav_value = db::get_value('config', 'GroupId="nav" and Variable="Headnav"', 'Value');
    $nav_row = str::json_data($nav_value, 'decode');
    foreach ($nav_row as $key=>$value){
    	if($value['Nav']==8 || $value['Nav']==9) continue;
        if ($value['Custom']){//自定义
            $url = $value['Url'];
            if(substr_count($url,'/sitemap.html')) continue;
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
        $sub_row = array();
        if ($value['Down'] && $_table){//是否有下拉
            $sub_row = db::get_all($_table, $sub_where, '*', $c['my_order']."{$sub_id} asc");
        }
        ?>
        <div class="item <?=$sub_row?'hasub':'';?>">
            <a class="a0" <?=$target;?> href="<?=$sub_row ? 'javascript:;' : $url;?>"><?=$name;?></a>
            <?php
            if ($sub_row){
            ?>
                <div class="sub trans3">
                    <div class="si cate_close">
                        <a href="javascript:;" class="trans3 ovauto" title="<?//=$c['lang_pack']['all'].' '.$c['lang_pack']['cate']; ?>"><?//=$c['lang_pack']['all'].' '.$c['lang_pack']['cate']; ?></a>
                    </div>
                    <?php foreach ($sub_row as $k=>$v){?>
                    <div class="si <?=$uid_category_row["0,{$v['CateId']},"] && $value['Nav']==5 ? 'hsec_sub' : '' ; ?>">
                        <a href="<?=web::get_url($v, $_table);?>" class="trans3 ovauto" title="<?=$v[$sub_name.$c['lang']];?>"><?=$v[$sub_name.$c['lang']];?></a>
                    </div>
                    <?php }?>
                </div>
            <?php
            }?>
        </div>
    <?php }?>
    <?php if($c['config']['global']['IsOpenInq']){ $h_bor =1; ?>
    <div class="head_inquiry">
        <a href="/inquiry.html" class="pic"></a>
        <a href="/inquiry.html" class="name"><?=$c['lang_pack']['inq_cart'];?></a>
    </div>
    <?php } ?>
</nav>
<div class="sec_nav trans3"></div>