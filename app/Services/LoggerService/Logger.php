<?php

namespace Kayako\Services\LoggerService;

class Logger
{
	public static function createLogFile($path, $content)
	{
		$now = date('Y-m-d H:i:s');
		file_put_contents($path, $now . "\n" . $content);
	}
	
	public static function appendLogFile($path, $content)
	{
		$now = date('Y-m-d H:i:s');
		file_put_contents($path,  $now . "\n" . $content, FILE_APPEND | LOCK_EX);
	}
}
