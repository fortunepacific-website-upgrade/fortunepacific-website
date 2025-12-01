/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

var seo_obj={
	overview_init:function(){
		$('#overview span.get_mission').click(function(){
			global_obj.div_mask();
			$.post('?', 'do_action=seo.overview_get_new_mission', function(data){
				$('#ajax_post_tips').remove();
				if(data.ret==1){
					window.location='./?m=seo&a=overview';
				}else{
					global_obj.win_alert(data.msg[0], function(){global_obj.div_mask(1);});
				}
			}, 'json');
		});
		var charts_data=$.parseJSON($('.charts').attr('data'));
		frame_obj.highcharts_init.column_basic('charts', charts_data);
	},
	
	keyword_init:function(){
		$('.keyword_edit_form').delegate('.add', 'click', function(){//增加一行
			$('.keyword_edit_form .list_input').append($('.keyword_edit_form .list_input .item:last').prop('outerHTML'));
			$('.keyword_edit_form .list_input .item').length>=counts && $('.keyword_edit_form .add').hide();
		});
		$('.keyword_edit_form').delegate('.del', 'click', function(){//删除一行
			$('.keyword_edit_form .list_input .item').length>1 && $(this).parents('.item').remove();
			$('.keyword_edit_form .list_input .item').length<counts && $('.keyword_edit_form .add:last').show();
		});
		$('#keyword .r_con_table').delegate('.add', 'click', function(){
			global_obj.div_mask();
			$('.keyword_edit_form').show();
			$('.keyword_edit_form .list_input .item').length>=counts && $('.keyword_edit_form .add').hide();
		});
		$('body').delegate('#div_mask', 'click', function(){//关闭弹框
			global_obj.div_mask(1);
			$('.keyword_edit_form').hide();
		});
		frame_obj.del_init($('#keyword .r_con_table'));
		frame_obj.submit_form_init($('.keyword_edit_form form'), './?m=seo&a=keyword','','',function(){
			window.location.reload();
		},0);
	},

	article_init:function(){
		$('.r_con_list').delegate('dt', 'click', function(){
			//$(this).hasClass("offTop")?$(this).removeClass("offTop"):$(this).addClass("offTop");
			$(this).next().is(':hidden')?$(this).next('.offBtm').slideDown():$(this).next('.offBtm').slideUp();
			$(this).siblings('dd').find('img').each(function(){$(this).attr('src', $(this).attr('_src'));});
		});

		/*永久关闭*/
		$('.r_con_list').delegate('a.close', 'click', function(){
			var obj=$(this).parents('li[data]');
			$.post('?', "do_action=seo.article_close&ArticleId="+obj.attr('data'), function(data){
				if(data.ret==1){
					obj.slideUp(500, function(){$(this).remove();});
				}else{
					global_obj.win_alert(data.msg[0], function(){global_obj.div_mask(1);});
				}
			}, 'json');
		});

		/*完成*/
		$('.r_con_list').delegate('a.finish', 'click', function(){
			var obj=$(this).parents('li[data]');
			$.post('?', "do_action=seo.article_finish&ArticleId="+obj.attr('data'), function(data){
				if(data.ret==1){
					obj.slideUp(500, function(){$(this).remove();});
				}else{
					global_obj.win_alert(data.msg[0], function(){global_obj.div_mask(1);});
				}
			}, 'json');
		});

		/*提醒*/
		$('.r_con_list').delegate('a.five, a.ten, a.month', 'click', function(){
			var obj=$(this).parents('li[data]');
			$.post('?', "do_action=seo.article_remind&time="+$(this).attr('class')+"&ArticleId="+obj.attr('data'), function(data){
				if(data.ret==1){
					obj.find('dl').slideUp(500, function(){$(this).remove();});
				}else{
					global_obj.win_alert(data.msg[0], function(){global_obj.div_mask(1);});
				}
			}, 'json');
		});
	},

	mobile_init:function(){
		$('.r_con_list').delegate('dt', 'click', function(){
			//$(this).hasClass("offTop")?$(this).removeClass("offTop"):$(this).addClass("offTop");
			$(this).next().is(':hidden')?$(this).next('.offBtm').slideDown():$(this).next('.offBtm').slideUp();
			$(this).siblings('dd').find('img').each(function(){$(this).attr('src', $(this).attr('_src'));});
		});

		/*永久关闭*/
		$('.r_con_list').delegate('a.close', 'click', function(){
			var obj=$(this).parents('li[data]');
			$.post('?', "do_action=seo.mobile_close&ArticleId="+obj.attr('data'), function(data){
				if(data.ret==1){
					obj.slideUp(500, function(){$(this).remove();});
				}else{
					global_obj.win_alert(data.msg[0], function(){global_obj.div_mask(1);});
				}
			}, 'json');
		});

		/*完成*/
		$('.r_con_list').delegate('a.finish', 'click', function(){
			var obj=$(this).parents('li[data]');
			$.post('?', "do_action=seo.mobile_finish&ArticleId="+obj.attr('data'), function(data){
				if(data.ret==1){
					obj.slideUp(500, function(){$(this).remove();});
				}else{
					global_obj.win_alert(data.msg[0], function(){global_obj.div_mask(1);});
				}
			}, 'json');
		});

		/*提醒*/
		$('.r_con_list').delegate('a.five, a.ten, a.month', 'click', function(){
			var obj=$(this).parents('li[data]');
			$.post('?', "do_action=seo.mobile_remind&time="+$(this).attr('class')+"&ArticleId="+obj.attr('data'), function(data){
				if(data.ret==1){
					obj.find('dl').slideUp(500, function(){$(this).remove();});
				}else{
					global_obj.win_alert(data.msg[0], function(){global_obj.div_mask(1);});
				}
			}, 'json');
		});
	},

	links_init:function(){
		$('.r_con_list').delegate('dt', 'click', function(){
			$(this).hasClass("offTop")?$(this).removeClass("offTop"):$(this).addClass("offTop");
			$(this).next().is(':hidden')?$(this).next('.offBtm').slideDown():$(this).next('.offBtm').slideUp();
			$(this).siblings('dd').find('img').each(function(){$(this).attr('src', $(this).attr('_src'));});
		});

		//视频播放
		$('body').delegate('#div_mask', 'click', function(){
			global_obj.div_mask(1);
			$('#VideoBox, #VideoClose').remove();
		});
		$('.r_con_list li dd .contents .list .rows .img_list.video').delegate('a', 'click', function(){
			var video=$(this).attr('data-video-url');
			global_obj.div_mask();
			$('<div id="VideoBox" style="width:960px; height:540px; position:absolute; top:50%; left:50%; margin-left:-480px; margin-top:-270px; background:#fff; z-index:10000;"><video preload="preload" controls autoplay src="'+video+'" style="width:100%; height:100%;"></video></div><div id="VideoClose" style="width:27px; height:27px; padding:10px; position:absolute; top:0; right:0; z-index:10000; cursor:pointer;">').appendTo($('body'));
		});

		frame_obj.submit_form_init($('.complete_form'), './?m=seo&a=links');
		$('body').delegate('.complete_form .btn_cancel, #div_mask', 'click', function(){
			global_obj.div_mask(1);
			$('.complete_form').hide();
		});
		$('.r_con_list').delegate('a.complete', 'click', function(){
			var obj=$(this).parents('li[data]');
			var form=$('.complete_form');
			form.find('input[name=Url]').val('');
			form.find('input[name=key]').val(obj.attr('data'));
			form.find('input[name=keywords]').val(obj.find('.finish').attr('data'));
			form.show();
			global_obj.div_mask();
		});
		$('.r_con_list').delegate('a.skip', 'click', function(){
			var obj=$(this).parent().parent().parent().parent();
			$.post('?', "do_action=seo.links_skip&key="+obj.attr('data')+'&keywords='+obj.find('.finish').attr('data'), function(data){
				if(data.ret==1){
					obj.slideUp(500, function(){$(this).remove();});
				}else{
					global_obj.win_alert(data.msg[0], function(){global_obj.div_mask(1);});
				}
			}, 'json');
		});
	},

	ads_init:function(){
		$('.r_con_list').delegate('dt', 'click', function(){
			$(this).hasClass("offTop")?$(this).removeClass("offTop"):$(this).addClass("offTop");
			$(this).next().is(':hidden')?$(this).next('.offBtm').slideDown():$(this).next('.offBtm').slideUp();
			$(this).siblings('dd').find('img').each(function(){$(this).attr('src', $(this).attr('_src'));});
		});

		//视频播放
		$('.r_con_list li dd .contents .list .rows .img_list.video').delegate('a', 'click', function(){
			var video=$(this).attr('data-video-url');
			
			global_obj.div_mask();
			$('<div id="VideoBox" style="width:960px; height:540px; position:absolute; top:50%; left:50%; margin-left:-480px; margin-top:-270px; background:#fff; z-index:10000;"><video preload="preload" controls autoplay src="'+video+'" style="width:100%; height:100%;"></video></div><div id="VideoClose" style="width:27px; height:27px; padding:10px; position:absolute; top:0; right:0; z-index:10000; cursor:pointer;"><img src="/static/js/plugin/lightbox/images/close.png" /></div>').appendTo($('body'));
			
			$('body').delegate('#VideoClose img, #div_mask', 'click', function(){
				global_obj.div_mask(1);
				$('#VideoBox, #VideoClose').remove();
			});
		});

		frame_obj.submit_form_init($('.complete_form'), './?m=seo&a=ads');
		$('body').delegate('.complete_form .btn_cancel, #div_mask', 'click', function(){
			global_obj.div_mask(1);
			$('.complete_form').hide();
		});
		$('.r_con_list').delegate('a.complete', 'click', function(){
			var obj=$(this).parents('li[data]');
			var form=$('.complete_form');
			form.find('input[name=Url]').val('');
			form.find('input[name=key]').val(obj.attr('data'));
			form.show();
			global_obj.div_mask();
		});
		$('.r_con_list').delegate('a.skip', 'click', function(){
			var obj=$(this).parent().parent().parent().parent();
			$.post('?', "do_action=seo.ads_skip&key="+obj.attr('data'), function(data){
				if(data.ret==1){
					obj.slideUp(500, function(){$(this).remove();});
				}else{
					global_obj.win_alert(data.msg[0], function(){global_obj.div_mask(1);});
				}
			}, 'json');
		});
	},

	blog_init:function(){
		$('.r_con_list li.post').delegate('dt', 'click', function(){
			$(this).hasClass("offTop")?$(this).removeClass("offTop"):$(this).addClass("offTop");
			$(this).next().is(':hidden')?$(this).next('.offBtm').slideDown():$(this).next('.offBtm').slideUp();
		});
		$('.r_con_list li.post').delegate('.lightbox-rel', 'click', function(){$('.lightbox-images:eq(0)').click();});

		frame_obj.submit_form_init($('.complete_form'), './?m=seo&a=blog');
		$('body').delegate('.complete_form .btn_cancel, #div_mask', 'click', function(){
			global_obj.div_mask(1);
			$('.complete_form').hide();
		});
		$('.r_con_list .create, .r_con_list li.post').delegate('a.complete', 'click', function(){
			var obj=$(this).parents('li[data]');
			var form=$('.complete_form');
			form.find('input[name=Url]').val('');
			form.find('input[name=key]').val(obj.attr('data'));
			form.find('input[name=keywords]').val(obj.find('.finish').attr('data'));
			form.find('input[name=num]').val(obj.attr('num'));
			form.show();
			global_obj.div_mask();
		});
	},

	seo_init:function(){
		frame_obj.submit_form_init($('#seo_form'), './?m=seo&a=sitemap');
	},

	description_init:function(){
		frame_obj.del_init($('#description .r_con_table'));
		frame_obj.select_all($('#description .r_con_table input[name=select_all]'), $('#description .r_con_table input[name=select]'), $('.list_menu_button .del'));
		frame_obj.del_bat($('.list_menu .del'), $('#description .r_con_table input[name=select]'), 'seo.description_del');
	},
	description_edit_init:function (){
		frame_obj.translation_init();
		frame_obj.submit_form_init($('#description_form'), './?m=seo&a=description');
	},
}