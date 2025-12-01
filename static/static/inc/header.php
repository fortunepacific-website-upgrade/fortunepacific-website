<?php !isset($c) && exit();?>
<script type="text/javascript">
$(window).resize(function(){$(window).webDisplay(<?=$c['config']['global']['WebDisplay']?>);});
$(window).webDisplay(<?=$c['config']['global']['WebDisplay']?>);
<?php if($c['config']['global']['IsCopy']){?>
	var omitformtags=["input","textarea", "select"];//过滤掉的标签
	omitformtags=omitformtags.join("|")
	function disableselect(e){
		var e=e || event;//IE 中可以直接使用 event 对象 ,FF e
		var obj=e.srcElement ? e.srcElement : e.target;//在 IE 中 srcElement 表示产生事件的源,FF 中则是 target
		if(omitformtags.indexOf(obj.tagName.toLowerCase())==-1){
			if(e.srcElement) document.onselectstart=new Function ("return false");//IE
			return false;
		}else{
			if(e.srcElement) document.onselectstart=new Function ("return true");//IE
			return true;  
		} 
	}
	function reEnable(){
		return true
	}
	document.onmousedown=disableselect;//按下鼠标上的设备(左键,右键,滚轮……)
	document.onmouseup=reEnable;//设备弹起
	document.oncontextmenu=new Function("event.returnValue=false;");
	document.onselectstart=new Function("event.returnValue=false;");
	document.oncontextmenu=function(e){return false;};//屏蔽鼠标右键
<?php }?>
</script>