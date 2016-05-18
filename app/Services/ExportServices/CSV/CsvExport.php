<?php

namespace Kayako\Services\ExportServices\CSV;

use Kayako\Services\ExportServices\AbstractExport;

class CsvExport extends AbstractExport
{	
	public function export($data, $pathToOutput = false)
	{
		$fp = fopen($pathToOutput, 'w');

		foreach ($data as $userDataPrepared) {
			fputcsv($fp, array_values($userDataPrepared));
		}

		fclose($fp);
	}
}
