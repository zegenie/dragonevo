<?php

	defined('DEVO_MEDIA_UPLOAD_PATH') || define('DEVO_MEDIA_UPLOAD_PATH', CASPAR_RESOURCES_PATH . 'images' . DS . 'media' . DS);
	defined('DEVO_CARD_UPLOAD_PATH') || define('DEVO_CARD_UPLOAD_PATH', CASPAR_RESOURCES_PATH . 'images' . DS . 'cards' . DS);

	date_default_timezone_set('Etc/GMT-2');

	\caspar\core\Caspar::autoloadNamespace('application\\lib', CASPAR_APPLICATION_PATH . 'lib');

	function devo_get_error_mailer()
	{
		static $mailer = null;
		if ($mailer === null) {
			require_once CASPAR_LIB_PATH . 'swift/lib/swift_required.php';
			$transport = \Swift_SmtpTransport::newInstance('smtp.domeneshop.no', 587)
				->setUsername('dragonevo1')
				->setPassword('sDf47nQ5');
			$mailer = \Swift_Mailer::newInstance($transport);
		}
		return $mailer;
	}

	function devo_mail_error($message, $file, $line, $trace = null)
	{
		if ($trace === null) {
			ob_start();
			debug_print_backtrace();
			$trace = ob_get_clean();
		}
		$reportBody  = "Something went wrong - here are the details: \n\n";
		$reportBody .= "When: ".date("d/m/Y h:i", $_SERVER["REQUEST_TIME"])."\n";
		$reportBody .= "Exception: ".$message."\n";
		$reportBody .= "URL: ".$_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI']."\n";
		$reportBody .= "File: ".$file."\n";
		$reportBody .= "Line: ".$line."\n";

//		$requestParams = \caspar\core\Caspar::getRequest()->getParameters();
		$reportBody .= "Request params:\n".var_export($_REQUEST, true)."\n";
		$reportBody .= "Backtrace: \n".$trace."\n";

		$mailer = devo_get_error_mailer();
		$message = \Swift_Message::newInstance('Dragonevo exception');
		$message->setFrom('support@playdragonevo.com', 'Dragon Evo devs');
		$message->setTo('zegenie@gmail.com');
		$message->setBody($reportBody, 'text/plain');

		$message->attach(Swift_Attachment::newInstance($trace, null, 'text/plain'));

		try
		{
			if ($mailer->send($message));
			{
			  $mailSent = true;
			}
		}
		catch (Exception $e)
		{
		// Not a lot we can do about this - maybe they don't have a valid mail server?
		}
		
	}

	function devo_exception_handler($exception)
	{
//		devo_mail_error($exception->getMessage(), $exception->getFile(), $exception->getLine(), $exception->getTraceAsString());
		\caspar\core\Caspar::exceptionHandler($exception);
	}
	
	function devo_error_handler($code, $error, $file, $line)
	{
//		devo_mail_error($error, $file, $line);
		\caspar\core\Caspar::errorHandler($code, $error, $file, $line);
	}
	
	function devo_shutdown_handler()
	{
		$error = error_get_last();
		if (isset($error['type']) && $error['type'] == 1) {
//			devo_mail_error($error['message'], $error['file'], $error['line']);
		}
	}
	
//	register_shutdown_function('devo_shutdown_handler');
//	set_error_handler('devo_error_handler', E_ALL);
//	set_exception_handler('devo_exception_handler');
	error_reporting(E_ALL | E_STRICT);
