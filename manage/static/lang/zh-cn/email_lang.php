<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
姓名：sheldon
日期: 2014-07-25
备注:分工的语言包开发，上线后该文件统一整合 
*/
return array(
	'email'	=>	array(
						'send'			=>	'发送',
						'module'		=>	'发送模块',
						'default'		=>	'默认设置',
						'custom_set'	=>	'自定义设置',
						'from_email'	=>	'发件人邮箱',
						'from_name'		=>	'发件人名称',
						'smtp'			=>	'SMTP地址',
						'port'			=>	'SMTP端口',
						'email'			=>	'邮箱帐号',
						'password'		=>	'邮箱密码',
						'subject'		=>	'主题',
						'addressee'		=>	'收件人',
						'member_group'	=>	'选择会员',
						'import_list'	=>	'外部导入名单',
						'import'		=>	'导入列表请选择*.txt格式',
						'send_status'	=>	'发送状态',
						'send_status_ary'=>	array('否', '是'),
						'send_time'		=>	'发送时间',
						'templates'		=>	'模板',
						'mail_tpl'		=>	'选择邮件模板',
						'contents'		=>	'内容',
						'remark'		=>	'备注: 多个收件人请每行填写一个，并且每个收件人的<span class="fc_red">邮箱地址</span>与<span class="fc_red">姓名</span>用<span class="fc_red">/</span>分隔开
											<br />如: webmaster@ly200.com/cai yuzhuan<br />
											邮件主题或邮件内容可用变量（红色内容）:<br />
											<span class="fc_red">{Email}</span>: 邮箱地址<br />
											<span class="fc_red">{FullName}</span>: 姓名',
						'remark_single'	=>	'备注，如:  webmaster@ly200.com/cai yuzhuan<br />
											邮件主题或邮件内容可用变量（红色内容）:<br />
											<span class="fc_red">{Email}</span>: 邮箱地址<br />
											<span class="fc_red">{FullName}</span>: 姓名',
						'send_tips'		=>	'收件人格式有误，未能完成操作，请修改',
					),
	'email_logs'	=>	array(
						'form_email'	=>	'发件人',
						'form_name'		=>	'发件人名称',
						'to_email'		=>	'收件人',
						'subject'		=>	'邮件主题',
						'content'		=>	'邮件内容',
						'status'		=>	'发送状态',
						'status_ary'	=>	array('发送成功', '发送失败')
						),
);