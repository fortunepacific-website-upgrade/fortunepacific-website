/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/
var products_obj={
	products_init:function(){
		frame_obj.del_init($('#products .r_con_table'));
		frame_obj.select_all($('#products .r_con_table input[name=select_all]'), $('#products .r_con_table input[name=select]'), $('.list_menu_button .del, .list_menu_button .explode'));	//批量、导出操作
		frame_obj.del_bat($('.list_menu .del'), $('#products .r_con_table input[name=select]'), 'products.products_del');	//批量删除
		$('#products .r_con_table .copy').click(function(){
			var o=$(this);
			global_obj.win_alert(lang_obj.global.copy_confirm, function(){
				window.location=o.attr('href');
			}, 'confirm');
			return false;
		});
		$('.list_menu_button .explode').click(function(){
			var id_list='';
			$('#products .r_con_table input[name=select]').each(function(index, element) {
				id_list+=$(element).get(0).checked?$(element).val()+',':'';
            });
			if(id_list){
				id_list=id_list.substring(0,id_list.length-1);
				window.location='./?do_action=products.products_explode&id='+id_list;
			}else{
				global_obj.win_alert(alert_txt?alert_txt:lang_obj.global.explode_dat_select);
			}
		});
		$('#products .r_con_table .myorder_select').on('dblclick', function(){
			var $obj=$(this),
				$number=$obj.attr('data-num'),
				$ProId=$obj.parents('tr').find('td:eq(0) input').val(),
				$mHtml=$obj.html(),
				$sHtml=$('#myorder_select_hide').html(),
				$val;
			$obj.html($sHtml+'<span style="display:none;">'+$mHtml+'</span>');
			$number && $obj.find('select').val($number).focus();
			$obj.find('select').on('blur', function(){
				$val=$(this).val();
				if($val!=$number){
					$.post('?', 'do_action=products.products_edit_myorder&ProId='+$ProId+'&Number='+$(this).val(), function(data){
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

	//语言选择
	products_edit_select_lang:function(){
		var lang_size=$('.lang_list .checked').length;
		lang_size==1?$('.tab_box_row').hide():$('.tab_box_row').show();
		$(".lang_list .input_checkbox input").each(function(){
			var pro_lang = $(this).attr('lang');
			if(lang_size<1 || $(this).is(':checked')){
				$('.tab_box_row .drop_down a[data-lang='+pro_lang+']').show();
				$('input[name=Name_'+pro_lang+']').attr('notnull','notnull');
			}else{
				$('.tab_box_row .drop_down a[data-lang='+pro_lang+']').hide();
				$('input[name=Name_'+pro_lang+']').removeAttr('notnull');
			}
		});
		$('.tab_box_row dt span').html($('.lang_list .checked:first font').html());
		$('.tab_box_row .drop_down').each(function(index, element) {
			//$(this).find('a[data-lang='+$(".lang_list .input_checkbox input:checked").attr("lang")+']').click();
		});
	},

	//产品属性
	products_edit_attr_select:function(value, attr, attrid){
		$.ajax({
			url:'./?m=products&a=products&do_action=products.products_get_attr&CateId='+value+(attrid?'&OldAttrId='+attrid:'')+(attr?'&Attr='+attr:''),
			success:function(data){
				if(data){
					json=eval('('+data+')');
					$('#edit_form .attribute').html(json.msg[0].toString());
					$('#all_attr').val(json.msg[1].toString());
					$('#attribute_hide').val(json.msg[2]);
					$('#check_attr').val('');
					products_obj.products_edit_select_lang();
				}
			}
		});
	},

	products_edit_init:function(){
		frame_obj.translation_init();
		
		$(".tab_txt").hide();
		var pro_default_lang = $(".pro_default_lang").val();
		$(".tab_txt_"+pro_default_lang).show();
		//语言选择
		$('body').on('click', '#products .lang_list .input_checkbox_box', function(e){
			var $obj=$(this);
			if(!$obj.hasClass('checked')){
				if($('#products .lang_list .checked').length<1){
					global_obj.win_alert(lang_obj.manage.set.select_once_language,function(){
						$obj.click();
						//var index = $obj.index();
						//$(".rows .input .tab_txt").eq(index).click();
					});
				}else{
					$obj.removeClass('checked').find('input').removeAttr('checked');
				}
			}else{
				$obj.addClass('checked').find('input').attr('checked','checked');
			}
			products_obj.products_edit_select_lang();
		});
		products_obj.products_edit_select_lang();

		/* 多分类 */
		$('.btn_expand').on('click', function(){
			var category_sel=$('#edit_form select[name=CateId]').html();
			$('.expand_list').append('<li><div class="fl box_select"><select name="ExtCateId[]">'+category_sel.replace(' selected','')+'</select></div><a class="close fl" href="javascript:void(0);"><img src="/static/images/ico/no.png" /></a></li>');
			$('.expand_list .close').on('click', function(){
				$(this).parent().remove();
			});
		});
		$('.expand_list .close').on('click', function(){
			$(this).prev().remove();
			$(this).remove();
		});

		//产品分类选择
		$('#edit_form select[name=CateId]').on('change', function(){
			var $attrid=$('input[name=AttrId]').val();
			products_obj.products_edit_attr_select($(this).val(), '', $attrid);
		});

		//选项卡
		frame_obj.switchery_checkbox(function(obj){
			$('.'+obj.attr('rel')).show();
		}, function(obj){
			$('.'+obj.attr('rel')).hide();
		});

		//图片上传
		frame_obj.mouse_click($('.multi_img .upload_btn, .pic_btn .edit'), 'pro', function($this){ //产品主图点击事件
			var $num=$this.parents('.img').attr('num');
			frame_obj.photo_choice_init('PicUpload_'+$num, '', 'PicDetail .img[num;'+$num+']', 'products', 10, 'do_action=products.products_img_del&Model=products',"frame_obj.upload_pro_img_init(1,'',1)");
		});
		$('.multi_img input[name=PicPath\\[\\]]').each(function(){
			if($(this).attr('save')==1){
				$(this).parent().find('img').attr('src', $(this).attr('data-value')); //直接替换成缩略图
			}
		});
		frame_obj.dragsort($('.multi_img'), '', 'dl', '', '<dl class="img placeHolder"></dl>'); //图片拖动
		frame_obj.mouse_click($('.pic_btn .del'), 'proDel', function($this){ //产品主图删除点击事件
			var $obj=$this.parents('.img'),
				$num=parseInt($obj.attr('num')),
				$path=$obj.find('input[name=PicPath\\[\\]]').val();
			global_obj.win_alert(lang_obj.global.del_confirm, function(){
				$.ajax({
					url:'./?do_action=products.products_img_del&Model=products&Path='+$path+'&Index='+$num+'&ProId='+$('#ProId').val(),
					success:function(data){
						$obj.removeClass('isfile').removeClass('show_btn');
						$obj.parent().append($obj);
						$obj.find('.preview_pic .upload_btn').show();
						$obj.find('.preview_pic a').remove();
						$obj.find('.preview_pic input:hidden').val('').attr('save', 0);
						frame_obj.upload_pro_img_init(1);
					}
				});
			}, 'confirm');
		});

		//文件上传
		$('#edit_form').fileupload({
			url: '/manage/?do_action=action.file_upload_plugin&size=file',
			acceptFileTypes: /^application\/(pdf|rar|zip|gzip|apk|ipa)$/i, //pdf rar zip gz apk ipa
			callback: function(filepath, count, name){
				$('.filepath').each(function(index, element){
					if($(element).val()==''){
						$(element).val(filepath);
						$('#FileName_'+index).val(name);
						return false;
					}
				});
			}
		});

		//平台导流
		$('.platform_rows .item').click(function(e) {
			var index=$(this).index();
			if($(this).hasClass('current')){
				$(this).removeClass('current');
				$('.platform_url_rows').eq(index).hide();
			}else{
				$(this).addClass('current');
				$('.platform_url_rows').eq(index).show();
			}
		});

		frame_obj.submit_form_init($('#edit_form'), './?m=products&a=products');
	},

	category_init:function(){
		frame_obj.del_init($('#category .r_con_table'));
		frame_obj.select_all($('#category .r_con_table input[name=select_all]'), $('#category .r_con_table input[name=select]'), $('.list_menu_button .del'));	//批量操作
		frame_obj.del_bat($('.list_menu .del'), $('#category .r_con_table input[name=select]'), 'products.category_del');	//批量删除
		frame_obj.switchery_checkbox();
		frame_obj.dragsort($('#category .r_con_table tbody'), 'products.category_order');
		$('select[name=UnderTheCateId]').change(function(){
			if($(this).val()){
				$('select[name=AttrId]').parents('.rows').hide();
			}else{
				$('select[name=AttrId]').parents('.rows').show();
			}
		});
		frame_obj.mouse_click($('.multi_img .upload_btn, .pic_btn .edit'), 'pro', function($this){ //产品主图点击事件
			frame_obj.photo_choice_init('PicUpload', '.multi_img input[name=PicPath]', 'PicDetail', '', 1);
		});
		if($('.multi_img input[name=PicPath]').length){
			var $obj=$('.multi_img input[name=PicPath]');
			if($obj.attr('save')==1){
				$obj.parent().append(frame_obj.upload_img_detail($obj.val())).children('.upload_btn').hide();
				$obj.parent().next().find('.del, .zoom').attr('href', $obj.val());
			}
		}
		$('.pic_btn .del').on('click', function(){
			$('.multi_img .preview_pic').children('a').remove();
			$('.multi_img .preview_pic').children('.upload_btn').show();
			$('.pic_btn .del, .pic_btn .zoom').attr('href', '');
			$('.multi_img input[name=PicPath]').val('');
			return false;
		});
		frame_obj.translation_init();
		frame_obj.submit_form_init($('#edit_form'), './?m=products&a=category');
	},

	attribute_init:function(){
		frame_obj.del_init($('#attribute .r_con_table'));
	},

	attribute_edit_init:function(){
		frame_obj.translation_init();
		$('.list_input>div[lang='+ueeshop_config.language[0]+']').show();
		$('.list_input .item').append('<span class="del"></span><span class="add">+ 添加</span>');
		$('.list_input').delegate('.add', 'click', function(){
			$('.list_input').append($('.list_input .item:last').prop('outerHTML'));
			$('.list_input .item:last input').val('');
		}).delegate('.del', 'click', function(){
			$('.list_input .item').length>1 && $(this).parents('.item').remove();
		});
		frame_obj.submit_form_init($('#attribute_edit_form'), './?m=products&a=attribute');
	},

	upload_init:function(){
		$('form[name=upload_form]').fileupload({
			url:'./?do_action=action.file_upload_plugin&size=file',
			//acceptFileTypes: /^application\/vnd\.(ms-excel|openxmlformats-officedocument.spreadsheetml.sheet)$/i, //csv xlsx xls
			acceptFileTypes: /^application\/(vnd.ms-excel|vnd.openxmlformats-officedocument.spreadsheetml.sheet|csv|xlsx|xls)$/i, //csv xlsx xls
			callback: function(filepath, count){
				$('#excel_path').val(filepath);
			}
		});
		$('form[name=upload_form]').fileupload(
			'option',
			'redirect',
			window.location.href.replace(/\/[^\/]*$/, '/cors/result.html?%s')
		);
		frame_obj.submit_form_init($('#upload_form'), '', function(){
			if($('*[placeholder]').length){
				$('*[placeholder]').each(function(){
					if($(this).val()==$(this).attr('placeholder')) $(this).val('');
				});
			}
			return true;
		}, false, function(data){
			if(data.ret==2){
				$('#explode_progress').append(data.msg[1]);
				$('#upload_form input[name=Number]').val(data.msg[0]);
				$('#upload_form .btn_submit').removeAttr('disabled').click();
			}else if(data.ret==1){
				$('#explode_progress').append(data.msg);
			}else{
				global_obj.win_alert(lang_obj.global.ser_error);
			}
		});
	},
	
	
	watermark_init:function(){
		frame_obj.submit_form_init($('#edit_form'), '', '', '', function(data){
			if(data.ret==2){
				$('#explode_progress').append(data.msg[1]);
				$('#edit_form input[name=Number]').val(data.msg[0]);
				$('#edit_form .btn_submit').attr('disabled', false).click();
			}else if(data.ret==1){
				$('#explode_progress').append(data.msg);
			}else{
				global_obj.win_alert(lang_obj.global.set_error);
			}
		});
	},
}