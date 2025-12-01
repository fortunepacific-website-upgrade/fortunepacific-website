/*
 * 广州联雅网络
 */
(function ($){
	$(function (){
		$('.category_list .item .cate_1').on('tap', function (e){
			$(this).parent('.item').toggleClass('on');
		});
	});
})(jQuery);
