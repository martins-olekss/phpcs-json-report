<?php

class ResultProcessor {


    /**
     * @param array $params
     * @return array
     */
    public static function getCommand(array $params)
    {
        $command = [
            'php',
            $params['processingFile'],
            $params['jsonReportFile'],
            $params['examineDirectory'],
            json_encode($params)
        ];

        return $command;
    }

    /**
     * @param array $data
     * @param array $config
     * @return array
     */
    public static function processResults(array $data, array $config) {
        $result = [];
        foreach ($data['files'] as $file => $data) {
            foreach ($data['messages'] as $item) {
                if (isset($item['source'])) {
                    $key = $item['source'];
                } else {
                    $key = $config['defaultKey'];
                }
                //TODO: Add more fields from sniffs
                $result[$key][] = array(
                    'path' => $file . ':' . $item['line'], // full_path:line
                    'filename' => basename($file), // only filename
                    'line' => $item['line'], // only code line
                    'message' => $item['message']
                );
            }
        }

        return $result;
    }
}