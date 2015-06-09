<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();
if (!file_exists("../config.php"))
	die("Please go to /install first");

require "../config.php";
require "../classes/config.class.php";
require "../classes/mysql.class.php";

$mysqlMan = new mysqlMan;
$mysqlMan->connect(
	"BlueStats",
	$config["mysql"]["username"],
	$config["mysql"]["password"],
	$config["mysql"]["host"],
	$config["mysql"]["dbname"]
);
$mysqli = $mysqlMan->get("BlueStats");

$config = new config($mysqli,"BlueStats_admin");

if (isset($_GET["logout"])){
	$_SESSION["auth"] = false;
}

if (isset($_GET["update"])){
	if (isset($_POST["value"])&&isset($_POST["option"])&&isset($_POST["plugin"])){
		$Updateconfig = new config($mysqli,htmlspecialchars_decode($_POST["plugin"]));
		$Updateconfig->set(
			htmlspecialchars_decode($_POST["option"]),
			json_decode(htmlspecialchars_decode($_POST["value"]))
		);
		$message="Config Updated!";
	}
}


if (!$config->configExist("username")){
	$config->set("username","admin");
}
if (!$config->configExist("password")){
	$config->set("password","admin");
}

if ((@$_POST["username"]!=$config->get("username")||@$_POST["password"]!=$config->get("password"))&&$_SESSION["auth"]===false){
	include "parts/login.php";
	die();
}else{
	$_SESSION["auth"]=true;
}

/* include page */
if ($_SESSION["auth"]===true)
	require 'parts/main.php';