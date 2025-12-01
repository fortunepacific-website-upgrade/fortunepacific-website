/*
 * 广州联雅网络
 */

jQuery(function ($){
	(function (){
		//小图拨动
		var goods_small_pic = $('.goods_small_pic');
		var win_w =$(window).width()>=640?640:$(window).width();
		var pic_w = win_w*(130/640);
		var mar_w = win_w*(15/640);
		var pic = $('.goods_small_pic .pic');
		var list = $('.goods_small_pic .list');
		pic.css({'height':pic_w, 'width':pic_w, 'margin-left':mar_w, 'margin-right':mar_w});
		goods_small_pic.css('display', 'block');
		var listW = Math.ceil(pic.outerWidth(true))*pic.length;
		list.width(listW);
		touch_nav(list, listW, win_w);
	})();
	
	$('.detail_desc .t').eq(0).addClass('on').next().show();
	$('.detail_desc .t').click(function(){
		$(this).toggleClass('on');
		$(this).next().toggle();
	});
	//切换图片
	(function (){
		//切换图片
		var goods_pic = $('.goods_pic');
		var olist = $('.goods_pic ul');
		var oitem = $('li', olist);
		var pic = $('img', oitem);
		var oitemLen = oitem.length;
		var boxW = goods_pic.width();
		var small_pic = $('.goods_small_pic .pic');
        olist.css({'width':boxW*oitemLen, 'display':'block'});
		oitem.css('width', boxW);
        
		//执行
		if (oitemLen>1){
			//********** 拨动切换 **************
			var startX = 0;
			var endX = 0;
			var disX = 0;//偏移量
			var basicX = boxW*0.15;//偏移量小于此值时还原
			var i = 0;
			var startML = 0;
			var str = '';
			var startPos = {};
			var MovePos = {};
			var isScrolling = 0;
			olist.get(0).ontouchstart = function (e){
				startX = e.touches[0].pageX;
				this.style.MozTransitionDuration = this.style.webkitTransitionDuration = 0;
				
				startPos = {x:e.touches[0].pageX,y:e.touches[0].pageY,time:+new Date};
				isScrolling = 0;
				
			};
			olist.get(0).ontouchmove = function (e){
				goods_pic.css('background-image', 'none');
				if(e.targetTouches.length > 1 || e.scale && e.scale !== 1) return;
				MovePos = {x:e.touches[0].pageX - startPos.x,y:e.touches[0].pageY - startPos.y};
				isScrolling = Math.abs(MovePos.x) < Math.abs(MovePos.y) ? 1:0;
				if(isScrolling==0){
					e.preventDefault();
					disX = e.touches[0].pageX-startX;
					startML = -i*boxW;
					this.style.MozTransform = this.style.webkitTransform = 'translate3d(' + (startML+disX) + 'px,0,0)';
					this.style.msTransform = this.style.OTransform = 'translateX(' + (startML+disX) + 'px)';
				}
				
			};
			olist.get(0).ontouchend = function (e){
				var _x = Math.abs(disX);
				if (_x>=basicX){
					if (disX>0){//右移
						i--;
						if (i<0){
							i = 0;
						}
					}else{//左移
						i++;
						if (i>=oitemLen){
							i = oitemLen-1;
						}
					}
				}
				small_pic.eq(i).addClass('on').siblings('.pic').removeClass('on');
				this.style.MozTransitionDuration = this.style.webkitTransitionDuration = '0.3s';
				this.style.MozTransform = this.style.webkitTransform = 'translate3d(' + -(i*boxW) + 'px,0,0)';
				this.style.msTransform = this.style.OTransform = 'translateX(' + -(i*boxW) + 'px)';
				startX = disX = _x = 0;
			};
			//*********** 拨动切换 结束 ***********
			//*********** 点击切换 **********
			
			small_pic.on('tap', function (e){
				i = small_pic.index(this);
				small_pic.eq(i).addClass('on').siblings('.pic').removeClass('on');
				olist.get(0).style.MozTransitionDuration = olist.get(0).style.webkitTransitionDuration = '0.3s';
				olist.get(0).style.MozTransform = olist.get(0).style.webkitTransform = 'translate3d(' + -(i*boxW) + 'px,0,0)';
				olist.get(0).style.msTransform = olist.get(0).style.OTransform = 'translateX(' + -(i*boxW) + 'px)';
			});
		}//执行 end
	})()
	
});

