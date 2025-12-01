<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

$c['manage']['language']=array(
	'global'	=>	array(
						'n_y'				=>	array('No', 'Yes'),
						'my_order_ary'		=>	array(0=>'Default')+range(0, 50)+array(-1=>'Last'),
						'my_order'			=>	'Ranking',
						'add'				=>	'Add',
						'edit'				=>	'Edit',
						'edit_success'		=>	'Edit Success',
						'del'				=>	'Delete',
						'more'				=>	'More',
						'other'				=>	'Other',
						'set'				=>	'Set',
						'date'				=>	'Date',
						'time'				=>	'Time',
						'edit_time'			=>	'Modify time',
						'submit'			=>	'Submit',
						'confirm'			=>	'Confirm',
						'save'				=>	'Save',
						'save_success'		=>	'Saved Success',
						'return'			=>	'Back',
						'cancel'			=>	'Cancel',
						'close'				=>	'Close',
						'close_success'		=>	'Close Success',
						'all'				=>	'All',
						'serial'			=>	'No.',
						'name'				=>	'Name',
						'title'				=>	'Title',
						'contents'			=>	'Contents',
						'operation'			=>	'Operate',
						'category'			=>	'Category',
						'sub_category'		=>	'Subclassification',
						'option'			=>	'Options',
						'search'			=>	'Search',
						'explode'			=>	'Export',
						'view'				=>	'View',
						'move'				=>	'Move',
						'used'				=>	'Start',
						'required'			=>	'Not Null',
						'select_all'		=>	'Select all',
						'un_select_all'		=>	'Deselect all',
						'open'				=>	'Open',
						'open_success'		=>	'Open Success',
						'pack_up'			=>	'Collect',
						'pic'				=>	'Picture',
						'ip'				=>	'IP',
						'email'				=>	'Email',
						'logo'				=>	'Logo',
						'id'				=>	'Id',
						'description'		=>	'Description',
						'brief_description'	=>	'Brief description',
						'pre_page'			=>	'<< Page Up',
						'next_page'			=>	'Page Down >>',
						'upload_pic'		=>	'Upload Photo',
						'pic_size_notes'	=>	'%s pixels of the picture is preferred',
						'pic_size_tips'		=>	'Photo size suggestion: ',
						'upload_file'		=>	'Upload file',
						'select_index'		=>	'--Select--',
						'do_error'			=>	'Invalid Operation',
						'sensitive_word'	=> 	'With sensitive words:',
						'sub_success'		=>	'Submitted successfully',
						'base_info'			=>	'Base information',
						'translation'		=>	'Translation',
						'translation_chars'	=>	'%s characters remaining',
						'language'			=>	'Language',
						'help'				=>	'Help Center',
						'welfare'			=>	'User Welfare',
						'seo'				=>	array(
													'seo'				=>	'SEO',
													'title'				=>	'Title',
													'keyword'			=>	'Keywords',
													'description'		=>	'Description',
													'custom_url'		=>	'Custom Address',
													'custom_url_notes'	=>	'SEO fill in rules<br /><br />
																			Title<br />
																			Display in the top corner of the browser and search for the headline of the first result in Google<br />
																			Suggestion:fill in the sentence consisting of 2-3 keywords<br /><br />
																			Keyword<br />
																			Not showing on webpage,but visible in the code<br />
																			Suggestion:Current product name + first and secondary category name<br /><br />
																			Description<br />
																			Brief description of the page,two lines of black small characters displayed in Google search results<br />
																			Suggestion:a fixed sentence with two inserted keywords<br />',
													'title_build'		=>	'Intelligent word selection',
													'keyword_build'		=>	'Build keyword',
													'desc_build'		=>	'Build description',
												    'desc_templet'		=>	'Description templet',
													'search'			=>	'Search',
													'related'			=>	'Related Keywords',
													'search_amount'		=>	'Monthly Searches',
													'compete'			=>	'Competitive intensity',
													'add'				=>	'Add to title',
													'search_notes'		=>	'Please fill query keyword'
												)
					),
	'module'	=>	array(
						'account'			=>	array(
													'module_name'		=>	'My Account',
													'index'				=>	'Home',
													'password'			=>	'Change Password'
												),
						'inquiry'			=>	array(
													'module_name'		=>	'Inquiry',
													'inquiry'			=>	'Inquiry',
													'feedback'			=>	'Feedback',
													'review'			=>	'Review',
													'newsletter'		=>	'Subscription'
												),
						'products'			=>	array(
													'module_name'		=>	'Products',
													'products'			=>	'Products',
													'attribute'			=>	'Attributes',
													'category'			=>	'Category',
													'upload'			=>	'Batch Upload',
													'watermark'			=>	'Batch Watermark'
												),
						'content'			=>	array(
													'module_name'		=>	'Contents',
														'page'				=>	array(
																				'module_name'	=>	'Single page',
																				'list'			=>	'Single page list',
																				'category'		=>	'Category'
																			),
													'info'				=>	array(
																				'module_name'	=>	'News',
																				'list'			=>	'News list',
																				'category'		=>	'Category'
																			),
													'partner'			=>	'Friend Links',
													'case'				=>	array(
																				'module_name'	=>	'Case',
																				'list'			=>	'Case list',
																				'category'		=>	'Category'
																			),
													'download'			=>	array(
																				'module_name'	=>	'Download',
																				'list'			=>	'Download list',
																				'category'		=>	'Category'
																			),
													'blog'				=>	array(
																				'module_name'	=>	'Blog',
																				'blog'			=>	'Blog',
																				'set'			=>	'Setting',
																				'category'		=>	'Category',
																				'review'		=>	'Comments'
																			),
													'photo'				=>	array(
																				'module_name'	=>	'Photo',
																				'list'			=>	'Photo list',
																				'category'		=>	'Category'
																			)
												),
						'seo'				=>	array(
													'module_name'		=>	'SEO',
													'overview'			=>	'SEO overview',
													'keyword'			=>	'Keyword management',
													'keyword_track'		=>	'Keyword tracking',
													'article'			=>	'In-site optimization',
													'mobile'			=>	'Mobile optimization',
													'links'				=>	'Link optimization',
													'blog'				=>	'Blog optimization',
													'ads'				=>	'Business publish',
													'sitemap'			=>	'Sitemap',
													'description'		=>	'Description management',
												),
						'mta'				=>	array(
													'module_name'		=>	'MTA',
													'visits'			=>	'Views',
													'country'			=>	'Regional source',
													'referer'			=>	'Traffic source'
												),
						'user'				=>	array(
													'module_name'		=>	'Member',
													'user'				=>	'Member',
													'permit'			=>	'Member permission',
													'reg_set'			=>	'Registration parameters',
													'add'				=>	'Add member'
												),
						'service'			=>	array(
													'module_name'		=>	'Customer service',
													'chat'				=>	'Customer service'
												),
						'email'				=>	array(
													'module_name'		=>	'Email',
													'send'				=>	'Email sending',
													'config'			=>	'Email setting',
													'logs'				=>	'Send log'
												),
						'set'				=>	array(
													'module_name'		=>	'Setting',
													'config'			=>	'Basic settings',
													'themes'			=>	'Template setting',
													'nav'				=>	array(
																				'module_name'	=>	'Navigation Settings',
																				'top'			=>	'Top navigation',
																				'head'			=>	'Header navigation',
																				'foot'			=>	'Footer navigation'
																			),
													'index_page'		=>	'Default Page Contents',
													'country'			=>	'Countries and Regions',
													'third_party_code'	=>	'Third-party Code',
													'manage'			=>	'Administrator',
													'manage_logs'		=>	'System Logs'
												)
					),
	'language'	=>	array(
						'en'				=>	'English',
						'jp'				=>	'Japanese',
						'de'				=>	'German',
						'fr'				=>	'French',
						'es'				=>	'Spanish',
						'ru'				=>	'Russian',
						'cn'				=>	'Chinese',
						'pt'				=>	'Portuguese',
						'cn'				=>	'Chinese'
					),
	'frame'		=>	array(
						'system_name'		=>	'Foreign Trade System',
						'edit_password'		=>	'Change password',
						'logout'			=>	'Exit'
					),
	'error'		=>	array(
						'no_data'			=>	'No data',
						'no_table_data'		=>	'There is currently no data',
						'add_now'			=>	'Add Now',
						'supplement_lang'	=>	'Please fill in the language version!',
						'no_permit'			=>	'You don\'t have permission to do this',
						'operating_illegal'	=>	'Do not operate illegally'
					)
);
?>