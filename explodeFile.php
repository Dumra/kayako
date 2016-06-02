<?php

require_once 'bootstrap/app.php';
use Kayako\Services\FileReaderService\FileReader;

$fileReader = new FileReader($app['source_data'], null);
$fileReader->explode($app['path_output']);
