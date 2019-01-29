<?php 
$config = parse_ini_file('config.ini');
$inputFilename = $config['input_filename'];
$outputFilename = $config['output_filename'];

// Retrieve PHPCS JSON report
$json = file_get_contents($inputFilename);
$jsonData = json_decode($json);

$revisedData = array();
// data to be written to file
$output = '';
$defaultKey = 'unknown';

function writeOut($content, $file)
{
	$outputFile = fopen($file, 'w');
	fwrite($outputFile, $content);
	fclose($outputFile);

}

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
	$output .= $sniff . PHP_EOL;
	foreach($data as $file) {
		echo "\t" . $file['ref_path'] . PHP_EOL;
		$output .= $file['ref_path'] . PHP_EOL;
		//echo "\t\t" . $file['ref_filename'] . PHP_EOL;
		//echo "\t\t" . $file['message'] . PHP_EOL;
	}
	echo PHP_EOL;
}
// Write results to file
writeOut($output, $outputFilename);
