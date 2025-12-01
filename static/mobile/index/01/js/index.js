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
		//导航
		/*var hnav = $('.hnav');
		var list = $('.hnav .list');
		var child = $('.hnav .list .item');
		var lW = 0;
		var win_w = $(window).width()>=640?640:$(window).width();
		child.each(function(index, element) {
			lW += Math.ceil($(element).outerWidth(true));
        });
		
		touch_nav(list, lW, win_w);*/
		
	})
})(jQuery);