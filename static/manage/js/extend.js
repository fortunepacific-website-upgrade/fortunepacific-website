/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/
var translate_obj={
	//Google 翻译
	translate_init:function (){
		$('.rows').on('click', '.switchery', function(){
			var $this=$(this),
				$key=0;
			if(!$this.hasClass('checked')){
				$key=1
				$this.addClass('checked');
			}else{
				$this.removeClass('checked');
			}
			$.post('?', 'do_action=extend.translate_set&key='+$key, function(data){
				if(data.ret==1){
				}else{
					global_obj.win_alert(lang_obj.global.set_error);
				}
			}, 'json');
		});
		
		$('.r_con_table').on('click', '.used_checkbox .switchery', function(){
			var $this=$(this),
				$tr=$this.parents('tr'),
				$key=0;
			if(!$this.hasClass('no_drop')){
				if(!$this.hasClass('checked')){
					$key=1;
					$this.addClass('checked');
				}else{
					$this.removeClass('checked');
				}
				$.post('?', 'do_action=extend.translate_init&lang='+$tr.attr('lang')+'&key='+$key, function(data){
					if(data.ret==1){
					}else{
						global_obj.win_alert(data.msg);
						//global_obj.win_alert(lang_obj.global.set_error);
					}
				}, 'json');
			}
		});
	}

}

var seo_obj={
	<!-- 全局 Start -->
	seo_init:function(){
		$('#search_form').submit(function(){return false;});
		$('#search_form input:submit').click(function(){
			if(global_obj.check_form($('*[notnull]'))){return false;};
			$(this).attr('disabled', true);
			
			var $form=$('input[name=Type]');
			if($form.val()=='link'){
				window.location='./?m=extend&a=seo.link&'+$('#search_form').serialize();
			}else if($form.val()=='third'){
				window.location='./?m=extend&a=seo.third&'+$('#search_form').serialize();
			}else{
				window.location='./?m=extend&a=seo.meta&d=list&'+$('#search_form').serialize();
			}
		});
		
		frame_obj.select_all($('#seo .r_con_table input[name=select_all]'), $('#seo .r_con_table input[name=select]')); //批量操作
		frame_obj.del_bat($('.seo_nav .del_bat'), $('#seo .r_con_table input[name=select]'), seo_obj.del_bat_callback);
		
		$('#seo .del').off().click(function(){
			var $this=$(this);
			global_obj.win_alert(lang_obj.global.del_confirm, 'confirm', function(){
				window.location=$this.attr('href');
			});
			return false;
		});
		
		$('#seo_form').submit(function(){return false;});
		$('#seo_form input:submit').live('click', function(){
			if($('*[placeholder]').length){
				$('*[placeholder]').each(function(){
					if($(this).val()==$(this).attr('placeholder')) $(this).val('');
				});
			}
			if(global_obj.check_form($('*[notnull]'))){return false;};
			$(this).attr('disabled', true);
			
			$.post('?', $('#seo_form').serialize(), function(data){
				$('#seo_form input:submit').attr('disabled', false);
				if(data.ret!=1){
					global_obj.win_alert(data.msg);
				}else{
					var $form=$('#seo_form');
					if($form.attr('name')=='link_form'){
						window.location='./?m=extend&a=seo.link';
					}else if($form.attr('name')=='meta_form'){
						window.location=(data.msg?data.msg:'./?m=extend&a=seo.meta');
					}else if($form.attr('name')=='sitemap_form'){
						window.location=(data.msg?data.msg:'./?m=extend&a=seo.sitemap');
					}else{
						window.location='./?m=extend&a=seo.third';
					}
				}
			}, 'json');
		});
	},
	
	del_bat_callback:function(group_id_str){
		var $this=$(this);
		global_obj.win_alert(lang_obj.global.del_confirm, 'confirm', function(){
			var $form=$('input[name=Type]');
			if($form.val()=='link'){
				window.location='./?do_action=extend.seo_link_del_bat&group_lid='+group_id_str;
			}else if($form.val()=='meta'){
				window.location='./?do_action=extend.seo_meta_del_bat&group_mid='+group_id_str;
			}else{
				window.location='./?do_action=extend.seo_third_del_bat&group_tid='+group_id_str;
			}
		});
		return false;
	},
	<!-- 全局 End -->
	
	<!-- 页面标题与标签管理 Start -->
	meta_init:function(){
		$('.meta_box').on('click', '.meta_head', function(){
			var $obj=$(this).next('.meta_body');
			if($obj.is(':hidden')){
				$(this).addClass('current');
				$obj.slideDown();
			}else{
				$(this).removeClass('current');
				$obj.slideUp();
			}
		}).on('click', '.more', function(){
			window.location=$(this).attr('href');
			return false;
		});
	},
	
	meta_edit_init:function(){
		$('#PicUpload').on('click', function(){
			frame_obj.photo_choice_init('PicUpload', 'form input[name=PicPath]', 'PicDetail', 'products_category', 1);
		});
		$('#PicDetail').html(frame_obj.upload_img_detail($('form input[name=PicPath]').val()));
	},
	<!-- 页面标题与标签管理 End -->
	
	<!-- 第三方代码管理 Start -->
	third_init:function(){
		frame_obj.switchery_checkbox();
	}
	<!-- 第三方代码管理 End -->
}


