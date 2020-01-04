<?php
/*
 *  sub-process that parses json results and creates HTML report
 */
require __DIR__ . '/vendor/autoload.php';

// Incoming command parameters
// TODO: Validate incoming params
$config['inputFile'] = $argv[1];
$config['projectBasePath'] = $argv[2];
$config['scanInfo'] = json_decode($argv[3], true);

$config['defaultKey'] = 'unknown';
$json = file_get_contents($config['inputFile']);
$jsonData = json_decode($json, true);
$result = ResultProcessor::processResults($jsonData, $config);
?>

<html>
<head>
    <meta charset="UTF-8">
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
</head>
<body>
<table>
    <tr>
        <th>Examined directory</th>
        <td><?= $config['scanInfo']['examineDirectory'] ?></td>
    </tr>
    <tr>
        <th>Standards</th>
        <td><?= $config['scanInfo']['standards'] ?></td>
    </tr>
    <tr>
        <th>Report file</th>
        <td><?= $config['scanInfo']['jsonReportFile'] ?></td>
    </tr>
    <tr>
        <th>Date</th>
        <td><?= date('Y-d-m H:i:s', time()); ?></td>
    </tr>
    <?php foreach ($result as $sniff => $data): ?>
    <tr>
        <td class="sniff-name"><?= $sniff ?></td>
        <td class="sniff-count">Count:<?= count($result[$sniff]) ?></td>
    </tr>
        <?php foreach ($data as $file): ?>
        <tr>
            <td class="path"><?= str_replace($config['projectBasePath'], '', $file['path']) ?></td>
            <td class="message"><?= $file['message'] ?></td>
        </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
</table>
</body>
</html>
