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
						'send'			=>	'Send ',
						'module'		=>	'Sending module',
						'default'		=>	'Default settings',
						'custom_set'	=>	'Custom settings',
						'from_email'	=>	'Sender’s address',
						'from_name'		=>	'Sender’s name',
						'smtp'			=>	'SMTP address',
						'port'			=>	'SMTP port',
						'email'			=>	'Mail account',
						'password'		=>	'Mail password',
						'subject'		=>	'Subject',
						'addressee'		=>	'Receiver',
						'member_group'	=>	'Select members',
						'import_list'	=>	'Import the name list',
						'import'		=>	'Please select *.txt format when importing the list',
						'send_status'	=>	'Send status',
						'send_status_ary'=>	array('No', 'Yes'),
						'send_time'		=>	'Send time',
						'templates'		=>	'Template',
						'mail_tpl'		=>	'Select mail template',
						'contents'		=>	'Content',
						'remark'		=>	'Remarks: for multiple addressees, please fill in one on each line and separate the <span class="fc_red">email address</span> and <span class="fc_red">name</span> of each addressee with <span class="fc_red">/</span>. Such as: webmaster@ly200.com/cai yuzhuan
											<br />Such as: webmaster@ly200.com/cai yuzhuan<br />
											Variables (content in red) can be used for the subject or content of emails:<br />
											<span class="fc_red">{Email}</span>: Email address<br />
											<span class="fc_red">{FullName}</span>: Name',
						'remark_single'	=>	'Formats Such as: webmaster@ly200.com/cai yuzhuan<br />
											Variables (content in red) can be used for the subject or content of emails:<br />
											<span class="fc_red">{Email}</span>: Email address<br />
											<span class="fc_red">{FullName}</span>: Name',
						'send_tips'		=>	'The format of the addressee is wrong; operation failed, please modify'
					),
	'email_logs'	=>	array(
						'form_email'	=>	'Sender',
						'form_name'		=>	'Sender Name',
						'to_email'		=>	'Addressee',
						'subject'		=>	'Email Subject',
						'content'		=>	'Email Content',
						'status'		=>	'Send Status',
						'status_ary'	=>	array('Send Success', 'Send Failure')
						),
);