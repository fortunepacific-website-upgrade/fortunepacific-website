/*
 * 广州联雅网络
 */
$(function(){
	var _w=$(window).width()>=640?640:$(window).width();
	window.touch_nav = function (pos, posW, win_w){
		var startPos = {};
		var MovePos = {};
		var isScrolling = 0;
		var _mL = 0;
		
		pos.get(0).ontouchstart = function (e){
			start(e);
		};
		pos.get(0).ontouchmove = function (e){
			move(e);
		}
		pos.get(0).ontouchend = function (e){
			end(e);
		}
		
		function start(e){
			startPos = {x:e.touches[0].pageX,y:e.touches[0].pageY,time:+new Date};
			isScrolling = 0;
			_mL = parseFloat(pos.css('margin-left'));
		}
		function move(e){
			if(e.targetTouches.length > 1 || e.scale && e.scale !== 1) return;
			MovePos = {x:e.touches[0].pageX - startPos.x,y:e.touches[0].pageY - startPos.y};
			isScrolling = Math.abs(MovePos.x) < Math.abs(MovePos.y) ? 1:0;
			if(isScrolling==1){
				pos.get(0).ontouchmove = function (){};
			}else{
				pos.get(0).ontouchmove = function (e2){
					e2.preventDefault();
					var marL = e2.touches[0].pageX-startPos.x;
					pos.css('margin-left', marL+_mL);
				};
			}
		}
		function end(e){
			_mL = parseFloat(pos.css('margin-left'));
			if (_mL>0){
				pos.animate({marginLeft:0}, 200);
			}else if (posW+_mL<win_w){
				if (posW>win_w){
					pos.animate({marginLeft:win_w-posW}, 200);
				}else{
					pos.animate({marginLeft:0}, 200);
				}
			}
			pos.get(0).ontouchmove = function (e){
				move(e);
			}
		}
	};//touch_nav end
	
	var to_top = $('.to_top');
	$(window).scroll(function(e) {
		if ($(window).scrollTop()>0){
			to_top.css('display', 'block');
		}else{
			to_top.css('display', 'none');
		}
	});
	to_top.on('click', function (){
		$(window).scrollTop(0);
	});
	//头部菜单
	$('header nav').on('click', function (e){
		e.stopPropagation();
	});
	
	$('header .icon_1').on('click', function (e){
		$('header nav').addClass('on');
		$('header .navbg').addClass('on');
		$('html').css({'height':$(window).height(),'overflow':'hidden'});
		e.stopPropagation();
	});
	$('header .navbg').on('click', function (e){
		$('header .sec_nav').removeClass('on');
		$('header nav').removeClass('on');
		$('header .navbg').removeClass('on');
		$('html').removeAttr('style');
	});
	$('.sec_nav').on('click','.cate_close', function (e){
		$('header .sec_nav').removeClass('on');
	});
	$('header nav .hasub').on('touchstart', function (e){
		$('.hasub .sub').removeClass('on');
		$('.sec_nav').html($(this).find('.sub').html()).addClass('on');
	});
	
	//搜索
	$('header .icon_3,.goods_searchbg').on('click', function (){
		$('.goods_search,.goods_searchbg').toggle();
	});
	
	
	//面包屑
	var page_title = $('.page_title');
	var pos = $('.page_title .pos');
	if (pos.length){
		var win_w = _w;
		var posW = parseInt($('.column', pos).outerWidth(true))+parseInt(page_title.css('padding-left'))*2;
		if (posW>page_title.width()){
			touch_nav(pos, posW, win_w);
		}//if end 
	}// if pos.length end
	//面包屑 end
	
	//选择语言
	$('footer .c_lang,header .c_lang').on('click', function (e){
		$('footer .lang_list').css('margin-top', function (){
			$(this).css('display', 'block');
			return -($(this).outerHeight(true)/2);
		});
	});
	$('footer .close').on('click', function (e){
		$('footer .lang_list').css('display', 'none');
	});
	//选择语言 end
	
	//下载
	$('#downlist').on('click','.down_btn', function(){
		var id = $(this).attr('l');
		if ($(this).hasClass('pwd')){
			global_obj.win_alert('', function (){
				var pwd = $('.win_alert input[name=Password]').val();
				$.get('/', {do_action:'action.download_pwd', DId:id, pwd:pwd}, function (data){
					if (data.ret==1){
						$('.win_alert .error_tips').hide(0).html('');
						if (data.msg.url==0){//内链
							$('.win_alert').remove();
							global_obj.div_mask(1);
							window.location.href = '/?do_action=action.download'+'&DId='+id+'&pwd='+pwd;
						}else{//外链
							window.location.href = data.msg.url;
						}
					}else{
						$('.win_alert .error_tips').show(0).html(data.msg[0]);
					}
				}, 'json');
			}, 'password');
		}else{
			if(!$(this).is('[target]')){
				window.location = '/?do_action=action.download'+'&DId='+id;
			}
		}
	});
	//询盘
	$('body').on('click','.inquiry_btn',function(){	//加入询盘篮
		if ($('.inquiry_tips').length){
			return;
		}
		$.post('?do_action=action.add_inquiry', 'ProId='+$(this).attr('data'), function(data){
			if(data.inq_type){
				window.location.href="/inquiry.html";
			}else{
				tips = lang_obj.global.add_success;
				if(data.status==-1){
					tips = lang_obj.global.already;
				}
				var html = '<div class="inquiry_tips">\
								<div class="c">\
									<div class="title">'+tips+'</div>\
									<a href="/inquiry.html">'+lang_obj.global.inquery+'</a><br><a href="javascript:void(0);" class="close">'+lang_obj.global.continues+'</a>\
								</div>\
							</div>\
							<div class="inquiry_tipsbg"></div>';
				$('body').append(html);
				$('.inquiry_tips .close,.inquiry_tipsbg').off('click').on('click', function (){
					$('.inquiry_tips').remove();
					$('.inquiry_tipsbg').remove();
				});
			}
		},'json');
	});
	
	//浮动在线客服
	$('#float_chat .chat_button').on('click', function(e){
		$('#float_chat .inner_chat').css('margin-top', function(){
			$(this).css('display', 'block');
			return -($(this).outerHeight(true)/2);
		});
	});
	$('#float_chat .chat_close').on('click', function (e){
		$('#float_chat .inner_chat').css('display', 'none');
	});
	
	//产品附件下载
	$('.detail_desc .pro_down a').click(function(){
		var proid = $(this).attr('ProId');
		var path = $(this).attr('path');
		if ($(this).hasClass('pwd')){
			global_obj.win_alert('', function (){
				var pwd = $('.win_alert input[name=Password]').val();
				$.get('/', {do_action:'action.products_download_pwd', Path:path, ProId:proid, pwd:pwd}, function (data){
					if (data.ret==1){
						$('.win_alert .error_tips').hide(0).html('');
						$('.win_alert').remove();
						global_obj.div_mask(1);
						window.location.href = '/?do_action=action.products_download&Path='+path+'&ProId='+proid+'&pwd='+pwd;
					}else{
						$('.win_alert .error_tips').show(0).html(data.msg[0]);
					}
				}, 'json');
				
			}, 'password');
		}else{
			window.location = '/?do_action=action.products_download&Path='+path+'&ProId='+proid;
		}
	});//产品附件下载 end
	
});

