<?php

define('ROOT', dirname(dirname(dirname(__DIR__))));

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
session_start();

if ($_SESSION["auth"] != true)
    die("Not authenticated");

require(ROOT."/classes/config.class.php");
require(ROOT."/classes/mysql.class.php");
$config = json_decode(file_get_contents(ROOT."/config.json"),true);

$mysqlMan = new mysqlMan;
$mysqlMan->connect(
    "BlueStats",
    $config["mysql"]["username"],
    $config["mysql"]["password"],
    $config["mysql"]["host"],
    $config["mysql"]["dbname"]
);

$config = new config($mysqlMan->get("BlueStats"),"BlueStats");
$theme = $config->get("theme");

$directory = ROOT."/themes/$theme/assets";
$scanned_directory = array_diff(scandir($directory), array('..', '.'));


foreach ($scanned_directory as $item){
    copy(ROOT."/themes/$theme/assets/$item",ROOT."/assets/$item");
}
