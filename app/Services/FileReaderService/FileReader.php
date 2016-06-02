<?php

namespace Kayako\Services\FileReaderService;

use Kayako\Services\ExportServices\AbstractExport;

class FileReader
{
	private $pathToFile;
	private $columnHeaders;	
	private $export;
	private $otherFormat;
	
	public function __construct($pathToFile, AbstractExport $export = null, $otherFormat = false)
	{
		$this->pathToFile = $pathToFile;
		$this->export = $export;		
		$this->otherFormat = $otherFormat;
		$this->pathOutput = 'resource/output/';
	}
	
	public function getColumnHeaders()
	{
		return $this->columnHeaders;
	}	
	
	public function readFile($otherFormat)
	{
		$csv = $this->fileReader();	
		
		return $this->export->convertToFormatData($csv, $otherFormat, $this->pathToFile);
	}
	
	public function export($pathToOutput = false)
	{		
		$this->export->export($this->readFile($this->otherFormat), $pathToOutput);		
	}
	
	public function explode($pathOutput, $countRows = 10000)
	{
		$csv = $this->fileReader();
		$fp = null;
		$numberOfFile = 0;		
		for($i = 0, $count = count($csv); $i < $count; $i++){
			if ($i === 0){				
				$numberOfFile++;
				$fp = fopen($pathOutput . basename($this->pathToFile, '.csv') . "_$numberOfFile" . '.csv', 'w');				
				fputcsv($fp, array_values($this->columnHeaders));				
			}			
			if ($i % $countRows === 0 && $i !== 0) {				
				fclose($fp);
				$numberOfFile++;
				$fp = fopen($pathOutput . basename($this->pathToFile, '.csv') . "_$numberOfFile" . '.csv', 'w');	
				fputcsv($fp, array_values($this->columnHeaders));
			}
			fputcsv($fp, array_values($csv[$i]));
		}
		fclose($fp);
	}
	
	private function fileReader()
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
		
		$columns = array_map(function($item) {
			return strtolower(str_replace('_', '', $item));
			
		}, $csv[0]);
		
		array_walk($csv, function(&$a) use ($csv, $columns) {
			$a = array_combine($columns, $a);
		   });
		 
		$this->columnHeaders = array_shift($csv);
		
		return $csv;
	}
	
}
