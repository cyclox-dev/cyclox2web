<?php

/*
 *  created at 2017/02/23 by shun
 */

App::uses('CakeEmail', 'Network/Email');

/**
 * 外部へのメール送信を行なうクラス
 *
 * @author shun
 */
class MailReporter
{
	public static function report($title, $msg)
	{
		if (Configure::read('mail_reports')) {
			$text = $msg . "\n\n※本メールは Cyclox2 Server から自動的に送信されたものです。"
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

			$Email->subject($title)->send($text);
		}
	}
}
