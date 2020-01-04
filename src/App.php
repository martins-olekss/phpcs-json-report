<?php

class App
{
    public static function writeLine($message) {
        echo $message . PHP_EOL;
    }

    public static function getParameters(array $settings)
    {
        $param['standards'] = implode(',', $settings['standards']);
        $param['ignore'] = implode(',', $settings['ignore']);
        $param['hash'] = md5($param['standards'] . $param['ignore'] . $settings['examineDirectory'] . date_timestamp_get(date_create()));
        $param['jsonReportFile'] = 'tmp/' . $param['hash'] . '.json';
        $param['outputFile'] = 'pub/report/' . $param['hash'] . '.html';
        $param['examineDirectory'] = $settings['examineDirectory'];
        $param['phpcs'] = $settings['phpcs'];

        return $param;
    }
}