var blog_obj={
	<!-- 文章管理 Start -->
	blog_default_init:function(){
		blog_obj.frame_init();
		blog_obj.list_init();
		blog_obj.blog_category_edit_init();
		blog_obj.blog_edit_init();
	},
	
	//博客设置
	blog_set_init:function (){
		$('#blog_form').submit(function(){return false;});
		$('#blog_form input:submit').click(function(){
			if($('*[placeholder]').length){
				$('*[placeholder]').each(function(){
					if($(this).val()==$(this).attr('placeholder')) $(this).val('');
				});
			}
			if(global_obj.check_form($('*[notnull]'))){return false;};
			$(this).attr('disabled', true);
			
			$.post('?', $('#blog_form').serialize(), function(data){
				$('#blog_form input:submit').attr('disabled', false);
				if(data.ret!=1){
					global_obj.win_alert(data.msg);
				}else{
					window.location='./?m=extend&a=blog.set';
				}
			}, 'json');
		});
		//添加导航
		$('#blog_form').on('click', '.addNav', function (){
			var container = $('.blog_nav');
			var name_lang = container.attr('data-name');
			var link_lang = container.attr('data-link');
			container.append('<div>'+name_lang+':<input type="text" name="name[]" class="form_input" value="" size="10" maxlength="30" /> '+link_lang+':<input type="text" name="link[]" class="form_input" value="" size="30" max="150" /><a href="javascript:void(0);"><img hspace="5" src="../../images/ico/del.png"></a></div>');
		});
		$('.blog_nav').on('click', 'div a', function (){
			$(this).parent().remove();
		});
		
		$('#AdUpload').on('click', function(){
			frame_obj.photo_choice_init('AdUpload', 'form input[name=Ad]', 'AdDetail', '', 1);
		});
		//frame_obj.file_upload($('#AdUpload'), $('form input[name=Ad]'), $('#AdDetail'));
		
		$('#AdDetail').html(frame_obj.upload_img_detail($('form input[name=Ad]').val()));
		
	},
	
	frame_init:function(){
		frame_obj.select_all($('#blog .r_con_table input[name=select_all]'), $('#blog .r_con_table input[name=select]')); //批量操作
		frame_obj.del_bat($('#blog .del_bat'), $('#blog input[name=select]'), blog_obj.del_bat_callback);
		
		$('.r_category_wrap .wrap_content').height($('.r_category_wrap').height()-$('.r_category_wrap .list_title').outerHeight()-($(window).width()<870?50:0));
		$('#blog .page_menu').jScrollPane().width('26%');
		if($('#blog .view').height()<$(window).height()-50) $('#blog .view').height($(window).height()-50);
	},
	
	list_init:function(){
		$('#blog .page_menu ul').dragsort({
			dragSelector:'li',
			dragEnd:function(){
				var data=$(this).parent().children('li').map(function(){
					return $(this).attr('CateId');
				}).get();
				$.get('?m=extend&a=blog.blog', {do_action:'extend.blog_category_order', sort_order:data.join('|')});
			},
			dragSelectorExclude:'dl, a',
			placeHolderTemplate:'<li class="placeHolder"></li>',
			scrollSpeed:5
		});
		
		$('#blog .page_menu li > dl').dragsort({
			dragSelector:'dt',
			dragEnd:function(){
				var data=$(this).parent().children('dt').map(function(){
					return $(this).attr('CateId');
				}).get();
				$.get('?m=extend&a=blog.blog', {do_action:'extend.blog_category_order', sort_order:data.join('|')});
			},
			dragSelectorExclude:'a',
			placeHolderTemplate:'<dt class="placeHolder"></dt>',
			scrollSpeed:5
		});
		
		$('#blog').on('click', '.page_menu h4 a', function(){
			var $this=$(this).parents('.menu_one').next();
			if($this.is(':hidden')){
				$this.parent().addClass('current');
				$this.show();
			}else{
				$this.parent().removeClass('current');
				$this.hide();
			}
		}).on('click', '.del', function(){
			var $this=$(this);
			global_obj.win_alert(lang_obj.global.del_confirm, 'confirm', function(){
				window.location=$this.attr('href');
			});
			return false;
		})
	},
	
	del_bat_callback:function(group_id_str){
		var $this=$(this);
		global_obj.win_alert(lang_obj.global.del_confirm, 'confirm', function(){
			window.location='./?do_action=extend.blog_del_bat&group_aid='+group_id_str;
		});
		return false;
	},
	
	blog_category_edit_init:function(){
		$('#blog_category_form').submit(function(){return false;});
		$('#blog_category_form input:submit').click(function(){
			if($('*[placeholder]').length){
				$('*[placeholder]').each(function(){
					if($(this).val()==$(this).attr('placeholder')) $(this).val('');
				});
			}
			if(global_obj.check_form($('*[notnull]'))){return false;};
			$(this).attr('disabled', true);
			
			$.post('?', $('#blog_category_form').serialize(), function(data){
				$('#blog_category_form input:submit').attr('disabled', false);
				if(data.ret!=1){
					global_obj.win_alert(data.msg);
				}else{
					window.location='./?m=extend&a=blog.blog';
				}
			}, 'json');
		});
	},
	
	blog_edit_init:function(){
		$('#blog_form').submit(function(){return false;});
		$('#blog_form input:submit').click(function(){
			if($('*[placeholder]').length){
				$('*[placeholder]').each(function(){
					if($(this).val()==$(this).attr('placeholder')) $(this).val('');
				});
			}
			if(global_obj.check_form($('*[notnull]'))){return false;}
			$(this).attr('disabled', true);
			
			$.post('?', $('#blog_form').serializeArray(), function(data){
				$('#blog_form input:submit').attr('disabled', false);
				if(data.ret!=1){
					global_obj.win_alert(data.msg);
				}else{
					window.location='./?m=extend&a=blog.blog';
				}
			}, 'json');
		});
	},
	<!-- 文章管理 End -->
	blog_review_init:function(){
		frame_obj.select_all($('#blog .r_con_table input[name=select_all]'), $('#blog .r_con_table input[name=select]')); //批量操作
		frame_obj.del_bat($('.blog_r .del_bat'), $('#blog input[name=select]'), blog_obj.del_review_bat_callback);
		$('#blog').on('click', '.del', function(){
			var $this=$(this);
			global_obj.win_alert(lang_obj.global.del_confirm, 'confirm', function(){
				window.location=$this.attr('href');
			});
			return false;
		})
		$('#blog_form').submit(function(){return false;});
		$('#blog_form input:submit').click(function(){
			if($('*[placeholder]').length){
				$('*[placeholder]').each(function(){
					if($(this).val()==$(this).attr('placeholder')) $(this).val('');
				});
			}
			if(global_obj.check_form($('*[notnull]'))){return false;};
			$(this).attr('disabled', true);
			
			$.post('?', $('#blog_form').serialize(), function(data){
				$('#blog_form input:submit').attr('disabled', false);
				if(data.ret!=1){
					global_obj.win_alert(data.msg);
				}else{
					window.location='./?m=extend&a=blog.review';
				}
			}, 'json');
		});
	},
	
	del_review_bat_callback:function(group_id_str){
		var $this=$(this);
		global_obj.win_alert(lang_obj.global.del_confirm, 'confirm', function(){
			window.location='./?do_action=extend.blog_del_review_bat&group_rid='+group_id_str;
		});
		return false;
	}
	
}

var analytics_obj={
	//Google Analytics 设置
	analytics_set_init:function (){
		$('#analytics_form').submit(function(){return false;});
		$('#analytics_form input:submit').click(function(){
			if(global_obj.check_form($('*[notnull]'))){return false;};
			$(this).attr('disabled', true);
			
			$.post('?', $('#analytics_form').serialize(), function(data){
				$('#analytics_form input:submit').attr('disabled', false);
				if(data.ret!=1){
					global_obj.win_alert(data.msg);
				}else{
					window.location='./?m=extend&a=analytics.set';
				}
			}, 'json');
		});
	}
	
}