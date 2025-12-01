/*
 * 广州联雅网络
 */
(function ($){
	$(function (){
		var $lang = $('.home_menu .i .lang');
		$lang.on('tap', function (e){
			e.stopPropagation();
			$(this).toggleClass('on');
		});
		$('.list', $lang).on('tap', function (e){
			e.stopPropagation();
		});
		$('body').on('tap', function (){
			$lang.removeClass('on');
		});
		
	})
})(jQuery);