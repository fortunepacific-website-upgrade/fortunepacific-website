/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/
var service_obj={
	chat_init:function(){
		frame_obj.del_init($('#chat .chat_box'));
		frame_obj.switchery_checkbox();
		frame_obj.submit_form_init($('#chat_edit_form'), './?m=service&a=chat');
		
		//弹出框编辑
		var box_chat_edit = $('.box_chat_edit');
		var select_Type = $('select[name=Type]', box_chat_edit);//选择框
		var ubox = $('.ubox', box_chat_edit);//图片上传框
		var $data = box_chat_edit.attr('data-chat');//数据
		$data=$.evalJSON($data);
		$('#chat').on('click', '.chat_title .add', function (){//添加
			$('#Picture, .whatsapp_tips').hide(0);
			$('#PicDetail .preview_pic a').remove();
			$('#PicDetail .upload_btn').css('display', 'block');
			$('#PicDetail .img').removeClass('isfile').find('.preview_pic').children('.upload_btn').show(0);
			$('#PicDetail .zoom').attr('href', 'javascript:;');
			$('input[name=Name]', box_chat_edit).val('');
			$('input[name=CId]', box_chat_edit).val('');
			$('input[name=PicPath]', box_chat_edit).val('');
			$('input[name=Account]', box_chat_edit).val('');
			select_Type.find('option:selected').attr('selected', false);
			select_Type.find('option:eq(0)').attr('selected', true);
			select_Type.change()
			if ($data.add){//判断添加权限
				ubox.css('display', 'block');
			}else{
				ubox.css('display', 'none');
			}
		});
		
		$('#chat').on('click', '.chat_box .edit', function (){//修改
			var CId=$(this).attr('data-cid');
			var data=$data[CId];
			
			$('#Picture, .whatsapp_tips').hide(0);
			$('#PicDetail .preview_pic a').remove();
			$('#PicDetail .upload_btn').css('display', 'block');
			$('input[name=Name]', box_chat_edit).val(data.Name);
			$('input[name=PicPath]', box_chat_edit).val(data.PicPath);
			$('input[name=CId]', box_chat_edit).val(CId);
			$('input[name=Account]', box_chat_edit).val(data.Account);
			select_Type.find('option:selected').attr('selected', false);
			select_Type.find('option[value="'+data.Type+'"]').attr('selected', true);
			
			if (data.Type==4){
				$('#Picture').show(0);
				if (data.PicPath){
					$('#PicDetail .img').addClass('isfile').find('.preview_pic').append(frame_obj.upload_img_detail(data.PicPath)).children('.upload_btn').hide(0);
					$('#PicDetail .zoom').attr('href', data.PicPath);
				}else{
					$('#PicDetail .img').removeClass('isfile').find('.preview_pic').children('.upload_btn').show(0);
				}
			}
			if(data.Type==5) $('.whatsapp_tips').show(0);
			
			if (data.Type==4){//判断添加权限
				ubox.css('display', 'block');
			}else{
				ubox.css('display', 'none');
			}
		});

		frame_obj.fixed_right($('.chat_box .edit, #chat .chat_title .add'), '.box_chat_edit');
		select_Type.change(function(){
			$val=$(this).val();	
			if($val==4){
				$('#Picture').show();
				$('.whatsapp_tips').hide();
			}else if($val==5){
				$('.whatsapp_tips').show();
				$('#Picture').hide();
			}else{
				$('.whatsapp_tips').hide();
				$('#Picture').hide();	
			}
		});
		/* 图片上传 */
		frame_obj.mouse_click($('#PicDetail .upload_btn, #PicDetail .pic_btn .edit'), 'img', function($this){ //点击上传图片
			//frame_obj.photo_choice_init('PicDetail', '', 1);
			frame_obj.photo_choice_init('PicDetail', '.multi_img input[name=PicPath]', 'PicDetail', '', 1);
		});
		frame_obj.dragsort($('#chat .chat_box .list_box'), 'service.chat_my_order', '.list .icon_myorder', '', '<div class="list cur"></div>', '.list'); //排序拖动
	},
	
	chat_set_init:function(){
		frame_obj.switchery_checkbox();
		
		/** 0 */
		$('#Bg3_0, .upload_Bg3_0 .edit').on('click', function(){frame_obj.photo_choice_init('DetailBg3_0', '', 1);});
		if($('form input[name=Bg3_0]').attr('save')==1){
			$('#DetailBg3_0').append(frame_obj.upload_img_detail($('form input[name=Bg3_0]').val())).children('.upload_btn').hide();
		}
		$('.upload_Bg3_0 .del').on('click', function(){
			$('#DetailBg3_0').children('a').remove();
			$('#DetailBg3_0').children('.upload_btn').show();
			$('#edit_form input[name=Bg3_0]').val('');
		});
		
		/** 1 */
		$('#Bg3_1, .upload_Bg3_1 .edit').on('click', function(){frame_obj.photo_choice_init('DetailBg3_1', '', 1);});
		if($('form input[name=Bg3_1]').attr('save')==1){
			$('#DetailBg3_1').append(frame_obj.upload_img_detail($('form input[name=Bg3_1]').val())).children('.upload_btn').hide();
		}
		$('.upload_Bg3_1 .del').on('click', function(){
			$('#DetailBg3_1').children('a').remove();
			$('#DetailBg3_1').children('.upload_btn').show();
			$('#edit_form input[name=Bg3_1]').val('');
		});
		
		/** 2 */
		$('#Bg4_0, .upload_Bg4_0 .edit').on('click', function(){frame_obj.photo_choice_init('DetailBg4_0', '', 1);});
		if($('form input[name=Bg4_0]').attr('save')==1){
			$('#DetailBg4_0').append(frame_obj.upload_img_detail($('form input[name=Bg4_0]').val())).children('.upload_btn').hide();
		}
		$('.upload_Bg4_0 .del').on('click', function(){
			$('#DetailBg4_0').children('a').remove();
			$('#DetailBg4_0').children('.upload_btn').show();
			$('#edit_form input[name=Bg4_0]').val('');
		});
		
		$('#chat .style_box input[name=Type]').click(function(){
			$Type=$(this).val();
			$.post('?', 'do_action=set.chat_style&Type='+$Type, function(data){
				if(data.ret==1){
				}else{
					global_obj.win_alert(lang_obj.global.set_error);
				}
			}, 'json');
		});
		
		$('.style_select').click(function(){
			var val = $(this).val();
			$('#bgcolor').show(0);
			$('#mulcolor').hide(0);
			$('#bg3pic').hide(0);
			$('#bg4pic').hide(0);
			if (val==1){
				$('#bgcolor').hide(0);
				$('#mulcolor').show(0);
			}else if (val==3){
				$('#mulcolor').show(0);
				$('#bg3pic').show(0);
			}else if (val==4){
				$('#bg4pic').show(0);
			}
			$('#window_style').val($(this).val());	
		});
		
		$('#chat .color').change(function (){
			var name = $(this).attr('name');
			$('.'+name).css('background-color', '#'+$(this).val()).attr('color', '#'+$(this).val());
			var hover = $('.hover'+name);
			hover.attr('hover-color', '#'+$(this).val());
		});
		
		$('#service_2 .Color').hover(function (){
			$(this).css('background-color', $(this).attr('hover-color'));
		}, function (){
			$(this).css('background-color', $(this).attr('color'));
		});
		frame_obj.submit_form_init($('#edit_form'), './?m=service&a=chat');
	}
}