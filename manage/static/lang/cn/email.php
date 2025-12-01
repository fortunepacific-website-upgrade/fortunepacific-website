<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791 
*/

return array(			
	'send'		=>	array(
						'send'			=>	'发送',
						'subject'		=>	'主题',
						'addressee'		=>	'收件人',
						'member_group'	=>	'选择会员',
						'bat_send_notes'=>	'多个邮件发送功能尚在开发中，敬请期待',
						'remark'		=>	'备注，如:  webmaster@ueeshop.com/service<br />
											邮件主题或邮件内容可用变量（红色内容）:<br />
											<span class="fc_red">{Email}</span>: 邮箱地址<br />
											<span class="fc_red">{FullName}</span>: 姓名'
					),
	'config'	=>	array(
						'method'		=>	'发送方式',
						'default'		=>	'默认设置',
						'custom_set'	=>	'自定义设置',
						'from_email'	=>	'发件人邮箱',
						'from_name'		=>	'发件人名称',
						'smtp'			=>	'SMTP地址',
						'port'			=>	'SMTP端口',
						'email'			=>	'邮箱帐号',
						'password'		=>	'邮箱密码'
					),
	'logs'	=>	array(
						'form_email'	=>	'发件人',
						'form_name'		=>	'发件人名称',
						'to_email'		=>	'收件人',
						'subject'		=>	'邮件主题',
						'content'		=>	'邮件内容',
						'status'		=>	'发送状态',
						'status_ary'	=>	array('发送成功', '发送失败')
					)
);