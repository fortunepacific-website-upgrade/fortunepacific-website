/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/
var email_obj={
	email_send_init:function(){
		$('.user_group').on('click', function(){
			global_obj.div_mask();
			$('#email').append('<div id="photo_choice" class="pop_form photo_choice"><iframe src="./?m=email&a=send&iframe=1&d=group&r='+Math.random()+'" frameborder="0"></iframe></div>');
			$('#photo_choice').show();
		});
		frame_obj.submit_form_init($('#email_form'), './?m=email&a=logs');
	},
	
	email_group_init:function(){
		var self = this;
		$('.r_nav, .r_footer').remove();
		$choice=$(window.parent.document).find('#photo_choice');
		$('html').height($choice.height()).css('overflow', 'hidden');
		$('#user_gr').height($choice.height());
		$('#user_gr .user_list').height($choice.height()-$('#user_gr .list_hd').outerHeight(true)-$('#user_gr .list_foot').outerHeight(true)-20);
		$(parent.document).find('html').css('overflow', 'hidden');

		$('.choice_btn').on('click', function(){
			var $this=$(this);

			if($(window.parent.document).find('#email_form .MemberToName').hasClass('member_textarea')){
				if($this.hasClass('current')){
					$this.removeClass('current').children('input').attr('checked', false);
				}else{
					$this.addClass('current').children('input').attr('checked', true);
				}
			}else{
				$('#user_list_form').find('.choice_btn').removeClass('current').children('input').attr('checked', false);
				$this.addClass('current').children('input').attr('checked', true);
			}
		});

		//关闭选择框
		$(parent.document.getElementById('div_mask')).on('click', function(e){ self.email_group_close(); });
		$("#user_gr .btn_cancel").click(function(){ self.email_group_close(); });

		//选择会员
		$('#button_add').click(function(){ self.email_group_select(); });
		$("#user_gr .user_list .choice_btn").dblclick(function(){ self.email_group_select(); });
	},
	
	email_group_close:function(){	//关闭选择框
		$(parent.document.getElementById('div_mask')).remove();
		$(parent.document.getElementById('photo_choice')).remove();
	},
	
	email_group_select:function(){	//选中会员
		var self = this;
		var data='';
		$('#user_list_form input[name=User]').each(function(){
			if($(this).get(0).checked){
				data+=$(this).parent().attr('title')+'/'+$(this).prev().text()+"\r\n";
			}
		});

		if(data){
			$(window.parent.document).find('.MemberToName').val(data);
			self.email_group_close();
		}else{
			global_obj.win_alert(lang_obj.manage.email.not_user);
		}
	},
	
	config_init:function(){
		frame_obj.submit_form_init($('#email_form'));
	}
}