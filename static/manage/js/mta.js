/*
Powered by ueeshop.com		http://www.ueeshop.com
广州联雅网络科技有限公司		020-83226791
*/

var mta_obj={
	visits_init:function(){
		var resize=function(){
			var $browser=$('.box_browser')
				$browserWidth=$browser.width(),
				$halfWidth=(($browserWidth-$browser.find('.item:eq(0)').outerWidth())/2);
			$browser.find('.item:gt(0)').css('width', $halfWidth-61);
		}
		resize();
		$(window).resize(function(){
			resize();
		});
		
		//时间段相关数据
		mta_obj.nav_condition(function(time_s, time_e, terminal, compare){
			var Time=$('.mta_menu .box_time a.current').attr('data-value'),
				par='do_action=mta.api_get_data&Action=ueeshop_analytics_get_visits_data&TimeS='+time_s+'&TimeE='+time_e+'&Terminal='+terminal+'&Compare='+compare,
				Data=new Object;
			$.post('./', par, function(data){
				//数据整合
				console.log(data);
				$('.box_data_list .pv').html(data.msg.total.pv);
				$('.box_data_list .average_pv').html(data.msg.total.average_pv);
				$('.box_data_list .uv').html(data.msg.total.uv);
				$('.box_data_list .ip').html(data.msg.total.ip);
				
				//概况
				Data=new Object;
				Data['xAxis']={'categories': data.msg.line_charts.xAxis.categories};
				Data['series']=new Array;
				for(k in data.msg.line_charts.series){
					Data['series'][k]={'name':'Pv', 'data':data.msg.line_charts.series[k].data};
				}
				frame_obj.highcharts_init.areaspline('line_charts', Data);
				
				//设备数据整合
				var browser_total=new Object,
					browser_percent=new Object,
					total=0;
				for(k in data.msg.browser_all_charts){
					browser_total[k]=0;
					for(k2 in data.msg.browser_all_charts[k]){
						browser_total[k]+=data.msg.browser_all_charts[k][k2];
					}
				}
				total=browser_total[0]+browser_total[1];
				browser_percent[0]=(browser_total[0]/total*100).toFixed(2);
				browser_percent[1]=(browser_total[1]/total*100).toFixed(2);
				browser_percent=Array({'name':lang_obj.global.source.pc, 'y':parseFloat(browser_percent[0])}, {'name':lang_obj.global.source.mobile, 'y':parseFloat(browser_percent[1])});
				
				//设备占比
				Data=new Object;
				Data['series']=new Array;
				Data['series'][0]={'name':lang_obj.manage.mta.equipment_ratio, 'data':browser_percent};
				frame_obj.highcharts_init.pie_legend('browser_charts', Data);
				
				if(data.msg.browser_all_charts.length>0){
					var count=0;
					//PC端浏览器
					html='';
					if(data.msg.browser_all_charts[0]){
						$.each(data.msg.browser_all_charts[0], function(key, value){
							count=(value/browser_total[0]*100).toFixed(2);
							html+='<div class="browser_data">\
								<div class="browser_left">'+key+'</div>\
								<div class="browser_right"><div class="process" style="width:'+count+'%;"></div></div>\
								<div class="browser_percent">'+count+'%</div>\
							</div>';
						});
					}
					$('.box_browser_pc').html(html);
					
					//移动端浏览器
					html='';
					if(data.msg.browser_all_charts[1]){
						$.each(data.msg.browser_all_charts[1], function(key, value){
							count=(value/browser_total[1]*100).toFixed(2);
							html+='<div class="browser_data">\
								<div class="browser_left">'+key+'</div>\
								<div class="browser_right"><div class="process" style="width:'+count+'%;"></div></div>\
								<div class="browser_percent">'+count+'%</div>\
							</div>';
						});
					}
					$('.box_browser_mobile').html(html);
				}
				
				//对比选项
				if(Time==-99){
					$('.compare').show();
					$('.box_data_list .compare_pv').html(data.msg.compare.total.pv);
					$('.box_data_list .compare_pv_img').removeClass('down up').addClass(data.msg.total.pv>=data.msg.compare.total.pv?'up':'down');
					$('.box_data_list .compare_average_pv').html(data.msg.compare.total.average_pv);
					$('.box_data_list .compare_average_pv_img').removeClass('down up').addClass(data.msg.total.average_pv>=data.msg.compare.total.average_pv?'up':'down');
					$('.box_data_list .compare_uv').html(data.msg.compare.total.uv);
					$('.box_data_list .compare_uv_img').removeClass('down up').addClass(data.msg.total.uv>=data.msg.compare.total.uv?'up':'down');
					$('.box_data_list .compare_ip').html(data.msg.compare.total.ip);
					$('.box_data_list .compare_ip_img').removeClass('down up').addClass(data.msg.total.ip>=data.msg.compare.total.ip?'up':'down');
				}else{
					$('.compare').hide();
				}
			}, 'json');
		});
	},
	
	country_init:function(){
		mta_obj.nav_condition(function(time_s, time_e, terminal, compare){
			var Time=$('.mta_menu .box_time a.current').attr('data-value'),
				par='do_action=mta.api_get_data&Action=ueeshop_analytics_get_visits_country_data&TimeS='+time_s+'&TimeE='+time_e+'&Terminal='+terminal+'&Compare='+compare,
				Data=new Object;
			$.post('./', par, function(data){
				//国家分布
				Data=new Object;
				Data['xAxis']={'categories': data.msg.line_charts.xAxis.categories};
				Data['series']=new Array;
				for(k in data.msg.line_charts.series){
					Data['series'][k]={'name':'PV', 'data':data.msg.line_charts.series[k].data, 'pointWidth':40};
				}
				frame_obj.highcharts_init.column_basic('country_charts', Data);
			}, 'json');
		});
	},
	
	referer_init:function(){
		mta_obj.nav_condition(function(time_s, time_e, terminal, compare){
			var lang=$('body').hasClass('en')?'en':'cn',
				Time=$('.mta_menu .box_time a.current').attr('data-value'),
				par='do_action=mta.api_get_data&Action=ueeshop_analytics_get_visits_referrer_data&TimeS='+time_s+'&TimeE='+time_e+'&Terminal='+terminal+'&Compare='+compare+'&lang='+lang,
				html='';
			$.post('./', par, function(data){
				//流量来源
				html='';
				$.each(data.msg.total, function(key, value){
					var title=value['title'];
					(key=='search_engine' || key=='share_platform') && (title='<a href="./?m=mta&a=referer&d=from&p='+key+'">'+title+'</a>');
					html+='<tr>\
						<td nowrap="nowrap" valign="top">'+title+'</td>\
						<td nowrap="nowrap">'+value['pv']+'<div class="compare compare_pv">0</div></td>\
						<td nowrap="nowrap">'+value['average_pv']+'<div class="compare compare_average_pv">0</div></td>\
						<td nowrap="nowrap">'+value['ip']+'<div class="compare compare_ip">0</div></td>\
						<td nowrap="nowrap">'+value['uv']+'<div class="compare compare_uv">0</div></td>\
					</tr>';
				});
				$('#visits_referrer_detail .data_table tbody').html(html);
				
				//来源网址
				var $urlObj=new Object, $urlData=new Array, $urlCount=0, i=0;
				html='';
				$.each(data.msg.detail.share_platform, function(key, value){
					$urlObj[value['title']]=0;
					$urlObj[value['title']]+=value['uv'];
				});
				$.each(data.msg.detail.search_engine, function(key, value){
					!$urlObj[value['title']] && ($urlObj[value['title']]=0);
					$urlObj[value['title']]+=value['uv'];
				});
				$.each(data.msg.detail.other, function(key, value){
					!$urlObj[value['title']] && ($urlObj[value['title']]=0);
					$urlObj[value['title']]+=value['uv'];
				});
				i=0;
				$.each($urlObj, function(key, value){
					$urlData[i]={'title':key, 'value':value};
					++i;
				});
				$urlData=$urlData.sort(function(a, b){
					return b.value - a.value;
				});
				$.each($urlData, function(key, value){
					if(key>9) return false;
					html+='<tr>\
						<td valign="top"><div class="title">'+value.title+'</div></td>\
						<td nowrap="nowrap"><div class="url_uv color_000">0%</div></td>\
						<td nowrap="nowrap"><div class="color_aaa">'+value.value+'</div></td>\
					</tr>';
					$urlCount+=value.value;
					++i;
				});
				$('.box_url_info tbody').html(html);
				html==''?$('.box_url_info .no_data').show():$('.box_url_info .no_data').hide();
				$.each($urlData, function(key, value){
					if(key>8) return false;
					$('.box_url_info tbody tr:eq('+key+') .url_uv').html((parseFloat(value.value)/$urlCount*100).toFixed(2)+'%');
				});
				
				if(Time==-99){
					$('.compare').show();
					$('#visits_referrer_detail .data_table tbody tr').each(function(index){
						var key=$(this).attr('data-key');
						var d=data.msg.compare.total[key];
						$(this).find('.compare_pv').html(d.pv);
						$(this).find('.compare_average_pv').html(d.average_pv);
						$(this).find('.compare_uv').html(d.uv);
						$(this).find('.compare_ip').html(d.ip);
					});
				}else{
					$('.compare').hide();
				}
			}, 'json');
		});
	},
	
	referer_from_init:function(){
		$('.mta_menu .item[data-value=-99]').hide();
		mta_obj.nav_condition(function(time_s, time_e, terminal, compare){
			var lang=$('body').hasClass('en')?'en':'cn',
				Time=$('.mta_menu .box_time a.current').attr('data-value'),
				par='do_action=mta.api_get_data&Action=ueeshop_analytics_get_visits_referrer_data&TimeS='+time_s+'&TimeE='+time_e+'&Terminal='+terminal+'&Compare='+compare+'&lang='+lang,
				html='';
			$.post('./', par, function(data){
				html='';
				var is_engine = type=='search_engine',
					pv_total = is_engine?data.msg.total.search_engine.pv:data.msg.total.share_platform.pv,
					detail_row = is_engine?data.msg.detail.search_engine:data.msg.detail.share_platform;
				$(".referer_detail .t h1").html(is_engine?data.msg.total.search_engine.title:data.msg.total.share_platform.title);
				$.each(detail_row, function(key, value){
					var percent=(parseFloat(value['pv'])/pv_total*100).toFixed(2);
					html+='<tr data-key="'+key+'">\
						<td valign="top">'+value['title']+'</td>\
						<td nowrap="nowrap">'+value['pv']+'</td>\
						<td nowrap="nowrap">'+value['average_pv']+'</td>\
						<td nowrap="nowrap">'+value['ip']+'</td>\
						<td nowrap="nowrap">'+value['uv']+'</td>\
						<td nowrap="nowrap" class="percent">'+percent+'%</td>\
					</tr>';
				});
				$('.r_con_table tbody').html(html);
				html==''?$('.no_data').show():$('.no_data').hide();
			}, 'json');
		});
	},
	
	referer_url_init:function(){
		$('.mta_menu .item[data-value=-99]').hide();
		mta_obj.nav_condition(function(time_s, time_e, terminal, compare){
			var lang=$('body').hasClass('en')?'en':'cn',
				Time=$('.mta_menu .box_time a.current').attr('data-value'),
				par='do_action=mta.api_get_data&Action=ueeshop_analytics_get_visits_referrer_data&TimeS='+time_s+'&TimeE='+time_e+'&Terminal='+terminal+'&Compare='+compare+'&lang='+lang,
				html='';
			$.post('./', par, function(data){
				html='';
				var $urlObj=new Object, $urlData=new Array, $urlCount=0, i=0;
				var $dataObj=new Object;
				html='';
				$.each(data.msg.detail.share_platform, function(key, value){
					$urlObj[value['title']]=0;
					$urlObj[value['title']]+=value['uv'];
					$dataObj[value['title']]=value;
				});
				$.each(data.msg.detail.search_engine, function(key, value){
					!$urlObj[value['title']] && ($urlObj[value['title']]=0);
					$urlObj[value['title']]+=value['uv'];
					$dataObj[value['title']]=value;
				});
				$.each(data.msg.detail.other, function(key, value){
					!$urlObj[value['title']] && ($urlObj[value['title']]=0);
					$urlObj[value['title']]+=value['uv'];
					$dataObj[value['title']]=value;
				});
				i=0;
				$.each($urlObj, function(key, value){
					$urlData[i]={'title':key, 'value':value};
					++i;
				});
				$urlData=$urlData.sort(function(a, b){
					return b.value - a.value;
				});
				$.each($urlData, function(key, value){
					html+='<tr>\
						<td valign="top"><div class="title">'+value.title+'</div></td>\
						<td nowrap="nowrap"><div class="XXX">'+$dataObj[value.title].pv+'</div></td>\
						<td nowrap="nowrap"><div class="XXX">'+$dataObj[value.title].average_pv+'</div></td>\
						<td nowrap="nowrap"><div class="XXX">'+$dataObj[value.title].ip+'</div></td>\
						<td nowrap="nowrap"><div class="XXX">'+$dataObj[value.title].uv+'</div></td>\
						<td nowrap="nowrap"><div class="url_uv color_000">0%</div></td>\
					</tr>';
					$urlCount+=value.value;
				});
				$('.r_con_table tbody').html(html);
				$.each($urlData, function(key, value){
					$('.r_con_table tbody tr:eq('+key+') .url_uv').html((parseFloat(value.value)/$urlCount*100).toFixed(2)+'%');
				});
				html==''?$('.no_data').show():$('.no_data').hide();
			}, 'json');
		});
	},
	
	nav_condition:function(callback, not_limit){
		if(not_limit){//不限制日期选择
			$('.pop_compared').find('input[name=TimeS], input[name=TimeE]').daterangepicker({
				timePicker: false,
				format: 'YYYY-MM-DD'
			});
		}else{//限制日期选择
			var mydate = new Date();
			var y = mydate.getFullYear();
			var m = mydate.getMonth()+1;
			var d = mydate.getDate();
			var maxD=y+'-'+m+'-'+d;
			var limitM=6;//限制只可以选择最近6个月
			if(m-limitM<1){
				y=y-1;
				m=m+12-limitM;
			}else{
				m=m-limitM;
			}
			var minD=y+'-'+m+'-'+d;
			
			$('.pop_compared').find('input[name=TimeS], input[name=TimeE]').daterangepicker({
				minDate: minD,
				maxDate: maxD,
				timePicker: false,
				format: 'YYYY-MM-DD'
			});
		}
		
		$('.mta_menu .item').click(function(){
			var $This=$(this),
				$Menu=$This.parents('.box_drop_down_menu');
			if($Menu.hasClass('box_terminal')){ //设备切换
				$Menu.find('.more>i').attr('class', $This.find('em').attr('class'));
			}else{ //其他
				$Menu.find('.more>span').html($This.html());
			}
			$This.addClass('current').siblings().removeClass('current');
			$Menu.find('.more_menu').removeAttr('style');
			if($Menu.hasClass('box_time')){
				if($This.attr('data-value')==-99 || $This.attr('data-value')==-100){ //自定义和对比时间
					$('.mta_menu .legend').show();
				}else{
					$('.mta_menu .legend').hide();
				}
			}
			if($Menu.hasClass('box_time') && ($This.attr('data-value')==-99 || $This.attr('data-value')==-100)){ //自定义和对比时间
				var $Obj=$('.pop_compared');
				frame_obj.pop_form($Obj, 0, 0);
				$Obj.find('.t h1').html($This.html());
				if($This.attr('data-value')==-100){
					$Obj.find('.unit_input font').hide();
					$Obj.find('.unit_input:eq(1)').hide();
					$('.mta_menu .legend .time_2 ').hide();
				}else{
					$Obj.find('.unit_input font').show();
					$Obj.find('.unit_input:eq(1)').show();
					$('.mta_menu .legend .time_2 ').show();
				}
			}else{
				mta_obj.nav_condition_callback(callback);
			}
		});
		
		$('#compared_form .btn_submit, #compared_form .btn_cancel').click(function(){
			var $Form=$('#compared_form'),
				$TimeS=$Form.find('input[name=TimeS]').val(),
				$TimeE=$Form.find('input[name=TimeE]').val();
			$('.mta_menu input[name=TimeS]').val($TimeS);
			$('.mta_menu input[name=TimeE]').val($TimeE);
			$('.mta_menu .legend .time_1').html($TimeS);
			$('.mta_menu .legend .time_2').html($TimeE);
			$('.pop_compared .t h2').click(); //关闭弹窗
			mta_obj.nav_condition_callback(callback);
			return false;
		});
		
		global_obj.win_alert_auto_close(lang_obj.global.loading, 'loading', -1);
		mta_obj.nav_condition_callback(callback);
		global_obj.win_alert_auto_close('', 'loading', 500, '', 0);
	},
	
	nav_condition_callback:function(callback){
		var compare		= 1,
			time_s		= $('.mta_menu input[name=TimeS]').val(),
			time_e		= $('.mta_menu input[name=TimeE]').val(),
			time		= $('.mta_menu .box_time a.current').attr('data-value'),
			terminal	= $('.mta_menu .box_terminal a.current').attr('data-value'),
			mta_method	= $('.mta_menu .mta_method a.cur').attr('rel'),
			mta_cycle	= $('.mta_menu .box_cycle a.current').attr('data-value');
		if(time>-99 || time==-100){ //不是对比选项
			time!=-100 && (time_s=time);
			time_e='';
			compare=0;
		}
		callback(time_s, time_e, terminal, compare, mta_method, mta_cycle);
	}
}