<?php
$stats = $plugin->getStat("skills", $player->uuid);
/* Get headers */
$headers = array();

if (isset($stats[0])):
unset($stats[0]["user_id"]);
?>
    <table class="table table-sorted">
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
<?php else: ?>
    <div class="alert alert-info" role="alert">
        No McMMO skills stats for this user
    </div>
<?php endif; ?>