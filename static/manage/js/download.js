/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/
var download_obj={
	<!-- 全局 Start -->
	
	global_init:function(){
		//搜索栏
		$('#search_form').submit(function(){return false;});
		$('#search_form input:submit').click(function(){
			if(global_obj.check_form($('*[notnull]'))){return false;};
			$(this).attr('disabled', true);
			
			var $form=$('input[name=Type]');
			if($form.val()=='download'){
				window.location='./?m=download&a=download&'+$('#search_form').serialize();
			}
		});
		
		frame_obj.select_all($('#download .r_con_table input[name=select_all]'), $('#download .r_con_table input[name=select]'));//批量操作
		frame_obj.del_bat($('.download_nav .del_bat'), $('#download .r_con_table input[name=select]'), download_obj.del_bat_callback);
		
		frame_obj.switchery_checkbox(function(obj){
			if(obj.find('input[name=IsUsed]').length){
				$("#default").css("display", "block");
			}
		}, function(obj){
			if(obj.find('input[name=IsUsed]').length){
				$("#default").css("display", "none");
			}
		});
		//删除事件
		$('#download').on('click', '.del', function(){
			var $this=$(this);
			if($('#global_win_alert').length) return false;
			global_obj.win_alert(lang_obj.global.del_confirm, 'confirm', function(){
				window.location=$this.attr('href');
			});
			return false;
		});
		
		//编辑页数据提交
		$('#download_form').submit(function(){return false;});
		$('#download_form input:submit').on('click', function(){
			if($('*[placeholder]').length){
				$('*[placeholder]').each(function(){
					if($(this).val()==$(this).attr('placeholder')) $(this).val('');
				});
			}
			if(global_obj.check_form($('#download_form').find('*[notnull]'))){return false;};
			//$(this).attr('disabled', true);
			
			$.post('?', $('#download_form').serializeArray(), function(data){
				$('#download_form input:submit').attr('disabled', false);
				if(data.ret!=1){
					global_obj.win_alert(data.msg);
				}else{
					var $form=$('#download_form');
					if($form.attr('name')=='category_form'){
						global_obj.win_alert(data.msg.txt);
						setTimeout(function(){
							window.location='./?m=download&a=category';
						}, 1000);
					}else if($form.attr('name')=='download_form'){
						window.location=$('#back_action').val();
					}
				}
			}, 'json');
		});
	},
	
	
	del_bat_callback:function(group_id_str){
		var $this=$(this);
		global_obj.win_alert(lang_obj.global.del_confirm, 'confirm', function(){
			var $form=$('input[name=Type]');
			if($form.val()=='download'){
				window.location='./?do_action=download.download_del_bat&group_proid='+group_id_str;
			}
		});
		return false;
	},
	
	category_frame_init:function(){
		$('.r_category_wrap .wrap_content').height($('.r_category_wrap').height()-$('.r_category_wrap .list_title').outerHeight()-($(window).width()<870?50:0));
		$('#category .page_menu').jScrollPane().width('26%');
		if($('#category .view').height()<$(window).height()-50) $('#category .view').height($(window).height()-50);
	},
	<!-- 全局 End -->
	
	<!-- 下载分类管理 Start -->
	category_default_init:function(){
		download_obj.category_frame_init();
		download_obj.category_list_init();
		download_obj.category_edit_init();
	},
	
	category_list_init:function(){
		$('#category .page_menu ul').dragsort({
			dragSelector:'li',
			dragEnd:function(){
				var data=$(this).parent().children('li').map(function(){
					return $(this).attr('CateId');
				}).get();
				$.get('?m=download&a=category', {do_action:'download.download_category_order', sort_order:data.join('|')});
			},
			dragSelectorExclude:'dl, a',
			placeHolderTemplate:'<li class="placeHolder"></li>',
			scrollSpeed:5
		});
		
		$('#category .page_menu li > dl').dragsort({
			dragSelector:'dt',
			dragEnd:function(){
				var data=$(this).parent().children('dt').map(function(){
					return $(this).attr('CateId');
				}).get();
				$.get('?m=download&a=category', {do_action:'download.download_category_order', sort_order:data.join('|')});
			},
			dragSelectorExclude:'.parent_th, a',
			placeHolderTemplate:'<dt class="placeHolder"></dt>',
			scrollSpeed:5
		});
		
		$('#category .page_menu .parent_th').dragsort({
			dragSelector:'dd',
			dragEnd:function(){
				var data=$(this).parent().children('dd').map(function(){
					return $(this).attr('CateId');
				}).get();
				$.get('?m=download&a=category', {do_action:'download.download_category_order', sort_order:data.join('|')});
			},
			dragSelectorExclude:'a',
			placeHolderTemplate:'<dd class="placeHolder"></dd>',
			scrollSpeed:5
		});
		
		$('#category').off().on('click', '.del', function(){
			var $this=$(this);
			if($('#global_win_alert').length) return false;
			global_obj.win_alert(lang_obj.global.del_confirm, 'confirm', function(){
				window.location=$this.attr('href');
			});
			return false;
		}).on('click', 'h4 a', function(){
			var $this=$(this).parents('.menu_one').next();
			if($this.is(':hidden')){
				$this.parent().addClass('current');
				$this.show();
			}else{
				$this.parent().removeClass('current');
				$this.hide();
			}
			$('#category .page_menu').jScrollPane().width('26%');
		});
	},
	
	category_edit_init:function(){
		$('#PicUpload').on('click', function(){
			frame_obj.photo_choice_init('PicUpload', 'form input[name=PicPath]', 'PicDetail', 'download_category', 1);
		});
		$('#PicDetail').html(frame_obj.upload_img_detail($('form input[name=PicPath]').val()));
		
		$('#download_form').on('click', '.open', function(){
			if($(this).hasClass('close')){
				$(this).removeClass('close').text(lang_obj.global.open);
				$('.seo_hide').slideUp(300);
			}else{
				$(this).addClass('close').text(lang_obj.global.pack_up);
				$('.seo_hide').slideDown(300);
			}
		});
	},
	<!-- 下载分类管理 End -->
	
	<!-- 下载管理 Start -->
	download_init:function(){
		$('#download').on('click', 'a[name=download]', function(){
			if(!$(this).is('[target]')){
				window.location = '/?do_action=action.download&form=manage'+'&DId='+$(this).attr('id');
			}
		});
		
		//上传图片
		$('#PicUpload').on('click', function(){
			frame_obj.photo_choice_init('PicUpload', 'form input[name=PicPath]', 'PicDetail', '', 1);
		});
		$('#PicDetail').html(frame_obj.upload_img_detail($('form input[name=PicPath]').val(),1));
		$('#PicDetail span').on('click', function(){
			$('#PicDetail').html('');
			$('#download_form input[name=PicPath]').val('');
		});

		//上传供下载文件
		/*
		var callback=function(filepath, count, name){
			$('#FilePath').val(filepath);
			$('#FileName').val(name);
		};
		frame_obj.file_upload($('#FileUpload'), '', '', 'file_upload', true, 1, callback, '*.pdf;*.rar;*.zip;*.gz;*.apk;*.ipa');
		*/
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
		
		$('#download_form .other_btns .choice_btn').click(function(){
			var $this=$(this);
			if($this.children('input').is(':checked')){
				$this.removeClass('current');
				$this.children('input').attr('checked', false);
			}else{
				$this.addClass('current');
				$this.children('input').attr('checked', true);
			}
		});
	}
	<!-- 下载管理 End -->
	
}
