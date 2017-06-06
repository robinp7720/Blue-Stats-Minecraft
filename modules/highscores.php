<?php
$this->loadPlugin("Statz");

/** @var \BlueStats\API\plugin $plugin */
$plugin = $this->plugins['Statz'];

foreach ($plugin->database['stats'] as $stat => $info) {
    echo "<h2>$info[name]</h2>";

    $table = new Table;

    foreach ($plugin->stats->statList($stat, 10) as $row) {
        $table->addRecord(
            $plugin->player->getName($plugin->player->getID($row['uuid'])),
            $row['aggregate']
        );
    }
    $table->makeHeader("Player", $info['name']);

    echo $table->tableToHTML();
}