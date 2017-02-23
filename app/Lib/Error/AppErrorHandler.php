<?php

/*
 *  created at 2017/02/23 by shun
 */

App::uses('ExceptionHandler', 'Error');
App::uses('MailReporter', 'Cyclox/Util');

/**
 * ExceptionHandler にメール report 機能を加えたもの
 *
 * @author shun
 */
class AppErrorHandler extends ErrorHandler
{
	/**
	 * @Override
	 * 自前で Exception を handling する。
	 * Basic 認証の第1段階問い合わせでの Unauthorized をスルー。
	 * @param Exception $exception The exception to render.
	 * @return void
	 * @see http://php.net/manual/en/function.set-exception-handler.php
	 */
	public static function handleException(Exception $exception) {
		//CakeLog::write(LOG_DEBUG, 'called with user: [' . env('PHP_AUTH_USER')
		//		. ' and ' . env('PHP_AUTH_PW') . '] by ex:' . $exception);
		//CakeLog::write(LOG_DEBUG, 'code:' . $exception->getCode());
		
		$config = Configure::read('Exception');
		if (self::__needReport($exception)) {
			self::_log($exception, $config);
			
			// メール報告
			self::__report($exception);
		}
		
		$renderer = isset($config['renderer']) ? $config['renderer'] : 'ExceptionRenderer';
		if ($renderer !== 'ExceptionRenderer') {
			list($plugin, $renderer) = pluginSplit($renderer, true);
			App::uses($renderer, $plugin . 'Error');
		}
		try {
			$error = new $renderer($exception);
			$error->render();
		} catch (Exception $e) {
			set_error_handler(Configure::read('Error.handler')); // Should be using configured ErrorHandler
			Configure::write('Error.trace', false); // trace is useless here since it's internal
			$message = sprintf("[%s] %s\n%s", // Keeping same message format
				get_class($e),
				$e->getMessage(),
				$e->getTraceAsString()
			);

			self::$_bailExceptionRendering = true;
			trigger_error($message, E_USER_ERROR);
		}
	}
	
	/**
	 * mail report を贈る
	 * @param type $exception
	 */
	private static function __report($exception)
	{
		$request = Router::getRequest();
		
		$msg = "Cyclox2 Server[" . $request->host() . "]にて Exception が発生しました at " . date('Y-m-d h:i:s') ."\n\n";
		$msg .= "エラー内容詳細は以下の通り\n" . self::_getMessage($exception) . "\n\n";
		$msg .= '現在のログインユーザ:[' . (is_null(env('PHP_AUTH_USER')) ? '未ログイン' : env('PHP_AUTH_USER'))
				. '] at client ip addr[' . $request->clientIp() . "]\n";
		$msg .= "Exception ごと詳細:" . self::__exceptionDetail($exception);
		
		MailReporter::report('Cyclox2 ErrReport [' . $request->host() . ']', $msg);
	}
	
	/**
	 * 例外ごとの詳細をかえす
	 * @param type $exception
	 * @return string
	 */
	private static function __exceptionDetail($exception)
	{
		if (get_class($exception) == 'UnauthorizedException')
		{
			return '認証試行 - user[' . env('PHP_AUTH_USER') . '], pwd[' . env('PHP_AUTH_PW') . ']';
		}
		
		return '特になし';
	}
	
	/**
	 * mail report が必要であるかを返す
	 * @param type $exception
	 * @return boolean
	 */
	private static function __needReport($exception)
	{
		if (get_class($exception) == 'UnauthorizedException')
		{
			// Basic 認証の第1段階についてはログ出力、メール報告ともにしない。
			
			return (env('PHP_AUTH_USER') !== '' && !is_null(env('PHP_AUTH_USER')))
					|| (env('PHP_AUTH_PW') !== '' && !is_null(env('PHP_AUTH_PW')));
		}
		else
		{
			$noReactions = array(
				'admin/config.php',
				'recordings/'
				// ここに例外ログを防ぎたいアドレスを
			);
			
			//CakeLog::write(LOG_DEBUG, 'path is ' . Router::url('/controller/action/', true));
			$requrl = Router::getRequest()->here;
			foreach ($noReactions as $nr) {
				if (self::__strEndsWith($requrl, $nr)) {
					return false;
				}
			}
		}

		return true;
	}
	
	/**
	 * string ends with の実装
	 * ref: http://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php より
	 * @param type $haystack
	 * @param type $needle
	 * @return type
	 */
	private static function __strEndsWith($haystack, $needle) {
		// search forward starting from end minus needle length characters
		return $needle === "" || (
			($temp = strlen($haystack) - strlen($needle)) >= 0 
				&& strpos($haystack, $needle, $temp) !== false
		);
	}

}
