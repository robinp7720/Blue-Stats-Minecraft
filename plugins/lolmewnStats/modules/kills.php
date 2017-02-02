<table class="table table-sorted" id="pvp-stats">
    <thead>
    <tr>
        <th>Weapon</th>
        <th>World</th>
        <th>Amount</th>
        <th>Entity Type</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($plugin->getStat('kill', $player->uuid, False) as $stat):?>
        <tr>
            <td><?= $stat['weapon'] ?></td>
            <td><?= $stat['world'] ?></td>
            <td><?= $stat['value'] ?></td>
            <td><?= $stat['entityType'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
