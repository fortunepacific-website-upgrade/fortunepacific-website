/*
 * 广州联雅网络
 */
(function ($){
	$(function (){
		var ospan = $('.banner .btn span');
		new Swipe(document.getElementById('banner_box'), {
			speed:500,
			auto:10000,
			callback: function(){
				ospan.removeClass("on").eq(this.index).addClass("on");
			}
		});
		
		$('.home_menu .lower').on('tap', function (){
			$(this).toggleClass('on');
		});
		
		$('.home_menu .lower a').on('tap', function (e){
			e.stopPropagation();
		});
		
	})
})(jQuery);