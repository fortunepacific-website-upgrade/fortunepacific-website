/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/
var account_obj={
	login_init:function(){
		if(window!=top){top.location.href=window.location.href;}
		$('form').submit(function(){return false;});
		$('input:submit').click(function(){
			var flag=false;
			$('#UserName, #Password').each(function(){
				if($(this).val()==''){
					$(this).focus();
					flag=true;
					return false;
				}
			});
			if(flag){return;}

			$('#login .tips').html(lang_obj.manage.account.log_in);
			$(this).attr('disabled', true);
			$.post('?', $('form').serialize(), function(data){
				$('input:submit').attr('disabled', false);
				if(data.ret==1){
				    console.log('登录成功，准备跳转');
					$('#login .tips').html(lang_obj.manage.account.log_in_ok);
					setTimeout(function(){
					    // 强制清除缓存并跳转
                        window.top.location.href = '/manage/?rand=' + Math.random();
                        // 同时强制重新加载
                        window.top.location.reload(true);
					}, 2000);
				}else{
					$('#login .tips').html(data.msg);
				}
			}, 'json');
		});
		//token验证
		var url=window.location.href;
		if(url.indexOf('token')!=-1 && 0){
			var token=url.substr(url.indexOf('token')+6);
			$.post('?','do_action=account.login&token='+token,function(data){
				if(data.ret==1){
					window.top.location='./';
				}else{
					global_obj.win_alert(data.msg);
				}
			},'json');
		}
	},

	index_init:function(){
		account_obj.home_condition(function(time_s){
			var lang=$('body').hasClass('en')?'en':'cn',
				par='do_action=account.get_account_data&TimeS='+time_s+'&lang='+lang,
				Data=new Object;
			$.post('./', par, function(data){
				var $Obj=$('#account .home_container'),
					$Html='';

				//最新询盘
				$Html='';
				if(data.msg.inquiry){
					$.each(data.msg.inquiry, function(key, value){
						$Html+='<tr data-key="'+key+'">\
							<td class="new">'+value['new']+'</td>\
							<td class="email">'+value['email']+'</td>\
							<td class="type">'+value['type']+'</td>\
							<td class="subject">'+value['subject']+'</td>\
							<td class="time">'+value['time']+'</td>\
							<td class="name more"><a href="'+value['url']+'"></a></td>\
						</tr>';
					});
				}
				$Html==''?$('.new_inquiry .no_data').show():$('.new_inquiry .no_data').hide();
				$('.new_inquiry .table_report_list tbody').html($Html);

				//流量
				$Html='';
				if(data.msg.visits){
					$.each(data.msg.visits, function(key, value){
						$Html+='<tr data-key="'+value['key']+'"'+(time_s==value['key']?' class="current"':'')+'>\
							<td nowrap="nowrap" class="day">'+value['title']+'</td>\
							<td nowrap="nowrap" class="pv">'+value['pv']+'</td>\
							<td nowrap="nowrap" class="uv">'+value['uv']+'</td>\
						</tr>';
					});
				}
				$('.home_visits .table_data tbody').html($Html);

				//流量统计
				frame_obj.highcharts_init.column_basic('visits_charts', data.msg.visits_charts);

				//流量来源
				frame_obj.highcharts_init.pie_donut_center_title('referrer_charts', data.msg.referrer_charts);
				
				//来源网址
				$Html='';
				if(data.msg.referrer.uv){
					var i=0;
					$.each(data.msg.referrer.uv, function(key, value){
						if(i++>6) return false;
						$Html+='<tr>\
							<td class="name" width="90%"><div title="'+key+'">'+key+'</div></td>\
							<td nowrap="nowrap" class="count">'+value+'</td>\
						</tr>';
					});
				}
				/*<td nowrap="nowrap" class="percent">'+data.msg.referrer.total[key]+'</td>\*/
				$Html==''?$('.home_referrer_url .no_data').show():$('.home_referrer_url .no_data').hide();
				$('.home_referrer_url .table_report_list tbody').html($Html);
				
				//关键词排名
				$Html='';
				if(data.msg.keyword_rank){
					$.each(data.msg.keyword_rank, function(key, value){
						if(key>6) return false;
						$Html+='<tr>\
							<td nowrap="nowrap" width="60%" class="name">'+value["name"]+'</td>\
							<td nowrap="nowrap" width="20%">'+value["percent"]+'</td>\
							<td nowrap="nowrap" width="20%">'+value["nums"]+'</td>\
						</tr>';
					});
				}
				$Html==''?$('.home_search .no_data').show():$('.home_search .no_data').hide();
				$('.home_search .table_report_list tbody').html($Html);
				
				//访问分布
				$Html='';
				if(data.msg.visits_country.list){
					var country_total = data.msg.visits_country.total;
					$.each(data.msg.visits_country.list, function(key, value){
						if(key>8) return false;
						var percent=(parseFloat(value[1])/country_total*100).toFixed(2);
						$Html+='<tr>\
							<td nowrap="nowrap">'+value[0]+'</td>\
							<td nowrap="nowrap" class="percent">'+percent+'%</td>\
							<td nowrap="nowrap" class="count">'+value[1]+'</td>\
						</tr>';
					});
				}
				$Html==''?$('.home_sources_country .no_data').show():$('.home_sources_country .no_data').hide();
				$('.home_sources_country .table_report_list tbody').html($Html);
				
				//访问终端
				if(data.msg.device_percent){
					$('.home_terminal .terminal_list>li:eq(0) strong').text(data.msg.device_percent.pc);
					$('.home_terminal .terminal_list>li:eq(1) strong').text(data.msg.device_percent.mobile);
				}
				
			}, 'json');
		});
	},
	home_condition:function(callback, not_limit){
		$('.home_choice_day').hover(function(){
			$('.home_choice_day>dd').show().stop(true).animate({'top':58, 'opacity':1}, 250);
		}, function(){
			$('.home_choice_day>dd').stop(true).animate({'top':48, 'opacity':0}, 250, function(){ $(this).hide(); });
		});

		$('.home_choice_day>dd>a').click(function(){
			$(this).addClass('current').siblings().removeClass('current');
			$('.home_choice_day>dt>strong').html($(this).html());

			global_obj.win_alert_auto_close(lang_obj.global.loading, 'loading', -1);
			account_obj.home_condition_callback(callback);
			global_obj.win_alert_auto_close('', 'loading', 500, '', 0);
		});

		global_obj.win_alert_auto_close(lang_obj.global.loading, 'loading', -1);
		account_obj.home_condition_callback(callback);
		global_obj.win_alert_auto_close('', 'loading', 500, '', 0);
	},

	home_condition_callback:function(callback){
		var time_s=$('.home_choice_day a.current').attr('data-rel');
		callback(time_s);
	},
	welfare_init:function(){
		$('.welfare_menu a').click(function(){
			var _ind = $(this).index();
			$('.welfare_menu a').removeClass('cur').eq(_ind).addClass('cur');
			$('#welfare .welfare_box').hide().eq(_ind).show();
		});
		$('.welfare_box .category a').click(function(){
			var _ind = $(this).index();
			$('.welfare_box .category a').removeClass('cur').eq(_ind).addClass('cur');
			$('.welfare_box .category_box').hide().eq(_ind).show();
		});
		$('.video_list .list').click(function(){
				global_obj.div_mask();
				$('.video_box').show();
			if($(this).hasClass('no_play')){
				$('#video_play').html($('.no_play_tips').html());
			}else{
				var ccid=$(this).attr('data-ccid');
				$.get('?','do_action=account.video_play&ccid='+ccid,function(data){
					if(data){
						$('#video_play').html(data.msg);
					}else{
						global_obj.div_mask(1);
						$('.video_box').hide();
					}
				}, 'json');
			}
		});
		$('.video_box .cloce').click(function(){
			global_obj.div_mask(1);
			$('.video_box').hide();
			$('#video_play').html('');
		});
	},
}