<?php
const __ROOT__ = __DIR__ . '/..';
require __ROOT__.'/vendor/autoload.php';
$con = new Connection();
$path = 'report/';
$files = array_diff(scandir($path), array('.', '..'));
?>

<table>
    <?php foreach($files as $file): ?>
    <?php if(pathinfo($file)['extension'] !== 'html') { continue; } ?>
    <tr>
        <td><a href="<?= $path.$file ?>"><?= $file ?></a></td>
    </tr>
    <?php endforeach; ?>
</table>
