<?php

// Option to whether or not to put the highscore in a bootstrap panel
$this->config->setDefault("panelEnable", TRUE);
$this->config->setDefault("count", 10);

$panelEnable = $this->config->get("panelEnable");
$count = $this->config->get("count");

$render = function ($module, $plugin, $stat, $count) {
    $info = $plugin->database['stats'][$stat];

    $table = new Table();

    $aggregateID = "";

    // Get aggregate stat id
    foreach ($info["values"] as $id => $info) {
        if ($info['aggregate']) {
            $aggregateID = $id;
            break;
        }
    }

    $stats = $plugin->stats->statList($stat, $count);

    if (!isset($stats) || empty($stats))
        return FALSE;

    foreach ($stats as $row) {
        // If the ID is not the username, get the username from the id. If the ID is the username, don't bother with any database queries
        if ($plugin->database['identifier'] != 'name') $username = $plugin->player->getName($row['id']);
        else $username = $row['id'];

        // Do the same for the uuid
        if ($plugin->database['identifier'] != 'uuid') $uuid = $plugin->player->getUUID($row['id']);
        else $uuid = $row['id'];

        if ($this->bluestats->url->useUUID) {
            $name = "<a href=\"" . $module->bluestats->url->player($uuid) . "\"><img src=\"https://minotar.net/helm/$username/32.png\" alt=\"\"> {$username}</a>";
        }
        else {
            $name = "<a href=\"" . $module->bluestats->url->player($username) . "\"><img src=\"https://minotar.net/helm/$username/32.png\" alt=\"\"> {$username}</a>";
        }

        // Format according to datatype of value
        switch ($plugin->database['stats'][$stat]["values"][$aggregateID]["dataType"]) {
            case "date":
                $row['aggregate'] = date('H:i m-d-y', $row['aggregate']);
                break;
            case "time":
                $row['aggregate'] = secondsToTime($row['aggregate']);
                break;
            default:
                break;
        }

        $table->addRecord(
            $name,
            $row['aggregate']
        );
    }
    $table->makeHeader("Player", $info['name']);

    return $table->tableToHTML(FALSE);

};

/** @var module $this */
foreach ($this->bluestats->plugins as $plugin) {
    /** @var \BlueStats\API\plugin $plugin */
    if (!$plugin::$isMySQLplugin)
        continue;

    echo "<h2>{$plugin->name}</h2>";

    if (!isset($plugin->database['groups'])) $plugin->database['groups'] = [];

    foreach ($plugin->database['groups'] as $groupId => $group) {
        echo "<h3>{$group['name']}</h3>";
        echo "<div class='row'>";
        foreach ($group['stats'] as $stat) {
            $info = $plugin->database['stats'][$stat];

            if ($panelEnable): ?>
                <div class='col-md-6'>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><?= $info['name'] ?></h4>
                        </div>
                        <div class="panel-body">
                            <?= $render($this, $plugin, $stat, $count); ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class='col-md-6'>
                    <h4><?= $info['name'] ?></h4>
                    <?= $render($this, $plugin, $stat, $count); ?>
                </div>
            <?php endif;
        }
        echo "</div>";
    }

    echo "<div class='row'>";

    foreach ($plugin->database['stats'] as $stat => $info) {
        // Set default stat options
        if (!isset($info['display'])) $info['display'] = TRUE;
        if (!$info['display']) break;

        $info = $plugin->database['stats'][$stat];

        if ($panelEnable): ?>
            <div class='col-md-6'>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><?= $info['name'] ?></h4>
                    </div>
                    <div class="panel-body">
                        <?= $render($this, $plugin, $stat, $count); ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class='col-md-6'>
                <h4><?= $info['name'] ?></h4>
                <?= $render($this, $plugin, $stat, $count); ?>
            </div>
        <?php endif;

    }
    echo "</div>";
}