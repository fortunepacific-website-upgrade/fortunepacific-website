/*
 * 广州联雅网络
 */
(function ($){
	$(function (){
		new Swipe(document.getElementById('banner_box'), {
			speed:500,
			auto:10000,
			callback: function(){}
		});
		
		var homebar = $('.homebar');
		var list = $('.homebar .list');
		var odiv = $('.homebar .list .c');
		var oitem = $('.item', odiv);
		var width = 1;
		var listW = list.width();
		var lbtn = $('.homebar .btn').eq(0);
		var rbtn = $('.homebar .btn').eq(1);
		oitem.each(function(index, element) {
			width+=Math.ceil($(element).width());
        });
		odiv.width(width);
		var t = '';
		touch_nav(odiv, width, listW);
		
		lbtn.on('tap', function (){
			var _move = parseFloat(odiv.css('margin-left'))+listW;
			if (_move>0){
				_move = 0;
			}
			odiv.animate({marginLeft:_move}, 300);
		});
		rbtn.on('tap', function (){
			var _move = parseFloat(odiv.css('margin-left'))-listW;
			if (width+_move<listW){
				_move = listW-width;
			}
			odiv.animate({marginLeft:_move}, 300);
		});
	});
})(jQuery);