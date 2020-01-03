<?php
/*
 * Processes json file
 * Produces HTML output
 */
$inputFile = $argv[1];
$projectBasePath = $argv[2];
$scanInfo = json_decode($argv[3]);

// Retrieve PHPCS JSON report
$json = file_get_contents($inputFile);
$jsonData = json_decode($json);

$revisedData = array();
// data to be written to file
$output = '';
$defaultKey = 'unknown';

// URL that will be replaced before HTML output
define('BASE_URL', $projectBasePath);

function writeOut($content, $file)
{
    $outputFile = fopen($file, 'w');
    fwrite($outputFile, $content);
    fclose($outputFile);

}

// Get summary for all Code Sniff
// print_r($jsonData->totals);
foreach ($jsonData->files as $file => $data) {
    //echo 'FILE: ' . $file . PHP_EOL;
    //echo '- ERRORS: ' . $data->errors . PHP_EOL;
    //echo '- WARNINGS: ' . $data->warnings . PHP_EOL;
    foreach ($data->messages as $item) {
        // Restructure data - group by ID
        if (isset($item->source)) {
            $key = $item->source;
        } else {
            $key = $defaultKey;
        }
        //TODO: Add more fields from sniffs
        $revisedData[$key][] = array(
            'ref_path' => $file . ':' . $item->line, // full_path:line
            'ref_filename' => basename($file), // only filename
            'line' => $item->line, // only code line
            'message' => $item->message
        );
    }
}
?>

<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
<style>
    * {
        font-size: 12px;
    }

    table {
        border-collapse: collapse;
    }

    table td {
        border: 1px solid #f3f3f3;
    }

    .sniff-name, .sniff-count {
        padding-top: 10px;
        background-color: #f0f0f0;
        font-weight: bold;
    }
</style>
<table>
    <tr>
        <th>Examined directory</th>
        <td><?= $scanInfo->examineDirectory ?></td>
    </tr>
    <tr>
        <th>Standards</th>
        <td><?= implode(', ', $scanInfo->standards) ?></td>
    </tr>
    <tr>
        <th>Report file</th>
        <td><?= $scanInfo->jsonReportFile ?></td>
    </tr>
    <tr>
        <th>Date</th>
        <td><?= date('Y-d-m H:i:s', time()); ?></td>
    </tr>
    <?php foreach ($revisedData as $sniff => $data): ?>
        <tr>
            <td class="sniff-name"><?= $sniff ?></td>
            <td class="sniff-count">Count:<?= count($revisedData[$sniff]) ?></td>
        </tr>
        <?php foreach ($data as $file): ?>
            <tr>
                <td class="path"><?= str_replace(BASE_URL, '', $file['ref_path']) ?></td>
                <td class="message"><?= $file['message'] ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
</table>
</body>
</html>
