<?php

require_once 'bootstrap/app.php';

use Kayako\Services\FileReaderService\FileReader;
use Kayako\Services\ExportServices\CSV\CsvExport;

$time_start = microtime(true);

$fileReader = new FileReader($app['source_data'], new CsvExport);
$fileReader->export($app['import_csv']);

$time_end = microtime(true);
$time = $time_end - $time_start;

echo "Script executing $time seconds\n";
	


