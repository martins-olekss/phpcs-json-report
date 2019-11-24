<?php
/*
 * Executes all necessary commands
 */
require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Process\Process;

$phpcs = 'C:\utilities\phpcs.phar'; // Location of the phpcs
$jsonFileName = 'report.json'; // Name of the report file
$outputFileName = 'test.html'; // File for final output
$dir = 'C:\www\project'; // Target for Code Sniffer

// Standards to use
$standards = implode(',', [
    'PSR1',
    'Zend'
]);
$command = [
    'php',
    $phpcs,
    "--standard={$standards}",
    '-s',
    '--ignore=vendor/*',
    '--report=json',
    "--report-file={$jsonFileName}",
    $dir
];

/*
 * TODO: Currently this process produces warning: "Misuse of shell builtins",
 * but still executes required commands
 */
$process = new Process($command);
$process->run();
if ($process->isTerminated()) {
    $subCommand = [
        'php',
        'out.php'
    ];
    $subProcess = new Process($subCommand);
    $subProcess->run();
    $output = fopen($outputFileName, 'w');
    fwrite($output, $subProcess->getOutput());
    fclose($output);
}
