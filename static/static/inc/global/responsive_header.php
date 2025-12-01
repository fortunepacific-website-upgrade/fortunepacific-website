<?php !isset($c) && exit();?>
<div class="ueeshop_responsive_header">
	<div class="header">
		<?=web::logo();?>
		<div class="func">
			<div class="btn search_btn"></div>
			<?php
			if(((int)$c['FunVersion'] && count($c['config']['global']['Language'])>1) || ($c['config']['translate']['TranLangs'] && $c['config']['translate']['IsTranslate'])){
				$cur_lang=substr($c['lang'], 1);
			?>
				<div class="btn language_btn"><?=$c['lang_name'][$cur_lang];?></div>
			<?php }?>
			<div class="btn menu_btn"></div>
		</div>
	</div>
	<div class="search_box trans">
		<div class="close_btn"><span></span></div>
		<div class="clear"></div>
		<form class="search" action="/search/" method="get">
            <input type="text" class="" name="Keyword" placeholder="Search Our Catalog" />
            <input type="submit" class="" value="" />
            <div class="clear"></div>
        </form>
	</div>
	<div class="language trans">
		<div class="close_btn"><span></span></div>
		<div class="content">
			<?php
			if(((int)$c['FunVersion'] && count($c['config']['global']['Language'])>1) || ($c['config']['translate']['TranLangs'] && $c['config']['translate']['IsTranslate'])){
				if(in_array(reset(explode('.', $_SERVER['HTTP_HOST'])), $c['config']['global']['Language']) || reset(explode('.', $_SERVER['HTTP_HOST']))=='www'){
					$dir=preg_replace('/^'.reset(explode('.', $_SERVER['HTTP_HOST'])).'\./i', '', $_SERVER['HTTP_HOST']);
				}else{
					$dir=$_SERVER['HTTP_HOST'];
				}
				foreach($c['config']['global']['Language'] as $v){
					if($v==$cur_lang){continue;}
					$dir_url='http://'.(($v==$c['config']['global']['LanguageDefault'])?'':$v.'.').$dir.($_SERVER['REQUEST_URI']!='/'?$_SERVER['REQUEST_URI']:'');
					printf('<div class="list"><a href="%s">%s</a></div>', $dir_url, $c['lang_name'][$v]);
				}
			}
			if($c['config']['translate']['IsTranslate']){
				$translate_url=urlencode(web::get_domain().$_SERVER['REQUEST_URI']);
				$from_lang=$cur_lang=='cn'?'cn':($cur_lang=='jp'?'ja':$cur_lang);
				$lang_link="https://translate.google.com/translate?sl=$from_lang&tl=%s&u=";
				foreach($c['config']['translate']['TranLangs'] as $v){
					if(@in_array($v, $c['config']['global']['Language']) || ($v=='ja' && @in_array('jp', $c['config']['global']['Language']))){continue;}
					printf('<div class="list"><a href="%s" target="_blank" title="%s">%s</a></div>', sprintf($lang_link, $v).$translate_url, $c['translate'][$v][1], $c['translate'][$v][1]);
				}
			}
			?>
		</div>
	</div>
	<div class="nav trans">
		<?php
		$all_category_row=str::str_code(db::get_all('products_category', '1', '*', $c['my_order'].'CateId asc'));
		$uid_category_row=array();
		foreach((array)$all_category_row as $v){
			$uid_category_row[$v['UId']][]=$v;
		}
		$nav_value=db::get_value('config', 'GroupId="nav" and Variable="Headnav"', 'Value');
		$nav_row=str::json_data($nav_value, 'decode');
		foreach($nav_row as $key=>$value){
			if($value['Custom']){//自定义
				$url=$value['Url'];
				$name=$value['Name'.$c['lang']];
				$target=$value['CusNewTarget']?'target="_blank"':'';
			}else{
				$url=$c['nav_cfg'][$value['Nav']]['url'];
				$name=$c['nav_cfg'][$value['Nav']]['name'.$c['lang']];
				$target=$value['NewTarget']?'target="_blank"':'';
				//信息页，产品页要单独处理
				//下拉查询初始化
				$_table=$c['nav_cfg'][$value['Nav']]['table'];
				$sub_name='Category';
				$sub_id='CateId';//主键
				$sub_where='UId="0,"';
				if($value['Nav']==6){//信息页
					$name=db::get_value('article_category', "CateId='{$value['Page']}'", 'Category'.$c['lang']);
					$temp_row=db::get_one('article', "CateId='{$value['Page']}'", "AId,CateId,Title{$c['lang']},Url,PageUrl", $c['my_order']."AId asc");//查询一条用于显示连接
					$temp_row && $url=web::get_url($temp_row, 'article');
					//下拉
					$sub_name='Title';
					$sub_id='AId';
					$sub_where="CateId='{$value['Page']}'";
				}else if ($value['Nav']==5 && $value['Cate']){//产品页并且设置了分类
					$_cate=db::get_one('products_category', "CateId='{$value['Cate']}'", "CateId,UId,Category{$c['lang']}");
					$name=$_cate['Category'.$c['lang']];
					$url=web::get_url($_cate, 'products_category');
					//下拉
					$sub_where="UId='{$_cate['UId']}{$_cate['CateId']},'";
				}
				//if Nav 结束
			}//if 结束
			if(!$name){continue;}
			$sub_row=array();
			($value['Down'] && $_table) && $sub_row=db::get_all($_table, $sub_where, '*', $c['my_order']."{$sub_id} asc");
		?>
			<div class="list <?=$sub_row?'has_sec':'';?>">
				<a href="<?=$sub_row?'javascript:;':$url;?>" <?=$target;?> class="title"><?=$name;?><?=$sub_row?'<i class="trans"></i>':'';?></a>
				<?php if($sub_row){?>
					<div class="sub">
						<div class="cate_close"><span></span></div>
						<?php
						foreach($sub_row as $k=>$v){
							$sub=($uid_category_row["0,{$v['CateId']},"] && $value['Nav']==5)?1:0;
						?>
							<div class="item">
								<a href="<?=$sub?'javascript:;':web::get_url($v, $_table);?>" class="son_nav_title"><?=$v[$sub_name.$c['lang']];?><?=$sub?'<i class="trans"></i>':'';?></a>
								<?php if($sub){?>
									<div class="third_nav">
										<?php foreach((array)$uid_category_row["0,{$v['CateId']},"] as $v1){?>
											<a href="<?=web::get_url($v1,'products_category'); ?>"><?=$v1['Category'.$c['lang']]; ?></a>
											
											<?php if(count($uid_category_row["0,{$v['CateId']},{$v1['CateId']},"])){?>
											<div class="fouth_cate f_cate_<?=$v1['CateId']; ?>">
											<?php foreach($uid_category_row["0,{$v['CateId']},{$v1['CateId']},"] as $k2=>$v2){?>
												<a href="<?=web::get_url($v2);?>" class="f_cate_name category_<?=$v2['CateId']; ?> "><?=$v2['Category'.$c['lang']];?></a>
											<?php }?>
											</div>
											<?php }?>
										<?php }?>
									</div>
								<?php } ?>
							</div>
						<?php }?>
					</div>
				<?php }?>
			</div>
		<?php }?>
	</div>
	<div class="son_nav trans"></div>
	<div class="nav_bg"></div>
