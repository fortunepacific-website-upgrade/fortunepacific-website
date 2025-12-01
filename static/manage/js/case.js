/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/
var case_obj={
	<!-- 全局 Start -->
	global_init:function(){
		//搜索栏
		$('#search_form').submit(function(){return false;});
		$('#search_form input:submit').click(function(){
			if(global_obj.check_form($('*[notnull]'))){return false;};
			$(this).attr('disabled', true);
			
			var $form=$('input[name=Type]');
			if($form.val()=='case'){
				window.location='./?m=case&a=case&'+$('#search_form').serialize();
			}
		});
		
		frame_obj.select_all($('#case .r_con_table input[name=select_all]'), $('#case .r_con_table input[name=select]'));//批量操作
		frame_obj.del_bat($('.case_nav .del_bat'), $('#case .r_con_table input[name=select]'), case_obj.del_bat_callback);
		
		frame_obj.part_init($('#case .list_box'));
		
		//删除事件
		$('#case').on('click', '.del', function(){
			var $this=$(this);
			if($('#global_win_alert').length) return false;
			global_obj.win_alert(lang_obj.global.del_confirm, 'confirm', function(){
				window.location=$this.attr('href');
			});
			return false;
		});
		
		//编辑页数据提交
		$('#case_form').submit(function(){return false;});
		$('#case_form input:submit').on('click', function(){
			if($('*[placeholder]').length){
				$('*[placeholder]').each(function(){
					if($(this).val()==$(this).attr('placeholder')) $(this).val('');
				});
			}
			if(global_obj.check_form($('#case_form').find('*[notnull]'))){return false;};
			$(this).attr('disabled', true);
			
			$.post('?', $('#case_form').serializeArray(), function(data){
				$('#case_form input:submit').attr('disabled', false);
				if(data.ret!=1){
					global_obj.win_alert(data.msg);
				}else{
					var $form=$('#case_form');
					if($form.attr('name')=='category_form'){
						global_obj.win_alert(data.msg.txt);
						setTimeout(function(){
							window.location='./?m=case&a=category';
						}, 1000);
					}else if($form.attr('name')=='case_form'){
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
			if($form.val()=='case'){
				window.location='./?do_action=case.case_del_bat&group_proid='+group_id_str;
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
	
	<!-- 案例分类管理 Start -->
	category_default_init:function(){
		case_obj.category_frame_init();
		case_obj.category_list_init();
		case_obj.category_edit_init();
	},
	
	category_list_init:function(){
		$('#category .page_menu ul').dragsort({
			dragSelector:'li',
			dragEnd:function(){
				var data=$(this).parent().children('li').map(function(){
					return $(this).attr('CateId');
				}).get();
				$.get('?m=case&a=category', {do_action:'case.case_category_order', sort_order:data.join('|')});
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
				$.get('?m=case&a=category', {do_action:'case.case_category_order', sort_order:data.join('|')});
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
				$.get('?m=case&a=category', {do_action:'case.case_category_order', sort_order:data.join('|')});
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
			frame_obj.photo_choice_init('PicUpload', 'form input[name=PicPath]', 'PicDetail', 'case_category', 1);
		});
		$('#PicDetail').html(frame_obj.upload_img_detail($('form input[name=PicPath]').val()));
		
		$('#case_form').on('click', '.open', function(){
			if($(this).hasClass('close')){
				$(this).removeClass('close').text(lang_obj.global.open);
				$('.seo_hide').slideUp(300);
			}else{
				$(this).addClass('close').text(lang_obj.global.pack_up);
				$('.seo_hide').slideDown(300);
			}
		});
	},
	<!-- 案例分类管理 End -->
	<!-- 案例显示设置 Start -->
	show_init:function(){
		$('#case_show .switchery').click(function(){
			var $this=$(this),
				$key=$this.attr('data')
				$checked_ary=new Object(),
				check=0;
			
			$('#case_show .switchery').each(function(){
				$checked_ary[$(this).attr('data')]=($key==$(this).attr('data')?($(this).hasClass('checked')?0:1):($(this).hasClass('checked')?1:0));
			});
			$checked=global_obj.json_decode_data($checked_ary);
			
			$.post('?', 'do_action=case.show_edit&Checked='+$checked, function(data){
				if(data.msg.ok==1){
					if($this.hasClass('checked')){
						$this.removeClass('checked');
					}else $this.addClass('checked');
				}else{
					global_obj.win_alert(lang_obj.global.set_error);
				}
			}, 'json');
		});
		
		$('#case_show').on('click', '.set', function(){
			var Title=$(this).parents('.box').find('.title').text();
			var Txt=$(this).parent().next('.txt').html();
			
			if(Txt){
				global_obj.div_mask();
				$('body').prepend('<div id="global_win_alert"><button class="close">X</button><h1>'+Title+'</h1><div class="list">'+Txt+'</div></div>');
				$('#global_win_alert').css({
					'position':'fixed',
					'left':$(window).width()/2-200,
					'top':'30%',
					'background':'#fff',
					'border':'1px solid #ccc',
					'opacity':0.95,
					'width':500,
					'z-index':100000,
					'border-radius':'8px',
					'padding':0
				}).children('.close').css({
					'float':'right',
					'padding':0,
					'line-height':'100%',
					'font-size':18,
					'margin-right':17,
					'opacity':0.2,
					'cursor':'pointer',
					'background':'none',
					'border':0,
					'font-weight':'bold',
					'color':'#000',
				}).siblings('h1').css({
					'margin':'10px 0 0 30px',
					'font-size':16,
					'font-weight':'bold',
				}).siblings('div.list').css({
					'width':440,
					'padding':'10px 10px 30px',
					'margin':'0 auto',
				}).children('div').css({
					'height':40,
					'line-height':'40px',
				}).children('.txt_name').css({
					'width':125,
					'display':'inline-block',
				});
				
				$('#global_win_alert').on('click', '.close', function(){
					$('#global_win_alert').remove();
					global_obj.div_mask(1);
				}).on('click', '.choice_btn', function(){
					var $this=$(this),
						$key=$this.attr('data'),
						$val=$this.attr('value'),
						$name=$this.parent().attr('name');
						$checked_ary=new Object;
					
					$this.parents('.list').find('span').each(function(){
						if($(this).hasClass('current')){
							$checked_ary[$(this).attr('data')]=$(this).attr('value');
						}
					});
					$checked_ary[$key]=$val;
					$checked=global_obj.json_decode_data($checked_ary);
					
					$.post('?', 'do_action=case.show_set_edit&Name='+$name+'&Checked='+$checked, function(data){
						if(data.msg.ok==1){
							$this.addClass('current').siblings().removeClass('current');
							$this.children('input').attr('checked', true);
						}else{
							global_obj.win_alert(lang_obj.global.set_error);
						}
					}, 'json');
				});
				
				$(document).keyup(function(event){//Esc、Space取消提示
					if(event.keyCode==27 || event.keyCode==8) {
						$('#global_win_alert .close').click();
					}
				});
			}
			
			return false;
		});
		
	},
	
	<!-- 案例管理 Start -->
	case_init:function(){
		//案例图片上传
		$('#PicUpload').on('click', function(){
			frame_obj.photo_choice_init('PicUpload', '', 'PicDetail', 'case', 3, 'm=case&a=case&do_action=case.case_img_del&Model=case');
		});
		$('#PicDetail div').on('click', 'span', function(){
			var $this=$(this);
			global_obj.win_alert(lang_obj.global.del_confirm, 'confirm', function(){
				$.ajax({
					url:'./?m=case&a=case&do_action=case.case_img_del&Model=case&Path='+$this.prev().attr('href')+'&Index='+$this.parent().index(),
					success:function(data){
						json=eval('('+data+')');
						$('#PicDetail div:eq('+json.msg[0]+')').remove();
					}
				});
			});
			return false;
		});
		
		$('#PicDetail').dragsort({
			dragSelector:'div',
			dragSelectorExclude:'',
			placeHolderTemplate:'<div class="placeHolder"></div>',
			scrollSpeed:5
		});
		
		$('#case_form .other_btns .choice_btn').click(function(){
			var $this=$(this);
			if($this.children('input').is(':checked')){
				$this.removeClass('current');
				$this.children('input').attr('checked', false);
			}else{
				$this.addClass('current');
				$this.children('input').attr('checked', true);
			}
		});
		
		$('#case_form').on('click', '.open', function(){
			if($(this).hasClass('close')){
				$(this).removeClass('close').text(lang_obj.global.open);
				$('.seo_hide').slideUp(300);
			}else{
				$(this).addClass('close').text(lang_obj.global.pack_up);
				$('.seo_hide').slideDown(300);
			}
		});
	}
	<!-- 案例管理 End -->
}