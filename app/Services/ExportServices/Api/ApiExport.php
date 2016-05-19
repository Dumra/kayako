<?php

namespace Kayako\Services\ExportServices\Api;

use Kayako\Services\ExportServices\AbstractExport;
use Kayako\Services\LoggerService\Logger;

class ApiExport extends AbstractExport
{
	public function __construct()
	{
		parent::__construct();
		\kyConfig::set(new \kyConfig($this->app['api_url'], $this->app['api_key'],  $this->app['secret_key']));
		//\kyConfig::get()->setDebugEnabled(true);
	}
	
	public function export($data, $count = false, $startIndex = 0)
	{		
		$index;
		$count = (!$count) ? count($data) : $count;
		try {		
			$registered_user_group = \kyUserGroup::getAll()
					->filterByTitle("Registered")
					->first();	
			/*$user_organization = \kyUserOrganization::getAll()
					->filterByName("GFL")
					->first();*/
			//$answers = [];
			for($i = $startIndex; $i < $count; $i++){
				$index = $i;
				$organization = null;						
				$user = $registered_user_group
					->newUser($data[$i]['firstname'] . ' ' . $data[$i]['lastname'], $data[$i]['email'], $this->generateRandomString())						
					->setPhone($data[$i]['telephone'])
					->setSendWelcomeEmail(false) //sendwelcomeemail
					->create();	
				if ($data[$i]['company'] !== '') {
					$organization = $this->createOrganization($data[$i]);
					$user = \kyUser::get($user->getId());
					$user->setUserOrganization($organization);
					$user->update();
				}				
				//$answers[] = $organization;
			}
		} 
		catch (\Exception $ex) {
			$tmp = $index  + 1;
			$errorStr = 'Cought some exception. Error: ' . $ex->getMessage() . "\n"				
					. 'Number failed user:' . $tmp . "\n"
					. 'Amount data: ' . $count . "\n\n";
			Logger::appendLogFile($this->app['log_file_apiExport'], $errorStr);	
			sleep(10);
			$this->export($data, $count, $index + 1);
		}
		
		//var_dump($answers);
	}
	
	private function createOrganization($data)
	{
		$organization = \kyUserOrganization::createNew()					
						->setName($data['company'])
						->setType(\kyUserOrganization::TYPE_RESTRICTED)
						->setAddress($data['address'])
						->setCity($data['city'])
						->setCountry($data['country'])
						->setPostalCode($data['postal'])
						->setState($data['state'])
						->setWebsite($data['website'])
						->create();
		
		return $organization;
	}
	
	private function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++)
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
