/*
// jQuery兼容性修复 - 仅针对特定问题
if (typeof jQuery !== "undefined" && !jQuery.fn.size) {
    jQuery.fn.size = function() {
        return this.length;
    };
}
Powered by ueeshop.com		http://www.ueeshop.com
广州联雅网络科技有限公司		020-83226791
*/

var frame_obj={
	page_init:function(){
		//页面加载
		var resize=function(){
			$(window).width()>=1280?$('body').addClass('w_1200'):$('body').removeClass('w_1200');
			$(window).width()>=1400?$('body').addClass('w_1400'):$('body').removeClass('w_1400');
			var $mainWidth=($(window).width()>=980?$(window).width():980),
				$mainHeight=$(window).height()-$('#header').outerHeight();
			$('#main').css({'width':$mainWidth, 'height':$mainHeight});
			$('#main .menu').width($('#main .menu_ico').width()+$('#main .menu_list').width()+$('#main .menu_button').width());
			$('#main .menu_list').height($mainHeight);
			$('#main .menu_list').jScrollPane();
			$('#main .menu_button i').css('marginTop', $('#main .menu_button a').height()/2-6);
			$('#main .righter').width($mainWidth-$('#main .menu').width());
			if($('#main .r_con_wrap').height()<$('#main .r_con_wrap').outerHeight()){
				$('#main .r_con_wrap').css({height:$mainHeight-$('.fixed_btn_submit').outerHeight(true)-5}); //40:r_con_wrap内间距
			}else{
				$('#main .r_con_wrap').css({height:$mainHeight-$('.fixed_btn_submit').outerHeight(true)});
			}
			$('#header').width($mainWidth);
			if($('#edit_form').length && $('#edit_form input.btn_submit').length && !$('#edit_form').hasClass('not_fixed')){ //提交按钮固定于底部
				$('#edit_form input.btn_submit').parents('.rows').addClass('fixed_btn_submit');
				$('#main .righter').append($('.fixed_btn_submit'));
				$('.fixed_btn_submit').css({width:$mainWidth-$('#main .menu').width(), left:$('#main .menu').width()});
				$('#main .r_con_wrap').css({height:$mainHeight-$('.fixed_btn_submit').outerHeight(true)-5});
			}
			if($('.fixed_btn_submit').length){
				$('.fixed_btn_submit').css({width:$mainWidth-$('#main .menu').width(), left:$('#main .menu').width()});
				$('#main .r_con_wrap').css({height:$mainHeight-$('.fixed_btn_submit').outerHeight(true)-5});
			}
			if($('#div_mask').length) $('#div_mask').css({height:$(document).height()}); //刷新遮罩层高度
			if($('#main .righter .fixed_loading').length) $('#main .righter .fixed_loading').css({width:$('#main .righter').width(), height:$('#main .righter').height()});
			//表格列表没有任何数据
			if($('.bg_no_table_data').length){
				var $insideTable=($('.inside_table').length?40:0), //40:内间距
					$content=$('.bg_no_table_data .content').outerHeight(true),
					$H=$('.r_con_wrap').outerHeight()-$('.inside_container').outerHeight(true)-$insideTable-$('.list_menu').outerHeight(),
					$half=($H-$content)/2;
				$('.bg_no_table_data').css('height', $H);
				$('.bg_no_table_data .content').css('top', ($half<0?0:$half));
			}
		}
		resize();
		$(window).resize(function(){resize();});

		//加载效果
		$(window).on("load", function(){
			$('#main .fixed_loading').fadeOut(500);
		});

		//左侧主栏目
		$('#main .menu').on('mouseenter', '.menu_ico .menu_item', function(){
			var $Index=$(this).index();
			if($(this).find('.icon_menu').hasClass('current')){ //当前管理栏目不用触发，如果有显示就隐藏起来
				$('#main .menu .menu_ico .icon_menu').removeClass('hover');
				$('#main .menu .menu_ico_name').removeClass('show');
				$('#main .menu .menu_ico_name .menu_item').removeClass('current');
				$('#main .menu .menu_list .jspPane').css('left', 0);
				return false;
			}
			if(!$('#main .menu .menu_ico_name').hasClass('show')){
				$('#main .menu .menu_ico_name').addClass('show');
				$('#main .menu .menu_list .jspPane').css('left', 60);
			}
			$(this).find('.icon_menu').addClass('hover');
			$(this).siblings().find('.icon_menu').removeClass('hover');
			$('#main .menu .menu_ico_name .menu_item').eq($Index).addClass('current').siblings().removeClass('current');
		}).on('mouseenter', '.menu_ico_name .menu_item', function(){
			var $Index=$(this).index();
			$(this).addClass('current').siblings().removeClass('current');
			$('#main .menu .menu_ico .menu_item').eq($Index).find('.icon_menu').addClass('hover');
			$('#main .menu .menu_ico .menu_item').eq($Index).siblings().find('.icon_menu').removeClass('hover');
		}).on('mouseleave', '.menu_ico_name', function(){
			$('#main .menu .menu_ico .icon_menu').removeClass('hover');
			$('#main .menu .menu_ico_name').removeClass('show');
			$('#main .menu .menu_ico_name .menu_item').removeClass('current');
			$('#main .menu .menu_list .jspPane').css('left', 0);
		});
		
		//左侧子栏目
		$('#main .menu dt').on('click', function(){
			var $this=$(this);
			$this.addClass('cur').siblings().removeClass('cur');
			if($this.next('dd').length){
				if($this.next('dd').is(':hidden')){
					$('#main .menu dt div').html('-');
					$this.next().filter('dd').slideDown(function(){
						$this.addClass('cur');
						$('#main .menu_list').jScrollPane();
					});
				}else{
					$this.children('div').html('+');
					$this.next().filter('dd').slideUp(function(){
						$this.removeClass('cur');
						$('#main .menu_list').jScrollPane();
					});
				}
			}
		});

		//左侧子栏目显藏按钮
		$('#main .menu_button a').on('click', function(){
			$(this).blur();
			if($('#main .menu_list').attr('status')=='off'){
				$(this).children('i').removeClass('show');
				$('#main .menu_list').attr('status', 'on').stop(true, false).animate({'width':130}, 200, function(){
					$('#main .menu_list').jScrollPane();
				});
				$('#main .menu').width($('#main .menu_ico').width()+$('#main .menu_button').width()+130);
				$('#main .righter').width($('#main').width()-$('#main .menu').width());
				$('#main .r_con_wrap').css({width:$(window).width()-$('#main .menu').width()});
				$('#edit_form .fixed_btn_submit').css({width:$('#main').width()-$('#main .menu').width(), left:$('#main .menu').width()});
			}else{
				$(this).children('i').addClass('show');
				$('#main .menu_list').attr('status', 'off').stop(true, false).animate({'width':0}, 200, function(){
					$('#main .menu').width($('#main .menu_ico').width()+$('#main .menu_button').width());
					$('#main .righter').width($('#main').width()-$('#main .menu').width());
					$('#main .r_con_wrap').css({width:$(window).width()-$('#main .menu').width()});
					$('#edit_form .fixed_btn_submit').css({width:$('#main').width()-$('#main .menu').width()-20, left:$('#main .menu').width()});
				});
			}
		});

		//弹出提示
		$('.tool_tips_ico').each(function(){
			var content_w;
			if($(this).attr('content')==''){
				$(this).hide();
				return;
			}else{
				$(this).html(' ');
				content_w = $(this).attr("content-width")?$(this).attr("content-width"):260;
				$('#main .r_con_wrap').tool_tips($(this), {position:'horizontal', html:$(this).attr('content'), width:content_w});
			}
		});
		/*
		$('*[placeholder]').each(function(){
			if(!$(this).val()){
				$(this).val($(this).attr('placeholder')).css('color', '#bbb');
			}
		}).focus(function(){
			if($(this).val()==$(this).attr('placeholder')){
            	$(this).val('').css('color', '#333');
			}
		}).blur(function(){
			if(!$(this).val()){
				$(this).val($(this).attr('placeholder')).css('color', '#bbb');
			}
		});
		*/
		$('.tip_ico').hover(function(){
			$(this).append('<span class="tip_ico_txt'+($(this).hasClass('tip_min_ico')?' tip_min_ico_txt':'')+' fadeInUp animate">'+$(this).attr('label')+'<em></em></span>');
		}, function(){
			$(this).removeAttr('style').children('span').remove();
		});
		$('.tip_ico_down').hover(function(){
			$(this).append('<span class="tip_ico_txt_down'+($(this).hasClass('tip_min_ico')?' tip_min_ico_txt_down':'')+' fadeInDown animate">'+$(this).attr('label')+'<em></em></span>');
		}, function(){
			$(this).removeAttr('style').children('span').remove();
		});

		//选项卡效果
		$('body').on('click', '.tab_box .tab_box_btn', function(){
			var $this = $(this),
				$lang = $this.attr('data-lang'),
				$obj = $this.parents('.rows');
			if($(".lang_list").length){	//execute in product edit page
				$obj.find('.tab_box_btn').each(function(){
					var tab_box_btn = $(this);
					$(".lang_list .checked").each(function(){
						if(tab_box_btn.attr("data-lang")==$(this).find("input").attr("lang")){
							tab_box_btn.show();
						}
					});
				});
			}else{
				$obj.find('.tab_box_btn').show();
			}
			$this.hide();
			$obj.find('dt span').text($this.find('span').text());
			$obj.find('.tab_txt').hide();
			$obj.find('.tab_txt_'+$lang).show();
		});
		//$('.input .tab_txt').eq(0).show();
		//勾选按钮
		$('.btn_checkbox, .btn_choice').on('click', function(){
			var $this=$(this),
				$obj=$(this).find('input');
			if($this.hasClass('disabled')) return false; //禁止调用
			if($obj.is(':checked')){ //已勾选
				$obj.removeAttr('checked');
				$this.removeClass('current');
			}else{ //未勾选
				$obj.attr('checked', true);
				$this.addClass('current');
			}
		});

		//属性勾选按钮
		$('.btn_attr_choice').on('click', function(){
			var $this=$(this),
				$obj=$(this).find('input');
			if($this.hasClass('disabled')) return false; //禁止调用
			if($obj.is(':checked')){ //已勾选
				$obj.removeAttr('checked');
				$this.removeClass('current');
			}else{ //未勾选
				$obj.attr('checked', true);
				$this.addClass('current');
			}
		});

		$('body').on('click', '.input_radio_box', function(){
			//单选按钮
			var name=$(this).find('input').attr('name');
			$('input[name='+name+']').removeAttr('checked').parent().parent().removeClass('checked');
			$(this).addClass('checked').find('input').attr('checked', true);
		}).on('click', '.input_checkbox_box:not(".disabled")', function(e){
			//多选按钮
			var $obj=$(this);
			if($obj.hasClass('checked')){
				$obj.find('input').removeAttr('checked');
				$obj.removeClass('checked');
			}else{
				$obj.find('input').attr('checked', true);
				$obj.addClass('checked');
			}
		});

		//表头效果
		if($('.list_menu').length){
			$('.r_con_wrap').scroll(function(){
				frame_obj.fixed_list_menu();
			});
			$(document).ready(function(){
				frame_obj.fixed_list_menu();
			});
		}

		//搜索框
		if($('.list_menu .search_form .ext>div').length){
			$('.list_menu .search_form .more').click(function(){
				if($('.list_menu .search_form .ext').is(':hidden')){
					$('.list_menu .search_form .ext').show();
					$('.list_menu .search_form form').css('border-radius', '5px 5px 0 0');
					$('.list_menu .search_form .more').addClass('more_up');
				}else{
					$('.list_menu .search_form .ext').hide();
					$('.list_menu .search_form form').css('border-radius', '5px');
					$('.list_menu .search_form .more').removeClass('more_up');
				}
			});
		}else{
			$('.list_menu .search_form .more').remove();
			$('.list_menu .search_form .form_input').addClass('long_form_input');
		}

		//表格更多下拉效果
		$('.inside_table .more').parent().hover(function(){
			$(this).find('.more_menu').show().stop(true).animate({'top':31, 'opacity':1}, 250);
		}, function(){
			$(this).find('.more_menu').show().stop(true).animate({'top':21, 'opacity':0}, 250, function(){ $(this).hide(); });
		});
		$('.r_con_table .operation dl').hover(function(){
			$(this).find('dd').show().stop(true).animate({'top':20, 'opacity':1}, 250);
		}, function(){
			$(this).find('dd').show().stop(true).animate({'top':10, 'opacity':0}, 250, function(){ $(this).hide(); });
		});

		//自定义下拉
		$('body').on('click', '.down_select_box dt', function(){
			$(this).addClass('box_drop_focus');
			$(this).next('dd').toggle();
			return false;
		}).on('click', '.down_select_box .select', function(){
			var value=$(this).attr('value');
			$(this).parents('dd').hide();
			if($(this).parents('.down_select_box').hasClass('edit_box')){
				$(this).parents('.down_select_box').find('dt input[type=text]').val($(this).text()).parent().find('input[type=hidden]').val(value);
			}else{
				$(this).parents('.down_select_box').find('dt>div>span').text($(this).text()).parent().find('input[type=hidden]').val(value);
			}
			return false;
		}).on('click', '.down_select_box .select i', function(){
			$(this).parent().remove();
			return false;
		}).on('click', '.down_select_box', function(){
			return false;
		});
		$(document).click(function(){
			$('.down_select_box dt').removeClass('box_drop_focus');
			$('.down_select_box dd').hide();
		});
		$('.down_select_box .select[selected]').each(function(){
			$(this).click();
		});

		//后台账号信息下拉
		$('#header .user_info').hover(function(){
			$(this).find('dd').show().stop(true).animate({'top':40, 'opacity':1}, 250);
		}, function(){
			$(this).find('dd').stop(true).animate({'top':30, 'opacity':0}, 250, function(){ $(this).hide(); });
		});

		//图片默认设置
		frame_obj.upload_img_init();
		frame_obj.upload_pro_img_init(1);

		frame_obj.rows_input();
	},
	
	translation_init:function(){	//翻译
		var translation_get_chars=function(){
			$.get('./?do_action=action.translation_get_chars', function(data){
				data.ret==1 && $('#translation .t span').show().html('('+data.msg+')');
			}, 'json');
		}
		$('.btn_translation').click(function(e) {
			if(typeof(CKEDITOR)=='object'){
				for(var i in CKEDITOR.instances) CKEDITOR.instances[i].updateElement();//更新编辑器内容
			}
			var o=$('#translation');
			frame_obj.pop_form(o);
			o.find('.r_con_table').css({margin:0, border:'none'});
			o.find('.t span').hide();
			o.find('.btn_submit').show();
			o.find('.btn_cancel').val(lang_obj.global.close).removeAttr('style');
			var language_html='';
			$('.tab_box_row .drop_down:first a').each(function(index, element) {
				if(index==0){return;}
				language_html+='<td nowrap="nowrap"><span class="input_checkbox_box"><span class="input_checkbox"><input type="checkbox" name="" value="'+$(this).attr('data-lang')+'"></span></span></td>';
			});
			o.find('.r_con_table tbody').html('');
			$('.rows.translation:visible').each(function(index, element) {
				var title=$(this).find('label').contents().filter(function (index, content) {
					return content.nodeType===3;
				}).text();
				var text=$(this).find('.tab_txt:first input, .tab_txt:first textarea').val();
				o.find('.r_con_table tbody').append('<tr><td>'+title+' <font class="fc_0">('+text.length+lang_obj.manage.translation.char+')</font></td>'+language_html+'</tr>');
				$(this).attr('translation', 1);
				if(text==''){
					o.find('.r_con_table tbody tr:last .input_checkbox_box').addClass('disabled no_checked');
					$(this).attr('translation', 0);	//不能进行翻译
				}else{
					$(this).find('.tab_txt').not(':first').each(function() {
						var translation_over=$(this).attr('translation_over');
						if(translation_over!=1){
							var input=o.find('.r_con_table tbody tr:last .input_checkbox_box input[value='+$(this).attr('lang')+']');
							input.attr('checked', true).parents('.input_checkbox_box').addClass('checked');
						}
					});
				}
			});
			translation_get_chars();
		});
		$('#translation form').submit(function(){return false;});
		$('#translation .btn_submit').click(function(e) {
			if($('.rows.translation[translation=1]').length==0 || $('#translation .r_con_table tbody tr input:checked').length==0){return;}	//没有内容可进行翻译
			var query_string='';
			$('.rows.translation:visible').each(function(index, element) {
				var input_obj=$('#translation .r_con_table tbody tr:eq('+index+') input:checked');
				if($(this).attr('translation')!=1 || input_obj.length==0){return;}
				var language='';
				input_obj.each(function(index, element) {
					language+=$(this).val()+',';
				});
				var text=$(this).find('.tab_txt:first input, .tab_txt:first textarea').val();
				query_string+='&text['+index+']='+encodeURIComponent(text)+'&language['+index+']='+language;
			});
			$(this).attr('disabled', true);
			global_obj.win_alert_auto_close(lang_obj.manage.translation.in_translation, 'loading', -1, 0, 0);
			$.post('./', 'do_action=action.translation&'+query_string, function(data){
				if(data.ret==1){
					$.each(data.msg, function(index, value) {
						$.each(value['msg'], function(i, n){
							var o=$('.rows.translation:visible').eq(i).find('.input .tab_txt[lang='+index+']').attr('translation_over', data.msg[index]['ret']).find('input, textarea');
							o.val(n);
							$('#cke_'+o.attr('id')).length && CKEDITOR.instances[o.attr('id')].setData(n);//更新编辑器内容
						});
					});
					var completed=1;
					$('#translation .r_con_table tbody input:checked').each(function(index, element) {
						var o=$(this).parents('td');
						if(data.msg[$(this).val()]['ret']==1){
							o.html(lang_obj.manage.translation.translation_success);
						}else{
							completed=0;
							o.html(o.find('.input_checkbox_box').prop('outerHTML')+lang_obj.manage.translation.translation_fail);
						}
					});
					if(completed){
						$('#translation .btn_submit').hide();
						$('#translation .btn_cancel').val(lang_obj.manage.translation.translation_success).css({
							backgroundColor:'#ff6600',
							color:'#fff',
							border:'1px solid #ff6600'
						});
					}
					translation_get_chars();
					global_obj.win_alert_auto_close('', 'loading', 500, '', 0);
				}
				$('#translation .btn_submit').attr('disabled', false);
			}, 'json');
		});
	},

	seo_include_init:function(){
		frame_obj.seo_output_module_msg();

		var title_colum = $(".title_colum").val();
		var default_lang = $(".seo_container").attr("default-lang");
		default_lang = default_lang ? "_" + default_lang:"";

		/*用隐藏域输出分类的名称*/
		$(".rows select[name='CateId']").change(function(){
			frame_obj.seo_output_module_msg();
		});

		/* SEO展示区域*/
		$("input[name='SeoTitle" + default_lang + "']").on('keydown keyup blur',function(){
			$(".seo_show_area .title input").val($(this).val());
		});
		$("input[name='PageUrl']").on('keydown keyup blur',function(){
			$(".seo_show_area .link input[type='text']").val($(".link .server_name").val() + $(this).val() + ".html");
		});
		$("textarea[name='SeoDescription" + default_lang + "']").on('keydown keyup blur',function(){
			$(".seo_show_area .brief textarea").html($(this).val());
		});

		/*弹出SEO标题选词框*/
		$('.title_build').on('click', function(){
			var default_title_val = $(".seo_search_form .form_input").val()?$(".seo_search_form .form_input").val():$("input[name='" + title_colum + default_lang + "']").val();
			frame_obj.seo_title_select_ajax(default_title_val);
			frame_obj.pop_form($("#seo_title_build"));
		});

		/*SEO标题选词搜索*/
		$('.seo_search_form .search_btn').click(function(){
			var Keyword = $(".seo_search_form input[name='Keyword']").val();
			frame_obj.seo_title_select_ajax(Keyword,1);
		});
		
		/*SEO标题选词*/
		var checkbox_fun=function(o){
			if(o.hasClass('checked')){
				o.find('input').removeAttr('checked');
				o.removeClass('checked');
			}else{
				o.find('input').attr('checked', true);
				o.addClass('checked');
			}
		};
		//$('body').off('click', '.input_checkbox_box:not(".disabled")');
		var checked_length = $("#seo_title_build .input_checkbox_box.checked").length;
		$(document).on('click', '#seo_title_build .input_checkbox_box', function(){
			checkbox_fun($(this));
			var $obj=$(this),
				checked_length = $("#seo_title_build .input_checkbox_box.checked").length;
			if(!$obj.hasClass('checked') && checked_length > 4){
				global_obj.win_alert_auto_close(lang_obj.manage.global.word_select_limit,'fail', 1000, '8%',0);
			}else{
				if($obj.hasClass('checked')){
					$obj.find('input').removeAttr('checked');
					$obj.removeClass('checked');
				}else{
					$obj.find('input').attr('checked', true);
					$obj.addClass('checked');
				}
			}
		});

		/*标题选词提交*/
		$("#seo_title_build .btn_submit").click(function(){
			var title_text = "";
			checked_length = $("#seo_title_build .input_checkbox_box.checked").length;
			if(checked_length){
				$("#seo_title_build .input_checkbox input:checked").each(function(){
					title_text += $(this).parents("tr").find("td").first().html();
					if( $(this).parents(".input_checkbox_box").index("#seo_title_build .input_checkbox_box.checked")+1 != checked_length ){
						title_text += ",";
					}
				});
				$(".seo_title input:visible").val(title_text);
				if($(".seo_title input[name='SeoTitle" + default_lang + "']").is(":visible")){
					$(".seo_show_area .title input").val(title_text);
				}
			}
			frame_obj.pop_form($("#seo_title_build"),1);
			$(".seo_tkd_build .input_checkbox_box").removeClass('checked');
			$(".seo_tkd_build .input_checkbox_box .input_checkbox input").attr('checked', false);
		});

		/*生成关键词*/
		$(".keyword_build").on('click', function(){
			$(".seo_keyword input").each(function(){
				this_lang = $(this).parent().attr("lang");
				var val = $("input[name='" + title_colum + "_" + this_lang + "']").val();
				if("_"+this_lang==default_lang && !val){
					global_obj.win_alert_auto_close(lang_obj.manage.global.name_require, 'fail', 1000, '8%');
					return false;
				}else{
					if($(".seo_category_" + this_lang).val()){
						val += ",";
						val += $(".seo_category_" + this_lang).val();
					}
					$(this).val(val);
				}
			});
		});

		/*弹出简述选择框*/
		$(".desc_build").click(function(){
			if($(".seo_title input[name='SeoTitle" + default_lang + "']").val()){
				frame_obj.seo_description_select_ajax();
				frame_obj.pop_form($("#seo_description_build"));
			}else{
				global_obj.win_alert_auto_close(lang_obj.manage.global.seo_title_require,'fail', 1000, '8%',0);
				return false;
			}
		});

		/*选择描述*/
		$(document).on('click', '#seo_description_build .select', function(){
			var DId = $(this).attr('data-did'),
				par = 'do_action=action.seo_description_check&DId=' + DId;
			$.post('./', par, function(data){
				$(".seo_description textarea").each(function(index){
					var lang = $(this).parents(".tab_txt").attr("lang"),
						s_title = $("input[name='SeoTitle_" + lang + "']").val(),
						title_arr = s_title.split(",",2),
						result_text = data.msg[index];
					if(s_title){
						for(var i=0;i<2;i++){
							if(!title_arr[1]) { title_arr[1]=title_arr[0]; }
							result_text = result_text.replace(/\[(.+?)\]/, title_arr[i]);
						}
					}else{
						result_text = result_text.replace(/\[(.+?)\]/g, '');
					}
					$(this).html(result_text);
					if(default_lang.replace(/_/, '')==lang) $(".seo_show_area .brief textarea").html(result_text);
				});
				frame_obj.pop_form($("#seo_description_build"),1);
			},'json');
		});
	},

	seo_output_module_msg:function(){
		var msg_obj = $('.seo_output_module_msg'),
			CateId = $("select[name='CateId']").val(),
			data_m = msg_obj.attr("data-m"),
			data_a = msg_obj.attr("data-a"),
			data_d = msg_obj.attr("data-d"),
			par = 'do_action=action.seo_output_module_category&CateId='+CateId + '&m='+data_m + '&a='+data_a + '&d='+data_d;
		if(CateId){
			$.post('./', par, function(data){
				if(data.msg['result']){
					msg_obj.html(data.msg['result']);
				}
			}, 'json');
		}else{
			msg_obj.html("");
		}
	},

	seo_title_select_ajax:function(keyword,IsSearch){	//ajax查询seo标题选词
		$('#seo_title_build tbody').html('');
		$('#seo_title_build .no_data').show();
		global_obj.win_alert_auto_close(lang_obj.global.loading, 'loading', -1,'',0);
		var par = 'do_action=action.seo_get_title&title=' + keyword;
		$.post('./', par, function(data){
			var $Html=''
				msg_string = JSON.stringify(data.msg);
			//console.log();
			if(msg_string !== '[]'){
				$.each(data.msg, function(key, value){
					$Html+='<tr data-key="'+key+'">\
						<td nowrap="nowrap">'+value[0]+'</td>\
						<td nowrap="nowrap">'+value[1]+'</td>\
						<td nowrap="nowrap"><span class="strength" style="width:'+(value[2]*100).toFixed(2)+'%;"></span></td>\
						<td nowrap="nowrap" class="center"><div class="input_checkbox_box"><div class="input_checkbox"><input type="checkbox" name="" class="custom_list" value="" /></div>'+lang_obj.manage.global.select+'</div></td>\
					</tr>';
				});
			}else{
				IsSearch?global_obj.win_alert(lang_obj.manage.global.search_fail,'','',1):'';
			}
			$Html==''?$('#seo_title_build .no_data').show():$('#seo_title_build .no_data').hide();
			$('#seo_title_build tbody').html($Html);
			global_obj.win_alert_auto_close('', 'loading', 500, '', 0);
		}, 'json');
	},

	seo_description_select_ajax:function(){	//ajax查询seo描述
		global_obj.win_alert_auto_close(lang_obj.global.loading, 'loading', -1,'',0);
		var par = 'do_action=action.seo_get_description';
		$.post('./', par, function(data){
			var $Html='';
			if(data.msg){
				$.each(data.msg, function(key, value){
					$Html+='<tr data-key="'+key+'">\
						<td>'+value[0]+'</td>\
						<td nowrap="nowrap" class="center"><a class="select" data-did="'+value[1]+'" href="javascript:;">'+lang_obj.manage.global.select+'</a></td>\
					</tr>';
				});
			}
			$Html==''?$('#seo_description_build .no_data').show():$('#seo_description_build .no_data').hide();
			$('#seo_description_build tbody').html($Html);
		}, 'json');
		global_obj.win_alert_auto_close('', 'loading', 500, '', 0);
	},


	rows_input:function(){ //计算多语言表单长度
		$('.global_form .rows .input:visible').has('.lang_input').each(function(){
			var o=$(this);
			var input_width=Math.max(o.find('input').outerWidth(), o.find('textarea').outerWidth());
			var title_width=last_width=0;
			o.find('.lang_input b[class!=last]').each(function(){
				var w=$(this).outerWidth();
				w>title_width && (title_width=w);
			});
			title_width+=1;
			o.find('.lang_input b.last').each(function(){
				var w=$(this).outerWidth();
				w>last_width && (last_width=w);
			});
			last_width+=1;
			o.find('.lang_input').width(input_width+title_width+last_width);
			o.find('.lang_input b[class!=last]').width(title_width-(title_width?19:0));
			o.find('.lang_input b.last').width(last_width-(last_width?19:0));
			o.find('.lang_input input, .lang_input textarea').width(o.find('.lang_input').outerWidth()-o.find('.lang_input b[class!=last]').outerWidth()-o.find('.lang_input b.last').outerWidth()-24);
		});
	},

	submit_form_init:function(o, jump, fun, debug, callback, is_pop){
		if(!o.length) return false;
		if(o.height()>$('#main .r_con_wrap').height()){
			var html='', part=0, num=1;
			o.find('.rows_hd_part:visible').each(function(){
				if(num<10) num='0'+num;
				$(this).before('<a name="part_'+part+'"></a>');
				html+='<li><a href="#part_'+part+'"'+(part==0 ? 'class="current"' : '')+'>'+$(this).find('span').html()+' <b>'+num+'</b></a></li>';
				part++;
				num++;
			});
			if(html){
				$('.left_container').append('<ul class="edit_form_part">'+html+'</ul>');
				$('.edit_form_part a').click(function(){
					$('.edit_form_part a').removeClass('current');
					$(this).addClass('current');
				});
				$(window).resize(function(){
					var left = $('.left_container').offset().left+$('.left_container').width();
					$('.edit_form_part').css('left',left+'px');
				}).resize();
			}
		}
		o.find('input[rel=amount]').keydown(function(e){
			var value	= $(this).val(),
				key		= (window.event?e.keyCode:e.which),
				ctrl	= (e.ctrlKey || e.metaKey);
			if((key>95 && key<106) || (key>47 && key<60) || (key==110 && value.indexOf('.')<0) || (key==190 && value.indexOf('.')<0)){ //[0~9][.]
			}else if((ctrl && key==67) || (ctrl && key==86) || (ctrl && key==65)){ //Ctrl+C Ctrl+V Ctrl+A
			}else if(key!=8){ //删除键
				if(window.event){//IE
					e.returnValue=false;
				}else{//Firefox
					e.preventDefault();
				}
				return false;
			}
		});
		o.find('input[rel=digital]').keydown(function(e){
			var value=$(this).val(),
				key=window.event?e.keyCode:e.which;
			if((key>95 && key<106) || (key>47 && key<60)){
				value==0 && $(this).val('');
			}else if(key!=8){
				if(window.event){//IE
					e.returnValue=false;
				}else{//Firefox
					e.preventDefault();
				}
				return false;
			}
		});
		if(o.find('input.btn_submit').length){ //表单自身是否包含了提交按钮
			var obj=o.find('input.btn_submit');
		}else{ //提交按钮在定位栏显示
			var obj=$('.fixed_btn_submit input.btn_submit');
		}
		o.submit(function(){return false;});
		obj.click(function(){
			if($.isFunction(fun) && fun()===false){ return false;};
			if(global_obj.check_form(o.find('*[notnull]'), o.find('*[format]'), 1)){
				o.find('*[notnull]').each(function(){
					if($.trim($(this).val())==''){
						if($(this).is(':hidden')){
							$('.r_con_wrap').animate({scrollTop:$(this).parents('.rows').position().top}, 500);
						}else{
							$('.r_con_wrap').animate({scrollTop:$(this).position().top}, 500);
						}
						return false;
					}
				});
				return false;
			};
			if(typeof(CKEDITOR)=='object'){
				for(var i in CKEDITOR.instances) CKEDITOR.instances[i].updateElement();//更新编辑器内容
			}
			$(this).attr('disabled', true);
			$.post('?', o.serialize(), function(data){
				if($.isFunction(callback)){
					callback(data);
					obj.attr('disabled', false);
				}else{
					if(debug){
						obj.attr('disabled', false);
						alert(unescape(data.replace(/\\/g, '%')));
					}else if(data.ret==1){
						if(data.msg.jump){
							window.location=data.msg.jump;
						}else if(data.msg){
							//global_obj.win_alert(data.msg, '', 'alert', is_pop);
							obj.attr('disabled', false);
							global_obj.win_alert_auto_close(data.msg, '', 1000, '8%',is_pop);
						}else if(jump){
							window.location=jump;
						}else{
							window.location.reload();
						}
					}else{
						obj.attr('disabled', false);
						//global_obj.win_alert(data.msg, '', 'alert', is_pop);
						global_obj.win_alert_auto_close(data.msg, 'fail', 1000, '8%',is_pop);
					}
				}
			}, debug?'text':'json');
		});
	},

	switchery_checkbox:function(confirmBind, cancelBind){
		$('.switchery').on('click', function(){
			if($(this).hasClass('checked')){
				$(this).removeClass('checked').find('input').attr('checked', false);
				cancelBind && cancelBind($(this));
			}else{
				$(this).addClass('checked').find('input').attr('checked', true);
				confirmBind && confirmBind($(this));
			}
		});
	},

	select_all:function(checkbox_select_btn, checkbox_list, process_obj, callback){
		var process=function(){
			if(checkbox_list.parent('.current').length>0){
				process_obj.css('display', 'block');
			}else{
				process_obj.css('display', 'none');
			}
		}
		checkbox_select_btn.parent().on('click', function(){ //全选
			var $isChecked=checkbox_select_btn.is(':checked')?1:0;
			checkbox_list.each(function(){
				if($isChecked==1){ //勾选
					$(this).attr('checked', true);
					$(this).parent().addClass('current');
				}else{ //取消
					$(this).removeAttr('checked');
					$(this).parent().removeClass('current');
				}
            });
			if($.isFunction(callback)){
				callback(checkbox_select_btn, checkbox_list);
			}else{
				process();
			}
		});
		checkbox_list.parent().on('click', function(){ //部分勾选
			if(checkbox_list.parent('.current').length==checkbox_list.parent().length){
				checkbox_select_btn.attr('checked', true);
				checkbox_select_btn.parent().addClass('current');
			}else{
				checkbox_select_btn.removeAttr('checked');
				checkbox_select_btn.parent().removeClass('current');
			};
			if($.isFunction(callback)){
				callback(checkbox_select_btn, checkbox_list);
			}else{
				process();
			}
		});
	},

	del_bat:function(btn_del_bat, checkbox_list, do_action, callback, alert_txt){
		btn_del_bat.on('click', function(){
			var id_list='';
			checkbox_list.each(function(index, element) {
				id_list+=$(element).get(0).checked?$(element).val()+',':'';
            });
			if(id_list){
				id_list=id_list.substring(0,id_list.length-1);
				if($.isFunction(callback)){
					callback(id_list);
				}else{
					global_obj.win_alert(lang_obj.global.del_confirm, function(){
						$.get('?', {do_action:do_action, id:id_list}, function(data){
							if(data.ret==1){
								window.location.reload();
							}
						}, 'json');
					}, 'confirm');
				}
			}else{
				global_obj.win_alert(alert_txt?alert_txt:lang_obj.global.del_dat_select);
			}
		});
	},

	del_init:function(o){
		o.find('.del').click(function(){
			var o=$(this);
			global_obj.win_alert(lang_obj.global.del_confirm, function(){
				$.get(o.attr('href'), function(data){
					if(data.ret==1){
						window.location.reload();
					}else{
						global_obj.win_alert(data.msg);
					}
				}, 'json');
			}, 'confirm');
			return false;
		});
	},

	dragsort:function(obj, do_action, dragSelector, dragSelectorExclude, placeHolderTemplate, itemSelector){
		typeof(dragSelector)=='undefined' && (dragSelector='tr');
		typeof(dragSelectorExclude)=='undefined' && (dragSelectorExclude='a, td[data!=move_myorder]');
		typeof(placeHolderTemplate)=='undefined' && (placeHolderTemplate='<tr class="placeHolder"></tr>');
		typeof(itemSelector)=='undefined' && (itemSelector='');
		obj.dragsort({
			dragSelector:dragSelector,
			dragSelectorExclude:dragSelectorExclude,
			placeHolderTemplate:placeHolderTemplate,
			itemSelector:itemSelector,
			scrollSpeed:5,
			dragEnd:function(){
				if(do_action){
					var target=(itemSelector?itemSelector:dragSelector);
					var data=obj.find(target).map(function(){
						return $(this).attr('id');
					}).get();
					$.get('?', {do_action:do_action, sort_order:data.join(',')});
				}
			}
		});
	},

	fixed_list_menu:function(){
		var $ScrollTop=$('.r_con_wrap').scrollTop(),
			$SideObj=$('.list_menu'),
			$SideTop=$SideObj.offset().top,
			$SideHeight=$SideObj.outerHeight();
			$Obj=$('.list_menu'),
			$BoxWidth=$Obj.width(),
			$BoxHeight=$Obj.outerHeight(true),
			$BoxTop=$('#header').outerHeight(),
			$BoxLeft=$Obj.parent().offset().left,
			$HeaderHeight=$('#header').outerHeight();
			if($Obj.hasClass('no_fixed')) return false;
		if($ScrollTop>($SideTop+$BoxHeight)){
			$Obj.css({'width':$BoxWidth, 'position':'fixed', 'top':$BoxTop, 'left':$BoxLeft});
			$Obj.addClass('fixed');
			$('.inside_table').css({'padding-top':$SideHeight});
		}else{
			$Obj.removeAttr('style');
			$Obj.removeClass('fixed');
			$('.inside_table').removeAttr('style');
		}
	},
	
	fixed_right:function(click_obj, target_class){
		var fun=(typeof(arguments[2])=='undefined')?'':arguments[2];
		click_obj.on('click', function(){
			$('#fixed_right').addClass('show').find(target_class).show().siblings().hide();
			frame_obj.fixed_right_div_mask();
			if($.isFunction(fun)){ fun($(this)); }
		});
		$('#fixed_right').off().on('click', '.close, .btn_cancel', function(){
			$('#fixed_right').removeClass('show').find('.global_container').hide();
			frame_obj.fixed_right_div_mask(1);
		});
		$('body').on('click', '#fixed_right_div_mask', function(){
			$('#fixed_right').removeClass('show').find('.global_container').hide();
			frame_obj.fixed_right_div_mask(1);
		});
	},
	
	fixed_right_div_mask:function(remove){
		if(remove==1){
			$('#fixed_right_div_mask').remove();
		}else{
			if(!$('#fixed_right_div_mask').length){
				$('body').prepend('<div id="fixed_right_div_mask"></div>');
				$('#fixed_right_div_mask').show();
			}
		}
	},
	
	pop_form:function(o, remove, not_div_mask){ //弹出编辑框
		if(remove==1){
			o.slideUp(250, function(){
				(!not_div_mask || not_div_mask==0) && global_obj.div_mask(1);
			});
		}else{
			global_obj.div_mask();
			o.slideDown(250);
			if($(document).height()<=680){
				o.css('top', 70);
				o.find('.r_con_form').css({'max-height':350});
			}
			o.find('.t h2').add(o.find('.btn_cancel')).click(function(){
				o.slideUp(250, function(){
					(!not_div_mask || not_div_mask==0) && global_obj.div_mask(1);
				});
			});
		}
	},

	pop_iframe:function(url, title, callback){ //弹出框架显示框
		var $html='';
		$html+='<div class="pop_form pop_iframe">';
			$html+='<form id="pop_iframe_form" class="w_1000">';
				$html+='<div class="t"><h1>'+title+'</h1><h2>×</h2></div>';
				$html+='<div class="r_con_form"><iframe src="" frameborder="0"></iframe></div>';
			$html+='</form>';
		$html+='</div>';
		$('.r_con_wrap').append($html);
		var o=$('.pop_iframe');
		frame_obj.pop_form(o, 0, callback);
		setTimeout(function(){
			o.find('iframe').attr('src', url+'&iframe=1&r='+Math.random()).on("load", function(){ //效果执行完，才加载内容显示
				iframe_resize();
			});
		}, 200);

		var resize=function(){
			var $h=$(window).height()-o.find('form>.t').outerHeight()-70;
			o.css('top', 30).find('.r_con_form').css({'height':$h, 'max-height':$h});
		}, iframe_resize=function(){
			var $h=$(window).height()-o.find('form>.t').outerHeight()-70,
				$iframe=o.find('iframe').contents();
				$iframe.find('.r_con_wrap').css({'overflow':'auto', 'height':($h-10)});
				$iframe.find('.menu_list').height($iframe.find('.r_con_wrap').height()-$iframe.find('.nav_list').outerHeight(true)-10).jScrollPane();
				$iframe.find('.shipping_area_edit').height($iframe.find('.r_con_wrap').height()-$iframe.find('.nav_list').outerHeight(true)-8);
		}
		resize();
		$(window).resize(function(){
			resize();
			if(o.find('.r_con_form').outerHeight()>300){ //已经固定min-height为300px
				iframe_resize();
			}
		});

		o.find('.t h2').add(o.find('.btn_cancel')).click(function(){ //取消
			frame_obj.pop_form(o, 1, callback);
			o.remove();
		});
	},

	upload_img_detail:function(img){
		if(!img){return;}
		var del=(typeof(arguments[1])=='undefined')?'':arguments[1];
		return '<a href="javascript:;"><img src="'+img+'"><em></em></a>';
	},

	pop_contents_close_init:function(o, remove, not_div_mask){
		if(not_div_mask) eval(not_div_mask); //执行回调函数
		if(!not_div_mask || not_div_mask==0) global_obj.div_mask(1);
		frame_obj.pop_form(o, 1, not_div_mask);
		remove==1?o.remove():o.hide();
	},

	photo_choice_iframe_init:function(url, id, callback){
		var $html='';
		$html+='<div class="pop_form photo_choice">';
			$html+='<form id="photo_choice_edit_form">';
				$html+='<div class="t"><h1>'+lang_obj.manage.photo.picture_upload+'</h1><h2>×</h2></div>';
				$html+='<div class="r_con_form"><iframe src="" frameborder="0"></iframe></div>';
				$html+='<div class="button"><input type="submit" class="btn_global btn_submit" id="button_add" name="submit_button" value="'+lang_obj.global.submit+'" /><input type="button" class="btn_global btn_cancel" value="'+lang_obj.global.cancel+'" /></div>';
			$html+='</form>';
		$html+='</div>';
		$('#righter').append($html);
		var o=$('.photo_choice');
		frame_obj.pop_form(o, 0);//, callback
		setTimeout(function(){
			o.find('iframe').attr('src', url+'&iframe=1&r='+Math.random()); //效果执行完，才加载内容显示
		}, 200);

		var resize=function(){
			var $h=$(window).height()-o.find('form>.t').outerHeight()-o.find('form>.button').outerHeight()-70;
			o.css('top', 30).find('.r_con_form').css({'height':$h, 'max-height':$h});
		}
		resize();
		$(window).resize(function(){resize();});

		o.find('#button_add').click(function(){ //提交
			var obj=o.find('iframe').contents(),
				save=obj.find('input[name=save]').val(),//保存图片隐藏域ID
				id=obj.find('input[name=id]').val(),//显示元素的ID
				type=obj.find('input[name=type]').val(),//类型
				maxpic=obj.find('input[name=maxpic]').val();//最大允许图片数
			frame_obj.photo_choice_return(id, type, save, maxpic);
			return false;
		});
		o.find('.t h2').add(o.find('.btn_cancel')).click(function(){ //取消
			frame_obj.pop_contents_close_init($('.photo_choice'), 1, callback);
		});
	},

	photo_choice_init:function(o, save, id, type, maxpic, del_url, callback){	//参数：【点击按钮id】【保存图片隐藏域(单图：id值；多图：name值)】【显示元素的id】【类型，例如：editor即添加到编辑器】【最大允许图片数】【删除图片地址('./?'+del_url+'&...')】
		var save=global_obj.urlencode(save);
		var maxpic=maxpic==null?-1:maxpic;
		if(type=='editor'){maxpic=9999;}//编辑器上传没上限
		frame_obj.photo_choice_iframe_init('./?m=content&a=photo&d=choice&obj='+o+'&save='+save+'&id='+id+'&type='+type+'&maxpic='+maxpic, 'photo_choice', callback);
		$('.photo_choice').append('<input type="hidden" class="del_url" value="'+del_url+'" /><input type="hidden" class="callback" value="'+callback+'" />');
	},

	photo_choice_return:function(id, type){
		var save=(typeof(arguments[2])=='undefined')?'':arguments[2].replace('\\[\\]', '[]');//保存图片隐藏域id
		var maxpic=(typeof(arguments[3])=='undefined')?'':arguments[3];//最大允许图片数
		var num=(typeof(arguments[4])=='undefined')?'':arguments[4];//类型(本地上传/图片银行)
		var imgpath=(typeof(arguments[5])=='undefined')?'':arguments[5];//已上传图片地址
		var surplus=(typeof(arguments[6])=='undefined')?0:arguments[6];//剩余图片数
		var number=(typeof(arguments[7])=='undefined')?1:arguments[7];//当前图片序号
		var img_name=(typeof(arguments[8])=='undefined')?1:arguments[8];//当前图片名称
		var del_url=parent.$('.photo_choice .del_url').val();
		var callback=parent.$('.photo_choice .callback').val();
		var not_div_mask=0;
		id=id.replace(';', '=');
		save=save.replace(';', '=');

			//console.log(surplus);
		var error_img = $("input[name='file2BigName_hidden_text']").val();
		var big_pic_size;
		if(!surplus){
			big_pic_size = $('.fileupload-buttonbar .classIt').length;
		}
		if(num){
			/* 本地上传 */
			if(imgpath || (type=='editor' && big_pic_size)){//防止代码自动执行  //
				if(type!='editor' && parent.$('#'+id+' div').length>=parseInt(maxpic)){
					global_obj.win_alert(lang_obj.manage.account.picture_tips.replace('xxx', maxpic), function(){
						parent.frame_obj.pop_contents_close_init(parent.$('.photo_choice'), 1, not_div_mask);
					}, '', not_div_mask);
					return;
				}
				
				if(type=='editor'){//编辑框
					imgpath && $('.fileupload-buttonbar').find('[name=Name\\[\\]][value="'+img_name+'"]').attr('picpath',imgpath);
					if(!surplus){
						$('.fileupload-buttonbar').find(".template-download").find('[name=Name\\[\\]]').each(function(){
							var imgpath_list = $(this).attr('picpath');
							var obj=parent.CKEDITOR.instances[id].insertHtml('<img src="'+imgpath_list+'" />');//向编辑器增加内容
						});
					}
				}else if(imgpath){
					var obj=parent.$('#'+id);
					if(number==1){//优先上传第一张图片
						obj.find('.pic_btn .zoom').attr('href',imgpath);
						obj.find('.preview_pic a').remove();
						obj.find('.preview_pic').append(frame_obj.upload_img_detail(imgpath)).children('.upload_btn').hide().parent().parent().addClass('isfile');
						obj.find('.preview_pic').children('input[type=hidden]').val(imgpath).attr('save', 1);
					}else{
						callback && eval(callback);
						var oth_obj='', i;
						for(i=0; i<maxpic; ++i){
							oth_obj=obj.parents('.multi_img').find('.img[num='+i+']');
							if(imgpath && oth_obj.find('input[type=hidden]').attr('save')==0){
								oth_obj.find('.pic_btn .zoom').attr('href',imgpath);
								oth_obj.find('.preview_pic').append(frame_obj.upload_img_detail(imgpath)).children('.upload_btn').hide().parent().parent().addClass('isfile');
								oth_obj.find('.preview_pic').children('input[type=hidden]').val(imgpath).attr('save', 1);
								break;
							}
						}
					}
				}
				callback && eval(callback);
			}
			
			if(!surplus){
				$(".photo_multi_img .classIt").remove();
				$("input[name='file2BigName_hidden_text']").val(" ");
				error_img && window.parent.global_obj.win_alert(lang_obj.manage.global.photo_gt_2m+error_img,'',"alert");
				parent.frame_obj.pop_contents_close_init(parent.$('.photo_choice'), 1, not_div_mask);//最后一张，自动关闭
			}
			imgpath && global_obj.win_alert_auto_close(lang_obj.manage.global.upload_success,'',1000,'8%');
		}else{
			/* 从图片银行复制 */
			$.post('./', $('.photo_choice').find('iframe').contents().find('#photo_list_form').serialize()+'&type='+type, function(data){
				$('#button_add').attr('disabled', 'disabled');
				if(data.ret!=1){
					global_obj.win_alert(data.msg, function(){
						frame_obj.pop_contents_close_init($('.photo_choice'), 1, not_div_mask);
					}, '', callback);
					callback && eval(callback);
					return false;
				}else{
					if(data.type=='editor'){
						/* 编辑框 */
						var html='';
						var obj = parent.CKEDITOR.instances[id];
						for (var i in data.Pic){
							html += '<img src="'+data.Pic[i]+'" />';
						}
						obj.insertHtml(html);//向编辑器增加内容
					}else{
						var html='';
						var obj=parent.$('#'+id);
						save=save.replace(/\\/g,'');
						//优先上传第一张图片
						obj.find('.preview_pic a').remove();
						obj.find('.preview_pic').append(frame_obj.upload_img_detail(data.Pic[0])).children('.upload_btn').hide().parent().parent().addClass('isfile');
						obj.find('.preview_pic').children(save?save:'input[type=hidden]').val(data.Pic[0]).attr('save', 1);

						if(data.Pic.length>1){//选择多张执行下面代码
							var oth_obj='', i;
							for(i=1; i<maxpic; ++i){
								oth_obj=obj.parents('.multi_img').find('.img[num='+i+']');
								if(data.Pic[i] && oth_obj.find(save?save:'input[type=hidden]').attr('save')==0){
									oth_obj.find('.preview_pic').append(frame_obj.upload_img_detail(data.Pic[i])).children('.upload_btn').hide().parent().parent().addClass('isfile');
									oth_obj.find('.preview_pic').children(save?save:'input[type=hidden]').val(data.Pic[i]).attr('save', 1);
								}
							}
						}
						callback && eval(callback);
					}
				}
				frame_obj.pop_contents_close_init($('.photo_choice'), 1, not_div_mask);
			}, 'json');
			
			global_obj.win_alert_auto_close(lang_obj.manage.global.upload_success,'',1000,'8%');
		}
	},

	prompt_steps:function(){
		if(!$('#prompt_steps_tips').length){
			var PromptContent='';
			PromptContent+='<div id="prompt_steps_bg"></div>';
			PromptContent+='<div id="prompt_steps_tips" status="0"><a href="javascript:;"><img src="/static/manage/images/prompt/prompt_steps_begin.png" /></a></div>';
			PromptContent+='<div id="prompt_steps_light"></div>';
			PromptContent+='<div id="prompt_steps_ico"><span>'+lang_obj.manage.global.setting+'</span></div>';
			$('body').prepend(PromptContent);
			$('#prompt_steps_bg').css({'width':'100%', 'height':$(document).height(), 'overflow':'hidden', 'position':'fixed', 'top':0, 'left':0, 'background':'url(/static/manage/images/prompt/prompt_steps_bg.png) repeat', 'z-index':10000});
			$('#prompt_steps_ico').css({'position':'absolute', 'width':70, 'height':70, 'background-image':'url(/static/manage/images/frame/m-ico.png)', 'background-repeat':'no-repeat', 'background-color':'#53a18e', 'text-align':'center', 'display':'none', 'z-index':10001}).find('span').css({'padding-top':44, 'color':'#fff', 'display':'block'});
			$('#prompt_steps_light').css({'position':'absolute', 'width':70, 'height':70, 'background':'url(/static/manage/images/prompt/prompt_steps_light.png) repeat', 'display':'none', 'z-index':10002});
		}
		var $PromptTips=$('#prompt_steps_tips'),
			$PromptStatus=parseInt($PromptTips.attr('status')),
			$PromptIco=$('#prompt_steps_ico'),
			$PromptLight=$('#prompt_steps_light'),
			$PromptClick=$PromptTips.find('a');
		if($PromptStatus==0){
			$PromptTips.css({'position':'absolute', 'top':74, 'background':'url(/static/manage/images/prompt/prompt_steps_0.png) no-repeat', 'width':619, 'height':107, 'z-index':10003});
			$PromptTips.css({'left':$(window).width()/2-309.5});
			$PromptClick.css({'marginTop':75, 'marginRight':10, 'float':'right'});
		}else if($PromptStatus==1){
			$PromptClick.find('img').attr('src', '/static/manage/images/prompt/prompt_steps_know.png');
			$PromptTips.css({'left':61, 'top':90, 'background':'url(/static/manage/images/prompt/prompt_steps_1.png) no-repeat', 'width':383, 'height':249});
			$PromptIco.css({'display':'block', 'left':0, 'top':53});
			$PromptLight.css({'display':'block', 'left':0, 'top':53});
			$PromptClick.css({'marginTop':180, 'marginRight':33});
		}else if($PromptStatus==2){
			$PromptTips.css({'left':58, 'top':230, 'background':'url(/static/manage/images/prompt/prompt_steps_2.png) no-repeat', 'width':336, 'height':185});
			$PromptIco.css({'top':197, 'background-position':'-140px -140px'}).find('span').text(lang_obj.manage.global.product);
			$PromptLight.css({'top':197});
			$PromptClick.css({'marginTop':137, 'marginRight':20});
		}else if($PromptStatus==3){
			$PromptTips.css({'left':62, 'top':158, 'background':'url(/static/manage/images/prompt/prompt_steps_3.png) no-repeat', 'width':337, 'height':158});
			$PromptIco.css({'top':125, 'background-position':'-70px -70px'}).find('span').text(lang_obj.manage.global.content);
			$PromptLight.css({'top':125});
			$PromptClick.css({'marginTop':104, 'marginRight':33});
		}else if($PromptStatus==4){
			$('#header ul li.ico-0').removeClass('current');
			$PromptLight.css({'background':'url(/static/manage/images/prompt/prompt_steps_light_to.png) repeat'});
			$PromptTips.css({'left':'auto', 'right':103, 'top':43, 'background':'url(/static/manage/images/prompt/prompt_steps_4.png) no-repeat', 'width':313, 'height':172});
			$PromptIco.css({'left':'auto', 'right':384, 'top':0, 'background-image':'url(/static/manage/images/frame/h-ico.png)', 'background-position':'0 -51px', 'background-color':'#e7e7e7', 'width':64, 'height':51}).find('span').text(' ');
			$PromptLight.css({'left':'auto', 'right':384, 'top':0, 'width':64, 'height':51});
			$PromptClick.css({'marginTop':111, 'marginRight':38});
		}else if($PromptStatus==5){
			$('#header ul li.ico-0').addClass('current');
			$PromptTips.css({'left':'auto', 'right':31, 'top':43, 'background':'url(/static/manage/images/prompt/prompt_steps_5.png) no-repeat', 'width':349, 'height':94});
			$PromptIco.css({'left':'auto', 'right':127, 'background-position':'0 -357px'});
			$PromptLight.css({'left':'auto', 'right':127});
			$PromptClick.css({'marginTop':49, 'marginRight':38});
		}else{
			$('#prompt_steps_bg, #prompt_steps_tips, #prompt_steps_ico, #prompt_steps_light').remove();
		}
		$PromptClick.on('click', function(){
			$PromptTips.attr('status', $PromptStatus+1);
			frame_obj.prompt_steps();
		});
	},

	mouse_click:function(o, name, fun){ //兼容个别浏览器，点击事件与拖动效果相互冲突
		var $obj={};
		$obj[name+'_hasMove'] = false;
		$obj[name+'_obj'] = {};
		$obj[name+'_end'] = 1;

		o.on('mousedown', function(e){ //按下鼠标键事件
			$obj[name+'_obj'].x = e.pageX;
			$obj[name+'_obj'].y = e.pageY;
			$obj[name+'_end'] = 0;
			$obj[name+'_hasMove'] = false;
		}).on('mousemove', function(e){ //移动鼠标键事件
			if($obj[name+'_end'] == 1) return false;
			if(e.pageX === $obj[name+'_obj'].x && e.pageY === $obj[name+'_obj'].y) {
				$obj[name+'_hasMove'] = false;
			}else{
				$obj[name+'_hasMove'] = true;
			}
		}).on('mouseup', function(e){ //松开鼠标键事件
			$obj[name+'_obj'].x = e.pageX;
			$obj[name+'_obj'].y = e.pageY;
			$obj[name+'_end'] = 1;
			if(!$obj[name+'_hasMove']){ //没有移动过当前元素
				$.isFunction(fun) && fun($(this));
			}
			$obj[name+'_hasMove'] = false;
		});
	},

	upload_img_init:function(){
		//图片上传默认设置
		$('.multi_img .preview_pic input:hidden').each(function(){
			if($(this).attr('save')==1){
				$(this).parent().append(frame_obj.upload_img_detail($(this).val())).children('.upload_btn').hide();
			}
		});
		frame_obj.mouse_click($('.multi_img .pic_btn .del'), 'Del', function($this){ //产品颜色图点击事件
			var $obj=$this.parents('.img');
			global_obj.win_alert(lang_obj.global.del_confirm, function(){
				$obj.removeClass('isfile').removeClass('show_btn').parent().append($obj);
				$obj.find('.preview_pic .upload_btn').show();
				$obj.find('.preview_pic a').remove();
				$obj.find('.preview_pic input:hidden').val('').attr('save', 0);
			}, 'confirm');
		});
	},

	//产品图片上传默认设置
	upload_pro_img_init:function(type){
		var obj=(typeof(arguments[1])=='undefined')?'':arguments[1],
			isParent=(typeof(arguments[2])=='undefined')?0:parseInt(arguments[2]),
			o=new Object;
		if(obj){
			if(isParent==1){ o=parent.$(obj).find('.img'); }
			else{ o=$(obj).find('.img'); }
		}else{
			if(isParent==1){ o=parent.$('.pro_multi_img .img'); }
			else o=$('.pro_multi_img .img');
		}
		if(type==1){ //从左到右
			o.each(function(){
				if(!$(this).hasClass('isfile')){
					$(this).addClass('show_btn');
					return false;
				}
			});
		}else{ //从右到左
			o.each(function(){
				if($(this).hasClass('isfile')){
					$(this).prev().addClass('show_btn'); //上一个显示
					return false;
				}
				if($(this).index()+1==$(this).parent().find('.img').length){ //最后一个，还没有关联图片可以显示
					$(this).addClass('show_btn');
				}
			});
		}		
	},

	load_edit_form:function(target_obj, url, type, value, callback, fuc){
		$.ajax({
			type:type,
			url:url+value,
			success:function(data){
				if(fuc=='append'){
					$(target_obj).append($(data).find(target_obj).html());
				}else{
					$(target_obj).html($(data).find(target_obj).html());
				}
				callback && callback(data);
			}
		});
	},

	water_fall:function(container, colWidth, colCount, cls){
		function Waterfall(param){
		    this.id = typeof param.container == 'string' ? document.getElementById(param.container) : param.container;
		    this.colWidth = param.colWidth;
		    this.colCount = param.colCount || 4;
		    this.cls = param.cls && param.cls != '' ? param.cls : 'wf-cld';
		    this.init();
		}
		//瀑布流
		Waterfall.prototype = {
		    getByClass:function(cls,p){
		        var arr = [],reg = new RegExp("(^|\\s+)" + cls + "(\\s+|$)","g");
		        var nodes = p.getElementsByTagName("*"),len = nodes.length;
		        for(var i = 0; i < len; i++){
		            if(reg.test(nodes[i].className)){
		                arr.push(nodes[i]);//
		                reg.lastIndex = 0;
		            }
		        }
		        return arr;
		    },
		    maxArr:function(arr){
		        var len = arr.length,temp = arr[0];
		        for(var ii= 1; ii < len; ii++){
		            if(temp < arr[ii]){
		                temp = arr[ii];
		            }
		        }
		        return temp;
		    },
		    getMar:function(node){
		        var dis = 0;
		        if(node.currentStyle){
		            dis = parseInt(node.currentStyle.marginBottom);
		        }else if(document.defaultView){
		            dis = parseInt(document.defaultView.getComputedStyle(node,null).marginBottom);
		        }
		        return dis;
		    },
		    getMinCol:function(arr){
		        var ca = arr,cl = ca.length,temp = ca[0],minc = 0;
		        for(var ci = 0; ci < cl; ci++){
		            if(temp > ca[ci]){
		                temp = ca[ci];
		                minc = ci;
		            }
		        }
		        return minc;
		    },
		    init:function(){
		        var _this = this;
		        var col = [],//列高
		            iArr = [];//索引
		        var nodes = _this.getByClass(_this.cls,_this.id),len = nodes.length;
		        for(var i = 0; i < _this.colCount; i++){
		            col[i] = 0;
		        }
		        for(var i = 0; i < len; i++){
		            nodes[i].h = nodes[i].offsetHeight + _this.getMar(nodes[i]);
		            iArr[i] = i;
		        }

		        for(var i = 0; i < len; i++){
		            var ming = _this.getMinCol(col);
		            nodes[i].style.left = ming * _this.colWidth + "px";
		            nodes[i].style.top = col[ming] + "px";
		            col[ming] += nodes[i].h;
		        }

		        _this.id.style.height = _this.maxArr(col) + "px";
		    }
		};

		new Waterfall({
		    "container": container, //id
		    "colWidth": colWidth,
		    "colCount": colCount,//parseInt($('#themes_box').width()/220)
		    "cls": cls //class
		});
	},

	highcharts_init:{
		colors:['#0cb083', '#4289ff', '#90ed7d', '#f7a35c', '#91e8e1',  '#f15c80', '#e4d354', '#8d4653'],
		//曲线面积图
		areaspline:function(ObjName, data){
			var chart=Highcharts.chart(ObjName, $.extend(true, {
					chart:	{type:'areaspline'},
					colors:	frame_obj.highcharts_init.colors,
					credits:{enabled:false},
					title:	{text:''},
					exporting:{enabled:true},
					legend:	{enabled:false},
					yAxis:	{title:{text:''}},
					plotOptions: {areaspline:{fillOpacity:0.2}}
				}, data)
			);
		},
		//基础柱形图
		column_basic:function(ObjName, data){
			var chart=Highcharts.chart(ObjName, $.extend(true, {
					chart:	{type:'column'},
					colors:	frame_obj.highcharts_init.colors,
					credits:{enabled:false},
					title:	{text:''},
					legend:	{enabled:false},
					yAxis:	{title:{text:''}},
					plotOptions: {column:{borderWidth:0}}
				}, data)
			);
		},
		//包含图例的饼图
		pie_legend:function(ObjName, data){
			var chart=Highcharts.chart(ObjName, $.extend(true, {
					chart:	{type:'pie'},
					colors:	frame_obj.highcharts_init.colors,
					credits:{enabled:false},
					title:	{text:''},
					plotOptions: {
							pie:{allowPointSelect:true, cursor:'pointer', dataLabels:{enabled:false}, showInLegend:true}
					}
				}, data)
			);
		},
		//标题居中的环形图
		pie_donut_center_title:function(ObjName, data){
			var chart = Highcharts.chart(ObjName, $.extend(true, {
				chart:	{spacing:[40, 0 , 40, 0]},
				title: 	{floating:true, text:lang_obj.manage.global.circle_title},
				credits:{enabled:false},
				tooltip:{pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'},
				plotOptions:{
					pie:{
						allowPointSelect: true,
						showInLegend: true,
						cursor: 'pointer',
						dataLabels: {enabled: false},
						point:{
							events:{
								mouseOver: function(e){ //鼠标滑过时动态更新标题
									chart.setTitle({
										text: e.target.name+'\t'+e.target.y+' %'
									});
								}
							}
						},
					}
				}
			}, data),
			function(c){ //图表初始化完毕后的会掉函数
				//环形图圆心
				var centerY = c.series[0].center[1],
					titleHeight = parseInt(c.title.styles.fontSize);
				//动态设置标题位置
				c.setTitle({
					y:centerY + titleHeight/2
				});
			});
		}
	}
}