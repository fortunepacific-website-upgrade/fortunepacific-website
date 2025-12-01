/*
 * 广州联雅网络
 */
var feedback_obj = {
	inquiry_init:function (){//询盘
		var inquiry_form = $('#inquiry_form');
		var rq_mark = true;
		var notnull = $('*[notnull]', inquiry_form);
		//删除
		$('.inquiry_info .del').on('click', function (){
			var par = $(this).parent().parent().parent();
			$.post('?do_action=action.del_inquiry', 'ProId='+$(this).attr('proid'), function(data){
				if(data.status==1){
					alert('Successful!');
					par.remove();
				}else if(data.status==-1){
					alert('Error!');
				}
			},'json');
		});
		//提交
		$('#sub_btn').on('click', function (e){
			if (rq_mark){
				notnull.removeClass('null');
				setTimeout(function (){
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
					var Email = $('input[name=Email]', inquiry_form);
					if(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/.test(Email.val())==false){
						Email.addClass('null').focus();
						status=1;
					}else{
						Email.removeClass('null');
					}
					if (status){
						return false;
					}
					//通过验证，提交数据
					rq_mark = false;
					$.post('?do_action=action.submit_inquiry', inquiry_form.serialize(), function(data){
						if(data.status==1){
							alert(data.msg);
							window.location.href='/';
						}else{
							rq_mark = true;
						}
					},'json');
					
				}, 10);
			}
		});// tap end
	}//询盘结束
	,feedback_init:function (){
		var feedback_form = $('#feedback_form');
		var rq_mark = true;
		var notnull = $('*[notnull]', feedback_form);
		$('#sub_btn').on('click', function (e){
			if (rq_mark){
				notnull.removeClass('null');
				setTimeout(function (){
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
					var Email = $('input[name=Email]', feedback_form);
					if(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/.test(Email.val())==false){
						Email.addClass('null').focus();
						status=1;
					}else{
						Email.removeClass('null');
					}
					if (status){
						return false;
					}
					//通过验证，提交数据
					rq_mark = false;
					$.post('?do_action=action.submit_feedback', feedback_form.serialize(), function(data){
						if(data.status==1){
							alert(data.msg);
							window.location.href='/';
						}else{
							alert(data.msg);
							rq_mark = true;
						}
					},'json');
					
				}, 10);
			}
		});// tap end
	}//留言结束
};


