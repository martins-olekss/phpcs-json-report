<?php 

// Example of command
// php phpcs.phar --standard=Zend -s --report=json --report-file=report.json path/to/code
// pass parameter -s to include source field in report ( sniff ID )
$json = file_get_contents('report1.json');
$jsonData = json_decode($json);

$revisedData = array();
$defaultKey = 'unknown';

// Get summary for all Code Sniff
// print_r($jsonData->totals);
foreach($jsonData->files as $file => $data) {
	//echo 'FILE: ' . $file . PHP_EOL;
	//echo '- ERRORS: ' . $data->errors . PHP_EOL;
	//echo '- WARNINGS: ' . $data->warnings . PHP_EOL;
	foreach($data->messages as $item) {
		// Restructure data - group by sniff ID
                if (isset($item->source)) {
			$key = $item->source;
                } else {
			$key = $defaultkey;
                }		
		$revisedData[$key][] = array(
			'ref_path' => $file . ':' . $item->line, // full_path:line
			'ref_filename' => basename($file), // only filename
			'line' => $item->line, // only code line
			'message' => $item->message
		);

		// Just outputting info
		//echo '-- MESSAGE:' . $item->message . PHP_EOL;
		//echo '-- TYPE:' . $item->type . PHP_EOL; 
		//echo '-- LINE:' . $item->line . PHP_EOL;
		//echo PHP_EOL;
		// format file:line
		//echo $file . ':' . $item->line . PHP_EOL;
		//echo "\t" . $item->message . PHP_EOL;
	}
}


// Test revised data
foreach($revisedData as $sniff => $data) {
	echo $sniff . PHP_EOL;
	foreach($data as $file) {
		echo "\t" . $file['ref_path'] . PHP_EOL;
		//echo "\t\t" . $file['ref_filename'] . PHP_EOL;
		//echo "\t\t" . $file['message'] . PHP_EOL;
	}
	echo PHP_EOL;
}
