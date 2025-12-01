/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

set_obj=$.extend({
	/* 图片银行 */
	photo_default_init:function(){//图片银行默认执行
		set_obj.photo_frame_init();
		set_obj.photo_list_init();
	},
	
	photo_frame_init:function(){
		$('#photo .page_menu').height($(window.parent.document).find('.iframe').height()-50);
		$('#photo .page_menu').jScrollPane();
		if($('#photo .view').height()<$(window).height()-50) $('#photo .view').height($(window).height()-50);
		$('.r_category_wrap .wrap_content').height($('.r_category_wrap').height()-$('.r_category_wrap .list_title').outerHeight()-($(window).width()<870?50:0));
		
		/*************** 图片选择页面js Start ***************/
		$choice=$(window.parent.document).find('#photo_choice');
		if($choice.length){
			$('html').height($choice.height()).css('overflow', 'hidden');
			$('#photo .choice_menu, #photo .choice_view').height($choice.height());
			$('#photo .photo_list').height($choice.height()-$('#photo .list_hd').outerHeight(true)-$('#photo .list_foot').outerHeight(true)-$('#photo .list_upload').outerHeight(true));
			$(parent.document).find('html').css('overflow', 'hidden');
			
			/*
			var $obj = $('input[name=obj]').val(),//点击按钮ID
				$save = $('input[name=save]').val(),//保存图片隐藏域ID
				$id = $('input[name=id]').val(),//显示元素的ID
				$type = $('input[name=type]').val(),//类型
				$maxpic = $('input[name=maxpic]').val(),//最大允许图片数
				number = 0;//执行次数
			var callback=function(imgpath, surplus){
				frame_obj.return_photo($id, $type, $save, $maxpic, 1, imgpath, surplus, ++number);
			}
			frame_obj.file_upload($('#PicUpload'), '', '', $type, true, $maxpic, callback);
			*/
			var $obj	= $('input[name=obj]').val(), //点击按钮ID
				$save	= $('input[name=save]').val(), //保存图片隐藏域ID
				$id		= $('input[name=id]').val(), //显示元素的ID
				$type	= $('input[name=type]').val(), //类型
				$maxpic	= $('input[name=maxpic]').val(), //最大允许图片数
				number	= 0;//执行次数
			$('form[name=upload_form]').fileupload({
				url: '/manage/?do_action=action.file_upload_plugin&size='+$type,
				acceptFileTypes: /^image\/(gif|jpe?g|png|x-icon|webp)$/i,
				callback: function(imgpath, surplus){
					frame_obj.return_photo($id, $type, $save, $maxpic, 1, imgpath, surplus, ++number);
				}
			});
			$('form[name=upload_form]').fileupload(
				'option',
				'redirect',
				window.location.href.replace(/\/[^\/]*$/, '/cors/result.html?%s')
			);
			
			if($obj){
				var $tips = $(window.parent.document).find('#'+$obj).next('.tips').text();
				if($tips){
					$('.list_upload .tips').text($tips);
				}
			}
			
			//点击遮罩层，关闭选择框
			$(parent.document.getElementById('div_mask')).click(function(e){
				//$(this).parents('html').css('overflow', 'auto');
				$(this).parent('body').find('#photo_choice').remove();
				$(this).remove();
			});
			
			$('#photo').on('click', '.page_menu_list a', function(){
				var $this;
				$('#photo .page_menu_list').find('a').removeClass('cur');
				$(this).addClass('cur');
				if($this=$(this).parents('.menu_one').next()){
					if($this.is(':hidden')){
						$this.parent().addClass('current');
						$this.show();
					}else{
						$this.parent().removeClass('current');
						$this.hide();
					}
				}
				
				$.ajax({
					type:'post',
					url:$(this).attr('href'),
					async:false,
					success:function(data){
						$('.list_hd').html($(data).find('.list_hd').html());
						$('.photo_list').html($(data).find('.photo_list').html());
						set_obj.photo_ajax_init();
					}
				});
				
				$('#photo .page_menu').jScrollPane();
				return false;
			});
			
			set_obj.photo_ajax_init();
		}
		/*************** 图片选择页面js End ***************/
	},
	
	photo_list_init:function(){//图片银行列表
		$('#list_search_form').submit(function(){return false;});
		$('#list_search_form input:submit').click(function(){
			if(global_obj.check_form($('*[notnull]'))){return false;}
			window.location='./?m=set&a=photo&'+$('#list_search_form').serialize();
		});
		
		$('#photo').on('click', '.anti', function(){//全选
			var $this=$(this);
			if($this.children('input').get(0).checked){
				$this.removeClass('current');
				$this.children('input').get(0).checked='';
			}else{
				$this.addClass('current');
				$this.children('input').get(0).checked='checked';
			}
			$('#photo_list_form .PIds').each(function(index, element) {
				$(element).parent('.img').click();
            });
		}).on('click', '.del', function(){
			var $this=$(this);
			global_obj.win_alert(lang_obj.global.del_confirm, 'confirm', function(){
				window.location=$this.attr('href');
			});
			return false;
		}).on('click', '.del_bat', function(){
			var $this=$(this);
			global_obj.win_alert(lang_obj.global.del_confirm, 'confirm', function(){
				$.post('?', $('#photo_list_form').serialize(), function (data){
					if(data.ret!=1){
						global_obj.win_alert(data.msg);
					}else{
						window.location='./?m=set&a=photo&CateId='+$('#photo_list_form input[name=CateId]').val()+'&IsSystem='+$('#photo_list_form input[name=IsSystem]').val();
					}
				}, 'json');
			});
			return false;
		}).on('click', '.clear_folder', function(e) {
			var $this=$(this);
			global_obj.win_alert(lang_obj.global.del_confirm, 'confirm', function(){
				$.post('?', {do_action:'set.photo_clear_folder'}, function (data){
					if(data.ret==1){
						global_obj.win_alert(lang_obj.manage.photo.empty_temp);
					}
				}, 'json');
			});
			return false;
		}).on('click', '.photo_list .item .img', function() {
			var parent=$(this).parent('.item'),
				$sort=$('#photo input[name=sort]').length>0?$('#photo input[name=sort]').val():'',
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
		}).on('click', '.photo_list .item .zoom', function(e) {
			e.stopPropagation();
		}).on('click', '.refresh', function(){
			var photoH = parseInt($(window).height())-(150*2);
			global_obj.div_mask();
			$('#photo').append('<div id="photo_choice"><iframe src="./?m=set&a=photo&iframe=1&d=move&PId='+$(this).prev().val()+'&r='+Math.random()+'" frameborder="0"></iframe></div>');
			$('#photo_choice, #photo_choice iframe').height(photoH);
			
			var photoOH = parseInt($('#photo_choice').outerHeight(true));
			$('#photo_choice').css({'display':'block', 'margin-top':-(photoOH/2)});
			window.onresize=function(){
				photoH = parseInt($(window).height())-(150*2);
				$('#photo_choice, #photo_choice iframe').height(photoH);
				$('#photo_choice').css({'margin-top':-(photoH+10)/2});
			};
		});
		$('.panel_2').click(function(){
			var photoH = parseInt($(window).height())-(150*2);
			PIds = $('.PIds');
			str = "";
			for(i=0;i<PIds.length;i++){
				if(PIds.eq(i).attr('checked')=='checked'){
					str += "&PId[]="+PIds.eq(i).val();
				}
			}
			global_obj.div_mask();
			$('#photo').append('<div id="photo_choice"><iframe src="./?m=set&a=photo&d=move&iframe=1'+str+'&r='+Math.random()+'" frameborder="0"></iframe></div>');
			$('#photo_choice, #photo_choice iframe').height(photoH);
			
			var photoOH = parseInt($('#photo_choice').outerHeight(true));
			$('#photo_choice').css({'display':'block', 'margin-top':-(photoOH/2)});
			window.onresize=function(){
				photoH = parseInt($(window).height())-(150*2);
				$('#photo_choice, #photo_choice iframe').height(photoH);
				$('#photo_choice').css({'margin-top':-(photoH+10)/2});
			};
		});
	},
	
	photo_ajax_init:function(){//图片银行ajax加载
		$('#choice_search_form').submit(function(){return false;});
		$('#choice_search_form input:submit').off().on('click', function(){
			if(global_obj.check_form($('*[notnull]'))){return false;}
			$.ajax({
				type:'post',
				url:$('#choice_search_form input[name=location]').val()+'&Name='+$('#choice_search_form input[name=Name]').val(),
				async:false,
				success:function(data){
					$('.list_hd').html($(data).find('.list_hd').html());
					$('.photo_list').html($(data).find('.photo_list').html());
					set_obj.photo_ajax_init();
				}
			});
			return false;
		});
		
		$('#turn_page_oth').off().on('click', 'a', function(){
			$.ajax({
				type:'post',
				url:$(this).attr('href'),
				async:false,
				success:function(data){
					$('.list_hd').html($(data).find('.list_hd').html());
					$('.photo_list').html($(data).find('.photo_list').html());
					set_obj.photo_ajax_init();
				}
			});
			return false;
		});
	},
	
	photo_category_edit_init:function(){
		$('#photo_category_form').submit(function(){return false;});
		$('#photo_category_form input:submit').click(function(){
			if(global_obj.check_form($('*[notnull]'))){return false;};
			$(this).attr('disabled', true);
			
			$.post('?', $('#photo_category_form').serialize(), function(data){
				$('#photo_category_form input:submit').attr('disabled', false);
				if(data.ret!=1){
					global_obj.win_alert(data.msg);
				}else{
					window.location='./?m=set&a=photo';
				}
			}, 'json');
		});
	},
	
	photo_add_init:function(){//添加图片
		/*
		var callback=function(imgpath,name){
			if($('#PicDetail .pic').length>=5){
				global_obj.win_alert(lang_obj.manage.account.picture_tips.replace('xxx', 5));
				return;
			}
			$('#PicDetail').append('<div class="pic"><div>'+frame_obj.upload_img_detail(imgpath)+'<span>'+lang_obj.global.del+'</span><input type="hidden" name="PicPath[]" value="'+imgpath+'" /></div><input type="text" maxlength="30" class="form_input" value="'+name+'" name="Name[]" placeholder="'+lang_obj.global.picture_name+'" notnull></div>');
			$('#PicDetail div span').off('click').on('click', function(){
				var $this=$(this);
				global_obj.win_alert(lang_obj.global.del_confirm, 'confirm', function(){
					$.ajax({
						url:'./?m=set&a=photo&do_action=set.photo_img_del&Path='+$this.prev().attr('href')+'&Index='+$this.parent().index(),
						success:function(data){
							json=eval('('+data+')');
							$('#PicDetail div:eq('+json.msg[0]+')').remove();
						}
					});
				});
				return false;
			});
		};
		set_obj.file_upload($('#PicUpload'), '', '', '', true, 5, callback);
		*/
		$('#photo_add_form').fileupload({
			url: '/manage/?do_action=action.file_upload_plugin&size=photo',
			acceptFileTypes: /^image\/(gif|jpe?g|png|webp)$/i,
			callback: function(imgpath,len,name){
				if($('#PicDetail .pic').length>=5){
					global_obj.win_alert(lang_obj.manage.account.picture_tips.replace('xxx', 5));
					return;
				}
				$('#PicDetail').append('<div class="pic"><div>'+frame_obj.upload_img_detail(imgpath)+'<span>'+lang_obj.global.del+'</span><input type="hidden" name="PicPath[]" value="'+imgpath+'" /></div><input type="text" maxlength="30" class="form_input" value="'+name+'" name="Name[]" placeholder="'+lang_obj.global.picture_name+'" notnull></div>');
				$('#PicDetail div span').off('click').on('click', function(){
					var $this=$(this);
					global_obj.win_alert(lang_obj.global.del_confirm, 'confirm', function(){
						$.ajax({
							url:'./?m=set&a=photo&do_action=set.photo_img_del&Path='+$this.prev().attr('href')+'&Index='+$this.parent().index(),
							success:function(data){
								json=eval('('+data+')');
								$('#PicDetail div:eq('+json.msg[0]+')').remove();
							}
						});
					});
					return false;
				});
			}
		});
		$('#photo_add_form').fileupload(
			'option',
			'redirect',
			window.location.href.replace(/\/[^\/]*$/, '/cors/result.html?%s')
		);
		
		$('#photo_add_form').submit(function(){return false;});
		$('#photo_add_form input:submit').click(function(){
			if(global_obj.check_form($('*[notnull]'))){return false;};
			
			$.post('?', $('#photo_add_form').serialize(), function(data){
				$('#photo_add_form input:submit').attr('disabled', true);
				if(data.ret!=1){
					global_obj.win_alert(data.msg);
				}else{
					window.location=data.msg[0]?data.msg[0]:'./?m=set&a=photo';
				}
			}, 'json');
		});
		
	},
	
	file_upload:function(file_input_obj, filepath_input_obj, img_detail_obj, size){//图片上传
		var multi=(typeof(arguments[4])=='undefined')?false:arguments[4];
		var queueSizeLimit=(typeof(arguments[5])=='undefined')?5:arguments[5];
		var callback=arguments[6];
		var fileExt=(typeof(arguments[7])=='undefined')?'*.jpg;*.png;*.gif;*.jpeg;*.bmp;*.webp':arguments[7];
		
		file_input_obj.omFileUpload({
			action:'./?session_id='+session_id,
			actionData:{
				do_action:'set.photo_file_upload',
				size:size
			},
			fileExt:fileExt,
			fileDesc:'Files',
			autoUpload:true,
			multi:multi,
			queueSizeLimit:queueSizeLimit,
			swf:'/inc/file/fileupload.swf?r='+Math.random(),
			method:'post',
			onComplete:function(ID, fileObj, response, data, event){
				var jsonData=eval('('+response+')');
				if(jsonData.status==1){
					if($.isFunction(callback)){
						callback(jsonData.filepath,jsonData.name);
					}else{
						filepath_input_obj.val(jsonData.filepath);
						img_detail_obj.html(frame_obj.upload_img_detail(jsonData.filepath));
					}
				}
			}
		});
	},
	
	photo_move_init:function(){//图片移动
		$('.r_footer').remove();
		$choice=$(window.parent.document).find('#photo_choice');
		$('html').height($choice.height()).css('overflow', 'hidden');
		$('#choice_move').height($choice.height()-$('#photo .list_hd').height());
		//$('#choice_move .move_list').height($choice.height()-$('#choice_move .list_hd').outerHeight(true)-$('#choice_move .list_foot').outerHeight(true));
		$(parent.document).find('html').css('overflow', 'hidden');
		
		//点击遮罩层，关闭选择框
		$(parent.document.getElementById('div_mask')).on('click', function(e){
			$(this).parents('html').css('overflow', 'auto');
			$(this).parent('body').find('#photo_choice').remove();
			$(this).remove();
		});
		
		$('#button_add').on('click', function(){
			$('#button_add').attr('disabled', true);
			$.post('?', $('#move_photo_form').serialize(), function(data){
				$('#button_add').attr('disabled', false);
				if(data.ret!=1){
					global_obj.win_alert(data.msg);
				}else{
					parent.document.location.reload();
					global_obj.win_alert(lang_obj.manage.photo.move_success);
					frame_obj.close_photo_choice();
				}
			}, 'json');
		});
	}
	
}, set_obj);