<?php
$this->loadPlugin("Statz");

/** @var \BlueStats\API\plugin $plugin */
$plugin = $this->plugins['Statz'];

foreach ($plugin->database['stats'] as $stat => $info) {
    echo "<div class='col-md-6'><h2>$info[name]</h2>";

    $table = new Table;

    foreach ($plugin->stats->statList($stat, 10) as $row) {
        $username = $plugin->player->getName($plugin->player->getID($row['uuid']));
        if ($this->bluestats->url->useUUID) {
            $name = "<a href=\"" . $this->bluestats->url->player($row['uuid']) . "\"><img src=\"https://minotar.net/helm/$username/32.png\" alt=\"\"> {$username}</a>";
        } else {
            $name = "<a href=\"" . $this->bluestats->url->player($username) . "\"><img src=\"https://minotar.net/helm/$username/32.png\" alt=\"\"> {$username}</a>";
        }
        $table->addRecord(
            $name,
            $row['aggregate']
        );
    }
    $table->makeHeader("Player", $info['name']);

    echo $table->tableToHTML(false);

    echo "</div>";
}