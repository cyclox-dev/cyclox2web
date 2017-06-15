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
		$msg = "Exception が発生しました。エラー内容詳細は以下の通りです。\n"
				. self::_getMessage($exception) . "\n\n";
		$msg .= "Exception ごと詳細:" . self::__exceptionDetail($exception);
		
		MailReporter::report($msg, 'Err');
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
				'recordings/',
				'a2billing/admin/Public/index.php',
				'a2billing/',
				'admin/i18n/readme.txt',
				'struts2-showcase/',
				'current_config/passwd',
				'current_config/Account1',
				'rest/api/2/configuration',
				'admin/modules/framework/',
				'plugins/weathermap/editor.php',
				'loginback.jpg',
				'script',
				'a2billing/common/javascript/misc.js',
				'cas/login.action',
				'admin/images/tango.png',
				'/recordings/index.php',
				'a2billing/admin/Public/templates/default/profiler.tpl',
				'recordings/index.php',
				'recordings/misc/audio.php',
				'HNAP1/',
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
	
	// @Override
	public static function handleError($code, $description, $file = null, $line = null, $context = null) {
		
		// 処理の中身は ErrorHandler そのまま。自前のhandleFatalErro() を呼びたいだけ。
		
		if (error_reporting() === 0) {
			return false;
		}
		$errorConfig = Configure::read('Error');
		list($error, $log) = self::mapErrorCode($code);
		if ($log === LOG_ERR) {
			return self::handleFatalError($code, $description, $file, $line);
		}

		$debug = Configure::read('debug');
		if ($debug) {
			$data = array(
				'level' => $log,
				'code' => $code,
				'error' => $error,
				'description' => $description,
				'file' => $file,
				'line' => $line,
				'context' => $context,
				'start' => 2,
				'path' => Debugger::trimPath($file)
			);
			return Debugger::getInstance()->outputError($data);
		}
		$message = $error . ' (' . $code . '): ' . $description . ' in [' . $file . ', line ' . $line . ']';
		if (!empty($errorConfig['trace'])) {
			$trace = Debugger::trace(array('start' => 1, 'format' => 'log'));
			$message .= "\nTrace:\n" . $trace . "\n";
		}
		return CakeLog::write($log, $message);
	}

	// @Override
	public static function handleFatalError($code, $description, $file, $line)
	{	
		// メール報告
		$logMessage = 'Fatal Error (' . $code . '): ' . $description . ' in [' . $file . ', line ' . $line . ']';
		$msg = "Fatal Error が発生しました。\nプログラムが間違っている可能性があります。"
				. "エラー内容詳細は以下の通りです。\n" . $logMessage;
		MailReporter::report($msg, 'FatalErr');
		
		return parent::handleFatalError($code, $description, $file, $line);
	}
}
