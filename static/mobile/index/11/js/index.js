/*
 * 广州联雅网络
 */
$(function(){
	
$(window).resize(function(){
	$('.picB .pic').height($('.picB .pic').width()*0.582);
	$('.picA').height($('.picB').height());
    $('.home_contact .contact').height($('.home_contact .contact').width()*0.854);
    $('.home_contact .con').each(function(){
        $(this).height($(this).find('.name').height()+$(this).find('.desc').outerHeight());
    });
});
$(window).resize();
});