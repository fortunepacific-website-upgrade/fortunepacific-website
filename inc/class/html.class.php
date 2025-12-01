<?php
/*
Powered by ueeshop.com		http://www.ueeshop.com
广州联雅网络科技有限公司		020-83226791
*/

class html{
	public static function btn_checkbox($name, $value='', $class=''){	//后台勾选按钮
		$html='';
		$html.='<div class="btn_checkbox '.$class.'">';
			$html.='<em class="button"></em>';
			$html.='<input type="checkbox" name="'.$name.'" value="'.$value.'" />';
		$html.='</div>';
		return $html;
	}
	
	public static function no_table_data($is_add=0, $add_url='javascript:;'){	//后台内页表格空白提示
		global $c;
		$html='';
		$html.=	'<div class="bg_no_table_data">';
		$html.=		'<div class="content">';
		$html.=			'<p class="color_000">{/error.no_table_data/}</p>';
		$html.=			($is_add==1?'<a href="'.$add_url.'" class="btn_global btn_add_item">{/global.add/}</a>':'');
		$html.=		'</div>';
		$html.=	'</div>';
		return $html;
	}
	
	public static function form_select($data, $name, $selected_value='', $field='', $key='', $index=0, $attr=''){	//生成下拉表单
		$select="<select name='$name' $attr>".($index?"<option value=''>$index</option>":'');
		foreach((array)$data as $k=>$v){
			$value=$key!=''?$v[$key]:$k;
			$selected=($selected_value!='' && $value==$selected_value)?'selected':'';
			$text=$field!=''?$v[$field]:$v;
			$select.="<option value='{$value}' $selected>{$text}</option>";
		}
		$select.='</select>';
		return $select;
	}
	
	public static function turn_page($row_count, $page, $total_pages, $page_string, $base_page=3){	//后台翻页按钮
		if(!$row_count){return;}
		$start=$page-$base_page>0?$page-$base_page:1;
		$end=$page+$base_page>=$total_pages?$total_pages:$page+$base_page;
		($total_pages-$page)<$base_page && $start=$start-($base_page-($total_pages-$page));
		$page<=$base_page && $end=$end+($base_page-$page+1);
		$start<1 && $start=1;
		$end>=$total_pages && $end=$total_pages;
		$pre=$page-1>0?$page-1:1;
		$html='';
		$html.='<div class="turn_page">';
			$html.='<div class="total_count">共 '.$row_count.'条</div>';
			$html.='<ul class="page">';
				if($page<=1){
					$html.='<li class="page_first"><span class="page_item page_noclick"><em class="icon_page_prev"></em></span></li>';
				}else{
					$html.='<li class="page_first"><a href="'.$page_string.$pre.'" class="page_item page_button"><em class="icon_page_prev"></em>'.$pre_page.'</a></li>';
				}
				$start>1 && $html.='<li><a href="'.$page_string.'1'.'" class="page_item">1</a></li><li><span class="page_omitted">...</span></li>';
				for($i=$start; $i<=$end; $i++){
					$html.=$page!=$i?'<li><a href="'.$page_string.$i.'" class="page_item">'.$i.'</a></li>':'<li><span class="page_item page_item_current">'.$i.'</span></li>';
				}
				$end<$total_pages && $html.='<li><span class="page_omitted">...</span></li><li><a href="'.$page_string.$total_pages.'" class="page_item">'.$total_pages.'</a></li>';
				$next=$page+1>$total_pages?$total_pages:$page+1;
				if($page+1>$total_pages){
					$html.='<li class="page_last"><span class="page_item page_noclick"><em class="icon_page_next"></em></span></li>';
				}else{
					$page>=$total_pages && $page--;
					$html.='<li class="page_last"><a href="'.$page_string.$next.'" class="page_item page_button"><em class="icon_page_next"></em></a></li>';
				}
			$html.='</ul>';
		$html.='</div>';
		return $html;
	}
	
	public static function turn_page_html($row_count, $page, $total_pages, $query_string, $pre_page='<<', $next_page='>>', $base_page=3, $link_ext_str='.html', $html=1){	//翻页
		if(!$row_count){return;}
		if($html==1){
			$url_ary=@explode('/', trim($_SERVER['REQUEST_URI'], '/'));
			$url='/';
			foreach((array)$url_ary as $k=>$v){
				if($k==count($url_ary)-1){
					$p=@explode('?', $v);
					$v=$p[0];
				}
				if(substr_count($v, $link_ext_str)){break;}
				$url.=$v.'/';
			}
			$page_string=str_replace('//', '/', $url);
			($query_string!='' && $query_string!='?') && $query_string='?'.web::get_query_string($query_string);
		}else{
			$page_string=$query_string;
			$link_ext_str=$query_string='';
		}
		$i_start=$page-$base_page>0?$page-$base_page:1;
		$i_end=$page+$base_page>=$total_pages?$total_pages:$page+$base_page;
		($total_pages-$page)<$base_page && $i_start=$i_start-($base_page-($total_pages-$page));
		$page<=$base_page && $i_end=$i_end+($base_page-$page+1);
		$i_start<1 && $i_start=1;
		$i_end>=$total_pages && $i_end=$total_pages;
		$turn_page_str='';
		$pre=$page-1>0?$page-1:1;
		$turn_page_str.=($page<=1)?"<span><font class='page_noclick'><em class='icon_page_prev'></em>$pre_page</font></span>":"<span><a href='{$page_string}{$pre}{$link_ext_str}{$query_string}' class='page_button'><em class='icon_page_prev'></em>$pre_page</a></span>";
		$i_start>1 && $turn_page_str.="<span><a href='{$page_string}1{$link_ext_str}{$query_string}' class='page_item'>1</a></span><span><font class='page_item'>...</font></span>";
		for($i=$i_start; $i<=$i_end; $i++){
			$turn_page_str.=$page!=$i?"<span><a href='{$page_string}{$i}{$link_ext_str}{$query_string}' class='page_item'>$i</a></span>":"<span><font class='page_item_current'>$i</font></span>";
		}
		$i_end<$total_pages && $turn_page_str.="<span><font class='page_item'>...</font></span><span><a href='{$page_string}{$total_pages}{$link_ext_str}{$query_string}' class='page_item'>$total_pages</a></span>";
		$next=$page+1>$total_pages?$total_pages:$page+1;
		if($page+1>$total_pages){
			$turn_page_str.="<span class='page_last'><font class='page_noclick'>$next_page<em class='icon_page_next'></em></font></span>";
		}else{
			$page>=$total_pages && $page--;
			$turn_page_str.="<span class='page_last'><a href='{$page_string}{$next}{$link_ext_str}{$query_string}' class='page_button'>$next_page<em class='icon_page_next'></em></a></span>";
		}
		return $turn_page_str;
	}
}
?>