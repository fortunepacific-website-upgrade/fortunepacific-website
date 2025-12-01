<?php !isset($c) && exit();?>
<script>$(function(){if($('.h_nav li').length==0){$('.h_nav').hide();}});</script>
<?php 
$nav_row = db::get_one('config', 'GroupId="nav" and Variable="Topnav"');
$nav_data = str::json_data($nav_row['Value'], 'decode');
$cur_lang=substr($c['lang'], 1);
?>
<ul class="h_nav fr">
	<?php
		foreach ($nav_data as $key=>$value){
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
					$temp_row = db::get_one('article', "CateId='{$value['Page']}'", "AId,CateId,Title{$c['lang']},PageUrl", $c['my_order']."AId asc");//查询一条用于显示连接
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
	?>
        <li class=""><a href="<?=$url;?>" <?=$target;?>><?=$name;?></a></li>
        <?php if($key+1!=count($nav_data)){?><li class="line">|</li><?php }?>
    <?php }?>
	<?php if(((int)$c['FunVersion'] && count($c['config']['global']['Language'])>1) || ($c['config']['translate']['TranLangs'] && $c['config']['translate']['IsTranslate'])){?>
        <li class="line">|</li>
        <li class="lang">
            <a href="#" class='cur'><?=$c['lang_name'][$cur_lang];?></a>
            <?php
			if(in_array(reset(explode('.', $_SERVER['HTTP_HOST'])), $c['config']['global']['Language']) || reset(explode('.', $_SERVER['HTTP_HOST']))=='www'){
				$dir=preg_replace('/^'.reset(explode('.', $_SERVER['HTTP_HOST'])).'\./i', '', $_SERVER['HTTP_HOST']);
			}else{
				$dir=$_SERVER['HTTP_HOST'];
			}
			?>
            <div class="language_silder" <?=(!empty($tranLangs) ? "style='width:auto;'" : "")?>>
				<?php //print_r($_SERVER);
                foreach($c['config']['global']['Language'] as $v){
                    if($v==$cur_lang){continue;}
                    $dir_url=($_SERVER['REQUEST_SCHEME']=='https'||$_SERVER['SERVER_PORT']==443?'https://':'http://').(($v==$c['config']['global']['LanguageDefault'])?'':$v.'.').$dir.($_SERVER['REQUEST_URI']!='/'?$_SERVER['REQUEST_URI']:'');
                ?>
                    <div class="l_rows"><a href='<?=$dir_url;?>'><?=$c['lang_name'][$v];?></a></div>
                <?php }?>
                <?php 
				if($c['config']['translate']['IsTranslate']){
					$translate_url=urlencode(web::get_domain().$_SERVER['REQUEST_URI']);
					$from_lang=$cur_lang=='cn'?'cn':($cur_lang=='jp'?'ja':$cur_lang);
					$lang_link="https://translate.google.com/translate?sl=$from_lang&tl=%s&u=";
					foreach($c['config']['translate']['TranLangs'] as $v){
						if ( @in_array($v, $c['config']['global']['Language']) || ($v=='ja' && @in_array('jp', $c['config']['global']['Language'])) ){continue;}
				?>
                    <div class="l_rows"><a href="<?=sprintf($lang_link, $v).$translate_url;?>" target="_blank" title="<?=$c['translate'][$v][1];?>"><?=$c['translate'][$v][1];?></a></div>
                <?php 
					}
				}
				?>
            </div>
        </li>
    <?php }?>
    <?php if((int)$c['config']['global']['IsOpenInq']){?>
        <li class="line">|</li>
        <li class="inquiry"><a href="/inquiry.html"><?=$c['lang_pack']['inquiry_cart'];?></a></li>
    <?php }?>
    <?php if((int)$c['FunVersion'] && $c['config']['global']['IsOpenMember']){?>
        <li class="line">|</li>
        <?php if((int)$_SESSION['ly200_user']['UserId']){?>
            <li class="member"><a href="/account/"><?=$c['lang_pack']['user']['account'];?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/account/logout.html"><?=$c['lang_pack']['user']['logout'];?></a></li>
        <?php }else{?>
            <li class="member"><a href="javascript:;" class="SignInButton"><?=$c['lang_pack']['user']['login'];?></a> <?=$c['lang_pack']['user']['or'];?>&nbsp;&nbsp;<a href="/account/sign-up.html"><?=$c['lang_pack']['user']['reg'];?></a></li>
        <?php }?>
		<?=ly200::load_static('/static/css/user.css', '/static/js/user.js');?>
        <script type="text/javascript">$(document).ready(function(){account_obj.sign_in_init();});</script>
    <?php }?>
    <?php /*Google翻译*/?>
    <?php /*?><li class="line">|</li>
    <li><div id="google_translate_element"></div></li>
	<script type="text/javascript">
    function googleTranslateElementInit() {
      new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, multilanguagePage: true}, 'google_translate_element');
    }
    </script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script><?php */?>
    <?php /*Google翻译*/?>
</ul>
<script type="text/javascript">
$(document).ready(function(){
	var hli=$('ul.h_nav li');
	if(hli.length){
		if(hli.eq(0).hasClass('line')) hli.eq(0).remove();
	}else{
		hli.parent().remove();
	}
});
</script>
