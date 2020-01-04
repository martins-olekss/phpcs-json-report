<?php
/*
 * main process, starts scan and after that starts result processing sub-process
 */
require __DIR__ . '/vendor/autoload.php';
use Symfony\Component\Process\Process;
$settings = [
    'phpcs' => 'D:\utilities\phpcs.phar',
    'examineDirectory' => 'C:\WinNMP\WWW\discovery-heap',
    'standards' => ['PSR1', 'Zend'],
    'ignore' => ['vendor/*', 'template/cache/*']
];
$params = App::getParameters($settings);

App::writeLine('Preparing for scan process');
App::writeLine(sprintf('- Project directory: %s',$params['examineDirectory']));
App::writeLine(sprintf('- Standards: %s',$params['standards']));
App::writeLine(sprintf('- Ignored directories: %s',$params['ignore']));
App::writeLine(sprintf('- Scan result: %s',$params['jsonReportFile']));
App::writeLine(sprintf('- HTML report: %s',$params['outputFile']));

$scanCommand = Scan::getCommand($params);
$scanProcess = new Process($scanCommand);
$scanProcess->run();
App::writeLine('Starting scan process');

if ($scanProcess->isTerminated()) {
    App::writeLine('Starting sub-process, processing scan results');

    $params['processingFile'] = 'process.php';
    $processorCommand = ResultProcessor::getCommand($params);
    $processor = new Process($processorCommand);
    $processor->run();

    App::writeLine(sprintf('Scan results processed, writing to output file %s',$params['outputFile']));
    $output = fopen($params['outputFile'], 'w');
    fwrite($output, $processor->getOutput());
    fclose($output);
}
App::writeLine('Process completed!');