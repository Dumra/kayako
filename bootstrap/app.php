<?php
error_reporting(E_ERROR | E_PARSE); 
date_default_timezone_set('Europe/Kiev');
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../vendor/kayako/php-api-library/kyIncludes.php';

$provider = new \werx\Config\Providers\ArrayProvider(__DIR__ . '/../config');

# Create a Config\Container Instance from this provider.
$config = new \werx\Config\Container($provider);

# Load config/config.php
$config->load('app', true);

$app = $config->app();
?>