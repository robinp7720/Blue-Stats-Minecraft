<?php

define('DEBUG', true);

require_once "../classes/plugin/plugin.php";
require_once "../plugins/new/Statz/Statz.php";
require_once "../classes/config.class.php";

$config = json_decode(file_get_contents("../config.json"), true);

$mysqli = new mysqli(
    $config["mysql"]["host"],
    $config["mysql"]["username"],
    $config["mysql"]["password"],
    $config["mysql"]["dbname"]
);

$plugin = new \BlueStats\Plugin\Statz($mysqli);

echo $plugin->player->getID("Zeyphros") . PHP_EOL;
echo $plugin->player->getID("5f7e4c8d-8c79-42a9-953b-538e3f62e644") . PHP_EOL;
echo $plugin->player->getUUID($plugin->player->getID("2Low")) . PHP_EOL;
echo $plugin->player->getName($plugin->player->getID("2Low")) . PHP_EOL;


echo $plugin->stats->player($plugin->player->getUUID($plugin->player->getID("2Low")),"joins");