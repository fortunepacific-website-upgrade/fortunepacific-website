<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

class action_module{
	public static function seo_output_module_category(){	//生成标题字段和分类名称的隐藏域(供SEO区域提取使用)
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$CateId=(int)$p_CateId;
		$m=$p_m;
		$a=$p_a;
		$d=$p_d;
		$lang_default=$c['manage']['language_default'];
		$data=array('result'=>'');
		if($CateId){
		    switch($a){
		        case 'page':$seo_category_table='article_category'; break;
		        case 'info':$seo_category_table='info_category'; break;
		        case 'case':$seo_category_table='case_category'; break;
		        case 'category':
		        case 'products':
		            $seo_category_table='products_category';
		        break;
		        case 'blog':$seo_category_table='blog_category'; break;
		    }
		    $seo_category_row=db::get_one($seo_category_table, "CateId='$CateId'", 'UId, CateId', 'MyOrder desc, CateId asc');
		}
		$not_category_page=(!in_array($a,array("blog","category")) && $d != "category_edit");
		if($not_category_page && $seo_category_row){
		    $seo_cate_arr=@explode(",",@str_replace("0,"," ",$seo_category_row['UId']).$seo_category_row['CateId']);
		    foreach($c['manage']['config']['Language'] as $k=>$v){
		        $seo_category_text="";
		        $c_count=count($seo_cate_arr);
		        for($i=0;$i<$c_count;$i++){
		            $this_name=db::get_value($seo_category_table,"CateId='{$seo_cate_arr[$i]}'","Category_".$v);
		            $seo_cate_arr[$i] && $seo_category_text .= $this_name;
		            $this_name && $i+1 != $c_count && $seo_category_text .= ",";
		        }
		        $data['result'] .= '<input type="hidden" class="seo_category_'.$v.'" value="'.$seo_category_text.'" />';
		    }
		}
		ly200::e_json($data, 1);
	}

	public static function seo_get_title(){
		@extract($_POST, EXTR_PREFIX_ALL, 'g');
		$g_title=str::str_code($g_title);
		$data=array();
		/*[相关关键词] [每月搜索量] [竞争激烈度]*/
		if($g_title){
			$result=manage::google_get_keyword_ideas($g_title);
			//print_r($result);
			if($result['ret']==1){
				$sort=array();
				foreach((array)$result['msg'] as $v){
					$data[]=array($v[0], (int)$v[1], $v[3]>=1?0:sprintf('%0.4f', $v[3]));
					$sort[]=(int)$v[1];
				}
				array_multisort($sort, SORT_DESC, $data);
			}
		}
		ly200::e_json($data, 1);
	}
	
	public static function seo_get_keywords(){
		@extract($_POST, EXTR_PREFIX_ALL, 'g');
		$g_Keyword=str::str_code($g_Keyword);
		ly200::e_json('', 1);
	}
	
	public static function seo_get_description(){
		global $c;
		$data=array();
		$desc_row=db::get_all('seo_description', 1, '*', 'DId desc');
		if($desc_row){
			foreach((array)$desc_row as $k=>$v){
				$data[$k]=array($v['Description_'.$c['manage']['language_default']],$v['DId']);
			}
		}
		ly200::e_json($data, 1);
	}
	
	public static function seo_description_check(){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$DId=(int)$p_DId;
		$desc_row=db::get_one('seo_description', "DId='$DId'");
		foreach($c['manage']['config']['Language'] as $k=>$v){
			/*$val=$desc_row['Description_'.$v];
			$pm=preg_match_all("/(\[)(.*)(\])+/U",$val,$match_arr);
			$data[$k]=$pm?str_replace($match_arr[0],"%s", $val):$val;*/
			$data[$k]=$desc_row['Description_'.$v];
		}
		ly200::e_json($data, 1);
	}