//Object => string
$.toJSON = typeof JSON == "object" && JSON.stringify ? JSON.stringify: function(e) {
	if (e === null) return "null";
	var t, n, r, i, s = $.type(e);
	if (s === "undefined") return undefined;
	if (s === "number" || s === "boolean") return String(e);
	if (s === "string") return $.quoteString(e);
	if (typeof e.toJSON == "function") return $.toJSON(e.toJSON());
	if (s === "date") {
		var o = e.getUTCMonth() + 1,
		u = e.getUTCDate(),
		a = e.getUTCFullYear(),
		f = e.getUTCHours(),
		l = e.getUTCMinutes(),
		c = e.getUTCSeconds(),
		h = e.getUTCMilliseconds();
		o < 10 && (o = "0" + o);
		u < 10 && (u = "0" + u);
		f < 10 && (f = "0" + f);
		l < 10 && (l = "0" + l);
		c < 10 && (c = "0" + c);
		h < 100 && (h = "0" + h);
		h < 10 && (h = "0" + h);
		return '"' + a + "-" + o + "-" + u + "T" + f + ":" + l + ":" + c + "." + h + 'Z"'
	}
	t = [];
	if ($.isArray(e)) {
		for (n = 0; n < e.length; n++) t.push($.toJSON(e[n]) || "null");
		return "[" + t.join(",") + "]"
	}
	if (typeof e == "object") {
		for (n in e) if (hasOwn.call(e, n)) {
			s = typeof n;
			if (s === "number") r = '"' + n + '"';
			else {
				if (s !== "string") continue;
				r = $.quoteString(n)
			}
			s = typeof e[n];
			if (s !== "function" && s !== "undefined") {
				i = $.toJSON(e[n]);
				t.push(r + ":" + i)
			}
		}
		return "{" + t.join(",") + "}"
	}
};

//string => Object
$.evalJSON = typeof JSON == "object" && JSON.parse ? JSON.parse: function(str) {
	return eval("(" + str + ")")
};
function SetMContent(contents){
	var _this = $(contents);
	_this.find("table").each(function(){
		$(this).width("100%");
	});
}