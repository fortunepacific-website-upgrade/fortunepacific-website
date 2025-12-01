<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

return array(
	'config'		=>	array(
							'basis'				=>	array(
														'basis'					=>	'Base setting',
														'site_name'				=>	'Website Name',
														'ico'					=>	'Icon',
														'web_display'			=>	'Website Display',
														'web_display_ary'		=>	array('Adaptive screen','Narrow screen','Widescreen'),
														'is_footer_feedback'	=>	'Open the bottom of the message',
														'products_search_tips'	=>	'Product search tips',
														'copyright'				=>	'Copy right',
														'blog_copyright'		=>	'Blog Copy right',
													),
							'switch'			=>	array(
														'switch'				=>	'Switch button',
														'shield_ip'				=>	'Shield Internal IP',
														'shield_ip_notes'		=>	'After opening,blocked Chinese IP',
														'shield_browser'		=>	'Shield Chinese Browser',
														'shield_browser_notes'	=>	'After opening, intercept access to Chinese browsers ',
														'open_inquiry'			=>	'Whether to open inquiry function',
														'cannot_copy'			=>	'Copy Protection',
														'cannot_copy_notes'		=>	'After opening,shielding mouse right key and blocked webpages saving',
														'prompt_steps'			=>	'Prompt Steps',
														'301'					=>	'HTTP 301 Redirect',
														'product_open_new'		=>	'Product new window opens',
														'case_open_new'			=>	'Case new window opens',
														'info_open_new'			=>	'News new window opens',
														'close_web'				=>	'Close Website',
														'cdn'					=>	'Enable CDN',
														'cdn_notes'				=>	'After opening, the website static resources enable CDN global acceleration, static resources use [ueeshop.ly200-cdn.com] domain name',
														'mobile_version'		=>	'Open mobile web site',
														'open_review'			=>	'Open Review',
														'open_review_notes'		=>	'After opening,show review module in product detail.',
														'open_review_verify'	=>	'Open review verify?'
													),
							'language'			=>	array(
														'language'				=>	'Language Settings',
														'browser_language'		=>	'Browser language',
														'browser_language_notes'=>	'Automatically recognize the browser language and switch the language version',
														'english_manage'		=>	'English manage',
														'flag'					=>	'Flag',
														'default_language'		=>	'Website Default Language',
														'close_all_notes'		=>	'Please select at least one language version',
														'cur_lang_colse_notes'	=>	'The current language is the default language of the website and cannot be closed directly.',
														'choose_count_notes'	=>	'You can only select up to %s language versions!'
													),
							'google_translate'	=>	array(
														'google_translate'		=>	'Google translate'
													),
							'inquiry'			=>	array(
														'fixed'					=>	'【Fixed system can not be changed】',
														'inquiry'				=>	'Inquiry setting',
														'inquiry_btn_color'		=>	'Inquiry button color',
														'inquiry_field'			=>	array(
																						'FirstName'		=>	'First Name',
																						'LastName'		=>	'Last Name',
																						'Email'			=>	'Email',
																						'Address'		=>	'Address',
																						'City'			=>	'City',
																						'State'			=>	'State',
																						'Country'		=>	'Country',
																						'PostalCode'	=>	'Postal Code',
																						'Phone'			=>	'Phone',
																						'Fax'			=>	'Fax',
																						'Subject'		=>	'Subject',
																						'Message'		=>	'Message',
																					),
														'feedback'				=>	'Feedback setting',
														'feedback_field'		=>	array(
																						'Fullname'		=>	'Name',
																						'Company'		=>	'Company',
																						'Phone'			=>	'Phone',
																						'Mobile'		=>	'Mobile',
																						'Email'			=>	'Email',
																						'Subject'		=>	'Subject',
																						'Message'		=>	'Message'
																					),
														'newsletter'			=>	'Subscription setting',
														'newsletter_field'		=>	array(
																						'seconds'		=>	'Seconds',
																						'tips'			=>	'Waiting corresponding seconds when enter website'
																					),
														'feedback_set'			=>	'Feedback custom colum',
														'custom_events'			=>	'custom colum',
														'type'					=>	'type',
														'type_list'				=>	array('multi-line text box', 'Input box'),
														'is_notnull'			=>	'is required'
													),
							'contact'			=>	array(
														'contact'				=>	'Contact Setting',
														'company'				=>	'Company',
														'email'					=>	'Email',
														'tel'					=>	'Phone',
														'fax'					=>	'Fax',
														'address'				=>	'Address',
														'contact_us'			=>	'Contact us',
														'contact_us_notes'		=>	'Such as：‘/index.html’',
														'home_page'				=>	'Hone link',
														'home_page_notes'		=>	'A single page link,Such as：‘/art/contact-us-2.html’',
													),
							'product'			=>	array(
														'product'				=>	'Product setting',
														'show_price'			=>	'Whether to open the product price',
														'show_price_notes'		=>	'Can control whether the user to open the price attributes and display',
														'share'					=>	'Social platform sharing',
														'share_notes'			=>	'Product details page with shared components, can be shared to the world\'s leading social platform such as:Facebook、Twitter、Google、Pinterest.',
														'inq_type'				=>	'Whether a single product inquiry',
														'inq_type_notes'		=>	'Control the type of product inquiry, select "ON" to adjust the product inquiry for a single product inquiry',
														'member'				=>	'Whether the price is visible only to members',
														'member_notes'			=>	'Control the price is only visible members, if opened, then log in to see',
														'pdf'					=>	'Generate PDF format',
														'pdf_notes'				=>	'Product details page for a product so that customers generate PDF format files, easy to spread.',
														'manage_myorder'		=>	'Products backstage sort display',
														'manage_myorder_notes'	=>	'Off by default, product management backstage to sort the list of added time display; When checked, will be set up to sort the product to sort is displayed.',
														'currency_symbol'		=>	'Currency symbol'
													),
							'user'				=>	array(
														'user'					=>	'Member setting',
														'is_open'				=>	'Open member function?',
														'verify'				=>	'Member verify',
														'email_verify'			=>	'Register email verify',
														'reg_page_notes'		=>	'Register page tips',
														'fixed'					=>	'【Fixed system can not be changed】',
														'custom_field'			=>	'custom field',
														'field_type'			=>	'Type',
														'field_type_ary'		=>	array('Textbox', 'Checkbox'),
														'field_option'			=>	'Option',
														'field_option_notes'	=>	'Tips:Each Row Each Option',
														'reg_field_set'			=>	'Default settings',
														'reg_field'				=>	array(
																						'Email'			=>	'Email',
																						'Name'			=>	'Name',
																						'Gender'		=>	'Gender',
																						'Age'			=>	'Age',
																						'NickName'		=>	'NickName',
																						'Telephone'		=>	'Telephone',
																						'Fax'			=>	'Fax',
																						'Birthday'		=>	'Birthday',
																						'Facebook'		=>	'Facebook',
																						'Company'		=>	'Company',
																					)
													),
							'watermark'			=>	array(
														'watermark'				=>	'Watermark Settings',
														'is_watermark'			=>	'Open Watermark Added',
														'alpha'					=>	'Watermark Transparency of the Picture',
														'alpha_notes'			=>	'(Parameter Invalid When Watermark to PNG)',
														'position'				=>	'Watermark Position',
														'position_ary'			=>	array('','Top is Left-set','Top is Middle-set','Top is Right-set','Middle Part is Left-set','Middle Part is Middle-set','Middle Part is Right-set','Bottom is Left-set','Bottom is Middle-set','Bottom is Right-set'),
														'upload_file'			=>	'Upload Watermark'
													),
							'share'				=>	array(
														'share'					=>	'Social media',
													)
						),
	'themes'		=>	array(
							'device'			=>	array('PC', 'Mobile'),
							'menu'				=>	array(
														'index_set'				=>	'Home setting',
														'nav'					=>	'Navigation',
														'footer_nav'			=>	'Bottom Columns',
														'toper_nav'				=>	'Top navigation',
														'themes'				=>	'Themes',
														'home_themes'			=>	'Home themes',
														'list_themes'			=>	'List themes',
														'header_set'			=>	'Navigation Settings',
														'footer_set'			=>	'Bottom Columns Settings',
														'ad'					=>	'Advertising',
													),
							'nav'				=>	array(
														'page_type_ary'			=>	array('Single page', 'Products'),
														'custom'				=>	'Custom',
														'url'					=>	'Link',
														'down'					=>	'SlideDown',
														'down_width'			=>	'SlideDown width',
														'down_width_ary'		=>	array('small', 'middle', 'big'),
														'new_target'			=>	'Open in window'
													),
							'themes'			=>	array(
														'use'					=>	'Use',
														'preview'				=>	'Demonstration',
														'use_fail_notes'		=>	'Your version does not support this themes.',
														'themes_download_fail'	=>	'Sorry, the themes file download failed!'
													),
							'ad'				=>	array(
														'show_type'				=>	'Display mode',
														'show_type_ary'			=>	array('Default', 'Fade in', 'Rolling upwards', 'Rolling leftwards'),
														'pic'					=>	'Advertising photo',
														'description'			=>	'Brief description',
														'url'					=>	'Link',
														'page'					=>	array(
																						'index'		=>	'Home',
																						'products'	=>	'products',
																						'case'		=>	'case',
																						'article'	=>	'article',
																						'news'		=>	'news',
																						'download'	=>	'download',
																						'feedback'	=>	'feedback',
																						'page'		=>	'page',
																					)
													),
							'header_set'		=>	array(
														'icon_color'			=>	'Icon',
														'icon_color_ary'		=>	array('White', 'grey', 'Pink'),
														'bg_color'				=>	'Background color',
														'fixed'					=>	'fixed'
													),
							'footer_set'		=>	array(
														'preview'				=>	'Preview',
														'font_family'			=>	'font Example',
														'bg_color'				=>	'Background color',
														'nav'					=>	'navigation',
														'url'					=>	'Link'
													)
						),
	'country'		=>	array(
							'country'			=>	'Countries and Regions',
							'acronym'			=>	'Abbreviation',
							'continent'			=>	'Continent',
							'continent_ary'		=>	array('Asia', 'Europe', 'Africa', 'North America', 'Antarctica', 'Oceania', 'Antarctica')
						),
	'third_party_code'=>	array(
							'code'				=>	'code content',
							'code_type'			=>	'Type',
							'code_type_ary'		=>	array('PC and Mobile', 'PC', 'Mobile'),
							'meta_notes'		=>	'Default is close; After opening this code is disposed between the <head> tag.',
							'is_meta'			=>	'Meta Code',
							'used_notes'		=>	'Default is open; cancel “open” and this code will be ineffective'
						),
	'manage'		=>	array(
							'username'			=>	'Name',
							'group'				=>	'Group',
							'group_ary'			=>	array(1=>'Super administrator',2=>'General administrator'),
							'last_login_time'	=>	'Last Login Time',
							'last_login_ip'		=>	'Last Login IP',
							'locked'			=>	'Entry Inhibited',
							'create_time'		=>	'Creation Time',
							'password_un_mod'	=>	'Password cannot be changed if space is left',
							'password'			=>	'Password',
							'confirm_password'	=>	'Confirm Password',
							'permit'			=>	'Privilege',
							'len_notes'			=>	'Sorry, user’s name and password’s length must be more than six digits!',
							'password_len_notes'=>	'Sorry, the length of password must be more than six digits!',
							'manage_exists'		=>	'Sorry, this username has been occupied, please change to another one!',
							'del_current_user'	=>	'Not allowed to delete the currently logged in user',
						),
	'manage_logs'	=>	array(
							'username'			=>	'User name',
							'module'			=>	'Function Module',
							'log_contents'		=>	'Log Contents',
							'ip'				=>	'IP Address',
							'ip_from'			=>	'Source of IP Address'
						)
);
?>