	public static function file_upload(){
		global $c;
		$size=$_GET['size']?$_GET['size']:$_POST['size'];
		if($size=='file_upload'){//文件上传
			$status=array('status'=>-1);
			if($filepath=file::file_upload($_FILES['Filedata'], $c['tmp_dir'].'file/')){
				$name=substr($_FILES['Filedata']['name'], 0, strrpos($_FILES['Filedata']['name'], '.'));
				$status['files'][0]=array(
					'name'			=>	$name,
					'size'			=>	$FileData['size'],
					'type'			=>	$FileData['type'],
					'url'			=>	$filepath,
					'thumbnailUrl'	=>	$filepath,
					'deleteUrl'		=>	'',
					'deleteType'	=>	'DELETE'
				);
			}
			exit(str::json_data($status));
		}else{//图片上传
			$file_size = $_FILES["Filedata"]["size"];
			$file_size > 2097152 && exit(str::json_data(array("files"=>array(0=>array(
				'name'	=>	$_FILES['Filedata']['name'],
				'error'	=>	"file2big"
			)))));
			
			$resize_ary=$c['manage']['resize_ary'];
			$is_water=0;
			if($c['manage']['is_watermark_pro'] && $size=='editor') $is_water=1;
			exit(file::file_upload_plugin($c['tmp_dir'].'photo/', $resize_ary, true, $is_water));//暂时把图片都保存到临时文件夹里
		}
	}

	public static function file_upload_plugin(){
		global $c;
		$type_ary=array('image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'image/bmp', 'image/ico');
		$_type=$_FILES['Filedata']['type'];
		if(!in_array($_type, $type_ary)){
			$_GET['size']='file_upload';
		}
		if($_GET['size']=='photo'){ //图片银行
			exit(file::file_upload_plugin($c['tmp_dir'].'photo/', '', false));
		}else{
			self::file_upload();
		}
	}

	public static function file_upload_ckeditor(){
		global $c;
		file::file_upload_ckeditor($c['manage']['upload_dir'].'file/');
	}

	public static function file_del(){	//删除单个图片
		global $c;
		@extract($_GET, EXTR_PREFIX_ALL, 'g');
		if(is_file($c['root_path'].$g_PicPath)){
			if(is_file($c['root_path'].$g_PicPath.".120x120.{$ext_name}")){//检查是否带有图片管理的缩略图
				file::del_file($g_PicPath.".120x120.{$ext_name}");
			}
			file::del_file($g_PicPath);
		}
		ly200::e_json('', 1);
	}

	public static function file_clear_cache(){//清空tmp/cache缓存
		global $c;
		$temp=$c['tmp_dir'].'cache/';
		$dir=$c['root_path'].ltrim($temp, '/');
		$handle=opendir($dir);
		while($file=readdir($handle)){
			if($file!='.' && $file!='..'){
				if(is_dir($dir.$file)) file::del_dir($dir.$file);
			}
		}
		closedir($handle);
		ly200::e_json('', 1);
	}

	public static function translation(){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		!(int)$c['FunVersion'] && ly200::e_json(manage::language('{/error.no_permit/}'));
		$target=array();
		foreach($p_language as $k=>$v){
			$v=ary::ary_format($v, 1);
			foreach($v as $v1){
				$target[$v1][]=$k;
			}
		}
		$translation=array();
		foreach($target as $k=>$v){
			$text=array();
			foreach($v as $v1){
				$text[$v1]=stripslashes($p_text[$v1]);
			}
			$result=manage::google_translation($text, $k);
			implode($result['msg'])=='' && $result['ret']=0;
			$translation[$k]=$result;
		}
		ly200::e_json($translation, 1);
	}
	
	public static function translation_get_chars(){	//翻译剩余的字符数
		global $c;
		!(int)$c['FunVersion'] && ly200::e_json(manage::language('{/error.no_permit/}'));
		$result=ly200::api(array('Action'=>'ueeshop_web_get_translation_chars'), $c['ApiKey'], $c['sync_url']);
		ly200::e_json(sprintf(manage::get_language('global.translation_chars'), '<font class="fc_red">'.(int)$result['msg'].'</font>'), $result['ret']);
	}
}
?>