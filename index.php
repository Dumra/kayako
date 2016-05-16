<?php
$time_start = microtime(true);

require_once 'bootstrap/app.php';

//$app = $config->app();
//kyConfig::set(new kyConfig($app['api_url'], $app['api_key'],  $app['secret_key']));
//kyConfig::get()->setDebugEnabled(true);
//var_dump(kyUser::getAll());


$fh = fopen('TICustomers.csv', 'r');
$countVals = 29;
$csv = [];

while ($values = fgetcsv($fh)) {
	if (count($values) === 1) {
	   continue;
	} 
	
	$csv[] = array_map(function($item){	 
		return str_replace("\r\n", " ", $item);	
	}, $values);	 
}

array_walk($csv, function(&$a) use ($csv) {
    $a = array_combine($csv[0], $a);
   });
   
$columnHeaders = array_shift($csv);
//var_dump($csv);

$time_end = microtime(true);
$time = $time_end - $time_start;

echo "Ничего не делал $time секунд\n";
	
	

