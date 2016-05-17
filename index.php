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

fclose($fh);

array_walk($csv, function(&$a) use ($csv) {
    $a = array_combine($csv[0], $a);
   });
   
$columnHeaders = array_shift($csv);

$result = [];
foreach ($csv as $userInfoRaw) {
	$userInfoPrepared = [
		'email' => $userInfoRaw['email'],
		'firstname' => $userInfoRaw['firstname'],
		'lastname' => $userInfoRaw['lastname'],
		'company' => '',
		'telephone' => $userInfoRaw['billing_telephone'],
		'salutation' => '',
		'designation' => '',
		'email_domain_filter' => '',
		'address' => '',
		'city' => '',
		'state' => '',
		'postal' => '',
		'country' => '',
		'phone' => '',
		'fax' => '',
		'website' => 'http://www.tomatoink.com'
	];
		
	if (trim($userInfoRaw['billing_company']) !== '') {
		$userInfoPrepared['company'] = trim($userInfoRaw['billing_company']);
		$userInfoPrepared['address'] = trim($userInfoRaw['billing_street']);
		$userInfoPrepared['city'] = trim($userInfoRaw['billing_city']);
		$userInfoPrepared['state'] = trim($userInfoRaw['billing_region_id']);
		$userInfoPrepared['postal'] = trim($userInfoRaw['billing_postcode']);
		$userInfoPrepared['country'] = trim($userInfoRaw['billing_country_id']);
	} elseif (trim($userInfoRaw['shipping_company']) !== ''){
		$userInfoPrepared['company'] = trim($userInfoRaw['shipping_company']);
		$userInfoPrepared['address'] = trim($userInfoRaw['bshipping_street']);
		$userInfoPrepared['city'] = trim($userInfoRaw['shipping_city']);
		$userInfoPrepared['state'] = trim($userInfoRaw['shipping_region_id']);
		$userInfoPrepared['postal'] = trim($userInfoRaw['shipping_postcode']);
		$userInfoPrepared['country'] = trim($userInfoRaw['shipping_country_id']);
	} elseif (trim($userInfoRaw['billing_street']) !== '') {
		$userInfoPrepared['company'] = 'Company';
		$userInfoPrepared['address'] = trim($userInfoRaw['billing_street']);
		$userInfoPrepared['city'] = trim($userInfoRaw['billing_city']);
		$userInfoPrepared['state'] = trim($userInfoRaw['billing_region_id']);
		$userInfoPrepared['postal'] = trim($userInfoRaw['billing_postcode']);
		$userInfoPrepared['country'] = trim($userInfoRaw['billing_country_id']);
	} elseif (trim($userInfoRaw['shipping_street']) !== '') {
		$userInfoPrepared['company'] = 'Company';
		$userInfoPrepared['address'] = trim($userInfoRaw['bshipping_street']);
		$userInfoPrepared['city'] = trim($userInfoRaw['shipping_city']);
		$userInfoPrepared['state'] = trim($userInfoRaw['shipping_region_id']);
		$userInfoPrepared['postal'] = trim($userInfoRaw['shipping_postcode']);
		$userInfoPrepared['country'] = trim($userInfoRaw['shipping_country_id']);
	}
	
	$result[] = $userInfoPrepared;
}

$fp = fopen('file.csv', 'w');

foreach ($result as $userDataPrepared) {
    fputcsv($fp, array_values($userDataPrepared));
}

fclose($fp);

$time_end = microtime(true);
$time = $time_end - $time_start;

print "Count data: " . count($csv) . "\n";
print "Null name:" . count($result) . "\n";

echo "Ничего не делал $time секунд\n";
	


