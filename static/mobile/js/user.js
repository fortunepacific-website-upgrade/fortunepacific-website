/*
 * 广州联雅网络
 */

(function ($, win){
	win.user_obj = {
		user_index:function (){
			
		}
		,user_login:function (){
			$('.user_login_form').submit(function(e) {return false;});
			//注册
			var reg_form = $('#reg_form');
			var reg_notnull = $('input[notnull]', reg_form);
			var reg_rq_mark = true;
			$('.submit', reg_form).on('tap', function (e){
				if (reg_rq_mark){
					reg_notnull.removeClass('null');
					setTimeout(function (){
						var status=0;
						reg_notnull.each(function(index, element) {
							if ($(element).val()==''){
								$(element).addClass('null');
								status=1;
							}else{
								$(element).removeClass('null');
							}
						});
						//判断内容
						var Email = $('input[name=Email]', reg_form);
						if(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/.test(Email.val())==false){
							Email.addClass('null');
							status=1;
						}else{
							Email.removeClass('null');
						}
						var pwd = $('input[name=Password]', reg_form);
						var pwd2 = $('input[name=Password2]', reg_form);
						if(pwd.val() != pwd2.val() || pwd.val()=='' || pwd2.val()==''){
							pwd.addClass('null');
							pwd2.addClass('null');
							status=1;
						}else{
							pwd.removeClass('null');
							pwd2.removeClass('null');
						}
						if (status){
							return false;
						}
						//通过验证，提交数据
						reg_rq_mark = false;
						$.post('/account/', reg_form.serializeArray(), function (data){
							if(data.ret!=1){
								alert(data.msg);
								reg_rq_mark = true;
							}else{
								window.location=data.msg;
							}
						}, 'json');
					}, 10);//setTimeout end
					
				}// if mark end
			});
			
			//登录
			var login_form = $('#login_form');
			var login_notnull = $('input[notnull]', login_form);
			var login_rq_mark = true;
			$('.submit', login_form).on('tap', function (e){
				if (login_rq_mark){
					login_notnull.removeClass('null');
					setTimeout(function (){
						var status=0;
						login_notnull.each(function(index, element) {
							if ($(element).val()==''){
								$(element).addClass('null');
								status=1;
							}else{
								$(element).removeClass('null');
							}
						});
						
						//判断内容
						var Email = $('input[name=Email]', login_form);
						if(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/.test(Email.val())==false){
							Email.addClass('null');
							status=1;
						}else{
							Email.removeClass('null');
						}
						if (status){
							return false;
						}
						//通过验证，提交数据
						login_rq_mark = false;
						$.post('/account/', login_form.serializeArray(), function (data){
							if(data.ret!=1){
								var msg = data.msg[0];
								msg = msg.replace(/<br>\s?/i, "\r\n");
								alert(msg);
								login_rq_mark = true;
							}else{
								window.location=data.msg;
							}
						}, 'json');
					}, 10);//setTimeout end
					
				}// if login_rq_mark end
			});
			
			//切换
			var user_login_tab = $('.user_login_tab div');
			user_login_tab.on('tap', function (){
				reg_notnull.removeClass('null');
				login_notnull.removeClass('null');
				user_login_tab.removeClass('on');
				$(this).addClass('on');
				$('.user_login').eq(user_login_tab.index(this)).css('display', 'block').siblings('.user_login').css('display', 'none');
			});
		}
		,user_setting:function (){
			var sub_btn = $('.sub_btn');
			sub_btn.on('click', function (){
				var index = sub_btn.index(this);
				var form = $('#setting_form'+index);
				var notnull = $('input[notnull]', form);
				var status=0;
				notnull.each(function(index, element) {
					if ($(element).val()==''){
						$(element).addClass('null').focus();
						status=1;
					}else{
						$(element).removeClass('null');
					}
				});
				
				//判断内容
				var Email = $('input[name=NewEmail]', form);
				if (Email.length){
					if(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/.test(Email.val())==false){
						Email.addClass('null');
						status=1;
					}else{
						Email.removeClass('null');
					}
				}
				if (status){
					return false;
				}
				
				//通过验证，提交数据
				form.submit();
			});
		}
	};
})(jQuery, window);
