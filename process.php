<?php
/*
 * Executes all necessary commands
 */
require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Process\Process;

// TODO: Confirm required files / directories exists
$settings = [
    'phpcs' => 'D:\utilities\phpcs.phar',
    'examineDirectory' => 'C:\WinNMP\WWW\discovery-heap',
    'standards' => ['PSR1', 'Zend'],
    'ignore' => ['vendor/*', 'template/cache/*']
];

$standards = implode(',', $settings['standards']);
$ignore = implode(',', $settings['ignore']);
$hash = md5($standards.$ignore.$settings['examineDirectory'].date_timestamp_get(date_create()));
$settings['jsonReportFile'] = 'tmp/' . $hash . '.json';
$settings['outputFile'] = 'pub/report/' . $hash . '.html';

$command = [
    'php',
    $settings['phpcs'],
    "--standard={$standards}",
    '-s',
    "--ignore={$ignore}",
    '--report=json',
    "--report-file={$settings['jsonReportFile']}",
    $settings['examineDirectory']
];

/*
 * TODO: Currently this process produces warning: "Misuse of shell builtins",
 * but still executes required commands
 */
$process = new Process($command);
$process->run();
// TODO: Confirm json file exists
if ($process->isTerminated()) {
    $subCommand = [
        'php',
        'out.php',
        $settings['jsonReportFile'],
        $settings['examineDirectory'],
        json_encode($settings)
    ];
    $subProcess = new Process($subCommand);
    $subProcess->run();
    $output = fopen($settings['outputFile'], 'w');
    fwrite($output, $subProcess->getOutput());
    fclose($output);
}
