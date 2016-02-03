<?php
$base_plugin = $config->get("base_plugin");
$plugin = $plugins[$base_plugin];

$url = str_replace('{page}','player', $config->get("player-url", 'BlueStats-Url'));
$url = str_replace('{player}', $config->get("useUUID", 'BlueStats-Url')=="true"? '{UUID}' : '{NAME}', $url);

$output['info'] = [
    'url' => $url
];
$output['data'] = $plugin->getUsers(0, 10000, MYSQLI_NUM);