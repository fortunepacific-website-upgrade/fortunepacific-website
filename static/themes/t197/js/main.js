/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/
$(function(){
	showthis('#d_products .dm .nav','#d_products .db_contents',0,'cur');
	$('#d_products .dm .nav').click(function(){
		showthis('#d_products .dm .nav','#d_products .db_contents',$(this).index(),'cur');
	});
	$("#banner .slideNum_1 .hd").hide();
	$(window).on('load', function(){
		$("#banner .slideNum_1 .hd").css("left","80%");	
		$("#banner .slideNum_1 .hd").show();
	});
	$(window).resize(function(){
		setTimeout(function(){
			$("#banner .slideNum_1 .hd").css("left","80%");		
		},50);	
	});
	nav("#nav .wrap","#nav .tem");
	$('#lib_review_form h1').hide();
	$('.review_t').html($('#lib_review_form h1').html());	
})
function small_pic_move(box, list, spaceW, type){//spaceW 移入多少范围开始执行
	var tips = 0;//左，上1 右，下2 其他0
	var Tid = '';
	var speed = 60;
	
	if (type==1){
		var boxW = box.width();
		var listW = list.outerWidth(true);
		var property = 'margin-left';
	}else{
		var boxW = box.height();
		var listW = $(list).outerHeight(true);
		var property = 'margin-top';
	}
	var xy = 0;
	box.mousemove(function(e) {
		xy = type==1 ? (e.pageX-$(this).offset().left) : (e.pageY-$(this).offset().top);
		if (xy<spaceW){//左边
			if (tips!=1){
				tips = 1;
				Tid = setInterval(function (){
					if (parseInt(list.css(property))<0){
						list.css(property, '+=2');
					}else{
						clearInterval(Tid);
					}
				}, speed);
			}
		}else if (xy>boxW-spaceW){//右边
			if (tips!=2){
				tips = 2;
				Tid = setInterval(function (){
					if (parseInt(list.css(property))>boxW-listW){
						list.css(property, '-=2');
					}else{
						clearInterval(Tid);
					}
				}, speed);
			}
		}else{
			if (tips!=0){
				tips = 0;
				clearInterval(Tid);
			}
		}
	});
	box.mouseleave(function (){
		clearInterval(Tid);
		tips = 0;
	});
}
