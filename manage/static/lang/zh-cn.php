<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

$c['manage']['language']=array(
	'global'	=>	array(
						'n_y'				=>	array('否', '是'),
						'my_order_ary'		=>	array(0=>'默认')+range(0, 50)+array(-1=>'最后'),
						'my_order'			=>	'排序',
						'add'				=>	'添加',
						'edit'				=>	'修改',
						'edit_success'		=>	'修改成功',
						'del'				=>	'删除',
						'more'				=>	'更多',
						'other'				=>	'其他',
						'set'				=>	'设置',
						'date'				=>	'日期',
						'time'				=>	'时间',
						'edit_time'			=>	'修改时间',
						'submit'			=>	'提交',
						'confirm'			=>	'确认',
						'save'				=>	'保存',
						'save_success'		=>	'保存成功',
						'return'			=>	'返回',
						'cancel'			=>	'取消',
						'close'				=>	'关闭',
						'close_success'		=>	'关闭成功',
						'all'				=>	'所有',
						'serial'			=>	'序号',
						'name'				=>	'名称',
						'title'				=>	'标题',
						'contents'			=>	'内容',
						'operation'			=>	'操作',
						'category'			=>	'分类',
						'sub_category'		=>	'子分类',
						'option'			=>	'选项',
						'search'			=>	'搜索',
						'explode'			=>	'导出',
						'view'				=>	'查看',
						'move'				=>	'移动',
						'used'				=>	'启用',
						'required'			=>	'必填',
						'select_all'		=>	'全选',
						'un_select_all'		=>	'取消全选',
						'open'				=>	'开启',
						'open_success'		=>	'开启成功',
						'pack_up'			=>	'收起',
						'pic'				=>	'图片',
						'ip'				=>	'IP',
						'email'				=>	'邮箱',
						'logo'				=>	'Logo',
						'id'				=>	'Id',
						'description'		=>	'详细介绍',
						'brief_description'	=>	'简短介绍',
						'pre_page'			=>	'<<上一页',
						'next_page'			=>	'下一页>>',
						'upload_pic'		=>	'上传图片',
						'pic_size_notes'	=>	'图片大小建议: %s像素',
						'upload_file'		=>	'上传文件',
						'select_index'		=>	'--请选择--',
						'do_error'			=>	'操作无效',
						'sensitive_word'	=> 	'带有敏感词：',
						'sub_success'		=>	'提交成功',
						'base_info'			=>	'基本信息',
						'translation'		=>	'翻译',
						'translation_chars'	=>	'剩余%s字符',
						'language'			=>	'语言',
						'seo'				=>	array(
													'seo'				=>	'SEO',
													'title'				=>	'标题',
													'keyword'			=>	'关键词',
													'description'		=>	'描述',
													'custom_url'		=>	'自定义地址',
													'custom_url_notes'	=>	'SEO填写规则<br /><br />
																			标题<br />
																			即Title，显示在浏览器上角，在谷歌搜索第一行的大标题<br />
																			填写建议：填写2-3个关键词组合的语句<br /><br />
																			关键词<br />
																			即Keyword，不显示在网页，在代码中可见<br />
																			填写建议：当前产品名称+一级二级类目名称<br /><br />
																			简述<br />
																			即Description，页面的简述，显示在谷歌搜索记录的两行黑色小字<br />
																			填写建议：一个固定的句子，中间插入两个关键词<br />',
													'title_build'		=>	'智能选词',
													'keyword_build'		=>	'生成关键词',
													'desc_build'		=>	'生成简述',
													'desc_templet'		=>	'描述模板',
													'search'			=>	'查询',
													'related'			=>	'相关关键词',
													'search_amount'		=>	'每月搜索量',
													'compete'			=>	'竞争激烈度',
													'add'				=>	'添加到标题',
													'search_notes'		=>	'请输入关键词查询'
												)
					),
	'module'	=>	array(
						'account'			=>	array(
													'module_name'		=>	'我的帐号',
													'index'				=>	'首页',
													'password'			=>	'修改密码'
												),
						'inquiry'			=>	array(
													'module_name'		=>	'询盘',
													'inquiry'			=>	'询盘管理',
													'feedback'			=>	'留言管理',
													'review'			=>	'产品评论',
													'newsletter'		=>	'邮件订阅'
												),
						'products'			=>	array(
													'module_name'		=>	'产品',
													'products'			=>	'产品管理',
													'attribute'			=>	'属性',
													'category'			=>	'分类',
													'upload'			=>	'批量上传'
												),
						'content'			=>	array(
													'module_name'		=>	'内容',
													'page'				=>	array(
																				'module_name'	=>	'单页管理',
																				'list'			=>	'单页',
																				'category'		=>	'分类'
																			),
													'info'				=>	array(
																				'module_name'	=>	'文章管理',
																				'list'			=>	'文章',
																				'category'		=>	'分类'
																			),
													'partner'			=>	'友情链接',
													'case'				=>	array(
																				'module_name'	=>	'案例管理',
																				'list'			=>	'案例',
																				'category'		=>	'分类'
																			),
													'download'			=>	array(
																				'module_name'	=>	'下载管理',
																				'list'			=>	'下载',
																				'category'		=>	'分类'
																			),
													'blog'				=>	array(
																				'module_name'	=>	'博客管理',
																				'blog'			=>	'博客',
																				'set'			=>	'设置',
																				'category'		=>	'分类',
																				'review'		=>	'评论'
																			),
													'photo'				=>	array(
																				'module_name'	=>	'图片管理',
																				'list'			=>	'图片',
																				'category'		=>	'分类'
																			)
												),
						'seo'				=>	array(
													'module_name'		=>	'SEO',
													'overview'			=>	'SEO概况',
													'keyword'			=>	'关键词管理',
													'keyword_track'		=>	'关键词追踪',
													'article'			=>	'站内优化',
													'mobile'			=>	'移动端优化',
													'links'				=>	'链接优化',
													'blog'				=>	'博客优化',
													'ads'				=>	'商机发布',
													'sitemap'			=>	'网站地图',
													'description'		=>	'描述管理',
												),
						'mta'				=>	array(
													'module_name'		=>	'统计',
													'visits'			=>	'访问量',
													'country'			=>	'地区来源',
													'referer'			=>	'流量来源'
												),
						'user'				=>	array(
													'module_name'		=>	'会员',
													'user'				=>	'会员管理',
													'permit'			=>	'权限管理',
													'reg_set'			=>	'注册参数管理',
													'add'				=>	'添加会员'
												),
						'service'			=>	array(
													'module_name'		=>	'客服',
													'chat'				=>	'在线客服'
												),
						'email'				=>	array(
													'module_name'		=>	'邮件',
													'send'				=>	'邮件发送',
													'config'			=>	'发送设置',
													'logs'				=>	'发送日志'
												),
						'set'				=>	array(
													'module_name'		=>	'设置',
													'config'			=>	'基本设置',
													'themes'			=>	'模版设置',
													'nav'				=>	array(
																				'module_name'	=>	'导航设置',
																				'top'			=>	'顶部导航',
																				'head'			=>	'头部导航',
																				'foot'			=>	'底部导航'
																			),
													'index_page'		=>	'首页设置',
													'country'			=>	'国家地区',
													'third_party_code'	=>	'第三方代码',
													'manage'			=>	'管理员',
													'manage_logs'		=>	'系统日志'
												)
					),
	'language'	=>	array(
						'en'				=>	'英文',
						'jp'				=>	'日语',
						'de'				=>	'德语',
						'fr'				=>	'法语',
						'es'				=>	'西班牙语',
						'ru'				=>	'俄语',
						'cn'				=>	'中文',
						'pt'				=>	'葡萄牙语',
						'zh-cn'				=>	'中文'
					),
	'frame'		=>	array(
						'system_name'		=>	'外贸系统',
						'edit_password'		=>	'更改密码',
						'logout'			=>	'退出'
					),
	'error'		=>	array(
						'no_data'			=>	'暂无数据',
						'no_table_data'		=>	'当前暂时没有数据',
						'supplement_lang'	=>	'请填写其他语言版资料！',
						'no_permit'			=>	'你没有权限进行此操作',
						'operating_illegal'	=>	'请勿非法操作'
					)
);
?>