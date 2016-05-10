<?php
$stats = $config->get("stats", "lolmewnStats");
?>
<table class="table table-sorted" id="stats">
    <thead>
    <th>Stat</th>
    <th>Value</th>
    <th>Server Total</th>
    </thead>
    <tbody>
    <?php foreach ($stats as $id => $stat): ?>
        <?php
        $statVal = $plugin->getStat($id, $player->uuid);
        if (!empty($statVal)):?>
            <tr>
                <td><?= $stat ?></td>
                <td><?= $statVal ?></td>
                <td><?= $plugin->getAllPlayerStatsSum($id)?></td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
    </tbody>
</table>