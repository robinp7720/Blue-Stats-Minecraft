<?php

error_reporting(-1);
ini_set("display_errors", 'On');

define('ROOT', dirname(dirname(dirname(__DIR__))));

session_start();

if ($_SESSION["auth"] != TRUE) {
    die(json_encode(['code' => 500, 'message' => 'User is not authenticated']));
}

require(ROOT . "/classes/config.class.php");
$dbConf = json_decode(file_get_contents(ROOT . "/config.json"), TRUE);

$mysqli = new mysqli(
    $dbConf["mysql"]["host"],
    $dbConf["mysql"]["username"],
    $dbConf["mysql"]["password"],
    $dbConf["mysql"]["dbname"]
);

$config  = new config($mysqli, 'BlueStats');
$plugins = $config->get("plugins");

if ($_POST['action'] == 'status')
    return print(json_encode(in_array($_POST['plugin'],$plugins)));
if ($_POST['action'] == "enable" && !in_array($_POST['plugin'], $plugins))
    array_push($plugins, $_POST['plugin']);
if ($_POST['action'] == "disable" && in_array($_POST['plugin'], $plugins))
    unset($plugins[array_search($_POST['plugin'], $plugins)]);

echo json_encode([
                     'code' => 200,
                     'success' => $config->set('plugins', $plugins)
                 ]);