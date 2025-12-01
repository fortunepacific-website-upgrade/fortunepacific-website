/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

var filename = "ueditor.js";

// 根据相对路径获取绝对路径
function getPath(relativePath, absolutePath){
	var reg = new RegExp("\\.\\./","g");
	var upCount = 0; // 相对路径中返回上层的次数。
	var m = relativePath.match(reg);
	if(m) upCount = m.length;
	var lastIndex = absolutePath.length-1;
	for(var i=0;i<=upCount;i++){
		lastIndex = absolutePath.lastIndexOf("/",lastIndex);
	}
	return absolutePath.substr(0,lastIndex+1) + relativePath.replace(reg,"");
}

// 获取当前文件绝对路径
function getAbsolutePath() {
	var scripts = document.getElementsByTagName('script');
	var script = null;
	var len = scripts.length;
   
	for(var i = 0; i < scripts.length; i++) {
		if(scripts[i].src.indexOf(filename) != -1) {
			script = scripts[i];
			break;
		}
	}
	if(script) {
		var src = script.src;
		// 不是绝对路径需要修正
		if(src.indexOf("http://") != 0 && src.indexOf("/") != 0){
			var url = location.href;
			var index = url.indexOf("?");
			if(index != -1){
				url = url.substring(0, index-1);
			}
			src = getPath(src,url);
		}
		return src;
	}
	return null;
}

var ued_path = getAbsolutePath();
ued_path = ued_path.replace(filename, ''); 

document.write('<script type="text/javascript" charset="utf-8" src="' + ued_path + '/ueditor.all.min.js"></script>');
document.write('<script type="text/javascript" charset="utf-8" src="' + ued_path + '/lang/zh-cn/zh-cn.js"></script>');