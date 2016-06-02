<?php

require_once 'bootstrap/app.php';

use Kayako\Services\FileReaderService\FileReader;
use Kayako\Services\ExportServices\Api\ApiExport;
use Kayako\Services\LoggerService\Logger;
use Kayako\Services\UploadService\Uploader;

$time_start = microtime(true);

$uploader = new Uploader($app['url_csv_files'], $app['log_upload_files'], $app['upload_to']);
$uploader->getFiles(); 

Logger::createLogFile($app['log_file_apiExport'], "Starting export api script....\n\n");

foreach ($app['uploaded_files'] as $value)
{
	//$fileReader = new FileReader($app['source_data'], new ApiExport);
	//$fileReader = new FileReader($app['source_data'], new ApiExport, true); //for other 2 files
	$fileReader = new FileReader($value, new ApiExport, true); //for other 2 files
	$fileReader->export(1);
}


$time_end = microtime(true);
$time = $time_end - $time_start;

Logger::appendLogFile($app['log_file_apiExport'], 'Ending export api script... Executing time: ' . gmdate("H:i:s", round($time, 2)) . "\n");

echo 'Script executing ' . round($time, 2) . " seconds\n";
