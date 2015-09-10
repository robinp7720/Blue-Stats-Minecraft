<?php

$stmt = $plugin->mysqli->stmt_init();

$sql = "SELECT *, sum(value) as value 
FROM {$plugin->prefix}pvp INNER JOIN `{$plugin->prefix}players` on {$plugin->prefix}pvp.UUID = {$plugin->prefix}players.UUID 
WHERE `victim` = ?
GROUP BY {$plugin->prefix}pvp.UUID 
ORDER BY value Desc Limit 1";

if ($stmt->prepare($sql)) {
    $stmt->bind_param("s", $player->uuid);
    /* execute query */
    $stmt->execute();

    $output = array();

    /* fetch value */
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $output[] = $row;
    }

    /* close statement */
    $stmt->close();
}
if (!empty($output)):
    if ($url->useUUID) {
        $linkId = $output[0]["uuid"];
    } else {
        $linkId = $output[0]["name"];
    }
    ?>
    <div class="panel panel-default">
        <img src="https://minotar.net/helm/<?= $linkId ?>.png" alt="" style="width:100%;">

        <div class="panel-body">
            <h3><a href="<?= $url->player($linkId) ?>"><?= $output[0]["name"] ?></a></h3>
            <h6 class="text-muted"><?= $player->name ?>'s Arch
                Enemy</h6>
        </div>
    </div>
<?php endif; ?>