<?php
if (!$config->configExist("stats")) {
    $config->set("stats", array("playtime", "joins"));
}
if (!$config->configExist("show_name_head")) {
    $config->set("show_name_head", "true");
}
if (!$config->configExist("limit")) {
    $config->set("limit", "10");
}
?>

<?php
$showPlayerTitle = $config->get("show_name_head");
$limit = $config->get("limit");
?>
<div class="row">
    <?php foreach ($config->get("stats") as $statName): ?>
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2 class="panel-title">Top <?= $limit ?> by <b><?= $plugin->statName($statName) ?></b></h2>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th><?php if ($showPlayerTitle == "true") {
                                    echo "Player";
                                } ?></th>
                            <th><?= $plugin->statName($statName) ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($plugin->getAllPlayerStats($statName, $limit) as $stat) {
                            if ($statName == "playtime") {
                                $statDisplay = secondsToTime($stat["value"], $contract = true);
                            } else {
                                $statDisplay = $stat["value"];
                            }
                            if ($url->useUUID) {
                                $linkId = $stat["uuid"];
                            } else {
                                $linkId = $stat["name"];
                            }
                            $linkUrl = $url->player($linkId);
                            echo "
							<tr>
								<td>
									<a href=\"$linkUrl\"><img src=\"https://minotar.net/helm/{$stat["name"]}/32.png\" alt=\"\"> {$stat["name"]}</a>
								</td>
								<td>
									" . $statDisplay . "
								</td>
							</tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>