/*
Powered by ueeshop.com		http://www.ueeshop.com
广州联雅网络科技有限公司		020-83226791
*/

var content_obj={
	page_init:function(){
		frame_obj.del_init($('#page .r_con_table'));
		frame_obj.select_all($('#page .r_con_table input[name=select_all]'), $('#page .r_con_table input[name=select]'), $('.list_menu_button .del'));
		frame_obj.del_bat($('.list_menu .del'), $('#page .r_con_table input[name=select]'), 'content.page_del');
		frame_obj.del_bat($('#page .my_order'), $('#page input[name=select]'), function(){
			var $this=$(this),
				$checkbox,
				my_order_str='';
			$('#page input[name=select]').each(function(index, element) {
				if ($(element).is(':checked')){
					var obj = $(element).parent().siblings('.myorder').children('select');
					my_order_str+=obj.val()+'|';
				}
			});
			global_obj.win_alert(lang_obj.global.my_order_confirm, 'confirm', function(){
				window.location='./?do_action=content.page_my_order&group_aid='+group_id_str+'&my_order_value='+my_order_str;
			});
			return false;
		}, lang_obj.global.dat_select);

		$('#page .r_con_table .myorder_select').on('dblclick', function(){
			var $obj=$(this),
				$number=$obj.attr('data-num'),
				$AId=$obj.parents('tr').find('td:eq(0) input').val(),
				$mHtml=$obj.html(),
				$sHtml=$('#myorder_select_hide').html(),
				$val;
			$obj.html($sHtml+'<span style="display:none;">'+$mHtml+'</span>');
			$number && $obj.find('select').val($number).focus();
			$obj.find('select').on('blur', function(){
				$val=$(this).val();
				if($val!=$number){
					$.post('?', 'do_action=content.page_my_order&AId='+$AId+'&Number='+$(this).val(), function(data){
						if(data.ret==1){
							$obj.html(data.msg);
							$obj.attr('data-num', $val);
						}
					}, 'json');
				}else{
					$obj.html($obj.find('span').html());
				}
			});
		});
	},

	page_edit_init:function(){
		frame_obj.translation_init();
		frame_obj.submit_form_init($('#edit_form'), './?m=content&a=page');
		frame_obj.switchery_checkbox();
	},

	page_category_init:function(){
		frame_obj.del_init($('#page_inside .r_con_table'));
		frame_obj.select_all($('#page_inside .r_con_table input[name=select_all]'), $('#page_inside .r_con_table input[name=select]'), $('.list_menu_button .del'));
		frame_obj.del_bat($('.list_menu .del'), $('#page_inside .r_con_table input[name=select]'), 'content.page_category_del');
		frame_obj.dragsort($('#page_inside .r_con_table tbody'), 'content.page_category_order');
	},

	page_category_edit_init:function(){
		frame_obj.translation_init();
		frame_obj.submit_form_init($('#edit_form'), './?m=content&a=page&d=category');
	},

	info_init:function(){
		frame_obj.del_init($('#info .r_con_table'));
		frame_obj.select_all($('#info .r_con_table input[name=select_all]'), $('#info .r_con_table input[name=select]'), $('.list_menu_button .del'));
		frame_obj.del_bat($('.list_menu .del'), $('#info .r_con_table input[name=select]'), 'content.info_del');
	},

	info_edit_init:function(){
		frame_obj.translation_init();
		$('#edit_form input[name=AccTime]').daterangepicker({singleDatePicker:true,showDropdowns:true});
		frame_obj.switchery_checkbox();

		frame_obj.mouse_click($('.multi_img .upload_btn, .pic_btn .edit'), 'par', function($this){
			frame_obj.photo_choice_init('PicUpload', '.multi_img input[name=PicPath]', 'PicDetail', '', 1);
		});
		frame_obj.submit_form_init($('#edit_form'), './?m=content&a=info');
	},

	info_category_init:function(){
		frame_obj.del_init($('#info_inside .r_con_table'));
		frame_obj.select_all($('#info_inside .r_con_table input[name=select_all]'), $('#info_inside .r_con_table input[name=select]'), $('.list_menu_button .del'));
		frame_obj.del_bat($('.list_menu .del'), $('#info_inside .r_con_table input[name=select]'), 'content.info_category_del');
		frame_obj.dragsort($('#info_inside .r_con_table tbody'), 'content.info_category_order');
	},

	info_category_edit_init:function(){
		frame_obj.translation_init();
		frame_obj.submit_form_init($('#edit_form'), './?m=content&a=info&d=category');
	},

	partner_init:function(){
		frame_obj.del_init($('#partner .r_con_table'));
		frame_obj.select_all($('#partner .r_con_table input[name=select_all]'), $('#partner .r_con_table input[name=select]'), $('.list_menu_button .del'));
		frame_obj.del_bat($('.list_menu .del'), $('#partner .r_con_table input[name=select]'), 'content.partner_del');
	},

	partner_edit_init:function (){
		frame_obj.translation_init();
		frame_obj.mouse_click($('.multi_img .upload_btn, .pic_btn .edit'), 'img', function($this){
			frame_obj.photo_choice_init('PicUpload', '.multi_img input[name=PicPath]', 'PicDetail', '', 1);
		});

		frame_obj.submit_form_init($('#partner_form'), './?m=content&a=partner');
	},

	case_init:function(){
		frame_obj.del_init($('#case .r_con_table'));
		frame_obj.select_all($('#case .r_con_table input[name=select_all]'), $('#case .r_con_table input[name=select]'), $('.list_menu_button .del'));
		frame_obj.del_bat($('.list_menu .del'), $('#case .r_con_table input[name=select]'), 'content.case_del');
	},

	case_edit_init:function(){
		frame_obj.translation_init();
		frame_obj.switchery_checkbox();
		frame_obj.mouse_click($('.multi_img .upload_btn, .pic_btn .edit'), '', function($this){
			var $num=$this.parents('.img').attr('num');
			frame_obj.photo_choice_init('PicUpload_'+$num, '', 'PicDetail .img[num;'+$num+']', 'products', 3, 'do_action=content.case_img_del');
		});
		$('.multi_img input[name=PicPath\\[\\]]').each(function(){
			if($(this).attr('save')==1){
				$(this).parent().find('img').attr('src', $(this).attr('data-value')); //直接替换成缩略图
			}
		});
		frame_obj.dragsort($('.multi_img'), '', 'dl', '', '<dl class="img placeHolder"></dl>'); //图片拖动
		frame_obj.mouse_click($('.pic_btn .del'), 'caseDel', function($this){ //产品主图删除点击事件
			var $obj=$this.parents('.img'),
				$num=parseInt($obj.attr('num')),
				$path=$obj.find('input[name=PicPath\\[\\]]').val();
			global_obj.win_alert(lang_obj.global.del_confirm, function(){
				$.ajax({
					url:'./?do_action=content.case_img_del&Model=case&Path='+$path+'&Index='+$num+'&CaseId='+$('#CaseId').val(),
					success:function(data){
						$obj.removeClass('isfile').removeClass('show_btn');
						$obj.parent().append($obj);
						$obj.find('.preview_pic .upload_btn').show();
						$obj.find('.preview_pic a').remove();
						$obj.find('.preview_pic input:hidden').val('').attr('save', 0);
						//frame_obj.upload_pro_img_init(1);
					}
				});
			}, 'confirm');
		});
		frame_obj.submit_form_init($('#edit_form'), './?m=content&a=case');
	},

	case_category_init:function(){
		frame_obj.del_init($('#case_inside .r_con_table'));
		frame_obj.select_all($('#case_inside .r_con_table input[name=select_all]'), $('#case_inside .r_con_table input[name=select]'), $('.list_menu_button .del'));
		frame_obj.del_bat($('.list_menu .del'), $('#case_inside .r_con_table input[name=select]'), 'content.case_category_del');
		frame_obj.dragsort($('#case_inside .r_con_table tbody'), 'content.case_category_order');
	},

	case_category_edit_init:function(){
		frame_obj.translation_init();
		frame_obj.submit_form_init($('#edit_form'), './?m=content&a=case&d=category');
	},

	download_init:function(){
		frame_obj.del_init($('#download .r_con_table'));
		frame_obj.select_all($('#download .r_con_table input[name=select_all]'), $('#download .r_con_table input[name=select]'), $('.list_menu_button .del'));
		frame_obj.del_bat($('.list_menu .del'), $('#download .r_con_table input[name=select]'), 'content.download_del');

		$('#download').on('click', 'a[name=download]', function(){
			if(!$(this).is('[target]')){
				window.location = '/?do_action=action.download&form=manage'+'&DId='+$(this).attr('id');
			}
		});
	},

	download_edit_init:function(){
		frame_obj.translation_init();
		frame_obj.switchery_checkbox();
		frame_obj.mouse_click($('.multi_img .upload_btn, .pic_btn .edit'), '', function($this){
			frame_obj.photo_choice_init('PicUpload', '.multi_img input[name=PicPath]', 'PicDetail', '', 1);
		});

		$('#download_form').fileupload({
			url: '/manage/?do_action=action.file_upload_plugin&size=file',
			acceptFileTypes: /^application\/(pdf|rar|zip|gzip|apk|ipa)$/i, //pdf rar zip gz apk ipa
			callback: function(filepath, count, name){
				$('#FilePath').val(filepath);
				$('#FileName').val(name);
			}
		});
		$('#download_form').fileupload(
			'option',
			'redirect',
			window.location.href.replace(/\/[^\/]*$/, '/cors/result.html?%s')
		);

		$('.pic_btn .del').on('click', function(){
			global_obj.win_alert(lang_obj.global.del_confirm, function(){
				var $obj=$("#PicDetail .img");
				$obj.removeClass('isfile').removeClass('show_btn');
				$obj.parent().append($obj);
				$obj.find('.preview_pic .upload_btn').show();
				$obj.find('.preview_pic a').remove();
				$obj.find('.preview_pic input:hidden').val('').attr('save', 0);
			}, 'confirm');
			return false;
		});
		frame_obj.submit_form_init($('#download_form'), './?m=content&a=download');
	},

	download_category_init:function(){
		frame_obj.del_init($('#download_inside .r_con_table'));
		frame_obj.select_all($('#download_inside .r_con_table input[name=select_all]'), $('#download_inside .r_con_table input[name=select]'), $('.list_menu_button .del'));
		frame_obj.del_bat($('.list_menu .del'), $('#download_inside .r_con_table input[name=select]'), 'content.download_category_del');
		frame_obj.dragsort($('#download_inside .r_con_table tbody'), 'content.download_category_order');
	},

	download_category_edit_init:function(){
		frame_obj.translation_init();
		frame_obj.submit_form_init($('#edit_form'), './?m=content&a=download&d=category');
	},

	blog_global:{
		del_action:'',
		order_action:'',
		init:function(){
			frame_obj.del_init($('#blog .r_con_table')); //删除事件
			frame_obj.select_all($('input[name=select_all]'), $('input[name=select]'), $('.list_menu_button .del')); //批量操作
			frame_obj.del_bat($('.list_menu .del'), $('.r_con_table input[name=select]'), content_obj.blog_global.del_action); //批量删除
			/* 批量排序 */
			$('#blog .r_con_table .myorder_select').on('dblclick', function(){
				var $obj=$(this),
					$number=$obj.attr('data-num'),
					$AId=$obj.parents('tr').find('td:eq(0) input').val(),
					$mHtml=$obj.html(),
					$sHtml=$('#myorder_select_hide').html(),
					$val;
				$obj.html($sHtml+'<span style="display:none;">'+$mHtml+'</span>');
				$number && $obj.find('select').val($number).focus();
				$obj.find('select').on('blur', function(){
					$val=$(this).val();
					if($val!=$number){
						$.post('?', 'do_action='+content_obj.blog_global.order_action+'&Id='+$AId+'&Number='+$(this).val(), function(data){
							if(data.ret==1){
								$obj.html(data.msg);
								$obj.attr('data-num', $val);
							}
						}, 'json');
					}else{
						$obj.html($obj.find('span').html());
					}
				});
			});
		}
	},

	blog_init:function(){
		content_obj.blog_global.del_action='content.blog_del';
		content_obj.blog_global.order_action='content.blog_edit_myorder';
		content_obj.blog_global.init();
	},

	blog_edit_init:function(){
		/* 图片上传 */
		frame_obj.mouse_click($('#PicDetail .upload_btn, #PicDetail .pic_btn .edit'), 'img', function($this){ //点击上传图片
			frame_obj.photo_choice_init('PicUpload', '.multi_img input[name=PicPath]', 'PicDetail', '', 1);
		});
		$('#edit_form .choice_btn').click(function(){
			var $this=$(this);
			if($this.children('input').is(':checked')){
				$this.removeClass('current');
				$this.children('input').attr('checked', false);
			}else{
				$this.addClass('current');
				$this.children('input').attr('checked', true);
			}
		});
		$('#edit_form').on('click', '.open', function(){
			if($(this).hasClass('close')){
				$(this).removeClass('close').text(lang_obj.global.open);
				$('.seo_hide').slideUp(300);
			}else{
				$(this).addClass('close').text(lang_obj.global.pack_up);
				$('.seo_hide').slideDown(300);
			}
		});
		frame_obj.submit_form_init($('#edit_form'), './?m=content&a=blog&d=blog');
	},

	blog_set_init:function(){
		/* 添加导航栏目 */
		$('#blog_edit_form').on('click', '.addNav', function (){
			var container=$('.blog_nav');
			var name_lang=container.attr('data-name');
			var link_lang=container.attr('data-link');
			var html='<div><div class="unit_input"> <b>'+name_lang+'</b> <input type="text" name="name[]" class="box_input" value="" size="10" maxlength="30" /> </div>   ';
				html+='<div class="unit_input"><b>'+link_lang+'</b> <input type="text" name="link[]" class="box_input" value="" size="30" max="150" /></div>';
				html+='<a href="javascript:void(0);"><img hspace="5" src="/static/ico/del.png"></a><div class="blank6"></div></div>';
			container.append(html);
		});
		/* 移除导航栏目 */
		$('.blog_nav').on('click', 'div a', function (){
			$(this).parent().remove();
		});
		/* 广告图上传 */
		frame_obj.mouse_click($('#AdDetail .upload_btn, #AdDetail .pic_btn .edit'), 'img', function($this){ //点击上传图片
			frame_obj.photo_choice_init('PicUpload', '.multi_img input[name=Banner]', 'AdDetail', '', 1);
		});
		frame_obj.submit_form_init($('#blog_edit_form'), './?m=content&a=blog&d=set');
	},

	blog_category_init:function(){
		content_obj.blog_global.del_action='content.blog_category_del_bat';
		content_obj.blog_global.order_action='content.blog_category_my_order';
		content_obj.blog_global.init();

		frame_obj.dragsort($('#blog .r_con_table tbody'), 'content.blog_category_order', 'tr', 'a, td[data!=move_myorder]', '<tr class="placeHolder"></tr>'); //元素拖动
	},

	blog_category_edit_init:function(){
		frame_obj.submit_form_init($('#blog_edit_form'), './?m=content&a=blog&d=category');
	},

	blog_review_init:function(){
		content_obj.blog_global.del_action='content.blog_review_del';
		content_obj.blog_global.init();
	},

	blog_review_reply_init:function(){
		frame_obj.submit_form_init($('#blog_review_edit_form'), './?m=content&a=blog&d=review');
	},

	photo_global:{
		list:function(){//图片银行列表
			$('body').on('click', '.bat_open', function(){//全选
				if($('#photo_list_form input:checkbox').not(':checked').length<301){
					$('#photo_list_form input:checkbox').not(':checked').each(function(){
						// $(this).parent('.img').click();
						$(this).attr('checked','checked').parent().parent().addClass('cur');
					});
					$(this).hide();
					$('.un_bat_open').css('display','block');
					$('.list_menu .move,.list_menu .del').css('display','block')
				}else{
					global_obj.win_alert(lang_obj.manage.photo.too_many, 'confirm');
				}
			}).on('click', '.un_bat_open', function(){//全选
				if($('#photo_list_form input:checkbox:checked').length<301){
					$('#photo_list_form input:checkbox:checked').each(function(){
						// $(this).parent('.img').click();
						$(this).removeAttr('checked').parent().parent().removeClass('cur');
					});
					$(this).hide();
					$('.bat_open').css('display','block');
					$('.list_menu .move,.list_menu .del').css('display','none')
				}else{
					global_obj.win_alert(lang_obj.manage.photo.too_many, 'confirm');
				}
			}).on('click', '.add', function(){//添加
				return false;
			}).on('click', '.del', function(){//删除
				var $this=$(this);
				global_obj.win_alert(lang_obj.global.del_confirm, function(){
					$.post('?', $('#photo_list_form').serialize(), function (data){
						if(data.ret!=1){
							global_obj.win_alert(data.msg);
						}else{
							window.location='./?m=content&a=photo&CateMenu='+$('.search_form select[name=CateMenu] option:selected').val()+'&Keyword='+$('.search_form input[name=Keyword]').val()+'&page='+$('#photo_list_form input[name=Page]').val();
						}
					}, 'json');
				}, 'confirm');
				return false;
			}).on('click', '.photo_list .item .img', function(){//勾选图片框
				var parent=$(this).parent('.item'),
					$sort=$('#photo input[name=sort]').val(),
					$val=$(this).find('input').val();
				if(parent.hasClass('cur')){
					parent.removeClass('cur');
					$(this).find('input').attr('checked', false);
					if($sort && global_obj.in_array($val, $sort.split('|'))){
						$('#photo input[name=sort]').val($sort.replace('|'+$val+'|', '|'));
					}
				}else{
					parent.addClass('cur');
					$(this).find('input').attr('checked', true);
					if($sort && !global_obj.in_array($val, $sort.split('|'))){
						$('#photo input[name=sort]').val($sort+$val+'|');
					}
				}
				if($('#photo_list_form input:checkbox:checked').length){
					$('.list_menu .move,.list_menu .del').css('display','block');
				}else{
					$('.list_menu .move,.list_menu .del').hide();
				}
				return false;
			}).on('click', '.photo_list .item .zoom', function(e){
				e.stopPropagation();
			}).on('click', '.refresh', function(){ //单个移动（已移除）
				frame_obj.pop_iframe_page_init('./?m=content&a=photo&d=move&PId='+$(this).prev().val(), 'user_group');
			}).on('click', '.move', function(){ //批量移动
				var $obj=$('.box_move_edit'),
					$html='';
				$obj.find('input[name=PId], input[name=PId\\[\\]]').remove();
				$('.PIds:checked').each(function(){
					$html+='<input type="hidden" name="PId[]" value="'+$(this).val()+'" />';
				});
				$obj.find('.rows').after($html);
				return false;
			});

			frame_obj.fixed_right($('.list_menu .add'),'.box_photo_edit');//添加
			frame_obj.fixed_right($('.list_menu .move'),'.box_move_edit');//移动
			var is_animate=0;
			$('.auto_load_photo').scroll(function(){
				var $obj=$('.auto_load_photo'),
					viewHeight=$obj.outerHeight(true),//可见高度
					contentHeight=$obj.get(0).scrollHeight,//内容高度
					scrollHeight=$obj.scrollTop(),//滚动高度
					page=parseInt($obj.attr('data-page')),
					total_pages=parseInt($obj.attr('data-total-pages'));
				if((contentHeight - viewHeight <= scrollHeight)&&is_animate==0&&page<=total_pages){
					is_animate=1;
					frame_obj.load_edit_form('.photo_list_box',$('.photo_list_box').attr('data-page-url'),'get','&page='+(page+1),function(){
						$obj.attr('data-page',(page+1));
						is_animate=0;
					},'append');
				}
				if(page>=total_pages&&is_animate==0){
					global_obj.win_alert_auto_close('已经是最后一页了！', 'await', 2000, '8%', 0);
					is_animate=1;
				}
			});
			//提交
			frame_obj.submit_form_init($('#box_photo_edit'), './?m=content&a=photo');
			frame_obj.submit_form_init($('#move_edit_form'), './?m=content&a=photo');
		}
	},

	photo_choice_init:function(){
		var resize=function(){
			$('#photo .wrap_content').css({'overflow':'auto', 'height':($(window).height()-$('.list_menu').outerHeight()-$('.list_foot').outerHeight()-20)});
		};
		resize();
		$(window).resize(function(){resize();});
		var save=$('input[name=save]').val(),//保存图片隐藏域ID
			id=$('input[name=id]').val(),//显示元素的ID
			type=$('input[name=type]').val(),//类型
			maxpic=$('input[name=maxpic]').val(),//最大允许图片数
			number=0,
			file2BigName_hidden_obj=$("input[name='file2BigName_hidden_text']"),
			file2BigName="</br>";//执行次数
		$('form[name=upload_form]').fileupload({
			url: '/manage/?do_action=action.file_upload&size='+type,
			acceptFileTypes: /^image\/(gif|jpe?g|png|x-icon|webp)$/i,
			disableImageResize:false,
			//maxNumberOfFiles: 1,
			imageMaxWidth: 2000,
			imageMaxHeight: 99999,
			imageForceResize:false,
			//maxFileSize: 2000000,
			messages: {
				maxFileSize: lang_obj.manage.photo.size_limit,
			},
			callback: function(imgpath, surplus, name, error){// 上传后的文件/0/原文件名
				if(error){
					file2BigName+=name+" </br>";//;
					file2BigName_hidden_obj.val(file2BigName);
				}
				frame_obj.photo_choice_return(id, type, save, maxpic, 1, imgpath, surplus, ++number,name);
			}
		});
		
		$('form[name=upload_form]').fileupload(
			'option',
			'redirect',
			window.location.href.replace(/\/[^\/]*$/, '/cors/result.html?%s')
		);
		content_obj.photo_global.list();
	},

	photo_init:function(){
		frame_obj.del_init($('#photo .category'));
		content_obj.photo_global.list();
	},

	photo_category_init:function(){
		frame_obj.del_init($('#photo .r_con_table')); //删除事件
		frame_obj.select_all($('#photo .r_con_table input[name=select_all]'), $('#photo .r_con_table input[name=select]'), $('.list_menu_button .del'));

		/* 批量删除 */
		frame_obj.del_bat($('.list_menu .del'), $('#photo .r_con_table input[name=select]'), '', function(id_list){
			var $this=$(this);
			global_obj.win_alert(lang_obj.global.del_confirm, function(){
				$.get('?', {do_action:'content.photo_category_del_bat', group_id:id_list}, function(data){
					if(data.ret==1){
						window.location.reload();
					}
				}, 'json');
			}, 'confirm');
			return false;
		});
		/* 批量排序 */
		$('#photo .r_con_table .myorder_select').on('dblclick', function(){
			var $obj=$(this),
				$number=$obj.attr('data-num'),
				$CateId=$obj.parents('tr').find('td:eq(0)>input').val(),
				$mHtml=$obj.html(),
				$sHtml=$('#myorder_select_hide').html(),
				$val;
			$obj.html($sHtml+'<span style="display:none;">'+$mHtml+'</span>');
			$number && $obj.find('select').val($number).focus();
			$obj.find('select').on('blur', function(){
				$val=$(this).val();
				if($val!=$number){
					$.post('?', 'do_action=content.photo_category_edit_myorder&Id='+$CateId+'&Number='+$(this).val(), function(data){
						if(data.ret==1){
							$obj.html(data.msg);
							$obj.attr('data-num', $val);
						}
					}, 'json');
				}else{
					$obj.html($obj.find('span').html());
				}
			});
		});
		$('#photo .r_con_table tbody').dragsort({
			dragSelector:'tr',
			dragSelectorExclude:'a, td[data!=move_myorder], dl',
			placeHolderTemplate:'<tr class="placeHolder"></tr>',
			scrollSpeed:5,
			dragEnd:function(){
				var data=$(this).parent().children('tr').map(function(){
					return $(this).attr('cateid');
				}).get();
				$.get('?', {do_action:'content.photo_category_edit_myorder', sort_order:data.join('|')});
			}
		});
		$('#photo .attr_list').dragsort({
			dragSelector:'dl',
			dragSelectorExclude:'a, dd[class!=attr_ico]',
			placeHolderTemplate:'<dl class="attr_box placeHolder"></dl>',
			scrollSpeed:5,
			dragEnd:function(){
				var data=$(this).parent().children('dl').map(function(){
					return $(this).attr('cateid');
				}).get();
				$.get('?', {do_action:'content.photo_category_order', sort_order:data.join('|')});
			}
		});
		$('#photo .attr_box').hover(function(){
			$(this).children('.attr_menu').stop(true, true).animate({'right':0}, 200);
		}, function(){
			$(this).children('.attr_menu').stop(true, true).animate({'right':-51}, 200);
		});
		/* 编辑弹出框 */
		frame_obj.fixed_right($('.list_menu .add, .attr_add .add, .r_con_table .edit'),'.box_photo_category_edit');//添加
		$('.list_menu .add, .attr_add .add, .r_con_table .edit').on('click', function(){
			var $id=parseInt($(this).attr('data-id')),
				$obj=$('.box_photo_category_edit');
			if($id){ //编辑
				var $data='';
				if($(this).parent().hasClass('attr_menu')){
					$data=$.evalJSON($(this).parents('dl.attr_box').attr('data'));
				}else{
					$data=$.evalJSON($(this).parents('tr').attr('data'));
				}
				$('#box_photo_category_edit input[name=Category]').val($data['Category']); //分类名称
				$.post('?', {do_action:'content.photo_category_select', 'ParentId':0, 'CateId':$id}, function(data){
					$('#box_photo_category_edit .rows:eq(1) .input').html(data); //分类所属
					$('#box_photo_category_edit input[name=UnderTheCateId]').parents('.down_select_box').find('.select[value='+$data['TopCateId']+']').click();
				});
				$('#box_photo_category_edit input[name=CateId]').val($id); //id
				$('.box_photo_category_edit .top_title>span').text(lang_obj.global.edit); //编辑框标题
			}else{ //添加
				var $ParentId=0;
				if($(this).parent().hasClass('attr_add')){
					$ParentId=$(this).parents('tr').attr('cateid');
				}
				$('#box_photo_category_edit input[name=Category]').val(''); //分类名称
				$.post('?', {do_action:'content.photo_category_select', 'ParentId':$ParentId, 'CateId':0}, function(data){
					$('#box_photo_category_edit .rows:eq(1) .input').html(data); //分类所属
					$('#box_photo_category_edit select[name=UnderTheCateId]').val($ParentId);
					$('#box_photo_category_edit input[name=UnderTheCateId]').parents('.down_select_box').find('.select[value='+$ParentId+']').click();
				});
				$('#box_photo_category_edit input[name=CateId]').val(0); //id
				$('.box_photo_category_edit .top_title>span').text(lang_obj.global.add); //编辑框标题
			}
			return false;
		});
		//提交
		frame_obj.submit_form_init($('#box_photo_category_edit'), './?m=content&a=photo&d=category');
	},

	photo_upload_init:function(){
		$('form[name=upload_form]').fileupload({
			url: '/manage/?do_action=action.file_upload_plugin&size=photo',
			acceptFileTypes: /^image\/(gif|jpe?g|png|x-icon|webp)$/i,
			disableImageResize:false,
			imageMaxWidth: 2000,
			imageMaxHeight: 99999,
			imageForceResize:false,
			maxFileSize: 2000000,
			maxNumberOfFiles: 20,
			messages: {
				maxFileSize: lang_obj.manage.photo.size_limit,
				maxNumberOfFiles: lang_obj.manage.account.picture_tips.replace('xxx', 20),
			},
			callback: function(imgpath, surplus, name){
				/*if($('#PicDetail .pic').length>=20){
					global_obj.win_alert(lang_obj.manage.account.picture_tips.replace('xxx', 20));
					return;
				}*/
				$('#PicDetail').append('<div class="pic"><div>'+frame_obj.upload_img_detail(imgpath)+'<span>'+lang_obj.global.del+'</span><input type="hidden" name="PicPath[]" value="'+imgpath+'" /></div><input type="text" maxlength="30" class="box_input" value="'+name+'" name="Name[]" placeholder="'+lang_obj.global.picture_name+'" notnull></div>');
				$('#PicDetail div span').off('click').on('click', function(){
					var $this=$(this);
					global_obj.win_alert(lang_obj.global.del_confirm, function(){
						$.ajax({
							url:'./?m=content&a=photo&do_action=content.photo_upload_del&Path='+$this.prev().attr('href')+'&Index='+$this.parent().parent().index(),
							success:function(data){
								json=eval('('+data+')');
								$('#PicDetail .pic:eq('+json.msg[0]+')').remove();
							}
						});
					}, 'confirm', 1);
					return false;
				});
			}
		});
		$('form[name=upload_form]').fileupload(
			'option',
			'redirect',
			window.location.href.replace(/\/[^\/]*$/, '/cors/result.html?%s')
		);
	}
}