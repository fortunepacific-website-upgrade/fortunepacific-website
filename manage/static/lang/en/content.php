<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

return array(
	'external_links'=>	'External Link',
	'page'			=>	array(
							'is_feedback'		=>	'Is Feedback',
							'category_del_notes'=>	'Built-in classification does not allow deletion'
						),
	'info'			=>	array(
							'is_index'			=>	'Home Page'
						),
	'partner'		=>	array(
							'url'				=>	'Link'
						),
	'case'			=>	array(
							'attribute'			=>	'Attribute',
							'is_hot'			=>	'Hot',
							'is_index'			=>	'Home Page',
							'number'			=>	'Serial Number',
							'children'			=>	'Type of Subordination'
						),
	'download'		=>	array(
							'download'			=>	'Download',
							'file'				=>	'File',
							'is_member'			=>	'Only Member',
							'external_link'		=>	'External Link',
							'is_external_link'	=>	'Are third-party links',
							'link_notes'		=>	'After opening the website can fill in the other links in the file path, such as: NetDisc',
							'filepath'			=>	'Or File Path',
							'download_password'	=>	'Download password'
						),
	'blog'			=>	array(
							'blog'				=>	array(
														'is_hot'	=>	'Popular Blogs',
														'author'	=>	'Author',
														'tag'		=>	'Labels',
														'tag_notes'	=>	'Separate the multiple tags with <span class=\'fc_red\'>|</span>',
													),
							'set'				=>	array(
														'title'		=>	'Blog Title',
														'nav'		=>	'Navigation',
														'link'		=>	'Link',
														'ad'		=>	'Advertising Picture'
													),
							'review'			=>	array(
														'is_reply'	=>	'Replied',
														'manager'	=>	'Administrator',
														'entry'		=>	'please enter...',
														'reply'		=>	'Reply',
													)
						),
	'photo'			=>	array(
							'photo_type'		=>	array(	//键名与$c['manage']['photo_type']的配置对应
														'products'	=>	'System Product Images',
														'editor'	=>	'Editor Images',
														'case'		=>	'System Case Images',
														'other'		=>	'Other System Images'
													),
							'category'			=>	'File',
							'select_index'		=>	'--Please select or fill--',
							'move_bat'			=>	'Batch move',
							'children'			=>	'Class of Category'
						)
);
?>