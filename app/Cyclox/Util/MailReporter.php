<?php

/*
 *  created at 2017/02/23 by shun
 */

App::uses('CakeEmail', 'Network/Email');
App::uses('AuthComponent' , 'Controller/Component');

/**
 * 外部へのメール送信を行なうクラス
 *
 * @author shun
 */
class MailReporter
{
	public static function report($msg, $titleSub = '')
	{
		if (Configure::read('mail_reports')) {
			$user = AuthComponent::user('username');
			if (empty($user)) {
				$user = env('PHP_AUTH_USER');
				if (empty($user)) $user = '[NotLogin or Guest]';
			}
			
			$request = Router::getRequest();
			
			$text = "Cyclox2 Server[" . $request->host() . "]からの報告 at " . date('Y-m-d H:i:s') ."\n\n"
					. '内容:'. $msg . "\n\n"
					. 'この処理を行なった Cyclox2 ユーザ:[' . $user
					. '] at client ip addr[' . $request->clientIp() . "]";
					"\n\n※本メールは Cyclox2 Server から自動的に送信されたものです。"
					. "返信してもリアクションはありません。";
			
			$to = Configure::read('mail_report_to');
			if (empty($to)) $to = 'sys-cxjp@ginuuk.net';
			
			$addr = Configure::read('mail_report_from');
			if (empty($addr)) $addr = 'sys-cxjp@ginuuk.net';
			
			$Email = new CakeEmail('sys_reporter');
			$Email = $Email->from(array($addr => 'CxSys-Reporter'))
				->sender($addr)
				->replyTo($addr)
				->to($to);
			
			$cc = Configure::read('mail_report_cc');
			if (!empty($cc)) {
				foreach ($cc as $c) {
					$Email = $Email->addCc($c);
				}
			}

			$Email->subject('Cyclox2 ' . $titleSub .' Report [' . $request->host() . ']')->send($text);
		}
	}
}
