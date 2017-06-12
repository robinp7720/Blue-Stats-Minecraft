<?php

$render = function($module, $plugin, $stat) {
    $info = $plugin->database['stats'][$stat];

    $output = "<div class='col-md-6'><h4>$info[name]</h4>";

    $table = new Table();

    $options = [
        "selectMethod" => isset($info["summary"]) ? $info["summary"] : "sum",
    ];

    foreach ($plugin->stats->statList($stat, 10, $options) as $row) {
        $username = $plugin->player->getName($row['id']);
        $uuid     = $plugin->player->getUUID($row['id']);

        if ($this->bluestats->url->useUUID) {
            $name = "<a href=\"" . $module->bluestats->url->player($uuid) . "\"><img src=\"https://minotar.net/helm/$username/32.png\" alt=\"\"> {$username}</a>";
        }
        else {
            $name = "<a href=\"" . $module->bluestats->url->player($username) . "\"><img src=\"https://minotar.net/helm/$username/32.png\" alt=\"\"> {$username}</a>";
        }

        $table->addRecord(
            $name,
            $row['aggregate']
        );
    }
    $table->makeHeader("Player", $info['name']);

    $output .= $table->tableToHTML(FALSE);
    $output .= "</div>";

    return $output;

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
            echo $render($this, $plugin, $stat);
        }
        echo "</div>";
    }

    echo "<div class='row'>";

    foreach ($plugin->database['stats'] as $stat => $info) {
        // Set default stat options
        if (!isset($info['display'])) $info['display'] = TRUE;
        if (!$info['display']) break;

        echo $render($this, $plugin, $stat);
    }
    echo "</div>";
}