<?php
$stats = $plugin->getStat("experience", $_GET["id"]);

unset($stats[0]["user_id"]);

?>
<table class="table">
    <thead>
    </thead>
    <tbody>
    <?php foreach ($stats[0] as $key => $val): ?>
        <tr>
            <th><?= ucfirst($key) ?></th>
            <td><?= $val ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>