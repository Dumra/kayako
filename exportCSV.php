<?php

require_once 'bootstrap/app.php';

use Kayako\Services\FileReaderService\FileReader;
use Kayako\Services\ExportServices\CSV\CsvExport;
use Kayako\Services\LoggerService\Logger;

$time_start = microtime(true);

try {
	Logger::createLogFile($app['log_file_csvExport'], "Starting export csv script....\n\n");	
	$fileReader = new FileReader($app['source_data'], new CsvExport);
	//$fileReader = new FileReader($app['source_data'], new CsvExport, true); // for other 2 files
	$fileReader->export($app['import_csv']);
} catch (Exception $ex) {
	Logger::appendLogFile($app['log_file_csvExport'], 
					'Something went wrong. Error: ' . $ex->getMessage() . "\n\n");
}

$time_end = microtime(true);
$time = $time_end - $time_start;
Logger::appendLogFile($app['log_file_csvExport'], 
		'Ending export csv script... Executing time: ' . gmdate("H:i:s", round($time, 2)) . "\n");

echo 'Script executing: ' . round($time, 2) . " seconds \n";
	


