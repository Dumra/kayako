<?php

namespace Kayako\Services\FileReaderService;

use Kayako\Services\ExportServices\AbstractExport;

class FileReader
{
	private $pathToFile;
	private $columnHeaders;	
	private $export;
	private $otherFormat;
	
	public function __construct($pathToFile, AbstractExport $export, $otherFormat = false)
	{
		$this->pathToFile = $pathToFile;
		$this->export = $export;		
		$this->otherFormat = $otherFormat;
	}
	
	public function getColumnHeaders()
	{
		return $this->columnHeaders;
	}
	
	public function readFile($otherFormat)
	{
		$fh = fopen($this->pathToFile, 'r');
		$csv = [];
		while ($values = fgetcsv($fh)) {
			if (count($values) === 1) {
			   continue;
			} 	
			$csv[] = array_map(function($item){	 
				return str_replace("\r", "", str_replace("\n", " ", $item));				
			}, $values);	 
		}
		fclose($fh);

		array_walk($csv, function(&$a) use ($csv) {
			$a = array_combine($csv[0], $a);
		   });

		$this->columnHeaders = array_shift($csv);		
		
		return $this->export->convertToFormatData($csv, $otherFormat);
	}
	
	public function export($pathToOutput = false)
	{		
		$this->export->export($this->readFile($this->otherFormat), $pathToOutput);		
	}
	
}
