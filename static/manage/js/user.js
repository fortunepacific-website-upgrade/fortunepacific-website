/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/
var user_obj={
	user_init:function(){
		frame_obj.del_init($('#user .r_con_table'));
		frame_obj.select_all($('#user .r_con_table input[name=select_all]'), $('#user .r_con_table input[name=select]'), $('.list_menu_button .del'));
		frame_obj.del_bat($('.list_menu .del'), $('#user .r_con_table input[name=select]'), 'user.user_del');

		$(".custom_column").hover(function(){
			$(this).find(".custom_body").show();
		}, function(){
			$(this).find(".custom_body").hide();
		});

		var option_checkbox = $(".custom_body .user_input_checkbox_box");
		option_checkbox.click(function(){
			if($(this).hasClass('checked')){
				$(this).removeClass('checked').find('input').removeAttr('checked');
			}else{
				$(this).addClass('checked').find('input').attr('checked','checked');
			}
			is_all_check();
		});
		$("input[name='custom_all']").parents(".input_checkbox_box").click(function(){
			var isChecked=$(this).find("input").is(':checked')?1:0;
			if(!isChecked){
				option_checkbox.not("disabled").addClass('checked').find("input").attr('checked','checked');
			}else{
				option_checkbox.not("disabled").removeClass('checked').find("input").removeAttr('checked');
			}
		});
		function is_all_check(){
			var is_select_all = 1;
			option_checkbox.each(function(){
				if(!$(this).hasClass("checked")){
					is_select_all = 0;
				}
			});
			if(is_select_all){
				$("input[name='custom_all']").attr('checked','checked').parents(".input_checkbox_box").addClass('checked');
			}else{
				$("input[name='custom_all']").removeAttr('checked').parents(".input_checkbox_box").removeClass('checked');
			}
		}
		is_all_check();

		frame_obj.submit_form_init($('#user_custom_form'), './?m=user&a=user');
	},

	explode_init:function(){
		$('#explode_edit_form input[name=RegTime]').daterangepicker({showDropdowns:true});
		frame_obj.submit_form_init($('#explode_edit_form'), '', '', '', function(data){
			if(data.ret==2){
				$('#explode_progress').append(data.msg[1]);
				$('#explode_edit_form input[name=Number]').val(data.msg[0]);
				$('#explode_edit_form .btn_submit').click();
			}else if(data.ret==1){
				$('#explode_edit_form input[name=Number]').val(0);
				window.location='./?do_action=user.user_explode_down&Status=ok';
			}else{
				$('#explode_edit_form input[name=Number]').val(0);
				global_obj.win_alert(data.msg);
				$('#explode_edit_form .btn_submit').removeAttr('disabled');
			}
		});
	},

	user_view_init:function(){
		frame_obj.submit_form_init($('#user_form'), './?m=user&a=user&d=view');
		frame_obj.switchery_checkbox();
	},
}