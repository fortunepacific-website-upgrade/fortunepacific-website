/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/
var inquiry_obj={
	inquiry_init:function(){
		frame_obj.del_init($('#inquiry .r_con_table'));
		frame_obj.select_all($('#inquiry .r_con_table input[name=select_all]'), $('#inquiry .r_con_table input[name=select]'), $('.list_menu_button .del,.list_menu_button .export'));
		frame_obj.del_bat($('.list_menu .del'), $('#inquiry .r_con_table input[name=select]'), 'inquiry.inquiry_del');
		inquiry_obj.export_data("inquiry.inquiry_explode");
	},

	feedback_init:function(){
		frame_obj.del_init($('#feedback .r_con_table'));
		frame_obj.select_all($('#feedback .r_con_table input[name=select_all]'), $('#feedback .r_con_table input[name=select]'), $('.list_menu_button .del'));
		frame_obj.del_bat($('.list_menu .del'), $('#feedback .r_con_table input[name=select]'), 'inquiry.feedback_del');

		var form = $('form[name=feedback_explode]');
		$('.explode_bat').click(function(){
			var id = '';
			$('input[name=select]', form).each(function(index, element) {
				if($(element).is(':checked')){
					id+=$(element).val()+',';
				}
            });
			if (id){
				$('input[name=IdStr]', form).val(id);
				form.submit();
			}else{
				global_obj.win_alert(lang_obj.global.dat_select);
			}
		});
	},

	review_init:function(){
		frame_obj.del_init($('#review .r_con_table'));
		frame_obj.select_all($('#review .r_con_table input[name=select_all]'), $('#review .r_con_table input[name=select]'), $('.list_menu_button .del'));
		frame_obj.del_bat($('.list_menu .del'), $('#review .r_con_table input[name=select]'), 'inquiry.review_del');
		
		frame_obj.submit_form_init($('#review_form'), './?m=inquiry&a=review');
		frame_obj.switchery_checkbox();
	},

	newsletter_init:function(){
		frame_obj.del_init($('#newsletter .r_con_table'));
		frame_obj.select_all($('#newsletter .r_con_table input[name=select_all]'), $('#newsletter .r_con_table input[name=select]'), $('.list_menu_button .del,.list_menu_button .export'));
		frame_obj.del_bat($('.list_menu .del'), $('#newsletter .r_con_table input[name=select]'), 'inquiry.newsletter_del');
		inquiry_obj.export_data("inquiry.newsletter_explode");
	},
	
	export_data:function(do_action){
		$('.list_menu_button .export').click(function(){
			var id_list='';
			$('.r_con_table input[name=select]').each(function(index, element) {
				id_list+=$(element).get(0).checked?$(element).val()+',':'';
            });
			if(id_list){
				id_list=id_list.substring(0,id_list.length-1);
				window.location='./?do_action=' + do_action + '&IdStr='+id_list;
			}else{
				global_obj.win_alert(alert_txt?alert_txt:lang_obj.global.explode_dat_select);
			}
		});
	},
}