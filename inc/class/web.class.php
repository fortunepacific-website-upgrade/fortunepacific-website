<?php
/*
Powered by ueeshop.com		http://www.ueeshop.com
广州联雅网络科技有限公司		020-83226791
*/

class web{
	public static function logo(){//输出网站logo
		global $c;
		if ($_GET['m']=='goods' || $_GET['m']=='info-detail' || $_GET['m']=='article'){//文章、单页、产品详细输出div
			echo '<div class="logo fl pic_box"><a href="/"><img src="'.$c['config']['global']['LogoPath'].'" alt="'.$c['config']['global']['SiteName'].'" /><em></em></a></div>';
		}else{//其他页面输出h1标签
			echo '<h1 class="logo fl pic_box"><a href="/"><img src="'.$c['config']['global']['LogoPath'].'" alt="'.$c['config']['global']['SiteName'].'" /><em></em></a></h1>';
		}
	}
	
	public static function get_domain($protocol=1){	//获取网站域名
		return ($protocol==1?((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on')?'https://':'http://'):'').$_SERVER['HTTP_HOST'].(($_SERVER['SERVER_PORT']!=80 && $_SERVER['SERVER_PORT']!=443)?':'.$_SERVER['SERVER_PORT']:'');
	}
	
	public static function get_sub_domain(){	//返回网站的二级域名列表
		global $c;
		return array_merge(array('www', 'm'), array_keys($c['lang_name']));
	}
	
	public static function get_cache_path($theme='', $root=1){	//生成缓存文件路径【$theme：风格，$root：1 绝对路径，0 相对路径】
		global $c;
		return ($root?$c['root_path']:'')."{$c['tmp_dir']}cache/".(($theme && $theme!='THEMES')?$theme:$c['themes'])."/{$c['lang']}/";
	}
	
	public static function get_web_position($row, $table, $lang='en', $char=' &gt; '){	//面包屑地址
		global $c;
		$str='';
		$UId=trim($row['UId'], ',');
		$UId=='0' && $str.=$char."<a class='po_cur' href='".web::get_url($row, $table)."'>{$row['Category_'.$lang]}</a>";  
		if($UId){
			$all_row=str::str_code(db::get_all($table, "CateId in($UId)", '*', $c['my_order'].'Dept asc'));	
			$i=0;
			foreach((array)$all_row as $v){
				$str.=($i==0?$char:'')."<a href='".web::get_url($v, $table)."'>{$v['Category_'.$lang]}</a>".$char;
				$i+=1;
			}
			$str.="<a class='po_cur' href='".web::get_url($row, $table)."'>{$row['Category_'.$lang]}</a>";
		}
		return $str;
	}
	
	public static function get_theme_file($themeFile){	//获取当前风格/inc/文件夹下的文件，如果文件不存在，获取对应/inc/lib/global/文件夹下的文件
		global $c;
		if($themeFile=='404.php'){
			@header('HTTP/1.1 404');
		}else{
			$filename=$c['theme_path'].'inc/'.$themeFile;
			$file=@is_file($filename)?$filename:"{$c['static_path']}inc/global/{$themeFile}";
			@is_file($file)?include($file):'';
		}
	}
	
	public static function get_query_string($str){	//重新组织伪静态参数
		$query_ary=@explode('&', trim($str, '?'));
		$query_string='';
		foreach((array)$query_ary as $k=>$v){
			$v=trim($v);
			if($v=='' || $v=='='){continue;}
			$query_string.="&{$v}";
		}
		return $query_string;
	}
	
	public static function get_url($row, $field='products_category'){	//生成页面地址
		global $c;
		$ary=@explode('_', $field);
		$length=count($ary);
		if($ary[0]=='article' && $length==1){
			$path=str::str_to_url($row['Title'.$c['lang']]);
			!$path && $path='article';
			$surl='/art/'.$path.'-a0'.sprintf('%04d', $row['AId']).'a1.html';
			$url=$row['PageUrl']?('/art/'.$row['PageUrl']):$surl;
			$url=$row['Url']?$row['Url']:$url;
		}elseif($ary[0]=='info' && $length==1){
			$path=str::str_to_url($row['Title'.$c['lang']]);
			$path=$row['PageUrl'] ? $row['PageUrl']:str::str_to_url($row['Title'.$c['lang']]);
			!$path && $path='news';
			$url='/info/'.$path.'-i0'.sprintf('%04d', $row['InfoId']).'i1.html';
			$url=$row['Url']?$row['Url']:$url;
		}elseif($ary[0]=='info' && $ary[1]=='category'){
			$path=str::str_to_url($row['Category'.$c['lang']]);
			!$path && $path='list';
			$url='/info/'.$path.'_c'.sprintf('%04d', $row['CateId']);
		}elseif($ary[0]=='case' && $length==1){
			$path=str::str_to_url($row['Name'.$c['lang']]);
			$path=$row['PageUrl'] ? $row['PageUrl']:str::str_to_url($row['Name'.$c['lang']]);
			!$path && $path='case';
			$url='/case/'.$path.'-c0'.sprintf('%04d', $row['CaseId']).'c1.html';
			$url=$row['Url']?$row['Url']:$url;
		}elseif($ary[0]=='case' && $ary[1]=='category'){
			$path=str::str_to_url($row['Category'.$c['lang']]);
			!$path && $path='list';
			$url='/case/'.$path.'_c'.sprintf('%04d', $row['CateId']);
		}elseif($ary[0]=='download' && $ary[1]=='category'){
			$path=str::str_to_url($row['Category'.$c['lang']]);
			!$path && $path='list';
			$url='/download/'.$path.'_c'.sprintf('%04d', $row['CateId']);
		}elseif($ary[0]=='products' && $length==1){
			$path=$row['PageUrl'] ? $row['PageUrl']:str::str_to_url($row['Name'.$c['lang']]);
			!$path && $path='products';
			$url='/'.$path.'-p0'.sprintf('%04d', $row['ProId']).'p1.html';
		}elseif($ary[0]=='products' && $ary[1]=='inquiry'){
			$path=str::str_to_url($row['Name'.$c['lang']]);
			!$path && $path='products';
			$url='/inquiry-'.$path.'-p0'.sprintf('%04d', $row['ProId']).'p1.html';
		}elseif($ary[0]=='products' && $ary[1]=='category'){
			$path=str::str_to_url($row['Category'.$c['lang']]);
			!$path && $path='list';
			$url='/c/'.$path.'_'.sprintf('%04d', $row['CateId']);
		}elseif($ary[0]=='blog' && $length==1){
			$path=str::str_to_url($row['Title']);
			$url='/blog/'.$path.'_b'.sprintf('%04d', $row['AId']).'.html';
		}elseif($ary[0]=='blog' && $ary[1]=='category'){
			$path=str::str_to_url($row['Category_en']);
			$url='/blog/c/'.$path.'_'.sprintf('%04d', $row['CateId']);
		}else{
			$url_ary=array(
				'page'				=>	"/?a=article&AId={$row['AId']}",
				'info'				=>	"/?a=info&InfoId={$row['InfoId']}",
				'products_category'	=>	"/?a=products&CateId={$row['CateId']}",
				'products'			=>	"/?a=goods&ProId={$row['ProId']}",
				'blog'				=>	"/?m=blog&p=detail&AId={$row['AId']}",
			);
			$url=$url_ary[$field];			
		}
		return $url;
	}
	
	public static function foot_share(){
		global $c;
		$res='<div class="share foot_share">';
		$row = $c['config']['global']['Contact'];
		$contact_row_type=array('Google','Twitter','YouTube','Pinterest','Facebook','LinkedIn','Instagram');
		foreach((array)$contact_row_type as $k=>$v){
			$url = $row[$v];
			if($url){
				$res.='<a href="'.$url.'" target="_blank" class="foot_share_box '.$v.'"></a>';
			}
		}
		$res.='</div>';
		
		return $res;
	}
	
	public static function powered_by($type=0){	//技术支持 0:带链接、1:隐藏、2:不带链接
		global $c;
		if($type==0){
			return '';
		}elseif($type==2){
			return 'POWERED BY UEESHOP';
		}else{
			return '<a href="http://www.ueeshop.com" target="_blank">POWERED BY UEESHOP</a>';
		}
	}
	
	public static function output_third_code(){	//输出第三方代码
		global $c;
		/*
		$str="<script type='text/javascript' src='{$c['analytics']}?Number={$c['Number']}'></script>";
		*/
		$str='';
		($_GET['m']=='user' && $_GET['a']=='register') && $str='';//注册页面去掉统计代码，Google把注册页面统计代码当木马了
		$where='IsUsed=1 and IsMeta=0';
		$where.=(web::is_mobile_client(1)?' and CodeType in(0,2)':' and CodeType in(0,1)');
		$third_row=db::get_all('third', $where, '*', 'TId desc');
		foreach((array)$third_row as $v) $str.=$v['Code'];		
		return $str!=''?'<div align="center">'.$str.'</div>':'';
	}
	
	public static function load_cdn_contents($html=''){
		global $c;
		exit($html);
	}
	
	public static function seo_meta($row='', $spare_row=''){	//前台页面输出标题标签
		global $c;
		$lang=$c['lang'];
		$home_row=str::str_code(db::get_one('meta', "Type='home'"));
		$SeoTitle=$row['SeoTitle'.$lang]?$row['SeoTitle'.$lang]:$spare_row['SeoTitle'];
		$SeoKeywords=$row['SeoKeyword'.$lang]?$row['SeoKeyword'.$lang]:$spare_row['SeoKeyword'];
		$SeoDescription=$row['SeoDescription'.$lang]?$row['SeoDescription'.$lang]:$spare_row['SeoDescription'];
		if(!$SeoTitle && !$SeoKeywords && !$SeoDescription){
			$SeoTitle=$home_row['SeoTitle'.$lang]?$home_row['SeoTitle'.$lang]:$c['config']['global']['SiteName'];
			$SeoKeywords=$home_row['SeoKeyword'.$lang]?$home_row['SeoKeyword'.$lang]:$c['config']['global']['SiteName'];
			$SeoDescription=$home_row['SeoDescription'.$lang]?$home_row['SeoDescription'.$lang]:$c['config']['global']['SiteName'];
		}
		$copyCode=(int)$c['config']['global']['IsCopy']?'<script type="text/javascript">document.oncontextmenu=new Function("event.returnValue=false;");document.onselectstart=new Function("event.returnValue=false;");</script>':'';	//防复制
		$str='';
		$where='IsUsed=1 and IsMeta=1';
		$where.=(web::is_mobile_client(1)?' and CodeType in(0,2)':' and CodeType in(0,1)');
		$third_row=db::get_all('third', $where, '*', 'TId desc');	//自定义Meta代码
		foreach((array)$third_row as $v) $str.=$v['Code'];
		if ($_GET['m']=='goods'){//产品详细页分享插件引用的图片
			global $products_row;
			$img_info =  getimagesize($c['root_path'].img::get_small_img($products_row['PicPath_0'], '240x240'));
			$str.='<meta property="og:title" content="'.htmlspecialchars($products_row['Name'.$c['lang']]).'"/><meta property="og:type" content="product"/><meta property="og:image" content="'.web::get_domain().img::get_small_img($products_row['PicPath_0'], '240x240').'"/><meta property="og:image:width" content="'.$img_info[0].'"/><meta property="og:image:height" content="'.$img_info[1].'"/>';
		}
		return "{$str}<link rel='shortcut icon' href='{$c['config']['global']['IcoPath']}' />\r\n<meta name=\"keywords\" content=\"$SeoKeywords\" />\r\n<meta name=\"description\" content=\"$SeoDescription\" />\r\n<title>$SeoTitle</title>\r\n".$copyCode;
	}
	
	public static function lock_china_ip(){
		global $c;
		if(web::isCrawler() || web::checkrobot()){return false;}//蜘蛛爬虫
		if($_SESSION['Manage']['UserName']){return false;}//已登录后台，则跳过检测
		if((int)$c['config']['global']['IsIP'] && $_SESSION['Ueeshop']['Ip']!='' && $_SESSION['Ueeshop']['Ip']==ly200::get_ip() && (int)$_SESSION['Ueeshop']['LockChinaIp']){return true;}
		$_SESSION['Ueeshop']['Ip']=ly200::get_ip();
		$_SESSION['Ueeshop']['LockChinaIp']=0;
		
		if((int)$c['config']['global']['IsIP']){
			$ChinaProvince="中国/北京/浙江/天津/安徽/上海/福建/重庆/江西/山东/河南/内蒙古/湖北/新疆维吾尔/湖南/宁夏回族/广东/西藏/海南/广西壮族/四川/河北/贵州/山西/云南/辽宁/陕西/吉林/甘肃/黑龙江/青海/江苏";
			$IpArea=ly200::ip(ly200::get_ip());
			if(substr_count($_SERVER['PHP_SELF'], '/manage/')==0 && substr_count($ChinaProvince, substr($IpArea, 0, 6))>0){
				$_SESSION['Ueeshop']['LockChinaIp']=1;
				return true;
			}
		}
		return false;
	}
	
	public static function lock_china_browser(){
		global $c;
		if(web::isCrawler() || web::checkrobot()){return false;}//蜘蛛爬虫
		if($_SESSION['Manage']['UserName']){return false;}//已登录后台，则跳过检测

		if((int)$c['config']['global']['IsChineseBrowser'] && strstr(strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']), 'zh-cn')){//简体中文版浏览器
			return true;
		}
		return false;
	}
	
	public static function close_website(){
		global $c;
		if($_SESSION['Manage']['UserName']){return false;}//已登录后台，则跳过检测
		return (int)$c['config']['global']['IsCloseWeb']?true:false;
	}
	
	public static function is_mobile_client($type=0){	//是否用手机访问($type 1：电脑允许打开手机版，0：只允许手机打开手机版)
		global $c;
		$is_mobile_client=0;
		if(!$c['is_responsive'] && !$c['config']['global']['IsOpenMobileVersion']){return $is_mobile_client;}
		if($type && (int)substr_count(web::get_domain(), '://m.') && preg_match('/^m\.(.*)/', $_SERVER['HTTP_HOST'], $host_match)){
			$is_mobile_client=1;
		}else{
			if(@stripos($_SERVER['HTTP_USER_AGENT'], 'ipad')){//iPad
				$is_mobile_client=0;
			}else{//其他移动端
				$phone_client_agent_array=array('240x320','acer','acoon','acs-','abacho','ahong','airness','alcatel','amoi','android','anywhereyougo.com','applewebkit/525','applewebkit/532','asus','audio','au-mic','avantogo','becker','benq','bilbo','bird','blackberry','blazer','bleu','cdm-','compal','coolpad','danger','dbtel','dopod','elaine','eric','etouch','fly ','fly_','fly-','go.web','goodaccess','gradiente','grundig','haier','hedy','hitachi','htc','huawei','hutchison','inno','ipaq','ipod','jbrowser','kddi','kgt','kwc','lenovo','lg ','lg2','lg3','lg4','lg5','lg7','lg8','lg9','lg-','lge-','lge9','longcos','maemo','mercator','meridian','micromax','midp','mini','mitsu','mmm','mmp','mobi','mot-','moto','nec-','netfront','newgen','nexian','nf-browser','nintendo','nitro','nokia','nook','novarra','obigo','palm','panasonic','pantech','philips','phone','pg-','playstation','pocket','pt-','qc-','qtek','rover','sagem','sama','samu','sanyo','samsung','sch-','scooter','sec-','sendo','sgh-','sharp','siemens','sie-','softbank','sony','spice','sprint','spv','symbian','tablet','talkabout','tcl-','teleca','telit','tianyu','tim-','toshiba','tsm','up.browser','utec','utstar','verykool','virgin','vk-','voda','voxtel','vx','wap','wellco','wig browser','wii','windows ce','wireless','xda','xde','zte','mobile');
				foreach($phone_client_agent_array as $v){
					if(@stripos($_SERVER['HTTP_USER_AGENT'], $v)){
						$is_mobile_client=1;
						break;
					}
				}
				unset($phone_client_agent_array);
			}
		}
		return $is_mobile_client;
	}

	/**********************过滤搜索引擎蜘蛛爬虫(start)************************/
	public static function isCrawler(){ 
		$agent=@strtolower($_SERVER['HTTP_USER_AGENT']); 
		if(!empty($agent)) { 
			$spiderSite=array("TencentTraveler", "Baiduspider+", "BaiduGame", "Googlebot", "msnbot", "Sosospider+", "Sogou web spider", "ia_archiver", "Yahoo! Slurp", "YoudaoBot", "Yahoo Slurp", "MSNBot", "Java (Often spam bot)", "BaiDuSpider", "Voila", "Yandex bot", "BSpider", "twiceler", "Sogou Spider", "Speedy Spider", "Google AdSense", "Heritrix", "Python-urllib", "Alexa (IA Archiver)", "Ask", "Exabot", "Custo", "OutfoxBot/YodaoBot", "yacy", "SurveyBot", "legs", "lwp-trivial", "Nutch", "StackRambler", "The web archive (IA Archiver)", "Perl tool", "MJ12bot", "Netcraft", "MSIECrawler", "WGet tools", "larbin", "Fish search", "Google Page Speed Insights"); 
			foreach($spiderSite as $val){ 
				$str=@strtolower($val); 
				if(@strpos($agent, $str)!==false){return true;} 
			} 
		}else{ 
			return false; 
		} 
	} 
	
	public static function checkrobot($useragent=''){//Discuz判断蜘蛛爬虫方法
		static $kw_spiders = array('bot', 'crawl', 'spider' ,'slurp', 'sohu-search', 'lycos', 'robozilla');
		static $kw_browsers = array('msie', 'netscape', 'opera', 'konqueror', 'mozilla');
	 
		$useragent = @strtolower(empty($useragent) ? $_SERVER['HTTP_USER_AGENT'] : $useragent);
		if(@strpos($useragent, 'http://')===false && web::dstrpos($useragent, $kw_browsers)) return false;
		if(web::dstrpos($useragent, $kw_spiders)) return true;
		return false;
	}
	
	public static function dstrpos($string, $arr, $returnvalue=false) {
		if(empty($string)) return false;
		foreach((array)$arr as $v){
			if(strpos($string, $v)!== false){
				$return = $returnvalue ? $v : true;
				return $return;
			}
		}
		return false;
	}
	/**********************过滤搜索引擎蜘蛛爬虫(end)************************/
}
?>