</div>
<div class="ueeshop_responsive_header header_blank"></div>
<script language="javascript">
$('.ueeshop_responsive_header .menu_btn').on('click',function(){
	if($(this).hasClass('on')){
		$(this).removeClass('on');
		$('.ueeshop_responsive_header').find('.nav, .nav_bg, .son_nav').removeClass('on');
		$('body').attr('style', '');
	}else{
		$(this).addClass('on');
		$('.ueeshop_responsive_header').find('.nav, .nav_bg').addClass('on');
		$('body').css({'overflow':'hidden'});
	}
});
$('.ueeshop_responsive_header .language_btn').on('click',function(){
	if($(this).hasClass('on')){
		$(this).removeClass('on');
		$('.ueeshop_responsive_header .language').removeClass('on');
		$('body').attr('style','');
	}else{
		$(this).addClass('on');
		$('.ueeshop_responsive_header .language').addClass('on');
		$('.ueeshop_responsive_header').find('.menu_btn, .nav_bg, .nav, .son_nav').removeClass('on');
		$('body').css({'overflow':'hidden'});
	}
});
$('.ueeshop_responsive_header .search_btn').on('click',function(){
	if($(this).hasClass('on')){
		$(this).removeClass('on');
		$('.ueeshop_responsive_header .search_box').removeClass('on');
	}else{
		$(this).addClass('on');
		$('.ueeshop_responsive_header .search_box').addClass('on');
		$('.ueeshop_responsive_header').find('.menu_btn, .nav_bg, .nav, .son_nav').removeClass('on');
	}
});
$('.ueeshop_responsive_header .nav_bg').on('click',function(){
	$(this).removeClass('on');
	$('.ueeshop_responsive_header').find('.nav, .son_nav, .menu_btn').removeClass('on');
});
$('.ueeshop_responsive_header .search_box .close_btn span').on('click',function(){
	$(this).parents('.search_box').removeClass('on');
	$('.ueeshop_responsive_header .search_btn').removeClass('on');
});
$('.ueeshop_responsive_header .language .close_btn span').on('click',function(){
	$(this).parents('.language').removeClass('on');
	$('.ueeshop_responsive_header .language_btn').removeClass('on');
})
$('.ueeshop_responsive_header .nav .list .title').on('click', function (e){
	$('.ueeshop_responsive_header .hasub .sub').removeClass('on');
	$('.ueeshop_responsive_header .son_nav').html($(this).parents('.list').find('.sub').html()).addClass('on');
});
$('.ueeshop_responsive_header .son_nav').on('click','.cate_close', function (e){
	$('.ueeshop_responsive_header .son_nav').removeClass('on');
})
$('.ueeshop_responsive_header .son_nav').on('click', '.son_nav_title',function(){
	$(this).parent('.item').find('.third_nav').toggle('on');
	$(this).toggleClass('on');
});
</script>