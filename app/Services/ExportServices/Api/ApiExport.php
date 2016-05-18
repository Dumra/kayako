<?php

namespace Kayako\Services\ExportServices\Api;

use Kayako\Services\ExportServices\AbstractExport;;

class ApiExport extends AbstractExport
{
	public function __construct()
	{
		parent::__construct();
		\kyConfig::set(new \kyConfig($this->app['api_url'], $this->app['api_key'],  $this->app['secret_key']));
		//\kyConfig::get()->setDebugEnabled(true);
	}
	
	public function export($data, $count = false)
	{		
		$registered_user_group = \kyUserGroup::getAll()
				->filterByTitle("Registered")
				->first();
		/*$user_organization = \kyUserOrganization::getAll()
				->filterByName("GFL")
				->first();*/
	//	$answers = [];
		for($i = 0; $i < 2; $i++){
			$user = $registered_user_group
				->newUser($data[$i]['firstname'] . ' ' . $data[$i]['lastname'], $data[$i]['email'], $this->generateRandomString())
				//->setUserOrganization($user_organization) //userorganizationid			
				->setPhone($data[$i]['telephone'])
				->setSendWelcomeEmail(false) //sendwelcomeemail
				->create();	
		//	$answers[] = $user;
		}
		
	//	var_dump($answers);
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
