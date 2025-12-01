<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

return array(
	'config'		=>	array(
							'basis'				=>	array(
														'basis'					=>	'基本设置',
														'site_name'				=>	'网站名称',
														'ico'					=>	'Ico图标',
														'web_display'			=>	'前端显示',
														'web_display_ary'		=>	array('自适应','窄屏','宽屏'),
														'is_footer_feedback'	=>	'开启底部留言',
														'products_search_tips'	=>	'产品搜索提示语',
														'copyright'				=>	'版权信息',
														'blog_copyright'		=>	'博客版权信息',
													),
							'switch'			=>	array(
														'switch'				=>	'快捷开关',
														'shield_ip'				=>	'屏蔽国内IP',
														'shield_ip_notes'		=>	'开启后，系统将拦截国内IP的访问源',
														'shield_browser'		=>	'屏蔽中文浏览器',
														'shield_browser_notes'	=>	'开启后，系统将拦截简体中文版浏览器的访问源',
														'open_inquiry'			=>	'是否开启询盘功能',
														'cannot_copy'			=>	'防止复制',
														'cannot_copy_notes'		=>	'开启后，将屏蔽右键与屏蔽网页另存为',
														'prompt_steps'			=>	'提示步骤',
														'301'					=>	'301重定向',
														'product_open_new'		=>	'产品新窗口打开',
														'case_open_new'			=>	'案例新窗口打开',
														'info_open_new'			=>	'新闻新窗口打开',
														'close_web'				=>	'关闭网站',
														'cdn'					=>	'启用CDN',
														'cdn_notes'				=>	'开启后，网站静态资源启用CDN全球加速，静态资源使用【ueeshop.ly200-cdn.com】域名',
														'mobile_version'		=>	'开启手机版网站',
														'open_review'			=>	'是否开启评论功能',
														'open_review_notes'		=>	'开启后，产品详细页下方出现评论模块',
														'open_review_verify'	=>	'是否开启评论审核'
													),
							'language'			=>	array(
														'language'				=>	'语言设置',
														'browser_language'		=>	'浏览器切换语言',
														'browser_language_notes'=>	'根据浏览器语言自动识别，并切换语言版本',
														'english_manage'		=>	'英文版后台',
														'flag'					=>	'国旗',
														'default_language'		=>	'网站默认语言',
														'close_all_notes'		=>	'请至少选择一个语言版本',
														'cur_lang_colse_notes'	=>	'当前语言为网站默认语言，不能直接关闭',
														'choose_count_notes'	=>	'你最多只能选择%s个语言版本！'
													),
							'google_translate'	=>	array(
														'google_translate'		=>	'Google翻译'
													),
							'inquiry'			=>	array(
														'fixed'					=>	'【系统固定不能更改】',
														'inquiry'				=>	'询盘设置',
														'inquiry_btn_color'		=>	'询盘按钮颜色',
														'inquiry_field'			=>	array(
																						'FirstName'		=>	'姓',
																						'LastName'		=>	'名',
																						'Email'			=>	'邮箱',
																						'Address'		=>	'地址',
																						'City'			=>	'城市',
																						'State'			=>	'省份',
																						'Country'		=>	'国家',
																						'PostalCode'	=>	'邮编',
																						'Phone'			=>	'电话',
																						'Fax'			=>	'传真',
																						'Subject'		=>	'主题',
																						'Message'		=>	'内容',
																					),
														'feedback'				=>	'在线留言设置',
														'feedback_field'		=>	array(
																						'Fullname'		=>	'姓名',
																						'Company'		=>	'公司',
																						'Phone'			=>	'电话',
																						'Mobile'		=>	'手机',
																						'Email'			=>	'邮箱',
																						'Subject'		=>	'主题',
																						'Message'		=>	'内容'
																					),
														'feedback_set'			=>	'留言自定义字段',
														'custom_events'	=>	'自定义字段',
														'type'			=>	'类型',
														'type_list'		=>	array('多行文本框', '单行文本框'),
														'is_notnull'	=>	'是否必填'
													),
							'contact'			=>	array(
														'contact'				=>	'联系方式设置',
														'company'				=>	'公司名称',
														'email'					=>	'邮箱',
														'tel'					=>	'电话',
														'fax'					=>	'传真',
														'address'				=>	'地址',
														'contact_us'			=>	'联系我们',
														'contact_us_notes'		=>	'如：‘/index.html’',
														'home_page'				=>	'首页链接',
														'home_page_notes'		=>	'一般为单页链接，如：‘/art/contact-us-2.html’',
													),
							'product'			=>	array(
														'product'				=>	'产品设置',
														'show_price'			=>	'是否开启产品价格',
														'show_price_notes'		=>	'可控制用户是否开启价格属性以及显示',
														'share'					=>	'社交平台分享',
														'share_notes'			=>	'产品详细页带有分享组件,可分享到全球知名的社交平台如Facebook、Twitter、Google、Pinterest等.',
														'inq_type'				=>	'是否单产品询盘',
														'inq_type_notes'		=>	'控制产品询盘的类型，选择"ON"把产品询盘调整为单产品询盘',
														'member'				=>	'价格是否仅会员可见',
														'member_notes'			=>	'控制价格是否仅会员可见，如果开启，则登录之后才能看到',
														'pdf'					=>	'生成PDF格式',
														'pdf_notes'				=>	'产品详细页针对某个产品让客户生成PDF格式文件,便于传播.',
														'manage_myorder'		=>	'后台产品排序显示方式',
														'manage_myorder_notes'	=>	'默认关闭，后台产品管理列表以添加时间进行排序显示；勾选后，则会以产品排序设置来进行排序显示.',
														'currency_symbol'		=>	'货币符号'
													),
							'user'				=>	array(
														'user'					=>	'会员设置',
														'is_open'				=>	'是否开启会员功能',
														'verify'				=>	'会员审核',
														'email_verify'			=>	'注册邮箱验证',
														'reg_page_notes'		=>	'注册页提示语',
														'fixed'					=>	'【系统固定不能更改】',
														'custom_field'			=>	'自定义字段',
														'field_type'			=>	'类型',
														'field_type_ary'		=>	array('文本框', '多选框'),
														'field_option'			=>	'选项',
														'field_option_notes'	=>	'提示：每一行内容为一个选项',
														'reg_field_set'			=>	'注册参数设置',
														'reg_field'				=>	array(
																						'Email'			=>	'邮箱',
																						'Name'			=>	'姓名',
																						'Gender'		=>	'性别',
																						'Age'			=>	'年龄',
																						'NickName'		=>	'昵称',
																						'Telephone'		=>	'电话',
																						'Fax'			=>	'传真',
																						'Birthday'		=>	'生日',
																						'Facebook'		=>	'Facebook',
																						'Company'		=>	'公司'
																					)
													),
							'watermark'			=>	array(
														'watermark'				=>	'水印设置',
														'is_watermark'			=>	'开启水印添加',
														'alpha'					=>	'图片水印透明度',
														'alpha_notes'			=>	'（PNG水印时此参数无效）',
														'position'				=>	'水印位置',
														'position_ary'			=>	array('', '顶端居左', '顶端居中', '顶端居右', '中部居左', '中部居中', '中部居右', '底端居左', '底端居中', '底端居右'),
														'upload_file'			=>	'上传水印'
													),
							'share'				=>	array(
														'share'					=>	'社交媒体',
													)
						),
	'themes'		=>	array(
							'device'			=>	array('PC端', '手机端'),
							'menu'				=>	array(
														'index_set'				=>	'首页设置',
														'nav'					=>	'头部导航',
														'footer_nav'			=>	'底部导航',
														'toper_nav'				=>	'顶部导航',
														'themes'				=>	'风格',
														'home_themes'			=>	'首页风格',
														'list_themes'			=>	'列表页风格',
														'header_set'			=>	'头部设置',
														'footer_set'			=>	'底部设置',
														'ad'					=>	'广告图管理',
													),
							'nav'				=>	array(
														'page_type_ary'			=>	array('信息页单页', '产品'),
														'custom'				=>	'自定义',
														'url'					=>	'链接地址',
														'down'					=>	'下拉',
														'down_width'			=>	'下拉框宽度',
														'down_width_ary'		=>	array('小', '中', '大'),
														'new_target'			=>	'新窗口'
													),
							'themes'			=>	array(
														'use'					=>	'使用',
														'preview'				=>	'演示',
														'use_fail_notes'		=>	'你的版本不支持选择此风格',
														'themes_download_fail'	=>	'对不起，风格文件下载失败！'
													),
							'ad'				=>	array(
														'show_type'				=>	'显示方式',
														'show_type_ary'			=>	array('默认', '渐显', '上滚动', '左滚动'),
														'pic'					=>	'广告图片',
														'description'			=>	'简介',
														'url'					=>	'链接',
														'page'					=>	array(
																						'index'			=>	'首页',
																						'products'		=>	'产品页',
																						'case'			=>	'案例',
																						'article'		=>	'单页',
																						'news'			=>	'文章',
																						'download'		=>	'下载',
																						'feedback'		=>	'留言',
																						'page'			=>	'内页'
																					)
													),
							'header_set'		=>	array(
														'icon_color'			=>	'图标',
														'icon_color_ary'		=>	array('白色', '灰色', '粉红色'),
														'bg_color'				=>	'背景色',
														'fixed'					=>	'固定'
													),
							'footer_set'		=>	array(
														'preview'				=>	'预览',
														'font_family'			=>	'字体 Example',
														'bg_color'				=>	'背景色',
														'nav'					=>	'导航',
														'url'					=>	'链接'
													)
						),
	'country'		=>	array(
							'country'			=>	'国家/地区',
							'acronym'			=>	'名称简写',
							'continent'			=>	'洲',
							'continent_ary'		=>	array('亚洲', '欧洲', '非洲', '北美洲', '南美洲', '大洋洲', '南极洲')
						),
	'third_party_code'=>	array(
							'code'				=>	'代码内容',
							'code_type'			=>	'类型',
							'code_type_ary'		=>	array('PC与手机', 'PC', '手机'),
							'meta_notes'		=>	'默认为关闭，开启后此代码设置在<head>标签之间',
							'is_meta'			=>	'Meta代码',
							'used_notes'		=>	'默认为开启，取消开启后此代码不作用'
						),
	'manage'		=>	array(
							'username'			=>	'用户名',
							'group'				=>	'用户组',
							'group_ary'			=>	array(1=>'超级管理员', 2=>'普通管理员'),
							'last_login_time'	=>	'最后登录时间',
							'last_login_ip'		=>	'最后登录IP',
							'locked'			=>	'禁止登录',
							'create_time'		=>	'创建时间',
							'password_un_mod'	=>	'留空则不修改密码',
							'password'			=>	'登录密码',
							'confirm_password'	=>	'确认密码',
							'permit'			=>	'权限',
							'len_notes'			=>	'对不起，用户名和密码的长度必须为6位以上！',
							'password_len_notes'=>	'对不起，密码的长度必须为6位以上！',
							'manage_exists'		=>	'对不起，此用户名已经被占用，请换一个用户名！',
							'del_current_user'	=>	'不允许删除当前登录用户'
						),
	'manage_logs'	=>	array(
							'username'			=>	'用户名',
							'module'			=>	'功能模块',
							'log_contents'		=>	'日志内容',
							'ip'				=>	'IP地址',
							'ip_from'			=>	'IP地址来源'
						)
);
?>