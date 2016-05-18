<?php

namespace Kayako\Services\ExportServices;

abstract class AbstractExport
{
	protected $userInfoPrepared = [
				'email' => '',
				'firstname' => '',
				'lastname' => '',
				'company' => '',
				'telephone' => '',
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
				'website' => ''
			];
	
	protected $app;
	
	public function __construct()
	{
		$provider = new \werx\Config\Providers\ArrayProvider(__DIR__ . '/../../../config');		
		$config = new \werx\Config\Container($provider);		
		$config->load('app', true);
		$this->app = $config->app();
	}
	
	abstract protected function export($data, $pathToOutput = false);

	public function convertToFormatData($data)
	{		
		$result = [];
		foreach ($data as $userInfoRaw) {
			$userInfoPrepared = $this->userInfoPrepared;
			$userInfoPrepared['email'] = $userInfoRaw['email'];
			$userInfoPrepared['firstname'] = $userInfoRaw['firstname'];
			$userInfoPrepared['lastname'] = $userInfoRaw['lastname'];
			$userInfoPrepared['telephone'] = $userInfoRaw['billing_telephone'];
			$userInfoPrepared['website'] = $this->app['TI_link'];			

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
		return $result;	
	}
}
