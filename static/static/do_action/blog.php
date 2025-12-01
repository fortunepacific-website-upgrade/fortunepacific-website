<?php 
/*博客提交*/
class blog_module{
	public static function blog_review(){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		
		$AId = (int)$p_AId;
		$Name = $p_Name;
		$Email = $p_Email;
		$Content = $p_Content;
		$data=array(
			'AId'			=>	$AId,//博客ID
			'Name'			=>	$Name,
			'Email'			=>	$Email,
			'Content'		=>	$Content,
			'AccTime'		=>	$c['time'],
			'Praise'		=>	0,
		);
		
		db::insert('blog_review', $data);
		ly200::e_json('Submit Success', 1);
	}
	
	public static function blog_praise(){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$type = (int)$p_type?1:-1;
		$RId = (int)$p_RId;
		!isset($_SESSION['blog_praise']) && $_SESSION['blog_praise']=array();//用SESSION记录是否重复点赞
		if (!in_array($RId, $_SESSION['blog_praise'])){
			db::query("UPDATE `blog_review` SET `Praise`=`Praise`+{$type} WHERE RId='{$RId}'");
			$_SESSION['blog_praise'][] = $RId;
			//返回记录数
			ly200::e_json(db::get_value('blog_review', "RId='{$RId}'", 'Praise'), 1);
		}else{
			ly200::e_json('You have been praised', 0);
		}
	}
}