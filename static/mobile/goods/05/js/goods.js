/*
 * 广州联雅网络
 */

jQuery(function ($){
	$('.detail_desc .t').eq(0).addClass('on').next().show();
	$('.detail_desc .t').click(function(){
		$(this).toggleClass('on');
		$(this).next().toggle();
	});
});

