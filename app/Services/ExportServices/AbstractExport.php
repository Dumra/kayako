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
	
	protected $configDir = '/../../../config';	
	protected $app;
	private $unknownCompany = 'Company';	
	
	public function __construct()
	{
		$provider = new \werx\Config\Providers\ArrayProvider(__DIR__ . $this->configDir);		
		$config = new \werx\Config\Container($provider);		
		$config->load('app', true);
		$this->app = $config->app();
	}
	
	abstract protected function export($data, $pathToOutput = false, $startIndex = 0);

	public function convertToFormatData($data, $otherFormat)
	{		
		$preparedData = null;
		if ($otherFormat === false){
			$preparedData = $this->parseFullFormat($data);
		}
		else {
			return $preparedData = $this->parsePartialFormal($data);
		}
		
		return $preparedData;
	}
	
	private function parseFullFormat($data)
	{
		$result = [];
		$counter = 0;
		foreach ($data as $userInfoRaw) {
			$userInfoPrepared = $this->userInfoPrepared;
			$userInfoPrepared['email'] = $userInfoRaw['email'];
			$userInfoPrepared['firstname'] = $userInfoRaw['firstname'];
			$userInfoPrepared['lastname'] = $userInfoRaw['lastname'];
			$userInfoPrepared['telephone'] = $userInfoRaw['billing_telephone'];
			$userInfoPrepared['website'] = $this->app['TI_link'];			

			if (trim($userInfoRaw['shipping_company']) !== '') {
				$userInfoPrepared['company'] = trim($userInfoRaw['shipping_company']);
				$userInfoPrepared['address'] = trim($userInfoRaw['shipping_street']);
				$userInfoPrepared['city'] = trim($userInfoRaw['shipping_city']);
				$userInfoPrepared['state'] = trim($userInfoRaw['shipping_region_id']);
				$userInfoPrepared['postal'] = trim($userInfoRaw['shipping_postcode']);
				$userInfoPrepared['country'] = trim($userInfoRaw['shipping_country_id']);
			} elseif (trim($userInfoRaw['billing_company']) !== ''){
				$userInfoPrepared['company'] = trim($userInfoRaw['billing_company']);
				$userInfoPrepared['address'] = trim($userInfoRaw['billing_street']);
				$userInfoPrepared['city'] = trim($userInfoRaw['billing_city']);
				$userInfoPrepared['state'] = trim($userInfoRaw['billing_region_id']);
				$userInfoPrepared['postal'] = trim($userInfoRaw['billing_postcode']);
				$userInfoPrepared['country'] = trim($userInfoRaw['billing_country_id']);
			} elseif (trim($userInfoRaw['shipping_street']) !== '') {
				$userInfoPrepared['company'] = $this->unknownCompany;
				$userInfoPrepared['address'] = trim($userInfoRaw['shipping_street']);
				$userInfoPrepared['city'] = trim($userInfoRaw['shipping_city']);
				$userInfoPrepared['state'] = trim($userInfoRaw['shipping_region_id']);
				$userInfoPrepared['postal'] = trim($userInfoRaw['shipping_postcode']);
				$userInfoPrepared['country'] = trim($userInfoRaw['shipping_country_id']);
			} elseif (trim($userInfoRaw['billing_street']) !== '') {
				$userInfoPrepared['company'] = $this->unknownCompany;
				$userInfoPrepared['address'] = trim($userInfoRaw['billing_street']);
				$userInfoPrepared['city'] = trim($userInfoRaw['billing_city']);
				$userInfoPrepared['state'] = trim($userInfoRaw['billing_region_id']);
				$userInfoPrepared['postal'] = trim($userInfoRaw['billing_postcode']);
				$userInfoPrepared['country'] = trim($userInfoRaw['billing_country_id']);
			}
			
			if ($userInfoPrepared['firstname'] === '' && $userInfoPrepared['lastname'] === ''){
				$userInfoPrepared['firstname'] = trim($userInfoRaw['shipping_firstname']);
				$userInfoPrepared['lastname'] = trim($userInfoRaw['shipping_lastname']);
				$userInfoPrepared['email'] = $this->getRandomEmail($counter);
			}
			$counter++;
			$result[] = $userInfoPrepared;
		}
		return $result;	
	}
	
	private function parsePartialFormal($data)
	{
		$result = [];
		foreach ($data as $userInfoRaw) {
			$userInfoPrepared = $this->userInfoPrepared;
			$userInfoPrepared['email'] = $userInfoRaw['email'];
			$userInfoPrepared['firstname'] = $userInfoRaw['firstname'];
			$userInfoPrepared['lastname'] = $userInfoRaw['lastname'];
			$userInfoPrepared['telephone'] = $userInfoRaw['phone'];
			$userInfoPrepared['city'] = trim($userInfoRaw['city']);
			$userInfoPrepared['state'] = trim($userInfoRaw['state']);
			$userInfoPrepared['country'] = trim($userInfoRaw['country']);
			$userInfoPrepared['postal'] = trim($userInfoRaw['postal']);
			$userInfoPrepared['address'] = trim($userInfoRaw['billing_address1']) . 
											' ' . trim($userInfoRaw['billing_address2']);
			if (trim($userInfoRaw['company']) !== '' ){
				$userInfoPrepared['company'] = trim($userInfoRaw['company']);
			} elseif (trim($userInfoRaw['company']) === '' && trim($userInfoPrepared['address']) !== ''){
				$userInfoPrepared['company'] = $this->unknownCompany;
			}			
			$userInfoPrepared['website'] = $this->app['CAS'];	
			$result[] = $userInfoPrepared;
		}
		return $result;	
	}
	
	private function getRandomEmail($index)
	{
		return 'noemail' . $index . '@email.com';
	}
}
