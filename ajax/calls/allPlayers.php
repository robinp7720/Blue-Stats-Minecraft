<?php
$base_plugin = $config->get("base_plugin");
$plugin = $plugins[$base_plugin];

$url = str_replace('{page}','player', $config->get("player-url", 'BlueStats-Url'));
$url = str_replace('{player}', $config->get("useUUID", 'BlueStats-Url')=="true"? '{UUID}' : '{NAME}', $url);

$output['info'] = [
    'url' => $url
];

$page = isset($_GET['page']) ? $_GET['page'] : 0;

$search = "";

if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

$output['data'] = $plugin->getUsers(50 * $page, 50, MYSQLI_NUM, $search);
