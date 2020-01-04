<?php

class Scan
{
    public static function getCommand(array $params)
    {

        $hash = md5($params['standards'] . $params['ignore'] . $params['examineDirectory'] . date_timestamp_get(date_create()));
        $settings['jsonReportFile'] = 'tmp/' . $hash . '.json';
        $settings['outputFile'] = 'pub/report/' . $hash . '.html';

        $command = [
            'php',
            $params['phpcs'],
            "--standard={$params['standards']}",
            '-s',
            "--ignore={$params['ignore']}",
            '--report=json',
            "--report-file={$params['jsonReportFile']}",
            $params['examineDirectory']
        ];

        return $command;
    }
}