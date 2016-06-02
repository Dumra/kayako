<?php

return [
//	'api_key' => 'b8fcac00-f2f0-99b4-c1cd-534d2fe02383',
//	'secret_key' => 'MDQ3ODFiNDMtMGQ2MS0zZDU0LTI5YzctNzdiYmFiMWJkYzQ5MjUyNDkzNzQtZjcyNy04NTU0LTIxZjYtOTA2MDkzOTYxNDVk',
//	'api_url' => 'http://gfl.kayako.com/api/',
	
	//'source_data' => 'resources/input/explode/CA/CAS-Customers_4_21_2016_48.csv',
	'source_data' => 'resources/input/TiCustomerDatafeedForVendor.csv',
	'import_csv' => 'resources/output/CI_Customers_4_21_2016.csv',
	'path_output' => 'resources/input/explode/CI/',
	'TI' => 'http://www.tomatoink.com',
	'CI' => 'http://www.comboink.com',
	'CAS' => 'http://www.compandsave.com',
	'guests' => 'Guests',
	'upload_to' => 'resources/input/daily/',
	'log_file_apiExport' => 'vendor/log/api_log.txt',
	'log_file_csvExport' => 'vendor/log/csv_log_CA_1.txt',
	'log_upload_files' => 'vendor/log/uploader.txt',
	'uploaded_files' => [
		'resources/input/daily/cas.csv',
		'resources/input/daily/ci.csv',
		'resources/input/daily/ti.csv'
	],
	'url_csv_files' => [
		'cas' => 'http://www.compandsave.com/v/dc/yy/subscriber_datafeed/CasCustomerDatafeedForVendor.csv',
		'ci' => 'http://www.comboink.com/v/dc/yy/subscriber_datafeed/CiCustomerDatafeedForVendor.csv',
		'ti' => 'http://tomatoink.com/download/feed/TiCustomerDatafeedForVendor.csv'
	]
];

//define('API_KEY', 'b8fcac00-f2f0-99b4-c1cd-534d2fe02383');
//define('SECRET_KEY', 'MDQ3ODFiNDMtMGQ2MS0zZDU0LTI5YzctNzdiYmFiMWJkYzQ5MjUyNDkzNzQtZjcyNy04NTU0LTIxZjYtOTA2MDkzOTYxNDVk');
//define('API_URL', 'http://gfl.kayako.com/api/');


