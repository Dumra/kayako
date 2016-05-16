<?php

namespace Kayako\Services;

class FileReader
{
	private $pathToFile;
	
	public function __construct($pathToFile)
	{
		$this->pathToFile = $pathToFile;
	}
	
	public function readFile()
	{
		$counter = 0;
		$dataOutput = [];
		while (($data = fgetcsv($this->pathToFile, 2000))) {
			if ($counter > 4)
			{
				break;
			}
			$dataOutput[] = fgetcsv($data);
			$counter++;
		}
		return $dataOutput;
	}
}
