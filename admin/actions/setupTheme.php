<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
session_start();

if ($_SESSION["auth"] != true)
    die("Not authenticated");

require("../../classes/config.class.php");
require("../../classes/mysql.class.php");
$config = json_decode(file_get_contents("../../config.json"),true);

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

$directory = "../../themes/".$theme."/assets";
$scanned_directory = array_diff(scandir($directory), array('..', '.'));

foreach ($scanned_directory as $item){
    copy("../../themes/$theme/assets/$item","../../assets/$item");
}