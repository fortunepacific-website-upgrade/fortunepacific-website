/*
Powered by ueeshop.com		http://www.ueeshop.com
广州联雅网络科技有限公司		020-83226791
*/

var set_obj={
	config_function:{
		switchery:function(obj, do_action, param_0, param_1, callback){
			obj.click(function(){
				var $this=$(this),
					$data_value=$this.attr(param_0),
					$used,
					$data=new Object;
				if(!$this.hasClass('no_drop')){
					if($this.hasClass('checked')){
						$used=0;
						$this.removeClass('checked');
					}else{
						$used=1;
						$this.addClass('checked');
					}
					$data[param_1]=$data_value;
					$data['IsUsed']=$used;
					$.post('?do_action='+do_action, $data, function(data){
						if(!data.ret){
							global_obj.win_alert_auto_close(data.msg, 'fail', 1000, '8%');
							if($used){
								$this.removeClass('checked');
							}else{
								$this.addClass('checked');
							}
						}
						if($.isFunction(callback)){
							callback(data);
							return false;
						}else{
							if(data.ret){
								global_obj.win_alert_auto_close(data.msg, '', 1000, '8%');
							}
						}
					},'json');
				}
			});
		}
	},

	config_edit_init:function(){
		frame_obj.translation_init();
		var html='', part=0, num=1;
		$('#config').find('.rows_hd_part:visible').each(function(){
			if(num<10) num='0'+num;
			$(this).before('<a id="part_'+part+'"></a>');
			html+='<li><a href="#part_'+part+'"'+(part==0 ? 'class="current"' : '')+'>'+$(this).find('span').html()+'</a></li>';
			part++;
			num++;
		});
		if(html){
			$('.center_container').append('<ul class="edit_form_part">'+html+'</ul>');
			$('.edit_form_part a').click(function(){
				$('.edit_form_part a').removeClass('current');
				$(this).addClass('current');
			    $('.r_con_wrap').animate({
			      scrollTop: $($(this).attr("href"))[0].offsetTop-20 + "px"
			    }, 200);
			    return false;
			});
			$(window).resize(function(){
				var left = $('.center_container').offset().left+$('.center_container').width()+40;
				$('.edit_form_part').css('left',left+'px');
			}).resize();
		}
	},

	config_basis_edit:function(){
		frame_obj.mouse_click($('#LogoDetail .upload_btn, #LogoDetail .pic_btn .edit'), 'img', function($this){ //点击上传图片
			frame_obj.photo_choice_init('LogoUpload', '#LogoDetail input[name=LogoPath]', 'LogoDetail', '', 1);
		});
		frame_obj.mouse_click($('#IcoDetail .upload_btn, #IcoDetail .pic_btn .edit'), 'img', function($this){ //点击上传图片
			frame_obj.photo_choice_init('IcoUpload', '#IcoDetail input[name=IcoPath]', 'IcoDetail', '', 1);
		});
		frame_obj.switchery_checkbox();
		frame_obj.submit_form_init($('#basis_edit_form'), './?m=set&a=config&d=basis');
	},
	
	config_seo_edit:function(){
		frame_obj.submit_form_init($('#seo_edit_form'), './?m=set&a=config&d=seo');
	},

	config_switch_edit:function(){
		$('#switch_edit_form .switchery').click(function(){
			var o=$(this);
			$.get('?', 'do_action=set.config_switch&field='+o.attr('field')+'&status='+o.attr('status'), function(data){
				if(data.ret==1){
					if(o.attr('status')==0){
						o.attr('status', 1).addClass('checked');
					}else{
						o.attr('status', 0).removeClass('checked');
					}
					global_obj.win_alert_auto_close(data.msg, '', 1000, '8%');
				}else{
					global_obj.win_alert_auto_close(lang_obj.global.set_error,'fail', 1000, '8%');
				}
			}, 'json');
		});
		frame_obj.switchery_checkbox(function(obj){
			if(obj.parent().find('input[name=IsCloseWeb]').length){
				$('.IsCloseWeb, .rows.button').show();
			}
		}, function(obj){
			if(obj.parent().find('input[name=IsCloseWeb]').length){
				$('.IsCloseWeb, .rows.button').hide();
			}
		});
		frame_obj.submit_form_init($('#switch_edit_form'), './?m=set&a=config&d=switch');
	},

	config_contact_edit:function(){
		frame_obj.submit_form_init($('#contact_edit_form'), './?m=set&a=config&d=contact');
	},

	config_inquiry_edit:function(){
		frame_obj.del_init($('.config_table, .r_con_table'));
		$('.switchery').not("#newsletter_set_form .switchery").click(function(){
			var o=$(this);
			$.get('?', 'do_action=set.config_inquiry_switch&field='+o.attr('field')+'&status='+o.attr('status')+'&type='+o.parents('.r_con_table').attr('rel'), function(data){
				if(data.ret==1){
					if(o.attr('status')==0){
						o.attr('status', 1).addClass('checked');
					}else{
						o.attr('status', 0).removeClass('checked');
					}
					global_obj.win_alert_auto_close(data.msg, '', 1000, '8%');
				}else{
					global_obj.win_alert_auto_close(lang_obj.global.set_error,'fail', 1000, '8%');
				}
			}, 'json');
		});
		frame_obj.submit_form_init($('.quick_save_form form'));

		frame_obj.fixed_right($('.feedback_set .edit, .feedback_set .set_add'), '.feedback_set_edit');
		$('.feedback_set .edit, .feedback_set .add').click(function(){
			frame_obj.load_edit_form('.feedback_set_edit',$(this).attr('data-url'),'get','',function(){
				frame_obj.submit_form_init($('#feedback_set_edit_form'), './?m=set&a=config&d=inquiry&p=feedback_set');
			});
		});
		$(document).on('click', '.switchery', function(){
			if($(this).hasClass('checked')){
				$(this).removeClass('checked').find('input').attr('checked', false);
			}else{
				$(this).addClass('checked').find('input').attr('checked', true);
			}
		});
		
		//订阅设置
		frame_obj.mouse_click($('.multi_img .upload_btn, .pic_btn .edit'), 'par', function($this){
			frame_obj.photo_choice_init('PicUpload', '.multi_img input[name=PicPath]', 'PicDetail', '', 1);
		});
		frame_obj.submit_form_init($('#newsletter_set_form'), './?m=set&a=config');
	},

	config_product_edit:function(){
		$('#product_edit_form .switchery').click(function(){
			var o=$(this);
			$.get('?', 'do_action=set.config_product_switch&field='+o.attr('field')+'&status='+o.attr('status'), function(data){
				if(data.ret==1){
					if(o.attr('status')==0){
						o.attr('status', 1).addClass('checked');
					}else{
						o.attr('status', 0).removeClass('checked');
					}
					global_obj.win_alert_auto_close(data.msg, '', 1000, '8%');
				}else{
					global_obj.win_alert_auto_close(lang_obj.global.set_error,'fail', 1000, '8%');
				}
			}, 'json');
		});
		frame_obj.switchery_checkbox(function(obj){
			if(obj.parent().find('input[name=show_price]').length){
				$('.currency_symbol').show();
			}
		}, function(obj){
			if(obj.parent().find('input[name=show_price]').length){
				$('.currency_symbol').hide();
			}
		});
		frame_obj.submit_form_init($('#product_edit_form'), './?m=set&a=config&d=product');
	},

	config_user_edit:function(){
		frame_obj.del_init($('.config_table, .r_con_table'));
		$('#reg_set .switchery[field]').click(function(){//注册参数
			var o=$(this);
			if(o.attr('field').indexOf('NotNull')!=-1){
				var notnull_obj=o.attr('field').replace('NotNull', '');
				if($('#reg_set .switchery[field='+notnull_obj+']').attr('status')==0){return false;}
			}
			$.get('?', 'do_action=set.config_user_reg_set&field='+o.attr('field')+'&status='+o.attr('status'), function(data){
				if(data.ret==1){
					var notnull_obj=$('#reg_set .switchery[field='+o.attr('field')+'NotNull]');
					if(o.attr('status')==0){
						o.attr('status', 1).addClass('checked');
						if(notnull_obj.length){
							notnull_obj.removeClass('no_drop');
						}
					}else{
						o.attr('status', 0).removeClass('checked');
						if(notnull_obj.length){
							notnull_obj.attr('status', 0).addClass('no_drop').removeClass('checked');
						}
					}
					global_obj.win_alert_auto_close(data.msg, '', 1000, '8%');
				}else{
					global_obj.win_alert_auto_close(lang_obj.global.set_error,'fail', 1000, '8%');
				}
			}, 'json');
		});
		frame_obj.switchery_checkbox();
		frame_obj.submit_form_init($('#user_config_form'), './?m=set&a=config&d=user&p=config');
		frame_obj.fixed_right($('#reg_set .edit, #reg_set .add'),'.reg_set_edit');
		$('#reg_set .edit, #reg_set .add').click(function(){
			frame_obj.load_edit_form('.reg_set_edit',$(this).attr('data-url'),'get','',function(){
				$('#type_select').change(function(){
					$(this).val()==1?$('.row_option').show():$('.row_option').hide();
				});
				frame_obj.submit_form_init($('#reg_set_form'), './?m=set&a=config&d=user&p=list');
			});
		});
	},

	config_watermark_edit:function(){
		frame_obj.switchery_checkbox();
		/* 水印图片上传 */
		frame_obj.mouse_click($('#WatermarkDetail .upload_btn, #WatermarkDetail .pic_btn .edit'), 'img', function($this){ //点击上传图片
			frame_obj.photo_choice_init('WatermarkUpload', '#WatermarkDetail input[name=WatermarkPath]', 'WatermarkDetail', '', 1);
		});
		/* 水印位置选择 */
		$('.watermark_position').click(function(){
			var $num=$(this).attr('data-position');
			$('.watermark_position').removeClass('cur').eq($(this).index()).addClass('cur');
			$('input[name=WaterPosition]').val($num);
		});
		$('#preview_pic').css('opacity',$('input[name=Alpha]').val()*0.01);
		$('#slider').slider({
			value:$('input[name=Alpha]').val(),
			change:function(){
				var val=$(this).slider('value');
				$('#slider_value').html(val+'%');
				$('#preview_pic').css('opacity',val*0.01);
				$('input[name=Alpha]').val(val);
			}
		});
		frame_obj.submit_form_init($('#watermark_edit_form'), './?m=set&a=config&d=watermark');
	},

	config_share_edit:function(){
		$('.btn_add_share').on('click', function(){
			var $obj=$('.platform_default');
			if($obj.is(':hidden')){ //优先显示出添加选项
				$obj.show();
				return false;
			}
			var $value=$('select[name=tax_code_type]').val(),
				$url=$('input[name=Add]').val();
			if($value!=0){
				$('.share_item[data-share='+$value+']').removeClass('hide').find('input').val($url);
				$('select[name=tax_code_type]>option[value='+$value+']').addClass('hide').attr('disabled', true);
				$('select[name=tax_code_type]').val('0').change();
				$('input[name=Add]').val('');
			}
			is_add();
		});
		$('.share_del').on('click', function(){
			var $this=$(this),
				$value=$this.attr('data-share');
			global_obj.win_alert(lang_obj.global.del_confirm, function(){
				$this.parents('.share_item').addClass('hide').find('input').val('');
				$('select[name=tax_code_type]>option[value='+$value+']').removeClass('hide').removeAttr('disabled');
				is_add();
			}, 'confirm');
		});
		function is_add(){
			if($('select[name=tax_code_type]>option[class!=hide]').length<=1){
				$('.share_add ,.btn_add_share').hide();
			}else{
				$('.share_add ,.btn_add_share').show();
			}
		}
		is_add();
		frame_obj.submit_form_init($('#share_edit_form'), './?m=set&a=config&d=share');
	},

	country_init:function(){
		var html='', part=0, num=1;
		$('#country').find('.rows_hd_part:visible').each(function(){
			if(num<10) num='0'+num;
			$(this).before('<a id="part_'+part+'"></a>');
			html+='<li><a href="#part_'+part+'"'+(part==0 ? 'class="current"' : '')+'>'+$(this).find("span").html()+'</a></li>';
			part++;
			num++;
		});
		if(html){
			$('.center_container').append('<ul class="edit_form_part">'+html+'</ul>');
			$('.edit_form_part a').click(function(){
				$('.edit_form_part a').removeClass('current');
				$(this).addClass('current');
			    $('.r_con_wrap').animate({
			      scrollTop: $($(this).attr("href")).siblings('.big_title')[0].offsetTop + "px"
			    }, 300);
			    return false;
			});
			$(window).resize(function(){
				var left = $('.center_container').offset().left+$('.center_container').outerWidth();
				$('.edit_form_part').css('left',left+'px');
			}).resize();
		}

		frame_obj.select_all($('#country .r_con_table input[name=select_all]'), $('#country .r_con_table input[name=select]')); //批量操作
		frame_obj.del_bat($('.r_nav .bat_open'), $('#country .r_con_table input[name=select]'), function(id_list){
			var $this=$(this);
			global_obj.win_alert(lang_obj.global.used_confirm, function(){
				$.get('./?do_action=set.country_used_bat&group_cid='+id_list+'&used=1', function(data){
					if(data.ret==1){
						window.location='./?m=set&a=country';
					}
				}, 'json');
			}, 'confirm');
			return false;
		}, lang_obj.global.used_dat_select);
		frame_obj.del_bat($('.r_nav .bat_close'), $('#country .r_con_table input[name=select]'), function(id_list){
			var $this=$(this);
			global_obj.win_alert(lang_obj.global.close_confirm, function(){
				$.get('./?do_action=set.country_used_bat&group_cid='+id_list+'&used=0', function(data){
					if(data.ret==1){
						window.location='./?m=set&a=country';
					}
				}, 'json');
			}, 'confirm');
			return false;
		}, lang_obj.global.close_dat_select);
		$('.r_con_table tbody td.default').css({'color':'#F00', 'font-weight':'bold', 'font-size':'14px'});
		$('.r_con_table').on('click', '.used_checkbox .switchery', function(){	//启用
			var $this=$(this),
				$tr=$this.parents('tr'),
				check=0;
			if(!$this.hasClass('no_drop')){
				if(!$this.hasClass('checked')){
					$this.addClass('checked');
					check=1;
				}else{
					$this.removeClass('checked');
					$tr.find('.hot_checkbox .switchery').removeClass('checked');
				}
				$.get('?', 'do_action=set.country_switch&CId='+$tr.attr('cid')+'&Check='+check, function(data){
					if(data.ret==1){
						global_obj.win_alert_auto_close(data.msg, '', 1000, '8%');
					}else{
						global_obj.win_alert_auto_close(lang_obj.global.set_error,'fail', 1000, '8%');
					}
				}, 'json');
			}
		});
		frame_obj.del_init($('#country .r_con_table'));
	},

	country_edit_init:function(){
		frame_obj.switchery_checkbox();
		frame_obj.submit_form_init($('#country_edit_form'), './?m=set&a=country');
	},

	third_party_code_init:function(){
		frame_obj.del_init($('#third_party_code .r_con_table'));

		$('.used_checkbox .switchery').click(function(){
			var $this=$(this),
				$tid=$this.attr('data-tid'),
				$used;
			if($this.hasClass('checked')){
				$used=0;
				$this.removeClass('checked');
			}else{
				$used=1;
				$this.addClass('checked');
			}
			$.post('?do_action=set.third_party_code_used',{'TId':$tid,'IsUsed':$used},function(data){
				if(data.ret==1){
					global_obj.win_alert_auto_close(data.msg, '', 1000, '8%');
				}else{
					global_obj.win_alert_auto_close(lang_obj.global.set_error,'fail', 1000, '8%');
				}
			},'json');
		});
	},

	third_party_code_edit_init:function(){
		frame_obj.switchery_checkbox();
		frame_obj.submit_form_init($('#third_party_code_edit_form'), './?m=set&a=third_party_code');
	},

	manage_init:function(){
		frame_obj.del_init($('#manage .r_con_table'));
		frame_obj.select_all($('#manage .r_con_table input[name=select_all]'), $('#manage .r_con_table input[name=select]'), $('.list_menu_button .del'));
		frame_obj.del_bat($('.list_menu .del'), $('#manage .r_con_table input[name=select]'), 'set.manage_del');
	},

	manage_edit_init:function(){
		$('#manage_edit_form').delegate('select[name=GroupId]', 'change', function(){
			var show=$(this).val()==1?'none':'';
			$('.permit').css('display', show);
		});
		var checkbox_fun=function(o){
			if(o.hasClass('checked')){
				o.find('input').removeAttr('checked');
				o.removeClass('checked');
			}else{
				o.find('input').attr('checked', true);
				o.addClass('checked');
			}
		}
		$('.list>.input_checkbox_box:not(".disabled")').click(function(e) {
			checkbox_fun($(this));
			var o=$(this).parents('.list');
			if($(this).hasClass('checked')){
				o.find('.ext .input_checkbox_box').addClass('checked');
				o.find('.ext .input_checkbox_box input').attr('checked', true);
			}else{
				o.find('.ext .input_checkbox_box').removeClass('checked');
				o.find('.ext .input_checkbox_box input').removeAttr('checked');
			}
			return false;
		});
		$('.list .ext .input_checkbox_box:not(".disabled")').click(function(e) {
			checkbox_fun($(this));
			var o=$(this).parents('.list');
			if(o.find('.ext .checked').length){
				o.find('>.input_checkbox_box').addClass('checked');
				o.find('>.input_checkbox_box input').attr('checked', true);
			}else{
				o.find('>.input_checkbox_box').removeClass('checked');
				o.find('>.input_checkbox_box input').removeAttr('checked');
			}
			return false;
		});
		frame_obj.submit_form_init($('#manage_edit_form'), './?m=set&a=manage', function(){
			if($('input[name=Password]').val()!=$('input[name=ConfirmPassword]').val()){
				global_obj.win_alert(lang_obj.global.confirm_password_error);
				$('input[name=Password]').focus();
				return false;
			}
		});
	},

	/******************* 语言设置 *******************/
	config_language_edit:function(){
		set_obj.config_function.switchery($('.language_switchery'), 'set.config_language_used', 'data-lang', 'Language', function(data){
			if(data.ret==1){
				if(ueeshop_config.FunVersion==0){
					window.location.reload();
				}else{
					global_obj.win_alert_auto_close(data.msg, '', 1000, '8%');
				}
			}
		});//开启语言版
		set_obj.config_function.switchery($('.manage_language_switchery'), 'set.config_language_manage_set', 'data-lang', 'Language', function(){
			window.location.reload();
		});//开启后台其它语言版
		set_obj.config_function.switchery($('.config_switchery'), 'set.config_language_browse_set', 'data-config', 'config');//网站基本设置开关

		frame_obj.mouse_click($('#FlagDetail .upload_btn, #FlagDetail .pic_btn .edit'), 'img', function($this){ //点击上传图片
			frame_obj.photo_choice_init('FlagPath', '.multi_img input[name=FlagPath]', 'FlagDetail', '', 1);
		});
		frame_obj.submit_form_init($('#language_edit_form'), './?m=set&a=config');
	},

	/******************* 首页设置 *******************/
	themes_index_set_init:function(){
		$('.abs_item').click(function(){
			var $this=$(this);
			$('.abs_item').removeClass('cur');
			$this.addClass('cur');
			frame_obj.load_edit_form('.index_set_exit','./?m=set&a=themes&d=index_set','get','&WId='+$this.attr('data-wid'),function(){
				$('.show_type .ty_list').click(function(){
					$('.show_type .ty_list').removeClass('cur').find('input').removeAttr('checked');
					$(this).addClass('cur').find('input').attr('checked','checked');
				});
				$('.upload_file_multi:first>.adpic_row').length>1 && frame_obj.dragsort($('.ad_drag'), '', '.adpic_row', '.ad_info, .l_img', '<li class="placeHolder"></li>');
				frame_obj.mouse_click($('.multi_img .upload_btn, .pic_btn .edit'), 'ad', function($this){
					var $id=$this.attr('id'),
						$lang=$this.parents('.img').attr('data-lang'),
						$num=$this.parents('.img').attr('num');
					frame_obj.photo_choice_init('PicUpload_'+$num, '.picpath', 'PicDetail_'+$lang+' .img[num;'+$num+']', 'ad', $('.upload_file_multi:first>.adpic_row').length);
				});
				frame_obj.upload_img_init();
				frame_obj.submit_form_init($('#index_set_edit_form'),$('input[name=return_url]').val()+'&WId='+$('.abs_item.cur').attr('data-wid'));
			});
		});
		if($('.abs_item.cur').length){
			$('.abs_item.cur').click();
		}else{
			$('.abs_item').eq(0).click();
		}
	},

	translate_init:function(){
		$('#translate').on('click', '.translate_used .switchery', function(){
			var $This=$(this),
				$Lang=$This.parents('tr').attr('data-lang'),
				$Status=0;
			if(!$This.hasClass('checked')){
				$Status=1;
				$This.addClass('checked');
			}else{
				$This.removeClass('checked');
			}
			$.post('?', {'do_action':'set.config_google_translate_lang_set', 'Lang':$Lang, 'Status':$Status}, function(data){
				if(data.ret==1){
					global_obj.win_alert_auto_close(data.msg, '', 1000, '8%');
				}
			}, 'json');
		});
		//单个语言切换

		$('.rows').on('click', '.google_translate_switchery', function(){
			var $this=$(this),
				$key=0,
				mod_btn = $this.parents(".rows").find('.set_edit');
			if(!$this.hasClass('checked')){
				$key=1
				$this.addClass('checked');
			}else{
				$this.removeClass('checked');
			}
			$.post('?', 'do_action=set.config_google_translate_set&key='+$key, function(data){
				if(data.ret==1){
					if($key==1){
						mod_btn.css({opacity:'1',display:'block'});
					}else{
						mod_btn.hide();
					}
					global_obj.win_alert_auto_close(data.msg, '', 1000, '8%');
				}else{
					global_obj.win_alert_auto_close(data.msg, 'fail', 1000, '8%');
				}
			}, 'json');
		});
		//启用google翻译
	},

	/******************* 风格管理 *******************/
	themes_themes_edit_init:function(){
		$('.themes_current .use').click(function(){
			var $this=$(this);
			global_obj.win_alert(lang_obj.manage.module.sure_module, function(){
				if($this.hasClass('IsMobile')){
					$action="do_action=set.themes_mobile_themes_edit&themes="+$this.attr('data-themes')+'&type='+$this.attr('data-type');
				}else{
					$action='do_action=set.themes_themes_edit&themes='+$this.attr('data-themes');
				}
				$.get('?', $action, function(data){
					if(data.ret!=1){
						global_obj.win_alert(data.msg, function(){
							window.location.reload();
						}, 'confirm');
					}else{
						window.location.reload();
					}
				}, 'json');
			}, 'confirm');
		});
		$('#themes_themes .item').click(function(){
			var $themes=$(this).attr('data-themes'),
				$url=$(this).attr('data-url'),
				$img=$(this).attr('data-img'),
				$name=$(this).attr('data-name');
			$('#themes_themes .item').removeClass('current');
			$(this).addClass('current');
			$('.themes_current .themes').text($name);
			$('.themes_current .use').attr('data-themes',$themes);
			$('.themes_current .view').attr('href',$url);
			$('.themes_current .themes_img img').attr('src',$img);
		});
		$('#themes_themes .item.current').click();
		$('.themes_themes').height($(window).height()-$('.themes_themes').offset().top-20);
		$('.themes_current .themes_img').height($(window).height()-$('.themes_img').offset().top-20);
		$('.themes_current .themes_img').hover(
			function(){
				if($(this).height()<$(this).find('img').height()){
					var $speed=100;
					if($(this).find('img').height()>1000){
						$speed=200;
					}
					if($(this).find('img').height()>2000){
						$speed=300;
					}
					if($(this).find('img').height()>3000){
						$speed=500;
					}
					var $time=($(this).find('img').height()-$(this).height())/$speed;
					$(this).find('img').stop().animate({'margin-top':$(this).height()-$(this).find('img').height()},$time*1000);
				}
			},
			function(){
				$(this).find('img').stop().animate({'margin-top':0},'fast');
			}
		);
		window.onload = function(){
			$(window).resize(function(){
				frame_obj.water_fall('themes_box', '157', 3, 'item'); // 瀑布流
			}).resize();
		}
	},

	//广告管理
	themes_ad_edit_init:function(){
		$('.show_type .ty_list').click(function(){
			$('.show_type .ty_list').removeClass('cur').find('input').removeAttr('checked');
			$(this).addClass('cur').find('input').attr('checked','checked');
		});
		$('.upload_file_multi:first>.adpic_row').length>1 && frame_obj.dragsort($('.ad_drag'), '', '.adpic_row', '.ad_info, .l_img', '<li class="placeHolder"></li>');
		frame_obj.mouse_click($('.multi_img .upload_btn, .pic_btn .edit'), 'ad', function($this){
			var $id=$this.attr('id'),
				$lang=$this.parents('.img').attr('data-lang'),
				$num=$this.parents('.img').attr('num');
			frame_obj.photo_choice_init('PicUpload_'+$num, '.picpath', 'PicDetail_'+$lang+' .img[num;'+$num+']', 'ad', $('.upload_file_multi:first>.adpic_row').length);
		});
		frame_obj.upload_img_init();
		frame_obj.submit_form_init($('#ad_edit_form'), './?m=set&a=themes&d=ad');
	},

	themes_nav_init:function(){
		var Type=$('.center_container').attr('Type');
		frame_obj.del_init($('#themes .config_table')); //删除事件
		$('#themes .move_box').dragsort({
			dragSelector:'.move',
			dragSelectorExclude:'',
			placeHolderTemplate:'<div class="placeHolder"></div>',
			scrollSpeed:5,
			dragEnd:function(){
				var data=$(this).parent().children('.move_item').map(function(){
					return $(this).attr('data-id');
				}).get();
				$.get('?', {do_action:'set.themes_nav_order', sort_order:data.join('|'), Type:Type}, function(){
					var num=0;
					$('.move_box .move_item').each(function(){
						$(this).attr('data-id', num);
						num++;
					});
				});
			}
		});
		$(document).on('change', 'select[name="Nav"]', function(){//是否有下拉 && 产品、单页判断
			var $this=$(this),
				opt=$this.find('option:selected'),
				$urlBox=$('#edit_form input[name="Url"]').parents('.rows');
			if(opt.attr('down')==1 && !$this.hasClass('no_down')){
				$('#nav_edit_form select[name="Down"]').html('<option value="0">'+lang_obj.global.n_y[0]+'</option><option value="1">'+lang_obj.global.n_y[1]+'</option>');
			}else{
				$('#nav_edit_form select[name="Down"]').html('<option value="0">'+lang_obj.global.n_y[0]+'</option>');
			}
			$urlBox.hide();
			$('.tab_box, .url, .down_width').hide();
			if($this.val()==-1){//自定义
				$this.parent().siblings('.nav_oth').hide().eq(2).show();
				$urlBox.show();
				$('.tab_box').css({display:'inline-block'});
				$('.url').show();
				$('.nav_oth').find('span,b,input').attr('style','');
				frame_obj.rows_input();
			}else if($this.val()==6){//单页
				$this.parent().siblings('.nav_oth').hide().eq(0).show();
			}else if($this.val()==5){//产品
				$this.parent().siblings('.nav_oth').hide().eq(1).show();
			}else{
				$this.parent().siblings('.nav_oth').hide();
			}
		}).on('change', 'select[name=Down]', function(){
			if($(this).val()==1){
				$('.down_width').show();
			}else{
				$('.down_width').hide();
			}
		});
		frame_obj.submit_form_init($('#nav_edit_form'), './?m=set&a=themes&d='+Type);
	},

	themes_header_set_init:function(){
		$('.headicon .img').click(function(e) {
			$('.headicon .img').removeClass('cur');
			$(this).addClass('cur');
			$('input[name=icon]').val($(this).attr('data-icon'));
		});
		frame_obj.switchery_checkbox();
		frame_obj.submit_form_init($('#header_set_form'), './?m=set&a=themes&d=header_set&IsMobile=1');
	},

	themes_footer_set_init:function(){
		$('.list_input').append('<div class="del"></div><div class="add">+ 添加</div>');
		$('#Linkrow').delegate('.add', 'click', function(){
			$('#Linkrow').append($('#Linkrow .rows:last').prop('outerHTML'));
			$('#Linkrow .rows:last input').val('');
		}).delegate('.del', 'click', function(){
			$('#Linkrow .rows').length>1 && $(this).parents('.rows').remove();
		});
		frame_obj.submit_form_init($('#footer_set_form'), './?m=set&a=themes&d=footer_set&IsMobile=1');
	},

}