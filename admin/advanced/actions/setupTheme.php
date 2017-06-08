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

$config = new config($mysqli, "BlueStats");
$theme  = $config->get("theme");

$directory         = ROOT . "/themes/$theme/assets";
$scanned_directory = array_diff(scandir($directory), ['..', '.']);

$success = 0;
$fail    = 0;

foreach ($scanned_directory as $item) {
    if (copy(ROOT . "/themes/$theme/assets/$item", ROOT . "/assets/$item")) {
        $success++;
    }
    else {
        $fail++;
    }
}

echo json_encode([
                     'code'    => 200,
                     'success' => $success,
                     'fail'    => $fail,
                 ]);