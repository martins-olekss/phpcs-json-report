<?php
$path = 'report/';
$files = array_diff(scandir($path), array('.', '..'));
?>

<table>
    <?php foreach($files as $file): ?>
    <?php if($file === '.gitkeep') {continue;} ?>
    <tr>
        <td><a href="<?= $path.$file ?>"><?= $file ?></a></td>
    </tr>
    <?php endforeach; ?>
</table>
