<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();
if (!file_exists("../../config.json"))
    die("Please go to /install first");

if (!isset($_SESSION["auth"])||$_SESSION["auth"]!=true){
    die("Not authenticated");
}

/** @noinspection PhpIncludeInspection */
require "../../classes/config.class.php";
require "../../classes/mysql.class.php";

$config = json_decode(file_get_contents("../../config.json"),true);

$mysqlMan = new mysqlMan;
$mysqlMan->connect(
    "BlueStats",
    $config["mysql"]["username"],
    $config["mysql"]["password"],
    $config["mysql"]["host"],
    $config["mysql"]["dbname"]
);
$mysqli = $mysqlMan->get("BlueStats");

$config = new config($mysqli, "BlueStats_admin");

if (isset($_GET["logout"])) {
    $_SESSION["auth"] = false;
}

if (isset($_GET["update"]) && $_SESSION["auth"] === true) {
    if (isset($_POST["value"]) && isset($_POST["option"]) && isset($_POST["plugin"])) {
        $Updateconfig = new config($mysqli, htmlspecialchars_decode($_POST["plugin"]));
        if ($_POST["type"] === "string" || $_POST["type"] == "NULL") {
            $Updateconfig->set(
                htmlspecialchars_decode($_POST["option"]),
                htmlspecialchars_decode($_POST["value"])
            );
        } else {
            $Updateconfig->set(
                htmlspecialchars_decode($_POST["option"]),
                json_decode(htmlspecialchars_decode($_POST["value"]))
            );
        }
        $message = "<b>{$_POST["option"]}</b> updated!";
    }
}

/* include page */
if ($_SESSION["auth"] === true)
    require 'parts/main.php';