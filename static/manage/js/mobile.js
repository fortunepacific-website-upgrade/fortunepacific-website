/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/
var mobile_obj={
	themes_init:function(){
		$('.temp_list .item').on('click', function (e){
			$(this).addClass('on').siblings('.item').removeClass('on');
			$('#mobile_form input[name=tpl]').val($(this).attr('data-tpl'));
		});
		//提交表单
		$('#mobile_form').submit(function(){return false;});
		$('#mobile_form input:submit').click(function(){
			if(global_obj.check_form($('*[notnull]'))){return false;};
			$(this).attr('disabled', true);
			
			$.post('?', $('#mobile_form').serializeArray(), function(data){
				$('#mobile_form input:submit').attr('disabled', false);
				if(data.ret!=1){
					global_obj.win_alert(data.msg);
				}else{
					window.location='./?m=mobile&a=themes';
				}
			}, 'json');
		});
	}
	,config_init:function (){
		var btn_preview = $('#btn_preview');
		btn_preview.css({'color':$('#btn_color').val(),'background-color':$('#btn_bg').val()});
		$('#btn_color').change(function (){
			btn_preview.css('color', '#'+$(this).val());
		});
		$('#btn_bg').change(function (){
			btn_preview.css('background-color', '#'+$(this).val());
		});
		
		var cart_btn_preview = $('#cart_btn_preview');
		cart_btn_preview.css({'color':$('#cart_btn_color').val(),'background-color':$('#cart_btn_bg').val()});
		$('#cart_btn_color').change(function (){
			cart_btn_preview.css('color', '#'+$(this).val());
		});
		$('#cart_btn_bg').change(function (){
			cart_btn_preview.css('background-color', '#'+$(this).val());
		});
		
		//提交表单
		$('#mobile_form').submit(function(){return false;});
		$('#mobile_form input:submit').click(function(){
			if(global_obj.check_form($('*[notnull]'))){return false;};
			$(this).attr('disabled', true);
			$.post('?', $('#mobile_form').serializeArray(), function(data){
				$('#mobile_form input:submit').attr('disabled', false);
				if(data.ret!=1){
					global_obj.win_alert(data.msg);
				}else{
					window.location='./?m=mobile&a=config';
				}
			}, 'json');
		});
		
		$('#LogoUpload').on('click', function(){
			frame_obj.photo_choice_init('LogoUpload', 'form input[name=LogoPath]', 'LogoDetail', '', 1);
		});
		$('#LogoDetail').html(frame_obj.upload_img_detail($('form input[name=LogoPath]').val()));
		$('#LogoDetail').on('click', 'span', function(){
			var $this=$(this);
			global_obj.win_alert(lang_obj.global.del_confirm, 'confirm', function(){
				$.ajax({
					url:'./?do_action=content.ad_img_del&PicPath='+$this.prev().attr('href'),
					success:function(data){
						json=eval('('+data+')');
						$('#LogoDetail').html('');
						$('#mobile_form input[name=LogoPath]').val('');
					}
				});
			});
			return false;
		});
	}
	,header_init:function (){
		frame_obj.switchery_checkbox();
		var icon_img = $('#mobile .headicon .img');
		icon_img.css('background-color', $('#bg_color').val());
		$('#bg_color').change(function (){
			icon_img.css('background-color', '#'+$(this).val());
		});
		
		icon_img.on('click', function (){
			icon_img.removeClass('on');
			$(this).addClass('on');
			$('#mobile_form input[name=icon]').val($(this).attr('data-icon'));
		});
		//提交表单
		$('#mobile_form').submit(function(){return false;});
		$('#mobile_form input:submit').click(function(){
			if(global_obj.check_form($('*[notnull]'))){return false;};
			$(this).attr('disabled', true);
			
			$.post('?', $('#mobile_form').serializeArray(), function(data){
				$('#mobile_form input:submit').attr('disabled', false);
				if(data.ret!=1){
					global_obj.win_alert(data.msg);
				}else{
					window.location='./?m=mobile&a=header';
				}
			}, 'json');
		});
		var Linkrow = $('#Linkrow');
		//新增导航
		$('#addLink').on('click', function(e) {
            Linkrow.append(cus_html);
        });
		/* 删除区间输入节点 */
		Linkrow.on('click', '.rows .del', function() {
           	var $this=$(this);
			if($('#global_win_alert').length) return false;
			global_obj.win_alert(lang_obj.global.del_confirm, 'confirm', function(){
				$this.parent().parent().remove();
			});
			return false;
        });
	}
	,footer_init:function (){
		var foot_preview = $('#foot_preview');
		foot_preview.css({'background-color':$('#bg_color').val(), 'color':$('#font_color').val()});
		$('#bg_color').change(function (){
			foot_preview.css('background-color', '#'+$(this).val());
		});
		$('#font_color').change(function (){
			foot_preview.css('color', '#'+$(this).val());
		});
		
		//提交表单
		$('#mobile_form').submit(function(){return false;});
		$('#mobile_form input:submit').click(function(){
			if(global_obj.check_form($('*[notnull]'))){return false;};
			$(this).attr('disabled', true);
			
			$.post('?', $('#mobile_form').serializeArray(), function(data){
				$('#mobile_form input:submit').attr('disabled', false);
				if(data.ret!=1){
					global_obj.win_alert(data.msg);
				}else{
					window.location='./?m=mobile&a=footer';
				}
			}, 'json');
		});
		var Linkrow = $('#Linkrow');
		//新增导航
		$('#addLink').on('click', function(e) {
            Linkrow.append(cus_html);
        });
		/* 删除区间输入节点 */
		Linkrow.on('click', '.rows .del', function() {
            var $this=$(this);
			if($('#global_win_alert').length) return false;
			global_obj.win_alert(lang_obj.global.del_confirm, 'confirm', function(){
				$this.parent().parent().remove();
			});
			return false;
        });
	}
	,list_init:function (){
		$('.temp_list .item').on('click', function (e){
			$(this).addClass('on').siblings('.item').removeClass('on');
			$('#mobile_form input[name=tpl]').val($(this).attr('data-tpl'));
		});
		//提交表单
		$('#mobile_form').submit(function(){return false;});
		$('#mobile_form input:submit').click(function(){
			if(global_obj.check_form($('*[notnull]'))){return false;};
			$(this).attr('disabled', true);
			
			$.post('?', $('#mobile_form').serializeArray(), function(data){
				$('#mobile_form input:submit').attr('disabled', false);
				if(data.ret!=1){
					global_obj.win_alert(data.msg);
				}else{
					window.location='./?m=mobile&a=list';
				}
			}, 'json');
		});
	},	
	ad_add_init:function (){//添加广告
		$('#ad_form select[name=AdType]').change(function(e){
			if($(this).val()==0){
				$('#pic_qty').css('display', 'block');
			}else{
				$('#pic_qty').css('display', 'none');
			}
        });
		
		$('#ad_form select[name=version]').change(function(e) {
			if($(this).val()==1){
				$('#pagetype').show(0);
			}else{
				$('#pagetype').hide(0);
			}
        });
		
	},
	ad_edit_init:function (){
		$('#ad_form').submit(function(){return false;});
		$('#ad_form input:submit').on('click', function(e){
			
			if(global_obj.check_form($('*[notnull]'))){return false;};
			$(this).attr('disabled', 'disabled');
			
			$.post('?t='+Math.random(), $('#ad_form').serializeArray(), function(data){
				if(data.ret!=1){
					global_obj.win_alert(data.msg);
				}else{
					window.location='./?m=mobile&a=ad';
				}
			}, 'json');
			
        });//click end
		
		$('#ad_form .del_flash').click(function(e){
			var $this=$(this);
			global_obj.win_alert(lang_obj.global.del_confirm, 'confirm', function(){
				var AId = $this.attr('data-AId');
				var S_FlashPath = $('#ad_form input[name="S_FlashPath"]');
				$.get('?', 'do_action=content.ad_del_flash&AId='+AId+'&S_FlashPath='+S_FlashPath.val(), function (data){
					if (data.ret==1){
						global_obj.win_alert(data.msg);
						S_FlashPath.val('');
						$('#cur_file').remove();
					}
				}, 'json');
			});
			return false;
		});
		//图片上传 开始
		$('.ad_drag').dragsort({
			dragSelector:'.adpic_row',
			dragSelectorExclude:'.ad_info, .multi_img_new',
			placeHolderTemplate:'<li class="placeHolder"></li>',
			scrollSpeed:5
		});
		
		$('.multi_img_new input.picpath').each(function(){//加载图片
			if($(this).attr('save')==1){
				$(this).parent().append(frame_obj.upload_img_detail($(this).val())).children('.upload_btn').hide();
			}
		});
		
		$('.multi_img_new').on('click', '.delete', function (){
			var $this=$(this);
			global_obj.win_alert(lang_obj.global.del_confirm, 'confirm', function(){
				var obj = $this.parent().siblings('.preview_pic');
				obj.find('a').remove();
				obj.children('.upload_btn').show();
				obj.children('.picpath').val('').attr('save', 0);
			});
			return false;
		});
		frame_obj.mouse_click($('.multi_img_new .upload_btn, .pic_btn .edit'), 'ad', function($this){ //产品颜色图点击事件
			var $id=$this.attr('id'),
				$lang=$this.attr('lang'),
				$num=$this.parents('.img').attr('num'),
				piccount=parseInt($this.attr('data-count'));
			frame_obj.photo_choice_init('PicDetail_'+$lang, '.picpath', 'PicDetail_'+$lang+' .img[num='+$num+']', 'ad', piccount, 'do_action=content.ad_img_del');
		});
		//图片上传 结束
	}	
}

