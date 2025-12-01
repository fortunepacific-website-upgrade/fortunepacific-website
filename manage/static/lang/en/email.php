<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

return array(
	'send'		=>	array(
						'send'			=>	'Send',
						'subject'		=>	'Subject',
						'addressee'		=>	'Receiver',
						'member_group'	=>	'Select members',
						'bat_send_notes'=>	'Multiple email sending functions are still under development, so stay tuned',
						'remark'		=>	'Remarks,Such as:  webmaster@ueeshop.com/service<br />
											Variables (content in red) can be used for the subject or content of emails:<br />
											<span class="fc_red">{Email}</span>: Email address<br />
											<span class="fc_red">{FullName}</span>: Name',
					),
	'config'	=>	array(
						'method'		=>	'Sending module',
						'default'		=>	'Default settings',
						'custom_set'	=>	'Custom settings',
						'from_email'	=>	'Sender’s address',
						'from_name'		=>	'Sender’s name',
						'smtp'			=>	'SMTP address',
						'port'			=>	'SMTP port',
						'email'			=>	'Mail account',
						'password'		=>	'Mail password'
					),
	'logs'	=>	array(
						'form_email'	=>	'Sender',
						'form_name'		=>	'Sender Name',
						'to_email'		=>	'Addressee',
						'subject'		=>	'Email Subject',
						'content'		=>	'Email Content',
						'status'		=>	'Send Status',
						'status_ary'	=>	array('Send Success', 'Send Failure')
					)
);