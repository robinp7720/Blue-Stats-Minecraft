<table  class="table table-sorted" id="stats">
<thead>
<tr>
    <th>Victim</th>
    <th>Weapon</th>
    <th>Time</th>
</tr>
<tbody>
</thead>

<?php
$config->setDefault("image-src", "http://cravatar.eu/avatar/{NAME}/64");
$imageSrc = $config->get("image-src");
$stmt = $plugin->mysqli->stmt_init();

$sql = "SELECT *
FROM {$plugin->prefix}pvp INNER JOIN `{$plugin->prefix}players` on {$plugin->prefix}pvp.victim = {$plugin->prefix}players.UUID 
WHERE `{$plugin->prefix}pvp`.`uuid`= ?
ORDER BY value Desc";

if ($stmt->prepare($sql)) {
    $stmt->bind_param("s", $player->uuid);
    $stmt->execute();
    $output = [];
    $output = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    foreach ($output as $value) {
        if ($url->useUUID) {
            $linkId = $value['victim'];
        } else {
            $linkId = $value['name'];
        }
        ?>
        <tr>
            <td><a href="<?= $url->player($linkId) ?>"><?=$value['name']?></a></td>
            <td><?=$value['weapon']?></td>
            <td><?=$value['time']?></td>
        </tr>

    <?php
    }

}
?>
    </tbody>
</table>