/*
 * 广州联雅网络
 */
$(function(){

	$(window).resize(function(){
        $('.home_box .pic_box').height($('.home_box .pic_box').width());
        $('.home_news .pic_box').height($('.home_news .pic_box').width()*0.65);
        $('.picA .pict,.picA .picb').height($('.picA .pict,.picA .picb').width());
        $('.picB').height($('.picA').height());
    });
    $(window).resize();
});