<?php

namespace Kayako\Services\UploadService;

use \GuzzleHttp\Client;
use Kayako\Services\LoggerService\Logger;

class Uploader
{

	private $headers;
	private $urls;
	private $clientGuzzle;
	private $logger;
	private $uploadTo;

	public function __construct($urls, $logger, $uploadTo)
	{
		$this->headers = ['User-Agent' => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36'];
		$this->urls = $urls;
		$this->clientGuzzle = new Client();
		$this->logger = $logger;
		$this->uploadTo = $uploadTo;
	}

	public function getFiles()
	{
		Logger::createLogFile($this->logger, "Starting upload: \n\n");
		$urls = $this->urls;
		foreach ($urls as $key => $value)
		{
			try
			{
				$request = $this->clientGuzzle->request('GET', $urls[$key], $this->headers);
				if ($request->getStatusCode() === 200)
				{
					file_put_contents($this->uploadTo . $key . '.csv', $request->getBody());
				}
			}
			catch (Exception $ex)
			{
				$errorStr = "Failed upload $key file: \n"
						. 'Cought some exception. Error: ' . $ex->getMessage() . "\n\n";					
				Logger::appendLogFile($this->logger, $errorStr);
			}
		}
		Logger::appendLogFile($this->logger, "Finished upload. \n");
	}

}
