<?php

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

$config = new config($mysqli, $_POST['plugin']);

echo json_encode([
                     'code'    => 200,
                     'success' => $config->set($_POST['option'], $_POST['value']),
                 ]);