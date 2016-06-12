<?php
$stats = $config->get("stats", "lolmewnStats");
?>
<table class="table table-sorted" id="stats">
    <thead>
        <tr>
            <th>Stat</th>
            <th>Value</th>
            <th>Server Total</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($stats as $id => $stat): ?>
        <?php
        $statVal = $plugin->getStat($id, $player->uuid);
        if (!empty($statVal)):?>
            <tr>
                <td><?= $stat ?></td>
                <td><?= $statVal ?></td>
                <td><?= $plugin->getStatSum($id)?></td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
    </tbody>
</table>
