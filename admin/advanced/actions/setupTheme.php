<?php

define('ROOT', dirname(dirname(dirname(__DIR__))));

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
session_start();

if ($_SESSION["auth"] != true)
    die("Not authenticated");

require(ROOT."/classes/config.class.php");
$dbConf = json_decode(file_get_contents(ROOT."/config.json"),true);

$mysqli = new mysqli(
    $dbConf["mysql"]["host"],
    $dbConf["mysql"]["username"],
    $dbConf["mysql"]["password"],
    $dbConf["mysql"]["dbname"]
);

$config = new config($mysqli,"BlueStats");
$theme = $config->get("theme");

$directory = ROOT."/themes/$theme/assets";
$scanned_directory = array_diff(scandir($directory), array('..', '.'));


foreach ($scanned_directory as $item){
    copy(ROOT."/themes/$theme/assets/$item",ROOT."/assets/$item");
}
