<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791 
*/

return array(
	'external_links'=>	'外部链接',
	'page'			=>	array(
							'is_feedback'		=>	'开启留言',
							'category_del_notes'=>	'内置分类不允许删除'
						),
	'info'			=>	array(
							'is_index'			=>	'首页显示'
						),
	'partner'		=>	array(
							'url'				=>	'链接地址'
						),
	'case'			=>	array(
							'attribute'			=>	'属性',
							'is_hot'			=>	'热门',
							'is_index'			=>	'首页显示',
							'number'			=>	'编号',
							'children'			=>	'隶属分类'
						),
	'download'		=>	array(
							'download'			=>	'下载',
							'file'				=>	'文件',
							'is_member'			=>	'是否会员可见',
							'external_link'		=>	'第三方链接',
							'is_external_link'	=>	'是否第三方链接',
							'link_notes'		=>	'开启后可在文件路径填写其他网站链接，例如：网盘',
							'filepath'			=>	'文件路径',
							'download_password'	=>	'下载密码'
						),
	'blog'			=>	array(
							'blog'				=>	array(
														'is_hot'	=>	'热门博客',
														'author'	=>	'作者',
														'tag'		=>	'标签',
														'tag_notes'	=>	'多个标签用 <span class=\'fc_red\'>|</span> 线隔开',
													),
							'set'				=>	array(
														'title'		=>	'博客标题',
														'nav'		=>	'导航',
														'link'		=>	'链接',
														'ad'		=>	'广告图'
													),
							'review'			=>	array(
														'is_reply'	=>	'已回复',
														'manager'	=>	'管理员',
														'entry'		=>	'请输入...',
														'reply'		=>	'回复',
													)
						),
	'photo'			=>	array(
							'photo_type'		=>	array(	//键名与$c['manage']['photo_type']的配置对应
														'products'	=>	'系统产品图',
														'editor'	=>	'编辑器图',
														'case'		=>	'系统案例图',
														'other'		=>	'其他系统图'
													),
							'category'			=>	'文件夹',
							'select_index'		=>	'--请选择或填写--',
							'move_bat'			=>	'批量移动',
							'children'			=>	'隶属分类'
						)
);
?>